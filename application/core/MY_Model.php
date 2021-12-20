<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {
  public $_table;
  
  function one($where = [], $select = ["A.*"], $array = FALSE) {
    $this->db->where($where);
    $this->db->select($select);

    if ($array)
      return $this->db->get("{$this->_table} A")->row_array();
    else
      return $this->db->get("{$this->_table} A")->row();
  }

  function find($where = [], $order_by = [], $select = ["A.*"], $array = FALSE) {
    $this->db->where($where);
    $this->order_by($order_by);
    $this->db->select($select);

    if ($array)
      return $this->db->get("{$this->_table} A")->result_array();
    else
      return $this->db->get("{$this->_table} A")->result();
  }

  function count($where = []) {
    $this->db->where($where);
    $this->db->from("{$this->_table} A");
    
    return $this->db->count_all_results();
  }

  function select_sum($where = [], $select = 'id') {
    $this->db->where($where);
    $this->db->select_sum($select);
    $result = $this->db->get($this->_table)->row()->{$select};
    
    return !$result ? 0 : $result;
  }

  function select_max($field) {
    $this->db->select_max($field);
    $result = $this->db->get($this->_table)->row()->{$field};
        
    return !$result ? 0 : $result;
  }

  function insert($data = []) {
    $this->db->insert($this->_table, $data);
    return $this->db->insert_id();
  }

  function update($where = [], $set = []) {
    $this->db->where($where);
    $this->db->update($this->_table, $set);
    return $this->db->affected_rows();
  }

  function delete($where = []) {
    $this->db->where($where);
    $this->db->delete($this->_table);
    return $this->db->affected_rows();
  }

  function order_by($order_by = []) {
    if (!empty($order_by)) {
      foreach ($order_by as $key => $value) {
        $this->db->order_by($key, $value);
      }
    }
  }

  function num_rows($where = []) {
    $this->db->where($where);
    return $this->db->get("{$this->_table} A")->num_rows();
  }
}
