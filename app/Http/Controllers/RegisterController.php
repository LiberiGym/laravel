<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tejuino\Adminbase\Controllers\AdminController;
use Illuminate\View;
use Mail;
use Carbon\Carbon;
use Hash;
use App\Models\Bitacoras\Bitacora;

use App\Models\User;
use App\Models\Gyms\Gym;
use App\Models\Gyms\GymImage;
use App\Models\Gyms\GymSchedule;
use App\Models\Gyms\GymService;
use App\Models\Locations\Location;
use App\Models\States\State;
use App\Models\Categories\Category;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;

class RegisterController extends Controller
{

    public function __construct()
    {

    }

    public function loadLocations(Request $request){
        $response = [
            'result' => 'error',
            'locations' => []
        ];
        if($request->has('state_id'))
        {
            $locations = Location::where('state_id',$request->get('state_id'))->orderBy('title','asc')->get();
            $response['result'] = 'ok';
            if(!is_null($locations)){
                $response['locations'] = $locations;
            }

        }
        return $response;
    }

    /*PROCESO DE REGISTRO*/

    /*registro inicial*/
    public function initRegister(Request $request){
        // se inicia el proceso de registro.
        //1. validamos si el correo ya esta registrado como gimnasio
        //2. en caso de no existir se crea un nuevo registro y se manda a la segunda pantalla del registro
        //3. en caso de existir se valida si el registro esta completo o si requiere completarse
        //4. si su registro no esta completo se recuperan sus datos y se manda a la segunda pantalla del registro
        //5. si su registro ya esta completo se devuelve un alerta pidiendole que inicie sesion en el formulario de login
        if(is_null($request)){
            return redirect('/');
        }

        $response = [
            'result' => 'error',
            'msj' => ''
        ];

        $recoverUser = User::getByEmail($request->email);
        if(is_null($recoverUser))
        {
            // no existe. Nuevo Registro
            $data_user = [
                'name'      => $request->get('name'),
                'last_name'      => $request->get('last_name'),
                'email'      => $request->get('email'),
                'location_id'      => $request->get('location'),
                'state_id'      => $request->get('state'),
                'registration_mode'      => 'gym',
                'role_id'      => 2,
                'registration_status'      => 'Pendiente',
                'password'  => \Hash::make($request->get('password')),
                'terminos_condiciones'  => ($request->has('terminos_condiciones'))?1:0
            ];

            $newUser = User::create($data_user);
            $userJSON = json_decode(json_encode($newUser));
            $userJSON->password = $request->get('password');
            $this->saveFBRecord('users/'.$newUser->id, $userJSON);

            $userdata = array(
                'email' => $request->get('email'),
                'password'=> $request->get('password')
            );
            if(Auth::attempt($userdata))
            {
                $user = Auth::user();

                $state = State::find($request->get('state'));
                $location = Location::find($request->get('location'));

                //registramos datos de gimnasio
                $newGym = new Gym();
                $newGym->user_id = $user->id;
                $newGym->tradename = $request->get('tradename');
                $newGym->terminos_condiciones = ($request->has('terminos_condiciones'))?1:0;
                $newGym->state_id = $request->get('state');
                $newGym->gym_state = $state->title;
                $newGym->location_id = $request->get('location');
                $newGym->gym_city = $location->title;
                $newGym->gym_description = '';
                $newGym->lat = '';
                $newGym->lng = '';
                $newGym->publish_date = Carbon::now();
                $newGym->save();

                $request->session()->put('user_id', $user->id);
                $request->session()->put('gym_id', $newGym->id);

                $this->saveFBRecord('gyms/'.$newGym->id, $newGym);

                //recuperamos el registro
                /*$gym = Gym::where('user_id', $user->id)->first();
                $categories = Category::orderBy('title', 'asc')->get();
                $imagesGym = GymImage::where('gym_id', $gym->id)->get();

                return view('registro', [
                    'user' => $user,
                    'gym' => $gym,
                    'categories' => $categories,
                    'imagesGym' => (is_null($imagesGym))? [] : $imagesGym
                ]);*/

                $response['result'] = 'ok';

            }else{
                $response['msj'] = 'No se pudo procesar tu registro, vuelve a intentarlo.';
                //return $this->dispatchError(404, 'No se pudo procesar tu registro, vuelve a intentarlo.');
            }
        }else{
            //existe, validamos si el registro esta completo o falta
            if($recoverUser->registration_status=='Pendiente'){
                //registro incompleto, recuperamos los datos y los dirigimos a la segunda pantalla de registro
                $userdata = array(
                    'email' => $request->get('email'),
                    'password'=> $request->get('password')
                );
                if(Auth::attempt($userdata))
                {
                    $user = Auth::user();

                    $response['result'] = 'ok';

                    /*//recuperamos el registro
                    $gym = Gym::where('user_id', $user->id)->first();
                    $categories = Category::orderBy('title', 'asc')->get();
                    $imagesGym = GymImage::where('gym_id', $gym->id)->get();

                    return view('registro', [
                        'user' => $user,
                        'gym' => $gym,
                        'categories' => $categories,
                        'imagesGym' => (is_null($imagesGym))? [] : $imagesGym
                    ]);*/

                }else{
                    $response['msj'] = 'Ya iniciaste un registro previamente, usa el formuario de arriba para acceder a tu cuenta.';
                    //return $this->dispatchError(404, 'No se pudo procesar tu registro, vuelve a intentarlo.');
                }

            }else{
                //registro completo
                $response['msj'] = 'Tu perfil ya se encuentra completo, usa el formuario de arriba para acceder a tu cuenta.';
                //return $this->dispatchError(404, 'Tu perfil ya se encuentra completo, usa el formuario de arriba para acceder a tu cuenta.');
            }
        }

        return $response;
    }

