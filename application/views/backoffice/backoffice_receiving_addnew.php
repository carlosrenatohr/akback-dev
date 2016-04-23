<jqx-window  onkeydown="KeyPress(event)" jqx-on-close="close()" id="dialog-receiving-addnew" jqx-create="dialogAddNewSettings" jqx-settings="dialogAddNewSettings" style="display:none;">
    <div id="receiving-addnew-form">
        <div class="container-fluid">
            <div class="row">
                <div style="float:left;">
                    Supplier <jqx-combo-box jqx-on-select="selectHandlerSupplier(event)" ng-model="selectedSupplierValue" jqx-settings="comboBoxSupplierSettings"></jqx-combo-box>
                </div>
                <div style="float:left;">
                    Location <jqx-combo-box jqx-on-select="selectHandlerLocation(event)" ng-model="selectedLocationValue" jqx-settings="comboBoxLocationSettings"></jqx-combo-box>
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
                <jqx-data-table id="receiving-addnew" jqx-on-row-click="receivingRowClick(event)" jqx-settings="receivingAddNewSettings"></jqx-data-table>
            </div>
            <div class="row" style="margin-top:10px;" ng-show="primary_button">
                <button ng-click="OnHold()" ng-disabled="OnHoldButton" id="OnHoldButton" class="btn btn-success btn-lg">On Hold</button>
                <button ng-click="SavePO()" class="btn btn-primary btn-lg">Receive PO</button>
                <button ng-click="CancelPO()" class="btn btn-warning btn-lg" ng-show="CancelPOButton">Close</button> <!--/Add New/-->
                <button ng-click="EditCancelPO()" class="btn btn-warning btn-lg" ng-show="EditCancelPOButton">Close</button> <!--/Edit/-->
                <button ng-click="DeletePO()" class="btn btn-danger btn-lg" ng-show="DeletePOButton">Delete</button>
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
                    <button ng-click="AskYes()" class="btn btn-success btn-lg">Yes</button>
                    <button ng-click="AskNo()" class="btn btn-primary btn-lg">No</button>
                </div>
            </div>
        <div>
    </div>
</jqx-window>
<script type="text/javascript">
    function KeyPress(e) {
        var evtobj = window.event? event : e;
        if (evtobj.keyCode == 66 && evtobj.ctrlKey){
            $("#barcode_search").focus();
        }
    }
    document.onkeydown = KeyPress;
</script>
<style type="text/css">
    #dialog-receiving-addnew{
        -webkit-border-radius: 15px 15px 15px 15px;
        border-radius: 15px 15px 15px 15px;
        border: 5px solid #449bca;
        height:100% !important;
        max-width: 90% !important;
        width: 100% !important;
    }
</style>
