<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Intagono\Openpay\Openpay;
class OpenPayController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * @var \Intagono\Openpay\Openpay
     */
    protected $openpay;

    /**
     * Constructor
     */
    public function __construct(Openpay $openpay)
    {
        $this->openpay = $openpay;
    }
    public function index(){
        $customer = array(
            'name' => "name",
            'last_name' => "last_name",
            'phone_number' => "phone_number",
            'email' => "email",);

        $chargeData = array(
            'method' => 'card',
            'amount' => 1200,
            'description' => 'Charge description',
            'customer' => $customer
        );
        print_r($this->openpay);
    }
}
