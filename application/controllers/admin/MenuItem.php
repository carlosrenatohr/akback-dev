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
//        $this->load->model('MenuItem_model', 'menuItem');
        $this->load->model('Menu_model', 'menu');
    }


    public function load_allMenusWithCategories($status, $withCategories) {
        $newMenus = [];
        $menus = $this->menu->getLists($status, $withCategories);
        foreach($menus as $menu) {
            if (array_search($menu['Unique'], $newMenus)) {

            }
            $newMenus[] = $menu;
        }

        echo json_encode(($newMenus));
    }

}