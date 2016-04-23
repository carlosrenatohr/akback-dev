<?php
	supplierangular();
	jqxangularjs();
	jqxthemes();
?>
<script type="text/javascript">
	//-->Global Variable
	var SiteRoot = "<?php echo base_url()?>";
	var DynamicTab;
	var selzipcode, selzipunique, selcity, selstate, selisland, selcountry=null;
	var zipcodesDataAdapter = <?php echo $allzip;?>;
	var citiesDataAdapter = <?php echo $allcities;?>;
	var statesDataAdapter = <?php echo $allstates;?>;
	var islandDataAdapter = <?php echo $allisland;?>;	
	var countriesDataAdapter = <?php echo $allcountries;?>;
	var areacode;
	var intervalclosemessage = 5000;
	var global_custid, global_custname='';

	$(function(){
		changetabtile();
		checkAnyFormFieldEdited();
		checkAnyFormFieldAdd();
	
		//$("#zip").select2();
		//$("#add_zip").select2();
		//$("#add_city").select2();
		//$("#add_state").select2();
		//$("#add_county").select2();

		$(document).ready(function () {
			$(".searchinput").keyup(function () {
				$(this).next().toggle(Boolean($(this).val()));
			});
			$(".searchclear").toggle(Boolean($(".searchinput").val()));
			$(".searchclear").click(function () {
				$(this).prev().val('').focus();
				$(this).hide();
			});

			$(".edit_searchinput").keyup(function () {
				$(this).next().toggle(Boolean($(this).val()));
			});
			$(".edit_searchclear").toggle(Boolean($(".edit_searchinput").val()));
			$(".edit_searchclear").click(function () {
				$(this).prev().val('').focus();
				$(this).hide();
			});
		});
	});
	
	function changetabtile(){
		$("#tabtitle").html("Supplier");
	}
	
	var demoApp = angular.module("demoApp", ["jqwidgets"]);
	demoApp.controller("demoController", function ($scope, $compile) {
		
		
		$scope.dialogSettings =
		{
			created: function(args)
			{
				dialog = args.instance;
			},
			resizable: false,
			width: "100%", height: "100%",
			autoOpen: false,
			theme: 'darkblue',
			isModal: true,
			showCloseButton: false
		};

		$scope.addialogSettings =
		{
			created: function(args)
			{
				addialog = args.instance;
			},
			resizable: false,
			width: "100%", height: "100%",
			autoOpen: false,
			theme: 'darkblue',
			isModal: true,
			showCloseButton: false
		}
		
		$("#_cancel").click(function(){
			//window.location.reload();
			var changed = $("#_update").is(":disabled");
			if(changed){
				$("#tab1").unblock(); 
				$("#tab2").unblock(); 
				$("#tab3").unblock(); 
				reset_form();
				dialog.close();
				$scope.$apply(function(){
					$scope.tabset = {};
				});
				$scope.$apply(function(){
					$scope.tabset = {
						selectedItem: 0
					}
				})
				setTimeout(function(){
					$("#table input.jqx-input").focus();
				},500);
				
			}else{
				$("#_btnscd").hide();
				$("#msg").show();
				$("#msg_delete").hide();
				
				$('#edit_jqxNotification').jqxNotification('closeAll');
				var process6 = false;
				if($("#company").val() == ''){
					$("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
					$("#edit_notificationContent").html("Company is required field");
					$("#edit_jqxNotification").jqxNotification("open");
					$("#company").css({"border-color":"#f00"});
					process6 = false;
				}else{
					$("#company").css({"border-color":"#ccc"});
					process6 = true;
				}
				
				var process1 = false;
				var SelZipCode = $("#zipcode").jqxComboBox('getSelectedItem');
				var SelZipCodeText = $("#zipcode").val();
				if(SelZipCode){
					process1 = true;
				}else{
					if(SelZipCodeText == ''){
						process1 = true;
					}else{
						$("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true,  template: "error" });
						$("#edit_notificationContent").html("Zip code does not exist");
						$("#edit_jqxNotification").jqxNotification("open");
						process1 = false;
					}
				}
				
				
				var process2 = false;
				var SelCity = $("#city").jqxComboBox('getSelectedItem');
				var SelCityText = $("#city").val();
				if(SelCity){
					process2 = true;
				}else{
					if(SelCityText == ''){
						process2 = true;
					}else{
						$("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
						$("#edit_notificationContent").html("City does not exist");
						$("#edit_jqxNotification").jqxNotification("open");
						process2 = false;
					}
				}
				
				var process3 = false;
				var SelState = $("#state").jqxComboBox('getSelectedItem');
				var SelStateText = $("#state").val();
				if(SelState){
					process3 = true;
				}else{
					if(SelStateText == ''){
						process3 = true;
					}else{
						$("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
						$("#edit_notificationContent").html("State does not exist");
						$("#edit_jqxNotification").jqxNotification("open");
						process3 = false;
					}
				}
				
				var process4 = false;
				var SelIsland = $("#island").jqxComboBox('getSelectedItem');
				var SelIslandText = $("#island").val();
				if(SelIsland){
					process4 = true;
				}else{
					if(SelIslandText == ''){
						process4 = true;
					}else{
						$("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
						$("#edit_notificationContent").html("Island does not exist");
						$("#edit_jqxNotification").jqxNotification("open");
						process4 = false;
					}
				}
				
				var process5 = false;
				var SelCountry = $("#country").jqxComboBox('getSelectedItem');
				var SelCountryText = $("#country").val();
				if(SelCountry){
					process5 = true;
				}else{
					if(SelCountryText == ''){
						process5 = true;
					}else{
						$("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
						$("#edit_notificationContent").html("Country does not exist");
						$("#edit_jqxNotification").jqxNotification("open");
						process5 = false;
					}
				}
				
				var process7 = false;
				if($("#email").val() != ''){
					if(check_email($("#email").val())){
						$("#email").css({"border-color":"#ccc"});
						process7 = true;
					}else{
						$("#email").css({"border-color":"#F00"});
						process7 = false;
						$("#edit_email_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "mail" });
						$("#edit_email_notificationContent").html("Please type a valid email address");
						$("#edit_email_jqxNotification").jqxNotification("open");
					}
				}else{
					$("#email").css({"border-color":"#ccc"});
					process7 = true;
				}
				
				if(process1 == true && process2 == true && process3 == true && process4 == true && process5 == true && process6 == true && process7 == true){
					$('#tab1').block({message: null});
					$('#tab2').block({message: null});
					$('#tab3').block({message: null});
				}else{
					$scope.$apply(function(){
						$scope.tabset = {};
					});
					$scope.$apply(function(){
						$scope.tabset = {
							selectedItem: 0
						}
					});
				}
				//$("#_btnscd").hide();
				//$("#msg").show();
				//$("#msg_delete").hide();
			}
			$("#del_confirmation_msg").hide();
			$("#delmymessage").html("");
			$("#edit_email_message").text("");
		});
		
		$("#_no").click(function(){
			$scope.$apply(function(){
				$scope.tabset = {
					selectedItem: 0
				}
			});
			setTimeout(function(){
				$("#table input.jqx-input").focus();
			},500);
			dialog.close();
			reset_form();
		});
		
		$("#_conf_cancel").click(function(){
			$scope.$apply(function(){
				$scope.tabset = {
					selectedItem: 0
				}
			});
			$('#tab1').unblock(); 
			$('#tab2').unblock();
			$('#tab3').unblock(); 
			$("#msg").hide();
			$("#_btnscd").show();
			
			$("#firstname").focus();
		});
		
		$("#_update").click(function(){
			$('#edit_jqxNotification').jqxNotification('closeAll');
			var process6 = false;
			if($("#company").val() == ''){
				$("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
				$("#edit_notificationContent").html("Company is required field");
				$("#edit_jqxNotification").jqxNotification("open");
				$("#company").css({"border-color":"#f00"});
				process6 = false;
			}else{
				$("#company").css({"border-color":"#ccc"});
				process6 = true;
			}
			
			var process1 = false;
			var SelZipCode = $("#zipcode").jqxComboBox('getSelectedItem');
			var SelZipCodeText = $("#zipcode").val();
			if(SelZipCode){
				process1 = true;
			}else{
				if(SelZipCodeText == ''){
					process1 = true;
				}else{
					$("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true,  template: "error" });
					$("#edit_notificationContent").html("Zip code does not exist");
					$("#edit_jqxNotification").jqxNotification("open");
					process1 = false;
				}
			}
			
			var process2 = false;
			var SelCity = $("#city").jqxComboBox('getSelectedItem');
			var SelCityText = $("#city").val();
			if(SelCity){
				process2 = true;
			}else{
				if(SelCityText == ''){
					process2 = true;
				}else{
					$("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
					$("#edit_notificationContent").html("City does not exist");
					$("#edit_jqxNotification").jqxNotification("open");
					process2 = false;
				}
			}
			
			var process3 = false;
			var SelState = $("#state").jqxComboBox('getSelectedItem');
			var SelStateText = $("#state").val();
			if(SelState){
				process3 = true;
			}else{
				if(SelStateText == ''){
					process3 = true;
				}else{
					$("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
					$("#edit_notificationContent").html("State does not exist");
					$("#edit_jqxNotification").jqxNotification("open");
					process3 = false;
				}
			}
			
			var process4 = false;
			var SelIsland = $("#island").jqxComboBox('getSelectedItem');
			var SelIslandText = $("#island").val();
			if(SelIsland){
				process4 = true;
			}else{
				if(SelIslandText == ''){
					process4 = true;
				}else{
					$("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
					$("#edit_notificationContent").html("Island does not exist");
					$("#edit_jqxNotification").jqxNotification("open");
					process4 = false;
				}
			}
			
			var process5 = false;
			var SelCountry = $("#country").jqxComboBox('getSelectedItem');
			var SelCountryText = $("#country").val();
			if(SelCountry){
				process5 = true;
			}else{
				if(SelCountryText == ''){
					process5 = true;
				}else{
					$("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
					$("#edit_notificationContent").html("Country does not exist");
					$("#edit_jqxNotification").jqxNotification("open");
					process5 = false;
				}
			}
			
			var process7 = false;
			if($("#email").val() != ''){
				if(check_email($("#email").val())){
					$("#email").css({"border-color":"#ccc"});
					process7 = true;
				}else{
					$("#email").css({"border-color":"#F00"});
					process7 = false;
					$("#edit_email_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "mail" });
					$("#edit_email_notificationContent").html("Please type a valid email address");
					$("#edit_email_jqxNotification").jqxNotification("open");
				}
			}else{
				$("#email").css({"border-color":"#ccc"});
				process7 = true;
			}
			
			if(process1 == true && process2 == true && process3 == true && process4 == true && process5 == true && process6 == true && process7 == true){
				$.when(update_supplier_info()).then(function(){
					$("#firstname").focus();
					$("#edit_save_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "success" });
					$("#edit_save_notificationContent").html("Supplier saved.");
					$("#edit_save_jqxNotification").jqxNotification("open")
				});
			}else{
				$scope.$apply(function(){
					$scope.tabset = {};
				});
				$scope.$apply(function(){
					$scope.tabset = {
						selectedItem: 0
					}
				});
			}
		});
		
		$("#_yes").click(function(){
			$('#edit_jqxNotification').jqxNotification('closeAll');
			var process6 = false;
			if($("#company").val() == ''){
				$("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
				$("#edit_notificationContent").html("Company is required field");
				$("#edit_jqxNotification").jqxNotification("open");
				$("#company").css({"border-color":"#f00"});
				process6 = false;
			}else{
				$("#company").css({"border-color":"#ccc"});
				process6 = true;
			}
			
			var process1 = false;
			var SelZipCode = $("#zipcode").jqxComboBox('getSelectedItem');
			var SelZipCodeText = $("#zipcode").val();
			if(SelZipCode){
				process1 = true;
			}else{
				if(SelZipCodeText == ''){
					process1 = true;
				}else{
					$("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true,  template: "error" });
					$("#edit_notificationContent").html("Zip code does not exist");
					$("#edit_jqxNotification").jqxNotification("open");
					process1 = false;
				}
			}
			
			var process2 = false;
			var SelCity = $("#city").jqxComboBox('getSelectedItem');
			var SelCityText = $("#city").val();
			if(SelCity){
				process2 = true;
			}else{
				if(SelCityText == ''){
					process2 = true;
				}else{
					$("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
					$("#edit_notificationContent").html("City does not exist");
					$("#edit_jqxNotification").jqxNotification("open");
					process2 = false;
				}
			}
			
			var process3 = false;
			var SelState = $("#state").jqxComboBox('getSelectedItem');
			var SelStateText = $("#state").val();
			if(SelState){
				process3 = true;
			}else{
				if(SelStateText == ''){
					process3 = true;
				}else{
					$("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
					$("#edit_notificationContent").html("State does not exist");
					$("#edit_jqxNotification").jqxNotification("open");
					process3 = false;
				}
			}
			
			var process4 = false;
			var SelIsland = $("#island").jqxComboBox('getSelectedItem');
			var SelIslandText = $("#island").val();
			if(SelIsland){
				process4 = true;
			}else{
				if(SelIslandText == ''){
					process4 = true;
				}else{
					$("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
					$("#edit_notificationContent").html("Island does not exist");
					$("#edit_jqxNotification").jqxNotification("open");
					process4 = false;
				}
			}
			
			var process5 = false;
			var SelCountry = $("#country").jqxComboBox('getSelectedItem');
			var SelCountryText = $("#country").val();
			if(SelCountry){
				process5 = true;
			}else{
				if(SelCountryText == ''){
					process5 = true;
				}else{
					$("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
					$("#edit_notificationContent").html("Country does not exist");
					$("#edit_jqxNotification").jqxNotification("open");
					process5 = false;
				}
			}
			
			var process7 = false;
			if($("#email").val() != ''){
				if(check_email($("#email").val())){
					$("#email").css({"border-color":"#ccc"});
					process7 = true;
				}else{
					$("#email").css({"border-color":"#F00"});
					process7 = false;
					$("#edit_email_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "mail" });
					$("#edit_email_notificationContent").html("Please type a valid email address");
					$("#edit_email_jqxNotification").jqxNotification("open");
				}
			}else{
				$("#email").css({"border-color":"#ccc"});
				process7 = true;
			}
			
			if(process1 == true && process2 == true && process3 == true && process4 == true && process5 == true && process6 == true && process7 == true){
				$.when(update_supplier_info()).done(function(){
					dialog.close();
					$scope.$apply(function(){
						$scope.tabset = {};
					});
					
					$scope.$apply(function(){
						$scope.tabset = {
							selectedItem: 0
						}
					})
					setTimeout(function(){
						$("#table input.jqx-input").focus();
					},500);
				});
			}else{
				$scope.$apply(function(){
					$scope.tabset = {};
				});
				$scope.$apply(function(){
					$scope.tabset = {
						selectedItem: 0
					}
				});
			}
		});
		
		$("#_delete").click(function(){
			var supplierid = $("#supplierid").val();
			var name = $("#firstname").val() + " " + $("#lastname").val();
			var company = $("#company").val(); 
			$("#_btnscd").hide();
			$("#msg_delete").show();
			$("#delmsg").text("Would you like to delete "+supplierid+" "+name+" "+company+"?");
			$("#tab1").block({message: null});
			$("#tab2").block({message: null});
			$("#tab3").block({message: null});
		});
		
		$("#_delyes").click(function(){
			$.when(delete_process()).then(function(){
				$("#_btnscd").show();
				$("#_restore").show();
				$("#_delete").hide();
				$("#_cancel").hide();
				$("#_canceldeleted").show();
			})
		});
		
		$("#_delno").click(function(){
			$("#tab1").unblock();
			$("#tab2").unblock();
			$("#tab3").unblock();
			$("#msg_delete").hide();
			$("#_btnscd").show();
			$("#delmsg").text("");
		});
		
		$("#_restore").click(function(){
			$.when(restore_process()).done(function(){
				$("#del_confirmation_msg").hide();
				$("#delmymessage").html("");
				$("#_restore").hide();
				$("#_delete").show();
				$("#_delete").attr("disabled",false);	
				$("#_cancel").show();
				$("#_canceldeleted").hide();	
			})	
		});
		
		$("#_canceldeleted").click(function(){
			$("#table").jqxDataTable('updateBoundData');
			reset_form();
			dialog.close();
			setTimeout(function(){
				$("#table input.jqx-input").focus();
			},500);
		})

		
		$("#_addnew").on("click", function() {
			//$scope.AddNew = function(){
			$("#ngxTabs1").block({
				message: '<img src=' + SiteRoot + '/assets/img/ajax-loader.gif />'
			});

			 var DefaultZipCode = 0;//$("#default_zipcode").val();
			 $scope.addzipcode.jqxComboBox('selectItem', DefaultZipCode);
			 $.when(city(DefaultZipCode)).then(function(){
				 $.when(state(DefaultZipCode)).then(function(){
					 $.when(island(DefaultZipCode)).then(function(){
						 $.when(country(DefaultZipCode)).done(function(){
							 $scope.addisland.apply('selectItem', selisland);
							 $scope.addstate.apply('selectItem', selstate);
							 $scope.addcity.apply('selectItem', selcity);
							 $scope.addcountry.apply('selectItem', selcountry);
							 $("#addform_handler").show();
							 $("#ngxTabs1").unblock();

							 $scope.$apply(function(){
								 $scope.selectedItem = 0;
							 });
							 //$("#SupplierController").block({message : null});
							 addialog.open();
							 add_reset_form();
						 })
					 })
				 })
			 });
			$scope.$apply(function () {
				$scope.tabsSettings = {};
			});
			//}
		});
		
		$("#add_cancel").click(function(){
			$('#add_jqxNotification').jqxNotification('closeAll'); 
			$scope.$apply(function(){
				$scope.tabsSettings = {};
			});
			var addsavebtn = $("#add_save").is(":disabled");
			if(addsavebtn){
				add_reset_form();
				$scope.$apply(function(){
					addialog.close();
					$scope.tabsSettings = {
						selectedItem: 0
					}
				});
				setTimeout(function(){
					$("#table input.jqx-input").focus();
				},500);
			}else{
				$("#add_msg").show();
				$("#add_btnscd").hide();
				var process6 = false;
				if($("#add_company").val() == ''){
					$("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
					$("#add_notificationContent").html("Company  is required field");
					$("#add_jqxNotification").jqxNotification("open");
					$("#add_company").css({"border-color":"#f00"});
					process6 = false;
				}else{
					$("#add_company").css({"border-color":"#ccc"});
					process6 = true;
				}
				
				var process1 = false;
				var SelZipCode = $("#add_zip").jqxComboBox('getSelectedItem');
				var SelZipCodeText = $("#add_zip").val();
				if(SelZipCode){
					process1 = true;
				}else{
					if(SelZipCodeText == ''){
						process1 = true;
					}else{
						$("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true,  template: "error" });
						$("#add_notificationContent").html("Zip code does not exist");
						$("#add_jqxNotification").jqxNotification("open");
						process1 = false;
					}
				}
				
				var process2 = false;
				var SelCity = $("#add_city").jqxComboBox('getSelectedItem');
				var SelCityText = $("#add_city").val();
				if(SelCity){
					process2 = true;
				}else{
					if(SelCityText == ''){
						process2 = true;
					}else{
						$("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
						$("#add_notificationContent").html("City does not exist");
						$("#add_jqxNotification").jqxNotification("open");
						process2 = false;
					}
				}
				
				var process3 = false;
				var SelState = $("#add_state").jqxComboBox('getSelectedItem');
				var SelStateText = $("#add_state").val();
				if(SelState){
					process3 = true;
				}else{
					if(SelStateText == ''){
						process3 = true;
					}else{
						$("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
						$("#add_notificationContent").html("State does not exist");
						$("#add_jqxNotification").jqxNotification("open");
						process3 = false;
					}
				}
				
				var process4 = false;
				var SelIsland = $("#add_island").jqxComboBox('getSelectedItem');
				var SelIslandText = $("#add_island").val();
				if(SelIsland){
					process4 = true;
				}else{
					if(SelIslandText == ''){
						process4 = true;
					}else{
						$("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
						$("#add_notificationContent").html("Island does not exist");
						$("#add_jqxNotification").jqxNotification("open");
						process4 = false;
					}
				}
				
				var process5 = false;
				var SelCountry = $("#add_country").jqxComboBox('getSelectedItem');
				var SelCountryText = $("#add_country").val();
				if(SelCountry){
					process5 = true;
				}else{
					if(SelCountryText == ''){
						process5 = true;
					}else{
						$("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
						$("#add_notificationContent").html("Country does not exist");
						$("#add_jqxNotification").jqxNotification("open");
						process5 = false;
					}
				}
				
				var process7 = false;
				if($("#add_email").val() != ''){
					if(check_email($("#add_email").val())){
						$("#add_email").css({"border-color":"#ccc"});
						process7 = true;
					}else{
						$("#add_email").css({"border-color":"#F00"});
						process7 = false;
						$("#add_email_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "mail" });
						$("#add_email_notificationContent").html("Please type a valid email address");
						$("#add_email_jqxNotification").jqxNotification("open");
					}
				}else{
					$("#add_email").css({"border-color":"#ccc"});
					process7 = true;
				}
				
				if(process1 == true && process2 == true && process3 == true && process4 == true && process5 == true && process6 == true && process7 == true){
					$('#addtab1').block({message: null});
					$('#addtab2').block({message: null});
					$('#addtab3').block({message: null});
				}else{
					$scope.$apply(function(){
						$scope.tabsSettings = {};
					});
					$scope.$apply(function(){
						$scope.tabsSettings = {
							selectedItem: 0
						}
					});
				}
			}
		});
		
		$("#add_save").click(function(){
			$('#add_jqxNotification').jqxNotification('closeAll');
			var process6 = false;
			if($("#add_company").val() == ''){
				$("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
				$("#add_notificationContent").html("Company is required field");
				$("#add_jqxNotification").jqxNotification("open");
				$("#add_company").css({"border-color":"#f00"});
				process6 = false;
			}else{
				$("#add_company").css({"border-color":"#ccc"});
				process6 = true;
			}
			
			var process1 = false;
			var SelZipCode = $("#add_zip").jqxComboBox('getSelectedItem');
			var SelZipCodeText = $("#add_zip").val();
			if(SelZipCode){
				process1 = true;
			}else{
				if(SelZipCodeText == ''){
					process1 = true;
				}else{
					$("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true,  template: "error" });
					$("#add_notificationContent").html("Zip code does not exist");
					$("#add_jqxNotification").jqxNotification("open");
					process1 = false;
				}
			}
			
			var process2 = false;
			var SelCity = $("#add_city").jqxComboBox('getSelectedItem');
			var SelCityText = $("#add_city").val();
			if(SelCity){
				process2 = true;
			}else{
				if(SelCityText == ''){
					process2 = true;
				}else{
					$("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
					$("#add_notificationContent").html("City does not exist");
					$("#add_jqxNotification").jqxNotification("open");
					process2 = false;
				}
			}
			
			var process3 = false;
			var SelState = $("#add_state").jqxComboBox('getSelectedItem');
			var SelStateText = $("#add_state").val();
			if(SelState){
				process3 = true;
			}else{
				if(SelStateText == ''){
					process3 = true;
				}else{
					$("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
					$("#add_notificationContent").html("State does not exist");
					$("#add_jqxNotification").jqxNotification("open");
					process3 = false;
				}
			}
			
			var process4 = false;
			var SelIsland = $("#add_island").jqxComboBox('getSelectedItem');
			var SelIslandText = $("#add_island").val();
			if(SelIsland){
				process4 = true;
			}else{
				if(SelIslandText == ''){
					process4 = true;
				}else{
					$("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
					$("#add_notificationContent").html("Island does not exist");
					$("#add_jqxNotification").jqxNotification("open");
					process4 = false;
				}
			}
			
			var process5 = false;
			var SelCountry = $("#add_country").jqxComboBox('getSelectedItem');
			var SelCountryText = $("#add_country").val();
			if(SelCountry){
				process5 = true;
			}else{
				if(SelCountryText == ''){
					process5 = true;
				}else{
					$("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
					$("#add_notificationContent").html("Country does not exist");
					$("#add_jqxNotification").jqxNotification("open");
					process5 = false;
				}
			}
			
			var process7 = false;
			if($("#add_email").val() != ''){
				if(check_email($("#add_email").val())){
					$("#add_email").css({"border-color":"#ccc"});
					process7 = true;
				}else{
					$("#add_email").css({"border-color":"#F00"});
					process7 = false;
					$("#add_email_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "mail" });
					$("#add_email_notificationContent").html("Please type a valid email address");
					$("#add_email_jqxNotification").jqxNotification("open");
				}
			}else{
				$("#add_email").css({"border-color":"#ccc"});
				process7 = true;
			}
			
			if(process1 == true && process2 == true && process3 == true && process4 == true && process5 == true && process6 == true && process7 == true){
				$.when(add_supplier_info()).done(function(){
					$scope.$apply(function(){
						$scope.tabsSettings = {};
					});
					$scope.$apply(function(){
						$scope.tabsSettings = {
							selectedItem: 0
						}
					})
					$("#add_save_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "success" });
					$("#add_save_notificationContent").html("New Supplier Saved.");
					$("#add_save_jqxNotification").jqxNotification("open");
				})
			}else{
				$scope.$apply(function(){
					$scope.tabsSettings = {};
				});
				$scope.$apply(function(){
					$scope.tabsSettings = {
						selectedItem: 0
					}
				})
			}
		});
		
		$("#add_aftersave_yes").click(function(){
			add_reset_form();
			$scope.$apply(function(){
				$scope.tabsSettings = {
					selectedItem : 0
				}
			});		
			
			$scope.gridSettings ={	
				created: function(args){
					grid = args.instance;
				},
				source:  {
					dataType: "json",
					dataFields: [
						{ name: 'Unique', type : 'int' },
						{ name: 'FirstName', type: 'string'},
						{ name: 'LastName', type: 'string' },
						{ name: 'Company', type: 'string'},
						{ name: 'Address1', type: 'string'},
						{ name: 'Address2', type: 'string'},
						{ name: 'City', type: 'string'},
						{ name: 'State', type: 'string'},
						{ name: 'Zip', type: 'string'},
						{ name: 'County', type: 'string'},
						{ name: 'Country', type: 'string'},
						{ name: 'Phone1', type: 'string'},
						{ name: 'Phone2', type: 'string'},
						{ name: 'Phone3', type: 'string'},
						{ name: 'Fax', type: 'string'},
						{ name: 'Email', type: 'string'},
						{ name: 'Website', type: 'string'},
						{ name: 'Custom1', type: 'string'},
						{ name: 'Custom2', type: 'string'},
						{ name: 'Custom3', type: 'string'},
						{ name: 'Note', type: 'string'}
					],
					id: 'Unique',
					url: SiteRoot+"backoffice/load_supplier"
				},
				created: function (args) {
				   var instance = args.instance;
				   instance.updateBoundData();
				}
			}
		
			$("#add_confirmation_after_save").hide();
			$("#addsavedmymessage").html("");
			$("#add_btnscd").show();
			$("#add_save").attr("disabled", true);
		});
		
		$("#add_aftersave_no").click(function(){
			add_reset_form();
			$scope.$apply(function(){
				$scope.tabsSettings = {
					selectedItem : 0
				}
			});	
			$scope.gridSettings ={	
				created: function(args){
					grid = args.instance;
				},
				source:  {
					dataType: "json",
					dataFields: [
						{ name: 'Unique', type : 'int' },
						{ name: 'FirstName', type: 'string'},
						{ name: 'LastName', type: 'string' },
						{ name: 'Company', type: 'string'},
						{ name: 'Address1', type: 'string'},
						{ name: 'Address2', type: 'string'},
						{ name: 'City', type: 'string'},
						{ name: 'State', type: 'string'},
						{ name: 'Zip', type: 'string'},
						{ name: 'County', type: 'string'},
						{ name: 'Country', type: 'string'},
						{ name: 'Phone1', type: 'string'},
						{ name: 'Phone2', type: 'string'},
						{ name: 'Phone3', type: 'string'},
						{ name: 'Fax', type: 'string'},
						{ name: 'Email', type: 'string'},
						{ name: 'Website', type: 'string'},
						{ name: 'Custom1', type: 'string'},
						{ name: 'Custom2', type: 'string'},
						{ name: 'Custom3', type: 'string'},
						{ name: 'Note', type: 'string'}
					],
					id: 'Unique',
					url: SiteRoot+"backoffice/load_supplier"
				},
				created: function (args) {
				   var instance = args.instance;
				   instance.updateBoundData();
				}
			}

			$("#add_confirmation_after_save").hide();
			addialog.close();
			setTimeout(function(){
				$("#table input.jqx-input").focus();
			},500);
				
		});
		

		$("#add_yes").click(function(){
			var process6 = false;
			if($("#add_company").val() == ''){
				$("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "info" });
				$("#add_notificationContent").html("Company is required field");
				$("#add_jqxNotification").jqxNotification("open");
				$("#add_company").css({"border-color":"#f00"});
				process6 = false;
			}else{
				$("#add_company").css({"border-color":"#ccc"});
				process6 = true;
			}
			
			var process1 = false;
			var SelZipCode = $("#add_zip").jqxComboBox('getSelectedItem');
			var SelZipCodeText = $("#add_zip").val();
			if(SelZipCode){
				process1 = true;
			}else{
				if(SelZipCodeText == ''){
					process1 = true;
				}else{
					$("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true,  template: "info" });
					$("#add_notificationContent").html("Zip code does not exist");
					$("#add_jqxNotification").jqxNotification("open");
					process1 = false;
				}
			}
			
			
			var process2 = false;
			var SelCity = $("#add_city").jqxComboBox('getSelectedItem');
			var SelCityText = $("#add_city").val();
			if(SelCity){
				process2 = true;
			}else{
				if(SelCityText == ''){
					process2 = true;
				}else{
					$("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "info" });
					$("#add_notificationContent").html("City does not exist");
					$("#add_jqxNotification").jqxNotification("open");
					process2 = false;
				}
			}
			
			var process3 = false;
			var SelState = $("#add_state").jqxComboBox('getSelectedItem');
			var SelStateText = $("#add_state").val();
			if(SelState){
				process3 = true;
			}else{
				if(SelStateText == ''){
					process3 = true;
				}else{
					$("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "info" });
					$("#add_notificationContent").html("State does not exist");
					$("#add_jqxNotification").jqxNotification("open");
					process3 = false;
				}
			}
			
			var process4 = false;
			var SelIsland = $("#add_island").jqxComboBox('getSelectedItem');
			var SelIslandText = $("#add_island").val();
			if(SelIsland){
				process4 = true;
			}else{
				if(SelIslandText == ''){
					process4 = true;
				}else{
					$("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "info" });
					$("#add_notificationContent").html("Island does not exist");
					$("#add_jqxNotification").jqxNotification("open");
					process4 = false;
				}
			}
			
			var process5 = false;
			var SelCountry = $("#add_country").jqxComboBox('getSelectedItem');
			var SelCountryText = $("#add_country").val();
			if(SelCountry){
				process5 = true;
			}else{
				if(SelCountryText == ''){
					process5 = true;
				}else{
					$("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "info" });
					$("#add_notificationContent").html("Country does not exist");
					$("#add_jqxNotification").jqxNotification("open");
					process5 = false;
				}
			}
			
			var process7 = false;
			if($("#add_email").val() != ''){
				if(check_email($("#add_email").val())){
					$("#add_email").css({"border-color":"#ccc"});
					process7 = true;
				}else{
					$("#add_email").css({"border-color":"#f00"});
					process7 = false;
					$("#add_email_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "email" });
					$("#add_email_notificationContent").html("Please type a valid email address");
					$("#add_email_jqxNotification").jqxNotification("open");
				}
			}else{
				$("#add_email").css({"border-color":"#ccc"});
				process7 = true;
			}
			
			if(process1 == true && process2 == true && process3 == true && process4 == true && process5 == true && process6 == true && process7 == true){
				$.when(add_supplier_info()).done(function(){
					$scope.$apply(function(){
						$scope.tabsSettings = {};
					});
					$scope.$apply(function(){
						$scope.tabsSettings = {
							selectedItem: 0
						}
					})
					$('#addtab1').unblock();
					$('#addtab2').unblock();
					$('#addtab3').unblock();
					$("#add_save_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "success" });
					$("#add_save_notificationContent").html("New Supplier Saved.");
					$("#add_save_jqxNotification").jqxNotification("open");
				});
				$("#add_btnscd").hide();
				$("#add_msg").hide();
			}
		});
		
		$("#add_no").click(function(){
			add_reset_form();
			addialog.close();
			$scope.$apply(function(){
				$scope.tabsSettings = {
					selectedItem: 0
				}
			});
			setTimeout(function(){
				$("#table input.jqx-input").focus();
			},500);	
		});
		
		$("#add_conf_cancel").click(function(){
			$scope.$apply(function(){
				$scope.tabsSettings = {};
			});
			$scope.$apply(function(){
				$scope.tabsSettings = {
					selectedItem: 0
				}
			});
			$("#add_msg").hide();
			$("#add_btnscd").show();
			$('#addtab1').unblock();
			$('#addtab2').unblock();
			$('#addtab3').unblock();
			$("#add_firstname").focus();
		});

//################################################################################################################################################################//
															//# Load Supplier List #//
		
		$scope.thetabs = 'darkblue';
		$scope.thetabsadd = 'darkblue';

		$scope.tabset = {
			selectedItem:0	
		};
		$scope.tabsSettings = {
			selectedItem:0
		};
			
		$scope.gridSettings = {
			width: "100%",
			editable: false,
			pageable: true,
			pagerMode: 'default',
			pageSize: 15,
			sortable: true,
			filterable: true,
			filterMode: 'simple',
			altRows: true,
			theme: 'arctic',
			created: function(args)
			{
				dataTable = args.instance;
			},
			source:  {
				dataType: "json",
				dataFields: [
					{ name: 'Unique', type : 'int' },
					{ name: 'FirstName', type: 'string'},
					{ name: 'LastName', type: 'string' },
					{ name: 'Company', type: 'string'},
					{ name: 'Address1', type: 'string'},
					{ name: 'Address2', type: 'string'},
					{ name: 'City', type: 'string'},
					{ name: 'State', type: 'string'},
					{ name: 'Zip', type: 'string'},
					{ name: 'County', type: 'string'},
					{ name: 'Country', type: 'string'},
					{ name: 'Phone1', type: 'string'},
					{ name: 'Phone2', type: 'string'},
					{ name: 'Phone3', type: 'string'},
					{ name: 'Fax', type: 'string'},
					{ name: 'Email', type: 'string'},
					{ name: 'Website', type: 'string'},
					{ name: 'Custom1', type: 'string'},
					{ name: 'Custom2', type: 'string'},
					{ name: 'Custom3', type: 'string'},
					{ name: 'Note', type: 'string'}
				],
				id: 'Unique',
				url: SiteRoot+"backoffice/load_supplier"
			},
			ready: function () {
				
			},
			columns: [
				{ text: 'ID', dataField: 'Unique', width: "5%" },
				{ text: 'First Name', dataField: 'FirstName', width: "8%" },
				{ text: 'Last Name', dataField: 'LastName', width: '8%' },
				{ text: 'Company', dataField: 'Company', width: '15%' },
				{ text: 'Address1', dataField: 'Address1', width: '17%' },
				{ text: 'Address2', dataField: 'Address2', hidden: true },
				{ text: 'City', dataField: 'City', width: '9%' },
				{ text: 'State', dataField: 'State', width: '6%',},
				{ text: 'Zip', dataField: 'Zip', width: '8%'},
				{ text: 'County', dataField: 'County', hidden: true },
				{ text: 'Country', dataField: 'Country', hidden: true },
				{ text: 'Phone', dataField: 'Phone1', width: '8%' },
				{ text: 'Phone2', dataField: 'Phone2', hidden: true },
				{ text: 'Phone3', dataField: 'Phone3', hidden: true },
				{ text: 'E-mail', dataField: 'Email', width: '16%' },
				{ text: 'Fax', dataField: 'Fax',hidden: true },
				{ text: 'Website', dataField: 'Website', hidden: true},
				{ text: 'Custom1', dataField: 'Custom1', hidden: true},
				{ text: 'Custom2', dataField: 'Custom2', hidden: true},
				{ text: 'Custom3', dataField: 'Custom3', hidden: true},
				{ text: 'Note', dataField: 'Note', hidden: true}
		  ]
		};

//################################################################################################################################################################//
																			/* Row RowDoubleClick */
		$scope.rowDoubleClick = function (event) {
			var args = event.args;
			var index = args.index;
			var row = args.row;
			var item = '';
			//reset_form();
			dialog.setTitle("Edit Supplier ID: " + row.Unique + " |" + row.FirstName+ " "+row.LastName);
			editRow = index;
			$("#supplierid").val(row.Unique);
			$("#firstname").val(row.FirstName);
			$("#lastname").val(row.LastName);
			$("#company").val(row.Company);
			$("#address1").val(row.Address1);
			$("#address2").val(row.Address2);
			
			$("#zipcode").jqxComboBox('selectItem', row.Zip);
			
			$("#phone1").val(row.Phone1);
			$("#phone2").val(row.Phone2);
			$("#phone3").val(row.Phone3);
			$("#email").val(row.Email);
			$("#fax").val(row.Fax);
			$("#website").val(row.Website);
			$("#custom1").val(row.Custom1);
			$("#custom2").val(row.Custom2);
			$("#custom3").val(row.Custom3);
			$("#note").val(row.Note);
			
			global_custid=row.Unique; 
			global_custname=row.FirstName+" "+row.LastName;
				
			selzipcode = row.Zip;
			selcity = row.City;
			selstate = row.State;
			selcountry = row.Country;
			
			$scope.$apply(function(){
				$scope.selectedItem = 0;
			});

			setTimeout(function(){
				$("#city").jqxComboBox('selectItem', row.City);
				$("#state").jqxComboBox('selectItem', row.State);
				$("#country").jqxComboBox('selectItem', row.Country);
				$("#island").jqxComboBox('selectItem', row.County);
				$("#_update").prop("disabled", true);
				dialog.open();
			},500);
			
			setTimeout(function(){
				$("#company").focus();
			}, 200);
		};
//################################################################################################################################################################//
															/*@@ City Drop Down @@*/
		$scope.addcity = {selectedIndex: 0, source: citiesDataAdapter, displayMember: "City", valueMember: "Unique", width: "99%", height: 25};
		$scope.placeHolderaddcity = "Select City";
		$("#add_city").on("select", function(event){
			if(event.args){
				var item = event.args.item;
				if (item) {
					selcity = item.value;
					$("#add_save").prop("disabled", false);
					$("#add_city").on('keydown', function(event){
						if(event.keyCode == 8 || event.keyCode == 46){
							$("#add_city").jqxComboBox('clearSelection');
							selcity = null;
							$("#add_save").prop("disabled", false);
						}
					})	
				}
			}
		})
		
		$scope.city = {selectedIndex: 0, source: citiesDataAdapter, displayMember: "City", valueMember: "Unique", width: "99%", height: 25};
		$scope.placeHoldercity = "Select City";
		$("#city").on("select", function(event){
			if(event.args){
				var item = event.args.item;
				if (item) {
					selcity = item.value;
					$("#_update").prop("disabled", false);
					$("#city").on('keydown', function(event){
						if(event.keyCode == 8 || event.keyCode == 46){
							$("#city").jqxComboBox('clearSelection');
							selcity = null;
							$("#_update").prop("disabled", false);
						}
					})
					$("#city").on('keypress', function(event){
						$("#_update").prop("disabled", false);
					})		
				}
			}
		})
//################################################################################################################################################################//	
															/*@@ Island Drop Down @@*/						
		$scope.addisland = {selectedIndex: 0, source: islandDataAdapter, displayMember: "Island", valueMember: "County", width: "99%", height: 25};
		$scope.placeHolderaddisland = "Select Island";
		$("#add_island").on("select", function(event){
			if(event.args){
				var item = event.args.item;
				if (item) {
					selisland = item.value;
					$("#add_save").prop("disabled", false);
					$("#add_island").on('keydown', function(event){
						if(event.keyCode == 8 || event.keyCode == 46){
							$("#add_island").jqxComboBox('clearSelection');
							selisland = null;
							$("#add_save").prop("disabled", false);
						}
					})	
				}
			}
		})
		
		$scope.island = {selectedIndex: 0, source: islandDataAdapter, displayMember: "Island", valueMember: "County", width: "99%", height: 25};
		$scope.placeHolderisland = "Select Island";	
		$("#island").on("select", function(event){
			if(event.args){
				var item = event.args.item;
				if (item) {
					selisland = item.value;
					$("#_update").prop("disabled", false);
					$("#island").on('keydown', function(event){
						if(event.keyCode == 8 || event.keyCode == 46){
							$("#island").jqxComboBox('clearSelection');
							selisland = null;
							$("#_update").prop("disabled", false);
						}
					})
					$("#island").on('keypress', function(event){
						$("#_update").prop("disabled", false);
					})	
				}
			}
		})
//################################################################################################################################################################//	
															/*@@ State Drop Down @@*/	
		$scope.addstate = {selectedIndex: 0, source: statesDataAdapter, displayMember: "State", valueMember: "StateID", width: "99%", height: 25};
		$scope.placeHolderaddstate = "State";
		$("#add_state").on("select", function(event){
			if(event.args){
				var item = event.args.item;
				if (item) {
					selisland = item.value;
					$("#add_save").prop("disabled", false);
					$("#add_state").on('keydown', function(event){
						if(event.keyCode == 8 || event.keyCode == 46){
							$("#add_state").jqxComboBox('clearSelection');
							selisland = null;
							$("#add_save").prop("disabled", false);
						}
					})	
				}
			}
		})
		
		
		$scope.state = {selectedIndex: 0, source: statesDataAdapter, displayMember: "State", valueMember: "StateID", width: "99%", height: 25};
		$scope.placeHolderstate = "Select State";
		$("#state").on("select", function(event){
			if(event.args){
				var item = event.args.item;
				if (item) {
					selstate = item.value;
					$("#_update").prop("disabled", false);
					$("#state").on('keydown', function(event){
						if(event.keyCode == 8 || event.keyCode == 46){
							$("#state").jqxComboBox('clearSelection');
							selstate = null;
							$("#_update").prop("disabled", false);
						}
					})	
					$("#state").on('keypress', function(event){
						$("#_update").prop("disabled", false);
					})
				}
			}
		})
//################################################################################################################################################################//	
															/*@@ Zip Code Drop Down @@*/	
		$scope.addzipcode = { selectedIndex: 0, source: zipcodesDataAdapter, displayMember: "ZipCode", valueMember: "ZipCode", width: "99%", height: 25};
		$scope.placeHolderaddzipcode = "Select Zip Code";
		$("#add_zip").on("select", function(event){
			if(event.args){
				var item = event.args.item;
				if (item) {
					$.when(city(item.value)).then(function(){
						$scope.addcity.apply('selectItem', selcity);
						$.when(state(item.value)).then(function(){
							$scope.addstate.apply('selectItem', selstate);
							$.when(island(item.value)).then(function(){
								$scope.addisland.apply('selectItem', selisland);
								$.when(country(item.value)).done(function(){
									$scope.addcountry.apply('selectItem', selcountry);
									$("#add_save").prop("disabled", false);
								})
							})
						})
					})
					$("#add_zip").on('keydown', function(event){
						if(event.keyCode == 8 || event.keyCode == 46){
							$("#add_zip").jqxComboBox('clearSelection');
							selzipcode = null;
							$("#add_save").prop("disabled", false);
						}
					})
				}
			}
		})
		
		$scope.zipcode = {selectedIndex: 0, source: zipcodesDataAdapter, displayMember: "ZipCode", valueMember: "ZipCode", width: "99%", height: 25};
		$scope.placeHolderzipcode = "Select Zip Code";
		$("#zipcode").on("select", function(event){
			if(event.args){
				var item = event.args.item;
				if (item) {
					$.when(city(item.value)).then(function(){
						$scope.city.apply('selectItem', selcity);
						$.when(state(item.value)).then(function(){
							$scope.state.apply('selectItem', selstate);
							$.when(island(item.value)).then(function(){
								$scope.island.apply('selectItem', selisland);
								$.when(country(item.value)).done(function(){
									$scope.country.apply('selectItem', selcountry);
									$("#_update").prop("disabled", false);
								})
							})
						})
					})
					$("#zipcode").on('keydown', function(event){
						if(event.keyCode == 8 || event.keyCode == 46){
							$("#zipcode").jqxComboBox('clearSelection');
							selzipcode = null;
							$("#_update").prop("disabled", false);
						}
					})
					$("#zipcode").on('keypress', function(event){
						$("#_update").prop("disabled", false);
					})
				}
			}
		})
//###############################################################################################################################################################//	
															/*@@ Country Drop Down @@*/	
		$scope.addcountry = { selectedIndex: 0, source: countriesDataAdapter, displayMember: "CountryName", valueMember: "CountryCode", width: "99%", height: 25};
		$scope.placeHolderaddcountry = "Select Country";
		$("#add_country").on("select", function(event){
			if(event.args){
				var item = event.args.item;
				if (item) {
					selcountry = item.value;
					$("#add_country").on('keydown', function(event){
						if(event.keyCode == 8 || event.keyCode == 46){
							$("#add_country").jqxComboBox('clearSelection');
							selcountry = null;
						}
					})	
				}
			}
		})
		
		$scope.country = {selectedIndex: 0, source: countriesDataAdapter, displayMember: "CountryName", valueMember: "CountryCode", width: "99%", height: 25};
		$scope.placeHoldercountry = "Select Country";
		$("#country").on("select", function(event){
			if(event.args){
				var item = event.args.item;
				if (item) {
					selcountry = item.value;
					$("#country").on('keydown', function(event){
						if(event.keyCode == 8 || event.keyCode == 46){
							$("#country").jqxComboBox('clearSelection');
							selcountry = null;
							$("#_update").prop("disabled", false);
						}
					})	
				}
			}
		})
//###############################################################################################################################################################//
	});
	
	var FilterCharacters = function(text){
		return encodeURIComponent(text);
	}
	
	/*End Angular Conroller*/
	function checkAnyFormFieldEdited() {
		$('.customer').keypress(function(e) { // text written
			enableSaveBtn();
		});
		
		$('.customer').keyup(function(e) {
			if (e.keyCode == 8 || e.keyCode == 46) { //backspace and delete key
				enableSaveBtn();
			} else { // rest ignore
				e.preventDefault();
			}
		});
		
		$('.customer').bind('paste', function(e) { // text pasted
			enableSaveBtn();
		});
	
		$('.customer').change(function(e) { // select element changed
			enableSaveBtn();
		});
	}
	
	function checkAnyFormFieldAdd() {
		$('.addcustomer').keypress(function(e) { // text written
			enableAddSaveBtn();
		});
		
		$('.addcustomer').keyup(function(e) {
			if (e.keyCode == 8 || e.keyCode == 46) { //backspace and delete key
				enableAddSaveBtn();
			} else { // rest ignore
				e.preventDefault();
			}
		});
		
		$('.addcustomer').bind('paste', function(e) { // text pasted
			enableAddSaveBtn();
		});
	
		$('.addcustomer').change(function(e) { // select element changed
			enableAddSaveBtn();
		});
	}
	
	function enableSaveBtn(){
		$("#_update").attr("disabled", false);	
	}
	
	function enableAddSaveBtn(){
		$("#add_save").attr("disabled", false);	
	}
	
	function reset_form(){
		selzipcode="";
		selzipunique="";
		selcity="";
		selstate="";
		selisland="";
		selcountry="";
		$("#firstname").val("");
		$("#lastname").val("");
		$("#company").val("");
		$("#address1").val("");
		$("#address2").val("");
		
		$("#zipcode").jqxComboBox('clearSelection'); 
		$("#city").jqxComboBox('clearSelection'); 
		$("#state").jqxComboBox('clearSelection');
		$("#country").jqxComboBox('clearSelection'); 
		
		$("#phone1").val("");
		$("#phone2").val("");
		$("#phone3").val("");
		$("#email").val("");
		$("#fax").val("");
		$("#website").val("");
		$("#custom1").val("");
		$("#custom2").val("");
		$("#custom3").val("");
		$("#note").val("");
		$("#edit_email_message").text("");
		$("#edit_searchclear").hide();
		$('#tab1').unblock(); 
		$('#tab2').unblock(); 
		$('#tab3').unblock();
		$("#msg").hide();
		//$("#SupplierController").unblock();
		$("#_btnscd").show();
		$("#_update").attr("disabled",true);
		$("#_delete").attr("disabled",false);
		$("#_restore").hide();
		$("#_delete").show();
		$("#_cancel").show();
		$("#_canceldeleted").hide();
		setTimeout(function(){
			$("#firstname").focus();
		}, 200);
	}
	
	function update_supplier_info(){
		var updatedefer = $.Deferred();
		var supplierid = $("#supplierid").val();
		var fname = FilterCharacters($("#firstname").val());
		var lname = FilterCharacters($("#lastname").val());
		var company = FilterCharacters($("#company").val());
		var address1 = FilterCharacters($("#address1").val());
		var address2 = FilterCharacters($("#address2").val());
		var city = FilterCharacters(selcity); 
		var state = FilterCharacters(selstate); 
		var zip = FilterCharacters(selzipcode);
		var county = FilterCharacters(selisland);
		var country = FilterCharacters(selcountry);
		var phone1 = $("#phone1").val();
		var phone2 = $("#phone2").val();
		var phone3 = $("#phone3").val();
		var email = $("#email").val();
		var fax = $("#fax").val();
		var website = FilterCharacters($("#website").val());
		var custom1 = FilterCharacters($("#custom1").val());
		var custom2 = FilterCharacters($("#custom2").val());
		var custom3 = FilterCharacters($("#custom3").val());
		var note = FilterCharacters($("#note").val());
		
		var post_data="supplierid="+supplierid;
			post_data+="&fname="+fname;
			post_data+="&lname="+lname;
			post_data+="&company="+company;
			post_data+="&address1="+address1;
			post_data+="&address2="+address2;
			post_data+="&city="+city;
			post_data+="&state="+state;
			post_data+="&zip="+zip;
			post_data+="&country="+country;
			post_data+="&county="+selisland;
			post_data+="&phone1="+phone1;
			post_data+="&phone2="+phone2;
			post_data+="&phone3="+phone3;
			post_data+="&email="+email;
			post_data+="&fax="+fax;
			post_data+="&website="+website;
			post_data+="&custom1="+custom1;
			post_data+="&custom2="+custom2;
			post_data+="&custom3="+custom3;
			post_data+="&note="+note;
		
			update_supplier_info_save(post_data);
	}
	
	function update_supplier_info_save(data){
		var updatesuppDefer = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/update_supplier_info',
			type: 'post',
			data: data,
			dataType: 'json',
			success: function(data){
				if(data.success){
					$("#message").text("Supplier Profile Updated.");
					$("#_update").attr("disabled", true);
					$("#message").fadeIn();
					$("#message").css({"color":"#5cb85c"});
					confirmation_message();
					$("#table").jqxDataTable('updateBoundData');
				}
				$("#msg").hide();
				$("#_btnscd").show();
				$('#tab1').unblock();
				$('#tab2').unblock();
				updatesuppDefer.resolve();
			},
			error: function(){
				updatesuppDefer.reject();
				alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
			}
		});
		return updatesuppDefer.promise();
	}
	
	function delete_process(){
		var deferdeleteitem = $.Deferred();
		
		var supplierid = $("#supplierid").val();
		var name = $("#firstname").val() + " " + $("#lastname").val();
		var company = $("#company").val();
		 
		$.ajax({
			url: SiteRoot+"backoffice/supplierdelete",
			type: "post",
			data: {suppid : supplierid},
			dataType:"json",
			success: function(data){
				if(data.success == true){
					$("#msg_delete").hide();
					//$("#message").text("Supplier Deleted.");
					//$("#message").text(global_custid+" "+global_custname+" "+"marked for deletion. To finalize deletion, select CLOSE or select RESTORE to undo");
					//$("#message").fadeIn();
					//$("#message").css({"color":"#F00"});
					$("#edit_delete_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
					$('#edit_restore_jqxNotification').jqxNotification({ autoCloseDelay: 2000 }); 
					$("#edit_delete_notificationContent").html(global_custid+" "+global_custname+" "+"marked for deletion. To finalize deletion, select CLOSE or select RESTORE to undo");
					$("#edit_delete_jqxNotification").jqxNotification("open");
					confirmation_message();
				}
				deferdeleteitem.resolve();
			},
			error: function(){
				deferdeleteitem.reject();
				alert("Sorry, we encoutered a technical difficulties\nPlease try again later.");
			}
		});
		return deferdeleteitem.promise();
	}
	
	function restore_process(){
		var restoredefer = $.Deferred();
		var supplierid = $("#supplierid").val();
		$.ajax({
			url: SiteRoot+"backoffice/supplierrestore",
			type: "post",
			data: {suppid : supplierid},
			dataType:"json",
			success: function(data){
				if(data.success == true){
					//$("#message").text("Supplier Restored.");
					//$("#message").fadeIn();
					//$("#message").css({"color":"#5cb85c"});
					//confirmation_message();
					$("#edit_restore_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "info" });
					$('#edit_restore_jqxNotification').jqxNotification({ autoCloseDelay: 2000 }); 
					$("#edit_restore_notificationContent").html("Customer Data Restored");
					$("#edit_restore_jqxNotification").jqxNotification("open");
				}
				restoredefer.resolve();
			},
			error: function(){
				alert("Sorry, we encoutered a technical difficulties\nPlease try again later.");
			}
		});
		return restoredefer.promise();
	}
	
	function add_supplier_info(){
		var fname = FilterCharacters($("#add_firstname").val());
		var lname = FilterCharacters($("#add_lastname").val());
		var company = FilterCharacters($("#add_company").val());
		var address1 = FilterCharacters($("#add_address1").val());
		var address2 = FilterCharacters($("#add_address2").val());
		var city = FilterCharacters(selcity);
		var state = FilterCharacters(selstate);
		var zip = selzipcode;
		var island = FilterCharacters(selisland);
		var country = FilterCharacters(selcountry);
		var phone1 = $("#add_phone1").val();
		var phone2 = $("#add_phone2").val();
		var phone3 = $("#add_phone3").val();
		var email = $("#add_email").val();
		var fax = $("#add_fax").val();
		var website = FilterCharacters($("#add_website").val());
		var custom1 = FilterCharacters($("#add_custom1").val());
		var custom2 = FilterCharacters($("#add_custom2").val());
		var custom3 = FilterCharacters($("#add_custom3").val());
		var note = FilterCharacters($("#add_note").val());
		
		var	post_data="&fname="+fname;
			post_data+="&lname="+lname;
			post_data+="&company="+company;
			post_data+="&address1="+address1;
			post_data+="&address2="+address2;
			post_data+="&city="+city;
			post_data+="&state="+state;
			post_data+="&zip="+zip;
			post_data+="&county="+island;
			post_data+="&country="+country;
			post_data+="&phone1="+phone1;
			post_data+="&phone2="+phone2;
			post_data+="&phone3="+phone3;
			post_data+="&email="+email;
			post_data+="&fax="+fax;
			post_data+="&website="+website;
			post_data+="&custom1="+custom1;
			post_data+="&custom2="+custom2;
			post_data+="&custom3="+custom3;
			post_data+="&note="+note;
			
		add_supplier_info_save(post_data);
	}
	
	function add_supplier_info_save(data){
		var adddefer = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/add_supplier_info',
			type: 'post',
			data: data,
			dataType: 'json',
			success: function(data){
				if(data.success){
					$("#add_btnscd").hide();
					$("#addsavedmymessage").html("Do you want to add another new Supplier?");
					$("#add_confirmation_after_save").show();
				}
				$("#add_msg").hide();
				$("#add_btnscd").hide();
				adddefer.resolve();
			},
			error: function(){
				adddefer.reject();
				alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
			}
		});
		return adddefer.promise();
	}
	
	function add_reset_form(){
		selzipcode=null;
		selzipunique=null;
		selcity=null;
		selstate=null;
		selisland=null;
		selcountry=null;
		$("#add_firstname").val("");
		$("#add_company").css({"border-color":"#ccc"});
		$("#add_lastname").val("");
		$("#add_company").val("");
		$("#add_address1").val("");
		$("#add_address2").val("");
		$("#add_zip").jqxComboBox('clearSelection'); 
		$("#add_city").jqxComboBox('clearSelection');
		$("#add_state").jqxComboBox('clearSelection');
		$("#add_island").jqxComboBox('clearSelection');
		$("#add_country").jqxComboBox('clearSelection');
		$("#add_phone1").val("");
		$("#add_phone2").val("");
		$("#add_phone3").val("");
		$("#add_email").val("");
		$("#add_email").css({"border-color":"#ccc"});
		$("#add_fax").val("");
		$("#add_website").val("");
		$("#add_custom1").val("");
		$("#add_custom2").val("");
		$("#add_custom3").val("");
		$("#add_note").val("");
		$("#add_email_message").text("");
		$("#searchclear").hide();
		$('#tab1').unblock(); 
		$('#tab2').unblock(); 
		$('#tab3').unblock(); 
		$("#add_msg").hide();
		$("#add_btnscd").show();
		$("#add_save").attr("disabled", true);
		setTimeout(function(){
			$("#add_firstname").focus()
		}, 200);
	}
	

	function check_email(val){
		if(!val.match(/\S+@\S+\.\S+/)){ // Jaymon's / Squirtle's solution
			return false;
		}
		if( val.indexOf(' ')!=-1 || val.indexOf('..')!=-1){
			return false;
		}
		return true;
	}
	
	function city(unique){
		var CityDefer = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/get_geocities_unique',
			type: 'post',
			data: {geocitiesid: unique},
			dataType:"json",
			success: function(data){
				selcity = data.City;
				selzipcode = data.Zip;
				areacode = data.AreaCode;
				CityDefer.resolve();
			},
			error: function(){
				CityDefer.reject();
				alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
			}
		});
		return CityDefer.promise();
	}
	
	
	function state(unique){
		var StateDefer = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/get_geocities_unique',
			type: 'post',
			data: {geocitiesid: unique},
			dataType:"json",
			success: function(data){
				selstate = data.State;
				StateDefer.resolve();
			},
			error: function(){
				StateDefer.reject();
				alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
			}
		});
		return StateDefer.promise();
	}
	
	function island(unique){
		var Islanddefer = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/get_geocities_unique',
			type: 'post',
			data: {geocitiesid: unique},
			dataType:"json",
			success: function(data){
				selisland = data.County;
				Islanddefer.resolve();
			},
			error: function(){
				Islanddefer.reject();
				alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
			}
		});
		return Islanddefer.promise();
	}
	
	function country(unique){
		var CountryDefer = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/get_geocities_unique',
			type: 'post',
			data: {geocitiesid: unique},
			dataType:"json",
			success: function(data){
				selcountry = data.Country;
				CountryDefer.resolve();
			},
			error: function(){
				CountryDefer.reject();
				alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
			}
		});
		return CountryDefer.promise();
	}
	
	
	function find_zipcode_selected(unique){
		var ZipcodeDefer = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/find_zipcode_selected',
			type: 'post',
			data: {zipcodeid : unique},
			dataType:"json",
			success: function(data){
				selzipunique = data.ZipUnique;	
				ZipcodeDefer.resolve();
				areacode = data.AreaCode;
			},
			error: function(){
				ZipcodeDefer.reject();
				alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
			}
		});
		return ZipcodeDefer.promise();
	}
	
	function countChar() {
		var len = $("#phone1").val().length;
		if (len >= 6) {
		  //do nothing
		} else {
		  $('#phone1').val("");
		}
    }
	
	function confirmation_message(){
		intervalclosemessage = 5000;
		setTimeout(function(){
			$("#message").text("");
			$("#add_message").text("");
		}, intervalclosemessage);
	}

	$(function(){
		setTimeout(function(){
			$("#table input.jqx-input").focus();
		},1000)
	})
</script>
<?php //echo $zipcode; ?>
<input type="hidden" id="default_zipcode" ng-model="default_zipcode" value="<?php echo $zipcode; ?>"/>
<input type="hidden" id="supplierid" value="">
<div id="SupplierController" ng-controller="demoController">
	<div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <nav class="navbar navbar-default" role="navigation" style="background:#CCC;">
					 <!--
                	 <div class="col-md-3">
                          <a class="navbar-brand" style="color: #146295;"><b>List of Supplier:</b></a>
                     </div>
                     -->
                     <div class="col-md-12">
                     	<div id="toolbar" class="toolbar-list">
                            <ul class="nav navbar-nav navbar-left">
								<li>
									<a href="<?php echo base_url("backoffice/dashboard")?>" style="outline:0;">
										<span class="icon-32-back"></span>
										Home
									</a>
								</li>
                                <li>
                                    <a style="outline:0;" id="_addnew" ng-click="AddNew()">
                                        <span class="icon-32-new"></span>
                                        New
                                    </a>
                                </li>
                            </ul>
                        </div>
                     </div>
            	</nav>
            </div>
            <div class="row">
				<jqx-data-table id="table" jqx-watch="disabled" jqx-on-row-click="rowClick(event)" jqx-on-row-double-click="rowDoubleClick(event)" jqx-settings="gridSettings"></jqx-data-table>
                <jqx-window jqx-on-close="close()" class="supplier_form" jqx-create="dialogSettings" jqx-settings="dialogSettings" style="display:none;">
                	<div id="editform">
                        <div style="overflow: hidden;">
                            <div class="col-md-12 col-md-offset-0" id="table" style="float:left;">
                                <jqx-tabs jqx-width="'100%'" jqx-height="'100%'" style="float: left;" jqx-theme="thetabs" jqx-settings="tabset" jqx-selected-item="selectedItem">
                                    <ul style="margin-left: 30px;">
                                        <li>Info</li>
                                        <li>Extra</li>
                                        <li>Note</li>
                                    </ul>
                  					<div class="col-md-12 col-md-offset-0 tabs" id="tab1" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height: 390px;">
                                    <div class="row">
                                    	<div style="width:330px;float:left;">
                                            <input type="hidden" name="submitted" id="submitted" value="1">
                                            <div style="float:left; padding:2px; width:350px;">
                                                <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">First Name:</div>
                                                <div style="float:left; width:180px;">
                                                    <input type="text" class="form-control customer" id="firstname" name="firstname" placeholder="First Name" autofocus>
                                                </div>
                                            </div>
                                            
                                            <div style="float:left; padding:2px; width:350px;">
                                                <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Last Name:</div>
                                                <div style="float:left; width:180px;">
                                                    <input type="text" class="form-control customer" id="lastname" name="lastname" placeholder="Last Name">
                                                </div>
                                            </div>
                                            
                                            <div style="float:left; padding:2px; width:350px;">
                                                <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Company:</div>
                                                <div style="float:left; width:180px;">
                                                    <input type="text" class="form-control customer" id="company" name="company" placeholder="Company">
                                                </div>
                                                <div style="float:left;">
                                                    <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                                </div>
                                            </div>
                                            
                                            <div style="float:left; padding:2px; width:350px;">
                                                <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Address1:</div>
                                                <div style="float:left; width:180px;">
                                                    <input type="text" class="form-control customer" id="address1" name="address1" placeholder="Address1">
                                                </div>
                                            </div>
                                            
                                            <div style="float:left; padding:2px; width:350px;">
                                                <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Address2:</div>
                                                <div style="float:left; width:180px;">
                                                    <input type="text" class="form-control customer" id="address2" name="address2" placeholder="Address2">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div style="width:330px;float:left;">
                                        	<div style="float:left; padding:2px; width:350px;">
                                                <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Phone1:</div>
                                                <div style="float:left; width:180px;">
                                                    <input type="text" class="form-control customer phone" id="phone1" name="phone1" placeholder="Phone1">
                                                </div>
                                            </div>
                                            
                                            <div style="float:left; padding:2px; width:350px;">
                                                <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Phone2:</div>
                                                <div style="float:left; width:180px;">
                                                    <input type="text" class="form-control customer phone" id="phone2" name="phone2" placeholder="Phone2">
                                                </div>
                                            </div>
                                            
                                            <div style="float:left; padding:2px; width:350px;">
                                                <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Phone3:</div>
                                                <div style="float:left; width:180px;">
                                                    <input type="text" class="form-control customer phone" id="phone3" name="phone3" placeholder="Phone3">
                                                </div>
                                            </div>
                                            
                                            <div style="float:left; padding:2px; width:350px;">
                                                <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Fax:</div>
                                                <div style="float:left; width:180px;">
                                                    <input type="text" class="form-control customer phone" id="fax" name="fax" placeholder="Fax">
                                                </div>
                                            </div>
                                            
                                            <div style="float:left; padding:2px; width:400px;">
                                                <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Email:</div>
                                                <div style="float:left; width:250px;">
                                                    <div class="btn-group">
                                                        <input type="email" class="form-control searchinput customer" id="email" name="email" placeholder="Email Address">
                                                        <span id="edit_searchclear" class="edit_searchclear glyphicon glyphicon-remove-circle"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div style="width:450px;float:left;">
                                        	<div style="float:left; padding:2px; width:350px;">
                                                <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Zip:</div>
                                                <div style="float:left; width:180px;">
                                                    <jqx-combo-box id="zipcode" jqx-on-select="zipselectHandler(event)" jqx-settings="zipcode" jqx-place-holder="placeHolderzipcode"></jqx-combo-box>
                                                </div>
                                            </div>
                                            
                                        	<div style="float:left; padding:2px; width:350px;">
                                                <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">City:</div>
                                                <div style="float:left; width:180px;">
                                                    <jqx-combo-box id="city" jqx-on-select="cityselectHandler(event)" jqx-settings="city" jqx-place-holder="placeHoldercity"></jqx-combo-box>
                                                </div>
                                            </div>
                                            
                                            <div style="float:left; padding:2px; width:350px;">
                                                <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">State:</div>
                                                <div style="float:left; width:180px;">
                                                    <jqx-combo-box id="state" jqx-on-select="stateselectHandler(event)" jqx-settings="state" jqx-place-holder="placeHolderstate"></jqx-combo-box>
                                                </div>
                                            </div>
                                            
                                            <div style="float:left; padding:2px; width:350px;">
                                                <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Island:</div>
                                                <div style="float:left; width:180px;">
                                                    <jqx-combo-box id="island" jqx-on-select="islandselectHandler(event)" jqx-settings="island" jqx-place-holder="placeHolderisland"></jqx-combo-box>
                                                </div>
                                            </div>
                                            
                                            <div style="float:left; padding:2px; width:350px;">
                                                <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Country:</div>
                                                <div style="float:left; width:180px;">
                                                    <jqx-combo-box id="country" jqx-on-select="countryselectHandler(event)" jqx-settings="country" jqx-place-holder="placeHoldercountry"></jqx-combo-box>
                                                </div>
                                            </div>
                                        </div>
                                      </div><!--End Row-->
                                    </div><!--End tab 1-->
                                    <div class="col-md-12 col-md-offset-0 tabs" id="tab2" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height: 390px;">
                    					<div class="row">
                                            <div style="width:330px;float:left;">
                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Website:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control customer" id="website" name="website" placeholder="Website">
                                                    </div>
                                                </div>
                                                
                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Custom1:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control customer" id="custom1" name="custom1" placeholder="Custom1">
                                                    </div>
                                                </div>
                                                
                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Custom2:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control customer" id="custom2" name="custom2" placeholder="Custom2">
                                                    </div>
                                                </div>
                                                
                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Custom3:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control customer" id="custom3" name="custom3" placeholder="Custom3">
                                                    </div>
                                                </div>
                                                
                                        	</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-md-offset-0 tabs" id="tab3" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height:390px;">
                                    	<div class="row">
                                        	<div style="width:100%;float:left;">
                                                 <div style="float:left; padding:2px; width:100%;">
                                                    <div style="float:left; padding:8px; text-align:left; width:100px; font-weight:bold;">Note:</div>
                                                    <div style="float:left; width:100%;"> 
                                                        <textarea rows="15" id="note" name="note" class="form-control customer" placeholder="Note"></textarea>                                                     </div>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </jqx-tabs>
                            </div>
                            <div class="col-md-12 col-md-offset-0">
                                <div class="row">
                                    <div id="_btnscd">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button type="button" id="_update" class="btn btn-primary" disabled>Save</button>
                                                <button	type="button" id="_cancel" class="btn btn-warning">Close</button>
												<button	type="button" id="_canceldeleted" class="btn btn-warning" style="display:none;">Close</button>
                                                <button	type="button" id="_delete" class="btn btn-danger">Delete</button>
                                                <button	type="button" id="_restore" class="btn btn-success" style="display:none;">Restore</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="msg" style="display:none; overflow:auto;">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                Would you like to save your changes.
                                                <button type="button" id="_yes" class="btn btn-primary">Yes</button>
                                                <button type="button" id="_no" class="btn btn-warning">No</button>
                                                <button type="button" id="_conf_cancel" class="btn btn-info">Cancel</button>
                                            </div>
                                        </div>
                                   </div>
                                   <div id="msg_delete" style="display:none; overflow:auto;">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <p id="delmsg"></p>
                                                <button type="button" id="_delyes" class="btn btn-primary">Yes</button>
                                                <button type="button" id="_delno" class="btn btn-warning">No</button>
                                            </div>
                                        </div>
                                   </div>
                                </div>
                           </div>
                        </div>
                        <div id="edit_jqxNotification">
                            <div id="edit_notificationContent"></div>
                        </div>
                        <div id="edit_email_jqxNotification">
                            <div id="edit_email_notificationContent"></div>
                        </div>
                        <div id="edit_save_jqxNotification">
                            <div id="edit_save_notificationContent"></div>
                        </div>
                        <div id="edit_delete_jqxNotification">
                            <div id="edit_delete_notificationContent"></div>
                        </div>
                        <div id="edit_restore_jqxNotification">
                            <div id="edit_restore_notificationContent"></div>
                        </div>
                        <div id="edit_container" style="width: 400px; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;">
                        </div>
                        <!--
                        <div style="width:100%; float:left;">
                             <p id="message"></p>
                        </div>
                        -->
                   </div>          
                </jqx-window>
                <jqx-window jqx-on-close="close()" id="supplier-form" class="supplier_form" jqx-create="addialogSettings" jqx-settings="addialogSettings" style="display:none; overflow: hidden;">
                	<div>Add New Supplier</div>
                        <div id="addform" style="overflow: hidden;">
                            <div id="addform_handler" style="overflow: hidden;">
                                <div class="col-md-12 col-md-offset-0" id="table_add" style="float:left;">
                                       <jqx-tabs jqx-width="'100%'" jqx-height="'100%'" style='float: left;' jqx-theme="thetabsadd" jqx-settings="tabsSettings" jqx-selected-item="selectedItem">
                                        <ul style="margin-left: 30px;">
                                            <li>Info</li>
                                            <li>Extra</li>
                                            <li>Note</li>
                                        </ul>
                                     <div class="col-md-12 col-md-offset-0 tabs" id="addtab1" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;">								
                                        <div class="row">
                                        	<div style="width:330px;float:left;">
                                                <input type="hidden" name="submitted" id="submitted" value="1">
                                                <div style="float:left; padding:2px; width:350px;">
                                                	<div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">First Name:</div>
                                                    <div style="float:left; width:180px;">
                                                    	<input type="text" class="form-control addcustomer" id="add_firstname" name="add_firstname" placeholder="First Name" autofocus>
                                                    </div>
                                                </div>
                                                
                                                <div style="float:left; padding:2px;  width:350px;">
                                                	<div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Last Name:</div>
                                                    <div style="float:left; width:180px;">
                                                    	<input type="text" class="form-control addcustomer" id="add_lastname" name="add_lastname" placeholder="Last Name">
                                                    </div>
                                                </div>
												
                                                <div style="float:left; padding:2px;  width:350px;">
                                                	<div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Company:</div>
                                                    <div style="float:left; width:180px;">
                                                    	<input type="text" class="form-control addcustomer" id="add_company" name="add_company" placeholder="Company">
                                                    </div>
                                                    <div style="float:left;">
                                                    	<span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                                    </div>
                                                </div>
                                                
                                                <div style="float:left; padding:2px;  width:350px;">
                                                	<div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Address1:</div>
                                                    <div style="float:left; width:180px;">
                                                    	<input type="text" class="form-control addcustomer" id="add_address1" name="add_address1" placeholder="Address1">
                                                    </div>
                                                </div>
                                                
                                              
                                                <div style="float:left; padding:2px;  width:350px;">
                                                	<div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Address2:</div>
                                                    <div style="float:left; width:180px;">
                                                    	<input type="text" class="form-control addcustomer" id="add_address2" name="add_address2" placeholder="Address2">
                                                    </div>
                                                </div>
                                             </div><!--End Grid1-->
                                             <div style="width:330px;float:left;">
                                                <div style="float:left; padding:2px; width:350px;">
                                                	<div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Phone1:</div>
                                                    <div style="float:left; width:180px;"> 
                                                    	<input type="text" class="form-control addcustomer phone" id="add_phone1" name="add_phone1" placeholder="Phone1">
                                                    </div>
                                                </div>
                                            
                                                
                                                <div style="float:left; padding:2px; width:350px;">
                                                	<div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Phone2:</div>
                                                    <div style="float:left; width:180px;"> 
                                                    	<input type="text" class="form-control addcustomer phone" id="add_phone2" name="add_phone2" placeholder="Phone2">
                                                    </div>
                                                </div>
                                                
                                                
                                                <div style="float:left; padding:2px; width:350px;">
                                                	<div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Phone3:</div>
                                                    <div style="float:left; width:180px;"> 
                                                    	<input type="text" class="form-control addcustomer phone" id="add_phone3" name="add_phone3" placeholder="Phone3">
                                                    </div>
                                                </div>
                                                
                                                <div style="float:left; padding:2px; width:350px;">
                                                	<div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Fax:</div>
                                                    <div style="float:left; width:180px;"> 
                                                    	<input type="text" class="form-control addcustomer phone" id="add_fax" name="add_fax" placeholder="Fax">
                                                    </div>
                                                </div>
                                                
                                                <div style="float:left; padding:2px; width:400px;">
                                                	<div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Email:</div>
                                                    <div style="float:left; width:250px;"> 
                                                    	<div class="btn-group">
                                                            <input type="email" class="form-control searchinput addcustomer" id="add_email" name="add_email" placeholder="Email Address" value="">
                                                            <span id="searchclear" class="searchclear glyphicon glyphicon-remove-circle"></span>
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div><!--End Grid2-->
                                            
                                            <div style="width:450px;float:left;">
                                                <div style="float:left; padding:2px; width:450px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Zip:</div>
                                                    <div style="float:left; width:180px;">
                                                        <jqx-combo-box id="add_zip" jqx-on-select="addzipselectHandler(event)" jqx-settings="addzipcode" jqx-place-holder="placeHolderaddzipcode"></jqx-combo-box>
                                                    </div>
                                                    <div style="float:left;">
                                                        <span class="add_sel_zipcode_message" style="color:#F00;"></span>
                                                    </div>
                                                </div>
                                            
                                                <div style="float:left; padding:2px;  width:450px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">City:</div>
                                                    <div style="float:left; width:180px;">
                                                        <jqx-combo-box id="add_city" jqx-on-select="addcityselectHandler(event)" jqx-settings="addcity" jqx-place-holder="placeHolderaddcity"></jqx-combo-box>
                                                    </div>
                                                </div>
                                           
                                                <div style="float:left; padding:2px;  width:450px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">State:</div>
                                                    <div style="float:left; width:180px;">
                                                        <jqx-combo-box id="add_state" jqx-on-select="addstateselectHandler(event)" jqx-settings="addstate" jqx-place-holder="placeHolderaddstate"></jqx-combo-box>
                                                    </div>
                                                </div>
                                            
                                           
                                                <div style="float:left; padding:2px;  width:450px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Island:</div>
                                                    <div style="float:left; width:180px;">
                                                        <jqx-combo-box id="add_island" jqx-on-select="addislandselectHandler(event)" jqx-settings="addisland" jqx-place-holder="placeHolderaddisland"></jqx-combo-box>
                                                    </div>
                                                </div>
                                         
                                                <div style="float:left; padding:2px;  width:450px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Country:</div>
                                                    <div style="float:left; width:180px;">
                                                        <jqx-combo-box id="add_country" jqx-on-select="addcountryselectHandler(event)" jqx-settings="addcountry" jqx-place-holder="placeHolderaddcountry"></jqx-combo-box>
                                                    </div>
                                                </div>
                                            </div><!--End Grid 3-->
                                        </div><!--End Grid Row-->
                                     </div><!--End Tab1-->
                                     
                                     <div class="col-md-12 col-md-offset-0 tabs" id="addtab2" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height: 390px;">
                                         <div class="row">
                                         	<div style="width:350px;float:left;">
                                                 <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Website:</div>
                                                    <div style="float:left; width:180px;"> 
                                                        <input type="text" class="form-control addcustomer" id="add_website" name="add_website" placeholder="Website">
                                                    </div>
                                                 </div>
                                                   
                                                 <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Custom1:</div>
                                                    <div style="float:left; width:180px;"> 
                                                        <input type="text" class="form-control addcustomer" id="add_custom1" name="add_custom1" placeholder="Custom1">
                                                    </div>
                                                 </div>
                                                 
                                                 <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Custom2:</div>
                                                    <div style="float:left; width:180px;"> 
                                                        <input type="text" class="form-control addcustomer" id="add_custom2" name="add_custom2" placeholder="Custom2">
                                                    </div>
                                                 </div>
                                                 
                                                 <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Custom3:</div>
                                                    <div style="float:left; width:180px;"> 
                                                        <input type="text" class="form-control addcustomer" id="add_custom3" name="add_custom3" placeholder="Custom3">
                                                    </div>
                                                 </div>
                                            </div>     
                                         </div>    
                                     </div> 
                                        
                                        <div class="col-md-12 col-md-offset-0 tabs" id="addtab3" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height: 390px;">
                                            <div class="row">
                                                <div style="width:100%;float:left;">
                                                     <div style="float:left; padding:2px; width:100%;">
                                                        <div style="float:left; padding:8px; text-align:left; width:100px; font-weight:bold;">Note:</div>
                                                        <div style="float:left; width:100%;"> 
                                                            <textarea rows="15" id="add_note" name="add_note" class="form-control addcustomer" placeholder="Note"></textarea>
                                                        </div>
                                                     </div>
                                                </div>     
                                            </div>         
                                        </div>	                       	
                                	</jqx-tabs>
                                    <div class="col-md-12 col-md-offset-0">
                                        <div class="row">
                                            <div id="add_btnscd">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <!--<button type="button" id="_new" class="btn btn-success btn-lg">New</button>-->
                                                        <button type="button" id="add_save" class="btn btn-primary" disabled>Save</button>
                                                        <button	type="button" id="add_cancel" class="btn btn-warning">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="add_msg" style="display:none; margin-top:10px; overflow:auto;">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        Would you like to save your changes.
                                                        <button type="button" id="add_yes" class="btn btn-primary">Yes</button>
                                                        <button type="button" id="add_no" class="btn btn-warning">No</button>
                                                        <button type="button" id="add_conf_cancel" class="btn btn-info">Cancel</button>
                                                    </div>
                                                </div>     
                                           </div>
                                        </div>
                                        <div class="row">
                                        	 <div id="add_confirmation_after_save" style="display:none; margin-top:10px; overflow:auto;">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <label id="addsavedmymessage"></label>    
                                                        <button type="button" id="add_aftersave_yes" class="btn btn-primary">Yes</button>
                                                        <button type="button" id="add_aftersave_no" class="btn btn-warning">No</button>
                                                    </div>
                                                </div>     
                                            </div>
                                        </div>
                                   </div>
                                </div>
                            </div>
                            <div id="add_jqxNotification">
                                <div id="add_notificationContent"></div>
                            </div>
                            <div id="add_email_jqxNotification">
                                <div id="add_email_notificationContent"></div>
                            </div>
                            <div id="add_save_jqxNotification">
                                <div id="add_save_notificationContent"></div>
                            </div>
                            <div id="add_container" style="width: 400px; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;">
                            </div>
                        </div>
                  </jqx-window>
            </div>
       </div>
   </div>  
</div>
             

<style type="text/css">
	body{
		padding: 0;
		margin: 0;
	}
	
	.required{
		color: #F00;
	}
	
	div.toolbar-list a {
        cursor: pointer;
        display: block;
        float: left;
        padding: 1px 10px;
        white-space: nowrap;
    }

    div.toolbar-list span {
        display: block;
        float: none;
        height: 32px;
        margin: 0 auto;
        width: 32px;
    }
    .icon-32-new {
        background-image: url("../assets/img/addnew.png");
    }

    .icon-32-edit{
        background-image: url("../assets/img/edit.png");
    }

    .icon-32-trash{
        background-image: url("../assets/img/remove3.png");
    }
	
	.icon-32-back {
        background-image: url("../assets/img/back.png");
    }
	
	.supplier_form{
		min-height: 72% !important;
		min-width: 55% !important;
	}
	
	.ngx-icon-close{
		display:none;
	}
	
	.supplier_form{
		-webkit-border-radius: 15px 15px 15px 15px;
		border-radius: 15px 15px 15px 15px;
		border: 5px solid #449bca;
	}
	
	#ngxTabs0{
		-webkit-border-radius: 20px 20px 20px 20px;
		border-radius: 20px 20px 20px 20px;
	}

	
	#ngxTabs1{
		-webkit-border-radius: 20px 20px 20px 20px;
		border-radius: 20px 20px 20px 20px;
	}
	
	div.growlUI { background: url("../assets/img/symbol_check.png") no-repeat 10px 10px; width:48px; }
	div.growlUI h1, div.growlUI h2 {
		color: white; padding: 5px 5px 5px 65px; text-align: left
	}
	
	div.growlUI h1{
		font-size:1.5em;
	}
	div.growlUI h2{
		font-size: 1em;
	}

	#editform{
		position:relative;	
	}
	
	.taskbar{
		border-top: 2px solid #CCC;
		overflow: auto;
		bottom: 0px;
        height: 30px;
        width: 100%;
		position:absolute;
		left:0px;
	}
	
	.add_taskbar{
		border-top: 2px solid #CCC;
		overflow: auto;
		bottom: 0px;
        height: 30px;
        width: 100%;
		position:absolute;
		left:0px;
	}

	.searchclear {
		position:absolute;
		right:5px;
		top:0;
		bottom:0;
		height:14px;
		margin:auto;
		font-size:14px;
		cursor:pointer;
		color:#ccc;
	}

	.edit_searchclear {
		position:absolute;
		right:5px;
		top:0;
		bottom:0;
		height:14px;
		margin:auto;
		font-size:14px;
		cursor:pointer;
		color:#ccc;
	}
</style>