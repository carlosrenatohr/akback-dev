<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 05-12-16
 * Time: 11:57 PM
 */
class MenuCategory extends AK_Controller
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
        $this->load->view("backoffice_admin/menu_categories/index", $data);
    }

    /**
     * @method POST
     * @param null $status Filter by status
     * @description Load all registered menus
     * @returnType json
     */
    public function load_allmenus($status = null)
    {
        $menus = $this->menu->getLists($status);
        $formatted_menus = [];
        foreach($menus as $menu) {
            $menu['StatusName'] = ($menu['Status'] == 1 ? 'Enabled' : 'Disabled');
            $formatted_menus[] = $menu;
        }
        echo json_encode($formatted_menus);
    }

    /**
     * @method POST
     * @description Load all registered categories
     * @returnType json
     */
    public function load_allcategories()
    {
        $categories = $this->menu->getCategories();
        $formatted_categories = [];
        foreach($categories as $category) {
            $category['StatusName'] = ($category['Status'] == 1) ? 'Enabled' : 'Disabled';
//            $category['statusName'] = ($category['Status'] == 1) ? 'Enabled' : 'Disabled';
            $formatted_categories[] = $category;
        }
        echo json_encode($formatted_categories);
    }

    /**
     * @method POST
     * @description Add new Menu to db
     * @returnType json
     */
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

    /**
     * @method POST
     * @param $id Unique from selected menu
     * @description update an existing Menu to db
     * @returnType json
     */
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

    /**
     * @method POST
     * @description Add new Category to db
     * @returnType json
     */
    public function add_newCategory() {

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $return = $this->menu->storeCategory($request);

        if ($return){
            $response = [
                'status' => 'success',
                'message' => $return
            ];
        }

        echo json_encode($response);
    }

    /**
     * @method POST
     * @param $id Unique from selected Category
     * @description update an existing Category to db
     * @returnType json
     */
    public function update_Category($id) {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $return = $this->menu->updateCategory($request, $id);

        if ($return){
            $response = [
                'status' => 'success',
                'message' => $return
            ];
        }

        echo json_encode($response);
    }

    /**
     * @method POST
     * @param $id Unique from selected Category
     * @description Delete an existing category
     * @returnType json
     */
    public function remove_category($id) {
        $return = $this->menu->deleteCategory($id);

        if ($return) {
            $response = [
                'status' => 'success',
                'message' => $return
            ];
        }

        echo json_encode($response);
    }
}