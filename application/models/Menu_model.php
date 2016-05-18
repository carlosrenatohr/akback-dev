<?php

class Menu_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    public function getLists($status = null)
    {
        if (!is_null($status)) {
            $this->db->where('Status', $status);
        }
        $this->db->order_by('Unique', 'DESC');
        $query = $this->db->get('config_menu');
        return $query->result_array();
    }

    public function getCategories()
    {
        $this->db->select('config_menu_category.*, config_menu.MenuName');
        $this->db->from('config_menu_category');
        $this->db->join('config_menu', 'config_menu.Unique = config_menu_category.MenuUnique', 'left');
        $this->db->order_by('Unique', 'DESC');
        $query = $this->db->get();
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

    public function deleteMenu($id) {
        $this->db->where('Unique', $id);
        $query = $this->db->delete('config_menu');
        return $query;
    }

    public function storeCategory($values) {
        $query = $this->db->insert('config_menu_category', $values);

        return $query;
    }

    public function updateCategory($values, $id)
    {
        $this->db->where('Unique', $id);
        $query = $this->db->update('config_menu_category', $values);
        return $query;
    }

    public function deleteCategory($id) {
        $this->db->where('Unique', $id);
        $query = $this->db->delete('config_menu_category');
        return $query;
    }

    public function getNameByMenu($id, $table) {
        return $this->db->get_where($table, ['Unique'=> $id])->result_array();
    }

    public function validateField($field, $value, $table, $whereNot = null)
    {
        $this->db->where($field, $value);
        if (!is_null($whereNot)) {
            $this->db->where($whereNot);
        }
        $query = $this->db->get($table)->result_array();
        return count($query);
    }

}