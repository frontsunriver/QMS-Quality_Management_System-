<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Planmodel extends CI_Model {

	public function index()
	{

	}

	public function get_plan($id = 0)
	{

		$this->db->where('plan_id', $id);
		$plan = $this->db->get('plan')->row();
		if($plan != null) 	return $plan;
		else					return false;

	}

}
