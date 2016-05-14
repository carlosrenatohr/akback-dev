<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 05-12-16
 * Time: 11:57 PM
 */
class Category extends AK_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_model', 'menu');
    }

    public function index()
    {
        $data['currentuser'] = $this->session->userdata("currentuser");
        $data['page_title'] = "Menu Categories";
        $data['storename'] = $this->displaystore();
        $this->load->view("admin_backoffice/menu_categories/index", $data);
    }

    public function load_allmenus()
    {
        echo json_encode($this->menu->getLists());
    }

    public function load_allcategories()
    {
        echo json_encode($this->menu->getCategories());
    }

    public function add_newMenu() {

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $return = $this->menu->storeMenu($request);

        if ($return){
            $response = [
                'status' => 'success',
                'message' => $return
            ];
        }

        echo json_encode($response);
    }

    public function edit_newMenu($id) {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $return = $this->menu->updateMenu($request, $id);

        if ($return){
            $response = [
                'status' => 'success',
                'message' => $return
            ];
        }

        echo json_encode($response);
    }
}