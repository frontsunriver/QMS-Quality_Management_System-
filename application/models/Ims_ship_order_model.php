<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ims_ship_order_model extends MY_Model
{
	public $_table = 'ims_ship_order';


	public function getAllShipOrderByWHID($wh_id){
        $sql = "SELECT a.id AS id, b.name AS partner, a.des_location AS des_location, a.status AS status, a.scheduled_date AS scheduled_date ".
                "FROM ims_ship_order as a LEFT JOIN ims_customer as b ON a.partner = b.id WHERE a.warehouse_id = $wh_id";
        return $this->db->query($sql)->result_array();
    }
}