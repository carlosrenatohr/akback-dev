<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'backoffice';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['service'] = "service/version";
$route['service/(:any)'] = "service/$1";

//logon page
$route['backoffice'] = "backoffice/login";
$route['backoffice/dashboard'] = "backoffice/dashboard_main";

//supplier
$route['backoffice/supplier'] = "backoffice/supplier_list_view";

//purchase order
$route['backoffice/receiving/add-new'] = "backoffice/include_receiving_addnew";
$route['backoffice/receiving/inventory'] = "backoffice/include_receiving_inventory";
$route['backoffice/receiving/poitemdel'] = "backoffice/include_podel_alert";
$route['backoffice/receiving/poiteminfo'] = "backoffice/include_po_item_info";

//inventory
$route['backoffice/inventory/new'] = "backoffice/newitem";
$route['backoffice/inventory/edit'] = "backoffice/edititem";
$route['backoffice/receiving'] = "backoffice/receiving_page";
$route['backoffice/receiving/purchase-order/add/(:any)'] = "backoffice/receiving_po_add_page/$1";
$route['backoffice/receiving/purchase-order/edit/(:any)'] = "backoffice/receiving_po_page/$1";

//category
$route['backoffice/category'] = "category/category_page";
$route['backoffice/category/test'] = "category/category_test_page";
$route['backoffice/category/add/form'] = "category/include_add_form";
$route['backoffice/category/edit/form'] = "category/include_edit_form";
$route['backoffice/category/delete/form'] = "category/include_delete_form";
$route['backoffice/sub/category/add/form'] = "category/include_add_subcat_form";
$route['backoffice/sub/category/edit/form'] = "category/include_edit_subcat_form";
$route['backoffice/sub/category/delete/form'] = "category/include_delete_subcat_form";
$route['backoffice/category/menu-header-info'] = "category/get_header_information";

/* Time Clock */
$route['backoffice/load-timeclock'] = "timeclock/load_timeclock";
$route['backoffice/timeclock/edit-time-clock'] = "timeclock/include_edit_timeclock_page";
$route['backoffice/timeclock/alert-message-info'] = "timeclock/include_dialog_alert";
$route['backoffice/timeclock/add-time-clock'] = "timeclock/include_add_timeclock_page";
$route['backoffice/timeclock/delete-time-clock'] = "timeclock/include_delete_timeclock_page";
$route['backoffice/timeclock'] = "timeclock/create_token"; 
$route['backoffice/timeclock/export'] = "timeclock/excel_export";
$route['backoffice/timeclock/download'] = "timeclock/download_file";

/*Dashboard Reports*/
$route['backoffice/reports'] = "Reports/index";
$route['backoffice/inventory/valuation/report'] = "inventory_report/inventory_valuation";
$route['backoffice/inventory/valuation/export'] = "inventory_report/inventory_valuation_export";
$route['backoffice/inventory/valuation/download'] = "inventory_report/download_file";

//cm 2016-03-12
$route['backoffice/reports/payments'] = "report_payments/payments_view"; 
$route['backoffice/reports/payments_echo'] = "report_payments/payments_echo";
$route['backoffice/reports/payments_select'] = "report_payments/payments_select"; 
$route['backoffice/reports/payments_select_url/:any/:any'] = "report_payments/payments_select_url"; 
$route['backoffice/reports/payments_export'] = "report_payments/payments_export"; 
$route['backoffice/reports/payments_download'] = "report_payments/payments_download"; 


//cm 2016-03-13
$route['backoffice/reports/receipts'] = "report_receipts/receipts_view"; 
$route['backoffice/reports/receipts_echo'] = "report_receipts/receipts_echo"; 
$route['backoffice/reports/receipts_select_url/:any/:any/:any'] = "report_receipts/receipts_select_url"; 
$route['backoffice/reports/receipts_select'] = "report_receipts/receipts_select"; 
$route['backoffice/reports/receipts_export'] = "report_receipts/receipts_export"; 
$route['backoffice/reports/receipts_download'] = "report_receipts/receipts_download"; 

//cm 2016-03-20
$route['backoffice/reports/itemsales_echo'] = "report_itemsales/itemsales_echo"; 
$route['backoffice/reports/itemsales'] = "report_itemsales/itemsales_view"; 
$route['backoffice/reports/itemsales_select'] = "report_itemsales/itemsales_select"; 
$route['backoffice/reports/itemsales_export'] = "report_itemsales/itemsales_export"; 
$route['backoffice/reports/itemsales_download'] = "report_itemsales/itemsales_download"; 

//cm 2016-03-23
$route['backoffice/reports/tips_echo'] = "report_tips/tips_echo"; 
$route['backoffice/reports/tips'] = "report_tips/tips_view"; 
$route['backoffice/reports/tips_select'] = "report_tips/tips_select"; 
$route['backoffice/reports/tips_export'] = "report_tips/tips_export"; 
$route['backoffice/reports/tips_download'] = "report_tips/tips_download"; 

//cm 2016-03-27
$route['backoffice/reports/categorysales_echo'] = "report_categorysales/categorysales_echo"; 
$route['backoffice/reports/categorysales'] = "report_categorysales/categorysales_view"; 
$route['backoffice/reports/categorysales_select'] = "report_categorysales/categorysales_select"; 
$route['backoffice/reports/categorysales_export'] = "report_categorysales/categorysales_export"; 
$route['backoffice/reports/categorysales_download'] = "report_categorysales/categorysales_download"; 

//cm 2016-03-27
$route['backoffice/reports/itemreturns_echo'] = "report_itemreturns/itemreturns_echo"; 
$route['backoffice/reports/itemreturns'] = "report_itemreturns/itemreturns_view"; 
$route['backoffice/reports/itemreturns_select'] = "report_itemreturns/itemreturns_select"; 
$route['backoffice/reports/itemreturns_export'] = "report_itemreturns/itemreturns_export"; 
$route['backoffice/reports/itemreturns_download'] = "report_itemreturns/itemreturns_download"; 

//administration
$route['backoffice/administration'] = "backoffice/admin_side";
