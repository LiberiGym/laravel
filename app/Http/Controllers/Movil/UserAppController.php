<?php
namespace App\Http\Controllers\Movil;

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

use App\Models\User;
use App\Models\Users\UserCard;

use App\Models\Gyms\Gym;
use App\Models\Gyms\GymImage;
use App\Models\Gyms\GymSchedule;
use App\Models\Gyms\GymService;
use App\Models\Locations\Location;
use App\Models\States\State;
use App\Models\Categories\Category;


class UserAppController extends BaseController
{

    public function __construct()
    {

    }

    /***************************/
    /*Login Page*/

    //validacion de ingreso usuario
    public function userLogin(Request $request){
        $response = [
            'result'=>'error',
            'msj'=>'',
            'Id'=>0,
            'Nombre'=>''
        ];
        if($request->has('Email')){

            try {
                $userdata = array(
                    'email' => $request->get('Email'),
                    'password'=> $request->get('Password')
                );
                if(Auth::attempt($userdata))
                {
                    $user = Auth::user();

                    $response['Id']=$user->id;
                    $response['Nombre']=$user->name;
                    $response['result']= 'ok';
                }else{
                    $response['msj']= 'Datos de Usuario Incorrectos. Vuelva a intentarlo';
                }

            } catch (\Exception $e) {
                $response['msj']= $e;
            }


        }else{
            $response['msj']= 'No hay variabel Email';
        }

        return $response;
    }

    //recuperar contraseña de usuario
    public function userPasswordReset(Request $request){
        $response = [
            'result'=>'error',
            'msj'=>''
        ];
        if($request->has('Email')){
            try {
                $user  = User::where('email',$request->get('Email'))->where('registration_mode','client')->get()->first();
                if(!is_null($user))
                {
                    $s = strtoupper(md5(uniqid(rand(),true)));
                    $newpass = substr($s, -7, 6);
                    $user->password = \Hash::make($newpass);
                    $user->save();

                    $dataMail = [
                        'nombre' => $user->name,
                        'newpass'=>$newpass,
                        'email'=>$request->get('Email')
                    ];

                    Mail::send('emails.recoverypass', $dataMail, function ($message) use ($dataMail) {
                        $message->subject('Recuperación de contraseña App Liberi');
                        $message->from(config('mail.from.address'), config('mail.from.name'));
                        $message->to($dataMail['email'], $dataMail['nombre']);
                    });

                    $response['result']= 'ok';
                }else{
                    $response['msj']= 'Datos de Usuario Incorrectos. Vuelva a intentarlo';
                }

            } catch (\Exception $e) {
                $response['msj']= $e->getMessage();
            }


        }else{
            $response['msj']= 'No hay variable Email';
        }

        return $response;
    }


    /***************************/
    /*RegistroPage*/

    //cargamos los estados
    public function loadStates(){
        $response = [
            'result' => 'error',
            'msj'=>'',
            'states'=>[]
        ];

        $mdlStates = [];
        try {

            $states = State::orderBy('title', 'asc')->get();

            $mdlStates = [];

            foreach($states as $state){
                $mdlStates[]=[
                    'Id' => $state->id,
                    'Title'=>$state->title
                ];
            }


            $response['result'] = 'ok';
            $response['states'] = $mdlStates;

        } catch (\Exception $e) {
            $response['msj'] = $e;
        }


        return $mdlStates;

    }

    //cargamos los municipios
    public function loadLocations(Request $request, $Id){
        $response = [
            'result' => 'error',
            'msj'=>''
        ];

        $mdlLocations = [];
        try {

            $locations = Location::where('state_id',$Id)->orderBy('title', 'asc')->get();

            $mdlLocations = [];

            foreach($locations as $location){
                $mdlLocations[]=[
                    'Id' => $location->id,
                    'Title'=>$location->title
                ];
            }


            $response['result'] = 'ok';
            $response['states'] = $mdlLocations;

        } catch (\Exception $e) {
            $response['msj'] = $e;
        }


        return $mdlLocations;

    }

