<?php
	angularplugins();
	angulartheme_arctic();
	angulartheme_metrodark();
	angulartheme_darkblue();
	jqxplugindatetime();
	jqxangularjs();
	jqxthemes();
?>
<script type="text/javascript">
	//-->Global Variable
	var SiteRoot = "<?php echo base_url()?>";
	var DynamicTab;
	var selzipcode, selzipunique, selcity, selstate, selisland, selcountry="";
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
	
		$("#zip").select2();
		$("#add_zip").select2();
		$("#add_city").select2();
		$("#add_state").select2();
		$("#add_county").select2();
		//$("#add_country").select2();
		
		/*
		$('.phone').inputmask({
		  mask: '(99?9) 999-9999'
		})

		$("#phone1").click(function(){
			var len = $(this).val().length;
			if (len >= 6) {
			  //do nothing
			} else {
			  $(this).val("("+areacode+")");
			}
		})
		
		$("#phone1").on("blur", function(){
			countChar();
		})
		*/
	})
	
	function changetabtile(){
		$("#tabtitle").html("Supplier");
	}
	
	var demoApp = angular.module("demoApp", ["ngwidgets", "jqwidgets"]);
	demoApp.controller("demoController", function ($scope, $compile) {
		
		$("#_cancel").click(function(){
			window.location.reload();
			/*
			var changed = $("#_update").is(":disabled");
			if(changed){
				$("#tab1").unblock(); 
				$("#tab2").unblock(); 
				$("#tab3").unblock(); 
				reset_form();
				$scope.gridSettings.disabled = false;
				dialog.close();
				$("#SupplierController").unblock();
				$scope.$apply(function(){
					$scope.tabset = {}
					
					$scope.gridSettings =
					{	
						disabled: false,
						created: function(args)
						{
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
				})
				
				$scope.$apply(function(){
					$scope.tabset = {
						selectedItem: 0
					}
				})
				
			}else{
				$("#_btnscd").hide();
				$("#msg").show();
				$("#msg_delete").hide();
				$('#tab1').block({ message: null }); 
				$('#tab2').block({ message: null });
				$('#tab3').block({ message: null });  
			}
			$("#del_confirmation_msg").hide();
			$("#delmymessage").html("");
			*/
		})
		
		$("#_no").click(function(){
			$scope.gridSettings.disabled = false;
			$scope.$apply(function(){
				$scope.tabset = {
					selectedItem: 0
				}
			})
			dialog.close();
			reset_form();
		})
		
		$("#_conf_cancel").click(function(){

			$scope.$apply(function(){
				$scope.tabset = {
					selectedItem: 0
				}
			})

			$('#tab1').unblock(); 
			$('#tab2').unblock();
			$('#tab3').unblock(); 
			$("#msg").hide();
			$("#_btnscd").show();

		})
		
		$("#_update").click(function(){
			$.when(update_supplier_info()).done(function(){
				$scope.$apply(function(){
					$scope.tabset = {};
				})
			})
			/*
			$scope.$apply(function(){
				$scope.tabset = {
					selectedItem: 0
				};
			})
			*/
		})
		
		$("#_yes").click(function(){
			$scope.gridSettings.disabled = false;
			$("#SupplierController").unblock();
			dialog.close();
			$.when(update_supplier_info()).done(function(){
				$scope.$apply(function(){
					$scope.tabset = {};
					
					$scope.gridSettings =
					{	
						disabled: false,
						created: function(args)
						{
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
				})
				
				$scope.$apply(function(){
					$scope.tabset = {
						selectedItem: 0
					}
				})
			})
			$("#msg").hide();
			$("#_btnscd").show();
			$('#tab1').unblock(); 
			$('#tab2').unblock();
		})
		
		$("#_delete").click(function(){
			var supplierid = $("#supplierid").val();
			var name = $("#firstname").val() + " " + $("#lastname").val();
			var company = $("#company").val(); 
			$("#_btnscd").hide();
			$("#msg_delete").show();
			$("#delmsg").text("Would you like to delete "+supplierid+" "+name+" "+company+"?");
		})
		
		$("#_delyes").click(function(){
			$.when(delete_process()).then(function(){
				$("#_btnscd").show();
				$("#_restore").show();
				$("#_delete").hide();
			})
		})
		
		$("#_delno").click(function(){
			$("#msg_delete").hide();
			$("#_btnscd").show();
			$("#delmsg").text("");
		})
		
		$("#_restore").click(function(){
			$.when(restore_process()).done(function(){
				$("#del_confirmation_msg").hide();
				$("#delmymessage").html("");
				$("#_restore").hide();
				$("#_delete").show();
				$("#_delete").attr("disabled",false);		
			})	
		})
		
		
		$("#_addnew").on("click", function(){
			$("#ngxTabs1").block({
				message: '<img src='+SiteRoot+'/assets/img/ajax-loader.gif />' 
			});
			var DefaultZipCode = $("#default_zipcode").val();
				$scope.addzipcode.apply('selectItem', DefaultZipCode);
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
									$scope.gridSettings.disabled = true;
									$scope.selectedItem = 0;
								})	
								$("#SupplierController").block({message : null});
								addialog.open();
								add_reset_form();
							})
						})
					})
				})
			
			$scope.$apply(function(){
				$scope.tabsSettings = {};
			})	
		})
		
		
		$("#add_cancel").click(function(){
			//window.location.reload();

			var addsavebtn = $("#add_save").is(":disabled");
			if(addsavebtn){
				add_reset_form();
				$scope.$apply(function(){
					$scope.tabsSettings = {};
				})
				$scope.$apply(function(){
					addialog.close();
					$scope.gridSettings.disabled = false;
					$scope.tabsSettings = {
						selectedItem : 0
					}
				})	
				$("#SupplierController").unblock();
			}else{
				$("#add_msg").show();
				$("#add_btnscd").hide();
			}
			
			$scope.$apply(function(){
				$scope.gridSettings = {	
					disabled: false,
					created: function(args)
					{
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
			});

			
		})
		
		$("#add_save").click(function(){
			$.when(add_supplier_info()).done(function(){})
		})
		
		$("#add_aftersave_yes").click(function(){
			add_reset_form();
			$scope.$apply(function(){
				$scope.tabsSettings = {
					selectedItem : 0
				}
			});			
			$("#add_confirmation_after_save").hide();
			$("#addsavedmymessage").html("");
			$("#add_btnscd").show();
			$("#add_save").attr("disabled", true);
		})
		
		$("#add_aftersave_no").click(function(){
			add_reset_form();
			$scope.$apply(function(){
				$scope.tabsSettings = {
					selectedItem : 0
				}
			});	
			$scope.gridSettings.disabled = false;
				addialog.close();
				$("#SupplierController").unblock();
				$scope.$apply(function(){
					$scope.gridSettings =
					{	
						disabled: false,
						created: function(args)
						{
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
				})
				$("#add_confirmation_after_save").hide();
		   })
		

		$("#add_zip").on("change", function(){
			$.when(add_selected_zipcode()).done();
		})
		
		$("#add_yes").click(function(){
			$.when(add_supplier_info()).done(function(){
				$scope.$apply(function(){
					$scope.tabsSettings = {
						selectedItem : 0
					}
				});
			});
			$("#add_msg").hide();
			$("#add_btnscd").hide();
		})
		
		$("#add_no").click(function(){
			add_reset_form();
			$("#SupplierController").unblock();
			$scope.gridSettings.disabled = false;
			addialog.close();
			$scope.$apply(function(){
				$scope.tabsSettings = {
					selectedItem: 0
				}
			});	
		})
		
		$("#add_conf_cancel").click(function(){
			$scope.$apply(function(){
				$scope.tabsSettings = {};
			})
			add_reset_form();
			$("#add_msg").hide();
			$("#add_btnscd").show();
			$scope.$apply(function(){
				$scope.tabsSettings = {
					selectedItem: 0
				};
			})
		})

//############################################################################################################################################################################//
															//# Load Supplier List #//
		
		$scope.thetabs = 'darkblue';
		$scope.thetabsadd = 'darkblue';
		
		$scope.tabset = {
			selectedItem:0	
		}
		$scope.tabsSettings = {
			selectedItem:0
		}
			
		$scope.gridSettings =
		{	
			disabled: false,
			created: function(args)
			{
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
			columnsResize: true,
			width: "99.7%",
			theme: 'arctic',
			sortable: true,
			pageable: true,
			pageSize: 20,
			pagerMode: 'advanced',
			altRows: true,
			filterable: true,
			filterMode: 'simple',
			ready: function () {
                    $scope.dialogSettings =
                    {
                        created: function(args)
                        {
                            dialog = args.instance;
                        },
                        resizable: false,
                        width: "100%", height: 900,
                        autoOpen: false,
						theme: 'darkblue'
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
						theme: 'darkblue'
					}
                },
			columns: [
				{ text: 'ID', dataField: 'Unique', width: "5%" },
				{ text: 'First Name', dataField: 'FirstName', width: "8%" },
				{ text: 'Last Name', dataField: 'LastName', width: '8%' },
				{ text: 'Company', dataField: 'Company', width: '15%' },
				{ text: 'Address1', dataField: 'Address1', width: '7%' },
				{ text: 'Address2', dataField: 'Address2', width: '7%' },
				{ text: 'City', dataField: 'City', width: '7%' },
				{ text: 'State', dataField: 'State', width: '4%',},
				{ text: 'Zip', dataField: 'Zip', width: '5%'},
				{ text: 'Country', dataField: 'Country', width: '5%' },
				{ text: 'Phone1', dataField: 'Phone1', width: '5%' },
				{ text: 'Phone2', dataField: 'Phone2', width: '5%' },
				{ text: 'Phone3', dataField: 'Phone3', width: '5%' },
				{ text: 'E-mail', dataField: 'Email', width: '7%' },
				{ text: 'Fax', dataField: 'Fax', width: '7%' },
				{ text: 'Website', dataField: 'Website', hidden: true},
				{ text: 'Custom1', dataField: 'Custom1', hidden: true},
				{ text: 'Custom2', dataField: 'Custom2', hidden: true},
				{ text: 'Custom3', dataField: 'Custom3', hidden: true},
				{ text: 'Note', dataField: 'Note', hidden: true}
		  ]
		}
		
//############################################################################################################################################################################//
																			/* Row RowDoubleClick */
		$scope.rowDoubleClick = function (event) {
			var args = event.args;
			var index = args.index;
			var row = args.row;
			// update the widgets inside ngxWindow.
			reset_form();
			$("#SupplierController").block({ message: null });
			$scope.gridSettings.disabled = true;
			dialog.setTitle("Edit Supplier ID: " + row.Unique + " |" + row.FirstName+ " "+row.LastName);
			editRow = index;
			$("#supplierid").val(row.Unique);
			$("#firstname").val(row.FirstName);
			$("#lastname").val(row.LastName);
			$("#company").val(row.Company);
			$("#address1").val(row.Address1);
			$("#address2").val(row.Address2);
			$("#city").val(row.City);
			$("#state").val(row.State);
			$("#zip").val(row.Zip);
			$("#country").val(row.Country);
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
			})
			
			$scope.zipselectHandler = "";
			$scope.cityselectHandler = "";
			$scope.islandselectHandler = "";
			$scope.stateselectHandler = "";
			$scope.countryselectHandler = "";
			
			$.when(find_zipcode_selected(row.Zip)).then(function(){
				$.when(island(selzipunique)).then(function(){
					$scope.zipcode.apply('selectItem', selzipunique);
					$scope.city.apply('selectItem', selcity);
					$scope.island.apply('selectItem', selisland);
					$scope.state.apply('selectItem', selstate);
					$scope.country.apply('selectItem', selcountry);
					dialog.open();
					
					//Zip
					$scope.zipselectHandler = function (event) {
						var zipcodeargs = event.args;
						if (zipcodeargs) {
							enableSaveBtn();
							$.when(city(zipcodeargs.item.value)).then(function(){
								$scope.city.apply('selectItem', selcity);
								$.when(state(zipcodeargs.item.value)).then(function(){
									$scope.state.apply('selectItem', selstate);
									$.when(island(zipcodeargs.item.value)).then(function(){
										$scope.island.apply('selectItem', selisland);
										$.when(country(zipcodeargs.item.value)).done(function(){
											$scope.country.apply('selectItem', selcountry);
										})
									})
								})
							})
						}
					};
						
					//City	
					$scope.cityselectHandler = function (event) {
						var args = event.args;
						if (args) {
							enableSaveBtn();
							selcity = args.item.value;
						}
					};
					
					//Island
					$scope.islandselectHandler = function (event) {
						var args = event.args;
						if (args) {
							enableSaveBtn();
							selisland = args.item.value;
						}
					};
					
					//State
					$scope.stateselectHandler = function (event) {
						var args = event.args;
						if (args) {
							enableSaveBtn();
							selstate = args.item.value;
						}
					};
					
					//Country
					$scope.countryselectHandler = function (event) {
						var args = event.args;
						if (args) {
							enableSaveBtn();
							selcountry = args.item.value;
						}
					};
						
				})
			})
			
			$scope.tabset = {};
		
			
			setTimeout(function(){
				$("#firstname").focus();
			}, 200);
		}
//############################################################################################################################################################################//
															/*@@ City Drop Down @@*/														
		$scope.addcity = {selectedIndex: 0, source: citiesDataAdapter, displayMember: "City", valueMember: "Unique", width: "99%", height: 25};
		$scope.addcityselectHandler = function (event) {
			var args = event.args;
			if (args) {
				enableSaveBtn();
				selcity = args.item.value;
			}
		};
		$scope.placeHolderaddcity = "Select City";
		
		$scope.city = {selectedIndex: 0, source: citiesDataAdapter, displayMember: "City", valueMember: "Unique", width: "99%", height: 25};
		$scope.placeHoldercity = "Select City";
//############################################################################################################################################################################//	
															/*@@ Island Drop Down @@*/						
		$scope.addisland = {selectedIndex: 0, source: islandDataAdapter, displayMember: "Island", valueMember: "County", width: "99%", height: 25};
		$scope.addislandselectHandler = function (event) {
			var args = event.args;
			if (args) {
				enableSaveBtn();
				selisland = args.item.value;
			}
		};
		$scope.placeHolderaddisland = "Select Island";
		
		$scope.island = {selectedIndex: 0, source: islandDataAdapter, displayMember: "Island", valueMember: "County", width: "99%", height: 25};
		$scope.placeHolderisland = "Select Island";	
//############################################################################################################################################################################//	
															/*@@ State Drop Down @@*/	
		$scope.addstate = {selectedIndex: 0, source: statesDataAdapter, displayMember: "State", valueMember: "StateID", width: "99%", height: 25};
		$scope.addstateselectHandler = function (event) {
			var args = event.args;
			if (args) {
				enableSaveBtn();
				selstate = args.item.value;
			}
		};
		$scope.placeHolderaddstate = "State";
		
		$scope.state = {selectedIndex: 0, source: statesDataAdapter, displayMember: "State", valueMember: "StateID", width: "99%", height: 25};
		$scope.placeHolderstate = "Select State";
//############################################################################################################################################################################//	
															/*@@ Zip Code Drop Down @@*/	
		$scope.addzipcode = { selectedIndex: 0, source: zipcodesDataAdapter, displayMember: "ZipCode", valueMember: "Unique", width: "99%", height: 25};
		$scope.addzipselectHandler = function (event) {
			var args = event.args;
			if (args) {
				//enableAddSaveBtn();
				$.when(city(args.item.value)).then(function(){
					$scope.addcity.apply('selectItem', selcity);
					$.when(state(args.item.value)).then(function(){
						$scope.addstate.apply('selectItem', selstate);
						$.when(island(args.item.value)).then(function(){
							$scope.addisland.apply('selectItem', selisland);
							$.when(country(args.item.value)).done(function(){
								$scope.addcountry.apply('selectItem', selcountry);
							})
						})
					})
				})
			}
		};
		$scope.placeHolderaddzip = "Select Zip Code";
		$scope.zipcode = {selectedIndex: 0, source: zipcodesDataAdapter, displayMember: "ZipCode", valueMember: "Unique", width: "99%", height: 25};
		$scope.placeHolderzipcode = "Select Zip Code";
//######################################################################################################################################################################//	
															/*@@ Country Drop Down @@*/	
		$scope.addcountry = { selectedIndex: 0, source: countriesDataAdapter, displayMember: "CountryName", valueMember: "CountryCode", width: "99%", height: 25};
		$scope.addcountryselectHandler = function (event) {
			var args = event.args;
			if (args) {
				selcountry = args.item.value;
			}
		};
		$scope.placeHolderaddcountry = "Select Country";
		
		$scope.country = {selectedIndex: 0, source: countriesDataAdapter, displayMember: "CountryName", valueMember: "CountryCode", width: "99%", height: 25};
		$scope.placeHoldercountry = "Select Country";
//######################################################################################################################################################################//
	})
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
		$("#city").val("");
		$("#state").val("");
		$("#zip").val("");
		$("#country").val("");
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
		$('#tab1').unblock(); 
		$('#tab2').unblock(); 
		$('#tab3').unblock();
		$("#msg").hide();
		$("#SupplierController").unblock();
		$("#_btnscd").show();
		$("#_update").attr("disabled",true);
		$("#_delete").attr("disabled",false);
		$("#_restore").hide();
		$("#_delete").show();
		setTimeout(function(){
			$("#firstname").focus();
		}, 200);
	}
	
	function update_supplier_info(){
		var updatedefer = $.Deferred();
		var supplierid = $("#supplierid").val();
		var fname = $("#firstname").val();
		var lname = $("#lastname").val();
		var company = $("#company").val();
		var address1 = $("#address1").val();
		var address2 = $("#address2").val();
		var city = selcity; 
		var state = selstate; 
		var zip = selzipcode;
		var country = selcountry;
		var phone1 = $("#phone1").val();
		var phone2 = $("#phone2").val();
		var phone3 = $("#phone3").val();
		var email = $("#email").val();
		var fax = $("#fax").val();
		var website = $("#website").val();
		var custom1 = $("#custom1").val();
		var custom2 = $("#custom2").val();
		var custom3 = $("#custom3").val();
		var note = $("#note").val();
		
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
		
		if(fname == '' || lname == ''){
			var elementStr = $("#message").text("");
			$("#message").text("Please fill out all required fields.");
			$("#message").css({"color":"#F00"})
			confirmation_message();
		}else{
			if(email != ''){
				if(check_email(email)){
					update_supplier_info_save(post_data);
				}else{
					$("#message").text("Please type a valid email address.");
					$("#message").css({"color":"#F00"})
					confirmation_message();
				}	
			}else{
				update_supplier_info_save(post_data);
			}
		}	
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
					$("#message").css({"color":"#5cb85c"})
					confirmation_message();	
				}
				updatesuppDefer.resolve();
			},
			error: function(){
				updatesuppDefer.reject();
				alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
			}
		})
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
					$("#message").text(global_custid+" "+global_custname+" "+"marked for deletion. To finalize deletion, select CLOSE or select RESTORE to undo");
					$("#message").fadeIn();
					$("#message").css({"color":"#F00"});
					confirmation_message();
				}
				deferdeleteitem.resolve();
			},
			error: function(){
				deferdeleteitem.reject();
				alert("Sorry, we encoutered a technical difficulties\nPlease try again later.");
			}
		})
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
					$("#message").text("Supplier Restored.");
					$("#message").fadeIn();
					$("#message").css({"color":"#5cb85c"})
					confirmation_message();
				}
				restoredefer.resolve();
			},
			error: function(){
				alert("Sorry, we encoutered a technical difficulties\nPlease try again later.");
			}
		})
		return restoredefer.promise();
	}
	
	
	function add_supplier_info(){
		var fname = $("#add_firstname").val();
		var lname = $("#add_lastname").val();
		var company = $("#add_company").val();
		var address1 = $("#add_address1").val();
		var address2 = $("#add_address2").val();
		var city = selcity; //$("#add_city").val();
		var state = selstate; //$("#add_state").val();
		var zip = selzipcode; //$("#add_zip").val();
		var country = selcountry; //$("#add_country").val();
		var phone1 = $("#add_phone1").val();
		var phone2 = $("#add_phone2").val();
		var phone3 = $("#add_phone3").val();
		var email = $("#add_email").val();
		var fax = $("#add_fax").val();
		var website = $("#add_website").val();
		var custom1 = $("#add_custom1").val();
		var custom2 = $("#add_custom2").val();
		var custom3 = $("#add_custom3").val();
		var note = $("#add_note").val();
		
		var	post_data="&fname="+fname;
			post_data+="&lname="+lname;
			post_data+="&company="+company;
			post_data+="&address1="+address1;
			post_data+="&address2="+address2;
			post_data+="&city="+city;
			post_data+="&state="+state;
			post_data+="&zip="+zip;
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
		
		if(fname == '' || lname == ''){
			$("#add_message").text("Please fill out all required fields.");
			$("#add_message").css({"color":"#F00"});
			confirmation_message();
		}else{
			if(email != ''){
				if(check_email(email)){
					add_supplier_info_save(post_data);
				}else{
					$("#add_message").text("Please type a valid email address.");
					$("#add_message").css({"color":"#F00"});
					confirmation_message();
				}	
			}else{
				add_supplier_info_save(post_data);
			}
		}
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
					$("#add_confirmation_msg").show();
					$("#addsavedmymessage").html("Do you want to add another new Supplier?");
					$("#add_confirmation_after_save").show();
					$("#add_message").text("New Supplier information saved.");
					$("#add_message").css({"color":"#5cb85c"});
					$("#add_message").fadeIn();
					confirmation_message();
				}
				adddefer.resolve();
			},
			error: function(){
				adddefer.reject();
				alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
			}
		})
		return adddefer.promise();
	}
	
	function add_reset_form(){
		selzipcode="";
		selzipunique="";
		selcity="";
		selstate="";
		selisland="";
		selcountry="";
		$("#add_firstname").val("");
		$("#add_lastname").val("");
		$("#add_company").val("");
		$("#add_address1").val("");
		$("#add_address2").val("");
		$("#add_city").val("");
		$("#add_state").val("");
		$("#add_zip").select2().select2('val','');
		$("#add_country").val("");
		$("#add_phone1").val("");
		$("#add_phone2").val("");
		$("#add_phone3").val("");
		$("#add_email").val("");
		$("#add_fax").val("");
		$("#add_website").val("");
		$("#add_custom1").val("");
		$("#add_custom2").val("");
		$("#add_custom3").val("");
		$("#add_note").val("");
		$('#tab1').unblock(); 
		$('#tab2').unblock(); 
		$("#add_msg").hide();
		$("#add_btnscd").show();
		$("#add_save").attr("disabled", true);
		setTimeout(function(){
			$("#add_firstname").focus()
		}, 200);
	}
	

	function check_email(val){
		if(!val.match(/\S+@\S+\.\S+/)){ // Jaymon's / Squirtle's solution
			// Do something
			return false;
		}
		if( val.indexOf(' ')!=-1 || val.indexOf('..')!=-1){
			// Do something
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
				//$("#add_phone1").val(data.AreaCode);
				CityDefer.resolve();
			},
			error: function(){
				CityDefer.reject();
				alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
			}
		})
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
		})
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
		})
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
		})
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
		})
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

