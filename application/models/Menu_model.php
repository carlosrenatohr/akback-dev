<?php

class Menu_model extends CI_Model
{

    private $menu_table = 'config_menu';
    private $category_table = 'config_menu_category';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    /**
     * MENU QUERIES
     *
     */
    public function getLists($status = null, $withCategories = null)
    {
        if (!is_null($status) && in_array($status, [1, 2])) {
            $this->db->where('config_menu.Status', $status);
        } else {
            $this->db->where('config_menu.Status !=', 0);
        }
        if (!is_null($withCategories) && $withCategories == 'on') {
            $this->db->select('config_menu.*,
                            config_menu_category.CategoryName,
                            config_menu_category.Unique as CategoryUnique,
                            config_menu_category.Sort as CategorySort,
                            config_menu_category.Row as CategoryRow,
                            config_menu_category.Column as CategoryColumn,
                            config_menu_category.Status as CategoryStatus,

                            ');
            $this->db->join(
                $this->category_table,
                'config_menu_category.MenuUnique = config_menu.Unique'
//                'left'
            );
            $this->db->where('config_menu_category.Status !=', 0);
        }
        $this->db->order_by('config_menu.MenuName', 'ASC');

        $query = $this->db->get($this->menu_table);
        return $query->result_array();
    }

    public function getMenuCateg($status) {
        $query = "SELECT cm.\"MenuName\",
                (SELECT cmc.* FROM config_menu_category cmc
                  WHERE cmc.\"MenuUnique\" = cm.\"Unique\" ORDER BY cmc.\"Unique\"
                  LIMIT 1
                ) AS CATEGORY_DATA

                FROM config_menu cm
                WHERE cm.\"Status\" = {$status}";

        return $this->db->query($query)->result_array();
    }

    public function getCategories()
    {
        $this->db->select('config_menu_category.*, config_menu.MenuName');
        $this->db->from($this->category_table);
        $this->db->join($this->menu_table, 'config_menu.Unique = config_menu_category.MenuUnique', 'left');
        $this->db->where('config_menu_category.Status!=', '0');

        $this->db->order_by('Unique', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function storeMenu($values)
    {
        $query = $this->db->insert($this->menu_table, $values);
        $insert_id = $this->db->insert_id();
        return $query;
    }

    public function updateMenu($values, $id)
    {
        $this->db->where('Unique', $id);
        $query = $this->db->update($this->menu_table, $values);
        return $query;
    }

    public function deleteMenu($id) {
        $deletingValues = [
            'Status' => 0,
            'Updated' => date('Y-m-d H:i:s'),
            'UpdatedBy' => $this->session->userdata('userid')
        ];
        $this->db->where('Unique', $id);
        $query = $this->db->update($this->menu_table, $deletingValues);
        return $query;
    }

    /**
     * MENU CATEGORIES QUERIES
     *
     */
    public function storeCategory($values) {
        $query = $this->db->insert($this->category_table, $values);

        return $query;
    }

    public function updateCategory($values, $id)
    {
        $this->db->where('Unique', $id);
        $query = $this->db->update($this->category_table, $values);
        return $query;
    }

    public function deleteCategory($id) {
        $deletingValues = [
            'Status' => 0,
            'Updated' => date('Y-m-d H:i:s'),
            'UpdatedBy' => $this->session->userdata('userid')
        ];
        $this->db->where('Unique', $id);
        $query = $this->db->update($this->category_table, $deletingValues);
        return $query;
    }

    public function getNameByMenu($id, $table) {
        return $this->db->get_where($table, ['Unique'=> $id])->result_array();
    }

    public function isCategoryPositionBusy($request, $id = null) {
        unset($request['CategoryName']);
        unset($request['Sort']);
        unset($request['Status']);
        if (!is_null($id)) {
            $this->db->where('Unique!=', $id);
        }
        $result = $this->db->get_where($this->category_table, $request)->result_array();

        return count($result);
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