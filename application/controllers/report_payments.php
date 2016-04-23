<?php defined('BASEPATH') OR exit('No direct script access allowed');

class report_payments extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->library('form_validation');
		$this->load->library('Curl');
		$this->load->helper('download');
        $timezone = "Pacific/Honolulu";
        if (function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
		$this->load->model('Reports_model');
		$this->load->model('backoffice_model');
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
	
	function displaystore(){
  		$storeid = $this->session->userdata("storeunique");
  		$storename = $this->AKPOSPayment->stores($storeid);
  		return $storename;
  	}
	
	//load payments report view cm 20160312
	public function payments_view(){
		if($this->_is_logged_in()){
			
			$storeid = $this->session->userdata("storeunique");
			$storename = $this->backoffice_model->stores($storeid);
					
			$data['file'] = $this->session->userdata('file');
			$data['DecimalsQuantity'] = $this->session->userdata('DecimalsQuantity');
			$data['DecimalsPrice'] = $this->session->userdata('DecimalsPrice');
			$data['DecimalsCost'] = $this->session->userdata('DecimalsCost');
			$data['DecimalsTax'] = $this->session->userdata('DecimalsTax');
			$data['currentdate'] = date("Y-m-d");
			$data['page_title'] = "Reports";
			$data['currentuser'] = $this->session->userdata('currentuser');
			$data["StationName"] = $this->session->userdata("station_name");
			$data['StoreName'] = $storename;
			$data['StartDate'] = date("Y-m-d");
			$data['EndDate'] = date("Y-m-d");
			
			$data['main_content'] = "backoffice_reports/report_payments_view";
			$this->load->view('backoffice_templates/backoffice_reports_template', $data);
			
			//$this->load->view('backoffice_reports/report_payments', $data);
			
		}else{
			redirect('login/login');
		}
	}
	
	//echo payments array cm 20160312
	public function payments_echo(){
		if($this->_is_logged_in()){	
			$data['results'] = $this->Reports_model->get_payments_report();
			echo '<pre>';
			print_r($data['results']);
		}else{
			redirect('login/login');
		}
	}
	//generate payments report by date range cm 20160312
	public function payments_select_url($StartDate='',$EndDate=''){
		if($this->_is_logged_in()){	
			$StartDate =  $this->uri->segment(4);
			$EndDate =  $this->uri->segment(5);
			$json = array();
			
			$result=$this->Reports_model->get_payments_report_date($StartDate,$EndDate);
		
			if($result){
				foreach($result as $row)
				{
					$json[] = array(
					"LocationName" => trim($row['LocationName']),
					"StationNumber" => trim($row['StationNumber']),
					"StationName" => trim($row['StationName']),
					"User" => trim($row['User']),
					"ReceiptNumber" => trim($row['ReceiptNumber']),
					"ReceiptTotal" => trim($row['ReceiptTotal']),
					"TransactionDate" => trim($row['TransactionDate']),
					"CreatedDate" => trim($row['CreatedDate']),
					"PayMethod" => trim($row['PayMethod']),
					"PayAmount" => trim($row['PayAmount']),
					"PayApply" => trim($row['PayApply']),
					"Change" => trim($row['Change'])
					);
			}
			}
			echo json_encode($json);
		}else{
			redirect('login/login');
		}
	}
	
//generate payments report by date range cm 20160312
	public function payments_select(){
		if($this->_is_logged_in()){	
			$StartDate =  $this->input->post('datefrom');
			$EndDate =  $this->input->post('dateto');
			//$Status =  $this->input->post('status');
			$Status = 12;
			$json = array();
			
			$result=$this->Reports_model->get_payments_report_date($StartDate,$EndDate, $Status);
		
			if($result){
				foreach($result as $row)
				{
					$json[] = array(
					"LocationName" => trim($row['LocationName']),
					"StationNumber" => trim($row['StationNumber']),
					"StationName" => trim($row['StationName']),
					"User" => trim($row['User']),
					"ReceiptNumber" => trim($row['ReceiptNumber']),
					"ReceiptTotal" => trim($row['ReceiptTotal']),
					"TransactionDate" => trim($row['TransactionDate']),
					"CreatedDate" => trim($row['CreatedDate']),
					"PayMethod" => trim($row['PayMethod']),
					"PayAmount" => trim($row['PayAmount']),
					"PayApply" => trim($row['PayApply']),
					"Change" => trim($row['Change'])
					);
			}
			}
			echo json_encode($json);
		}else{
			redirect('login/login');
		}
	}
	
	
//excel export	
	public function payments_export(){
	if($this->_is_logged_in()){
		$StartDate = $this->input->post('datefrom');
		$EndDate = $this->input->post('dateto');
		$Status = $this->input->post('status');
		//$StartDate = '2016-03-01';
		//$EndDate ='2016-03-18';
		//$Status = '4';
		//echo $StartDate;
		//echo $EndDate;
		//echo $Status;
			
		$this->load->library('PHPExcel');
		$this->load->library('PHPExcel/IOFactory');

			
		//$inputFileName = "assets/templates/report_receipts_template.xlsx";
		//$inputFileType = IOFactory::identify($inputFileName);
		//$objReader = IOFactory::createReader($inputFileType);
		//$objPHPExcel = $objReader->load($inputFileName);
		
		$objPHPExcel = new PHPExcel();
	
		//station settings
		$decimalQty = $this->session->userdata('DecimalsQuantity');
		$decimalPrice = $this->session->userdata('DecimalsPrice');
		$decimalCost = $this->session->userdata('DecimalsCost');
		
		$formatQty = number_format(0, $decimalQty, '.','');
		$formatPrice = number_format(0, $decimalPrice, '.','');
		$formatCost = number_format(0, $decimalCost, '.','');
		
		//format numbers in this report
		$formatNumbers = number_format(0, 2, '.','');	
					
		$objPHPExcel->setActiveSheetIndex(0);
			
		//report title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Payments Received');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		$objPHPExcel->getActiveSheet()->setTitle('Payments');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		
		 // set column titles
		$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Location');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Station');
		$objPHPExcel->getActiveSheet()->setCellValue('C3', 'User');
		$objPHPExcel->getActiveSheet()->setCellValue('D3', 'Date');
		$objPHPExcel->getActiveSheet()->setCellValue('E3', 'Receipt');
		$objPHPExcel->getActiveSheet()->setCellValue('F3', 'Total');
		$objPHPExcel->getActiveSheet()->setCellValue('G3', 'Tendered');
		$objPHPExcel->getActiveSheet()->setCellValue('H3', 'Received');
		$objPHPExcel->getActiveSheet()->setCellValue('I3', 'Change');
		$objPHPExcel->getActiveSheet()->setCellValue('J3', 'Method');
		
		//page settings
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		//$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

		//format data label row 		
		$objPHPExcel->getActiveSheet()->getStyle('A3:J3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A3:J3')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->getStyle('F3:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('J3:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		
		$curdate = date("Y-m-d_his");
		
		for($col = ord('A'); $col <= ord('E'); $col++){
            //set column dimension
            $objPHPExcel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
            //change the font size
            $objPHPExcel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12); 		
            $objPHPExcel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);		
        }
		
		for($col = ord('F'); $col <= ord('J'); $col++){
            //set column dimension
            $objPHPExcel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
            //change the font size
			$objPHPExcel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12); 		
			$objPHPExcel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		
			$objPHPExcel->getActiveSheet()->getStyle(chr($col))->getNumberFormat()->setFormatCode("#,##".$formatNumbers."");
        }
		
		for($col = ord('G'); $col <= ord('I'); $col++){	
			$objPHPExcel->getActiveSheet()->getStyle(chr($col))->getNumberFormat()->setFormatCode("#,##".$formatNumbers."");
        }
		
		$json = array();
		$result_export=$this->Reports_model->get_payments_report_date($StartDate,$EndDate,$Status);
		//$convert = json_decode($result_export, true);
		
		$exceldata="";
	
		if($result_export){		
				$Tendered = 0;
				$Received = 0;
				$Change = 0;
				$rowCount = 4; //starting row to count from
				
			foreach ($result_export as $row){	
				$exceldata[] = array(
					"LocationName" => trim($row['LocationName']),
					"StationName" => trim($row['StationName']),
					"User" => trim($row['User']),
					"TransactionDate" => trim($row['TransactionDate']),
					"ReceiptNumber" => trim($row['ReceiptNumber']),			
					"ReceiptTotal" => trim($row['ReceiptTotal']),
					"PayAmount"  => trim($row['PayAmount']),
					"PayApply" => trim($row['PayApply']),
					"Change" => trim($row['Change']),			
					"PayMethod" => trim($row['PayMethod'])					
					);
	
					$Tendered += $row["PayAmount"];
					$Received += $row["PayApply"];
					$Change += $row["Change"];
					
					$rowCount++;					
			}
			$objPHPExcel->getActiveSheet()->getStyle('G'.$rowCount.':I'.$rowCount)->getFont()->setBold(true);
			
			$objPHPExcel->getActiveSheet()->getStyle('G'.$rowCount)->getNumberFormat()->setFormatCode("#,##".$formatNumbers."");
			$objPHPExcel->getActiveSheet()->getStyle('H'.$rowCount)->getNumberFormat()->setFormatCode("#,##".$formatNumbers."");
			$objPHPExcel->getActiveSheet()->getStyle('I'.$rowCount)->getNumberFormat()->setFormatCode("#,##".$formatNumbers."");
			
			$objPHPExcel->setActiveSheetIndex()
				->setCellValue('G'.$rowCount, $Tendered)
				->setCellValue('H'.$rowCount, $Received)
				->setCellValue('I'.$rowCount, $Change);
			}
	
		//var_dump($exceldata);
				
        //Fill data 
        $objPHPExcel->getActiveSheet()->fromArray($exceldata, null, 'A4');
		
		$curdate = date("Y-m-d_his");
		
		$objPHPExcel->setActiveSheetIndex(0);
				
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('assets/download/PaymentsReceived_'.$curdate.'.xlsx');
				
		$file = 'assets/download/PaymentsReceived_'.$curdate.'.xlsx';	
				
		$data["file"] = $file;
		$data["filename"] = $file;
		$this->session->unset_userdata($data);
		$this->session->set_userdata($data);
				
		$json["file"] = $file;
		$json["filename"] = 'PaymentsReceived_'.$curdate.'.xlsx';
		$json["success"] = true;
		
		$filename='PaymentsReceived_'.$curdate.'.xlsx'; //save our workbook as this file name
		
		//below doesn't work with ajax
		//header('Content-Type: application/vnd.ms-excel'); //2003 mime type
		//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //2007 mime type
		
		//header('Cache-Control: max-age=0'); // nocache
		//header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		//$objWriter->save('php://output');
		
		}else{
			redirect('login/login');
			}
		}
		
	function payments_download(){
		$name = $this->session->userdata("file");
		force_download($name, NULL);
		}
}
