<?php
	//angularplugins();
	//angulartheme_arctic();
	//angulartheme_metrodark();
	//angulartheme_darkblue();
	inventoryangular();
	jqxplugindatetime();
	jqxangularjs();
	jqxthemes();
?>
<script type="text/javascript">
	//Global variable
	var SiteRoot = "<?php echo base_url(); ?>";
	var supplierid = 0;
	var editform = '';
	var rowitemid = 0;
	var location_selected = "<?php echo $storeid; ?>";
	var ItemrowClick;
	var decimalprice, decimalcost, decimalquantity = 0;
	var global_item, global_itemdesc='';
	var putdecimalprice = "<?php echo $price; ?>";
	var putdecimalcost = "<?php echo $cost; ?>";
	var intervalclosemessage = 5000;
	
	//Global Cookie
	var DefaultSupplier = <?php if($DefaultSupplier){echo $DefaultSupplier;}else{echo 0;} ?>;
	var DefaultBrand = <?php if($DefaultBrand){ echo $DefaultBrand; }else{ echo 0; } ?>;
	var DefaultCategory = <?php if($DefaultCategory){ echo $DefaultCategory; }else{ echo 0; }?>;
	var DefaultSubCategory = <?php if($DefaultSubCategory){ echo $DefaultSubCategory; }else{ echo 0; } ?>;
	
	//console.log("Supplier: "+DefaultSupplier);
	//###################################//
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth();
	var yyyy = today.getFullYear();
	//##################################//
	
	//console.log(encodeURIComponent('\uD800\uDFFF'));

	$(function(){
		decimalprice = $("#decimalprice").val();
		decimalcost = $("#decimalcost").val();
		decimalquantity = $("#decimalqty").val();

		changetabtile();
		//$("#supplier").select2();
		//$("#brand").select2();
		//$("#maincat").select2();
		//$("#subcat").select2();
		/*
		$("#add_supplier").select2({
			placeholder: "Select Supplier"
		});
		$("#add_brand").select2({
			placeholder: "Select Brand"
		});
		$("#add_maincat").select2({
			placeholder: "Select Category"
		});
		$("#add_subcat").select2({
			placeholder: "Select Sub Category"
		});
		$("#maincat").on("change", function(){
			var maincatid = $("#maincat").val();
			subcat(maincatid);
		});
		$("#add_maincat").on("change", function(){
			var addmaincatid = $(this).val();
			add_subcat(addmaincatid);
		});
		*/
		//$("#_adj_location").select2();
		//$("#_location").select2();

		$('.price').keypress(function (event) {
			if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57) ) {
				if (event.keyCode !== 8 && event.keyCode !== 46 ){ //exception
					event.preventDefault();
				}
			}
			if(($(this).val().indexOf('.') != -1) && ($(this).val().substring($(this).val().indexOf('.'),$(this).val().indexOf('.').length).length>  decimalprice)){
				if (event.keyCode !== 8 && event.keyCode !== 46 ){ //exception
					event.preventDefault();
				}
			}
		});

		$('.cost').keypress(function (event) {
			if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57) ) {
				if (event.keyCode !== 8 && event.keyCode !== 46 ){ //exception
					event.preventDefault();
				}
			}
			if(($(this).val().indexOf('.') != -1) && ($(this).val().substring($(this).val().indexOf('.'),$(this).val().indexOf('.').length).length>  decimalcost)){
				if (event.keyCode !== 8 && event.keyCode !== 46 ){ //exception
					event.preventDefault();
				}
			}
		});

		$('.stock').keypress(function (event) {
			if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57) ) {
				if (event.keyCode !== 8 && event.keyCode !== 46 ){ //exception
					event.preventDefault();
				}
			}
			if(($(this).val().indexOf('.') != -1) && ($(this).val().substring($(this).val().indexOf('.'),$(this).val().indexOf('.').length).length>  decimalquantity)){
				if (event.keyCode !== 8 && event.keyCode !== 46 ){ //exception
					event.preventDefault();
				}
			}
		});

		//$.when(supplier()).then(function(){
			//$.when(brand()).then(function(){
				//$.when(maincat()).then(function(){})
			//})
		//});

		checkAnyFormFieldEdited();
		checkStockLevelFormFieldEdited();
		AddItemLevelFormFieldEdited();

		$('#cost').keyup(function() {
			updateTotal();
		});
		$('#costextra').keyup(function() {
			updateTotal();
		});
		$('#costfreight').keyup(function(){
			updateTotal();
		});
		$('#costduty').keyup(function(){
			updateTotal();
		});
		var updateTotal = function () {
		  var input1 = Number($('#cost').val());
		  var input2 = Number($('#costextra').val());
		  var input3 = Number($('#costfreight').val());
		  var input4 = Number($('#costduty').val());
		  $('#costlanded').val(parseFloat(input1 + input2 + input3 + input4).toFixed(putdecimalcost));
		};

		$("#adjustqty").click(function(){
			$("#_btnscd").hide();
			//$("#_location").select2().select2('val', stocklevel_location);
			$("#_location").val(location_selected);
			$('#tab4').block({
				message: $("#_adjqty"),
				css: {
					textAlign: 'left !important',
					padding: '10px',
					width: '65%'
				}
			});
			$.ajax({
				url: SiteRoot+'backoffice/total_adjustqty',
				type: 'post',
				data: {itemid : $("#itemunique").val(), locationid: location_selected},
				dataType:'json',
				success: function(data){
					if(data.success == true){
						$("#_qtyinstock").val(data.Quantity);
						$("#_newqty").val(data.Quantity);
					}
				},
				error: function(){
					alert("Sorry, we encoutered a technical difficulties\nPlease try again later.");
				}
			});
			$("#_qtyaddremove").focus();
		});

		$.when(main_location()).done(function(){
			$("#_main_location").val(0);
		})
	
		/*Add Item*/
		$("#addjqxWidgetDate").jqxDateTimeInput({width: '120px', height: '25px', formatString: 'd'});
		$("#addjqxWidgetTime").jqxDateTimeInput({ width: '130px', height: '25px', formatString: 'T', showCalendarButton: false});
		/*Edit Item*/
		$("#jqxWidgetDate").jqxDateTimeInput({width: '120px', height: '25px', formatString: 'd'});
		$("#jqxWidgetTime").jqxDateTimeInput({ width: '130px', height: '25px', formatString: 'T', showCalendarButton: false});

		$("#price, #cost, #costextra, #costfreight, #costduty, #_newqty").click(function(){
			$(this).select();
		});

		$("#_location").on('change',function(){
			$.ajax({
				url: SiteRoot+'backoffice/total_adjustqty',
				type: 'post',
				data: { itemid: $("#itemunique").val(), locationid : $(this).val() },
				dataType:'json',
				success: function(data){
					if(data.success == true){
						$("#_qtyinstock").val("");
						$("#_newqty").val("");
						$("#_qtyinstock").val(data.Quantity);
						$("#_newqty").val(data.Quantity);
					}
				},
				error: function(){
					alert("Sorry, we encoutered a technical difficulties\nPlease try again later.");
				}
			})
		})
	});

	function changetabtile(){
		$("#tabtitle").html("Inventory Management");
	}

	var demoApp = angular.module("demoApp", ["jqwidgets"]);
	demoApp.controller("demoController", ['$scope', '$http', '$compile', function ($scope, $http, $compile) {
		$scope.tabsSettings = {};
		$scope.tabset = {};
		$scope.selectedItem = 0;
		$scope.barcode = {};
		$scope.barcode = {
			wsearch: null
		};
		
		$scope.EditQuantityStockWhen = true;
		
		
		setTimeout(function(){
			$("#_qtyinstock").jqxNumberInput({ width: '80px', height: '30px', inputMode: 'simple', spinButtons: false, decimalDigits: decimalquantity, disabled: true});
			$("#_qtyaddremove").jqxNumberInput({ width: '80px', height: '30px', inputMode: 'simple', spinButtons: false, decimalDigits: decimalquantity});
			$("#_newqty").jqxNumberInput({ width: '80px', height: '30px', inputMode: 'simple', spinButtons: false, decimalDigits: decimalquantity});
			
			$("#add_qtyinstock").jqxNumberInput({ width: '80px', height: '30px', inputMode: 'simple', spinButtons: false, disabled: true, decimalDigits: decimalquantity});
			$("#add_qtyaddremove").jqxNumberInput({ width: '80px', height: '30px', inputMode: 'simple', spinButtons: false, decimalDigits: decimalquantity});
			$("#add_newqty").jqxNumberInput({ width: '80px', height: '30px', inputMode: 'simple', spinButtons: false, decimalDigits: decimalquantity});
		},1000);
		
		

		$scope.coslandedDisabled = true; //Applied to Cost and Prices.
		$scope.AddInventoryDisabled = true; //Aplied to Cost and Prices.

		var ID, Item, Part, Description, Supplier, SupplierPart, Brand, Category, Cost, Price, Quantity, grid;
		//$scope.dateTimeInputSettings = { width: '110px', height: '25px', formatString: 'd' };
		//$scope.TimeInputSettings = {width: '110px', height: '25px', formatString: 'h:mm tt'};
		//$scope.showCalendarButton = false;
		
		//Supplier	
		var source = {
			datatype: "json",
			datafields: [
				{ name: 'Unique' },
				{ name: 'Supplier' }
			],
			localdata: {},
			async: false
		};
		$scope.comboboxSettingsSupplier = {source: source, searchMode: 'contains', autoComplete: true, displayMember: "Supplier", valueMember: "Unique", width: 220, height: 25 };
		$("#supplier").jqxComboBox({placeHolder: "Select Supplier" });
		
		$scope.comboboxSettingsAddSupplier = {source: source, searchMode: 'contains', autoComplete: true, displayMember: "Supplier", valueMember: "Unique", width: 220, height: 25 };
		$("#add_supplier").jqxComboBox({placeHolder: "Select Supplier" });
		
		
		
		var Locsource = {
			datatype: "json",
			datafields: [
				{ name: 'Unique' },
				{ name: 'description' }
			],
			localdata: {},
			async: false
		};
		$scope.comboBoxADJLocationSettings = {source: Locsource, searchMode: 'contains', autoComplete: true, displayMember: "description", valueMember: "Unique", width: 220, height: 25 };
		$("#_adj_location").jqxComboBox({placeHolder: "Select Location" });
		
		
		$scope.comboBoxADJQTYLocationSettings = {source: Locsource, searchMode: 'contains', autoComplete: true, displayMember: "description", valueMember: "Unique", width: 150, height: 25 };
		$("#_location").jqxComboBox({placeHolder: "Select Location" });
		
		$scope.comboBoxAddADJLocationSettings = {source: Locsource, searchMode: 'contains', autoComplete: true, displayMember: "description", valueMember: "Unique", width: 150, height: 25 };
		$("#add_location").jqxComboBox({placeHolder: "Select Location" });
		
		
		//Brand
		var source = {
			datatype: "json",
			datafields: [
				{ name: 'Unique'},
				{ name: 'Name'}
			],
			localdata: {},
			async: false
		};
		$scope.comboboxSettingsBrand = {source: source, searchMode: 'contains', autoComplete: true, displayMember: "Name", valueMember: "Unique", width: 220, height: 25 };
		$("#brand").jqxComboBox({placeHolder: "Select Brand" });
		
		
		$scope.comboboxSettingsAddBrand = {source: source, searchMode: 'contains', autoComplete: true, displayMember: "Name", valueMember: "Unique", width: 220, height: 25 };
		$("#add_brand").jqxComboBox({placeHolder: "Select Brand" });
		
		//Category
		var source = {
			datatype: "json",
			datafields: [
				{name: 'Unique'},
				{name: 'MainName'}
			],
			localdata: {},
			async: false
		};
		$scope.comboboxSettingsCategory = {source: source, searchMode: 'contains', autoComplete: true, displayMember: "MainName", valueMember: "Unique", width: 220, height: 25 };
		$("#maincat").jqxComboBox({placeHolder: "Select Category" });
		
		$scope.comboboxSettingsAddCategory = {source: source, searchMode: 'contains', autoComplete: true, displayMember: "MainName", valueMember: "Unique", width: 220, height: 25 };
		$("#add_maincat").jqxComboBox({placeHolder: "Select Category" });
		
		//Sub Category
		var source = {
			datatype: "json",
			datafields: [
				{name: 'Unique'},
				{name: 'Name'}
			],
			localdata: {},
			async: false
		};
		
		$scope.comboboxSettingsSubCat = {source: source, searchMode: 'contains', autoComplete: true, displayMember: "Name", valueMember: "Unique", width: 220, height: 25 };
		$("#subcat").jqxComboBox({placeHolder: "Select Sub Category" });
		
		$scope.comboboxSettingsAddSubCat = {source: source, searchMode: 'contains', autoComplete: true, displayMember: "Name", valueMember: "Unique", width: 220, height: 25 };
		$("#add_subcat").jqxComboBox({placeHolder: "Select Sub Category" });
		
		
		var load_barcode = function(ItemUnique){
			var postdata="itemid="+ItemUnique;
			$http({
				url: SiteRoot+'backoffice/load_barcode',
				method: "POST",
				data: postdata,
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			 })
			 .success(function(data){
				$scope.barcodelist = {};
				$scope.barcodelist = data;
			 })
			 .error(function(){
				alert("Sorry, we encountered a technical difficulties\nPlease try again later.");	
			 })
		};
		
		var supplier = function(){
			$http({
				method: 'get',
				url: SiteRoot+'backoffice/edit_supplier'
			}).success(function(data){
				var source = {
					datatype: "json",
					datafields: [
						{ name: 'Unique' },
						{ name: 'Supplier' }
					],
					localdata: data,
					async: false
				};
				$scope.comboboxSettingsSupplier = {source: source, displayMember: "Supplier", valueMember: "Unique", width: 220, height: 30 };
				$scope.selectHandlerSupplier = function (event) {
					if (event.args) {
						var item = event.args.item;
						if (item) {
							$scope.log = "Label: " + item.label + ", Value: " + item.value;
						}
					}
				};
				
				$scope.comboboxSettingsAddSupplier = {source: source, displayMember: "Supplier", valueMember: "Unique", width: 220, height: 30 };
				$scope.selectHandlerAddSupplier = function (event) {
					if (event.args) {
						var item = event.args.item;
						if (item) {
							$scope.log = "Label: " + item.label + ", Value: " + item.value;
						}
					}
				};
			})
		}
		
		var brand = function(){
			$http({
				method: 'get',
				url: SiteRoot+'backoffice/edit_brand'
			}).success(function(data){
				var source = {
					datatype: "json",
					datafields: [
						{ name: 'Unique' },
						{ name: 'Brand' }
					],
					localdata: data,
					async: false
				};
				$scope.comboboxSettingsBrand = {source: source, displayMember: "Brand", valueMember: "Unique", width: 220, height: 30 };
				$scope.selectHandlerBrand = function (event) {
					if (event.args) {
						var item = event.args.item;
						if (item) {
							$scope.log = "Label: " + item.label + ", Value: " + item.value;
						}
					}
				};
				
				$scope.comboboxSettingsAddBrand = {source: source, displayMember: "Brand", valueMember: "Unique", width: 220, height: 30 };
				$scope.selectHandlerAddBrand = function (event) {
					if (event.args) {
						var item = event.args.item;
						if (item) {
							$scope.log = "Label: " + item.label + ", Value: " + item.value;
						}
					}
				};		
			})
		}
		
		var category = function(){
			$http({
				method: 'get',
				url: SiteRoot+'backoffice/maincat'
			}).success(function(data){
				var source = {
					datatype: "json",
					datafields: [
						{ name: 'Unique' },
						{ name: 'MainName' }
					],
					localdata: data,
					async: false
				};
				$scope.comboboxSettingsCategory = {source: source, displayMember: "MainName", valueMember: "Unique", width: 220, height: 30 };
				$scope.selectHandlerCategory = function (event) {
					if (event.args) {
						var item = event.args.item;
						if (item) {
							$scope.log = "Label: " + item.label + ", Value: " + item.value;
						}
					}
				};
				
				$scope.comboboxSettingsAddCategory = {source: source, displayMember: "MainName", valueMember: "Unique", width: 220, height: 30 };
				$scope.selectHandlerAddCategory = function (event) {
					if (event.args) {
						var item = event.args.item;
						if (item) {
							$scope.log = "Label: " + item.label + ", Value: " + item.value;
						}
					}
				};		
			})
		}
		
		
		var subcat = function(catid){
			var defersubcat = $.Deferred();
			var postdata="maincatid="+catid;
			$http({
				method: 'post',
				url: SiteRoot+'backoffice/subcat',
				data: postdata,
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).success(function(data){
				var source = {
					datatype: "json",
					datafields: [
						{ name: 'Unique' },
						{ name: 'Name' }
					],
					localdata: data,
					async: false
				};
				$scope.comboboxSettingsSubCat = {source: source, displayMember: "Name", valueMember: "Unique", width: 220, height: 30 };
				defersubcat.resolve();
			})
			return defersubcat.promise();
		}
		
		var add_subcat = function(catid){
			var deferaddsubcat = $.Deferred();
			var postdata="maincatid="+catid;
			$http({
				method: 'post',
				url: SiteRoot+'backoffice/subcat',
				data: postdata,
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).success(function(data){
				var source = {
					datatype: "json",
					datafields: [
						{ name: 'Unique' },
						{ name: 'Name' }
					],
					localdata: data,
					async: false
				};
				$scope.comboboxSettingsAddSubCat = {source: source, displayMember: "Name", valueMember: "Unique", width: 220, height: 30 };
				deferaddsubcat.resolve();
			})
			return deferaddsubcat.promise();
		}
		
		var adj_load_location = function(){
			var deferadjlocation = $.Deferred();
			$http({
				method: 'post',
				url: SiteRoot+'backoffice/load_stores',
			}).success(function(data){
				console.log(data);
				var source = {
					datatype: "json",
					datafields: [
						{ name: 'Unique' },
						{ name: 'description' }
					],
					localdata: data,
					async: false
				};
				$scope.comboBoxADJLocationSettings = {source: source, displayMember: "description", valueMember: "Unique", width: 220, height: 30 };
				deferadjlocation.resolve();
			})
			return deferadjlocation.promise();
		}
		
		var adjqty_load_location = function(){
			var deferadjqtylocation = $.Deferred();
			$http({
				method: 'post',
				url: SiteRoot+'backoffice/load_stores_stock',
			}).success(function(data){
				console.log(data);
				var source = {
					datatype: "json",
					datafields: [
						{ name: 'Unique' },
						{ name: 'description' }
					],
					localdata: data,
					async: false
				};
				$scope.comboBoxADJQTYLocationSettings = {source: source, displayMember: "description", valueMember: "Unique", width: 130, height: 30 };
				$scope.comboBoxAddADJLocationSettings = {source: source, displayMember: "description", valueMember: "Unique", width: 130, height: 30 };
				deferadjqtylocation.resolve();
			})
			return deferadjqtylocation.promise();
		}
		
	
		/************************/
			//Load Functions//
			supplier();
			brand();
			category();
			adj_load_location();
			adjqty_load_location();
		/***********************/
		

		$scope.thetabs = 'darkblue';
		$scope.thetabsadd = 'darkblue';
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
					{ name: 'Item', type: 'string'},
					{ name: 'Part', type: 'string' },
					{ name: 'Description', type: 'string'},
					{ name: 'Size', type: 'string'},
					{ name: 'Color', type: 'string'},
					{ name: 'Other', type: 'string'},
					{ name: 'SupplierId', type: 'int'},
					{ name: 'Supplier', type: 'string'},
					{ name: 'SupplierPart', type: 'string'},
					{ name: 'BrandId', type: 'int'},
					{ name: 'Brand', type: 'string'},
					{ name: 'CatMainId', type: 'int'},
					{ name: 'Category', type: 'string'},
					{ name: 'SubCategory', type: 'int'},
					{ name: 'Cost', type: 'string'},
					{ name: 'CostExtra', type: 'string'},
					{ name: 'CostFreight', type: 'string'},
					{ name: 'CostDuty', type: 'string'},
					{ name: 'CostLanded', type: 'string'},
					{ name: 'ListPrice', type: 'string'},
					{ name: 'price1', type: 'string'},
					{ name: 'price2', type: 'string'},
					{ name: 'price3', type: 'string'},
					{ name: 'price4', type: 'string'},
					{ name: 'price5', type: 'string'},
					{ name: 'Quantity', type: 'string'}
				],
				url: SiteRoot+"backoffice/load_inventory/"+location_selected
			},
			columnsResize: true,
			width: "99.7%",
			theme: 'arctic',
			sortable: true,
			pageable: true,
			pageSize: 15,
			pagerMode: 'default',
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
					//position: { left: table.offsetLeft + 50, top: table.offsetTop + 50 },
					width: "100%", height: "100%",
					autoOpen: false,
					showCloseButton: false,
					theme: 'darkblue',
					isModal: 'true',
					keyboardCloseKey: 'none',
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
					showCloseButton: false,
					theme: 'darkblue',
					isModal: 'true',
					keyboardCloseKey: 'none',

				}
			},
			columns: [
				{ text: 'ID', dataField: 'Unique', width: "8%"},
				{ text: 'Item Number', dataField: 'Item', width: "14%"},
				{ text: 'Part Number', dataField: 'Part', hidden: true },
				{ text: 'Description', dataField: 'Description', width: '24%' },
				{ text: 'Size', dataField: 'Size', width: '7%' },
				{ text: 'Color', dataField: 'Color', width: '7%' },
				{ text: 'Other', dataField: 'Other', hidden: true },
				{ text: 'SupplierID', dataField: 'SupplierId', hidden: true}, //Hidden column
				{ text: 'Supplier', dataField: 'Supplier', width: '11%'},
				{ text: 'Supplier Part', dataField: 'SupplierPart', hidden: true },
				{ text: 'BrandID', dataField: 'BrandId', hidden: true},
				{ text: 'Brand', dataField: 'Brand', hidden: true },
				{ text: 'CatMainId', dataField: 'CatMainId', hidden: true},
				{ text: 'Category', dataField: 'Category', width: '11%'},
				{ text: 'SubCat', dataField: 'SubCategory', hidden: true},
				{ text: 'Cost', dataField: 'Cost', cellsalign: 'right', hidden: true},
				{ text: 'CostExtra', dataField: 'CostExtra', cellsalign: 'right', hidden: true},
				{ text: 'CostFreight', dataField: 'CostFreight', cellsalign: 'right', hidden: true},
				{ text: 'CostDuty', dataField: 'CostDuty', cellsalign: 'right', hidden: true},
				{ text: 'Cost', dataField: 'CostLanded', cellsalign: 'right', width: "8%", hidden: true},
				{ text: 'Price', dataField: 'price1', width: '9%', align: 'right', cellsalign: 'right'}, //Modified 02/01/2016 before ListPrice
				//{ text: 'SalePrice', dataField: 'price1', hidden: true},
				{ text: 'Price2', dataField: 'price2', width: '8%', cellsalign: 'right', hidden: true},
				{ text: 'Price3', dataField: 'price3', width: '8%', cellsalign: 'right', hidden: true},
				{ text: 'Price4', dataField: 'price4', width: '8%', cellsalign: 'right', hidden: true},
				{ text: 'Price5', dataField: 'price5', width: '8%', cellsalign: 'right', hidden: true},
				{ text: 'Quantity', dataField: 'Quantity', width: '9%', align: 'right', cellsalign: 'right'}
			]
		}

		/*
		$http({
			method: 'get',
			url: 'http://192.168.0.110:1337/inventory-data'
		}).success(function(data){
			console.log("Inventory Data "+data);

			$scope.gridSettings = {
				source: {
					dataType: "json", 
					localdata: data.rows
				}
			}
		})
		*/
		
		$("#add_supplier").on('keydown', function(event){
			if(event.keyCode == 8 || event.keyCode == 46){
				$("#add_supplier").jqxComboBox('clearSelection');
				$("#add_save").prop('disabled', false);
			}
		})
		
		$("#add_brand").on('keydown', function(event){
			if(event.keyCode == 8 || event.keyCode == 46){
				$("#add_brand").jqxComboBox('clearSelection');
				$("#add_save").prop('disabled', false);
			}
		})
		
		$("#add_maincat").on('keydown', function(event){
			if(event.keyCode == 8 || event.keyCode == 46){
				$("#add_maincat").jqxComboBox('clearSelection');
				$("#add_save").prop('disabled', false);
			}
		})
		
		$("#add_subcat").on('keydown', function(event){
			if(event.keyCode == 8 || event.keyCode == 46){
				$("#add_subcat").jqxComboBox('clearSelection');
				$("#add_save").prop('disabled', false);
			}
		})
		
		$("#supplier").on('keydown', function(event){
			if(event.keyCode == 8 || event.keyCode == 46){
				$("#supplier").jqxComboBox('clearSelection');
				$("#_update").prop('disabled', false);
			}
		})
		
		$("#brand").on('keydown', function(event){
			if(event.keyCode == 8 || event.keyCode == 46){
				$("#brand").jqxComboBox('clearSelection');
				$("#_update").prop('disabled', false);
			}
		})
		
		$("#maincat").on('keydown', function(event){
			if(event.keyCode == 8 || event.keyCode == 46){
				$("#maincat").jqxComboBox('clearSelection');
				$("#subcat").jqxComboBox('clearSelection');
				$("#subcat").jqxComboBox('clear'); 
				$("#_update").prop('disabled', false);
			}
		})
		
		$("#subcat").on('keydown', function(event){
			if(event.keyCode == 8 || event.keyCode == 46){
				$("#subcat").jqxComboBox('clearSelection');
				$("#_update").prop('disabled', false);
			}
		})

		/* Row DoubleClick */
		$scope.rowDoubleClick = function (event) {
			var args = event.args;
			var index = args.index;
			var row = args.row;
			// update the widgets inside ngxWindow.
			editRow = index;
			reset_form();
			//$scope.gridSettings.disabled = true;
			dialog.setTitle("Edit ID: " + row.Unique + " |" + row.Item+ " |"+row.Description);
			$("#itemunique").val(row.Unique);
			$("#itemnumber").val(row.Item);
			$("#partnumber").val(row.Part);
			$("#description").val(row.Description);
			$("#supplierpart").val(row.SupplierPart);
			$("#price").val(parseFloat(row.ListPrice).toFixed(putdecimalprice));
			$("#saleprice").val(parseFloat(row.price1).toFixed(putdecimalprice));
			$("#listprice").val(parseFloat(row.ListPrice).toFixed(putdecimalprice));
			$("#price1").val(parseFloat(row.price1).toFixed(putdecimalprice));
			$("#price2").val(parseFloat(row.price2).toFixed(putdecimalprice));
			$("#price3").val(parseFloat(row.price3).toFixed(putdecimalprice));
			$("#price4").val(parseFloat(row.price4).toFixed(putdecimalprice));
			$("#price5").val(parseFloat(row.price5).toFixed(putdecimalprice));
			$("#cost").val(row.Cost);
			$("#costextra").val(row.CostExtra);
			$("#costfreight").val(row.CostFreight);
			$("#costduty").val(row.CostDuty);
			$("#costlanded").val(row.CostLanded);
			$("#quantity").val(row.Quantity);
			
			if(row.SupplierId){
				$("#supplier").val(row.SupplierId);
			}else{
				
			}
			if(row.BrandId){
				$("#brand").val(row.BrandId);
			}else{
			
			}
			if(row.CatMainId){
				$("#maincat").val(row.CatMainId);
			}else{
				
			}
			
			/*Stock Level*/ 
			$http({
				method: 'get',
				url: SiteRoot+"backoffice/load_item_stock_line/"+row.Unique+"/"+location_selected	
			}).success(function(data){
				//var grid = {};
				$scope.gridStockSettings = {
					disabled: false,
					created: function(args){
						grid = args.instance;
					},
					source:  {
						//url: SiteRoot+"backoffice/load_item_stock_line/"+row.Unique+"/"+location_selected,
						dataType: "json",
						dataFields: [
							{ name: 'Unique', type : 'int' },
							{ name: 'TransactionDate', type: 'string'},
							{ name: 'Type', type: 'string' },
							{ name: 'Location', type: 'string'},
							{ name: 'Quantity', type: 'string'},
							{ name: 'Total', type: 'string'},
							{ name: 'Comment', type: 'string'}
						],
						localdata: data,
						sortcolumn: 'TransactionDate',
						sortdirection: 'desc'
					},
					columnsResize: true,
					width: 740,
					height: 290,
					theme: 'arctic',
					sortable: true,
					altRows: true,
					rowDetails: true,
					initRowDetails: function (id, row, element, rowinfo) {
						var tabsdiv = null;
						var information = null;
						var Comment = null;
						rowinfo.detailsHeight = 120;
						element.append($("<div style='margin: 10px;'><ul style='margin-left: 30px;'><li>Comments</li></ul><div class='notes'></div></div>"));
						tabsdiv = $(element.children()[0]);
						if (tabsdiv != null) {
							notes = tabsdiv.find('.notes');
							var notescontainer = $('<div style="white-space: normal; margin: 5px;"><span>' + row.Comment + '</span></div>');
							$(notes).append(notescontainer);
							var tabs = new jqxTabs(tabsdiv, {width: "94%", height: 100});
						}
					},
					columns: [
						{ text: 'ID', dataField: 'Unique', hidden: true},
						{ text: 'Date', dataField: 'TransactionDate', width: "20%"},
						{ text: 'Type', dataField: 'Type', width: '19%' },
						{ text: 'Location', dataField: 'Location', width: '19%' },
						{ text: 'Quantity', dataField: 'Quantity', width: '19%', align: 'center', cellsAlign: 'center' },
						{ text: 'Total', dataField: 'Total', width: '19%', align: 'center', cellsAlign: 'center' }
					]
				};
			})
			/*End Stock Level*/
			$.when(load_tax()).then(function(){
				$.ajax({
					url: SiteRoot+'backoffice/gettaxval',
					type: 'post',
					data: {itemid : $("#itemunique").val()},
					dataType:"json",
					success: function(data){
						$.each(data, function(index, value){
							if(value.Status == 1){
								$("#"+value.Tax).jqxCheckBox({ width: 120, height: 25, checked: true});
							}else{
								$("#"+value.Tax).jqxCheckBox({ width: 120, height: 25, checked: false});
							}
						})
					},
					error: function(){
						alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
					}
				});
				
				
				$("#_adj_location").val(location_selected);
				
				
				$('#supplier').on('change', function (event){
					if (args) {                          
						var index = args.index;
						$("#_update").prop("disabled", false);
					}
				});
				
				$('#brand').on('change', function (event){
					if (args) {                          
						var index = args.index;
						$("#_update").prop("disabled", false);
					}
				}); 
				
				$('#maincat').on('change', function (event){
					var args = event.args;
					if (args) {                          
						var index = args.index;
						var item = args.item;
						var label = item.label;
						var value = item.value;	
						subcat(value);
						$("#_update").prop("disabled", false);
					}
				}); 
				
				$('#subcat').on('change', function (event){
					if (args) {                          
						var index = args.index;
						//var item = args.item;
						//var label = item.label;
						//var value = item.value;
						$("#_update").prop("disabled", false);
					}
				});	
				
				if(row.CatMainId){
					$.when(subcat(row.CatMainId)).done(function(){
						setTimeout(function(){
							$("#subcat").val(row.SubCategory);
							$("#_update").prop("disabled", true);
						},100)
					});
					dialog.open();	
				}else{
					$("#_update").prop("disabled", true);
					dialog.open();
				}
				
			});

			//-->Load Barcode list
			load_barcode(row.Unique);

			global_item = row.Item;
			global_itemdesc = row.Description;

			$scope.tabset = {};
			$scope.tabclick = function (event) {
				var eventArguments = event.args;
				var clickedTabIndex = eventArguments.item;
				//$("#_btnscd").show();
				//$("#tab3").unblock();
				$("#_qtyaddremove").val("");
				$("#_qtycomment").val("");
			}
		};
		//* End Row DoubleClick *//

		//-->Click Barcode
		$scope.setSelected = function(BarcodeUnique, Barcode) {
			 $scope.barcode = {};
			 if ($scope.lastSelected) {
			 	$scope.lastSelected.selected = '';
		     }
		     this.selected = 'selected';
		     $scope.lastSelected = this;
			 $scope.barcode = {
				 wsearch : Barcode
			 };
			 $scope.BarcodeUnique = BarcodeUnique;
		};
		//-->End Click Barcode

		$("#_addnew").click(function(){
			//$.when(add_load_stores()).then(function(){
			$("#add_location").val(location_selected);
			$.when(add_tax()).done(function(){
				$scope.$apply(function(){
					addialog.open();
					$scope.gridSettings.disabled = true;
					$scope.tabsSettings = {};
				})
			})
			//})
			
			$("#add_supplier").on('select', function (event) {
				if (event.args) {
					var item = event.args.item;
					if (item) {
						$(".add_sel_supplier_message").text('');
						$("#add_save").prop("disabled", false);
					}
				}
            });
			 
			$("#add_brand").on('select', function (event) {
				if (event.args) {
					var item = event.args.item;
					if (item) {
						$(".add_sel_brand_message").text('');
						$("#add_save").prop("disabled", false);
					}
				}	
			})
			 
			$("#add_maincat").on('select', function (event) {
				if (event.args) {
					var item = event.args.item;
					if (item) {
						$(".add_sel_category_message").text('');
						$("#add_save").prop("disabled", false);
						add_subcat(item.value);
					}
				}	
			})
			 
			$("#add_subcat").on('select', function (event) {
				if (event.args) {
					var item = event.args.item;
					if (item) {
						$(".add_sel_subcat_message").text('');
						$("#add_save").prop("disabled", false);
					}
				}	
			})
			reset_add_new_item_form();
			
		});

		$("#add_price, #add_cost, #add_costextra, #add_costfreight, #add_costduty, #add_qtyaddremove, #add_newqty").click(function(){
			$(this).select();
		});

		$('#add_price').keyup(function(e) {
			var txtVal = $(this).val();
			$('#add_listprice').attr("value", txtVal);
		});

		$("#add_saleprice").blur(function(){
			$("#add_price1").val = $(this).val();
		})

		$("#add_save").click(function(){
			var process1 = false;
			var SelSupplier = $("#add_supplier").jqxComboBox('getSelectedItem');
			var SelSupplierText = $("#add_supplier").val();
			if(SelSupplier){
				$(".add_sel_supplier_message").text('');
				process1 = true;
			}else{
				if(SelSupplierText == ''){
					process1 = true;
					$(".add_sel_supplier_message").text('');
				}else{
					$(".add_sel_supplier_message").text("Supplier does not exist.");
					process1 = false;
				}
			}
			
			var process2 = false;
			var SelBrand = $("#add_brand").jqxComboBox('getSelectedItem');
			var SelBrandText = $("#add_brand").val();
			if(SelBrand){
				$(".add_sel_brand_message").text('');
				process2 = true;
			}else{
				if(SelBrandText == ''){
					process2 = true;
					$(".add_sel_brand_message").text('');
				}else{
					$(".add_sel_brand_message").text("Brand does not exist");
					process2 = false;
				}
			}
			
			var process3 = false;
			var SelCategory = $("#add_maincat").jqxComboBox('getSelectedItem');
			var SelCategoryText = $("#add_maincat").val();
			if(SelCategory){
				$(".add_sel_category_message").text('');
				process3 = true;
			}else{
				if(SelCategoryText == ''){
					$(".add_sel_category_message").text('');
					process3 = true;
				}else{
					$(".add_sel_category_message").text("Category does not exist");
					process3 = false;
				}
			}
			
			var process4 = false;
			var SelSubCat = $("#add_subcat").jqxComboBox('getSelectedItem');
			var SelSubCatText = $("#add_subcat").val();
			if(SelSubCat){
				$(".add_sel_subcat_message").text('');
				process4 = true;
			}else{
				if(SelSubCatText == ''){
					$(".add_sel_subcat_message").text('');
					process4 = true;
				}else{
					$(".add_sel_subcat_message").text("Sub Category does not exist");
					process4 = false;
				}
			}
			
			var process5 = false;
			var ItemNumber = $("#add_itemnumber").val();
			if(ItemNumber){
				$(".add_itemnumber_message").text('*');
				process5 = true;	
			}else{
				$(".add_itemnumber_message").text("Item Number is required field.");
				process5 = false;
			}
			
			var process6 = false;
			var Barcode = $("#add_partnumber").val();
			if(Barcode){
				$(".add_barcode_message").text('*');
				process6 = true;
			}else{
				$(".add_barcode_message").text("Barcode is required field.");
				process6 = false
			}
			
			if(process1 == true && process2 == true && process3 == true && process4 == true && process5 == true && process6 == true){			
				$.when(add_save_new_item()).then(function(){
					reset_add_new_item_form();
					$("#addtab1, #addtab2, #addtab3, #addtab4, #addtab5, #addtab6").block({message: null})
					$scope.gridSettings = {
						disabled: true,
						source:  {
							dataType: "json",
							dataFields: [
								{ name: 'Unique', type : 'int' },
								{ name: 'Item', type: 'string'},
								{ name: 'Part', type: 'string' },
								{ name: 'Description', type: 'string'},
								{ name: 'Size', type: 'string'},
								{ name: 'Color', type: 'string'},
								{ name: 'Other', type: 'string'},
								{ name: 'SupplierId', type: 'int'},
								{ name: 'Supplier', type: 'string'},
								{ name: 'SupplierPart', type: 'string'},
								{ name: 'BrandId', type: 'int'},
								{ name: 'Brand', type: 'string'},
								{ name: 'CatMainId', type: 'int'},
								{ name: 'Category', type: 'string'},
								{ name: 'SubCategory', type: 'int'},
								{ name: 'Cost', type: 'string'},
								{ name: 'CostExtra', type: 'string'},
								{ name: 'CostFreight', type: 'string'},
								{ name: 'CostDuty', type: 'string'},
								{ name: 'CostLanded', type: 'string'},
								{ name: 'ListPrice', type: 'string'},
								{ name: 'price1', type: 'string'},
								{ name: 'price2', type: 'string'},
								{ name: 'price3', type: 'string'},
								{ name: 'price4', type: 'string'},
								{ name: 'price5', type: 'string'},
								{ name: 'Quantity', type: 'string'}
							],
							id: 'Unique',
							url: SiteRoot+"backoffice/load_inventory/"+location_selected
						},
						created: function (args) {
						   var instance = args.instance;
						   instance.updateBoundData();
						}
					};
					$.when(add_tax()).done(function(){})
				});
				$scope.$apply(function(){
					$scope.tabsSettings = {};
				})
			}else{
				
			}
		});


		$("#add_aftersave_yes").click(function(){
			show_hide();
			$("#addtab1, #addtab2, #addtab3, #addtab4, #addtab5, #addtab6").unblock();
			$("#add_confirmation_after_save").hide();
			$("#addsavedmymessage").html("");
			$("#add_save").attr("disabled", true);
			$("#add_itemnumber").focus();
			$scope.$apply(function(){
				$scope.tabsSettings = {
					selectedItem: 0
				}
			})
		});

		$('#add_cost').keyup(function() {
			saveCostTotal();
		});
		$('#add_costextra').keyup(function() {
			saveCostTotal();
		});
		$('#add_costfreight').keyup(function(){
			saveCostTotal();
		});
		$('#add_costduty').keyup(function(){
			saveCostTotal();
		});
		var saveCostTotal = function () {
			var input1 = Number($('#add_cost').val());
			var input2 = Number($('#add_costextra').val());
			var input3 = Number($('#add_costfreight').val());
			var input4 = Number($('#add_costduty').val());

			$('#add_costlanded').val(parseFloat(input1 + input2 + input3 + input4).toFixed(putdecimalcost));
		};

		$("#add_itemnumber").on('keyup', function() {
			$("#add_partnumber").val($(this).val());
			$("#add_supplierpart").val($(this).val());
	    });

		$("#add_qtyaddremove").keyup(function(event){
			var sum=0;
			var addup = $("#add_qtyinstock").val();
			sum = Number($(this).val());
			$("#add_newqty").val(Number(sum)+Number(addup));
			//$('#add_qtyaddremove').val().replace(/[A-Za-z$-]/g, "");
		});

		$("#add_newqty").keyup(function(){
			var sum=0;
			var addup = $("#_qtyinstock").val();
			sum = Number($(this).val());
			$("#add_qtyaddremove").val(Number(sum)-Number(addup));
		});


		$("#add_yes").click(function(){
			var process1 = false;
			var SelSupplier = $("#add_supplier").jqxComboBox('getSelectedItem');
			var SelSupplierText = $("#add_supplier").val();
			if(SelSupplier){
				$(".add_sel_supplier_message").text('');
				process1 = true;
			}else{
				if(SelSupplierText == ''){
					process1 = true;
					$(".add_sel_supplier_message").text('');
				}else{
					$(".add_sel_supplier_message").text("Supplier does not exis.");
					process1 = false;
				}
			}
			
			var process2 = false;
			var SelBrand = $("#add_brand").jqxComboBox('getSelectedItem');
			var SelBrandText = $("#add_brand").val();
			if(SelBrand){
				$(".add_sel_brand_message").text('');
				process2 = true;
			}else{
				if(SelBrandText == ''){
					process2 = true;
					$(".add_sel_brand_message").text('');
				}else{
					$(".add_sel_brand_message").text("Brand does not exist");
					process2 = false;
				}
			}
			
			var process3 = false;
			var SelCategory = $("#add_maincat").jqxComboBox('getSelectedItem');
			var SelCategoryText = $("#add_maincat").val();
			if(SelCategory){
				$(".add_sel_category_message").text('');
				process3 = true;
			}else{
				if(SelCategoryText == ''){
					$(".add_sel_category_message").text('');
					process3 = true;
				}else{
					$(".add_sel_category_message").text("Category does not exist");
					process3 = false;
				}
			}
			
			var process4 = false;
			var SelSubCat = $("#add_subcat").jqxComboBox('getSelectedItem');
			var SelSubCatText = $("#add_subcat").val();
			if(SelSubCat){
				$(".add_sel_subcat_message").text('');
				process4 = true;
			}else{
				if(SelSubCatText == ''){
					$(".add_sel_subcat_message").text('');
					process4 = true;
				}else{
					$(".add_sel_subcat_message").text("Sub Category does not exist");
					process4 = false;
				}
			}
			
			var process5 = false;
			var ItemNumber = $("#add_itemnumber").val();
			if(ItemNumber){
				$(".add_itemnumber_message").text('*');
				process5 = true;	
			}else{
				$(".add_itemnumber_message").text("Item Number is required field.");
				process5 = false;
			}
			
			var process6 = false;
			var Barcode = $("#add_partnumber").val();
			if(Barcode){
				$(".add_barcode_message").text('*');
				process6 = true;
			}else{
				$(".add_barcode_message").text("Barcode is required field.");
				process6 = false
			}
			
			if(process1 == true && process2 == true && process3 == true && process4 == true && process5 == true && process6 == true){			
				$.when(add_save_new_item()).then(function(){
					reset_add_new_item_form();
					$("#addtab1, #addtab2, #addtab3, #addtab4, #addtab5, #addtab6").block({message: null})
					$scope.gridSettings = {
						disabled: true,
						source:  {
							dataType: "json",
							dataFields: [
								{ name: 'Unique', type : 'int' },
								{ name: 'Item', type: 'string'},
								{ name: 'Part', type: 'string' },
								{ name: 'Description', type: 'string'},
								{ name: 'Size', type: 'string'},
								{ name: 'Color', type: 'string'},
								{ name: 'Other', type: 'string'},
								{ name: 'SupplierId', type: 'int'},
								{ name: 'Supplier', type: 'string'},
								{ name: 'SupplierPart', type: 'string'},
								{ name: 'BrandId', type: 'int'},
								{ name: 'Brand', type: 'string'},
								{ name: 'CatMainId', type: 'int'},
								{ name: 'Category', type: 'string'},
								{ name: 'SubCategory', type: 'int'},
								{ name: 'Cost', type: 'string'},
								{ name: 'CostExtra', type: 'string'},
								{ name: 'CostFreight', type: 'string'},
								{ name: 'CostDuty', type: 'string'},
								{ name: 'CostLanded', type: 'string'},
								{ name: 'ListPrice', type: 'string'},
								{ name: 'price1', type: 'string'},
								{ name: 'price2', type: 'string'},
								{ name: 'price3', type: 'string'},
								{ name: 'price4', type: 'string'},
								{ name: 'price5', type: 'string'},
								{ name: 'Quantity', type: 'string'}
							],
							id: 'Unique',
							url: SiteRoot+"backoffice/load_inventory/"+location_selected
						},
						created: function (args) {
						   var instance = args.instance;
						   instance.updateBoundData();
						}
					};
					$.when(add_tax()).done(function(){})
				});
				$scope.$apply(function(){
					$scope.tabsSettings = {};
				})
			}else{
				
			}
		});

		$("#add_no").click(function(){
			reset_add_new_item_form();
			$("#add_msg").hide();
			$("#add_btnscd").show();
			$("#addtab1, #addtab2, #addtab3, #addtab4, #addtab5, #addtab6").unblock();
			$("#add_supplier").jqxComboBox('clearSelection');
			$("#add_brand").jqxComboBox('clearSelection');
			$("#add_maincat").jqxComboBox('clearSelection');
			$("#add_subcat").jqxComboBox('clearSelection');
			$scope.gridSettings.disabled = false;
			addialog.close();
			$scope.$apply(function(){
				$scope.tabsSettings = {
					selectedItem: 0
				};
			})
		});

		$("#add_cancel").click(function(){
			var SaveStatus = $("#add_save").attr("disabled");
			if(SaveStatus){
				$scope.gridSettings.disabled = false;
				addialog.close();
				$scope.$apply(function(){
					$scope.tabsSettings = {};
				});
				$scope.$apply(function(){
					$scope.tabsSettings = {
						selectedItem : 0
					};
				});
				reset_add_new_item_form();
				supplier();
				brand();
				category();
			}else{
				$("#addtab1, #addtab2, #addtab3, #addtab4, #addtab5, #addtab6").block({message: null});
				$("#add_btnscd").hide();
				$("#add_msg").show();
			}
		});

		$("#add_conf_cancel").click(function(){
			$("#addtab1, #addtab2, #addtab3, #addtab4, #addtab5, #addtab6").unblock();
			$("#add_supplier").jqxDropDownList('clearSelection');
			$("#add_brand").jqxDropDownList('clearSelection');
			$("#add_maincat").jqxDropDownList('clearSelection');
			$("#add_subcat").jqxDropDownList('clearSelection');
			$("#add_btnscd").show();
			$("#add_msg").hide();
		});

		/*Stock Level Tab*/
		$scope.gridStockSettings = {
			disabled: false,
			height: 300,
			created: function(args)
			{
				grid = args.instance;
			},
			source:  {
				dataType: "json",
				dataFields: [
					{ name: 'Unique', type : 'int' },
					{ name: 'TransactionDate', type: 'string'},
					{ name: 'Type', type: 'string' },
					{ name: 'Location', type: 'string'},
					{ name: 'Quantity', type: 'string'},
					{ name: 'Total', type: 'string'},
					{ name: 'Comment', type: 'string'}
				],
				id: 'Unique',
				url: ''
			}
		};
		/*End Stock level tab*/

		/*Save, Cancel, Delete buttons*/
		$("#_update").click(function(){
			
			var process1 = false;
			var SelSupplier =  $("#supplier").jqxComboBox('getSelectedItem');
			var SelSupplierText = $("#supplier").jqxComboBox('val');
			if(SelSupplier){
				$(".edit_sel_supplier_message").text('');
				process1 = true;
			}else{
				if(SelSupplierText == ''){
					$(".edit_sel_supplier_message").text('');
					//$("#supplier").val(DefaultSupplier);
					process1 = true;	
				}else{
					$(".edit_sel_supplier_message").text("Supplier does not exist");
					process1 = false;
				}
			}
			
			var process2 = false;
			var SelBrand =  $("#brand").jqxComboBox('getSelectedItem');
			var SelBrandText = $("#brand").val();
			if(SelBrand){
				$(".edit_sel_brand_message").text('');
				process2 = true;	
			}else{
				if(SelBrandText == ''){
					$(".edit_sel_brand_message").text('');
					//$("#brand").jqxComboBox('val',DefaultBrand);
					process2 = true;	
				}else{
					$(".edit_sel_brand_message").text("Brand does not exist");
					process2 = false;
				}
			}
			
			var process3 = false;
			var SelCategory =  $("#maincat").jqxComboBox('getSelectedItem');
			var SelCategoryText = $("#maincat").val();
			if(SelCategory){
				$(".edit_sel_category_message").text('');
				process3 = true;
			}else{
				if(SelCategoryText == ''){
					$(".edit_sel_category_message").text('');
					//$("#brand").val(DefaultCategory);
					process3 = true;	
				}else{
					$(".edit_sel_category_message").text("Category does not exist");
					process3 = false;
				}
			}
			
			var process4 = false;
			var SelSubCat =  $("#subcat").jqxComboBox('getSelectedItem');
			var SelSubCatText = $("#subcat").val();
			if(SelSubCat){
				$(".edit_sel_subcat_message").text('');
				process4 = true;
			}else{
				if(SelSubCatText == ''){
					$(".edit_sel_subcat_message").text('');
					//$("#maincat").val(DefaultSubCategory);
					process4 = true;	
				}else{
					$(".edit_sel_subcat_message").text("Sub Category does not exist");
					process4 = false;
				}
			}
			
			var process5 = false;
			var ItemNumber = $("#itemnumber").val();
			if(ItemNumber){
				$(".edit_itemnumber_message").text('*');
				process5 = true;
			}else{
				$(".edit_itemnumber_message").text("Item Number is required field");
				process5 = false;
			}
			
			var process6 = false;
			var Barcode = $("#partnumber").val();
			if(Barcode){
				$(".edit_barcode_message").text('*');
				process6 = true;
			}else{
				$(".edit_barcode_message").text("Barcode is required field");
				process6 = false;
			}
			
			
			if(process1 == true && process2 == true && process3 == true && process4 == true && process5 == true && process6 == true){
				$.when(update_process()).then(function(){
					$.when(load_tax()).done(function(){
						$.ajax({
							url: SiteRoot+'backoffice/gettaxval',
							type: 'post',
							data: {itemid : $("#itemunique").val()},
							dataType:"json",
							success: function(data){
								$.each(data, function(index, value){
									if(value.Status == 1){
										$("#"+value.Tax).jqxCheckBox({ width: 120, height: 25, checked: true});
									}else{
										$("#"+value.Tax).jqxCheckBox({ width: 120, height: 25, checked: false});
									}
								})
							},
							error: function(){
								alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
							}
						})
					});
					$scope.gridSettings = {
						disabled: false,
						source:  {
							dataType: "json",
							dataFields: [
								{ name: 'Unique', type : 'int' },
								{ name: 'Item', type: 'string'},
								{ name: 'Part', type: 'string' },
								{ name: 'Description', type: 'string'},
								{ name: 'Size', type: 'string'},
								{ name: 'Color', type: 'string'},
								{ name: 'Other', type: 'string'},
								{ name: 'SupplierId', type: 'int'},
								{ name: 'Supplier', type: 'string'},
								{ name: 'SupplierPart', type: 'string'},
								{ name: 'BrandId', type: 'int'},
								{ name: 'Brand', type: 'string'},
								{ name: 'CatMainId', type: 'int'},
								{ name: 'Category', type: 'string'},
								{ name: 'SubCategory', type: 'int'},
								{ name: 'Cost', type: 'string'},
								{ name: 'CostExtra', type: 'string'},
								{ name: 'CostFreight', type: 'string'},
								{ name: 'CostDuty', type: 'string'},
								{ name: 'CostLanded', type: 'string'},
								{ name: 'ListPrice', type: 'string'},
								{ name: 'price1', type: 'string'},
								{ name: 'price2', type: 'string'},
								{ name: 'price3', type: 'string'},
								{ name: 'price4', type: 'string'},
								{ name: 'price5', type: 'string'},
								{ name: 'Quantity', type: 'string'}
							],
							id: 'Unique',
							url: SiteRoot+"backoffice/load_inventory/"+location_selected
						},
						created: function (args) {
							var instance = args.instance;
							instance.updateBoundData();
						}
					}
					//dialog.close();
				})
			}
		});


		$scope.EditInventoryChange = function(){
			$("#_update").prop("disabled", false);
		}

		$("#_cancel").click(function(){
			$scope.$apply(function(){
				$scope.tabset = {
					selectedItem: 0
				}
			});
			var changed = $("#_update").is(":disabled");
			if(changed){
				$('#tab1').unblock();
				$('#tab2').unblock();
				$('#tab3').unblock();
				$('#tab4').unblock();
				reset_form();
				dialog.close();
			}else{
				$("#_btnscd").hide();
				$("#msg").show();
				$("#msg_delete").hide();
				$('#tab1').block({ message: null });
				$('#tab2').block({ message: null });
				$('#tab3').block({ message: null });
				$('#tab4').block({ message: null });
			}
			$("#del_confirmation_msg").hide();
			$("#delmymessage").html("");
		});
		
		$("#_delcancel").click(function(){
			$scope.$apply(function(){
				$scope.tabset = {
					selectedItem: 0
				}
			});
			var changed = $("#_update").is(":disabled");
			if(changed){
				$('#tab1').unblock();
				$('#tab2').unblock();
				$('#tab3').unblock();
				$('#tab4').unblock();
				reset_form();
				dialog.close();
				$scope.$apply(function(){
					$scope.gridSettings = {
						disabled: false,
						source:  {
							dataType: "json",
							dataFields: [
								{ name: 'Unique', type : 'int' },
								{ name: 'Item', type: 'string'},
								{ name: 'Part', type: 'string' },
								{ name: 'Description', type: 'string'},
								{ name: 'Size', type: 'string'},
								{ name: 'Color', type: 'string'},
								{ name: 'Other', type: 'string'},
								{ name: 'SupplierId', type: 'int'},
								{ name: 'Supplier', type: 'string'},
								{ name: 'SupplierPart', type: 'string'},
								{ name: 'BrandId', type: 'int'},
								{ name: 'Brand', type: 'string'},
								{ name: 'CatMainId', type: 'int'},
								{ name: 'Category', type: 'string'},
								{ name: 'SubCategory', type: 'int'},
								{ name: 'Cost', type: 'string'},
								{ name: 'CostExtra', type: 'string'},
								{ name: 'CostFreight', type: 'string'},
								{ name: 'CostDuty', type: 'string'},
								{ name: 'CostLanded', type: 'string'},
								{ name: 'Price', type: 'string'},
								{ name: 'SalePrice', type: 'string'},
								{ name: 'Quantity', type: 'string'}
							],
							id: 'Unique',
							url: SiteRoot+"backoffice/load_inventory/"+location_selected
						},
						created: function (args) {
						   var instance = args.instance;
						   //instance.updateBoundData();
						}
					}
				})
			}else{
				$("#_btnscd").hide();
				$("#msg").show();
				$("#msg_delete").hide();
				$('#tab1').block({ message: null });
				$('#tab2').block({ message: null });
				$('#tab3').block({ message: null });
				$('#tab4').block({ message: null });
			}
			$("#del_confirmation_msg").hide();
			$("#delmymessage").html("");
			$(this).hide();
			$("#_cancel").show();
		})
		

		$("#_delete").click(function(){
			var itemnumber = $("#itemnumber").val();
			var description = $("#description").val();
			$("#tab1, #tab2, #tab3, #tab4, #tab5, #tab6").block({message: null});
			$("#_btnscd").hide();
			$("#msg_delete").show();
			$("#delmsg").text("Would you like to delete "+itemnumber+" "+description+"?");
		});

		$("#_delyes").click(function(){
			$.when(delete_process()).then(function(){
				$("#_btnscd").show();
				$("#_restore").show();
				$("#_delete").hide();
				$("#_cancel").hide();
				$("#_delcancel").show();
				$("#msg_delete").hide();
			})
		});

		$("#_delno").click(function(){
			$("#msg_delete").hide();
			$("#_btnscd").show();
			$("#delmsg").text("");
			$("#tab1, #tab2, #tab3, #tab4, #tab5, #tab6").unblock();
		});

		$("#_restore").click(function(){
			$.when(restore_process()).done(function(){
				$("#_restore").hide();
				$("#_delete").show();
				$("#_delete").attr("disabled",false);
				$("#_cancel").show();
				$("#_delcancel").hide();
				$("#tab1, #tab2, #tab3, #tab4, #tab5, #tab6").unblock();
			})
		});

		/*Confirmation Yes or No*/
		$("#_yes").click(function(){
			//update_process();
			//$("#InventoryController").unblock();
			dialog.close();
			$.when(update_process()).done(function(){
				$scope.$apply(function(){
					$scope.gridSettings = {
						disabled: false,
						source:  {
							dataType: "json",
							dataFields: [
								{ name: 'Unique', type : 'int' },
								{ name: 'Item', type: 'string'},
								{ name: 'Part', type: 'string' },
								{ name: 'Description', type: 'string'},
								{ name: 'Size', type: 'string'},
								{ name: 'Color', type: 'string'},
								{ name: 'Other', type: 'string'},
								{ name: 'SupplierId', type: 'int'},
								{ name: 'Supplier', type: 'string'},
								{ name: 'SupplierPart', type: 'string'},
								{ name: 'BrandId', type: 'int'},
								{ name: 'Brand', type: 'string'},
								{ name: 'CatMainId', type: 'int'},
								{ name: 'Category', type: 'string'},
								{ name: 'SubCategory', type: 'int'},
								{ name: 'Cost', type: 'string'},
								{ name: 'CostExtra', type: 'string'},
								{ name: 'CostFreight', type: 'string'},
								{ name: 'CostDuty', type: 'string'},
								{ name: 'CostLanded', type: 'string'},
								{ name: 'ListPrice', type: 'string'},
								{ name: 'price1', type: 'string'},
								{ name: 'price2', type: 'string'},
								{ name: 'price3', type: 'string'},
								{ name: 'price4', type: 'string'},
								{ name: 'price5', type: 'string'},
								{ name: 'Quantity', type: 'string'}
							],
							id: 'Unique',
							url: SiteRoot+"backoffice/load_inventory/"+location_selected
						},
						created: function (args) {
						   var instance = args.instance;
						   instance.updateBoundData();
						}
					}
				})
			});
			$("#msg").hide();
			$("#_btnscd").show();
			$('#tab1').unblock();
			$('#tab2').unblock();
			$('#tab3').unblock();
			$('#tab4').unblock();
		});

		$("#_no").click(function(){
			dialog.close();
			//$("#InventoryController").unblock();
			reset_form();
			$scope.$apply(function(){
				$scope.gridSettings = {
					disabled: false,
					source:  {
						dataType: "json",
						dataFields: [
							{ name: 'Unique', type : 'int' },
							{ name: 'Item', type: 'string'},
							{ name: 'Part', type: 'string' },
							{ name: 'Description', type: 'string'},
							{ name: 'Size', type: 'string'},
							{ name: 'Color', type: 'string'},
							{ name: 'Other', type: 'string'},
							{ name: 'SupplierId', type: 'int'},
							{ name: 'Supplier', type: 'string'},
							{ name: 'SupplierPart', type: 'string'},
							{ name: 'BrandId', type: 'int'},
							{ name: 'Brand', type: 'string'},
							{ name: 'CatMainId', type: 'int'},
							{ name: 'Category', type: 'string'},
							{ name: 'SubCategory', type: 'int'},
							{ name: 'Cost', type: 'string'},
							{ name: 'CostExtra', type: 'string'},
							{ name: 'CostFreight', type: 'string'},
							{ name: 'CostDuty', type: 'string'},
							{ name: 'CostLanded', type: 'string'},
							{ name: 'ListPrice', type: 'string'},
							{ name: 'price1', type: 'string'},
							{ name: 'price2', type: 'string'},
							{ name: 'price3', type: 'string'},
							{ name: 'price4', type: 'string'},
							{ name: 'price5', type: 'string'},
							{ name: 'Quantity', type: 'string'}
						],
						id: 'Unique',
						url: SiteRoot+"backoffice/load_inventory/"+location_selected
					},
					created: function (args) {
					   var instance = args.instance;
					   instance.updateBoundData();
					}
				}
			})
		});

		$("#_conf_cancel").click(function(){
			$('#tab1').unblock();
			$('#tab2').unblock();
			$('#tab3').unblock();
			$('#tab4').unblock();
			$("#msg").hide();
			$("#_btnscd").show();
		});

		$("#_qtyaddremove").keyup(function(event){
			var sum=0;
			var addup = $("#_qtyinstock").val();
			sum = Number($(this).val());
			$("#_newqty").val(Number(sum)+Number(addup));
			//$('#_qtyaddremove').val().replace(/[A-Za-z$-]/g, "");
			$("#_update").attr("disabled", true);
		});

		$("#_newqty").keyup(function(){
			var sum=0;
			var addup = $("#_qtyinstock").val();
			sum = Number($(this).val());
			$("#_qtyaddremove").val(Number(sum)-Number(addup));
			$("#_update").attr("disabled", true);
		});

		$("#_location").change(function(){
			$("#_update").attr("disabled", true);
		});


		$("#_adjcancel").click(function(){
			var adjsave = $("#_adjsave").is(":disabled");

			if(adjsave){
				$("#tab4").unblock();
				$("#_qtyaddremove").val("");
				$("#_qtycomment").val("");
				$("#_btnscd").show();
				$("#jqxWidgetDate").jqxDateTimeInput({ value: new Date(yyyy, mm, dd) });
				$("#jqxWidgetTime").jqxDateTimeInput({ formatString: 'T', showCalendarButton: false });
			}else{
				$("#stkbtns").hide();
				$("#msgstklevel").show();
			}

		});

		$("#_adjsave").click(function(){
			var qtyaddrem = $("#_qtyaddremove").val();
			var stocklevel_location = $("#_adj_location").val();
			if(qtyaddrem){
				var itemunique = $("#itemunique").val();
				$.when(save_stock_line_qty()).done(function(){
					$scope.$apply(function () {
						$scope.gridStockSettings = {
							source:  {
								dataType: "json",
								dataFields: [
									{ name: 'Unique', type : 'int' },
									{ name: 'TransactionDate', type: 'string'},
									{ name: 'Type', type: 'string' },
									{ name: 'Location', type: 'string'},
									{ name: 'Quantity', type: 'string'},
									{ name: 'Total', type: 'string'},
									{ name: 'Comment', type: 'string'}
								],
								id: 'Unique',
								url: SiteRoot+"backoffice/load_item_stock_line/"+itemunique+"/"+stocklevel_location
							},
							created: function (args) {
								var instance = args.instance;
								instance.updateBoundData();
							}
						}
						
						$scope.gridSettings = {
							disabled: false,
							source:  {
								dataType: "json",
								dataFields: [
									{ name: 'Unique', type : 'int' },
									{ name: 'Item', type: 'string'},
									{ name: 'Part', type: 'string' },
									{ name: 'Description', type: 'string'},
									{ name: 'Size', type: 'string'},
									{ name: 'Color', type: 'string'},
									{ name: 'Other', type: 'string'},
									{ name: 'SupplierId', type: 'int'},
									{ name: 'Supplier', type: 'string'},
									{ name: 'SupplierPart', type: 'string'},
									{ name: 'BrandId', type: 'int'},
									{ name: 'Brand', type: 'string'},
									{ name: 'CatMainId', type: 'int'},
									{ name: 'Category', type: 'string'},
									{ name: 'SubCategory', type: 'int'},
									{ name: 'Cost', type: 'string'},
									{ name: 'CostExtra', type: 'string'},
									{ name: 'CostFreight', type: 'string'},
									{ name: 'CostDuty', type: 'string'},
									{ name: 'CostLanded', type: 'string'},
									{ name: 'ListPrice', type: 'string'},
									{ name: 'price1', type: 'string'},
									{ name: 'price2', type: 'string'},
									{ name: 'price3', type: 'string'},
									{ name: 'price4', type: 'string'},
									{ name: 'price5', type: 'string'},
									{ name: 'Quantity', type: 'string'}
								],
								id: 'Unique',
								url: SiteRoot+"backoffice/load_inventory/"+location_selected
							},
							created: function (args) {
							   var instance = args.instance;
							   instance.updateBoundData();
							}
						}
						
					});
					$("#_btnscd").show();
				});
				$("#_adjsave").attr("disabled",true);
			}else{
				alert("Quantity to Add or Remove is required field.");
			}
		});

		$("#_stkno").click(function(){
			$("#stkbtns").show();
			$("#msgstklevel").hide();
			$("#tab3").unblock();
			$("#_qtyaddremove").val("");
			$("#_qtycomment").val("");
			$("#_adjsave").attr("disabled", true);
			$("#jqxWidgetDate").jqxDateTimeInput({ todayString: 'Today' });
			$("#jqxWidgetTime").jqxDateTimeInput({ formatString: 'T', showCalendarButton: false });
			$("#_btnscd").show();
		});

		$("#_stkyes").click(function(){
			var itemunique = $("#itemunique").val();
			var stocklevel_location = $("#_adj_location").val();
				$.when(save_stock_line_qty()).done(function(){
					$scope.$apply(function () {
						$scope.gridStockSettings = {
							source:  {
								dataType: "json",
								dataFields: [
									{ name: 'Unique', type : 'int' },
									{ name: 'TransactionDate', type: 'string'},
									{ name: 'Type', type: 'string' },
									{ name: 'Location', type: 'string'},
									{ name: 'Quantity', type: 'string'},
									{ name: 'Total', type: 'string'},
									{ name: 'Comment', type: 'string'}
								],
								id: 'Unique',
								url: SiteRoot+"backoffice/load_item_stock_line/"+itemunique+"/"+stocklevel_location
							},
							created: function (args) {
								var instance = args.instance;
								instance.updateBoundData();
							}
						}
					});
					$("#_btnscd").show();
				});
			$("#_adjsave").attr("disabled",true);
		});

		$("#_stkcancel").click(function(){
			$("#stkbtns").show();
			$("#msgstklevel").hide();
		});

		$("#_adj_location").on('change',function(){
			var itemid = $("#itemunique").val();
			var locationid = $(this).val();
				$scope.$apply(function(){
					$scope.gridStockSettings = {
					source:  {
						dataType: "json",
						dataFields: [
							{ name: 'Unique', type : 'int' },
							{ name: 'TransactionDate', type: 'string'},
							{ name: 'Type', type: 'string' },
							{ name: 'Location', type: 'string'},
							{ name: 'Quantity', type: 'string'},
							{ name: 'Total', type: 'string'},
							{ name: 'Comment', type: 'string'}
						],
						id: 'Unique',
						url: SiteRoot+"backoffice/adj_select_location/"+itemid+"/"+locationid
					},
					created: function (args) {
						var instance = args.instance;
						instance.updateBoundData();
					}
				}
			})
		});

		$("#_main_location").change(function(){
			location_selected = $(this).val();
			var main_location = $(this).val();
			$scope.$apply(function(){
				$scope.gridSettings = {
					disabled: false,
					source:  {
						dataType: "json",
						dataFields: [
							{ name: 'Unique', type : 'int' },
							{ name: 'Item', type: 'string'},
							{ name: 'Part', type: 'string' },
							{ name: 'Description', type: 'string'},
							{ name: 'Size', type: 'string'},
							{ name: 'Color', type: 'string'},
							{ name: 'Other', type: 'string'},
							{ name: 'SupplierId', type: 'int'},
							{ name: 'Supplier', type: 'string'},
							{ name: 'SupplierPart', type: 'string'},
							{ name: 'BrandId', type: 'int'},
							{ name: 'Brand', type: 'string'},
							{ name: 'CatMainId', type: 'int'},
							{ name: 'Category', type: 'string'},
							{ name: 'SubCategory', type: 'int'},
							{ name: 'Cost', type: 'string'},
							{ name: 'CostExtra', type: 'string'},
							{ name: 'CostFreight', type: 'string'},
							{ name: 'CostDuty', type: 'string'},
							{ name: 'CostLanded', type: 'string'},
							{ name: 'ListPrice', type: 'string'},
							{ name: 'price1', type: 'string'},
							{ name: 'price2', type: 'string'},
							{ name: 'price3', type: 'string'},
							{ name: 'price4', type: 'string'},
							{ name: 'price5', type: 'string'},
							{ name: 'Quantity', type: 'string'}
						],
						id: 'Unique',
						url: SiteRoot+"backoffice/load_inventory_by_location/"+main_location
					},
					created: function (args) {
					   var instance = args.instance;
					   instance.updateBoundData();
					}
				}
			})
		});


		$("#add_aftersave_no").click(function(){
			reset_add_new_item_form();
			$scope.gridSettings.disabled = false;
				addialog.close();
				//$("#InventoryController").unblock();
				$("#addtab1, #addtab2, #addtab3, #addtab4, #addtab5, #addtab6").unblock()
				$("#add_confirmation_after_save").hide();
				$("#add_btnscd").show();
					$scope.gridSettings = {
						source:  {
							dataType: "json",
							dataFields: [
								{ name: 'Unique', type : 'int' },
								{ name: 'Item', type: 'string'},
								{ name: 'Part', type: 'string' },
								{ name: 'Description', type: 'string'},
								{ name: 'Size', type: 'string'},
								{ name: 'Color', type: 'string'},
								{ name: 'Other', type: 'string'},
								{ name: 'SupplierId', type: 'int'},
								{ name: 'Supplier', type: 'string'},
								{ name: 'SupplierPart', type: 'string'},
								{ name: 'BrandId', type: 'int'},
								{ name: 'Brand', type: 'string'},
								{ name: 'CatMainId', type: 'int'},
								{ name: 'Category', type: 'string'},
								{ name: 'SubCategory', type: 'int'},
								{ name: 'Cost', type: 'string'},
								{ name: 'CostExtra', type: 'string'},
								{ name: 'CostFreight', type: 'string'},
								{ name: 'CostDuty', type: 'string'},
								{ name: 'CostLanded', type: 'string'},
								{ name: 'ListPrice', type: 'string'},
								{ name: 'price1', type: 'string'},
								{ name: 'price2', type: 'string'},
								{ name: 'price3', type: 'string'},
								{ name: 'price4', type: 'string'},
								{ name: 'price5', type: 'string'},
								{ name: 'Quantity', type: 'string'}
							],
							id: 'Unique',
							url: SiteRoot+"backoffice/load_inventory/"+location_selected
						},
						created: function (args) {
						   var instance = args.instance;
						   instance.updateBoundData();
						}
					};

					 $scope.$apply(function(){
						$scope.tabsSettings = {
							selectedItem : 0
						}
					})

		   });

		   $scope.EnterBarcode = function(){
			    var ItemUnique = $("#itemunique").val();
				var postdata="itemid="+ItemUnique;
		    	 postdata+="&barcode="+ $scope.barcode.wsearch;
				 $http({
					url: SiteRoot+'backoffice/addbarcode',
					method: "POST",
					data: postdata,
					headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				 })
				 .success(function(data){
					if(data.success == true){
						load_barcode(ItemUnique);
						$scope.barcode = {};
						$scope.barcode = {
							wsearch: ''
						};
					}
				 })
				 .error(function(status){
					alert(status);
				 })	
		   };

		   $scope.BarcodeTab = function(){
			  $scope.barcodefocus = true;
		   };
		   
		   //-->Add Barcode
		   $scope.AddBarcode = function(){
			    var barcode = $scope.barcode.wsearch;
				if(barcode == null){
					alert("Please enter the barcode number.");
				}else{	 
					var ItemUnique = $("#itemunique").val();
					var postdata="itemid="+ItemUnique;
						postdata+="&barcode="+barcode;
					 $http({
						url: SiteRoot+'backoffice/addbarcode',
						method: "POST",
						data: postdata,
						headers: {'Content-Type': 'application/x-www-form-urlencoded'}
					 })
					 .success(function(data){
						if(data.success == true){
							load_barcode(ItemUnique);
							$scope.barcode = {};
							$scope.barcode = {
								wsearch: null
							};
						}else{
							alert("Please enter the barcode number");
						}
					 })
					 .error(function(status){
						alert(status);
					 })
				}
			};
			
			$scope.EditBarcode = function(){
				var barcode = $scope.barcode.wsearch;
				if(barcode == null){
					alert("Please enter the barcode number.");
				}else{	 
					var ItemUnique = $("#itemunique").val();
					var postdata="itemid="+ItemUnique;
						postdata+="&barcodeunique="+$scope.BarcodeUnique;
						postdata+="&barcode="+ $scope.barcode.wsearch;
					 $http({
						url: SiteRoot+'backoffice/editbarcode',
						method: "POST",
						data: postdata,
						headers: {'Content-Type': 'application/x-www-form-urlencoded'}
					 })
					 .success(function(data){
						if(data.success == true){
							load_barcode(ItemUnique);
							$scope.barcode = {};
							$scope.barcode = {
								wsearch: null
							};
						}
					 })
					 .error(function(status){
						alert(status);
					 })
				}
			};
		   
		   //-->Delete Barcode
		   $scope.DeleteBarcode = function(){
			  	var barcode = $scope.barcode.wsearch;
				if(barcode == null){
					alert("Please enter the barcode number.");
				}else{ 
				  var ItemUnique = $("#itemunique").val();
				  var postdata="itemunique="+ItemUnique;	
					  postdata+="&barcodeunique="+$scope.BarcodeUnique;
				  $http({
					 url: SiteRoot+'backoffice/deletebarcode',
					 method: "POST",
					 data: postdata,
					 headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				  })
				  .success(function(data){
					 if(data.success == true){
						load_barcode(ItemUnique);
						$scope.barcode = {};
						$scope.barcode = {
							wsearch: null
						};
					 } 
				  })
				  .error(function(status){
					alert(status);
				  })
			    }
		   }
		   
		   var reset_add_new_item_form = function(){
				var decprice = $("#decimalprice").val();
				var deccost = $("#decimalcost").val();
				var decqty = $("#decimalqty").val();
				$("#add_itemnumber").val("");
				$("#add_partnumber").val("");
				$("#add_description").val("");
				$("#add_supplierpart").val("");
				$("#add_price").val("");
				$("#add_cost").val("");
				$("#add_costextra").val("");
				$("#add_costfreight").val("");
				$("#add_costduty").val("");
				$("#add_costlanded").val("");
				$("#add_qtyinstock").val(0);
				$("#add_qtyaddremove").val(0);
				$("#add_newqty").val(0);
				$("#add_qty").val("");
				$("#add_qtycomment").val("");
				$("#addjqxWidgetDate").jqxDateTimeInput({ value: new Date(yyyy, mm, dd) });
				$("#addjqxWidgetTime").jqxDateTimeInput({ formatString: 'T', showCalendarButton: false });
				$("#add_save").attr("disabled", true);
				$("#add_price").val("");
				$("#add_saleprice").val("");
				$("#add_listprice").val("");
				$("#add_price1").val("");
				$("#add_price2").val("");
				$("#add_price3").val("");
				$("#add_price4").val("");
				$("#add_price5").val("");
				$(".add_sel_supplier_message").text('');
				$(".add_sel_brand_message").text('');
				$(".add_sel_category_message").text('');
				$(".add_sel_subcat_message").text('');
				
				$("#add_msg").hide();
				
				if(DefaultSupplier > 0){
					$("#add_supplier").jqxComboBox('val', DefaultSupplier); 
				}else{
					$("#add_supplier").jqxComboBox('clearSelection'); 
				}
				if(DefaultBrand > 0){
					$("#add_brand").jqxComboBox('val', DefaultBrand); 
				}else{
					$("#add_brand").jqxComboBox('clearSelection');
				}
				//HD1
				if(DefaultCategory > 0){
					$("#add_maincat").jqxComboBox('val', DefaultCategory);
					$.when(add_subcat(DefaultCategory)).done(function(){
						console.log(DefaultSubCategory);
						if(DefaultSubCategory > 0){
							setTimeout(function(){
								$("#add_subcat").jqxComboBox('val', DefaultSubCategory);
								$("#add_save").prop("disabled", true);
							},100)
						}
					})
				}else{
					$("#add_maincat").jqxComboBox('clearSelection');
					$("#add_subcat").jqxComboBox('clear');
				}
				
				
				
				setTimeout(function(){
					$("#add_itemnumber").focus();
					$("#add_save").prop("disabled", true);
				}, 200);
			}
			
			 $('#aktabs').on('tabclick', function (event){ 
				 var clickedItem = event.args.item;
				 if(clickedItem == 3){
					 setTimeout(function(){
						$("#gridStock").jqxDataTable('refresh');	
					 },100);
				 }
			 }); 
			
		   
	}]);

	//-->AngularJS Directives declaration
	demoApp.directive('ngEnter', function () {
		return function (scope, element, attrs) {
			element.bind("keypress", function (event) {
				if(event.which === 13) {
					scope.$apply(function (){
							scope.$eval(attrs.ngEnter);
					});
					event.preventDefault();
				}
			});
		};
	});
	
	demoApp.directive('focusMe', function($timeout, $parse) {
	  return {
		link: function(scope, element, attrs) {
		  var model = $parse(attrs.focusMe);
		  scope.$watch(model, function(value) {
			console.log('value=',value);
			if(value === true) { 
			  $timeout(function() {
				element[0].focus(); 
			  });
			}
		  });
		  element.bind('blur', function() {
			console.log('blur');
			scope.$apply(model.assign(scope, false));
		  })
		}
	  };
	});

	//demoApp.directive('keyPress')

	//-->End AngularJS

	var sort_by = function(field, reverse, primer){

	   var key = primer ?
		   function(x) {return primer(x[field])} :
		   function(x) {return x[field]};

	   reverse = !reverse ? 1 : -1;

	   return function (a, b) {
		   return a = key(a), b = key(b), reverse * ((a > b) - (b > a));
		 }
	};
	/*
	function supplier(){
		var mydata = [];
		var SupplierDefer = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/edit_supplier',
			type: 'post',
			dataType: 'json',
			success: function(data){
				var mydata = data;

				$("#supplier").html("<option value=''></option>");
				$.each(mydata, function(index, value){
					$("#supplier").append("<option value='"+index+"'>"+value.Supplier+"</option>");
					console.log(value.Supplier);
				});

				var mylist = $('#supplier');
					var listitems = mylist.children('option').get();
					listitems.sort(function(a, b) {
					   return $(a).text().toUpperCase().localeCompare($(b).text().toUpperCase());
					});
				$.each(listitems, function(idx, itm) { mylist.append(itm); });

				SupplierDefer.resolve();
			},
			error: function(){
				alert('Sorry, we encountered a technical difficulties\nPlease try again later.');
			}
		});
		return SupplierDefer.promise();
	}
	*/

	function add_supplier(){
		var AddSupplierDefer = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/edit_supplier',
			type: 'post',
			dataType: 'json',
			success: function(data){
				$("#add_supplier").html("<option value=''></option>");
				$.each(data, function(index, value){
					$("#add_supplier").append("<option value='"+index+"'>"+value.Supplier+"</option>");
				});

				var mylist = $('#add_supplier');
					var listitems = mylist.children('option').get();
					listitems.sort(function(a, b) {
					   return $(a).text().toUpperCase().localeCompare($(b).text().toUpperCase());
					});
				$.each(listitems, function(idx, itm) { mylist.append(itm); });

				AddSupplierDefer.resolve();
			},
			error: function(){
				alert('Sorry, we encountered a technical difficulties\nPlease try again later.');
			}
		});
		return AddSupplierDefer.promise();
	}

	/*
	function brand(){
		var BrandDefer = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/edit_brand',
			type: 'post',
			dataType: 'json',
			success: function(data){
				$("#brand").html("<option value=''></option>");
				$.each(data, function(index, value){
					$("#brand").append("<option value='"+index+"'>"+value.Brand+"</option>");
				});

				var mylist = $('#brand');
					var listitems = mylist.children('option').get();
					listitems.sort(function(a, b) {
					   return $(a).text().toUpperCase().localeCompare($(b).text().toUpperCase());
					});
				$.each(listitems, function(idx, itm) { mylist.append(itm); });

				BrandDefer.resolve();
			},
			error: function(){
				alert('Sorry, we encountered a technical difficulties\nPlease try again later.');
			}
		});
		return BrandDefer.promise();
	}
	*/

	function add_brand(){
		var AddBrandDefer = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/edit_brand',
			type: 'post',
			dataType: 'json',
			success: function(data){
				$("#add_brand").html("<option value=''></option>");
				$.each(data, function(index, value){
					$("#add_brand").append("<option value='"+index+"'>"+value.Brand+"</option>");
				});

				var mylist = $('#add_brand');
					var listitems = mylist.children('option').get();
					listitems.sort(function(a, b) {
					   return $(a).text().toUpperCase().localeCompare($(b).text().toUpperCase());
					});
				$.each(listitems, function(idx, itm) { mylist.append(itm); });

				AddBrandDefer.resolve();
			},
			error: function(){
				alert('Sorry, we encountered a technical difficulties\nPlease try again later.');
			}
		});
		return AddBrandDefer.promise();
	}
	
	/*
	function maincat(){
		var defermaincat = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/maincat',
			type: 'post',
			dataType:"json",
			success: function(data){
				$("#maincat").html("<option value=''></option>");
				$.each(data, function(index, value){
					$("#maincat").append("<option value='"+index+"'>"+value.maincat+"</option>");
				});

				var mylist = $('#maincat');
					var listitems = mylist.children('option').get();
					listitems.sort(function(a, b) {
					   return $(a).text().toUpperCase().localeCompare($(b).text().toUpperCase());
					});
				$.each(listitems, function(idx, itm) { mylist.append(itm); });

				defermaincat.resolve();
			},
			error: function(){
				defermaincat.reject();
				alert("Sorry, we encouter a technical difficulties\nPlease try again later.");
			}
		});
		return defermaincat.promise();
	}
	*/


	function add_maincat(){
		var AddMainCatDefer = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/maincat',
			type: 'post',
			dataType:"json",
			success: function(data){
				$("#add_maincat").html("<option value=''></option>");
				$.each(data, function(index, value){
					$("#add_maincat").append("<option value='"+index+"'>"+value.maincat+"</option>");
				});

				var mylist = $('#add_maincat');
					var listitems = mylist.children('option').get();
					listitems.sort(function(a, b) {
					   return $(a).text().toUpperCase().localeCompare($(b).text().toUpperCase());
					});
				$.each(listitems, function(idx, itm) { mylist.append(itm); });

				AddMainCatDefer.resolve();
			},
			error: function(){
				alert("Sorry, we encouter a technical difficulties\nPlease try again later.");
			}
		});
		return AddMainCatDefer.promise();
	}

	/*
	function subcat(subcatid){
		var defersubcat = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/subcat',
			type: 'post',
			data: { maincatid : subcatid },
			dataType:"json",
			success: function(data){
				$("#subcat").html("<option value=''></option>");
				$.each(data, function(index, value){
					$("#subcat").append("<option value='"+index+"'>"+value.subcat+"</option>");
				});

				var mylist = $('#subcat');
					var listitems = mylist.children('option').get();
					listitems.sort(function(a, b) {
					   return $(a).text().toUpperCase().localeCompare($(b).text().toUpperCase());
					});
				$.each(listitems, function(idx, itm) { mylist.append(itm); });

				defersubcat.resolve();
			},
			error: function(){
				defersubcat.reject();
				alert("Sorry, we encouter a technical difficulties\nPlease try again later.");
			}
		});
		return defersubcat.promise();
	}
	*/
	
	/*
	function add_subcat(subcatid){
		var AddSubCatDefer = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/subcat',
			type: 'post',
			data: { maincatid : subcatid },
			dataType:"json",
			success: function(data){
				$("#add_subcat").html("<option value=''></option>");
				$.each(data, function(index, value){
					$("#add_subcat").append("<option value='"+index+"'>"+value.subcat+"</option>");
				});

				var mylist = $('#add_subcat');
					var listitems = mylist.children('option').get();
					listitems.sort(function(a, b) {
					   return $(a).text().toUpperCase().localeCompare($(b).text().toUpperCase());
					});
				$.each(listitems, function(idx, itm) { mylist.append(itm); });

				AddSubCatDefer.resolve();
			},
			error: function(){
				alert("Sorry, we encouter a technical difficulties\nPlease try again later.");
			}
		});
		return AddSubCatDefer.promise();
	}
	*/

	function edititem(){
		if(itemid!=0){
		 	$("#itemid").val(itemid);
        	$("#frmedit").submit();
		}else{
			//alert("Please select contact first.");
			custom_alert_message('Please select an item from the list.');
		}
    }

	function deletecontact(){
		if(itemid!=0){
		 	$("#itemid").val(itemid);
			if (confirm('Are you sure you want to delete this contact?')) {
				$("#frmdelete").submit();
			} else {
				// Do nothing!
			}
		}else{
			alert("Please select contact first.");
		}
	}

	function custom_alert_message(msg){
		BootstrapDialog.alert(msg);
	}

	function custom_confirm_message(msg){
		BootstrapDialog.confirm(msg, function(result){
            if(result) {
                alert('Yup.');
            }else {
                alert('Nope.');
            }
        });
	}


	function checkAnyFormFieldEdited() {
		$('.itemelement').keypress(function(e) { // text written
			enableSaveBtn();
		});

		$('.itemelement').keyup(function(e) {
			if (e.keyCode == 8 || e.keyCode == 46) { //backspace and delete key
				enableSaveBtn();
			} else { // rest ignore
				e.preventDefault();
			}
		});

		$('.itemelement').bind('paste', function(e) { // text pasted
			enableSaveBtn();
		});

		$('.itemelement').change(function(e) { // select element changed
			enableSaveBtn();
		});

		$('.checktax').on("click", function(){
			enableSaveBtn();
		});

		/*
		$(':radio').change(function(e) { // radio changed
			enableSaveBtn();
		});

		$(':password').keypress(function(e) { // password written
			enableSaveBtn();
		});
		$(':password').bind('paste', function(e) { // password pasted
			enableSaveBtn();
		});
		*/
	}

	function checkStockLevelFormFieldEdited() {
		$('.stklevel').keypress(function(e) { // text written
			enableSaveBtnStklevel();
		});

		$('.stklevel').keyup(function(e) {
			if (e.keyCode == 8 || e.keyCode == 46) { //backspace and delete key
				enableSaveBtnStklevel();
			} else { // rest ignore
				e.preventDefault();
			}
		});
		$('.stklevel').bind('paste', function(e) { // text pasted
			enableSaveBtnStklevel();
		});

		$('.stklevel').change(function(e) { // select element changed
			enableSaveBtnStklevel();
		});
	}

	function AddItemLevelFormFieldEdited() {
		$('.additemelement').keypress(function(e) { // text written
			enableSaveAddBtn();
		});

		$('.additemelement').keyup(function(e) {
			if (e.keyCode == 8 || e.keyCode == 46) { //backspace and delete key
				enableSaveAddBtn();
			} else { // rest ignore
				e.preventDefault();
			}
		});
		$('.additemelement').bind('paste', function(e) { // text pasted
			enableSaveAddBtn()();
		});

		$('.additemelement').change(function(e) { // select element changed
			enableSaveAddBtn();
		});
	}


	function enableSaveBtn(){
		$("#_update").attr("disabled",false);
	}

	function enableSaveBtnStklevel(){
		$("#_adjsave").attr("disabled", false);
	}

	function enableSaveAddBtn(){
		$("#add_save").attr("disabled", false);
	}
	
	function update_process(){
		var deferupdateitem = $.Deferred();
		var checkboxitem = [];
		var uncheckboxitem = [];
		itemunique = $("#itemunique").val();
		itemnumber = encodeURIComponent($("#itemnumber").val());
		partnumber = encodeURIComponent($("#partnumber").val());
		description = encodeURIComponent($("#description").val());
		supplierpart = encodeURIComponent($("#supplierpart").val());
		price = $("#price").val();
		saleprice = $("#saleprice").val();
		price2 = $("#price2").val();
		price3 = $("#price3").val();
		price4 = $("#price4").val();
		price5 = $("#price5").val();
		cost = $("#cost").val();
		costextra = $("#costextra").val();
		costfreight = $("#costfreight").val();
		costduty = $("#costduty").val();
		
		if($("#price").val() == ''){
			price = 0;
		}
		if($("#saleprice").val() == ''){
			saleprice = 0;
		}
		if($("#price2").val() == ''){
			price2 = 0;
		}
		if($("#price3").val() == ''){
			price3 = 0;
		}
		if($("#price4").val() == ''){
			price4 = 0;
		}
		if($("#price5").val() == ''){
			price5 = 0;
		}
		
		//supplier = $("#supplier").val();
		//brand = $("#brand").val();
		//category = $("#subcat").val();
		
		if($("#supplier").val() == ''){
			supplier = null;
		}else{
			supplier = $("#supplier").val();
		}
		if($("#brand").val() == ''){
			brand = null;
		}else{
			brand = $("#brand").val();
		}
		if($("#subcat").val() == ''){
			category = null;
		}else{
			category = $("#subcat").val();
		}

		var post_data="itemunique="+itemunique;
			post_data+="&itemnumber="+itemnumber;
			post_data+="&partnumber="+partnumber;
			post_data+="&description="+description;
			post_data+="&supplier="+supplier;
			post_data+="&supplierpart="+supplierpart;
			post_data+="&brand="+brand;
			post_data+="&category="+category;
			post_data+="&price="+price;
			post_data+="&price2="+price2;
			post_data+="&price3="+price3;
			post_data+="&price4="+price4;
			post_data+="&price5="+price5;
			post_data+="&saleprice="+saleprice;
			post_data+="&cost="+cost;
			post_data+="&costextra="+costextra;
			post_data+="&costfreight="+costfreight;
			post_data+="&costduty="+costduty;

			$.each($(".checktax"), function(){
				var elemid = this.id;
				var checked = $("#"+elemid).val();
				if (checked) {
					checkboxitem.push(elemid);
				}else{
					uncheckboxitem.push(elemid);
				}
			});

			post_data+="&taxchecked="+checkboxitem;
			post_data+="&taxunchecked="+uncheckboxitem;

		$.ajax({
			url: SiteRoot+'backoffice/update_inventory_item',
			type: 'post',
			data: post_data,
			dataType: 'json',
			success: function(data){
				if(data.success == true){
					$("#message").text("Item Updated.");
					$("#_update").attr("disabled", true);
					confirmation_message()
				}
				deferupdateitem.resolve();
			},
			error: function(){
				alert('Sorry, we encountered a technical difficulties\nPlease try again later.');
			}
		});

		return deferupdateitem.promise();
	}

	function delete_process(){
		var deferdeleteitem = $.Deferred();

		itemunique = $("#itemunique").val();
		$.ajax({
			url: SiteRoot+"backoffice/itemdelete",
			type: "post",
			data: {itemid : itemunique},
			dataType:"json",
			success: function(data){
				if(data.success == true){
					$("#message").text("Item Deleted.");
					$("#message").text(global_item+" "+global_itemdesc+" "+"marked for deletion. To finalize deletion, select CLOSE or select RESTORE to undo");
					$("#_delete").attr("disabled", true);
					confirmation_message()
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

		itemunique = $("#itemunique").val();
		$.ajax({
			url: SiteRoot+"backoffice/itemrestore",
			type: "post",
			data: {itemid : itemunique},
			dataType:"json",
			success: function(data){
				if(data.success == true){
					$("#message").text("Item Restored.");
					$("#_delete").attr("disabled", false);
					$("#_delete").show();
					$("#_restore").hide();
					confirmation_message()
				}
				restoredefer.resolve();
			},
			error: function(){
				alert("Sorry, we encoutered a technical difficulties\nPlease try again later.");
			}
		});
		return restoredefer.promise();
	}


	function reset_form(){
		$("#itemunique").val("");
		$("#itemnumber").val("");
		$("#partnumber").val("");
		$("#description").val("");
		$("#supplierpart").val("");
		$("#supplier").jqxComboBox('clearSelection'); 
		$("#brand").jqxComboBox('clearSelection'); 
		$("#maincat").jqxComboBox('clearSelection'); 
		$("#subcat").jqxComboBox('clearSelection'); 
		$("#_adj_location").jqxComboBox('clearSelection'); 
		$("#price").val("");
		$("#saleprice").val();
		$("#listprice").val();
		$("#price1").val();
		$("#price2").val();
		$("#price3").val();
		$("#price4").val();
		$("#price5").val();
		$("#cost").val("");
		$("#costextra").val("");
		$("#costfreight").val("");
		$("#costduty").val("");
		$('#tab1').unblock();
		$('#tab2').unblock();
		$('#tab3').unblock();
		$('#tab4').unblock();
		$("#msg").hide();
		$("#_btnscd").show();
		$("#_update").attr("disabled",true);
		$("#_delete").attr("disabled",false);
		$("#_restore").hide();
		$("#_delete").show();
		$("#jqxWidgetDate").jqxDateTimeInput({ value: new Date(yyyy, mm, dd) });
		$("#jqxWidgetTime").jqxDateTimeInput({ formatString: 'T', showCalendarButton: false });
	}

	function save_stock_line_qty(){
		var defstockqty = $.Deferred();
		var quantityRM = $("#_qtyaddremove").val();
		var itemunique = $("#itemunique").val();
		var qtycomment = $("#_qtycomment").val();
		var setdate = $("#jqxWidgetDate").val();
		var settime = $("#jqxWidgetTime").val();
		var locationid = $("#_location").val();

		var post_data="itemid="+itemunique;
			post_data+="&quantity="+quantityRM;
			post_data+="&comment="+qtycomment;
			post_data+="&setdate="+setdate;
			post_data+="&settime="+settime;
			post_data+="&locationid="+locationid;
		$.ajax({
			url: SiteRoot+'backoffice/save_new_stockqty',
			type: 'post',
			data: post_data,
			dataType:'json',
			success: function(data){
				if(data.success == true){
					$("#message").text("Quantity Adjusted");
					confirmation_message();
					$("#stkbtns").show();
					$("#msgstklevel").hide();
					$("#tab4").unblock();
					$("#_qtyaddremove").val("");
					$("#_qtycomment").val("");
					$("#jqxWidgetDate").jqxDateTimeInput({ value: new Date(yyyy, mm, dd) });
					$("#jqxWidgetTime").jqxDateTimeInput({ formatString: 'T', showCalendarButton: false });
					//$("#_location").val(location_selected);
					$("#_location").val(location_selected);

				}
				defstockqty.resolve();
			},
			error: function(){
				alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
			}
		});
		return defstockqty.promise();
	}

	function load_stores(){
		var locationdef = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/load_stores',
			type: 'post',
			dataType:"json",
			success: function(data){
				$("#_location").html("<option value=''></option>");
				$.each(data, function(index, value){
					$("#_location").append("<option value='"+index+"'>"+value.description+"</option>");
				});

				var mylist = $('#_location');
					var listitems = mylist.children('option').get();
					listitems.sort(function(a, b) {
					   return $(a).text().toUpperCase().localeCompare($(b).text().toUpperCase());
					});
				$.each(listitems, function(idx, itm) { mylist.append(itm); });

				locationdef.resolve();
			}
		});
		return locationdef.promise();
	}

	function add_load_stores(){
		var AddLoadStoreDefer = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/load_stores',
			type: 'post',
			dataType:"json",
			success: function(data){
				$("#add_location").html("");
				$.each(data, function(index, value){
					$("#add_location").append("<option value='"+index+"'>"+value.description+"</option>");
				});

				var mylist = $('#add_location');
					var listitems = mylist.children('option').get();
					listitems.sort(function(a, b) {
					   return $(a).text().toUpperCase().localeCompare($(b).text().toUpperCase());
					});
				$.each(listitems, function(idx, itm) { mylist.append(itm); });

				AddLoadStoreDefer.resolve();
			}
		});
		return AddLoadStoreDefer.promise();
	}

	function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode;

        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
	/*
	function load_tax(){
		var taxdefer = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/load_tax',
			type: 'post',
			dataType:"json",
			success: function(data){
				$("#itemtax").html("");
				$.each(data, function(index, value){
					$("#itemtax").append("<div id='"+index+"' onClick='Chkbox("+index+")' style='margin-left: 10px;'>"+value.Code+" "+value.Rate+"</div>");
					$("#"+index).jqxCheckBox({ width: 120, height: 25});
				})
				taxdefer.resolve();
			},
			error: function(){
				alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
			}
		})
		return taxdefer.promise();
	}
	*/
	function load_tax(){
		var taxdefer = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/load_tax',
			type: 'post',
			dataType:"json",
			success: function(data){
				$("#itemtax").html("<table id='taxtable' class='table'>"+
									   "<thead>"+
										   "<tr>"+
											   "<th data-field='code'></th>"+
											   "<th data-field='code'>Code</th>"+
											   "<th data-field='desc'>Description</th>"+
											   "<th data-field='rate'>Rate</th>"+
											   "<th data-field='basis'>Basis</th>"+
										   "</tr>"+
									   "</thead>"+
								   "</table>");
				$.each(data, function(index, value){
					$("#taxtable").append("<tr>"+
												"<td><div id='"+index+"' onClick='Chkbox("+index+")' class='checktax itemelement'></div></td>"+
												"<td>"+value.Code+"</td>"+
												"<td>"+value.itemtax+"</td>"+
												"<td>"+value.Rate+"</td>"+
												"<td>"+value.Basis+"</td>"+
										  "</tr>");
					$("#"+index).jqxCheckBox({ width: 120, height: 25});
				});
				taxdefer.resolve();
			},
			error: function(){
				alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
			}
		});
		return taxdefer.promise();
	}

	function add_tax(){
		var AddTaxDefer = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/load_tax',
			type: 'post',
			dataType:"json",
			success: function(data){
				var checked;

				$("#add_itemtax").html("<table id='add_taxtable' class='table' height='120'>"+
										   "<thead>"+
											   "<tr>"+
												   "<th data-field='code'></th>"+
												   "<th data-field='code'>Code</th>"+
												   "<th data-field='desc'>Description</th>"+
												   "<th data-field='rate'>Rate</th>"+
												   "<th data-field='basis'>Basis</th>"+
											   "</tr>"+
										   "</thead>"+
									   "</table>"
								      );
				$.each(data, function(index, value){
					$("#"+index).remove();
				});

				$.each(data, function(index, value){
					checked = value.Checked;
					$("#add_taxtable").append("<tr>"+
												"<td><div id='"+index+"' class='addchecktax'></div></td>"+
												"<td>"+value.Code+"</td>"+
												"<td>"+value.itemtax+"</td>"+
												"<td>"+value.Rate+"</td>"+
												"<td>"+value.Basis+"</td>"+
										  	  "</tr>"
										  	 );
					if(checked){
						$("#"+index).jqxCheckBox({ width: 120, height: 25, checked: true});
					}
					$("#"+index).jqxCheckBox({ width: 120, height: 25 });

				});
				AddTaxDefer.resolve();
			},
			error: function(){
				AddTaxDefer.reject();
				alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
			}
		});
		return AddTaxDefer.promise();
	}
	/*
	function Chkbox(elemid){
		$("#"+elemid).bind('change', function (event) {
			var checked = event.args.checked;
			var value;
			var itemIDChk = $("#itemunique").val();
			if (checked) {
				value = 1;
				click_check_box(itemIDChk, elemid, value);
			} else {
				value = 0;
				click_check_box(itemIDChk, elemid, value);
			}
		});
	}
	*/
	function Chkbox(elemid){
		$("#_update").attr("disabled",false);
	}
	/*
	function click_check_box(unique, elementid, val){
		$.ajax({
			url: SiteRoot+'backoffice/checkedbox',
			type: 'post',
			data: {itemid : unique, taxid : elementid, status: val},
			dataType:"json",
			success: function(data){
				if(data.success == true){
					console.log("success");
				}
			},
			error:function(){
				alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
			}
		})
	}
	*/
	
	/*
	function adj_load_location(){
		var adjlocationdef = $.Deferred();
		var locationid = location_selected;
		$.ajax({
			url: SiteRoot+'backoffice/load_stores',
			type: 'post',
			dataType:"json",
			success: function(data){
				$("#_adj_location").html("<option value='0'>ALL LOCATION</option>");
				$.each(data, function(index, value){
					$("#_adj_location").append("<option value='"+index+"'>"+value.description+"</option>");
				});

				var mylist = $('#_adj_location');
					var listitems = mylist.children('option').get();
					listitems.sort(function(a, b) {
					   return $(a).text().toUpperCase().localeCompare($(b).text().toUpperCase());
					});
				$.each(listitems, function(idx, itm) { mylist.append(itm); });

				adjlocationdef.resolve();
			}
		});
		return adjlocationdef.promise();
	}
	*/

	function main_location(){
		var mainlocationdef = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/load_stores',
			type: 'post',
			dataType:"json",
			success: function(data){
				$("#_main_location").html("<option value='0'>All LOCATION</option>");
				$.each(data, function(index, value){
					$("#_main_location").append("<option value='"+index+"'>"+value.description+"</option>");
				});
				mainlocationdef.resolve();
			}
		});
		return mainlocationdef.promise();
	}


	function add_save_new_item(){
		var addsavenewdefer = $.Deferred();
		var addlistprice, price1, price2, price3, price4, price5 = 0;
		var addcheckboxitem = [];
		var adduncheckboxitem = [];
		var additemnumber = encodeURIComponent($("#add_itemnumber").val());
		var addpartnumber = encodeURIComponent($("#add_partnumber").val());
		var adddescription = encodeURIComponent($("#add_description").val());
		var addsupplier = $("#add_supplier").val();
		var addbrand = $("#add_brand").val();
		var addsupplierpart = $("#add_supplierpart").val();
		var addcategory = $("#add_maincat").val();
		var addsubcategory = $("#add_subcat").val();
		 addlistprice = $("#add_price").val();
		 price1 = $("#add_saleprice").val();
		 price2 = $("#add_price2").val();
		 price3 = $("#add_price3").val();
		 price4 = $("#add_price4").val();
		 price5 = $("#add_price5").val();
		var addcost = $("#add_cost").val();
		var addcostextra = $("#add_costextra").val();
		var addcostfreight = $("#add_costfreight").val();
		var addcostduty = $("#add_costduty").val();
		var addqty = $("#add_qtyaddremove").val();
		var addtransdate = $("#addjqxWidgetDate").val();
		var addtranstime = $("#jqxWidgetTime").val();
		var addlocationid = $("#add_location").val();
		var addqtycomment = $("#add_qtycomment").val();
		var addbarcode = $("#addnewbarcode").val();

		if($("#add_cost").val() == ''){
			addcost=0;
		}
		if($("#add_costextra").val() == ''){
			addcostextra=0;
		}
		if($("#add_costduty").val() == ''){
			addcostduty=0;
		}
		if($("#add_costfreight").val() == ''){
			addcostfreight=0;
		}
		if($("#add_qtyaddremove").val() == ''){
			addqty=0;
		}
		if($("#add_price").val() == ''){
			addlistprice = 0;
		}
		if($("#add_saleprice").val() == ''){
			price1 = 0;
		}
		if($("#add_price2").val() == ''){
			price2 = 0;
		}
		if($("#add_price3").val() == ''){
			price3 = 0;
		}
		if($("#add_price4").val() == ''){
			price4 = 0;
		}
		if($("#add_price5").val() == ''){
			price5 = 0;
		}

		var post_data="itemnumber="+additemnumber;
			post_data+="&partnumber="+addpartnumber;
			post_data+="&description="+adddescription;
			post_data+="&supplier="+addsupplier;
			post_data+="&brand="+addbrand;
			post_data+="&supplierpart="+addsupplierpart;
			post_data+="&category="+addsubcategory;
			post_data+="&price="+addlistprice;
			post_data+="&price1="+price1;
			post_data+="&price2="+price2;
			post_data+="&price3="+price3;
			post_data+="&price4="+price4;
			post_data+="&price5="+price5;
			post_data+="&cost="+addcost;
			post_data+="&costextra="+addcostextra;
			post_data+="&costfreight="+addcostfreight;
			post_data+="&costduty="+addcostduty;
			post_data+="&quantity="+addqty;
			post_data+="&transdate="+addtransdate;
			post_data+="&transtime="+addtranstime;
			post_data+="&locationid="+addlocationid;
			post_data+="&mainlocationid="+location_selected;
			post_data+="&qtycomment="+addqtycomment;
			post_data+="&barcode="+addbarcode;


		$.each($(".addchecktax"), function(){
			var elemid = this.id;
			var checked = $("#"+elemid).val();
			if (checked) {
				addcheckboxitem.push(elemid);
			}else{
				adduncheckboxitem.push(elemid);
			}
		});

		post_data+="&taxchecked="+addcheckboxitem;
		post_data+="&taxunchecked="+adduncheckboxitem;
		$.ajax({
			url: SiteRoot+'backoffice/save_item',
			type: 'post',
			data: post_data,
			dataType: 'json',
			success: function(data){
				if(data.success == true){
					$("#add_btnscd").hide();
					$("#add_confirmation_msg").show();
					$("#addsavedmymessage").html("Do you want to add another new item?");
					$("#add_confirmation_after_save").show();
					$("#add_message").text("New Item saved.");
					confirmation_message();
				}
				addsavenewdefer.resolve();
			},
			error: function(){
				addsavenewdefer.reject();
				alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
			}
		})
		return addsavenewdefer.promise();
	}

	function add_save_yes_new_item(){
		var addsaveyesnewdefer = $.Deferred();

		var addcheckboxitem = [];
		var adduncheckboxitem = [];
		var additemnumber = $("#add_itemnumber").val();
		var addpartnumber = $("#add_partnumber").val();
		var adddescription = $("#add_description").val();
		var addsupplier = $("#add_supplier").val();
		var addbrand = $("#add_brand").val();
		var addsupplierpart = $("#add_supplierpart").val();
		var addcategory = $("#add_maincat").val();
		var addsubcategory = $("#add_subcat").val();
		var addprice = $("#add_price").val();
		var addcost = $("#add_cost").val();
		var addcostextra = $("#add_costextra").val();
		var addcostfreight = $("#add_costfreight").val();
		var addcostduty = $("#add_costduty").val();
		var addqty = $("#add_qtyaddremove").val();
		var addtransdate = $("#addjqxWidgetDate").val();
		var addtranstime = $("#jqxWidgetTime").val();
		var addlocationid = $("#add_location").val();
		var addqtycomment = $("#add_qtycomment").val();

		if($("#add_cost").val() == ''){
			addcost=0;
		}
		if($("#add_costextra").val() == ''){
			addcostextra=0;
		}
		if($("#add_costduty").val() == ''){
			addcostduty=0;
		}
		if($("#add_costfreight").val() == ''){
			addcostfreight=0;
		}
		if($("#add_price").val() == ''){
			addprice=0;
		}
		if($("#add_qtyaddremove").val() == ''){
			addqty=0;
		}

		var post_data="itemnumber="+additemnumber;
			post_data+="&partnumber="+addpartnumber;
			post_data+="&description="+adddescription;
			post_data+="&supplier="+addsupplier;
			post_data+="&brand="+addbrand;
			post_data+="&supplierpart="+addsupplierpart;
			post_data+="&category="+addsubcategory;
			post_data+="&price="+addprice;
			post_data+="&cost="+addcost;
			post_data+="&costextra="+addcostextra;
			post_data+="&costfreight="+addcostfreight;
			post_data+="&costduty="+addcostduty;
			post_data+="&quantity="+addqty;
			post_data+="&transdate="+addtransdate;
			post_data+="&transtime="+addtranstime;
			post_data+="&locationid="+addlocationid;
			post_data+="&mainlocationid="+location_selected;
			post_data+="&qtycomment="+addqtycomment;


		$.each($(".addchecktax"), function(){
			var elemid = this.id;
			var checked = $("#"+elemid).val();
			if (checked) {
				addcheckboxitem.push(elemid);
			}else{
				adduncheckboxitem.push(elemid);
			}
		});

		post_data+="&taxchecked="+addcheckboxitem;
		post_data+="&taxunchecked="+adduncheckboxitem;

		if(additemnumber == "" || addpartnumber == ""){
			alert("Please fill out all required fields.");
		}else{
			$.ajax({
				url: SiteRoot+'backoffice/save_item',
				type: 'post',
				data: post_data,
				dataType: 'json',
				success: function(data){
					if(data.success == true){
						$("add_btnscd").show();
						$("#add_message").text("New Item saved.");
						confirmation_message();
					}
					addsaveyesnewdefer.resolve();
				},
				error: function(){
					addsaveyesnewdefer.reject();
					alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
				}
			})
		}

		return addsaveyesnewdefer.promise();
	}

	function show_hide(){
		$("#add_msg").hide();
		$("#add_btnscd").show();
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
<?php
	//echo $breadcrumb;
	$decimalprice = number_format(0, $price);
	$decimalcost = number_format(0, $cost);
	$decimalqty = number_format(0, $quantity);
?>
<input type="hidden" id="decimalprice" value="<?php echo $price; ?>" />
<input type="hidden" id="decimalcost" value="<?php echo $cost; ?>" />
<input type="hidden" id="decimalqty" value="<?php echo $quantity; ?>" />
<input type="hidden" id="itemunique" value="" />
<div id="InventoryController" ng-controller="demoController">
	<div class="container-fluid">
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <nav class="navbar navbar-default" role="navigation" style="background:#CCC;">
					<!--
                     <div class="col-md-2">
                     	<div style="padding-top:10px;">
                     		<select id="_main_location" class="form-control"></select>
                     	</div>
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
                                    <a style="outline:0;" id="_addnew">
                                        <span class="icon-32-new"></span>
                                        New
                                    </a>
                                </li>
                            </ul>
                        </div><!-- /.navbar-collapse -->
                     </div>
            	</nav>
            	</nav>
            </div>
            <div class="row">
                <!--<ngx-grid-view ngx-watch="gridSettings.disabled" ngx-on-row-double-click="rowDoubleClick(event)" ngx-settings="gridSettings"></ngx-grid-view>-->
				<jqx-data-table id="table" jqx-watch="gridSettings.disabled" jqx-on-row-double-click="rowDoubleClick(event)" jqx-settings="gridSettings"></jqx-data-table>
                <jqx-window jqx-on-close="close()" id="edit-form" jqx-create="dialogSettings" jqx-settings="dialogSettings" style="display:none;">
                    <div>Edit Dialog</div>
                    <div id="editform">
                        <div style="overflow: hidden;">
                            <div class="col-md-12 col-md-offset-0" id="table" style="float:left;">
                                <jqx-tabs id="aktabs" jqx-width="'100%'" jqx-height="'100%'" style="float: left;" jqx-theme="thetabs" jqx-settings="tabset" jqx-selected-item="selectedItem" jqx-on-tabclick="tabclick($event)">
                                    <ul style="margin-left: 30px;">
                                        <li>Item</li>
                                        <li>Cost</li>
										<li>Prices</li>
                                        <li>Stock Level</li>
                                        <li>Tax</li>
                                        <li ng-click="BarcodeTab()">Barcode</li>
                                    </ul>
                                    <div class="col-md-12 col-md-offset-0 tabs" id="tab1" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;"><!--/Tab1/-->
                                    <!--<label style="color:#F00;">Required Field <span class="required">*</span></label>-->
                                    <input type="hidden" name="submitted" id="submitted" value="1">
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="inputType" class="col-sm-3 control-label">Item Number:</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control itemelement" id="itemnumber" name="itemnumber" placeholder="Item Number" autofocus>
                                            </div>
                                            <span class="required edit_itemnumber_message">*</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="inputType" class="col-sm-3 control-label">Barcode:</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control itemelement" id="partnumber" name="partnumber" placeholder="Barcode">
                                            </div>
                                            <span class="required edit_barcode_message">*</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="inputType" class="col-sm-3 control-label">Description:</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control itemelement" id="description" name="description" placeholder="Description">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="inputType" class="col-sm-3 control-label">Supplier:</label>
                                            <div class="col-sm-4">
                                            	<!--
                                                <select id="supplier" class="itemelement" style="width:100%;">
                                                    <option value="">Select Supplier</option>
                                                </select>
                                                -->
												<jqx-combo-box id="supplier" jqx-on-select="selectHandlerSupplier(event)" jqx-settings="comboboxSettingsSupplier"></jqx-combo-box>
                                            </div>
                                            <span class="edit_sel_supplier_message" style="color:#F00;"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="inputType" class="col-sm-3 control-label">Supplier Part:</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control itemelement" id="supplierpart" name="supplierpart" placeholder="Supplier Part Number">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="inputType" class="col-sm-3 control-label">Brand:</label>
                                            <div class="col-sm-4">
                                            <!--
                                                <select name="brand" id="brand" class="itemelement" style="width:100%;">
                                                    <option value="">Select Brand</option>
                                                </select>
                                             -->  
                                             <jqx-combo-box id="brand" jqx-on-select="selectHandlerBrand(event)" jqx-settings="comboboxSettingsBrand"></jqx-combo-box> 
                                            </div>
                                            <span class="edit_sel_brand_message" style="color:#F00;"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="inputType" class="col-sm-3 control-label">Category:</label>
                                            <div class="col-sm-4">
                                             <!--
                                                <select name="maincat" id="maincat" class="itemelement" style="width:100%;">
                                                    <option value="">Select Category</option>
                                                </select>
                                                 -->
                                                <jqx-combo-box id="maincat" jqx-on-select="selectHandlerCategory(event)" jqx-settings="comboboxSettingsCategory"></jqx-combo-box> 
                                            </div>
                                            <span class="edit_sel_category_message" style="color:#F00;"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="inputType" class="col-sm-3 control-label">Sub Category:</label>
                                            <div class="col-sm-4">
                                            	<!--
                                                <select name="subcat" id="subcat" style="width:100%;"></select>
                                            	-->
                                                <jqx-combo-box id="subcat" jqx-on-select="selectHandlerSubCat(event)" jqx-settings="comboboxSettingsSubCat"></jqx-combo-box> 
                                            </div>
                                            <span class="edit_sel_subcat_message" style="color:#F00;"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="inputType" class="col-sm-3 control-label">List Price:</label>
                                            <div class="col-sm-4">
                                                <!--<input type="text" class="form-control" id="price" name="price" value="" placeholder="Price">-->
                                                <div class="input-group">
                                                  <span class="input-group-addon">$</span>
                                                  <?php /*<input type="text" id="price" name="price" class="form-control itemelement price" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalprice; ?>" value="">*/ ?>
												  <jqx-number-input id="price" jqx-width="80" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="EditInventoryChange()" ng-model="price.amount"></jqx-number-input>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group">
                                            <label for="inputType" class="col-sm-3 control-label">Sell Price:</label>
                                            <div class="col-sm-4">
                                                <!--<input type="text" class="form-control" id="price" name="price" value="" placeholder="Price">-->
                                                <div class="input-group">
                                                  <span class="input-group-addon">$</span>
                                                  <?php /*<input type="text" id="saleprice" name="saleprice" class="form-control itemelement price" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalprice; ?>" value=""> */?>
												  <jqx-number-input id="saleprice" jqx-width="80" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="EditInventoryChange()" ng-model="saleprice.amount"></jqx-number-input>
												</div>
                                            </div>
                                        </div>
                                    </div>
                                    </div><!--/End Tab1/-->

                                    <div class="col-md-12 col-md-offset-0 tabs" id="tab2" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;"><!--/Tab2/-->
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-3 control-label">Cost:</label>
                                                <div class="col-sm-4">
                                                     <div class="input-group">
                                                      <span class="input-group-addon">$</span>
                                                      <?php /*<input type="text" id="cost" name="cost" class="form-control itemelement cost" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalcost; ?>" value="">*/ ?>
													  <jqx-number-input id="cost" jqx-width="90" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="EditInventoryChange()" ng-model="cost.amount"></jqx-number-input>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-3 control-label">Cost Extra:</label>
                                                <div class="col-sm-4">
                                                     <div class="input-group">
                                                      <span class="input-group-addon">$</span>
                                                      <?php /*<input type="text" id="costextra" name="costextra" class="form-control itemelement cost" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalcost; ?>" value="">*/ ?>
													  <jqx-number-input id="costextra" jqx-width="90" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="EditInventoryChange()" ng-model="costextra.amount"></jqx-number-input>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-3 control-label">Cost Freight:</label>
                                                <div class="col-sm-4">
                                                     <div class="input-group">
                                                      <span class="input-group-addon">$</span>
                                                      <?php /*<input type="text" id="costfreight" name="costfreight" class="form-control itemelement cost" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalcost; ?>" value="">*/?>
													  <jqx-number-input id="costfreight" jqx-width="90" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="EditInventoryChange()" ng-model="costfreight.amount"></jqx-number-input>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-3 control-label">Cost Duty:</label>
                                                <div class="col-sm-4">
                                                     <div class="input-group">
                                                      <span class="input-group-addon">$</span>
                                                      <?php /*<input type="text" id="costduty" name="costduty" class="form-control itemelement cost" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalcost; ?>" value="">*/ ?>
													  <jqx-number-input id="costduty" jqx-width="90" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="EditInventoryChange()" ng-model="costduty.amount"></jqx-number-input>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-3 control-label">Cost Landed:</label>
                                                <div class="col-sm-4">
                                                     <div class="input-group">
                                                      <span class="input-group-addon">$</span>
                                                      <?php /*<input type="text" id="costlanded" name="costlanded" class="form-control itemelement" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalcost; ?>" value="" disabled>*/ ?>
													  <jqx-number-input id="costlanded" jqx-width="90" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="EditInventoryChange()" ng-disabled="coslandedDisabled" ng-model="costlanded.amount"></jqx-number-input>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--/End Tab2/-->
									<div class="col-md-12 tabs" id="tab3" style="padding-top:10px;  padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;"> <!--Tab3-->
										<div class="col-md-12 col-md-offset-0 tabs" id="tab2" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;"><!--/Tab2/-->
											<div class="row">
												<div class="form-group">
													<label for="inputType" class="col-sm-3 control-label">List Price:</label>
													<div class="col-sm-4">
														<div class="input-group">
															<span class="input-group-addon">$</span>
															<?php /*<input type="text" id="listprice" name="listprice" class="form-control itemelement cost" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalcost; ?>" value="" disabled>*/ ?>
															<jqx-number-input id="listprice" jqx-width="90" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="EditInventoryChange()" ng-disabled="coslandedDisabled" ng-model="listprice.amount"></jqx-number-input>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="form-group">
													<label for="inputType" class="col-sm-3 control-label">Price1:</label>
													<div class="col-sm-4">
														<div class="input-group">
															<span class="input-group-addon">$</span>
															<?php /*<input type="text" id="price1" name="price1" class="form-control itemelement cost" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalcost; ?>" value="" disabled> */?>
															<jqx-number-input id="price1" jqx-width="90" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="EditInventoryChange()" ng-disabled="coslandedDisabled" ng-model="price1.amount"></jqx-number-input>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="form-group">
													<label for="inputType" class="col-sm-3 control-label">Price2:</label>
													<div class="col-sm-4">
														<div class="input-group">
															<span class="input-group-addon">$</span>
															<?php /*<input type="text" id="price2" name="price2" class="form-control itemelement cost" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalcost; ?>" value=""> */?>
															<jqx-number-input id="price2" jqx-width="90" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="EditInventoryChange()"  ng-model="price2.amount"></jqx-number-input>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="form-group">
													<label for="inputType" class="col-sm-3 control-label">Price3:</label>
													<div class="col-sm-4">
														<div class="input-group">
															<span class="input-group-addon">$</span>
															<?php /*<input type="text" id="price3" name="price3" class="form-control itemelement cost" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalcost; ?>" value="" >*/ ?>
															<jqx-number-input id="price3" jqx-width="90" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="EditInventoryChange()"  ng-model="price3.amount"></jqx-number-input>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="form-group">
													<label for="inputType" class="col-sm-3 control-label">Price4:</label>
													<div class="col-sm-4">
														<div class="input-group">
															<span class="input-group-addon">$</span>
															<?php /*<input type="text" id="price4" name="price4" class="form-control itemelement" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalcost; ?>" value=""> */ ?>
															<jqx-number-input id="price4" jqx-width="90" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="EditInventoryChange()"  ng-model="price4.amount"></jqx-number-input>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="form-group">
													<label for="inputType" class="col-sm-3 control-label">Price5:</label>
													<div class="col-sm-4">
														<div class="input-group">
															<span class="input-group-addon">$</span>
															<?php /*<input type="text" id="price5" name="price5" class="form-control itemelement" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalcost; ?>" value=""> */ ?>
															<jqx-number-input id="price5" jqx-width="90" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="EditInventoryChange()" ng-model="price5.amount"></jqx-number-input>
														</div>
													</div>
												</div>
											</div>
										</div><!--/End Tab3/-->
									</div><!--/End Tab Prices/-->
                                    <div class="col-md-12 tabs" id="tab4" style="padding-top:10px; height: 400px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;"> <!--Tab4-->
                                        <div class="row">
                                        	<div class="col-md-8">
                                                <div class="form-group">
                                                   <div class="top_stockqty_display">
                                                        <button class="btn btn-primary" id="adjustqty"><img src="<?php echo base_url("assets/img/kahon.png")?>" /></button>
                                                        Adjust Quantity
                                                   </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                   <div>
                                                        <!--<select id="_adj_location" class="" style="width:100%;"></select>-->
                                                        <jqx-combo-box id="_adj_location" jqx-on-select="selectHandlerADJLocation(event)" jqx-settings="comboBoxADJLocationSettings"></jqx-combo-box>
                                                   </div>
                                                </div>
                                            </div>
                                        </div>
                                        <form id="_adjqty" style="display:none; cursor:default;">
                                        	<div class="col-md-11">
                                                <div class="row" id="_adjustqty">
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <label for="inputType" class="col-sm-6 control-label" style="text-align:right">Current Quantity in Stock:</label>
                                                            <div class="col-sm-3">
                                                            	  <?php /*
                                                                  <input type="text" id="_qtyinstock" name="_qtyinstock" class="form-control stock" value="" placeholder="<?php echo $decimalqty?>" disabled />
                                                                  */?>
                                                                  <div id='_qtyinstock'></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <label for="inputType" class="col-sm-6 control-label" style="text-align:right">Quantity to Add or Remove:</label>
                                                            <div class="col-sm-3">
                                                            	  <?php /*
                                                                  <input type="text" id="_qtyaddremove" name="_qtyaddremove" class="form-control stklevel stock" placeholder="<?php echo $decimalqty?>">
																  */?>
                                                                  <div id='_qtyaddremove' class="stklevel"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <label for="inputType" class="col-sm-6 control-label" style="text-align:right">New Quantity:</label>
                                                            <div class="col-sm-3">
                                                            	  <?php /*	
                                                                  <input type="text" id="_newqty" name="_newqty" class="form-control stklevel stock" value="" placeholder="<?php echo $decimalqty?>">
																  */?>
                                                                  <div id='_newqty'></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <label for="inputType" class="col-sm-6 control-label" style="text-align:right">Transaction Date:</label>
                                                            <div class="col-sm-3">
                                                                  <div id='jqxWidgetDate'></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <label for="inputType" class="col-sm-6 control-label" style="text-align:right">Transaction Time:</label>
                                                            <div class="col-sm-3">
                                                                  <div id='jqxWidgetTime'></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <label for="inputType" class="col-sm-6 control-label" style="text-align:right">Location:</label>
                                                            <div class="col-sm-3">
                                                                  <!--<select id="_location" name="_location" class="stklevel" style="width:100%;"></select>-->
                                                                 <jqx-combo-box id="_location" jqx-on-select="selectHandlerADJQTYLocation(event)" jqx-settings="comboBoxADJQTYLocationSettings"></jqx-combo-box> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                    	<div class="container-fluid">
                                                        	<div class="row">
                                                            	<div class="col-md-9" align="right">
                                                                 	<label for="inputType" class="col-sm-6 control-label" style="text-align:left">Comment:</label>
                                                                </div>
                                                                <div class="col-md-9 col-md-offset-1">
                                                                  <textarea id="_qtycomment" class="form-control" cols="5" rows="3"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row" id="stkbtns">
                                                            <div class="col-md-10" align="right">
                                                                <!--<button type="button" id="_new" class="btn btn-success btn-lg">New</button>-->
                                                                <button type="button" id="_adjsave" class="btn btn-primary" disabled>Save</button>
                                                                <button	type="button" id="_adjcancel" class="btn btn-warning">Close</button>
                                                            </div>
                                                    </div>
                                                    <div class="row">
                                                        <div id="msgstklevel" style="display:none; margin-top:10px; overflow:auto;">
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    Would you like to save your changes.
                                                                    <button type="button" id="_stkyes" class="btn btn-primary">Yes</button>
                                                                    <button type="button" id="_stkno" class="btn btn-warning">No</button>
                                                                    <button type="button" id="_stkcancel" class="btn btn-info">Cancel</button>
                                                                </div>
                                                            </div>
                                                       </div>
                                                   </div>
                                                </div>
                                            </div>
                                       </form>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div id="stocklevel" style="overflow:auto; height:auto;">
                                                        <jqx-data-table id="gridStock" jqx-settings="gridStockSettings"></jqx-data-table>
                                                    </div>
                                                </div>
                                            </div>
                                    </div><!--/End Tab4/-->

                                    <div class="col-md-12 tabs" id="tab5" style="padding-top:10px;  padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;"> <!--Tab4-->
                                        <div class="row">
                                        	<div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label for="inputType" class="col-sm-3 control-label">Tax:</label>
                                                    </div>
                                                 </div>
                                                 <div class="form-group">
                                                    <div class="row">
                                                        <div id="itemtax"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--/End Tab5/-->
                                    <div class="col-md-12 tabs" id="tab6" style="padding-top:10px;  padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;"> <!--Tab6-->
                                     <div class="row">
                                        	<div class="col-sm-12">
                                                 <div class="form-group">
                                                    <div class="row">
                                                        <div id="itembarcode" style="width:40%; float:left;">
                                                        	<input type="text" class="form-control" focus-me="barcodefocus" ng-enter="EnterBarcode()" placeholder="Enter Barcode" ng-model="barcode.wsearch" id="barcodesearch"/>
                                                        </div>
                                                        <div id="functions" style="width:40%; float:left; margin-left:10px;">
                                                        	<button ng-click="AddBarcode()" class="btn btn-primary">Add</button>
                                                            <button ng-click="EditBarcode()" class="btn btn-warning">Update</button>
                                                            <button ng-click="DeleteBarcode()" class="btn btn-danger">Delete Barcode</button>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row" style="margin-top:10px;">
                                                        	<div style="margin-bottom:5px; font-size:16px;"><strong>Barcode(s)</strong></div>
                                                            <div style="width:100%; border:2px solid #06F;">
                                                                <div class="item-barcode {{selected}}" ng-repeat="barcodes in barcodelist" style="font-size:15px; font-weight: bolder;  border:1px solid #999;" ng-click="setSelected(barcodes.Unique, barcodes.Barcode)">{{barcodes.Barcode}}</div>
                                                            </div>
                                                        </div>
                                                 	</div>
                                                    <input type="hidden" ng-model="BarcodeUnique" />
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--/End Tab5/-->
                               </jqx-tabs>
                            </div><!--/End col-md-12/-->
                            <div class="col-md-12 col-md-offset-0">
                                <div class="row">
                                    <div id="del_confirmation_msg" style="display:none; margin-top:10px; overflow:auto;">
                                        <div class="form-group">
                                            <div class="col-sm-11">
                                                <p id="delmymessage"></p>
                                            </div>
                                        </div>
                                   </div>
                                </div>
                                <div class="row">
                                    <div id="confirmation_msg" style="display:none; margin-top:10px; overflow:auto;">
                                        <div class="form-group">
                                            <div class="col-sm-11">
                                                <label id="mymessage"></label>
                                            </div>
                                        </div>
                                   </div>
                                </div>
                                <div class="row">
                                    <div id="_btnscd">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button type="button" id="_update" class="btn btn-primary" disabled>Save</button>
                                                <button	type="button" id="_cancel" class="btn btn-warning">Close</button>
                                                <button type="button" id="_delcancel" class="btn btn-warning" style="display:none;">Close</button>
                                                <button	type="button" id="_delete" class="btn btn-danger">Delete</button>
                                                <button	type="button" id="_restore" class="btn btn-success" style="display:none;">Restore</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="msg" style="display:none; margin-top:10px; overflow:auto;">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                Would you like to save your changes.
                                                <button type="button" id="_yes" class="btn btn-primary">Yes</button>
                                                <button type="button" id="_no" class="btn btn-warning">No</button>
                                                <button type="button" id="_conf_cancel" class="btn btn-info">Cancel</button>
                                            </div>
                                        </div>
                                   </div>
                                   <div id="msg_delete" style="display:none; margin-top:10px; overflow:auto;">
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
                        <!--
                        <div class="taskbar">
                        	<div style="width:84%; float:left;">
                                 <p id="message"></p>
                            </div>
                        </div>
                        -->
                  	</div><!--/End editform/-->
                </jqx-window>
                <jqx-window jqx-on-close="close()" id="add-form" jqx-create="addialogSettings" jqx-settings="addialogSettings" style="display:none;">
                	<div>Add New Item</div>
                    <div id="addform">
                    	<div style="overflow: hidden;">
                            <div class="col-md-12 col-md-offset-0" id="table_add" style="float:left;">
                                <jqx-tabs jqx-width="'100%'" jqx-height="'100%'" style='float: left;' jqx-theme="thetabsadd" jqx-settings="tabsSettings" jqx-selected-item="selectedItem">
                                    <ul style="margin-left: 30px;">
                                        <li>Item</li>
                                        <li>Cost</li>
										<li>Prices</li>
                                        <li>Stock Level</li>
                                        <li>Tax</li>
                                        <li>Barcode</li>
                                    </ul>
                                    <div class="col-md-12 col-md-offset-0 tabs" id="addtab1" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;"><!--/Tab1/-->
                                    	<!--<label style="color:#F00;">Required Field <span class="required">*</span></label>-->
                                        <input type="hidden" name="submitted" id="submitted" value="1">
                                        <div class="row addnewitem">
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-3 control-label">Item Number:</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control additemelement" id="add_itemnumber" name="add_itemnumber" placeholder="Item Number" autofocus>
                                                </div>
                                                <span class="required add_itemnumber_message">*</span>
                                            </div>
                                        </div>
                                        <div class="row addnewitem">
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-3 control-label">Barcode:</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control additemelement" id="add_partnumber" name="add_partnumber" placeholder="Barcode">
                                                </div>
                                                <span class="required add_barcode_message">*</span>
                                            </div>
                                        </div>
                                        <div class="row addnewitem">
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-3 control-label">Description:</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control additemelement" id="add_description" name="description" placeholder="Description">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row addnewitem">
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-3 control-label">Supplier:</label>
                                                <div class="col-sm-4">
                                                	<!--
                                                    <select id="add_supplier" name="add_supplier" class="additemelement" style="width:100%;">
                                                        <option value="">Select Supplier</option>
                                                    </select>
                                                    -->
                                                    <jqx-combo-box id="add_supplier" jqx-on-select="selectHandlerAddSupplier(event)" jqx-settings="comboboxSettingsAddSupplier"></jqx-combo-box> 
                                                </div>
                                                <span class="add_sel_supplier_message" style="color:#F00;"></span>
                                            </div>
                                        </div>
                                        <div class="row addnewitem">
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-3 control-label">Supplier Part:</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control additemelement" id="add_supplierpart" name="add_supplierpart" placeholder="Supplier Part Number">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row addnewitem">
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-3 control-label">Brand:</label>
                                                <div class="col-sm-4">
                                                	<!--
                                                    <select name="add_brand" id="add_brand" class="additemelement" style="width:100%;">
                                                        <option value="">Select Brand</option>
                                                    </select>
                                                    -->
                                                    <jqx-combo-box id="add_brand" jqx-on-select="selectHandlerAddBrand(event)" jqx-settings="comboboxSettingsAddBrand"></jqx-combo-box> 
                                                </div>
                                                <span class="add_sel_brand_message" style="color:#F00;"></span>
                                            </div>
                                        </div>
                                        <div class="row addnewitem">
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-3 control-label">Category:</label>
                                                <div class="col-sm-4">
                                                	<!--
                                                    <select name="add_maincat" id="add_maincat" class="additemelement" style="width:100%;">
                                                        <option value="">Select Category</option>
                                                    </select>
                                                    -->
                                                    <jqx-combo-box id="add_maincat" jqx-on-select="selectHandlerAddCategory(event)" jqx-settings="comboboxSettingsAddCategory"></jqx-combo-box> 
                                                </div>
                                                <span class="add_sel_category_message" style="color:#F00;"></span>
                                            </div>
                                        </div>
                                        <div class="row addnewitem">
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-3 control-label">Sub Category:</label>
                                                <div class="col-sm-4">
                                                	<!--
                                                    <select name="add_subcat" id="add_subcat" style="width:100%;" class="additemelement">
                                                        <option value="">Select Sub Category</option>
                                                    </select>
                                                    -->
                                                    <jqx-combo-box id="add_subcat" jqx-on-select="selectHandlerAddSubCat(event)" jqx-settings="comboboxSettingsAddSubCat"></jqx-combo-box> 
                                                </div>
                                                <span class="add_sel_subcat_message" style="color:#F00;"></span>
                                            </div>
                                        </div>
										<div class="row">
											<div class="form-group">
												<label for="inputType" class="col-sm-3 control-label">List Price:</label>
												<div class="col-sm-4">
													<div class="input-group">
														<span class="input-group-addon">$</span>
														<?php /*<input type="text" id="add_price" name="add_price" class="form-control additemelement price" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalprice; ?>" value=""> */ ?>
														<jqx-number-input id="add_price" jqx-width="80" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="AddInventoryChange()" ng-model="add_price.amount"></jqx-number-input>
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="form-group">
												<label for="inputType" class="col-sm-3 control-label">Sell Price:</label>
												<div class="col-sm-4">
													<!--<input type="text" class="form-control" id="price" name="price" value="" placeholder="Price">-->
													<div class="input-group">
														<span class="input-group-addon">$</span>
														<?php /*<input type="text" id="add_saleprice" name="add_saleprice" class="form-control additemelement price" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalprice; ?>" value=""> */ ?>
														<jqx-number-input id="add_saleprice" jqx-width="80" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="AddInventoryChange()" ng-model="add_saleprice.amount"></jqx-number-input>
													</div>
												</div>
											</div>
										</div>
                                    </div>
                                    <div class="col-md-12 col-md-offset-0 tabs" id="addtab2" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;"><!--/Tab2/-->
                                    	<div class="row addnewitem">
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-3 control-label">Cost:</label>
                                                <div class="col-sm-4">
                                                     <div class="input-group">
                                                      <span class="input-group-addon">$</span>
                                                      <?php /*<input type="text" id="add_cost" name="add_cost" class="form-control additemelement cost" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalcost; ?>" value=""> */ ?>
													  <jqx-number-input id="add_cost" jqx-width="90" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="AddInventoryChange()" ng-model="add_cost.amount"></jqx-number-input>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row addnewitem">
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-3 control-label">Cost Extra:</label>
                                                <div class="col-sm-4">
                                                     <div class="input-group">
                                                      <span class="input-group-addon">$</span>
                                                      <?php /*<input type="text" id="add_costextra" name="add_costextra" class="form-control additemelement cost" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalcost; ?>" value="">*/ ?>
													  <jqx-number-input id="add_costextra" jqx-width="90" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="AddInventoryChange()" ng-model="add_costextra.amount"></jqx-number-input>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row addnewitem">
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-3 control-label">Cost Freight:</label>
                                                <div class="col-sm-4">
                                                     <div class="input-group">
                                                      <span class="input-group-addon">$</span>
                                                      <?php /*<input type="text" id="add_costfreight" name="add_costfreight" class="form-control additemelement cost" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalcost; ?>" value="">*/ ?>
													  <jqx-number-input id="add_costfreight" jqx-width="90" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="AddInventoryChange()" ng-model="add_costfreight.amount"></jqx-number-input>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row addnewitem">
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-3 control-label">Cost Duty:</label>
                                                <div class="col-sm-4">
                                                     <div class="input-group">
                                                      <span class="input-group-addon">$</span>
                                                      <?php /*<input type="text" id="add_costduty" name="add_costduty" class="form-control additemelement cost" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalcost; ?>" value="">*/ ?>
													  <jqx-number-input id="add_costduty" jqx-width="90" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="AddInventoryChange()" ng-model="add_costduty.amount"></jqx-number-input>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row addnewitem">
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-3 control-label">Cost Landed:</label>
                                                <div class="col-sm-4">
                                                     <div class="input-group">
                                                      <span class="input-group-addon">$</span>
                                                      <?php /*<input type="text" id="add_costlanded" name="add_costlanded" class="form-control additemelement" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalcost; ?>" value="" disabled>*/ ?>
													  <jqx-number-input id="add_costlanded" jqx-width="90" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="AddInventoryChange()" ng-model="add_costlanded.amount" ng-disabled="AddInventoryDisabled"></jqx-number-input>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<!--Tab3 Prices-->
									<div class="col-md-12 col-md-offset-0 tabs" id="addtab3" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;"><!--/Tab3/-->
										<div class="row">
											<div class="form-group">
												<label for="inputType" class="col-sm-3 control-label">List Price:</label>
												<div class="col-sm-4">
													<div class="input-group">
														<span class="input-group-addon">$</span>
														<?php /*<input type="text" id="add_listprice" name="add_listprice" class="form-control" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalcost; ?>" value="" disabled>*/ ?>
														<jqx-number-input id="add_listprice" jqx-width="90" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="AddInventoryChange()" ng-model="add_listprice.amount" ng-disabled="AddInventoryDisabled"></jqx-number-input>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="form-group">
												<label for="inputType" class="col-sm-3 control-label">Price1:</label>
												<div class="col-sm-4">
													<div class="input-group">
														<span class="input-group-addon">$</span>
														<?php /*<input type="text" id="add_price1" name="add_price1" class="form-control additemelement cost" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalcost; ?>" value="" disabled>*/ ?>
														<jqx-number-input id="add_price1" jqx-width="90" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="AddInventoryChange()" ng-model="add_price1.amount" ng-disabled="AddInventoryDisabled"></jqx-number-input>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="form-group">
												<label for="inputType" class="col-sm-3 control-label">Price2:</label>
												<div class="col-sm-4">
													<div class="input-group">
														<span class="input-group-addon">$</span>
														<?php /*<input type="text" id="add_price2" name="add_price2" class="form-control additemelement cost" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalcost; ?>" value="">*/ ?>
														<jqx-number-input id="add_price2" jqx-width="90" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="AddInventoryChange()" ng-model="add_price2.amount"></jqx-number-input>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="form-group">
												<label for="inputType" class="col-sm-3 control-label">Price3:</label>
												<div class="col-sm-4">
													<div class="input-group">
														<span class="input-group-addon">$</span>
														<?php /*<input type="text" id="add_price3" name="add_price3" class="form-control additemelement cost" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalcost; ?>" value=""> */ ?>
														<jqx-number-input id="add_price3" jqx-width="90" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="AddInventoryChange()" ng-model="add_price3.amount"></jqx-number-input>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="form-group">
												<label for="inputType" class="col-sm-3 control-label">Price4:</label>
												<div class="col-sm-4">
													<div class="input-group">
														<span class="input-group-addon">$</span>
														<?php /*<input type="text" id="add_price4" name="add_price4" class="form-control additemelement cost" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalcost; ?>" value="">*/ ?>
														<jqx-number-input id="add_price4" jqx-width="90" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="AddInventoryChange()" ng-model="add_price4.amount"></jqx-number-input>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="form-group">
												<label for="inputType" class="col-sm-3 control-label">Price5:</label>
												<div class="col-sm-4">
													<div class="input-group">
														<span class="input-group-addon">$</span>
														<?php /*<input type="text" id="add_price5" name="add_price5" class="form-control additemelement cost" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $decimalcost; ?>" value="">*/ ?>
														<jqx-number-input id="add_price5" jqx-width="90" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-change="AddInventoryChange()" ng-model="add_price5.amount"></jqx-number-input>
													</div>
												</div>
											</div>
										</div>
									</div><!--/End Tab Prices/-->
                                    <div class="col-md-12 col-md-offset-0 tabs" id="addtab4" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;"><!--/Tab3/-->
                                    	<div class="form-group">
                                              <form id="add_qty" style="cursor:default;">
                                                <div class="col-md-11">
                                                    <div class="row" id="_adjustqty">
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <label for="inputType" class="col-sm-6 control-label" style="text-align:right">Current Quantity in Stock:</label>
                                                                <div class="col-sm-3">
                                                                	<?php /*
                                                                      <input type="text" id="add_qtyinstock" name="add_qtyinstock" class="form-control stock" placeholder="<?php echo $decimalqty?>" value="" disabled />
																	  */?>
                                                                      <div id="add_qtyinstock"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <label for="inputType" class="col-sm-6 control-label" style="text-align:right">Quantity to Add or Remove:</label>
                                                                <div class="col-sm-3">
                                                                	<?php /*
                                                                      <input type="text" id="add_qtyaddremove" name="add_qtyaddremove" class="form-control additemelement stock" placeholder="<?php echo $decimalqty?>" value="">
																	  */?>
                                                                      <div id="add_qtyaddremove"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <label for="inputType" class="col-sm-6 control-label" style="text-align:right">New Quantity:</label>
                                                                <div class="col-sm-3">
                                                                	<?php /*	
                                                                      <input type="text" id="add_newqty" name="add_newqty" class="form-control additemelement stock" placeholder="<?php echo $decimalqty?>" value="">
																	  */?>
                                                                      <div id="add_newqty"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <label for="inputType" class="col-sm-6 control-label" style="text-align:right">Transaction Date:</label>
                                                                <div class="col-sm-4">
                                                                      <div id='addjqxWidgetDate'></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <label for="inputType" class="col-sm-6 control-label" style="text-align:right">Transaction Time:</label>
                                                                <div class="col-sm-4">
                                                                      <div id='addjqxWidgetTime'></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <label for="inputType" class="col-sm-6 control-label" style="text-align:right">Location:</label>
                                                                <div class="col-sm-3">
                                                                      <!--<select id="add_location" name="add_location" class="form-control stklevel"></select>-->
                                                                     <jqx-combo-box id="add_location" jqx-on-select="selectHandlerAddADJLocation(event)" jqx-settings="comboBoxAddADJLocationSettings"></jqx-combo-box> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="container-fluid">
                                                                <div class="row">
                                                                    <div class="col-md-9" align="right">
                                                                        <label for="inputType" class="col-sm-6 control-label" style="text-align:left">Comment:</label>
                                                                    </div>
                                                                    <div class="col-md-9 col-md-offset-1">
                                                                      <textarea id="add_qtycomment" class="form-control" cols="5" rows="3"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                           </form>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-md-offset-0 tabs" id="addtab5" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;"><!--/Tab4/-->
                                    	<div class="row addnewitem">
                                        	<div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label for="inputType" class="col-sm-3 control-label">Tax:</label>
                                                    </div>
                                                 </div>
                                                 <div class="form-group">
                                                    <div class="row">
                                                        <div id="add_itemtax"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 tabs" id="addtab6" style="padding-top:10px;  padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;"> <!--Tab5-->
                                     <div class="row">
                                        	<div class="col-sm-12">
                                                 <div class="form-group">
                                                    <div class="row">
                                                    	<div style="width:10%; float:left;"><strong>Barcode: </strong></div>
                                                        <div id="itembarcode" style="width:40%; float:left;">
                                                        	<input type="text" class="form-control" focus-me="barcodefocus" placeholder="Enter Barcode" id="addnewbarcode"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--/End Tab5/-->
                                </jqx-tabs>
                                <!--Add New  / Buttons-->
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
                                        <!--
                                        <div class="row">
                                            <div id="add_confirmation_msg" style="display:none; margin-top:10px; overflow:auto;">
                                                <div class="form-group">
                                                    <div class="col-sm-11">
                                                        <label id="addmymessage"></label>
                                                    </div>
                                                </div>
                                           </div>
                                        </div>
                                        -->
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
                                <!--Add New  / Buttons-->
                         	</div>
                        </div>
                        <!--
                        <div class="add_taskbar">
                            <div style="width:84%; float:left;">
                                 <p id="add_message"></p>
                            </div>
                        </div>
                        -->
                    </div>
                </jqx-window>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
	body{
		padding:0;
		margin:0;
		padding-bottom: 60px;
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

	input.search-query {
		padding-left:26px;
	}
	form.form-search {
		position: relative;
	}
	form.form-search:before {
		display: block;
		width: 14px;
		height: 14px;
		content: "\e003";
		font-family: 'Glyphicons Halflings';
		background-position: -48px 0;
		position: absolute;
		top:8px;
		left:8px;
		opacity: .5;
		z-index: 1000;
	}

	.required{
		color:#F00;
	}

	.modal-backdrop {
	  z-index: -1;
	}

	.ngx-icon-close{
		display:none;
	}

	.checktax{
		width:30px !important;
	}

	.addnewitem{
		margin-top:5px;
	}

	#edit-form{
		-webkit-border-radius: 15px 15px 15px 15px;
		border-radius: 15px 15px 15px 15px;
		border: 5px solid #449bca;
		height:75% !important;
	}

	#ngxTabs0{
		-webkit-border-radius: 20px 20px 20px 20px;
		border-radius: 20px 20px 20px 20px;
	}

	#add-form{
		-webkit-border-radius: 15px 15px 15px 15px;
		border-radius: 15px 15px 15px 15px;
		border: 5px solid #449bca;
		height:75% !important;
	}

	#ngxTabs1{
		-webkit-border-radius: 20px 20px 20px 20px;
		border-radius: 20px 20px 20px 20px;
	}

	.taskbar{
		overflow: auto;
		bottom: 0px;
        height: 30px;
        width: 100%;
		position:absolute;
		left:0px;
	}

	.add_taskbar{
		overflow: auto;
		bottom: 0px;
        height: 30px;
        width: 100%;
		position:absolute;
		left:0px;
	}

	.selected .item-barcode{
	   background-color: rgb(252, 248, 227);
	}

	.selected {
		-moz-box-shadow:    inset 0 0 10px #000000;
		-webkit-box-shadow: inset 0 0 10px #000000;
		box-shadow:         inset 0 0 0px #000000;
	}

	.item-barcode{
		cursor: pointer;
	}

</style>
<!--/
	ngx-window-close-button ngx-window-close-button-darkblue ngx-icon-close ngx-icon-close-darkblue
/-->
