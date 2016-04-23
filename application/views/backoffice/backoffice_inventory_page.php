<?php jqxplugins(); ?>
<script type="text/javascript">
	//-->Global Variable
	var SiteRoot = "<?php echo base_url()?>";
	var itemid = 0;
	
	//-->JQuery functions
	$(function(){
		changetabtile();
		load_inventory();
		
		$("#btnsearch").click(function(){
			load_inventory();
		})
	})
	
	function changetabtile(){
		$("#tabtitle").html("Inventory Management");
	}
	
	function load_inventory(){
        var search_item = $("#search").val();
		
		if(search_item == ''){
			var url = SiteRoot+"backoffice/load_inventory";
		}else{
			var url = SiteRoot+"backoffice/load_inventory/"+search_item;	
		}	
			// prepare the data
			var source =
			{
				datatype: "json",
				datafields: [
					{ name: 'Unique', type : 'int' },
					{ name: 'Item', type: 'string'},
					{ name: 'Part', type: 'string' },
					{ name: 'Description', type: 'string'},
					{ name: 'Size', type: 'string'},
					{ name: 'Color', type: 'string'},
					{ name: 'Other', type: 'string'},
					{ name: 'Supplier', type: 'string'},
					{ name: 'SupplierPart', type: 'string'},
					{ name: 'Brand', type: 'string'},
					{ name: 'Category', type: 'string'},
					{ name: 'Cost', type: 'float'},
					{ name: 'Price', type: 'float'},
					{ name: 'Quantity', type: 'int'}
				],
				url: url
			};
	
			var dataAdapter = new $.jqx.dataAdapter(source);
	
			$("#jqxgrid").jqxGrid(
				{
					width: "99.5%",
					height: "560",
					theme: 'bootstrap',
					pagesize: 20,
					source: dataAdapter,
					columnsresize: true,
					sortable: true,
					pageable: true,
					altrows: true,
					filterable: true,
					enabletooltips: true,
					columns: [
						{ text: 'ID', dataField: 'Unique', width: "5%"},
						{ text: 'Item Number', dataField: 'Item', width: "7%"},
						{ text: 'Part Number', dataField: 'Part', width: '7%' },
						{ text: 'Description', dataField: 'Description', width: '15%' },
						{ text: 'Size', dataField: 'Size', width: '7%' },
						{ text: 'Color', dataField: 'Color', width: '7%' },
						{ text: 'Other', dataField: 'Other', width: '7%' },
						{ text: 'Supplier', dataField: 'Supplier', width: '8%'},
						{ text: 'Supplier Part', dataField: 'SupplierPart', width: '7%' },
						{ text: 'Brand', dataField: 'Brand', width: '8%' },
						{ text: 'Category', dataField: 'Category', width: '7%'},
						{ text: 'Cost', dataField: 'Cost', width: '5%', cellsalign: 'right', cellsformat: 'c2'},
						{ text: 'Price', dataField: 'Price', width: '5%', cellsalign: 'right', cellsformat: 'c2'},
						{ text: 'Quantity', dataField: 'Quantity', width: '5%', cellsalign: 'center'}
					]
				});
	
			$("#jqxgrid").on('rowselect', function (event) {
				var data =  event.args.rowindex;
				var itemobj = $('#jqxgrid').jqxGrid('getrowdata', data);
				itemid = $(itemobj).attr("Unique");
			});
	}
	
	
	function edititem(){
		if(itemid!=0){
		 	$("#itemid").val(itemid);
        	$("#frmedit").submit();
		}else{
			//alert("Please select contact first.");
			custom_alert_message();
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
	
	function custom_alert_message(){
		BootstrapDialog.alert('Please select an item from the list.');
	}

</script>
<?php echo $breadcrumb; ?>
<div class="container-fluid">
	<div class="col-md-12 col-md-offset-0">
        <nav class="navbar navbar-default" role="navigation" style="background:#CCC;">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                	<div class="col-md-3">
                    	<a class="navbar-brand" style="color: #146295;"><b>Inventory:</b></a>
                    </div>
                    <div class="col-md-9" style="padding:10px;">
                        <div class="input-group">
                            <input type="text" id="search" class="form-control search-query" placeholder="Search..." /> <span class="input-group-btn">
                            <button type="button" id="btnsearch" class="btn btn-primary"> Search</button>
                            </span>
                        </div>
                    </div>
                </div>
                <div id="toolbar" class="toolbar-list">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="<?php echo base_url("backoffice/inventory/new")?>" style="outline:0;">
                                <span class="icon-32-new"></span>
                                New
                            </a>
                        </li>
                        <li> 
                            <a onclick="edititem()" class="" style="cursor: pointer; outline:0;">
                                <span class="icon-32-edit"></span>
                                Edit
                            </a>
                            <form method="post" id="frmedit" action="<?php echo base_url('backoffice/inventory/edit')?>">
                                <input type="hidden" id="itemid" name="itemid">
                            </form>
                        </li>
                        <li>
                            <a onClick="deletecontact()" class="">
                                <span class="icon-32-trash"></span>
                                Delete
                            </a>
                            <form method="post" id="frmdelete" action="<?php echo base_url('backoffice/deletecontact')?>">
                                <input type="hidden" id="contactid" name="contactid">
                            </form>
                        </li>
                        <li>
                            <a href="<?php echo base_url("backoffice/dashboard")?>" style="outline:0;">
                                <span class="icon-32-back"></span>
                             Menu
                            </a>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <div class="row">
            <div id='jqxWidget' style="font-size: 13px; font-family: Verdana;">
                <div id="jqxgrid"></div>
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
</style>
