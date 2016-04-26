<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 04-25-16
 * Time: 01:50 PM
 */
class DashboardController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        $data["page_title"] = "Administrator";
        $data['main_content'] = "admin_backoffice/dashboard/index";
        $this->load->view('admin_backoffice/templates/main_layout', $data);
    }
}