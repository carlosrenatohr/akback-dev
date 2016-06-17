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
        $sort = isset($_GET['sort']) ? $_GET['sort'] : null;
        $items = $this->menuItem->getItems($sort);
        $new_items = [];
        foreach($items as $item) {
            if (!empty(trim($item['Description']))) {
                $item['Description'] = trim($item['Description']);
                $new_items[] = $item;
            }
        }

        echo json_encode($new_items);
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

        $ready = $this->validatePostingItemsOnMenu($request);
        if ($ready['needValidation']) {
            $response = [
                'status' => 'error',
                'message' => $ready['message']
            ];
        }
        // Posting
        else {
            $status = $this->menuItem->postItemByMenu($request);
            if ($status) {
                $response = [
                    'status' => 'success',
                    'message' => 'Item success: ' . $status
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Database error: ' . $status
                ];
            }
        }
        echo json_encode($response);
    }

    private function validatePostingItemsOnMenu($data) {
        $msg = [];
        $needValidation = false;
        $condition = false;
        if (isset($data['posCol'])) {
            $condition = $data['Column'] == $data['posCol'] && $data['Row'] == $data['posRow'];
        }

        if ($condition) {}
        else {
            $busy = $this->menuItem->verifyBusyPosition($data['Row'], $data['Column'], $data['MenuCategoryUnique']);
            if ($busy) {
                $needValidation = true;
                $msg['Row'] = 'Row and Column position are occupied.';
            }
            // No busy
            else {}
        }

        return [
            'needValidation' => $needValidation,
            'message' => $msg
            ];
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



    public function load_itemquestions($itemId = null) {
        $questions_format = [];
        $questions = $this->menuItem->getAllItemQuestions($itemId);
        foreach($questions as $question) {
            if ($question['Status'] == 1)
                $question['StatusName'] = 'Enabled';
            elseif($question['Status'] == 2)
                $question['StatusName'] = 'Disabled';
            else
                $question['StatusName'] = '-';
            $questions_format[] = $question;
        }

        echo json_encode($questions_format);
    }

    public function postQuestionMenuItems()
    {
        $request = $_POST;

        $status = $this->menuItem->postItemQuestion($request);
        if ($status) {
            $response = [
                'status' => 'success',
                'message' => 'Question Item success: ' . $status
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Database error: ' . $status
            ];
        }
        echo json_encode($response);
    }

    public function updateQuestionMenuItems($id) {
        $request = $_POST;

        $status = $this->menuItem->updateItemQuestion($id, $request);
        if ($status) {
            $response = [
                'status' => 'success',
                'message' => 'Question Item success: ' . $status
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Database error: ' . $status
            ];
        }
        echo json_encode($response);
    }

    public function deleteQuestionMenuItems($id) {
        $status = $this->menuItem->deleteItemQuestion($id);
        if ($status) {
            $response = [
                'status' => 'success',
                'message' => 'Question Item deleted: ' . $status
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => $status
            ];
        }
        echo json_encode($response);
    }

}