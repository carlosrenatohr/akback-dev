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

    public function getAllCustomers($select = null)
    {
        $fields = ['Unique', 'FirstName'];
        $fields_select = array_merge($fields, $this->getAllByField($this->getFieldsForCustomer(), 'Field'));
        $fields_select = array_unique($fields_select);
        //
        $this->db->select($fields_select);
        $query = $this->db->get_where($this->customerTable, []);
        return $query->result_array();
    }

    public function getFieldsForCustomer()
    {
//        $this->db->select('config_attribute.*');
//        $this->db->join('config_attribute as ca_parent', 'config_attribute.Unique = ca_parent.ParentUnique');
//        $this->db->where('ParentUnique', 0);
        $this->db->where('Status', 1);
        $this->db->order_by('ParentUnique, Sort');
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

}