<?php defined('BASEPATH') OR exit('No direct script access allowed');

class report_receipts extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->library('form_validation');
		$this->load->library('Curl');
		$this->load->helper('download');
        $timezone = "Pacific/Honolulu";
        if (function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
		$this->load->model('Reports_model'); //cm 20160312
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
	
	//load receipt report view
	public function receipts_view (){
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
			
			$data['main_content'] = "backoffice_reports/report_receipts_view";
			$this->load->view('backoffice_templates/backoffice_reports_template', $data);
			
		}else{
			redirect('login/login');
			}		
	}
	
	//echo receipt report data array
	public function receipts_echo(){
		if($this->_is_logged_in()){	
			$data['results'] = $this->Reports_model->get_receipts_report();
			echo '<pre>';
			print_r($data['results']);
		}else{
			redirect('login/login');
		}
	}
	
	//generate receipts report by date range cm 20160312
	public function receipts_select_url($StartDate='',$EndDate='', $Status=''){
		if($this->_is_logged_in()){	
			$StartDate =  $this->uri->segment(4);
			$EndDate =  $this->uri->segment(5);
			$Status =  $this->uri->segment(6);
			$json = array();
			$result=$this->Reports_model->get_receipts_report_date($StartDate,$EndDate,$Status);
		
			if($result){
				foreach($result as $row)
				{
					$json[] = array(
					"ReceiptID" => trim($row['ReceiptID']),
					"StationName" => trim($row['StationName']),
					"User" => trim($row['User']),
					"ReceiptNumber" => trim($row['ReceiptNumber']),
					"Customer" => trim($row['Customer']),
					"SubTotal" => trim($row['SubTotal']),
					"Tip" => trim($row['Tip']),
					"Tax" => trim($row['Tax']),
					"Total" => trim($row['Total']),
					"Paid" => trim($row['Paid']),
					"Balance" => trim($row['Balance']),
					"CreatedDate" => trim($row['Created']),
					"TransactionDate" => trim($row['TransactionDate']),
					"ReceiptStatus" => trim($row['ReceiptStatus'])
					);
				}
			}
			echo json_encode($json);
		
			}else{
				redirect('login/login');
			}
	}
	
	//ajax post
	public function receipts_select(){
		if($this->_is_logged_in()){	
			$StartDate =  $this->input->post('datefrom');
			$EndDate =  $this->input->post('dateto');
			$Status =  $this->input->post('status');
			//$StartDate = '2016-03-01';
			//$EndDate ='2016-03-18';
			//$Status = 4;
			$json = array();
			
			$result=$this->Reports_model->get_receipts_report_date($StartDate,$EndDate,$Status);
		
			if($result){
				foreach($result as $row)
				{
					$json[] = array(
					"ReceiptID" => trim($row['ReceiptID']),
					"LocationName" => trim($row['LocationName']),
					"StationName" => trim($row['StationName']),
					"User" => trim($row['User']),
					"ReceiptNumber" => trim($row['ReceiptNumber']),
					"Customer" => trim($row['Customer']),
					"SubTotal" => trim($row['SubTotal']),
					"Tip" => trim($row['Tip']),
					"Tax" => trim($row['Tax']),
					"Total" => trim($row['Total']),
					"Paid" => trim($row['Paid']),
					"Balance" => trim($row['Balance']),
					"CreatedDate" => trim($row['Created']),
					"TransactionDate" => trim($row['TransactionDate']),
					"ReceiptStatus" => trim($row['ReceiptStatus'])
					);
				}
			}
			echo json_encode($json);
		}else{
			redirect('login/login');
			}
	}
	
