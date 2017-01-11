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
        $this->load->model('Config_location_model');
        $this->load->model('Customer_model', 'customer');
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

    public function getLocations() {
        return $this->customer->getLocations();
    }

//    public function isCustomerCheckedInEnabled($setting, $value, $field) {
    public function getSettingLocation($setting, $value, $field = 'stationunique') {
        $this->Config_location_model->getConfigSetting($setting, $value, $field);
    }

    public function getPicturePath() {
        $this->getSettingLocation('ItemPictureLocation', $this->session->userdata("station_number"));
        $picturesPath = base_url() . $this->session->userdata('admin_ItemPictureLocation');
        $sep = DIRECTORY_SEPARATOR;
        return str_replace(['/', "\\"], [$sep, $sep], $picturesPath);
    }

    public function dbErrorMsg($type = null)
    {
        if(is_null($type))
            $msg = 'Database error';
        elseif ($type == 0)
            $msg = 'Invalid request';
        else
            $msg = 'Unexpected error.';

        return $response = [
            'status' => 'error',
            'message' => $msg
        ];
    }

}