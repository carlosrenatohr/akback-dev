<?php defined('BASEPATH') OR exit('No direct script access allowed');

class report_itemreturns extends CI_Controller {
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
	
	//load item sales view cm 20160312
	public function itemreturns_view(){
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
			
			$data['main_content'] = "backoffice_reports/report_itemreturns_view";
			$this->load->view('backoffice_templates/backoffice_reports_template', $data);
			
		}else{
			redirect('login/login');
		}
	}
	
	//echo array cm 20160312
	public function itemreturns_echo(){
		if($this->_is_logged_in()){	
			$data['results'] = $this->Reports_model->get_itemreturns_report();
			echo '<pre>';
			print_r($data['results']);
		}else{
			redirect('login/login');
		}
	}

	
//generate report by date range cm 20160312
	public function itemreturns_select(){
		if($this->_is_logged_in()){	
			$StartDate =  $this->input->post('datefrom');
			$EndDate =  $this->input->post('dateto');
			//$Status =  $this->input->post('status');
			//$Status = 12;
			$json = array();
			
			$result=$this->Reports_model->get_itemreturns_report_date($StartDate,$EndDate);
		
			if($result){
				foreach($result as $row)
				{
					$json[] = array(
					"ReceiptNumber" => trim($row['ReceiptNumber']),
					"TransactionDate" => trim($row['TransactionDate']),
					"Item" => trim($row['Item']),
					"Description" => trim($row['Description']),
					"Quantity" => trim($row['Quantity']),
					"ListPrice" => trim($row['ListPrice']),
					"Discount" => trim($row['Discount']),
					"SellPrice" => trim($row['SellPrice']),
					"ExtSellPrice" => trim($row['ExtSellPrice']),
					"Tax" => trim($row['Tax']),
					"Total" => trim($row['Total']),
					"LocationName" => trim($row['LocationName']),
					"User" => trim($row['User'])
					);
				}	
			}
			echo json_encode($json);
		}else{
			redirect('login/login');
		}
	}
	
	
//excel export	
	public function itemreturns_export(){
	if($this->_is_logged_in()){
		$StartDate = $this->input->post('datefrom');
		$EndDate = $this->input->post('dateto');
		//$Status = $this->input->post('status');
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
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Item Returns');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		$objPHPExcel->getActiveSheet()->setTitle('Item Returns');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		
		 // set column titles
		$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Location');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'User');
		$objPHPExcel->getActiveSheet()->setCellValue('C3', 'Date');
		$objPHPExcel->getActiveSheet()->setCellValue('D3', 'Receipt');
		$objPHPExcel->getActiveSheet()->setCellValue('E3', 'Item');
		$objPHPExcel->getActiveSheet()->setCellValue('F3', 'Description');
		$objPHPExcel->getActiveSheet()->setCellValue('G3', 'Price');
		$objPHPExcel->getActiveSheet()->setCellValue('H3', 'Quantity');
		$objPHPExcel->getActiveSheet()->setCellValue('I3', 'Total');

		
		//page settings
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		//$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

		//format data label row 		
		$objPHPExcel->getActiveSheet()->getStyle('A3:I3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A3:I3')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A3:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->getStyle('G3:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		
		$curdate = date("Y-m-d_his");
		
		for($col = ord('A'); $col <= ord('F'); $col++){
            //set column dimension
            $objPHPExcel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
            //change the font size
            $objPHPExcel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12); 		
            $objPHPExcel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);		
        }
		
		for($col = ord('G'); $col <= ord('I'); $col++){
            //set column dimension
            $objPHPExcel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
            //change the font size
			$objPHPExcel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12); 		
			$objPHPExcel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		
			$objPHPExcel->getActiveSheet()->getStyle(chr($col))->getNumberFormat()->setFormatCode("#,##".$formatNumbers."");
        }
		
		$json = array();
		$result_export=$this->Reports_model->get_itemreturns_report_date($StartDate,$EndDate);
		//$convert = json_decode($result_export, true);
		
		$exceldata="";
	
		if($result_export){		
				$Quantity = 0;
				$ExtSellPrice= 0;
				$Total = 0;
				$rowCount = 4; //starting row to count from
								
			foreach ($result_export as $row){	
				$exceldata[] = array(
					"LocationName" => trim($row['LocationName']),
					"User" => trim($row['User']),
					"TransactionDate" => trim($row['TransactionDate']),
					"ReceiptNumber" => trim($row['ReceiptNumber']),
					"Item" => trim($row['Item']),
					"Description" => trim($row['Description']),
					"SellPrice" => trim($row['SellPrice']),
					"Quantity" => trim($row['Quantity']),
					"Total" => trim($row['Total']),								
					);
	
					$Quantity += $row["Quantity"];
					$ExtSellPrice += $row["ExtSellPrice"];
					$Total += $row["Total"];
					
					$rowCount++;					
			}
			$objPHPExcel->getActiveSheet()->getStyle('G'.$rowCount.':I'.$rowCount)->getFont()->setBold(true);
			
			$objPHPExcel->getActiveSheet()->getStyle('G'.$rowCount)->getNumberFormat()->setFormatCode("#,##".$formatNumbers."");
			$objPHPExcel->getActiveSheet()->getStyle('H'.$rowCount)->getNumberFormat()->setFormatCode("#,##".$formatNumbers."");
			$objPHPExcel->getActiveSheet()->getStyle('I'.$rowCount)->getNumberFormat()->setFormatCode("#,##".$formatNumbers."");
			
			$objPHPExcel->setActiveSheetIndex()
				->setCellValue('G'.$rowCount, $ExtSellPrice)
				->setCellValue('H'.$rowCount, $Quantity)
				->setCellValue('I'.$rowCount, $Total);
			}
	
		//var_dump($exceldata);
				
        //Fill data 
        $objPHPExcel->getActiveSheet()->fromArray($exceldata, null, 'A4');
		
		$curdate = date("Y-m-d_his");
		
		$objPHPExcel->setActiveSheetIndex(0);
				
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('assets/download/ItemReturns_'.$curdate.'.xlsx');
				
		$file = 'assets/download/ItemReturns_'.$curdate.'.xlsx';	
				
		$data["file"] = $file;
		$data["filename"] = $file;
		$this->session->unset_userdata($data);
		$this->session->set_userdata($data);
				
		$json["file"] = $file;
		$json["filename"] = 'ItemReturns_'.$curdate.'.xlsx';
		$json["success"] = true;
		
		$filename='ItemReturns_'.$curdate.'.xlsx'; //save our workbook as this file name
		
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
		
	function itemreturns_download(){
		$name = $this->session->userdata("file");
		force_download($name, NULL);
		}
}
