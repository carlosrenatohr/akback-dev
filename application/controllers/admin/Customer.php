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
        $data['customerFields'] = $this->customer->getFieldsForCustomer();
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

}