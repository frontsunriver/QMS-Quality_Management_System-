<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authmodel extends CI_Model {

	public function index()
	{

	}
   public function admin_login($username,$password)
	{   
			$this->db->where('password',$password);
            $this->db->where('username',$username);
		    $query=$this->db->get('admin');
	 if (count($query->row())>0) {
	 	return $query->row();
	 }else{
	 	return false;
	 }
	}
	public function employee_login($username,$password,$usertype)
	{
		$this->db->where('employees.status',1);
		$this->db->where('employees.password',$password);
		$this->db->where('employees.username',$username);
		$query=$this->db->get('employees');
		 if (count($query->row())>0) {
			return $query->row();
		 }else{
			return false;
		 }
	}
	public function consultant_login($username,$password)
	{   
			$this->db->where('password',$password);
            $this->db->where('username',$username);
		    $query=$this->db->get('consultant');
	 if (count($query->row())>0) {
	 	return $query->row();
	 }else{
	 	return false;
	 }
	}

	 public function consultant_register($data=NULL)
	{   
	 $query=$this->db->insert('consultant',$data);
	  return $this->db->insert_id();
	}


    public function consultant_purchase($data=NULL,$consultant_id=NULL)
	{   
	        $this->db->where('consultant_id',$consultant_id);
		    $query=$this->db->get('purchase_plan');
		    if (count($query->row())>0) {
		    	  $this->db->where('consultant_id',$consultant_id);
		    	  $this->db->update('purchase_plan',$data);
	              return 1;
		    }else{
		    	 $this->db->insert('purchase_plan',$data);
	              return $this->db->insert_id();
		    }
	}


	public function consultant_ot_login($username,$password)
	{   
			$this->db->where('password',$password);
            $this->db->where('username',$username);
		    $query=$this->db->get('employees');
	 if (count($query->row())>0) {
	 	return $query->row();
	 }else{
	 	return false;
	 }
	}



	public function admin_email($email)
	{   
            $this->db->where('email',$email);
		    $query=$this->db->get('admin');
	 if (!empty($query->row())) {
	 	return $query->row();
	 }else{
	 	return false;
	 }
	}
	public function employee_email($email)
	{   
            $this->db->where('employee_email',$email);
		    $query=$this->db->get('employees');
	 if (!empty($query->row())>0) {
	 	return $query->row();
	 }else{
	 	return false;
	 }
	}
	public function consultant_email($email)
	{   
            $this->db->where('email',$email);
		    $query=$this->db->get('consultant');
	 if (!empty($query->row())>0) {
	 	return $query->row();
	 }else{
	 	return false;
	 }
	}

}
