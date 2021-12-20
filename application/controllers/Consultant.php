<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH.'/libraries/BaseController.php';
class Consultant extends BaseController//CI_Controller
{
	public function __construct(){
		parent::__construct();

		$this->load->library('session');

		$this->load->model(['Control_barcode_model']);
	}
    // Output JSON string
    protected function render_json($data, $code = 200)
    {
        $this->output
            ->set_status_header($code)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));

        // force output immediately and interrupt other scripts
        global $OUT;
        $OUT->_display();
        exit;
    }

    function get($id = null) {
    	if (!$id)
    		$result = $this->Consultant_model->find(['status' => 1]);
    	else
    		$result = $this->Consultant_model->one(['consultant_id' => $id]);

    	$this->render_json($result);
    }

//supplier
public function supplier()
{
		$data['cc1'] = 'active';
		$data['c11'] = 'act1';
		$consultant_id = $this->session->userdata('consultant_id');
		if($consultant_id){
			$data['title'] = "Supplier";
			$this->load->view('consultant/manage/supplier', $data);
		}else{
			redirect('Welcome');
		}
}
public function supplier_read($id = NULL)
{
		$consultant_id  = $this->session->userdata('consultant_id');
		$displayStart = $this->input->post('iDisplayStart');
		$displayLength = $this->input->post('iDisplayLength');
		$search = $this->input->post('sSearch');
		$sortingCols = $this->input->post('iSortingCols');
		$supplier_list = $this->input->post('supplier_list');
		$data = array();
		if (isset($id)) {
				$data['supplier'] = '';
		} else {
				$filter['del_flag'] = 0;
				if ($displayLength != -1) {
						$filter['start'] = $displayStart;
						$filter['limit'] = $displayLength;
						$filter['search'] = $search;
				}
				$order = array();
				for ($i = 0; $i < $sortingCols; $i++) {
						$sortCol = $this->input->post('iSortCol_' . $i);
						$sortDir = $this->input->post('sSortDir_' . $i);
						$dataProp = $this->input->post('mDataProp_' . $sortCol);
						$order[$dataProp] = $sortDir;
				}
				$sql = "SELECT * FROM supplier
										WHERE
												company_id = " . $consultant_id . " and del_flag = 0";
				$data['iTotalRecords'] = count($this->db->query($sql)->result());
				if ($supplier_list != ''){
					$temp = explode(",",$supplier_list);
					$temp_count = 0;
					$sql .= " and (";
					foreach ($temp as $temp_data){
						$temp_count++;
						$sql .= " id = ".$temp_data;
						if ($temp_count != count($temp)){
							$sql .= " OR";
						}
					}
					$sql .= " )";
				}
				if ($search != ''){
						$sql .= " and (name like '%".$search."%')";
				}
				$data['iTotalDisplayRecords'] = count($this->db->query($sql)->result());
				$sql .= " ORDER BY reg_date";
				$count = 0;
				foreach ($order as $key => $val) {
						$sql .= ", ";
						$sql .= $key." ".$val;
						$count = $count + 1;
				}
				$sql .= " limit ".$displayStart.", ".$displayLength;
				$data['supplier'] = $this->db->query($sql)->result();
				$data['sEcho'] = $search;
		}
		$this->render_json($data);
}
public function supplier_save()
{
	$data = $this->input->post(NULL, TRUE);
	$config = array(
			array(
					 'field'   => 'material',
					 'label'   => 'Material',
					 'rules'   => 'trim|required'
			),
			array(
					 'field'   => 'name',
					 'label'   => 'Name',
					 'rules'   => 'required'
			),
			array(
					 'field'   => 'phone',
					 'label'   => 'Name',
					 'rules'   => 'required'
			),
			array(
					 'field'   => 'email',
					 'label'   => 'Email Address',
					 'rules'   => 'required'
			)
	);
	$this->form_validation->set_rules($config);
	if ($this->form_validation->run() == TRUE)
	{
		if(!empty($data['id'])) {
				$this->db->where('id', $data['id']);
				$result = $this->db->update('supplier',$data);
		} else{
				$consultant_id  = $this->session->userdata('consultant_id');
				$data['company_id'] = $consultant_id;
				$this->db->set('reg_date','now()',FALSE);
				$result = $this->db->insert('supplier',$data);
		}
		if ($result > 0){
				$this->render_json(array('success'=>TRUE));
		}else{
				$this->render_json(array('success'=>FALSE));
		}
	}else{
		$this->render_json(array('success'=>FALSE, 'message'=>strip_tags(validation_errors())));
	}
}
public function supplier_delete()
{
	$id = $this->input->post('ids', TRUE);
	$this->db->where('id', $id);
	$result = $this->db->update('supplier', array('del_flag'=>'1'));
	echo json_encode(array('success'=>$result));
}
//Trigger
	public function trigger()
	{
		$data['cc1'] = 'active';
		$data['c5'] = 'active';
		$data['c52'] = 'act1';
		$consultant_id = $this->session->userdata('consultant_id');
		if($consultant_id){
			$data['title'] = "Trigger";
			$this->load->view('consultant/manage/manage_trigger', $data);
		}else{
			redirect('Welcome');
		}
	}
	public function trigger_read($id = NULL)
	{
		$consultant_id  = $this->session->userdata('consultant_id');
		$displayStart = $this->input->post('iDisplayStart');
		$displayLength = $this->input->post('iDisplayLength');
		$search = $this->input->post('sSearch');
		$sortingCols = $this->input->post('iSortingCols');
		$data = array();
		if (isset($id)) {
			$data['trigger'] = '';
		} else {
			$filter['del_flag'] = 0;
			if ($displayLength != -1) {
				$filter['start'] = $displayStart;
				$filter['limit'] = $displayLength;
				$filter['search'] = $search;
			}
			$order = array();
			for ($i = 0; $i < $sortingCols; $i++) {
				$sortCol = $this->input->post('iSortCol_' . $i);
				$sortDir = $this->input->post('sSortDir_' . $i);
				$dataProp = $this->input->post('mDataProp_' . $sortCol);
				$order[$dataProp] = $sortDir;
			}
			$sql = "SELECT * FROM rmt.trigger
										WHERE
												company_id = " . $consultant_id;
			$data['iTotalRecords'] = count($this->db->query($sql)->result());
			if ($search != ''){
				$sql .= " and (trigger_name like '%".$search."%')";
			}
			$data['iTotalDisplayRecords'] = count($this->db->query($sql)->result());
			$sql .= " ORDER BY ";
			$count = 0;
			foreach ($order as $key => $val) {
				if($count > 0){
					$sql .= ", ";
				}
				$sql .= $key." ".$val;
				$count = $count + 1;
			}
			$sql .= " limit ".$displayStart.", ".$displayLength;
			$data['trigger'] = $this->db->query($sql)->result();
			$data['sEcho'] = $search;
		}
		$this->render_json($data);
	}
	//Customer requirement
	public function customer_requirement()
	{
		$data['cc1'] = 'active';
		$data['c5'] = 'active';
		$data['c53'] = 'act1';
		$consultant_id = $this->session->userdata('consultant_id');
		if($consultant_id){
			$data['title'] = "Customer Requirement";
			$this->load->view('consultant/manage/manage_customer_requirement', $data);
		}else{
			redirect('Welcome');
		}
	}
	public function customer_requirement_read($id = NULL)
	{
		$consultant_id  = $this->session->userdata('consultant_id');
		$displayStart = $this->input->post('iDisplayStart');
		$displayLength = $this->input->post('iDisplayLength');
		$search = $this->input->post('sSearch');
		$sortingCols = $this->input->post('iSortingCols');
		$data = array();
		if (isset($id)) {
			$data['customer'] = '';
		} else {
			$filter['del_flag'] = 0;
			if ($displayLength != -1) {
				$filter['start'] = $displayStart;
				$filter['limit'] = $displayLength;
				$filter['search'] = $search;
			}
			$order = array();
			for ($i = 0; $i < $sortingCols; $i++) {
				$sortCol = $this->input->post('iSortCol_' . $i);
				$sortDir = $this->input->post('sSortDir_' . $i);
				$dataProp = $this->input->post('mDataProp_' . $sortCol);
				$order[$dataProp] = $sortDir;
			}
			$sql = "SELECT * FROM customer_requirment
										WHERE
												company_id = " . $consultant_id;
			$data['iTotalRecords'] = count($this->db->query($sql)->result());
			if ($search != ''){
				$sql .= " and (name like '%".$search."%')";
			}
			$data['iTotalDisplayRecords'] = count($this->db->query($sql)->result());
			$sql .= " ORDER BY ";
			$count = 0;
			foreach ($order as $key => $val) {
				if($count > 0){
					$sql .= ", ";
				}
				$sql .= $key." ".$val;
				$count = $count + 1;
			}
			$sql .= " limit ".$displayStart.", ".$displayLength;
			$data['customer'] = $this->db->query($sql)->result();
			$data['sEcho'] = $search;
		}
		$this->render_json($data);
	}
	//Product
	public function product()
	{
		$data['cc1'] = 'active';
		$data['c5'] = 'active';
		$data['c54'] = 'act1';
		$consultant_id = $this->session->userdata('consultant_id');
		if($consultant_id){
			$data['title'] = "Product";
			$this->load->view('consultant/manage/manage_product', $data);
		}else{
			redirect('Welcome');
		}
	}
	public function product_read($id = NULL)
	{
		$consultant_id  = $this->session->userdata('consultant_id');
		$displayStart = $this->input->post('iDisplayStart');
		$displayLength = $this->input->post('iDisplayLength');
		$search = $this->input->post('sSearch');
		$sortingCols = $this->input->post('iSortingCols');
		$data = array();
		if (isset($id)) {
			$data['product'] = '';
		} else {
			$filter['del_flag'] = 0;
			if ($displayLength != -1) {
				$filter['start'] = $displayStart;
				$filter['limit'] = $displayLength;
				$filter['search'] = $search;
			}
			$order = array();
			for ($i = 0; $i < $sortingCols; $i++) {
				$sortCol = $this->input->post('iSortCol_' . $i);
				$sortDir = $this->input->post('sSortDir_' . $i);
				$dataProp = $this->input->post('mDataProp_' . $sortCol);
				$order[$dataProp] = $sortDir;
			}
			$sql = "SELECT * FROM product
										WHERE
												company_id = " . $consultant_id . " and del_flag = 0 ";
			$data['iTotalRecords'] = count($this->db->query($sql)->result());
			if ($search != ''){
				$sql .= " and (name like '%".$search."%')";
			}
			$data['iTotalDisplayRecords'] = count($this->db->query($sql)->result());
			$sql .= " ORDER BY ";
			$count = 0;
			foreach ($order as $key => $val) {
				if($count > 0){
					$sql .= ", ";
				}
				$sql .= $key." ".$val;
				$count = $count + 1;
			}
			$sql .= " limit ".$displayStart.", ".$displayLength;
			$data['product'] = $this->db->query($sql)->result();
			$data['sEcho'] = $search;
		}
		$this->render_json($data);
	}
	//Product
	public function shift()
	{
		$data['cc1'] = 'active';
		$data['c5'] = 'active';
		$data['c57'] = 'act1';
		$consultant_id = $this->session->userdata('consultant_id');
		if($consultant_id){
			$data['title'] = "Shift";
			$this->load->view('consultant/manage/manage_shift', $data);
		}else{
			redirect('Welcome');
		}
	}
	public function shift_read($id = NULL)
	{
		$consultant_id  = $this->session->userdata('consultant_id');
		$displayStart = $this->input->post('iDisplayStart');
		$displayLength = $this->input->post('iDisplayLength');
		$search = $this->input->post('sSearch');
		$sortingCols = $this->input->post('iSortingCols');
		$data = array();
		if (isset($id)) {
			$data['shift'] = '';
		} else {
			$filter['del_flag'] = 0;
			if ($displayLength != -1) {
				$filter['start'] = $displayStart;
				$filter['limit'] = $displayLength;
				$filter['search'] = $search;
			}
			$order = array();
			for ($i = 0; $i < $sortingCols; $i++) {
				$sortCol = $this->input->post('iSortCol_' . $i);
				$sortDir = $this->input->post('sSortDir_' . $i);
				$dataProp = $this->input->post('mDataProp_' . $sortCol);
				$order[$dataProp] = $sortDir;
			}
			$sql = "SELECT * FROM shift
										WHERE
												company_id = " . $consultant_id;
			$data['iTotalRecords'] = count($this->db->query($sql)->result());
			if ($search != ''){
				$sql .= " and (name like '%".$search."%')";
			}
			$data['iTotalDisplayRecords'] = count($this->db->query($sql)->result());
			$sql .= " ORDER BY ";
			$count = 0;
			foreach ($order as $key => $val) {
				if($count > 0){
					$sql .= ", ";
				}
				$sql .= $key." ".$val;
				$count = $count + 1;
			}
			$sql .= " limit ".$displayStart.", ".$displayLength;
			$data['shift'] = $this->db->query($sql)->result();
			$data['sEcho'] = $search;
		}
		$this->render_json($data);
	}
	//Policy
	public function policy()
	{
		$data['cc1'] = 'active';
		$data['c5'] = 'active';
		$data['c56'] = 'act1';
		$consultant_id = $this->session->userdata('consultant_id');
		if($consultant_id){
			$data['title'] = "Policy/Procedure/Records";
			$this->load->view('consultant/manage/manage_policy', $data);
		}else{
			redirect('Welcome');
		}
	}
	public function policy_read($id = NULL)
	{
		$consultant_id  = $this->session->userdata('consultant_id');
		$displayStart = $this->input->post('iDisplayStart');
		$displayLength = $this->input->post('iDisplayLength');
		$search = $this->input->post('sSearch');
		$sortingCols = $this->input->post('iSortingCols');
		$data = array();
		if (isset($id)) {
			$data['policy'] = '';
		} else {
			$filter['del_flag'] = 0;
			if ($displayLength != -1) {
				$filter['start'] = $displayStart;
				$filter['limit'] = $displayLength;
				$filter['search'] = $search;
			}
			$order = array();
			for ($i = 0; $i < $sortingCols; $i++) {
				$sortCol = $this->input->post('iSortCol_' . $i);
				$sortDir = $this->input->post('sSortDir_' . $i);
				$dataProp = $this->input->post('mDataProp_' . $sortCol);
				$order[$dataProp] = $sortDir;
			}
			$sql = "SELECT * FROM policy
										WHERE
												company_id = " . $consultant_id;
			$data['iTotalRecords'] = count($this->db->query($sql)->result());
			if ($search != ''){
				$sql .= " and (name like '%".$search."%')";
			}
			$data['iTotalDisplayRecords'] = count($this->db->query($sql)->result());
			$sql .= " ORDER BY ";
			$count = 0;
			foreach ($order as $key => $val) {
				if($count > 0){
					$sql .= ", ";
				}
				$sql .= $key." ".$val;
				$count = $count + 1;
			}
			$sql .= " limit ".$displayStart.", ".$displayLength;
			$data['policy'] = $this->db->query($sql)->result();
			$data['sEcho'] = $search;
		}
		$this->render_json($data);
	}
	//Regulatory Requirement
	public function regulatory_requirement()
	{
		$data['cc1'] = 'active';
		$data['c5'] = 'active';
		$data['c55'] = 'act1';
		$consultant_id = $this->session->userdata('consultant_id');
		if($consultant_id){
			$data['title'] = "Regulatory Requirement";
			$this->load->view('consultant/manage/manage_regulatory_requirement', $data);
		}else{
			redirect('Welcome');
		}
	}
	public function regulatory_requirement_read($id = NULL)
	{
		$consultant_id  = $this->session->userdata('consultant_id');
		$displayStart = $this->input->post('iDisplayStart');
		$displayLength = $this->input->post('iDisplayLength');
		$search = $this->input->post('sSearch');
		$sortingCols = $this->input->post('iSortingCols');
		$data = array();
		if (isset($id)) {
			$data['regulatory'] = '';
		} else {
			$filter['del_flag'] = 0;
			if ($displayLength != -1) {
				$filter['start'] = $displayStart;
				$filter['limit'] = $displayLength;
				$filter['search'] = $search;
			}
			$order = array();
			for ($i = 0; $i < $sortingCols; $i++) {
				$sortCol = $this->input->post('iSortCol_' . $i);
				$sortDir = $this->input->post('sSortDir_' . $i);
				$dataProp = $this->input->post('mDataProp_' . $sortCol);
				$order[$dataProp] = $sortDir;
			}
			$sql = "SELECT * FROM regulatory_requirement
										WHERE
												company_id = " . $consultant_id;
			$data['iTotalRecords'] = count($this->db->query($sql)->result());
			if ($search != ''){
				$sql .= " and (name like '%".$search."%')";
			}
			$data['iTotalDisplayRecords'] = count($this->db->query($sql)->result());
			$sql .= " ORDER BY ";
			$count = 0;
			foreach ($order as $key => $val) {
				if($count > 0){
					$sql .= ", ";
				}
				$sql .= $key." ".$val;
				$count = $count + 1;
			}
			$sql .= " limit ".$displayStart.", ".$displayLength;
			$data['regulatory'] = $this->db->query($sql)->result();
			$data['sEcho'] = $search;
		}
		$this->render_json($data);
	}
//Customer
public function customer()
{
		$data['cc1'] = 'active';
		$data['c10'] = 'act1';
		$consultant_id = $this->session->userdata('consultant_id');
		if($consultant_id){
			$data['title'] = "Customer";
			$this->load->view('consultant/manage/customer', $data);
		}else{
			redirect('Welcome');
		}
}
public function customer_read($id = NULL)
{
		$consultant_id  = $this->session->userdata('consultant_id');
		$displayStart = $this->input->post('iDisplayStart');
		$displayLength = $this->input->post('iDisplayLength');
		$search = $this->input->post('sSearch');
		$sortingCols = $this->input->post('iSortingCols');
		$customer_list = $this->input->post('customer_list');
		$data = array();
		if (isset($id)) {
				$data['customer'] = '';
		} else {
				$filter['del_flag'] = 0;
				if ($displayLength != -1) {
						$filter['start'] = $displayStart;
						$filter['limit'] = $displayLength;
						$filter['search'] = $search;
				}
				$order = array();
				for ($i = 0; $i < $sortingCols; $i++) {
						$sortCol = $this->input->post('iSortCol_' . $i);
						$sortDir = $this->input->post('sSortDir_' . $i);
						$dataProp = $this->input->post('mDataProp_' . $sortCol);
						$order[$dataProp] = $sortDir;
				}
				$sql = "SELECT * FROM customer
										WHERE
												company_id = " . $consultant_id . " and del_flag = 0";
				$data['iTotalRecords'] = count($this->db->query($sql)->result());
				if ($customer_list != ''){
					$temp = explode(",",$customer_list);
					$temp_count = 0;
					$sql .= " and (";
					foreach ($temp as $temp_data){
						$temp_count++;
						$sql .= " id = ".$temp_data;
						if ($temp_count != count($temp)){
							$sql .= " OR";
						}
					}
					$sql .= " )";
				}
				if ($search != ''){
						$sql .= " and (name like '%".$search."%')";
				}
				$data['iTotalDisplayRecords'] = count($this->db->query($sql)->result());
				$sql .= " ORDER BY ";
				$count = 0;
				foreach ($order as $key => $val) {
						if($count > 0){
							$sql .= ", ";
						}
						$sql .= $key." ".$val;
						$count = $count + 1;
				}
				$sql .= " limit ".$displayStart.", ".$displayLength;
				$data['customer'] = $this->db->query($sql)->result();
				$data['sEcho'] = $search;
		}
		$this->render_json($data);
}
public function customer_save()
{
	$data = $this->input->post(NULL, TRUE);
	$config = array(
			array(
					 'field'   => 'customer',
					 'label'   => 'Customer',
					 'rules'   => 'trim|required'
			),
			array(
					 'field'   => 'name',
					 'label'   => 'Name',
					 'rules'   => 'required'
			),
			array(
					 'field'   => 'phone',
					 'label'   => 'Name',
					 'rules'   => 'required'
			),
			array(
					 'field'   => 'product',
					 'label'   => 'Product',
					 'rules'   => 'required'
			),
			array(
					 'field'   => 'email',
					 'label'   => 'Email Address',
					 'rules'   => 'required'
			)
	);
	$this->form_validation->set_rules($config);
	if ($this->form_validation->run() == TRUE)
	{
		if(!empty($data['id'])) {
				$this->db->where('id', $data['id']);
				$result = $this->db->update('customer',$data);
		} else{
				$consultant_id  = $this->session->userdata('consultant_id');
				$data['company_id'] = $consultant_id;
				$this->db->set('reg_date','now()',FALSE);
				$result = $this->db->insert('customer',$data);
		}
		if ($result > 0){
				$this->render_json(array('success'=>TRUE));
		}else{
				$this->render_json(array('success'=>FALSE));
		}
	}else{
		$this->render_json(array('success'=>FALSE, 'message'=>strip_tags(validation_errors())));
	}
}
public function customer_delete()
{
	$id = $this->input->post('ids', TRUE);
	$this->db->where('id', $id);
	$result = $this->db->update('customer', array('del_flag'=>'1'));
	echo json_encode(array('success'=>$result));
}
//Records
public function record()
{
		$data['cc1'] = 'active';
		$data['c9'] = 'act1';
		$consultant_id = $this->session->userdata('consultant_id');
		if($consultant_id){
			$data['title'] = "Records";
			$this->load->view('consultant/manage/record', $data);
		}else{
			redirect('Welcome');
		}
}
public function record_read($id = NULL)
{
		$consultant_id  = $this->session->userdata('consultant_id');
		$displayStart = $this->input->post('iDisplayStart');
		$displayLength = $this->input->post('iDisplayLength');
		$search = $this->input->post('sSearch');
		$sortingCols = $this->input->post('iSortingCols');
		$record_list = $this->input->post('record_list');
		$data = array();
		if (isset($id)) {
				$data['record'] = '';
		} else {
				$filter['del_flag'] = 0;
				if ($displayLength != -1) {
						$filter['start'] = $displayStart;
						$filter['limit'] = $displayLength;
						$filter['search'] = $search;
				}
				$order = array();
				for ($i = 0; $i < $sortingCols; $i++) {
						$sortCol = $this->input->post('iSortCol_' . $i);
						$sortDir = $this->input->post('sSortDir_' . $i);
						$dataProp = $this->input->post('mDataProp_' . $sortCol);
						$order[$dataProp] = $sortDir;
				}
				$sql = "SELECT * FROM record
										WHERE
												company_id = " . $consultant_id . " and del_flag = 0";
				$data['iTotalRecords'] = count($this->db->query($sql)->result());
				if ($record_list != ''){
					$temp = explode(",",$record_list);
					$temp_count = 0;
					$sql .= " and (";
					foreach ($temp as $temp_data){
						$temp_count++;
						$sql .= " id = ".$temp_data;
						if ($temp_count != count($temp)){
							$sql .= " OR";
						}
					}
					$sql .= " )";
				}
				if ($search != ''){
						$sql .= " and (name like '%".$search."%' or description like '%".$search."%')";
				}
				$data['iTotalDisplayRecords'] = count($this->db->query($sql)->result());
				$sql .= " ORDER BY ";
				$count = 0;
				foreach ($order as $key => $val) {
						if($count > 0){
							$sql .= ", ";
						}
						$sql .= $key." ".$val;
						$count = $count + 1;
				}
				$sql .= " limit ".$displayStart.", ".$displayLength;
				$data['record'] = $this->db->query($sql)->result();
				$data['sEcho'] = $search;
		}
		$this->render_json($data);
}
	public function record_save()
	{
		$config = array(
				array(
						 'field'   => 'name',
						 'label'   => 'Name',
						 'rules'   => 'trim|required'
				),
				array(
						 'field'   => 'description',
						 'label'   => 'Description',
						 'rules'   => 'required'
				)
		);
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == TRUE)
		{
			$data['id'] = $this->input->post('id', TRUE);
			$data['name'] = $this->input->post('name', TRUE);
			$data['description'] = $this->input->post('description', TRUE);
			$data['version_date'] = $this->input->post('version_date', TRUE);
			$data['revision_date'] = $this->input->post('revision_date', TRUE);
			if (!empty($_FILES['file']['name'])) {
				$config['upload_path']   = 'uploads/Doc/';
				$config['allowed_types'] = 'jpg|jpeg|png|xls|pdf|doc|docx';
				$config['file_name']     = time() . $_FILES['file']['name'];
				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if ($this->upload->do_upload('file')) {
					$uploadData = $this->upload->data();
					$data['file_path']   = $uploadData['file_name'];
				}
			}
			if(!empty($data['id'])) {
				$this->db->where('id', $data['id']);
				$result = $this->db->update('record',$data);
				$id = $data['id'];
			} else{
				$consultant_id  = $this->session->userdata('consultant_id');
				$data['company_id'] = $consultant_id;
				$this->db->set('reg_date','now()',FALSE);
				$result = $this->db->insert('record',$data);
				$id = $this->db->insert_id();
			}
			if ($result > 0){
				$this->render_json(array('success'=>$id));
			}else{
				$this->render_json(array('success'=>FALSE));
			}
		}else{
			$this->render_json(array('success'=>FALSE, 'message'=>strip_tags(validation_errors())));
		}
	}
	public function record_save_content()
	{
		$data['id'] = $this->input->post('edit_id', TRUE);
		$data['content'] = $this->input->post('content', TRUE);
		$data['content'] = str_replace("&lt;html&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;/html&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;head&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;/head&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;title&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;/title&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;body&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;/body&gt;",'',$data['content']);
		if(!empty($data['id'])) {
			$this->db->where('id', $data['id']);
			$result = $this->db->update('record',$data);
		} else{
			redirect('consultant/record');
		}
		if ($result > 0){
			redirect('consultant/record');
		}else{
			redirect('consultant/record');
		}
	}
	public function record_delete()
	{
		$id = $this->input->post('ids', TRUE);
		$this->db->where('id', $id);
		$result = $this->db->update('record', array('del_flag'=>'1'));
		echo json_encode(array('success'=>$result));
	}
//procedures
		public function procedure()
		{
				$data['cc1'] = 'active';
				$data['c8'] = 'act1';
				$consultant_id = $this->session->userdata('consultant_id');
				if($consultant_id){
					$data['title'] = "Procedures Register";
					$this->load->view('consultant/manage/procedure', $data);
				}else{
					redirect('Welcome');
				}
		}
		public function procedure_read($id = NULL)
		{
				$consultant_id  = $this->session->userdata('consultant_id');
				$displayStart = $this->input->post('iDisplayStart');
				$displayLength = $this->input->post('iDisplayLength');
				$search = $this->input->post('sSearch');
				$sortingCols = $this->input->post('iSortingCols');
				$procedure_list = $this->input->post('procedure_list');
				$data = array();
				if (isset($id)) {
						$data['procedure'] = '';
				} else {
						$filter['del_flag'] = 0;
						if ($displayLength != -1) {
								$filter['start'] = $displayStart;
								$filter['limit'] = $displayLength;
								$filter['search'] = $search;
						}
						$order = array();
						for ($i = 0; $i < $sortingCols; $i++) {
								$sortCol = $this->input->post('iSortCol_' . $i);
								$sortDir = $this->input->post('sSortDir_' . $i);
								$dataProp = $this->input->post('mDataProp_' . $sortCol);
								$order[$dataProp] = $sortDir;
						}
						$sql = "SELECT * FROM procedures
												WHERE
														company_id = " . $consultant_id . " and del_flag = 0";
						$data['iTotalRecords'] = count($this->db->query($sql)->result());
						if ($procedure_list != ''){
							$temp = explode(",",$procedure_list);
							$temp_count = 0;
							$sql .= " and (";
							foreach ($temp as $temp_data){
								$temp_count++;
								$sql .= " id = ".$temp_data;
								if ($temp_count != count($temp)){
									$sql .= " OR";
								}
							}
							$sql .= " )";
						}
						if ($search != ''){
								$sql .= " and (name like '%".$search."%' or description like '%".$search."%')";
						}
						$data['iTotalDisplayRecords'] = count($this->db->query($sql)->result());
						$sql .= " ORDER BY ";
						$count = 0;
						foreach ($order as $key => $val) {
								if($count > 0){
									$sql .= ", ";
								}
								$sql .= $key." ".$val;
								$count = $count + 1;
						}
						$sql .= " limit ".$displayStart.", ".$displayLength;
						$data['procedure'] = $this->db->query($sql)->result();
						$data['sEcho'] = $search;
				}
				$this->render_json($data);
		}
		public function procedure_save()
		{
			$config = array(
					array(
							 'field'   => 'name',
							 'label'   => 'Name',
							 'rules'   => 'trim|required'
					),
					array(
							 'field'   => 'description',
							 'label'   => 'Description',
							 'rules'   => 'required'
					)
			);
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == TRUE)
			{
				$data['id'] = $this->input->post('id', TRUE);
				$data['name'] = $this->input->post('name', TRUE);
				$data['description'] = $this->input->post('description', TRUE);
				$data['version_date'] = $this->input->post('version_date', TRUE);
				$data['revision_date'] = $this->input->post('revision_date', TRUE);
				if (!empty($_FILES['file']['name'])) {
					$config['upload_path']   = 'uploads/Doc/';
					$config['allowed_types'] = 'jpg|jpeg|png|xls|pdf|doc|docx';
					$config['file_name']     = time() . $_FILES['file']['name'];
					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					if ($this->upload->do_upload('file')) {
						$uploadData = $this->upload->data();
						$data['file_path']   = $uploadData['file_name'];
					}
				}
				if(!empty($data['id'])) {
						$this->db->where('id', $data['id']);
						$result = $this->db->update('procedures',$data);
						$id = $data['id'];
				} else{
						$consultant_id  = $this->session->userdata('consultant_id');
						$data['company_id'] = $consultant_id;
						$this->db->set('reg_date','now()',FALSE);
						$result = $this->db->insert('procedures',$data);
						$id = $this->db->insert_id();
				}
				if ($result > 0){
						$this->render_json(array('success'=>$id));
				}else{
						$this->render_json(array('success'=>FALSE));
				}
			}else{
				$this->render_json(array('success'=>FALSE, 'message'=>strip_tags(validation_errors())));
			}
		}
		public function procedure_save_content()
		{
				$data['id'] = $this->input->post('edit_id', TRUE);
				$data['content'] = $this->input->post('content', TRUE);
				$data['content'] = str_replace("&lt;html&gt;",'',$data['content']);
				$data['content'] = str_replace("&lt;/html&gt;",'',$data['content']);
				$data['content'] = str_replace("&lt;head&gt;",'',$data['content']);
				$data['content'] = str_replace("&lt;/head&gt;",'',$data['content']);
				$data['content'] = str_replace("&lt;title&gt;",'',$data['content']);
				$data['content'] = str_replace("&lt;/title&gt;",'',$data['content']);
				$data['content'] = str_replace("&lt;body&gt;",'',$data['content']);
				$data['content'] = str_replace("&lt;/body&gt;",'',$data['content']);
				if(!empty($data['id'])) {
					$this->db->where('id', $data['id']);
					$result = $this->db->update('procedures',$data);
				} else{
					redirect('consultant/procedure');
				}
				if ($result > 0){
					redirect('consultant/procedure');
				}else{
					redirect('consultant/procedure');
				}
		}
		public function procedure_delete()
		{
			$id = $this->input->post('ids', TRUE);
			$this->db->where('id', $id);
			$result = $this->db->update('procedures', array('del_flag'=>'1'));
			echo json_encode(array('success'=>$result));
		}
//assessment_controls
		public function assessment_controls()
		{
				$data['cc1'] = 'active';
				$data['c6'] = 'active';
				$data['c63'] = 'active';
				$consultant_id = $this->session->userdata('consultant_id');
				if($consultant_id){
					$data['title'] = "Assessment Controls";
					$this->load->view('consultant/manage/strategic/assessment_controls', $data);
				}else{
					redirect('Welcome');
				}
		}
		public function assessment_controls_read($id = NULL)
		{
				$consultant_id  = $this->session->userdata('consultant_id');
				$displayStart = $this->input->post('iDisplayStart');
				$displayLength = $this->input->post('iDisplayLength');
				$search = $this->input->post('sSearch');
				$sortingCols = $this->input->post('iSortingCols');
				$data = array();
				if (isset($id)) {
						$data['assessment_controls'] = '';
				} else {
						$filter['del_flag'] = 0;
						if ($displayLength != -1) {
								$filter['start'] = $displayStart;
								$filter['limit'] = $displayLength;
								$filter['search'] = $search;
						}
						$order = array();
						for ($i = 0; $i < $sortingCols; $i++) {
								$sortCol = $this->input->post('iSortCol_' . $i);
								$sortDir = $this->input->post('sSortDir_' . $i);
								$dataProp = $this->input->post('mDataProp_' . $sortCol);
								$order[$dataProp] = $sortDir;
						}
						$sql = "SELECT * FROM assessment_controls
												WHERE
														company_id = " . $consultant_id . " and del_flag = 0";
						$data['iTotalRecords'] = count($this->db->query($sql)->result());
						if ($search != ''){
								$sql .= " and (rating like '%".$search."%' or action like '%".$search."%')";
						}
						$data['iTotalDisplayRecords'] = count($this->db->query($sql)->result());
						$sql .= " ORDER BY ";
						$count = 0;
						foreach ($order as $key => $val) {
								if($count > 0){
									$sql .= ", ";
								}
								$sql .= $key." ".$val;
								$count = $count + 1;
						}
						$sql .= " limit ".$displayStart.", ".$displayLength;
						$data['assessment_controls'] = $this->db->query($sql)->result();
						$data['sEcho'] = $search;
				}
				$this->render_json($data);
		}
		public function assessment_controls_save()
		{
			$data = $this->input->post(NULL, TRUE);
			$config = array(
					array(
							 'field'   => 'rating',
							 'label'   => 'Rating',
							 'rules'   => 'trim|required'
					),
					array(
							 'field'   => 'description',
							 'label'   => 'Description',
							 'rules'   => 'required'
					),
					array(
							 'field'   => 'action',
							 'label'   => 'Action',
							 'rules'   => 'required'
					)
			);
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == TRUE)
			{
				if(!empty($data['id'])) {
						$this->db->where('id', $data['id']);
						$result = $this->db->update('assessment_controls',$data);
				} else{
						$consultant_id  = $this->session->userdata('consultant_id');
						$data['company_id'] = $consultant_id;
						$this->db->set('reg_date','now()',FALSE);
						$result = $this->db->insert('assessment_controls',$data);
				}
				if ($result > 0){
						$this->render_json(array('success'=>TRUE));
				}else{
						$this->render_json(array('success'=>FALSE));
				}
			}else{
				$this->render_json(array('success'=>FALSE, 'message'=>strip_tags(validation_errors())));
			}
		}
		public function assessment_controls_delete()
		{
			$id = $this->input->post('ids', TRUE);
			$this->db->where('id', $id);
			$result = $this->db->update('assessment_controls', array('del_flag'=>'1'));
			echo json_encode(array('success'=>$result));
		}
//control_actions
		public function control_actions()
		{
				$data['cc1'] = 'active';
				$data['c6'] = 'active';
				$data['c62'] = 'active';
				$consultant_id = $this->session->userdata('consultant_id');
				if($consultant_id){
					$data['title'] = "Control Actions";
					$this->load->view('consultant/manage/strategic/control_actions', $data);
				}else{
					redirect('Welcome');
				}
		}
		public function control_actions_read($id = NULL)
		{
				$consultant_id  = $this->session->userdata('consultant_id');
				$displayStart = $this->input->post('iDisplayStart');
				$displayLength = $this->input->post('iDisplayLength');
				$search = $this->input->post('sSearch');
				$sortingCols = $this->input->post('iSortingCols');
				$data = array();
				if (isset($id)) {
						$data['control_actions'] = '';
				} else {
						$filter['del_flag'] = 0;
						if ($displayLength != -1) {
								$filter['start'] = $displayStart;
								$filter['limit'] = $displayLength;
								$filter['search'] = $search;
						}
						$order = array();
						for ($i = 0; $i < $sortingCols; $i++) {
								$sortCol = $this->input->post('iSortCol_' . $i);
								$sortDir = $this->input->post('sSortDir_' . $i);
								$dataProp = $this->input->post('mDataProp_' . $sortCol);
								$order[$dataProp] = $sortDir;
						}
						$sql = "SELECT * FROM control_actions
												WHERE
														company_id = " . $consultant_id . " and del_flag = 0";
						$data['iTotalRecords'] = count($this->db->query($sql)->result());
						if ($search != ''){
								$sql .= " and (rating like '%".$search."%' or description like '%".$search."%')";
						}
						$data['iTotalDisplayRecords'] = count($this->db->query($sql)->result());
						$sql .= " ORDER BY ";
						$count = 0;
						foreach ($order as $key => $val) {
								if($count > 0){
									$sql .= ", ";
								}
								$sql .= $key." ".$val;
								$count = $count + 1;
						}
						$sql .= " limit ".$displayStart.", ".$displayLength;
						$data['control_actions'] = $this->db->query($sql)->result();
						$data['sEcho'] = $search;
				}
				$this->render_json($data);
		}
		public function control_actions_save()
		{
			$data = $this->input->post(NULL, TRUE);
			$config = array(
					array(
							 'field'   => 'rating',
							 'label'   => 'Rating',
							 'rules'   => 'trim|required'
					),
					array(
							 'field'   => 'description',
							 'label'   => 'Description',
							 'rules'   => 'required'
					)
			);
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == TRUE)
			{
				if(!empty($data['id'])) {
						$this->db->where('id', $data['id']);
						$result = $this->db->update('control_actions',$data);
				} else{
						$consultant_id  = $this->session->userdata('consultant_id');
						$data['company_id'] = $consultant_id;
						$this->db->set('reg_date','now()',FALSE);
						$result = $this->db->insert('control_actions',$data);
				}
				if ($result > 0){
						$this->render_json(array('success'=>TRUE));
				}else{
						$this->render_json(array('success'=>FALSE));
				}
			}else{
				$this->render_json(array('success'=>FALSE, 'message'=>strip_tags(validation_errors())));
			}
		}
		public function control_actions_delete()
		{
			$id = $this->input->post('ids', TRUE);
			$this->db->where('id', $id);
			$result = $this->db->update('control_actions', array('del_flag'=>'1'));
			echo json_encode(array('success'=>$result));
		}

		function control_active($id) {
			$param = $this->input->get();
			$param['active_at'] = date('Y-m-d H:i:s');
			$this->Control_list_model->update(['id' => $id], $param);
			redirect('consultant/conduct');
		}
