<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller
{
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
	
	function category_page(){
        if($this->_is_logged_in()){
			$data["page_title"] = "Category";
			$data['main_content'] = "backoffice/backoffice_category_page";
			$data['userid'] = $this->session->userdata("userid");
			$this->load->view('backoffice_templates/backoffice_category', $data);
        }else{
            $data['error'] = "Your session has already expired!";
            $this->session->set_userdata($data);
            redirect('backoffice/login');
        }
    }
	
	function get_header_information(){
       $json = array();
       $station_name = $this->session->userdata("station_name");
       $storename = $this->session->userdata("store_name");
       $user_name = '';
       
       $station_unique = $this->session->userdata("station_cashier_unique");
       $userunique = $this->session->userdata("userid");
	   
   	   $json["station_name"] = $station_name;
   	   $json["store_name"] = $storename;
       $json["user_name"] = $user_name;
   	
   	   echo json_encode($json);
   	 }
	
	function category_test_page(){
        $this->load->view('backoffice/backoffice_category_page_test');
    }
	
	/* Checking whether is logged or not */
    function _is_logged_in(){
        if($this->session->userdata('logged_in')){
            return true;
        }else{
            return false;
        }
    }

    /* Logout */
    function logout(){
        $this->session->sess_destroy();
        redirect('backoffice/login');
    }
	
	function include_add_form(){
		$this->load->view('backoffice/backoffice_category_add_form');
	}
	
	function include_edit_form(){
		$this->load->view('backoffice/backoffice_category_edit_form');
	}
	
	function include_delete_form(){
		$this->load->view('backoffice/backoffice_category_delete_form');
	}
	
	function include_add_subcat_form(){
		$this->load->view('backoffice/backoffice_category_sub_add_form');
	}
	
	function include_edit_subcat_form(){
		$this->load->view('backoffice/backoffice_category_sub_edit_form');
	}
	
	function include_delete_subcat_form(){
		$this->load->view('backoffice/backoffice_category_sub_delete_form');
	}
}