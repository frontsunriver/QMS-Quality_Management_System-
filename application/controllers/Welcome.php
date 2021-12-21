<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller
{
	public $_user;

	function __construct() {
		parent::__construct();

		$this->_user = $this->session->userdata('user');
	}

	public function index() {
		$this->mHeader['title'] = 'Home';
		$this->mHeader['menu_title'] = 'home';
		$this->render('home');
	}

	public function aboutus() {
		$this->mHeader['title'] = 'About Us';
		$this->mHeader['menu_title'] = 'aboutus';
		$this->render('about-us');
	}

	public function register()
	{
		$data['title']="Register";
		$this->load->view('register',$data);
	}

	public function dashboard() {
		if (!$this->_user)
			$this->redirect('auth/login');

		if ($this->_user->type == 'executive' || $this->_user->type == 'admin')
			$this->redirect('admin/consultant_list');
		else if ($this->_user->type == 'employee' ||
				$this->_user->type == 'process_owner' || $this->_user->type == 'consultant')
			$this->redirect('welcome/consultantdashboard');
		else if ($this->_user->type == 'manufacturing' || $this->_user->type == 'monitor')
			$this->redirect('manufacture');
		else if ($this->_user->type == 'warehousing')
			$this->redirect('warehouse');
        else if ($this->_user->type == 'sales')
            $this->redirect('sales');
        else if ($this->_user->type == 'procurement')
        	$this->redirect('procurement');
	}

	public function employeedashboard()
	{
        $employee_id=$this->session->userdata('employee_id');
        $consultant_id1=$this->session->userdata('consultant_id');
		$open_status = 1;
		$closed_status = 0;
		if(!isset($employee_id)){
			$this->logout();
		}
		if ($employee_id!='') {
    		$data['title']="Home";
            $date=date('Y-m-d');
		    $this->db->where('consultant_id',$consultant_id1);
         	$data['comp']=$this->db->get('consultant')->row();

            $date1=explode('-', $data['comp']->expired);
            $date2=explode('-', $date);
            $ndate1=$date1[0].$date1[1].$date1[2];
            $ndate2=$date2[0].$date2[1].$date2[2];
             if ($ndate1 > $ndate2) {

                 $this->load->view('employee/dashboard',$data);
             }else{
				 $data['title']="Login";
                 $data['otp_status'] = $this->settings->otp_verification ? true:false;
				 $this->session->set_flashdata('message', 'You company account has expired. please contact consultant.');
				 $this->load->view('login',$data);
             }
    	}else{
    		redirect('Welcome');
    	}

	}

	public function consultantdashboard() {
		 $com_status=$this->session->userdata('com_status');
		 $consultant_id=$this->session->userdata('consultant_id');
		 $user_type=$this->session->userdata('user_type');

         $date=date('Y-m-d');

		  if(!isset($consultant_id)){
		  	$this->logout();
		  }

         if ($consultant_id) {
			 $data['title'] = 'Home';

			 $this->db->join("process","process.id = control_list.process_id","left");
			 $this->db->join("risk","risk.id = process.risk_id","left");
			 $this->db->where('risk.company_id',$consultant_id);
			 $this->db->where('control_list.status','0');
			 $this->db->where('control_list.del_flag','0');
			 if ($user_type != "consultant"){
				 $employee_id = $this->session->userdata('employee_id');
				 $this->db->where('(control_list.sme = '.$employee_id.' OR control_list.responsible_party = '.$employee_id.' OR process.process_owner = '.$employee_id.')');
			 }
			 $data['action_open_nums']=sizeof($this->db->get('control_list')->result());
			 $this->db->flush_cache();

			 $this->db->where('consultant_id',$consultant_id);
         	$data['comp']=$this->db->get('consultant')->row();
            // $date1=explode('-', $data['comp']->expired);
            // $date2=explode('-', $date);
            // $ndate1=$date1[0].$date1[1].$date1[2];
            // $ndate2=$date2[0].$date2[1].$date2[2];


			$this->load->view('consultant/dashboard',$data);
         	// if ($com_status=='1' && $consultant_id!='' && $ndate1 > $ndate2) {

			// 	$this->load->view('consultant/dashboard',$data);
			// }else{
			// 	$this->mHeader['title'] = 'Next';
			// 	$this->mHeader['menu_title'] = $this->mHeader['title'];

			// 	$chk = $this->Employees_model->num_rows([
			// 		'consultant_id' => $consultant_id
			// 	]);

			// 	$this->mContent['plans'] = $this->Plan_model->find([
			// 		'no_of_user >=' => $chk,
			// 		'is_trial' => 0
			// 	], ['no_of_user' => 'asc']);

			// 	$this->render('Register/register_payment_plans');
			// }
         }else{
         	$this->redirect('welcome');
         }
	}
	
	public function product_barcode($id = NULL){
		if (!empty($id)){
			$data['id'] = $id;
			$data['type'] = "product";
			$this->load->view('Register/view_barcode', $data);
		}else{
			redirect('Welcome');
		}
	}
	public function traceability_barcode($id = NULL){
		if (!empty($id)){
			$data['id'] = $id;
			$data['type'] = "traceability";
			$this->load->view('Register/view_barcode', $data);
		}else{
			redirect('Welcome');
		}
	}
	public function records_barcode($id = NULL){
		if (!empty($id)){
			$data['id'] = $id;
			$data['type'] = "records";
			$this->load->view('Register/view_barcode', $data);
		}else{
			redirect('Welcome');
		}
	}
	public function machine_barcode($id = NULL){
		if (!empty($id)){
			$data['id'] = $id;
			$data['type'] = "machine";
			$this->load->view('Register/view_barcode', $data);
		}else{
			redirect('Welcome');
		}
	}
	public function procedures_barcode($id = NULL){
		if (!empty($id)){
			$data['id'] = $id;
			$data['type'] = "procedures";
			$this->load->view('Register/view_barcode', $data);
		}else{
			redirect('Welcome');
		}
	}
	public function add_barcode($id = NULL){
		$control_id = $this->input->post('control_id');
		$type = $this->input->post('type');
		if (!empty($_FILES['file_name']['name'])) {
			$config['upload_path']   = 'uploads/file/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx';
			$config['file_name']     = time() . $_FILES['file_name']['name'];
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('file_name')) {
				$uploadData = $this->upload->data();
				$temp   = $uploadData['file_name'];
			} else {
				$temp = '';
			}
		} else {
			$temp = '';
		}
		switch ($type){
			case 'product':
				$data['product_barcode_image'] = $temp;
				break;
			case 'records':
				$data['records_barcode_image'] = $temp;
				break;
			case 'traceability':
				$data['traceability_barcode_image'] = $temp;
				break;
			case 'machine':
				$data['machine_barcode_image'] = $temp;
				break;
			case 'procedures':
				$data['procedures_barcode_image'] = $temp;
				break;
		}
		$this->db->where('control_id', $control_id);
		$array = $this->db->get('control_barcode')->result();
		if (count($array) > 0){
			$this->db->where('control_id', $control_id);
			$result = $this->db->update('control_barcode',$data);
			echo "Success";
		}else{
			redirect('Welcome');
		}
	}

	public function upload_barcode($type, $id){
		$data['id'] = $id;
		$data['type'] = $type;
		$this->load->view('Register/view_barcode', $data);
	}

	public function upload_barcode_request(){
		$id = $this->input->post('id');
		$type = $this->input->post('type');
		if (!empty($_FILES['file_name']['name'])) {
			$config['upload_path']   = 'uploads/file/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx';
			$config['file_name']     = time() . $_FILES['file_name']['name'];
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('file_name')) {
				$uploadData = $this->upload->data();
				$temp   = $uploadData['file_name'];
			} else {
				$temp = '';
			}
		} else {
			$temp = '';
		}

		if ($temp){
			switch ($type) {
				case 'product':
					$this->db->where('id', $id);
					$this->db->update('product', array('barcode_image' => $temp));
					break;
				case 'material':
					$this->db->where('id', $id);
					$this->db->update('material', array('barcode_image' => $temp));
					break;
			}
			echo 'Success.';
		}else echo 'Failed.';
	}

	public function logout() {
		$this->session->sess_destroy();
		redirect('auth/login');
	}
}
