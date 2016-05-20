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
    public function load_allmenus($status = null, $withCategories = null)
    {
        $menus = $this->menu->getLists($status, $withCategories);
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
        $table = 'config_menu';

        $validation = $this->beforeAddingMenu($request, $table);
        if (!$validation['sure']){
            $response = [
                'status' => 'error',
                'message' => $validation['message']
            ];
        } else {
            $values['Created'] = date('Y-m-d H:i:s');
            $values['CreatedBy'] = $this->session->userdata('userid');
            $return = $this->menu->storeMenu($request);

            if ($return) {
                $response = [
                    'status' => 'success',
                    'message' => $return
                ];
            }
        }

        echo json_encode($response);
    }

    private function beforeAddingMenu($request, $table) {
        $sure = true;
        $message = [];
        //
        $nameUsed = $this->menu->validateField('MenuName', $request['MenuName'], $table);
        if ($nameUsed) {
            $sure = false;
            $message['MenuName'] = 'Menu name must be unique. Please type a different one.';
        }
        //
        if (!ctype_digit($request['Row'])) {
            $sure = false;
            $message['MenuRow'] = 'Row must be an integer value.';
        }

        if (!ctype_digit($request['Column'])) {
            $sure = false;
            $message['MenuColumn'] = 'Column must be an integer value.';
        }

        return [
            'sure' => $sure,
            'message' => $message
        ];
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
        $table = 'config_menu';

        $validation = $this->beforeUpdatingMenu($id, $request, $table);
        if (!$validation['sure']) {
            $response = [
                'status' => 'error',
                'message' => $validation['message']
            ];
        }
         else {
            $values['Updated'] = date('Y-m-d H:i:s');
            $values['UpdatedBy'] = $this->session->userdata('userid');
            $status = $this->menu->updateMenu($request, $id);

            if ($status) {
                $response = [
                    'status' => 'success',
                    'message' => $status
                ];
            }
        }

        echo json_encode($response);
    }

    private function beforeUpdatingMenu($id, $request, $table) {
        $sure = true;
        $message = [];
        //
        $menu = $this->menu->getNameByMenu($id, $table);
        $whereNot = ['MenuName !=' => $menu[0]['MenuName']];
        $nameUsed = $this->menu->validateField('MenuName', $request['MenuName'], $table, $whereNot);
        if ($nameUsed) {
            $sure = false;
            $message['MenuName'] = 'Menu name must be unique. Please type a different one.';
        }

        return [
            'sure' => $sure,
            'message' => $message
        ];
    }

    /**
     * @method POST
     * @description Add new Category to db
     * @returnType json
     */
    public function add_newCategory() {

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $table = 'config_menu_category';

        $nameUsed = $this->menu->validateField('CategoryName', $request['CategoryName'], $table);

        if ($nameUsed) {
            $response = [
                'status' => 'error',
                'message' => [
                    'CategoryName' => 'Category name must be unique.'
                ]
            ];
        } else {
            $values['Created'] = date('Y-m-d H:i:s');
            $values['CreatedBy'] = $this->session->userdata('userid');
            $return = $this->menu->storeCategory($request);

            if ($return){
                $response = [
                    'status' => 'success',
                    'message' => $return
                ];
            }
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
        $table = 'config_menu_category';

        $menu = $this->menu->getNameByMenu($id, $table);
        $whereNot = ['CategoryName !=' => $menu[0]['CategoryName']];
        $nameUsed = $this->menu->validateField('CategoryName', $request['CategoryName'], $table, $whereNot);

        if ($nameUsed) {
            $response = [
                'status' => 'error',
                'message' => [
                    'CategoryName' => 'Category name must be unique.'
                ]
            ];
        } else {
            $values['Updated'] = date('Y-m-d H:i:s');
            $values['UpdatedBy'] = $this->session->userdata('userid');
            $return = $this->menu->updateCategory($request, $id);

            if ($return){
                $response = [
                    'status' => 'success',
                    'message' => $return
                ];
            }
        }


        echo json_encode($response);
    }

    /**
     * @method POST
     * @param $id Unique from selected Menu
     * @description Delete an existing Menu
     * @returnType json
     */
    public function remove_menu($id) {
        $return = $this->menu->deleteMenu($id);

        if ($return) {
            $response = [
                'status' => 'success',
                'message' => $return
            ];
        } else {
            $response = [
                'status' => 'error',
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
        } else {
            $response = [
                'status' => 'error',
                'message' => $return
            ];
        }

        echo json_encode($response);
    }
}