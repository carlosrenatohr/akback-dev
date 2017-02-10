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
        $this->load->model('Item_model', 'item');
    }

    public function index()
    {
        // Data to send
        $data = $this->initDefaultSession();
        $data['currentuser'] = $this->session->userdata("currentuser");
        $data['station'] = $this->session->userdata("station_number");
        $data['page_title'] = "Menu Categories";
        $data['storename'] = $this->displaystore();
        $data['labelPos'] = $this->item->getLabelPosList();
        // Partials Views
        $menu_path = 'backoffice_admin/menu_categories/';
        $data['menu_tab_view'] = $menu_path . "menu_tab";
        $data['menu_data_subtab_view'] = $menu_path . "menu_data_subtab";
        $data['menu_styles_subtab_view'] = $menu_path . "menu_styles_subtab";
        $data['menu_btns'] = $menu_path . "menu_btns";
        $data['cat_data_subview'] = $menu_path . "categories_data_subtab";
        $data['cat_picture_subview'] = $menu_path . "categories_picture_subtab";
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
        $data['items_style_subtab_view'] = $menu_path . "items_style_subtab";
        $data['questions_data_subtab'] = $menu_path . "questions_data_subtab";
        $data['questions_choices_subtab'] = $menu_path . "questions_choices_subtab";
        $data['qChoices_item_subtab'] = $menu_path . "questions_choices_item_subtab";
        $data['qChoices_style_subtab'] = $menu_path . "questions_choices_style_subtab";
        $data['qChoices_btns'] = $menu_path . "questions_choices_btns";
        $data['questions_style_subtab'] = $menu_path . "questions_style_subtab";
        $data['questions_tab_view'] = $menu_path . "questions_tab";
        $data['printers_tab_view'] = $menu_path . "printer_tab";
        // Main page
        $data['location_path'] = $this->getPicturePath();
        $data['main_content'] = $menu_path . "index";
        $this->load->view('backoffice_admin/templates/main_layout', $data);
    }

    protected function initDefaultSession() {
        $st = $this->session->userdata("station_number");
        $this->getSettingLocation('DefaultQuestionItemLabelFontSize', $st);
        $this->getSettingLocation("DefaultQuestionItemLabelFontColor", $st);
        $this->getSettingLocation("DefaultQuestionItemButtonSecondaryColor", $st);
        $this->getSettingLocation("DefaultQuestionItemButtonPrimaryColor", $st);
        $this->getSettingLocation("DefaultQuestionLabelFontSize", $st);
        $this->getSettingLocation("DefaultQuestionLabelFontColor", $st);
        $this->getSettingLocation("DefaultQuestionButtonSecondaryColor", $st);
        $this->getSettingLocation("DefaultQuestionButtonPrimaryColor", $st);
        $this->getSettingLocation("DefaultCategoryButtonLabelFontSize", $st);
        $this->getSettingLocation("DefaultCategoryButtonLabelFontColor", $st);
        $this->getSettingLocation("DefaultCategoryButtonSecondaryColor", $st);
        $this->getSettingLocation("DefaultCategoryButtonPrimaryColor", $st);
        $this->getSettingLocation("DefaultCategoryButtonLabelFontSize", $st);
        $this->getSettingLocation("DefaultCategoryButtonLabelFontColor", $st);
        $this->getSettingLocation("DefaultCategoryButtonSecondaryColor", $st);
        $this->getSettingLocation("DefaultCategoryButtonPrimaryColor", $st);
        $this->getSettingLocation("DefaultItemButtonLabelFontSize", $st);
        $this->getSettingLocation("DefaultItemButtonLabelFontColor", $st);
        $this->getSettingLocation("DefaultItemButtonSecondaryColor", $st);
        $this->getSettingLocation("DefaultItemButtonPrimaryColor", $st);
        //
        $data = [];
        $data['decimalsPrice'] = (int)$this->session->userdata("DecimalsPrice");
        $data['decimalsQuantity'] = (int)$this->session->userdata("DecimalsQuantity");
        //
        $qitBPC = $this->session->userdata("admin_DefaultQuestionItemButtonPrimaryColor");
        $qitBPC = explode('#', $qitBPC);
        $data['qitButtonPrimaryColor'] = $qitBPC[1];
        $qitBSC = $this->session->userdata("admin_DefaultQuestionItemButtonSecondaryColor");
        $qitBSC = explode('#', $qitBSC);
        $data['qitButtonSecondaryColor'] = $qitBSC[1];
        $qitLFC = $this->session->userdata("admin_DefaultQuestionItemLabelFontColor");
        $qitLFC = explode('#', $qitLFC);
        $data['qitLabelFontColor'] = $qitLFC[1];
        $data['qitLabelFontSize'] = $this->session->userdata("admin_DefaultQuestionItemLabelFontSize");
        //
        $qBPC = $this->session->userdata("admin_DefaultQuestionButtonPrimaryColor");
        $qBPC = explode('#', $qBPC);
        $data['qButtonPrimaryColor'] = $qBPC[1];
        $qBSC = $this->session->userdata("admin_DefaultQuestionButtonSecondaryColor");
        $qBSC = explode('#', $qBSC);
        $data['qButtonSecondaryColor'] = $qBSC[1];
        $qLFC = $this->session->userdata("admin_DefaultQuestionLabelFontColor");
        $qLFC = explode('#', $qLFC);
        $data['qLabelFontColor'] = $qLFC[1];
        $data['qLabelFont'] = $this->session->userdata("admin_DefaultQuestionLabelFontSize");
        //
        $catBPC = $this->session->userdata("admin_DefaultCategoryButtonPrimaryColor");
        $catBPC = explode('#', $catBPC);
        $data['catButtonPrimaryColor'] = $catBPC[1];
        $catBSC = $this->session->userdata("admin_DefaultCategoryButtonSecondaryColor");
        $catBSC = explode('#', $catBSC);
        $data['catButtonSecondaryColor'] = $catBSC[1];
        $catLFC = $this->session->userdata("admin_DefaultCategoryButtonLabelFontColor");
        $catLFC = explode('#', $catLFC);
        $data['catLabelFontColor'] = $catLFC[1];
        $data['catLabelFontSize'] = $this->session->userdata("admin_DefaultCategoryButtonLabelFontSize");
        //
        $mitBPC = $this->session->userdata("admin_DefaultItemButtonPrimaryColor");
        $mitBPC = explode('#', $mitBPC);
        $data['mitButtonPrimaryColor'] = $mitBPC[1];
        $mitBSC = $this->session->userdata("admin_DefaultItemButtonSecondaryColor");
        $mitBSC = explode('#', $mitBSC);
        $data['mitButtonSecondaryColor'] = $mitBSC[1];
        $mitLSC = $this->session->userdata("admin_DefaultItemButtonLabelFontColor");
        $mitLSC = explode('#', $mitLSC);
        $data['mitLabelFontColor'] = $mitLSC[1];
        $data['mitLabelFontSize'] = $this->session->userdata("admin_DefaultItemButtonLabelFontSize");
        return $data;
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
            //
            $bpc = explode('#', $category['ButtonPrimaryColor']);
            $category['ButtonPrimaryColor'] = (!is_null($category['ButtonPrimaryColor'])) ? $bpc[1] : null;
            $bpc = explode('#', $category['ButtonSecondaryColor']);
            $category['ButtonSecondaryColor'] = (!is_null($category['ButtonPrimaryColor'])) ? $bpc[1]: null;
            $bpc = explode('#', $category['LabelFontColor']);
            $category['LabelFontColor'] = (!is_null($category['LabelFontColor'])) ? $bpc[1]: null;
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
        $bpc = explode('#', $status['ButtonPrimaryColor']);
        $status['ButtonPrimaryColor'] = (!is_null($status['ButtonPrimaryColor'])) ? $bpc[1] : null;
        $bpc = explode('#', $status['ButtonSecondaryColor']);
        $status['ButtonSecondaryColor'] = (!is_null($status['ButtonPrimaryColor'])) ? $bpc[1]: null;
        $bpc = explode('#', $status['LabelFontColor']);
        $status['LabelFontColor'] = (!is_null($status['LabelFontColor'])) ? $bpc[1]: null;
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
            $message['CategoryColumn'] = 'Menu, Row and Column cannot be the same as another Category';
            $message['CategoryRow'] = 'Menu, Row and Column cannot be the same as another Category';
            $message['MenuUnique'] = 'Menu, Row and Column cannot be the same as another Category';
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
            $message['CategoryColumn'] = 'Menu, Row and Column cannot be the same as another Category';
            $message['CategoryRow'] = 'Menu, Row and Column cannot be the same as another Category';
            $message['MenuUnique'] = 'Menu, Row and Column cannot be the same as another Category';
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