<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller
{
	public $_user;

	public function __construct(){
		parent::__construct();

		$this->_user = $this->session->userdata('user');
	}

	public function plan_list() {
		$this->mContent['title'] = 'Plans';
		$this->mContent['menu_title'] = $this->mContent['title'];
		$this->mContent['plans'] = $this->Plan_model->find();

		// $this->render('admin/plan_list', 'admin/');
		$this->load->view('admin/plan_list', $this->mContent);
	}

	public function payment_list() {
		$this->mContent['title'] = 'Payments';
		$this->mContent['menu_title'] = $this->mContent['title'];
		$this->mContent['payment'] = $this->Payment_model->find();

		// $this->render('admin/plan_list', 'admin/');
		$this->load->view('admin/payment_list', $this->mContent);
	}

	public function add_plan() {
		$plan_name     = $this->input->post('plan_name');
		$no_of_user    = $this->input->post('no_of_user');
		//$total_process = $this->input->post('total_process');
		$total_amount  = $this->input->post('total_amount');
		$created_at    = date('Y-m-d');

		$data = array(
			'plan_name' => $plan_name,
			'no_of_user' => $no_of_user,
			'total_amount' => $total_amount,
			'created_at' => $created_at
		);
		$done = $this->db->insert('plan', $data);

		if ($done)
			$this->session->set_flashdata('message', 'success');
		else
			$this->session->set_flashdata('message', 'failed');

		$this->redirect('admin/plan_list');
	}

	public function delete_plan($id) {
		$this->db->where('plan_id', $id);
		$done = $this->db->delete('plan');
		if ($done)
			$this->session->set_flashdata('message', 'success_del');
		else
			$this->session->set_flashdata('message', 'failed');

		$this->redirect('admin/plan_list');
	}
	public function findplan() {
		$id = $this->input->post('id');
		$this->db->where('plan_id', $id);
		$done = $this->db->get('plan')->row();
		echo json_encode($done);
	}

	public function findcomp() {
		$id = $this->input->post('id');
		$this->db->where('consultant_id', $id);
		$done = $this->db->get('consultant')->row();

		$done->expired = date('m/d/Y', strtotime($done->expired));

		echo json_encode($done);
	}

	public function edit_plan() {
		$plan_id      = $this->input->post('plan_id1');
		$plan_name    = $this->input->post('plan_name');
		$no_of_user   = $this->input->post('no_of_user');
		$total_amount = $this->input->post('total_amount');
		$created_at   = date('Y-m-d');

		if($plan_id == '1'){
			$plan_name = 'Trial';
		}
		$data = array(
			'plan_name' => $plan_name,
			'no_of_user' => $no_of_user,
			'total_amount' => $total_amount
		);

		$this->db->where('plan_id', $plan_id);
		$done = $this->db->update('plan', $data);

		if ($done)
			$this->session->set_flashdata('message', 'update_success');

		$this->redirect('admin/plan_list');
	}


	public function consultant_list() {
		$this->mContent['title'] = 'Owner Management';
		$this->mContent['menu_title'] = $this->mContent['title'];

		$this->db->join("{$this->Plan_model->_table} B", "B.plan_id = A.plan_id", 'left');
		$this->mContent['consultant'] = $this->Consultant_model->find([
			"A.plan_id !=" => 0
		], [], ["A.*", "B.plan_name", "B.no_of_user"]);
		
		$this->mContent['plan'] = $this->Plan_model->find(['is_trial' => 0], ['no_of_user' => 'asc'], [], TRUE);

		// $this->render('admin/consultant_list', 'admin/');
		$this->load->view('admin/consultant_list', $this->mContent);
	}

	public function delete_consultant($id) {
		$param = ['consultant_id' => $id];

		$this->Employees_model->delete($param);
		$this->Payment_model->delete($param);
		$this->Purchase_plan_model->delete($param);
		$this->Consultant_model->delete($param);

		$this->session->set_flashdata('message', 'success_del');
		
		$this->redirect('admin/consultant_list');
	}

	public function invoice($type = 'list') {
		$this->mHeader['title'] = 'Invoice Management';
		$this->mHeader['menu_title'] = $this->mHeader['title'];

		if ($type == 'list') {
			$sdt = $this->input->get('start');
			$edt = $this->input->get('end');

			if (!$sdt)
				$sdt = date('Y-m-d', strtotime(date('Y-m-d') . ' - 29 days'));
			if (!$edt)
				$edt = date('Y-m-d');

			$this->mContent['start_date'] = $sdt;
			$this->mContent['end_date'] = $edt;
			$this->mContent['total_amount'] = $this->Invoice_model->select_sum([
				'create_date >=' => $sdt,
				'create_date <=' => $edt
			], 'amount');

			$this->mContent['total_open_amount'] = $this->Invoice_model->select_sum([
				'create_date >=' => $sdt,
				'create_date <=' => $edt,
				'status' => 'pending'
			], 'amount');

			$this->mContent['total_paid_amount'] = $this->Invoice_model->select_sum([
				'create_date >=' => $sdt,
				'create_date <=' => $edt,
				'status' => 'paid'
			], 'amount');

			$this->db->join($this->Consultant_model->_table, "{$this->Invoice_model->_table}.consultant_id = {$this->Consultant_model->_table}.consultant_id", 'left');
			$this->mContent['invoices'] = $this->Invoice_model->find([
				'create_date >=' => $sdt,
				'create_date <=' => $edt
			], ['create_date' => 'desc'], ["{$this->Invoice_model->_table}.*", "{$this->Consultant_model->_table}.username", "{$this->Consultant_model->_table}.consultant_name"]);

			$this->render('admin/invoice/list', 'admin/');
		} else if ($type == 'add') {
			$param = $this->input->post('add');
			if (!$param) {
				$this->mHeader['title'] = 'Invoice Add';
				$this->mContent['admin'] = $this->_user;
				$this->mContent['consultants'] = $this->Consultant_model->find(['status' => 1]);

				$this->render('admin/invoice/add', 'admin/');
			} else {
				$filter = [
					'consultant_id' => $param['consultant_id'],
					'invoice_num' => $param['invoice_num'],
					'comment' => $param['comment'],
					'tax_rate' => $param['tax_rate'],
					'amount' => $param['total_amount'],
					'create_date' => $param['create_date'],
					'due_date' => $param['create_date'],
					'footer_comment' => $param['footer_comment'],
					'status' => 'pending'
				];
				
				$invoice_id = $this->Invoice_model->insert($filter);

				$tax = $this->input->post('tax');
				$amount = $this->input->post('amount');
				$description = $this->input->post('description');

				// while(list($key, $val) = each($amount)) {
				while (TRUE) {
	                $key = key($amount);
	                if($key === null)
	                    break;
	                $val = current($amount);
					$item = [
						'invoice_id' => $invoice_id,
						'description' => $description[$key],
						'amount' => $amount[$key]
					];
					if(isset($tax[$key])){
						if($tax[$key] == 'on'){
							$item['is_tax'] = 1;
						}
					}
					$this->Invoice_item_model->insert($item);
					next($amount);
				}

				$this->redirect('admin/invoice/list');
			}
		}
	}

	public function invoice_edit($id) {
		$param = $this->input->post('edit');
		if (!$param) {
			$this->mHeader['title'] = 'Invoice Edit';
			$this->mHeader['menu_title'] = 'Invoice Management';

			$this->mContent['admin'] = $this->_user;
			$this->mContent['invoice'] = $this->Invoice_model->one(['id' => $id]);
			$this->mContent['items'] = $this->Invoice_item_model->find(['invoice_id' => $id]);
			$this->mContent['customer_admin'] = $this->Consultant_model->one(['consultant_id' => $this->mContent['invoice']->consultant_id]);

			$this->render('admin/invoice/edit', 'admin/');
		} else {
			$invoice_data=[
				'comment' => $param['comment'],
				'footer_comment' => $param['footer_comment'],
				'tax_rate' => $param['tax_rate'],
				'amount' => $param['total_amount'],
				'create_date' => $param['create_date'],
				'due_date' => $param['create_date'],
			];

			$result = $this->Invoice_model->update(['id' => $id], $invoice_data);
			if ($result) {
				$this->Invoice_item_model->delete(['invoice_id' => $id]);

				$tax = $this->input->post('tax');
				$amount = $this->input->post('amount');
				$description = $this->input->post('description');

				// while(list($key,$val) = each($amount)){
				while (TRUE) {
	                $key = key($amount);
	                if($key === null)
	                    break;
	                $val = current($amount);
					$item_data = [
						'invoice_id' => $id,
						'description' => $description[$key],
						'amount' => $amount[$key]
					];
					if(isset($tax[$key])){
						if($tax[$key] == 'on'){
							$item_data['is_tax'] = 1;
						}
					}

					$this->Invoice_item_model->insert($item_data);

					$this->redirect('admin/invoice/list');
					next($amount);
				}
			}
		}
	}

	public function invoice_delete($id) {
		$this->Invoice_model->delete(['id' => $id]);
		$this->Invoice_item_model->delete(['invoice_id' => $id]);

		$this->redirect('admin/invoice/list');
	}

	public function invoice_pay($id) {
		$this->Invoice_model->update(['id' => $id], ['status' => 'paid']);
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function invoice_view($id) {
		$this->mHeader['title'] = 'Invoice View';
		$this->mHeader['menu_title'] = 'Invoice Management';

		$this->mContent['admin'] = $this->_user;
		$this->mContent['invoice'] = $this->Invoice_model->one(['id' => $id]);
		$this->mContent['items'] = $this->Invoice_item_model->find(['invoice_id' => $id]);
		$this->mContent['consultant'] = $this->Consultant_model->one(['consultant_id' => $this->mContent['invoice']->consultant_id]);

		$subtotal = 0;
		$taxable = 0;
		$taxdue = 0;
		// while(list($key, $val) = each($this->mContent['items'])){
		while (TRUE) {
            $key = key($this->mContent['items']);
            if($key === null)
                break;
            $val = current($this->mContent['items']);
			$subtotal = $subtotal + $val->amount;
			if($val->is_tax == 1)
				$taxable = $taxable + $val->amount;
			next($this->mContent['items']);
		}
		$amount_list = array();
		$amount_list = [
			'subtotal' => $subtotal,
			'taxable' => $taxable,
			'taxdue' => $taxable * $this->mContent['invoice']->tax_rate / 100
		];

		$this->mContent['amount_list'] = $amount_list;

		$this->render('admin/invoice/view', 'admin/');
	}

	public function invoice_pdf() {
		$id = $this->input->post('view_invoice_id');

		$super = $this->_user;
		$invoice = $this->Invoice_model->one(['id' => $id]);
		$items = $this->Invoice_item_model->find(['invoice_id' => $id]);

		$subtotal = 0;
		$taxable = 0;
		$taxdue = 0;
		// while(list($key,$val) = each($items)){
		while (TRUE) {
            $key = key($items);
            if($key === null)
                break;
            $val = current($items);
			$subtotal = $subtotal + $val->amount;
			if($val->is_tax == 1)
				$taxable = $taxable + $val->amount;
			next($items);
		}
		$amount_list = array();
		$amount_list = [
			'subtotal' => $subtotal,
			'taxable' => $taxable,
			'taxdue' => $taxable*$invoice->tax_rate/100,
		];

		$customer_admin = $this->Consultant_model->one(['consultant_id' => $invoice->consultant_id]);

		$out_html = '';
		$out_html = '<table style="width:100%;border:none!important">';
					$out_html .= '<tr>';
						$out_html .= '<td style="width:50%;vertical-align:top">';
							$out_html .= '<h1 style="padding-left:10px!important;">'.$super->company_name.'</h1>';
							$out_html .= '<p style="margin:1px;padding-left:10px!important;">'.$super->address.'</p>';
							$out_html .= '<p style="margin:1px;padding-left:10px!important;">'.$super->city.'</p>';
							$out_html .= '<p style="margin:1px;padding-left:10px!important;">'.$super->phone.'</p>';
							$out_html .= '<p style="margin:1px;padding-left:10px!important;">'.$super->fax.'</p>';
							$out_html .= '<h3 style="margin-bottom:5px;padding-left:10px;width:50%;color:#A5A0A0">Bill To:</h3>';
							$out_html .= '<p style="margin:1px;padding-left:10px;!important">'.$customer_admin->consultant_name.'</p>';
							$out_html .= '<p style="margin:1px;padding-left:10px;!important">'.$customer_admin->address.'</p>';
							$out_html .= '<p style="margin:1px;padding-left:10px;!important">'.$customer_admin->city.'</p>';
						$out_html .= '</td>';
						$out_html .= '<td style="width:50%;vertical-align:top;text-align:right">';
							$out_html .= '<h1 style="font-size: 25px;color: #8796C5;padding-right:30px" >INVOICE</h1>';
							$out_html .= '<p style="margin:1px;">Invoice Date:'.$invoice->create_date.'</p>';
							$out_html .= '<p style="margin:1px;">INVOICE:'.$invoice->invoice_num.'</p>';
						$out_html .= '</td>';
					$out_html .= '</tr>';
					$out_html .= '</table>';
					$out_html .= '<table style="border:none!important;width:100%!important;margin-top:20px">';
						$out_html .= '<tr>';
							$out_html .= '<td style="background-color:#F8F8F8!important;border:none!important;padding:10px!important;text-align:center">Description</td>';
							$out_html .= '<td style="background-color:#F8F8F8!important;border:none!important;padding:10px!important;text-align:center">Taxed</td>';
							$out_html .= '<td style="background-color:#F8F8F8!important;border:none!important;padding:10px!important;text-align:center">Amount</td>';
						$out_html .= '</tr>';
						$index=0;
						foreach($items as $item){ 
						$out_html .= '<tr>';
							$out_html .= '<td style="border-bottom:1px solid #eee;padding:2px!important;text-align:center">'.$item->description.'</td>';
							if($item->is_tax == 0){
							$out_html .= '<td style="border-bottom:1px solid #eee;padding:2px!important;text-align:center;color:red">No</td>';
							}
							if($item->is_tax == 1){
							$out_html .= '<td style="border-bottom:1px solid #eee;padding:2px!important;important;text-align:center;color:green">Yes</td>';
							}
							$out_html .= '<td style="border-bottom:1px solid #eee;padding:2px!important;important;text-align:center">$'.$item->amount.'</td>';	
						$out_html .= '</tr>';
						$index++;
						}
					$out_html .= '</table>';
					$out_html .= '<table style="width:100%;border:none!important;margin-top:20px">';
						$out_html .= '<tr>';
							$out_html .= '<td style="width:65%;vertical-align:top;">';
							$out_html .= '<table style="width:70%;border:none!important;">';
								$out_html .= '<tr>';
									$out_html .= '<td style="vertical-align:top;text-align:left;width:100%;">';
										$out_html .= '<h3 style="margin:0;padding:10px;width:90%;background-color:#F8F8F8">Other Comments</h3>';
									$out_html .= '</td>';
								$out_html .= '</tr>';
								$out_html .= '<tr>';
									$out_html .= '<td style="margin-top:10px;white-space:pre-line;vertical-align:top;text-align:left;width:100%;word-break:break-word;">'.$invoice->comment.'</td>';
								$out_html .= '</tr>';
							$out_html .= '</table>';
							$out_html .= '</td>';
							$out_html .= '<td style="width:35%;vertical-align:top;text-align:right">';
							$out_html .= '<table style="width:100%;border:none!important;">';
								$out_html .= '<tr>';
									$out_html .= '<td style="text-align:right;border-bottom:1px solid #eee;padding:10px;width:50%;">Sub Total:</td>';
									$out_html .= '<td style="text-align:center;border-bottom:1px solid #eee;padding:10px;width:50%">$'.$amount_list['subtotal'].'</td>';
								$out_html .= '</tr>';
								$out_html .= '<tr>';
									$out_html .= '<td style="text-align:right;border-bottom:1px solid #eee;padding:10px;width:50%;">Taxable:</td>';
									$out_html .= '<td style="text-align:center;border-bottom:1px solid #eee;padding:10px;width:50%">$'.$amount_list['taxable'].'</td>';
								$out_html .= '</tr>';
								$out_html .= '<tr>';
									$out_html .= '<td style="text-align:right;border-bottom:1px solid #eee;padding:10px;width:50%;">Tax Rate:</td>';
									$out_html .= '<td style="text-align:center;border-bottom:1px solid #eee;padding:10px;width:50%">$'.$invoice->tax_rate.' (%)</td>';
								$out_html .= '</tr>';
								$out_html .= '<tr>';
									$out_html .= '<td style="text-align:right;border-bottom:1px solid #eee;padding:10px;width:50%;">Tax Due:</td>';
									$out_html .= '<td style="text-align:center;border-bottom:1px solid #eee;padding:10px;width:50%">$'.$amount_list['taxdue'].'</td>';
								$out_html .= '</tr>';
								$out_html .= '<tr>';
									$out_html .= '<td style="text-align:right;padding:10px;width:50%;"><h4 style="margin:0;font-size:20px;font-weight:400;">Total Due:</h4></td>';
									$out_html .= '<td style="text-align:center;padding:10px;width:50%"><h4 style="margin:0;font-size:20px;font-weight:400;">$'.$invoice->amount.'</h4></td>';
								$out_html .= '</tr>';
							$out_html .= '</table>';
							$out_html .= '</td>';
						$out_html .= '</tr>';	
					$out_html .= '</table>';
		$out_html .= '<div style="width:100%!important;text-align:center;white-space:pre;font-family:monospace;padding-top:30px">';
		$out_html .= ''.$invoice->footer_comment.'';
		$out_html .= '</div>';

		$this->load->library('html2pdf');
		$this->html2pdf->folder(UPLOAD_URL . 'doc/');
		$this->html2pdf->filename('invoice.pdf');
		$this->html2pdf->paper('a4', 'portrait');
		$this->html2pdf->html($out_html);
		if($this->html2pdf->create('download')) {
			echo 'PDF saved';
		}
	}

	public function edit_profile() {
		$this->mHeader['title'] = 'Edit Profile';
		$this->mHeader['menu_title'] = $this->mHeader['title'];

		$this->mContent['profile'] = $this->Admin_model->one(['id' => $this->_user->id]);

		// $this->render('admin/edit_profile', 'admin/');
		$this->load->view('admin/edit_profile', $this->mContent);
	}

	public function update_profile() {
		$param = $this->input->post();
        /*=-=- check user mobile number valid start =-=-*/
        $phone_response = $this->phone_rk->checkPhoneNumber($param['phone']);
        if (!$phone_response['success']){
            $this->session->set_flashdata('phone_response', $phone_response);
            redirect('admin/edit_profile');
            return;
        }
        /*=-=- check user mobile number valid end =-=-*/

		$result = $this->Admin_model->update(['id' => $this->_user->id], $param);
		if ($result)
			$this->session->set_flashdata('message', 'update_success');

		$this->redirect('admin/edit_profile');
	}

    public function update_password() {
        $param  = $this->input->post();
        $user   = $this->Admin_model->one(array('id' => $this->_user->id));
        if ($user){
            if (!verifyHashedPassword($param['old_password'], $user->password)){
                $this->session->set_flashdata('password', array('success' => false, 'message' => 'Old Password did\'nt matched'));
                $this->redirect('admin/edit_profile');
            }
            if (empty(trim($param['password'])) && empty(trim($param['repassword']))){
                $this->session->set_flashdata('password', array('success' => false, 'message' => 'New Password Cannot be Empty'));
                $this->redirect('admin/edit_profile');
            }
            if ($param['password'] != $param['repassword']){
                $this->session->set_flashdata('password', array('success' => false, 'message' => 'New Password didn\'t matched with confirm password'));
                $this->redirect('admin/edit_profile');
            }
            $password   = getHashedPassword($param['password']);
            $result     = $this->Admin_model->update(['id' => $user->id], array('password' => $password));
            if ($result){
                $this->session->set_flashdata('password', array('success' => true, 'message' => 'Password Updated Successfully'));
            }else{
                $this->session->set_flashdata('password', array('success' => true, 'message' => 'Password Not Updated'));
            }

            $this->redirect('admin/edit_profile');
        }
        redirect('Welcome');
    }

	public function default_logo() {
		$this->mHeader['title'] = 'Default Logo';
		$this->mHeader['menu_title'] = $this->mHeader['title'];

		$this->mContent['logo'] = $this->Default_logo_model->one(['id' => 1]);

		$this->render('admin/default_logo', 'admin/');
	}

	public function update_default() {
		if (!empty($_FILES['picture']['name'])) {
			$config['upload_path']   = 'uploads/logo/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['file_name']     = time() . $_FILES['picture']['name'];

			$this->upload->initialize($config);

			if ($this->upload->do_upload('picture')) {
				$uploadData = $this->upload->data();
				$picture    = $uploadData['file_name'];
			} else
				$picture = '';
		} else
			$picture = @$this->db->query("SELECT * FROM default_setting WHERE id='1'")->row()->logo;

		$up = array('logo' => $picture);

		$done = $this->Default_logo_model->update(['id' => 1], $up);
		if ($done)
			$this->session->set_flashdata('message', 'update_success');

		$this->redirect('admin/default_logo');
	}

	public function edit_consultant() {
		$consultant_name = $this->input->post('consultant_name');
		$username     = $this->input->post('username');
		$email        = $this->input->post('email');
        /*=-=- check user mobile number valid start =-=-*/
        $phone        = $this->input->post('phone');
        $phone_response = $this->phone_rk->checkPhoneNumber($phone);
        if (!$phone_response['success']){
            $this->session->set_flashdata('phone_response', $phone_response);
            redirect('admin/consultant_list');
            return;
        }
        /*=-=- check user mobile number valid end =-=-*/
		$password     = getHashedPassword($this->input->post('password'));
		$consultant_id11 = $this->input->post('consultant_id11');
		$plan_id     = $this->input->post('plan');
		$expired = date('Y-m-d', strtotime($this->input->post('expired_date')));

		$data = array(
			'consultant_name' => $consultant_name,
			'user_type' => $consultant_name,
			'username' => $username,
			'email' => $email,
            'phone' => $phone,
			'password' => $password,
			'plan_type' => 'real',
			'expired' => $expired,
			'plan_id' => $plan_id
		);

		//check main otp verification status
		if ($this->settings->otp_verification){
		    $data['otp_status'] = $this->input->post('otp_status');
        }

        if (empty(trim($this->input->post('password')))){
            unset($data['password']);
        }

		$this->db->where('consultant_id', $consultant_id11);
		$done = $this->db->update('consultant', $data);

		if ($done)
			$this->session->set_flashdata('message', 'update_success');
		else
			$this->session->set_flashdata('message', 'failed');

		redirect('admin/consultant_list');
	}


	public function add_consultant() {
		$consultant_name = $this->input->post('consultant_name');
		$username       = $this->input->post('username');
		$email          = $this->input->post('email');
        /*=-=- check user mobile number valid start =-=-*/
        $phone        = $this->input->post('phone');
        $phone_response = $this->phone_rk->checkPhoneNumber($phone);
        if (!$phone_response['success']){
            $this->session->set_flashdata('phone_response', $phone_response);
            redirect('admin/consultant_list');
            return;
        }
        /*=-=- check user mobile number valid end =-=-*/
		$password     = getHashedPassword($this->input->post('password'));
		$consultant_id11 = $this->input->post('consultant_	id11');
		$plan_id     = $this->input->post('plan');
		$expired = date('Y-m-d', strtotime($this->input->post('expired_date')));
		$date             = date('Y-m-d');

		$data = array(
			'consultant_name' => $consultant_name,
			'user_type' => $consultant_name,
			'username' => $username,
			'email' => $email,
            'phone' => $phone,
			'password' => $password,
			'plan_type' => 'real',
			'expired' => $expired,
			'plan_id' => $plan_id,
			'status' => '1',
			'created_at' => $date
		);
        //check main otp verification status
        if ($this->settings->otp_verification){
            $data['otp_status'] = $this->input->post('otp_status');
        }

		$done = $this->db->insert('consultant', $data);
		if ($done) {
			$this->session->set_flashdata('message', 'update_success');
			//---------------------send email to user(admin)-----------------------
			$email_temp = $this->getEmailTemp('Super Admin assign subscription');
			$email_temp['message'] = str_replace("{USERNAME}", $username, $email_temp['message']);
			$email_temp['message'] = str_replace("{COURSE_NAME}", 'isoimplementationsoftware.com', $email_temp['message']);
			$email_temp['message'] = str_replace("{firstname1}", 'firstname1', $email_temp['message']);
			$email_temp['message'] = str_replace("{LOGO}", "<img src='cid:logo'>", $email_temp['message']);
			$this->sendemail($email, 'Super Admin assigned a subscription', $email_temp['message'], $email_temp['subject']);
            //---------------------------------------------- send sms ----------------------------------------------
            if (!empty($phone) && $this->settings->otp_verification){
                $phone = formatMobileNumber($phone, true);
                /*=-=- check user mobile number valid start =-=-*/
                $phone_response = $this->phone_rk->checkPhoneNumber($phone);
                if ($phone_response['success']){
                    $message = "Hi {$username}".PHP_EOL;
                    $message.= "Congratulations you have been assigned to ".APP_NAME." Quality Circle's Process Risk(Strategic and Operational) Based Implementation Software. The software is the first of its kind globally. It is a cloud based automated tool which enables users to monitor established controls so data can be harvested for useful analytics and evaluation by top management to drive continual improvement.";
                    $this->twill_rk->sendMsq($phone,$message);
                }
            }
			//---------------------------------------------------------------------
			redirect('admin/consultant_list');
		} else {
			$this->session->set_flashdata('message', 'failed');
			redirect('admin/consultant_list');
		}
	}

	public function cases_list() {
		$data['title'] = "Case Type";
		$data['case']  = $this->db->get('cases')->result();
		$this->load->view('admin/cases_list', $data);
	}

	public function add_case() {
		$case_name = $this->input->post('case_name');
		$data      = array(
			'case_name' => $case_name
		);
		$done = $this->db->insert('cases', $data);

		if ($done)
			redirect('admin/cases_list');
		else
			$this->session->set_flashdata('message', 'failed');

		redirect('admin/cases_list');
	}

	public function delete_case($id = Null) {
		$this->db->where('case_id', $id);
		$done = $this->db->delete('cases');
		if ($done) {
			$this->session->set_flashdata('message', 'success_del');
			redirect('Admin/cases_list');
		} else {
			$this->session->set_flashdata('message', 'failed');
			redirect('Admin/cases_list');
		}
	}

	public function findcase() {
		$id = $this->input->post('id');
		$this->db->where('case_id', $id);
		$done = $this->db->get('cases')->row();
		echo json_encode($done);
	}
	
	public function edit_case() {
		$case_id   = $this->input->post('case_id');
		$case_name = $this->input->post('case_name');
		$data      = array(
			'case_name' => $case_name
		);

		$this->db->where('case_id', $case_id);
		$done = $this->db->update('cases', $data);

		if ($done)
			$this->session->set_flashdata('message', 'update_success');
		else
			$this->session->set_flashdata('message', 'failed');

		$this->redirect('admin/cases_list');
	}



	public function update_status($id) {
		$upArr = array('is_active' => $_GET['is_active']);
		$this->db->where('consultant_id', $id);
		$done = $this->db->update('consultant', $upArr);

		if($done) {
			$this->session->set_flashdata('message', 'update_success');
			redirect('admin/consultant_list');
		}
	}

    public function update_otp_setting(){
        $response = array('success' => false, 'message' => 'action not allowed');
        if ($this->session->userdata('user_type') != 'admin'){
            echo json_encode($response);
            return false;
        }
        $status = $this->input->post('status');
        $this->db->where('id', 1);
        if ($this->db->update('default_setting', array('otp_verification' => $status))){
            $response['success'] = true;
            $response['message'] = 'OTP Verification Status Changed';
        }
        echo json_encode($response);
        return true;
    }

}
