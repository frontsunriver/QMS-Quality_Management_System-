<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OTPVerification extends CI_Model {

    public $table = 'auth_otp';

    public function set_auth_OTP($data)
    {
        $this->db->where('model_id', $data['model_id']);
        $this->db->where('model_name', $data['model_name']);
        $q = $this->db->get($this->table);
        $this->db->reset_query();

        if ( $q->num_rows() > 0 )
        {
            $this->db->where('model_id', $data['model_id']);
            return $this->db->where('model_name', $data['model_name'])->update($this->table, $data);
        } else {

            return $this->db->insert($this->table, $data);
        }
    }
    public function get_auth_OTP($data)
    {
        $this->db->where('model_id', $data['model_id']);
        $this->db->where('model_name', $data['model_name']);
        $this->db->where('otp', $data['otp']);
        $q = $this->db->get($this->table);
        $this->db->reset_query();

        return $q->num_rows();
    }


}
