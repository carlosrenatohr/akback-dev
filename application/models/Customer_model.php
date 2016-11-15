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

    public function getAllCustomers($parentUnique = null, $formName = null, $isCount = false, $pageNum = null, $perPage = null, $filterQuery = null, $sortData = null)
    {
        $fields = ['customer.Unique', 'ParentUnique', 'LastVisit', 'VisitDays', 'AccountStatus'
//                    'customer_visit.Unique as VisitUnique', 'customer_visit.FirstName as VisitFirstName'
                ];
        $formName = (!is_null($formName)) ? $formName : 'Customer';
        $fields_select = array_merge($fields, $this->getAllByField($this->getAttributesByForm($formName, 'Tab, Sort, Row, Column'), 'Field', 'customer'));
        $fields_select = array_unique($fields_select);
        //
        $this->db->select($fields_select);
        $this->db->from($this->customerTable);
//        $this->db->join('customer_visit', 'customer_visit.CustomerUnique = customer.Unique');


        // Filtering
        if (!empty($filterQuery)) {
            $this->db->where($filterQuery, NULL, false);
        }
        $where = ['customer.Status' => 1];
        if (!is_null($parentUnique)) {
            $where['ParentUnique'] = $parentUnique;
            $this->db->where($where);
        } else {
            $where['ParentUnique'] = null;
            $this->db->where($where);
            //Query to Search In Contacts
            if (!empty($filterQuery))
                $this->db->or_where("customer.\"ParentUnique\" IS NULL AND \"customer\".\"Unique\" IN (select \"ParentUnique\" from customer WHERE " . $filterQuery . ")" , NULL, false);
        }

        // Paging
        if (!is_null($pageNum) && !is_null($perPage)) {
            $offset = ($pageNum) * $perPage; // -1
            $this->db->limit($perPage, $offset);
        }
        // Sorting
        if (!is_null($sortData))
        {
            if ($sortData['sortorder'] == "desc")
                $this->db->order_by("customer.\"".$sortData['sortdatafield'] . "\"", 'DESC');
            else if ($sortData['sortorder'] == "asc")
                $this->db->order_by("customer.\"".$sortData['sortdatafield'] . "\"", 'ASC');
             else
                $this->db->order_by("customer.\"Unique\"", 'DESC');
        } else
            $this->db->order_by("customer.\"Unique\"", 'DESC');

        $query = $this->db->get()->result_array();
//        var_dump($this->db->last_query());exit;

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

    private function getAllByField($array, $field, $table = null)
    {
        $values = [];
        $tablename = (!is_null($table)) ? "\"" . $table . "\"." : '';
        foreach ($array as $index => $row) {
            if (!empty($row[$field]))
                $values[] = $tablename . $row[$field];
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
        receipt_details."Tax",receipt_details."Total", receipt_details."SellPrice", round(receipt_details."SellPrice",2) as "_SellPrice",
        round(receipt_details."SellPrice" * receipt_details."Quantity",2) as "ExtSell", receipt_header."CustomerUnique"
        from receipt_header
        left join customer on receipt_header."CustomerUnique" = customer."Unique"
        left join receipt_details on receipt_header."Unique" = receipt_details."ReceiptHeaderUnique" and receipt_header."Status" = 4' . $where;
        $result = $this->db->query($query)->result_array();

        return  $result;
    }

    public function receiptsBasedByCustomer($customerID = null) {
        $whereAttached = (!is_null($customerID))
            ? ' WHERE RH."CustomerUnique" = '. $customerID.  ' '
            : '';
        $query = '
            select RH."Unique" as "ReceiptID", RH."ReceiptNumber" as "Receipt", 
            round(RH."SubTotal",2) as "SubTotal",round(RH."Tip",2) as "Tip", round(RH."Tax",2) as "Tax", round( RH."Total",2) as "Total",
            RH."CustomerUnique" as "CustomerID", coalesce(C."FirstName", \'\') || \' \' || coalesce(C."LastName", \'\') as "Customer", 
            RD."Description", RD."ListPrice", RD."SellPrice",
            CL."LocationName" as "Location", RH."Status" as "Status",      
            case when RH."Status" = 4 then \'Complete\' when RH."Status" = 5 then \'Hold\' when RH."Status" = 10 then \'Cancel\' 
            when RH."Status" = 1 then \'New\' else \'Other\' end as "StatusName",
            to_char(date_trunc(\'minutes\', RH."ReceiptDate"::timestamp), \'MM/DD/YYYY HH:MI AM\') as "ReceiptDate",
            to_char(date_trunc(\'minutes\', RH."Created"::timestamp), \'MM/DD/YYYY HH:MI AM\') as "Created",
            CU1."UserName" as "CreatedBy",
            to_char(date_trunc(\'minutes\', RH."Updated"::timestamp), \'MM/DD/YYYY HH:MI AM\') as "Updated",
            CU2."UserName" as "UpdatedBy"
            from receipt_header RH 
            join customer C on RH."CustomerUnique" = C."Unique"
            left join config_user CU1 on RH."CreatedBy" = CU1."Unique"
            left join config_user CU2 on RH."CreatedBy" = CU2."Unique"
            left join config_location CL on RH."LocationUnique" = CL."Unique" 
            left join receipt_details RD on RH."Unique" = RD."ReceiptHeaderUnique" and RH."Status" = 4 '
            . $whereAttached .
            'order by RH."Unique" DESC '
        ;

        $result = $this->db->query($query)->result_array();
        return $result;
    }

    public function receiptDetailsByHeader($receipt_id) {
        $sql = "select \"ReceiptHeaderUnique\" as \"ReceiptID\", \"Item\",\"Description\",\"Quantity\" as \"Quantity\",
		round(\"ListPrice\",2) as \"ListPrice\",
		round(\"SellPrice\",2) as \"SellPrice\" ,round(\"Tax\",2) as \"Tax\",round(\"Total\",2) as \"Total\",
		case when (RD.\"ReturnUnique\" > 0 or null) then 'Removed' else 'Complete' end as \"Status\",
		date_trunc('min', RD.\"created\"::timestamp) as \"Created\",CU1.\"UserName\" as \"CreatedBy\",
		date_trunc('min', RD.\"updated\"::timestamp) as \"Updated\",CU2.\"UserName\" as \"UpdatedBy\"
		from receipt_details RD
		left join config_user CU1 on RD.\"created_by\" = CU1.\"Unique\"
		left join config_user CU2 on RD.\"updated_by\" = CU2.\"Unique\"
		Where \"ReceiptHeaderUnique\" = '".$receipt_id."' and RD.\"Status\" in (1,10) order by \"LineNo\" asc";

        return $this->db->query($sql)->result_array();
    }

    /**
     * CUSTOMER CARD
     */
    public function cardsByCustomer($customerID = null) {
        $this->db->select(
            'customer_card.Unique, customer_card.Card4, customer_card.CardType,
             customer_card.Created, customer_card.CreatedBy, createdUser.UserName as CreatedByName'
        );
        $this->db->from('customer_card');
        $this->db->join('config_user createdUser', 'createdUser.Unique = customer_card.CreatedBy', 'left');
        $this->db->where('customer_card.CustomerUnique', $customerID);
        $this->db->where('customer_card.Status', 1);
        $result = $this->db->get()->result_array();

        return $result;
    }

    public function deleteCustomerCard($id) {
        $this->db->where('Unique', $id);
//        return $this->db->delete('customer_card');
        return $this->db->update('customer_card', ['Status' => 0]);
    }

    public function getLocations() {
        $this->db->select('Unique, Name, LocationName');
        $this->db->where('Status', 1);
        $this->db->order_by('LocationName', 'ASC');
        return $this->db->get('config_location')->result_array();
    }

    public function getLocationName($id) {
        return $this->db->get_where('config_location', ['Unique'=> $id])->result_array();
    }

    /**
     * CHECK IN - CHECK OUT
     */
    public function getCustomersWithVisits($status, $location, $isCount = false, $filterQuery = null, $pageNum = null, $perPage = null, $sortData = null) {

        $this->db->select('customer.*, customer_visit.Status as StatusCheckIn, LocationUnique, customer_visit.LocationUnique,
                        customer_visit.Unique as VisitUnique, customer_visit.CheckInDate, customer_visit.Note,
                        customer_visit.CheckInBy, customer_visit.CheckOutDate, customer_visit.CheckOutBy,
                        customer_visit.Quantity, customer_visit.LastName as lname, customer_visit.FirstName as fname,
                        checkInUser.UserName as CheckInUser, checkOutUser.UserName as CheckOutUser
                        ');
        $this->db->from('customer_visit');
        $this->db->join('customer', 'customer.Unique = customer_visit.CustomerUnique', 'left');
        $this->db->join('config_user checkInUser', 'checkInUser.Unique = customer_visit.CheckInBy', 'left');
        $this->db->join('config_user checkOutUser', 'checkOutUser.Unique = customer_visit.CheckOutBy', 'left');
        $this->db->where('customer_visit.Status', $status);
        if ($location > 0) {
            $this->db->where('LocationUnique', $location);
        }
        // Filtering
        if (!empty($filterQuery)) {
            $this->db->where($filterQuery, NULL, false);
        }
        // Paging
        if (!is_null($pageNum) && !is_null($perPage)) {
            $offset = ($pageNum) * $perPage; // -1
            $this->db->limit($perPage, $offset);
        }
        // Sorting
        if (!is_null($sortData))
        {
            if ($sortData['sortorder'] == "desc")
                $this->db->order_by($sortData['sortdatafield'], 'DESC');
            else if ($sortData['sortorder'] == "asc")
                $this->db->order_by($sortData['sortdatafield'], 'ASC');
            else
                $this->db->order_by('Unique', 'DESC');
        } else
            $this->db->order_by('Unique', 'DESC');

        $result = $this->db->get()->result_array();

        if ($isCount)
            return count($result);
        else
            return $result;
    }

    public function setCheckIn($request) {
        $this->db->trans_start();
        $this->db->where('Unique', $request['CustomerUnique']);
        $this->db->update('customer', ['LastVisit' => date('Y-m-d H:i:s')]);
        $this->db->trans_complete();

        $extraFields = [
            'Status' => 1,
            'CheckInDate' => date('Y-m-d H:i:s'),
            'CheckInBy' => $this->session->userdata('userid'),
            'Created' => date('Y-m-d H:i:s'),
            'CreatedBy' => $this->session->userdata('userid')
        ];
        $data = array_merge($request, $extraFields);
        $status = $this->db->insert('customer_visit', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function updateCustomerVisit($id, $request) {
        $extraFields = [
            'Updated' => date('Y-m-d H:i:s'),
            'UpdatedBy' => $this->session->userdata('userid')
        ];
        if (isset($request['Status']) && $request['Status'] == 2) {
            $extraFields['CheckOutDate'] = date('Y-m-d H:i:s');
            $extraFields['CheckOutBy'] = $this->session->userdata('userid');
        }
        if (isset($request['Quantity'])) {
            $request['Quantity'] = (float)$request['Quantity'];
        }
        $data = array_merge($request, $extraFields);

        $this->db->where('Unique', $id);
        $status = $this->db->update('customer_visit', $data);
        return $status;
    }

    public function isCustomerCheckedOut($id) {
        $query = $this->db->get_where('customer_visit', ['CustomerUnique' => $id, 'Status' => 2])->result_array();
        return count($query);
    }


}