</script>
<input type="hidden" id="default_zipcode" value="<?php echo $zipcode; ?>"/>
<input type="hidden" id="supplierid" value="">
<div id="SupplierController" ng-controller="demoController">
	<div class="container-fluid">
        <div class="col-md-12 col-md-offset-0">
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
                                    <a style="outline:0;" id="_addnew">
                                        <span class="icon-32-new"></span>
                                        New
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url("backoffice/dashboard")?>" style="outline:0;">
                                        <span class="icon-32-back"></span>
                                        Menu
                                    </a>
                                </li>
                            </ul>
                        </div>
                     </div>
            	</nav>
            </div>
            <div class="row">
                <ngx-grid-view ngx-watch="gridSettings.disabled" ngx-on-row-double-click="rowDoubleClick(event)" ngx-settings="gridSettings"></ngx-grid-view>
                <ngx-window ngx-on-close="close()" class="supplier_form" ngx-create="dialogSettings" ngx-settings="dialogSettings" style="display:none;">
                	<div id="editform">
                        <div style="overflow: hidden;">
                            <div class="col-md-12 col-md-offset-0" id="table" style="float:left;">
                                <ngx-tabs ngx-width="'100%'" ngx-height="'100%'" style="float: left;" ngx-theme="thetabs" ngx-settings="tabset" ngx-selected-item="selectedItem">
                                    <ul style="margin-left: 30px;">
                                        <li>Info</li>
                                        <li>Extra</li>
                                        <li>Note</li>
                                    </ul>
                  					<div class="col-md-12 col-md-offset-0 tabs" id="tab1" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;">	
                                    <div class="row" style="width:100%;">
                                        <div class="col-md-6">	
                                            <input type="hidden" name="submitted" id="submitted" value="1">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="inputType" class="col-sm-3 control-label">First Name:</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control customer" id="firstname" name="firstname" placeholder="First Name" autofocus>
                                                    </div>
                                                    <span class="required">*</span>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="inputType" class="col-sm-3 control-label">Last Name:</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control customer" id="lastname" name="lastname" placeholder="Last Name">
                                                    </div>
                                                    <span class="required">*</span>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="inputType" class="col-sm-3 control-label">Company:</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control customer" id="company" name="company" placeholder="Company">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="inputType" class="col-sm-3 control-label">Address1:</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control customer" id="address1" name="address1" placeholder="Address1">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="inputType" class="col-sm-3 control-label">Address2:</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control customer" id="address2" name="address2" placeholder="Address2">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="inputType" class="col-sm-3 control-label">Zip:</label>
                                                    <div class="col-sm-7">
                                                        <ngx-combo-box ngx-on-select="zipselectHandler(event)" ngx-settings="zipcode" ngx-place-holder="placeHolderzipcode"></ngx-combo-box>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="inputType" class="col-sm-3 control-label">City:</label>
                                                    <div class="col-sm-7">
                                                        <ngx-combo-box ngx-on-select="cityselectHandler(event)" ngx-settings="city" ngx-place-holder="placeHoldercity"></ngx-combo-box>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="inputType" class="col-sm-3 control-label">State:</label>
                                                    <div class="col-sm-7">
                                                        <ngx-combo-box ngx-on-select="stateselectHandler(event)" ngx-settings="state" ngx-place-holder="placeHolderstate"></ngx-combo-box>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="inputType" class="col-sm-3 control-label">Island:</label>
                                                    <div class="col-sm-7">
                                                        <ngx-combo-box ngx-on-select="islandselectHandler(event)" ngx-settings="island" ngx-place-holder="placeHolderisland"></ngx-combo-box>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="inputType" class="col-sm-3 control-label">Country:</label>
                                                    <div class="col-sm-7">
                                                        <ngx-combo-box ngx-on-select="countryselectHandler(event)" ngx-settings="country" ngx-place-holder="placeHoldercountry"></ngx-combo-box>
                                                         
                                                    </div>
                                                </div>
                                            </div>
                                            <!--<p>Update City, State and Country based on new zipcode.</p>-->
                                     	</div><!--End Grid 1-->
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="inputType" class="col-sm-3 control-label">Phone1:</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control customer phone" id="phone1" name="phone1" placeholder="Phone1">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="inputType" class="col-sm-3 control-label">Phone2:</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control customer phone" id="phone2" name="phone2" placeholder="Phone2">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="inputType" class="col-sm-3 control-label">Phone3:</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control customer phone" id="phone3" name="phone3" placeholder="Phone3">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="inputType" class="col-sm-3 control-label">Fax:</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control customer phone" id="fax" name="fax" placeholder="Fax">
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="row">
                                                <div class="form-group">
                                                    <label for="inputType" class="col-sm-3 control-label">Email:</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control customer" id="email" name="email" placeholder="Email">
                                                    </div>
                                                </div>
                                            </div>
                                      </div><!--End Grid 2-->
                                      </div><!--End Row-->
                                    </div><!--End tab 1-->
                                    <div class="col-md-12 col-md-offset-0 tabs" id="tab2" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;">							
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-3 control-label">Website:</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control customer" id="website" name="website" placeholder="Website">
                                                </div>
                                            </div>
                                        </div>
                                       
                                       <div class="row">
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-3 control-label">Custom1:</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control customer" id="custom1" name="custom1" placeholder="Custom1">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-3 control-label">Custom2:</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control customer" id="custom2" name="custom2" placeholder="Custom2">
                                                </div>
                                            </div>
                                        </div> 
                                        
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-3 control-label">Custom3:</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control customer" id="custom3" name="custom3" placeholder="Custom3">
                                                </div>
                                            </div>
                                        </div>  
                                        
                                    </div>
                                    
                                    <div class="col-md-12 col-md-offset-0 tabs" id="tab3" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;">
                                    	<div class="row">
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-2 control-label">Note:</label>
                                                <div class="col-sm-10">
                                                    <textarea rows="10" id="note" name="note" class="form-control customer" placeholder="Note"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </ngx-tabs> 
                            </div>
                            <div class="col-md-12 col-md-offset-0">
                                <div class="row">
                                    <div id="_btnscd">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button type="button" id="_update" class="btn btn-primary" disabled>Save</button>
                                                <button	type="button" id="_cancel" class="btn btn-warning">Close</button>
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
                        <div style="width:100%; float:left;">
                             <p id="message"></p> 
                        </div>
                        <!--
                        <div class="taskbar">
                        	<div style="width:84%; float:left;">
                                 <p id="message"></p> 
                            </div>
                            <div style="width:15%; float:left; text-align:center; border-left: 3px solid #004a73;">
                                 <p>Edit Profile</p> 
                            </div>
                        </div>
                        -->
                   </div>          
                </ngx-window>
                <ngx-window ngx-on-close="close()" class="supplier_form" ngx-create="addialogSettings" ngx-settings="addialogSettings" style="display:none;">
                	<div>Add New Supplier</div>
                        <div id="addform">
                            <div id="addform_handler" style="overflow: hidden;">
                                <div class="col-md-12 col-md-offset-0" id="table_add" style="float:left;">
                                       <ngx-tabs ngx-width="'100%'" ngx-height="'100%'" style='float: left;' ngx-theme="thetabsadd" ngx-settings="tabsSettings" ngx-selected-item="selectedItem">
                                        <ul style="margin-left: 30px;">
                                            <li>Info</li>
                                            <li>Extra</li>
                                            <li>Note</li>
                                        </ul>
                                     <div class="col-md-12 col-md-offset-0 tabs" id="tab1" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;">								
                                        <div class="row" style="width:100%;">
                                        	<div class="col-md-6">	
                                                <input type="hidden" name="submitted" id="submitted" value="1">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="inputType" class="col-sm-3 control-label">First Name:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control addcustomer" id="add_firstname" name="add_firstname" placeholder="First Name" autofocus>
                                                        </div>
                                                        <span class="required">*</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="inputType" class="col-sm-3 control-label">Last Name:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control addcustomer" id="add_lastname" name="add_lastname" placeholder="Last Name">
                                                        </div>
                                                        <span class="required">*</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="inputType" class="col-sm-3 control-label">Company:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control addcustomer" id="add_company" name="add_company" placeholder="Company">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="inputType" class="col-sm-3 control-label">Address1:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control addcustomer" id="add_address1" name="add_address1" placeholder="Address1">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="inputType" class="col-sm-3 control-label">Address2:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control addcustomer" id="add_address2" name="add_address2" placeholder="Address2">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="inputType" class="col-sm-3 control-label">Zip:</label>
                                                        <div class="col-sm-7">
                                                        <!--
                                                            <select id="add_zip" name="add_zip" class="addcustomer" style="width:100%;">
                                                            	<option value="">Select Zip Code</option>
                                                            </select>
                                                        -->
                                                        <ngx-combo-box  ngx-on-select="addzipselectHandler(event)" ngx-settings="addzipcode" ngx-place-holder="placeHolderaddzip"></ngx-combo-box>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="inputType" class="col-sm-3 control-label">City:</label>
                                                        <div class="col-sm-7">
                                                            <!--<input type="text" class="form-control addcustomer" id="add_city" name="add_city" placeholder="City" disabled="disabled">
                                                            <select id="add_city" name="add_city" class="addcustomer" style="width:100%;">
                                                            	<option value="">Select City</option>
                                                            </select>
                                                        	-->
                                                            <ngx-combo-box ngx-settings="addcity" ngx-place-holder="placeHolderaddcity"></ngx-combo-box>
                                                        </div>
                                                    </div>
                                                </div>
                                           
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="inputType" class="col-sm-3 control-label">State:</label>
                                                        <div class="col-sm-7">
                                                            <!--<input type="text" class="form-control addcustomer" id="add_state" name="add_state" placeholder="State" disabled="disabled">
                                                            <select id="add_state" name="add_state" class="addcustomer" style="width:100%;">
                                                            	<option value="">Select State</option>
                                                            </select>
                                                            -->
                                                             <ngx-combo-box ngx-settings="addstate" ngx-place-holder="placeHolderaddstate"></ngx-combo-box>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="inputType" class="col-sm-3 control-label">Island:</label>
                                                        <div class="col-sm-7">
                                                            <!--<input type="text" class="form-control addcustomer" id="add_county" name="add_county" placeholder="Island" disabled="disabled">
                                                            <select id="add_county" name="add_county" class="addcustomer" style="width:100%;">
                                                            	<option value="">Select Island</option>
                                                            </select>
                                                            -->
                                                            <ngx-combo-box ngx-settings="addisland" ngx-place-holder="placeHolderaddisland"></ngx-combo-box>
                                                        </div>
                                                    </div>
                                                </div>
                                               
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="inputType" class="col-sm-3 control-label">Country:</label>
                                                        <div class="col-sm-7">
                                                              <!--
                                                            <input type="text" class="form-control addcustomer" id="add_country" name="add_country" placeholder="Country" disabled="disabled">
                                                          
                                                            <select id="add_country" name="add_country" class="addcustomer" style="width:100%;">
                                                            	<option value="">Select Country</option>
                                                            </select>
                                                            -->
                                                            <ngx-combo-box ngx-settings="addcountry" ngx-place-holder="placeHolderaddcountry"></ngx-combo-box>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--End Grid1-->
                                            
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="inputType" class="col-sm-3 control-label">Phone1:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control addcustomer phone" id="add_phone1" name="add_phone1" placeholder="Phone1">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="inputType" class="col-sm-3 control-label">Phone2:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control addcustomer phone" id="add_phone2" name="add_phone2" placeholder="Phone2">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="inputType" class="col-sm-3 control-label">Phone3:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control addcustomer phone" id="add_phone3" name="add_phone3" placeholder="Phone3">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="inputType" class="col-sm-3 control-label">Fax:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control addcustomer phone" id="add_fax" name="add_fax" placeholder="Fax">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="inputType" class="col-sm-3 control-label">Email:</label>
                                                        <div class="col-sm-7">
                                                            <input type="email" class="form-control addcustomer" id="add_email" name="add_email" placeholder="Email">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div><!--End Grid2-->
                                        </div><!--End Grid Row-->
                                     </div><!--End Tab1-->  
                                     <div class="col-md-12 col-md-offset-0 tabs" id="tab2" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;">							
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="inputType" class="col-sm-3 control-label">Website:</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control addcustomer" id="add_website" name="add_website" placeholder="Website">
                                                    </div>
                                                </div>
                                            </div>
                                           
                                           <div class="row">
                                                <div class="form-group">
                                                    <label for="inputType" class="col-sm-3 control-label">Custom1:</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control addcustomer" id="add_custom1" name="add_custom1" placeholder="Custom1">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="inputType" class="col-sm-3 control-label">Custom2:</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control addcustomer" id="add_custom2" name="add_custom2" placeholder="Custom2">
                                                    </div>
                                                </div>
                                            </div> 
                                            
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="inputType" class="col-sm-3 control-label">Custom3:</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control addcustomer" id="add_custom3" name="add_custom3" placeholder="Custom3">
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        </div> 
                                        
                                        <div class="col-md-12 col-md-offset-0 tabs" id="tab3" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;">
                                        	<div class="row">
                                                <div class="form-group">
                                                    <label for="inputType" class="col-sm-2 control-label">Note:</label>
                                                    <div class="col-sm-10">
                                                        <textarea rows="10" id="add_note" name="add_note" class="form-control addcustomer" placeholder="Note"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                        	
                                	</ngx-tabs>
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
                                            <div id="add_confirmation_msg" style="display:none; margin-top:10px; overflow:auto;">
                                                <div class="form-group">
                                                    <div class="col-sm-11">
                                                        <label id="addmymessage"></label>    
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
                            <!--
                            <div class="add_zip_message" style="margin-top:20px;">
                            	<p>Update City, State and Country based on new zipcode.</p>
                            </div>
                            -->
                            <!--
                            <div class="add_taskbar">
                                <div style="width:84%; float:left;">
                                     <p id="add_message"></p> 
                                </div>
                                <div style="width:15%; float:left; text-align:center; border-left: 3px solid #004a73;">
                                     <p>Add New Supplier</p> 
                                </div>
                            </div>
                            -->
                        </div>
                  </ngx-window>        
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
		min-height: 45% !important;
		min-width: 55% !important;
	}
	
	.ngx-icon-close{
		display:none;
	}
	
	.supplier_form{
		-webkit-border-radius: 15px 15px 15px 15px;
		border-radius: 15px 15px 15px 15px;
		border: 5px solid #449bca;
		height:65% !important;
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
</style>