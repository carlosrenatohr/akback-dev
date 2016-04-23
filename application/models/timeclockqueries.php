<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TimeClockQueries extends CI_Model{

    function insert($table, $data){
        $this->db->insert($table, $data);
        $newid = $this->db->insert_id();
        return $newid;
    }

    function update($table, $fieldname, $data, $unique){
        $this->db->where($fieldname, $unique);
        $this->db->update($table, $data);
        $result = $this->db->affected_rows();
        if($result > 0){
            return true;
        }else{
            return false;
        }
    }

    function update_multiple_id($table, $fields_array, $data){
        $this->db->where($fields_array);
        $this->db->update($table, $data);
        $result = $this->db->affected_rows();
        if($result > 0){
            return true;
        }else{
            return false;
        }
    }

    function load_timeclock(){
        $this->db->select("*");
        $this->db->where("status", 1);
        $this->db->order_by("user_name", "asc");
        $query = $this->db->get("time_clock");
        $result = $query->result_array();
        return $result;
    }

    function test(){
        $this->db->select("unique");
        $query = $this->db->get("time_clock");
        $result = $query->result_array();
        return $result;
    }

}