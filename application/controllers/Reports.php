<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->library('form_validation');
		$this->load->library('Curl');
		$this->load->helper('download');
		$this->load->model('backoffice_model');
        $timezone = "Pacific/Honolulu";
        if (function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
    }
	
	public function index(){
		if($this->_is_logged_in()){
			$storeid = $this->session->userdata("storeunique");
			$storename = $this->backoffice_model->stores($storeid);
			
			$data['page_title'] = "Reports";
			
			$data['store'] = $this->session->userdata("storeunique");
			$data['currentuser'] = $this->session->userdata('currentuser');
			$data["StationName"] = $this->session->userdata("station_name");
			$data['StoreName'] = $storename;
			$data['main_content'] = "backoffice/backoffice_dashboard_reports";
			$this->load->view('backoffice_templates/backoffice_reports_template', $data);
		}else{
			//redirect('backoffice/login'); disable login
			$storeid = $this->session->userdata("storeunique");
			$storename = $this->backoffice_model->stores($storeid);	
			$data['page_title'] = "Reports";
			$data['store'] = $this->session->userdata("storeunique");
			$data['currentuser'] = $this->session->userdata('currentuser');
			$data["StationName"] = $this->session->userdata("station_name");
			$data['StoreName'] = $storename;
			$data['main_content'] = "backoffice/backoffice_dashboard_reports";
			$this->load->view('backoffice_templates/backoffice_reports_template', $data);
		}
	}
	
	
	/*Checking whether is logged or not*/
	public function _is_logged_in(){
		if($this->session->userdata('logged_in')){
			return true;
		}else{
			return false;
		}
	}

	/*Logout*/
	public function logout(){
		$this->session->sess_destroy();
		redirect('login/login');
	}
	
}
