<?php
namespace App\Http\Controllers;
require(dirname(__FILE__) . '/Openpay/Openpay.php');
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
//use Intagono\Openpay\Openpay;
class OpenPayController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function index(){
        $openpay = \Openpay::getInstance('mmgdkgnzoy3qpcxf925c', 'sk_f7d7e49cdfa7462cb3ca8af2106481fb');
        $customerData = array(
            'name' => 'Liberi',
            'last_name' => 'Ejemplo 3',
            'email' => 'ejemplo3@liberi.com',
            'phone_number' => '4421112233',
            'address' => array(
                'line1' => 'Privada Rio No. 12',
                'line2' => 'Co. El Tintero',
                'line3' => '',
                'postal_code' => '66058',
                'state' => 'Nuevo León',
                'city' => 'Monterrey',
                'country_code' => 'MX'));
        $customer = $openpay->customers->add($customerData);
        print_r($customer);
        $cardData = array(
            'holder_name' => 'Liberi Ejemplo',
            'card_number' => '4111111111111111',
            'cvv2' => '123',
            'expiration_month' => '12',
            'expiration_year' => '20',
            'address' => array(
                'line1' => 'Privada Rio No. 12',
                'line2' => 'Co. El Tintero',
                'line3' => '',
                'postal_code' => '66058',
                'state' => 'Nuevo León',
                'city' => 'Monterrey',
                'country_code' => 'MX'));

        $customer = $openpay->customers->get('amvybavjqpt9cgtqjrpc');
        $card = $customer->cards->add($cardData);

        print_r($card);
    }
    public function processCharge(Request $request) {
        $openpay = \Openpay::getInstance('mmgdkgnzoy3qpcxf925c', 'sk_f7d7e49cdfa7462cb3ca8af2106481fb');
        $response = [];
        $customerData = array(
            'name' => $request->input("name"),
            'last_name' => $request->input("last_name"),
            'phone_number' => $request->input("phone_number"),
            'email' => $request->input("email"),);
        $customer = $openpay->customers->add($customerData);
        $response['customer_id'] = $customer->id;
        $cardData = array(
            'token_id' => $request->input("token_id"),
            'device_session_id' => $request->input("deviceIdHiddenFieldName")
        );
        $chargeData = array(
            'method' => 'card',
            'source_id' => $request->input("token_id"),
            'amount' => (float)$request->input("amount"),
            'description' => $request->input("description"),
            'use_card_points' => $request->input("use_card_points"), // Optional, only used for reward points
            'device_session_id' => $request->input("deviceIdHiddenFieldName"),
            'customer' => $customerData
        );
        $card = $customer->cards->add($cardData);
        $response['card'] = $card;

        $charge = $openpay->charges->create($chargeData);
        $response['charge'] = $charge;
        echo json_encode($response);
    }
}
