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
        $this->load->model('Item_printer_model', 'menuPrinter');
    }

    public function load_allItemPrinters($unique = null) {
        $newPrinters = [];
        $printers = $this->menuPrinter->getAllItemPrinters($unique);
        echo json_encode($printers);
    }

    public function load_allPrintersFromConfig() {
        $newPrinters = [];
        $printers = $this->menuPrinter->getPrinters();
        foreach($printers as $printer) {
            $printer['fullDescription'] = $printer['name'] . ' | ' . $printer['description'];
            $newPrinters[] = $printer;
        }
        echo json_encode($newPrinters);
    }

    public function post_item_printer()
    {
        $post = $_POST;
        $id = $this->menuPrinter->postPrinter($post);
        if($id) {
            $response =
                [
                    'status' => 'success',
                    'message' => true,
                    'id' => $id
                ];
        } else {
            $response = $this->dbErrorMsg();
        }
        echo json_encode($response);
    }
    
    public function update_item_printer($id)
    {
        $post = $_POST;
        $status = $this->menuPrinter->updatePrinter($id, $post);
        if ($status) {
            $response =
                [
                    'status' => 'success',
                    'message' => $status
                ];
        } else {
            $response = $this->dbErrorMsg();
        }
        echo json_encode($response);

    }

    public function delete_item_printer($id)
    {
        $status = $this->menuPrinter->deletePrinter($id);
        if ($status) {
            $response =
                [
                    'status' => 'success',
                    'message' => $status
                ];
        } else {
            $response = $this->dbErrorMsg();
        }
        echo json_encode($response);
    }


}