    /*registro generales*/
    public function registerGrales(Request $request){
        if($request->session()->has('user_id'))
        {
            $user=User::find($request->session()->get('user_id'));
            //recuperamos el registro
            $gym = Gym::where('user_id', $request->session()->get('user_id'))->first();
            $categories = Category::orderBy('title', 'asc')->get();
            $imagesGym = GymImage::where('gym_id', $gym->id)->get();

            return view('front.registro.generales', [
                'user' => $user,
                'gym' => $gym,
                'categories' => $categories,
                'imagesGym' => (is_null($imagesGym))? [] : $imagesGym
            ]);
        }else{
            return redirect('/');
        }


    }

    public function uploadGymImage(Request $request){
        $response = [
            'result' => 'error',
            'file' => ''
        ];

        if ($request->hasFile('file') && $request->file('file')->isValid())
        {
            $ext = strtolower(pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_EXTENSION));
            $filename = $request->file('file')->getClientOriginalName();

            $gym = Gym::where('user_id',Auth::user()->id)->first();

            switch ($request->get('type'))
            {

                case 'images':
                    if (in_array($ext, ['tiff', 'jpg', 'jpeg', 'png']))
                    {
                        $newImageGym = new GymImage();
                        $newFile = Files::save($request->file('file')->getRealPath(), $ext, 'gyms', 'gym_');
                        $newImageGym->gym_id = $gym->id;
                        $newImageGym->image = $newFile;
                        $newImageGym->save();

                        $dataBitacora=[
                            'sol_user_id'=>$gym->user_id,
                            'table'=>'gym_image',
                            'table_column'=>'image',
                            'table_id'=>$newImageGym->id,
                            'old_info'=>'',
                            'new_info'=>$newFile,
                            'description'=>'Se grego nueva imagen'
                        ];
                        $this->newBitacora($dataBitacora);

                        $response['result'] = 'ok';
                        $response['file'] = $newFile;
                    }
                    else
                    {
                        $response['result'] = 'error_type';
                        $response['message'] = 'Solo formatos de TIFF, JPG y PNG';
                    }
                    break;
                case 'logo':
                    if (in_array($ext, ['tiff', 'jpg', 'jpeg', 'png']))
                    {
                        $newFile = Files::save($request->file('file')->getRealPath(), $ext, 'gyms', 'gym_');
                        $gym->gym_logo = $newFile;
                        $gym->save();

                        $response['result'] = 'ok';
                        $response['file'] = $newFile;
                    }
                    else
                    {
                        $response['result'] = 'error_type';
                        $response['message'] = 'Solo formatos de TIFF, JPG y PNG';
                    }
                    break;
                case 'registro':
                    if (in_array($ext, ['tiff', 'jpg', 'jpeg', 'png', 'pdf']))
                    {
                        $newFile = Files::save($request->file('file')->getRealPath(), $ext, 'gyms', 'gym_');
                        $gym->gym_register = $newFile;
                        $gym->save();

                        $response['result'] = 'ok';
                        $response['file'] = $newFile;
                    }
                    else
                    {
                        $response['result'] = 'error_type';
                        $response['message'] = 'Solo formatos de TIFF, JPG y PNG';
                    }
                    break;
            }
        }
        return $response;
    }

    public function registerGralesCreate(Request $request){

        // se inicia el proceso de registro.
        //1. validamos que exista una sesion activa
        //2. recuperamos el gym activo
        //3. actualizamos el registro del gym
        //4. registramos los servicios
        //5. registramos los horarios
        //6. redireccionamos a datos fiscales

        if(is_null($request)){
            return redirect('/');
        }

        $user = Auth::user();

        if(!is_null($user)){
            //recuperamos el registro
            $gym = Gym::where('user_id', $user->id)->first();

            $gym->manager = $request->get('manager');
            $gym->manager_cel = $request->get('manager_cel');
            $gym->gym_monthly_fee = $request->get('gym_monthly_fee');
            $gym->gym_phone = $request->get('gym_phone');
            $gym->gym_email = $request->get('gym_email');
            $gym->gym_web = $request->get('gym_web');
            $gym->gym_url_video = $request->get('gym_url_video');
            $gym->gym_description = $request->get('gym_description');
            $gym->gym_street = $request->get('gym_street');
            $gym->gym_number = $request->get('gym_number');
            $gym->gym_neighborhood = $request->get('gym_neighborhood');
            $gym->gym_zipcode = $request->get('gym_zipcode');
            $gym->lat = $request->get('lat');
            $gym->lng = $request->get('lng');
            $gym->diasopera = $request->get('diasoperasemana');
            $gym->gym_schedule = $request->get('gym_schedule');
            $gym->save();

            //eliminamos registros existentes de horarios y servicios
            $schedules = GymSchedule::where('gym_id',$gym->id)->forceDelete();
            $services = GymService::where('gym_id',$gym->id)->forceDelete();

            //registramos servicios
            foreach ($request->get('servicios') as $key => $value) {
                $service = new GymService();
                $service->gym_id = $gym->id;
                $service->category_id = $value;
                $service->save();
            }


            //registramos horarios
            foreach ($request->get('daysOpen') as $key => $value) {
                $schedule = new GymSchedule();
                $schedule->gym_id = $gym->id;
                if($value == 'lunes'){
                    $schedule->day_legend = 'Lunes';
                    $schedule->day = '1';
                    $schedule->start_time = $request->get('lunesDe');
                    $schedule->end_time = $request->get('lunesA');
                }
                if($value == 'martes'){
                    $schedule->day_legend = 'Martes';
                    $schedule->day = '2';
                    $schedule->start_time = $request->get('martesDe');
                    $schedule->end_time = $request->get('martesA');
                }
                if($value == 'miercoles'){
                    $schedule->day_legend = 'Miercoles';
                    $schedule->day = '3';
                    $schedule->start_time = $request->get('miercolesDe');
                    $schedule->end_time = $request->get('miercolesA');
                }
                if($value == 'jueves'){
                    $schedule->day_legend = 'Jueves';
                    $schedule->day = '4';
                    $schedule->start_time = $request->get('juevesDe');
                    $schedule->end_time = $request->get('juevesA');
                }
                if($value == 'viernes'){
                    $schedule->day_legend = 'Viernes';
                    $schedule->day = '5';
                    $schedule->start_time = $request->get('viernesDe');
                    $schedule->end_time = $request->get('viernesA');
                }
                if($value == 'sabado'){
                    $schedule->day_legend = 'Sábado';
                    $schedule->day = '6';
                    $schedule->start_time = $request->get('sabadoDe');
                    $schedule->end_time = $request->get('sabadoA');
                }
                if($value == 'domingo'){
                    $schedule->day_legend = 'Domingo';
                    $schedule->day = '7';
                    $schedule->start_time = $request->get('domingoDe');
                    $schedule->end_time = $request->get('domingoA');
                }
                $schedule->save();
            }

            /*return view('datos_fiscales', [
                'user' => $user,
                'gym' => $gym
            ]);*/
            return redirect('/registro-datos-fiscales');
        }else{
            return redirect('/');
        }

    }

    /*registro datos fiscales*/
    public function registerDFiscales(Request $request){

        if($request->session()->has('user_id'))
        {
            $user=User::find($request->session()->get('user_id'));

            //recuperamos el registro
            $gym = Gym::where('user_id', $request->session()->get('user_id'))->first();

            return view('front.registro.datos_fiscales', [
                'user' => $user,
                'gym' => $gym
            ]);

        }else{
            return redirect('/');
        }


    }

    public function registerDFiscalesCreate(Request $request){
        // se inicia el proceso de registro.
        //1. validamos que exista una sesion activa
        //2. recuperamos el gym activo
        //3. actualizamos el registro del gym
        //4. redireccionamos a datos de banco

        if(is_null($request)){
            return redirect('/');
        }

        $user = Auth::user();

        if(!is_null($user)){
            //recuperamos el registro
            $gym = Gym::where('user_id', $user->id)->first();

            $gym->gym_logo_change = ( $request->has('changeLogo') ) ? 1 : 0;
            $gym->razon_social = $request->get('razon_social');
            $gym->rfc = $request->get('rfc');
            $gym->calle = $request->get('calle');
            $gym->no_ext = $request->get('no_ext');
            $gym->no_int = $request->get('no_int');
            $gym->colonia = $request->get('colonia');
            $gym->cp = $request->get('cp');
            $gym->municipio = $request->get('municipio');
            $gym->ciudad = $request->get('ciudad');
            $gym->ciudad = $request->get('ciudad');
            $gym->estado = $request->get('estado');
            $gym->pais = $request->get('pais');
            $gym->save();

            $user->phone = $request->get('phone');
            $user->save();

            /*return view('datos_bancarios', [
                'user' => $user,
                'gym' => $gym
            ]);*/

            return redirect('/registro-datos-bancarios');
        }else{
            return redirect('/');
        }
    }

    /*registro datos bancarios*/
    public function registerDBancarios(Request $request){

        if($request->session()->has('user_id'))
        {
            $user=User::find($request->session()->get('user_id'));

            //recuperamos el registro
            $gym = Gym::where('user_id', $request->session()->get('user_id'))->first();

            return view('front.registro.datos_bancarios', [
                'user' => $user,
                'gym' => $gym,
                'terminos' => \App\Models\Terminoscondiciones\Terminocondicion::get()->first()
            ]);

        }else{
            return redirect('/');
        }


    }

    public function registerDBancariosCreate(Request $request){
        // se inicia el proceso de registro.
        //1. validamos que exista una sesion activa
        //2. recuperamos el gym activo
        //3. actualizamos el registro del gym
        //4. redireccionamos a finalizar proceso

        if(is_null($request)){
            return redirect('/');
        }

        $user = Auth::user();

        if(!is_null($user)){
            //recuperamos el registro
            $gym = Gym::where('user_id', $user->id)->first();



            $gym->terminos_condiciones = ( $request->has('terminos_condiciones') ) ? 1 : 0;
            $gym->cta_titular = $request->get('cta_titular');
            $gym->cta_numero = $request->get('cta_numero');
            $gym->cta_clabe = $request->get('cta_clabe');
            $gym->cta_banco = $request->get('cta_banco');
            $gym->cta_pais = $request->get('cta_pais');
            $gym->save();

            $user->registration_status = 'Finalizado';
            $user->save();


            /*REGISTRAMOS LA BITACORA DE NUEVO GYM*/
            $newBitacora = new Bitacora();
            $newBitacora->fecha_solicitud = \DB::raw('NOW()');
            $newBitacora->sol_user_id = $user->id;
            $newBitacora->user_type = "Gym";
            $newBitacora->table = 'gym';
            $newBitacora->table_column = 'publish_status';
            $newBitacora->table_id = $gym->id;
            $newBitacora->old_info = 'Pendiente';
            $newBitacora->new_info = 'Autorizado';
            $newBitacora->description = 'Nuevo Registro Gym: '.$gym->tradename;
            $newBitacora->save();

            /*return view('registro_finalizacion', [
                'user' => $user,
                'gym' => $gym
            ]);*/

            return redirect('/registro-finalizar');
        }else{
            return redirect('/');
        }
    }

    /*registro finalizar*/
    public function registerFinalizar(Request $request){

        if($request->session()->has('user_id'))
        {
            $user=User::find($request->session()->get('user_id'));

            //recuperamos el registro
            $gym = Gym::where('user_id', $request->session()->get('user_id'))->first();

            return view('front.registro.finalizacion', [
                'user' => $user,
                'gym' => $gym
            ]);

        }else{
            return redirect('/');
        }


    }

    /*FUNCIÒN PARA REGISTRO DEBITACORA*/
    public function newBitacora($dataBitacora){

        $newBitacora = new Bitacora();
        $newBitacora->fecha_solicitud = \DB::raw('NOW()');
        $newBitacora->sol_user_id =$dataBitacora['sol_user_id'];
        $newBitacora->user_type = "Gym";
        $newBitacora->table = $dataBitacora['table'];
        $newBitacora->table_column = $dataBitacora['table_column'];
        $newBitacora->table_id = $dataBitacora['table_id'];
        $newBitacora->old_info = $dataBitacora['old_info'];
        $newBitacora->new_info = $dataBitacora['new_info'];
        $newBitacora->description = $dataBitacora['description'];
        $newBitacora->save();
    }

    public function saveFBRecord($ref, $record){
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/liberi-4e329-firebase-adminsdk-e50il-40cdf113f1.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->create();
        $db = $firebase->getDatabase();
        $db->getReference($ref)->set($record);
    }

}
