<?php

namespace App\Http\Controllers;

require_once (__DIR__.'/../../../rmccue/requests/Requests.php');

use Illuminate\Http\Request;
use Requests;

class CredimaxController extends Controller
{
    public function index()
    {
//        echo "Hello";
        Requests::register_autoloader();
        $PWD = "470b61dc064faa3ed24fb188c46b1a35";
        $order_id = substr(md5(mt_rand()), 0, 7);

        $headers = array();
        $data = array(
            'apiOperation' => "CREATE_CHECKOUT_SESSION",
            'apiPassword' => "470b61dc064faa3ed24fb188c46b1a35",
            'apiUsername' => "merchant.E16175950",
            'merchant' => "E16175950",
            'interaction.operation' => "AUTHORIZE",
            'order.id' => "$order_id",
            'order.amount' => '100.00',
            'order.currency' => 'BHD'
        );
        $response = Requests::post('https://credimax.gateway.mastercard.com/api/nvp/version/57', $headers, $data);
        $data = $response->body;
        $final_arr = array();
//        $data = json_encode(json_decode($response->body));
        $data = explode("&", $data);

        foreach ($data as $datam) {
            $_arr = explode('=', $datam);
            $final_arr[$_arr[0]] = $_arr[1];
            /*echo "<pre>";
            print_r($final_arr);
            echo "</pre>";*/
        }


//        echo "<pre>";
//        print_r($final_arr);

        return view('credimax', compact('final_arr'));
    }

    public function hosted_session()
    {
        return view('hosted_session');
    }
}
