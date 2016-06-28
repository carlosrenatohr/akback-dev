<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 06-17-16
 * Time: 06:35 PM
 */
class Customer_model extends CI_Model
{

    private $customerTable = 'customer';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    public function getAllCustomers($select = null)
    {
        $fields = ['Unique', 'FirstName'];
        $fields_select = array_merge($fields, $this->getAllByField($this->getFieldsForCustomer(), 'Field'));
        $fields_select = array_unique($fields_select);
        //
        $this->db->select($fields_select);
        $query = $this->db->get_where($this->customerTable, ['Status' => 1]);
        return $query->result_array();
    }

    public function getFieldsForCustomer()
    {
//        $this->db->select('config_attribute.*');
//        $this->db->join('config_attribute as ca_parent', 'config_attribute.Unique = ca_parent.ParentUnique');
//        $this->db->where('ParentUnique', 0);
        $this->db->where('Status', 1);
        $this->db->where('Form', 'Customer');
        $this->db->order_by('Tab, Row, Column');
        $query = $this->db->get('config_attribute');
        return $query->result_array();
        // select * from config_attribute where "ParentUnique" = 0 and "Status" = 1 order by "Sort"
    }

    private function getAllByField($array, $field)
    {
        $values = [];
        foreach ($array as $index => $row) {
            $values[] = $row[$field];
        }
        return $values;
    }

    public function postCustomer($request)
    {
        $extraFields = [
            'Status' => 1,
            'Created' => date('Y-m-d H:i:s'),
            'CreatedBy' => $this->session->userdata('userid')
        ];
        $data = array_merge($request, $extraFields);
        $status = $this->db->insert($this->customerTable, $data);
        $insert_id = $this->db->insert_id();
        return $status;
    }

    public function updateCustomer($request, $id)
    {
        $extraFields = [
            'Status' => 1,
            'Updated' => date('Y-m-d H:i:s'),
            'UpdatedBy' => $this->session->userdata('userid')
        ];
        $data = array_merge($request, $extraFields);
        //
        $this->db->where('Unique', $id);
        $status = $this->db->update($this->customerTable, $data);
        return $status;
    }

    public function deleteCustomer($id)
    {
        $extraFields = [
            'Status' => 0,
            'Updated' => date('Y-m-d H:i:s'),
            'UpdatedBy' => $this->session->userdata('userid')
        ];
        $this->db->where('Unique', $id);
        $status = $this->db->update($this->customerTable, $extraFields);
        return $status;
    }

}