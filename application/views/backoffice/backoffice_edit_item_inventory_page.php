<script type="application/javascript">
	var SiteRoot = "<?php echo base_url(); ?>";
	var subcatid ='';
	var subcatval = '';
	
	$(function(){
	   changetabtile();
	   $("#supplier").select2()
	   $("#brand").select2();
	   $("#maincat").select2();
	   $("#subcat").select2();
	   $("#maincat").on("change",function(){
		    subcatid = $(this).val();
	   		subcat();
	   })
	
		$.when(supplier()).then(function(){
			$('div.hdcontainer').block({ 
				message: '<h4>Fetching information<br/>Please wait...</h4>', 
				css: { border: '3px solid #a00' } 
			}); 
			$.when(brand()).then(function(){
				$.when(maincat()).then(function(){
					$.when(item_information()).then(function(){
						$.when(subcat()).done(function(value){
							$("#subcat").select2().select2('val', subcatval);
							$('div.hdcontainer').unblock();
						})
					})
				})
			})			 
		})
	})
	
	function changetabtile(){
		$("#tabtitle").html("Edit Item");
	}
	
	function item_information(){
		var deferiteminfo = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/item_information',
			type: 'post',
			data: {itemid: $("#itemid").val()},
			dataType: 'json',
			success: function(data){
				if(data.success == true){
					$("#itemnumber").val(data.itemnumber);
					$("#partnumber").val(data.partnumber);
					$("#description").val(data.description);
					$("#supplier").select2().select2('val', data.supplier);
					$("#supplierpart").val(data.supplierpart);
					$("#brand").select2().select2('val', data.brand);
					$("#maincat").select2().select2('val', data.category);
					$("#cost").val(data.cost);
					$("#price").val(data.price);
					$("#quantity").val(data.quantity);
					subcatid = data.category;
					subcatval = data.subcat;
					deferiteminfo.resolve();
				}	
			},
			error: function(){
				deferiteminfo.reject();
				alert("Sorry, we encounter a technical difficulties\nPlease try again later.");
			}
		})
		return deferiteminfo.promise();						
	}
	
	function supplier(){
		var defersupplier = $.Deferred();
		$.ajax({
				url: SiteRoot+'backoffice/supplier',
				type: 'post',
				dataType:'json',
				success: function(data){
					$("#supplier").html("<option value=''>Select Supplier</option>");
					$.each(data, function(index, value){
						$("#supplier").append("<option value="+index+">"+value.supplier+"</option>");
					})
					defersupplier.resolve();
				},
				error: function(){
					defersupplier.reject();
					alert("Sorry, we encouter a technical difficulties\nPlease try again later.");
				}
			})					
		return defersupplier.promise();					
	}
	
	function brand(){
		var deferbrand = $.Deferred();
		$.ajax({
				url: SiteRoot+'backoffice/brand',
				type:'post',
				dataType:'json',
				success: function(data){
					$("#brand").html("<option value=''>Select Brand</option>");
					$.each(data, function(index, value){
						$("#brand").append("<option value='"+index+"'>"+value.brand+"</option>");
					})	
					deferbrand.resolve();
				},
				error: function(){
					deferbrand.reject();
					alert("Sorry, we encouter a technical difficulties\nPlease try again later.");
				}
			})			
		return deferbrand.promise();
	}
	
	function maincat(){
		var defermaincat = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/maincat',
			type: 'post',
			dataType:"json",
			success: function(data){
				$("#maincat").html("<option value=''>Select Category</option>");
				$.each(data, function(index, value){
					$("#maincat").append("<option value='"+index+"'>"+value.maincat+"</option>");
				})
				defermaincat.resolve();
			},
			error: function(){
				defermaincat.reject();
				alert("Sorry, we encouter a technical difficulties\nPlease try again later.");
			}
		})				
		return defermaincat.promise();					
	}
	
	function subcat(){
		var defersubcat = $.Deferred();
		$.ajax({
			url: SiteRoot+'backoffice/subcat',
			type: 'post',
			data: { maincatid : subcatid },
			dataType:"json",
			success: function(data){
				$("#subcat").html("<option value=''>Select SubCategory</option>");
				$.each(data, function(index, value){
					$("#subcat").append("<option value='"+index+"'>"+value.subcat+"</option>");
				})
				defersubcat.resolve();
			},
			error: function(){
				defersubcat.reject();
				alert("Sorry, technical difficulties\nPlease try again later.");
			}
		})
		return defersubcat.promise();					
	}
	
	
	function callmain(){
		custom_alert_message_cancel();
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
</script>
<input type="hidden" id="itemid" name="itemid" value="<?php echo $_POST["itemid"]; ?>"/>
<?php echo $breadcrumb; ?>
<div class="container-fluid">
 <div class="hdcontainer" style="overflow:auto;">
	<div class="col-md-12 col-md-offset-0">
    	<h4 class="nav-header" style="color:#999;">Edit Item</h4>
        <label style="color:#F00;">Required Field <span class="required">*</span></label>
        <?php $attributes = array('name'=>'frmnewitem', 'class'=>'form-horizantal');?>
        <?php echo form_open('backoffice/newitem', $attributes)?>
        	<input type="hidden" name="submitted" id="submitted" value="1">
            <div class="row">
                <div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label">Item Number:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="itemnumber" name="itemnumber" placeholder="Item Number" autofocus>
                    </div>
                    <span class="required">*</span>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label">Barcode:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="partnumber" name="partnumber" placeholder="Barcode">
                    </div>
                    <span class="required">*</span>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label">Description:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description">
                    </div>
                </div>
            </div>
            <div class="row">
            	<div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label">Supplier:</label>
                    <div class="col-sm-4">
                        <select id="supplier" class="form-control">
                        	<option value="">Select Supplier</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
            	<div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label">Supplier Part:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="supplierpart" name="supplierpart" placeholder="Supplier Part Number">
                    </div>            
                </div>
            </div>
            <div class="row">
            	<div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label">Brand:</label>
                    <div class="col-sm-4">
                        <select name="brand" id="brand" class="form-control">
                        	<option value="">Select Brand</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
            	<div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label">Category:</label>
                    <div class="col-sm-4">
                        <select name="maincat" id="maincat" class="form-control">
                        	<option value="">Select Category</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label">Sub Category:</label>
                    <div class="col-sm-4">
                        <select name="subcat" id="subcat" class="form-control">
                        	<option value="">Select Sub-Category</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
            	<div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label">Cost:</label>
                    <div class="col-sm-4">
                        <!--<input type="text" class="form-control" value="" placeholder="Cost">-->
                         <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input type="text" id="cost" name="cost" class="form-control" aria-label="Amount (to the nearest dollar)" placeholder="0.00">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            	<div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label">Price:</label>
                    <div class="col-sm-4">
                        <!--<input type="text" class="form-control" id="price" name="price" value="" placeholder="Price">-->
                        <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input type="text" id="price" name="price" class="form-control" aria-label="Amount (to the nearest dollar)" placeholder="0.00">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            	<div class="form-group">
                    <label for="inputType" class="col-sm-1 control-label">Quantity:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="quantity" name="quantity" value="" placeholder="Quantity">
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
   </div><!--End hdcontainer-->   
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
</style>