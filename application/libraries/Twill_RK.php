<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
*  ==============================================================================
 *  Author  : Fastnet | the internet lifestyle
 *  Email   : websupport@fastnet.net.sa
 *  For     : Twillio SMS Send for PHP
 *  License : MIT License
 *  ==============================================================================
 */

// Include the bundled autoload from the Twilio PHP Helper Library
require __DIR__ . '/Twilio/autoload.php';
use Twilio\Rest\Client;

class Twill_RK
{
    /*=-=-= Your Account Detail from twilio.com/console -=-=-*/

    /*=-=-= Test Account Credentials -=-=-*/
    private $account_sid_test   = 'ACd3f63fdc2c9a4ca81ae1c44f3fdb3faf';
    private $auth_token_test    = '5ec891cd14fc074220779183cf8e1339';

    /*=-=-= Live Account Credentials -=-=-*/
    private $account_sid_live   = 'AC8aa28cf11da6af828155fe1d0aa0e543';
    private $auth_token_live    = 'd28cf16b6d7de6d9d40ca224977bb01a';

    /*=-=-= A Twilio number you own with SMS capabilities -=-=-*/
    private $from_mobile        = '+12058801305';//'+19382226875';

    private $response           = array('success' => false, 'message' => 'Twillio Api Not Connected', 'data' => array());

    public $to_mobile;
    public $message;

    public function __construct()
    {

    }

    public function sendMsq( $mobile, $message, $API_live = true){
        //I sent this message from fsscverificationsoftware
        //debug('in message',1);
        $this->to_mobile    = $mobile;
        $this->message      = $message;

        if ($API_live){
            $this->callLive();
        }else{
            $this->callTest();
        }
        return $this->response;
    }

    private function callTest(){
        // Your Account SID and Auth Token from twilio.com/console
        $account_sid = $this->account_sid_test;
        $auth_token = $this->auth_token_test;
        // A Twilio number you own with SMS capabilities
        $twilio_number = $this->from_mobile;
        try{
            $client = new Client($account_sid, $auth_token);
            $result = $client->messages->create(
            // Where to send a text message (your cell phone?)
                $this->to_mobile,
                array(
                    'from' => $twilio_number,
                    'body' => $this->message
                )
            );

            $this->response['success']  = is_null($result->errorMessage) ? true:false;
            $this->response['message']  = $result->errorMessage;
            $this->response['data']     = $result;
        }catch (Exception $e){
            $this->response['success']  = false;
            $this->response['message']  = $e->getMessage();
            $this->response['data']     = $e;
        }
    }

    private function callLive(){
        // Your Account SID and Auth Token from twilio.com/console
        $account_sid = $this->account_sid_live;
        $auth_token = $this->auth_token_live;
        // A Twilio number you own with SMS capabilities
        $twilio_number = $this->from_mobile;
        try{
            $client = new Client($account_sid, $auth_token);
            $result = $client->messages->create(
            // Where to send a text message (your cell phone?)
                $this->to_mobile,
                array(
                    'from' => $twilio_number,
                    'body' => $this->message
                )
            );

            $this->response['success']  = is_null($result->errorMessage) ? true:false;
            $this->response['message']  = $result->errorMessage;
            $this->response['data']     = $result;
        }catch (Exception $e){
            $this->response['success']  = false;
            $this->response['message']  = $e->getMessage();
            $this->response['data']     = $e;
        }
    }
}