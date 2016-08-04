<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 08-03-16
 * Time: 07:41 PM
 */
class MenuPrinter extends AK_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_printer_model', 'menuPrinter');
    }

    public function load_allItemPrinters() {
        echo json_encode($this->menuPrinter->getAllPrinters());
    }

}