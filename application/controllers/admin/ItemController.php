<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 10-24-16
 * Time: 06:57 PM
 */
class ItemController extends AK_Controller
{

    protected $decimalCost, $decimalQty;
    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        // Data to send
        $data['currentuser'] = $this->session->userdata("currentuser");
        $data['station'] = $this->session->userdata("station_number");
        $data['page_title'] = "Menu Categories";
        $data['storename'] = $this->displaystore();
        $data['decimalsPrice'] = (int)$this->session->userdata("DecimalsPrice");
        $data['decimalsQuantity'] = (int)$this->session->userdata("DecimalsQuantity");
        // Partials Views
        $menu_path = 'backoffice_admin/inventory/';
        $data['inventory_item_subtab_view'] = $menu_path . "item_subtab";
        $data['inventory_cost_subtab_view'] = $menu_path . "cost_subtab";
        $data['inventory_price_subtab_view'] = $menu_path . "price_subtab";
        $data['inventory_stocklevel_subtab_view'] = $menu_path . "stocklevel_subtab";
        $data['inventory_tax_subtab_view'] = $menu_path . "tax_subtab";
        $data['inventory_barcode_subtab_view'] = $menu_path . "barcode_subtab";
        $data['inventory_question_subtab_view'] = $menu_path . "question_subtab";
        $data['inventory_printer_subtab_view'] = $menu_path . "printer_subtab";
        $data['inventory_options_subtab_view'] = $menu_path . "options_subtab";
        $data['inventory_picture_subtab_view'] = $menu_path . "picture_subtab";
        // Main page
        $data['main_content'] = $menu_path . "main";
        $this->load->view('backoffice_admin/templates/main_layout', $data);
    }

    public function brandsPage() {
        $data['currentuser'] = $this->session->userdata("currentuser");
        $data['station'] = $this->session->userdata("station_number");
        $data['page_title'] = "Item Brands";
        $data['storename'] = $this->displaystore();
        $brand_path = 'backoffice_admin/inventory/brands/';
        $data['brand_subtab'] = $brand_path . 'brand_subtab';
        $data['info_subtab'] = $brand_path . 'info_subtab';
        //
        $data['main_content'] = $brand_path . "index";
        $this->load->view('backoffice_admin/templates/main_layout', $data);
    }

    public function countPage() {
        $station = $this->session->userdata("station_number");
        $this->getSettingLocation('DecimalsCost', $station);
        $this->getSettingLocation('DecimalsQuantity', $station);
        //
        $data['currentuser'] = $this->session->userdata("currentuser");
        $data['decimalCost'] = $this->session->userdata('admin_DecimalsCost');
        $data['decimalQty'] = $this->session->userdata('admin_DecimalsQuantity');
        $data['station'] = $station;
        $data['page_title'] = "Item Count";
        $data['storename'] = $this->displaystore();
        $data['locations'] = $this->getLocations();
        $count_path = 'backoffice_admin/inventory/count/';
        $data['count_subtab'] = $count_path . 'count_subtab';
        $data['list_subtab'] = $count_path . 'count_list_subtab';
        $data['filters_subtab'] = $count_path . 'filters_subtab';
        $data['btns_template'] = $count_path . '_btns';
        //
        $data['main_content'] = $count_path . "index";
        $this->load->view('backoffice_admin/templates/main_layout', $data);
    }

    public function countImportPage() {
        $data['currentuser'] = $this->session->userdata("currentuser");
//        $data['decimalCost'] = $this->session->userdata('admin_DecimalsCost');
//        $data['decimalQty'] = $this->session->userdata('admin_DecimalsQuantity');
        $data['station'] = $this->session->userdata("station_number");
        $data['page_title'] = "Item Scan Import";
        $data['storename'] = $this->displaystore();
        $data['locations'] = $this->getLocations();
        $scan_path = 'backoffice_admin/inventory/count/scan_import/';
        $data['import_subtab'] = $scan_path . 'import_subtab';
        $data['list_subtab'] = $scan_path . 'scan_list_subtab';
        $data['btns_template'] = $scan_path . '_btns';
        //
        $data['main_content'] = $scan_path . "index";
        $this->load->view('backoffice_admin/templates/main_layout', $data);
    }

}