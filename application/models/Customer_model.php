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

    public function getAllCustomers()
    {
        $query = $this->db->get_where($this->customerTable, []);
        return $query->result_array();
    }

}