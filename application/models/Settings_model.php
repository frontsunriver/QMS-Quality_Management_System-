<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model {


    function getEmailTemplate($where){
        $result = $this->db->get_where('settings_email_template', $where);
        $res=$result->row_array();
        return $res;
    }



}
