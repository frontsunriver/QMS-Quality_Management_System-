<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' ); 

/**
 * Class : BaseController
 * Base Class to control over all the classes
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class BaseController extends CI_Controller {
	protected $role = '';
	protected $vendorId = '';
	protected $name = '';
	//protected $email = '';
	protected $roleText = '';	
	protected $viewPath = '';	
	protected $global = array ();
	protected $sidemenubar = '';
	protected $term = array();
	protected $company = array ();

    public $settings;

    public function __construct()
    {
        parent::__construct();
        $this->settings = $this->db->query("select * from `default_setting` where `id`='1'")->row();
        //start get company from uri
//		$prefix = $this->uri->segment(1);
//		$company_url = $this->uri->segment(2);
//		if($prefix == "company" && isset($company_url)){
//			$this->company = array ();
//			$this->load->model('Company_model');
//			$result = $this->Company_model->getByUrl($company_url);
//			if($result){
//				$result['company_url'] = 'company/'.$result['url'];
//				$this->company = $result;
//			}else{
//				redirect('home');
//			}
//		}
//		//end get company from uri
//        $isLoggedIn = $this->session->userdata('isLoggedIn');
//
//        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
//        {
//
//        }
//        else
//        {
//
//            $this->load->model('User_model');
//            $userid = $this->session->userdata('userId');
//            $this->User_model->update(array('last_login' => date("Y-m-d H:i:s")), 'id='.$userid);
//            $user = $this->User_model->getRow('id='.$userid);
//            $lang = $user->language;
//        }
//
//		if (!$lang) $lang = DEFAULT_LANG;
//
//		$where[lang_code] = $lang;
//		$this->load->model('Translate_model');
//		$lang_data = $this->Translate_model->getLanguageList($where)[data][0];
//		$field_term = 'term';	$field_lang_user = $lang_data['field_name'];
//		$data_rows = $this->Translate_model->getTermList($field_term, $field_lang_user);
//		$this->term = array();
//		foreach($data_rows[data] as $key => $value){
//			$this->term[$value[$field_term]] = $value[$field_lang_user];
//		}

    }
	public function response($data = NULL) {
		$this->output->set_status_header ( 200 )->set_content_type ( 'application/json', 'utf-8' )->set_output ( json_encode ( $data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) )->_display ();
		exit ();
	}

	/**
     * This function used to make directory for uploaded files 
     */
    function makeDirectory($path) {
        if (!file_exists($path))
        {
            $this->makeDirectory(dirname($path));
            mkdir($path, 0777);
        }
    }
    
	
	/**
	 * This function used to check the user is logged in or not
	 */
	function isLoggedIn() {
		$isLoggedIn = $this->session->userdata ( 'isLoggedIn' );
		
		if (! isset ( $isLoggedIn ) || $isLoggedIn != TRUE) 
		{
			redirect ( 'login' );
		} 
		else 
		{
			$this->role = $this->session->userdata ( 'user_type' );
			$this->vendorId = $this->session->userdata ( 'userId' );
			$this->name = $this->session->userdata ( 'name' );
			$this->roleText = $this->session->userdata ( 'roleText' );
			//$this->email = $this->session->userdata ( 'email' );
			
			$this->global ['name'] = $this->name;
			$this->global ['role'] = $this->role;
			$this->global ['roleText'] = $this->roleText;
			//$this->global ['email'] = $this->email;
		}
	}
	
	/**
	 * This function is used to check the access
	 */
	function isSuperAdmin() {
		if ($this->role == ROLE_SUPERADMIN) 
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}

	/**
	 * This function is used to check the access
	 */
	function isAdmin() {
		if ($this->role == ROLE_ADMIN || $this->role == ROLE_SUPERADMIN) 
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}

	/**
	 * This function is used to check the access
	 */
	function isInstructor() {
		if ($this->role == ROLE_INSTRUCTOR)
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}

	/**
	 * This function is used to check the access
	 */
	function isCompany() {
		if ($this->role == ROLE_COMPANY) 
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}
	
	/**
	 * This function is used to check the access
	 */
	function isLearner() {
		if ($this->role == ROLE_LEARNER) 
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}


	public function error404()
	{
		$isLoggedIn = $this->session->userdata('isLoggedIn');
		

		if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            //$this->load->view('login');
            redirect('login');
        }
        else
        {
			$this->load->library('Sidebar');
			$sessiondata = $this->session->get_userdata(); 
			$side_params = array('selected_menu_id'=>'1-0');   
			$sessiondata['sidebar'] = $this->sidebar->generate($side_params, $sessiondata['user_type']);

			$this->load->view('_templates/header', $sessiondata);
	        $this->load->view('errors/html/error_4041');
	        $this->load->view('_templates/footer');
	    }
        
	}
	
	/**
	 * This function is used to load the set of views
	 */
	function loadThis() {
		$this->global ['pageTitle'] = 'Access Denied';
		
		$this->load->view ( '_templates/header', $this->global );
		$this->load->view ( 'access' );
		$this->load->view ( '_templates/footer' );
	}

	/**
     * This function used to load views
     * @param {string} $viewName : This is view name
     * @param {mixed} $headerInfo : This is array of header information
     * @param {mixed} $pageInfo : This is array of page information
     * @param {mixed} $footerInfo : This is array of footer information
     * @return {null} $result : null
     */
    function loadViews($viewName = "", $headerInfo = NULL, $pageInfo = NULL, $footerInfo = NULL){

        $this->load->model('Settings_model');

        $headerInfo['site_theme'] = $this->Settings_model->getTheme();
        if(sizeof($headerInfo['site_theme']) >= 1){
            $headerInfo['site_theme'] = $headerInfo['site_theme'][0];
        }
        if(sizeof($headerInfo['site_theme'])  == 0){
            $headerInfo['site_theme'] = array();
        }

        $headerInfo['company_name'] = $this->getSettingValue('company_name');
        $headerInfo['company_phone'] = $this->getSettingValue('company_phone');

		$headerInfo[term] = $this->term;
		$pageInfo[term] = $this->term;
		$footerInfo[term] = $this->term;

        $this->load->view('_templates/header', $headerInfo);
        $this->load->view($viewName, $pageInfo);
        $this->load->view('_templates/footer', $footerInfo);
    }

    function loadViews_front($viewName = "", $headerInfo = NULL, $pageInfo = NULL, $footerInfo = NULL){

        /*$this->load->model('Settings_model');

        $headerInfo['site_theme'] = $this->Settings_model->getTheme();
        if(sizeof($headerInfo['site_theme']) >= 1){
            $headerInfo['site_theme'] = $headerInfo['site_theme'][0];
        }
        if(sizeof($headerInfo['site_theme'])  == 0){
            $headerInfo['site_theme'] = array();
        }
        */
        $headerInfo['company_name'] = $this->getSettingValue('company_name');
        $headerInfo['company_phone'] = $this->getSettingValue('company_phone');

        $headerInfo[term] = $this->term;
        $pageInfo[term] = $this->term;
        $footerInfo[term] = $this->term;

        $this->load->view('_templates/main_header', $headerInfo);
        $this->load->view($viewName, $pageInfo);
        $this->load->view('_templates/main_footer', $footerInfo);
    }
    function getSettingValue($action = ''){
		$this->load->model('Settings_model');
        $value_ar = $this->Settings_model->getGlobal("action='".$action."'");
        if(sizeof($value_ar) > 0){
            $value_ar = $value_ar[0]['value'];
        }
        else{
            $value_ar = "";
        }
       return $value_ar;
    }

    /**
     * This function used to upload
     */
    public function doUpload($field, $dir = null){

        if(isset($dir))
            $targetDir = $dir;
        else
            $targetDir = './uploads/';

        /* correct submit? */
        if (isset($_FILES[$field]) && $_FILES[$field]) {
            $_file = $_FILES[$field];
        }
        elseif (($c = preg_match_all('/(?:^[^\[]+)|\[[^]]*\]/', $field, $matches)) > 1) {
            $_file = $_FILES;
            for ($i = 0; $i < $c; $i++) {
                if (($field = trim($matches[0][$i], '[]')) === '' OR ! isset($_file[$field])) {
                    $_file = NULL;
                    break;
                }
                $_file = $_file[$field];
            }
        }
        if ( ! isset($_file)) {
            $param['possible'] = 0;
            $param['msg'] = "don't select picture.";
            return $param;
        }

        $sessiondata = $this->session->get_userdata(); 

        /* utf8 encode_ln */
        $fileType = pathInfo($_file['name'],PATHINFO_EXTENSION);
        $now = microtime(true);	//date('Ymdhms');
        $realName = $_file['name'];
        $tmpName = $now.".".$fileType;
        $targetFile = $targetDir.$tmpName;

        /* is same file */
        if (file_exists($targetFile)) {
            $param['msg'] = "already exist on.";
            $param['possible'] = 0;
            return $param;
        }
        /* size of pic default:200MB */
        if($_file['size'] >= 1024 * 1024 * 2000){
            $param['msg'] = "size < 200MB.";
            $param['possible'] = 0;
            return $param;
        }
        /* upload part */
        if (move_uploaded_file($_file["tmp_name"], $targetFile)) {
            $param['msg'] = $_file['name']."success.";
            $param['file_type'] = $fileType;
            $param['possible'] = 1;
            $param['tmpName'] = $tmpName;
            $param['realName'] = $realName;
            $param['path'] = $targetFile;
            return $param;
        } else {
            $param['msg'] = $_file['name']."faild.";
            $param['possible'] = 0;
            return $param;
        }
    }



	/**
	 * This function used provide the pagination resources
	 * @param {string} $link : This is page link
	 * @param {number} $count : This is page count
	 * @param {number} $perPage : This is records per page limit
	 * @return {mixed} $result : This is array of records and pagination data
	 */
	function paginationCompress($link, $count, $perPage = 10) {
		$this->load->library ( 'pagination' );
	
		$config ['base_url'] = base_url () . $link;
		$config ['total_rows'] = $count;
		$config ['uri_segment'] = SEGMENT;
		$config ['per_page'] = $perPage;
		$config ['num_links'] = 5;
		$config ['full_tag_open'] = '<nav><ul class="pagination">';
		$config ['full_tag_close'] = '</ul></nav>';
		$config ['first_tag_open'] = '<li class="arrow">';
		$config ['first_link'] = 'First';
		$config ['first_tag_close'] = '</li>';
		$config ['prev_link'] = 'Previous';
		$config ['prev_tag_open'] = '<li class="arrow">';
		$config ['prev_tag_close'] = '</li>';
		$config ['next_link'] = 'Next';
		$config ['next_tag_open'] = '<li class="arrow">';
		$config ['next_tag_close'] = '</li>';
		$config ['cur_tag_open'] = '<li class="active"><a href="#">';
		$config ['cur_tag_close'] = '</a></li>';
		$config ['num_tag_open'] = '<li>';
		$config ['num_tag_close'] = '</li>';
		$config ['last_tag_open'] = '<li class="arrow">';
		$config ['last_link'] = 'Last';
		$config ['last_tag_close'] = '</li>';
	
		$this->pagination->initialize ( $config );
		$page = $config ['per_page'];
		$segment = $this->uri->segment ( SEGMENT );
	
		return array (
				"page" => $page,
				"segment" => $segment
		);
	}

    public function generateFileName($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function getEmailTemp($action){
    	$this->load->model('Settings_model');
    	$email_temp = $this->Settings_model->getEmailTemplate(array('action'=>$action));
    	return $email_temp;
    }

    public function getEmailAddress($user_id){
        $this->load->model('User_model');
        return $this->User_model->getEmailAddressById($user_id);
    }
    public function getSuperEmailAddress(){
        $this->load->model('User_model');
        return $this->User_model->getSuperEmailAddress();
    }

    public function sendemail($to , $toname , $content , $title, $type = 0){

        require_once(APPPATH . "third_party/phpmailer/class.phpmailer.php");
		require_once(APPPATH . "third_party/phpmailer/language/phpmailer.lang-zh.php");
//		require_once(APPPATH . "third_party/PHPMailer-6.0.7/src/PHPMailer.php");
//		require_once(APPPATH . "third_party/PHPMailer-6.0.7/src/SMTP.php");
//		require_once(APPPATH . "third_party/PHPMailer-6.0.7/src/Exception.php");
//		require_once(APPPATH . "third_party/PHPMailer-6.0.7/src/OAuth.php");
//		require_once(APPPATH . "third_party/PHPMailer-6.0.7/src/POP3.php");

        $mail = new PHPMailer;//\PHPMailer\PHPMailer();

        // Tell PHPMailer to use SMTP
        $mail->isSMTP();

//		$mail->SMTPOptions = array(
//				'ssl' => array(
//						'verify_peer' => false,
//						'verify_peer_name' => false,
//						'allow_self_signed' => true
//				)
//		);

        // Replace sender@example.com with your "From" address.
        // This address must be verified with Amazon SES.
        //$mail->setFrom('support@gosmartacademy.com', 'gosmartacademy');
		//$mail->setFrom('support@isogapauditsoftware.com', 'isogapauditsoftware');
		//$mail->setFrom('support@fsscverificationsoftware.com', 'fsscverification');
		//$mail->setFrom('support@isoprocessbasedauditexperts.com', 'isoprocessbasedaudittool');
		$mail->setFrom('support@isoimplementationsoftware.com', 'isoimplementationsoftware');

        // Replace recipient@example.com with a "To" address. If your account
        // is still in the sandbox, this address must be verified.
        // Also note that you can include several addAddress() lines to send
        // email to multiple recipients.
        $mail->addAddress($to, $toname);

        // Replace smtp_username with your Amazon SES SMTP user name.
        //$mail->Username = 'AKIAIXRRD3HLZ4CW3DWA';
		//$mail->Username = 'support@isogapauditsoftware.com';
		//$mail->Username = 'support@fsscverificationsoftware.com';
		//$mail->Username = 'support@isoprocessbasedauditexperts.com';
		$mail->Username = 'support@isoimplementationsoftware.com';

        // Replace smtp_password with your Amazon SES SMTP password.
        //$mail->Password = 'BE6SzEN9R0dYTI2sjTf33YslSfTNdAbYkpeKUJS3/cMu';
		//$mail->Password = 'Chinamei1111!';
		//$mail->Password = 'Verification1!';
		//$mail->Password = 'Processaudit1!';
		$mail->Password = 'G00gle@Secure!!';

        // Specify a configuration set. If you do not want to use a configuration
        // set, comment or remove the next line.
        //$mail->addCustomHeader('X-SES-CONFIGURATION-SET', 'ConfigSet');

        // If you're using Amazon SES in a region other than US West (Oregon),
        // replace email-smtp.us-west-2.amazonaws.com with the Amazon SES SMTP
        // endpoint in the appropriate region.
        //$mail->Host = 'email-smtp.us-east-1.amazonaws.com';
		//$mail->Host = 'mail.fsscverificationsoftware.com';
		//$mail->Host = 'mail.isoprocessbasedauditexperts.com';
		$mail->Host = 'secure.emailsrvr.com';

        // The subject line of the email
        $mail->Subject =$title;

        // The HTML-formatted body of the email
        $mail->Body = $content;

        // Tells PHPMailer to use SMTP authentication
        $mail->SMTPAuth = true;

        // Enable TLS encryption over port 587
        $mail->SMTPSecure = 'tls';
        //$mail->Port = 587;
		$mail->Port = 587;

        // Tells PHPMailer to send HTML-formatted email
        $mail->isHTML(true);

        // The alternative email body; this is only displayed when a recipient
        // opens the email in a non-HTML email client. The \r\n represents a
        // line break.
        $mail->AltBody = "Email Test\r\nThis email was sent through the 
            Amazon SES SMTP interface using the PHPMailer class.";

//		$mail->AddEmbeddedImage('assets/images/logo-top_message.png', 'logo');
		$mail->AddEmbeddedImage('assets/images//images/logo_f.png', 'logo');
		if($type == 0){
			$mail->AddEmbeddedImage('assets/images/images/bg_1.jpg', 'bg');
			$mail->AddEmbeddedImage('assets/images/images/work-2.jpg', 'work-2');
			$mail->AddEmbeddedImage('assets/images/images/work-4.jpg', 'work-4');
		}
		if($type == 1){
			$mail->AddEmbeddedImage('assets/images/images/01-bg-4.jpg', 'bg');
			$mail->AddEmbeddedImage('assets/images/images/work-1.jpg', 'work-1');
			$mail->AddEmbeddedImage('assets/images/images/work-0.jpg', 'work-0');
		}
		if($type == 2){
			$mail->AddEmbeddedImage('assets/images/images/01-bg-3.jpg', 'bg');
			$mail->AddEmbeddedImage('assets/images/images/work-1.jpg', 'work-1');
			$mail->AddEmbeddedImage('assets/images/images/work-5.jpg', 'work-5');
		}
		if($type == 3){
			$mail->AddEmbeddedImage('assets/images/images/01-bg-5.jpg', 'bg');
			$mail->AddEmbeddedImage('assets/images/images/work-7.jpg', 'work-7');
		}

		return $mail->send();

       // if(!$mail->send()) {
       //     echo "Email not sent. " , $mail->ErrorInfo , PHP_EOL;
       // } else {

       //     echo "Email sent!" , PHP_EOL;
       // }

//		$emailto = $to;
//		$toname = 'TO NAME';
//		$emailfrom = 'support@isogapauditsoftware.com';
//		$fromname = 'FROM NAME';
//		$subject = $title;
//		$messagebody = $content;
//		$headers =
//				'Return-Path: ' . $emailfrom . "\r\n" .
//				'From: ' . $fromname . ' <' . $emailfrom . '>' . "\r\n" .
//				'X-Priority: 3' . "\r\n" .
//				'X-Mailer: PHP ' . phpversion() .  "\r\n" .
//				'Reply-To: ' . $toname . ' <' . $emailfrom . '>' . "\r\n" .
//				'MIME-Version: 1.0' . "\r\n" .
//				'Content-Transfer-Encoding: 8bit' . "\r\n" .
//				'Content-Type: text/plain; charset=UTF-8' . "\r\n";
//		$params = '-f ' . $emailfrom;
//		$test = mail($emailto, $subject, $messagebody, $headers, $params);
//		if($test)
//			die("sent");
		// $test should be TRUE if the mail function is called correctly

    }
}
