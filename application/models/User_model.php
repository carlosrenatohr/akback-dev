<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 04-25-16
 * Time: 03:54 PM
 */
class user_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getLists()
    {
        $this->db->select("*");
        $this->db->from("config_user");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function store($data)
    {
        $result = $this->db->insert('config_user', $data);
        return $result;
    }

}