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
use Tejuino\Adminbase\Files;
use Illuminate\View;
use Mail;
use Carbon\Carbon;
use Hash;
use App\Models\Bitacoras\Bitacora;
use App\Models\Promociones\Promocion;

use App\Models\User;
use App\Models\Users\UserQualification;
use App\Models\Users\UserPurchases;


use App\Models\Gyms\Gym;
use App\Models\Gyms\GymImage;
use App\Models\Gyms\GymSchedule;
use App\Models\Gyms\GymService;
use App\Models\Gyms\GymUsers;
use App\Models\Locations\Location;
use App\Models\States\State;
use App\Models\Categories\Category;


class PerfilController extends Controller
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

    /*Validación de usuario*/
    public function loginUser(Request $request){

        $response = [
            'result' => 'error',
            'message' => 'ha ocurrido un error',
            'type' => 0,
        ];

        $userdata = array(
            'email' => $request->get('login_name'),
            'password'=> $request->get('login_pass')
        );
        /*,
        'registration_mode'=> 'gym'*/

        if(Auth::attempt($userdata))
        {
            $user = Auth::user();
            if($user->role_id==2 || $user->role_id==3  || $user->role_id==5){//2=gym | 3=admin |5=Monitor(usuario de gym)
                $response['result'] ='ok';
                $response['type'] =$user->role_id;

                if($user->role_id==5){
                    $gymUser = GymUsers::where('user_id',$user->id)->get()->first();
                    $request->session()->put('gym_id', $gymUser->gym_id);

                }else if($user->role_id==2){
                    $gym = Gym::where('user_id',$user->id)->get()->first();
                    $request->session()->put('gym_id', $gym->id);

                }
                $response['message'] = 'Se inicio sesión correctamente.';
            }else{
                $response['type'] =1;
                $response['message'] = 'No tienes privilegios para ingresar por este medio.';
            }


        }else{
            $response['message'] = 'Sus credenciales no son validas. Por favor verifíquelas.';
        }
        return $response;
    }

    /*PERFIL GYM*/

    /*Perfil Inicio*/
    public function perfilInicio(Request $request){

        $user = Auth::user();

        if(!is_null($user)){
            if(!$user->registration_mode=='gym'){
                return redirect('/');
            }else{
                $gym = Gym::where('user_id', $user->id)->first();

                //recuperamos la informacion del form y guardamos
                if($request->has('editInfo')){
                    /*Se modifica*/
                    if($gym->gym_url_video != $request->get('gym_url_video')){
                        $dataBitacora=[
                            'sol_user_id'=>$user->id,
                            'table'=>'gym',
                            'table_column'=>'gym_url_video',
                            'table_id'=>$gym->id,
                            'old_info'=>$gym->gym_url_video,
                            'new_info'=>$request->get('gym_url_video'),
                            'description'=>'Modificación de datos'
                        ];
                        $this->newBitacora($dataBitacora);
                        $gym->gym_url_video = $request->get('gym_url_video');
                    }

                    if($gym->gym_description != $request->get('gym_description')){
                        $dataBitacora=[
                            'sol_user_id'=>$user->id,
                            'table'=>'gym',
                            'table_column'=>'gym_description',
                            'table_id'=>$gym->id,
                            'old_info'=>$gym->gym_description,
                            'new_info'=>$request->get('gym_description'),
                            'description'=>'Modificación de datos'
                        ];
                        $this->newBitacora($dataBitacora);
                        $gym->gym_description = $request->get('gym_description');
                    }

                    if($gym->gym_monthly_fee != $request->get('gym_monthly_fee')){
                        $dataBitacora=[
                            'sol_user_id'=>$user->id,
                            'table'=>'gym',
                            'table_column'=>'gym_monthly_fee',
                            'table_id'=>$gym->id,
                            'old_info'=>$gym->gym_monthly_fee,
                            'new_info'=>$request->get('gym_monthly_fee'),
                            'description'=>'Modificación de datos'
                        ];
                        $this->newBitacora($dataBitacora);
                        $gym->gym_monthly_fee = $request->get('gym_monthly_fee');
                    }

                    if($gym->gym_phone != $request->get('gym_phone')){
                        $dataBitacora=[
                            'sol_user_id'=>$user->id,
                            'table'=>'gym',
                            'table_column'=>'gym_phone',
                            'table_id'=>$gym->id,
                            'old_info'=>$gym->gym_phone,
                            'new_info'=>$request->get('gym_phone'),
                            'description'=>'Modificación de datos'
                        ];
                        $this->newBitacora($dataBitacora);
                        $gym->gym_phone = $request->get('gym_phone');
                    }

                    if($gym->gym_email != $request->get('gym_email')){
                        $dataBitacora=[
                            'sol_user_id'=>$user->id,
                            'table'=>'gym',
                            'table_column'=>'gym_email',
                            'table_id'=>$gym->id,
                            'old_info'=>$gym->gym_email,
                            'new_info'=>$request->get('gym_email'),
                            'description'=>'Modificación de datos'
                        ];
                        $this->newBitacora($dataBitacora);
                        $gym->gym_email = $request->get('gym_email');
                    }

                    if($gym->gym_web != $request->get('gym_web')){
                        $dataBitacora=[
                            'sol_user_id'=>$user->id,
                            'table'=>'gym',
                            'table_column'=>'gym_web',
                            'table_id'=>$gym->id,
                            'old_info'=>$gym->gym_web,
                            'new_info'=>$request->get('gym_web'),
                            'description'=>'Modificación de datos'
                        ];
                        $this->newBitacora($dataBitacora);
                        $gym->gym_web = $request->get('gym_web');
                    }

                    if($gym->gym_street != $request->get('gym_street')){
                        $dataBitacora=[
                            'sol_user_id'=>$user->id,
                            'table'=>'gym',
                            'table_column'=>'gym_street',
                            'table_id'=>$gym->id,
                            'old_info'=>$gym->gym_street,
                            'new_info'=>$request->get('gym_street'),
                            'description'=>'Modificación de datos'
                        ];
                        $this->newBitacora($dataBitacora);
                        $gym->gym_street = $request->get('gym_street');
                    }

                    if($gym->gym_number != $request->get('gym_number')){
                        $dataBitacora=[
                            'sol_user_id'=>$user->id,
                            'table'=>'gym',
                            'table_column'=>'gym_number',
                            'table_id'=>$gym->id,
                            'old_info'=>$gym->gym_number,
                            'new_info'=>$request->get('gym_number'),
                            'description'=>'Modificación de datos'
                        ];
                        $this->newBitacora($dataBitacora);
                        $gym->gym_number = $request->get('gym_number');
                    }

                    if($gym->gym_neighborhood != $request->get('gym_neighborhood')){
                        $dataBitacora=[
                            'sol_user_id'=>$user->id,
                            'table'=>'gym',
                            'table_column'=>'gym_neighborhood',
                            'table_id'=>$gym->id,
                            'old_info'=>$gym->gym_neighborhood,
                            'new_info'=>$request->get('gym_neighborhood'),
                            'description'=>'Modificación de datos'
                        ];
                        $this->newBitacora($dataBitacora);
                        $gym->gym_neighborhood = $request->get('gym_neighborhood');
                    }

                    if($gym->gym_zipcode != $request->get('gym_zipcode')){
                        $dataBitacora=[
                            'sol_user_id'=>$user->id,
                            'table'=>'gym',
                            'table_column'=>'gym_zipcode',
                            'table_id'=>$gym->id,
                            'old_info'=>$gym->gym_zipcode,
                            'new_info'=>$request->get('gym_zipcode'),
                            'description'=>'Modificación de datos'
                        ];
                        $this->newBitacora($dataBitacora);
                        $gym->gym_zipcode = $request->get('gym_zipcode');
                    }

                    $gym->gym_schedule = $request->get('gym_schedule');

                    $gym->manager = $request->get('manager');
                    $gym->manager_cel = $request->get('manager_cel');

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
                }

                //cargamos la informacion de inicio
                $schedules = GymSchedule::where('gym_id',$gym->id)->orderBy('day', 'asc')->get();
                $services = GymService::where('gym_id',$gym->id)->get();
                $categories = Category::orderBy('title', 'asc')->get();
                $imagesGym = GymImage::where('gym_id', $gym->id)->get();

                $servicesSelected = [];
                foreach($services as $service){
                    array_push($servicesSelected,$service->category_id);
                }

                $schedulesSelected = [
                    ['day'=>1, 'inicia'=>'', 'termina'=>'', 'checked'=>'false'],
                    ['day'=>2, 'inicia'=>'', 'termina'=>'', 'checked'=>'false'],
                    ['day'=>3, 'inicia'=>'', 'termina'=>'', 'checked'=>'false'],
                    ['day'=>4, 'inicia'=>'', 'termina'=>'', 'checked'=>'false'],
                    ['day'=>5, 'inicia'=>'', 'termina'=>'', 'checked'=>'false'],
                    ['day'=>6, 'inicia'=>'', 'termina'=>'', 'checked'=>'false'],
                    ['day'=>7, 'inicia'=>'', 'termina'=>'', 'checked'=>'false']
                ];
                foreach($schedules as $schedule){
                    if($schedule->day=='1'){
                        $schedulesSelected[0]['inicia']=$schedule->start_time;
                        $schedulesSelected[0]['termina']=$schedule->end_time;
                        $schedulesSelected[0]['checked']='checked';
                    }
                    if($schedule->day=='2'){
                        $schedulesSelected[1]['inicia']=$schedule->start_time;
                        $schedulesSelected[1]['termina']=$schedule->end_time;
                        $schedulesSelected[1]['checked']='checked';
                    }
                    if($schedule->day=='3'){
                        $schedulesSelected[2]['inicia']=$schedule->start_time;
                        $schedulesSelected[2]['termina']=$schedule->end_time;
                        $schedulesSelected[2]['checked']='checked';
                    }
                    if($schedule->day=='4'){
                        $schedulesSelected[3]['inicia']=$schedule->start_time;
                        $schedulesSelected[3]['termina']=$schedule->end_time;
                        $schedulesSelected[3]['checked']='checked';
                    }
                    if($schedule->day=='5'){
                        $schedulesSelected[4]['inicia']=$schedule->start_time;
                        $schedulesSelected[4]['termina']=$schedule->end_time;
                        $schedulesSelected[4]['checked']='checked';
                    }
                    if($schedule->day=='6'){
                        $schedulesSelected[5]['inicia']=$schedule->start_time;
                        $schedulesSelected[5]['termina']=$schedule->end_time;
                        $schedulesSelected[5]['checked']='checked';
                    }
                    if($schedule->day=='7'){
                        $schedulesSelected[6]['inicia']=$schedule->start_time;
                        $schedulesSelected[6]['termina']=$schedule->end_time;
                        $schedulesSelected[6]['checked']='checked';
                    }
                }

            }
        }else{
            return redirect('/');
        }

        return view('front.gyms.perfil_inicio', [
            'user' => $user,
            'gym' => $gym,
            'categories' => $categories,
            'schedulesSelected' => $schedulesSelected,
            'servicesSelected' => $servicesSelected,
            'imagesGym' => (is_null($imagesGym))? [] : $imagesGym
        ]);

    }

    /*Eliminar imagen de perfil*/
    public function perfilDeleteImage(Request $request){
        $response = [
            'result'=> 'error'
        ];
        $delImage = GymImage::find($request->get('image_id'));

        if(!is_null($delImage))
        {
            $delImage->delete();

            $response['result']='ok';
        }

        return $response;
    }

    /*Perfil Datos Fiscales*/
    public function perfilDFiscales(Request $request){

        $user = Auth::user();

        if(!is_null($user)){
            if(!$user->registration_mode=='gym'){
                return redirect('/');
            }else{
                $gym = Gym::where('user_id', $user->id)->first();

                //recuperamos la informacion del form y guardamos
                if($request->has('editInfo')){
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
                }
            }
        }else{
            return redirect('/');
        }

        return view('front.gyms.datos_fiscales', [
            'user' => $user,
            'gym' => $gym
        ]);

    }

    /*Perfil Datos Bancarios*/
    public function perfilDBancarios(Request $request){

        $user = Auth::user();

        if(!is_null($user)){
            if(!$user->registration_mode=='gym'){
                return redirect('/');
            }else{
                $gym = Gym::where('user_id', $user->id)->get()->first();

                //recuperamos la informacion del form y guardamos
                if($request->has('editInfo')){
                    $gym->cta_titular = $request->get('cta_titular');
                    $gym->cta_numero = $request->get('cta_numero');
                    $gym->cta_clabe = $request->get('cta_clabe');
                    $gym->cta_banco = $request->get('cta_banco');
                    $gym->cta_pais = $request->get('cta_pais');
                    $gym->save();

                }
            }
        }else{
            return redirect('/');
        }

        return view('front.gyms.datos_bancarios', [
            'user' => $user,
            'gym' => $gym
        ]);

    }

    /*perfil - usuarios*/
    public function perfilUsuarios(Request $request){
        $user = Auth::user();

        if(!is_null($user)){
            if(!$user->registration_mode=='gym'){
                return redirect('/logout');
            }else{

                $gym = Gym::find($request->session()->get('gym_id'));

                $gymUsers = GymUsers::where('gym_id', $gym->id)->get();
                foreach ($gymUsers as $gymuser) {

                    $gymuser->usuario = User::find($gymuser->user_id);
                }

            }
        }else{
            return redirect('/');
        }

        return view('front.gyms.perfil_usuarios', [
            'user' => $user,
            'gym' => $gym,
            'gymUsers' => $gymUsers
        ]);
    }

    /*perfil - usuarios - delete*/
    public function perfilUsuariosDelete(Request $request){
        $response = [
            'result' => 'error',
            'msj' => ''
        ];
        if($request->has('gymuser_id'))
        {
            $gymUser = GymUsers::find($request->get('gymuser_id'));
            if(!is_null($gymUser))
            {
                $userId = $gymUser->user_id;
                $gymUser->forceDelete();

                $user = User::find($userId);
                //$user->status='Eliminado';

                $user->delete();



                $response['result'] = 'ok';
            }else{
                $response['msj'] = 'No se pudo eliminar, vuelve a intentarlo';
            }

        }else{
            $response['msj'] = 'No se pudo eliminar, vuelve a intentarlo';
        }

        return $response;
    }

    /*perfil - usuarios - select*/
    public function perfilUsuariosSelect(Request $request){
        $response = [
            'result' => 'error',
            'usuario' => [],
            'msj' => ''
        ];
        if($request->has('gymuser_id'))
        {
            $gymUser = GymUsers::where('id',$request->get('gymuser_id'))->get()->first();
            if(!is_null($gymUser))
            {

                $gymUser->usuario = User::find($gymUser->user_id);

                $response['usuario'] = $gymUser;
                $response['result'] = 'ok';
            }else{
                $response['msj'] = 'No se pudo cargar la información del usuario, vuelve a intentarlo';
            }

        }else{
            $response['msj'] = 'No se pudo cargar la información del usuario, vuelve a intentarlo';
        }

        return $response;
    }

    /*perfil - usuarios - create*/
    public function perfilUsuariosCreate(Request $request){
        $response = [
            'result' => 'error',
            'msj' => ''
        ];
        if($request->has('editInfo'))
        {
            if($request->get('editInfo')==0){
                $userExist = User::where('email',$request->get('user_nick'))->get()->first();
                if(is_null($userExist)){
                    //agregamos
                    $data_user = [
                        'name'      => $request->get('user_name'),
                        'email'      => $request->get('user_nick'),
                        'image'      => $request->get('image'),
                        'registration_mode'      => 'gym',
                        'role_id'      => 5,
                        'registration_status'      => 'Activo',
                        'password'  => \Hash::make($request->get('password'))
                    ];

                    $newUser = User::create($data_user);

                    $newGymUsers = new GymUsers();
                    $newGymUsers->gym_id = $request->session()->get('gym_id');
                    $newGymUsers->user_id = $newUser->id;
                    $newGymUsers->save();

                    $response['result'] = 'ok';
                }else{
                    $response['msj'] = 'El correo ya se encuentra registrado en el sistema y no se puede repetir';
                }
            }else{
                //editamos

                $user = User::where('id',$request->get('gymuser_id'))->get()->first();
                $user->name = $request->get('user_name');
                $user->image = $request->get('image');
                if($request->get('password')!='required'){
                    $user->password = \Hash::make($request->get('password'));
                }
                $user->save();

                $response['result'] = 'ok';

            }


        }else{
            $response['msj'] = 'No se pudo cargar la información del usuario, vuelve a intentarlo';
        }

        return $response;
    }

    /*perfil - usuarios - upload - imagearc*/
    public function perfilUsuariosUploadImage(Request $request){
        $response = [
            'result' => 'error',
            'file' => ''
        ];

        if ($request->hasFile('file') && $request->file('file')->isValid())
        {
            $ext = strtolower(pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_EXTENSION));
            $filename = $request->file('file')->getClientOriginalName();

            switch ($request->get('type'))
            {

                case 'images':
                    if (in_array($ext, ['tiff', 'jpg', 'jpeg', 'png']))
                    {
                        $newFile = Files::save($request->file('file')->getRealPath(), $ext, 'users', 'user_');

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

    /*perfil - reportes - comentarios*/
    public function perfilReportesComentarios(Request $request){
        $user = Auth::user();

        if(!is_null($user)){
            if(!$user->registration_mode=='gym'){
                return redirect('/logout');
            }else{

                $gym = Gym::find($request->session()->get('gym_id'));

                $gymPurcharses = UserPurchases::where('gym_id', $gym->id)->with('qualification')->get();

                foreach ($gymPurcharses as $gymPurcharse) {

                    $gymPurcharse->usuario = User::find($gymPurcharse->user_id);
                }

            }
        }else{
            return redirect('/');
        }

        return view('front.gyms.perfil_reporte_comentario', [
            'user' => $user,
            'gym' => $gym,
            'gymPurcharses' => $gymPurcharses
        ]);
    }

    /*perfil - reportes - ventas*/
    public function perfilReportesVentas(Request $request){
        $user = Auth::user();

        if(!is_null($user)){
            if(!$user->registration_mode=='gym'){
                return redirect('/logout');
            }else{

                $gym = Gym::find($request->session()->get('gym_id'));

                $gymPurcharses = UserPurchases::where('gym_id', $gym->id)->get();

                foreach ($gymPurcharses as $gymPurcharse) {

                    $gymPurcharse->usuario = User::find($gymPurcharse->user_id);
                }

            }
        }else{
            return redirect('/');
        }

        return view('front.gyms.perfil_reporte_ventas', [
            'user' => $user,
            'gym' => $gym,
            'gymPurcharses' => $gymPurcharses
        ]);
    }

    /*perfil - reportes - servicio*/
    public function perfilReportesServicio(Request $request){
        $user = Auth::user();

        if(!is_null($user)){

            if(!$user->registration_mode=='gym'){
                return redirect('/logout');
            }else{
                //dd($request->session()->get('gym_id'));
                $gym = Gym::find($request->session()->get('gym_id'));
            }
        }else{
            return redirect('/');
        }


        return view('front.gyms.perfil_reporte_servicio', [
            'user' => $user,
            'gym' => $gym
        ]);
    }

    /*perfil - reportes - servicio - reportar*/
    public function perfilReportesServicioReportar(Request $request){
        $response = [
            'result' => "error",
            'msj' => ''
        ];

        $user = Auth::user();

        if(!is_null($user)){
            if(!$user->registration_mode=='gym'){
                return redirect('/logout');
            }else{

                $gym = Gym::find($request->session()->get('gym_id'));

                $parms = [
                    'GymId' => $gym->id,
                    'GymName' => $gym->tradename,
                    'Nombre' => $request->get('nombre'),
                    'Correo' => $request->get('correo'),
                    'IDUsuario' => $request->get('idusuario'),
                    'Comentario' => $request->get('comentario'),
                ];

                // Send email
                Mail::send('emails.reporte_servicio', $parms, function($message)use($request){
                    $message->subject('Reporte de Mal Uso de Servicio - Liberi.com.mx');
                    $message->from(config('mail.from.address'), config('mail.from.name'));

                    /*foreach(config('mail.to.addresses') as $email)
                    {*/
                    $message->to('taquion3x109@gmail.com', 'LIBERI WEB');
                        //$message->to($email, config('mail.to.name'));
                    //}
                });

                $response['result']='ok';
            }
        }else{
            $response['msj']='No se pudo enviar su reporte, vuelva a intentarlo';
        }

        return $response;

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

    /*!--PERFIL GYM--*/

    /*PERFIL ADMINISTRACION*/

    /*Admin Inicio*/
    public function adminInicio(Request $request){

        $user = Auth::user();

        if(!is_null($user)){
            if(!$user->role_id==3){
                return redirect('/');
            }else{
                $gyms = Gym::orderBy('tradename', 'ASC')->get();
                foreach ($gyms as $gym) {
                    $gym->usuario=User::find($gym->user_id);
                }
            }
        }else{
            return redirect('/');
        }

        return view('front.admin.perfil_inicio', [
            'user' => $user,
            'gyms' => $gyms
        ]);

    }

    /*Admin - usuarios*/
    public function adminUsuarios(Request $request){
        $user = Auth::user();

        if(!is_null($user)){
            if($user->role_id!=3){
                return redirect('/logout');
            }else{

                $gym = Gym::find($request->session()->get('gym_id'));

                $users = User::where('role_id',3)->get();

            }
        }else{
            return redirect('/');
        }

        return view('front.admin.perfil_usuarios', [
            'user' => $user,
            'gym' => $gym,
            'users' => $users
        ]);
    }

    /*Admin - usuarios - delete*/
    public function adminUsuariosDelete(Request $request){
        $response = [
            'result' => 'error',
            'msj' => ''
        ];
        if($request->has('user_id'))
        {
            $user = User::find($request->get('user_id'));
            if(!is_null($user))
            {
                $user->delete();
                $response['result'] = 'ok';
            }else{
                $response['msj'] = 'No se pudo eliminar, vuelve a intentarlo';
            }

        }else{
            $response['msj'] = 'No se pudo eliminar, vuelve a intentarlo';
        }

        return $response;
    }

    /*Admin - usuarios - select*/
    public function adminUsuariosSelect(Request $request){
        $response = [
            'result' => 'error',
            'usuario' => [],
            'msj' => ''
        ];
        if($request->has('user_id'))
        {
            $user = User::find($request->get('user_id'));
            if(!is_null($user))
            {
                $response['usuario'] = $user;
                $response['result'] = 'ok';
            }else{
                $response['msj'] = 'No se pudo cargar la información del usuario, vuelve a intentarlo';
            }

        }else{
            $response['msj'] = 'No se pudo cargar la información del usuario, vuelve a intentarlo';
        }

        return $response;
    }

    /*Admin - usuarios - create*/
    public function adminUsuariosCreate(Request $request){
        $response = [
            'result' => 'error',
            'msj' => ''
        ];
        if($request->has('editInfo'))
        {
            if($request->get('editInfo')==0){
                //validamos que el correo no exista
                $userExist = User::where('email',$request->get('user_nick'))->get()->first();
                if(is_null($userExist)){
                    //agregamos
                    $data_user = [
                        'name'      => $request->get('user_name'),
                        'email'      => $request->get('user_nick'),
                        'image'      => $request->get('image'),
                        'registration_mode'      => 'email',
                        'role_id'      => 3,
                        'registration_status'      => 'Activo',
                        'password'  => \Hash::make($request->get('password'))
                    ];

                    $newUser = User::create($data_user);

                    $response['result'] = 'ok';
                }else{
                    $response['msj'] = 'El correo ya se encuentra registrado en el sistema y no se puede repetir';
                }

            }else{
                //editamos
                $user = User::where('id',$request->get('user_id'))->get()->first();
                $user->name = $request->get('user_name');
                $user->image = $request->get('image');
                if($request->get('password')!='required'){
                    $user->password = \Hash::make($request->get('password'));
                }
                $user->save();

                $response['result'] = 'ok';
            }

        }else{
            $response['msj'] = 'No se pudo cargar la información del usuario, vuelve a intentarlo';
        }

        return $response;
    }

    /*Admin - reportes - ventas*/
    public function adminReportesVentas(Request $request){
        $user = Auth::user();

        if(!is_null($user)){
            if($user->role_id!=3){
                return redirect('/logout');
            }else{
                $gymPurcharses = UserPurchases::orderBy('fecha', 'DESC')->get();

                foreach ($gymPurcharses as $gymPurcharse) {
                    $gymPurcharse->usuario = User::find($gymPurcharse->user_id);
                    $gymPurcharse->gym = Gym::find($gymPurcharse->gym_id);
                }

            }
        }else{
            return redirect('/');
        }

        return view('front.admin.perfil_reporte_ventas', [
            'user' => $user,
            'gymPurcharses' => $gymPurcharses
        ]);
    }

    /*Admin - reportes - notificaciones*/
    public function adminReportesNotificaciones(Request $request){
        $user = Auth::user();

        if(!is_null($user)){
            if($user->role_id!=3){
                return redirect('/logout');
            }else{
                $bitacoras = Bitacora::where('user_type','Gym')->where('status','Activo')->orderBy('fecha_solicitud', 'DESC')->get();

                foreach ($bitacoras as $bitacora) {
                    $bitacora->gym = Gym::where('user_id',$bitacora->sol_user_id)->get()->first();
                }

            }
        }else{
            return redirect('/');
        }

        return view('front.admin.perfil_reporte_notificaciones', [
            'user' => $user,
            'bitacoras' => $bitacoras
        ]);
    }

    /*Admin - reportes - notificaciones - aceptar*/
    public function adminReportesNotificacionesAceptar(Request $request){
        $response = [
            'result' => 'error',
            'msj' => ''
        ];
        if($request->has('bitacora_id'))
        {
            $bitacora = Bitacora::find($request->get('bitacora_id'));
            if(!is_null($bitacora))
            {
                //aceptamos la información
                $aceptarInfo = DB::statement("UPDATE ".$bitacora->table." SET ".$bitacora->table_column."='".$bitacora->new_info."' WHERE id=".$bitacora->table_id);

                $bitacora->status_auth='Autorizado';
                $bitacora->status='Procesado';
                $bitacora->fecha_autorizacion = \DB::raw('NOW()');
                $bitacora->aut_user_id=Auth::user()->id;
                $bitacora->save();

                $response['result'] = 'ok';
            }else{
                $response['msj'] = 'No se pudo aceptar, vuelve a intentarlo';
            }

        }else{
            $response['msj'] = 'No se pudo aceptar, vuelve a intentarlo';
        }

        return $response;
    }

    /*Admin - reportes - notificaciones - cancelar*/
    public function adminReportesNotificacionesCancelar(Request $request){
        $response = [
            'result' => 'error',
            'msj' => ''
        ];
        if($request->has('bitacora_id'))
        {
            $bitacora = Bitacora::find($request->get('bitacora_id'));
            if(!is_null($bitacora))
            {
                //hacemos rollback a la información
                $rollBack = DB::statement("UPDATE ".$bitacora->table." SET ".$bitacora->table_column."='".$bitacora->old_info."' WHERE id=".$bitacora->table_id);


                $bitacora->status_auth='Cancelado';
                $bitacora->status='Procesado';
                $bitacora->fecha_autorizacion = \DB::raw('NOW()');
                $bitacora->aut_user_id=Auth::user()->id;
                $bitacora->save();

                $response['result'] = 'ok';
            }else{
                $response['msj'] = 'No se pudo rechazar el cambio, vuelve a intentarlo';
            }

        }else{
            $response['msj'] = 'No se pudo rechazar el cambio, vuelve a intentarlo';
        }

        return $response;
    }

    /*Admin - promociones*/
    public function adminPromociones(Request $request){
        $user = Auth::user();

        if(!is_null($user)){
            if($user->role_id!=3){
                return redirect('/logout');
            }else{
                $promociones = Promocion::orderBy('vigencia','Desc')->get();
            }
        }else{
            return redirect('/');
        }

        return view('front.admin.perfil_promociones', [
            'user' => $user,
            'promociones' => $promociones
        ]);
    }

    /*Admin - promociones - delete*/
    public function adminPromocionesDelete(Request $request){
        $response = [
            'result' => 'error',
            'msj' => ''
        ];
        if($request->has('promo_id'))
        {
            $promo = Promocion::find($request->get('promo_id'));
            if(!is_null($promo))
            {
                $promo->delete();
                $response['result'] = 'ok';
            }else{
                $response['msj'] = 'No se pudo eliminar, vuelve a intentarlo';
            }

        }else{
            $response['msj'] = 'No se pudo eliminar, vuelve a intentarlo';
        }

        return $response;
    }

    /*Admin - promociones - select*/
    public function adminPromocionesSelect(Request $request){
        $response = [
            'result' => 'error',
            'promo' => [],
            'msj' => ''
        ];
        if($request->has('promo_id'))
        {
            $promo = Promocion::find($request->get('promo_id'));
            if(!is_null($promo))
            {
                $response['promo'] = $promo;
                $response['result'] = 'ok';
            }else{
                $response['msj'] = 'No se pudo cargar la información de la promoción, vuelve a intentarlo';
            }

        }else{
            $response['msj'] = 'No se pudo cargar la información de la promoción, vuelve a intentarlo';
        }

        return $response;
    }

    /*Admin - promociones - create*/
    public function adminPromocionesCreate(Request $request){
        $response = [
            'result' => 'error',
            'msj' => ''
        ];
        if($request->has('editInfo'))
        {
            if($request->get('editInfo')==0){

                $newPromo = new Promocion();

                $newPromo->nombre_promocion = $request->get('nombre_promocion');
                $newPromo->vigencia = $request->get('vigencia');
                $newPromo->tipo = $request->get('tipo');
                $newPromo->monto = $request->get('monto');
                $newPromo->limite = $request->get('limite');
                $newPromo->cantidad = $request->get('cantidad');
                $newPromo->por_usuario = $request->get('por_usuario');
                $newPromo->save();

                $response['result'] = 'ok';
            }else{
                //editamos
                $promo = Promocion::find($request->get('promo_id'));
                $promo->nombre_promocion = $request->get('nombre_promocion');
                $promo->vigencia = $request->get('vigencia');
                $promo->tipo = $request->get('tipo');
                $promo->monto = $request->get('monto');
                $promo->limite = $request->get('limite');
                $promo->cantidad = $request->get('cantidad');
                $promo->por_usuario = $request->get('por_usuario');
                $promo->save();

                $response['result'] = 'ok';
            }

        }else{
            $response['msj'] = 'No se pudo cargar la información de la información, vuelve a intentarlo';
        }

        return $response;
    }

    /*Admin - clientes - gym*/
    public function adminClientesGym(Request $request, $id){

        $user = Auth::user();

        $gym = Gym::where('id', $id)->first();
        if(!is_null($gym)){
            //cargamos la informacion de inicio
            $schedules = GymSchedule::where('gym_id',$gym->id)->orderBy('day', 'asc')->get();
            $services = GymService::where('gym_id',$gym->id)->get();
            $categories = Category::orderBy('title', 'asc')->get();
            $imagesGym = GymImage::where('gym_id', $gym->id)->get();

            $servicesSelected = [];
            foreach($services as $service){
                array_push($servicesSelected,$service->category_id);
            }

            $schedulesSelected = [
                ['day'=>1, 'inicia'=>'', 'termina'=>'', 'checked'=>'false'],
                ['day'=>2, 'inicia'=>'', 'termina'=>'', 'checked'=>'false'],
                ['day'=>3, 'inicia'=>'', 'termina'=>'', 'checked'=>'false'],
                ['day'=>4, 'inicia'=>'', 'termina'=>'', 'checked'=>'false'],
                ['day'=>5, 'inicia'=>'', 'termina'=>'', 'checked'=>'false'],
                ['day'=>6, 'inicia'=>'', 'termina'=>'', 'checked'=>'false'],
                ['day'=>7, 'inicia'=>'', 'termina'=>'', 'checked'=>'false']
            ];
            foreach($schedules as $schedule){
                if($schedule->day=='1'){
                    $schedulesSelected[0]['inicia']=$schedule->start_time;
                    $schedulesSelected[0]['termina']=$schedule->end_time;
                    $schedulesSelected[0]['checked']='checked';
                }
                if($schedule->day=='2'){
                    $schedulesSelected[1]['inicia']=$schedule->start_time;
                    $schedulesSelected[1]['termina']=$schedule->end_time;
                    $schedulesSelected[1]['checked']='checked';
                }
                if($schedule->day=='3'){
                    $schedulesSelected[2]['inicia']=$schedule->start_time;
                    $schedulesSelected[2]['termina']=$schedule->end_time;
                    $schedulesSelected[2]['checked']='checked';
                }
                if($schedule->day=='4'){
                    $schedulesSelected[3]['inicia']=$schedule->start_time;
                    $schedulesSelected[3]['termina']=$schedule->end_time;
                    $schedulesSelected[3]['checked']='checked';
                }
                if($schedule->day=='5'){
                    $schedulesSelected[4]['inicia']=$schedule->start_time;
                    $schedulesSelected[4]['termina']=$schedule->end_time;
                    $schedulesSelected[4]['checked']='checked';
                }
                if($schedule->day=='6'){
                    $schedulesSelected[5]['inicia']=$schedule->start_time;
                    $schedulesSelected[5]['termina']=$schedule->end_time;
                    $schedulesSelected[5]['checked']='checked';
                }
                if($schedule->day=='7'){
                    $schedulesSelected[6]['inicia']=$schedule->start_time;
                    $schedulesSelected[6]['termina']=$schedule->end_time;
                    $schedulesSelected[6]['checked']='checked';
                }
            }
        }else{
            return redirect('/');
        }

        return view('front.admin.perfil_gym_generales', [
            'user' => $user,
            'gym' => $gym,
            'categories' => $categories,
            'schedulesSelected' => $schedulesSelected,
            'servicesSelected' => $servicesSelected,
            'imagesGym' => (is_null($imagesGym))? [] : $imagesGym
        ]);

    }

    /*Admin - clientes - gym - Datos Fiscales*/
    public function adminClientesGymDFis(Request $request, $id){

        $user = Auth::user();

        $gym = Gym::where('id', $id)->first();

        if(is_null($gym)){
            return redirect('/');
        }

        return view('front.admin.perfil_gym_datos_fiscales', [
            'user' => $user,
            'gym' => $gym
        ]);

    }

    /*Admin - clientes - gym - Datos Bancarios*/
    public function adminClientesGymDBan(Request $request, $id){

        $user = Auth::user();
        $gym = Gym::where('id', $id)->get()->first();

        if(is_null($gym)){

            return redirect('/');
        }

        return view('front.admin.perfil_gym_datos_bancarios', [
            'user' => $user,
            'gym' => $gym
        ]);

    }




    /*!--PERFIL ADMINISTRACION--*/

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



}
