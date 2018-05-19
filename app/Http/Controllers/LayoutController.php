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

class LayoutController extends Controller
{

    public function __construct()
    {

    }

    //FORMULARIO CONTACTO
    public function sendContacto(Request $request)
    {
        $response = [
            'result' => 'error',
            'message' => 'ha ocurrido un error',
        ];

        if($request->has('contact_name') && $request->has('contact_email')){

            $parms = [
                'contact_name' => $request->get('contact_name'),
                'contact_phone' => $request->get('contact_phone'),
                'contact_email' => $request->get('contact_email'),
                'contact_message' => $request->get('contact_message'),
            ];

            // Send email
            Mail::send('emails.contacto', $parms, function($message)use($request){
                $message->subject('Contacto desde sitio web de Liberi.com.mx');
                $message->from(config('mail.from.address'), config('mail.from.name'));

                /*foreach(config('mail.to.addresses') as $email)
                {*/
                $message->to('eduardoibarra904@gmail.com', 'LIBERI WEB');
                    //$message->to($email, config('mail.to.name'));
                //}
            });

            $response['result'] ='ok';
            $response['message'] = 'Se ha enviado el formulario';
        }
        return $response;
    }


}
