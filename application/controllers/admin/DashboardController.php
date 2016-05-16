<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 04-25-16
 * Time: 01:50 PM
 */
class DashboardController extends AK_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        $data["page_title"] = "Administrator";
        $data['currentuser'] = $this->session->userdata("currentuser");
        $data['storename'] = $this->displaystore();
        $data['main_content'] = "backoffice_admin/dashboard/index";
        $this->load->view('backoffice_admin/templates/main_layout', $data);
    }
}