<?php

namespace Paytabscom\Laravel_paytabs\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Paytabscom\Laravel_paytabs\Services\IpnRequest;
use Paytabscom\Laravel_paytabs\Facades\paypage;

class PaytabsLaravelListenerApi extends BaseController
{

    /**
     * RESTful callable action able to receive: callback request\IPN Default Web request from the payment gateway after payment is processed
     */
    public function paymentIPN(Request $request){
 
        try{
            $ipnRequest= new IpnRequest($request);

            $callback = config('paytabs.callback');
            if(is_object($callback) && method_exists($callback, 'updateCartByIPN') ){
                $callback->updateCartByIPN($ipnRequest);
            }
            $response= 'valid IPN request. Cart updated';
            return response($response, 200)
                ->header('Content-Type', 'text/plain');
        }catch(\Exception $e){
            return response($e, 400)
                ->header('Content-Type', 'text/plain');        
        }
    }

    
    // public function index(){

    //     $pay= paypage::sendPaymentCode('all')
    //     ->sendTransaction('sale')
    //      ->sendCart(10,1000,'test')
    //     ->sendCustomerDetails('Walaa Elsaeed', 'w.elsaeed@paytabs.com', '0101111111', 'test', 'Nasr City', 'Cairo', 'EG', '1234','100.279.20.10')
    //     ->sendShippingDetails('Walaa Elsaeed', 'w.elsaeed@paytabs.com', '0101111111', 'test', 'Nasr City', 'Cairo', 'EG', '1234','100.279.20.10')
    //     ->sendURLs('return_url', 'callback_url')
    //     ->sendLanguage('en')
    //     ->sendShippingDetails('same as billing')
    //     ->sendHideShipping(true)
    //     ->sendFramed(true)
    //     ->create_pay_page();    
    //     return $pay;

    // }

}