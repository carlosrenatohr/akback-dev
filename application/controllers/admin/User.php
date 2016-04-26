<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 04-25-16
 * Time: 01:45 PM
 */
class User extends AK_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index()
    {
        $data['currentuser'] = $this->session->userdata("currentuser");
        $data['page_title'] = "Users administrator";
        $data['storename'] = $this->displaystore();
        $data['main_content'] = "admin_backoffice/users/index";
        $this->load->view('admin_backoffice/templates/main_layout', $data);
    }

    /**
     * @method GET
     * @description Get all users
     */
    public function load_users()
    {
        echo json_encode($this->user_model->getLists());
    }

}