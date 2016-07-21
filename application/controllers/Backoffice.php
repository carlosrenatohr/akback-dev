<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Backoffice extends CI_Controller {

	function __construct() {
        parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->library('form_validation');
		//$this->load->model('ExtendClass');
        $this->load->model('backoffice_model');
		$this->load->library('Curl');
		$timezone = "Pacific/Honolulu";
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
    }
	
	public function index()
	{
		$this->login(); 
	}
	
	
	/*Login Page*/
	function login(){
		$api = 'http://akamaidev:1337/';  //cm
		//$api = '192.168.0.110:1337/';  //cm
		//Redirect
		if($this->_is_logged_in()){
			redirect('backoffice/dashboard'); //cm
			//redirect('backoffice/cashier'); //cm Default to Cashier page.
		}
		if($_POST){
			//-->Data
			$username = $this->input->post('username', true);
			$password = $this->input->post('password', true);
			$StationNumber = $this->input->post("station");
			$StationInfo = $this->backoffice_model->config_station_by_unique($StationNumber);
			$data["screensize"] = $StationInfo["screensize"];
			$StationName = $this->backoffice_model->find_station_name($StationNumber);
			$storeid = $this->backoffice_model->find_location_unique($StationNumber);
			$userdata = $this->backoffice_model->validate($username, md5($password));
			$location_setting = $this->backoffice_model->location_setting($StationNumber);
			$config_menu_functions = $this->backoffice_model->config_menu_functions();
			
			$config_datacap = $this->curl->simple_get($api."merchant/datacap/".$StationNumber);
			$datacap = json_decode($config_datacap, true);
			foreach($datacap['rows'] as $row){
				$data[$row["Setting"]] = $row["Value"];
			}
			
			foreach($config_menu_functions as $row){
				$functions[] = array(
					"Unique"		=> $row["Unique"],
					"StationUnique" => $row["StationUnique"],
					"Function"		=> $row["Function"],
					"Label"			=> $row["Label"],
					"Status"		=> $row["Status"],
					"Sort1"			=> $row["Sort1"],
					"Sort2"			=> $row["Sort2"],
					"HTMLString"	=> $row["HTMLString"]
				);  
			}
			$data['Functions'] = $functions;
			
      		//$customers = $this->backoffice_model->load_customers();
			//-->Validation
			if($userdata){
				foreach($location_setting as $row){
					$data[$row["Setting"]] = $row["Value"];
				}
				//$data['zipcodes'] = $this->load_zipcode_prepopulate();
				//$data['cities'] = $this->load_city_prepopulate();
				//$data['island'] = $this->load_island_prepopulate();
				//$data['states'] = $this->load_state_prepopulate();
				//$data['countries'] = $this->load_country_prepopulate();
				$data['userid'] = $userdata["Unique"];
				$data['storeunique'] = $storeid;
				$storename = $this->backoffice_model->stores($storeid);
				$data['store_name'] = $storename;
				$data['currentuser'] = $userdata["FirstName"];
				$data['station_number'] = $StationNumber;
				$data['station_name'] = $StationName;
				$data['logged_in'] = true;
        		//$data['customers'] = $customers;
				$this->session->set_userdata($data);
				redirect('backoffice/dashboard'); //cm
				//redirect('backoffice/cashier');  //cm Default to Cashier page.
			}else{
				$data['error'] = "Invalid username or password!";
				$data['main_content'] = "backoffice/backoffice_login_page";
				$this->load->view('backoffice_templates/backoffice_template', $data);
			}
			return;
		 }
		$error = $this->session->userdata("error");
		if($error){
			$data["error"] = $error;
		}
		$data['main_content'] = 'backoffice/backoffice_login_page';
		$this->load->view('backoffice_templates/backoffice_template', $data);
	}
	
	
	function displaystore(){
		$storeid = $this->session->userdata("storeunique");
		$storename = $this->backoffice_model->stores($storeid);
		return $storename;
	}
	
	/*Dashboard or Main Page*/
    function dashboard_main(){
		if($this->_is_logged_in()){
			$this->session->unset_userdata("token");
			$data["storename"] = $this->displaystore();
			$data["currentuser"] = $this->session->userdata("currentuser");
			$data['main_content'] = "backoffice/backoffice_dashboard_page";
			$this->load->view('backoffice_templates/backoffice_template', $data);
		}else{
			$data['error'] = "Your session has already expired!";
			$this->session->set_userdata($data);
			redirect('backoffice/login');
		}
	}

	function receiving_page(){
		if($this->_is_logged_in()){
			$data["storename"] = $this->displaystore();
			$data["currentuser"] = $this->session->userdata("currentuser");
			$data["userid"] = $this->session->userdata("userid");
			$data["stationnumber"] = $this->session->userdata("station_number");
			$data["storeunique"] = $this->session->userdata("storeunique");
			$data["page_title"] = "Receiving";
			$data['main_content'] = "backoffice/backoffice_receiving_page";
			$this->load->view('backoffice_templates/backoffice_receiving_template', $data);
		}else{
			$data['error'] = "Your session has already expired!";
			$this->session->set_userdata($data);
			redirect('backoffice/login');
		}
	}

	function receiving_po_page(){
		if($this->_is_logged_in()){
			$data["storename"] = $this->displaystore();
			$data["currentuser"] = $this->session->userdata("currentuser");
			$data["userid"] = $this->session->userdata("userid");
			$data["stationnumber"] = $this->session->userdata("station_number");
			$data["storeunique"] = $this->session->userdata("storeunique");
			$data["page_title"] = "Receiving";
			$data['main_content'] = "backoffice/backoffice_receiving_po_page";
			$this->load->view('backoffice_templates/backoffice_purchaseorder_template', $data);
		}else{
			$data['error'] = "Your session has already expired!";
			$this->session->set_userdata($data);
			redirect('backoffice/login');
		}
	}

	function receiving_po_add_page(){
		if($this->_is_logged_in()){
			$data["storename"] = $this->displaystore();
			$data["currentuser"] = $this->session->userdata("currentuser");
			$data["userid"] = $this->session->userdata("userid");
			$data["stationnumber"] = $this->session->userdata("station_number");
			$data["storeunique"] = $this->session->userdata("storeunique");
			$data["page_title"] = "Receiving";
			$data['main_content'] = "backoffice/backoffice_receiving_add_po_page";
			$this->load->view('backoffice_templates/backoffice_purchaseorder_add_template', $data);
		}else{
			$data['error'] = "Your session has already expired!";
			$this->session->set_userdata($data);
			redirect('backoffice/login');
		}
	}


	function just_test(){
		$result = $this->session->userdata();
		var_dump($result);
	}

	/*Checking whether is logged or not*/
	function _is_logged_in(){
		if($this->session->userdata('logged_in')){
			return true;
		}else{
			return false;
		}
	}
	/*Logout*/
	function logout(){
		$this->session->sess_destroy();
		redirect('backoffice/login');
	}

	/*Load Stores from station table*/
	function load_station(){
		$json = array();
		$result = $this->backoffice_model->config_station();
		if($result){
			foreach($result as $row){
				$number = $row["Number"];
				$name = $row["Name"];
				$LocationUnique = $row["LocationUnique"];
				$json[$number]["description"] = $name;
			}
		}
		echo json_encode($json);
	}

	function load_stores(){
		$json = array();
		$json[] = array(
					"Unique" => 0,
					"description" => "All Location"
				  );
		$result = $this->backoffice_model->stores(false);
		if($result){
			foreach($result as $row){
				/*
				$storeunique = $row["Unique"];
				$description = $row["LocationName"];
				$json[$storeunique]["description"] = $description;
				*/
				$json[] = array(
					"Unique" => $row["Unique"],
					"description" => $row["LocationName"]
				);
			}
		}
		echo json_encode($json);
	}
	
	function load_stores_stock(){
		$json = array();
		$result = $this->backoffice_model->stores(false);
		if($result){
			foreach($result as $row){
				$json[] = array(
					"Unique" => $row["Unique"],
					"description" => $row["LocationName"]
				);
			}
		}
		echo json_encode($json);
	}


	function inventory(){
		if($this->_is_logged_in()){
			/*Breadcrumb*/
			$data['breadcrumb'] = '<ol class="breadcrumb" style="margin:0;">
									  <li><a href="'.base_url("backoffice").'">Dashboard</a></l>
									  <li class="active">Inventory</li>
									</ol>';
			$data["storename"] = $this->displaystore();
			$data["storeid"] = $this->session->userdata("storeunique");
			$data["currentuser"] = $this->session->userdata("currentuser");
			$data["cost"] = $this->session->userdata("DecimalsCost");
			$data["price"] = $this->session->userdata("DecimalsPrice");
			$data["quantity"] = $this->session->userdata("DecimalsQuantity");
			$data["tax"] = $this->session->userdata("DecimalsTax");
			$data['main_content'] = "backoffice/backoffice_inventory_test_page";
			$data['DefaultSupplier'] = $this->session->userdata('DefaultSupplier');
			$data['DefaultBrand'] = $this->session->userdata('DefaultBrand');
			$data['DefaultCategory'] = $this->session->userdata('DefaultCategory');
			$data['DefaultSubCategory'] = $this->session->userdata('DefaultSubCategory');
			$this->load->view('backoffice_templates/backoffice_template', $data);
		}else{
			$data['error'] = "Your session has already expired!";
			$this->session->set_userdata($data);
			redirect('backoffice/login');
		}
	}


	function administration(){
		$data["currentuser"] = $this->session->userdata("currentuser");
		$data['main_content'] = "backoffice/backoffice_administration_page";
		$this->load->view('backoffice_templates/backoffice_template', $data);
	}


	function load_inventory($locationid){
		$json = array();
		//$storeunique = $this->session->userdata("storeunique");
		$decimalscost = $this->session->userdata("DecimalsCost");
		$decimalsprice = $this->session->userdata("DecimalsPrice");
		$decimalsquantity = $this->session->userdata("DecimalsQuantity");
		$decimalstax = $this->session->userdata("DecimalsTax");
		$result = $this->backoffice_model->inventory($locationid);
		if($result){
			foreach($result as $row){
				$json[]=array(
							"Unique" => trim($row["Unique"]),
							"Item" => trim($row["Item"]),
							"Part" => trim($row["Part"]),
							"Description" => trim($row["Description"]),
							"Size" => trim($row["Size"]),
							"Color" => trim($row["Color"]),
							"Other" => trim($row["Other"]),
							"SupplierId" => trim($row["SupplierId"]),
							"Supplier" => trim($row["Supplier"]),
							"SupplierPart" => trim($row["SupplierPart"]),
							"BrandId" => trim($row["BrandId"]),
							"Brand" => trim($row["Brand"]),
							"CatMainId" => trim($row["CatMainId"]),
							"Category" => trim($row["Category"]),
							"SubCategory" => trim($row["SubCategory"]),
							"Cost" => trim(number_format($row["Cost"],$decimalscost, '.', ',')),
							"CostExtra" => trim(number_format($row["Cost_Extra"],$decimalscost, '.', ',')),
							"CostFreight" => trim(number_format($row["Cost_Freight"],$decimalscost, '.', ',')),
							"CostDuty" => trim(number_format($row["Cost_Duty"],$decimalscost, '.', ',')),
							//"CostDuty" => trim(floor($row["Cost_Duty"])),
							"CostLanded" => trim(number_format($row["CostLanded"],$decimalscost, '.', ',')),
							"ListPrice" => trim(number_format($row["ListPrice"],$decimalsprice, '.', ',')),
							"price1" => trim(number_format($row["price1"],$decimalsprice, '.', ',')),
							"price2" => trim(number_format($row["price2"],$decimalsprice, '.', ',')),
							"price3" => trim(number_format($row["price3"],$decimalsprice, '.', ',')),
							"price4" => trim(number_format($row["price4"],$decimalsprice, '.', ',')),
							"price5" => trim(number_format($row["price5"],$decimalsprice, '.', ',')),
							"Quantity" => trim(number_format($row["Quantity"],$decimalsquantity))
						);
			}
		}
		echo json_encode($json);
	}
	
	/*

	function getusers(){
		//ExtendClass
		$sql="SET OWNER = 'W1NDWARD', 'W1NDW&RDsoftw@re056968', '05696868', '666', 'VS/vZggrqocXme)glEnbcv6j', 'W1NDWARD', 'W1NDW&RDsoftw@re056968', '05696868', '666', 'DE3chRvmyqcR3wozoartrqRr', 'VS8erJTl<aeiApf7Tl&rxfAb'; ";
		$sql.="SELECT * FROM words ORDER BY wordsname";
		$this->ExtendClass->querydecrypt($sql);
		$result = $this->ExtendClass->result();
		var_dump($result); die();
		if($result !== FALSE){
			foreach($result as $row){
				echo $row->wordsunique;
			}
		}
	}
	
	*/

	

	function newitem(){
		if($this->_is_logged_in()){
			/*Breadcrumb*/
			$data['breadcrumb'] = '<ol class="breadcrumb" style="margin:0;">
									  <li><a href="'.base_url("backoffice").'">Dashboard</a></li>
									  <li><a href="'.base_url("backoffice/inventory").'">Inventory</a></li>
									  <li class="active">New</li>
									</ol>';
			$data["storename"] = $this->displaystore();
			$data["currentuser"] = $this->session->userdata("currentuser");
			$data["cost"] = $this->session->userdata("DecimalsCost");
			$data["price"] = $this->session->userdata("DecimalsPrice");
			$data["quantity"] = $this->session->userdata("DecimalsQuantity");
			$data["tax"] = $this->session->userdata("DecimalsTax");
			$data['main_content'] = "backoffice/backoffice_new_item_inventory_page";
			$this->load->view('backoffice_templates/backoffice_template', $data);

		}else{
			$data['error'] = "Your session has already expired!";
			$this->session->set_userdata($data);
			redirect('backoffice/login');
		}
	}


	function edititem(){
		if($this->_is_logged_in()){
			/*Breadcrumb*/
			$data['breadcrumb'] = '<ol class="breadcrumb" style="margin:0;">
									  <li><a href="'.base_url("backoffice").'">Dashboard</a></li>
									  <li><a href="'.base_url("backoffice/inventory").'">Inventory</a></li>
									  <li class="active">Edit</li>
									</ol>';
			$data["storename"] = $this->displaystore();
			$data["currentuser"] = $this->session->userdata("currentuser");
			$data['main_content'] = "backoffice/backoffice_edit_item_inventory_page";
			$this->load->view('backoffice_templates/backoffice_template', $data);

		}else{
			$data['error'] = "Your session has already expired!";
			$this->session->set_userdata($data);
			redirect('backoffice/login');
		}
	}


	function save_new_item(){
		if($_POST){
			$storeid = $this->session->userdata("storeunique");
			$itemnumber = $this->input->post('itemnumber');
			$partnumber = $this->input->post('partnumber');
			$description = $this->input->post('description');
			$supplier = $this->input->post('supplier');
			$supplierpart = $this->input->post('supplierpart');
			$brand = $this->input->post('brand');
			$category = $this->input->post('maincat');
			$subcategory = $this->input->post('subcat');
			$cost = $this->input->post('cost');
			$price = $this->input->post('price');
			$quantity = $this->input->post('quantity');

			//var_dump($subcategory); die();
			if($supplier == ''){
				$supplier=NULL;
			}

			if($brand == ''){
				$brand=NULL;
			}

			if($cost == ''){
				$cost='0.00';
			}

			if($price == ''){
				$price = '0.00';
			}

			if($subcategory == ''){
				$subcategory=NULL;
			}

			if($quantity == ''){
				$quantity=0;
			}

			$current_user = $this->session->userdata("userid");
			//var_dump($subcategory); die();

			$to_item = array(
				"Item" => $itemnumber,
				"Part" => $partnumber,
				"Description" => $description,
				"SupplierUnique" => $supplier,
				"SupplierPart" => $supplierpart,
				"BrandUnique" => $brand,
				"CategoryUnique" => $subcategory,
				"Cost" => $cost,
				"Cost_Extra" => 0,
				"Cost_Freight" => 0,
				"Cost_Duty" => 0,
				"ListPrice" => 0,
				"price1" => 0,
				"price2" => 0,
				"price3" => 0,
				"price4" => 0,
				"price5" => 0,
				"CreatedBy" => $current_user
			);
			$itemunique = $this->backoffice_model->new_item($to_item);

			/*
			$to_item_price = array(
				"ItemUnique" => $itemunique,
				"ScheduleLevel" => 0,
				"RScheduleType" => 'F',
				"SScheduleType" => 'F',
				"RegularPrice" => $price,
				"SalePrice" => $price,
				"QuanDisc" => 0,
				"Location" => $storeid,
				"StartDate" => date('Y-m-d'),
				"EndDate" => '1000-01-01',
				"CreatedBy" => $current_user,
				"StartTime" => date("h:i:s")
			);
			$this->backoffice_model->new_item_price($to_item_price);
			*/

			$to_item_stock_line = array(
				"ItemUnique" => $itemunique,
				"LocationUnique" => $storeid,
				"Type" => 1,
				"Quantity" => $quantity,
				"CreatedBy" => $current_user
			);
			$this->backoffice_model->new_item_stock_line($to_item_stock_line);

			$checkbox = $this->input->post("taxchecked");
			$checkedarray = explode(',', $checkbox);
			if($checkbox){
				foreach($checkedarray as $checked){
					$item_tax[] = array(
						"ItemUnique" => $itemunique,
						"TaxUnique" => $checked,
						"Status" => 1,
						"CreatedBy" => $current_user
					);
				}
				$this->backoffice_model->new_item_tax($item_tax);
			}
		}

		$json["success"] = true;
		$json["msg"] = "Data saved.";
		echo json_encode($json);

	}

	function supplier_list(){ //supplier() changed to supplier_list() 6/16/2015
		$json = array();
		$result = $this->backoffice_model->supplier_listdata();
		if($result){
			foreach($result as $row){
				$unique = $row["Unique"];
				$json[$unique]["supplier"] = $row["Company"];
			}
		}
		echo json_encode($json);
	}

	function edit_supplier(){
		$json = array();
		$result = $this->backoffice_model->supplier_listdata();
		if($result){
			foreach($result as $row){
				
				$json[] = array(
					"Unique" => $row["Unique"],
					"Supplier" => $row["Company"]
				);
				
				/*
				$unique = $row["Unique"];
				$json[$unique]["Unique"] = $row["Unique"];
				$json[$unique]["Supplier"] = ucwords(strtolower($row["Company"]));
				*/
			}
		}
		echo json_encode($json);
	}

	function test_supplier(){
		$json = array();
		$result = $this->backoffice_model->supplier_listdata();
		if($result){
			foreach($result as $row){
				$json[] = array("Unique" => $row["Unique"],
								"Supplier" => $row["Company"]
						  );
			}
		}
		echo json_encode($json);
	}

	function brand_list(){ //brand change to brand_list 06/17/2015
		$json = array();
		$result = $this->backoffice_model->brand();
		if($result){
			foreach($result as $row){
				$unique = $row["Unique"];
				$json[$unique]["brand"] = $row["Name"];
			}
		}
		echo json_encode($json);
	}


	function edit_brand(){
		$json = array();
		$result = $this->backoffice_model->brand();
		if($result){
			foreach($result as $row){
				
				$json[] = array(
					"Unique" => $row["Unique"],
					"Brand" => $row["Name"]
				);
				
				/*
				foreach($result as $row){
				$unique = $row["Unique"];
				$json[$unique]["Brand"] = $row["Name"];
				}
				*/
			}
		}
		echo json_encode($json);
	}

	function maincat(){
		$json = array();
		$result = $this->backoffice_model->maincat();
		if($result){
			foreach($result as $row){
				/*
				$unique = $row["Unique"];
				$json[$unique]["maincat"] = $row["MainName"];
				*/
				$json[] = array(
					"Unique" => $row["Unique"],
					"MainName" => $row["MainName"]
				);
			}
		}
		echo json_encode($json);
	}

	function subcat(){
		$json = array();
		$maincatid = $this->input->post('maincatid');
		$result = $this->backoffice_model->maincat_search($maincatid);
		if($result){
			foreach($result as $row){
				/*
				$unique = $row["Unique"];
				$json[$unique]["subcat"] = $row["Name"];
				*/
				$json[] = array(
					"Unique" => $row["Unique"],
					"Name" => $row["Name"]
				);
			}
		}
		echo json_encode($json);
	}

	function sync_item_stock(){
		$result = $this->backoffice_model->syncitemstock();
		if($result){
			foreach($result as $row){
				$data[] = array(
					"ItemUnique" => $row["ItemUnique"],
					"StoreUnique" => $row["Store"],
					"Types" => 1,
					"Quantity" => $row["Quantity"]
				);
			}
			$result = $this->backoffice_model->save_sync_item_stock($data);
		}
		echo "Done";
	}

	function sync_maincat(){
		$result = $this->backoffice_model->wwmaincat();
		if($result){
			foreach($result as $row){
				$number = $row["Number"];
				$mainname = $row["MainName"];
				$catstart = $row["CatStart"];
				$catsend = $row["CatEnd"];

				$data[] = array(
					"WWUnique" => $number,
					"MainName" => $mainname,
					"CatStart" => $catstart,
					"CatEnd" => $catsend
				);
			}
			$this->backoffice_model->save_category_main($data);
		}
	}

	function item_information(){
		$json = array();
		$storeid = $this->session->userdata("storeunique");
		$itemid = $this->input->post("itemid");
		$result = $this->backoffice_model->iteminfo($itemid, $storeid);
		if($result){
			$row = $result;
			$json["itemnumber"] = trim($row["Item"]);
			$json["partnumber"] = trim($row["Part"]);
			$json["description"] = trim($row["Description"]);
			$json["supplier"] = trim($row["Supplier"]);
			$json["supplierpart"] = trim($row["SupplierPart"]);
			$json["brand"] = trim($row["Brand"]);
			$json["category"] = trim($row["Category"]);
			$json["subcat"] = trim($row["SubCategory"]);
			$json["cost"] = trim(number_format($row["Cost"],2));
			$json["price"] = trim(number_format($row["Price"],2));
			$json["quantity"] = trim(number_format($row["Quantity"]));

			$json["success"] = true;
		}
		echo json_encode($json);
	}

	function update_inventory_item(){
		$json = array();

		$processed_array = array();
		$itemunique = $this->input->post("itemunique");
		$item = $this->input->post("itemnumber");
		$part = $this->input->post("partnumber");
		$description = $this->input->post("description");
		$supplierpart = $this->input->post("supplierpart");
		$supplier = $this->input->post("supplier");
		$brand = $this->input->post("brand");
		$category = $this->input->post("category");
		$cost = $this->input->post("cost");
		$costextra = $this->input->post("costextra");
		$costfreight =$this->input->post("costfreight");
		$costduty = $this->input->post("costduty");
		$price = $this->input->post("price");
		$price2 = $this->input->post("price2");
		$price3 = $this->input->post("price3");
		$price4 = $this->input->post("price4");
		$price5 = $this->input->post("price5");
		$saleprice = $this->input->post("saleprice");

		$userid = $this->session->userdata("userid");
		$decimalscost = $this->session->userdata("DecimalsCost");
		$decimalsprice = $this->session->userdata("DecimalsPrice");
		$decimalsquantity = $this->session->userdata("DecimalsQuantity");
		$decimalstax = $this->session->userdata("DecimalsTax");

		if($supplier == "null"){
		  $supplier=NULL;
		}

		if($brand == "null"){
		  $brand=NULL;
		}

		if($category=="null"){
		  $category=NULL;
		}

		if(!isset($cost)){
			$cost = 0;
		}
		if(!isset($costduty)){
			$costduty = 0;
		}
		if(!isset($costextra)){
			$costextra = 0;
		}
		if(!isset($costfreight)){
			$costextra = 0;
		}


		/*Item Processing*/
		$itemdata[] = array(
			"Unique" => $itemunique,
			"Item" => $item,
			"Part" => $part,
			"Description" => $description,
			"SupplierUnique" => $supplier,
			"SupplierPart" => $supplierpart,
			"BrandUnique" => $brand,
			"CategoryUnique" => $category,
			"Cost" => $cost,
			"Cost_Extra" => $costextra,
			"Cost_Freight" => $costfreight,
			"Cost_Duty" =>$costduty,
			"ListPrice" => $price,
			"price1" => $saleprice,
			"price2" => $price2,
			"price3" => $price3,
			"price4" => $price4,
			"price5" => $price5,
			"Updated" => date("Y-m-d H:i:s"),
 			"UpdatedBy" => $this->session->userdata("userid")
		);

		$getitemdata = $this->backoffice_model->get_item_data($itemunique);
		$table_item = $this->fields("item", $getitemdata);
		$processed_array = $this->processing_array("item", $itemdata, $table_item, "Unique");
		$result = $this->backoffice_model->update_inventory("item", $itemunique, $processed_array, $userid, "Unique");

		$checkedbox = $this->input->post("taxchecked");
		$checkedarray = explode(',', $checkedbox);
		if($checkedbox){
			foreach($checkedarray as $check_id){
				$exist_check_unique = $this->backoffice_model->check_tax_exists($itemunique, $check_id);
				if($exist_check_unique){
					$status_check_zero = $this->backoffice_model->check_tax_exists_status_zero($itemunique, $check_id);
					if($status_check_zero){
						$check_update = array(
							"Status" => 1,
							"Updated" => date("Y-m-d H:i:s"),
							"UpdatedBy" => $this->session->userdata("userid")
						);
						$this->backoffice_model->update_tax_status($exist_check_unique, $check_update);
					}//else do nothing
				}else{
					$new_tax = array(
						"ItemUnique" => $itemunique,
						"TaxUnique" => $check_id,
						"Status" => 1,
						"CreatedBy" => $this->session->userdata("userid")
					);
					$this->backoffice_model->save_new_tax($new_tax);
				}
			}
		}


		$uncheckedbox = $this->input->post("taxunchecked");
		$uncheckedarray = explode(',', $uncheckedbox);
		if($uncheckedbox){
			foreach($uncheckedarray as $uncheck_id){
				$exist_uncheck_unique = $this->backoffice_model->check_tax_exists($itemunique, $uncheck_id);
				if($exist_uncheck_unique){
					$status_uncheck_zero = $this->backoffice_model->check_tax_exists_status_zero($itemunique, $uncheck_id);
					if(!$status_uncheck_zero){
						$uncheck_update = array(
							"Status" => 0,
							"Updated" => date("Y-m-d H:i:s"),
							"UpdatedBy" => $this->session->userdata("userid")
						);
						$this->backoffice_model->update_tax_status($exist_uncheck_unique, $uncheck_update);
					}
				}
			}
		}

		if($result){
			$json["success"] = true;
		}else{
			$json["success"] = false;
		}

		echo json_encode($json);
	}


	function save_item(){
		$json = array();
		$mainlocation = $this->input->post("mainlocationid");
		$locationid = $this->input->post("locationid");
		$item = $this->input->post("itemnumber");
		$part = $this->input->post("partnumber");
		$description = $this->input->post("description");
		$supplierpart = $this->input->post("supplierpart");
		$supplier = $this->input->post("supplier");
		$brand = $this->input->post("brand");
		$category = $this->input->post("category");
		$cost = $this->input->post("cost");
		$costextra = $this->input->post("costextra");
		$costfreight =$this->input->post("costfreight");
		$costduty = $this->input->post("costduty");
		$price = $this->input->post("price");
		$price1 = $this->input->post("price1");
		$price2 = $this->input->post("price2");
		$price3 = $this->input->post("price3");
		$price4 = $this->input->post("price4");
		$price5 = $this->input->post("price5");
		$quantity = $this->input->post("quantity");
		$transdate = $this->input->post("transdate");
		$transtime = $this->input->post("transtime");
		$qtycomment = $this->input->post("qtycomment");
		$barcode = $this->input->post("barcode");

		if($supplier == ''){
		  $supplier=NULL;
		}

		if($brand == ''){
		  $brand=NULL;
		}

		if($category == ''){
		  $category=NULL;
		}

		#########*Item Table*#####################################
		$item_array = array(
			"Item" => $item,
			"Part" => $part,
			"Description" => $description,
			"SupplierUnique" => $supplier,
			"SupplierPart" => $supplierpart,
			"BrandUnique" => $brand,
			"CategoryUnique" => $category,
			"Cost" => $cost,
			"Cost_Extra" => $costextra,
			"Cost_Freight" => $costfreight,
			"Cost_Duty" => $costduty,
			"ListPrice" => $price,
			"price1" => $price1,
			"price2" => $price2,
			"price3" => $price3,
			"price4" => $price4,
			"price5" => $price5,
			"Status" => 1,
			"CreatedBy" => $this->session->userdata("userid")
		);
		$itemunique = $this->backoffice_model->add_save_new_item($item_array);
		#########*End Item Table*#################################
		
		
		#########*Item Stock Line Table*###########################
		$stockqty_array = array(
			"ItemUnique" => $itemunique,
			"LocationUnique" => $locationid,
			"Type" => 1,
			"Quantity" => $quantity,
			"TransactionDate" => $transdate." ".$transtime,
			"Comment" => $qtycomment,
			"CreatedBy" => $this->session->userdata("userid"),
			"trans_date" => date('Y-m-d', strtotime($transdate)),
			"status" => 1
		);
		$result = $this->backoffice_model->add_save_new_item_stock($stockqty_array);
		########*End Item Stock Line Table*######################

		
		########*Item Tax Table*###################################
		$checkedbox = $this->input->post("taxchecked");
		$checkedarray = explode(',', $checkedbox);
		if($checkedbox){
			foreach($checkedarray as $check_id){
				$new_tax = array(
					"ItemUnique" => $itemunique,
					"TaxUnique" => $check_id,
					"Status" => 1,
					"CreatedBy" => $this->session->userdata("userid")
				);
				$this->backoffice_model->save_new_tax($new_tax);
			}
		}
		########*End Tax Table*####################################
		
		########*Barcode*##########################################
		$data = array(
			"ItemUnique" => $itemunique,
			"Barcode" => $barcode,
			"Status" => 1,
			"CreatedBy" => $this->session->userdata("userid")
		);
		$this->backoffice_model->insert("item_barcode", $data);
		###########################################################
		
		if($result){
			$json["success"] = true;
		}else{
			$json["success"] = false;
		}

		print json_encode($json);
	}



	function processing_array($table, $data1, $data2, $usedfield){
		$update_items = array();
		foreach($data1 as $key => $val){
			$found_unique = $this->SearchForUniqueUpdate($val[$usedfield], $usedfield, $data2); //Slow to this part.
			if(isset($found_unique)){
				if ( $u = array_diff_assoc($data1[$key], $found_unique) ){
					$ref = $val[$usedfield];
					$u[$usedfield] = $ref;
					$update_items[$key] = $u;
				}
			}
		}
		return $update_items;
	}

	function SearchForUniqueUpdate($id, $field, $array) {
	   foreach ($array as $key => $val) {
		   if ($val[$field] == $id)
			   return $array[$key];
	   }
	   return NULL;
	}


	function fields($table, $data){
		//var_dump($data); die();
		$field_arr = array();
		if($table == "item"){
			foreach($data as $row){
				$field_arr[] = array(
					"Unique" => trim($row["Unique"]),
					"Item" => trim($row["Item"]),
					"Part" => trim($row["Part"]),
					"Description" => trim($row["Description"]),
					"SupplierUnique" => trim($row["SupplierUnique"]),
					"BrandUnique" => trim($row["BrandUnique"]),
					"CategoryUnique" => trim($row["CategoryUnique"]),
					"Cost" => trim(number_format($row["Cost"],6)),
					"Cost_Extra" => trim(number_format($row["Cost_Extra"],6)),
					"Cost_Freight" => trim(number_format($row["Cost_Freight"],6)),
					"Cost_Duty" => trim(number_format($row["Cost_Duty"],6))
				);
			}
		}else if($table == "item_price"){
			foreach($data as $row){
				$field_arr[] = array(
					"ItemUnique" => trim($row["ItemUnique"]),
					"RegularPrice" => trim($row["RegularPrice"])
				);
			}
		}

		return $field_arr;
	}

	function itemdelete(){
		$json = array();
		$itemunique = $this->input->post("itemid");
		$data = array(
			"Status" => 0
		);
		$result = $this->backoffice_model->delete_item("item", $data, $itemunique, "Unique");
		if($result){
			$json["success"] = true;
		}else{
			$json["success"] = false;
		}
		echo json_encode($json);
	}

	function itemrestore(){
		$json = array();
		$itemunique = $this->input->post("itemid");
		$data = array(
			"Status" => 1
		);
		$result = $this->backoffice_model->restore_item("item", $data, $itemunique, "Unique");
		if($result){
			$json["success"] = true;
		}else{
			$json["success"] = false;
		}
		echo json_encode($json);
	}


	function DateTime(){
		$date_time = date("Y-m-d h:i:s");
		return $date_time;
	}

	function load_item_stock_line($itemunique, $locationid){
		$json = array();
		$newqty=0;
		$location=0;
		$result = $this->backoffice_model->item_stock_line_by_itemunique($itemunique, $locationid);
		$decimalscost = $this->session->userdata("DecimalsCost");
		$decimalsprice = $this->session->userdata("DecimalsPrice");
		$decimalsquantity = $this->session->userdata("DecimalsQuantity");
		$decimalstax = $this->session->userdata("DecimalsTax");
		if($result){
			foreach($result as $row){
				$transdate = $row["TransactionDate"];
				if($transdate){
					$transdate = date("m/d/Y h:i A",strtotime($transdate));
				}else{
					$transdate = '';
				}

				/*
				if($row["LocationUnique"] != $location){
					$location = $row["LocationUnique"];
					$newqty = $row["Quantity"];
				}else{
					$newqty += $row["Quantity"];
				}
				*/


				$json[] = array(
					"Unique" => $row["Unique"],
					"TransactionDate" => $transdate,
					"Location" => $row["LocationName"],
					"Type" => $row["Description"],
					"Quantity" => number_format($row["Quantity"], $decimalsquantity),
					"Total" => number_format($row["Total"], $decimalsquantity),
					//"Total" => number_format($newqty, $decimalsquantity),
					"Comment" => trim($row["Comment"])
				);
			}
		}
		echo json_encode($json);
	}

	function total_adjustqty(){
		$json = array();
		$itemunique = $this->input->post("itemid");
		$store = $this->input->post("locationid");
		$decimalscost = $this->session->userdata("DecimalsCost");
		$decimalsprice = $this->session->userdata("DecimalsPrice");
		$decimalsquantity = $this->session->userdata("DecimalsQuantity");
		$decimalstax = $this->session->userdata("DecimalsTax");
		if($store){
			$location = $store;
		}else{
			$location = $this->session->userdata("storeunique");
		}
		$result = $this->backoffice_model->total_adjqty($itemunique, $location);

		if($result){
			$row=$result;
			$json["Quantity"] = number_format($row["Quantity"], $decimalsquantity);
		}else{
			$json["Quantity"] = number_format(0, $decimalsquantity);
		}

		$json["success"] = true;

		echo json_encode($json);
	}


	function save_new_stockqty(){
		$json = array();
		$decimalscost = $this->session->userdata("DecimalsCost");
		$decimalsprice = $this->session->userdata("DecimalsPrice");
		$decimalsquantity = $this->session->userdata("DecimalsQuantity");
		$decimalstax = $this->session->userdata("DecimalsTax");
		$itemunique = $this->input->post("itemid");
		$quantity = $this->input->post("quantity");
		$comment = $this->input->post("comment");
		$setdate = $this->input->post("setdate");
		$settime = $this->input->post("settime");
		$locationid = $this->input->post("locationid");

		$type = 4;
		$data = array(
			"ItemUnique" => $itemunique,
			"LocationUnique" => $locationid,
			"Type" => $type,
			"Quantity" => number_format($quantity, $decimalsquantity),
			//"TransactionDate" => date("Y-m-d H:i:s"),
			"TransactionDate" => date("Y-m-d",strtotime($setdate))." ".date("H:i:s",strtotime($settime)),
			"Comment" => $comment,
			"trans_date" => date("Y-m-d", strtotime($setdate)),
			"status" => 1
		);

		//var_dump($data);
		//die();

		$result = $this->backoffice_model->save_data("item_stock_line",$data);
		if($result){
			$json["success"] = true;
		}else{
			$json["success"] = false;
		}

		echo json_encode($json);
	}

	function load_tax(){
		$json = array();
		$result = $this->backoffice_model->alltax();
		$decimalstax = $this->session->userdata("DecimalsTax");
		if($result){
			foreach($result as $row){
				$unique = $row["Unique"];
				$json[$unique]["itemtax"] = $row["Description"];
				$json[$unique]["Code"] = $row["Code"];
				$json[$unique]["Rate"] = number_format($row["Rate"], $decimalstax);
				$json[$unique]["Basis"] = $row["Basis"];
				$json[$unique]["Checked"] = $row["Default"];
			}
		}
		echo json_encode($json);
	}

	function gettaxval(){
		$json = array();
		$itemunique = $this->input->post("itemid");
		$result = $this->backoffice_model->get_tax_value($itemunique);
		if($result){
			foreach($result as $row){
				$unique = $row["Unique"];
				$json[$unique]["Tax"] = $row["TaxUnique"];
				$json[$unique]["Status"] = $row["Status"];
			}
		}
		echo json_encode($json);
	}
	
	function checkedbox(){
		$json = array();
		$itemunique = $this->input->post("itemid");
		$taxid = $this->input->post("taxid");
		$status = $this->input->post("status");
		$tax_unique = $this->backoffice_model->check_tax_exists($itemunique, $taxid);
		if($tax_unique > 0){
			$data=array(
				"TaxUnique" => $taxid,
				"Status" => $status,
				"Updated" => date("Y-m-d h:i:s"),
				"UpdatedBy" => $this->session->userdata("userid")
			);
			$result = $this->backoffice_model->update_tax_status($tax_unique, $data);
		}else{
			$data=array(
				"ItemUnique" => $itemunique,
				"TaxUnique" => $taxid,
				"Status" => 1,
				"CreatedBy" => $this->session->userdata("userid")
			);
			$result = $this->backoffice_model->save_new_tax($data);
		}
		$json["success"] = true;
		echo json_encode($json);
	}

	function adj_select_location($itemunique, $locationid){
		$json = array();
		$result = $this->backoffice_model->adj_qty_by_location($itemunique, $locationid);
		$storeunique = $this->session->userdata("storeunique");
		$decimalscost = $this->session->userdata("DecimalsCost");
		$decimalsprice = $this->session->userdata("DecimalsPrice");
		$decimalsquantity = $this->session->userdata("DecimalsQuantity");
		$decimalstax = $this->session->userdata("DecimalsTax");
		if($result){
			foreach($result as $row){
				$transdate = $row["TransactionDate"];
				if($transdate){
					$transdate = date("m/d/Y h:i A",strtotime($transdate));
				}else{
					$transdate = '';
				}

				$json[] = array(
					"Unique" => $row["Unique"],
					"TransactionDate" => $transdate,
					"Location" => $row["LocationName"],
					"Type" => $row["Description"],
					"Quantity" => number_format($row["Quantity"], $decimalsquantity),
					"Total" => number_format($row["Total"], $decimalsquantity),
					"Comment" => trim($row["Comment"])
				);
			}
		}
		echo json_encode($json);
	}

	function load_inventory_by_location($storeunique){
		$json = array();
		$decimalscost = $this->session->userdata("DecimalsCost");
		$decimalsprice = $this->session->userdata("DecimalsPrice");
		$decimalsquantity = $this->session->userdata("DecimalsQuantity");
		$decimalstax = $this->session->userdata("DecimalsTax");
		$result = $this->backoffice_model->inventory_by_location($storeunique);
		if($result){
			foreach($result as $row){
				$json[]=array(
							"Unique" => trim($row["Unique"]),
							"Item" => trim($row["Item"]),
							"Part" => trim($row["Part"]),
							"Description" => trim($row["Description"]),
							"Size" => trim($row["Size"]),
							"Color" => trim($row["Color"]),
							"Other" => trim($row["Other"]),
							"SupplierId" => trim($row["SupplierId"]),
							"Supplier" => trim($row["Supplier"]),
							"SupplierPart" => trim($row["SupplierPart"]),
							"BrandId" => trim($row["BrandId"]),
							"Brand" => trim($row["Brand"]),
							"CatMainId" => trim($row["CatMainId"]),
							"Category" => trim($row["Category"]),
							"SubCategory" => trim($row["SubCategory"]),
							"Cost" => trim(number_format($row["Cost"],$decimalscost)),
							"CostExtra" => trim(number_format($row["Cost_Extra"],$decimalscost)),
							"CostFreight" => trim(number_format($row["Cost_Freight"],$decimalscost)),
							"CostDuty" => trim(number_format($row["Cost_Duty"],$decimalscost)),
							"CostLanded" => trim(number_format($row["CostLanded"],$decimalscost)),
							"ListPrice" => trim(number_format($row["ListPrice"],$decimalsprice)),
							"price1" => trim(number_format($row["price1"],$decimalsprice)),
							"price2" => trim(number_format($row["price2"],$decimalsprice)),
							"price3" => trim(number_format($row["price3"],$decimalsprice)),
							"price4" => trim(number_format($row["price4"],$decimalsprice)),
							"price5" => trim(number_format($row["price5"],$decimalsprice)),
							"Quantity" => trim(number_format($row["Quantity"],$decimalsquantity))
						);
			}
		}
		echo json_encode($json);
	}


	function test2(){
		$data['main_content'] = 'posadmin/test2';
		$this->load->view('backoffice_templates/backoffice_template', $data);
	}

	function testpage(){
		$data['main_content'] = 'posadmin/test';
		$this->load->view('backoffice_templates/backoffice_template', $data);
	}

	function test(){
		var_dump($this->session->userdata());
	}

	function test_location(){
		$json = array();
		$result = $this->backoffice_model->stores(false);
		if($result){
			foreach($result as $row){
				$storeunique = $row["Unique"];
				$description = $row["LocationName"];
				$json[] = array("locationunique" => $storeunique, "description" => $description);
			}
		}
		//var_dump($json); die();
		echo json_encode($json);
	}

	function test_get_location(){
		$json = array();
		$result = $this->backoffice_model->location_test_load();
		if($result){
			$row = $result;
			$storeunique = $row["Unique"];
			$description = $row["LocationName"];
			$json[] = array("locationunique" => $storeunique, "description" => $description);
		}
		echo json_encode($json);
	}

	function location_array(){
		$result = $this->backoffice_model->stores(false);
		if($result){
			foreach($result as $row){
				$storeunique = $row["Unique"];
				$description = $row["LocationName"];
				$array[] = array($row["LocationName"]);
			}
		}
		//var_dump($array); die();
		return $array;
	}


	function customer(){
		if($this->_is_logged_in()){
			$data['allzip'] = $this->load_zipcode_prepopulate();
			$data['allcities'] = $this->load_city_prepopulate();
			$data['allisland'] = $this->load_island_prepopulate();
			$data['allstates'] = $this->load_state_prepopulate();
			$data['allcountries'] = $this->load_country_prepopulate();
			$data["storename"] = $this->displaystore();
			$data["currentuser"] = $this->session->userdata("currentuser");
			$data["zipcode"] = $this->session->userdata("CustomerZipCode");
			$data['main_content'] = "backoffice/backoffice_customer_page";
			$this->load->view('backoffice_templates/backoffice_template', $data);
		}else{
			$data['error'] = "Your session has already expired!";
			$this->session->set_userdata($data);
			redirect('backoffice/login');
		}
	}

	function load_customer(){
		$json = array();

		$result = $this->backoffice_model->customer();
		if($result){
			foreach($result as $row){
				$json[] = array(
					"Unique" => $row["Unique"],
					"FirstName" => $row["FirstName"],
					"LastName" => $row["LastName"],
					"Company" => $row["Company"],
					"Address1" => $row["Address1"],
					"Address2" => $row["Address2"],
					"City" => $row["City"],
					"State" => $row["State"],
					"Zip" => $row["Zip"],
					"Country" => $row["Country"],
					"County" => $row["County"],
					"Phone1" => $row["Phone1"],
					"Phone2" => $row["Phone2"],
					"Phone3" => $row["Phone3"],
					"Email" => $row["Email"],
					"Fax" => $row["Fax"],
					"Website" => $row["Website"],
					"Custom1" => $row["Custom1"],
					"Custom2" => $row["Custom2"],
					"Custom3" => $row["Custom3"],
					"Note" => $row["Note"]
				);
			}
		}

		echo json_encode($json);
	}


	function load_supplier(){
		$json = array();
		$result = $this->backoffice_model->supplier();
		if($result){
			foreach($result as $row){
				$json[] = array(
					"Unique" => $row["Unique"],
					"FirstName" => $row["FirstName"],
					"LastName" => $row["LastName"],
					"Company" => $row["Company"],
					"Address1" => $row["Address1"],
					"Address2" => $row["Address2"],
					"City" => $row["City"],
					"State" => $row["State"],
					"Zip" => $row["Zip"],
					"County" => $row["County"],
					"Country" => $row["Country"],
					"Phone1" => $row["Phone1"],
					"Phone2" => $row["Phone2"],
					"Phone3" => $row["Phone3"],
					"Email" => $row["Email"],
					"Fax" => $row["Fax"],
					"Website" => $row["Website"],
					"Custom1" => $row["Custom1"],
					"Custom2" => $row["Custom2"],
					"Custom3" => $row["Custom3"],
					"Note" => $row["Note"]
				);
			}
		}
		echo json_encode($json);
	}

	function update_customer_info(){
		$json = array();
		$customerid = $this->input->post("customerid");
		$fname = $this->input->post("fname");
		$lname = $this->input->post("lname");
		$company = $this->input->post("company");
		$address1 = $this->input->post("address1");
		$address2 = $this->input->post("address2");
		$city = $this->input->post("city");
		$state = $this->input->post("state");
		$zip = $this->input->post("zip");
		$country = $this->input->post("country");
		$county = $this->input->post("county");
		$phone1 = $this->input->post("phone1");
		$phone2 = $this->input->post("phone2");
		$phone3 = $this->input->post("phone3");
		$email = $this->input->post("email");
		$fax = $this->input->post("fax");
		$website = $this->input->post("website");
		$custom1 = $this->input->post("custom1");
		$custom2 = $this->input->post("custom2");
		$custom3 = $this->input->post("custom3");
		$note = $this->input->post("note");
		
		if($zip == "null"){
			$zip = NULL;
		}
		if($city == "null"){
			$city = NULL;	
		}
		if($state == "null"){
			$state = NULL;
		}
		if($county == "null"){
			$county = NULL;
		}
		if($country == "null"){
			$country = NULL;
		}
		
		$infoarray = array(
			"FirstName" => $fname,
			"LastName" => $lname,
			"Company" => $company,
			"Address1" => $address1,
			"Address2" => $address2,
			"City" => $city,
			"State" => $state,
			"Zip" => $zip,
			"Country" => $country,
			"County" => $county,
			"Phone1" => $phone1,
			"Phone2" => $phone2,
			"Phone3" => $phone3,
			"Email" => $email,
			"Fax" => $fax,
			"Website" => $website,
			"Custom1" => $custom1,
			"Custom2" => $custom2,
			"Custom3" => $custom3
		);

		$result = $this->backoffice_model->update_customer_information($infoarray, $customerid);

		//-->Find Reference Unique
		$find_field = array(
			"ReferenceUnique" => $customerid,
			"Type" => "customer"
		);
		$noteid = $this->backoffice_model->check_note_exist($find_field);
		if($noteid > 0){
			$notearray = array(
				"Note" => trim($note),
				"Updated" => date("Y-m-d H:i:s"),
				"UpdatedBy" => $this->session->userdata("userid")
			);
			$this->backoffice_model->update_note($customerid, $notearray, "customer");
		}else{
			$notearray = array(
				"ReferenceUnique" => $customerid,
				"Note" => trim($note),
				"Type" => "customer",
				"Status" => 1,
				"CreatedBy" => $this->session->userdata("userid")
			);
			$this->backoffice_model->new_note($notearray);
		}



		if($result){
			$json["success"] = true;
		}else{
			$json["success"] = false;
		}

		echo json_encode($json);
	}


	function update_supplier_info(){
		$json = array();
		$supplierid = $this->input->post("supplierid");
		$fname = $this->input->post("fname");
		$lname = $this->input->post("lname");
		$company = $this->input->post("company");
		$address1 = $this->input->post("address1");
		$address2 = $this->input->post("address2");
		$city = $this->input->post("city");
		$state = $this->input->post("state");
		$zip = $this->input->post("zip");
		$country = $this->input->post("country");
		$county = $this->input->post("county");
		$phone1 = $this->input->post("phone1");
		$phone2 = $this->input->post("phone2");
		$phone3 = $this->input->post("phone3");
		$email = $this->input->post("email");
		$fax = $this->input->post("fax");
		$website = $this->input->post("website");
		$custom1 = $this->input->post("custom1");
		$custom2 = $this->input->post("custom2");
		$custom3 = $this->input->post("custom3");
		$note = $this->input->post("note");
		
		if($zip == "null"){
			$zip = NULL;
		}
		if($city == "null"){
			$city = NULL;	
		}
		if($state == "null"){
			$state = NULL;
		}
		if($county == "null"){
			$county = NULL;
		}
		if($country == "null"){
			$country = NULL;
		}

		$infoarray = array(
			"FirstName" => $fname,
			"LastName" => $lname,
			"Company" => $company,
			"Address1" => $address1,
			"Address2" => $address2,
			"City" => $city,
			"State" => $state,
			"Zip" => $zip,
			"Country" => $country,
			"County" => $county,
			"Phone1" => $phone1,
			"Phone2" => $phone2,
			"Phone3" => $phone3,
			"Email" => $email,
			"Fax" => $fax,
			"Website" => $website,
			"Custom1" => $custom1,
			"Custom2" => $custom2,
			"Custom3" => $custom3,
			"Updated" => date("Y-m-d H:i:s"),
			"UpdatedBy" => $this->session->userdata("userid")
		);

		$result = $this->backoffice_model->update_supplier_information($infoarray, $supplierid);

		//-->Find Reference Unique
		$find_field = array(
			"ReferenceUnique" => $supplierid,
			"Type" => "supplier"
		);
		$noteid = $this->backoffice_model->check_note_exist($find_field);

		if($noteid > 0){
			$notearray = array(
				"Note" => trim($note),
				"Updated" => date("Y-m-d H:i:s"),
				"UpdatedBy" => $this->session->userdata("userid")
			);
			$this->backoffice_model->update_note($supplierid, $notearray, "supplier");
		}else{
			$notearray = array(
				"ReferenceUnique" => $supplierid,
				"Note" => trim($note),
				"Type" => "supplier",
				"Status" => 1,
				"CreatedBy" => $this->session->userdata("userid")
			);
			$this->backoffice_model->new_note($notearray);
		}

		if($result){
			$json["success"] = true;
		}else{
			$json["success"] = false;
		}

		echo json_encode($json);
	}


	function customerdelete(){
		$json = array();
		$customerid = $this->input->post("custid");
		$data = array(
			"Status" => 0,
			"Updated" => date("Y-m-d H:i:s"),
			"UpdatedBy" => $this->session->userdata("userid")
		);
		$result = $this->backoffice_model->customer_delete_info($data, $customerid);
		if($result){
			$json["success"] = true;
		}else{
			$json["success"] = false;
		}

		echo json_encode($json);
	}


	function supplierdelete(){
		$json = array();
		$suppid = $this->input->post("suppid");
		$data = array(
			"Status" => 0,
			"Updated" => date("Y-m-d H:i:s"),
			"UpdatedBy" => $this->session->userdata("userid")
		);
		$result = $this->backoffice_model->supplier_delete_info($data, $suppid);
		if($result){
			$json["success"] = true;
		}else{
			$json["success"] = false;
		}

		echo json_encode($json);
	}

	function customerrestore(){
		$json = array();
		$customerid = $this->input->post("custid");
		$data = array(
			"Status" => 1,
			"Updated" => date("Y-m-d H:i:s"),
			"UpdatedBy" => $this->session->userdata("userid")
		);
		$result = $this->backoffice_model->customer_restore_info($data, $customerid);
		if($result){
			$json["success"] = true;
		}else{
			$json["success"] = false;
		}

		echo json_encode($json);
	}

	function supplierrestore(){
		$json = array();
		$supplierid = $this->input->post("suppid");
		$data = array(
			"Status" => 1,
			"Updated" => date("Y-m-d H:i:s"),
			"UpdatedBy" => $this->session->userdata("userid")
		);
		$result = $this->backoffice_model->supplier_restore_info($data, $supplierid);
		if($result){
			$json["success"] = true;
		}else{
			$json["success"] = false;
		}

		echo json_encode($json);
	}

	function add_customer_info(){
		$json = array();
		$fname = $this->input->post("fname");
		$lname = $this->input->post("lname");
		$company = $this->input->post("company");
		$address1 = $this->input->post("address1");
		$address2 = $this->input->post("address2");
		$city = $this->input->post("city");
		$state = $this->input->post("state");
		$zipcode = $this->input->post("zip");
		$county = $this->input->post("county");
		$country = $this->input->post("country");
		$phone1 = $this->input->post("phone1");
		$phone2 = $this->input->post("phone2");
		$phone3 = $this->input->post("phone3");
		$email = $this->input->post("email");
		$fax = $this->input->post("fax");
		$website = $this->input->post("website");
		$custom1 = $this->input->post("custom1");
		$custom2 = $this->input->post("custom2");
		$custom3 = $this->input->post("custom3");
		$note = $this->input->post("note");
		$status = $this->input->post("status");

		
		if($zipcode == "null"){
			$zipcode = NULL;
		}
		if($city == "null"){
			$city = NULL;	
		}
		if($state == "null"){
			$state = NULL;
		}
		if($county == "null"){
			$county = NULL;
		}
		if($country == "null"){
			$country = NULL;
		}
		
/*
		if($phone1 == "808" || $phone1 == "(808)"){
			$phone1 = "";
		}
		if($phone2 == "808" || $phone2 == "(808)"){
			$phone2 = "";
		}
		if($phone3 == "808" || $phone3 == "(808)"){
			$phone3 = "";
		}
*/		

		$infoarray = array(
			"FirstName" => $fname,
			"LastName" => $lname,
			"Company" => $company,
			"Address1" => $address1,
			"Address2" => $address2,
			"City" => $city,
			"State" => $state,
			"Zip" => $zipcode,
			"County" => $county,
			"Country" => $country,
			"Phone1" => $phone1,
			"Phone2" => $phone2,
			"Phone3" => $phone3,
			"Email" => $email,
			"Fax" => $fax,
			"Website" => $website,
			"Custom1" => $custom1,
			"Custom2" => $custom2,
			"Custom3" => $custom3,
			"Status" => $status
		);
		
		//var_dump($infoarray);
		//die();
		
		$lastid = $this->backoffice_model->new_customer($infoarray);

		if($note){
			$notearray = array(
				"ReferenceUnique" => $lastid,
				"Note" => trim($note),
				"Status" => 1,
				"Type" => "customer",
				"CreatedBy" => $this->session->userdata("userid")
			);
			$this->backoffice_model->new_note($notearray);
		}

		if($lastid){
			$json["success"] = true;
		}else{
			$json["success"] = false;
		}

		echo json_encode($json);
	}


	function add_supplier_info(){
		$json = array();

		$fname = $this->input->post("fname");
		$lname = $this->input->post("lname");
		$company = $this->input->post("company");
		$address1 = $this->input->post("address1");
		$address2 = $this->input->post("address2");
		$city = $this->input->post("city");
		$state = $this->input->post("state");
		$zipcode = $this->input->post("zip");
		$country = $this->input->post("country");
		$county = $this->input->post("county");
		$phone1 = $this->input->post("phone1");
		$phone2 = $this->input->post("phone2");
		$phone3 = $this->input->post("phone3");
		$email = $this->input->post("email");
		$fax = $this->input->post("fax");
		$website = $this->input->post("website");
		$custom1 = $this->input->post("custom1");
		$custom2 = $this->input->post("custom2");
		$custom3 = $this->input->post("custom3");
		$note = $this->input->post("note");

		if($zipcode == "null"){
			$zipcode = NULL;
		}
		if($city == "null"){
			$city = NULL;	
		}
		if($state == "null"){
			$state = NULL;
		}
		if($county == "null"){
			$county = NULL;
		}
		if($country == "null"){
			$country = NULL;
		}
		
		$infoarray = array(
			"FirstName" => $fname,
			"LastName" => $lname,
			"Company" => $company,
			"Address1" => $address1,
			"Address2" => $address2,
			"City" => $city,
			"State" => $state,
			"Zip" => $zipcode,
			"Country" => $country,
			"County" => $county,
			"Phone1" => $phone1,
			"Phone2" => $phone2,
			"Phone3" => $phone3,
			"Email" => $email,
			"Fax" => $fax,
			"Website" => $website,
			"Custom1" => $custom1,
			"Custom2" => $custom2,
			"Custom3" => $custom3,
			"Status" => 1
		);

		$lastid = $this->backoffice_model->new_supplier($infoarray);

		if($note){
			$notearray = array(
				"ReferenceUnique" => $lastid,
				"Note" => trim($note),
				"Status" => 1,
				"Type" => "supplier",
				"CreatedBy" => $this->session->userdata("userid")
			);
			$this->backoffice_model->new_note($notearray);
		}

		if($lastid){
			$json["success"] = true;
		}else{
			$json["success"] = false;
		}

		echo json_encode($json);
	}

	/*
	function load_zipcode(){
		$json = array();

		$result = $this->backoffice_model->load_zipcode();
		if($result){
			foreach($result as $row){
				$unique = $row["Unique"];
				$zipcode = $row["Zip"];
				$json[$unique]["Zip"] = $zipcode;
			}
		}

		echo json_encode($json);
	}
	*/

	#############################################################################################################################################################
															#@ Populate data @#
	function load_zipcode_prepopulate(){
		$json = array();
		$result = $this->backoffice_model->load_zipcode();
		if($result){
			foreach($result as $row){
				$unique = $row["Unique"];
				$zipcode = $row["Zip"];
				$countylabel = $row["CountyLabel"];
				$json[]= array(
					"Unique" => $unique,
					"ZipCode" => $zipcode,
					"CountyLabel" => $countylabel
				);
			}
		}
		return json_encode($json);
	}

	function load_city_prepopulate(){
		$json = array();
		$result = $this->backoffice_model->load_city();
		if($result){
			foreach($result as $row){
				$unique = $row["City"];
				$country = $row["City"];

				$json[] = array(
					"Unique" => $unique,
					"City" => $country
				);
			}
		}
		return json_encode($json);
	}

	function load_island_prepopulate(){
		$json = array();
		$result = $this->backoffice_model->load_island();
		if($result){
			foreach($result as $row){
				//$unique = $row["Unique"];
				$island = $row["County"];

				$json[] = array(
					"County" => $island,
					"Island" => $island
				);
			}
		}
		return json_encode($json);
	}

	function load_state_prepopulate(){
		$json = array();

		$result = $this->backoffice_model->load_state();
		if($result){
			foreach($result as $row){
				$state = $row["State"];
				$statename = $row["StateName"];
				$json[] = array(
					"StateID" => $state,
					"State" => $state."  | ".$statename
				);
			}
		}
		return json_encode($json);
	}

	function load_country_prepopulate(){
		$json = array();

		$result = $this->backoffice_model->load_country();
		if($result){
			foreach($result as $row){
				$country = $row["Country"];
				$countryname = $row["CountryName"];
				$json[] = array(
					"CountryCode" => $country,
					"CountryName" => $country."  | ".$countryname
				);
			}
		}
		return json_encode($json);
	}

	##############################################################################################################################################################





	function load_zipcode(){
		$json = array();

		$result = $this->backoffice_model->load_zipcode();
		if($result){
			foreach($result as $row){
				$unique = $row["Unique"];
				$zipcode = $row["Zip"];
				$json[]= array(
					"Unique" => $unique,
					"ZipCode" => $zipcode
				);
			}
		}

		echo json_encode($json);
	}

	function get_citystatecountry(){
		$json = array();
		$unique = $this->input->post("geocitiesid");
		$result = $this->backoffice_model->get_citystatecountry($unique);
		if($result){
			foreach($result as $row){
				$unique = $row["Unique"];
				$city = $row["City"];
				$state = $row["State"];
				$statename = $row["StateName"];
				$county = $row["County"];
				$country = $row["Country"];
				$countryname = $row["CountryName"];
				$areacode = $row["Area_Codes"];
				$json["City"] = $city;
				$json["State"] = $state."|".$statename;
				$json["StateName"] = $statename;
				$json["County"] = $county;
				$json["Country"] = $country;
				$json["CountryName"] = $countryname;
				$json["AreaCode"] = $areacode;
			}
		}

		echo json_encode($json);
	}


	function edit_get_citystatecountry(){
		$json = array();
		$zipcode = $this->input->post("geocitiesid");
		$result = $this->backoffice_model->edit_get_citystatecountry($zipcode);
		if($result){
			foreach($result as $row){
				$unique = $row["Unique"];
				$city = $row["City"];
				$state = $row["State"];
				$statename = $row["StateName"];
				$county = $row["County"];
				$country = $row["Country"];
				$countryname = $row["CountryName"];
				$areacode = $row["Area_Codes"];
				$json["Zip"] = $unique;
				$json["City"] = $city;
				$json["State"] = $state;
				$json["StateName"] = $statename;
				$json["County"] = $county;
				$json["Country"] = $country;
				$json["CountryName"] = $countryname;
				$json["AreaCode"] = $areacode;
			}
		}

		echo json_encode($json);
	}

	function load_city(){
		$json = array();
		$result = $this->backoffice_model->load_city();
		if($result){
			foreach($result as $row){
				$unique = $row["City"];
				$country = $row["City"];

				$json[] = array(
					"Unique" => $unique,
					"City" => $country
				);
			}
		}
		echo json_encode($json);
	}

	function load_island(){
		$json = array();
		$result = $this->backoffice_model->load_island();
		if($result){
			foreach($result as $row){
				//$unique = $row["Unique"];
				$island = $row["County"];

				$json[] = array(
					"County" => $island,
					"Island" => $island
				);
			}
		}
		echo json_encode($json);
	}

	function load_state(){
		$json = array();

		$result = $this->backoffice_model->load_state();
		if($result){
			foreach($result as $row){
				$state = $row["State"];
				$statename = $row["StateName"];
				$json[] = array(
					"StateID" => $state,
					"State" => $state."  | ".$statename
				);
			}
		}

		echo json_encode($json);
	}

	function load_country(){
		$json = array();

		$result = $this->backoffice_model->load_country();
		if($result){
			foreach($result as $row){
				$country = $row["Country"];
				$countryname = $row["CountryName"];
				$json[] = array(
					"CountryCode" => $country,
					"CountryName" => $country."  | ".$countryname
				);
			}
		}
		echo json_encode($json);
	}

	function get_geocities_unique(){
		$json = array();
		$unique = $this->input->post("geocitiesid");
		$result = $this->backoffice_model->get_geocities_unique($unique);
		if($result){
			$row = $result;
			$unique = $row["Unique"];
			$zip = $row["Zip"];
			$city = $row["City"];
			$state = $row["State"];
			$county = $row["County"];
			$country = $row["Country"];
			$areacode = $row["Area_Codes"];
			$json["Zip"] = $zip;
			$json["City"] = $city;
			$json["State"] = $state;
			$json["County"] = $county;
			$json["Country"] = $country;
			$json["AreaCode"] = $areacode;
		}
		echo json_encode($json);
	}

	function find_zipcode_selected(){
		$json = array();
		$zipcodeid = $this->input->post("zipcodeid");
		$result = $this->backoffice_model->find_zipcode_selected($zipcodeid);
		if($result){
			$row = $result;
			$zipcode = $row["Unique"];
			$areacode = $row["Area_Codes"];
			$json["ZipUnique"] = $zipcode;
			$json["AreaCode"] = $areacode;
		}

		echo json_encode($json);
	}

	function supplier_list_view(){
		if($this->_is_logged_in()){
			$data['allzip'] = $this->load_zipcode_prepopulate();
			$data['allcities'] = $this->load_city_prepopulate();
			$data['allisland'] = $this->load_island_prepopulate();
			$data['allstates'] = $this->load_state_prepopulate();
			$data['allcountries'] = $this->load_country_prepopulate();
			$data["storename"] = $this->displaystore();
			$data["currentuser"] = $this->session->userdata("currentuser");
			$data["zipcode"] = $this->session->userdata("SupplierZipCode");
			$data['main_content'] = "backoffice/backoffice_supplier_page";
			$this->load->view('backoffice_templates/backoffice_template', $data);
		}else{
			$data['error'] = "Your session has already expired!";
			$this->session->set_userdata($data);
			redirect('backoffice/login');
		}
	}

	function brand(){
		if($this->_is_logged_in()){
			$data["storename"] = $this->displaystore();
			$data["currentuser"] = $this->session->userdata("currentuser");
			$data['main_content'] = "backoffice/backoffice_brand_page";
			$this->load->view('backoffice_templates/backoffice_template', $data);
		}else{
			$data['error'] = "Your session has already expired!";
			$this->session->set_userdata($data);
			redirect('backoffice/login');
		}
	}

	function load_brand(){
		$json = array();

		$result = $this->backoffice_model->load_brand();
		if($result){
			foreach($result as $row){
				$unique = $row["Unique"];
				$brandname = $row["Name"];
				$note = $row["Note"];

				$json[] = array(
					"Unique" => $unique,
					"Brand" => $brandname,
					"Note" => $note
				);
			}
		}

		echo json_encode($json);
	}

	function update_brand(){
		$json = array();
		$brandid = $this->input->post("brandid");
		$brandname = $this->input->post("brandname");
		$brandnote = $this->input->post("note");

		$BrandInfoArray = array(
			"Name" => $brandname,
			"Updated" => date("Y-m-d H:i:s"),
			"UpdatedBy" => $this->session->userdata("userid"),
		);
		$result = $this->backoffice_model->update_brand($brandid, $BrandInfoArray);

		//-->Find Reference Unique
		$find_field = array(
			"ReferenceUnique" => $brandid,
			"Type" => "brand"
		);
		$noteid = $this->backoffice_model->check_note_exist($find_field);
		if($noteid > 0){
			$notearray = array(
				"Note" => trim($brandnote),
				"Updated" => date("Y-m-d H:i:s"),
				"UpdatedBy" => $this->session->userdata("userid")
			);
			$this->backoffice_model->update_note($brandid, $notearray, "brand");
		}else{
			$notearray = array(
				"ReferenceUnique" => $brandid,
				"Note" => trim($brandnote),
				"Type" => "brand",
				"Status" => 1,
				"CreatedBy" => $this->session->userdata("userid")
			);
			$this->backoffice_model->new_note($notearray);
		}


		if($result){
			$json["success"] = true;
		}else{
			$json["success"] = false;
		}

		echo json_encode($json);
	}

	function add_brand(){
		$json = array();

		$brand = $this->input->post("brandname");
		$note = $this->input->post("note");
		$newbrand = array(
			"Name" => $brand,
			"Status" => 1,
			"CreatedBy" => $this->session->userdata("userid")
		);

		$lastid = $this->backoffice_model->new_brand($newbrand);

		if($note){
			$notearray = array(
				"ReferenceUnique" => $lastid,
				"Note" => trim($note),
				"Status" => 1,
				"Type" => "brand",
				"CreatedBy" => $this->session->userdata("userid")
			);
			$this->backoffice_model->new_note($notearray);
		}

		if($lastid){
			$json["success"] = true;
		}else{
			$json["success"] = false;
		}
		echo json_encode($json);
	}

	function branddelete(){
		$json = array();
		$brandid = $this->input->post("tbrandid");
		$data = array(
			"Status" => 0,
			"Updated" => date("Y-m-d H:i:s"),
			"UpdatedBy" => $this->session->userdata("userid")
		);
		$result = $this->backoffice_model->brand_delete_info($data, $brandid);
		if($result){
			$json["success"] = true;
		}else{
			$json["success"] = false;
		}

		echo json_encode($json);
	}

	function brandrestore(){
		$json = array();
		$supplierid = $this->input->post("tbrandid");
		$data = array(
			"Status" => 1,
			"Updated" => date("Y-m-d H:i:s"),
			"UpdatedBy" => $this->session->userdata("userid")
		);
		$result = $this->backoffice_model->brand_restore_info($data, $supplierid);
		if($result){
			$json["success"] = true;
		}else{
			$json["success"] = false;
		}

		echo json_encode($json);
	}
	
	function load_barcode(){
		$json = array();
		$itemunique = $this->input->post("itemid");
		$result = $this->backoffice_model->get_barcode_list($itemunique);
		if($result){
			foreach($result as $row){
				$Unique = $row["Unique"];
				$Barcode = $row["Barcode"];
				$json[] = array(
					"Unique" => $Unique,
					"Barcode" => $Barcode
				);
			}
		}
		echo json_encode($json);
	}
	
	function addbarcode(){
		$json = array();
		$itemid = $this->input->post("itemid");
		$barcode = trim($this->input->post("barcode"));
		//var_dump($barcode);
		//die();
		if($itemid){
			if($barcode != NULL){
				$data = array(
					"ItemUnique" => $itemid,
					"Barcode" => $barcode,
					"Status" => 1,
					"CreatedBy" => $this->session->userdata("userid")
				);
				$result = $this->backoffice_model->insert("item_barcode", $data);
			}
		}
		if($result > 0){
			$json["success"] = true;
			$json["msg"] = "New Barcode added";
		}else{
			$json["msg"] = "Plese enter the barcode number.";
			$json["success"] = false;
 		}
		echo json_encode($json);
	}
	
	function editbarcode(){
		$json = array();
		$itemid = $this->input->post("itemid");
		$barcodeunique = $this->input->post("barcodeunique");
		$barcode = trim($this->input->post("barcode"));
		if($barcodeunique && $barcode != NULL){
			$data = array(
				"Barcode" => $barcode,
				"Updated" => date("Y-m-d H:i:s"),
				"UpdatedBy" => $this->session->userdata("userid")
			);
			$result = $this->backoffice_model->update("item_barcode", "Unique", $data, $barcodeunique);
		}
		if($result){
			$json["success"] = true;
		}else{
			$json["success"] = false;
		}
		echo json_encode($json);
	}
	
	function deletebarcode(){
		$json = array();
		$itemid = $this->input->post("itemid");
		$barcodeunique = $this->input->post("barcodeunique");
		if($barcodeunique){
			$data = array(
				"Unique" => $barcodeunique
			);
			$result = $this->backoffice_model->delete("item_barcode", $data);
		}
		if($result){
			$json["success"] = true;
		}else{
			$json["success"] = false;
		}
		echo json_encode($json);
	}

	function include_receiving_addnew(){
		$this->load->view("backoffice/backoffice_receiving_addnew");
	}

	function include_receiving_inventory(){
		$this->load->view("backoffice/backoffice_po_inventory");
	}

	function include_podel_alert(){
		$this->load->view("alerts/backoffice_pos_po_delmsg");
	}

	function include_testone(){
		$this->load->view("test/backoffice_pos_testone");
	}

	function include_po_item_info(){
		$this->load->view("backoffice/backoffice_po_edit_item_popup");
	}
	
	function admin_side(){
		echo "Admin side";
	}
}
