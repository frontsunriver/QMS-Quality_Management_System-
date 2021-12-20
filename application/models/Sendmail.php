<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sendmail extends CI_Model {

    public function emails($email,$message)
    {

        $secretkey= MAILGUN_SECRET_KEY;
        $domain = MAILGUN_DOMAIN;
        $Option['FROM_MAIL']=MAILGUN_FROM_MAIL;
        $Option['FROM_NAME']=MAILGUN_FROM_NAME;
        $Option['TO_MAIL']=$email;
        $Option['TO_NAME']= "EMS";
        $Option['SUBJECT']="Notification";
        $Option['BODY_TEXT']=$message;
        $Option['BODY_HTML']="<b style='color:red'>".$message."</b>";
        require 'vendor/autoload.php';
        $client = new \GuzzleHttp\Client([
            'verify' => false,
        ]);
        $adapter = new \Http\Adapter\Guzzle6\Client($client);
        $mailgun = new \Mailgun\Mailgun($secretkey, $adapter);
        $result = $mailgun->sendMessage($domain, array(
            'from'    => $Option['FROM_MAIL'],
            'to'      => $Option['TO_MAIL'],
            'subject' => $Option['SUBJECT'],
            'text'    => $Option['BODY_TEXT'],
            'html'    => $Option['BODY_HTML'],
        ));

    }

    public function emails_custom_content($email,$message)
    {

        $secretkey= MAILGUN_SECRET_KEY;
        $domain = MAILGUN_DOMAIN;
        $Option['FROM_MAIL']=MAILGUN_FROM_MAIL;
        $Option['FROM_NAME']=MAILGUN_FROM_NAME;

        require 'vendor/autoload.php';
        $client = new \GuzzleHttp\Client([
            'verify' => false,
        ]);
        $adapter = new \Http\Adapter\Guzzle6\Client($client);
        $mailgun = new \Mailgun\Mailgun($secretkey, $adapter);

        foreach($email as $item){
            if($item != null && $item != "") {
                $Option['TO_MAIL'] = $item;
                $Option['TO_NAME'] = "EMS";
                $Option['SUBJECT'] = "Notification";
                //$Option['BODY_TEXT']=$message;
                $Option['BODY_HTML'] = $message;

                $result = $mailgun->sendMessage($domain, array(
                    'from' => $Option['FROM_MAIL'],
                    'to' => $Option['TO_MAIL'],
                    'subject' => $Option['SUBJECT'],
                    /*'text'    => $Option['BODY_TEXT'],*/
                    'text' => 'Your mail do not support HTML',
                    'html' => $Option['BODY_HTML'],
                ));
            }
        }


    }
}
