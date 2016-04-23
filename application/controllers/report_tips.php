<?php defined('BASEPATH') OR exit('No direct script access allowed');

class report_tips extends CI_Controller {
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
	
	public function tips_view(){
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
			
			$data['main_content'] = "backoffice_reports/report_tips_view";
			$this->load->view('backoffice_templates/backoffice_reports_template', $data);
			
		}else{
			redirect('login/login');
		}
	}
	
	//echo array cm 20160312
	public function tips_echo(){
		if($this->_is_logged_in()){	
			$data['results'] = $this->Reports_model->get_tips_report();
			echo '<pre>';
			print_r($data['results']);
		}else{
			redirect('login/login');
		}
	}

	
//generate report by date range cm 20160312
	public function tips_select(){
		if($this->_is_logged_in()){	
			$StartDate =  $this->input->post('datefrom');
			$EndDate =  $this->input->post('dateto');
			//$Status =  $this->input->post('status');
			//$Status = 12;
			$json = array();
			
			$result=$this->Reports_model->get_tips_report_date($StartDate,$EndDate);
		
			if($result){
				foreach($result as $row)
				{
					$json[] = array(
					"ReceiptNumber" => trim($row['ReceiptNumber']),
					"ReceiptUser" => trim($row['ReceiptUser']),
					"ReceiptSubTotal" => trim($row['ReceiptSubTotal']),
					"ReceiptTip" => trim($row['ReceiptTip']),
					"ReceiptTax" => trim($row['ReceiptTax']),
					"ReceiptTotal" => trim($row['ReceiptTotal']),
					"PayMethod" => trim($row['PayMethod']),
					"Tendered" => trim($row['Tendered']),
					"Paid" => trim($row['Paid']),
					"Change" => trim($row['Change']),
					"PaidTip" => trim($row['PaidTip']),
					"PaymentDate" => trim($row['PaymentDate']),
					"PaymentUser" => trim($row['PaymentUser']),
					"Status" => trim($row['Status'])
					);			
				}	
			}
			echo json_encode($json);
		}else{
			redirect('login/login');
		}
	}
	
	
//excel export	
	public function tips_export(){
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
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Item Sales');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		$objPHPExcel->getActiveSheet()->setTitle('Item Sales');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		
		 // set column titles
		$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Item');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Description');
		$objPHPExcel->getActiveSheet()->setCellValue('C3', 'Date');
		$objPHPExcel->getActiveSheet()->setCellValue('D3', 'List Price');
		$objPHPExcel->getActiveSheet()->setCellValue('E3', 'Discount');
		$objPHPExcel->getActiveSheet()->setCellValue('F3', 'Sell Price');
		$objPHPExcel->getActiveSheet()->setCellValue('G3', 'Quantity');
		$objPHPExcel->getActiveSheet()->setCellValue('H3', 'Ext Sell');
		$objPHPExcel->getActiveSheet()->setCellValue('I3', 'Total');
		$objPHPExcel->getActiveSheet()->setCellValue('J3', 'Location');
		$objPHPExcel->getActiveSheet()->setCellValue('K3', 'User');
		
		//page settings
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		//$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

		//format data label row 		
		$objPHPExcel->getActiveSheet()->getStyle('A3:K3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A3:J3')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A3:C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->getStyle('D3:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('J3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		
		$curdate = date("Y-m-d_his");
		
		for($col = ord('A'); $col <= ord('C'); $col++){
            //set column dimension
            $objPHPExcel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
            //change the font size
            $objPHPExcel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12); 		
            $objPHPExcel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);		
        }
		
		for($col = ord('D'); $col <= ord('I'); $col++){
            //set column dimension
            $objPHPExcel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
            //change the font size
			$objPHPExcel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12); 		
			$objPHPExcel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		
			$objPHPExcel->getActiveSheet()->getStyle(chr($col))->getNumberFormat()->setFormatCode("#,##".$formatNumbers."");
        }
		
		for($col = ord('J'); $col <= ord('L'); $col++){	
			$objPHPExcel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle(chr($col))->getNumberFormat()->setFormatCode("#,##".$formatNumbers."");
			$objPHPExcel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
        }
		
		$json = array();
		$result_export=$this->Reports_model->get_itemsales_report_date($StartDate,$EndDate);
		//$convert = json_decode($result_export, true);
		
		$exceldata="";
	
		if($result_export){		
				$Quantity = 0;
				$ExtSell = 0;
				$Total = 0;
				$rowCount = 4; //starting row to count from
				
			foreach ($result_export as $row){	
				$exceldata[] = array(
					"ReceiptNumber" => trim($row['ReceiptNumber']),
					"ReceiptUser" => trim($row['ReceiptUser']),
					"ReceiptSubTotal" => trim($row['ReceiptSubTotal']),
					"ReceiptTip" => trim($row['ReceiptTip']),
					"ReceiptTax" => trim($row['ReceiptTax']),
					"ReceiptTotal" => trim($row['ReceiptTotal']),
					"PayMethod" => trim($row['PayMethod']),
					"Tendered" => trim($row['Tendered']),
					"Paid" => trim($row['Paid']),
					"Change" => trim($row['Change']),
					"PaidTip" => trim($row['PaidTip']),
					"PaymentDate" => trim($row['PaymentDate']),
					"PaymentUser" => trim($row['PaymentUser']),
					"Status" => trim($row['Status'])						
					);
	
					$Quantity += $row["Quantity"];
					$ExtSell += $row["ExtSellPrice"];
					$Total += $row["Total"];
					
					$rowCount++;					
			}
			$objPHPExcel->getActiveSheet()->getStyle('G'.$rowCount.':I'.$rowCount)->getFont()->setBold(true);
			
			$objPHPExcel->getActiveSheet()->getStyle('G'.$rowCount)->getNumberFormat()->setFormatCode("#,##".$formatNumbers."");
			$objPHPExcel->getActiveSheet()->getStyle('H'.$rowCount)->getNumberFormat()->setFormatCode("#,##".$formatNumbers."");
			$objPHPExcel->getActiveSheet()->getStyle('I'.$rowCount)->getNumberFormat()->setFormatCode("#,##".$formatNumbers."");
			
			$objPHPExcel->setActiveSheetIndex()
				->setCellValue('G'.$rowCount, $Quantity)
				->setCellValue('H'.$rowCount, $ExtSell)
				->setCellValue('I'.$rowCount, $Total);
			}
	
		//var_dump($exceldata);
				
        //Fill data 
        $objPHPExcel->getActiveSheet()->fromArray($exceldata, null, 'A4');
		
		$curdate = date("Y-m-d_his");
		
		$objPHPExcel->setActiveSheetIndex(0);
				
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('assets/download/ItemSales_'.$curdate.'.xlsx');
				
		$file = 'assets/download/ItemSales_'.$curdate.'.xlsx';	
				
		$data["file"] = $file;
		$data["filename"] = $file;
		$this->session->unset_userdata($data);
		$this->session->set_userdata($data);
				
		$json["file"] = $file;
		$json["filename"] = 'ItemSales_'.$curdate.'.xlsx';
		$json["success"] = true;
		
		$filename='ItemSales_'.$curdate.'.xlsx'; //save our workbook as this file name
		
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
		
	function tips_download(){
		$name = $this->session->userdata("file");
		force_download($name, NULL);
		}
}
