
<div id="wrapper">
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
           <!-- <a class="navbar-brand" href="index.html">SB Admin v2.0</a>-->
            <a href="<?php echo base_url('backoffice')?>"><img src="<?php echo base_url('assets/img/company_logo.png')?>"></a>
            <strong id="tabtitle" style="font-size:1.3em;"></strong>
        </div>
        <!-- /.navbar-header -->
        <ul class="nav navbar-top-links navbar-right">
        	<li><a href="<?php echo base_url("backoffice/reports")?>" style="outline:0;color:#3C6;">
                    <span class="icon-32-back"></span>
                    Report Menu
                </a>
            </li>
			<li><?php echo "Station: <label style='color:#3C6;'>".$StationName."</label>"; ?></li>
			<li><?php echo "Location: <label style='color:#3C6;'>".$StoreName."</label>"; ?></li>  
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li>
                    	<span style="color:#00F; margin-left:5px;">Logged: <?php echo $currentuser ?></span>
                    </li>
                    <li class="divider"></li>
                    <li>
                    	<a href="<?php echo base_url("backoffice/logout") ?>"><i class="fa fa-sign-out fa-fw"></i>Logout</a>
                    </li>
                </ul>
            </li>
        </ul>  
    </nav>
    <div style="margin-bottom: 0; background-color: rgba(50, 50, 50, 0.1); height:40px; width:100%; padding-top:3px;">
    	<div style="float:left; padding:2px;">
        	<a class="btn btn-success" href="<?php echo base_url("backoffice/dashboard")?>" style="outline:0;">
               Home
            </a>
        </div>
        <div style="float:left; padding:2px;">
        	<a class="btn btn-primary" style="outline:0;" href="<?php echo base_url("backoffice/reports")?>">
               Back
            </a>
		</div>
		
		 <div style="float:left; padding:2px;">
        	<a class="btn btn-default" style="outline:0;font:bold;" >
               <h2>Receipt Totals Report</h2>
            </a>
		</div>
 
</div>

<div id="wrapper">
   <div style="margin-bottom: 10; background-color: rgba(50, 50, 50, 0.1); height:50px; width:100%; padding-top:3px; ">
		 <table>
			<tr>
				<td><label class='btn btn-primary'>Start Date</label></td>
				<td><label class='btn'><div id="calendar_From"></div></label></td>
				<td><label class='btn btn-primary'>End Date</label></td>
				<td><label class='btn'><div id="calendar_To"></div></label></td>
				<td><label class='btn btn-primary'><div id="Label"></div>Status</label></td>
				<td><label class='btn'><div id="status"></div></label></td>
				<td><input class="btn btn-primary" type="button" style="color: white;margin-left:10px;" id="SubmitDateRange" value="Search" /></td>
				<td><input class="btn btn-primary" type="button" style="color: white;margin-left:10px;" id="clearfilteringbutton" value="Clear Filters" /></td> 
				<td><input class="btn btn-primary" type="button" style="color: white;margin-left:10px;" id="pdfExport" value="PDF" /></td>	
				<td><input class="btn btn-primary" type="button" style="color: white;margin-left:10px;" id="DownloadExcel" value="Excel" /></td>					
			</tr>
		</table>
		
    </div>
</div>

