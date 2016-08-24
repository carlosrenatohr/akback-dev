<?php

class Config_location_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    /**
     * @param $setting
     * @param $value
     * @param string $field LocationUnique or StationUnique
     * @return mixed
     */
    public function getConfigSetting($setting, $value, $field = 'LocationUnique')
    {
        $query = $this->db->get_where(
            'config_location_settings',
            [$field => $value, 'Setting' => $setting, 'Status' => 1]
        )->result_array();

        $this->session->set_userdata(['admin_' . $setting => $query[0]['Value']]);
        return $query[0]['Value'];
    }

}