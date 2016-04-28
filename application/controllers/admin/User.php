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
     * returnType json
     */
    public function load_users()
    {
        echo json_encode($this->user_model->getLists());
    }

    /**
     * @method GET
     * @description Get all positions to show
     * returnType json
     */
    public function load_allPositions()
    {
        echo json_encode($this->user_model->getPositions());
    }

    /**
     * @method POST
     * @description Save a new user
     * @returnType json
     */
    public function store_user()
    {
        $values = [];
        foreach ($_POST as $index => $element) {
            $pos = strpos($index, '_');
            if ($pos !== false) {
                $temp_index = ucfirst(substr($index, $pos + 1));
                if ($temp_index == 'Password' || $temp_index == 'Code') {
                    $values[$temp_index] = md5($element);
                }
            } else {
                $values[$index] = $element;
            }
        }
        var_dump($this->user_model->store($values));
    }

}