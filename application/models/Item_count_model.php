<?php

class Item_count_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getLists()
    {
        return $this->db->get_where('item_count_list', [])->result_array();
    }

}