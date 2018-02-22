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
use App\Models\Users\UserCategories;
use App\Models\Users\UserPreferences;

use App\Models\Gyms\Gym;
use App\Models\Gyms\GymImage;
use App\Models\Gyms\GymSchedule;
use App\Models\Gyms\GymService;
use App\Models\Locations\Location;
use App\Models\States\State;
use App\Models\Categories\Category;

use App\Models\Terminoscondiciones\Terminocondicion;


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
            'Nombre'=>'',
            'Apellido'=>'',
            'ImagenUrl'=>'',
            'UserType'=>''
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

                    if($user->registration_mode=='client'){
                        $response['Id']=$user->id;
                        $response['Nombre']=$user->name;
                        $response['Apellido']=$user->middle_name;
                        $response['ImagenUrl']=$user->image;
                        $response['result']= 'ok';
                        $response['UserType']=$user->registration_mode;
                    }else if($user->registration_mode=='gym'){
                        $gym = Gym::where('user_id', $user->id)->get()->first();
                        if(!is_null($gym)){
                            $response['Id']=$user->id;
                            $response['Nombre']=$gym->tradename;
                            $response['Apellido']=$user->middle_name;
                            $response['ImagenUrl']=$user->image;
                            $response['result']= 'ok';
                            $response['UserType']=$user->registration_mode;
                        }else{
                            $response['msj']= 'Datos de Usuario Incorrectos. Vuelva a intentarlo';
                        }
                    }else{
                        $response['msj']= 'No tiene permiso para acceder a la app.';
                    }
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
            'Id'=> 0
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
                        'codigo_postal'      => $request->get('CP'),
                        'genero'      => $request->get('Genero'),
                        'image'      => $request->get('ImageName'),
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

                        $response['Id']= $user->id;
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
    public function userUploadImage(Request $request){

        $response = [
            'result' => 'error',
            'Nombre' => '',
            'msj' => ''
        ];

        if ($request->hasFile('file') && $request->file('file')->isValid())
        {
            $ext = strtolower(pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_EXTENSION));
            $filename = $request->file('file')->getClientOriginalName();

            if (in_array($ext, ['jpg', 'jpeg', 'png']))
            {
                $newFile = Files::save($request->file('file')->getRealPath(), $ext, 'users', 'user_');
                $response['result'] = 'ok';
                $response['Nombre'] = $newFile;
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

    //crear tarjeta de usuario
    public function createUserCard(Request $request){
        $response = [
            'result'=>'error',
            'msj'=>''
        ];
        if($request->has('IdUser')){

            try {
                $newCard = new UserCard();

                $newCard->user_id = $request->get('IdUser');
                $newCard->type = $request->get('Tipo');
                $newCard->owner = $request->get('Titular');
                $newCard->number = $request->get('Numero');
                $newCard->mm = $request->get('Mes');
                $newCard->aa = $request->get('Anho');
                $newCard->cvv = $request->get('Cvv');
                $newCard->prefer = '1';
                $newCard->save();

                $response['result']= 'ok';

            } catch (\Exception $e) {
                $response['msj']= $e->getMessage();
            }
        }

        return $response;
    }

    /***************************/
    /*DatosPersonalesPage*/

    //recuperamos los datos de usuario
    public function getUser(Request $request){
        $response = [
            'result'=>'error',
            'msj'=>'',
            'user'=> ''
        ];


        if($request->has('userId')){

            try {
                $userExist = User::where('id', $request->get('userId'))->get()->first();

                if(!is_null($userExist)){
                    $response['user'] = [
                        'Nombre' => $userExist->name,
                        'ApePat' => $userExist->middle_name,
                        'ApeMat' => $userExist->last_name,
                        'Email' => $userExist->email,
                        'Cel' => $userExist->phone,
                        'FechaNac' => $userExist->birth_date,
                        'IdLocation' => $userExist->location_id,
                        'IdEstado' => $userExist->state_id,
                        'CP' => $userExist->codigo_postal,
                        'Genero' => $userExist->genero,
                        'ImageName' => $userExist->image
                    ];
                    $response['result']= 'ok';
                }
            } catch (\Exception $e) {
                $response['msj']= $e->getMessage();
            }
        }else{
            $response['msj']= 'No Data Send';
        }
        return $response;
    }

    //actualizadmos los datos del usuario
    public function updateUser(Request $request){
        $response = [
            'result'=>'error',
            'msj'=>''
        ];
        if($request->has('IdUser')){

            try {
                $userExist = User::where('id', $request->get('IdUser'))->get()->first();
                if(!is_null($userExist)){
                    $userExist->name = $request->get('Nombre');
                    $userExist->middle_name = $request->get('ApePat');
                    $userExist->last_name = $request->get('ApeMat');
                    $userExist->phone = $request->get('Cel');
                    $userExist->birth_date = $request->get('FechaNac');
                    $userExist->location_id = $request->get('IdLocation');
                    $userExist->state_id = $request->get('IdEstado');
                    $userExist->codigo_postal = $request->get('CP');
                    $userExist->genero = $request->get('Genero');
                    if($request->get('ImageName')!=''){
                        $userExist->image = $request->get('ImageName');
                    }
                    $userExist->save();

                    $response['result']= 'ok';

                }else{
                    $response['msj']= 'No se pudo guardar la información, vuelva a intentarlo.';
                }

            } catch (\Exception $e) {
                $response['msj']= $e->getMessage();
            }
        }else{
            $response['msj']= 'No Data Send';
        }

        return $response;
    }

    /***************************/
    /*DatosTarjeetaPage*/

    //crear tarjeta de usuario registrado
    public function updateUserAddCard(Request $request){
        $response = [
            'result'=>'error',
            'msj'=>''
        ];
        if($request->has('IdUser')){

            try {
                $newCard = new UserCard();

                $newCard->user_id = $request->get('IdUser');
                $newCard->type = $request->get('Tipo');
                $newCard->owner = $request->get('Titular');
                $newCard->number = $request->get('Numero');
                $newCard->mm = $request->get('Mes');
                $newCard->aa = $request->get('Anho');
                $newCard->cvv = $request->get('Cvv');
                $newCard->prefer = '0';
                $newCard->save();

                $response['result']= 'ok';

            } catch (\Exception $e) {
                $response['msj']= $e->getMessage();
            }
        }

        return $response;
    }


    /***************************/
    /*AyudaTerminosCondicionesPage*/

    //recuperamos los terminos y las condiciones
    public function getTerminosCondiciones(Request $request){

        $response = [
            'Result'=>'error',
            'Msj'=>'',
            'Contenido'=>''
        ];
        if($request->has('Id')){

            try {
                $terminos = Terminocondicion::find($request->get('Id'));

                $response['Result']= 'ok';
                $response['Contenido']= $terminos->contenido;

            } catch (\Exception $e) {
                $response['Msj']= $e->getMessage();
            }
        }

        return $response;
    }

    /***************************/
    /*PreferenciasPage*/

    //recuperamos las preferencias del usuario
    public function getPreferencias(Request $request){

        $response = [
            'Result'=>'error',
            'Msj'=>'',
            'IdUser'=>'',
            'Categorias'=>[],
            'CategoriasUser'=>[],
            'PreferenciasUser'=>[]
        ];
        if($request->has('IdUser')){

            try {

                $Categorias = Category::orderBy('title','asc')->get();
                foreach ($Categorias as $category) {
                    $response['Categorias'][]=[
                        'Id'=>$category->id,
                        'Title'=>$category->title,
                        'IsToggled'=>true
                        ] ;
                }

                $CategoriasUser = UserCategories::where('user_id',$request->get('IdUser'))->get();

                if(!is_null($CategoriasUser)){
                    foreach ($CategoriasUser as $categoryUser) {
                        $response['CategoriasUser'][]=[
                            'Id'=>$categoryUser->category_id
                            ] ;
                    }
                }


                $PreferenciasUser = UserPreferences::where('user_id',$request->get('IdUser'))->get()->first();

                if(!is_null($PreferenciasUser)){
                    $response['PreferenciasUser']=[
                        'Id'=>$PreferenciasUser->id,
                        'Distance'=>$PreferenciasUser->distance,
                        'Price'=>$PreferenciasUser->price
                        ] ;
                }

                $response['Result']= 'ok';
                $response['IdUser']= $request->get('IdUser');

            } catch (\Exception $e) {
                $response['Msj']= $e->getMessage();
            }
        }

        return $response;
    }

    //actualizamos las preferencias
    public function updateUserPreferencias(Request $request){

        $response = [
            'Result'=>'error',
            'Msj'=>''
        ];
        if($request->has('IdUser')){

            try {

                //eliminamos las categorias registradas
                $CategoriasUser = UserCategories::where('user_id',$request->get('IdUser'))->get();
                $CategoriasUser->forceDelete();

                //registramos las nuevas categorias
                foreach ($request->get('Categoria') as $category) {
                    $newCategoriasUser = new UserCategories();
                    //$newCategoriasUser->;

                    //user_idint(10) unsigned NOT NULL
                    //    category_id
                }

                //actualizamos los datos de distancia y precio


                $Categorias = Category::orderBy('title','asc')->get();
                foreach ($Categorias as $category) {
                    $response['Categorias'][]=[
                        'Id'=>$category->id,
                        'Title'=>$category->title,
                        'IsToggled'=>true
                        ] ;
                }

                $CategoriasUser = UserCategories::where('user_id',$request->get('IdUser'))->get();

                if(!is_null($CategoriasUser)){
                    foreach ($CategoriasUser as $categoryUser) {
                        $response['CategoriasUser'][]=[
                            'Id'=>$categoryUser->category_id
                            ] ;
                    }
                }

                $response['CategoriasUser'][]=[
                    'Id'=>2
                    ] ;


                $PreferenciasUser = UserPreferences::where('user_id',$request->get('IdUser'))->get()->first();

                if(!is_null($PreferenciasUser)){
                    $response['PreferenciasUser']=[
                        'Id'=>$PreferenciasUser->id,
                        'Distance'=>$PreferenciasUser->distance,
                        'Price'=>$PreferenciasUser->price
                        ] ;
                }

                $response['PreferenciasUser']=[
                    'Id'=>1,
                    'Distance'=>2,
                    'Price'=>70
                    ] ;



                $response['Result']= 'ok';
                $response['IdUser']= $request->get('IdUser');

            } catch (\Exception $e) {
                $response['Msj']= $e->getMessage();
            }
        }

        return $response;
    }

    /***************************/
    /*MapaPage*/

    //recuperamos la ubicación de los Gym
    public function getLocationGyms(Request $request){
        //recuperamos las configuraciones de preferencias del usuario
        //filtramos los gymnasios que coincidan con las preferencias del usuario
        $response = [
            'Result'=>'error',
            'Msj'=>'',
            'Gyms'=>[]
        ];

        if($request->has('IdUser')){

            try {
                $userCategoriesArr = [];
                $userDistance = 2;
                $userPrice = 500;
                $CategoriasUser = UserCategories::where('user_id',$request->get('IdUser'))->get();

                if(!is_null($CategoriasUser)){
                    foreach ($CategoriasUser as $categoryUser) {
                        $userCategoriesArr[]=$categoryUser->category_id;
                    }
                }

                $PreferenciasUser = UserPreferences::where('user_id',$request->get('IdUser'))->get()->first();

                if(!is_null($PreferenciasUser)){
                    $userDistance = $PreferenciasUser->distance;
                    $userPrice = $PreferenciasUser->price;
                }

                //realizamos la busqueda de los gyms por distancia
                $categories = implode(",", $userCategoriesArr);
                $joinStr = "";
                if(count($userCategoriesArr)>0){
                    $joinStr = "INNER JOIN gym_service as gs ON g.id=gs.gym_id AND gs.category_id IN(".$categories.")";
                }

                $box = $this->getBoundaries($request->get('Lat'), $request->get('Lng'), $userDistance);

                $gyms = DB::select("SELECT DISTINCT
                                    g.id as IdGym, (
                                      6371 * acos (
                                      cos ( radians(".$request->get('Lat').") )
                                      * cos( radians( g.lat ) )
                                      * cos( radians( g.lng ) - radians(".$request->get('Lng').") )
                                      + sin ( radians(".$request->get('Lat').") )
                                      * sin( radians( g.lat ) )
                                    )
                                ) AS Distance, g.lat as Lat, g.lng as Lgn, g.tradename as Tradename,
                                IFNULL((SELECT 'Abierto Ahora'
                                FROM gym_schedule as gh
                                WHERE gh.day=(WEEKDAY(NOW())+1) AND NOW() BETWEEN start_time AND end_time AND gh.gym_id=g.id),'Cerrado') AS EstatusService
                                FROM gym as g
                                ".$joinStr."
                                WHERE (g.lat BETWEEN ".$box['min_lat']." AND ".$box['max_lat'].")
                                AND (g.lng BETWEEN ".$box['min_lng']." AND ". $box['max_lng'].")
                                HAVING Distance < ".$userDistance."
                                ORDER BY Distance",
                                []);

                //return $gyms;

                if(count($gyms)==0){
                    $response['Result']= 'error';
                    $response['Msj']= 'No se encontraron gimnasios cerca de tu ubicación';
                    $response['Gyms']= $gyms;
                }else{
                    $response['Result']= 'ok';
                    $response['Gyms']= $gyms;
                }


            } catch (\Exception $e) {
                $response['Msj']= $e->getMessage();
            }
        }

        return $response;

    }

    public function getBoundaries($lat, $lng, $distance = 2, $earthRadius = 6371)
    {
        $return = array();

        // Los angulos para cada dirección
        $cardinalCoords = array('north' => '0',
                                'south' => '180',
                                'east' => '90',
                                'west' => '270');
        $rLat = deg2rad($lat);
        $rLng = deg2rad($lng);
        $rAngDist = $distance/$earthRadius;
        foreach ($cardinalCoords as $name => $angle)
        {
            $rAngle = deg2rad($angle);
            $rLatB = asin(sin($rLat) * cos($rAngDist) + cos($rLat) * sin($rAngDist) * cos($rAngle));
            $rLonB = $rLng + atan2(sin($rAngle) * sin($rAngDist) * cos($rLat), cos($rAngDist) - sin($rLat) * sin($rLatB));
             $return[$name] = array('lat' => (float) rad2deg($rLatB),
                                    'lng' => (float) rad2deg($rLonB));
        }
        return array('min_lat'  => $return['south']['lat'],
                     'max_lat' => $return['north']['lat'],
                     'min_lng' => $return['west']['lng'],
                     'max_lng' => $return['east']['lng']);
    }

    /***************************/
    /*AyudaPage*/

    //recuperamos el tipo de reporte de ayuda
    public function  ayudaApp(Request $request){
        $response = [
            'Result'=>'error',
            'Msj'=>''
        ];
        if($request->has('IdUser')){
            try {
                $user  = User::where('id',$request->get('IdUser'))->get()->first();
                if(!is_null($user))
                {
                    $dataMail = [
                        'nombre' => $user->name." ".$user->middle_name." ".$user->last_name,
                        'phone' => $user->phone,
                        'idUser'=>$request->get('IdUser'),
                        'email'=>$user->email,
                        'type'=>$request->get('type'),
                        'informacion'=>$request->get('informacion'),
                        'fechaEnvio'=>date("d/m/Y")
                    ];

                    Mail::send('emails.ayuda', $dataMail, function ($message) use ($dataMail) {
                        $message->subject('Solicitud de Ayuda desde App');
                        $message->from($dataMail['email'], $dataMail['nombre']);
                        //$message->to(config('mail.from.address'), config('mail.from.name'));
                        $message->to("taquion3x109@gmail.com", config('mail.from.name'));

                    });

                    $response['Result']= 'ok';
                    $response['Msj']= 'Tu solicitud fue enviada correctamente. Pronto un miembro del equipo de LIBERI dará atención a tu reporte.';
                }else{
                    $response['Msj']= 'Datos de Usuario Incorrectos. Vuelva a intentarlo';
                }

            } catch (\Exception $e) {
                $response['Msj']= $e->getMessage();
            }


        }else{
            $response['Msj']= 'No hay variable Usuario';
        }

        return $response;
    }

    /***************************/
    /*NegocioDetallePage*/

    //recuperamos las imagenes del gym
    public function getGymGallery(Request $request){

        $response = [
            'Result'=>'error',
            'Msj'=>'',
            'Gallery'=>[]
        ];

        if($request->has('IdGym')){

            try {

                $imagesGym = GymImage::where('gym_id',  $request->get('IdGym'))->select('image')->get();

                if(!is_null($imagesGym)){
                    $response['Result']= 'ok';
                    if(count($imagesGym)>0){
                        $response['Gallery']= $imagesGym;
                    }else{
                        $response['Gallery'][]= ['image'=>'default.png'];
                    }

                }else{
                    $response['Msj']= "No hay imagenes del gym";
                }

            } catch (\Exception $e) {
                $response['Msj']= $e->getMessage();
            }
        }

        return $response;

    }

    //recuperamos el video del gym
    public function getGymVideo(Request $request){

        $response = [
            'Result'=>'error',
            'Msj'=>'',
            'UrlVideo'=>''
        ];

        if($request->has('IdGym')){

            try {

                $gym = Gym::find($request->get('IdGym'));

                if(!is_null($gym)){
                    if($gym->gym_url_video==""){
                        $response['Result']= 'error';
                        $response['UrlVideo']= '';
                    }else{
                        $urlVideoParams = explode('?v=',$gym->gym_url_video);
                        $urlVideoClean = explode('&',$urlVideoParams[1]);

                        $response['Result']= 'ok';
                        $response['UrlVideo']= "https://www.youtube.com/embed/".$urlVideoClean[0];
                    }


                }else{
                    $response['Msj']= "No hay video del gym";
                }

            } catch (\Exception $e) {
                $response['Msj']= $e->getMessage();
            }
        }

        return $response;

    }



}
