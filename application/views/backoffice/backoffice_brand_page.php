<?php
	//angularplugins();
	//angulartheme_arctic();
	//angulartheme_metrodark();
	//angulartheme_darkblue();
	brandangular();
	//jqxplugindatetime();
	jqxangularjs();
	jqxthemes();
?>
<script type="text/javascript">
	var SiteRoot = "<?php echo base_url()?>";
	var brandid;
	var global_brandid;
	var global_brandname;
	
	$(function(){
		changetabtile();
	});
	
	function changetabtile(){
		$("#tabtitle").html("Brand");
	}
	
//###############################################################################################################################################################//
																	//@ AngularJS Controller @//	
	
	var demoApp = angular.module("demoApp", ['jqwidgets']);
	demoApp.controller("demoController", function ($scope, $compile) {
		
		$scope.dialogSettings =
		{
			created: function(args)
			{
				dialog = args.instance;
			},
			resizable: false,
			width: "100%", height: 360,
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
			width: "100%", height: 360,
			autoOpen: false,
			theme: 'darkblue',
			isModal: true,
			showCloseButton: false
		}	
		
		
//###############################################################################################################################################################//
																	//@ Save Brand @//			
		$("#add_save").click(function(){
			$('#add_jqxNotification').jqxNotification('closeAll');
			var process1 = false;
			if($("#add_brandname").val() == ''){
				$("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
				$("#add_notificationContent").html("Brand is required field");
				$("#add_jqxNotification").jqxNotification("open");
				$("#add_company").css({"border-color":"#f00"});
				process1 = false;
			}else{
				$("#add_brandname").css({"border-color":"#ccc"});
				process1 = true;
			}
			
			if(process1 == true){
				$.when(add_brand_info()).done(function(){
					$scope.$apply(function(){
						$scope.tabsSettings = {};
					});
					$scope.$apply(function(){
						$scope.tabsSettings = {
							selectedItem: 0
						}
					})
					$("#add_save_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "success" });
					$("#add_save_notificationContent").html("New Brand Saved.");
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
		
		
//################################################################################################################################################################//
																	//@ After Save Yes @//		
		$("#add_aftersave_yes").click(function(){
			add_reset_form();
			$scope.$apply(function(){
				$scope.tabsSettings = {};
			});
			$scope.$apply(function(){
				$scope.tabsSettings = {
					selectedItem: 0
				}
			});
			
			$("#table").jqxDataTable('updateBoundData');
			
			$("#add_confirmation_after_save").hide();
			$("#addsavedmymessage").html("");
			$("#add_btnscd").show();
			$("#add_save").attr("disabled", true);
		});

//################################################################################################################################################################//
																	//@ After Save No @//				
		$("#add_aftersave_no").click(function(){
			$("#table").jqxDataTable('updateBoundData');
			
			$scope.settings ={
				selectedItem: 0
			};
			
			addialog.close();
			
			add_reset_form();
			$("#add_confirmation_after_save").hide();
			$scope.$apply(function(){
				$scope.tabsSettings = {};
			});
			$scope.$apply(function(){
				$scope.tabsSettings = {
					selectedItem: 0
				}
			})
		});

//################################################################################################################################################################//
																	//@ Add Another Brand Yes @//		
		   
		   $("#add_yes").click(function(){
			   $('#add_jqxNotification').jqxNotification('closeAll');
				var process1 = false;
				if($("#add_brandname").val() == ''){
					$("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
					$("#add_notificationContent").html("Brand is required field");
					$("#add_jqxNotification").jqxNotification("open");
					$("#add_company").css({"border-color":"#f00"});
					process1 = false;
				}else{
					$("#add_brandname").css({"border-color":"#ccc"});
					process1 = true;
				}
				
				if(process1 == true){
					$.when(add_brand_info()).done(function(){});
					
					$("#add_save_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "success" });
					$("#add_save_notificationContent").html("New Brand Saved.");
					$("#add_save_jqxNotification").jqxNotification("open");
					
					$("#add_msg").hide();
					$("#add_btnscd").hide();
				
				}else{
					$scope.$apply(function(){
						$scope.tabsSettings = {};
					});
					$scope.$apply(function(){
						$scope.tabsSettings = {
							selectedItem: 0
						}
					})
					$("#add_brandname").focus();
				}
		   });
//################################################################################################################################################################//
																	//@ Add Another Brand No @//		
		   $("#add_no").click(function(){
				add_reset_form();
				addialog.close();
				$scope.$apply(function(){
					$scope.tabsSettings = {};
				});
				$scope.$apply(function(){
					$scope.tabsSettings = {
						selectedItem: 0
					}
				})	
		   });
//################################################################################################################################################################//
																	//@ Add Another Brand Cancel @//		   
		   $("#add_conf_cancel").click(function(){
				$("#add_msg").hide();
				$("#add_btnscd").show();
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
				$("#add_brandname").focus();
		   });
//################################################################################################################################################################//
																	//@ Open Popup Brand Form @//		
		$("#_addnew").on("click", function(){
			checkAnyFormFieldAdd();
			$scope.$apply(function(){
				$scope.selectedItem = 0;
			});
			addialog.open();
			add_reset_form();
			setTimeout(function(){
				$("#add_brandname").focus();
			}, 200);
		});
//################################################################################################################################################################//
																	//@ Cancel Add Brand @//			
		$("#add_cancel").click(function(){
			//$("#add_message").text("");
			var addsavebtn = $("#add_save").is(":disabled");
			if(addsavebtn){
				add_reset_form();
				$scope.$apply(function(){
					addialog.close();
					$scope.selectedItem = 0;
				});
				$scope.$apply(function(){
					$scope.tabsSettings = {};
				});
				$scope.$apply(function(){
					$scope.tabsSettings = {
						selectedItem: 0
					}
				})
				setTimeout(function(){
					$("#table input.jqx-input").focus();
				},500);
			}else{
				var process1 = false;
				if($("#add_brandname").val() == ''){
					$("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
					$("#add_notificationContent").html("Brand Name is required field");
					$("#add_jqxNotification").jqxNotification("open");
					$("#add_brandname").css({"border-color":"#f00"});
					process1 = false;
				}else{
					$("#add_brandname").css({"border-color":"#ccc"});
					process1 = true;
				}
				
				if(process1 == true){
					$('#addtab1').block({message: null});
					$('#addtab2').block({message: null});
				}else{
					$scope.$apply(function(){
						$scope.tabsSettings = {};
					});
					$scope.$apply(function(){
						$scope.tabsSettings = {
							selectedItem: 0
						}
					});
					$("#add_brandname").focus();
				}
				
				$("#add_msg").show();
				$("#add_btnscd").hide();
			}
		});
//################################################################################################################################################################//
																	//@ Cancel Edit Brand No @//			

		$("#_no").click(function(){
			dialog.close();
			reset_form();
			$scope.$apply(function(){
				$scope.tabset = {};
			});
			$scope.$apply(function(){
				$scope.tabset = {
					selectedItem: 0
				}
			})
		});
//################################################################################################################################################################//
																	//@ Cancel Edit Brand Yes @//		
		$("#_yes").click(function(){
			$('#add_jqxNotification').jqxNotification('closeAll');
				var process1 = false;
				if($("#brandname").val() == ''){
					$("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
					$("#edit_notificationContent").html("Brand is required field");
					$("#edit_jqxNotification").jqxNotification("open");
					$("#brandname").css({"border-color":"#f00"});
					process1 = false;
				}else{
					$("#brandname").css({"border-color":"#ccc"});
					process1 = true;
				}
				
				if(process1 == true){
					$.when(update_brand_info()).then(function(){
						$("#table").jqxDataTable('updateBoundData');
						$scope.$apply(function(){
							$scope.tabset = {};
						});
						$scope.$apply(function(){
							$scope.tabset = {
								selectedItem: 0
							}
						})
						dialog.close();
					});
					$("#msg").hide();
					$("#_btnscd").show();
					$('#tab1').unblock(); 
					$('#tab2').unblock();
				}else{
					$scope.$apply(function(){
						$scope.tabset = {};
					});
					$scope.$apply(function(){
						$scope.tabset = {
							selectedItem: 0
						}
					})
				}
		});
//################################################################################################################################################################//
																	//@ Cancel Edit Brand @//
		$("#_conf_cancel").click(function(){
			$('#tab1').unblock(); 
			$('#tab2').unblock(); 
			$("#msg").hide();
			$("#_btnscd").show();
			$scope.$apply(function(){
				$scope.tabset = {};
			});
			$scope.$apply(function(){
				$scope.tabset = {
					selectedItem: 0
				}
			})
			$("#brandname").focus();
		});
		
		
		$("#_delete").click(function(){
			var brandname = $("#brandname").val();
			$("#_btnscd").hide();
			$("#msg_delete").show();
			$("#delmsg").text("Would you like to delete "+brandid+" "+brandname+"?");
			$("#tab1").block({message: null});
			$("#tab2").block({message: null});
		});
		
		
		$("#_delyes").click(function(){
			$.when(delete_process()).then(function(){
				$("#_btnscd").show();
				$("#_restore").show();
				$("#_delete").hide();
				$("#_cancel").hide();
				$("#_deletecancel").show();
				
			});
		});
		
		$("#_delno").click(function(){
			$("#tab1").unblock();
			$("#tab2").unblock();
			$("#msg_delete").hide();
			$("#_btnscd").show();
			$("#delmsg").text("");
			$("#brandname").focus();
		});
		
		
		$("#_restore").click(function(){
			$.when(restore_process()).done(function(){
				$("#edit_restore_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "success" });
				$("#edit_restore_notificationContent").html("Brand restored");
				$("#edit_restore_jqxNotification").jqxNotification("open");
				
				$("#del_confirmation_msg").hide();
				$("#delmymessage").text("");
				$("#_restore").hide();
				$("#_delete").show();
				$("#_delete").attr("disabled",false);
				$("#tab1").unblock();
				$("#tab2").unblock();
				$("#brandname").focus();
				$("#_cancel").show();
				$("#_deletecancel").hide();		
			})	
		});
		
		$("#_deletecancel").click(function(){
			$("#table").jqxDataTable('updateBoundData');
			reset_form();
			dialog.close();
			setTimeout(function(){
				$("#table input.jqx-input").focus();
			},500);
		})
		
		
//################################################################################################################################################################//
																	//@ Update Brand @//
		$("#_update").click(function(){
			var process1 = false;
			if($("#brandname").val() == ''){
				$("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "info" });
				$("#edit_notificationContent").html("Brand Name is required field");
				$("#edit_jqxNotification").jqxNotification("open");
				$("#brandname").css({"border-color":"#f00"});
				process1 = false;
			}else{
				$("#brandname").css({"border-color":"#ccc"});
				process1 = true;
			}
			
			if(process1 == true){
				$.when(update_brand_info()).done(function(){
					$("#table").jqxDataTable('updateBoundData');
					$("#edit_save_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "success" });
					$("#edit_save_notificationContent").html("Brand Name Saved.");
					$("#edit_save_jqxNotification").jqxNotification("open");
				})
				$("#brandname").focus();
			}else{
				$scope.$apply(function(){
					$scope.tabset = {};
				});
				$scope.$apply(function(){
					$scope.tabset = {
						selectedItem: 0
					}
				})
				$("#brandname").focus();
			}
		});
		
//################################################################################################################################################################//
																	//@ Close Dialog Box @//
		$("#_cancel").click(function(){
			$("#message").html("");
			var changed = $("#_update").is(":disabled");
			if(changed){
				$('#tab1').unblock(); 
				$('#tab2').unblock();  
				reset_form();
				dialog.close();
				$scope.$apply(function(){
					$scope.tabsSettings = {};
				});
				$scope.$apply(function(){
					$scope.tabsSettings = {
						selectedItem: 0
					}
				})
				setTimeout(function(){
					$("#table input.jqx-input").focus();
				},500);
			}else{
				var process1 = false;
				if($("#brandname").val() == ''){
					$("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
					$("#edit_notificationContent").html("Brand Name is required field");
					$("#edit_jqxNotification").jqxNotification("open");
					$("#brandname").css({"border-color":"#f00"});
					process1 = false;
				}else{
					$("#brandname").css({"border-color":"#ccc"});
					process1 = true;
				}
				
				if(process1 == true){
				
					$('#tab1').block({message: null});
					$('#tab2').block({message: null});

				}else{
					$scope.$apply(function(){
						$scope.tabset = {};
					});
					$scope.$apply(function(){
						$scope.tabset = {
							selectedItem: 0
						}
					});
					$("#brandname").focus();
				}
				
				$("#_btnscd").hide();
				$("#msg").show();
				$("#msg_delete").hide();
			}
			
			$("#del_confirmation_msg").hide();
			$("#delmymessage").text("");
		});
		
				//################################################################################################################################################################//
															//# Load Brand List #//
		$scope.thetabs = 'darkblue';
		$scope.thetabsadd = 'darkblue';
		
		$scope.tabset = {
			selectedItem:0	
		};
		$scope.tabsSettings = {
			selectedItem:0
		};
			
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
					{ name: 'Brand', type: 'string'},
					{ name: 'Note', type: 'string'},
				],
				id: 'Unique',
				url: SiteRoot+"backoffice/load_brand"
			},
			columnsResize: true,
			width: "30%",
			height: 500,
			theme: 'arctic',
			sortable: true,
			pageable: true,
			pageSize: 15,
			pagerMode: 'default',
			altRows: true,
			filterable: true,
			filterMode: 'simple',
			ready: function () {
                    
            },
			columns: [
				{ text: 'ID', dataField: 'Unique', width: "30%" },
				{ text: 'Brand Name', dataField: 'Brand', width: "70%" },
		  ]
		};
		
		//################################################################################################################################################################//
																			/* Row RowDoubleClick */
		$scope.rowDoubleClick = function (event) {
			var args = event.args;
			var index = args.index;
			var row = args.row;
			reset_form();
			dialog.setTitle("Edit Brand ID: " + row.Unique + " |" + row.Brand);
			editRow = index;
			brandid = row.Unique;
			$("#brandid").val(row.Unique);
			$("#brandname").val(row.Brand);
			$("#note").val(row.Note);
			
			global_brandid = row.Unique;
			global_brandname = row.Brand;
				
			$scope.$apply(function(){
				$scope.selectedItem = 0;
			});
			
			setTimeout(function(){
				$("#brandname").focus();
			}, 200);
			checkAnyFormFieldEdited();
			dialog.open();
		}
		
	});
	/*End Angular JS*/
	
	var FilterCharacters = function(text){
		return encodeURIComponent(text);
	}
	
	function checkAnyFormFieldEdited() {
		$('.brand').keypress(function(e) { // text written
			enableSaveBtn();
		});
		
		$('.brand').keyup(function(e) {
			if (e.keyCode == 8 || e.keyCode == 46) { //backspace and delete key
				enableSaveBtn();
			} else { // rest ignore
				e.preventDefault();
			}
		});
		
		$('.brand').bind('paste', function(e) { // text pasted
			enableSaveBtn();
		});
	
		$('.brand').change(function(e) { // select element changed
			enableSaveBtn();
		});
	}
	
	function checkAnyFormFieldAdd() {
		$('.addbrand').keypress(function(e) { // text written
			enableAddSaveBtn();
		});
		
		$('.addbrand').keyup(function(e) {
			if (e.keyCode == 8 || e.keyCode == 46) { //backspace and delete key
				enableAddSaveBtn();
			} else { // rest ignore
				e.preventDefault();
			}
		});
		
		$('.addbrand').bind('paste', function(e) { // text pasted
			enableAddSaveBtn();
		});
	
		$('.addbrand').change(function(e) { // select element changed
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
		brandid="";
		$("#brandname").val("");
		$("#brandname").css({"border-color":"#ccc"});
		$("#note").val("");
		$('#tab1').unblock(); 
		$('#tab2').unblock(); 
		$("#msg").hide();
		$("#_btnscd").show();
		$("#_update").attr("disabled",true);
		$("#_delete").attr("disabled",false);
		$("#_restore").hide();
		$("#_delete").show();
		$("#delmsg").text("");
		$("#_cancel").show();
		$("#_deletecancel").hide();
	}
	
	function add_reset_form(){
		$("#add_brandname").val("");
		$("#add_brandname").css({"border-color":"#ccc"});
		$("#add_note").val("");
		$('#addtab1').unblock(); 
		$('#addtab2').unblock(); 
		$("#add_msg").hide();
		$("#add_btnscd").show();
		$("#add_save").attr("disabled", true);
		setTimeout(function(){
			$("#add_brandname").focus()
		}, 200);
	}

	function add_brand_info(){
		var addbrandDefer = $.Deferred();
		var brandname = FilterCharacters($("#add_brandname").val());
		var note = FilterCharacters($("#add_note").val());
		var post_data="brandname="+brandname;
			post_data+="&note="+note;
			
			$.ajax({
				url: SiteRoot+'backoffice/add_brand',
				type: 'post',
				data: post_data,
				dataType: 'json',
				success: function(data){
					if(data.success == true){
						$("#add_btnscd").hide();
						$("#add_confirmation_msg").show();
						$("#addsavedmymessage").html("Do you want to add another new Brand?");
						$("#add_confirmation_after_save").show();
						$('#addtab1').block({ message: null }); 
						$('#addtab2').block({ message: null }); 
						confirmation_message();
					}	
					addbrandDefer.resolve();
				},
				error: function(){
					addbrandDefer.reject();
					alert("Sorry, we encountered a technical difficulties\nPlease trya again later.");
				}
			})

		return addbrandDefer.promise();
	}
	
	function update_brand_info(){
		var brandupdateDefer = $.Deferred();
		var brandname = FilterCharacters($("#brandname").val());
		var note = FilterCharacters($("#note").val());
		var post_data="brandid="+brandid;
			post_data+="&brandname="+brandname;
			post_data+="&note="+note;
		
			$.ajax({
				url: SiteRoot+'backoffice/update_brand',
				type: 'post',
				data: post_data,
				dataType: 'json',
				success: function(data){
					if(data.success == true){
						//$("#message").text("Brand Information Updated.");
						$("#_update").attr("disabled", true);
						//$("#message").fadeIn();
						//$("#message").css({"color":"#5cb85c"});
						confirmation_message();		
					}
					brandupdateDefer.resolve();
				},
				error: function(){
					brandupdateDefer.reject();
					alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
				}
			})

		return brandupdateDefer.promise();
	}
	
	
	function delete_process(){
		var deferdeletebrand = $.Deferred();
		$.ajax({
			url: SiteRoot+"backoffice/branddelete",
			type: "post",
			data: {tbrandid : brandid},
			dataType:"json",
			success: function(data){
				if(data.success == true){
					$("#msg_delete").hide();
					//$("#message").text();
					//$("#message").fadeIn();
					//$("#message").css({"color":"#F00"});
					$("#edit_delete_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
					$("#edit_delete_jqxNotification").jqxNotification({"autoCloseDelay": 2000});
					$("#edit_delete_notificationContent").html(global_brandid+" "+global_brandname+" "+"marked for deletion. To finalize deletion, select CLOSE or select RESTORE to undo");
					$("#edit_delete_jqxNotification").jqxNotification("open");
					//confirmation_message();
				}
				deferdeletebrand.resolve();
			},
			error: function(){
				deferdeletebrand.reject();
				alert("Sorry, we encoutered a technical difficulties\nPlease try again later.");
			}
		});
		return deferdeletebrand.promise();
	}
	
	
	function restore_process(){
		var restoredefer = $.Deferred();
		$.ajax({
			url: SiteRoot+"backoffice/brandrestore",
			type: "post",
			data: {tbrandid : brandid},
			dataType:"json",
			success: function(data){
				if(data.success == true){
					$("#message").text("Brand Restored.");
					$("#message").fadeIn();
					$("#message").css({"color":"#5cb85c"});
					confirmation_message();
				}
				restoredefer.resolve();
			},
			error: function(){
				alert("Sorry, we encoutered a technical difficulties\nPlease try again later.");
			}
		});
		return restoredefer.promise();
	}
		
	function confirmation_message(){
		intervalclosemessage = 5000;
		setTimeout(function(){
			$("#message").text("");
			//$("#add_message").text("");
		}, intervalclosemessage);
	}


	$(function(){
		setTimeout(function(){
			$("#table input.jqx-input").focus();
		},1000)
	})
</script>
<input type="hidden" id="brandid" value="">
<div id="BrandController" ng-controller="demoController">
	<div class="container-fluid">
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <nav class="navbar navbar-default" role="navigation" style="background:#CCC;">
					<!--
                	 <div class="col-md-3">
                          <a class="navbar-brand" style="color: #146295;"><b>List of Brand:</b></a>
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
                        </div>
                     </div>
            	</nav>
            </div>
             <div class="row">
                <jqx-data-table id="table" jqx-watch="gridSettings.disabled" jqx-on-row-double-click="rowDoubleClick(event)" jqx-settings="gridSettings"></jqx-data-table>
                <jqx-window jqx-on-close="close()" id="brand-form" class="brand-form" jqx-create="dialogSettings" jqx-settings="dialogSettings" style="display:none;">
                	<div id="editform">
                        <div style="overflow: hidden;">
                            <div class="col-md-12 col-md-offset-0" id="table" style="float:left;">
                                <jqx-tabs jqx-width="'100%'" jqx-height="'100%'" style="float: left;" jqx-theme="thetabs" jqx-settings="tabset" jqx-selected-item="selectedItem">
                                    <ul style="margin-left: 30px;">
                                        <li>Info</li>
                                        <li>Note</li>
                                    </ul>
                  					<div class="col-md-12 col-md-offset-0 tabs" id="tab1" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height: 150px;">	
                                    <div class="row" style="width:100%;">
                                        <div class="col-md-12">	
                                            <input type="hidden" name="submitted" id="submitted" value="1">
                                            <div class="row">
                                            	<div style="float:left; padding:2px; width:100%;">
                                                    <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Brand Name:</div>
                                                    <div style="float:left; width:70%;">
                                                        <input type="text" class="form-control brand" id="brandname" name="brandname" placeholder="Brand Name" autofocus>
                                                    </div>
                                                    <div style="float:left;">
                                                        <span class="required">*</span>
                                                    </div>
                                                </div>
                                                <!--
                                                <div class="form-group">
                                                    <label for="inputType" class="col-sm-2 control-label">Brand Name:</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control brand" id="brandname" name="brandname" placeholder="Brand Name" autofocus>
                                                    	
                                                    </div>
                                                    <div class="col-sm-1">
                                                    	<span class="required">*</span>
                                                    </div>
                                                </div>
                                                -->
                                            </div>
                                        </div><!--End Grid 2-->
                                      </div><!--End Row-->
                                    </div><!--End tab 1-->
                                    <div class="col-md-12 col-md-offset-0 tabs" id="tab2" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height: 150px;">
                                    	<div class="row">
                                        	<div style="float:left; padding:2px; width:100%;">
                                                <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Note:</div>
                                                <div style="float:left; width:80%;">
                                                    <textarea rows="5" id="note" name="note" class="form-control brand" placeholder="Note"></textarea>
                                                </div>
                                            </div>
                                            <!--
                                            <div class="form-group">
                                                <label for="inputType" class="col-sm-2 control-label">Note:</label>
                                                <div class="col-sm-10">
                                                    <textarea rows="5" id="note" name="note" class="form-control brand" placeholder="Note"></textarea>
                                                </div>
                                            </div>
                                            -->
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
                                                <button type="button" id="_deletecancel" class="btn btn-warning" style="display:none;">Close</button>
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
                        <div id="edit_container" style="width: 400px; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
                        <div id="edit_save_jqxNotification">
                            <div id="edit_save_notificationContent"></div>
                        </div>
                         <div id="edit_delete_jqxNotification">
                            <div id="edit_delete_notificationContent"></div>
                        </div>
                        <div id="edit_restore_jqxNotification">
                            <div id="edit_restore_notificationContent"></div>
                        </div>
                        <!--
						<div style="width:84%; margin-top:20px; float:left;">
							<p id="message"></p>
						</div>
                        -->
						<!--
                        <div class="taskbar">
                        	<div style="width:84%; float:left;">
                                 <p id="message"></p>
                            </div>
                            <div style="width:15%; float:left; text-align:center; border-left: 3px solid #004a73;">
                                 <p>Edit Brand</p> 
                            </div>
                        </div>
                        -->
                   </div>
                </jqx-window>
                <jqx-window jqx-on-close="close()" id="brand-form" class="brand-form" jqx-create="addialogSettings" jqx-settings="addialogSettings" style="display:none;">
                	<div>Add New Brand</div>
                        <div id="addform">
                            <div id="addform_handler" style="overflow: hidden;">
                                <div class="col-md-12 col-md-offset-0" id="table_add" style="float:left;">
                                       <jqx-tabs jqx-width="'100%'" jqx-height="'100%'" style='float: left;' jqx-theme="thetabsadd" jqx-settings="tabsSettings" jqx-selected-item="selectedItem">
                                        <ul style="margin-left: 30px;">
                                            <li>Info</li>
                                            <li>Note</li>
                                        </ul>
                                     <div class="col-md-12 col-md-offset-0 tabs" id="addtab1" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height: 150px;">								
                                        <div class="row" style="width:100%;">
                                        	<div class="col-md-12">	
                                                <input type="hidden" name="submitted" id="submitted" value="1">
                                                <div class="row">
                                                    <div style="float:left; padding:2px; width:100%;">
                                                        <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Brand Name:</div>
                                                        <div style="float:left; width:70%;">
                                                            <input type="text" class="form-control addbrand" id="add_brandname" name="add_brandname" placeholder="Brand Name" autofocus>
                                                        </div>
                                                        <div style="float:left;">
                                                        	<span class="required">*</span>
                                                    	</div>
                                                    </div>
                                                </div>
                                            </div><!--End Grid2-->
                                        </div><!--End Grid Row-->
                                     </div><!--End Tab1-->  
                                     <div class="col-md-12 col-md-offset-0 tabs" id="addtab2" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;  height: 150px;">
                                        	<div class="row">
                                                <div style="float:left; padding:2px; width:100%;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Note:</div>
                                                    <div style="float:left; width:80%;">
                                                        <textarea rows="5" id="add_note" name="add_note" class="form-control addbrand" placeholder="Note"></textarea>
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
                                        	 <div id="add_confirmation_after_save" style="display:none; margin-top:5px; overflow:auto;">
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
                            <div id="add_container" style="width: 400px; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
                            <div id="add_save_jqxNotification">
                                <div id="add_save_notificationContent"></div>
                            </div>
                            <!--
							<div style="width:84%; magin-top:20px; float:left;">
								<p id="add_message"></p>
							</div>
                            -->
                        </div>
                  </jqx-window>
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
	
	.ngx-icon-close{
		display:none;
	}
	
	#brand-form{
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
</style>