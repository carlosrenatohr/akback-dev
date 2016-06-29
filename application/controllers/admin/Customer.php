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
    }

    public function index()
    {
        $data['currentuser'] = $this->session->userdata("currentuser");
        $data['page_title'] = "Customer Dashboard";
        $data['storename'] = $this->displaystore();
//        $data['customerFields'] = $this->customerFieldsWithOptions();
        $data['contacts_tab_view'] = "backoffice_admin/customers/contacts_tab";
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
        $customers = $this->customer->getAllCustomers($parentUnique);
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
            $response = [
                'status' => 'error',
                'message' => 'Database error'
            ];
        }
        echo json_encode($response);
    }

    /**
     * @method POST
     * @description Create new customer by custom attributes
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
            $response = [
                'status' => 'error',
                'message' => 'Database error' . $status
            ];
        }
        echo json_encode($response);
    }

    /**
     * @method POST
     * @description Create new customer by custom attributes
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
            $response = [
                'status' => 'error',
                'message' => 'Database error'
            ];
        }
        echo json_encode($response);
    }

    //

    /**
     * @method GET
     * @description Load all customers attributes
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

}