<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>backoffice | Payments</title>
<link rel="icon" type="image/ico" href="/backoffice/backoffice.ico">
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<link rel="stylesheet" href="../../assets/css/reset.css" type="text/css" />
<link rel="stylesheet" href="../../assets/js/jqwidgets/styles/jqx.base.css" type="text/css" />
<link media="screen" href="../../assets/js/jqwidgets/styles/jqx.ui-start.css" rel="stylesheet">
<link media="screen" href="../../assets/js/jqwidgets/styles/jqx.orange.css" rel="stylesheet">
<link media="screen" href="../../assets/js/jqwidgets/styles/jqx.ui-le-frog.css" rel="stylesheet">
<link media="screen" href="../../assets/js/jqwidgets/styles/jqx.metrodark.css" rel="stylesheet">
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxdata.js"></script> 
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxbuttons.js"></script>
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxmenu.js"></script>
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxcheckbox.js"></script>
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxlistbox.js"></script>
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxdropdownlist.js"></script>
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxcombobox.js"></script>
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxgrid.js"></script>
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxgrid.sort.js"></script> 
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxgrid.pager.js"></script> 
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxgrid.selection.js"></script> 
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxgrid.edit.js"></script>
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxdatetimeinput.js"></script>
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxcalendar.js"></script>
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxtooltip.js"></script>
<script type="text/javascript" src="../../assets/js/jqwidgets/globalization/globalize.js"></script>
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxbuttons.js"></script>
<script type="text/javascript" src="../../assets/js/jqwidgetscripts/gettheme.js"></script>
<script type="text/javascript" src="../../assets/js/jqwidgetscripts/generatedata.js"></script>
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxgrid.filter.js"></script>
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxgrid.columnsresize.js"></script> 
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxdropdownlist.js"></script>
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxgrid.aggregates.js"></script> 
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxprogressbar.js"></script>
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxgrid.grouping.js"></script>
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxdata.export.js"></script>
<script type="text/javascript" src="../../assets/js/jqwidgets/jqxgrid.export.js"></script>