//food_rating
		public function food_rating()
		{
				$data['cc1'] = 'active';
				$data['c7'] = 'active';
				$data['c71'] = 'act1';
				$consultant_id = $this->session->userdata('consultant_id');
				if($consultant_id){
					$data['title'] = "Food Rating Matrix";
					$data['type'] = 1;
					$this->load->view('consultant/manage/operational_rating/other_rating', $data);
				}else{
					redirect('Welcome');
				}
		}
//quality_rating
		public function quality_rating()
		{
				$data['cc1'] = 'active';
				$data['c7'] = 'active';
				$data['c72'] = 'act1';
				$consultant_id = $this->session->userdata('consultant_id');
				if($consultant_id){
					$data['title'] = "Quality Rating Matrix";
					$data['type'] = 2;
					$this->load->view('consultant/manage/operational_rating/other_rating', $data);
				}else{
					redirect('Welcome');
				}
		}
//environment_rating
		public function environment_rating()
		{
				$data['cc1'] = 'active';
				$data['c7'] = 'active';
				$data['c73'] = 'act1';
				$consultant_id = $this->session->userdata('consultant_id');
				if($consultant_id){
					$data['title'] = "Environment Rating Matrix";
					$data['type'] = 3;
					$this->load->view('consultant/manage/operational_rating/other_rating', $data);
				}else{
					redirect('Welcome');
				}
		}
//safety_rating
		public function safety_rating()
		{
				$data['cc1'] = 'active';
				$data['c7'] = 'active';
				$data['c74'] = 'act1';
				$consultant_id = $this->session->userdata('consultant_id');
				if($consultant_id){
					$data['title'] = "Safety Rating Matrix";
					$data['type'] = 4;
					$this->load->view('consultant/manage/operational_rating/other_rating', $data);
				}else{
					redirect('Welcome');
				}
		}
//taccp_rating
		public function taccp_rating()
		{
				$data['cc1'] = 'active';
				$data['c7'] = 'active';
				$data['c75'] = 'act1';
				$consultant_id = $this->session->userdata('consultant_id');
				if($consultant_id){
					$data['title'] = "TACCP Rating Matrix";
					$data['type'] = 5;
					$this->load->view('consultant/manage/operational_rating/other_rating', $data);
				}else{
					redirect('Welcome');
				}
		}
//taccp_rating
		public function vaccp_rating()
		{
				$data['cc1'] = 'active';
				$data['c7'] = 'active';
				$data['c76'] = 'act1';
				$consultant_id = $this->session->userdata('consultant_id');
				if($consultant_id){
					$data['title'] = "VACCP Rating Matrix";
					$data['type'] = 6;
					$this->load->view('consultant/manage/operational_rating/other_rating', $data);
				}else{
					redirect('Welcome');
				}
		}
//risk_opportunities
		public function risks_opportunities()
		{
				$data['cc1'] = 'active';
				$data['c6'] = 'active';
				$data['c61'] = 'active';
				$data['c611'] = 'act1';
				$consultant_id = $this->session->userdata('consultant_id');
				if($consultant_id){
					$data['title'] = "Risks And Opportunities";
					$this->load->view('consultant/manage/strategic/rating_matrix/risks_opportunities', $data);
				}else{
					redirect('Welcome');
				}
		}
		public function risks_opportunities_read($id = NULL)
		{
				$consultant_id  = $this->session->userdata('consultant_id');
				$displayStart = $this->input->post('iDisplayStart');
				$displayLength = $this->input->post('iDisplayLength');
				$search = $this->input->post('sSearch');
				$sortingCols = $this->input->post('iSortingCols');
				$post_type = $this->input->post('type');
				$type = 'strategic';
				if($post_type == 0){
					$type = 'strategic';
				}else if($post_type == 1){
					$type = 'food';
				}else if($post_type == 2){
					$type = 'quality';
				}else if($post_type == 3){
					$type = 'environmental';
				}else if($post_type == 4){
					$type = 'safety';
				}else if($post_type == 5){
					$type = 'taccp';
				}else if($post_type == 6){
					$type = 'vaccp';
				}
				$data = array();
				if (isset($id)) {
						$data['risks_opportunities'] = '';
				} else {
						$filter['del_flag'] = 0;
						if ($displayLength != -1) {
								$filter['start'] = $displayStart;
								$filter['limit'] = $displayLength;
								$filter['search'] = $search;
						}
						$order = array();
						for ($i = 0; $i < $sortingCols; $i++) {
								$sortCol = $this->input->post('iSortCol_' . $i);
								$sortDir = $this->input->post('sSortDir_' . $i);
								$dataProp = $this->input->post('mDataProp_' . $sortCol);
								$order[$dataProp] = $sortDir;
						}
						$sql = "SELECT likelihood.* FROM likelihood
												WHERE
														company_id = " . $consultant_id . " and del_flag = 0 and type like '".$type."'";
						$data['iTotalRecords'] = count($this->db->query($sql)->result());
						if ($search != ''){
								$sql .= " and (name like '%".$search."%' OR risk like '%".$search."%' OR opportunity like '%".$search."%')";
						}
						$data['iTotalDisplayRecords'] = count($this->db->query($sql)->result());
						$sql .= " ORDER BY reg_date";
						$count = 0;
						foreach ($order as $key => $val) {
								$sql .= ", ";
								$sql .= $key." ".$val;
								$count = $count + 1;
						}
						$sql .= " limit ".$displayStart.", ".$displayLength;
						$data['risks_opportunities'] = $this->db->query($sql)->result();
						$data['sEcho'] = $search;
				}
				$this->render_json($data);
		}
		public function risks_opportunities_save()
		{
			$data = $this->input->post(NULL, TRUE);
			$type = $this->input->post('type');
			if($type == 0){
				$config = array(
						array(
								 'field'   => 'name',
								 'label'   => 'Name',
								 'rules'   => 'trim|required'
						),
						array(
								 'field'   => 'risk',
								 'label'   => 'Risk',
								 'rules'   => 'required'
						),
						array(
								 'field'   => 'opportunity',
								 'label'   => 'Opportunity',
								 'rules'   => 'required'
						)
				);
			}else{
				$config = array(
						array(
								 'field'   => 'name',
								 'label'   => 'Rating',
								 'rules'   => 'trim|required'
						),
						array(
								 'field'   => 'risk',
								 'label'   => 'Cause',
								 'rules'   => 'required'
						)
				);
			}
			$this->form_validation->set_rules($config);
			if($type == 0){
				$data['type'] = 'strategic';
			}else if($type == 1){
				$data['type'] = 'food';
			}else if($type == 2){
				$data['type'] = 'quality';
			}else if($type == 3){
				$data['type'] = 'environmental';
			}else if($type == 4){
				$data['type'] = 'safety';
			}else if($type == 5){
				$data['type'] = 'taccp';
			}else if($type == 6){
				$data['type'] = 'vaccp';
			}
			if ($this->form_validation->run() == TRUE)
			{
				if(!empty($data['id'])) {
						$this->db->where('id', $data['id']);
						$result = $this->db->update('likelihood',$data);
				} else{
						$consultant_id  = $this->session->userdata('consultant_id');
						$data['company_id'] = $consultant_id;
						$this->db->set('reg_date','now()',FALSE);
						$result = $this->db->insert('likelihood',$data);
				}
				if ($result > 0){
						$this->render_json(array('success'=>TRUE));
				}else{
						$this->render_json(array('success'=>FALSE));
				}
			}else{
				$this->render_json(array('success'=>FALSE, 'message'=>strip_tags(validation_errors())));
			}
		}
		public function risks_opportunities_delete()
		{
			$id = $this->input->post('ids', TRUE);
			$this->db->where('id', $id);
			$result = $this->db->update('likelihood', array('del_flag'=>'1'));
			echo json_encode(array('success'=>$result));
		}
//impact
		public function impact()
		{
				$data['cc1'] = 'active';
				$data['c6'] = 'active';
				$data['c61'] = 'active';
				$data['c612'] = 'act1';
				$consultant_id = $this->session->userdata('consultant_id');
				if($consultant_id){
					$data['title'] = "Impact";
					$sql1 = "select * from risk_value where type = 0 and del_flag = 0 and company_id = ".$consultant_id." order by start";
					$data['risk_values'] = $this->db->query($sql1)->result();
					$this->load->view('consultant/manage/strategic/rating_matrix/impact', $data);
				}else{
					redirect('Welcome');
				}
		}
		public function impact_read($id = NULL)
		{
				$consultant_id  = $this->session->userdata('consultant_id');
				$displayStart = $this->input->post('iDisplayStart');
				$displayLength = $this->input->post('iDisplayLength');
				$search = $this->input->post('sSearch');
				$sortingCols = $this->input->post('iSortingCols');
				$post_type = $this->input->post('type');
				$type = 'strategic';
				if($post_type == 0){
					$type = 'strategic';
				}else if($post_type == 1){
					$type = 'food';
				}else if($post_type == 2){
					$type = 'quality';
				}else if($post_type == 3){
					$type = 'environmental';
				}else if($post_type == 4){
					$type = 'safety';
				}else if($post_type == 5){
					$type = 'taccp';
				}else if($post_type == 6){
					$type = 'vaccp';
				}
				$data = array();
				if (isset($id)) {
						$data['impact'] = '';
				} else {
						$filter['del_flag'] = 0;
						if ($displayLength != -1) {
								$filter['start'] = $displayStart;
								$filter['limit'] = $displayLength;
								$filter['search'] = $search;
						}
						$order = array();
						for ($i = 0; $i < $sortingCols; $i++) {
								$sortCol = $this->input->post('iSortCol_' . $i);
								$sortDir = $this->input->post('sSortDir_' . $i);
								$dataProp = $this->input->post('mDataProp_' . $sortCol);
								$order[$dataProp] = $sortDir;
						}
						$sql = "SELECT consequence.* FROM consequence
												WHERE
														company_id = " . $consultant_id . " and del_flag = 0 and type like '".$type."'";
						$data['iTotalRecords'] = count($this->db->query($sql)->result());
						if ($search != ''){
								$sql .= " and (name like '%".$search."%' OR risk like '%".$search."%' OR opportunity like '%".$search."%')";
						}
						$data['iTotalDisplayRecords'] = count($this->db->query($sql)->result());
						$sql .= " ORDER BY reg_date";
						$count = 0;
						foreach ($order as $key => $val) {
								$sql .= ", ";
								$sql .= $key." ".$val;
								$count = $count + 1;
						}
						$sql .= " limit ".$displayStart.", ".$displayLength;
						$data['impact'] = $this->db->query($sql)->result();
						unset($filter['search']);
						$data['sEcho'] = $search;
						$sql1 = "select * from risk_value where type = 0 and del_flag = 0 and company_id = ".$consultant_id." order by start";
						$data['risk_values'] = $this->db->query($sql1)->result();
				}
				$this->render_json($data);
		}
		public function impact_save()
		{
			$data = $this->input->post(NULL, TRUE);
			$type = $this->input->post('type');
			if($type == 0){
				$config = array(
						array(
								 'field'   => 'name',
								 'label'   => 'Name',
								 'rules'   => 'trim|required'
						),
						array(
								 'field'   => 'risk',
								 'label'   => 'Risk',
								 'rules'   => 'required'
						),
						array(
								 'field'   => 'opportunity',
								 'label'   => 'Opportunity',
								 'rules'   => 'required'
						)
				);
			}else{
				$config = array(
						array(
								 'field'   => 'name',
								 'label'   => 'Rating',
								 'rules'   => 'trim|required'
						),
						array(
								 'field'   => 'risk',
								 'label'   => 'Cause',
								 'rules'   => 'required'
						)
				);
			}
			$this->form_validation->set_rules($config);
			if($type == 0){
				$data['type'] = 'strategic';
			}else if($type == 1){
				$data['type'] = 'food';
			}else if($type == 2){
				$data['type'] = 'quality';
			}else if($type == 3){
				$data['type'] = 'environmental';
			}else if($type == 4){
				$data['type'] = 'safety';
			}else if($type == 5){
				$data['type'] = 'taccp';
			}else if($type == 6){
				$data['type'] = 'vaccp';
			}
			if ($this->form_validation->run() == TRUE)
			{
				if(!empty($data['id'])) {
						$this->db->where('id', $data['id']);
						$result = $this->db->update('consequence',$data);
				} else{
						$consultant_id  = $this->session->userdata('consultant_id');
						$data['company_id'] = $consultant_id;
						$this->db->set('reg_date','now()',FALSE);
						$result = $this->db->insert('consequence',$data);
				}
				if ($result > 0){
						$this->render_json(array('success'=>TRUE));
				}else{
						$this->render_json(array('success'=>FALSE));
				}
			}else{
				$this->render_json(array('success'=>FALSE, 'message'=>strip_tags(validation_errors())));
			}
		}
		public function impact_delete()
		{
			$id = $this->input->post('ids', TRUE);
			$this->db->where('id', $id);
			$result = $this->db->update('consequence', array('del_flag'=>'1'));
			echo json_encode(array('success'=>$result));
		}
//operational_risk_values
		public function operational_risk_values()
		{
			$data['cc1'] = 'active';
			$data['c7'] = 'active';
			$data['c77'] = 'act1';
			$consultant_id = $this->session->userdata('consultant_id');
			if($consultant_id){
				$data['title'] = "Risk Values";
				$data['type'] = 1;
				$this->load->view('consultant/manage/strategic/rating_matrix/risk_values', $data);
			}else{
				redirect('Welcome');
			}
		}
