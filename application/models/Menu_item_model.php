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


    public function getItems() {
        $query = $this->db->get_where($this->itemTable, ['Status!=' => 0]);

        $result = $query->result_array();
        return $result;
    }

}