<script type="text/javascript">

	$(document).ready(function(){
		
		var theme = getDemoTheme();	
		$(".submitbutton").jqxButton({ width: '100', height: '25px', theme: "energyblue"});	
		$("#so_download").jqxButton({ width: '40', height: '25px', theme: "energyblue"});
		$("#calendar_From").jqxDateTimeInput({width: '150px', height: '25px', theme: "energyblue", formatString: "yyyy-MM-dd"});
		$("#calendar_To").jqxDateTimeInput({width: '150px', height: '25px', theme: "energyblue", formatString: "yyyy-MM-dd"});
		
		
		var source = [

                   "Payment Date"
		        ];
                // Create a jqxDropDownList
                $("#salesdetailsby").jqxDropDownList({theme: "energy-blue", enableBrowserBoundsDetection:false, autoDropDownHeight: true,
									placeHolder: "Select:", source: source, selectedIndex: 0, width: '200', height: '25'});
	


		$("#SubmitDateRange").click(function(){
			get_salesdetails();
			query = $("#salesdetailsby").val();
		    date_from = $("#calendar_From").val();
			date_to = $("#calendar_To").val();
			//alert(query+" "+date_from+" "+date_to)
		})
		
	
	})
	
	/*generate report automatically when load page
	//$(function(){
	//	get_salesdetails();
	})
	*/
	
	
	function get_salesdetails(){
		 query = $("#salesdetailsby").val();
		 date_from = $("#calendar_From").val();
		 date_to = $("#calendar_To").val();
		 
		 var theme = getDemoTheme();
		 //var url = "action.php?action=get_salesdetail&query="+query+"&startdate="+date_from+"&enddate="+date_to+"";
		 //var url = "http://localhost/backoffice/windward/ww_matrixsales/2015-12-01/2015-12-14";
		 //var url = "http://localhost/backoffice/windward/ww_matrixsales/"+date_from+"/"+date_to;
		 //var base_url = "/backoffice/";
		 
		 //var url = window.location.origin + '/akback/backoffice/reports/payments_date/'+date_from+'/'+date_to;

            
			// prepare the data
			   var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'StationNumber', type: 'integer' },
                    { name: 'StationName', type: 'string' },
					{ name: 'User', type: 'string' },
					{ name: 'ReceiptNumber', type: 'string' },
					{ name: 'ReceiptTotal', type: 'number' },
                    { name: 'TransactionDate', type: 'date',format:"yyyy-MM-dd"},
                    { name: 'CreatedDate', type: 'date'},
                    { name: 'PayMethod', type: 'string' },
					{ name: 'PayAmount', type: 'number' },
					{ name: 'PayApply', type: 'number' },
					{ name: 'Change', type: 'number' }
                ],
				id:'id',
                url: url,
				root:'data'
            };
			
            var dataAdapter = new $.jqx.dataAdapter(source);
			
				
            $("#jqxgrid").jqxGrid(
            {
                width: true,
				//height: 570,
				autoheight: true,
				theme: "ui-start",
                source: dataAdapter,
                columnsresize: true,
				altrows:true,
				sortable: true,
                pageable: true,
				//groupable:true,
				//showgroupsheader:true,
				pagesize: 20,
				pagermode: 'default', //or simple
				showaggregates: true,
				showstatusbar: true,
                statusbarheight: 40,
				enabletooltips: true,
                filterable: true,
				filtermode:'excel',
				//selectionmode: 'multiplecellsextended',
				//showfilterrow: true,
				autoshowfiltericon: true,
                columns: [
                     //{ text: 'Station', dataField: 'StationNumber', width: '5%',filtertype: 'input'},
					{ text: 'Station', dataField: 'StationName', width: '10%',filtertype: 'input',align: 'left',cellsalign: 'left' },
					{ text: 'User', dataField: 'User', width: '10%',filtertype: 'input',align: 'left',cellsalign: 'left' },
					{ text: 'Date', dataField: 'CreatedDate', cellsformat: 'M/d/yyyy h:mm tt',width: '10%',filtertype: 'input',align: 'left',cellsalign: 'left'},					
					{ text: 'Receipt #', dataField: 'ReceiptNumber', width: '10%',filtertype: 'input',align: 'right',cellsalign: 'right' },
					{ text: 'Total', dataField: 'ReceiptTotal', cellsformat: 'd2',width: '10%',filtertype: 'input',align: 'right',cellsalign: 'right'},
                     { text: 'Tendered', dataField: 'PayAmount', cellsformat: 'd2',width: '10%',filtertype: 'input',align: 'right',cellsalign: 'right',
						aggregates: ['sum'], aggregatesrenderer: function (aggregates, column, element, summaryData) {
                          var renderstring = "<div class='jqx-widget-content jqx-widget-content-" + theme + "' style='float: left; width: 100%; height: 100%;'>";
                          $.each(aggregates, function (key, value) {
                              var name = key == 'sum' ? 'Sum' : 'Avg';
                              var color = 'red';
                              if (key == 'sum' && summaryData['sum'] < 650) {
                                  color = 'red';
                              }
                              
                              renderstring += '<div style="color: ' + color + '; position: relative; margin: 6px; text-align: right; overflow: hidden;">' + value + '</div>';
                          });
                          renderstring += "</div>";
                          return renderstring;
					}},
					 { text: 'Received', dataField: 'PayApply', cellsformat: 'd2',width: '10%',filtertype: 'input',align: 'right',cellsalign: 'right',
						aggregates: ['sum'], aggregatesrenderer: function (aggregates, column, element, summaryData) {
                          var renderstring = "<div class='jqx-widget-content jqx-widget-content-" + theme + "' style='float: left; width: 100%; height: 100%;'>";
                          $.each(aggregates, function (key, value) {
                              var name = key == 'sum' ? 'Sum' : 'Avg';
                              var color = 'red';
                              if (key == 'sum' && summaryData['sum'] < 650) {
                                  color = 'red';
                              }
                              
                              renderstring += '<div style="color: ' + color + '; position: relative; margin: 6px; text-align: right; overflow: hidden;">' + value + '</div>';
                          });
                          renderstring += "</div>";
                          return renderstring;
					}},
					 { text: 'Change', dataField: 'Change', cellsformat: 'd2',width: '10%',align: 'right',cellsalign: 'right',
						aggregates: ['sum'], aggregatesrenderer: function (aggregates, column, element, summaryData) {
                          var renderstring = "<div class='jqx-widget-content jqx-widget-content-" + theme + "' style='float: left; width: 100%; height: 100%;'>";
                          $.each(aggregates, function (key, value) {
                              var name = key == 'sum' ? 'Sum' : 'Avg';
                              var color = 'red';
                              if (key == 'sum' && summaryData['sum'] < 650) {
                                  color = 'red';
                              }
                              
                              renderstring += '<div style="color: ' + color + '; position: relative; margin: 6px; text-align: right; overflow: hidden;">' + value + '</div>';
                          });
                          renderstring += "</div>";
                          return renderstring;
					}},
					 { text: 'Method', dataField: 'PayMethod', width: '10%',filtertype: 'input',align: 'right',cellsalign: 'right'},
						]
            });
	}
	
	$(document).ready(function(){
	 $("#pdfExport").click(function () {
                $("#jqxgrid").jqxGrid('exportdata', 'pdf', 'backoffice Payments Report');
            });
	})

	$(document).ready(function(){
			 
		$("#DownloadExcel").click(function(){
			 
			 query = $("#salesdetailsby").val();
			 date_from = $("#calendar_From").val();
			 date_to = $("#calendar_To").val();
			 
			 var post_data="query="+query;
				 post_data+="&startdate="+date_from;
				 post_data+="&enddate="+date_to;
			
			var excelDownload = 'http://localhost/backoffice/windward/ww_matrixsales_excel/'+date_from+'/'+date_to;
			window.location.href = (excelDownload);
			alert('Please Wait while Excel Generates');
			
			//var post_data = "http://localhost/backoffice/windward/ww_matrixsales_excel/"+date_from+'/'+date_to

			 
		})
	})
	
	$(document).on("click", "a.fileDownloadSimpleRichExperience", function() {
	 
		$("#so_download").hide();
	 
		var $preparingFileModal = $("#preparing-file-modal");
 
		$preparingFileModal.dialog({ modal: true });
 
		$.fileDownload($(this).attr('href'), {
			successCallback: function(url) {
 
				$preparingFileModal.dialog('close');
				
			},
			failCallback: function(responseHtml, url) {
 
				$preparingFileModal.dialog('close');
				$("#error-modal").dialog({ modal: true });
			}
		});
		return false; //this is critical to stop the click event which will trigger a normal file download!
	});
	
	
