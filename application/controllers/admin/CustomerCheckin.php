<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 07-26-16
 * Time: 05:41 PM
 */
class CustomerCheckin extends AK_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model', 'customer');
    }

    public function load_checkInCustomersByLocation($status, $location) {
        echo json_encode($this->customer->getCustomersWithVisits($status, $location));
    }

    public function setCustomerAsCheckin() {
        $request = $_POST;
        $newId = $this->customer->setCheckin($request);
        if ($newId) {
            $response = [
                'status' => 'success',
                'message' => 'Checked in successfully!',
                'new_id' => $newId
            ];
        } else {
            $response = $this->dbErrorMsg();
        }
        echo json_encode($response);
    }

}