//excel export	
	public function receipts_export(){
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
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Receipt Totals');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		$objPHPExcel->getActiveSheet()->setTitle('ReceiptsTotals');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		
		 // set column titles
		$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Location');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Station');
		$objPHPExcel->getActiveSheet()->setCellValue('C3', 'User');
		$objPHPExcel->getActiveSheet()->setCellValue('D3', 'Date');
		$objPHPExcel->getActiveSheet()->setCellValue('E3', 'Receipt');
		$objPHPExcel->getActiveSheet()->setCellValue('F3', 'SubTotal');
		$objPHPExcel->getActiveSheet()->setCellValue('G3', 'Tip');
		$objPHPExcel->getActiveSheet()->setCellValue('H3', 'Tax');
		$objPHPExcel->getActiveSheet()->setCellValue('I3', 'Total');
		$objPHPExcel->getActiveSheet()->setCellValue('J3', 'Paid');
		$objPHPExcel->getActiveSheet()->setCellValue('K3', 'Balance');
		$objPHPExcel->getActiveSheet()->setCellValue('L3', 'Status');
		
		//page settings
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		//$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

		//format data label row 		
		$objPHPExcel->getActiveSheet()->getStyle('A3:L3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A3:L3')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->getStyle('F3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('L3:L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		
		$curdate = date("Y-m-d_his");
		
		for($col = ord('A'); $col <= ord('E'); $col++){
            //set column dimension
            $objPHPExcel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
            //change the font size
            $objPHPExcel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12); 		
            $objPHPExcel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);		
        }
		
		
		for($col = ord('F'); $col <= ord('L'); $col++){
            //set column dimension
            $objPHPExcel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
            //change the font size
			$objPHPExcel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12); 		
			$objPHPExcel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		
			$objPHPExcel->getActiveSheet()->getStyle(chr($col))->getNumberFormat()->setFormatCode("#,##".$formatNumbers."");
        }
		
		$json = array();
		$result_export=$this->Reports_model->get_receipts_report_date($StartDate,$EndDate,$Status);
		$convert = json_decode($result_export, true);
		
		$exceldata="";
	
		if($result_export){		
				$SubTotal = 0;
				$Tip = 0;
				$Tax = 0;
				$Total = 0;
				$Paid = 0;
				$Balance = 0;
				$rowCount = 4; //starting row to count from
				
			foreach ($result_export as $row){	
				$exceldata[] = array(
					"LocationName" => trim($row['LocationName']),
					"Station" => trim($row['StationName']),
					"User" => trim($row['User']),
					"Date" => trim($row['TransactionDate']),
					"Receipt" => trim($row['ReceiptNumber']),			
					"SubTotal" => trim($row['SubTotal']),
					"Tip"  => trim($row['Tip']),
					"Tax" => trim($row['Tax']),
					"Total" => trim($row['Total']),			
					"Paid" => trim($row['Paid']),
					"Balance" => trim($row['Balance']),	
					"Status" => trim($row['ReceiptStatus']),					
					);
					
					$SubTotal += $row["SubTotal"];
					$Tip += $row["Tip"];
					$Tax += $row["Tax"];
					$Total += $row["Total"];
					$Paid += $row["Paid"];
					$Balance += $row["Balance"];
					
					$rowCount++;					
			}
			$objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount.':K'.$rowCount)->getFont()->setBold(true);
			
			$objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->getNumberFormat()->setFormatCode("#,##".$formatNumbers."");
			$objPHPExcel->setActiveSheetIndex()
				->setCellValue('F'.$rowCount, $SubTotal)
				->setCellValue('G'.$rowCount, $Tip)
				->setCellValue('H'.$rowCount, $Tax)
				->setCellValue('I'.$rowCount, $Total)
				->setCellValue('J'.$rowCount, $Paid)
				->setCellValue('K'.$rowCount, $Balance);
			}
	
		//var_dump($exceldata);
				
        //Fill data 
        $objPHPExcel->getActiveSheet()->fromArray($exceldata, null, 'A4');
		
		$curdate = date("Y-m-d_his");
		
		$objPHPExcel->setActiveSheetIndex(0);
				
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('assets/download/ReceiptTotals_'.$curdate.'.xlsx');
				
		$file = 'assets/download/ReceiptTotals_'.$curdate.'.xlsx';	
				
		$data["file"] = $file;
		$data["filename"] = $file;
		$this->session->unset_userdata($data);
		$this->session->set_userdata($data);
				
		$json["file"] = $file;
		$json["filename"] = 'ReceiptTotals_'.$curdate.'.xlsx';
		$json["success"] = true;
		
		$filename='ReceiptTotals_'.$curdate.'.xlsx'; //save our workbook as this file name
		
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
		
	function receipts_download(){
		$name = $this->session->userdata("file");
		force_download($name, NULL);
		}
		
		
}
