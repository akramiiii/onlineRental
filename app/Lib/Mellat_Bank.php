<?php

namespace App\Lib;

use App\Search;
use App\Setting;
use DB;

/**
 * This is just an example.
 */
class Mellat_Bank
{
    public $TerminalId;
    public $UserName;
    public $Password;
    public function __construct()
    {
        $this->TerminalId=Setting::get_value('TerminalId');
        $this->UserName=Setting::get_value('Username');
        $this->Password=Setting::get_value('Password');
    }
    public function pay($amount, $order_id, $callBackUrl)
    {
        $client = new \nusoap_client('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
        $namespace='http://interfaces.core.sw.bps.com/';
        $error = $client->getError();
        if ($error) {
            return false;
        }
        $parameters = array(
            'terminalId' =>$this->TerminalId,
            'userName' =>$this->UserName,
            'userPassword' =>$this->Password,
            'orderId' =>time().$order_id,
            'amount' => $amount,
            'localDate' =>date("Ymd"),
            'localTime' =>date("His"),
            'additionalData' =>'خرید',
            'callBackUrl' =>$callBackUrl ? $callBackUrl :url('order/verify'),
            'payerId' =>0
        );
        $result = $client->call('bpPayRequest', $parameters, $namespace);
        $res=@explode(',', $result);
        if (is_array($res) && sizeof($res)==2) {
            if ($res[0]==0) {
                return $res[1];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function Verify($SaleOrderId, $SaleReferenceId)
    {
        $client =new \nusoap_client('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
        $namespace='http://interfaces.core.sw.bps.com/';
        $error = $client->getError();
        if ($error) {
            return false;
        }
        $parameters = array(
            'terminalId' =>$this->TerminalId,
            'userName' =>$this->UserName,
            'userPassword' =>$this->Password,
            'orderId' => $SaleOrderId,
            'saleOrderId' => $SaleOrderId,
            'saleReferenceId' => $SaleReferenceId
        );
        $VerifyAnswer = $client->call('bpVerifyRequest', $parameters, $namespace);
        if ($VerifyAnswer==0) {
            $client->call('bpSettleRequest', $parameters, $namespace);
            return true;
        } else {
            $this->Inquiry($SaleOrderId, $SaleReferenceId);
        }
    }
    public function Inquiry($SaleOrderId, $SaleReferenceId)
    {
        $client =new \nusoap_client('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
        $namespace='http://interfaces.core.sw.bps.com/';
        $error = $client->getError();
        if ($error) {
            return false;
        }
        $parameters = array(
            'terminalId' =>$this->TerminalId,
            'userName' =>$this->UserName,
            'userPassword' =>$this->Password,
            'orderId' => $SaleOrderId,
            'saleOrderId' => $SaleOrderId,
            'saleReferenceId' => $SaleReferenceId
        );
        $Inquiry = $client->call('bpInquiryRequest', $parameters, $namespace);
        if ($Inquiry==0 || $Inquiry==43) {
            $result=$client->call('bpSettleRequest', $parameters, $namespace);
            return true;
        } else {
            $result=$client->call('bpReversalRequest', $parameters, $namespace);
            return false;
        }
    }
}
