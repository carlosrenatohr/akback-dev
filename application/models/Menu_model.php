<?php

class Menu_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    public function getLists()
    {
        $this->db->order_by('Unique', 'DESC');
        $query = $this->db->get('config_menu');
        return $query->result_array();
    }

    public function getCategories()
    {
        $this->db->order_by('Unique', 'DESC');
        $query = $this->db->get('config_menu_category');
        return $query->result_array();
    }

    public function storeMenu($values)
    {
        $query = $this->db->insert('config_menu', $values);
        $insert_id = $this->db->insert_id();
        return $query;
    }

    public function updateMenu($values, $id)
    {
        $this->db->where('Unique', $id);
        $query = $this->db->update('config_menu', $values);
        return $query;
    }

}