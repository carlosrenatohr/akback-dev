<jqx-window jqx-on-close="close()" id="item_info_popup" jqx-create="dialogPOpopup" jqx-settings="dialogPOpopup" style="display:none;">
    <div class="container">
        <div class="col-md-12">
            <div class="row add-item-adjustment">
                <div class="form-group">
                    <label for="inputType" class="col-sm-3 control-label">Order:</label>
                    <div class="col-sm-8">
                        <jqx-number-input id="add-order-input" jqx-width="100" jqx-height="25" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-model="poOrder.value"></jqx-number-input>
                    </div>
                </div>
            </div>
            <div class="row add-item-adjustment">
                <div class="form-group">
                    <label for="inputType" class="col-sm-3 control-label">Received:</label>
                    <div class="col-sm-8">
                        <jqx-number-input id="add-receive-input"  jqx-width="100" jqx-height="25" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-model="poReceived.value"></jqx-number-input>
                    </div>
                </div>
            </div>
            <div class="row add-item-adjustment">
                <div class="form-group">
                    <label for="inputType" class="col-sm-3 control-label">Cost:</label>
                    <div class="col-sm-8">
                        <jqx-number-input id="add-cost-input"  jqx-width="100" jqx-height="25" jqx-spin-buttons="false" jqx-input-mode="simple" jqx-symbol="''" ng-model="poCost.value"></jqx-number-input>
                    </div>
                </div>
            </div>
            <div class="row add-item-adjustment">
                <div class="form-group">
                    <label for="inputType" class="col-sm-3 control-label">Receive Date:</label>
                    <div class="col-sm-8">
                        <jqx-date-time-input ng-model="received.setdate" jqx-settings="ReceiveddateInputSettings" jqx-format-string="Orderdatestring"></jqx-date-time-input>
                    </div>
                </div>
            </div>
            <div class="row add-item-adjustment">
                <input type="hidden" ng-model="PurchaseDetails.Unique">
                <input type="hidden" ng-model="Item.Unique">
                <button class="btn btn-primary" ng-click="ItemOrderSave()">Save</button>
                <button class="btn btn-warning" ng-click="ItemOrderClose()">Cancel</button>
            </div>
        </div>
    </div>
</jqx-window>
<style type="text/css">
    #item_info_popup {
        -webkit-border-radius: 15px 15px 15px 15px;
        border-radius: 15px 15px 15px 15px;
        border: 5px solid #a4bed4;
    }
    body{
        overflow: hidden;
        padding:0;
        margin:0;
    }
    .add-item-adjustment{
        margin-bottom: 5px;
    }
    .control-label {

    }
</style>