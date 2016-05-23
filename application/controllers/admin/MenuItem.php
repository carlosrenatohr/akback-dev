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


    public function load_allMenusWithCategories($status, $withCategories) {
        $newMenus = [];
        $menus = $this->menu->getLists($status, $withCategories);
        foreach($menus as $menu) {
            if (!isset($newMenus[$menu['MenuName']])) {
                $categ_keys = ['CategoryName' => '', 'CategoryRow' => '','CategoryColumn' => '','CategorySort' => '','CategoryStatus' => '','CategoryUnique' => '', ];
                $menuValues = array_diff_key($menu, $categ_keys);
                $newMenus[$menu['MenuName']] = $menuValues;
            }

            $newMenus
            [$menu['MenuName']]['categories'][] =
                                    ['CategoryName' => $menu['CategoryName'],
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

    public function load_allItems() {
        $items = $this->menuItem->getItems();

        echo json_encode($items);
    }

}