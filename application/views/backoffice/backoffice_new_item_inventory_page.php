<?php echo jqxplugindatetime(); ?>
<script type="text/javascript">
	//Global Variable
	var SiteRoot = "<?php echo base_url();?>";
	
	$(function(){
	   changetabtile();
	   $("#subcat").select2(); 
	   $.when(supplier()).then(function(){
			$("#brand").select2();
		   $.when(brand()).then(function(){
				$("#maincat").select2();
			   $.when(maincat()).then(function(){
				   $.when(load_tax()).done(function(){});  
			   })	  
		   })  
	   })
	   $("#maincat").on("change",function(){
	   		subcat();
	   })
	   
	   $("#itemnumber").on('keyup', function() {
			$("#partnumber").val($(this).val());
			$("#supplierpart").val($(this).val());
	   });
	   
	   $("#_save").click(function(){
			var checkboxitem = [];
			var itemnumber = $("#itemnumber").val();
			var partnumber = $("#partnumber").val();
			var description = $("#description").val();
			var supplier = $("#supplier").val();
			var supplierpart = $("#supplierpart").val();
			var brand = $("#brand").val();
			var category = $("#maincat").val();
			var subcategory = $("#subcat").val();
			var cost = $("#cost").val();
			var price = $("#price").val();
			var quantity = $("#quantity").val();
			
			var post_data="itemnumber="+itemnumber;
				post_data+="&partnumber="+partnumber;
				post_data+="&description="+description;
				post_data+="&supplier="+supplier;
				post_data+="&supplierpart="+supplierpart;
				post_data+="&brand="+brand;
				post_data+="&maincat="+category;
				post_data+="&subcat="+subcategory;
				post_data+="&cost="+cost;
				post_data+="&price="+price;
				post_data+="&quantity="+quantity;
			
			$.each($(".checktax"), function(){
				var elemid = this.id;
				var checked = $("#"+elemid).val();
				if (checked) {
					checkboxitem.push(elemid);
					console.log(checkboxitem);					
				}	
			})
				
			post_data+="&taxchecked="+checkboxitem;	
				
			if(itemnumber == '' || partnumber == ''){
				alert('Please fill out the required fields');
			}else{
				
				$.ajax({
					url: SiteRoot+'backoffice/save_new_item',
					type: 'post',
					data: post_data,
					dataType: 'json',
					success: function(data){
						if(data.success == true){
							custom_alert_message_save();
						}
					},
					error: function(){
						alert("Sorry, Error Encountered\nPlease try again or contact support.");
					}
				})
				
			}
		})
	})
	
	function changetabtile(){
		$("#tabtitle").html("New Item");
	}
	
	
	function supplier(){
		var supplierdefer = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/supplier',
			type: 'post',
			dataType:'json',
			success: function(data){
				$("#supplier").html("<option value=''>Select Supplier</option>");
				$.each(data, function(index, value){
					$("#supplier").append("<option value="+index+">"+value.supplier+"</option>");
				})
				supplierdefer.resolve();
			},
			error: function(){
				alert("Sorry, we encouter a technical difficulties\nPlease try again later.");
			}
		})
		$("#supplier").select2();
		return supplierdefer.promise();
	}
	
	function brand(){
		var branddefer = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/brand',
			type:'post',
			dataType:'json',
			success: function(data){
				$("#brand").html("<option value=''>Select Brand</option>");
				$.each(data, function(index, value){
					$("#brand").append("<option value='"+index+"'>"+value.brand+"</option>");
				})
				branddefer.resolve();	
			},
			error: function(){
				alert("Sorry, we encouter a technical difficulties\nPlease try again later.");
			}
		})
		branddefer.promise();
	}
	
	function maincat(){
		var maincatdefer = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/maincat',
			type: 'post',
			dataType:"json",
			success: function(data){
				$("#maincat").html("<option value=''>Select Category</option>");
				$.each(data, function(index, value){
					$("#maincat").append("<option value='"+index+"'>"+value.maincat+"</option>");
				})
				maincatdefer.resolve();
			},
			error: function(){
				alert("Sorry, we encouter a technical difficulties\nPlease try again later.");
			}
		})
		maincatdefer.promise();
	}
	
	function subcat(){
		var subcatdefer = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/subcat',
			type: 'post',
			data: { maincatid : $("#maincat").val() },
			dataType:"json",
			success: function(data){
				$("#subcat").html("<option value=''>Select SubCategory</option>");
				$.each(data, function(index, value){
					$("#subcat").append("<option value='"+index+"'>"+value.subcat+"</option>");
				})
				subcatdefer.resolve();
			},
			error: function(){
				alert("Sorry, we encouter a technical difficulties\nPlease try again later.");
			}
		})
		return subcatdefer.promise();
	}
	
	function callmain(){
		custom_alert_message_cancel();
	}
	
	function custom_alert_message_save(){
		BootstrapDialog.confirm({
            title: 'AK | Message',
            message: 'New Item saved. Do you want to add another new item?',
            type: BootstrapDialog.TYPE_WARNING, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
            closable: false, // <-- Default value is false
            draggable: false, // <-- Default value is false
            btnCancelLabel: 'Yes', // <-- Default value is 'Cancel',
            btnOKLabel: 'No', // <-- Default value is 'OK',
            btnOKClass: 'btn-warning', // <-- If you didn't specify it, dialog type will be used,
            callback: function(result) {
                // result will be true if button was click, while it will be false if users close the dialog directly.
                if(result) {
					var url=SiteRoot+'backoffice/inventory';
                    window.location = url;
                }else {
					var url=SiteRoot+'backoffice/inventory/new';
                    window.location = url;
                }
            }
        });
	}
	
	
	function custom_alert_message_cancel(){
		BootstrapDialog.confirm({
            title: 'AK | Message',
            message: 'Are you sure you want to cancel?',
            type: BootstrapDialog.TYPE_WARNING, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
            closable: false, // <-- Default value is false
            draggable: false, // <-- Default value is false
            btnCancelLabel: 'Yes', // <-- Default value is 'Cancel',
            btnOKLabel: 'No', // <-- Default value is 'OK',
            btnOKClass: 'btn-warning', // <-- If you didn't specify it, dialog type will be used,
            callback: function(result) {
                // result will be true if button was click, while it will be false if users close the dialog directly.
                if(result) {
					
                }else {
					var url=SiteRoot+'backoffice/inventory';
                    window.location = url;
                }
            }
        });
	}
	
	function load_tax(){
		var taxdefer = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/load_tax',
			type: 'post',
			dataType:"json",
			success: function(data){
				var checked;
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
					checked = value.Checked;
					
					$("#taxtable").append("<tr>"+
												"<td><div id='"+index+"' class='checktax'></div></td>"+
												"<td>"+value.Code+"</td>"+
												"<td>"+value.itemtax+"</td>"+
												"<td>"+value.Rate+"</td>"+
												"<td>"+value.Basis+"</td>"+
										  "</tr>");
					if(checked){
						$("#"+index).jqxCheckBox({ width: 120, height: 25, checked: true});
					}					  
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
	
</script>
<?php 
	echo $breadcrumb; 
	$costdecimals = number_format(0, $cost);
	$pricedecimals = number_format(0, $price);
	$quantitydecimals = number_format(0, $quantity);
?>
<div class="container-fluid">
	<div class="col-md-12 col-md-offset-0">
    	<h4 class="nav-header" style="color:#999;">New Item</h4>
        <label style="color:#F00;">Required Field <span class="required">*</span></label>
        <?php $attributes = array('name'=>'frmnewitem', 'class'=>'form-horizantal');?>
        <?php echo form_open('backoffice/newitem', $attributes)?>
        	<input type="hidden" name="submitted" id="submitted" value="1">
            <div class="row">
                <div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label" style="text-align:right">Item Number:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="itemnumber" name="itemnumber" placeholder="Item Number" autofocus>
                    </div>
                    <span class="required">*</span>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label" style="text-align:right">Barcode:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="partnumber" name="partnumber" placeholder="Barcode">
                    </div>
                    <span class="required">*</span>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label" style="text-align:right">Description:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description">
                    </div>
                </div>
            </div>
            <div class="row">
            	<div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label" style="text-align:right">Supplier:</label>
                    <div class="col-sm-4">
                        <select id="supplier" style="width:100%;">
                        	<option value="">Select Supplier</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
            	<div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label" style="text-align:right">Supplier Part:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="supplierpart" name="supplierpart" placeholder="Supplier Part Number">
                    </div>            
                </div>
            </div>
            <div class="row">
            	<div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label" style="text-align:right">Brand:</label>
                    <div class="col-sm-4">
                        <select name="brand" id="brand" style="width:100%;">
                        	<option value="">Select Brand</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
            	<div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label" style="text-align:right">Category:</label>
                    <div class="col-sm-4">
                        <select name="maincat" id="maincat" style="width:100%;">
                        	<option value="">Select Category</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label" style="text-align:right">Sub Category:</label>
                    <div class="col-sm-4">
                        <select name="subcat" id="subcat" style="width:100%;">
                        	<option value="">Select Sub-Category</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
            	<div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label" style="text-align:right">Cost:</label>
                    <div class="col-sm-4">
                        <!--<input type="text" class="form-control" value="" placeholder="Cost">-->
                         <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input type="text" id="cost" name="cost" class="form-control" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $costdecimals;?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            	<div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label" style="text-align:right">Price:</label>
                    <div class="col-sm-4">
                        <!--<input type="text" class="form-control" id="price" name="price" value="" placeholder="Price">-->
                        <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input type="text" id="price" name="price" class="form-control" aria-label="Amount (to the nearest dollar)" placeholder="<?php echo $pricedecimals?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            	<div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label" style="text-align:right">Quantity:</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="quantity" name="quantity" value="" placeholder="Quantity">
                    </div>
                </div>
            </div>
            <div class="row">
            	<div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label" style="text-align:right">Tax:</label>
                    <div class="col-sm-4">
                        <div id="itemtax"></div>
                    </div>
				</div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-sm-5 page-header">
                            <!--<button type="button" id="_new" class="btn btn-success btn-lg">New</button>-->
                            <button type="button" id="_save" class="btn btn-primary btn-lg">Save</button>
                            <button	type="button" onClick="callmain()" class="btn btn-warning btn-lg">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <?php if(@$error):?>
                <div class="alert alert-danger col-sm-3" role="alert">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    <?php echo $error;?>
                </div>
            <?php endif;?> 
        </div>
    </div>   
</div>
<style>
	body{
		margin:0;
		padding:0;
	}
	.required{
		color:#F00;
	}
	
	.control-label{
		color:#999;
	}
	.row{
		margin:0.5em;
	}
	.checktax{
		width:30px !important;
	}
</style>