</script>
<style type="text/css">
	#creek_container{
		height: auto;
		overflow: hidden;
	}

	#creek_header{
		margin-top: 10px;
		height: 50px;
		text-align: left;
	}
	
	#creek_header h1{
		color: #000;
		font-weight: bolder;
	}

	#creek_navigation{
		float: left;
		width: 40px;
		height: 768px;
	}
	
	#creek_content{
		float: left;
		height: auto;
		width: 100%;
	}


	#calendar_To {
		float: left;
		font-size: 10px;
	}
	
	#SubmitDateRange{
		margin-left: 10px;
		font-size: 12px;
		color: #000;
		font-weight: bolder;
	}
	
	#DownloadExcel{
		margin-left: 10px;
		font-size: 12px;
		color: #000;
		font-weight: bolder;
	}
	
	
	#selection_daterange{
		width: 1024px;
		height: auto;	
		margin-bottom: 10px;
	}

	#main_content{
		overflow: hidden;
	}
	
	h1{
		font-size: 24px;
		color: grey;
	}
	
	#so_download{
		text-decoration:none;
	}
	
	.jqx-grid-column-header
    {
        font-weight: bold;
		color: #000;
    }
	

	.jqx-dropdownlist-content{
		font-weight: bold;
		color: #000;
	}
	
	.lbl1{
		font-weight: bolder;
	}
	
	.lbl2 {
		font-weight: bolder;
	}
	
	
</style>
</head>

<body>
	<div id="creek_container">
		<div id="creek_header">
			<h1>Payments Report</h1>
		</div>
		
		<!--<div id="navigation"></div>-->
		<div id="creek_content">
			<div id="main_content">
				 <div id="selection_daterange">
					 <table>
						<tr>
							<td><div id='salesdetailsby'></div></td>
							<td><label class='lbl1'>Date From:</label></td>
							<td><div id="calendar_From"></div></td>
							<td><label class='lbl2'>Date To:</label></td>
							<td><div id="calendar_To"></div></td>
							<td><input type="button" class="submitbutton" id="SubmitDateRange" value="Display" /></td>
							<td><input type="button" class="submitbutton" id="pdfExport" value="PDF" /></td> 
							<td><input type="button" class="submitbutton" id="DownloadExcel" value="Excel" /></td> 

							<td><a id="so_download" href="" class="fileDownloadSimpleRichExperience" style="display:none;">Download</a></td>
							<!--<a href="<?php echo base_url()?>windward/ww_matrixsales_excel/$date_from/$date_to"> Excel</a> -->
						</tr>
						<tr>
							
						</tr>
						<tr>
							 
						</tr>
					 </table>
				 </div>
				 <div id='jqxWidget' style="font-size: 13px; font-family: Verdana;">
					<div id="jqxgrid"></div>
				 </div>
				 
			</div>
		</div>
	</div>
</body>
</html>
