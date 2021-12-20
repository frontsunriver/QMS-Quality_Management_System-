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
require __DIR__ . '/GeoLocate.php';
use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberParseException;

// Include the bundled autoload from the Twilio PHP Helper Library
//require __DIR__ . '/Twilio/autoload.php';

class Phone_RK
{
    private $response           = array('success' => false, 'message' => 'Not a Valid Phone Number', 'data' => array());
    public function __construct()
    {
    }

    public function checkPhoneNumber($phoneNumber, $restrictOnlyMobile = false){
        if (empty($phoneNumber)){
            $this->response['message'] = 'Please Enter A Valid Number';
            return $this->response;
        }
        $phoneNumber = formatMobileNumber($phoneNumber,true);
        $geo            = new GeoLocate();
        $geo->locate();
        $region_code    = !empty($geo->regionCode) ? $geo->regionCode:'US';
        try {
            $number = PhoneNumber::parse($phoneNumber,$region_code);
            if (!$number->isValidNumber()) {
                return $this->response;
            }
            if ($restrictOnlyMobile){
                if ($number->getNumberType() != \libphonenumber\PhoneNumberType::MOBILE) {
                    $this->response['message'] = 'Only Mobile Number Accepted';
                    return $this->response;
                }
            }
            $this->response['success'] = true;
            $this->response['message'] = 'Valid Number';
            return $this->response;
        }
        catch (PhoneNumberParseException $e) {
            // 'The string supplied is too short to be a phone number.'
            $this->response['message'] = $e->getMessage();
            return $this->response;
        }
    }
}