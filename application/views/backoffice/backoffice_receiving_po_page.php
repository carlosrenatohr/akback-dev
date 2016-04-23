<?php
    jqxangularjs();
    jqxthemes();
    $array = $this->uri->segment_array(4);
?>
<script type="text/javascript">
    function KeyPress(e) {
        var evtobj = window.event? event : e;
        if (evtobj.keyCode == 66 && evtobj.ctrlKey){
            $("#barcode_search").focus();
        }
    }
    document.onkeydown = KeyPress;
</script>
<div class="splash" ng-cloak="">
    <p>Loading</p>
</div>
<div class="row-offcanvas row-offcanvas-left ng-cloak">
    <div class="container-fluid" onkeydown="KeyPress(event)">
    	<div class="row alert-danger">
        	<span style="color:#000; font-weight:bold;">{{itemdesc.info}}</span>
        </div>
        <div class="row">
            <div id="receiving-addnew-form">
                <div class="container-fluid">
                    <div class="row alert-info" style="padding: 5px;">
                        <div style="float:left; width:220px;">
                            Supplier <jqx-combo-box id="SelectSupplier" jqx-on-select="selectHandlerSupplier(event)" ng-model="selectedSupplierValue" jqx-settings="comboBoxSupplierSettings"></jqx-combo-box>
                        </div>
                        <div style="float:left;">
                            Location <jqx-combo-box id="SelectLocation" jqx-on-select="selectHandlerLocation(event)" ng-model="selectedLocationValue" jqx-settings="comboBoxLocationSettings"></jqx-combo-box>
                        </div>
                        <div style="float: left;">
                            Order Date<jqx-date-time-input ng-model="order.setdate" jqx-settings="OrderdateInputSettings" jqx-format-string="Orderdatestring"></jqx-date-time-input>
                        </div>
                        <div style="float:left;">
                            Ref Code:
                            <input type="text" class="form-control" ng-model="RefCode">
                        </div>
                        <div style="float:">
                            Search:
                            <div class="input-group">
                                <input type="search" class="form-control" ng-model="Item.Search" id="barcode_search" ng-enter="EnterItemSearch()" ng-disabled="TxtSearchWhen"/>
                                <div class="input-group-btn">
                                    <button class="btn btn-primary" ng-click="SearchItemButton(); focusInput=true" type="button" ng-disabled="BtnSearchWhen"></i><span class="glyphicon glyphicon-search"></span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <jqx-data-table id="receiving-addnew" jqx-on-row-click="receivingRowClick(event)" jqx-on-row-double-click="receivingRowDoubleClick()" jqx-settings="receivingAddNewSettings"></jqx-data-table>
                    </div>
                    <div class="row" style="margin-top:10px;" ng-show="primary_button">
                        <!--
                        <button ng-click="OnHold()" ng-disabled="OnHoldButton" id="OnHoldButton" class="btn btn-success btn-lg">On Hold</button>
                        <button ng-click="SavePO()" class="btn btn-primary btn-lg">Receive PO</button>
                        <button ng-click="DeletePO()" class="btn btn-danger btn-lg">Delete</button>
                        <button ng-click="EditCancelPO()" class="btn btn-warning btn-lg">Close</button>
                        -->
                        <button ng-click="SavePO()" class="btn btn-primary btn-lg">Save</button>
                        <button ng-click="CancelPO()" class="btn btn-danger btn-lg">Delete</button>
                    </div>
                    <div class="col-md-12" ng-show="DeleteBox">
                        <div class="row" style="margin-top:10px;">
                            <span style="color: #FF0000;">{{delete.message}}</span>
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <button ng-click="DeleteYes()" class="btn btn-success btn-lg">Yes</button>
                            <button ng-click="DeleteNo()" class="btn btn-primary btn-lg">No</button>
                        </div>
                    </div>
                    <div class="col-md-12" ng-show="AskBox">
                        <div class="row" style="margin-top:10px;">
                            <span style="color: #FF0000;">{{ask.message}}</span>
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <button ng-click="AskNo()" class="btn btn-success btn-lg">Yes</button>
                            <button ng-click="AskYes()" class="btn btn-primary btn-lg">No</button>
                            <button ng-click="DeleteCancel()" class="btn btn-warning btn-lg">Cancel</button>
                        </div>
                    </div>
                 <div>
             </div>
        </div>
    </div>
    <input type="hidden" ng-model="userid" ng-init="userid='<?php echo $userid?>'">
    <input type="hidden" ng-model="storeid" ng-init="storeid='<?php echo $storeunique?>'">
    <input type="hidden" ng-model="purchaseheader" ng-init=purchaseheader="<?php echo $array[5]?>">
    <inventory-purchase></inventory-purchase>
    <podel-confirmation></podel-confirmation>
    <item-popup-info></item-popup-info>
</div>
<style type="text/css">
    body{
        padding:0;
        margin:0;
        overflow: hidden;
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

    .icon-32-back {
        background-image: url("http://localhost/app/assets/img/back.png");
    }

    .icon-32-new {
        background-image: url("http://localhost/app//assets/img/addnew.png");
    }

    [ng-cloak].splash {
        display: block !important;
    }

    .splash {
        background-color: #428bca;
        display: none;
    }
	
	#SelectSupplier{
		width: auto !important;
	}

</style>