<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 04-25-16
 * Time: 05:49 PM
 */
class AK_Controller extends \CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // It can be auto-loaded
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->model('backoffice_model');
        $this->_is_logged_in();
    }

    /**
     * Helpers..
     */
    function displaystore()
    {
        $storeid = $this->session->userdata("storeunique");
        $storename = $this->backoffice_model->stores($storeid);
        return $storename;
    }

    private function _is_logged_in()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('backoffice/dashboard');
        }
    }

    public function dbErrorMsg()
    {
        return $response = [
            'status' => 'error',
            'message' => 'Database error'
        ];
    }

}