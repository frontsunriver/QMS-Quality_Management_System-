<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends MY_Model
{
	function login($param, $usertype) {
		// $param['password'] = md5($param['password']);

		if ($usertype == 'employee')
			$param['status'] = 1;

		if ($usertype == 'admin' || $usertype == 'consultant')
			$this->_table = $usertype;
		else {
			$this->db->where("role LIKE '%{$usertype}%'");
			$this->_table = 'employees';
		}
		return $this->one($param);
	}

	public function employee_login($username,$usertype)
	{
		$this->db->join('permision', 'permision.employee_id = employees.employee_id', 'left');
		$this->db->join('user_type', 'permision.type_id = user_type.utype_id', 'left');
		$this->db->where('employees.status',1);
		/*$this->db->where('employees.password',$password);*/
		$this->db->where('employees.username',$username);
		$this->db->where('user_type.utype_name',$usertype);
		$query=$this->db->get('employees');
		if ($query->num_rows()>0) {
			return $query->row();
		}else{
			return false;
		}
	}

	function consultant_register($param) {
		$this->_table = 'consultant';
		
		return $this->insert($param);
	}
}