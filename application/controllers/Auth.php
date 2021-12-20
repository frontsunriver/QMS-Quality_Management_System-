<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller
{
	public function login() {
		$this->mHeader['title']         = 'Login';
		$this->mHeader['menu_title']    = 'login';
        $this->mHeader['otp_status']    = $this->settings->otp_verification ? true:false;
		$param = $this->input->post('login');

        $this->login_limit->remove_penalty();
		if ($param) {
            
            /*=-=-= limit login attempt start -=-=-*/
            
            // $this->login_limit->check_user_valid();
            /*=-=-= limit login attempt end -=-=-*/

            /*=-=-= verification on/off start -=-=-*/
            
		    if ($this->settings->otp_verification){

                $user_OTP       = $this->input->post('code');
                $user_OTP       = is_array($user_OTP) ? $user_OTP:array();
                $_POST['code']  = $user_OTP = implode('',$user_OTP);

                $validation = array(
                    array(
                        'field' => 'login[u]',
                        'label' => 'Username',
                        'rules' => 'required'
                    ), array(
                        'field' => 'login[p]',
                        'label' => 'Password',
                        'rules' => 'required'
                    ), array(
                        'field' => 'u_t',
                        'label' => 'User Type',
                        'rules' => 'required',
                        'errors' => array('required' => 'Please Select %s.'),
                    ), array(
                        'field' => 'code',
                        'label' => 'OTP',
                        'rules' => 'required|exact_length[4]',
                        'errors' => array('required' => 'Invalid %s.'),
                    )
                );

                $this->form_validation->set_rules($validation);

                if (!$this->form_validation->run()){
                    $this->render('login');
                }else{
                    try{
                        $type               = _decode($this->input->post('u_t'));
                        $username           = _decode($param['u']);
                        $password           = _decode($param['p']);
                    }catch (Exception $e){
                        $this->session->set_flashdata('flash', array(
                            'msg' => 'Na Kakka Halii Na'
                        ));
                        $this->redirect('auth/verification');
                        return;
                    }
                    $param['username']  = $username;
                    unset($param['p'],$param['u']);

                    if($type == "admin"){
                        $user = $this->Auth_model->login($param, $type);
                        if($user && verifyHashedPassword( $password, $user->password )){
                            /*=-=-=- check is OTP Valid Start =-=-=-*/
                            $verified = $this->OTPVerification->get_auth_OTP(array(
                                'model_name'    => 'admin',
                                'model_id'      => $user->id,
                                'otp'           => $user_OTP,
                            ));
                            if (!$verified){
                                $this->session->set_flashdata('flash', array(
                                    'msg' => 'Invalid OTP'
                                ));
                                $this->redirect('auth/verification');
                            }
                            /*=-=-=- check is OTP Valid end =-=-=-*/
                            $user->type = $type;
                            $this->session->set_userdata('user', $user);
                            $this->session->set_userdata(array(
                                'admin_id' => $user->id,
                                'username' => $user->username,
                                'is_password_updated' => $user->isPasswordUptd,
                                'user_type' => $type
                            ));
                            /*=-=- refresh attempts =-=-*/
                            $this->login_limit->refresh_attempts();
                        }else{
                            $user = false;
                        }
                    }
                    else if($type == 'consultant' || $type == "executive"){
                        $user = $this->Auth_model->login($param, $type);
                        if($user && verifyHashedPassword( $password, $user->password )){
                            /*=-=-=- check is OTP Valid Start =-=-=-*/
                            if ($type == "executive"){
                                $model_id   = 'employee_id';
                            }else{
                                $model_id   = 'consultant_id';
                            }
                            $verified = $this->OTPVerification->get_auth_OTP(array(
                                'model_name'    => $type,
                                'model_id'      => $user->$model_id,
                                'otp'           => $user_OTP,
                            ));
                            if (!$verified){
                                $this->session->set_flashdata('flash', array(
                                    'msg' => 'Invalid OTP'
                                ));
                                $this->redirect('auth/verification');
                            }
                            /*=-=-=- check is OTP Valid end =-=-=-*/
                            if($user->is2FAEnabled == 1) {
                                $user->type = $type;
                                $this->session->set_userdata('temp_user', $user);
                                redirect('auth/securityAuth');
                            }
                            $user->type = $type;
                            $this->session->set_userdata('user', $user);
                            $this->session->set_userdata(array(
                                'consultant_id' => $user->consultant_id,
                                'username' => $user->username,
                                'user_type' => $user->type,
                                'com_status' => $user->status,
                                'is_password_updated' => $user->isPasswordUptd
                            ));
                            /*=-=- refresh attempts =-=-*/
                            $this->login_limit->refresh_attempts();
                        }else{
                            $user = false;
                        }
                    } else{
                        $user = $this->Auth_model->employee_login($username, $type);
                        if($user && verifyHashedPassword( $password, $user->password )){
                            /*=-=-=- check is OTP Valid Start =-=-=-*/
                            $verified = $this->OTPVerification->get_auth_OTP(array(
                                'model_name'    => $type,
                                'model_id'      => $user->employee_id,
                                'otp'           => $user_OTP,
                            ));
                            if (!$verified){
                                $this->session->set_flashdata('flash', array(
                                    'msg' => 'Invalid OTP'
                                ));
                                $this->redirect('auth/verification');
                            }
                            /*=-=-=- check is OTP Valid end =-=-=-*/
                            $user->type = $type;
                            $this->session->set_userdata('user', $user);
                            $this->session->set_userdata(array(
                                'employee_id' => $user->employee_id,
                                'username' => $user->username,
                                'consultant_id' => $user->consultant_id,
                                'user_type' => $user->type,
                                'com_status' => $user->status,
                                'is_password_updated' => $user->isPasswordUptd
                            ));
                            /*=-=- refresh attempts =-=-*/
                            $this->login_limit->refresh_attempts();
                        }else{
                            $user = false;
                        }
                    }
                    if($user){
                        $this->redirect('welcome/dashboard');
                    }
                    else {
                        /*=-=-= limit login attempt start -=-=-*/
                        $this->login_limit->add_attempt();
                        /*=-=-= limit login attempt end -=-=-*/
                        $this->session->set_flashdata('flash', array(
                            'msg' => 'Invalid credentials'
                        ));
                        $this->render('login');
                    }
                }
            }else{
                
                $validation = array(
                    array(
                        'field' => 'login[username]',
                        'label' => 'Username',
                        'rules' => 'required'
                    ), array(
                        'field' => 'login[password]',
                        'label' => 'Password',
                        'rules' => 'required'
                    )
                );
                $this->form_validation->set_rules($validation);

                if (!$this->form_validation->run()){
                    $this->render('login');
                }else {
                    
                    $type = $this->input->post('usertype');
                    $username = $param['username'];
                    $password = $param['password'];
                    $attempt  = 0;
                    
                    /*=-=-= After password hashed start -=-=-*/
                    unset($param['password']);
                    /*=-=-= After password hashed end -=-=-*/
                    if($type == "admin"){
                        $user = $this->Auth_model->login($param, $type);
                        
                        if($user && verifyHashedPassword( $password, $user->password )){
                            $user->type = $type;
                            $this->session->set_userdata('user', $user);
                            $this->session->set_userdata(array(
                                'admin_id' => $user->id,
                                'username' => $user->username,
                                'is_password_updated' => $user->isPasswordUptd,
                                'user_type' => $type
                            ));
                            /*=-=- refresh attempts =-=-*/
                            $this->login_limit->refresh_attempts();
                        }else{
                            $user = false;
                        }

                    }
                    else if($type == 'consultant' || $type == "executive"){
                        
                        $user = $this->Auth_model->login($param, $type);
                        if($user && verifyHashedPassword( $password, $user->password )){
                            if($user->is_active == 0) {
                                $this->session->set_flashdata('flash', array(
                                    'msg' => 'Please verifiy your email to access the system'
                                ));
                                redirect('auth/login');
                                exit;
                            }
                            if($user->is2FAEnabled == 1) {
                                $user->type = $type;
                                $this->session->set_userdata('temp_user', $user);
                                redirect('auth/securityAuth');
                            }
                            $user->type = $type;
                            $this->session->set_userdata('user', $user);
                            $this->session->set_userdata(array(
                                'consultant_id' => $user->consultant_id,
                                'username' => $user->username,
                                'user_type' => $user->type,
                                'com_status' => $user->status,
                                'is_password_updated' => $user->isPasswordUptd
                            ));
                            /*=-=- refresh attempts =-=-*/
                            // $this->login_limit->refresh_attempts();
                        }else{
                            $user = false;
                        }
                    } else{
                        $user = $this->Auth_model->employee_login($username, $type);
                        if($user && verifyHashedPassword( $password, $user->password )){
                            $user->type = $type;
                            $this->session->set_userdata('user', $user);
                            $this->session->set_userdata(array(
                                'employee_id' => $user->employee_id,
                                'username' => $user->username,
                                'consultant_id' => $user->consultant_id,
                                'user_type' => $user->type,
                                'com_status' => $user->status,
                                'is_password_updated' => $user->isPasswordUptd
                            ));
                            /*=-=- refresh attempts =-=-*/
                            $this->login_limit->refresh_attempts();
                        }else{
                            $user = false;
                        }
                    }
                    if($user){
                        $this->redirect('welcome/dashboard');
                    }
                    else {
                        /*=-=-= limit login attempt start -=-=-*/
                        $this->login_limit->add_attempt();
                        /*=-=-= limit login attempt end -=-=-*/
                        $this->session->set_flashdata('flash', array(
                            'msg' => 'Invalid Credentials'
                        ));
                        $this->render('login');
                    }
                }
            }
		} else{
            $this->render('login');
        }
	}

    public function verification(){
        if (!$this->settings->otp_verification){
            redirect('Auth/login');
        }
        $this->load->model('OTPVerification');
        $this->load->library('form_validation');
        $this->load->library('phone_RK');


        $this->mHeader['title']         = 'Login';
        $this->mHeader['menu_title']    = 'login';
        $this->mHeader['otp_status']    = $this->settings->otp_verification ? true:false;
        $param                          = $this->input->post('login');
        if ($param){
            /*=-=-= limit login attempt start -=-=-*/
            $this->login_limit->check_user_valid();
            /*=-=-= limit login attempt end -=-=-*/

            $validation = array(
                array(
                    'field' => 'login[username]',
                    'label' => 'Username',
                    'rules' => 'required'
                ), array(
                    'field' => 'login[password]',
                    'label' => 'Password',
                    'rules' => 'required'
                ), array(
                    'field' => 'verification_method',
                    'label' => 'Verification Method',
                    'rules' => array('required','in_list[email,phone]')
                )
            );
            $this->form_validation->set_rules($validation);
            if (!$this->form_validation->run()){
                $this->render('login');
            }else{
                try{
                    $type               = _decode($this->input->post('usertype'));
                    $username           = _decode($param['username']);
                    $password           = _decode($param['password']);
                    $param['username']  = $username;
                }catch (Exception $e){
                    $this->session->set_flashdata('message', 'Na Kakka Halii Na');
                    redirect('Auth/verification');
                    return;
                }
                $via_method         = $this->input->post('verification_method');
                $random_otp         = rand(1000,9999);
                $method_value       = '';
                /*=-=-= After password hashed start -=-=-*/
                unset($param['password']);
                /*=-=-= After password hashed end -=-=-*/

                $this->mHeader['title']      = 'Verification';
                $this->mHeader['username']   = _encode($username);
                $this->mHeader['user_type']  = _encode($type);
                $this->mHeader['password']   = _encode($password);
                $this->mHeader['via_method'] = $via_method;

                if (isset($type)){
                    if($type == "admin"){
                        $user = $this->Auth_model->login($param, $type);
                        if($user && verifyHashedPassword( $password, $user->password )){
                            $data1 = array(
                                'model_name'    => 'admin',
                                'model_id'      => $user->id,
                                'method_value'  => $user->$via_method,
                                'otp'           => $random_otp,
                                'is_verified'   => 0
                            );
                            $method_value   = $user->$via_method;
                            if (!empty($method_value)){
                                $result = $this->OTPVerification->set_auth_OTP($data1);
                            }

                        }else{
                            /*=-=-= limit login attempt start -=-=-*/
                            $this->login_limit->add_attempt();
                            /*=-=-= limit login attempt end -=-=-*/
                            $this->session->set_flashdata('flash', array(
                                'msg' => 'Invalid credentials'
                            ));
                            $this->redirect('auth/login');
                        }
                    }
                    else if($type == 'consultant' || $type == "executive"){
                        $user = $this->Auth_model->login($param, $type);
                        if($user && verifyHashedPassword( $password, $user->password )){
                            if($user->is_active == 0) {
                                $this->session->set_flashdata('flash', array(
                                    'msg' => 'Please verifiy your email to access the system'
                                ));
                                redirect('auth/login');
                                exit;
                            }
                            if ($type == "executive"){
                                $field_name = 'employee_'.$via_method;
                                $model_id   = 'employee_id';
                            }else{
                                $model_id   = 'consultant_id';
                                $field_name = $via_method;

                                /*if (!$user->otp_status){
                                    $user->type = $type;
                                    $this->session->set_userdata('user', $user);
                                    $this->session->set_userdata(array(
                                        'consultant_id' => $user->consultant_id,
                                        'username' => $user->username,
                                        'user_type' => $user->type,
                                        'com_status' => $user->status,
                                        'is_password_updated' => $user->isPasswordUptd
                                    ));
                                    $this->redirect('welcome/dashboard');
                                }*/
                            }
                            $data1 = array(
                                'model_name'    => $type,
                                'model_id'      => $user->$model_id,
                                'method_value'  => $user->$field_name,
                                'otp'           => $random_otp,
                                'is_verified'   => 0
                            );
                            $method_value   = $user->$field_name;
                            if (!empty($user->$field_name)){
                                $result = $this->OTPVerification->set_auth_OTP($data1);
                            }

                        }else{
                            /*=-=-= limit login attempt start -=-=-*/
                            $this->login_limit->add_attempt();
                            /*=-=-= limit login attempt end -=-=-*/
                            $this->session->set_flashdata('flash', array(
                                'msg' => 'Invalid credentials'
                            ));
                            $this->redirect('auth/login');
                        }
                    } else{
                        $user = $this->Auth_model->employee_login($username, $type);
                        if($user && verifyHashedPassword( $password, $user->password )){
                            $user->type = $type;
                            $field_name = 'employee_'.$via_method;
                            $data1      = array(
                                'model_name'    => $type,
                                'model_id'      => $user->employee_id,
                                'method_value'  => $user->$field_name,
                                'otp'           => $random_otp,
                                'is_verified'   => 0
                            );
                            $method_value   = $user->$field_name;
                            $method_value   = $user->$field_name;
                            if (!empty($user->$field_name)){
                                $result = $this->OTPVerification->set_auth_OTP($data1);
                            }
                        }else{
                            /*=-=-= limit login attempt start -=-=-*/
                            $this->login_limit->add_attempt();
                            /*=-=-= limit login attempt end -=-=-*/
                            $this->session->set_flashdata('flash', array(
                                'msg' => 'Invalid credentials'
                            ));
                            $this->redirect('auth/login');
                        }
                    }
                }else{
                    $this->session->set_flashdata('flash', array(
                        'msg' => 'Invalid Type'
                    ));
                    $this->redirect('auth/login');
                }
                /*=-=- check if method value is empty start =-=-*/
                $method_value = trim($method_value);
                if (empty($method_value)){
                    $this->session->set_flashdata('flash', array(
                        'msg' => 'Please try the other Verification Method'
                    ));
                    $this->redirect('auth/login');
                }
                /*=-=- check if method value is empty end =-=-*/
                if ($via_method == 'phone'){
                    $method_value = formatMobileNumber($method_value, true);
                    /*=-=- check user mobile number valid start =-=-*/
                    $phone_response = $this->phone_rk->checkPhoneNumber($method_value);
                    if (!$phone_response['success']){
                        $this->session->set_flashdata('flash', array(
                            'msg' => 'Your Mobile Number Is Not Valid Please Contact Admin'
                        ));
                        $this->redirect('auth/login');
                    }
                    /*=-=- send msg to user start =-=-*/
                    $response = $this->twill_rk->sendMsq($method_value, "Your ".APP_NAME." Login OTP is $random_otp");
                    if (!$response['success']){
                        $this->session->set_flashdata('flash', array(
                            'msg' => $response['message']
                        ));
                        $this->redirect('auth/login');
                    }
                    $this->render('OTP_verification');
                }elseif ($via_method == 'email'){

                    //-------------------send email----------------------
                    $email_temp = $this->getEmailTemp('OTP-Verification-Email');
                    $email_temp['message'] = str_replace("{OTP}", $random_otp, $email_temp['message']);
                    $email_temp['message'] = str_replace("{APP_NAME}", APP_NAME, $email_temp['message']);
                    $this->sendemail($method_value, 'OTP Verification Email', $email_temp['message'], $email_temp['subject']);

                    $this->render('OTP_verification');
                }else{
                    $this->session->set_flashdata('flash', array(
                        'msg' => 'We Dont Have Your Email or mobile Please Contact Admin'
                    ));
                    redirect('Welcome/login');
                }
            }
        }else{
            $this->render('login');
        }
    }

    public function verifyMethod(){
        if (!$this->settings->otp_verification && empty($this->input->post('v'))){
            redirect('Auth/login');
        }

        $this->load->library('form_validation');
        $this->load->library('phone_RK');

        $this->mHeader['title']         = 'Verify Method';
        $this->mHeader['menu_title']    = 'verifymethod';
        $this->mHeader['otp_status']    = $this->settings->otp_verification ? true:false;

        $param                          = $this->input->post('login');
        if ($param){
            /*=-=-= limit login attempt start -=-=-*/
            $this->login_limit->check_user_valid();
            /*=-=-= limit login attempt end -=-=-*/
            $validation = array(
                array(
                    'field' => 'login[username]',
                    'label' => 'Username',
                    'rules' => 'required'
                ), array(
                    'field' => 'login[password]',
                    'label' => 'Password',
                    'rules' => 'required'
                )
            );
            $this->form_validation->set_rules($validation);
            if (!$this->form_validation->run()){
                $this->render('login');
            }else{
                $type               = $this->input->post('usertype');
                $username           = $param['username'];
                $password           = $param['password'];
                /*=-=-= After password hashed start -=-=-*/
                unset($param['password']);
                /*=-=-= After password hashed end -=-=-*/
                $this->mContent['username']     = _encode($username);
                $this->mContent['password']     = _encode($password);
                $this->mContent['user_type']    = _encode($type);
                $this->mContent['otp_status']   = array('email' => true, 'phone' => true);
                if (isset($type)){
                    if($type == "admin"){
                        $user = $this->Auth_model->login($param, $type);
                        if($user && verifyHashedPassword( $password, $user->password )){
                            $this->render('verification_method');
                        }else{
                            /*=-=-= limit login attempt start -=-=-*/
                            $this->login_limit->add_attempt();
                            /*=-=-= limit login attempt end -=-=-*/
                            $this->session->set_flashdata('flash', array(
                                'msg' => 'Invalid credentials'
                            ));
                            $this->redirect('auth/login');
                        }
                    }else if($type == 'consultant' || $type == "executive"){
                        $user = $this->Auth_model->login($param, $type);
                        if($user && verifyHashedPassword( $password, $user->password )){
                            if (!$user->otp_status){
                                $this->mContent['otp_status']['phone'] = false;
                            }
                            $this->render('verification_method');
                            return true;
                        }else{
                            /*=-=-= limit login attempt start -=-=-*/
                            $this->login_limit->add_attempt();
                            /*=-=-= limit login attempt end -=-=-*/
                            $this->session->set_flashdata('flash', array(
                                'msg' => 'Invalid credentials'
                            ));
                            $this->redirect('auth/login');
                        }
                    }else{
                        $user = $this->Auth_model->employee_login($username, $type);
                        if($user && verifyHashedPassword( $password, $user->password )){
                            $this->render('verification_method');
                        }else{
                            /*=-=-= limit login attempt start -=-=-*/
                            $this->login_limit->add_attempt();
                            /*=-=-= limit login attempt end -=-=-*/
                            $this->session->set_flashdata('flash', array(
                                'msg' => 'Invalid credentials'
                            ));
                            $this->redirect('auth/login');
                        }
                    }
                }else{
                    $this->session->set_flashdata('flash', array(
                        'msg' => 'Invalid Type'
                    ));
                    $this->redirect('auth/login');
                }
            }
        }else{
            $this->redirect('auth/login');
        }
    }
	/*public function password_check($str)
	{
	   if (preg_match('#[0-9]#', $str) && preg_match('#[a-z]#', $str) && preg_match('#[A-Z]#', $str)) {
	     return TRUE;
	   }
	   	 $this->form_validation->set_message('password_check', 'Password must contain number, length limit(8),letter(small & uppercase)');
	   
	   return FALSE;
	}*/

    /**
     * Validate the password
     *
     * @param string $password
     *
     * @return bool
     */
    public function password_check($password = '')
    {
        $password = trim($password);
        $regex_lowercase = '/[a-z]/';
        $regex_uppercase = '/[A-Z]/';
        $regex_number = '/[0-9]/';
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';
        if (empty($password))
        {
            $this->form_validation->set_message('password_check', 'The {field} field is required.');
            return FALSE;
        }
        if (preg_match_all($regex_lowercase, $password) < 1)
        {
            $this->form_validation->set_message('password_check', 'The {field} field must be at least one lowercase letter.');
            return FALSE;
        }
        if (preg_match_all($regex_uppercase, $password) < 1)
        {
            $this->form_validation->set_message('password_check', 'The {field} field must be at least one uppercase letter.');
            return FALSE;
        }
        if (preg_match_all($regex_number, $password) < 1)
        {
            $this->form_validation->set_message('password_check', 'The {field} field must have at least one number.');
            return FALSE;
        }
        if (preg_match_all($regex_special, $password) < 1)
        {
            $this->form_validation->set_message('password_check', 'The {field} field must have at least one special character.' . ' ' . htmlentities('!@#$%^&*()\-_=+{};:,<.>§~'));
            return FALSE;
        }
        if (strlen($password) < 8)
        {
            $this->form_validation->set_message('password_check', 'The {field} field must be at least 8 characters in length.');
            return FALSE;
        }
        if (strlen($password) > 32)
        {
            $this->form_validation->set_message('password_check', 'The {field} field cannot exceed 32 characters in length.');
            return FALSE;
        }
        return TRUE;
    }



	public function register() {


		// $this->sendemail('team.asl398@yopmail.com', 'User sign up for subscription', 'Demo Mail', 'Demo Subject');

		// exit;



		$this->mHeader['title'] = 'Register';
		$this->mHeader['menu_title'] = 'register';

		$param = $this->input->post('register');
		$email = $param['email'];
		$username = $param['username'];

		if ($param) {
			$validation = [
				[
					'field' => 'register[consultant_name]',
					'label' => 'Company Name',
					'rules' => 'required'
				], [
					'field' => 'register[username]',
					'label' => 'Username',
					'rules' => 'required|is_unique[consultant.username]'
				], [
                    'field' => 'register[email]',
                    'label' => 'Email',
                    'rules' => 'required|valid_email|is_unique[consultant.email]'
                ], [
                    'field' => 'register[phone]',
                    'label' => 'Mobile',
                    'rules' => 'required|is_unique[consultant.phone]'
                ], [
					'field' => 'register[password]',
					'label' => 'Password',
					'rules' => 'required|min_length[8]|callback_password_check'
				], [
					'field' => 'register[repassword]',
					'label' => 'Password',
					'rules' => 'required|min_length[8]|callback_password_check'
				], [
					'field' => 'register[repassword]',
					'label' => 'Password Confirmation',
					'rules' => 'required|matches[register[password]]'
				]
			];
			$this->form_validation->set_rules($validation);
            /*=-=- check user mobile number valid start =-=-*/
            $phone          = $this->input->post('register[phone]');
            $phone_response = $this->phone_rk->checkPhoneNumber($phone);
            /*=-=- check user mobile number valid end =-=-*/
			if (!$this->form_validation->run() || stristr($email, "<script>") != FALSE || stristr($username, "<script>") != FALSE || !$phone_response['success']) {
                if (!$phone_response['success']){
                    $this->session->set_flashdata('message', $phone_response['message']);
                }
                $this->render('Register/register');
            }else {
				// $param['password'] = md5($param['password']);
				$activation_code    = $this->serialkey();
				$param['created_at']= date('Y-m-d');
				$param['user_type'] = 'consultant';
				$param['logo']      = 1;
				unset($param['repassword']);

				$param['is_active'] = 0;
				$param['activation_code'] = $activation_code;

				$param['password'] = getHashedPassword($param['password']);

				$param['isPasswordUptd'] = 1;


				$consultant_id = $this->Auth_model->consultant_register($param);


				if ($consultant_id > 0) {
					//----------------------------------------------send email----------------------------------------------
					$email_temp = $this->getEmailTemp('User sign up for subscription');
					$email_temp['message'] = str_replace("{USERNAME}", $username, $email_temp['message']);
					$email_temp['message'] = str_replace("{COURSE_NAME}", 'isoimplementationsoftware.com', $email_temp['message']);
					$email_temp['message'] = str_replace("{LOGO}", "<img src='cid:logo'>", $email_temp['message']);
					$this->sendemail($email, 'User sign up for subscription', $email_temp['message'], $email_temp['subject']);
					//---------------------------------------------------------------------------------------------------------

				//-------------------Send email to registered user for Email verificaiton  ----------------------

				$verificaiton_link = base_url().'index.php/Auth/verifyEmail/'.$activation_code;
				$email_tempU = $this->getEmailTemp('email verification authentication');

				$email_tempU['message'] = str_replace("{username}", $username, $email_tempU['message']);
				$email_tempU['message'] = str_replace("{verification_link}", $verificaiton_link, $email_tempU['message']);
				// $this->sendemail($email, 'Email Verification', $email_tempU['message'], $email_tempU['subject']);
				$this->send_mail($email, 'Email Verification', $email_tempU['message'], $email_tempU['subject']);
				//-------------------------------------------------------

                    //---------------------------------------------- send sms ----------------------------------------------
                    if (!empty($phone) && $this->settings->otp_verification){
                        $phone = formatMobileNumber($phone, true);
                        /*=-=- check user mobile number valid start =-=-*/
                        $phone_response = $this->phone_rk->checkPhoneNumber($phone);
                        if ($phone_response['success']){
                            $message = "Hi {$username}".PHP_EOL;
                            $message.= "Congratulations you have signed up to Quality Circle’s Process Risk(Strategic and Operational) Based Implementation Software. The software is the first of its kind globally. It is a cloud based automated tool which enables users to monitor established controls so data can be harvested for useful analytics and evaluation by top management to drive continual improvement.";
                            $this->twill_rk->sendMsq($phone,$message);
                        }
                    }

					$this->session->set_userdata([
						'username' => $param['username'],
						'consultant_id' => $consultant_id
					]);
					$this->redirect('auth/reg_pay_plans');
				}
			}
		} else
			$this->render('Register/register');
	}

	public function reg_pay_plans() {
		$this->mHeader['title'] = 'Register Pay Plans';
		$this->mHeader['menu_title'] = 'register_pay_plans';

		$this->mContent['plans'] = $this->Plan_model->find([
			'is_trial' => 0
		], ['no_of_user' => 'asc']);
		$this->mContent['trial_plan'] = $this->Plan_model->one([
			'is_trial' => 1
		]);

		$this->render('Register/register_payment_plans');
	}

	public function add_purchase() {
		$plan_id = $this->input->post('plan_id');
		$consultant_id = $this->session->userdata('consultant_id');

		if ($plan_id == '0')
			$this->redirect('auth/reg_pay_plans');

		else {

		    $admin_name         = $this->session->userdata('username');
			$plan_name          = $this->db->where('plan_id', $plan_id)->get('plan')->row()->plan_name;
            $admin_info         = $this->db->get('admin')->row();
			$email              = $admin_info->email;
			$consultant_name    = $this->db->where('consultant_id', $consultant_id)->get('consultant')->row()->consultant_name;

			//-------------------- send email-------------------------
			$email_temp = $this->getEmailTemp('User Sign up to Super Admin');
			$email_temp['message'] = str_replace("{Admin Name}", $admin_name." from ".$consultant_name, $email_temp['message']);
			$email_temp['message'] = str_replace("{COURSE NAME}", 'isoimplementationsoftware.com', $email_temp['message']);
			$email_temp['message'] = str_replace("{Plan}", $plan_name, $email_temp['message']);
			$this->sendemail($email, 'User sign up for subscription', $email_temp['message'], $email_temp['subject'], 2);
            //---------------------------------------------- send sms ----------------------------------------------
            if (!empty($admin_info->phone) && $this->settings->otp_verification){
                $phone = formatMobileNumber($admin_info->phone, true);
                /*=-=- check user mobile number valid start =-=-*/
                $phone_response = $this->phone_rk->checkPhoneNumber($phone);
                if ($phone_response['success']){
                    $message = "Hello Super Admin".PHP_EOL;
                    $message.= "{$admin_name} from {$consultant_name} has signed up for {$plan_name} of ".APP_NAME.".";
                    $this->twill_rk->sendMsq($phone,$message);
                }
            }
			//--------------------------------------------------------

			if ($plan_id == '1')
				$this->trial();
			else {
				$result = $this->Consultant_model->update(['consultant_id' => $consultant_id], ['plan_id' => $plan_id]);

				if ($result)
					$this->redirect('auth/reg_pay_plans');
				else
					$this->redirect('auth/term_condition');
			}
		}
	}

	public function trial() {
		$consultant_id = $this->session->userdata('consultant_id');
		if (!$consultant_id)
			$this->redirect('auth/reg_pay_plans');
		else {
			$param = [
				'plan_type' => 'trial',
				'plan_id' => 1,
				'expired' => date('Y-m-d', strtotime(date('Y-m-d') . ' + 14 days')),
				'status' => 1
			];

			$this->Consultant_model->update(['consultant_id' => $consultant_id], $param);

			$this->session->set_userdata(['com_status' => 1]);


			// Check Email Verified OR Not

			$chkVerification  = $this->db->select('is_active')->get_where('consultant', array('consultant_id'=> $consultant_id ))->row();

			if($chkVerification->is_active == 0) {
				$this->session->unset_userdata(array('consultant_id', 'com_status', 'plan_type', 'plan_id', 'username'));
				$data1 = array();
				$this->session->set_userdata($data1);
				$this->session->set_flashdata('flash', [
						'msg' => 'Please verifiy your email to access the system'
				]);
				//$this->render('login');
				redirect('auth/login');
				exit;
			} else {
				redirect('Welcome/dashboard');
			}



			$this->redirect('welcome/dashboard');
		}
	}

	public function term_condition() {
		$this->mHeader['title'] = 'Term Condition';
		$this->mHeader['menu_title'] = 'term_condition';

		$this->render('Register/term_condition');
	}

	public function next_process_done() {
		$checked = $this->input->post('checkeds');
		if ($checked == 'on')
			$this->redirect('auth/payment');
		else
			$this->redirect('auth/reg_pay_plans');
	}

	public function payment() {
		$consultant_id = $this->session->userdata('consultant_id');
		if (isset($consultant_id)) {
			$this->mHeader['title'] = 'Payment';
			$this->mHeader['menu_title'] = 'payment';

			$this->mContent['company'] = $this->Consultant_model->one(['consultant_id' => $consultant_id]);
			$this->mContent['plan'] = $this->Plan_model->one(['plan_id' => $this->mContent['company']->plan_id]);

			$this->render('Register/reg_payment');
		} else
			$this->redirect('auth/reg_pay_plans');
	}

	public function logout() {
		$this->session->sess_destroy();
		$this->redirect('welcome');
	}

	public function next_process2() {
		$data['title'] = 'Next';
		$query         = $this->db->get('plan');
		$data['plan']  = $query->result();
		$this->load->view('process_two', $data);
	}

	public function payment_option() {

		$date             = date('Y-m-d');
		$total_amount     = $this->input->post('total_amount');
		$company_id       = $this->input->post('consultant_id');
		$plan_id          = $this->input->post('plan_id');

		require_once('./config.php');
		$token = $_POST['stripeToken'];
		$email = $_POST['stripeEmail'];

		$customer = \Stripe\Customer::create(array(
			'email' => $email,
			'source' => $token
		));

		$charge = \Stripe\Charge::create(array(
			'customer' => $customer->id,
			'amount' => $total_amount * 100,
			'currency' => 'usd'
		));

		$data = array(
			'total_amount' => $total_amount,
			'consultant_id' => $company_id,
			'payment_status' => 'paid',
			'token' => $customer->created,
			'transaction_id' => $customer->id,
			'updated_at' => date('Y-m-d', strtotime($date)),
			'purchase_plan_id' => $plan_id
		);

		$paid = $this->db->insert('payment', $data);
		if ($paid) {

			$expired = date('Y-m-d', strtotime($date . ' + 365 days'));

			$data2 = array(
				'status' => 1,
				'plan_type' => 'real',
				'expired' => $expired,
				'plan_id' => $plan_id
			);
			$this->db->where('consultant_id', $company_id);
			$paid1 = $this->db->update('consultant', $data2);

			$datan = array(
				'com_status' => 1,
				'user_type' => 'consultant',
			);
			$this->session->set_userdata($datan);

			// Check Email Verified OR Not

			$chkVerification  = $this->db->select('is_active')->get_where('consultant', array('consultant_id'=> $company_id ))->row();

			if($chkVerification->is_active == 0) {
				$this->session->unset_userdata(array('consultant_id', 'com_status', 'plan_type', 'plan_id', 'username'));
				$data1 = array();
				$this->session->set_userdata($data1);
				$this->session->set_flashdata('flash', [
						'msg' => 'Please verifiy your email to access the system'
				]);
				//$this->render('login');
				redirect('auth/login');
				exit;
			} else {
				redirect('Welcome/consultantdashboard');
			}

			redirect('Welcome/consultantdashboard');

		} else {
			redirect('Auth/reg_pay_plans');
		}
	}


	public function get_purchase($ppi = NULL) {
		$this->db->where('purchase_plan_id', $ppi);
		$query = $this->db->get('purchase_plan');
		return $query->row();
	}


	public function update_process() {
		$this->mHeader['title'] = 'Upgrade';
		$this->mHeader['menu_title'] = $this->mHeader['title'];

		$consultant_id = $this->session->userdata('consultant_id');
		$consultant = $this->Consultant_model->one(['consultant_id' => $consultant_id]);
		$chk = $this->Plan_model->one(['plan_id' => $consultant->plan_id]);

		$where = ['is_trial' => 0];
		if ($consultant->plan_id != '1')
			array_merge($where, ['no_of_user > ' => $chk->no_of_user]);

		$this->mContent['plans'] = $this->Plan_model->find($where, ['no_of_user' => 'asc']);
		$this->mContent['upgrade'] = 0;

		$this->render('consultant/update_process');
	}

	public function check_update_process($consultant_id)
	{

		$data = $this->db->query("select * from `consultant` where `consultant_id`='$consultant_id' ")->row()->plan_id;

		if ($data) {
			$data1 = $this->db->query("select * from `plan` where `plan_id`='$data'")->row();
			return $data1;
		}
	}


	public function forgot_pass()
	{

		$this->load->model('Authmodel');
		$this->load->library('form_validation');

		$data['title'] = 'Next';
		$this->load->view('forgot_pass', $data);
	}

	public function forgot_pass_send_link()
	{

		$this->load->model('Authmodel');
		$this->load->library('form_validation');

		$data['title'] = 'Next';
		$email         = $this->input->post('email');
        $method        = $this->input->post('forget_method');

		if ($email != '') {
			$very1 = $this->Authmodel->admin_email($email);
			$very2 = $this->Authmodel->employee_email($email);
			$very3 = $this->Authmodel->consultant_email($email);
			if (!empty($very1) || !empty($very2) || !empty($very3)) {
				$forgot_pass_code = $this->serialkey();
				$dd   = array(
					'forget_pass_code' => $forgot_pass_code
				);
				$this->load->library('email');
				if (!empty($very1)) {
					$this->db->where('email', $email);
					$query = $this->db->update('admin', $dd);
				}
				if (!empty($very2)) {
					$this->db->where('employee_email', $email);
					$query = $this->db->update('employees', $dd);
				}
				if (!empty($very3)) {
					$this->db->where('email', $email);
					$query = $this->db->update('consultant', $dd);
				}
				/*$this->load->library('email');

				$email   = $email;
				$subject = 'Forgot Password';

				$htmlContent = 'Dear User, Your new Password is ' . $pass;


				$this->email->from('admin@rrgpos.com', 'New Password');
				$this->email->to($email);
				$this->email->subject($subject);
				$this->email->message($htmlContent);*/

				//-------------------Send email to registered user for resetting account password  ----------------------
                if ($method == 'user'){
                    $data['forget_method'] = 'Username';
                    $recovery_link  = base_url().'auth/resetUsername/'.$forgot_pass_code;
                }else{
                    $data['forget_method'] = 'Password';
                    $recovery_link  = base_url().'auth/resetPassword/'.$forgot_pass_code;
                }
				$email_tempF            = $this->getEmailTemp('forgot password recovery');
                $email_tempF['message'] = str_replace("{METHOD}", $data['forget_method'], $email_tempF['message']);
				$email_tempF['message'] = str_replace("{forgot_pass_link}", $recovery_link, $email_tempF['message']);
				// $this->sendemail($email, 'Email Verification', $email_tempU['message'], $email_tempU['subject']);
				$result = $this->sendemail($email, $email, $email_tempF['message'], "Forgot {$data['forget_method']} Recovery");
				//-------------------------------------------------------


				if ($result) {
					$this->load->view('forgot_pass_send_link', $data);
				} else {
					$this->session->set_flashdata('message', 'Invalid Email Address');
					redirect($_SERVER['HTTP_REFERER']);
				}

			} else {
				$this->session->set_flashdata('message', 'Invalid Email Address');
				redirect($_SERVER['HTTP_REFERER']);
			}
			$this->load->view('forgot_pass_send_link', $data);
		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function upgrade_plan()
	{
		$this->load->model('Companymodel');
		$plan_id    = $this->input->post('plan_id');
		$consultant_id = $this->session->userdata('consultant_id');

		if(!isset($consultant_id)){
			$this->session->sess_destroy();
			redirect('Welcome');
		}


		if ($plan_id == 0 || $plan_id == '0') {
			redirect('Auth/update_process');
		} else {
			$data = array();
			$data['title'] = 'agreement';
			$data['plan_id'] = $plan_id;
			//$result = $this->consultantmodel->update_consultant($data, $consultant_id);
			//redirect('Auth/term_condition');
			$this->load->view('upgrade_term_condition', $data);
		}

	}


	public function upgrade_process_done()
	{
		$checked = $this->input->post('checkeds');
		$plan_id = $this->input->post('plan_id');

		if ($checked != '') {
			redirect('Auth/upgrade_payment/'.$plan_id);
		} else {
			redirect('Auth/upgrade_plan');
		}
	}


	public function upgrade_payment($plan_id=0)
	{
		$consultant_id = $this->session->userdata('consultant_id');


		if (isset($consultant_id)) {

			$this->load->model('Companymodel');
			$this->load->model('Planmodel');

			$consultant = $this->Companymodel->get_company($consultant_id);
			$plan = $this->Planmodel->get_plan($plan_id);

			$data['consultant'] = $consultant;
			$data['plan'] = $plan;


			$data['title'] = 'Payment';
			$this->load->view('upgrade_reg_payment', $data);

		} else {
			redirect('Auth/reg_pay_plans');
		}

	}

	public function terms(){

		$data['menu_title'] = 'payment';
		$this->load->view('terms', $data);
	}



	public function securityAuth() {
		$this->mHeader['title'] = 'Security Check';
		$this->mHeader['menu_title'] = 'security';

		// $userData = $this->session->userdata('temp_user');

		// $data['userData '] = $userData;

		$this->render('2FAPage');
	}


	public function submitAnswer() {
		$this->mHeader['title'] = 'Security Check';
		$this->mHeader['menu_title'] = 'security';

		$param = $this->input->post('security');
		// echo "<pre>";
		// 	print_r($param);
		// exit;
		if ($param) {
			$validation = [
				[
					'field' => 'security[question]',
					'label' => 'Security Question',
					'rules' => 'required'
				], [
					'field' => 'security[answer]',
					'label' => 'Security Answer',
					'rules' => 'required'
				]
			];
			$this->form_validation->set_rules($validation);

			if (!$this->form_validation->run())
				$this->render('2FAPage');
			else {
				$userData = $this->session->userdata('temp_user');
				$user = array();

				if($param['answer'] == $userData->security_answer) {
					$user = $userData;
					$this->session->set_userdata('user', $userData);
					$this->session->set_userdata([
							'consultant_id' => $userData->consultant_id,
							'username' => $userData->username,
							'user_type' => $userData->type,
							'com_status' => $userData->status
					]);
				}


				if($user){
					$this->redirect('welcome/dashboard');
				}
				else {
					$this->session->set_flashdata('flash', [
							'msg' => 'Invalid Answer , Please try again.'
					]);
					$this->render('2FAPage');
				}
			}
		} else {
			$this->render('2FAPage');
		}
	}

	public function send_mail($to , $toname , $content , $title, $type = 0) { 
         $from_email = "support@isoimplementationsoftware.com"; 
         $to_email = $to; 
   
         //Load email library 
         $this->load->library('email'); 
   		
         $this->email->set_mailtype('html'); 
         $this->email->from($from_email, $toname); 
         $this->email->to($to_email);
         $this->email->subject($title); 
         $this->email->message($content);
   
         //Send mail 
		 if($this->email->send()) {
		 	//echo $this->email->print_debugger();
		 	//exit;
		 	return true;
		 } else {
		 	//echo $this->email->print_debugger();
		 	//exit;
		 	return false;
		 }

		 //echo $this->email->print_debugger(); exit;
      }


	public function random($length, $chars = '')
	{
		if (!$chars) {
			$chars = implode(range('a','f'));
			$chars .= implode(range('0','9'));
		}
		$shuffled = str_shuffle($chars);
		return substr($shuffled, 0, $length);
	}

	public function serialkey()
	{
		return $this->random(8).'-'.$this->random(8).'-'.$this->random(8).'-'.$this->random(8);
	}


	public function verifyEmail ($activation_code) {
		// $data['title'] = 'Verify Email';
		// $data['menu_title'] = 'emailverify';

		$this->mHeader['title'] = 'Verify Email';
		$this->mHeader['menu_title'] = 'emailverify';

		$this->db->where('activation_code', $activation_code);
		$update = $this->db->update('consultant', array('is_active' => 1));

	    $this->load->view("layout/header", $this->mHeader);

	    $this->load->view('verifyEmail');

	    $this->load->view("layout/footer");
	}


	public function resetPassword ($recovery_link = '') {
		$this->mHeader['title']  = 'Reset Password';
		$this->mHeader['menu_title'] = 'resetpassword';
		$this->mHeader['recovery_link'] = $recovery_link;

		//$this->db->where('activation_code', $activation_code);
		//$update = $this->db->update('admin', array('is_active' => 1));

        if($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('password', 'Password','required|min_length[8]|callback_password_check');
            $this->form_validation->set_rules('repassword', 'Password', 'required|min_length[8]|callback_password_check');
            $this->form_validation->set_rules('repassword', 'Password Confirmation', 'required|matches[password]');
            if ($this->form_validation->run() == FALSE) {
                $this->mHeader['menu_title'] = 'resetpassword';
                $this->mHeader['recovery_link'] = $this->input->post('recovery_link');
                $this->load->view("layout/header", $this->mHeader);

                $this->load->view('reset-password', $this->mHeader);

                $this->load->view("layout/footer");
            } else {
                $password     = getHashedPassword($this->input->post('password'));
                $recovery_link = $this->input->post('recovery_link');
                $up = array('password' => $password);

                $this->db->where('forget_pass_code', $recovery_link);
                $update1 = $this->db->update('consultant', $up);

                $this->db->where('forget_pass_code', $recovery_link);
                $update2 = $this->db->update('admin', $up);

                $this->db->where('forget_pass_code', $recovery_link);
                $update3 = $this->db->update('employees', $up);


                if($update1 || $update2 || $update3) {
                    $this->load->view('reset-password-success');
                } else {
                    $this->session->set_flashdata('message', 'OOPS ! Something went wrong , Please try again.');
                    $this->load->view("layout/header", $this->mHeader);

                    $this->load->view('reset-password', $this->mHeader);

                    $this->load->view("layout/footer");
                }

            }

        } else {
            $this->load->view("layout/header", $this->mHeader);

            $this->load->view('reset-password', $this->mHeader);

            $this->load->view("layout/footer");
        }

    }

    public function resetUsername ($recovery_link = '') {
        $this->mHeader['title']  = 'Reset Username';
        $this->mHeader['menu_title'] = 'resetusername';
        $this->mHeader['recovery_link'] = $recovery_link;
        //$this->db->where('activation_code', $activation_code);
        //$update = $this->db->update('admin', array('is_active' => 1));

        if($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('username', 'Username','required|is_unique[consultant.username]|is_unique[admin.username]|is_unique[employees.username]');

            if ($this->form_validation->run() == FALSE) {
                $this->mHeader['menu_title']    = 'resetusername';
                $this->mHeader['recovery_link'] = $this->input->post('recovery_link');
                $this->load->view("layout/header", $this->mHeader);

                $this->load->view('reset-username', $this->mHeader);

                $this->load->view("layout/footer");
            } else {
                $username     = $this->input->post('username');
                $recovery_link = $this->input->post('recovery_link');
                $up = array('username' => $username);

                $this->db->where('forget_pass_code', $recovery_link);
                $update1 = $this->db->update('consultant', $up);

                $this->db->where('forget_pass_code', $recovery_link);
                $update2 = $this->db->update('admin', $up);

                $this->db->where('forget_pass_code', $recovery_link);
                $update3 = $this->db->update('employees', $up);


                if($update1 || $update2 || $update3) {
                    $this->load->view('reset-username-success');
                } else {
                    $this->session->set_flashdata('message', 'OOPS ! Something went wrong , Please try again.');
                    $this->load->view("layout/header", $this->mHeader);

                    $this->load->view('reset-username', $this->mHeader);

                    $this->load->view("layout/footer");
                }

            }

        } else {
            $this->load->view("layout/header", $this->mHeader);

            $this->load->view('reset-username', $this->mHeader);

            $this->load->view("layout/footer");
        }

    }


    public function update_password()
    {
        // echo "<pre>";
        // 	print_r($this->input->post());
        // exit;
        $this->load->model('Authmodel');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password', 'Password','required|min_length[8]|callback_password_check');
        $this->form_validation->set_rules('repassword', 'Password', 'required|min_length[8]|callback_password_check');
		$this->form_validation->set_rules('repassword', 'Password Confirmation', 'required|matches[password]');
		if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
		} else {
			$password     = getHashedPassword($this->input->post('password'));

			$user_type    = $this->input->post('user_type');

			$upArr  = array('password' => $password, 'isPasswordUptd' => 1);

			switch ($user_type) {
			  case 'admin':
				$this->db->where('id', $this->session->userdata('admin_id'));
				$query = $this->db->update('admin', $upArr);
			    break;
			  case 'executive':
				$this->db->where('consultant_id', $this->session->userdata('consultant_id'));
				$query = $this->db->update('consultant',$upArr);
			    break;
			  case 'consultant':
				$this->db->where('consultant_id', $this->session->userdata('consultant_id'));
				$query = $this->db->update('consultant',$upArr);
			    break;
			  default:
				$this->db->where('id', $this->session->userdata('employee_id'));
				$query = $this->db->update('employees', $upArr);
			}

			if($query) {
				$this->session->set_userdata('is_password_updated', 1);
				echo json_encode(['success'=>'Password updated successfully.']);
			}

		}
	}

}
