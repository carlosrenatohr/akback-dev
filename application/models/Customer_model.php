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

    public function getAllCustomers($parentUnique = null, $formName = null, $isCount = false, $pageNum = null, $perPage = null)
    {
        $fields = ['Unique', 'ParentUnique'];
        $formName = (!is_null($formName)) ? $formName : 'Customer';
        $fields_select = array_merge($fields, $this->getAllByField($this->getAttributesByForm($formName, 'Tab, Sort, Row, Column'), 'Field'));
        $fields_select = array_unique($fields_select);
        //
        $this->db->select($fields_select);
        $this->db->order_by('Unique', 'DESC');
        $where = ['Status' => 1];
        if (!is_null($parentUnique)) {
            $where['ParentUnique'] = $parentUnique;
        } else {
            $where['ParentUnique'] = null;
        }
        // Paging results
//        $pageNum = 1;
//        $perPage = 5;
        if (!is_null($pageNum) && !is_null($perPage)) {
            $offset = ($pageNum) * $perPage; // -1
            $this->db->limit($perPage, $offset);
        }
        $query = $this->db->get_where($this->customerTable, $where)->result_array();
        if ($isCount) {
            return count($query);
        } else {
            return $query;
        }
    }

    public function getAttributesByForm($form, $orderBy = 'Sort')
    {
//        $this->db->select('config_attribute.*');
//        $this->db->join('config_attribute as ca_parent', 'config_attribute.Unique = ca_parent.ParentUnique');
//        $this->db->where('ParentUnique', 0);
        $this->db->where('Status', 1);
        $this->db->where('Form', $form);
        $this->db->order_by($orderBy);
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

    public function postCustomer($request, $parentUnique = null)
    {
        $extraFields = [
            'Status' => 1,
            'Created' => date('Y-m-d H:i:s'),
            'CreatedBy' => $this->session->userdata('userid')
        ];
        $data = array_merge($request, $extraFields);
        $status = $this->db->insert($this->customerTable, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
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

    /**
     * CUSTOMER CONTACTS
     */
    public function getFieldsForCustomerContacts()
    {
        $this->db->where('Status', 1);
        $this->db->where('Form', 'CustomerContact');
        $this->db->order_by('Tab, Sort, Row, Column');
        $query = $this->db->get('config_attribute');
        return $query->result_array();
    }

    /**
     * CUSTOMER PURCHASES
     */
    public function purchasesBasedByCustomer($customerID = null) {
        $where = (!is_null($customerID)) ?
            'where receipt_header."CustomerUnique" = ' . $customerID . ' order by "ReceiptNumber" desc ': '';
        //
        $query =
        'select receipt_header."Unique", receipt_header."ReceiptNumber",receipt_header."ReceiptDate", customer."FirstName",customer."LastName",customer."Company",
        receipt_details."Item",receipt_details."Description",receipt_details."Quantity",receipt_details."ListPrice",receipt_details."Discount",
        receipt_details."created",receipt_details."created_by",receipt_details."updated",receipt_details."updated_by",receipt_details."location_unique",
        receipt_details."Tax",receipt_details."Total",round(receipt_details."SellPrice",2) as "SellPrice",
        round(receipt_details."SellPrice" * receipt_details."Quantity",2) as "ExtSell", receipt_header."CustomerUnique"
        from receipt_header
        left join customer on receipt_header."CustomerUnique" = customer."Unique"
        left join receipt_details on receipt_header."Unique" = receipt_details."ReceiptHeaderUnique" and receipt_header."Status" = 4' . $where;
        $result = $this->db->query($query)->result_array();
        return  $result;
    }

    public function getLocationName($id) {
        return $this->db->get_where('config_location', ['Unique'=> $id])->result_array();
    }


}