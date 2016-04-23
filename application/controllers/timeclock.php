<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TimeClock extends CI_Controller
{
    function __construct(){
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('ESC_POS');
        $this->load->library('Curl');
		$this->load->helper('download');
        $this->load->model('TimeClockQueries');
        $timezone = "Pacific/Honolulu";
        if (function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
    }

	function create_token(){
		if($this->_is_logged_in()){
			$data["token"] = 1;
			$this->session->set_userdata($data);
			//echo $this->session->userdata("token");
			$this->timeclock_page();
        }else{
            $data['error'] = "Your session has already expired!";
            $this->session->set_userdata($data);
            redirect('login/login');
        }
	}

    function timeclock_page(){
        if($this->_is_logged_in()){
			if($this->session->userdata("token")){
				$data["page_title"] = "Main Menu";
				$data['main_content'] = "backoffice/backoffice_timeclock_page";
				$this->load->view('backoffice_templates/backoffice_timeclock', $data);
			}else{
				redirect('backoffice/cashier');
			}
        }else{
            $data['error'] = "Your session has already expired!";
            $this->session->set_userdata($data);
            redirect('login/login');
        }
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
        redirect('login/login');
    }

    function load_timeclock(){
        $json = array();
        $result = $this->curl->simple_get('http://192.168.0.110:1337/time_clock');
        //$convert = json_decode($result, true);
        /*
        if($result){
            foreach($result as $row) {
                $json[] = array(
                    "unique" => $row["unique"],
                    "user_unique" => $row["user_unique"],
                    "user_name" => $row["user_name"],
                    "clock_in_date" => $row["clock_in_date"],
                    "clock_in_time" => $row["clock_in_time"],
                    "clock_in_location" => $row["clock_in_location"],
                    "clock_out_date" => $row["clock_out_date"],
                    "clock_out_time" => $row["clock_out_time"],
                    "clock_out_location" => $row["clock_out_location"],
                    "clock_datetime" => $row["clock_datetime"],
                    "status" => $row["status"]
                );
            }
        }
        */
        $json["data"] = $result;
        echo json_encode($json);
    }

    function include_add_timeclock_page(){
        $this->load->view("backoffice/backoffice_add_timeclock");
    }

    function include_edit_timeclock_page(){
        $this->load->view("backoffice/backoffice_edit_timeclock");
    }

    function include_delete_timeclock_page(){
        $this->load->view("backoffice/backoffice_delete_timeclock");
    }
	
	function excel_export(){
		$this->load->library("PHPExcel");
		$this->load->library("PHPExcel/IOFactory");

		$rowCount = 4;
		$inputFileName = "assets/backoffice_templates/backoffice_time_sheet_template.xlsx";
		$inputFileType = IOFactory::identify($inputFileName);
		$objReader = IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($inputFileName);
		
		$api = 'http://192.168.0.110:1337/';
		$datefrom = $this->input->post("datefrom");
		$dateto = $this->input->post("dateto");
		$location = $this->input->post("inlocation");
		$location_name = $this->input->post("inlocation_name");
	
		$objPHPExcel->setActiveSheetIndex()
			    	->setCellValue('C2', "From: ".date("m/d/Y",strtotime($datefrom)))
					->setCellValue('E2', "To: ".date("m/d/Y",strtotime($dateto)))
					->setCellValue('H2', $location_name);
					
		$result = $this->curl->simple_get($api."timeclock-daterange/".$datefrom."/".$dateto."/".$location);
        $convert = json_decode($result, true);
        if($result){
            foreach($convert as $row) {
				if(isset($row["clock_out_location"])){
					$out_location = $row["clock_out_location"]["LocationName"];
					$out_date = date("m/d/Y",strtotime($row["clock_out_date"]));
					$out_time = date("h:i a", strtotime($row["clock_out_time"]));
				}else{
					$out_location = '';
					$out_date = '';
					$out_time = '';
				}
				$objPHPExcel->setActiveSheetIndex()
			    	->setCellValue('A'.$rowCount, $row["Unique"])
					->setCellValue('B'.$rowCount, $row["user_name"])
					->setCellValue('C'.$rowCount, date("m/d/Y",strtotime($row["clock_in_date"])))
					->setCellValue('D'.$rowCount, date("h:i a", strtotime($row["clock_in_time"])))
					->setCellValue('E'.$rowCount, $row["clock_in_location"]["LocationName"])
					->setCellValue('F'.$rowCount, $out_date)
					->setCellValue('G'.$rowCount, $out_time)
					->setCellValue('H'.$rowCount, $out_location)
					->setCellValue('I'.$rowCount, $row["elapsed"]);
				$rowCount++;
            }
        }
		
		$curdate = date("Y-m-d_his");
		
		$objPHPExcel->getActiveSheet()->setTitle('Time Sheet');

		$objPHPExcel->setActiveSheetIndex(0);
		
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('assets/download/timesheet_'.$curdate.'.xlsx');
		
		$file = 'assets/download/timesheet_'.$curdate.'.xlsx';	
		
		$data["file"] = $file;
		$data["filename"] = $filename;
		$this->session->unset_userdata($data);
		$this->session->set_userdata($data);
		
		$json["file"] = $file;
		$json["filename"] = 'timesheet'.$curdate.'.xlsx';
		$json["success"] = true;
		echo json_encode($json);
	}
	
	function download_file(){
		$name = $this->session->userdata("file");
		force_download($name, NULL);
	}
}
