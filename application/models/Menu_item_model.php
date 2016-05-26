<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 05-19-16
 * Time: 02:59 PM
 */
class Menu_item_model extends CI_Model
{

    private $itemTable = 'item';
    private $menuItemTable = 'config_menu_items';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    public function getItems() {
        $query = $this->db->get_where($this->itemTable, ['Status!=' => 0]);

        $result = $query->result_array();
        return $result;
    }

    public function getItemsByCategoryMenu($id) {
        $this->db->select();
        $this->db->from($this->menuItemTable);
        $this->db->join('item', 'item.Unique = config_menu_items.ItemUnique');
        $this->db->where('MenuCategoryUnique', $id);
        $result = $this->db->get()->result_array();

        return $result;
    }

    public function postItemByMenu($request)
    {
        $where = [
            'MenuCategoryUnique' => $request['MenuCategoryUnique'],
            'ColumnPosition' => $request['ColumnPosition'],
            'RowPosition' => $request['RowPosition']
        ];
        $exists = $this->db->where($where)
            ->get($this->menuItemTable)->result_array();
        if (count($exists)) {
            $request['Updated'] = date('Y-m-d H:i:s');
            $request['UpdatedBy'] = $this->session->userdata('userid');
            $this->db->where($where);
            $return = $this->db->update($this->menuItemTable, $request);
        } else {
            $request['Status'] = 1;
            $request['Created'] = date('Y-m-d H:i:s');
            $request['CreatedBy'] = $this->session->userdata('userid');
            $return = $this->db->insert($this->menuItemTable, $request);
        }
        return $return;
    }


}