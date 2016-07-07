<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 06-17-16
 * Time: 06:34 PM
 */
class Customer extends AK_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model', 'customer');
        $this->load->model('Note_model', 'notes');
    }

    public function index()
    {
        $data['currentuser'] = $this->session->userdata("currentuser");
        $data['page_title'] = "Customer Dashboard";
        $data['storename'] = $this->displaystore();
        $data['contacts_tab_view'] = "backoffice_admin/customers/contacts_tab";
        $data['notes_tab_view'] = "backoffice_admin/customers/notes_tab";
        $data['purchases_tab_view'] = "backoffice_admin/customers/purchases_tab";
        $data['main_content'] = "backoffice_admin/customers/index";
        $this->load->view('backoffice_admin/templates/main_layout', $data);
    }

    /**
     * @method GET
     * @description Load all customers
     * @returnType json
     */
    public function load_allCustomers()
    {
        $parentUnique = (isset($_GET['parent'])) ? $_GET['parent'] : null;
        $formName = (isset($_GET['form'])) ? $_GET['form'] : null;
        $customers = $this->customer->getAllCustomers($parentUnique, $formName);
        echo json_encode($customers);
    }

    /**
     * @helper
     * @description group fields with their sub-fields
     * @returnType array
     */
    private function customerFieldsWithOptions()
    {
        $new_fields = [];
        $fields = $this->customer->getAttributesByForm('Customer', 'Tab, Sort, Row, Column');
        foreach ($fields as $field) {
            if ($field['ParentUnique'] == 0) {
                $field['classForm'] = strtolower($field['Form']);
                $new_fields[$field['Unique']] = $field;
            } else {
                $new_fields[$field['ParentUnique']]['options'][] = $field;
            }
        }
        return $new_fields;
    }

    /**
     * @method GET
     * @description Load all customers attributes
     * @returnType json
     */
    public function load_customerAttributes()
    {
        echo json_encode($this->customerFieldsWithOptions());
    }

    /**
     * @method GET
     * @description Load customers attributes to show on grid
     * @returnType json
     */
    public function load_customerGridAttributes()
    {
        echo json_encode($this->customer->getAttributesByForm('CustomerGrid', 'Sort ASC'));
    }

    /**
     * @method POST
     * @description Create new customer by custom attributes
     * @returnType json
     */
    public function createCustomer()
    {
        $request = $_POST;
        $newId = $this->customer->postCustomer($request);
        if ($newId) {
            $response = [
                'status' => 'success',
                'message' => 'Customer success!',
                'new_id' => $newId
            ];
        } else {
            $response = $this->dbErrorMsg();
        }
        echo json_encode($response);
    }

    /**
     * @method POST
     * @description Update customer
     * @returnType json
     */
    public function updateCustomer($id)
    {
        $request = $_POST;
        $status = $this->customer->updateCustomer($request, $id);
        if ($status) {
            $response = [
                'status' => 'success',
                'message' => 'Customer update: ' . $status
            ];
        } else {
            $response = $this->dbErrorMsg();
        }
        echo json_encode($response);
    }

    /**
     * @method POST
     * @description Delete customer
     * @returnType json
     */
    public function deleteCustomer($id)
    {
        $status = $this->customer->deleteCustomer($id);
        if ($status) {
            $response = [
                'status' => 'success',
                'message' => 'Customer deleted!'
            ];
        } else {
            $response = $this->dbErrorMsg();
        }
        echo json_encode($response);
    }

    //
    /**
     * @method GET
     * @description Load all customers Contacts attributes
     * @returnType json
     */
    public function load_customerContactsAttributes()
    {
        echo json_encode($this->customerContactsAttrsWithOptions());
    }

    /**
     * @helper
     * @description group fields with their sub-fields
     * @returnType array
     */
    private function customerContactsAttrsWithOptions()
    {
        $new_fields = [];
        $fields = $this->customer->getAttributesByForm('CustomerContact', 'Sort');
        foreach ($fields as $field) {
            if ($field['ParentUnique'] == 0) {
                $new_fields[$field['Unique']] = $field;
            } else {
                $new_fields[$field['ParentUnique']]['options'][] = $field;
            }
        }
        return $new_fields;
    }

    // --- CUSTOMER NOTES
    /**
     * @method GET
     * @description Load all notes by customer
     * @returnType json
     */
    public function load_customerNotes($customerID = null)
    {
        $notes = $this->notes->getNotesByType('customer', $customerID);

        echo json_encode($notes);
    }

    /**
     * @method POST
     * @description Create Customer note
     * @returnType json
     */
    public function createCustomerNote()
    {
        $request = $_POST;
        $newId = $this->notes->postNote($request);
        if ($newId) {
            $response = [
                'status' => 'success',
                'message' => 'Customer Note success!',
                'new_id' => $newId
            ];
        } else {
            $response = $this->dbErrorMsg();
        }
        echo json_encode($response);
    }

    /**
     * @method POST
     * @description Update Customer note
     * @returnType json
     */
    public function updateCustomerNote($id)
    {
        $request = $_POST;
        $newId = $this->notes->updateNote($id, $request);
        if ($newId) {
            $response = [
                'status' => 'success',
                'message' => 'Customer Note success!',
                'new_id' => $newId
            ];
        } else {
            $response = $this->dbErrorMsg();
        }
        echo json_encode($response);
    }

    /**
     * @method POST
     * @description Delete customer note
     * @returnType json
     */
    public function deleteCustomerNote($id)
    {
        $status = $this->notes->deleteNote($id);
        if ($status) {
            $response = [
                'status' => 'success',
                'message' => 'Customer Note deleted!'
            ];
        } else {
            $response = $this->dbErrorMsg();
        }
        echo json_encode($response);
    }

    /**
     * @helper
     * @description in error case
     * @returnType array
     */
    private function dbErrorMsg()
    {
        return $response = [
            'status' => 'error',
            'message' => 'Database error'
        ];
    }

    // --- CUSTOMER PURCHASES
    /**
     * @method GET
     * @description Load all customers purchases
     * @returnType json
     */
    public function load_purchasesCustomer($customerID = null)
    {
        $formatPurchases = [];
        $purchases = $this->customer->purchasesBasedByCustomer($customerID);
        foreach($purchases as $purchase) {
            $purchase['ReceiptDate_'] = date('d/m/Y H:i:s', strtotime($purchase['ReceiptDate'])); //d-m-Y H:i:sA
            $purchase['Quantity'] = number_format($purchase['Quantity'], $this->session->userdata('DecimalsQuantity'));
            $formatPurchases[] = $purchase;
        }
        echo json_encode($formatPurchases);
    }

}