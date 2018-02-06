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
                    $newCategoriasUser->;

                    user_idint(10) unsigned NOT NULL
category_id
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
}
