<jqx-window id="dialog-receiving-inventory" jqx-create="dialogInventorySettings" jqx-settings="dialogInventorySettings" style="display:none;">
    <div id="receiving-addnew-form">
        <div class="container-fluid">
            <input type="hidden" ng-model="inventory.unique">
            <input type="hidden" ng-model="inventory.description">
            <input type="hidden" ng-model="inventory.supplierunique">
            <input type="hidden" ng-model="inventory.supplierpart">
            <input type="hidden" ng-model="inventory.cost">
            <input type="hidden" ng-model="inventory.costextra">
            <input type="hidden" ng-model="inventory.costfreight">
            <input type="hidden" ng-model="inventory.costduty">
            <div class="row">
                <jqx-data-table id="receiving-inventory" jqx-on-row-double-click="InventoryRowDoubleClick(event)" jqx-on-row-click="InventoryRowClick(event)" jqx-settings="receivingInventorySettings"></jqx-data-table>
            </div>
            <div class="row" style="margin-top: 10px;">
                <button ng-click="PickItem()" class="btn btn-primary btn-lg">Ok</button>
                <button ng-click="CancelInventory()" class="btn btn-danger btn-lg">Cancel</button>
            </div>
        <div>
    </div>
</jqx-window>
<style type="text/css">
    #dialog-receiving-inventory{
        -webkit-border-radius: 15px 15px 15px 15px;
        border-radius: 15px 15px 15px 15px;
        border: 5px solid #449bca;
        height:100% !important;
        max-width: 100% !important;
        width: 100% !important;
    }
</style>
