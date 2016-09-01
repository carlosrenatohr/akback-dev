<?php

class Item_model extends CI_Model
{

    public function update($id, $request)
    {
        $this->db->where('Unique', $id);
        return $this->db->update('item', $request);
    }

    public function getItemsData() {
        $this->db->select('*');
        $this->db->from('item');
        $this->db->where(['Status' => 1]);

        return $this->db->get()->result_array();
    }

}