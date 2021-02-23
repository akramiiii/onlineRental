<?php
namespace App\Lib;

use App\Setting;

class ZarinPal
{
    protected $MerchantID;
    public function __construct()
    {
        $this->MerchantID=Setting::get_value('MerchantID');
    }
    public function pay($amount, $callbackURL=null)
    {
        $Description = 'توضیحات تراکنش تستی';
        $CallbackURL =$callbackURL ? $callbackURL : url('order/verify');
        $client = new \SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

        $result = $client->PaymentRequest(
            [
                'MerchantID' =>$this->MerchantID,
                'Amount' => $amount,
                'Description' => $Description,
                'CallbackURL' => $CallbackURL,
            ]
        );
        if ($result->Status == 100) {
            return $result->Authority;
        } else {
            return  false;
        }
    }
    public function verify($amount, $Authority)
    {
        $client = new \SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
        $result = $client->PaymentVerification(
            [
                'MerchantID' => $this->MerchantID,
                'Authority' => $Authority,
                'Amount' => $amount,
            ]
        );
        if ($result->Status == 100) {
            return $result->RefID;
        } else {
            return  false;
        }
    }
}