//risk_values
		public function risk_values()
		{
				$data['cc1'] = 'active';
				$data['c6'] = 'active';
				$data['c61'] = 'active';
				$data['c613'] = 'act1';
				$consultant_id = $this->session->userdata('consultant_id');
				if($consultant_id){
					$data['title'] = "Risk Values";
					$data['type'] = 0;
					$this->load->view('consultant/manage/strategic/rating_matrix/risk_values', $data);
				}else{
					redirect('Welcome');
				}
		}
		public function risk_values_read($id = NULL)
		{
				$consultant_id  = $this->session->userdata('consultant_id');
				$displayStart = $this->input->post('iDisplayStart');
				$displayLength = $this->input->post('iDisplayLength');
				$search = $this->input->post('sSearch');
				$sortingCols = $this->input->post('iSortingCols');
				$type = $this->input->post('type');
				$data = array();
				if (isset($id)) {
						$data['risk_values'] = '';
				} else {
						$filter['del_flag'] = 0;
						if ($displayLength != -1) {
								$filter['start'] = $displayStart;
								$filter['limit'] = $displayLength;
								$filter['search'] = $search;
						}
						$order = array();
						for ($i = 0; $i < $sortingCols; $i++) {
								$sortCol = $this->input->post('iSortCol_' . $i);
								$sortDir = $this->input->post('sSortDir_' . $i);
								$dataProp = $this->input->post('mDataProp_' . $sortCol);
								$order[$dataProp] = $sortDir;
						}
						$sql = "SELECT risk_value.* FROM risk_value
												WHERE
														company_id = " . $consultant_id . " and del_flag = 0";
						if ($type == "0"){
							$sql .= " and type = ".$type;
						}else{
							$sql .= " and type != 0";
						}
						$data['iTotalRecords'] = count($this->db->query($sql)->result());
						if ($search != ''){
								$sql .= " and (name like '%".$search."%' OR risk like '%".$search."%' OR opportunity like '%".$search."%')";
						}
						$data['iTotalDisplayRecords'] = count($this->db->query($sql)->result());
						$sql .= " limit ".$displayStart.", ".$displayLength;
						$data['risk_values'] = $this->db->query($sql)->result();
						$data['sEcho'] = $search;
				}
				$this->render_json($data);
		}
		public function risk_values_save()
		{
			$data = $this->input->post(NULL, TRUE);
			$config = array(
					array(
							 'field'   => 'level',
							 'label'   => 'Level',
							 'rules'   => 'trim|required'
					),
					array(
							 'field'   => 'start',
							 'label'   => 'Start Value',
							 'rules'   => 'required'
					),
					array(
							 'field'   => 'end',
							 'label'   => 'End Value',
							 'rules'   => 'required'
					)
			);
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == TRUE)
			{
				if(!empty($data['id'])) {
						$this->db->where('id', $data['id']);
						$result = $this->db->update('risk_value',$data);
				} else{
						$consultant_id  = $this->session->userdata('consultant_id');
						$data['company_id'] = $consultant_id;
						$result = $this->db->insert('risk_value',$data);
				}
				if ($result > 0){
						$this->render_json(array('success'=>TRUE));
				}else{
						$this->render_json(array('success'=>FALSE));
				}
			}else{
				$this->render_json(array('success'=>FALSE, 'message'=>strip_tags(validation_errors())));
			}
		}
		public function risk_values_delete()
		{
			$id = $this->input->post('ids', TRUE);
			$this->db->where('id', $id);
			$result = $this->db->update('risk_value', array('del_flag'=>'1'));
			echo json_encode(array('success'=>$result));
		}
		//**************************************************************************//
    public function risk_list()
    {
		$this->session->set_userdata("sidebar_history","-1");
        $data['aa1'] = 'active';
        $data['a1']  = 'act1';
        $consultant_id  = $this->session->userdata('consultant_id');
		$data['user_type'] = $this->session->userdata('user_type');

        if ($consultant_id) {
            $data['title'] = "Potential Hazard List";
            $this->load->view('consultant/risk_list', $data);
        } else {
            redirect('Welcome');
        }
    }
    public function risk_read($id = NULL)
    {
        $consultant_id  = $this->session->userdata('consultant_id');

        $displayStart = $this->input->post('iDisplayStart');
        $displayLength = $this->input->post('iDisplayLength');
        $search = $this->input->post('sSearch');
        $sortingCols = $this->input->post('iSortingCols');
        $status = $this->input->post('status');
        $type = $this->input->post('type');

        $data = array();
        if (isset($id)) {
            $data['risk'] = '';
        } else {
            $filter['del_flag'] = 0;
            if ($displayLength != -1) {
                $filter['start'] = $displayStart;
                $filter['limit'] = $displayLength;
                $filter['search'] = $search;
            }
            $order = array();
            for ($i = 0; $i < $sortingCols; $i++) {
                $sortCol = $this->input->post('iSortCol_' . $i);
                $sortDir = $this->input->post('sSortDir_' . $i);
                $dataProp = $this->input->post('mDataProp_' . $sortCol);

                $order[$dataProp] = $sortDir;
            }

            $sql = "SELECT risk.* FROM risk
                        WHERE
                            company_id = " . $consultant_id . " and del_flag = 0";
            if ($status != '-1'){
                $sql .= " and status = ".$status;
            }
            if ($type != '-1'){
                $sql .= " and risk_type = ".$type;
            }
            if ($search != ''){
                $sql .= " and (name like '%".$search."%' OR description like '%".$search."%')";
            }
            $sql .= " ORDER BY reg_date DESC";
			$data['risks'] = $this->db->query($sql)->result();
			$data['iTotalDisplayRecords'] = count($data['risks']);
			unset($filter['search']);
			$data['iTotalRecords'] = count($data['risks']);
			if ($displayLength != -1) {
				$sql .= " limit ".$displayStart.",".$displayLength;
			}
			$data['risks'] = $this->db->query($sql)->result();
            $data['sEcho'] = $search;
        }
        $this->render_json($data);
    }
    public function add_risk()
    {
        $consultant_id  = $this->session->userdata('consultant_id');
        $checked = $this->input->post("assess_type");
        $data['risk_type'] = $this->input->post("risk_type");
        $data['type_flag'] = $this->input->post("type_flag");
        $data['name'] = $this->input->post("name");
        $data['description'] = $this->input->post("description");
        $data['detail'] = $this->input->post("detail");
		if (empty($data['type_flag'])){
			$data['type_flag'] = 0;
		}
        $data['assess_type'] = substr($checked,1,strlen($checked)-1);
        $data['company_id'] = $consultant_id;

        $this->db->set('reg_date','now()',FALSE);
        $this->db->insert('risk', $data);
        $insert_id = $this->db->insert_id();
        echo json_encode(array('id'=>$insert_id));
    }
    public function edit_risk()
    {
        $data['name'] = $this->input->post("name");
        $data['description'] = $this->input->post("description");
		$data['detail'] = $this->input->post("detail");
        $id = $this->input->post("id");
        $this->db->where('id', $id);
        $result = $this->db->update('risk', $data);
        if ($result > 0){
            echo "success";
        }else{
            echo "failed";
        }
    }
    //delete
    public function risk_delete() {
        $id = $this->input->post('ids', TRUE);
        $this->db->where('id', $id);
        $result = $this->db->update('risk', array('del_flag'=>'1'));
        echo json_encode(array('success'=>$result));
    }
	public function risk_close() {
		$id = $this->input->post('ids', TRUE);
		$this->db->where('id', $id);
		$result = $this->db->update('risk', array('status'=>'1'));
		echo json_encode(array('success'=>$result));
	}
    public function rating_matrix($id = Null)
    {
        $data['aa1'] = 'active';
        $data['a1']  = 'act1';
        $data['title'] = "Rating Matrix";
        $consultant_id = $this->session->userdata('consultant_id');
		$data['user_type'] = $this->session->userdata('user_type');
		$data['risk_id'] = $id;
        if ($consultant_id) {
            $data['id'] = $id;
            $this->db->where('id', $id);
            $temp = $this->db->get('risk')->row();
            if ($temp->risk_type == 0){
				if ($data['user_type'] == "consultant"){
					$this->load->view('consultant/strategic_rating', $data);
				}else{
					redirect('consultant/strategic_process/'.$id);
				}
            }else if ($temp->risk_type == 1){
                $sql = "select * from risk where id = ".$data['id'];
                $type = @$this->db->query($sql)->row()->assess_type;
                $data['assess_type'] = explode(",",$type);
				if ($data['user_type'] == "consultant"){
					$this->load->view('consultant/operational_rating', $data);
				}else{
					redirect('consultant/operational_process/'.$id);
				}

            }else{
				$this->db->where('id', $id);
				$risk_type = $this->db->get('risk')->row()->risk_type;
				if ($risk_type == 2){
					$data['title'] = "PRP Processes";
				}else{
					$data['title'] = "FSSC Additional Requirements Processes";
				}
				$this->db->where('company_id', $consultant_id);
                $this->db->where('del_flag', 0);
				if ($risk_type == 2){
					$data['processes'] = $this->db->get('manage_pre_process')->result();
				}else{
					$data['processes'] = $this->db->get('manage_additional_process')->result();
				}
				$this->db->where('consultant_id', $consultant_id);
				$data['employees'] = $this->db->get('employees')->result();
				$this->load->view('consultant/other_process', $data);
			}
        } else {
            redirect('Welcome');
        }
    }
    public function rating_matrix_list(){
        $id = $this->input->post('id', TRUE);
        $type = $this->input->post('type', TRUE);
        $data['type'] = $type;
        $consultant_id  = $this->session->userdata('consultant_id');

        if ($type == "strategic"){
            $sql = "select * from likelihood where type = '".$type."' and del_flag = 0 and company_id = ".$consultant_id." order by reg_date";
            $data['likelihood'] = $this->db->query($sql)->result();
            $sql = "select * from consequence where type = '".$type."' and del_flag = 0 and company_id = ".$consultant_id." order by reg_date";
            $data['consequence'] = $this->db->query($sql)->result();
            $sql = "select * from rating_matrix where type = '".$type."' and risk_id = ".$id;
            $data['values'] = $this->db->query($sql)->result();
			if (count($data['values']) == 0){
				$sql = "select * from manage_rating_matrix where type = '".$type."' and company_id = ".$consultant_id;
				$temp = $this->db->query($sql)->result();
				foreach ($temp as $row){
					$this->db->insert('rating_matrix', array('risk_id'=>$id,'type'=>$type,'like_id'=>$row->like_id,'conse_id'=>$row->conse_id,'value'=>$row->value));
				}
				$sql = "select * from rating_matrix where type = '".$type."' and risk_id = ".$id;
				$data['values'] = $this->db->query($sql)->result();
			}
            $sql = "select * from risk_value where type = 0 and del_flag = 0 and company_id = ".$consultant_id." order by start";
            $data['risk_values'] = $this->db->query($sql)->result();
            $this->load->view('consultant/rating_detail', $data);
        }else{
            $sql = "select * from likelihood where type = '".$type."' and del_flag = 0 and company_id = ".$consultant_id." order by reg_date";
            $data['likelihood'] = $this->db->query($sql)->result();
            $sql = "select * from consequence where type = '".$type."' and del_flag = 0 and company_id = ".$consultant_id." order by reg_date";
            $data['consequence'] = $this->db->query($sql)->result();
            $sql = "select * from rating_matrix where type = '".$type."' and risk_id = ".$id;
            $data['values'] = $this->db->query($sql)->result();
			if (count($data['values']) == 0){
				$sql = "select * from manage_rating_matrix where type = '".$type."' and company_id = ".$consultant_id;
				$temp = $this->db->query($sql)->result();
				foreach ($temp as $row){
					$this->db->insert('rating_matrix', array('risk_id'=>$id,'type'=>$type,'like_id'=>$row->like_id,'conse_id'=>$row->conse_id,'value'=>$row->value));
				}
				$sql = "select * from rating_matrix where type = '".$type."' and risk_id = ".$id;
				$data['values'] = $this->db->query($sql)->result();
			}
			switch ($type){
				case "Food":
					$type = 1;
					break;
				case "Quality":
					$type = 2;
					break;
				case "Environmental":
					$type = 3;
					break;
				case "Safety":
					$type = 4;
					break;
				case "TACCP":
					$type = 5;
					break;
				case "VACCP":
					$type = 6;
					break;
			}
            $sql = "select * from risk_value where type = ".$type." and del_flag = 0 and company_id = ".$consultant_id." order by start";
            $data['risk_values'] = $this->db->query($sql)->result();
            $this->load->view('consultant/rating_detail', $data);
        }
    }
    public function edit_rating() {
        $consultant_id  = $this->session->userdata('consultant_id');
        $id = $this->input->post('id', TRUE);
        $type = $this->input->post('type', TRUE);
        $name = $this->input->post('name', TRUE);

        if ($id != 0 && $type == 0){
            $this->db->where('id', $id);
            $result = $this->db->update('likelihood', array('name'=>$name));
        }else if ($id != 0 && $type == 1){
            $this->db->where('id', $id);
            $result = $this->db->update('consequence', array('name'=>$name));
        }else if ($id == 0){
            if ($this->input->post('flag', TRUE) == 0){
                $this->db->set('reg_date','now()',FALSE);
                $result = $this->db->insert('likelihood', array('name'=>$name,'type'=>$type,'company_id'=>$consultant_id));
            }else{
                $this->db->set('reg_date','now()',FALSE);
                $result = $this->db->insert('consequence', array('name'=>$name,'type'=>$type,'company_id'=>$consultant_id));
            }
        }
        echo json_encode(array('success'=>$result));
    }
    public function delete_rating() {
        $id = $this->input->post('id', TRUE);
        $type = $this->input->post('type', TRUE);
        $this->db->where('id', $id);
        if ($id != 0 && $type == 0){
            $result = $this->db->update('likelihood', array('del_flag'=>'1'));
        }else if ($id != 0 && $type == 1){
            $result = $this->db->update('consequence', array('del_flag'=>'1'));
        }
        echo json_encode(array('success'=>$result));
    }
    public function edit_rating_value() {
        $id = $this->input->post('id', TRUE);
        $type = $this->input->post('type', TRUE);
        $risk_id = $this->input->post('risk_id', TRUE);
        $like_id = $this->input->post('like_id', TRUE);
        $conse_id = $this->input->post('conse_id', TRUE);
        $value = $this->input->post('value', TRUE);

        if ($id != 0){
            $this->db->where('id', $id);
            $result = $this->db->update('rating_matrix', array('value'=>$value));
        }else if ($id == 0){
            $result = $this->db->insert('rating_matrix', array('risk_id'=>$risk_id,'type'=>$type,'like_id'=>$like_id,'conse_id'=>$conse_id,'value'=>$value));
        }
        echo json_encode(array('success'=>$result));
    }
    public function strategic_process($id = NULL)
    {
        $data['aa1'] = 'active';
        $data['a1']  = 'act1';
        $data['risk_id']  = $id;
        $consultant_id  = $this->session->userdata('consultant_id');
        $user_type  = $this->session->userdata('user_type');
		$data['user_type'] = $user_type;

        if ($consultant_id) {

            $sql = "select * from risk where id = ".$id;
            $type = @$this->db->query($sql)->row()->assess_type;
			$type_flag = @$this->db->query($sql)->row()->type_flag;
			$data['type_flag'] = $type_flag;
			if ($type_flag == 0){
				$data['title'] = "Internal and External Issues";
			}else{
				$data['title'] = "Needs and expectation of interested Parties";
			}
            $data['assess_type'] = explode(",",$type);
            $sql = "select process.*,employees.employee_name process_owner_name from process left join employees on process.process_owner = employees.employee_id where process.risk_id = ".$id." and process.del_flag = 0 and process.flag = 'swot'";
			if ($user_type == "process_owner"){
				$sql .= " and process.process_owner = ".$this->session->userdata('employee_id');
			}
            $data['swots'] = $this->db->query($sql)->result();
//			foreach ($data['swots'] as $item){
//				$this->db->where('type', 'strategic');
//				$this->db->where('risk_id', $data['risk_id']);
//				$tmp_value =  @$this->db->get('rating_matrix')->row();
//				if (count($tmp_value) > 0){
//					$tmp_data['food_like'] = $tmp_value->like_id;
//					$tmp_data['food_conse'] = $tmp_value->conse_id;
//					$tmp_data['food_value'] = $tmp_value->value;
//					$tmp_data['environmental_like'] = $tmp_value->like_id;
//					$tmp_data['environmental_conse'] = $tmp_value->conse_id;
//					$tmp_data['environmental_value'] = $tmp_value->value;
//					$tmp_data['taccp_like'] = $tmp_value->like_id;
//					$tmp_data['taccp_conse'] = $tmp_value->conse_id;
//					$tmp_data['taccp_value'] = $tmp_value->value;
//					$tmp_data['quality_like'] = $tmp_value->like_id;
//					$tmp_data['quality_conse'] = $tmp_value->conse_id;
//					$tmp_data['quality_value'] = $tmp_value->value;
//					$tmp_data['safety_like'] = $tmp_value->like_id;
//					$tmp_data['safety_conse'] = $tmp_value->conse_id;
//					$tmp_data['safety_value'] = $tmp_value->value;
//					$tmp_data['vaccp_like'] = $tmp_value->like_id;
//					$tmp_data['vaccp_conse'] = $tmp_value->conse_id;
//					$tmp_data['vaccp_value'] = $tmp_value->value;
//				}
//				$this->db->where('process_id', $item->id);
//				$this->db->update('process_risk_rating', $tmp_data);
//				$sql = "select risk.* from risk left join process on process.risk_id = risk.id where process.id = ".$item->id;
//				$tmp_type = @$this->db->query($sql)->row()->assess_type;
//				$assess_type = explode(",",$tmp_type);
//				foreach ($assess_type as $row){
//					$sql = "select IF (
//								(select ".strtolower($row)."_value from process_risk_rating where process_id = ".$item->id.")
//									>= a. START && (select ".strtolower($row)."_value from process_risk_rating where process_id = ".$item->id.")
//									<= a.END,a. LEVEL,NULL) name
//							FROM
//								risk_value a where company_id = ".$consultant_id." and type = 0 having name is not NULL";
//					$temp_value = $this->db->query($sql)->row();
//					if (count($temp_value) > 0){
//						$sql = "update process_risk_rating set ".strtolower($row)."_value = '".$temp_value->name."' where process_id = ".$item->id;
//						$this->db->query($sql);
//					}
//				}
//			}
            $sql = "select process.*,employees.employee_name process_owner_name from process left join employees on process.process_owner = employees.employee_id where process.risk_id = ".$id." and process.del_flag = 0 and process.flag = 'steep'";
			if ($user_type == "process_owner"){
				$sql .= " and process.process_owner = ".$this->session->userdata('employee_id');
			}
			$data['steeps'] = $this->db->query($sql)->result();
//			foreach ($data['steeps'] as $item){
//				$this->db->where('type', 'strategic');
//				$this->db->where('risk_id', $data['risk_id']);
//				$tmp_value =  @$this->db->get('rating_matrix')->row();
//				if (count($tmp_value) > 0){
//					$tmp_data['food_like'] = $tmp_value->like_id;
//					$tmp_data['food_conse'] = $tmp_value->conse_id;
//					$tmp_data['food_value'] = $tmp_value->value;
//					$tmp_data['environmental_like'] = $tmp_value->like_id;
//					$tmp_data['environmental_conse'] = $tmp_value->conse_id;
//					$tmp_data['environmental_value'] = $tmp_value->value;
//					$tmp_data['taccp_like'] = $tmp_value->like_id;
//					$tmp_data['taccp_conse'] = $tmp_value->conse_id;
//					$tmp_data['taccp_value'] = $tmp_value->value;
//					$tmp_data['quality_like'] = $tmp_value->like_id;
//					$tmp_data['quality_conse'] = $tmp_value->conse_id;
//					$tmp_data['quality_value'] = $tmp_value->value;
//					$tmp_data['safety_like'] = $tmp_value->like_id;
//					$tmp_data['safety_conse'] = $tmp_value->conse_id;
//					$tmp_data['safety_value'] = $tmp_value->value;
//					$tmp_data['vaccp_like'] = $tmp_value->like_id;
//					$tmp_data['vaccp_conse'] = $tmp_value->conse_id;
//					$tmp_data['vaccp_value'] = $tmp_value->value;
//				}
//				$sql = "select risk.* from risk left join process on process.risk_id = risk.id where process.id = ".$item->id;
//				$tmp_type = @$this->db->query($sql)->row()->assess_type;
//				$assess_type = explode(",",$tmp_type);
//				foreach ($assess_type as $row){
//					$sql = "select IF (
//								(select ".strtolower($row)."_value from process_risk_rating where process_id = ".$item->id.")
//									>= a. START && (select ".strtolower($row)."_value from process_risk_rating where process_id = ".$item->id.")
//									<= a.END,a. LEVEL,NULL) name
//							FROM
//								risk_value a where company_id = ".$consultant_id." and type = 0 having name is not NULL";
//					$temp_value = $this->db->query($sql)->row();
//					if (count($temp_value) > 0){
//						$sql = "update process_risk_rating set ".strtolower($row)."_value = '".$temp_value->name."' where process_id = ".$item->id;
//						$this->db->query($sql);
//					}
//				}
//			}
            $sql = "select process.*,employees.employee_name process_owner_name from process left join employees on process.process_owner = employees.employee_id where process.risk_id = ".$id." and process.del_flag = 0 and process.flag = 'needs'";
			if ($user_type == "process_owner"){
				$sql .= " and process.process_owner = ".$this->session->userdata('employee_id');
			}
			$data['needs'] = $this->db->query($sql)->result();
//			foreach ($data['needs'] as $item){
//				$this->db->where('type', 'strategic');
//				$this->db->where('risk_id', $data['risk_id']);
//				$tmp_value =  @$this->db->get('rating_matrix')->row();
//				if (count($tmp_value) > 0){
//					$tmp_data['food_like'] = $tmp_value->like_id;
//					$tmp_data['food_conse'] = $tmp_value->conse_id;
//					$tmp_data['food_value'] = $tmp_value->value;
//					$tmp_data['environmental_like'] = $tmp_value->like_id;
//					$tmp_data['environmental_conse'] = $tmp_value->conse_id;
//					$tmp_data['environmental_value'] = $tmp_value->value;
//					$tmp_data['taccp_like'] = $tmp_value->like_id;
//					$tmp_data['taccp_conse'] = $tmp_value->conse_id;
//					$tmp_data['taccp_value'] = $tmp_value->value;
//					$tmp_data['quality_like'] = $tmp_value->like_id;
//					$tmp_data['quality_conse'] = $tmp_value->conse_id;
//					$tmp_data['quality_value'] = $tmp_value->value;
//					$tmp_data['safety_like'] = $tmp_value->like_id;
//					$tmp_data['safety_conse'] = $tmp_value->conse_id;
//					$tmp_data['safety_value'] = $tmp_value->value;
//					$tmp_data['vaccp_like'] = $tmp_value->like_id;
//					$tmp_data['vaccp_conse'] = $tmp_value->conse_id;
//					$tmp_data['vaccp_value'] = $tmp_value->value;
//				}
//				$sql = "select risk.* from risk left join process on process.risk_id = risk.id where process.id = ".$item->id;
//				$tmp_type = @$this->db->query($sql)->row()->assess_type;
//				$assess_type = explode(",",$tmp_type);
//				foreach ($assess_type as $row){
//					$sql = "select IF (
//								(select ".strtolower($row)."_value from process_risk_rating where process_id = ".$item->id.")
//									>= a. START && (select ".strtolower($row)."_value from process_risk_rating where process_id = ".$item->id.")
//									<= a.END,a. LEVEL,NULL) name
//							FROM
//								risk_value a where company_id = ".$consultant_id." and type = 0 having name is not NULL";
//					$temp_value = $this->db->query($sql)->row();
//					if (count($temp_value) > 0){
//						$sql = "update process_risk_rating set ".strtolower($row)."_value = '".$temp_value->name."' where process_id = ".$item->id;
//						$this->db->query($sql);
//					}
//				}
//			}
            $sql = "select * from swot_type where company_id = ".$consultant_id;
            $data['swot_type'] = $this->db->query($sql)->result();
            $sql = "select * from steep_type where company_id = ".$consultant_id;
            $data['steep_type'] = $this->db->query($sql)->result();
            $sql = "select * from needs_type where company_id = ".$consultant_id;
            $data['needs_type'] = $this->db->query($sql)->result();
            $sql = "select * from employees where consultant_id = ".$consultant_id;
            $data['employees'] = $this->db->query($sql)->result();
            $sql = "select a.* from process_risk_rating a left join process b on a.process_id = b.id where b.risk_id = ".$id;
            $data['ratings'] = $this->db->query($sql)->result();
            $sql = "select * from likelihood where company_id = ".$consultant_id." and type = 'strategic' and del_flag = 0 order by reg_date";
            $data['likelihood'] = $this->db->query($sql)->result();
            $sql = "select * from consequence where company_id = ".$consultant_id." and type = 'strategic' and del_flag = 0 order by reg_date";
            $data['consequence'] = $this->db->query($sql)->result();
            $data['swot_id'] = @$this->db->get('swot_type')->row()->name;
            $data['steep_id'] = @$this->db->get('steep_type')->row()->name;
            $data['needs_id'] = @$this->db->get('needs_type')->row()->name;

            $this->db->where('id', $id);
            $temp = $this->db->get('risk')->row();
            if ($temp->type_flag == 0){
                $this->load->view('consultant/strategic_process', $data);
            }else{
                $this->load->view('consultant/strategic_process_needs', $data);
            }
        } else {
            redirect('Welcome');
        }
    }
    public function add_swot_type()
    {
        $consultant_id = $this->session->userdata('consultant_id');
        $name       = $this->input->post('name');
        $data       = array(
            'name' => $name,
            'company_id' => $consultant_id
        );
        $done       = $this->db->insert('swot_type', $data);
        if ($done) {
            $this->db->where('company_id', $consultant_id);
            $list = $this->db->get('swot_type')->result();
            foreach ($list as $items) {
                echo "<option value='" . $items->name . "'>" . $items->name . "</option>";
            }
        } else {
        }
    }
    public function all_swot_type()
    {
        $swot_id = $this->input->post('name');
        $consultant_id = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $consultant_id);
        $list = $this->db->get('swot_type')->result();
        foreach ($list as $items) {
            if ($swot_id == $items->name){
                echo "<option value='" . $items->name . "' selected>" . $items->name . "</option>";
            }else{
                echo "<option value='" . $items->name . "'>" . $items->name . "</option>";
            }
        }
        if ($swot_id == "-1"){
            echo "<option value='-1' selected>Show All</option>";
        }else{
            echo "<option value='-1'>Show All</option>";
        }
    }
	public function all_edit_swot_type()
{
	$consultant_id = $this->session->userdata('consultant_id');
	$this->db->where('company_id', $consultant_id);
	$list = $this->db->get('swot_type')->result();
	foreach ($list as $items) {
		echo "<option value='" . $items->name . "'>" . $items->name . "</option>";
	}
}
    public function all_swot_type_table()
    {
        $consultant_id = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $consultant_id);
        $list = $this->db->get('swot_type')->result();
        foreach ($list as $items) {
            echo "<tr><td>" . $items->name . "</td><td><a onclick='deleteswot_type(" . $items->id . ");';><i class='icon-trash'></i></a></td><tr>";
        }
    }
    public function delete_swot_type()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('swot_type');
    }
    public function add_steep_type()
    {
        $consultant_id = $this->session->userdata('consultant_id');
        $name       = $this->input->post('name');
        $data       = array(
            'name' => $name,
            'company_id' => $consultant_id
        );
        $done       = $this->db->insert('steep_type', $data);
        if ($done) {
            $this->db->where('company_id', $consultant_id);
            $list = $this->db->get('steep_type')->result();
            foreach ($list as $items) {
                echo "<option value='" . $items->name . "'>" . $items->name . "</option>";
            }
        } else {
        }
    }
    public function all_steep_type()
    {
        $swot_id = $this->input->post('name');
        $consultant_id = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $consultant_id);
        $list = $this->db->get('steep_type')->result();
        foreach ($list as $items) {
            if ($swot_id == $items->name){
                echo "<option value='" . $items->name . "' selected>" . $items->name . "</option>";
            }else{
                echo "<option value='" . $items->name . "'>" . $items->name . "</option>";
            }
        }
        if ($swot_id == "-1"){
            echo "<option value='-1' selected>Show All</option>";
        }else{
            echo "<option value='-1'>Show All</option>";
        }
    }
	public function all_edit_steep_type()
	{
		$consultant_id = $this->session->userdata('consultant_id');
		$this->db->where('company_id', $consultant_id);
		$list = $this->db->get('steep_type')->result();
		foreach ($list as $items) {
			echo "<option value='" . $items->name . "'>" . $items->name . "</option>";
		}
	}
    public function all_steep_type_table()
    {
        $consultant_id = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $consultant_id);
        $list = $this->db->get('steep_type')->result();
        foreach ($list as $items) {
            echo "<tr><td>" . $items->name . "</td><td><a onclick='deletesteep_type(" . $items->id . ");';><i class='icon-trash'></i></a></td><tr>";
        }
    }
    public function delete_steep_type()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('steep_type');
    }
    public function add_needs_type()
    {
        $consultant_id = $this->session->userdata('consultant_id');
        $name       = $this->input->post('name');
        $data       = array(
            'name' => $name,
            'company_id' => $consultant_id
        );
        $done       = $this->db->insert('needs_type', $data);
        if ($done) {
            $this->db->where('company_id', $consultant_id);
            $list = $this->db->get('needs_type')->result();
            foreach ($list as $items) {
                echo "<option value='" . $items->name . "'>" . $items->name . "</option>";
            }
        } else {
        }
    }
    public function all_needs_type()
    {
        $swot_id = $this->input->post('name');
        $consultant_id = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $consultant_id);
        $list = $this->db->get('needs_type')->result();
        foreach ($list as $items) {
            if ($swot_id == $items->name){
                echo "<option value='" . $items->name . "' selected>" . $items->name . "</option>";
            }else{
                echo "<option value='" . $items->name . "'>" . $items->name . "</option>";
            }
        }
        if ($swot_id == "-1"){
            echo "<option value='-1' selected>Show All</option>";
        }else{
            echo "<option value='-1'>Show All</option>";
        }
    }
    public function all_needs_type_table()
    {
        $consultant_id = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $consultant_id);
        $list = $this->db->get('needs_type')->result();
        foreach ($list as $items) {
            echo "<tr><td>" . $items->name . "</td><td><a onclick='deleteneeds_type(" . $items->id . ");';><i class='icon-trash'></i></a></td><tr>";
        }
    }
    public function delete_needs_type()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('needs_type');
    }
    public function add_process_strategic() {
        $consultant_id  = $this->session->userdata('consultant_id');
        $id = $this->input->post('id', TRUE);
        $data['risk_id'] = $this->input->post('risk_id', TRUE);
        $data['flag'] = $this->input->post('flag', TRUE);
        if ($data['flag'] == "swot" || $data['flag'] == "needs"){
            $data['type'] = $this->input->post('edit_swot_type', TRUE);
        }else{
            $data['type'] = $this->input->post('edit_steep_type', TRUE);
        }
        $data['process_owner'] = $this->input->post('process_owner', TRUE);
        $data['name'] = $this->input->post('name', TRUE);
        $data['description'] = $this->input->post('description', TRUE);
        $data['opportunities'] = $this->input->post('opportunities', TRUE);
        $data['potential_hazard'] = $this->input->post('potential_hazard', TRUE);
        $data['Food'] = $this->input->post('Food', TRUE);
        $data['Environmental'] = $this->input->post('Environmental', TRUE);
        $data['TACCP'] = $this->input->post('TACCP', TRUE);
        $data['Quality'] = $this->input->post('Quality', TRUE);
        $data['Safety'] = $this->input->post('Safety', TRUE);
        $data['VACCP'] = $this->input->post('VACCP', TRUE);

        if ($id != 0){
            $this->db->where('id', $id);
            $result = $this->db->update('process', $data);
        }else if ($id == 0){
            $this->db->set('reg_date','now()',FALSE);
            $this->db->insert('process', $data);
			$last_id = $this->db->insert_id();

//			$this->db->where('type', 'strategic');
//			$this->db->where('risk_id', $data['risk_id']);
//			$tmp_value =  @$this->db->get('rating_matrix')->row();
//			if (count($tmp_value) > 0){
//				$tmp_data['food_like'] = $tmp_value->like_id;
//				$tmp_data['food_conse'] = $tmp_value->conse_id;
//				$tmp_data['food_value'] = $tmp_value->value;
//				$tmp_data['environmental_like'] = $tmp_value->like_id;
//				$tmp_data['environmental_conse'] = $tmp_value->conse_id;
//				$tmp_data['environmental_value'] = $tmp_value->value;
//				$tmp_data['taccp_like'] = $tmp_value->like_id;
//				$tmp_data['taccp_conse'] = $tmp_value->conse_id;
//				$tmp_data['taccp_value'] = $tmp_value->value;
//				$tmp_data['quality_like'] = $tmp_value->like_id;
//				$tmp_data['quality_conse'] = $tmp_value->conse_id;
//				$tmp_data['quality_value'] = $tmp_value->value;
//				$tmp_data['safety_like'] = $tmp_value->like_id;
//				$tmp_data['safety_conse'] = $tmp_value->conse_id;
//				$tmp_data['safety_value'] = $tmp_value->value;
//				$tmp_data['vaccp_like'] = $tmp_value->like_id;
//				$tmp_data['vaccp_conse'] = $tmp_value->conse_id;
//				$tmp_data['vaccp_value'] = $tmp_value->value;
//			}
//			$tmp_data['process_id'] = $last_id;
//			$this->db->insert('process_risk_rating', $tmp_data);
//			$sql = "select risk.* from risk left join process on process.risk_id = risk.id where process.id = ".$last_id;
//			$tmp_type = @$this->db->query($sql)->row()->assess_type;
//			$assess_type = explode(",",$tmp_type);
//			foreach ($assess_type as $row){
//				$sql = "select IF (
//								(select ".strtolower($row)."_value from process_risk_rating where process_id = ".$last_id.")
//									>= a. START && (select ".strtolower($row)."_value from process_risk_rating where process_id = ".$last_id.")
//									<= a.END,a. LEVEL,NULL) name
//							FROM
//								risk_value a where company_id = ".$consultant_id." and type = 0 having name is not NULL";
//				$temp_value = $this->db->query($sql)->row();
//				if (count($temp_value) > 0){
//					$sql = "update process_risk_rating set ".strtolower($row)."_value = '".$temp_value->name."' where process_id = ".$last_id;
//					$this->db->query($sql);
//				}
//			}
        }
		$data["user_type"]  = $this->session->userdata('user_type');
        redirect("Consultant/strategic_process/".$data['risk_id']);
    }
    public function change_process_rating() {
        $id = $this->input->post('id', TRUE);
        $type = $this->input->post('type', TRUE);
        $flag = $this->input->post('flag', TRUE);
        $value = $this->input->post('value', TRUE);

        $this->db->where('process_id', $id);
        $temp = $this->db->get('process_risk_rating')->row();
		if ($flag == "like"){
			switch ($type){
				case 'Food':
					$data['food_like'] = $value;
					break;
				case 'Environmental':
					$data['environmental_like'] = $value;
					break;
				case 'TACCP':
					$data['taccp_like'] = $value;
					break;
				case 'Quality':
					$data['quality_like'] = $value;
					break;
				case 'Safety':
					$data['safety_like'] = $value;
					break;
				case 'VACCP':
					$data['vaccp_like'] = $value;
					break;
			}
		}else if ($flag == "conse"){
			switch ($type){
				case 'Food':
					$data['food_conse'] = $value;
					break;
				case 'Environmental':
					$data['environmental_conse'] = $value;
					break;
				case 'TACCP':
					$data['taccp_conse'] = $value;
					break;
				case 'Quality':
					$data['quality_conse'] = $value;
					break;
				case 'Safety':
					$data['safety_conse'] = $value;
					break;
				case 'VACCP':
					$data['vaccp_conse'] = $value;
					break;
			}
		}
        if (count((array)$temp) > 0){
            $this->db->where('id', $temp->id);
            $result = $this->db->update('process_risk_rating', $data);
        }else{
            $data['process_id'] = $id;
            $this->db->insert('process_risk_rating', $data);
        }
		$sql = "select risk_type from risk left join process on process.risk_id = risk.id where process.id = ".$id;
		$temp_risk_type = $this->db->query($sql)->row()->risk_type;
		if ($temp_risk_type == 1){
			switch ($type){
				case "Food":
					$temp_type = 1;
					break;
				case "Quality":
					$temp_type = 2;
					break;
				case "Environmental":
					$temp_type = 3;
					break;
				case "Safety":
					$temp_type = 4;
					break;
				case "TACCP":
					$temp_type = 5;
					break;
				case "VACCP":
					$temp_type = 6;
					break;
			}
		}else{
			$temp_type = 0;
		}
		$sql = "select IF(c.value >= e.start && c.value <= e.end,e.level,NULL) name from process_risk_rating a
                            LEFT JOIN process b ON a.process_id = b.id
                            LEFT JOIN rating_matrix c ON b.risk_id = c.risk_id
                            AND c.like_id = a.".strtolower($type)."_like
                            AND c.conse_id = a.".strtolower($type)."_conse
                            LEFT JOIN risk d on d.id = b.risk_id
                            LEFT JOIN risk_value e on d.company_id = e.company_id and e.type = ".$temp_type."
                            WHERE
                                a.process_id = ".$id." having name is not NULL";
		$temp_value = $this->db->query($sql)->row();
		if (count((array)$temp_value) > 0){
			$sql = "update process_risk_rating set ".strtolower($type)."_value = '".$temp_value->name."' where process_id = ".$id;
			$this->db->query($sql);
			echo json_encode(array('value'=>$temp_value->name));
		}else{
			echo json_encode(array('value'=>''));
		}
    }
    public function find_process()
    {
        $consultant_id = $this->session->userdata('consultant_id');
        if ($consultant_id) {
            $id = $this->input->post('id');
            $type = $this->input->post('type');

            $sql = "select process.* from process where process.id = ".$id." and process.del_flag = 0 and process.flag = '".$type."'";
            $done = $this->db->query($sql)->row();
            echo json_encode($done);
        } else {
            redirect('Welcome');
        }
    }
    public function get_strategic_process()
    {
		$data["user_type"]  = $this->session->userdata('user_type');
        $data['aa1'] = 'active';
        $data['a1']  = 'act1';
        $data['risk_id']  = $this->input->post('risk_id');
        $id = $data['risk_id'];
        $get_flag  = $this->input->post('get_flag');
        $get_value_swot  = $this->input->post('get_value_swot');
        $get_value_steep  = $this->input->post('get_value_steep');
        $consultant_id  = $this->session->userdata('consultant_id');
		$user_type  = $this->session->userdata('user_type');

        if ($consultant_id) {
            $data['title'] = "Process";

            $sql = "select * from risk where id = ".$data['risk_id'];
            $type = @$this->db->query($sql)->row()->assess_type;
            $data['assess_type'] = explode(",",$type);
            $data['swot_id'] = $get_value_swot;
            if ($get_value_swot == '-1'){
                $data['swot_id'] = "-1";
            }
            if ($get_flag == 'swot' && $get_value_swot != "-1"){
                $sql = "select process.*,employees.employee_name process_owner_name from process left join employees on process.process_owner = employees.employee_id where process.risk_id = ".$id." and process.del_flag = 0 and process.flag = 'swot' and process.type = '".$get_value_swot."'";
            }else{
                $sql = "select process.*,employees.employee_name process_owner_name from process left join employees on process.process_owner = employees.employee_id where process.risk_id = ".$id." and process.del_flag = 0 and process.flag = 'swot'";
            }
			if ($user_type == "process_owner"){
				$sql .= " and process.process_owner = ".$this->session->userdata('employee_id');
			}
            $data['swots'] = $this->db->query($sql)->result();
            $data['steep_id'] = $get_value_steep;
            if ($get_value_steep == '-1'){
                $data['steep_id'] = "-1";
            }
            if ($get_flag == 'steep' && $get_value_steep != "-1"){
                $sql = "select process.*,employees.employee_name process_owner_name from process left join employees on process.process_owner = employees.employee_id where process.risk_id = ".$id." and process.del_flag = 0 and process.flag = 'steep' and process.type = '".$get_value_steep."'";
            }else{
                $sql = "select process.*,employees.employee_name process_owner_name from process left join employees on process.process_owner = employees.employee_id where process.risk_id = ".$id." and process.del_flag = 0 and process.flag = 'steep'";
            }
			if ($user_type == "process_owner"){
				$sql .= " and process.process_owner = ".$this->session->userdata('employee_id');
			}
            $data['steeps'] = $this->db->query($sql)->result();
            $data['needs_id'] = $get_value_swot;
            if ($get_value_swot == '-1'){
                $data['needs_id'] = "-1";
            }
            if ($get_flag == 'needs' && $get_value_swot != "-1"){
                $sql = "select process.*,employees.employee_name process_owner_name from process left join employees on process.process_owner = employees.employee_id where process.risk_id = ".$id." and process.del_flag = 0 and process.flag = 'needs' and process.type = '".$get_value_swot."'";
            }else{
                $sql = "select process.*,employees.employee_name process_owner_name from process left join employees on process.process_owner = employees.employee_id where process.risk_id = ".$id." and process.del_flag = 0 and process.flag = 'needs'";
            }
			if ($user_type == "process_owner"){
				$sql .= " and process.process_owner = ".$this->session->userdata('employee_id');
			}
            $data['needs'] = $this->db->query($sql)->result();
            $sql = "select * from swot_type where company_id = ".$consultant_id;
            $data['swot_type'] = $this->db->query($sql)->result();
            $sql = "select * from steep_type where company_id = ".$consultant_id;
            $data['steep_type'] = $this->db->query($sql)->result();
            $sql = "select * from needs_type where company_id = ".$consultant_id;
            $data['needs_type'] = $this->db->query($sql)->result();
            $sql = "select * from employees where consultant_id = ".$consultant_id;
            $data['employees'] = $this->db->query($sql)->result();
            $sql = "select a.* from process_risk_rating a left join process b on a.process_id = b.id where b.risk_id = ".$id;
            $data['ratings'] = $this->db->query($sql)->result();
            $sql = "select * from likelihood where company_id = ".$consultant_id." and type = 'strategic' and del_flag = 0 order by reg_date";
            $data['likelihood'] = $this->db->query($sql)->result();
            $sql = "select * from consequence where company_id = ".$consultant_id." and type = 'strategic' and del_flag = 0 order by reg_date";
            $data['consequence'] = $this->db->query($sql)->result();
			$this->db->where('id', $id);
			$temp = $this->db->get('risk')->row();
			if ($temp->type_flag == 0){
				$this->load->view('consultant/strategic_process', $data);
			}else{
				$this->load->view('consultant/strategic_process_needs', $data);
			}
        } else {
            redirect('Welcome');
        }
    }
    public function delete_process() {
        $id = $this->input->post('id', TRUE);
        $this->db->where('id', $id);
        $result = $this->db->update('process', array('del_flag'=>'1'));
        echo json_encode(array('success'=>$result));
    }
    public function control_list($id = NULL)
    {
        $data['aa1'] = 'active';
        $data['a1']  = 'act1';
        $data['process_id']  = $id;
        $consultant_id  = $this->session->userdata('consultant_id');
        $data['user_type']  = $this->session->userdata('user_type');
        if ($consultant_id) {
            $data['title'] = "Determine Controls";
            $this->db->where('company_id', $consultant_id);
            $data['actions'] = $this->db->get('control_actions')->result();
            $this->db->where('company_id', $consultant_id);
            $data['assessments'] = $this->db->get('assessment_controls')->result();
            $this->db->where('consultant_id', $consultant_id);
            $data['employees'] = $this->db->get('employees')->result();
            $this->load->view('consultant/control_list', $data);
        } else {
            redirect('Welcome');
        }
    }
    public function control_read($id = NULL)
    {
        $consultant_id  = $this->session->userdata('consultant_id');
        $user_type  = $this->session->userdata('user_type');

        $displayStart = $this->input->post('iDisplayStart');
        $displayLength = $this->input->post('iDisplayLength');
        $search = $this->input->post('sSearch');
        $sortingCols = $this->input->post('iSortingCols');
        $process_id = $this->input->post('process_id');

        $data = array();
        if (isset($id)) {
            $data['control'] = '';
        } else {
            $filter['del_flag'] = 0;
            if ($displayLength != -1) {
                $filter['start'] = $displayStart;
                $filter['limit'] = $displayLength;
                $filter['search'] = $search;
            }
            $order = array();
            for ($i = 0; $i < $sortingCols; $i++) {
                $sortCol = $this->input->post('iSortCol_' . $i);
                $sortDir = $this->input->post('sSortDir_' . $i);
                $dataProp = $this->input->post('mDataProp_' . $sortCol);

                $order[$dataProp] = $sortDir;
            }

            $sql = "SELECT a.*,b.rating action_name,(select employee_name from employees where employees.employee_id = a.sme) sme_name,a.name,a.plan,d.rating assessment_name,
                        (select employee_name from employees where employees.employee_id = a.responsible_party) responsible_name,a.review_date,c.frequency_name,c.days,c.type,DATEDIFF(a.review_date,now()) due, TO_SECONDS(a.review_date) review_date_time, TO_SECONDS(now()) now_time
                        FROM control_list a
                        left join control_actions b on a.action = b.id
                        left join frequency c on a.frequency = c.frequency_id
                        left join assessment_controls d on a.assessment = d.id
                        WHERE
                            a.process_id = " . $process_id . " and a.del_flag = 0";
            if ($search != ''){
                $sql .= " and (a.name like '%".$search."%' OR a.plan like '%".$search."%')";
            }
			if ($user_type == "monitor"){
				$sql .= " and a.monitor = ".$this->session->userdata('employee_id');
			}
			$data['controls'] = $this->db->query($sql)->result();
			$data['iTotalDisplayRecords'] = count($data['controls']);
			unset($filter['search']);
			$data['iTotalRecords'] = count($data['controls']);
			if ($displayLength != -1) {
				$sql .= " limit ".$displayStart.",".$displayLength;
			}
            $data['controls'] = $this->db->query($sql)->result();
            $data['sEcho'] = $search;
        }
        $this->render_json($data);
    }
    public function add_frequency()
    {
        $consultant_id  = $this->session->userdata('consultant_id');
        $name = $this->input->post('frequency');
        $days = $this->input->post('days');
        $type = $this->input->post('type');
        $data = array(
            'frequency_name' => $name,
            'days' => $days,
            'type' => $type,
            'company_id' => $consultant_id
        );
        $done = $this->db->insert('frequency', $data);
        if ($done) {
            $this->db->where('company_id', $consultant_id);
            $frequencys = $this->db->get('frequency')->result();
            foreach ($frequencys as $frequency) {
                echo "<option value='" . $frequency->frequency_id . "'>" . $frequency->frequency_name . "</option>";
            }
        } else {
        }
    }

    public function all_frequency()
    {
        $consultant_id  = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $consultant_id);
        $frequencys = $this->db->get('frequency')->result();
        foreach ($frequencys as $frequency) {
            echo "<option value='" . $frequency->frequency_id . "'>" . $frequency->frequency_name . "</option>";
        }
    }

    public function all_frequency_table()
    {
        $consultant_id  = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $consultant_id);
        $frequencys = $this->db->get('frequency')->result();
        $index = 1;
        foreach ($frequencys as $frequency) {
			if ($frequency->type == 0){
				$temp_type = "Day";
			}else if ($frequency->type == 1){
				$temp_type = "Hour";
			}else{
				$temp_type = "Minute";
			}
            echo "<tr><td>" . $index . "</td><td>" . $frequency->frequency_name . "</td><td>" . $frequency->days . "</td><td>" . $temp_type . "</td><td><a onclick='deletefrequency(" . $frequency->frequency_id . ");';><i class='icon-trash'></i></a></td><tr>";
            $index ++;
        }
    }

    public function delete_frequency()
    {
        $consultant_id  = $this->session->userdata('consultant_id');
        $id = $this->input->post('id');
        $pa_id = @$this->db->query("SELECT * FROM `control_list` WHERE `frequency`='$id'")->row()->id;
        if ($pa_id != null) {
            echo json_encode('failure');
        } else {
            $this->db->where('frequency_id', $id);
            $this->db->delete('frequency');
            echo json_encode('success');
        }
    }
    public function add_control()
    {
        $data['id'] = $this->input->post("id");
        $data['process_id'] = $this->input->post("process_id");
        $data['action'] = $this->input->post("action");
        $data['sme'] = $this->input->post("sme");
        $data['name'] = $this->input->post("name");
        $data['plan'] = $this->input->post("plan");
        $data['responsible_party'] = $this->input->post("responsible_party");
        $data['frequency'] = $this->input->post("frequency");
        $data['assessment'] = $this->input->post("assessment");

		//---------------------------get info------------------------------------------
		$consultant_id      = $this->session->userdata('consultant_id');
		$company_name       = $this->db->where('consultant_id', $consultant_id)->get('consultant')->row()->consultant_name;
		$process_name       = $this->db->where('id', $data['process_id'])->get('process')->row()->name;
		$inspector_info     = $this->db->where('employee_id', $data['responsible_party'])->get('employees')->row();
		$process_owner_info = $this->db->where('employee_id', $data['sme'])->get('employees')->row();
		//-----------------------------------------------------------------------------

        if ($data['id'] != '0'){
            $this->db->where('id', $data['id']);
            $result = $this->db->update('control_list', $data);
        }else{
			$this->db->set('review_date','now()',FALSE);
            $result = $this->db->insert('control_list', $data);
        }
        if ($result > 0){

			//-------------------------------send email-----------------------------
			$email_temp = $this->getEmailTemp('When Monitoring is scheduled by Admin to Inspector');
			$email_temp['message'] = str_replace("{Inspector NAME}", $inspector_info->employee_name, $email_temp['message']);
			$email_temp['message'] = str_replace("{Company Name}", $company_name, $email_temp['message']);
			$email_temp['message'] = str_replace("{Process Name}", $process_name, $email_temp['message']);
			$email_temp['message'] = str_replace("{COURSE_NAME}", 'isoimplementationsoftware.com', $email_temp['message']);
			$email_temp['message'] = str_replace("{LOGO}", "<img src='cid:logo'>", $email_temp['message']);
			$this->sendemail($inspector_info->employee_email, 'Monitoring is scheduled by Admin', $email_temp['message'], $email_temp['subject'], 1);
            //---------------------------------------------- send sms ----------------------------------------------
            if (!empty($inspector_info->employee_phone) && $this->settings->otp_verification){
                $phone = formatMobileNumber($inspector_info->employee_phone, true);
                /*=-=- check user mobile number valid start =-=-*/
                $phone_response = $this->phone_rk->checkPhoneNumber($phone);
                if ($phone_response['success']){
                    $message = "Hi {$inspector_info->employee_name}".PHP_EOL;
                    $message.= "Congratulations you have been assigned to Inspect {$process_name} by your Administrator from {$company_name} on ".APP_NAME." Quality Circle’s Continual Improvement Software.";
                    $this->twill_rk->sendMsq($phone,$message);
                }
            }

			$email_temp = $this->getEmailTemp('When Monitoring is scheduled by Admin to Process Owner');
			$email_temp['message'] = str_replace("{Process Owner NAME}", $process_owner_info->employee_name, $email_temp['message']);
			$email_temp['message'] = str_replace("{Company Name}", $company_name, $email_temp['message']);
			$email_temp['message'] = str_replace("{Process Name}", $process_name, $email_temp['message']);
			$email_temp['message'] = str_replace("{COURSE_NAME}", 'isoimplementationsoftware.com', $email_temp['message']);
			$email_temp['message'] = str_replace("{LOGO}", "<img src='cid:logo'>", $email_temp['message']);
			$this->sendemail($process_owner_info->employee_email, 'Monitoring is scheduled by Admin', $email_temp['message'], $email_temp['subject'], 1);
            //---------------------------------------------- send sms ----------------------------------------------
            if (!empty($process_owner_info->employee_phone) && $this->settings->otp_verification){
                $phone = formatMobileNumber($process_owner_info->employee_phone, true);
                /*=-=- check user mobile number valid start =-=-*/
                $phone_response = $this->phone_rk->checkPhoneNumber($phone);
                if ($phone_response['success']){
                    $message = "Hi {$process_owner_info->employee_name}".PHP_EOL;
                    $message.= "Congratulations you have been assigned {$process_name} by your Administrator from {$company_name} on ".APP_NAME." Quality Circle's Continual Improvement Software.";
                    $this->twill_rk->sendMsq($phone,$message);
                }
            }
			//----------------------------------------------------------------------

            echo "success";
        }else{
            echo "failed";
        }
    }
    public function delete_control() {
        $id = $this->input->post('ids', TRUE);
        $this->db->where('id', $id);
        $result = $this->db->update('control_list', array('del_flag'=>'1'));
        echo json_encode(array('success'=>$result));
    }
	public function close_control() {
		$id = $this->input->post('ids', TRUE);
		$this->db->where('id', $id);
		$result = $this->db->update('control_list', array('status'=>'1'));
		echo json_encode(array('success'=>$result));
	}
    public function manage_control($id = NULL)
    {
		$sidebar_history = $this->session->userdata('sidebar_history');
		if ($sidebar_history == "-1"){
			$data['aa1'] = 'active';
			$data['a1']  = 'act1';
		}else if ($sidebar_history == "1"){
			$data['ee1']             = 'active';
			$data['e2']              = 'act1';
		}

        $data['control_id']  = $id;
        $consultant_id  = $this->session->userdata('consultant_id');
        if ($consultant_id) {
			$this->db->select("risk.*");
			$this->db->join("process","process.id = control_list.process_id","left");
			$this->db->join("risk","risk.id = process.risk_id","left");
			$this->db->where('control_list.id', $id);
			$temp = @$this->db->get('control_list')->row();
			$data['risk_type'] = $temp->risk_type;
			$data['type_flag'] = $temp->type_flag;
            $data['title'] = "Manage Control";
            $this->db->where('id', $id);
            $data['control'] = $this->db->get('control_list')->row();
            $this->db->where('consultant_id', $consultant_id);
            $data['employees'] = $this->db->get('employees')->result();
			$tmp_data['history_status'] = "0";
			$this->db->where('id', $data['control_id']);
			$result = $this->db->update('control_list',$tmp_data);

			$user_type = $this->session->userdata('user_type');
			if ($user_type == 'company' || $user_type == 'consultant')
				$data['monitoring_access'] = '';

			if ($user_type == null)
				$data['monitoring_access'] = '';

            $this->load->view('consultant/manage_control', $data);
        } else {
            redirect('Welcome');
        }
    }
    public function monitoring_read($id = NULL)
    {
        $consultant_id  = $this->session->userdata('consultant_id');

        $displayStart = $this->input->post('iDisplayStart');
        $displayLength = $this->input->post('iDisplayLength');
        $search = $this->input->post('sSearch');
        $sortingCols = $this->input->post('iSortingCols');
        $control_id = $this->input->post('control_id');

        $data = array();
        if (isset($id)) {
            $data['monitoring'] = '';
        } else {
            $filter['del_flag'] = 0;
            if ($displayLength != -1) {
                $filter['start'] = $displayStart;
                $filter['limit'] = $displayLength;
                $filter['search'] = $search;
            }
            $order = array();
            for ($i = 0; $i < $sortingCols; $i++) {
                $sortCol = $this->input->post('iSortCol_' . $i);
                $sortDir = $this->input->post('sSortDir_' . $i);
                $dataProp = $this->input->post('mDataProp_' . $sortCol);

                $order[$dataProp] = $sortDir;
            }

            $sql = "select * from monitoring where del_flag = 0 and control_id = ".$control_id;
            if ($search != ''){
                $sql .= " and (area like '%".$search."%' OR criteria like '%".$search."%' OR description like '%".$search."%')";
            }
			$data['monitorings'] = $this->db->query($sql)->result();
			$data['iTotalDisplayRecords'] = count($data['monitorings']);
			unset($filter['search']);
			$data['iTotalRecords'] = count($data['monitorings']);
			if ($displayLength != -1) {
				$sql .= " limit ".$displayStart.",".$displayLength;
			}
            $data['monitorings'] = $this->db->query($sql)->result();
            $data['sEcho'] = $search;
        }
        $this->render_json($data);
    }
	public function monitoring_history_read($id = NULL)
	{
		$consultant_id  = $this->session->userdata('consultant_id');

		$displayStart = $this->input->post('iDisplayStart');
		$displayLength = $this->input->post('iDisplayLength');
		$search = $this->input->post('sSearch');
		$sortingCols = $this->input->post('iSortingCols');
		$control_id = $this->input->post('control_id');

		$data = array();
		if (isset($id)) {
			$data['monitoring'] = '';
		} else {
			$filter['del_flag'] = 0;
			if ($displayLength != -1) {
				$filter['start'] = $displayStart;
				$filter['limit'] = $displayLength;
				$filter['search'] = $search;
			}
			$order = array();
			for ($i = 0; $i < $sortingCols; $i++) {
				$sortCol = $this->input->post('iSortCol_' . $i);
				$sortDir = $this->input->post('sSortDir_' . $i);
				$dataProp = $this->input->post('mDataProp_' . $sortCol);

				$order[$dataProp] = $sortDir;
			}

			$sql = "select * from monitoring_history where del_flag = 0 and history_id = ".$control_id;
			if ($search != ''){
				$sql .= " and (area like '%".$search."%' OR criteria like '%".$search."%' OR description like '%".$search."%')";
			}
			$data['monitorings'] = $this->db->query($sql)->result();
			$data['iTotalDisplayRecords'] = count($data['monitorings']);
			unset($filter['search']);
			$data['iTotalRecords'] = count($data['monitorings']);
			if ($displayLength != -1) {
				$sql .= " limit ".$displayStart.",".$displayLength;
			}
			$data['monitorings'] = $this->db->query($sql)->result();
			$data['sEcho'] = $search;
		}
		$this->render_json($data);
	}
    public function add_monitoring()
    {
        $data['id'] = $this->input->post("id");
        $data['control_id'] = $this->input->post("control_id");
        $data['area'] = $this->input->post("area");
        $data['criteria'] = $this->input->post("criteria");
        $data['description'] = $this->input->post("description");
        $data['status'] = $this->input->post("monitor_status");

		if ($data['id'] != '0'){
			$this->db->where('id', $data['id']);
			$result = $this->db->update('monitoring', $data);
			$result = $this->db->update('monitoring_history', $data);
		}else{
			$result = $this->db->insert('monitoring', $data);
			$result = $this->db->insert('monitoring_history', $data);
		}

        if ($result > 0){
            echo "success";
        }else{
            echo "failed";
        }
    }
	public function delete_monitoring() {
		$id = $this->input->post('ids', TRUE);
		$this->db->where('id', $id);
		$result = $this->db->update('monitoring', array('del_flag'=>'1'));
		echo json_encode(array('success'=>$result));
	}
    public function submit_monitoring()
    {
        $id = $this->input->post("control_id");
        $risk_type = $this->input->post("risk_type");
        $data['issues1'] = $this->input->post("issues1");
        $data['issues2'] = $this->input->post("issues2");
        $data['functional_area'] = $this->input->post("functional_area");
        $data['monitor'] = $this->input->post("sme");
        $data['responsible_party'] = $this->input->post("responsible_party");


        $this->db->where('id', $id);
        $process_id = @$this->db->get('control_list')->row()->process_id;

		//--------------------------------get info-------------------------------
		$process_name = $this->db->where('id', $process_id)->get('process')->row()->name;
		$admin_id = $this->session->userdata('consultant_id');
		$admin_info = $this->db->where('consultant_id', $admin_id)->get('consultant')->row();
		$inspector_info = $this->db->where('employee_id', $data['responsible_party'])->get('employees')->row();
		$process_owner_info = $this->db->where('employee_id', $data['monitor'])->get('employees')->row();
		$monitoring_areas     = $this->input->post('monitoring_area');
		$monitoring_ncount = count($monitoring_areas);
		$nonconformity_cnt = 0;
		for($i = 0 ; $i < $monitoring_ncount ; $i++) {
			$nonconformity = $this->input->post("nonconformity$i");
			if(isset($nonconformity))
				$nonconformity_cnt ++;
		}
		//-----------------------------------------------------------------------

		//-----------------------------------send email------------------------------
		$email_temp = $this->getEmailTemp('Completion sent to Admin');
		$email_temp['message'] = str_replace("{Admin NAME}", $admin_info->consultant_name, $email_temp['message']);
		$email_temp['message'] = str_replace("{Process Name}", $process_name, $email_temp['message']);
		$email_temp['message'] = str_replace("{Company Name}", $admin_info->consultant_name, $email_temp['message']);
		$email_temp['message'] = str_replace("{Inspector Name}", $inspector_info->employee_name, $email_temp['message']);
		if($nonconformity_cnt == 0)
			$email_temp['message'] = str_replace("{nonconformity}", "out Non-conformity", $email_temp['message']);
		else
			$email_temp['message'] = str_replace("{nonconformity}", " nonconformity", $email_temp['message']);
		$email_temp['message'] = str_replace("{LOGO}", "<img src='cid:logo'>", $email_temp['message']);
		$this->sendemail($admin_info->email, 'Completion sent to Admin', $email_temp['message'], $email_temp['subject'], 2);
        //---------------------------------------------- send sms ----------------------------------------------
        if (!empty($admin_info->phone) && $this->settings->otp_verification){
            $phone = formatMobileNumber($admin_info->phone, true);
            /*=-=- check user mobile number valid start =-=-*/
            $phone_response = $this->phone_rk->checkPhoneNumber($phone);
            if ($phone_response['success']){
                $message = "Hi {$admin_info->consultant_name}".PHP_EOL;
                $message.= "{$inspector_info->employee_name} has just completed Monitoring of {$process_name} for {$admin_info->consultant_name} with".($nonconformity_cnt == 0 ? 'out Non-conformity':' nonconformity').".".PHP_EOL;
                $message.= "{$inspector_info->employee_name}";
                $this->twill_rk->sendMsq($phone,$message);
            }
        }

		$email_temp = $this->getEmailTemp('Completion sent to Inspector');
		$email_temp['message'] = str_replace("{Process Name}", $process_name, $email_temp['message']);
		$email_temp['message'] = str_replace("{Company Name}", $admin_info->consultant_name, $email_temp['message']);
		$email_temp['message'] = str_replace("{Inspector Name}", $inspector_info->employee_name, $email_temp['message']);
		if($nonconformity_cnt == 0)
			$email_temp['message'] = str_replace("{nonconformity}", "out Non-conformity", $email_temp['message']);
		else
			$email_temp['message'] = str_replace("{nonconformity}", " nonconformity", $email_temp['message']);
		$email_temp['message'] = str_replace("{LOGO}", "<img src='cid:logo'>", $email_temp['message']);
		$this->sendemail($inspector_info->employee_email, 'Completion sent to Inspector', $email_temp['message'], $email_temp['subject'], 2);
        //---------------------------------------------- send sms ----------------------------------------------
        if (!empty($inspector_info->employee_phone) && $this->settings->otp_verification){
            $phone = formatMobileNumber($inspector_info->employee_phone, true);
            /*=-=- check user mobile number valid start =-=-*/
            $phone_response = $this->phone_rk->checkPhoneNumber($phone);
            if ($phone_response['success']){
                $message = "Congratulations {$inspector_info->employee_name}".PHP_EOL;
                $message.= "You have just completed Monitoring activities for {$process_name} for {$admin_info->consultant_name} with".($nonconformity_cnt == 0 ? 'out Non-conformity':' nonconformity').".";
                $this->twill_rk->sendMsq($phone,$message);
            }
        }

		$email_temp = $this->getEmailTemp('Completion sent to Process Owner without Nonconformity');
		if($nonconformity_cnt != 0){
			$email_temp = $this->getEmailTemp('Completion sent to Process Owner with Nonconformity');
			$email_temp['message'] = str_replace("{number of nonconformities}", $nonconformity_cnt." of nonconformities", $email_temp['message']);
		}
		$email_temp['message'] = str_replace("{Process Owner Name}", $process_owner_info->employee_name, $email_temp['message']);
		$email_temp['message'] = str_replace("{Company Name}", $admin_info->consultant_name, $email_temp['message']);
		$email_temp['message'] = str_replace("{Process Name}", $process_name, $email_temp['message']);
		$email_temp['message'] = str_replace("{Inspector Name}", $inspector_info->employee_name, $email_temp['message']);
		$email_temp['message'] = str_replace("{LOGO}", "<img src='cid:logo'>", $email_temp['message']);
		$this->sendemail($process_owner_info->employee_email, 'Completion sent to Admin', $email_temp['message'], $email_temp['subject'], 2);
        //---------------------------------------------- send sms ----------------------------------------------
        if (!empty($process_owner_info->employee_phone) && $this->settings->otp_verification){
            $phone = formatMobileNumber($process_owner_info->employee_phone, true);
            /*=-=- check user mobile number valid start =-=-*/
            $phone_response = $this->phone_rk->checkPhoneNumber($phone);
            if ($phone_response['success']){
                $message = "Congratulations {$process_owner_info->employee_name}".PHP_EOL;
                $message.= "Monitoring activities for your {$process_name} for {$admin_info->consultant_name} process have just been completed without any nonconformities. You are not required to take any further actions.";
                $message.= "{$inspector_info->employee_name}";
                if ($nonconformity_cnt != 0){
                    $message = "Hello {$process_owner_info->employee_name}".PHP_EOL;
                    $message.= "Monitoring activities for your {$process_name} process have just been completed with {$nonconformity_cnt} of nonconformities. You are not required to log in you profile to see the nonconformity and take the appropriate actions.";
                    $message.= "{$inspector_info->employee_name}";
                }
                $this->twill_rk->sendMsq($phone,$message);
            }
        }
		//---------------------------------------------------------------------------

		if ($risk_type == '0'){
			$this->db->where('id', $id);
			$this->db->set('review_date','now()',FALSE);
			$this->db->update('control_list', $data);
			$data["control_id"] = $id;
			$this->db->insert('control_list_history', $data);
			$insert_id = $this->db->insert_id();
			//$this->db->where('history_id',"0");
			//$this->db->update('monitoring_history', array('history_id'=>$insert_id));

			/*monitoring history*/
            $monitoring_area     = $this->input->post('monitoring_area');
            $monitoring_criteria = $this->input->post('monitoring_criteria');
            $descriptions = $this->input->post("description");

			$monitoring_count = count($monitoring_area);
            $j = 0;
			for($i = 0 ; $i < $monitoring_count ; $i++){
				$temp_area = $monitoring_area[$i];
				$temp_criteria = $monitoring_criteria[$i];

				$verify_status = $this->input->post("verify$i");
				$nonconformity_status = $this->input->post("nonconformity$i");
				$status = isset($verify_status) ? 0 : (isset($nonconformity_status) ? 1 : -1);

                if($status == 1){
                    $temp_description = $descriptions[$j];
                    $j ++;
                }
                else{
                    $temp_description = "";
                }

				$insert_data = array(
					'area' => $temp_area,
					'sign_image' => $this->input->post("sign_info"),
					'criteria' => $temp_criteria,
					'status' => $status,
					'description' => $temp_description,
					'control_id' => $id,
					'history_id' => $insert_id,
				);

				$this->db->insert('monitoring_history', $insert_data);

				$this->db->where('id', $id);
				$control = $this->db->get('control_list')->row();

				if ($control->workorder_id) {
					$this->db->where(['control_id' => $id, 'status' => 1]);
					$this->db->from('monitoring_history');
					$count = $this->db->count_all_results();

					if ($count == 0) {
						$this->db->where('id', $control->workorder_id);
						$this->db->update('ims_manuorder_work_order', ['state' => 2, 'qualitychecker_id' =>$this->session->userdata('employee_id'), 'qualitycheck_at' => date('Y-m-d H:i:s')]);
					}
				}
			}

			$data["user_type"]  = $this->session->userdata('user_type');
			$sidebar_history = $this->session->userdata('sidebar_history');
			if ($sidebar_history == "-1"){
				redirect('Consultant/control_list/'.$process_id);
			}else if ($sidebar_history == "1"){
				redirect('Consultant/conduct');
			}
		}else{
			$this->db->where('id', $id);

			 $data['sme'] = $this->input->post("sme");

			$this->db->update('control_list', $data);
			unset($data['sme']);
			$this->db->insert('control_list_history', $data);
			$insert_id = $this->db->insert_id();
			//$this->db->where('history_id',"0");
			//$this->db->update('monitoring_history', array('history_id'=>$insert_id));

			/*monitoring history*/
			$monitoring_area     = $this->input->post('monitoring_area');
			$monitoring_criteria = $this->input->post('monitoring_criteria');
            $descriptions = $this->input->post("description");

			$monitoring_count = count($monitoring_area);
			$j = 0;
			for($i = 0 ; $i < $monitoring_count ; $i++){
				$temp_area = $monitoring_area[$i];
				$temp_criteria = $monitoring_criteria[$i];

				$verify_status = $this->input->post("verify$i");
				$nonconformity_status = $this->input->post("nonconformity$i");
				$status = isset($verify_status) ? 0 : (isset($nonconformity_status) ? 1 : -1);
                if($status == 1){
                    $temp_description = $descriptions[$j];
                    $j ++;
                }
				else{
                    $temp_description = "";
                }
				$insert_data = array(
						'area' => $temp_area,
						'criteria' => $temp_criteria,
						'status' => $status,
						'description' => $temp_description,
						'control_id' => $id,
                        'sign_image' => $this->input->post("sign_info"),
						'history_id' => $insert_id,
				);
				$monitor_id = $this->db->insert('monitoring_history', $insert_data);

				$this->db->where('id', $id);
				$control = $this->db->get('control_list')->row();

				if ($control->workorder_id) {
					$this->db->where(['control_id' => $id, 'status' => 1]);
					$this->db->from('monitoring_history');
					$count = $this->db->count_all_results();

					if ($count == 0) {
						$this->db->where('id', $control->workorder_id);
						$this->db->update('ims_manuorder_work_order', ['state' => 2, 'qualitychecker_id' =>$this->session->userdata('employee_id'), 'qualitycheck_at' => date('Y-m-d H:i:s')]);
					}
				}
			}
			if(isset($monitor_id)){
                $data["monitor_id"] = $monitor_id;
            }
            else{
                $data["monitor_id"] = 0;
            }
			$data["user_type"]  = $this->session->userdata('user_type');
			redirect('Consultant/control_barcode/'.$id.'/'.$insert_id);
		}
    }
	public function control_barcode($id = NULL, $monitor_id = 0)
	{
		$sidebar_history = $this->session->userdata('sidebar_history');
		if ($sidebar_history == "-1"){
			$data['aa1'] = 'active';
			$data['a1']  = 'act1';
		}else if ($sidebar_history == "1"){
			$data['ee1']             = 'active';
			$data['e2']              = 'act1';
		}
		$data['control_id']  = $id;
		$consultant_id  = $this->session->userdata('consultant_id');

		$this->db->select("process.outsource_id as outsource_id, process.name as process_name, process.process_step,control_list.name control_name,control_list.history_status,control_list.requirement_met,control_list.reason,control_list.status");
		$this->db->join("process","process.id = control_list.process_id","left");
		$this->db->where('control_list.id', $id);
		$temp = @$this->db->get('control_list')->row();

		$data['control_status'] = $temp->history_status;
        if($temp->outsource_id != 0){
            $this->db->where('id', $temp->outsource_id);
            $outsource_process = @$this->db->get('outsource_process')->row();
            $data['process_name'] = $outsource_process->name;
        }
        else{
            $data['process_name'] = $temp->process_name;
        }
		$data['process_step'] = $temp->process_step;
		$data['control_name'] = $temp->control_name;

		$this->db->insert('control_barcode', array("control_id"=>$id));
		$control_insert_id = $this->db->insert_id();

		$this->db->where('control_id', $id);
		$control_data = @$this->db->get('control_barcode')->row();

		if ($control_data) {
			// requirement_met
			if ($control_data->require_active == 1)
				$data['requirement_met'] = $temp->requirement_met;
else
   $data['requirement_met'] = 0;
			// procedures
			if ($control_data->procedure_active == 1) {
				$this->db->where('company_id', $consultant_id);
				$data['procedures'] = $this->db->get('procedures')->result();
			}

			// supplier
			if ($control_data->supplier_active == 1) {
				$this->db->where('company_id', $consultant_id);
				$data['supplier'] = $this->db->get('supplier')->result();
			}

			// customer
			if ($control_data->customer_active == 1) {
				$this->db->where('company_id', $consultant_id);
				$data['customer'] = $this->db->get('customer')->result();
			}

			// record
			if ($control_data->record_active == 1) {
				$this->db->where('del_flag', 0);
				$this->db->where('company_id', $consultant_id);
				$data['record_list'] = $this->db->get('record')->result();
			}
			// material
			if ($control_data->material_active == 1) {
				$this->db->where('del_flag', 0);
				$this->db->where('company_id', $consultant_id);
				$data['material_list'] = $this->db->get('material')->result();
			}
			// machine
			if ($control_data->machine_active == 1) {
				$this->db->where('del_flag', 0);
				$this->db->where('company_id', $consultant_id);
				$data['machine_list'] = $this->db->get('machine')->result();
			}

			$data['control_data'] = $control_data;
		}

		$data['reason'] = $temp->reason;
		
		$this->db->where('company_id', $consultant_id);
		$data['records'] = $this->db->get('record')->result();


		/*datalit combobox*/
		//product
		$this->db->where('company_id', $consultant_id);
		$this->db->where('del_flag', 0);
		$data['product_list'] = $this->db->get('product')->result();
		

		$data['monitor_id'] = $monitor_id;
		if ($data['control_status'] == "0"){
			$data['control_insert_id'] = $control_insert_id;
			$this->load->view('consultant/control_barcode', $data);
		}else{

			$this->load->view('consultant/show_control_barcode', $data);
		}
	}
	function control_barcode_active($id) {
		$type = $this->input->post('type');
		$state = $this->input->post('state');

		$keys = [
			'material' => 'material_active',
			'supplier' => 'supplier_active',
			'customer' => 'customer_active',
			'record' => 'record_active',
			'machine' => 'machine_active',
			'procedure' => 'procedure_active',
			'require' => 'require_active'
		];

		$param = [
			$keys[$type] => $state == 'TRUE' ? 1 : 0
		];

		$this->Control_barcode_model->update(['id' => $id], $param);

   		$this->output->set_content_type('application/json')->set_output(json_encode(['success' => TRUE]));
	}
	public function show_control_barcode($id = NULL)
	{
		$sidebar_history = $this->session->userdata('sidebar_history');
		if ($sidebar_history == "-1"){
			$data['aa1'] = 'active';
			$data['a1']  = 'act1';
		}else if ($sidebar_history == "1"){
			$data['ee1']             = 'active';
			$data['e4']              = 'act1';
		}
		$data['control_id']  = $id;
		$consultant_id  = $this->session->userdata('consultant_id');
		$this->db->select("process.outsource_id as outsource_id, process.name as process_name, process.process_step,control_list.name control_name,control_list.history_status,control_list.requirement_met,control_list.reason,control_list.status");
		$this->db->join("process","process.id = control_list.process_id","left");
		$this->db->join("control_barcode","control_barcode.control_id = control_list.id","left");
		$this->db->where('control_barcode.id', $id);
		$temp = @$this->db->get('control_list')->row();
		$data['control_status'] = $temp->history_status;

        if($temp->outsource_id != 0){
            $this->db->where('id', $temp->outsource_id);
            $outsource_process = @$this->db->get('outsource_process')->row();
            $data['process_name'] = $outsource_process->name;
        }
        else{
            $data['process_name'] = $temp->process_name;
        }

		$data['process_step'] = $temp->process_step;
		$data['control_name'] = $temp->control_name;
		$data['requirement_met'] = $temp->requirement_met;
		$data['reason'] = $temp->reason;
		$this->db->where('id', $id);
		$data['control_data'] = @$this->db->get('control_barcode')->row();
		//product
		$this->db->where('company_id', $consultant_id);
		$this->db->where('del_flag', 0);
		$data['product_list'] = $this->db->get('product')->result();

		$this->load->view('consultant/show_control_barcode', $data);
	}
    public function history_control($id = NULL)
    {
		$data["user_type"]  = $this->session->userdata('user_type');
		$sidebar_history = $this->session->userdata('sidebar_history');
		if ($sidebar_history == "-1"){
			$data['aa1'] = 'active';
			$data['a1']  = 'act1';
		}else if ($sidebar_history == "1"){
			$data['ee1']             = 'active';
			$data['e2']              = 'act1';
		}
        $data['process_id']  = $id;
        $consultant_id  = $this->session->userdata('consultant_id');
        if ($consultant_id) {
            $data['title'] = "History Controls";
            $this->db->where('company_id', $consultant_id);
            $data['actions'] = $this->db->get('control_actions')->result();
            $this->db->where('company_id', $consultant_id);
            $data['assessments'] = $this->db->get('assessment_controls')->result();
            $this->db->where('consultant_id', $consultant_id);
            $data['employees'] = $this->db->get('employees')->result();
            $this->load->view('consultant/history_control', $data);
        } else {
            redirect('Welcome');
        }
    }
    public function history_control_read($id = NULL)
    {
        $consultant_id  = $this->session->userdata('consultant_id');

        $displayStart = $this->input->post('iDisplayStart');
        $displayLength = $this->input->post('iDisplayLength');
        $search = $this->input->post('sSearch');
        $sortingCols = $this->input->post('iSortingCols');
        $process_id = $this->input->post('process_id');

        $data = array();
        if (isset($id)) {
            $data['control'] = '';
        } else {
            $filter['del_flag'] = 0;
            if ($displayLength != -1) {
                $filter['start'] = $displayStart;
                $filter['limit'] = $displayLength;
                $filter['search'] = $search;
            }
            $order = array();
            for ($i = 0; $i < $sortingCols; $i++) {
                $sortCol = $this->input->post('iSortCol_' . $i);
                $sortDir = $this->input->post('sSortDir_' . $i);
                $dataProp = $this->input->post('mDataProp_' . $sortCol);

                $order[$dataProp] = $sortDir;
            }

            $sql = "SELECT h.id,a.name,a.review_date,a.reason,a.sign_status,b.rating action_name,(select employee_name from employees where employees.employee_id = a.monitor) monitor_name,a.name,
                        a.review_date,c.frequency_name,c.days,f.employee_name process_owner_name,e.name process_name
                        FROM control_list_history h
                        left join control_list a on a.id = h.control_id
                        left join control_actions b on a.action = b.id
                        left join frequency c on a.frequency = c.frequency_id
                        left join assessment_controls d on a.assessment = d.id
                        left join process e on a.process_id = e.id
                        left join employees f on a.responsible_party = f.employee_id
                        WHERE
                            a.process_id = " . $process_id . " and a.del_flag = 0";
            if ($search != ''){
                $sql .= " and (a.name like '%".$search."%' OR a.reason like '%".$search."%')";
            }
            $sql .= " ORDER BY a.reg_date DESC";
			$data['controls'] = $this->db->query($sql)->result();
			$data['iTotalDisplayRecords'] = count($data['controls']);
			unset($filter['search']);
			$data['iTotalRecords'] = count($data['controls']);
			if ($displayLength != -1) {
				$sql .= " limit ".$displayStart.",".$displayLength;
			}
            $data['controls'] = $this->db->query($sql)->result();
            $data['sEcho'] = $search;
        }
        $this->render_json($data);
    }
    public function view_control($id = NULL)
    {
		$sidebar_history = $this->session->userdata('sidebar_history');
		if ($sidebar_history == "-1"){
			$data['aa1'] = 'active';
			$data['a1']  = 'act1';
		}else if ($sidebar_history == "1"){
			$data['ee1']             = 'active';
			$data['e2']              = 'act1';
		}
        $data['history_id']  = $id;
		$this->db->where('id', $id);
		$temp = $this->db->get('control_list_history')->row();
		$control_id  = $temp->control_id;
        $consultant_id  = $this->session->userdata('consultant_id');
        if ($consultant_id) {
			$this->db->select("risk.*");
			$this->db->join("process","process.id = control_list.process_id","left");
			$this->db->join("risk","risk.id = process.risk_id","left");
			$this->db->where('control_list.id', $control_id);
			$temp = @$this->db->get('control_list')->row();
			$data['risk_type'] = $temp->risk_type;
			$data['type_flag'] = $temp->type_flag;
            $data['title'] = "View Control";
			$this->db->join("control_list","control_list.id = control_list_history.control_id","left");
            $this->db->where('control_list_history.id', $id);
            $data['control'] = $this->db->get('control_list_history')->row();
			$data['control_id']  = $data['control']->control_id;
            $this->db->where('consultant_id', $consultant_id);
            $data['employees'] = $this->db->get('employees')->result();
			$tmp_data['history_status'] = "1";
			$this->db->where('id', $data['control_id']);
			$result = $this->db->update('control_list',$tmp_data);
            $this->load->view('consultant/view_control', $data);
        } else {
            redirect('Welcome');
        }
    }
    public function corrective_action_form($id = '')
    {
        $consultant_id  = $this->session->userdata('consultant_id');
        $data['bb1'] = 'active';
        if ($consultant_id) {
            $data['title'] = "CORRECTIVE ACTION FORM";
            if ($id != '') {
                $data['monitoring_id'] = $id;
                $sql = "SELECT
c.name process_name,c.process_step,c.process_owner,a.description note
FROM
	monitoring_history AS a
left join control_list b on a.control_id = b.id
left join process c on b.process_id = c.id
WHERE
	a.id = " . $id;
                $data['selected_item'] = @$this->db->query($sql)->row();
                $this->db->where('company_id', $consultant_id);
                $data['monitoring_type'] = $this->db->get('type_of_monitoring')->result();
                $this->db->select("process.*");
                $this->db->join("risk","risk.id = process.risk_id","left");
                $this->db->where('risk.company_id', $consultant_id);
                $data['process'] = $this->db->get('process')->result();
                $this->db->where('employees.consultant_id', $consultant_id);
                $data['employees'] = $this->db->get('employees')->result();
                $this->db->where('company_id', $consultant_id);
                $data['triggers'] = $this->db->get('trigger')->result();
                $this->load->view('consultant/corrective_action_form_two', $data);
            } else {
                $this->db->where('company_id', $consultant_id);
                $data['monitoring_type'] = $this->db->get('type_of_monitoring')->result();
                $this->db->select("process.*");
                $this->db->join("risk","risk.id = process.risk_id","left");
                $this->db->where('risk.company_id', $consultant_id);
                $data['process'] = $this->db->get('process')->result();
                $this->db->where('employees.consultant_id', $consultant_id);
                $data['employees'] = $this->db->get('employees')->result();
                $this->db->where('company_id', $consultant_id);
                $data['triggers'] = $this->db->get('trigger')->result();

                $this->load->view('consultant/corrective_action_form', $data);

            }
        } else {
            redirect('Welcome');
        }
    }
    public function add_mashine()
    {
        $company_id = $this->session->userdata('consultant_id');
        $name       = $this->input->post('name');
        $data       = array(
            'name' => $name,
            'company_id' => $company_id
        );
        $done       = $this->db->insert('mashine', $data);
        if ($done) {
            $this->db->where('company_id', $company_id);
            $mashine = $this->db->get('mashine')->result();
            echo '<option value="Not Applicable">Not Applicable</option>';
            foreach ($mashine as $mashines) {
                echo "<option value='" . $mashines->name . "'>" . $mashines->name . "</option>";
            }
        } else {
        }
    }
    public function all_mashine()
    {
        $company_id = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $company_id);
        $mashine = $this->db->get('mashine')->result();
        echo '<option value="Not Applicable">Not Applicable</option>';
        foreach ($mashine as $mashines) {
            echo "<option value='" . $mashines->name . "'>" . $mashines->name . "</option>";
        }
    }
    public function all_mashine_table()
    {
        $company_id = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $company_id);
        $mashine = $this->db->get('mashine')->result();
        foreach ($mashine as $mashines) {
            echo "<tr><td>" . $mashines->name . "</td><td><a onclick='deletemashine(" . $mashines->id . ");';><i class='icon-trash'></i></a></td><tr>";
        }
    }
    public function delete_mashine()
    {
        $id         = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('mashine');
    }
    public function add_regulatory_requirement()
    {
        $company_id = $this->session->userdata('consultant_id');
        $name       = $this->input->post('name');
        $data       = array(
            'name' => $name,
            'company_id' => $company_id
        );
        $done       = $this->db->insert('regulatory_requirement', $data);
        if ($done) {
            $this->db->where('company_id', $company_id);
            $regulatory_requirement = $this->db->get('regulatory_requirement')->result();
            echo '<option value="Not Applicable">Not Applicable</option>';
            foreach ($regulatory_requirement as $regulatory_requirements) {
                echo "<option value='" . $regulatory_requirements->name . "'>" . $regulatory_requirements->name . "</option>";
            }
        } else {
        }
    }
	public function edit_regulatory_requirement()
	{
		$consultant_id  = $this->session->userdata('consultant_id');
		$id = $this->input->post('id');
		$value = $this->input->post('name');
		$data = array(
				'name' => $value,
				'company_id' => $consultant_id
		);
		if ($id == 0){
			$done = $this->db->insert('regulatory_requirement', $data);
		}else{
			$this->db->where('id', $id);
			$done = $this->db->update('regulatory_requirement', $data);
		}
		if ($done) {
			echo "success";
		} else {
			echo "";
		}
	}
    public function all_regulatory_requirement()
    {
        $company_id = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $company_id);
        $regulatory_requirement = $this->db->get('regulatory_requirement')->result();
        echo '<option value="Not Applicable">Not Applicable</option>';
        foreach ($regulatory_requirement as $regulatory_requirements) {
            echo "<option value='" . $regulatory_requirements->name . "'>" . $regulatory_requirements->name . "</option>";
        }
    }
    public function all_regulatory_requirement_table()
    {
        $company_id = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $company_id);
        $regulatory_requirement = $this->db->get('regulatory_requirement')->result();
        foreach ($regulatory_requirement as $regulatory_requirements) {
            echo "<tr><td>" . $regulatory_requirements->name . "</td><td><a onclick='deleteregulatory_requirement(" . $regulatory_requirements->id . ");';><i class='icon-trash'></i></a></td><tr>";
        }
    }
    public function delete_regulatory_requirement()
    {
        $id         = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('regulatory_requirement');
    }
    public function add_customer_requirment()
    {
        $company_id = $this->session->userdata('consultant_id');
        $name       = $this->input->post('name');
        $data       = array(
            'name' => $name,
            'company_id' => $company_id
        );
        $done       = $this->db->insert('customer_requirment', $data);
        if ($done) {
            $this->db->where('company_id', $company_id);
            $regulatory_requirement = $this->db->get('customer_requirment')->result();
            echo '<option value="Not Applicable">Not Applicable</option>';
            foreach ($regulatory_requirement as $regulatory_requirements) {
                echo "<option value='" . $regulatory_requirements->name . "'>" . $regulatory_requirements->name . "</option>";
            }
        } else {
        }
    }
	public function edit_customer_requirement()
	{
		$consultant_id  = $this->session->userdata('consultant_id');
		$id = $this->input->post('id');
		$value = $this->input->post('name');
		$data = array(
				'name' => $value,
				'company_id' => $consultant_id
		);
		if ($id == 0){
			$done = $this->db->insert('customer_requirment', $data);
		}else{
			$this->db->where('id', $id);
			$done = $this->db->update('customer_requirment', $data);
		}
		if ($done) {
			echo "success";
		} else {
			echo "";
		}
	}
    public function all_customer_requirment()
    {
        $company_id = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $company_id);
        $regulatory_requirement = $this->db->get('customer_requirment')->result();
        echo '<option value="Not Applicable">Not Applicable</option>';
        foreach ($regulatory_requirement as $regulatory_requirements) {
            echo "<option value='" . $regulatory_requirements->name . "'>" . $regulatory_requirements->name . "</option>";
        }
    }
    public function all_customer_requirment_table()
    {
        $company_id = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $company_id);
        $regulatory_requirement = $this->db->get('customer_requirment')->result();
        foreach ($regulatory_requirement as $regulatory_requirements) {
            echo "<tr><td>" . $regulatory_requirements->name . "</td><td><a onclick='deletecustomer_requirment(" . $regulatory_requirements->id . ");';><i class='icon-trash'></i></a></td><tr>";
        }
    }
    public function delete_customer_requirment()
    {
        $id         = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('customer_requirment');
    }
    public function add_process_step()
    {
        $company_id = $this->session->userdata('consultant_id');
        $name       = $this->input->post('name');
        $data       = array(
            'name' => $name,
            'company_id' => $company_id
        );
        $done       = $this->db->insert('process_step', $data);
        if ($done) {
            $this->db->where('company_id', $company_id);
            $regulatory_requirement = $this->db->get('process_step')->result();
            echo '<option value="Not Applicable">Not Applicable</option>';
            foreach ($regulatory_requirement as $regulatory_requirements) {
                echo "<option value='" . $regulatory_requirements->name . "'>" . $regulatory_requirements->name . "</option>";
            }
        } else {
        }
    }
    public function all_process_step()
    {
        $company_id = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $company_id);
        $regulatory_requirement = $this->db->get('process_step')->result();
        echo '<option value="Not Applicable">Not Applicable</option>';
        foreach ($regulatory_requirement as $regulatory_requirements) {
            echo "<option value='" . $regulatory_requirements->name . "'>" . $regulatory_requirements->name . "</option>";
        }
    }
    public function all_process_step_table()
    {
        $company_id = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $company_id);
        $regulatory_requirement = $this->db->get('process_step')->result();
        foreach ($regulatory_requirement as $regulatory_requirements) {
            echo "<tr><td>" . $regulatory_requirements->name . "</td><td><a onclick='deletestandard(" . $regulatory_requirements->id . ");';><i class='icon-trash'></i></a></td><tr>";
        }
    }
    public function delete_process_step()
    {
        $id         = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('process_step');
    }
    public function add_policy()
    {
        $company_id = $this->session->userdata('consultant_id');
        $name       = $this->input->post('name');
        $data       = array(
            'name' => $name,
            'company_id' => $company_id
        );
        $done       = $this->db->insert('policy', $data);
        if ($done) {
            $this->db->where('company_id', $company_id);
            $regulatory_requirement = $this->db->get('policy')->result();
            echo '<option value="Not Applicable">Not Applicable</option>';
            foreach ($regulatory_requirement as $regulatory_requirements) {
                echo "<option value='" . $regulatory_requirements->name . "'>" . $regulatory_requirements->name . "</option>";
            }
        } else {
        }
    }
	public function edit_policy()
	{
		$consultant_id  = $this->session->userdata('consultant_id');
		$id = $this->input->post('id');
		$value = $this->input->post('name');
		$data = array(
				'name' => $value,
				'company_id' => $consultant_id
		);
		if ($id == 0){
			$done = $this->db->insert('policy', $data);
		}else{
			$this->db->where('id', $id);
			$done = $this->db->update('policy', $data);
		}
		if ($done) {
			echo "success";
		} else {
			echo "";
		}
	}
    public function all_policy()
    {
        $company_id = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $company_id);
        $regulatory_requirement = $this->db->get('policy')->result();
        echo '<option value="Not Applicable">Not Applicable</option>';
        foreach ($regulatory_requirement as $regulatory_requirements) {
            echo "<option value='" . $regulatory_requirements->name . "'>" . $regulatory_requirements->name . "</option>";
        }
    }
    public function all_policy_table()
    {
        $company_id = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $company_id);
        $regulatory_requirement = $this->db->get('policy')->result();
        foreach ($regulatory_requirement as $regulatory_requirements) {
            echo "<tr><td>" . $regulatory_requirements->name . "</td><td><a onclick='deletepolicy(" . $regulatory_requirements->id . ");';><i class='icon-trash'></i></a></td><tr>";
        }
    }
    public function delete_policy()
    {
        $id         = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('policy');
    }
    public function add_product()
    {
        $company_id = $this->session->userdata('consultant_id');
        $name       = $this->input->post('name');
        $data       = array(
            'name' => $name,
            'company_id' => $company_id
        );
        $done       = $this->db->insert('product', $data);
        if ($done) {
            $this->db->where('company_id', $company_id);
            $regulatory_requirement = $this->db->get('product')->result();
            echo '<option value="Not Applicable">Not Applicable</option>';
            foreach ($regulatory_requirement as $regulatory_requirements) {
                echo "<option value='" . $regulatory_requirements->name . "'>" . $regulatory_requirements->name . "</option>";
            }
        } else {
        }
    }
	public function edit_product()
	{
		$consultant_id  = $this->session->userdata('consultant_id');
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$code = $this->input->post('code');
		$upc_number = $this->input->post('upc_number');
		$size = $this->input->post('size');
		$packaging_type = $this->input->post('packaging_type');
		$barcode_info = $this->input->post('barcode_info');

		$data = array(
				'name' => $name,
				'company_id' => $consultant_id,
				'code' => $code,
				'upc_number' => $upc_number,
				'size' => $size,
				'packaging_type' => $packaging_type,
				'barcode_info' => $barcode_info,
		);
		if ($id == 0){
			$done = $this->db->insert('product', $data);
		}else{
			$this->db->where('id', $id);
			$done = $this->db->update('product', $data);
		}
		if ($done) {
			echo "success";
		} else {
			echo "";
		}
	}
    public function all_product()
    {
        $company_id = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $company_id);
        $regulatory_requirement = $this->db->get('product')->result();
        echo '<option value="Not Applicable">Not Applicable</option>';
        foreach ($regulatory_requirement as $regulatory_requirements) {
            echo "<option value='" . $regulatory_requirements->name . "'>" . $regulatory_requirements->name . "</option>";
        }
    }
    public function all_product_table()
    {
        $company_id = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $company_id);
        $regulatory_requirement = $this->db->get('product')->result();
        foreach ($regulatory_requirement as $regulatory_requirements) {
            echo "<tr><td>" . $regulatory_requirements->name . "</td><td><a onclick='deleteproduct(" . $regulatory_requirements->id . ");';><i class='icon-trash'></i></a></td><tr>";
        }
    }
    public function delete_product()
    {
        $id         = $this->input->post('id');
        $this->db->where('id', $id);
		$result = $this->db->update('product', array('del_flag'=>'1'));
    }
    public function add_shift()
    {
        $company_id = $this->session->userdata('consultant_id');
        $name       = $this->input->post('name');
        $data       = array(
            'name' => $name,
            'company_id' => $company_id
        );
        $done       = $this->db->insert('shift', $data);
        if ($done) {
            $this->db->where('company_id', $company_id);
            $regulatory_requirement = $this->db->get('shift')->result();
            echo '<option value="Not Applicable">Not Applicable</option>';
            foreach ($regulatory_requirement as $regulatory_requirements) {
                echo "<option value='" . $regulatory_requirements->name . "'>" . $regulatory_requirements->name . "</option>";
            }
        } else {
        }
    }
	public function edit_shift()
	{
		$consultant_id  = $this->session->userdata('consultant_id');
		$id = $this->input->post('id');
		$value = $this->input->post('name');
		$data = array(
				'name' => $value,
				'company_id' => $consultant_id
		);
		if ($id == 0){
			$done = $this->db->insert('shift', $data);
		}else{
			$this->db->where('id', $id);
			$done = $this->db->update('shift', $data);
		}
		if ($done) {
			echo "success";
		} else {
			echo "";
		}
	}
    public function all_shift()
    {
        $company_id = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $company_id);
        $regulatory_requirement = $this->db->get('shift')->result();
        echo '<option value="Not Applicable">Not Applicable</option>';
        foreach ($regulatory_requirement as $regulatory_requirements) {
            echo "<option value='" . $regulatory_requirements->name . "'>" . $regulatory_requirements->name . "</option>";
        }
    }
    public function all_shift_table()
    {
        $company_id = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $company_id);
        $regulatory_requirement = $this->db->get('shift')->result();
        foreach ($regulatory_requirement as $regulatory_requirements) {
            echo "<tr><td>" . $regulatory_requirements->name . "</td><td><a onclick='deleteshift(" . $regulatory_requirements->id . ");';><i class='icon-trash'></i></a></td><tr>";
        }
    }
    public function delete_shift()
    {
        $id         = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('shift');
    }
    public function add_trigger()
    {
        $consultant_id  = $this->session->userdata('consultant_id');
        $value = $this->input->post('trigger');
        $data = array(
            'trigger_name' => $value,
            'company_id' => $consultant_id
        );
        $done = $this->db->insert('trigger', $data);
        if ($done) {
            $this->db->where('company_id', $consultant_id);
            $triggers = $this->db->get('trigger')->result();
            foreach ($triggers as $trigger) {
                echo "<option value='" . $trigger->trigger_name . "'>" . $trigger->trigger_name . "</option>";
            }
        } else {
			echo "";
        }
    }
	public function edit_trigger()
	{
		$consultant_id  = $this->session->userdata('consultant_id');
		$id = $this->input->post('id');
		$value = $this->input->post('trigger');
		$data = array(
				'trigger_name' => $value,
				'company_id' => $consultant_id
		);
		if ($id == 0){
			$done = $this->db->insert('trigger', $data);
		}else{
			$this->db->where('trigger_id', $id);
			$done = $this->db->update('trigger', $data);
		}
		if ($done) {
			echo "success";
		} else {
			echo "";
		}
	}

    public function all_trigger()
    {
        $checklist_id = $this->input->post('name');
        $consultant_id = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $consultant_id);
        $triggers = $this->db->get('trigger')->result();
        foreach ($triggers as $trigger) {
            echo "<option value='" . $trigger->trigger_id . "'>" . $trigger->trigger_name . "</option>";
        }
    }

    public function all_trigger_table()
    {
        $consultant_id  = $this->session->userdata('consultant_id');
        $this->db->where('company_id', $consultant_id);
        $triggers = $this->db->get('trigger')->result();
        $index = 1;
        foreach ($triggers as $trigger) {
            echo "<tr><td>" . $index . "</td><td>" . $trigger->trigger_name . "</td><td><a onclick='deletetrigger(" . $trigger->trigger_id . ");';><i class='icon-trash'></i></a></td><tr>";
            $index ++;
        }
    }

    public function delete_trigger()
    {
        $consultant_id  = $this->session->userdata('consultant_id');
        $id = $this->input->post('id');
        $pa_id = @$this->db->query("SELECT * FROM `corrective_action_data` WHERE `trigger_id`='$id'")->row()->id;
        if ($pa_id != null) {
            echo json_encode('failure');
        } else {
            $this->db->where('trigger_id', $id);
            $this->db->delete('trigger');
            echo json_encode('success');
        }
    }
    public function add_corrective_action_data()
    {
        $company_id                 = $this->session->userdata('consultant_id');
        $monitoring_id                       = $this->input->post('monitoring_id');
        $monitoring_type                       = $this->input->post('monitoring_type');
        if(!isset($monitoring_type)){
            $monitoring_type = 0;
        }
        $process                       = $this->input->post('process');
        if(!isset($process)){
            $process = 0;
        }
        $line_worker                       = $this->input->post('line_worker');
        $trigger_id                       = $this->input->post('trigger_id');
        $customer_requirment                       = $this->input->post('customer_requirment');
        $occur_date                       = $this->input->post('occur_date');
        $product                       = $this->input->post('product');
        $process_step                       = $this->input->post('process_step');
        $regulatory_requirement                       = $this->input->post('regulatory_requirement');
        $policy                       = $this->input->post('policy');
        $mashine_clause                       = $this->input->post('mashine_clause');
        $shift                       = $this->input->post('shift');
        $prob_desc                       = $this->input->post('prob_desc');
        $correction                       = $this->input->post('correction');
        $business_impact                       = $this->input->post('business_impact');
        $root_cause                       = $this->input->post('root_cause');
        $action_plan                       = $this->input->post('action_plan');
        $corrective_action                       = $this->input->post('corrective_action');
        $verification_effectiveness                       = $this->input->post('verification_effectiveness');
        $type                       = $this->input->post('type');
        $by_when_date                       = $this->input->post('by_when_date');
        $responsible_party                       = $this->input->post('responsible_party');
        $role                       = $this->input->post('role');
        $unique_id                  = time();
        $create_at                  = date('Y-m-d');
        if (!empty($_FILES['root_doc']['name'])) {
            $config['upload_path']   = 'uploads/Doc/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx';
            $config['file_name']     = time() . $_FILES['root_doc']['name'];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('root_doc')) {

                $uploadData = $this->upload->data();
                $root_doc   = $uploadData['file_name'];
            } else {
                $root_doc = '';
            }
        } else {
            $root_doc = '';
        }
        if (!empty($_FILES['corrective_plan_doc']['name'])) {
            $config['upload_path']   = 'uploads/Doc/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx';
            $config['file_name']     = time() . $_FILES['corrective_plan_doc']['name'];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('corrective_plan_doc')) {
                $uploadData          = $this->upload->data();
                $corrective_plan_doc = $uploadData['file_name'];
            } else {
                $corrective_plan_doc = '';
            }
        } else {
            $corrective_plan_doc = '';
        }
        if (!empty($_FILES['corrective_doc']['name'])) {
            $config['upload_path']   = 'uploads/Doc/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx';
            $config['file_name']     = time() . $_FILES['corrective_doc']['name'];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('corrective_doc')) {
                $uploadData = $this->upload->data();
                $corrective_doc = $uploadData['file_name'];
            } else {
                $corrective_doc = '';
            }
        } else {
            $corrective_doc = '';
        }
        if (!empty($_FILES['verification_doc']['name'])) {
            $config['upload_path']   = 'uploads/Doc/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx';
            $config['file_name']     = time() . $_FILES['verification_doc']['name'];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('verification_doc')) {
                $uploadData       = $this->upload->data();
                $verification_doc = $uploadData['file_name'];
            } else {
                $verification_doc = '';
            }
        } else {
            $verification_doc = '';
        }
        $data12 = array(
            'company_id' => $company_id,
            'monitoring_type' => $monitoring_type,
            'create_at' => $create_at,
            'by_when_date' => $by_when_date,
            'policy' => $policy,
            'role' => $role,
            'process_owner' => $responsible_party,
            'type' => $type,
            'action_plan' => $action_plan,
            'business_impact' => $business_impact,
            'root_cause' => $root_cause,
            'correction' => $correction,
            'prob_desc' => $prob_desc,
            'mashine_clause' => $mashine_clause,
            'shift' => $shift,
            'regulatory_requirement' => $regulatory_requirement,
            'process_step' => $process_step,
            'product' => $product,
            'customer_requirment' => $customer_requirment,
            'occur_date' => $occur_date,
            'trigger_id' => $trigger_id,
            'line_worker' => $line_worker,
            'unique_id' => $unique_id,
            'process' => $process,
            'monitoring_id' => $monitoring_id,
            'corrective_action' => $corrective_action,
            'verification_effectiveness' => $verification_effectiveness,
            'root_doc' => $root_doc,
            'corrective_plan_doc' => $corrective_plan_doc,
            'corrective_doc' => $corrective_doc,
            'verification_doc' => $verification_doc
        );
        if ($company_id) {
            $data = array(
                'company_id' => $company_id,
                'monitoring_type' => $monitoring_type,
                'process' => $process,
                'create_at' => $create_at,
                'by_when_date' => $by_when_date,
                'role' => $role,
                'process_owner' => $responsible_party,
                'type' => $type,
                'action_plan' => $action_plan,
                'business_impact' => $business_impact,
                'root_cause' => $root_cause,
                'correction' => $correction,
                'prob_desc' => $prob_desc,
                'mashine_clause' => $mashine_clause,
                'policy' => $policy,
                'shift' => $shift,
                'regulatory_requirement' => $regulatory_requirement,
                'process_step' => $process_step,
                'product' => $product,
                'customer_requirment' => $customer_requirment,
                'occur_date' => $occur_date,
                'trigger_id' => $trigger_id,
                'line_worker' => $line_worker,
                'unique_id' => $unique_id,
                'corrective_action' => $corrective_action,
                'verification_effectiveness' => $verification_effectiveness,
                'root_doc' => $root_doc,
                'corrective_plan_doc' => $corrective_plan_doc,
                'corrective_doc' => $corrective_doc,
                'verification_doc' => $verification_doc
            );
            if ($monitoring_id != '') {
                $this->db->where('monitoring_id', $monitoring_id);
                $corrective_temp = $this->db->get('corrective_action_data')->result();
                if (count($corrective_temp) > 0){
                    $this->db->where('id', $corrective_temp[0]->id);
                    $this->db->update('corrective_action_data', $data12);
                    $last_id = $corrective_temp[0]->id;
                }else{
                    $done    = $this->db->insert('corrective_action_data', $data12);
                    $last_id = $this->db->insert_id();
                }
                $this->db->where('id', $monitoring_id);
                $monitoring_temp = $this->db->get('monitoring')->row();
            }else {
                $done    = $this->db->insert('corrective_action_data', $data);
                $last_id = $this->db->insert_id();
            }
			if ($done) {
				$this->session->set_flashdata('message', 'submit');
				redirect('consultant/car_action_notification/' . $last_id);
			} else {
				$this->session->set_flashdata('message', 'failed');
				redirect('consultant/car_action_notification/' . $last_id);
			}
        } else {
            redirect('Welcome');
        }
    }
    public function outsource_process($id = NULL)
    {
		$data["user_type"]  = $this->session->userdata('user_type');
		$consultant_id  = $this->session->userdata('consultant_id');
        $data['aa1'] = 'active';
        $data['a1']  = 'act1';
        $data['risk_id']  = $id;
        $consultant_id  = $this->session->userdata('consultant_id');
        if ($consultant_id) {
            $data['title'] = "Outsource Process";
			$this->db->where('consultant_id', $consultant_id);
            $data['employees'] = $this->db->get('employees')->result();
            $this->load->view('consultant/outsource_process', $data);
        } else {
            redirect('Welcome');
        }
    }
    public function outsource_process_read($id = NULL)
    {
        $consultant_id  = $this->session->userdata('consultant_id');

        $displayStart = $this->input->post('iDisplayStart');
        $displayLength = $this->input->post('iDisplayLength');
        $search = $this->input->post('sSearch');
        $sortingCols = $this->input->post('iSortingCols');
        $risk_id = $this->input->post('risk_id');

        $data = array();
        if (isset($id)) {
            $data['process'] = '';
        } else {
            $filter['del_flag'] = 0;
            if ($displayLength != -1) {
                $filter['start'] = $displayStart;
                $filter['limit'] = $displayLength;
                $filter['search'] = $search;
            }
            $order = array();
            for ($i = 0; $i < $sortingCols; $i++) {
                $sortCol = $this->input->post('iSortCol_' . $i);
                $sortDir = $this->input->post('sSortDir_' . $i);
                $dataProp = $this->input->post('mDataProp_' . $sortCol);

                $order[$dataProp] = $sortDir;
            }

            $sql = "SELECT a.*,(select employees.employee_name from employees where employees.employee_id = a.process_owner) process_owner_name from outsource_process a where
                            a.risk_id = " . $risk_id . " and a.del_flag = 0";
            if ($search != ''){
                $sql .= " and (a.name like '%".$search."%' OR a.description like '%".$search."%')";
            }
            $sql .= " ORDER BY a.reg_date DESC";
			$data['processes'] = $this->db->query($sql)->result();
			$data['iTotalDisplayRecords'] = count($data['processes']);
			unset($filter['search']);
			$data['iTotalRecords'] = count($data['processes']);
			if ($displayLength != -1) {
				$sql .= " limit ".$displayStart.",".$displayLength;
			}
            $data['processes'] = $this->db->query($sql)->result();
            $data['sEcho'] = $search;
        }
        $this->render_json($data);
    }
    public function add_outsource_process()
    {
        $data['id'] = $this->input->post("id");
        $data['risk_id'] = $this->input->post("risk_id");
        $data['name'] = $this->input->post("name");
        $data['description'] = $this->input->post("description");
        $data['process_owner'] = $this->input->post("process_owner");

        if ($data['id'] != '0'){
            $this->db->where('id', $data['id']);
            $result = $this->db->update('outsource_process', $data);
        }else{
            $result = $this->db->insert('outsource_process', $data);
        }
        if ($result > 0){
            echo "success";
        }else{
            echo "failed";
        }
    }
    public function delete_outsource_process() {
        $id = $this->input->post('ids', TRUE);
        $this->db->where('id', $id);
        $result = $this->db->update('outsource_process', array('del_flag'=>'1'));
        echo json_encode(array('success'=>$result));
    }
    public function risk_scope($id = NULL)
    {
        $data['aa1'] = 'active';
        $data['a1']  = 'act1';
        $data['risk_id']  = $id;
        $consultant_id  = $this->session->userdata('consultant_id');
        if ($consultant_id) {
            $data['title'] = "Scope";
            $this->db->where('risk_id', $id);
            $temp = $this->db->get('risk_sign')->row();
            if (count($temp) > 0){
                $data['id'] = $temp->id;
                $data['scope'] = $temp->scope;
            }else{
                $data['id'] = '0';
                $data['scope'] = '';
            }
            $this->load->view('consultant/risk_scope', $data);
        } else {
            redirect('Welcome');
        }
    }
    public function add_risk_scope() {
        $data['aa1'] = 'active';
        $data['a1']  = 'act1';
        $data['title'] = "Policy";
        $id = $this->input->post('id', TRUE);
        $risk_id = $this->input->post('risk_id', TRUE);
        $scope = $this->input->post('scope', TRUE);
        if ($id == 0){
            $result = $this->db->insert('risk_sign', array('risk_id'=>$risk_id,'scope'=>$scope));
            $id = $this->db->insert_id();
        }else{
            $this->db->where('id', $id);
            $result = $this->db->update('risk_sign', array('risk_id'=>$risk_id,'scope'=>$scope));
        }
        $this->db->where('id', $id);
        $temp = $this->db->get('risk_sign')->row();
        $data['id'] = $id;
        $data['policy'] = $temp->policy;
        $this->load->view('consultant/risk_sign', $data);
    }
	public function add_risk_sign() {
		$data['aa1'] = 'active';
		$data['a1']  = 'act1';
		$id = $this->input->post('id', TRUE);
		$policy = $this->input->post('policy', TRUE);
		$this->db->where('id', $id);
		$result = $this->db->update('risk_sign', array('policy'=>$policy));
		redirect("consultant/risk_list");
	}
    public function operational_process($id = NULL)
    {
        $data['aa1'] = 'active';
        $data['a1']  = 'act1';
        $data['risk_id']  = $id;
        $consultant_id  = $this->session->userdata('consultant_id');
		$data['user_type']  = $this->session->userdata('user_type');
        if ($consultant_id) {
            $data['title'] = "Process";
			$this->db->where('company_id', $consultant_id);
            $this->db->where('del_flag', 0);
			$data['processes'] = $this->db->get('manage_process')->result();
			$this->db->where('consultant_id', $consultant_id);
            $data['employees'] = $this->db->get('employees')->result();
            $this->load->view('consultant/operational_process', $data);
        } else {
            redirect('Welcome');
        }
    }
    public function operational_process_read($id = NULL)
    {
        $consultant_id  = $this->session->userdata('consultant_id');
        $user_type  = $this->session->userdata('user_type');

        $displayStart = $this->input->post('iDisplayStart');
        $displayLength = $this->input->post('iDisplayLength');
        $search = $this->input->post('sSearch');
        $sortingCols = $this->input->post('iSortingCols');
        $risk_id = $this->input->post('risk_id');
        $flag = $this->input->post('flag');

        $data = array();
        if (isset($id)) {
            $data['process'] = '';
        } else {
            $filter['del_flag'] = 0;
            if ($displayLength != -1) {
                $filter['start'] = $displayStart;
                $filter['limit'] = $displayLength;
                $filter['search'] = $search;
            }
            $order = array();
            for ($i = 0; $i < $sortingCols; $i++) {
                $sortCol = $this->input->post('iSortCol_' . $i);
                $sortDir = $this->input->post('sSortDir_' . $i);
                $dataProp = $this->input->post('mDataProp_' . $sortCol);

                $order[$dataProp] = $sortDir;
            }
            $sql = "SELECT a.*,(select employees.employee_name from employees where employees.employee_id = a.process_owner) process_owner_name from outsource_process a where
                            a.risk_id = " . $risk_id . " and a.del_flag = 0 and a.flag = ".$flag;
            if ($search != ''){
                $sql .= " and (a.name like '%".$search."%' OR a.description like '%".$search."%')";
            }
			if ($user_type == "process_owner"){
				$sql .= " and a.process_owner = ".$this->session->userdata('employee_id');
			}
            $sql .= " ORDER BY a.reg_date DESC";
			$data['processes'] = $this->db->query($sql)->result();
			$data['iTotalDisplayRecords'] = count($data['processes']);
			unset($filter['search']);
			$data['iTotalRecords'] = count($data['processes']);
			if ($displayLength != -1) {
				$sql .= " limit ".$displayStart.",".$displayLength;
			}
            $data['processes'] = $this->db->query($sql)->result();
            $data['sEcho'] = $search;
        }
        $this->render_json($data);
    }
    public function add_operational_process()
    {
        $data['id'] = $this->input->post("id");
        $data['risk_id'] = $this->input->post("risk_id");
        $process_id = $this->input->post("process");
        $data['process_owner'] = $this->input->post("process_owner");

        if ($data['id'] != '0'){
			$this->db->where('id', $process_id);
			$temp = $this->db->get('manage_process')->row();
			$data['name'] = $temp->name;
			$data['description'] = $temp->description;
			$this->db->where('id', $data['id']);
            $result = $this->db->update('outsource_process', $data);
        }else{
			$sql = "select * from risk where id = ".$data['risk_id'];
			$type_flag = @$this->db->query($sql)->row()->risk_type;
            $data['flag'] = $this->input->post("flag");
			$this->db->where('id', $process_id);
            if ($type_flag == 1){
                $temp = $this->db->get('manage_process')->row();
            }else
			if ($type_flag == 2){
				$temp = $this->db->get('manage_pre_process')->row();
			}else if ($type_flag == 3){
				$temp = $this->db->get('manage_additional_process')->row();
			}

			$data['name'] = $temp->name;
			$data['description'] = $temp->description;
            $result = $this->db->insert('outsource_process', $data);
        }
        if ($result > 0){
            echo "success";
        }else{
            echo "failed";
        }
    }
    public function delete_operational_process() {
        $id = $this->input->post('ids', TRUE);
        $this->db->where('id', $id);
        $result = $this->db->update('outsource_process', array('del_flag'=>'1'));
        echo json_encode(array('success'=>$result));
    }
    public function select_sme($id = NULL)
    {
        $data['aa1'] = 'active';
        $data['a1']  = 'act1';
        $data['process_id']  = $id;
        $consultant_id  = $this->session->userdata('consultant_id');
        $user_type  = $this->session->userdata('user_type');
		$data["user_type"]  = $this->session->userdata('user_type');
        if ($consultant_id) {
			$this->db->join("risk","risk.id = outsource_process.risk_id","left");
			$this->db->where('outsource_process.id', $id);
			$temp = @$this->db->get('outsource_process')->row()->risk_type;
			if ($user_type == "monitor"){
				if ($temp == 1){
					redirect('consultant/get_operational_child_process/'.$id);
				}else{
					redirect('consultant/get_other_child_process/'.$id);
				}
			}else{
				$data['title'] = "Select Process Owner";
				$this->load->view('consultant/select_sme', $data);
			}
        } else {
            redirect('Welcome');
        }
    }
    public function select_sme_read($id = NULL)
    {
        $consultant_id  = $this->session->userdata('consultant_id');

        $displayStart = $this->input->post('iDisplayStart');
        $displayLength = $this->input->post('iDisplayLength');
        $search = $this->input->post('sSearch');
        $sortingCols = $this->input->post('iSortingCols');
        $process_id = $this->input->post('process_id');

        $data = array();
        if (isset($id)) {
            $data['sme'] = '';
        } else {
            $filter['del_flag'] = 0;
            if ($displayLength != -1) {
                $filter['start'] = $displayStart;
                $filter['limit'] = $displayLength;
                $filter['search'] = $search;
            }
            $order = array();
            for ($i = 0; $i < $sortingCols; $i++) {
                $sortCol = $this->input->post('iSortCol_' . $i);
                $sortDir = $this->input->post('sSortDir_' . $i);
                $dataProp = $this->input->post('mDataProp_' . $sortCol);

                $order[$dataProp] = $sortDir;
            }
            $sql = "SELECT *,'0' flag from employees where consultant_id = " . $consultant_id . " and status = 1";
            if ($search != ''){
                $sql .= " and (employee_name like '%".$search."%' OR employee_email like '%".$search."%')";
            }
            $sql .= " ORDER BY created_at DESC";
			$employees = $this->db->query($sql)->result();
			$data['iTotalDisplayRecords'] = count($employees);
			unset($filter['search']);
			$data['iTotalRecords'] = count($employees);
			if ($displayLength != -1) {
				$sql .= " limit ".$displayStart.",".$displayLength;
			}
            $employees = $this->db->query($sql)->result();
            $this->db->where('id', $process_id);
            $temp = @$this->db->get('outsource_process')->row()->sme;
            $checked = explode(",",$temp);
            if ($temp != ''){
                for ($i = 0;$i<count($checked);$i++){
                    for ($j = 0;$j<count($employees);$j++){
                        if ($employees[$j]->employee_id == $checked[$i]){
                            $employees[$j]->flag = 1;
                        }
                    }
                }
            }
            $data['smes'] = $employees;
            $data['sEcho'] = $search;
        }
        $this->render_json($data);
    }
	public function save_select_sme()
	{
		$id = $this->input->post("process_id");
		$sme = $this->input->post("select_sme");
		$consultant_id  = $this->session->userdata('consultant_id');
		$data["user_type"]  = $this->session->userdata('user_type');

		$this->db->where('id', $id);
		$result = $this->db->update('outsource_process', array("sme"=>$sme));
		$this->db->join("risk","risk.id = outsource_process.risk_id","left");
		$this->db->where('outsource_process.id', $id);
		$temp = @$this->db->get('outsource_process')->row()->risk_type;
		$sql = "select risk.* from risk LEFT join outsource_process on outsource_process.risk_id = risk.id where outsource_process.id = ".$id;
		$type = @$this->db->query($sql)->row()->assess_type;
		$data['assess_type'] = explode(",",$type);
		$data['outsource_id'] = $id;

		if ($temp == 1){
			$sql = "select process.*,process_step.name process_step_name from process LEFT join process_step on process_step.id = process.process_step where process.outsource_id = ".$id." and process.del_flag = 0";
			$data['processes'] = $this->db->query($sql)->result();
			foreach ($data['processes'] as $items) {
				$this->db->where('id', $data['outsource_id']);
				$data['risk_id'] = @$this->db->get('outsource_process')->row()->risk_id;
				$this->db->where('type', 'Food');
				$this->db->where('risk_id', $data['risk_id']);
				$tmp_value = @$this->db->get('rating_matrix')->row();
				if (count((array)$tmp_value) > 0) {
					$tmp_data['food_like'] = $tmp_value->like_id;
					$tmp_data['food_conse'] = $tmp_value->conse_id;
					$tmp_data['food_value'] = $tmp_value->value;
				}
				$this->db->where('type', 'Environmental');
				$this->db->where('risk_id', $data['risk_id']);
				$tmp_value = @$this->db->get('rating_matrix')->row();
				if (count((array)$tmp_value) > 0) {
					$tmp_data['environmental_like'] = $tmp_value->like_id;
					$tmp_data['environmental_conse'] = $tmp_value->conse_id;
					$tmp_data['environmental_value'] = $tmp_value->value;
				}
				$this->db->where('type', 'TACCP');
				$this->db->where('risk_id', $data['risk_id']);
				$tmp_value = @$this->db->get('rating_matrix')->row();
				if (count((array)$tmp_value) > 0) {
					$tmp_data['taccp_like'] = $tmp_value->like_id;
					$tmp_data['taccp_conse'] = $tmp_value->conse_id;
					$tmp_data['taccp_value'] = $tmp_value->value;
				}
				$this->db->where('type', 'Quality');
				$this->db->where('risk_id', $data['risk_id']);
				$tmp_value = @$this->db->get('rating_matrix')->row();
				if (count((array)$tmp_value) > 0) {
					$tmp_data['quality_like'] = $tmp_value->like_id;
					$tmp_data['quality_conse'] = $tmp_value->conse_id;
					$tmp_data['quality_value'] = $tmp_value->value;
				}
				$this->db->where('type', 'Safety');
				$this->db->where('risk_id', $data['risk_id']);
				$tmp_value = @$this->db->get('rating_matrix')->row();
				if (count((array)$tmp_value) > 0) {
					$tmp_data['safety_like'] = $tmp_value->like_id;
					$tmp_data['safety_conse'] = $tmp_value->conse_id;
					$tmp_data['safety_value'] = $tmp_value->value;
				}
				$this->db->where('type', 'VACCP');
				$this->db->where('risk_id', $data['risk_id']);
				$tmp_value = @$this->db->get('rating_matrix')->row();
				if (count((array)$tmp_value) > 0) {
					$tmp_data['vaccp_like'] = $tmp_value->like_id;
					$tmp_data['vaccp_conse'] = $tmp_value->conse_id;
					$tmp_data['vaccp_value'] = $tmp_value->value;
				}
				$this->db->where('process_id', $items->id);
				$this->db->update('process_risk_rating', $tmp_data);
				$sql = "select risk.* from risk left join process on process.risk_id = risk.id where process.id = " . $items->id;
				$tmp_type = @$this->db->query($sql)->row()->assess_type;
				$assess_type = explode(",", $tmp_type);
				foreach ($assess_type as $row) {
					switch ($row) {
						case "Food":
							$temp_type = 1;
							break;
						case "Quality":
							$temp_type = 2;
							break;
						case "Environmental":
							$temp_type = 3;
							break;
						case "Safety":
							$temp_type = 4;
							break;
						case "TACCP":
							$temp_type = 5;
							break;
						case "VACCP":
							$temp_type = 6;
							break;
					}
					$sql = "select IF (
								(select " . strtolower($row) . "_value from process_risk_rating where process_id = " . $items->id . ")
									>= a. START && (select " . strtolower($row) . "_value from process_risk_rating where process_id = " . $items->id . ")
									<= a.END,a. LEVEL,NULL) name
							FROM
								risk_value a where company_id = " . $consultant_id . " and type = " . $temp_type . " having name is not NULL";
					$temp_value = $this->db->query($sql)->row();
					if (count((array)$temp_value) > 0) {
						$sql = "update process_risk_rating set " . strtolower($row) . "_value = '" . $temp_value->name . "' where process_id = " . $items->id;
						$this->db->query($sql);
					}
				}
			}
			$sql = "select a.* from process_risk_rating a left join process b on a.process_id = b.id where b.outsource_id = ".$id;
			$data['ratings'] = $this->db->query($sql)->result();
			$sql = "select * from likelihood where company_id = ".$consultant_id." and type != 'strategic' and del_flag = 0 order by reg_date";
			$data['likelihood'] = $this->db->query($sql)->result();
			$sql = "select * from consequence where company_id = ".$consultant_id." and type != 'strategic' and del_flag = 0 order by reg_date";
			$data['consequence'] = $this->db->query($sql)->result();
			$this->load->view('consultant/operational_child_process', $data);
		}else{
			$sql = "select process.*,process_step.name process_step_name from process LEFT join process_step on process_step.id = process.process_step where process.outsource_id = ".$id." and process.del_flag = 0";
			$data['processes'] = $this->db->query($sql)->result();
			$this->load->view('consultant/other_child_process', $data);
		}
	}
	public function get_operational_child_process($temp_id = NULL)
	{
		$id = $this->input->post("outsource_id");
		if ($temp_id != NULL){
			$id = $temp_id;
		}
		$consultant_id  = $this->session->userdata('consultant_id');
		$data['user_type']  = $this->session->userdata('user_type');

		$this->db->join("risk","risk.id = outsource_process.risk_id","left");
		$this->db->where('outsource_process.id', $id);
		$temp = @$this->db->get('outsource_process')->row()->risk_type;
		$sql = "select risk.* from risk LEFT join outsource_process on outsource_process.risk_id = risk.id where outsource_process.id = ".$id;
		$type = @$this->db->query($sql)->row()->assess_type;
		$data['assess_type'] = explode(",",$type);
		$data['outsource_id'] = $id;

		// $sql = "select process.* from process where process.outsource_id = ".$id." and process.del_flag = 0";
		// $data['processes'] = $this->db->query($sql)->result();
		// $sql = "select a.* from process_risk_rating a left join process b on a.process_id = b.id where b.id = ".$id;
		// $data['ratings'] = $this->db->query($sql)->result();
		// $sql = "select * from likelihood where company_id = ".$consultant_id." and type != 'strategic' and del_flag = 0 order by reg_date";
		// $data['likelihood'] = $this->db->query($sql)->result();
		// $sql = "select * from consequence where company_id = ".$consultant_id." and type != 'strategic' and del_flag = 0 order by reg_date";
		// $data['consequence'] = $this->db->query($sql)->result();
		$sql = "select process.*,process_step.name process_step_name from process LEFT join process_step on process_step.id = process.process_step where process.outsource_id = ".$id." and process.del_flag = 0";
		$data['processes'] = $this->db->query($sql)->result();
		$sql = "select a.* from process_risk_rating a left join process b on a.process_id = b.id where b.outsource_id = ".$id;
		$data['ratings'] = $this->db->query($sql)->result();
		$sql = "select * from likelihood where company_id = ".$consultant_id." and type != 'strategic' and del_flag = 0 order by reg_date";
		$data['likelihood'] = $this->db->query($sql)->result();
		$sql = "select * from consequence where company_id = ".$consultant_id." and type != 'strategic' and del_flag = 0 order by reg_date";
		$data['consequence'] = $this->db->query($sql)->result();
		$this->load->view('consultant/operational_child_process', $data);
	}
	public function get_other_child_process($temp_id = NULL)
	{
		$id = $this->input->post("outsource_id");
		if ($temp_id != NULL){
			$id = $temp_id;
		}
		$consultant_id  = $this->session->userdata('consultant_id');
		$data["user_type"]  = $this->session->userdata('user_type');

		$this->db->join("risk","risk.id = outsource_process.risk_id","left");
		$this->db->where('outsource_process.id', $id);
		$temp = @$this->db->get('outsource_process')->row()->risk_type;
		$sql = "select risk.* from risk LEFT join outsource_process on outsource_process.risk_id = risk.id where outsource_process.id = ".$id;
		$type = @$this->db->query($sql)->row()->assess_type;
		$data['assess_type'] = explode(",",$type);
		$data['outsource_id'] = $id;

		$sql = "select process.* from process where process.outsource_id = ".$id." and process.del_flag = 0";
		$data['processes'] = $this->db->query($sql)->result();
		$this->load->view('consultant/other_child_process', $data);
	}
	public function add_operational_child_process() {
		$consultant_id  = $this->session->userdata('consultant_id');
		$id = $this->input->post('id', TRUE);
		$data['outsource_id'] = $this->input->post('outsource_id', TRUE);
		$data['flag'] = $this->input->post('flag', TRUE);
		$data['process_step'] = $this->input->post('process_step', TRUE);
		$data['Food'] = $this->input->post('Food', TRUE);
		$data['Environmental'] = $this->input->post('Environmental', TRUE);
		$data['TACCP'] = $this->input->post('TACCP', TRUE);
		$data['Quality'] = $this->input->post('Quality', TRUE);
		$data['Safety'] = $this->input->post('Safety', TRUE);
		$data['VACCP'] = $this->input->post('VACCP', TRUE);

		if ($id != 0){
			$this->db->where('id', $id);
			$result = $this->db->update('process', $data);
		}else if ($id == 0){
			$this->db->where('id', $data['outsource_id']);
			$data['risk_id'] = @$this->db->get('outsource_process')->row()->risk_id;
			$this->db->set('reg_date','now()',FALSE);
			$result = $this->db->insert('process', $data);
			$last_id = $this->db->insert_id();

			$this->db->where('type', 'Food');
			$this->db->where('risk_id', $data['risk_id']);
			$tmp_value =  @$this->db->get('rating_matrix')->row();
			if (is_array($tmp_value) && count($tmp_value) > 0){
				$tmp_data['food_like'] = $tmp_value->like_id;
				$tmp_data['food_conse'] = $tmp_value->conse_id;
				$tmp_data['food_value'] = $tmp_value->value;
			}
			$this->db->where('type', 'Environmental');
			$this->db->where('risk_id', $data['risk_id']);
			$tmp_value =  @$this->db->get('rating_matrix')->row();
			if (is_array($tmp_value) && count($tmp_value) > 0){
				$tmp_data['environmental_like'] = $tmp_value->like_id;
				$tmp_data['environmental_conse'] = $tmp_value->conse_id;
				$tmp_data['environmental_value'] = $tmp_value->value;
			}
			$this->db->where('type', 'TACCP');
			$this->db->where('risk_id', $data['risk_id']);
			$tmp_value =  @$this->db->get('rating_matrix')->row();
			if (is_array($tmp_value) && count($tmp_value) > 0){
				$tmp_data['taccp_like'] = $tmp_value->like_id;
				$tmp_data['taccp_conse'] = $tmp_value->conse_id;
				$tmp_data['taccp_value'] = $tmp_value->value;
			}
			$this->db->where('type', 'Quality');
			$this->db->where('risk_id', $data['risk_id']);
			$tmp_value =  @$this->db->get('rating_matrix')->row();
			if (is_array($tmp_value) && count($tmp_value) > 0){
				$tmp_data['quality_like'] = $tmp_value->like_id;
				$tmp_data['quality_conse'] = $tmp_value->conse_id;
				$tmp_data['quality_value'] = $tmp_value->value;
			}
			$this->db->where('type', 'Safety');
			$this->db->where('risk_id', $data['risk_id']);
			$tmp_value =  @$this->db->get('rating_matrix')->row();
			if (is_array($tmp_value) && count($tmp_value) > 0){
				$tmp_data['safety_like'] = $tmp_value->like_id;
				$tmp_data['safety_conse'] = $tmp_value->conse_id;
				$tmp_data['safety_value'] = $tmp_value->value;
			}
			$this->db->where('type', 'VACCP');
			$this->db->where('risk_id', $data['risk_id']);
			$tmp_value =  @$this->db->get('rating_matrix')->row();
			if (is_array($tmp_value) && count($tmp_value) > 0){
				$tmp_data['vaccp_like'] = $tmp_value->like_id;
				$tmp_data['vaccp_conse'] = $tmp_value->conse_id;
				$tmp_data['vaccp_value'] = $tmp_value->value;
			}
			$tmp_data['process_id'] = $last_id;
			$this->db->insert('process_risk_rating', $tmp_data);
			$sql = "select risk.* from risk left join process on process.risk_id = risk.id where process.id = ".$last_id;
			$tmp_type = @$this->db->query($sql)->row()->assess_type;
			$assess_type = explode(",",$tmp_type);
			foreach ($assess_type as $row){
				switch ($row){
					case "Food":
						$temp_type = 1;
						break;
					case "Quality":
						$temp_type = 2;
						break;
					case "Environmental":
						$temp_type = 3;
						break;
					case "Safety":
						$temp_type = 4;
						break;
					case "TACCP":
						$temp_type = 5;
						break;
					case "VACCP":
						$temp_type = 6;
						break;
				}
				$sql = "select IF (
								(select ".strtolower($row)."_value from process_risk_rating where process_id = ".$last_id.")
									>= a. START && (select ".strtolower($row)."_value from process_risk_rating where process_id = ".$last_id.")
									<= a.END,a. LEVEL,NULL) name
							FROM
								risk_value a where company_id = ".$consultant_id." and type = ".$temp_type." having name is not NULL";
				$temp_value = $this->db->query($sql)->row();
				if (is_array($tmp_value) && count($temp_value) > 0){
					$sql = "update process_risk_rating set ".strtolower($row)."_value = '".$temp_value->name."' where process_id = ".$last_id;
					$this->db->query($sql);
				}
			}
		}
		redirect("Consultant/get_operational_child_process/".$data['outsource_id']);
	}
	public function add_other_child_process() {
		$consultant_id  = $this->session->userdata('consultant_id');
		$id = $this->input->post('id', TRUE);
		$data['outsource_id'] = $this->input->post('outsource_id', TRUE);
		$data['flag'] = $this->input->post('flag', TRUE);
		$data['process_step'] = $this->input->post('process_step', TRUE);
		$data['Food'] = $this->input->post('Food', TRUE);
		$data['Environmental'] = $this->input->post('Environmental', TRUE);
		$data['TACCP'] = $this->input->post('TACCP', TRUE);
		$data['Quality'] = $this->input->post('Quality', TRUE);
		$data['Safety'] = $this->input->post('Safety', TRUE);
		$data['VACCP'] = $this->input->post('VACCP', TRUE);

		if ($id != 0){
			$this->db->where('id', $id);
			$result = $this->db->update('process', $data);
		}else if ($id == 0){
			$this->db->where('id', $data['outsource_id']);
			$data['risk_id'] = @$this->db->get('outsource_process')->row()->risk_id;
			$this->db->set('reg_date','now()',FALSE);
			$result = $this->db->insert('process', $data);
		}
		redirect("Consultant/get_other_child_process/".$data['outsource_id']);
	}

	public function employees() {
		$consultant_id = $this->session->userdata('consultant_id');
		$data['cc1'] = 'active';
		$data['c1']  = 'act1';
		$search_name = $this->input->post('search_name');
		$usertype_sel = $this->input->post('usertype_sel');
		if ($consultant_id) {
			$data['title'] = "Employee List";
			$plan_id = @$this->db->query("SELECT * FROM `consultant` WHERE `consultant_id`='$consultant_id'")->row()->plan_id;
			$rowdata1 = @$this->db->query("SELECT COUNT(employee_id) as emps FROM `employees` WHERE `consultant_id`='$consultant_id'")->row()->emps;
			if ($plan_id) {
				$rowdata = @$this->db->query("SELECT * FROM `plan` WHERE `plan_id`='$plan_id'")->row()->no_of_user;
				$data['total_account'] = $rowdata1;
				$data['limit']         = $rowdata;
				$data['reached']       = (($rowdata1 * 100) / $rowdata);
			}
			$where = "";
			$data['search_name'] = "";
			if($search_name != Null && $search_name != '') {
				$data['search_name'] = $search_name;
				$where .= " AND e.employee_name like '%" . $search_name . "%'";
			}
			if($usertype_sel != Null && $usertype_sel != '0') {
				$where .= " AND p.type_id = " . $usertype_sel;
			}
			$sql = "SELECT * , GROUP_CONCAT(t.utype_name) type_name FROM employees e
 					LEFT JOIN permision p ON e.employee_id = p.employee_id
                    LEFT JOIN user_type t ON p.type_id = t.utype_id
				  	WHERE e.consultant_id = " . $consultant_id . $where . " GROUP BY e.employee_id";
			$data['employees'] = $this->db->query($sql)->result();
			$this->load->view('consultant/employees', $data);
		} else {
			$this->redirect('welcome');
		}
	}

	public function add_employee()
	{
		$confirm = TRUE;
		$consultant_id = $this->session->userdata('consultant_id');
		if ($consultant_id) {
			$employee_name  = $this->input->post('add_name');
			$employee_email = $this->input->post('add_email');
            /*=-=- check user mobile number valid start =-=-*/
            $this->load->library('phone_RK');
            $phone          = formatMobileNumber($this->input->post('add_phone'));;
            $phone_response = $this->phone_rk->checkPhoneNumber($phone);
            if (!$phone_response['success']){
                $this->session->set_flashdata('phone_response', $phone_response);
                redirect($_SERVER['HTTP_REFERER']);
                return;
            }
            /*=-=- check user mobile number valid end =-=-*/
			$role_name = $this->input->post('add_role');
			$username = $this->input->post('add_username');
			$password = getHashedPassword($this->input->post('add_password'));
			$executive = $this->input->post('executive');
			$process_owner_sme = $this->input->post('process_owner_sme');
			$employee = $this->input->post('employee');
			$pm_mo_sv = $this->input->post('pm_mo_sv');
			$procurement = $this->input->post('procurement');
			$warehousing = $this->input->post('warehousing');
			$sales = $this->input->post('sales');
			$manufacturing = $this->input->post('manufacturing');
			$created_at = date('Y-m-d');
			$data = array(
                'consultant_id' => $consultant_id,
                'employee_name' => $employee_name,
                'username' => $username,
                'employee_email' => $employee_email,
                'employee_phone' => $phone,
                'role' => $role_name,
                'password' => $password,
                'created_at' => $created_at,
                'status' => 1
			);

			$employee_list = $this->db->query("SELECT * FROM `employees` WHERE `username`='$username'")->row();			
			if($employee_list == null) {				
				$plan_id = @$this->db->query("SELECT * FROM `consultant` WHERE `consultant_id`='$consultant_id'")->row()->plan_id;
				if ($plan_id) {
					$rowdata = @$this->db->query("SELECT * FROM `plan` WHERE `plan_id`='$plan_id'")->row()->no_of_user;
				}
				$rowdata1 = @$this->db->query("SELECT COUNT(employee_id) as emps FROM `employees` WHERE `consultant_id`='$consultant_id'")->row()->emps;				
				if ($rowdata == $rowdata1 || $rowdata1 > $rowdata) {
					$this->session->set_flashdata('message', 'failed');
					redirect('Consultant/employees');
				} else {
					$done = $this->db->insert('employees', $data);
					if ($done) {

						//-------------------------------added_by_Mei------------------------------
						$this->db->order_by('employee_id', 'asc');
						$employee_id = $this->db->get('employees')->last_row()->employee_id;
						if($executive != "" && $executive != null) {
							$tmp = array(
									'employee_id' => $employee_id,
									'type_id' => $executive
							);
							$confirm = $this->db->insert('permision', $tmp);
						}
						if($process_owner_sme != "" && $process_owner_sme != null) {
							$tmp = array(
									'employee_id' => $employee_id,
									'type_id' => $process_owner_sme
							);
							$confirm = $confirm & $this->db->insert('permision', $tmp);
						}
						if($employee != "" && $employee != null) {
							$tmp = array(
									'employee_id' => $employee_id,
									'type_id' => $employee
							);
							$confirm = $confirm & $this->db->insert('permision', $tmp);
						}
						if($pm_mo_sv != "" && $pm_mo_sv != null) {
							$tmp = array(
									'employee_id' => $employee_id,
									'type_id' => $pm_mo_sv
							);
							$confirm = $confirm & $this->db->insert('permision', $tmp);
						}
						if($procurement != "" && $procurement != null) {
							$tmp = array(
									'employee_id' => $employee_id,
									'type_id' => $procurement
							);
							$confirm = $confirm & $this->db->insert('permision', $tmp);
						}
						if($warehousing != "" && $warehousing != null) {
							$tmp = array(
									'employee_id' => $employee_id,
									'type_id' => $warehousing
							);
							$confirm = $confirm & $this->db->insert('permision', $tmp);
						}
						if($sales != "" && $sales != null) {
							$tmp = array(
									'employee_id' => $employee_id,
									'type_id' => $sales
							);
							$confirm = $confirm & $this->db->insert('permision', $tmp);
						}
						if($manufacturing != "" && $manufacturing != null) {
							$tmp = array(
									'employee_id' => $employee_id,
									'type_id' => $manufacturing
							);
							$confirm = $confirm & $this->db->insert('permision', $tmp);
						}
						//--------------------------------------------------------------------------

						$this->session->set_flashdata('message', 'success');
						redirect('Consultant/employees');
					} else {
						$this->session->set_flashdata('message', 'error');
						redirect('Consultant/employees');
					}
				}
			} else {
				$this->session->set_flashdata('message', 'live_err');
				redirect('Consultant/employees');
			}
		} else {
			redirect('Welcome');
		}
	}
	public function finduser()
	{
		$consultant_id = $this->session->userdata('consultant_id');
		if ($consultant_id) {
			$id = $this->input->post('id');

			$sql = "SELECT
                            *, GROUP_CONCAT(p.type_id) type_ids
                        FROM
                            employees e
                        LEFT JOIN permision p ON e.employee_id = p.employee_id
                        WHERE
                            e.consultant_id = " . $consultant_id . " AND e.employee_id = " . $id . "
                        GROUP BY
                            e.employee_id";
			$done = $this->db->query($sql)->row();
			echo json_encode($done);
		} else {
			redirect('Welcome');
		}
	}
	public function edit_employee()
	{
		$confirm = TRUE;
		$consultant_id = $this->session->userdata('consultant_id');
		if ($consultant_id) {
			$employee_id = $this->input->post("employee_id");
			$employee_name  = $this->input->post('edit_name');
			$employee_email = $this->input->post('edit_email');
            /*=-=- check user mobile number valid start =-=-*/
            $this->load->library('phone_RK');
            $phone          = formatMobileNumber($this->input->post('edit_phone'));;
            $phone_response = $this->phone_rk->checkPhoneNumber($phone);
            if (!$phone_response['success']){
                $this->session->set_flashdata('phone_response', $phone_response);
                redirect($_SERVER['HTTP_REFERER']);
                return;
            }
            /*=-=- check user mobile number valid end =-=-*/
			$role_name = $this->input->post('edit_role');
			$username = $this->input->post('edit_username');
			$password = getHashedPassword($this->input->post('edit_password'));
			$old_username = $this->input->post('old_username');
			$executive = $this->input->post('edit_executive');
			$process_owner_sme = $this->input->post('edit_process_owner_sme');
			$employee = $this->input->post('edit_employee');
			$pm_mo_sv = $this->input->post('edit_pm_mo_sv');
			$procurement = $this->input->post('edit_procurement');
			$warehousing = $this->input->post('edit_warehousing');
			$sales = $this->input->post('edit_sales');
			$manufacturing = $this->input->post('edit_manufacturing');

            $data = array(
                'consultant_id' => $consultant_id,
                'employee_name' => $employee_name,
                'username' => $username,
                'employee_email' => $employee_email,
                'employee_phone' => $phone,
                'role' => $role_name,
                'password' => $password,
                'status' => 1
            );
            if (empty(trim($this->input->post('edit_password')))){
                unset($data['password']);
            }

			$employee_list = $this->db->query("SELECT * FROM `employees` WHERE `username`='$username'")->row();
			if($employee_list == null) {
				$this->db->where("employee_id", $employee_id);
				$done = $this->db->update('employees', $data);
				if ($done) {

					//---------------------------------------------------------------------
					$this->db->where("employee_id", $employee_id);
					$this->db->delete("permision");

					if ($executive != "" && $executive != null) {
						$tmp = array(
								'employee_id' => $employee_id,
								'type_id' => $executive
						);
						$confirm = $this->db->insert('permision', $tmp);
					}
					if ($process_owner_sme != "" && $process_owner_sme != null) {
						$tmp = array(
								'employee_id' => $employee_id,
								'type_id' => $process_owner_sme
						);
						$confirm = $confirm & $this->db->insert('permision', $tmp);
					}
					if ($employee != "" && $employee != null) {
						$tmp = array(
								'employee_id' => $employee_id,
								'type_id' => $employee
						);
						$confirm = $confirm & $this->db->insert('permision', $tmp);
					}
					if ($pm_mo_sv != "" && $pm_mo_sv != null) {
						$tmp = array(
								'employee_id' => $employee_id,
								'type_id' => $pm_mo_sv
						);
						$confirm = $confirm & $this->db->insert('permision', $tmp);
					}
					if ($procurement != "" && $procurement != null) {
						$tmp = array(
								'employee_id' => $employee_id,
								'type_id' => $procurement
						);
						$confirm = $this->db->insert('permision', $tmp);
					}
					if ($warehousing != "" && $warehousing != null) {
						$tmp = array(
								'employee_id' => $employee_id,
								'type_id' => $warehousing
						);
						$confirm = $confirm & $this->db->insert('permision', $tmp);
					}
					if ($sales != "" && $sales != null) {
						$tmp = array(
								'employee_id' => $employee_id,
								'type_id' => $sales
						);
						$confirm = $confirm & $this->db->insert('permision', $tmp);
					}
					if ($manufacturing != "" && $manufacturing != null) {
						$tmp = array(
								'employee_id' => $employee_id,
								'type_id' => $manufacturing
						);
						$confirm = $confirm & $this->db->insert('permision', $tmp);
					}
					//---------------------------------------------------------------------

					$this->session->set_flashdata('message', 'update_success');
					redirect('Consultant/employees');
				} else {
					$this->session->set_flashdata('message', 'error');
					redirect('Consultant/employees');
				}
			} else {
				if($old_username == $username) {
					$this->db->where("employee_id", $employee_id);
					$done = $this->db->update('employees', $data);
					if ($done) {
						//---------------------------------------------------------------------
						$this->db->where("employee_id", $employee_id);
						$this->db->delete("permision");

						if ($executive != "" && $executive != null) {
							$tmp = array(
									'employee_id' => $employee_id,
									'type_id' => $executive
							);
							$confirm = $this->db->insert('permision', $tmp);
						}
						if ($process_owner_sme != "" && $process_owner_sme != null) {
							$tmp = array(
									'employee_id' => $employee_id,
									'type_id' => $process_owner_sme
							);
							$confirm = $confirm & $this->db->insert('permision', $tmp);
						}
						if ($employee != "" && $employee != null) {
							$tmp = array(
									'employee_id' => $employee_id,
									'type_id' => $employee
							);
							$confirm = $confirm & $this->db->insert('permision', $tmp);
						}
						if ($pm_mo_sv != "" && $pm_mo_sv != null) {
							$tmp = array(
									'employee_id' => $employee_id,
									'type_id' => $pm_mo_sv
							);
							$confirm = $confirm & $this->db->insert('permision', $tmp);
						}
						if ($procurement != "" && $procurement != null) {
							$tmp = array(
									'employee_id' => $employee_id,
									'type_id' => $procurement
							);
							$confirm = $this->db->insert('permision', $tmp);
						}
						if ($warehousing != "" && $warehousing != null) {
							$tmp = array(
									'employee_id' => $employee_id,
									'type_id' => $warehousing
							);
							$confirm = $confirm & $this->db->insert('permision', $tmp);
						}
						if ($sales != "" && $sales != null) {
							$tmp = array(
									'employee_id' => $employee_id,
									'type_id' => $sales
							);
							$confirm = $confirm & $this->db->insert('permision', $tmp);
						}
						if ($manufacturing != "" && $manufacturing != null) {
							$tmp = array(
									'employee_id' => $employee_id,
									'type_id' => $manufacturing
							);
							$confirm = $confirm & $this->db->insert('permision', $tmp);
						}
						//---------------------------------------------------------------------

						$this->session->set_flashdata('message', 'update_success');
						redirect('Consultant/employees');
					} else {
						$this->session->set_flashdata('message', 'error');
						redirect('Consultant/employees');
					}
				} else {
					$this->session->set_flashdata('message', 'live_err');
					redirect('Consultant/employees');
				}
			}
		} else {
			redirect('Welcome');
		}
	}
	public function add_barcode()
	{
		$data['control_id'] = $this->input->post("control_id");
		$data['product_name'] = $this->input->post("product_name");
		$data['product_barcode'] = $this->input->post("product_barcode");
		$data['product_quantity'] = $this->input->post("product_quantity");
		$data['product_barcode_image'] = $this->input->post("product_barcode_image");

		$data['records_name'] = $this->input->post("record_id");
		$data['records_barcode'] = $this->input->post("records_barcode");

		$data['traceability_name'] = $this->input->post("material_id");
		$data['traceability_barcode'] = $this->input->post("traceability_barcode");
		$data['traceability_quantity'] = $this->input->post("traceability_quantity");
		$data['traceability_barcode_image'] = $this->input->post("traceability_barcode_image");
		$data['supplier'] = $this->input->post("supplier_id");
		$data['customer'] = $this->input->post("customer_id");

		$data['machine_work'] = $this->input->post("machine_id");
		$data['machine_corrective'] = $this->input->post("machine_corrective");
		$data['machine_preventive'] = $this->input->post("machine_preventive");
		//$data['machine_barcode'] = $this->input->post("machine_barcode");

		$data['procedures_name'] = $this->input->post("procedure_id");
		$data['procedures_barcode'] = $this->input->post("procedures_barcode");
		$tmp_data['requirement_met'] = $this->input->post("requirement_met");
		$tmp_data['reason'] = $this->input->post("reason");
		$data['sign_image'] = $this->input->post("sign_info");
		$control_insert_id = $this->input->post("control_insert_id");


		$monitor_id = $this->input->post("monitor_id");
		$this->load->helper("string_helper");
		if (!empty($_FILES['procedures_file_path']['name'][0])) {
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$data['procedures_file_path'] = '';

			$procedures_file_path = array();
			foreach($_FILES['procedures_file_path']['name'] as $key => $val) {
				$upload_path = 'uploads/Doc/';
				$file_name = md5(random_string('alnum', 16));
				$file_ext = substr($_FILES['procedures_file_path']['name'][$key], strpos($_FILES['procedures_file_path']['name'][$key], "."));
				move_uploaded_file($_FILES['procedures_file_path']['tmp_name'][$key], $upload_path.$file_name.$file_ext);
				array_push($procedures_file_path, $file_name.$file_ext);
			}
			$data['procedures_file_path'] = json_encode($procedures_file_path);
		} else {
			$data['procedures_file_path'] = '';
		}
		if (!empty($_FILES['records_file_path']['name'][0])) {
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$data['records_file_path'] = '';

			$records_file_path = array();
			foreach($_FILES['records_file_path']['name'] as $key => $val) {
				$upload_path = 'uploads/Doc/';
				$file_name = md5(random_string('alnum', 16));
				$file_ext = substr($_FILES['records_file_path']['name'][$key], strpos($_FILES['records_file_path']['name'][$key], "."));
				move_uploaded_file($_FILES['records_file_path']['tmp_name'][$key], $upload_path.$file_name.$file_ext);
				array_push($records_file_path, $file_name.$file_ext);
			}
			$data['records_file_path'] = json_encode($records_file_path);
		} else {
			$data['records_file_path'] = '';
		}

		$this->db->where('id', $control_insert_id);
		$array = $this->db->get('control_barcode')->result();
		if (isset($array)){
			$this->db->where('control_id', $data['control_id']);
			$result = $this->db->update('control_barcode',$data);
		}else{
			//$result = $this->db->insert('control_barcode',$data);
		}
		//$result = $this->db->insert('control_barcode',$data);

		$this->db->where('id', $data['control_id']);
		$this->db->set('review_date','now()',FALSE);
		$result = $this->db->update('control_list',$tmp_data);

		$this->db->where('id', $data['control_id']);
		$process_id = @$this->db->get('control_list')->row()->process_id;
		$sidebar_history = $this->session->userdata('sidebar_history');


		// set monitor sign image

        $this->db->where('history_id', $monitor_id);
        $monitor_arr = array(
            'sign_image' => $data['sign_image']
        );

        $result = $this->db->update('monitoring_history',$monitor_arr);

		if ($sidebar_history == "-1"){
			redirect('Consultant/control_list/'.$process_id);
		}else if ($sidebar_history == "1"){
			redirect('Consultant/conduct');
		}

	}
	public function get_barcode_image()
	{
		$consultant_id = $this->session->userdata('consultant_id');
		$id = $this->input->post("id");
		if ($consultant_id) {
			/*$this->db->where('control_id', $id);
			$done = @$this->db->get('control_barcode')->row();*/
			$this->db->where('id', $id);
			$type = $this->input->post('type');
			$done = array();
			switch($type){
				case "product":
					$done = @$this->db->get('product')->row();
					break;
				case "material":
					$done = @$this->db->get('material')->row();
					break;
			}

			echo json_encode($done);
		} else {
			redirect('Welcome');
		}
	}
	public function save_signature()
	{
		if (isset($_REQUEST["id"]) && isset($_REQUEST["sign"]))
		{
			// Need to decode before saving since the data we received is already base64 encoded
			$unencodedData=base64_decode(substr($_REQUEST["sign"], strpos($_REQUEST["sign"], ",")+1));
			$imageName =  time() ."_sign.png";
			if(!file_exists("uploads/sign/" )){
				mkdir("uploads/sign/", 0777, TRUE);
			}
			$filepath = "uploads/sign/" . $imageName;

			$fp = fopen("$filepath", 'wb' );
			fwrite( $fp, $unencodedData);
			fclose( $fp );
			$this->db->where('id', $_REQUEST["id"]);
			$result = $this->db->update('control_list',array("sign_image"=>$imageName,"sign_status"=>'1'));

			echo "SUCCESS";
		} else {
			echo "FAILED";
		}
	}
	public function save_signature_control_barcode()
	{
		if (isset($_REQUEST["id"]) && isset($_REQUEST["sign"]))
		{
			// Need to decode before saving since the data we received is already base64 encoded
			$unencodedData=base64_decode(substr($_REQUEST["sign"], strpos($_REQUEST["sign"], ",")+1));
			$imageName =  time() ."_sign.png";
			if(!file_exists("uploads/sign/" )){
				mkdir("uploads/sign/", 0777, TRUE);
			}
			$filepath = "uploads/sign/" . $imageName;

			$fp = fopen("$filepath", 'wb' );
			fwrite( $fp, $unencodedData);
			fclose( $fp );

			echo $imageName;
		} else {
			echo "fail";
		}
	}

    public function save_signature_monitoring()
    {
        if (isset($_REQUEST["id"]) && isset($_REQUEST["sign"]))
        {
            // Need to decode before saving since the data we received is already base64 encoded
            $unencodedData=base64_decode(substr($_REQUEST["sign"], strpos($_REQUEST["sign"], ",")+1));
            $imageName =  time() ."_sign.png";
            if(!file_exists("uploads/sign/" )){
                mkdir("uploads/sign/", 0777, TRUE);
            }
            $filepath = "uploads/sign/" . $imageName;

            $fp = fopen("$filepath", 'wb' );
            fwrite( $fp, $unencodedData);
            fclose( $fp );

            echo $imageName;
        } else {
            echo "fail";
        }
    }

	public function save_signature_risk()
	{
		if (isset($_REQUEST["id"]) && isset($_REQUEST["sign"]))
		{
			// Need to decode before saving since the data we received is already base64 encoded
			$unencodedData=base64_decode(substr($_REQUEST["sign"], strpos($_REQUEST["sign"], ",")+1));
			$imageName =  time() ."_sign.png";
			if(!file_exists("uploads/sign/" )){
				mkdir("uploads/sign/", 0777, TRUE);
			}
			$filepath = "uploads/sign/" . $imageName;

			$fp = fopen("$filepath", 'wb' );
			fwrite( $fp, $unencodedData);
			fclose( $fp );
			$this->db->where('id', $_REQUEST["id"]);
			$result = $this->db->update('risk_sign',array("sign_file"=>$imageName));

			echo "SUCCESS";
		} else {
			echo "FAILED";
		}
	}
	public function check_rating() {
		$consultant_id  = $this->session->userdata('consultant_id');
		$risk_id = $this->input->post('risk_id', TRUE);
		$type = $this->input->post('type', TRUE);
		$this->db->where('risk_id', $risk_id);
		$this->db->where('type', $type);
		$temp1 = $this->db->get('rating_matrix')->result();
		$this->db->where('type', strtolower($type));
		$this->db->where('company_id', $consultant_id);
		$this->db->where('del_flag', "0");
		$temp2 = $this->db->get('likelihood')->result();
		$this->db->where('type', strtolower($type));
		$this->db->where('company_id', $consultant_id);
		$this->db->where('del_flag', "0");
		$temp3 = $this->db->get('consequence')->result();
		if (count($temp1) >= (count($temp2)*count($temp3))){
			$result = 1;
		}else{
			$result = 0;
		}
		echo json_encode(array('success'=>$result));
	}
	public function operational_check_rating() {
		$temp = 0;
		$consultant_id  = $this->session->userdata('consultant_id');
		$risk_id = $this->input->post('risk_id', TRUE);
		$this->db->where('id', $risk_id);
		$temp_type = @$this->db->get('risk')->row()->assess_type;
		$data['assess_type'] = explode(",",$temp_type);
		$this->db->where('risk_id', $risk_id);
		$temp1 = $this->db->get('rating_matrix')->result();
		foreach ($data['assess_type'] as $type) {
			$this->db->where('type', strtolower($type));
			$this->db->where('company_id', $consultant_id);
			$this->db->where('del_flag', "0");
			$temp2 = $this->db->get('likelihood')->result();
			$this->db->where('type', strtolower($type));
			$this->db->where('company_id', $consultant_id);
			$this->db->where('del_flag', "0");
			$temp3 = $this->db->get('consequence')->result();
			$temp = $temp + count($temp2)*count($temp3);
		}
		if (count($temp1) >= $temp){
			$result = 1;
		}else{
			$result = 0;
		}
		echo json_encode(array('success'=>$result));
	}
	public function car_action_notification($id = Null)
	{
		$company_id1             = $this->session->userdata('consultant_id');
		$data['admin_emails']    = @$this->db->query("SELECT * FROM `admin`")->row()->email;
		$data['comp_email']      = @$this->db->query("SELECT * FROM `consultant` WHERE `consultant_id`='$company_id1'")->row()->email;
		$data['employees_email'] = @$this->db->query("SELECT * FROM `employees` WHERE `consultant_id`='$company_id1' &&  `employee_email`!=''")->result();


		$data['bb1'] = 'active';
		$company_id  = $this->session->userdata('consultant_id');
		if ($company_id) {
			$data['title'] = "CAR ACTION NOTIFICATION";
			$this->db->where('id', $id);
			$data['standalone'] = $this->db->get('corrective_action_data')->row();
			$this->load->view('consultant/car_action_notification', $data);
		} else {
			redirect('Welcome');
		}
	}
	public function resolution_list()
	{
		$data['bb1']   = 'active';
		$data['b3']    = 'act1';
		$company_id    = $this->session->userdata('consultant_id');
		$data['title'] = "Corrective Action Resolution Log";
		if ($company_id) {
			$this->db->order_by('by_when_date', 'DESC');
			$this->db->where('company_id', $company_id);
			$this->db->where('process_status!=', 'Close');
			$data['standalone_data'] = $this->db->get('corrective_action_data')->result();
			$this->load->view('consultant/resolution_list', $data);
		} else {
			redirect('Welcome');
		}
	}
	public function resolution($id = '')
	{
		$data['bb1'] = 'active';
		$data['b3']  = 'act1';
		$company_id = $this->session->userdata('consultant_id');
		if ($company_id) {
			$this->db->where('consultant_id', $company_id);
			$data['employees'] = $this->db->get('employees')->result();
			$data['title']     = "Resolution";
			$this->db->where('id', $id);
			$data['standalone_data'] = $this->db->get('corrective_action_data')->row();
			$this->db->where('company_id', $company_id);
			$data['trigger_list'] = $this->db->get('trigger')->result();
			$this->db->where('company_id', $company_id);
			$data['customer_requirment_list'] = $this->db->get('customer_requirment')->result();
			$this->db->where('company_id', $company_id);
			$data['product_list'] = $this->db->get('product')->result();
			$this->db->where('company_id', $company_id);
			$data['process_step_list'] = $this->db->get('process_step')->result();
			$this->db->where('company_id', $company_id);
			$data['regulatory_requirement_list'] = $this->db->get('regulatory_requirement')->result();
			$this->db->where('company_id', $company_id);
			$data['shift_list'] = $this->db->get('shift')->result();
			$this->db->where('company_id', $company_id);
			$data['policy_list'] = $this->db->get('policy')->result();
			$this->db->where('company_id', $company_id);
			$data['mashine_list'] = $this->db->get('mashine')->result();

			$data['corrective_id'] = $id;

			$this->load->view('consultant/resolution', $data);
		} else {
			redirect('Welcome');
		}
	}
	public function update_resolution()
	{
		$company_id                 = $this->session->userdata('consultant_id');
		$employee_id                 = $this->session->userdata('employee_id');
		$trigger_id                 = $this->input->post('trigger_id');
		$customer_requirment        = $this->input->post('customer_requirment');
		$product                    = $this->input->post('product');
		$regulatory_requirement     = $this->input->post('regulatory_requirement');
		$policy                     = $this->input->post('policy');
		$shift                      = $this->input->post('shift');
		$process_step               = $this->input->post('process_step');
		$mashine_clause             = $this->input->post('mashine_clause');
		$occur_date                 = $this->input->post('occur_date');
		$prob_desc                  = $this->input->post('prob_desc');
		$correction                 = $this->input->post('correction');
		$root_cause                 = $this->input->post('root_cause');
		$business_impact            = $this->input->post('business_impact');
		$action_plan                = $this->input->post('action_plan');
		$by_when_date               = $this->input->post('by_when_date');
		$process_status             = $this->input->post('process_status');
		$type                       = $this->input->post('type');
		$closed_date                = date('Y-m-d');
		$corrective_action          = $this->input->post('corrective_action');
		$verification_effectiveness = $this->input->post('verification_effectiveness');
		$verification_question_flag = $this->input->post('verification_question_flag');
		$verification_flag          = $this->input->post('verification_flag');
		$action_taken               = $this->input->post('action_taken');
		$action_taken               = intval($action_taken) + 1;
		$form_id                    = $this->input->post('form_id');
		$process_owner_id			= $this->input->post('respo_id');
		$actionNo					= $this->input->post('actionNo');

		//---------------------------------get info------------------------------
		$monitoring_id = $this->db->where('id', $form_id)->get('corrective_action_data')->row()->monitoring_id;
		if($monitoring_id != 0){
			$control_id = $this->db->where('id', $monitoring_id)->get('monitoring_history')->row()->control_id;
			$inspector_id = $this->db->where('id', $control_id)->get('control_list')->row()->responsible_party;
			$inspector_info = $this->db->where('employee_id', $inspector_id)->get('employees')->row();
		}
		$process_owner_info = $this->db->where('employee_id', $process_owner_id)->get('employees')->row();
		$admin_info = $this->db->where('consultant_id', $company_id)->get('consultant')->row();
		//-----------------------------------------------------------------------

		if (!empty($_FILES['root_doc']['name'])) {
			$config['upload_path'] = 'uploads/Doc/';
			$config['file_name']   = time() . $_FILES['root_doc']['name'];
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('root_doc')) {
				$uploadData = $this->upload->data();
				$root_doc   = $uploadData['file_name'];
			} else {
				$root_doc = '';
			}
		} else {
			$root_doc = '';
		}
		if (!empty($_FILES['corrective_plan_doc']['name'])) {
			$config['upload_path'] = 'uploads/Doc/';
			$config['file_name']   = time() . $_FILES['corrective_plan_doc']['name'];
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('corrective_plan_doc')) {
				$uploadData          = $this->upload->data();
				$corrective_plan_doc = $uploadData['file_name'];
			} else {
				$corrective_plan_doc = '';
			}
		} else {
			$corrective_plan_doc = '';
		}
		if (!empty($_FILES['corrective_doc']['name'])) {
			$config['upload_path'] = 'uploads/Doc/';
			$config['file_name']   = time() . $_FILES['corrective_doc']['name'];
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('corrective_doc')) {
				$corrective_doc = $this->upload->data();
				$corrective_doc = $uploadData['file_name'];
			} else {
				$corrective_doc = '';
			}
		} else {
			$corrective_doc = '';
		}
		if (!empty($_FILES['verification_doc']['name'])) {
			$config['upload_path'] = 'uploads/Doc/';
			$config['file_name']   = time() . $_FILES['verification_doc']['name'];
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('verification_doc')) {
				$uploadData       = $this->upload->data();
				$verification_doc = $uploadData['file_name'];
			} else {
				$verification_doc = '';
			}
		} else {
			$verification_doc = '';
		}


		if ($company_id) {
			$data = array(
					'by_when_date' => $by_when_date,
					'type' => $type,
					'action_plan' => $action_plan,
					'business_impact' => $business_impact,
					'root_cause' => $root_cause,
					'correction' => $correction,
					'prob_desc' => $prob_desc,
					'mashine_clause' => $mashine_clause,
					'process_step' => $process_step,
					'shift' => $shift,
					'regulatory_requirement' => $regulatory_requirement,
					'policy' => $policy,
					'product' => $product,
					'customer_requirment' => $customer_requirment,
					'occur_date' => $occur_date,
					'trigger_id' => $trigger_id,
					'closed_date' => $closed_date,
					'process_status' => $process_status,
					'corrective_action' => $corrective_action,
					'verification_effectiveness' => $verification_effectiveness,
					'verification_flag' => $verification_flag,
					'action_taken' => $action_taken
			);

			if($root_doc != ''){
				$data['root_doc'] = $root_doc;
			}
			if($corrective_plan_doc != ''){
				$data['corrective_plan_doc'] = $corrective_plan_doc;
			}
			if($corrective_doc != ''){
				$data['corrective_doc'] = $corrective_doc;
			}
			if($verification_doc != ''){
				$data['verification_doc'] = $verification_doc;
			}

			$this->db->where('id', $form_id);
			$done = $this->db->update('corrective_action_data', $data);
			////////// Modify 2019-04-23 //////////////
			if ($process_status == 'Close') {
				$this->db->where('id', $form_id);
				$cor_action_data = $this->db->get('corrective_action_data')->row();
				$this->db->where('id', $cor_action_data->monitoring_id);
				$monitor = $this->db->get('monitoring_history')->row();
				$this->db->where('id', $monitor->control_id);
				$control = $this->db->get('control_list')->row();
				if ($control->workorder_id) {
					$this->db->where('id', $cor_action_data->monitoring_id);
					$this->db->update('monitoring_history', ['status' => 0]);

					$this->db->where(['control_id' => $monitor->control_id, 'status' => 1]);
					$this->db->from('monitoring_history');
					$count = $this->db->count_all_results();

					if ($count == 0) {
						$this->db->where('id', $control->workorder_id);
						$this->db->update('ims_manuorder_work_order', ['state' => 2, 'qualitychecker_id' =>$this->session->userdata('employee_id'), 'qualitycheck_at' => date('Y-m-d H:i:s')]);						
					}
				}
			}
			////////////////////////
			if ($done) {

				//-----------------------------------send email---------------------------
				if($employee_id == $process_owner_id){
					$email_temp = $this->getEmailTemp('Process Owner Takes Correction and Corrective Action(to Process Owner)');
					$email_temp['message'] = str_replace("{Process Owner NAME}", $process_owner_info->employee_name, $email_temp['message']);
					$email_temp['message'] = str_replace("{Admin NAME}", $admin_info->username, $email_temp['message']);
					$email_temp['message'] = str_replace("{Nonconformity #}", $actionNo, $email_temp['message']);
					$email_temp['message'] = str_replace("{Nonconformity Name}", $prob_desc, $email_temp['message']);
					$email_temp['message'] = str_replace("{LOGO}", "<img src='cid:logo'>", $email_temp['message']);
					$this->sendemail($process_owner_info->employee_email, 'Process Owner Takes Correction and Corrective Action', $email_temp['message'], $email_temp['subject']);
                    //---------------------------------------------- send sms ----------------------------------------------
                    if (!empty($process_owner_info->employee_phone) && $this->settings->otp_verification){
                        $phone = formatMobileNumber($process_owner_info->employee_phone, true);
                        /*=-=- check user mobile number valid start =-=-*/
                        $phone_response = $this->phone_rk->checkPhoneNumber($phone);
                        if ($phone_response['success']){
                            $message = "Hi {$process_owner_info->employee_name}".PHP_EOL;
                            $message.= "Congratulation you have submitted Correction and Corrective Action for {$actionNo} {$prob_desc} your Inspector will review your submission and verify whether the action taken is effective or not and closed or reopen the nonconformity. A notification will be sent to you once the Inspector reviews the action taken.".PHP_EOL;
                            $message.= "{$admin_info->username}";
                            $this->twill_rk->sendMsq($phone,$message);
                        }
                    }

					if(isset($inspector_id)){
						$email_temp = $this->getEmailTemp('Process Owner Takes Correction and Corrective Action(to Inspector)');
						$email_temp['message'] = str_replace("{Process Owner NAME}", $process_owner_info->employee_name, $email_temp['message']);
						$email_temp['message'] = str_replace("{Admin NAME}", $admin_info->username, $email_temp['message']);
						$email_temp['message'] = str_replace("{Inspector NAME}", $inspector_info->employee_name, $email_temp['message']);
						$email_temp['message'] = str_replace("{Nonconformity #}", $actionNo, $email_temp['message']);
						$email_temp['message'] = str_replace("{Nonconformity Name}", $prob_desc, $email_temp['message']);
						$email_temp['message'] = str_replace("{LOGO}", "<img src='cid:logo'>", $email_temp['message']);
						$this->sendemail($inspector_info->employee_email, 'Process Owner Takes Correction and Corrective Action', $email_temp['message'], $email_temp['subject']);
                        //---------------------------------------------- send sms ----------------------------------------------
                        if (!empty($inspector_info->employee_phone) && $this->settings->otp_verification){
                            $phone = formatMobileNumber($inspector_info->employee_phone, true);
                            /*=-=- check user mobile number valid start =-=-*/
                            $phone_response = $this->phone_rk->checkPhoneNumber($phone);
                            if ($phone_response['success']){
                                $message = "Hi {$inspector_info->employee_name}".PHP_EOL;
                                $message.= "{$process_owner_info->employee_name} have submitted Correction and Corrective Action for {$actionNo} {$prob_desc}. You are required to evaluate their submission and verify whether the action taken is effective or not and closed or reopen the nonconformity.".PHP_EOL;
                                $message.= "{$admin_info->username}";
                                $this->twill_rk->sendMsq($phone,$message);
                            }
                        }
					}

					$email_temp = $this->getEmailTemp('Process Owner Takes Correction and Corrective Action( to Admin)');
					$email_temp['message'] = str_replace("{Process Owner NAME}", $process_owner_info->employee_name, $email_temp['message']);
					$email_temp['message'] = str_replace("{Admin NAME}", $admin_info->username, $email_temp['message']);
					$email_temp['message'] = str_replace("{Nonconformity #}", $actionNo, $email_temp['message']);
					$email_temp['message'] = str_replace("{Nonconformity Name}", $prob_desc, $email_temp['message']);
					$email_temp['message'] = str_replace("{LOGO}", "<img src='cid:logo'>", $email_temp['message']);
					$this->sendemail($admin_info->email, 'Process Owner Takes Correction and Corrective Action', $email_temp['message'], $email_temp['subject']);
                    //---------------------------------------------- send sms ----------------------------------------------
                    if (!empty($admin_info->phone) && $this->settings->otp_verification){
                        $phone = formatMobileNumber($admin_info->phone, true);
                        /*=-=- check user mobile number valid start =-=-*/
                        $phone_response = $this->phone_rk->checkPhoneNumber($phone);
                        if ($phone_response['success']){
                            $message = "Hi {$admin_info->username}".PHP_EOL;
                            $message.= "{$process_owner_info->employee_name} have submitted Correction and Corrective Action for {$actionNo} {$prob_desc}.";
                            $this->twill_rk->sendMsq($phone,$message);
                        }
                    }
				}
				if($employee_id == $inspector_id){
					$tit = 'Inspector Verify a Nonconformity as effectively closed';
					if($verification_flag == 'Yes')
						$email_temp = $this->getEmailTemp('Inspector Verify a Nonconformity as effectively closed');
					else{
						$email_temp = $this->getEmailTemp('Inspector Verify a Nonconformity as not effectively closed');
						$tit = 'Inspector Verify a Nonconformity as not effectively closed';
					}
					$email_temp['message'] = str_replace("{Inspector NAME}", $inspector_info->employee_name, $email_temp['message']);
					$email_temp['message'] = str_replace("{Process Owner NAME}", $process_owner_info->employee_name, $email_temp['message']);
					$email_temp['message'] = str_replace("{LOGO}", "<img src='cid:logo'>", $email_temp['message']);
					$this->sendemail($process_owner_info->employee_email, $tit, $email_temp['message'], $email_temp['subject'], 2);
                    //---------------------------------------------- send sms ----------------------------------------------
                    if (!empty($process_owner_info->employee_phone) && $this->settings->otp_verification){
                        $phone = formatMobileNumber($process_owner_info->employee_phone, true);
                        /*=-=- check user mobile number valid start =-=-*/
                        $phone_response = $this->phone_rk->checkPhoneNumber($phone);
                        if ($phone_response['success']){
                            $message = "Hi {$process_owner_info->employee_name}".PHP_EOL;
                            $message.= "Your Nonconformity Has been Verified as not adequately closed. Please check the Nonconformity on your profile for comments and further actions required.".PHP_EOL;
                            $message.= "{$inspector_info->employee_name}";
                            if($verification_flag == 'Yes'){
                                $message = "Hi {$process_owner_info->employee_name}".PHP_EOL;
                                $message.= "Congratulations your Nonconformity Has been Verified as completed No further action is required by you.".PHP_EOL;
                                $message.= "{$inspector_info->employee_name}";
                            }
                            $this->twill_rk->sendMsq($phone,$message);
                        }
                    }
				}

				//------------------------------------------------------------------------

				if ($verification_question_flag == '2') {
					$this->session->set_flashdata('message', 'submit');
					redirect('consultant/car_verification_form/' . $form_id);
				} else {
					redirect('consultant/resolution_list');
				}
			} else {
				$this->session->set_flashdata('message', 'failed');
				redirect('consultant/car_verification_form/' . $form_id);
			}
		} else {
			redirect('Welcome');
		}
	}
	public function car_verification_form($id)
	{
		$company_id = $this->session->userdata('consultant_id');
		if ($company_id) {
			$data['title'] = "Verification Form";
			$this->db->where('id', $id);
			$data['standalone_data'] = $this->db->get('corrective_action_data')->row();
			$this->load->view('consultant/car_verification_form', $data);
		} else {
			redirect('Welcome');
		}
	}
	public function corrective_action_report()
	{
		$data['bb1']             = 'active';
		$data['b2']              = 'act1';
		$company_id              = $this->session->userdata('consultant_id');
		$data['admin_emails']    = $this->db->query("SELECT * FROM `admin`")->row()->email;
		$data['comp_email']      = $this->db->query("SELECT * FROM `consultant` WHERE `consultant_id`='$company_id'")->row()->email;
		$data['employees_email'] = $this->db->query("SELECT * FROM `employees` WHERE `consultant_id`='$company_id' &&  `employee_email`!=''")->result();
		$data['title']           = "CORRECTIVE ACTIONS Report";
		if ($company_id) {
			$data['no'] = "owner";
			$emp_list   = $this->db->query("SELECT * FROM `employees` WHERE `consultant_id`='$company_id'")->result();
			for ($i = 0; $i < sizeof($emp_list); $i++) {
				$item            = $emp_list[$i];
				$cnt             = $this->db->query("SELECT COUNT(id) as count FROM `corrective_action_data` WHERE del_flag=0 and `process_status`!='Close'  AND `process_owner`='$item->employee_id'")->row()->count;
				$item->open_cnt  = $cnt;
				$cnt             = $this->db->query("SELECT COUNT(id) as count FROM `corrective_action_data` WHERE del_flag=0 and `process_status`='Close'  AND `process_owner`='$item->employee_id'")->row()->count;
				$item->close_cnt = $cnt;
				$emp_list[$i]    = $item;
			}
			$data['standalone_data'] = $emp_list;
			$this->load->view('consultant/corrective_action_report', $data);
		} else {
			redirect('Welcome');
		}
	}
	public function resolved_list($type = '')
	{
		$data['bb1'] = 'active';
		if ($type == 'CORRECTION') {
			$data['b4']   = 'act1';
			$data['title'] = "Monitoring Resolution History";
		} else {
			$data['b5']    = 'act1';
			$data['title'] = "Resolution log for the monitoring";
		}
		$data['type'] = $type;
		$company_id   = $this->session->userdata('consultant_id');
		if ($company_id) {
			$trigger_id = $this->db->query("SELECT * FROM `trigger` WHERE `company_id`='$company_id' ")->row()->trigger_id;
			$data['no'] = "auditor";
			$this->db->where('type', $type);
			$this->db->where('company_id', $company_id);
			$this->db->where('process_status', 'Close');
			$query = "select * from corrective_action_data  where del_flag=0 and company_id=" . $company_id;
			$query .= " and process_status='Close'";
			if ($type == 'CORRECTION') {
				$query .= " and (type = 'CORRECTION' or trigger_id=" . $trigger_id . ")";
			} else {
				$query .= " and (type = 'CORRECTIVE' and trigger_id !=" . $trigger_id . ")";
			}
			$data['standalone_data'] = $this->db->query($query)->result();
			$this->load->view('consultant/resolved_list', $data);
		} else {
			redirect('Welcome');
		}
	}
	public function corrective_action_form_detail($id = Null)
	{
		$type = $_GET['type'];
		if (!isset($type)) {
			$type = 'CORRECTION';
		}
		$data['type'] = $type;
		$data['bb1']  = 'active';
		$company_id   = $this->session->userdata('consultant_id');
		if ($company_id) {
			$data['title'] = "Standalone Form Detail";
			$this->db->where('id', $id);
			$data['standalone'] = $this->db->get('corrective_action_data')->row();
			$this->load->view('consultant/corrective_action_form_detail', $data);
		} else {
			redirect('Welcome');
		}
	}
	public function main_info()
	{
		$data['cc1'] = 'active';
		$data['c5']  = 'active';
        $data['c51'] = 'act1';
		$consultant_id  = $this->session->userdata('consultant_id');
		$employee_id = $this->session->userdata('employee_id');
		if ($consultant_id) {
			if ($employee_id) {
				$this->db->where('employee_id', $employee_id);
				$data['profile'] = $this->db->get('employees')->row();
			} else {
				$this->db->where('consultant_id', $consultant_id);
				$data['profile'] = $this->db->get('consultant')->row();
			}
			$data['title'] = "Edit Profile";
			$this->load->view('consultant/main_info', $data);
		} else {
			redirect('Welcome');
		}
	}
	public function update_main_info()
	{
		$consultant_id   = $this->session->userdata('consultant_id');
		$employee_id  = $this->session->userdata('employee_id');
		$username     = $this->input->post('username');
		$consultant_name = $this->input->post('consultant_name');
		$address      = $this->input->post('address');
		$city         = $this->input->post('city');
		$state        = $this->input->post('state');
        /*=-=- check user mobile number valid start =-=-*/
        $phone        = $this->input->post('phone');
        $phone_response = $this->phone_rk->checkPhoneNumber($phone);
        if (!$phone_response['success']){
            $this->session->set_flashdata('phone_response', $phone_response);
            redirect('Consultant/main_info');
            return;
        }
        /*=-=- check user mobile number valid end =-=-*/
		if (!empty($_FILES['picture']['name'])) {
			$config['upload_path']   = 'uploads/logo/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['file_name']     = time() . $_FILES['picture']['name'];
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('picture')) {
				$uploadData = $this->upload->data();
				$picture    = $uploadData['file_name'];
			} else {
				$picture = '';
			}
		} else {
			$picture = @$this->db->query("SELECT * FROM consultant WHERE consultant_id='$consultant_id'")->row()->logo;
		}
		$up = array(
            'state' => $state,
            'consultant_name' => $consultant_name,
            'address' => $address,
            'city' => $city,
            'username' => $username,
            'logo' => $picture,
            'phone'=>$phone
		);
		if ($consultant_id) {
			$this->db->where('consultant_id', $consultant_id);
			$done = $this->db->update('consultant', $up);
			if ($done) {
				$this->session->set_flashdata('message', 'update_success');
				redirect('Consultant/main_info');
			} else {
				redirect('Consultant/main_info');
			}
		} else {
			redirect('Welcome');
		}
	}
	public function update_main_info_password(){
        $param  = $this->input->post();
        $user   = $this->session->userdata('user');
        if ($user){
            if (!verifyHashedPassword($param['old_password'], $user->password)){
                $this->session->set_flashdata('password', array('success' => false, 'message' => 'Old Password did\'nt matched'));
                redirect('Consultant/main_info');
            }
            if (empty(trim($param['password'])) && empty(trim($param['repassword']))){
                $this->session->set_flashdata('password', array('success' => false, 'message' => 'New Password Cannot be Empty'));
                redirect('Consultant/main_info');
            }
            if ($param['password'] != $param['repassword']){
                $this->session->set_flashdata('password', array('success' => false, 'message' => 'New Password didn\'t matched with confirm password'));
                redirect('Consultant/main_info');
            }
            $password   = getHashedPassword($param['password']);
            $this->db->where('consultant_id', $user->consultant_id);
            $result     = $this->db->update('consultant', array('password' => $password));
            if ($result){
                $this->session->set_flashdata('password', array('success' => true, 'message' => 'Password Updated Successfully'));
            }else{
                $this->session->set_flashdata('password', array('success' => true, 'message' => 'Password Not Updated'));
            }

            redirect('Consultant/main_info');
        }else{
            redirect('Welcome');
        }
    }
	public function edit_profile()
	{
		$employee_id = $this->session->userdata('employee_id');
		if ($employee_id) {

			$this->db->where('employee_id', $employee_id);
			$data['profile'] = $this->db->get('employees')->row();
			$data['title']   = "Edit Profile";
			$this->load->view('consultant/edit_profile', $data);
		} else {
			redirect('Welcome');
		}
	}

	public function update_profile()
	{
		$employee_id = $this->session->userdata('employee_id');
		$employee_email = $this->input->post('employee_email');
		$username = $this->input->post('username');
        /*=-=- check user mobile number valid start =-=-*/
        $phone        = $this->input->post('phone');
        $phone_response = $this->phone_rk->checkPhoneNumber($phone);
        if (!$phone_response['success']){
            $this->session->set_flashdata('phone_response', $phone_response);
            redirect('consultant/edit_profile');
            return;
        }
        /*=-=- check user mobile number valid end =-=-*/
		$up = array(
            'username' => $username,
            'employee_email' => $employee_email,
            'employee_phone' => $phone
        );

		if ($employee_id) {
			$this->db->where('employee_id', $employee_id);
			$done = $this->db->update('employees', $up);
			if ($done) {
				$this->session->set_flashdata('message', 'update_success');
				redirect('consultant/edit_profile');
			} else {
				redirect('consultant/edit_profile');
			}

		} else {
			redirect('Welcome');
		}
	}

    public function update_password() {
        $param  = $this->input->post();
        $user   = $this->session->userdata('user');
        if ($user){
            if (!verifyHashedPassword($param['old_password'], $user->password)){
                $this->session->set_flashdata('password', array('success' => false, 'message' => 'Old Password did\'nt matched'));
                redirect('consultant/edit_profile');
            }
            if (empty(trim($param['password'])) && empty(trim($param['repassword']))){
                $this->session->set_flashdata('password', array('success' => false, 'message' => 'New Password Cannot be Empty'));
                redirect('consultant/edit_profile');
            }
            if ($param['password'] != $param['repassword']){
                $this->session->set_flashdata('password', array('success' => false, 'message' => 'New Password didn\'t matched with confirm password'));
                redirect('consultant/edit_profile');
            }
            $password   = getHashedPassword($param['password']);
            $result     = $this->Employees_model->update(['employee_id' => $user->employee_id], array('password' => $password));
            if ($result){
                $this->session->set_flashdata('password', array('success' => true, 'message' => 'Password Updated Successfully'));
            }else{
                $this->session->set_flashdata('password', array('success' => true, 'message' => 'Password Not Updated'));
            }

            redirect('consultant/edit_profile');
        }else{
            redirect('Welcome');
        }
    }

	public function confirm_assign() {
		$id = $this->input->post('id');
		$audit_list = @$this->db->query("SELECT * FROM `outsource_process` WHERE `process_owner`='$id'")->row();
		$confirm = ($audit_list != null) ? FALSE : TRUE;
		$process_list = @$this->db->query("SELECT * FROM `process` WHERE `process_owner`='$id'")->row();
		$confirm = $confirm & (($process_list != null) ? FALSE : TRUE);
		$corrective_action = @$this->db->query("SELECT * FROM `corrective_action_data` WHERE `line_worker`='$id' OR `process_owner`='$id'")->row();
		$confirm = $confirm & (($corrective_action != null) ? FALSE : TRUE);
		$control_list = @$this->db->query("SELECT * FROM `control_list` WHERE `sme`='$id' OR `responsible_party`='$id' OR `monitor`='$id'")->row();
		$confirm = $confirm & (($control_list != null) ? FALSE : TRUE);

		echo json_encode($confirm);
	}
	public function delete_employee($id = Null)
	{
		$consultant_id = $this->session->userdata('consultant_id');
		if ($consultant_id) {
			$this->db->where('employee_id', $id);
			$done = $this->db->delete('employees');
			if ($done) {
				$this->session->set_flashdata('message', 'success_del');
				redirect('consultant/employees');
			} else {
				$this->session->set_flashdata('message', 'error');
				redirect('consultant/employees');
			}
		} else {
			redirect('Welcome');
		}
	}
	public function manage_strategic_rating($id = Null)
	{
		$data['cc1'] = 'active';
		$data['c6'] = 'active';
		$data['c61'] = 'active';
		$data['c614'] = 'act1';
		$data['title'] = "Rating Matrix";
		$consultant_id = $this->session->userdata('consultant_id');
		$data['user_type'] = $this->session->userdata('user_type');
		$data['risk_id'] = $id;
		if ($consultant_id) {
			$data['id'] = $id;
			$this->db->where('id', $id);
			$temp = $this->db->get('risk')->row();
			$this->load->view('consultant/manage/strategic/strategic_rating', $data);
		} else {
			redirect('Welcome');
		}
	}
	public function manage_rating_matrix_list(){
		$type = $this->input->post('type', TRUE);
		$temp_type = $type;
		$consultant_id  = $this->session->userdata('consultant_id');
		switch($type){
			case '1':
				$type = "Food";
				break;
			case '2':
				$type = "Quality";
				break;
			case '3':
				$type = "Environmental";
				break;
			case '4':
				$type = "Safety";
				break;
			case '5':
				$type = "TACCP";
				break;
			case '6':
				$type = "VACCP";
				break;
		}
		$data['type'] = $type;

		if ($type == "strategic"){
			$sql = "select * from likelihood where type = '".$type."' and del_flag = 0 and company_id = ".$consultant_id." order by reg_date";
			$data['likelihood'] = $this->db->query($sql)->result();
			$sql = "select * from consequence where type = '".$type."' and del_flag = 0 and company_id = ".$consultant_id." order by reg_date";
			$data['consequence'] = $this->db->query($sql)->result();
			$sql = "select * from manage_rating_matrix where type = '".$type."' and company_id = ".$consultant_id;
			$data['values'] = $this->db->query($sql)->result();
			$sql = "select * from risk_value where type = 0 and del_flag = 0 and company_id = ".$consultant_id." order by start";
			$data['risk_values'] = $this->db->query($sql)->result();
			$this->load->view('consultant/rating_detail', $data);
		}else{
			$sql = "select * from likelihood where type = '".$type."' and del_flag = 0 and company_id = ".$consultant_id." order by reg_date";
			$data['likelihood'] = $this->db->query($sql)->result();
			$sql = "select * from consequence where type = '".$type."' and del_flag = 0 and company_id = ".$consultant_id." order by reg_date";
			$data['consequence'] = $this->db->query($sql)->result();
			$sql = "select * from manage_rating_matrix where type = '".$type."' and company_id = ".$consultant_id;
			$data['values'] = $this->db->query($sql)->result();
			$sql = "select * from risk_value where type = ".$temp_type." and del_flag = 0 and company_id = ".$consultant_id." order by start";
			$data['risk_values'] = $this->db->query($sql)->result();
			$this->load->view('consultant/rating_detail', $data);
		}
	}
	public function edit_manage_rating_value() {
		$id = $this->input->post('id', TRUE);
		$type = $this->input->post('type', TRUE);
		$like_id = $this->input->post('like_id', TRUE);
		$conse_id = $this->input->post('conse_id', TRUE);
		$value = $this->input->post('value', TRUE);
		$consultant_id  = $this->session->userdata('consultant_id');
		switch($type){
			case '1':
				$type = "Food";
				break;
			case '2':
				$type = "Quality";
				break;
			case '3':
				$type = "Environmental";
				break;
			case '4':
				$type = "Safety";
				break;
			case '5':
				$type = "TACCP";
				break;
			case '6':
				$type = "VACCP";
				break;
		}

		if ($id != 0){
			$this->db->where('id', $id);
			$result = $this->db->update('manage_rating_matrix', array('value'=>$value));
		}else if ($id == 0){
			$result = $this->db->insert('manage_rating_matrix', array('company_id'=>$consultant_id,'type'=>$type,'like_id'=>$like_id,'conse_id'=>$conse_id,'value'=>$value));
		}
		echo json_encode(array('success'=>$result));
	}
	public function process()
	{
		$data['cc1'] = 'active';
		$data['c12'] = 'act1';
		$consultant_id = $this->session->userdata('consultant_id');
		if($consultant_id){
			$data['title'] = "Process";
			$this->load->view('consultant/manage/process', $data);
		}else{
			redirect('Welcome');
		}
	}
	public function process_read($id = NULL)
	{
		$consultant_id  = $this->session->userdata('consultant_id');

		$displayStart = $this->input->post('iDisplayStart');
		$displayLength = $this->input->post('iDisplayLength');
		$search = $this->input->post('sSearch');
		$sortingCols = $this->input->post('iSortingCols');
		$flag = $this->input->post('flag');

		$data = array();
		if (isset($id)) {
			$data['process'] = '';
		} else {
			$filter['del_flag'] = 0;
			if ($displayLength != -1) {
				$filter['start'] = $displayStart;
				$filter['limit'] = $displayLength;
				$filter['search'] = $search;
			}
			$order = array();
			for ($i = 0; $i < $sortingCols; $i++) {
				$sortCol = $this->input->post('iSortCol_' . $i);
				$sortDir = $this->input->post('sSortDir_' . $i);
				$dataProp = $this->input->post('mDataProp_' . $sortCol);

				$order[$dataProp] = $sortDir;
			}
			$sql = "SELECT a.* from manage_process a where
                            a.company_id = " . $consultant_id . " and a.del_flag = 0";
			if ($search != ''){
				$sql .= " and (a.name like '%".$search."%' OR a.description like '%".$search."%')";
			}
			$sql .= " ORDER BY a.reg_date DESC";
			$data['processes'] = $this->db->query($sql)->result();
			$data['iTotalDisplayRecords'] = count($data['processes']);
			unset($filter['search']);
			$data['iTotalRecords'] = count($data['processes']);
			if ($displayLength != -1) {
				$sql .= " limit ".$displayStart.",".$displayLength;
			}
			$data['processes'] = $this->db->query($sql)->result();
			$data['sEcho'] = $search;
		}
		$this->render_json($data);
	}
	public function add_process()
	{
		$data['id'] = $this->input->post("id");
		$data['name'] = $this->input->post("name");
		$data['description'] = $this->input->post("description");
		$data['version_date'] = $this->input->post('version_date', TRUE);
		$data['revision_date'] = $this->input->post('revision_date', TRUE);
		$data['company_id']  = $this->session->userdata('consultant_id');
		if (!empty($_FILES['file']['name'])) {
			$config['upload_path']   = 'uploads/Doc/';
			$config['allowed_types'] = 'jpg|jpeg|png|xls|pdf|doc|docx';
			$config['file_name']     = time() . $_FILES['file']['name'];
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if ($this->upload->do_upload('file')) {
				$uploadData = $this->upload->data();
				$data['file_path']   = $uploadData['file_name'];
			}
		}
		if ($data['id'] != '0'){
			$this->db->where('id', $data['id']);
			$result = $this->db->update('manage_process', $data);
			$id = $data['id'];
		}else{
			$result = $this->db->insert('manage_process', $data);
			$id = $this->db->insert_id();
		}
		if ($result > 0){
			$this->render_json(array('success'=>$id));
		}else{
			$this->render_json(array('success'=>FALSE));
		}
	}
	public function process_save_content()
	{
		$data['id'] = $this->input->post('edit_id', TRUE);
		$data['content'] = $this->input->post('content', TRUE);
		$data['content'] = str_replace("&lt;html&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;/html&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;head&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;/head&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;title&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;/title&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;body&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;/body&gt;",'',$data['content']);
		if(!empty($data['id'])) {
			$this->db->where('id', $data['id']);
			$result = $this->db->update('manage_process',$data);
		} else{
			redirect('consultant/process');
		}
		if ($result > 0){
			redirect('consultant/process');
		}else{
			redirect('consultant/process');
		}
	}
	public function delete_manage_process() {
		$id = $this->input->post('ids', TRUE);
		$this->db->where('id', $id);
		$result = $this->db->update('manage_process', array('del_flag'=>'1'));
		echo json_encode(array('success'=>$result));
	}
	public function download_content_pdf()
	{
		$content = $this->input->post('content', TRUE);
		$content = str_replace("&lt;html&gt;",'',$content);
		$content = str_replace("&lt;/html&gt;",'',$content);
		$content = str_replace("&lt;head&gt;",'',$content);
		$content = str_replace("&lt;/head&gt;",'',$content);
		$content = str_replace("&lt;title&gt;",'',$content);
		$content = str_replace("&lt;/title&gt;",'',$content);
		$content = str_replace("&lt;body&gt;",'',$content);
		$content = str_replace("&lt;/body&gt;",'',$content);
		$this->load->library("Pdf");
		$consultant_id  = $this->session->userdata('consultant_id');
//		$contract = $this->contract_model->get_first_contract(array('id' => $id));
		$this->db->where('company_id', $consultant_id);
		$temp = $this->db->get('procedures')->result();
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, TRUE, 'UTF-8', FALSE);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		$pdf->SetPrintFooter(FALSE);
		$pdf->SetPrintHeader(FALSE);

		$pdf->AddPage();

		$html =  "
			<style>
				h1 {
					text-align: center;
					text-transform: capitalize;
				}
			</style>
			<div class='content'>";
		$this->db->where('consultant_id', $consultant_id);
		$consultant = @$this->db->get('consultant')->row();
		$html .= '<table style="margin-left: 20px;width: 600px;">';
		$html .= '<tr style="text-align: center;">';
		$html .= '<td style="padding-left: 40px;padding-right: 40px;height: 850px;text-align: center;">';
		$html .= '<table style="text-align: center;">';
		$html .= '<tr><td style="height: 100px;"></td></tr>';
		$html .= '<tr ><td style="height: 150px;"><p style="font-size: 40px;">Procedures Register</p></td></tr>';
		$html .= '<tr><td><p style="font-size: 20px;">'.$consultant->consultant_name.'</p></td></tr>';
		$html .= '<tr><td><p style="font-size: 15px;">'.$consultant->contact_no.'</p></td></tr>';
		$html .= '<tr><td><p style="font-size: 15px;">'.$consultant->address.'</p></td></tr>';
		$html .= '</table>';
		$html .= '</td>';
		$html .= '</tr>';

		$html .= '<tr style="text-align: center;"><td style="height: 850px;text-align: center;"><table cellpadding = "5" style="text-align: center;">';
		$html .= '<tr><td style="text-align: left;width: 10%;font-size: 12px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">Title</td><td style="text-align: left;width: 40%;font-size: 12px;border-bottom-width:1px;border-bottom-color: #DCDCDC;background-color:#F5F5F5;">Description</td><td style="text-align: left;width: 20%;font-size: 12px;border-bottom-width:1px;border-bottom-color: #DCDCDC;background-color:#F5F5F5;">Active Date</td><td style="text-align: left;width: 20%;font-size: 12px;border-bottom-width:1px;border-bottom-color: #DCDCDC;background-color:#F5F5F5;">Review Date</td></tr>';
		$count = 0;
		foreach ($temp as $row){
			$count++;
			$html .= '<tr>';
			if ($count % 2 == 0){
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->name.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->description.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->version_date.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->revision_date.'</td>';
			}else{
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->name.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->description.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->version_date.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->revision_date.'</td>';
			}

			$html .= '</tr>';
		}
		$html .="</table></td></tr>";
		$html .="</table>";
		$html .="</div>";

		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, TRUE, '', TRUE);

		// $pdf->Output($contract['contract_title'].'.pdf', 'D');
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/RMT/uploads/doc/')){
			mkdir($_SERVER['DOCUMENT_ROOT'].'/RMT/uploads/doc/', 0777, TRUE);
		}
		if (ob_get_length()) ob_end_clean();
		$pdf->Output('procedure_'.$consultant_id.'.pdf', 'D');
	}
	public function download_content_pdf_process()
	{
		$this->load->library("Pdf");
//		$contract = $this->contract_model->get_first_contract(array('id' => $id));
		$consultant_id  = $this->session->userdata('consultant_id');
		$this->db->where('company_id', $consultant_id);
		$temp = $this->db->get('manage_process')->result();
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, TRUE, 'UTF-8', FALSE);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		$pdf->SetPrintFooter(FALSE);
		$pdf->SetPrintHeader(FALSE);

		$pdf->AddPage();

		$html =  "
			<style>
				h1 {
					text-align: center;
					text-transform: capitalize;
				}
			</style>
			<div class='content'>";
		$this->db->where('consultant_id', $consultant_id);
		$consultant = @$this->db->get('consultant')->row();
		$html .= '<table style="margin-left: 20px;width: 600px;">';
		$html .= '<tr style="text-align: center;">';
		$html .= '<td style="padding-left: 40px;padding-right: 40px;height: 850px;text-align: center;">';
		$html .= '<table style="text-align: center;">';
		$html .= '<tr><td style="height: 100px;"></td></tr>';
		$html .= '<tr ><td style="height: 150px;"><p style="font-size: 40px;">Process</p></td></tr>';
		$html .= '<tr><td><p style="font-size: 20px;">'.$consultant->consultant_name.'</p></td></tr>';
		$html .= '<tr><td><p style="font-size: 15px;">'.$consultant->contact_no.'</p></td></tr>';
		$html .= '<tr><td><p style="font-size: 15px;">'.$consultant->address.'</p></td></tr>';
		$html .= '</table>';
		$html .= '</td>';
		$html .= '</tr>';

		$html .= '<tr style="text-align: center;"><td style="height: 850px;text-align: center;"><table cellpadding = "5" style="text-align: center;">';
		$html .= '<tr><td style="text-align: left;width: 10%;font-size: 12px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">Title</td><td style="text-align: left;width: 40%;font-size: 12px;border-bottom-width:1px;border-bottom-color: #DCDCDC;background-color:#F5F5F5;">Description</td><td style="text-align: left;width: 20%;font-size: 12px;border-bottom-width:1px;border-bottom-color: #DCDCDC;background-color:#F5F5F5;">Active Date</td><td style="text-align: left;width: 20%;font-size: 12px;border-bottom-width:1px;border-bottom-color: #DCDCDC;background-color:#F5F5F5;">Review Date</td></tr>';
		$count = 0;
		foreach ($temp as $row){
			$count++;
			$html .= '<tr>';
			if ($count % 2 == 0){
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->name.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->description.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->version_date.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->revision_date.'</td>';
			}else{
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->name.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->description.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->version_date.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->revision_date.'</td>';
			}

			$html .= '</tr>';
		}
		$html .="</table></td></tr>";
		$html .="</table>";
		$html .="</div>";

		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, TRUE, '', TRUE);

		// $pdf->Output($contract['contract_title'].'.pdf', 'D');
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/RMT/uploads/doc/')){
			mkdir($_SERVER['DOCUMENT_ROOT'].'/RMT/uploads/doc/', 0777, TRUE);
		}
		if (ob_get_length()) ob_end_clean();
		$pdf->Output('process_'.$consultant_id.'.pdf', 'D');

	}
	public function download_content_pdf_pre_process()
	{
		$this->load->library("Pdf");
//		$contract = $this->contract_model->get_first_contract(array('id' => $id));
		$consultant_id  = $this->session->userdata('consultant_id');
		$this->db->where('company_id', $consultant_id);
		$temp = $this->db->get('manage_pre_process')->result();
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, TRUE, 'UTF-8', FALSE);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		$pdf->SetPrintFooter(FALSE);
		$pdf->SetPrintHeader(FALSE);

		$pdf->AddPage();

		$html =  "
			<style>
				h1 {
					text-align: center;
					text-transform: capitalize;
				}
			</style>
			<div class='content'>";
		$this->db->where('consultant_id', $consultant_id);
		$consultant = @$this->db->get('consultant')->row();
		$html .= '<table style="margin-left: 20px;width: 600px;">';
		$html .= '<tr style="text-align: center;">';
		$html .= '<td style="padding-left: 40px;padding-right: 40px;height: 850px;text-align: center;">';
		$html .= '<table style="text-align: center;">';
		$html .= '<tr><td style="height: 100px;"></td></tr>';
		$html .= '<tr ><td style="height: 150px;"><p style="font-size: 40px;">Process</p></td></tr>';
		$html .= '<tr><td><p style="font-size: 20px;">'.$consultant->consultant_name.'</p></td></tr>';
		$html .= '<tr><td><p style="font-size: 15px;">'.$consultant->contact_no.'</p></td></tr>';
		$html .= '<tr><td><p style="font-size: 15px;">'.$consultant->address.'</p></td></tr>';
		$html .= '</table>';
		$html .= '</td>';
		$html .= '</tr>';

		$html .= '<tr style="text-align: center;"><td style="height: 850px;text-align: center;"><table cellpadding = "5" style="text-align: center;">';
		$html .= '<tr><td style="text-align: left;width: 10%;font-size: 12px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">Title</td><td style="text-align: left;width: 40%;font-size: 12px;border-bottom-width:1px;border-bottom-color: #DCDCDC;background-color:#F5F5F5;">Description</td><td style="text-align: left;width: 20%;font-size: 12px;border-bottom-width:1px;border-bottom-color: #DCDCDC;background-color:#F5F5F5;">Active Date</td><td style="text-align: left;width: 20%;font-size: 12px;border-bottom-width:1px;border-bottom-color: #DCDCDC;background-color:#F5F5F5;">Review Date</td></tr>';
		$count = 0;
		foreach ($temp as $row){
			$count++;
			$html .= '<tr>';
			if ($count % 2 == 0){
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->name.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->description.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->version_date.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->revision_date.'</td>';
			}else{
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->name.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->description.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->version_date.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->revision_date.'</td>';
			}

			$html .= '</tr>';
		}
		$html .="</table></td></tr>";
		$html .="</table>";
		$html .="</div>";

		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, TRUE, '', TRUE);

		// $pdf->Output($contract['contract_title'].'.pdf', 'D');
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/RMT/uploads/doc/')){
			mkdir($_SERVER['DOCUMENT_ROOT'].'/RMT/uploads/doc/', 0777, TRUE);
		}
		if (ob_get_length()) ob_end_clean();
		$pdf->Output('pre_process_'.$consultant_id.'.pdf', 'D');

	}
	public function download_content_pdf_additional_process()
	{
		$this->load->library("Pdf");
//		$contract = $this->contract_model->get_first_contract(array('id' => $id));
		$consultant_id  = $this->session->userdata('consultant_id');
		$this->db->where('company_id', $consultant_id);
		$temp = $this->db->get('manage_additional_process')->result();
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, TRUE, 'UTF-8', FALSE);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		$pdf->SetPrintFooter(FALSE);
		$pdf->SetPrintHeader(FALSE);

		$pdf->AddPage();

		$html =  "
			<style>
				h1 {
					text-align: center;
					text-transform: capitalize;
				}
			</style>
			<div class='content'>";
		$this->db->where('consultant_id', $consultant_id);
		$consultant = @$this->db->get('consultant')->row();
		$html .= '<table style="margin-left: 20px;width: 600px;">';
		$html .= '<tr style="text-align: center;">';
		$html .= '<td style="padding-left: 40px;padding-right: 40px;height: 850px;text-align: center;">';
		$html .= '<table style="text-align: center;">';
		$html .= '<tr><td style="height: 100px;"></td></tr>';
		$html .= '<tr ><td style="height: 150px;"><p style="font-size: 40px;">Process</p></td></tr>';
		$html .= '<tr><td><p style="font-size: 20px;">'.$consultant->consultant_name.'</p></td></tr>';
		$html .= '<tr><td><p style="font-size: 15px;">'.$consultant->contact_no.'</p></td></tr>';
		$html .= '<tr><td><p style="font-size: 15px;">'.$consultant->address.'</p></td></tr>';
		$html .= '</table>';
		$html .= '</td>';
		$html .= '</tr>';

		$html .= '<tr style="text-align: center;"><td style="height: 850px;text-align: center;"><table cellpadding = "5" style="text-align: center;">';
		$html .= '<tr><td style="text-align: left;width: 10%;font-size: 12px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">Title</td><td style="text-align: left;width: 40%;font-size: 12px;border-bottom-width:1px;border-bottom-color: #DCDCDC;background-color:#F5F5F5;">Description</td><td style="text-align: left;width: 20%;font-size: 12px;border-bottom-width:1px;border-bottom-color: #DCDCDC;background-color:#F5F5F5;">Active Date</td><td style="text-align: left;width: 20%;font-size: 12px;border-bottom-width:1px;border-bottom-color: #DCDCDC;background-color:#F5F5F5;">Review Date</td></tr>';
		$count = 0;
		foreach ($temp as $row){
			$count++;
			$html .= '<tr>';
			if ($count % 2 == 0){
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->name.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->description.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->version_date.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->revision_date.'</td>';
			}else{
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->name.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->description.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->version_date.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->revision_date.'</td>';
			}

			$html .= '</tr>';
		}
		$html .="</table></td></tr>";
		$html .="</table>";
		$html .="</div>";

		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, TRUE, '', TRUE);

		// $pdf->Output($contract['contract_title'].'.pdf', 'D');
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/RMT/uploads/doc/')){
			mkdir($_SERVER['DOCUMENT_ROOT'].'/RMT/uploads/doc/', 0777, TRUE);
		}
		if (ob_get_length()) ob_end_clean();
		$pdf->Output('additional_process_'.$consultant_id.'.pdf', 'D');

	}
	public function download_content_pdf_record()
	{
		$content = $this->input->post('content', TRUE);
		$content = str_replace("&lt;html&gt;",'',$content);
		$content = str_replace("&lt;/html&gt;",'',$content);
		$content = str_replace("&lt;head&gt;",'',$content);
		$content = str_replace("&lt;/head&gt;",'',$content);
		$content = str_replace("&lt;title&gt;",'',$content);
		$content = str_replace("&lt;/title&gt;",'',$content);
		$content = str_replace("&lt;body&gt;",'',$content);
		$content = str_replace("&lt;/body&gt;",'',$content);
		$this->load->library("Pdf");
//		$contract = $this->contract_model->get_first_contract(array('id' => $id));
		$consultant_id  = $this->session->userdata('consultant_id');
		$this->db->where('company_id', $consultant_id);
		$temp = $this->db->get('record')->result();
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, TRUE, 'UTF-8', FALSE);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		$pdf->SetPrintFooter(FALSE);
		$pdf->SetPrintHeader(FALSE);

		$pdf->AddPage();

		$html =  "
			<style>
				h1 {
					text-align: center;
					text-transform: capitalize;
				}
			</style>
			<div class='content'>";
		$this->db->where('consultant_id', $consultant_id);
		$consultant = @$this->db->get('consultant')->row();
		$html .= '<table style="margin-left: 20px;width: 600px;">';
		$html .= '<tr style="text-align: center;">';
		$html .= '<td style="padding-left: 40px;padding-right: 40px;height: 850px;text-align: center;">';
		$html .= '<table style="text-align: center;">';
		$html .= '<tr><td style="height: 100px;"></td></tr>';
		$html .= '<tr ><td style="height: 150px;"><p style="font-size: 40px;">Records</p></td></tr>';
		$html .= '<tr><td><p style="font-size: 20px;">'.$consultant->consultant_name.'</p></td></tr>';
		$html .= '<tr><td><p style="font-size: 15px;">'.$consultant->contact_no.'</p></td></tr>';
		$html .= '<tr><td><p style="font-size: 15px;">'.$consultant->address.'</p></td></tr>';
		$html .= '</table>';
		$html .= '</td>';
		$html .= '</tr>';

		$html .= '<tr style="text-align: center;"><td style="height: 850px;text-align: center;"><table cellpadding = "5" style="text-align: center;">';
		$html .= '<tr><td style="text-align: left;width: 10%;font-size: 12px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">Title</td><td style="text-align: left;width: 40%;font-size: 12px;border-bottom-width:1px;border-bottom-color: #DCDCDC;background-color:#F5F5F5;">Description</td><td style="text-align: left;width: 20%;font-size: 12px;border-bottom-width:1px;border-bottom-color: #DCDCDC;background-color:#F5F5F5;">Active Date</td><td style="text-align: left;width: 20%;font-size: 12px;border-bottom-width:1px;border-bottom-color: #DCDCDC;background-color:#F5F5F5;">Review Date</td></tr>';
		$count = 0;
		foreach ($temp as $row){
			$count++;
			$html .= '<tr>';
			if ($count % 2 == 0){
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->name.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->description.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->version_date.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->revision_date.'</td>';
			}else{
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->name.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->description.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->version_date.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->revision_date.'</td>';
			}

			$html .= '</tr>';
		}
		$html .="</table></td></tr>";
		$html .="</table>";
		$html .="</div>";

		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, TRUE, '', TRUE);

		// $pdf->Output($contract['contract_title'].'.pdf', 'D');
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/RMT/uploads/doc/')){
			mkdir($_SERVER['DOCUMENT_ROOT'].'/RMT/uploads/doc/', 0777, TRUE);
		}
		if (ob_get_length()) ob_end_clean();
		$pdf->Output('record_'.$consultant_id.'.pdf', 'D');
	}
	public function pre_process()
	{
		$data['cc1'] = 'active';
		$data['c13'] = 'act1';
		$consultant_id = $this->session->userdata('consultant_id');
		if($consultant_id){
			$data['title'] = "PreRequisite Programs Process";
			$this->load->view('consultant/manage/pre_process', $data);
		}else{
			redirect('Welcome');
		}
	}
	public function pre_process_read($id = NULL)
	{
		$consultant_id  = $this->session->userdata('consultant_id');

		$displayStart = $this->input->post('iDisplayStart');
		$displayLength = $this->input->post('iDisplayLength');
		$search = $this->input->post('sSearch');
		$sortingCols = $this->input->post('iSortingCols');
		$flag = $this->input->post('flag');

		$data = array();
		if (isset($id)) {
			$data['process'] = '';
		} else {
			$filter['del_flag'] = 0;
			if ($displayLength != -1) {
				$filter['start'] = $displayStart;
				$filter['limit'] = $displayLength;
				$filter['search'] = $search;
			}
			$order = array();
			for ($i = 0; $i < $sortingCols; $i++) {
				$sortCol = $this->input->post('iSortCol_' . $i);
				$sortDir = $this->input->post('sSortDir_' . $i);
				$dataProp = $this->input->post('mDataProp_' . $sortCol);

				$order[$dataProp] = $sortDir;
			}
			$sql = "SELECT a.* from manage_pre_process a where
                            a.company_id = " . $consultant_id . " and a.del_flag = 0";
			if ($search != ''){
				$sql .= " and (a.name like '%".$search."%' OR a.description like '%".$search."%')";
			}
			$sql .= " ORDER BY a.reg_date DESC";
			$data['processes'] = $this->db->query($sql)->result();
			$data['iTotalDisplayRecords'] = count($data['processes']);
			unset($filter['search']);
			$data['iTotalRecords'] = count($data['processes']);
			if ($displayLength != -1) {
				$sql .= " limit ".$displayStart.",".$displayLength;
			}
			$data['processes'] = $this->db->query($sql)->result();
			$data['sEcho'] = $search;
		}
		$this->render_json($data);
	}
	public function add_pre_process()
	{
		$data['id'] = $this->input->post("id");
		$data['name'] = $this->input->post("name");
		$data['description'] = $this->input->post("description");
		$data['version_date'] = $this->input->post('version_date', TRUE);
		$data['revision_date'] = $this->input->post('revision_date', TRUE);
		$data['company_id']  = $this->session->userdata('consultant_id');
		if (!empty($_FILES['file']['name'])) {
			$config['upload_path']   = 'uploads/Doc/';
			$config['allowed_types'] = 'jpg|jpeg|png|xls|pdf|doc|docx';
			$config['file_name']     = time() . $_FILES['file']['name'];
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if ($this->upload->do_upload('file')) {
				$uploadData = $this->upload->data();
				$data['file_path']   = $uploadData['file_name'];
			}
		}
		if ($data['id'] != '0'){
			$this->db->where('id', $data['id']);
			$result = $this->db->update('manage_pre_process', $data);
			$id = $data['id'];
		}else{
			$result = $this->db->insert('manage_pre_process', $data);
			$id = $this->db->insert_id();
		}
		if ($result > 0){
			$this->render_json(array('success'=>$id));
		}else{
			$this->render_json(array('success'=>FALSE));
		}
	}
	public function pre_process_save_content()
	{
		$data['id'] = $this->input->post('edit_id', TRUE);
		$data['content'] = $this->input->post('content', TRUE);
		$data['content'] = str_replace("&lt;html&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;/html&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;head&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;/head&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;title&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;/title&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;body&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;/body&gt;",'',$data['content']);
		if(!empty($data['id'])) {
			$this->db->where('id', $data['id']);
			$result = $this->db->update('manage_pre_process',$data);
		} else{
			redirect('consultant/pre_process');
		}
		if ($result > 0){
			redirect('consultant/pre_process');
		}else{
			redirect('consultant/pre_process');
		}
	}
	public function delete_manage_pre_process() {
		$id = $this->input->post('ids', TRUE);
		$this->db->where('id', $id);
		$result = $this->db->update('manage_pre_process', array('del_flag'=>'1'));
		echo json_encode(array('success'=>$result));
	}
	public function additional_process()
	{
		$data['cc1'] = 'active';
		$data['c14'] = 'act1';
		$consultant_id = $this->session->userdata('consultant_id');
		if($consultant_id){
			$data['title'] = "Additional Requirements Process";
			$this->load->view('consultant/manage/additional_process', $data);
		}else{
			redirect('Welcome');
		}
	}
	public function additional_process_read($id = NULL)
	{
		$consultant_id  = $this->session->userdata('consultant_id');

		$displayStart = $this->input->post('iDisplayStart');
		$displayLength = $this->input->post('iDisplayLength');
		$search = $this->input->post('sSearch');
		$sortingCols = $this->input->post('iSortingCols');
		$flag = $this->input->post('flag');

		$data = array();
		if (isset($id)) {
			$data['process'] = '';
		} else {
			$filter['del_flag'] = 0;
			if ($displayLength != -1) {
				$filter['start'] = $displayStart;
				$filter['limit'] = $displayLength;
				$filter['search'] = $search;
			}
			$order = array();
			for ($i = 0; $i < $sortingCols; $i++) {
				$sortCol = $this->input->post('iSortCol_' . $i);
				$sortDir = $this->input->post('sSortDir_' . $i);
				$dataProp = $this->input->post('mDataProp_' . $sortCol);

				$order[$dataProp] = $sortDir;
			}
			$sql = "SELECT a.* from manage_additional_process a where
                            a.company_id = " . $consultant_id . " and a.del_flag = 0";
			if ($search != ''){
				$sql .= " and (a.name like '%".$search."%' OR a.description like '%".$search."%')";
			}
			$sql .= " ORDER BY a.reg_date DESC";
			$data['processes'] = $this->db->query($sql)->result();
			$data['iTotalDisplayRecords'] = count($data['processes']);
			unset($filter['search']);
			$data['iTotalRecords'] = count($data['processes']);
			if ($displayLength != -1) {
				$sql .= " limit ".$displayStart.",".$displayLength;
			}
			$data['processes'] = $this->db->query($sql)->result();
			$data['sEcho'] = $search;
		}
		$this->render_json($data);
	}
	public function add_additional_process()
	{
		$data['id'] = $this->input->post("id");
		$data['name'] = $this->input->post("name");
		$data['description'] = $this->input->post("description");
		$data['version_date'] = $this->input->post('version_date', TRUE);
		$data['revision_date'] = $this->input->post('revision_date', TRUE);
		$data['company_id']  = $this->session->userdata('consultant_id');
		if (!empty($_FILES['file']['name'])) {
			$config['upload_path']   = 'uploads/Doc/';
			$config['allowed_types'] = 'jpg|jpeg|png|xls|pdf|doc|docx';
			$config['file_name']     = time() . $_FILES['file']['name'];
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if ($this->upload->do_upload('file')) {
				$uploadData = $this->upload->data();
				$data['file_path']   = $uploadData['file_name'];
			}
		}
		if ($data['id'] != '0'){
			$this->db->where('id', $data['id']);
			$result = $this->db->update('manage_additional_process', $data);
			$id = $data['id'];
		}else{
			$result = $this->db->insert('manage_additional_process', $data);
			$id = $this->db->insert_id();
		}
		if ($result > 0){
			$this->render_json(array('success'=>$id));
		}else{
			$this->render_json(array('success'=>FALSE));
		}
	}
	public function additional_process_save_content()
	{
		$data['id'] = $this->input->post('edit_id', TRUE);
		$data['content'] = $this->input->post('content', TRUE);
		$data['content'] = str_replace("&lt;html&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;/html&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;head&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;/head&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;title&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;/title&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;body&gt;",'',$data['content']);
		$data['content'] = str_replace("&lt;/body&gt;",'',$data['content']);
		if(!empty($data['id'])) {
			$this->db->where('id', $data['id']);
			$result = $this->db->update('manage_additional_process',$data);
		} else{
			redirect('consultant/additional_process');
		}
		if ($result > 0){
			redirect('consultant/additional_process');
		}else{
			redirect('consultant/additional_process');
		}
	}
	public function delete_manage_additional_process() {
		$id = $this->input->post('ids', TRUE);
		$this->db->where('id', $id);
		$result = $this->db->update('manage_additional_process', array('del_flag'=>'1'));
		echo json_encode(array('success'=>$result));
	}
	public function excel_report($id){
		$consultant_id = $this->session->userdata('consultant_id');
		$data['consultant_id'] = $consultant_id;
		$this->db->where('id', $id);
		$temp = @$this->db->get('risk')->row();
		$data["title"] = "Risk Register";
		$this->db->where('company_id', $consultant_id);
		$data['risk_type'] = $temp->risk_type;
		if ($temp->risk_type == '0'){
			$this->db->where('type', 'strategic');
		}else if ($temp->risk_type == '1'){
			$this->db->where('type != "strategic"');
		}
		$data["likelihood"] = $this->db->get('likelihood')->result();
		$this->db->where('company_id', $consultant_id);
		if ($temp->risk_type == '0'){
			$this->db->where('type', 'strategic');
		}else if ($temp->risk_type == '1'){
			$this->db->where('type != "strategic"');
		}
		$data["consequence"] = $this->db->get('consequence')->result();
		$this->db->where('company_id', $consultant_id);
		$data["assessment_controls"] = $this->db->get('assessment_controls')->result();
		$sql = "select likelihood.name likelihood_name, consequence.name consequence_name, rating_matrix.type, rating_matrix.value
					from rating_matrix
					left join likelihood on likelihood.id = rating_matrix.like_id
					left join consequence on consequence.id = rating_matrix.conse_id
					left join risk on risk.id = rating_matrix.risk_id
					where rating_matrix.risk_id = ".$id."
					";
		$data["rating_matrix"] = $this->db->query($sql)->result();
		$sql = "select DATE_FORMAT(risk.reg_date,'%y-%b-%e') date_raised,consultant.username,process.type category,process.potential_hazard event,
 					process.opportunities cause
 					from risk
					left join process on process.risk_id = risk.id
					left join consultant on consultant.consultant_id = risk.company_id

					where risk.id = ".$id."
					";
		$data["result"] = $this->db->query($sql)->result();
		$this->load->view("excel_manual",$data);
	}
	function control_message() {
		$data['dd1'] = 'active';
		$data['d3'] = 'act1';
		$consultant_id = $this->session->userdata('consultant_id');
		$user_type  = $this->session->userdata('user_type');
		if ($consultant_id) {
			$data['title'] = "Control Inbox";
			if ($user_type == "consultant"){
				$where = "";
			}else if ($user_type == "process_owner"){
				$employee_id = $this->session->userdata('employee_id');
				$where = " AND a.process_owner = " . $employee_id;
			}else{
				$employee_id = $this->session->userdata('employee_id');
				$where = " AND (control.sme = " . $employee_id . " OR control.responsible_party = " . $employee_id . ")";
			}
			$sql = "SELECT control.id, control.name,control.plan,f.frequency_name,b.rating actions ,c.rating assessment
                        FROM
                            control_list AS control
                        left join process a on control.process_id = a.id
                        left join control_actions b on control.action = b.id
                        left join assessment_controls c on control.assessment = c.id
                        LEFT JOIN frequency f ON f.frequency_id = control.frequency
                        WHERE
                            control.id IN (
                                SELECT control_id FROM control_message WHERE company_id = " . $consultant_id . "
                            ) and control.del_flag = 0 " . $where . "
                        ORDER BY control.id DESC";
			$data['control_message'] = $this->db->query($sql)->result();
			$this->load->view('consultant/control_message', $data);
		} else {
			redirect('Welcome');
		}
	}
	public function show_control_message($id = '')
	{
		$data['dd1'] = 'active';
		$data['d3'] = 'act1';
		$consultant_id = $this->session->userdata('consultant_id');
		if ($consultant_id) {
			$this->db->where('control_id', $id);
			$this->db->where('company_id', $consultant_id);
			$this->db->order_by('date_time', 'asc');
			$data['message'] = $this->db->get('control_message')->result();
			$data['title']   = "Messages";

			$sql = "SELECT a.id,b.rating action_name,a.name,a.plan,d.rating assessment_name,a.review_date
                        FROM control_list a
                        left join control_actions b on a.action = b.id
                        left join frequency c on a.frequency = c.frequency_id
                        left join assessment_controls d on a.assessment = d.id
                        WHERE
                            a.id = " . $id . " and a.del_flag = 0";
			$data['control_data'] = @$this->db->query($sql)->row();
			$this->load->view('consultant/show_control_message', $data);
		} else {
			redirect('Welcome');
		}
	}
	public function send_control_message() {
		$consultant_id  = $this->session->userdata('consultant_id');
		$com_status  = $this->session->userdata('com_status');
		$user_type = $this->session->userdata('user_type');
		$message = $this->input->post('message');
		$control_id = $this->input->post('control_id');
		if ($user_type == "consultant"){
			if ($consultant_id && $com_status != '0') {
				$created_at = date('Y-m-d h:i:s');

				$data = array(
						'company_id' => $consultant_id,
						'sender_id' => $consultant_id,
						'sender_role' => 'Consultant',
						'message' => $message,
						'date_time' => $created_at,
						'control_id' => $control_id
				);
				$done = $this->db->insert('control_message', $data);
				echo json_encode($done);
			} else {
				redirect('Welcome');
			}
		}else{
			$employee_id = $this->session->userdata('employee_id');
			if ($employee_id) {
				$created_at = date('Y-m-d h:i:s');
				$data = array(
						'company_id' => $consultant_id,
						'sender_id' => $employee_id,
						'sender_role' => $user_type,
						'message' => $message,
						'date_time' => $created_at,
						'control_id' => $control_id
				);
				$done = $this->db->insert('control_message', $data);
				echo json_encode($done);
			} else {
				redirect('Welcome');
			}
		}
	}
	public function corrective_message()
	{
		$data['dd1'] = 'active';
		$data['d1'] = 'act1';
		$consultant_id = $this->session->userdata('consultant_id');
		$com_status = $this->session->userdata('com_status');
		$user_type  = $this->session->userdata('user_type');
		if ($consultant_id && $com_status != '0') {
			$data['title'] = "Corrective Action Inbox";
			if ($user_type == "consultant"){
				$where = "";
			}else{
				$employee_id = $this->session->userdata('employee_id');
				$where = " AND (corrective.process_owner = " . $employee_id . " OR corrective.line_worker = " . $employee_id . ")";
			}
			$sql = "SELECT corrective.create_at,
                                corrective.id,
                                corrective.mashine_clause,
                                corrective.prob_desc,
		                        t.trigger_name,
                                (SELECT employee_name FROM employees WHERE corrective.process_owner = employees.employee_id) AS process_owner_name
                        FROM
                                corrective_action_data AS corrective
                        LEFT JOIN `trigger` t ON corrective.trigger_id = t.trigger_id
                        WHERE
                                corrective.id IN (
                                        SELECT corrective_id FROM corrective_message WHERE company_id = " . $consultant_id . "
                                )" . $where . "
                        ORDER BY corrective.id DESC";

			$data['corrective_message'] = $this->db->query($sql)->result();
			$this->load->view('consultant/corrective_message', $data);
		} else {
			redirect('Welcome');
		}
	}
	public function show_corrective_message($id = '')
	{
		$data['dd1'] = 'active';
		$data['d1'] = 'act1';
		$consultant_id = $this->session->userdata('consultant_id');
		$com_status = $this->session->userdata('com_status');
		if ($consultant_id && $com_status != '0') {
			$this->db->where('corrective_id', $id);
			$this->db->where('company_id', $consultant_id);
			$this->db->order_by('date_time', 'asc');
			$data['message'] = $this->db->get('corrective_message')->result();
			$data['title']   = "Messages";
			$this->db->where('id', $id);
			$data['standalone_data'] = $this->db->get('corrective_action_data')->row();
			$data['corrective_id'] = $id;
			$this->load->view('consultant/show_corrective_message', $data);
		} else {
			redirect('Welcome');
		}
	}
	public function send_corrective_message() {
		$consultant_id  = $this->session->userdata('consultant_id');
		$com_status  = $this->session->userdata('com_status');
		$user_type = $this->session->userdata('user_type');
		$message = $this->input->post('message');
		$corrective_id = $this->input->post('corrective_id');
		if ($user_type == "consultant"){
			if ($consultant_id && $com_status != '0') {
				$created_at = date('Y-m-d h:i:s');

				$data = array(
						'company_id' => $consultant_id,
						'sender_id' => $consultant_id,
						'sender_role' => 'Consultant',
						'message' => $message,
						'date_time' => $created_at,
						'corrective_id' => $corrective_id
				);
				$done = $this->db->insert('corrective_message', $data);
				print_r($this->db->last_query());
				echo json_encode($done);
			} else {
				redirect('Welcome');
			}
		}else{
			$employee_id = $this->session->userdata('employee_id');
			if ($employee_id) {
				$created_at = date('Y-m-d h:i:s');

				$data = array(
						'company_id' => $consultant_id,
						'sender_id' => $employee_id,
						'sender_role' => $user_type,
						'message' => $message,
						'date_time' => $created_at,
						'corrective_id' => $corrective_id
				);
				$done = $this->db->insert('corrective_message', $data);
				echo json_encode($done);
			} else {
				redirect('Welcome');
			}
		}
	}
	public function individual_message()
	{
		$data['dd1'] = 'active';
		$data['d2'] = 'act1';
		$consultant_id = $this->session->userdata('consultant_id');
		$com_status = $this->session->userdata('com_status');
		$user_type = $this->session->userdata('user_type');
		$data['title'] = "Individual Inbox";
		if ($user_type == "consultant"){
			if ($consultant_id && $com_status != '0') {
				$this->db->order_by('date_time', 'desc');
				$this->db->where('company_id', $consultant_id);
				$data['individual_message'] = $this->db->get('individual_message')->result();
				$this->db->where('consultant_id', $consultant_id);
				$data['employees'] = $this->db->get('employees')->result();
				$this->load->view('consultant/individual_message', $data);
			} else {
				redirect('Welcome');
			}
		}else{
			$employee_id = $this->session->userdata('employee_id');
			if ($employee_id) {
				$data['title'] = "Individual Inbox";
				$sql = "SELECT
							*
						FROM
							individual_message
						WHERE
							company_id = " . $consultant_id . "
						AND (from_user = " . $employee_id . " OR to_user = " . $employee_id . ")
						ORDER BY
							date_time DESC";
				$data['individual_message'] = $this->db->query($sql)->result();
				$this->db->where('consultant_id', $consultant_id);
				$this->db->where('employee_id !=', $employee_id);
				$data['employees'] = $this->db->get('employees')->result();
				$this->load->view('consultant/individual_message', $data);
			} else {
				redirect('Welcome');
			}
		}
	}
	function mails_to_indi()
	{
		$consultant_id = $this->session->userdata('consultant_id');
		$user_type = $this->session->userdata('user_type');
		$title      = $this->input->post('title');
		$message    = $this->input->post('message');
		$to_user    = $this->input->post('to_user');
		$date_time  = date('Y-m-d');
		if ($user_type == "consultant"){
			$mszdata = array(
					'company_id' => $consultant_id,
					'message' => $message,
					'from_user' => $consultant_id,
					'to_user' => $to_user,
					'from_role' => 'consultant',
					'to_role' => 'employee',
					'title' => $title,
					'date_time' => $date_time
			);
		}else{
			if ($to_user == 'owner') {
				$to_role = 'consultant';
			} else {
				$to_role = 'employee';
			}
			$employee_id = $this->session->userdata('employee_id');
			$mszdata = array(
					'company_id' => $consultant_id,
					'message' => $message,
					'from_user' => $employee_id,
					'to_user' => $to_user,
					'from_role' => 'employee',
					'to_role' => $to_role,
					'title' => $title,
					'date_time' => $date_time
			);
		}
		$done    = $this->db->insert('individual_message', $mszdata);
		$data_id = $this->db->insert_id();
		if ($user_type == "consultant"){
			if ($done) {
				$mszdata1 = array(
						'company_id' => $consultant_id,
						'message' => $message,
						'from_user' => $consultant_id,
						'to_user' => $to_user,
						'from_role' => 'consultant',
						'to_role' => 'employee',
						'title' => $title,
						'data_id' => $data_id,
						'date_time' => $date_time
				);
				$this->db->insert('individual_message_data', $mszdata1);
			}
		}else{
			if ($done) {
				$mszdata1 = array(
						'company_id' => $consultant_id,
						'message' => $message,
						'from_user' => $employee_id,
						'to_user' => $to_user,
						'from_role' => 'employee',
						'to_role' => $to_role,
						'title' => $title,
						'data_id' => $data_id,
						'date_time' => $date_time
				);
				$this->db->insert('individual_message_data', $mszdata1);
			}
		}
		redirect('consultant/individual_message');
	}
	public function show_individual_message($id = '')
	{
		$data['dd1'] = 'active';
		$data['d2'] = 'act1';
		$consultant_id = $this->session->userdata('consultant_id');
		$com_status = $this->session->userdata('com_status');
		if ($consultant_id && $com_status != '0') {
			$this->db->where('data_id', $id);
			$data['message'] = $this->db->get('individual_message_data')->result();
			$data['title']   = "Messages";
			$this->db->where('id', $id);
			$data['title_msz'] = $this->db->get('individual_message')->row();
			$this->load->view('consultant/show_individual_message', $data);
		} else {
			redirect('Welcome');
		}
	}
	function mails_to_indi_data()
	{
		$consultant_id = $this->session->userdata('consultant_id');
		$user_type = $this->session->userdata('user_type');
		$message    = $this->input->post('message');
		$to_user    = $this->input->post('to_user');
		$data_id    = $this->input->post('data_id');
		$date_time  = date('Y-m-d');
		if ($user_type == "consultant"){
			$mszdata1 = array(
					'company_id' => $consultant_id,
					'message' => $message,
					'from_user' => $consultant_id,
					'to_user' => $to_user,
					'from_role' => 'consultant',
					'to_role' => 'employee',
					'data_id' => $data_id,
					'date_time' => $date_time
			);
		}else{
			$employee_id = $this->session->userdata('employee_id');
			if ($to_user == '0') {
				$ml      = $this->db->query("select * from `consultant` where `consultant_id`='$consultant_id'")->row();
				$to_role = 'consultant';
			} else {
				$ml      = $this->db->query("select * from `employees` where `employee_id`='$to_user'")->row();
				$to_role = 'employee';
			}
			$mszdata1 = array(
					'company_id' => $consultant_id,
					'message' => $message,
					'from_user' => $employee_id,
					'to_user' => $to_user,
					'from_role' => "employee",
					'to_role' => $to_role,
					'data_id' => $data_id,
					'date_time' => $date_time
			);
		}
		$this->db->insert('individual_message_data', $mszdata1);
		redirect('Consultant/show_individual_message/' . $data_id);
	}
	public function report()
	{
		$data['ee1']             = 'active';
		$data['e1']              = 'act1';
		$company_id              = $this->session->userdata('consultant_id');
		$user_type              = $this->session->userdata('user_type');
		$data['admin_emails']    = $this->db->query("SELECT * FROM `admin`")->row()->email;
		$data['comp_email']      = $this->db->query("SELECT * FROM `consultant` WHERE `consultant_id`='$company_id'")->row()->email;
		$data['employees_email'] = $this->db->query("SELECT * FROM `employees` WHERE `consultant_id`='$company_id' &&  `employee_email`!=''")->result();
		if ($company_id) {
			$data['title'] = "MONITORING ACTIVITY";
			$this->db->select("control_list.*,frequency.frequency_name,frequency.days,frequency.type,DATEDIFF(control_list.review_date,now()) due,now() now_date");
			$this->db->join("process","process.id = control_list.process_id","left");
			$this->db->join("risk","process.risk_id = risk.id","left");
			$this->db->join("frequency","frequency.frequency_id = control_list.frequency","left");
			$this->db->where('risk.company_id', $company_id);
			$this->db->where('risk.status', '0');
			if ($user_type != "consultant"){
				$employee_id = $this->session->userdata('employee_id');
				if ($user_type == "process_owner"){
					$this->db->where('(control_list.sme = '.$employee_id.' OR process.process_owner = '.$employee_id.')');
				}else{
					$this->db->where('(control_list.monitor = '.$employee_id.' OR control_list.responsible_party = '.$employee_id.')');
				}
			}
			//$this->db->order_by('control_list.status,review_date', 'DESC');
			$this->db->order_by('control_list.status', 'ASC');
			$this->db->order_by('review_date', 'DESC');

			$list = $this->db->get('control_list')->result();
			$data['standalone_data'] = $list;
			$this->load->view('consultant/report', $data);
		} else {
			redirect('Welcome');
		}
	}
	public function conduct()
	{
		$this->session->set_userdata("sidebar_history","1");
		$data['ee1']             = 'active';
		$data['e2']              = 'act1';
		$company_id              = $this->session->userdata('consultant_id');
		$user_type              = $this->session->userdata('user_type');
		$data['admin_emails']    = $this->db->query("SELECT * FROM `admin`")->row()->email;
		$data['comp_email']      = $this->db->query("SELECT * FROM `consultant` WHERE `consultant_id`='$company_id'")->row()->email;
		$data['employees_email'] = $this->db->query("SELECT * FROM `employees` WHERE `consultant_id`='$company_id' &&  `employee_email`!=''")->result();
		if ($company_id) {
			$data['title'] = "MONITORING ACTIVITY";
			$this->db->select("risk.name hazard_name, process.potential_hazard, control_list.*,frequency.frequency_name,frequency.days,frequency.type, DATEDIFF(control_list.review_date, IF (`control_list`.active <> 1, `control_list`.active_at, now())) due, IF (`control_list`.active <> 1, `control_list`.active_at, now()) now_date");
			$this->db->join("process","process.id = control_list.process_id","left");
			$this->db->join("risk","process.risk_id = risk.id","left");
			$this->db->join("frequency","frequency.frequency_id = control_list.frequency","left");
			$this->db->where('risk.company_id', $company_id);
			$this->db->where('risk.status', '0');
			$this->db->where('risk.del_flag', '0');
			if ($user_type != "consultant"){
				$employee_id = $this->session->userdata('employee_id');
				if ($user_type == "process_owner"){
					$this->db->where('(control_list.sme = '.$employee_id.' OR process.process_owner = '.$employee_id.')');
				}else{
					$this->db->where('(control_list.monitor = '.$employee_id.' OR control_list.responsible_party = '.$employee_id.')');
				}
			}
			//$this->db->order_by('control_list.status,review_date', 'DESC');
			$this->db->order_by('control_list.status', 'ASC');
			$this->db->order_by('review_date', 'DESC');

			$list = $this->db->get('control_list')->result();

			$data['standalone_data'] = $list;
			$this->load->view('consultant/conduct', $data);
		} else {
			redirect('Welcome');
		}
	}
	public function verification_log()
	{
		$data['ee1']             = 'active';
		$data['e3']              = 'act1';
		$company_id              = $this->session->userdata('consultant_id');
		$user_type              = $this->session->userdata('user_type');
		$data['admin_emails']    = $this->db->query("SELECT * FROM `admin`")->row()->email;
		$data['comp_email']      = $this->db->query("SELECT * FROM `consultant` WHERE `consultant_id`='$company_id'")->row()->email;
		$data['employees_email'] = $this->db->query("SELECT * FROM `employees` WHERE `consultant_id`='$company_id' &&  `employee_email`!=''")->result();
		if ($company_id) {
			$data['title'] = "View Details of Previous Inspection";
			$this->db->select("monitoring_history.*,control_list.name control_name,frequency.frequency_name,frequency.days,frequency.type,DATEDIFF(control_list.review_date,now()) due, TO_SECONDS(control_list.review_date) review_date_time, TO_SECONDS(now()) now_time");
			$this->db->join("control_list","monitoring_history.control_id = control_list.id","left");
			$this->db->join("process","process.id = control_list.process_id","left");
			$this->db->join("risk","process.risk_id = risk.id","left");
			$this->db->join("frequency","frequency.frequency_id = control_list.frequency","left");
			$this->db->where('risk.company_id', $company_id);
			if ($user_type != "consultant"){
				$employee_id = $this->session->userdata('employee_id');
				if ($user_type == "process_owner"){
					$this->db->where('(control_list.sme = '.$employee_id.' OR process.process_owner = '.$employee_id.')');
				}else{
					$this->db->where('(control_list.monitor = '.$employee_id.' OR control_list.responsible_party = '.$employee_id.')');
				}
			}
			$this->db->order_by('control_list.review_date', 'DESC');
			$list = $this->db->get('monitoring_history')->result();
			$data['standalone_data'] = $list;
            $data['base_url'] = base_url();
			$this->load->view('consultant/verification_log', $data);
		} else {
			redirect('Welcome');
		}
	}
	//export risk
	public function download_risk()
	{
		$risk_type = $this->input->get('type');
		$risk_status = $this->input->get('status');
		$this->load->library("Pdf");
		$consultant_id  = $this->session->userdata('consultant_id');
		if ($risk_type != -1){
			$this->db->where('risk_type', $risk_type);
		}
		if ($risk_status != -1){
			$this->db->where('status', $risk_status);
		}
		$this->db->where('company_id', $consultant_id);
		$this->db->where('del_flag', '0');
		$temp = $this->db->get('risk')->result();
		$this->db->where('consultant_id', $consultant_id);
		$consultant = @$this->db->get('consultant')->row();
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, TRUE, 'UTF-8', FALSE);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		$pdf->SetPrintFooter(FALSE);
		$pdf->SetPrintHeader(FALSE);

		$pdf->AddPage();

		$html =  "
			<style>
				h1 {
					text-align: center;
					text-transform: capitalize;
				}
			</style>
			<div class='content'>";
		$html .= '<table style="margin-left: 20px;width: 600px;">';
		$html .= '<tr style="text-align: center;">';
		$html .= '<td style="padding-left: 40px;padding-right: 40px;height: 850px;text-align: center;">';
		$html .= '<table style="text-align: center;">';
		$html .= '<tr><td style="height: 100px;"></td></tr>';
		$html .= '<tr ><td style="height: 150px;"><p style="font-size: 40px;">Risk and Opportunities</p></td></tr>';
		$html .= '<tr><td><p style="font-size: 20px;">'.$consultant->consultant_name.'</p></td></tr>';
		$html .= '<tr><td><p style="font-size: 15px;">'.$consultant->contact_no.'</p></td></tr>';
		$html .= '<tr><td><p style="font-size: 15px;">'.$consultant->address.'</p></td></tr>';
		$html .= '</table>';
		$html .= '</td>';
		$html .= '</tr>';

		$html .= '<tr style="text-align: center;"><td style="height: 850px;text-align: center;"><table cellpadding="5" style="text-align: center;">';
		$html .= '<tr><td style="text-align: left;width: 10%;font-size: 12px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">Hazard Name</td><td style="text-align: left;width: 20%;font-size: 12px;border-bottom-width:1px;border-bottom-color: #DCDCDC;background-color:#F5F5F5;">Assessment Type</td><td style="text-align: left;width: 20%;font-size: 12px;border-bottom-width:1px;border-bottom-color: #DCDCDC;background-color:#F5F5F5;">Description</td><td style="text-align: left;width: 20%;font-size: 12px;border-bottom-width:1px;border-bottom-color: #DCDCDC;background-color:#F5F5F5;">Detail and Technical Data</td><td style="text-align: left;width: 20%;font-size: 12px;border-bottom-width:1px;border-bottom-color: #DCDCDC;background-color:#F5F5F5;">Risk Type</td><td style="text-align: left;width: 10%;font-size: 12px;border-bottom-width:1px;border-bottom-color: #DCDCDC;background-color:#F5F5F5;">Status</td></tr>';
		$count = 0;
		foreach ($temp as $row){
			$count++;
			if ($row->risk_type == 0){
				$risk_type = "Strategic Risk";
			}else if ($row->risk_type == 1){
				$risk_type = "Operational Risk";
			}else if ($row->risk_type == 2){
				$risk_type = "Prerequisite Program(PRP)";
			}else{
				$risk_type = "FSSC Additional Requirement";
			}
			if ($row->status == 0){
				$status = "OPEN";
			}else{
				$status = "CLOSE";
			}
			$html .= '<tr>';
			if ($count % 2 == 0){
				$html .= '<td style="text-align: left;font-size: 10px;margin:10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->name.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;padding-top:10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->assess_type.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;padding-top:10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->description.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;padding-top:10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->detail.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;padding-top:10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$risk_type.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;padding-top:10px;background-color:#F5F5F5;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$status.'</td>';
			}else{
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->name.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->assess_type.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->description.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$row->detail.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$risk_type.'</td>';
				$html .= '<td style="text-align: left;font-size: 10px;background-color:#FFFFFF;border-bottom-width:1px;border-bottom-color: #DCDCDC;">'.$status.'</td>';
			}

			$html .= '</tr>';
		}
		$html .="</table></td></tr>";
		$html .="</table>";
		$html .="</div>";

		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, TRUE, '', TRUE);

		// $pdf->Output($contract['contract_title'].'.pdf', 'D');
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/RMT/uploads/doc/')){
			mkdir($_SERVER['DOCUMENT_ROOT'].'/RMT/uploads/doc/', 0777, TRUE);
		}
		if (ob_get_length()) ob_end_clean();
		$pdf->Output('risk_'.$consultant_id.'.pdf', 'D');
	}

	public function payment_list() {
        $data['cc1'] = 'active';
        $data['c16']  = 'act1';
        $consultant_id  = $this->session->userdata('consultant_id');
        if ($consultant_id) {
            $data['title'] = "Invoice";

            $data['payments'] = $this->Payment_model->find(['consultant_id' => $consultant_id]);

            $this->load->view('consultant/payment_list', $data);
        } else {
            redirect('Welcome');
        }
    }

	//material
	public function manage_material()
	{
		$data['cc1'] = 'active';
		$data['c17'] = 'act1';
		$consultant_id = $this->session->userdata('consultant_id');
		if($consultant_id){
			$data['title'] = "Material";
			$this->load->view('consultant/manage/manage_material', $data);
		}else{
			redirect('Welcome');
		}
	}

	public function material_read($id = NULL)
	{
		$consultant_id  = $this->session->userdata('consultant_id');
		$displayStart = $this->input->post('iDisplayStart');
		$displayLength = $this->input->post('iDisplayLength');
		$search = $this->input->post('sSearch');
		$sortingCols = $this->input->post('iSortingCols');
		$material_list = $this->input->post('material_list');
		$data = array();
		if (isset($id)) {
			$data['material'] = '';
		} else {
			$filter['del_flag'] = 0;
			if ($displayLength != -1) {
				$filter['start'] = $displayStart;
				$filter['limit'] = $displayLength;
				$filter['search'] = $search;
			}
			$order = array();
			for ($i = 0; $i < $sortingCols; $i++) {
				$sortCol = $this->input->post('iSortCol_' . $i);
				$sortDir = $this->input->post('sSortDir_' . $i);
				$dataProp = $this->input->post('mDataProp_' . $sortCol);
				$order[$dataProp] = $sortDir;
			}
			$sql = "SELECT * FROM material
										WHERE
												del_flag = 0 and company_id = ".$consultant_id;
			$data['iTotalRecords'] = count($this->db->query($sql)->result());
			if ($material_list != ''){
				$temp = explode(",",$material_list);
				$temp_count = 0;
				$sql .= " and (";
				foreach ($temp as $temp_data){
					$temp_count++;
					$sql .= " id = ".$temp_data;
					if ($temp_count != count($temp)){
						$sql .= " OR";
					}
				}
				$sql .= " )";
			}
			if ($search != ''){
				$sql .= " and (name like '%".$search."%')";
			}
			$data['iTotalDisplayRecords'] = count($this->db->query($sql)->result());
			$sql .= " ORDER BY ";
			$count = 0;
			foreach ($order as $key => $val) {
				if($count > 0){
					$sql .= ", ";
				}
				$sql .= $key." ".$val;
				$count = $count + 1;
			}
			$sql .= " limit ".$displayStart.", ".$displayLength;
			$data['material'] = $this->db->query($sql)->result();
			$data['sEcho'] = $search;
		}
		$this->render_json($data);
	}

	public function delete_material() {
		$id = $this->input->post('id', TRUE);
		$this->db->where('id', $id);
		$result = $this->db->update('material', array('del_flag'=>'1'));
		echo json_encode(array('success'=>$result));
	}

	public function edit_material()
	{
		$consultant_id  = $this->session->userdata('consultant_id');
		$id = $this->input->post('id');
		//$data[company_id] = $consultant_id;
		$data['name'] = $this->input->post('name');
		$data['upc'] = $this->input->post('upc');
		$data['size'] = $this->input->post('size');
		$data['barcode_info'] = $this->input->post('barcode_info');
		$data['company_id'] = $consultant_id;

		if ($id == 0){
			$done = $this->db->insert('material', $data);
		}else{
			$this->db->where('id', $id);
			$done = $this->db->update('material', $data);
		}
		if ($done) {
			echo "success";
		} else {
			echo "";
		}
	}

	//machine
	public function manage_machine()
	{
		$data['cc1'] = 'active';
		$data['c18'] = 'act1';
		$consultant_id = $this->session->userdata('consultant_id');
		if($consultant_id){
			$data['title'] = "Machine";
			$this->load->view('consultant/manage/manage_machine', $data);
		}else{
			redirect('Welcome');
		}
	}

	public function machine_read($id = NULL)
	{
		$consultant_id  = $this->session->userdata('consultant_id');
		$displayStart = $this->input->post('iDisplayStart');
		$displayLength = $this->input->post('iDisplayLength');
		$search = $this->input->post('sSearch');
		$sortingCols = $this->input->post('iSortingCols');
		$machine_list = $this->input->post('machine_list');
		$data = array();
		if (isset($id)) {
			$data['machine'] = '';
		} else {
			$filter['del_flag'] = 0;
			if ($displayLength != -1) {
				$filter['start'] = $displayStart;
				$filter['limit'] = $displayLength;
				$filter['search'] = $search;
			}
			$order = array();
			for ($i = 0; $i < $sortingCols; $i++) {
				$sortCol = $this->input->post('iSortCol_' . $i);
				$sortDir = $this->input->post('sSortDir_' . $i);
				$dataProp = $this->input->post('mDataProp_' . $sortCol);
				$order[$dataProp] = $sortDir;
			}
			$sql = "SELECT * FROM machine
										WHERE
												del_flag = 0 and company_id = ".$consultant_id;
			$data['iTotalRecords'] = count($this->db->query($sql)->result());
			if ($machine_list != ''){
				$temp = explode(",",$machine_list);
				$temp_count = 0;
				$sql .= " and (";
				foreach ($temp as $temp_data){
					$temp_count++;
					$sql .= " id = ".$temp_data;
					if ($temp_count != count($temp)){
						$sql .= " OR";
					}
				}
				$sql .= " )";
			}
			if ($search != ''){
				$sql .= " and (name like '%".$search."%')";
			}
			$data['iTotalDisplayRecords'] = count($this->db->query($sql)->result());
			$sql .= " ORDER BY ";
			$count = 0;
			foreach ($order as $key => $val) {
				if($count > 0){
					$sql .= ", ";
				}
				$sql .= $key." ".$val;
				$count = $count + 1;
			}
			$sql .= " limit ".$displayStart.", ".$displayLength;
			$data['machine'] = $this->db->query($sql)->result();
			$data['sEcho'] = $search;
		}
		$this->render_json($data);
	}

	public function delete_machine() {
		$id = $this->input->post('id', TRUE);
		$this->db->where('id', $id);
		$result = $this->db->update('machine', array('del_flag'=>'1'));
		echo json_encode(array('success'=>$result));
	}

	public function edit_machine()
	{
		$consultant_id  = $this->session->userdata('consultant_id');
		$id = $this->input->post('id');
		//$data[company_id] = $consultant_id;
		$data['name'] = $this->input->post('name');
		$data['number'] = $this->input->post('number');
		$data['location'] = $this->input->post('location');
		$data['next_maintenance'] = $this->input->post('next_maintenance');
		$data['last_maintenance'] = $this->input->post('last_maintenance');
		$data['company_id'] = $consultant_id;

		if ($id == 0){
			$done = $this->db->insert('machine', $data);
		}else{
			$this->db->where('id', $id);
			$done = $this->db->update('machine', $data);
		}
		if ($done) {
			echo "success";
		} else {
			echo "";
		}
	}

	//machine
	public function traceability_log()
	{
		$data['ee1'] = 'active';
		$data['e4'] = 'act1';
		$consultant_id = $this->session->userdata('consultant_id');
		if($consultant_id){
			$data['title'] = "Traceability Log";
			$this->load->view('consultant/traceability_log', $data);
		}else{
			redirect('Welcome');
		}
	}

	public function traceability_log_read($id = NULL)
	{
		$consultant_id  = $this->session->userdata('consultant_id');
		$user_type              = $this->session->userdata('user_type');
		$displayStart = $this->input->post('iDisplayStart');
		$displayLength = $this->input->post('iDisplayLength');
		$search = $this->input->post('sSearch');
		$sortingCols = $this->input->post('iSortingCols');
		$data = array();
		if (isset($id)) {
			$data['machine'] = '';
		} else {
			$filter['del_flag'] = 0;
			if ($displayLength != -1) {
				$filter['start'] = $displayStart;
				$filter['limit'] = $displayLength;
				$filter['search'] = $search;
			}
			$order = array();
			for ($i = 0; $i < $sortingCols; $i++) {
				$sortCol = $this->input->post('iSortCol_' . $i);
				$sortDir = $this->input->post('sSortDir_' . $i);
				$dataProp = $this->input->post('mDataProp_' . $sortCol);
				$order[$dataProp] = $sortDir;
			}
			$sql = "SELECT control_barcode.* FROM control_barcode left join control_list on control_barcode.control_id = control_list.id left join process b on control_list.process_id = b.id left join risk c on b.risk_id = c.id where c.company_id = ".$consultant_id;
			if ($user_type != "consultant"){
				$employee_id = $this->session->userdata('employee_id');
				if ($user_type == "process_owner"){
					$sql .= ' and (control_list.sme = '.$employee_id.' OR process.process_owner = '.$employee_id.')';
				}else{
					$sql .= ' and (control_list.monitor = '.$employee_id.' OR control_list.responsible_party = '.$employee_id.')';
				}
			}
			$data['iTotalRecords'] = count($this->db->query($sql)->result());
			if ($search != ''){
				$sql .= " and (control_barcode.product_name like '%".$search."%')";
			}
			$data['iTotalDisplayRecords'] = count($this->db->query($sql)->result());
			$sql .= " ORDER BY ";
			$count = 0;
			foreach ($order as $key => $val) {
				if($count > 0){
					$sql .= ", ";
				}
				$sql .= "control_barcode.".$key." ".$val;
				$count = $count + 1;
			}
			$sql .= " limit ".$displayStart.", ".$displayLength;
			$data['traceability'] = $this->db->query($sql)->result();
			$data['sEcho'] = $search;
		}
		$this->render_json($data);
	}

	function findresponsible(){
	    $id = $this->input->post('id');
        $this->db->where('employee_id', $id);
        $row = $this->db->get('employees')->row();

        echo $row->role;
    }

    function analytics() {
    	$data['bb1']   = 'active';
		$data['b3']    = 'act1';

		$data['title'] = 'Corrective Action Resolution Log';

		$company_id    = $this->session->userdata('consultant_id');

		if ($company_id)
			$this->load->view('consultant/analytics', $data);
		else
			$this->redirect('welcome');
    }

    function library() {
    	$data['menu_title'] = 'Library';
    	$data['title'] = 'Library';

    	$consultant_id = $this->session->userdata('consultant_id');
    	if ($consultant_id) {
    		$data['audito'] = $this->Consultant_model->one(['consultant_id' => $consultant_id]);
    		$data['dlogo'] = $this->Default_logo_model->one(['id' => 1]);
    		$this->load->view('consultant/library', $data);
    	} else
    		$this->redirect('welcome');
    }

    function library_create_directory() {
    	
    }

    function redirect($url) {
		$url = base_url($url);
		header("Location: {$url}");
	}

	/****
		
		Function for saving 2FA
		Security Question & Answer.
		
	****/

	public function update_security_question()
	{
		$consultant_id   = $this->session->userdata('consultant_id');
		//$employee_id  = $this->session->userdata('employee_id');
		$up = array(
				'is2FAEnabled' => 1,
				'security_question' => $this->input->post('question'),
				'security_answer' => $this->input->post('answer')
		);
		if ($consultant_id) {
			$this->db->where('consultant_id', $consultant_id);
			$done = $this->db->update('consultant', $up);
			if ($done) {
				$this->session->set_flashdata('message', 'update_security_success');
				redirect('Consultant/main_info');
			} else {
				redirect('Consultant/main_info');
			}
		} else {
			redirect('Welcome');
		}
	}






}
