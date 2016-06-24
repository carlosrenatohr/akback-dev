<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 06-17-16
 * Time: 06:34 PM
 */
class Customer extends AK_Controller
{
    private $customerFields;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model', 'customer');
//        $this->customerFields = $this->customer->getFieldsForCustomer();
    }

    public function index()
    {
        $data['currentuser'] = $this->session->userdata("currentuser");
        $data['page_title'] = "Customer Dashboard";
        $data['storename'] = $this->displaystore();
        $data['customerFields'] = $this->customerFieldsWithOptions();
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
        $customers = $this->customer->getAllCustomers();
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
        $fields = $this->customer->getFieldsForCustomer();
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
        $status = $this->customer->postCustomer($request);
        if ($status) {
            $response = [
                'status' => 'success',
                'message' => 'Customer success: ' . $status
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

}