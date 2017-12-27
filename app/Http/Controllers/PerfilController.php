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

use App\Models\User;
use App\Models\Gyms\Gym;
use App\Models\Gyms\GymImage;
use App\Models\Gyms\GymSchedule;
use App\Models\Gyms\GymService;
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
        ];

        $userdata = array(
            'email' => $request->get('login_name'),
            'password'=> $request->get('login_pass'),
            'registration_mode'=> 'gym'
        );

        if(Auth::attempt($userdata))
        {
            $response['result'] ='ok';
            $response['message'] = 'Se inicio sesión correctamente.';

        }else{
            $response['message'] = 'Sus credenciales no son validas. Por favor verifíquelas.';
        }
        return $response;
    }

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

        return view('perfil_inicio', [
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

    /*perfil - usuarios*/
    public function perfilUsuarios(Request $request){
        $user = Auth::user();

        if(!is_null($user)){
            if(!$user->registration_mode=='gym'){
                return redirect('/logout');
            }else{
                $gym = Gym::where('user_id', $user->id)->first();

                //recuperamos la informacion del form y guardamos
                if($request->has('editInfo')){

                }
            }
        }else{
            return redirect('/');
        }

        return view('perfil_usuarios', [
            'user' => $user,
            'gym' => $gym
        ]);
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
