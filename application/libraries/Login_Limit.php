<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
*  ==============================================================================
 *  Author  : Fastnet | the internet lifestyle
 *  Email   : websupport@fastnet.net.sa
 *  For     : Login Throttle CodeIgniter
 *  License : MIT License
 *  ==============================================================================
 */

class Login_Limit
{
    private $CI;
    private $penalty_time   = 600;
    private $redirectTo;

    public function __construct($config = array())
    {
        $this->CI           =& get_instance();
        $this->redirectTo   = isset($config['redirectTo']) ? $config['redirectTo']:'auth/login';
    }

    public function check_user_valid(){
        if($this->CI->session->tempdata('penalty')){
            //Shows code that user is on a penalty
            $this->CI->session->set_flashdata('flash', array(
                'msg' => 'You have reached your login attempt limit, please try to reset your password'
            ));
            redirect($this->redirectTo);
            return;
        }
    }

    public function draw_timer(){
        if ($this->CI->session->tempdata('penalty_time')){
            //debug($this->CI->session->tempdata('penalty_time'),1);
            $template   = "<script language=\"JavaScript\">
                            TargetDate = \"{$this->CI->session->tempdata('penalty_time')}\";//12/31/2020 5:00 AM
                            BackColor = \"white\";
                            ForeColor = \"red\";
                            CountActive = true;
                            CountStepper = -1;
                            LeadingZero = true;
                            DisplayFormat = \"Due To Wrong Attempts Access Blocked For <br/> %%M%% Minutes, %%S%% Seconds.\";//%%D%% Days, %%H%% Hours, %%M%% Minutes, %%S%% Seconds.
                            FinishMessage = \"\";
                        </script>
                        <script language=\"JavaScript\" src=\"https://rhashemian.github.io/js/countdown.js\"></script>";
            echo $template;
        }
    }

    public function add_attempt(){
        $attempt = $this->CI->session->userdata('attempt');
        $attempt++;
        $this->CI->session->set_userdata('attempt', $attempt);

        // if ($attempt >= 3) {
        //     $this->CI->session->set_flashdata('flash', array(
        //         'msg' => "Your account is locked, you have reached your login attempt limit!"
        //     ));

        //     //code for setting tempdata when reached maximun tries
        //     date_default_timezone_set ( get_tz($this->CI->input->ip_address()) );
        //     $this->CI->session->set_tempdata('penalty', true, $this->penalty_time); //set the name of the sess var to 'penalty, the value will be true and will expire within 5 minutes (expressed in sec.)
        //     $this->CI->session->set_tempdata('penalty_time', date('m/d/Y h:i:s A',strtotime("now {$this->penalty_time} seconds")), $this->penalty_time);

        //     redirect($this->redirectTo);
        //     return;

        // }
    }

    public function refresh_attempts(){
        $this->CI->session->set_userdata('attempt', 0);
    }

    public function remove_penalty(){
        $this->CI->session->set_tempdata('penalty', false, 10);
        $this->CI->session->set_tempdata('penalty_time', false, 10);
    }

}