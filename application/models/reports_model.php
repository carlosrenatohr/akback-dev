<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports_model extends CI_Model {

	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
		$timezone = "Pacific/Honolulu";
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
		ini_set('max_execution_time', 1000);
		
	}
	
	//payments report echo
	function get_payments_report(){
	
	$sql = "SELECT config_location.\"Name\" as \"LocationName\",config_station.\"Number\" as \"StationNumber\", config_station.\"Name\" as \"StationName\", coalesce(\"FirstName\", '') || ' ' || coalesce(\"LastName\", '') as \"User\",receipt_header.\"ReceiptNumber\",round(receipt_header.\"Total\",2) as \"ReceiptTotal\",receipt_payment.\"transaction_date\" as \"TransactionDate\",
		date_trunc('minute',receipt_payment.\"created\"::timestamp) as \"CreatedDate\",
		receipt_payment.\"payment_name\" as \"PayMethod\",round(receipt_payment.\"amount\",2) as \"PayAmount\",round(receipt_payment.\"paid\",2) as \"PayApply\", round(receipt_payment.\"change\",2) as \"Change\"
		from receipt_payment 
		left join station_cashier on station_cashier.\"unique\" = receipt_payment.\"station_cashier_unique\"
		left join config_station on config_station.\"Unique\" = station_cashier.\"station_unique\" 
		left join config_location on config_station.\"LocationUnique\" = config_location.\"Unique\"
		left join receipt_header on receipt_header.\"Unique\" = receipt_payment.\"receipt_header_unique\"
		left join config_user on config_user.\"Unique\" = receipt_payment.\"created_by\" 
		";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	//payments report by date
	function get_payments_report_date($StartDate, $EndDate, $Status){
		$this->load->database();
		$sql = "SELECT config_location.\"Name\" as \"LocationName\",config_station.\"Number\" as \"StationNumber\", config_station.\"Name\" as \"StationName\", coalesce(\"FirstName\", '') || ' ' || coalesce(\"LastName\", '') as \"User\",receipt_header.\"ReceiptNumber\",round(receipt_header.\"Total\",2) as \"ReceiptTotal\",receipt_payment.\"transaction_date\" as \"TransactionDate\",
		date_trunc('minute',receipt_payment.\"created\"::timestamp) as \"CreatedDate\",
		receipt_payment.\"payment_name\" as \"PayMethod\",round(receipt_payment.\"amount\",2) as \"PayAmount\",round(receipt_payment.\"paid\",2) as \"PayApply\", round(receipt_payment.\"change\",2) as \"Change\"
		from receipt_payment 
		left join station_cashier on station_cashier.\"unique\" = receipt_payment.\"station_cashier_unique\"
		left join config_station on config_station.\"Unique\" = station_cashier.\"station_unique\" 
		left join config_location on config_station.\"LocationUnique\" = config_location.\"Unique\"
		left join receipt_header on receipt_header.\"Unique\" = receipt_payment.\"receipt_header_unique\"
		left join config_user on config_user.\"Unique\" = receipt_payment.\"created_by\"
		where receipt_payment.\"transaction_date\" between '$StartDate' and '$EndDate' and receipt_payment.\"status\" in ('$Status')
		order by config_station.\"Name\" asc, receipt_payment.\"created\" desc
		";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}
	
	function get_receipts_report(){
		$this->load->database();
		$sql = "select receipt_header.\"Unique\" as \"ReceiptID\", config_location.\"Name\" as \"LocationName\", config_station.\"Name\" as \"StationName\",coalesce(config_user.\"FirstName\", '') || ' ' || coalesce(config_user.\"LastName\", '') as \"User\",\"ReceiptNumber\", 
		coalesce(customer.\"FirstName\", '') || ' ' || coalesce(customer.\"LastName\", '') as \"Customer\",
		round(\"SubTotal\",2) as \"SubTotal\", round(\"Tip\",2) as \"Tip\",round(\"Tax\",2) as \"Tax\", round(\"Total\",2) as \"Total\",COALESCE(t1.\"Paid\",0.00) as \"Paid\",
		case when receipt_header.\"Status\" = 10 then 0.00 else round(receipt_header.\"Total\" - COALESCE(t1.\"Paid\",0.00),2) end as \"Balance\",
		date_trunc('minute', receipt_header.\"Created\"::timestamp) as \"CreatedDate\",receipt_header.\"transaction_date\" as \"TransactionDate\",
		case when receipt_header.\"Status\" = 10 then 'Cancelled' when receipt_header.\"Status\" = 4 then 'Completed'
		when receipt_header.\"Status\" = 5 then 'On Hold' when receipt_header.\"Status\" = 4 then 'Completed' else 'Other' end as \"ReceiptStatus\"
		from receipt_header
		left join config_location on receipt_header.\"LocationUnique\" = config_location.\"Unique\"
		left join config_user on receipt_header.\"CreatedBy\" = config_user.\"Unique\"
		left join config_station on config_station.\"Unique\" = receipt_header.\"StationUnique\" 
		left join customer on customer.\"Unique\" = receipt_header.\"CustomerUnique\" 
		left join (select receipt_payment.\"receipt_header_unique\" as \"id\", round(sum(receipt_payment.\"paid\"),2) as \"Paid\"
		from receipt_payment where receipt_payment.\"status\" = 12 group by receipt_payment.\"receipt_header_unique\") t1
		on receipt_header.\"Unique\" = t1.\"id\"
		";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}
	
	function get_receipts_report_date($StartDate, $EndDate, $Status){
		$this->load->database();
		$sql = "select receipt_header.\"Unique\" as \"ReceiptID\", config_location.\"Name\" as \"LocationName\",config_station.\"Name\" as \"StationName\",coalesce(config_user.\"FirstName\", '') || ' ' || coalesce(config_user.\"LastName\", '') as \"User\",\"ReceiptNumber\", 
		coalesce(customer.\"FirstName\", '') || ' ' || coalesce(customer.\"LastName\", '') as \"Customer\",
		round(\"SubTotal\",2) as \"SubTotal\", round(\"Tip\",2) as \"Tip\",round(\"Tax\",2) as \"Tax\", round(\"Total\",2) as \"Total\",COALESCE(t1.\"Paid\",0.00) as \"Paid\",
		case when receipt_header.\"Status\" = 10 then 0.00 else round(receipt_header.\"Total\" - COALESCE(t1.\"Paid\",0.00),2) end as \"Balance\",
		date_trunc('minute', receipt_header.\"Created\"::timestamp) as \"Created\",receipt_header.\"transaction_date\" as \"TransactionDate\",
		case when receipt_header.\"Status\" = 10 then 'Cancelled' when receipt_header.\"Status\" = 4 then 'Completed'
		when receipt_header.\"Status\" = 5 then 'On Hold' when receipt_header.\"Status\" = 4 then 'Completed' else 'Other' end as \"ReceiptStatus\"
		from receipt_header
		left join config_location on receipt_header.\"LocationUnique\" = config_location.\"Unique\"
		left join config_user on receipt_header.\"CreatedBy\" = config_user.\"Unique\"
		left join config_station on config_station.\"Unique\" = receipt_header.\"StationUnique\" 
		left join customer on customer.\"Unique\" = receipt_header.\"CustomerUnique\" 
		left join (select receipt_payment.\"receipt_header_unique\" as \"id\", round(sum(receipt_payment.\"paid\"),2) as \"Paid\"
		from receipt_payment where receipt_payment.\"status\" = 12 group by receipt_payment.\"receipt_header_unique\") t1
		on receipt_header.\"Unique\" = t1.\"id\"
		where receipt_header.\"transaction_date\" between '$StartDate' and '$EndDate' and receipt_header.\"Status\" in ('$Status')
		";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}
	
	function get_itemsales_report(){
	$this->load->database();
	$sql = "select date_trunc('minute', receipt_details.\"created\"::timestamp) as \"TransactionDate\", receipt_details.\"Item\",receipt_details.\"Description\",
	receipt_details.\"Quantity\",receipt_details.\"ListPrice\",receipt_details.\"Discount\",
	receipt_details.\"SellPrice\",receipt_details.\"SellPrice\"*receipt_details.\"Quantity\" as \"ExtSellPrice\", receipt_details.\"Tax\" as \"ExtTax\",receipt_details.\"Total\",
	config_location.\"Name\" as \"LocationName\",
	coalesce(config_user.\"FirstName\", '') || ' ' || coalesce(config_user.\"LastName\", '') as \"User\"
	from receipt_details
	left join config_location on receipt_details.\"location_unique\" = config_location.\"Unique\"
	left join config_user on receipt_details.\"created_by\" = config_user.\"Unique\"
	where receipt_details.\"Status\" = 1
	";
	
	$query = $this->db->query($sql);
	$result = $query->result_array();
	return $result;
	}

	function get_itemsales_report_date($StartDate, $EndDate) {
	$this->load->database();
	$sql = "select date_trunc('minute', receipt_details.\"created\"::timestamp) as \"TransactionDate\", receipt_details.\"Item\",receipt_details.\"Description\",
	receipt_details.\"Quantity\",receipt_details.\"ListPrice\",receipt_details.\"Discount\",
	receipt_details.\"SellPrice\",receipt_details.\"SellPrice\"*receipt_details.\"Quantity\" as \"ExtSellPrice\", receipt_details.\"Tax\" as \"ExtTax\",receipt_details.\"Total\",
	config_location.\"Name\" as \"LocationName\",
	coalesce(config_user.\"FirstName\", '') || ' ' || coalesce(config_user.\"LastName\", '') as \"User\"
	from receipt_details
	left join config_location on receipt_details.\"location_unique\" = config_location.\"Unique\"
	left join config_user on receipt_details.\"created_by\" = config_user.\"Unique\"
	where receipt_details.\"Status\" = 1 and date_trunc('day', receipt_details.\"created\"::timestamp) between '$StartDate' and '$EndDate'
	";
	
	$query = $this->db->query($sql);
	$result = $query->result_array();
	return $result;
	}
	
	function get_tips_report () {
	$this->load->database();
	$sql = "select receipt_payment.\"receipt_number\" as \"ReceiptNumber\", coalesce(b.\"FirstName\", '') || ' ' || coalesce(b.\"LastName\", '') as \"ReceiptUser\",
	round(receipt_header.\"SubTotal\",2) as \"ReceiptSubTotal\",round(receipt_header.\"Tip\",2) as \"ReceiptTip\",round(receipt_header.\"Tax\",2) as \"ReceiptTax\",
	round(receipt_header.\"Total\",2) as \"ReceiptTotal\",receipt_payment.\"payment_name\" as \"PayMethod\",round(receipt_payment.\"amount\",2) as \"Tendered\", round(receipt_payment.\"paid\",2) as \"Paid\" ,
	round(receipt_payment.\"change\",2) as \"Change\" ,round(receipt_tip.\"TipAmount\",2) as \"PaidTip\", 
	date_trunc('minutes', receipt_payment.\"created\"::timestamp) as \"PaymentDate\",
	coalesce(a.\"FirstName\", '') || ' ' || coalesce(a.\"LastName\", '') as \"PaymentUser\",
	receipt_payment.\"status\" as \"Status\"
	from receipt_payment
	join receipt_header on receipt_header.\"Unique\" = receipt_payment.receipt_header_unique
	left join receipt_tip on receipt_payment.\"unique\" = receipt_tip.\"ReceiptPaymentUnique\" 
	left join config_user a on receipt_payment.\"created_by\" = a.\"Unique\"
	left join config_user b on receipt_header.\"CreatedBy\" = b.\"Unique\"
	where receipt_payment.\"status\" = 12
	order by \"PaymentDate\" desc";

	$query = $this->db->query($sql);
	$result = $query->result_array();
	return $result;
	}
	
	function get_tips_report_date ($StartDate, $EndDate) {
	$this->load->database();
	$sql = "select receipt_payment.\"receipt_number\" as \"ReceiptNumber\", coalesce(b.\"FirstName\", '') || ' ' || coalesce(b.\"LastName\", '') as \"ReceiptUser\",
	round(receipt_header.\"SubTotal\",2) as \"ReceiptSubTotal\",round(receipt_header.\"Tip\",2) as \"ReceiptTip\",round(receipt_header.\"Tax\",2) as \"ReceiptTax\",
	round(receipt_header.\"Total\",2) as \"ReceiptTotal\",receipt_payment.\"payment_name\" as \"PayMethod\",round(receipt_payment.\"amount\",2) as \"Tendered\", round(receipt_payment.\"paid\",2) as \"Paid\" ,
	round(receipt_payment.\"change\",2) as \"Change\" ,round(receipt_tip.\"TipAmount\",2) as \"PaidTip\", 
	date_trunc('minutes', receipt_payment.\"created\"::timestamp) as \"PaymentDate\",
	coalesce(a.\"FirstName\", '') || ' ' || coalesce(a.\"LastName\", '') as \"PaymentUser\",
	receipt_payment.\"status\" as \"Status\"
	from receipt_payment
	join receipt_header on receipt_header.\"Unique\" = receipt_payment.receipt_header_unique
	left join receipt_tip on receipt_payment.\"unique\" = receipt_tip.\"ReceiptPaymentUnique\" 
	left join config_user a on receipt_payment.\"created_by\" = a.\"Unique\"
	left join config_user b on receipt_header.\"CreatedBy\" = b.\"Unique\"
	where receipt_payment.\"status\" = 12 and date_trunc('day', receipt_payment.\"created\"::timestamp) between '$StartDate' and '$EndDate'
	order by \"PaymentDate\" desc";

	$query = $this->db->query($sql);
	$result = $query->result_array();
	return $result;
	}
	
	function get_categorysales_report() {
	$this->load->database();
	
	$sql = "select config_location.\"Name\" as \"LocationName\",category_main.\"MainName\" as \"Category\", round(sum(receipt_details.\"Quantity\")) as \"Quantity\",
	round(sum(receipt_details.\"ListPrice\" * receipt_details.\"Quantity\"),2) as \"ExtList\",
	round(sum(receipt_details.\"Discount\"* receipt_details.\"Quantity\"),2) as \"Discount\",round(sum(receipt_details.\"SellPrice\"*receipt_details.\"Quantity\"),2) as \"ExtSell\",
	round(sum(receipt_details.\"Tax\"),2) as \"Tax\",round(sum(receipt_details.\"Total\"),2) as \"Total\" from receipt_details
	left join config_location on receipt_details.\"location_unique\" = config_location.\"Unique\"
	left join config_user on receipt_details.\"created_by\" = config_user.\"Unique\" left join item on item.\"Unique\" = receipt_details.\"ItemUnique\"
	left join category_sub on item.\"CategoryUnique\" = category_sub.\"Unique\" left join category_main on category_sub.\"CategoryMainUnique\" = category_main.\"Unique\"
	where receipt_details.\"Status\" = 1 group by config_location.\"Name\",category_main.\"MainName\" order by \"Category\" ";
	
	$query = $this->db->query($sql);
	$result = $query->result_array();
	return $result;
	}
	
	function get_categorysales_report_date ($StartDate, $EndDate) {
	$this->load->database();
	$sql = "select config_location.\"Name\" as \"LocationName\",category_main.\"MainName\" as \"Category\", round(sum(receipt_details.\"Quantity\")) as \"Quantity\",
	round(sum(receipt_details.\"ListPrice\" * receipt_details.\"Quantity\"),2) as \"ExtList\",
	round(sum(receipt_details.\"Discount\"* receipt_details.\"Quantity\"),2) as \"Discount\",round(sum(receipt_details.\"SellPrice\"*receipt_details.\"Quantity\"),2) as \"ExtSell\",
	round(sum(receipt_details.\"Tax\"),2) as \"Tax\",round(sum(receipt_details.\"Total\"),2) as \"Total\" from receipt_details
	left join config_location on receipt_details.\"location_unique\" = config_location.\"Unique\"
	left join config_user on receipt_details.\"created_by\" = config_user.\"Unique\" left join item on item.\"Unique\" = receipt_details.\"ItemUnique\"
	left join category_sub on item.\"CategoryUnique\" = category_sub.\"Unique\" left join category_main on category_sub.\"CategoryMainUnique\" = category_main.\"Unique\"
	where receipt_details.\"Status\" = 1 and date_trunc('day', receipt_details.\"created\"::timestamp) between '$StartDate' and '$EndDate'
	group by config_location.\"Name\",category_main.\"MainName\" order by \"Category\" ";
	
	$query = $this->db->query($sql);
	$result = $query->result_array();
	return $result;
	}
	
	function get_itemreturns_report () {
	$this->load->database();
	$sql = "select receipt_header.\"ReceiptNumber\", date_trunc('minute', receipt_details.\"created\"::timestamp) as \"TransactionDate\", receipt_details.\"Item\",
	receipt_details.\"Description\",receipt_details.\"Quantity\",receipt_details.\"ListPrice\",receipt_details.\"Discount\",
	receipt_details.\"SellPrice\",receipt_details.\"SellPrice\"*receipt_details.\"Quantity\" as \"ExtSellPrice\", receipt_details.\"Tax\",receipt_details.\"Total\",
	config_location.\"Name\" as \"LocationName\",
	coalesce(config_user.\"FirstName\", '') || ' ' || coalesce(config_user.\"LastName\", '') as \"User\"
	from receipt_details
	left join receipt_header on receipt_details.\"ReceiptHeaderUnique\" = receipt_header.\"Unique\"
	left join config_location on receipt_details.\"location_unique\" = config_location.\"Unique\"
	left join config_user on receipt_details.\"created_by\" = config_user.\"Unique\"
	where receipt_details.\"Status\" = 1 and receipt_details.\"Quantity\" < 0
	order by receipt_details.\"created\" desc ";

	$query = $this->db->query($sql);
	$result = $query->result_array();
	return $result;
	}
	
	function get_itemreturns_report_date ($StartDate, $EndDate) {
	$this->load->database();
	$sql = "select receipt_header.\"ReceiptNumber\", date_trunc('minute', receipt_details.\"created\"::timestamp) as \"TransactionDate\", receipt_details.\"Item\",
	receipt_details.\"Description\",receipt_details.\"Quantity\",receipt_details.\"ListPrice\",receipt_details.\"Discount\",
	receipt_details.\"SellPrice\",receipt_details.\"SellPrice\"*receipt_details.\"Quantity\" as \"ExtSellPrice\", receipt_details.\"Tax\",receipt_details.\"Total\",
	config_location.\"Name\" as \"LocationName\",
	coalesce(config_user.\"FirstName\", '') || ' ' || coalesce(config_user.\"LastName\", '') as \"User\"
	from receipt_details
	left join receipt_header on receipt_details.\"ReceiptHeaderUnique\" = receipt_header.\"Unique\"
	left join config_location on receipt_details.\"location_unique\" = config_location.\"Unique\"
	left join config_user on receipt_details.\"created_by\" = config_user.\"Unique\"
	where receipt_details.\"Status\" = 1 and receipt_details.\"Quantity\" < 0 
	and date_trunc('day', receipt_details.\"created\"::timestamp) between '$StartDate' and '$EndDate'
	order by receipt_details.\"created\" desc ";

	$query = $this->db->query($sql);
	$result = $query->result_array();
	return $result;
	}
	
}