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
        // Data to send
        $data['currentuser'] = $this->session->userdata("currentuser");
        $data['station'] = $this->session->userdata("station_number");
        $data['page_title'] = "Menu Categories";
        $data['storename'] = $this->displaystore();
        $data['decimalsPrice'] = (int)$this->session->userdata("DecimalsPrice");
        $data['decimalsQuantity'] = (int)$this->session->userdata("DecimalsQuantity");
        // Partials Views
        $menu_path = 'backoffice_admin/menu_categories/';
        $data['menu_tab_view'] = $menu_path . "menu_tab";
        $data['cat_data_subview'] = $menu_path . "categories_data_subtab";
        $data['cat_style_subview'] = $menu_path . "categories_styles_subtab";
        $data['category_tab_view'] = $menu_path . "categories_tab";
        $data['items_tab_view'] = $menu_path . "items_tab";
        $data['categoryName_form'] = $menu_path . "categoryname_form";
        $data['items_menuitem_subtab_view'] = $menu_path . "items_menuitem_subtab";
        $data['items_price_subtab_view'] = $menu_path . "items_price_subtab";
        $data['items_questions_subtab_view'] = $menu_path . "items_question_subtab";
        $data['items_printers_subtab_view'] = $menu_path . "items_printer_subtab";
        $data['items_extra_subtab_view'] = $menu_path . "items_extra_subtab";
        $data['items_layout_subtab_view'] = $menu_path . "items_layout_subtab";
        $data['items_picture_subtab_view'] = $menu_path . "items_picture_subtab";
        $data['questions_tab_view'] = $menu_path . "questions_tab";
        $data['printers_tab_view'] = $menu_path . "printer_tab";
        // Main page
        $data['main_content'] = $menu_path . "index";
        $this->load->view('backoffice_admin/templates/main_layout', $data);
    }

    /**
     * @method GET
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
     * @method GET
     * @description Load all registered categories
     * @returnType json
     */
    public function load_allcategories()
    {
        $categories = $this->menu->getCategories();
        $formatted_categories = [];
        foreach($categories as $category) {
            $category['StatusName'] = ($category['Status'] == 1) ? 'Enabled' : 'Disabled';
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

//        $postdata = file_get_contents("php://input");
//        $request = json_decode($postdata, true);
        if (!is_null($_POST) && !empty($_POST)) {
            $request = $_POST;
            $table = 'config_menu';
            $validation = $this->beforeAddingMenu($request, $table);
            if (!$validation['sure']) {
                $response = [
                    'status' => 'error',
                    'message' => $validation['message']
                ];
            } else {
                $request['Created'] = date('Y-m-d H:i:s');
                $request['CreatedBy'] = $this->session->userdata('userid');
                $return = $this->menu->storeMenu($request);
                if ($return) {
                    $response = [
                        'status' => 'success',
                        'message' => $return
                    ];
                }
            }
        } else
            $response = $this->dbErrorMsg(0);

        echo json_encode($response);
    }

    /**
     * @description Validation before creating menu
     * @param $request
     * @param $table
     * @return array
     */
    private function beforeAddingMenu($request, $table) {
        $sure = true;
        $message = [];
        //
        $nameUsed = $this->menu->validateField('MenuName', $request['MenuName'], $table);
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
     * @param $id Unique from selected menu
     * @description update an existing Menu to db
     * @returnType json
     */
    public function edit_newMenu($id) {
//        $postdata = file_get_contents("php://input");
//        $request = json_decode($postdata, true);
        if (!is_null($_POST) && !empty($_POST)) {
            $request = $_POST;
            $table = 'config_menu';

            $validation = $this->beforeUpdatingMenu($id, $request, $table);
            if (!$validation['sure']) {
                $response = [
                    'status' => 'error',
                    'message' => $validation['message']
                ];
            }
            else {
                $request['Updated'] = date('Y-m-d H:i:s');
                $request['UpdatedBy'] = $this->session->userdata('userid');
                $status = $this->menu->updateMenu($request, $id);

                if ($status) {
                    $response = [
                        'status' => 'success',
                        'message' => $status
                    ];
                }
            }
        } else
            $response = $this->dbErrorMsg(0);

        echo json_encode($response);
    }

    /**
     * @description Validation before updating Menu
     * @param $id
     * @param $request
     * @param $table
     * @return array
     */
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

    public function get_oneCategory($id) {
        $status = $this->menu->getCategory($id);

        if ($status) {
            $response = [
                'status' => 'success',
                'message' => 'A category was found',
                'row' => $status
            ];
        } else {
            $response = $this->dbErrorMsg();
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
        $table = 'config_menu_category';

        $validation = $this->beforeAddingCategory($request, $table);

        if (!$validation['sure']){
            $response = [
                'status' => 'error',
                'message' => $validation['message']
            ];
        } else {
            $request['Created'] = date('Y-m-d H:i:s');
            $request['CreatedBy'] = $this->session->userdata('userid');
            $return = $this->menu->storeCategory($request);

            if ($return) {
                $response = [
                    'status' => 'success',
                    'message' => $return
                ];
            }
        }

        echo json_encode($response);
    }

    /**
     * @description Validation before creating
     * @param $request
     * @param $table
     * @return array
     */
    private function beforeAddingCategory($request, $table) {
        $sure = true;
        $message = [];
        //
        $nameUsed = $this->menu->validateField('CategoryName', $request['CategoryName'], $table);        if ($nameUsed) {
            $sure = false;
            $message['CategoryName'] = 'Category name must be unique. Please type a different one.';
        }
        //
//        if (!ctype_digit($request['Row'])) {
//            $sure = false;
//            $message['CategoryRow'] = 'Row must be an integer value.';
//        }
//
//        if (!ctype_digit($request['Column'])) {
//            $sure = false;
//            $message['CategoryColumn'] = 'Column must be an integer value.';
//        }
        $gridPosition = $this->menu->isCategoryPositionBusy($request);
        if ($gridPosition) {
            $sure = false;
            $message['CategoryColumn'] = 'Row and Column cannot be the same as another Category';
            $message['CategoryRow'] = 'Row and Column cannot be the same as another Category';
        };

        return [
            'sure' => $sure,
            'message' => $message
        ];
    }

    /**
     * @method POST
     * @param $id Unique from selected Category
     * @description update an existing Category to db
     * @returnType json
     */
    public function update_Category($id, $novalidation = null) {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $table = 'config_menu_category';

        if (!is_null($novalidation)) {
            $validation['sure'] = true;
        } else {
            $validation = $this->beforeUpdatingCategory($id, $request, $table);
        }
        //
        if (!$validation['sure']) {
            $response = [
                'status' => 'error',
                'message' => $validation['message']
            ];
        }
        else {
            $request['Updated'] = date('Y-m-d H:i:s');
            $request['UpdatedBy'] = $this->session->userdata('userid');
            $status = $this->menu->updateCategory($request, $id);

            if ($status) {
                $response = [
                    'status' => 'success',
                    'message' => $status
                ];
            }
        }

        echo json_encode($response);
    }

    /**
     * @description Validation before updating Category
     * @param $id
     * @param $request
     * @param $table
     * @return array
     */
    private function beforeUpdatingCategory($id, $request, $table) {
        $sure = true;
        $message = [];
        //
        $category = $this->menu->getNameByMenu($id, $table);
        $whereNot = ['CategoryName !=' => $category[0]['CategoryName']];
        $nameUsed = $this->menu->validateField('CategoryName', $request['CategoryName'], $table, $whereNot);
        if ($nameUsed) {
            $sure = false;
            $message['CategoryName'] = 'Category name must be unique. Please type a different one.';
        }
//        if (!ctype_digit($request['Row'])) {
//            $sure = false;
//            $message['CategoryRow'] = 'Row must be an integer value.';
//        }
//
//        if (!ctype_digit($request['Column'])) {
//            $sure = false;
//            $message['CategoryColumn'] = 'Column must be an integer value.';
//        }
        $gridPosition = $this->menu->isCategoryPositionBusy($request, $id);
        if ($gridPosition) {
            $sure = false;
            $message['CategoryColumn'] = 'Row and Column cannot be the same as another Category';
            $message['CategoryRow'] = 'Row and Column cannot be the same as another Category';
        };

        return [
            'sure' => $sure,
            'message' => $message
        ];
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