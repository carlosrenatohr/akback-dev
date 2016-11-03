<?php

class Item_brand_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getLists($id = null)
    {
        $this->db->select('
            item_brand."Name",item_brand."Note",
            cuc."UserName" as "CreatedByName", date_trunc(\'minutes\',item_brand."Created" ::timestamp) as "Created",
            cuu."UserName" as "UpdatedByName", date_trunc(\'minutes\',item_brand."Updated" ::timestamp) as "Updated"
        ', false);
        $this->db->from('item_brand');
        $this->db->where(['item_brand.Status' => 1]);
        $this->db->join('config_user cuc', 'cuc.Unique = item_brand.CreatedBy', 'left');
        $this->db->join('config_user cuu', 'cuu.Unique = item_brand.UpdatedBy', 'left');
        return $this->db->get()->result_array();
    }

    public function postBrand($request) {
        $extra_fields = [
            'Status' => 1,
            'Created' => date('Y-m-d H:i:s'),
            'Createdby' => $this->session->userdata('userid')
        ];
        $data = array_merge($request, $extra_fields);
        $status = $this->db->insert('item_brand', $data);
        return $this->db->insert_id();
    }

    public function updateBrand($id, $request) {
        $extra_fields = [
            'Updated' => date('Y-m-d H:i:s'),
            'UpdatedBy' => $this->session->userdata('userid')
        ];
        $data = array_merge($request, $extra_fields);
        $this->db->where('Unique', $id);
        $status = $this->db->update('item_brand', $data);
        return $status;
    }

    public function deleteBrand($id) {
        $status = true;
        if (!is_null($id) && $id != 'null') {
            $this->db->where('Unique', $id);
            $status = $this->db->delete('item_brand');
        }
        return $status;
    }

}