    //crear usuario
    public function createUser(Request $request){
        $response = [
            'result'=>'error',
            'msj'=>'',
            'userId'=> 0
        ];
        if($request->has('Nombre')){

            try {
                $userExist = User::getByEmail($request->get('Email'));
                if(is_null($userExist)){
                    $data_user = [
                        'name'      => $request->get('Nombre'),
                        'middle_name'      => $request->get('ApePat'),
                        'last_name'      => $request->get('ApeMat'),
                        'email'      => $request->get('Email'),
                        'password'  => \Hash::make($request->get('Password')),
                        'phone'      => $request->get('Cel'),
                        'birth_date'      => $request->get('FechaNac'),
                        'location_id'      => $request->get('IdLocation'),
                        'state_id'      => $request->get('IdEstado'),
                        'codigo_postal'      => $request->get('Cp'),
                        'genero'      => $request->get('Genero'),
                        'image'      => '',
                        'registration_mode'      => 'client',
                        'registration_status'      => 'Pendiente',
                        'terminos_condiciones'  => 0
                    ];

                    $newUser = User::create($data_user);
                    $userdata = array(
                        'email' => $request->get('Email'),
                        'password'=> $request->get('Password')
                    );
                    if(Auth::attempt($userdata))
                    {
                        $user = Auth::user();

                        $response['userId']= $user->id;
                        $response['result']= 'ok';
                    }

                }

            } catch (\Exception $e) {
                $response['msj']= $e->getMessage();
            }
        }else{
            $response['msj']= 'No Data Send';
        }

        return $response;
    }