<link rel="stylesheet" href="../../assets/css/reset.css" type="text/css" />
<link rel="stylesheet" href="../../assets/js/jqwidgets/styles/jqx.base.css" type="text/css" />
<link rel="stylesheet" href="../../assets/js/jqwidgets/styles/jqx.energyblue.css" type="text/css" />
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
	var SiteRoot = "<?php echo base_url()?>";
	
	$(document).ready(function(){
		
	var theme = getDemoTheme();	

		$("#calendar_From").jqxDateTimeInput({width: '150px', height: '30px', theme: "energyblue", formatString: "yyyy-MM-dd"});
		$("#calendar_To").jqxDateTimeInput({width: '150px', height: '30px', theme: "energyblue", formatString: "yyyy-MM-dd"});
		
	//var source-old = [
    // "Completed", "On Hold", "Cancelled"
	//	        ];
	
    //Create a jqxDropDownList
        //$("#status").jqxDropDownList({theme: "energy-blue", enableBrowserBoundsDetection:false, autoDropDownHeight: true,
		//placeHolder: "Select:", source: source, selectedIndex: 0, width: '200', height: '30'});
				
	var StatusData = [
                { ID: 4, Status: "Completed" },
                { ID: 5, Status: "On Hold" },
                { ID: 10, Status: "Cancelled" }
                ];
				
	var source =
                {
                    localdata: StatusData,
                    datatype: "array",
                    datafields: [
                    { name: 'ID' },
                    { name: 'Status' }
                    ]
                };
     
	 var dataAdapter = new $.jqx.dataAdapter(source);
	 
	 $("#status").jqxDropDownList(
        {
        theme: "energy-blue", height: '30px',  width: '200px', source: dataAdapter,
        valueMember: 'ID', displayMember: 'Status'//,checkboxes: true
        });

	$("#status").jqxDropDownList('selectItem', 4); // select the default value (using the integer id)
	
	
	$("#SubmitDateRange").click(function(){
		get_salesdetails();
		//date_from = $("#calendar_From").val();
		//date_to = $("#calendar_To").val();
		//status = $("#status").val();
		//alert(date_from+"/"+date_to+"/"+status)
		})
	
	/*generate report automatically when load page
	//$(function(){
	//	get_salesdetails();
	})
	*/
	
	function get_salesdetails(){
		 status = $("#status").val();
		 date_from = $("#calendar_From").val();
		 date_to = $("#calendar_To").val();
		 
		 /*
		 $.ajax({
			url: 'http://localhost/akback/backoffice/reports/receipts_select/'+date_from+'/'+date_to,
			type: 'GET',
			beforeSend: function(){
				$('body').block({message: 'Loading...'})
			},
			success: function(data){
				$('body').unblock();
				console.log(data);
		 */
		 var postdata ="datefrom="+date_from;
		 	 postdata+="&dateto="+date_to;
			 postdata+="&status="+status;
	 
		$.ajax({
			//url: 'http://backoffice/akback/backoffice/reports/receipts_select',
			url: window.location.origin + '/akback/backoffice/reports/receipts_select',
			type: 'POST',
			data: postdata,
			beforeSend: function(){
				$('body').block({message: 'Loading...'})
			},
			success: function(data){
				$('body').unblock();
				//console.log(data);	
		 
		 var theme = getDemoTheme();
		 //var url = "action.php?action=get_salesdetail&query="+query+"&startdate="+date_from+"&enddate="+date_to+"";
		 //var url = "http://localhost/backoffice/windward/ww_matrixsales/2015-12-01/2015-12-14";
		 //var url = "http://localhost/backoffice/windward/ww_matrixsales/"+date_from+"/"+date_to;
		 //var base_url = "/backoffice/";
		 
		 //var url = window.location.origin + '/akback/backoffice/reports/receipts_select/'+date_from+'/'+date_to;
            
			// prepare the data
			   var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'ReceiptID', type: 'integer' },
					{ name: 'LocationName', type: 'string' },
                    { name: 'StationName', type: 'string' },
					{ name: 'User', type: 'string' },
					{ name: 'ReceiptNumber', type: 'string' },
					{ name: 'Customer', type: 'string' },
					{ name: 'SubTotal', type: 'number' },
					{ name: 'Tip', type: 'number' },
					{ name: 'Tax', type: 'number' },
					{ name: 'Total', type: 'number' },
					{ name: 'Paid', type: 'number' },
					{ name: 'Balance', type: 'number' },
					{ name: 'CreatedDate', type: 'date'},
                    { name: 'TransactionDate', type: 'date',format:"yyyy-MM-dd"},
                    { name: 'ReceiptStatus', type: 'string' }
					        ],
				id:'id',
                //url: url,
				localdata: data,
				root:'data'
            };		

	$('#jqxgrid').on('bindingcomplete', function (event) {
     //alert("Binding is completed" );			
			 });
			
            var dataAdapter = new $.jqx.dataAdapter(source);
				
            $("#jqxgrid").jqxGrid(
            {
                width: '100%',
				//height: 570, or '100%'
				autoheight: true,
				theme: "energyblue",
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
				//filtermode:'excel',
				//selectionmode: 'multiplecellsextended',
				showfilterrow: true,
				autoshowfiltericon: true,
				ready: function () {
                    // callback function which is called by jqxGrid when the widget is initialized and the binding is completed.
                },

                columns: [
					{ text: 'Location', dataField: 'LocationName', filtertype: 'checkedlist',width: '10%',align: 'left',cellsalign: 'left' },
					{ text: 'Station', dataField: 'StationName', filtertype: 'checkedlist',width: '10%',align: 'left',cellsalign: 'left' },
					{ text: 'User', dataField: 'User', width: '10%',filtertype: 'checkedlist',align: 'left',cellsalign: 'left' },	
					{ text: 'Date', dataField: 'CreatedDate', cellsformat: 'MM/dd/yy hh:mm tt',width: '10%',filtertype: 'input',align: 'left',cellsalign: 'left'},					
					{ text: 'Receipt', dataField: 'ReceiptNumber', filtertype: 'input',width: '10%',align: 'right',cellsalign: 'right',
						aggregates: ['count'], aggregatesrenderer: function (aggregates, column, element, summaryData) {
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
						}
					},
					{ text: 'SubTotal', dataField: 'SubTotal', cellsformat: 'd2',width: '10%',align: 'right',cellsalign: 'right',
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
						}	
					},
					{ text: 'Tip', dataField: 'Tip', cellsformat: 'd2',width: '5%',align: 'right',cellsalign: 'right',
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
						}	
					},					
					 { text: 'Tax', dataField: 'Tax', cellsformat: 'd2',width: '5%',align: 'right',cellsalign: 'right',
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
						}
					},
					 { text: 'Total', dataField: 'Total', cellsformat: 'd2',width: '10%',align: 'right',cellsalign: 'right',
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
						}
					},
					 { text: 'Paid', dataField: 'Paid',cellsformat: 'd2',width: '10%',align: 'right',cellsalign: 'right',
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
						}
					},
					 { text: 'Balance', dataField: 'Balance', cellsformat: 'd2',width: '10%',align: 'right',cellsalign: 'right',
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
						}
					}
					//{ text: 'Status', dataField: 'ReceiptStatus', filtertype: 'checkedlist',width: '10%',align: 'left',cellsalign: 'left' }
						]
    
			});
			
			},
			error: function(){
				alert('error');
				$('body').unblock();
			}
		 })
			
			
			$('#clearfilteringbutton').jqxButton({ height: 30});
            $('#clearfilteringbutton').click(function () {
                $("#jqxgrid").jqxGrid('clearfilters');
            });
			
	}
	})
	$(document).ready(function(){
	 $("#pdfExport").click(function () {
                $("#jqxgrid").jqxGrid('exportdata', 'pdf', 'backoffice Receipt Totals Report');
            });
	})

	$(document).ready(function(){
			 
		$("#DownloadExcel").click(function(){
			
			status = $("#status").val();
			date_from = $("#calendar_From").val();
			date_to = $("#calendar_To").val();
			
			var postdata ="datefrom="+date_from;
		 	postdata+="&dateto="+date_to;
			postdata+="&status="+status;
			console.log(postdata);
			
			//var excelDownload = 'http://localhost/backoffice/windward/ww_matrixsales_excel/'+date_from+'/'+date_to;
			//var excelDownload = window.location.origin + '/akback/backoffice/reports/payments_excel/'+date_from+'/'+date_to;
			//window.location.href = (excelDownload);
			//alert('Please Wait while Excel Generates');
			
			//var post_data = "http://localhost/backoffice/windward/ww_matrixsales_excel/"+date_from+'/'+date_to
				
			 
		$.ajax({
			url: window.location.origin + '/akback/backoffice/reports/receipts_export',
			type: 'POST',
			data: postdata,
			beforeSend: function(){
				$('body').block({message: 'Loading...'})
			},

			success: function(data){
				$('body').unblock();
				console.log(data);	
				//window.open('http://backoffice/akback/backoffice/reports/receipts_download','_blank' );
				window.location = (window.location.origin + '/akback/backoffice/reports/receipts_download');
				
			},
			error: function(){
				alert('No Data or Error');
				$('body').unblock();
			}
			
		 })				
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
		color:blue;
	}

	#creek_navigation{
		float: left;
		width: 40px;
		height: 768px;
	}
	
	#creek_content{
	  position: relative;
    min-height: 150px;
	}


	#calendar_To {
		float: left;
		font-size: 10px;
	}
	
	#SubmitDateRange{

	}
	
	#DownloadExcel{

	}
	
	
	#selection_daterange{

	}

	#main_content{
		overflow: hidden;
	}
	
	h1{
		font-size: 24px;
		color: green;
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
		 bottom: 25;
    left: 0;
		
	}
	
	.lbl2 {
		font-weight: bolder;
	}
	
	
	input[type="button"] 
	{
		background: #5cb85c;	
	}

	
	
</style>
</head>

<body>
	<div id="creek_content">
		<div id="main_content">
			<div id='jqxWidget' style="font-size: 50px; font-family: Verdana;">
				<div id="jqxgrid"></div>
			 </div>
				 
		</div>
	</div>

</body>

