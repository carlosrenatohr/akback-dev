<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 05-19-16
 * Time: 02:57 PM
 */
class MenuItem extends AK_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_item_model', 'menuItem');
        $this->load->model('Menu_model', 'menu');
    }

    /**
     * @method POST
     * @param $status filter by status
     * @param $withCategories include categories data values
     * @description Load all registered menus with categories
     * @returnType json
     */
    public function load_allMenusWithCategories($status, $withCategories)
    {
        $newMenus = [];
        $menus = $this->menu->getLists($status, $withCategories);
        foreach ($menus as $menu) {
            if (!isset($newMenus[$menu['MenuName']])) {
                $categ_keys = [
                    'CategoryName' => '',
                    'CategoryRow' => '',
                    'CategoryColumn' => '',
                    'CategorySort' => '',
                    'CategoryStatus' => '',
                    'CategoryUnique' => '',
                ];
                $menuValues = array_diff_key($menu, $categ_keys);
                $newMenus[$menu['MenuName']] = $menuValues;
            }
            $newMenus
            [$menu['MenuName']]['categories'][] =
                [
                    'CategoryName' => $menu['CategoryName'],
                    'Unique' => $menu['CategoryUnique'],
                    'Row' => $menu['CategoryRow'],
                    'Column' => $menu['CategoryColumn'],
                    'Sort' => $menu['CategorySort'],
                    'Status' => $menu['CategoryStatus']
                ];
//            $newMenus[] = $menu;
        }
        echo json_encode(array_values($newMenus));
    }

    /**
     * @method GET
     * @description Load all items
     * @returnType json
     */
    public function load_allItems()
    {
        $items = $this->menuItem->getItems();
        echo json_encode($items);
    }

    /**
     * @method GET
     * @param $id
     * @description Load all items by Category menu
     * @returnType json
     */
    public function getItemsByCategoryMenu($id)
    {
        $items = $this->menuItem->getItemsByCategoryMenu($id);
        echo json_encode($items);
    }

    /**
     * @method GET
     * @description Load an item by position of Row and Column
     * @returnType json
     */
    public function getItemByPositions()
    {
        $request = $_POST;
        $row = $this->menuItem->getItemByPosition($request);
        echo json_encode($row[0]);
    }

    /**
     * @method POST
     * @description post an item By Category
     * @returnType json
     */
    public function postMenuItems()
    {
        $request = $_POST;
        $status = $this->menuItem->postItemByMenu($request);
        // FIX missing validations
        if ($status) {
            $response = [
                'status' => 'success',
                'message' => 'Item success: ' . $status
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => $status
            ];
        }
        echo json_encode($response);
    }

    /**
     * @method POST
     * @description delete an item By Category on config_menu_items table
     * @returnType json
     */
    public function deleteMenuItems()
    {
        $request = $_POST;
        $status = $this->menuItem->deleteMenuItem($request);
        // FIX missing validations
        if ($status) {
            $response = [
                'status' => 'success',
                'message' => 'Item deleted: ' . $status
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => $status
            ];
        }
        echo json_encode($response);
    }

    /**
     * @method POST
     * @description set new position values between items on grid
     * @param $category array
     * @returnType json
     */
    public function setNewPosition($category) {
        $request = $_POST;
        $element = $request['element'];
        $target = $request['target'];

        $status = $this->menuItem->setNewPosition($category, $element, $target);
        echo json_encode($status);
    }

}