    //subir imagen de usuario
    public function userUploadImage(Request $request)
    {
        $response = [
            'result' => 'error',
            'msj' => ''
        ];

        if ($request->hasFile('file') && $request->file('file')->isValid())
        {
            $ext = strtolower(pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_EXTENSION));
            $filename = $request->file('file')->getClientOriginalName();

            if (in_array($ext, ['jpg', 'jpeg', 'png']))
            {
                $newFile = Files::save($request->file('file')->getRealPath(), $ext, 'users', 'user_');

                //recuperamos el usuario
                $user = User::find($request->get('userId'));
                $user->image = $newFile;
                $user->save();

                $response['result'] = 'ok';
            }
            else
            {
                $response['msj'] = 'Only jpg and png images allowed. ';
            }
        }else{
            $response['msj'] = 'Not File Found';
        }
        return $response;
    }











    public function createUserCard(Request $request){

        $idUser = "";
        if($request->has('IdUser')){

            try {
                $newCard = UserCard();

                $newCard->user_id = $request->get('IdUser');
                $newCard->type = $request->get('Tipo');
                $newCard->owner = $request->get('Titular');
                $newCard->number = $request->get('Numero');
                $newCard->mm = $request->get('Mes');
                $newCard->aa = $request->get('Anho');
                $newCard->cvv = $request->get('Cvv');
                $newCard->prefer = '1';
                $newCard->save();

                $idUser = $request->get('IdUser');

            } catch (\Exception $e) {

            }
        }

        return $idUser;
    }


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

        $recoverUser = User::getByEmail($request->email);
        if(is_null($recoverUser))
        {
            // no existe. Nuevo Registro
            $data_user = [
                'name'      => $request->get('name'),
                'last_name'      => $request->get('last_name'),
                'email'      => $request->get('email'),
                'registration_mode'      => 'gym',
                'registration_status'      => 'Pendiente',
                'password'  => \Hash::make($request->get('password')),
                'terminos_condiciones'  => ($request->has('terminos_condiciones'))?1:0
            ];

            $newUser = User::create($data_user);

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
                $newGym->publish_date = Carbon::now();
                $newGym->save();

                //recuperamos el registro
                $gym = Gym::where('user_id', $user->id)->first();
                $categories = Category::orderBy('title', 'asc')->get();
                $imagesGym = GymImage::where('gym_id', $gym->id)->get();

                return view('registro', [
                    'user' => $user,
                    'gym' => $gym,
                    'categories' => $categories,
                    'imagesGym' => (is_null($imagesGym))? [] : $imagesGym
                ]);

            }else{
                return $this->dispatchError(404, 'No se pudo procesar tu registro, vuelve a intentarlo.');
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

                    //recuperamos el registro
                    $gym = Gym::where('user_id', $user->id)->first();
                    $categories = Category::orderBy('title', 'asc')->get();
                    $imagesGym = GymImage::where('gym_id', $gym->id)->get();

                    return view('registro', [
                        'user' => $user,
                        'gym' => $gym,
                        'categories' => $categories,
                        'imagesGym' => (is_null($imagesGym))? [] : $imagesGym
                    ]);

                }else{
                    return $this->dispatchError(404, 'No se pudo procesar tu registro, vuelve a intentarlo.');
                }

            }else{
                //registro completo
                return $this->dispatchError(404, 'Tu perfil ya se encuentra completo, usa el formuario de arriba para acceder a tu cuenta.');
            }
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

    public function DatosGralesRegister(Request $request){

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

            return view('datos_fiscales', [
                'user' => $user,
                'gym' => $gym
            ]);
        }else{
            return redirect('/');
        }

    }

    public function DatosFisRegister(Request $request){
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

            return view('datos_bancarios', [
                'user' => $user,
                'gym' => $gym
            ]);
        }else{
            return redirect('/');
        }
    }

    public function DatosBancariosRegister(Request $request){
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

            return view('registro_finalizacion', [
                'user' => $user,
                'gym' => $gym
            ]);
        }else{
            return redirect('/');
        }
    }







    public function loadQuotesAjax(Request $request)
    {

        if($request->type=='sector'){

            $integralservices = DB::table('integralservices_sectors')
            ->join('integralservice', 'integralservices_sectors.integralservice_id', '=', 'integralservice.id')
            ->where('integralservices_sectors.subcategoryservices_id', $request->id)
            ->get();

            $packages = DB::table('packages_sectors')
            ->join('package', 'packages_sectors.package_id', '=', 'package.id')
            ->where('packages_sectors.subcategoryservices_id', $request->id)
            ->get();

            $ciatejservices = Ciatejservice::where('subcategoryservices_id','=',$request->id)->orderBy('title', 'asc')->get();
        }else{

            $integralservices = DB::table('integralservices_laboratories')
            ->join('integralservice', 'integralservices_laboratories.integralservice_id', '=', 'integralservice.id')
            ->where('integralservices_laboratories.thirdcategoryservices_id', $request->id)
            ->get();

            $packages = DB::table('packages_laboratories')
            ->join('package', 'packages_laboratories.package_id', '=', 'package.id')
            ->where('packages_laboratories.thirdcategoryservices_id', $request->id)
            ->get();

            $ciatejservices = Ciatejservice::where('thirdcategoryservices_id','=',$request->id)->orderBy('title', 'asc')->get();
        }


        return view('front.servicios_industria.cotizador.services', [
            'integralservices' => $integralservices,
            'packages' => $packages,
            'ciatejservices'=>$ciatejservices
        ]);
    }

    public function cartOverview(Request $request)
    {
        $this->initOrder($request);

        if(!$this->order || $this->order->total == 0)
        {
            return redirect('/');
        }

        return view('pedidos.carrito.carrito', [
            'order' => $this->order
        ]);
    }

    public function updateOrder(Request $request)
    {

        $this->initOrder($request);
        if(!$this->order)
        {
            $this->order = new Quotation();
            $this->name = '';
            $this->phone = '';
            $this->company_name = '';
            $this->email = '';
            $this->message = '';
            $this->total = 0;
            $this->voucher = '';
            $this->authorization = '';
            $this->order->save();
            $request->session()->put('order_id', $this->order->id);
        }

        $this->order->items()->forceDelete();

        $totalOrden = 0;
        $this->order->updateTotal($totalOrden);

        foreach($request->items as $item)
        {

            $orderItem = new QuotationItems();
            $orderItem->quotation_id = $this->order->id;
            $orderItem->itemid = $item['product_id'];
            $orderItem->quantity = ($item['quantity'] > 0 ?  $item['quantity'] : 1);
            $orderItem->amount = $item['price']*($item['quantity'] > 0 ?  $item['quantity'] : 1);
            $orderItem->price = $item['price'];
            $orderItem->itemtype = $item['product_type'];
            $orderItem->save();

            $totalOrden+= ($item['price']*($item['quantity'] > 0 ?  $item['quantity'] : 1));
        }

        $this->order->updateTotal($totalOrden);

        foreach($this->order->items as $item)
        {
            $item->services;
        }

        return response()->json([
            'order' => $this->order
        ]);
    }

    public function finishOrder(Request $request)
    {
        /*para finalizar la orden primero registramos al usuario*/
        $response = [
            'result' => 'error',
            'logued' => 0,
            'user' => '',
            'errortype' => ''
        ];

        $folioOrder =0;

        if ($request->get('name') && $request->get('email'))
        {
            $data_user = [
                'name'      => $request->get('name'),
                'last_name' => $request->get('company'),
                'email'     => $request->get('email'),
                'password'  => bcrypt($request->get('passuser'))
            ];

            /*******************************************************/
            $newUser = new User;
            if ($newUser->isValid($data_user))
            {
                $newUser->fill($data_user);
                $newUser->save();

                $response['result'] = 'ok';
            }
            else
            {
                $userdata = array(
                    'email' => $request->get('email'),
                    'password'=> $request->get('passuser')
                );
                if(Auth::attempt($userdata))
                {
                    $response['result'] = 'ok';
                    $response['errortype'] = '';
                }else
                {
                    $response['result'] = 'error';
                    $response['errortype'] = 'Tu correo ya se encuentra registrado, por favor anota la contraseña correcta';
                }
            }
            /*******************************************************/

            if($response['result'] == 'ok'){
                /*actualizamos la orden con los datos de usuario*/
                $this->initOrder($request);

                if($this->order)
                {
                    $folioOrder =$this->order->getFolioAttribute();

                    $this->order->name = $request->name;
                    $this->order->phone = $request->phone;
                    $this->order->company_name = $request->company;
                    $this->order->email = $request->email;
                    $this->order->message = $request->message;
                    $this->order->folio = $folioOrder;
                    $this->order->save();

                    /*enviamos el correo*/
                    $orderFinish = $this->order;

                    $idEncode = base64_encode($this->order->id);

                    $dataMail = [
                        'order' => $orderFinish,
                        'idEncode'=>$idEncode,
                        'urlTicket'=>'',
                        'username'=>$request->email,
                        'userpass'=>$request->get('passuser')
                    ];

                    Mail::send('mail.deposit', $dataMail, function ($message) use ($request) {
                        $message->subject('Cotizacion Servicios');
                        //$message->from(config('mail.from.address'), config('mail.from.name'));
                        $message->from('cxc@ciatej.mx', config('SERVICIOS CIATEJ'));

                        $message->to($request->email, $request->name);
                    });

                    /*cerramos la session*/
                    $request->session()->forget('order_id');
                }

                $response['result'] = 'ok';

                return response()->json([
                    'folioOrder' => $folioOrder,
                    'result'=>$response['result'],
                    'errortype'=>''
                ]);
            }else{
                return response()->json([
                    'folioOrder' => $folioOrder,
                    'result'=>$response['result'],
                    'errortype'=>$response['errortype']
                ]);
            }




        }else{
            $response['result'] = 'error';
            return response()->json([
                'folioOrder' => $folioOrder,
                'result'=>$response['result'],
                'errortype'=>'no hay datos de usuario'
            ]);
        }




    }

    public function loginUserOrder(Request $request){
        $response = [
            'logued' => 0,
        ];
        $userdata = array(
            'email' => $request->get('txtUserName'),
            'password'=> $request->get('txtPassUser')
        );
        if(Auth::attempt($userdata))
        {
            $response['logued'] = 1;
        }
        return $response;
    }

    public function validTicketOrder(Request $request, $id)
    {
        $idDecode =base64_decode($id);

        $quotation = Quotation::where('status','=','Revisión')->where('id','=',$idDecode)->get()->first();
        if(is_null($quotation))
        {
            return redirect('/');
        }

        return view('front.receipt.ticket', [
            'quotation'=>$quotation
        ]);
    }

    public function upload(Request $request)
    {
        $response = [
            'result' => 'error',
            'quoatation' => ''
        ];

        if ($request->hasFile('file') && $request->file('file')->isValid())
        {
            $quotation = Quotation::find($request->get('quotation_id'));

            if (!is_null($quotation))
            {
                $ext = strtolower(pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_EXTENSION));
                $filename = $request->file('file')->getClientOriginalName();

                switch ($request->get('type'))
                {
                    case 'image':
                        if (in_array($ext, ['jpg', 'jpeg', 'png']))
                        {
                            $newFile = Files::save($request->file('file')->getRealPath(), $ext, 'quotation', 'quotation_');
                            $quotation->voucher = $newFile;
                            $quotation->save();
                            $response['result'] = 'ok';
                            $response['file'] = $quotation->voucher;
                        }
                        else
                        {
                            $response['result'] = 'error_type';
                            $response['message'] = 'Only jpg and png images allowed';
                        }
                        break;
                }
            }
            else
            {
                $response['result'] = 'error_article';
            }
        }
        return $response;
    }

    public function finishQuote(Request $request)
    {
        $response = [
            'result' => 'error',
            'folio' => ''
        ];
        $quotation = Quotation::find($request->get('quotation_id'));


        $folioOrder =$quotation->getFolioAttribute();

        $response['folio'] = $folioOrder;

        if (!is_null($quotation))
        {

            if($request->get('folio_ticket')==$folioOrder){
                $quotation->status = 'Pagado';
                $quotation->save();
                $response['result'] = 'ok';
            }else{
                $response['result'] = 'error_folio';

            }


        }
        else
        {
            $response['result'] = 'error_article';


        }

        return $response;
    }

}
