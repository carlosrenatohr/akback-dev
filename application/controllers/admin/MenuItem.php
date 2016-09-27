<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 05-19-16
 * Time: 02:57 PM
 */
class MenuItem extends AK_Controller
{

    protected $decimalQuantity, $decimalPrice, $decimalTax;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_item_model', 'menuItem');
        $this->load->model('Menu_model', 'menu');
        $this->load->model('Item_model', 'item');
        $this->decimalQuantity = (int)$this->session->userdata('DecimalsQuantity');
        $this->decimalPrice = (int)$this->session->userdata("DecimalsPrice");
        $this->decimalTax = (int)$this->session->userdata("DecimalsTax");
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
            if (isset($request['pricesValues']) && isset($request['extraValues'])) {
                $pricesValues = $request['pricesValues'];
                $extraValues = $request['extraValues'];
                unset($request['pricesValues']);
                unset($request['extraValues']);
            }
            $status = $this->menuItem->postItemByMenu($request);
            if ($status) {
                if(isset($extraValues) && isset($pricesValues)) {
                    $itemFields = array_merge($pricesValues, $extraValues);
                    $this->item->update($request['ItemUnique'], $itemFields);
                }
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

    /**
     * INVENTORY MODULE ON ADMIN - Item table
     */

    public function getItemsData() {
        $items = [];
        foreach($this->item->getItemsData() as $count=> $item) {
            $item['ListPrice'] = number_format($item['ListPrice'], $this->decimalPrice);
            $item['price1'] = number_format($item['price1'], $this->decimalPrice);
//            $quantity = !is_null($item['Quantity']) ? $item['Quantity'] : 0;
            $item['Quantity'] = number_format($item['Quantity'], $this->decimalQuantity) ;
            $items[] = $item;
        }
        echo json_encode($items);
    }

    public function getSupplierList() {
        $newSuppliers = [];
        foreach($this->item->getSupplierList() as $supplier) {
            $supplier['Company'] = trim($supplier['Company']);
            $newSuppliers[] = $supplier;
        }
        echo json_encode($newSuppliers);
    }
    public function getBrandList() {
        $brands = [];
        foreach($this->item->getBrandList() as $brand) {
            $brand['Name'] = trim($brand['Name']);
            $brands[] = $brand;
        }
        echo json_encode($brands);
    }
    public function getCategoryList() {
        $categories = [];
        foreach($this->item->getCategoryList() as $category) {
            $category['MainName'] = trim($category['MainName']);
            $categories[] = $category;
        }
        echo json_encode($categories);
    }
    public function getSubcategoryList($id = null) {
        $subcategories = [];
        foreach($this->item->getSubcategoryList($id) as $subcategory) {
            $subcategory['Name'] = trim($subcategory['Name']);
            $subcategories[] = $subcategory;
        }
        echo json_encode($subcategories);
    }

    private function checkItemValues($data) {
        $values = [];
//        foreach($data as $field) {
            $data['Cost'] = (isset($data['Cost'])) ? number_format($data['Cost'], $this->decimalPrice, '.', '') : 0;
            $data['Cost_Extra'] = (isset($data['Cost_Extra'])) ? number_format($data['Cost_Extra'], $this->decimalPrice, '.', '') : 0;
            $data['Cost_Freight'] = (isset($data['Cost_Freight'])) ? number_format($data['Cost_Freight'], $this->decimalPrice, '.', '') : 0;
            $data['Cost_Duty'] = (isset($data['Cost_Duty'])) ? number_format($data['Cost_Duty'], $this->decimalPrice, '.', '') : 0;
            $data['price1'] = (isset($data['price1'])) ? number_format($data['price1'], $this->decimalPrice, '.', '') : 0;
            $data['price2'] = (isset($data['price2'])) ? number_format($data['price2'], $this->decimalPrice, '.', '') : 0;
            $data['price3'] = (isset($data['price3'])) ? number_format($data['price3'], $this->decimalPrice, '.', '') : 0;
            $data['price4'] = (isset($data['price4'])) ? number_format($data['price4'], $this->decimalPrice, '.', '') : 0;
            $data['price5'] = (isset($data['price5'])) ? number_format($data['price5'], $this->decimalPrice, '.', '') : 0;
            $data['ListPrice'] = (isset($data['ListPrice'])) ? number_format($data['ListPrice'], $this->decimalPrice, '.', '') : 0;
            $data['PromptPrice'] = (isset($data['PromptPrice'])) ? number_format($data['PromptPrice'], $this->decimalPrice, '.', '') : null;
            $data['SupplierUnique'] = (isset($data['SupplierUnique'])) ? (int)$data['SupplierUnique'] : null;
            $data['BrandUnique'] = (isset($data['BrandUnique'])) ? (int)$data['BrandUnique'] : null;
            $data['MainCategory'] = (isset($data['MainCategory'])) ? (int)$data['MainCategory'] : null;
            $data['CategoryUnique'] = (isset($data['CategoryUnique'])) ? (int)$data['CategoryUnique'] : null;
            $data['GiftCard'] = (isset($data['GiftCard'])) ? (int)$data['GiftCard'] : null;
            $data['Group'] = (isset($data['Group'])) ? (int)$data['Group'] : null;
            $data['PromptPrice'] = (isset($data['PromptPrice'])) ? (int)$data['PromptPrice'] : null;
            $data['PromptDescription'] = (isset($data['PromptDescription'])) ? (int)$data['PromptDescription'] : null;
            $data['EBT'] = (isset($data['EBT'])) ? (int)$data['EBT'] : null;
            $data['MinimumAge'] = (isset($data['MinimumAge'])) ? (int)$data['MinimumAge'] : null;
            $data['CountDown'] = (isset($data['CountDown'])) ? (int)$data['CountDown'] : null;
            $data['Points'] = (isset($data['Points'])) ? (float)$data['Points'] : null;
//        }
        return $data;
    }

    public function postItemInventory() {
        $data = $_POST;
        if (!empty($data) || !is_null($_POST)) {
            $taxes = (isset($_POST['taxesValues']) && !empty($_POST['taxesValues']))
                        ? $_POST['taxesValues']
                        : [];
//            unset($_POST['taxesValues']);
            unset($data['taxesValues']);
            $status = $this->item->saveItem($this->checkItemValues($data));
            if ($status) {
                $this->item->updateTaxesByItem($taxes, $status);
                $response = [
                    'status' => 'success',
                    'id' => $status,
                    'message' => 'Item created successfully!'
                ];
            } else
                $response = $this->dbErrorMsg();
        }
        else
            $response = $this->dbErrorMsg(0);

        echo json_encode($response);
    }

    public function updateItemInventory($id) {
        $data = $_POST;
        if (!empty($data) || !is_null($_POST)) {
            $taxes = (isset($_POST['taxesValues']) && !empty($_POST['taxesValues']))
                        ? $_POST['taxesValues']
                        : '';
//            unset($_POST['taxesValues']);
            unset($data['taxesValues']);
            $this->item->updateTaxesByItem($taxes);
            $status = $this->item->updateItem($id, $this->checkItemValues($data));
            if ($status) {
                $response = [
                    'status' => 'success',
//                    'id' => $status,
                    'message' => 'Item updated successfully!'
                ];
            } else
                $response = $this->dbErrorMsg();
        }
        else
            $response = $this->dbErrorMsg(0);

        echo json_encode($response);
    }

    public function deleteItemInventory($id) {
        $data = $_POST;
        if (!empty($data) || !is_null($_POST)) {
            $status = $this->item->updateItem($id, ['Status' => 0]);
            if ($status) {
                $response = [
                    'status' => 'success',
                    'message' => 'Item deleted successfully!'
                ];
            } else
                $response = $this->dbErrorMsg();
        }
        else
            $response = $this->dbErrorMsg(0);

        echo json_encode($response);
    }

    /**
     * @param null $id
     * @description Get barcodes by item
     */
    public function getBarcodesByItem($id = null) {
        echo json_encode($this->item->getBarcodesByItem($id));
    }

    public function saveBarcodeItem($id = null) {
        $data = $_POST;
        if (!empty($data) || !is_null($_POST)) {
            if (is_null($id))
                $status = $this->item->saveItemBarcode($data);
            else
                $status = $this->item->updateItemBarcode($id, $data);
            if ($status) {
                $response = [
                    'status' => 'success',
                    'id' => $status,
                    'message' => 'Barcode updated!'
                ];
            } else
                $response = $this->dbErrorMsg();
        } else
            $response = $this->dbErrorMsg(0);

        echo json_encode($response);
    }

    public function deleteBarcodeItem($id) {
        if (isset($id)) {
            $status = $this->item->deleteItemBarcode($id);
            if ($status) {
                $response = [
                    'status' => 'success',
                    'message' => 'Barcode deleted!'
                ];
            } else
                $response = $this->dbErrorMsg();
        } else
            $response = $this->dbErrorMsg(0);

        echo json_encode($response);
    }

    /**
     * @description Get taxes
     */
    public function getTaxesList($itemId = null, $creating = null) {
        $taxes = $this->item->getTaxList();
//        if (!is_null($itemId)) {
            $taxesWithItemData = [];
            foreach($taxes as $tax) {
                if (!is_null($itemId)) {
                    $tax['taxed'] = $this->item->verifyTaxByItem($itemId, $tax['Unique']);
                } else {
                    $tax['taxed'] = ($tax['Status'] == 1) && ($tax['Default'] == 1) ? true : false;
                }
                $taxesWithItemData[] = $tax;
            }
            $taxes = $taxesWithItemData;
//        }
        echo json_encode($taxes);
    }

    /**
     * @description Get stock line by item
     * @param $id
     * @param $location
     */
    public function getStocklineItems($id = null, $location = null) {
        $stock_n = [];
        if ($id != null) {
            $stock = $this->item->getStockItemByLocation($id, $location);
            foreach($stock as $row) {
                $row["Quantity"] = number_format($row["Quantity"], $this->decimalQuantity);
				$row["Total"] = number_format($row["Total"], $this->decimalQuantity);
                $row["Comment"] = trim($row["Comment"]);
                $row["TransactionDate"] = is_null($row["TransactionDate"]) ? "" :date("m/d/Y h:i A",strtotime($row["TransactionDate"]));
                $stock_n[] = $row;
            }
        }

        echo json_encode($stock_n);
    }

    public function updateStocklineItems() {
        $data = $_POST;
        if (!empty($data) || !is_null($data)) {
            $data['Type'] = 4;
            $data['status'] = 1;
            $data['Comment'] = trim($data['Comment']);
            $data['Quantity'] = number_format($data['Quantity'], $this->decimalQuantity);
            $data['trans_date'] = date("Y-m-d", strtotime($data['trans_date']));
            $data['TransactionDate'] = $data['trans_date'] . " ".
                date("H:i:s",strtotime($data['trans_time']));
            unset($data['trans_time']);
            $status = $this->item->updateStockByItem($data);
            if ($status) {
                $response = [
                    'status' => 'success',
//                    'id' => $status,
                    'message' => 'Stock item updated successfully!'
                ];
            } else
                $response = $this->dbErrorMsg();
        }
        else
            $response = $this->dbErrorMsg(0);

        echo json_encode($response);
    }

    public function totalQuantityByLocation($id, $location) {
        if (isset($id) || isset($location)) {
            $qty = $this->item->getTotalQuantity($id, $location);
            $quantity = number_format($qty['Quantity'], $this->decimalQuantity);
            echo $quantity;
        } else
            echo "There was an error";
    }

    public function getLocationsList($all = null) {
        $new = [];
        if ($all != null) {
            $new[] = [
                'Unique' => 0,
                'Name' => 'All Location',
                'LocationName' => 'All Location',
            ];
        }
        foreach($this->getLocations() as $location) {
            $location['LocationName'] = trim($location['LocationName']);
            $new[] = $location;
        }
        echo json_encode($new);
    }

}