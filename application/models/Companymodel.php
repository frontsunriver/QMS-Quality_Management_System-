<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Companymodel extends CI_Model {

	public function index()
	{

	}

    public function update_company($data = array(),$company_id = 0)
	{
		  $this->db->where('consultant_id',$company_id);
		  return $this->db->update('consultant',$data);
	}

	public function get_company($id = 0)
	{

		$this->db->where('consultant_id', $id);
		$company = $this->db->get('consultant')->row();
		if($company != null) 	return $company;
		else					return false;

	}

}
