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

    public function getItems()
    {
        $query = $this->db->get_where($this->itemTable, ['Status!=' => 0]);
        $result = $query->result_array();
        return $result;
    }

    public function getItemByPosition($request)
    {
        $result = $this->db->get_where($this->menuItemTable, $request)->result_array();
        return $result;
    }

    public function getItemsByCategoryMenu($id)
    {
        $this->db->select('item.Description, config_menu_items.*');
        $this->db->from($this->menuItemTable);
        $this->db->join('item', 'item.Unique = config_menu_items.ItemUnique');
        $this->db->where('config_menu_items.MenuCategoryUnique', $id);
//        $this->db->where('config_menu_items.Status!=', 0);
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function postItemByMenu($request)
    {
        $where = [
            'MenuCategoryUnique' => $request['MenuCategoryUnique'],
            'Column' => $request['Column'],
            'Row' => $request['Row']
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

    public function deleteMenuItem($request)
    {
        $this->db->where($request);
//        $return = $this->db->update(
//            $this->menuItemTable,
//            [
//                'Status' => 0,
//                'Updated' => date('Y-m-d H:i:s'),
//                'UpdatedBy' => $this->session->userdata('userid')
//            ]
//        );
        $return = $this->db->delete($this->menuItemTable);

        return $return;
    }

    public function setNewPosition($category, $element, $target)
    {
        //
        $this->db->trans_start();
        $exists = $this->db->where('MenuCategoryUnique', $category)
            ->where($target)
            ->get($this->menuItemTable)->result_array();
        $this->db->trans_complete();
        //
        $targetValues = array_merge(
            [
                'Updated' => date('Y-m-d H:i:s'),
                'UpdatedBy' => $this->session->userdata('userid')
            ],
            $target
        );
        $elementValues = array_merge(
            [
                'Updated' => date('Y-m-d H:i:s'),
                'UpdatedBy' => $this->session->userdata('userid')
            ],
            $element
        );
        //
        $this->db->trans_start();
        $query = $this->db->where('MenuCategoryUnique', $category)
            ->where($element)
            ->update($this->menuItemTable, $targetValues);
        $this->db->trans_complete();
        /**
         * Target
         */
        if (count($exists)) {
            $target_id = $exists[0]['Unique'];
            $this->db->trans_start();
            $this->db->where('Unique', $target_id)
                ->update($this->menuItemTable, $elementValues);
            $this->db->trans_complete();
        }
        return count($exists);
    }

}