<!-- Main buttons before saving item on grid -->
<div class="col-md-12 col-md-offset-0">
    <div id="mainButtonsOnItemInv" class="rowMsgInv">
        <div class="form-group">
            <div class="col-sm-12">
                                <span class="btn btn-success" id="uploadItemPictureBtn" flow-btn style="display: none;">
                                    Upload Picture
                                </span>
                <button type="button" id="saveInventoryBtn" ng-click="saveInventoryAction()"
                        class="btn btn-primary" disabled>
                    Save
                </button>
                <button type="button" ng-click="closeInventoryAction()" class="btn btn-warning">Close</button>
                <button type="button" id="deleteInventoryBtn" ng-click="deleteInventoryAction()" class="btn btn-danger"
                        style="overflow:auto;display: none;">Delete
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Prompt before saving item on grid -->
<div class="col-md-12 col-md-offset-0">
    <div id="promptCloseItemInv" class="rowMsgInv" style="display: none">
        <div class="form-group">
            <div class="col-sm-12">
                <div class="message">Do you want to save your changes?</div>
                <button type="button" ng-click="closeInventoryAction(0)" class="btn btn-primary">Yes</button>
                <button type="button" ng-click="closeInventoryAction(1)" class="btn btn-warning">No</button>
                <button type="button" ng-click="closeInventoryAction(2)" class="btn btn-info">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- Prompt before saving item to add features on grid -->
<div class="col-md-12 col-md-offset-0">
    <div id="promptMoveItemInv" class="rowMsgInv" style="display: none">
        <div class="form-group">
            <div class="col-sm-12">
                <div class="message">To add a <label id="tabTitleOnMsg"></label> new item must first be saved. Do you want to save now ?</div>
                <button type="button" ng-click="moveTabInventoryAction(0)" class="btn btn-primary">Yes</button>
                <button type="button" ng-click="moveTabInventoryAction(2)" class="btn btn-info">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- Prompt before delete an item on grid -->
<div class="col-md-12 col-md-offset-0">
    <div id="promptToDeleteItemInv" class="rowMsgInv" style="display: none">
        <div class="form-group">
            <div class="col-sm-12">
                Do you really want to delete it?
                <button type="button" ng-click="deleteInventoryAction(0)" class="btn btn-primary">Yes</button>
                <button type="button" ng-click="deleteInventoryAction(1)" class="btn btn-warning">No</button>
                <button type="button" ng-click="deleteInventoryAction(2)" class="btn btn-info">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Prompt before pressing generate number on item -->
<div class="col-md-12 col-md-offset-0">
    <div id="generateItemNItemInv" class="rowMsgInv" style="display: none">
        <div class="form-group">
            <div class="col-sm-12">
                would like you to right save the New Item into Item Table?
                <button type="button" ng-click="generateItemNumber(0)" class="btn btn-primary">Yes</button>
                <button type="button" ng-click="generateItemNumber(1)" class="btn btn-warning">No</button>
                <button type="button" ng-click="generateItemNumber(2)" class="btn btn-info">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- Prompt before delete a BARCODE item on grid -->
<div class="col-md-12 col-md-offset-0">
    <div id="promptToDeleteBarcodeInv" class="rowMsgInv" style="display: none">
        <div class="form-group">
            <div class="col-sm-12">
                Are you sure want to delete list barcode <span id="barcode-span"></span> ?
                <button type="button" ng-click="deleteItemBarcode(0)" class="btn btn-primary">Yes</button>
                <button type="button" ng-click="deleteItemBarcode(1)" class="btn btn-warning">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- NOTIFICATIONS AREA -->
<div class="col-md-12 col-md-offset-0">
    <div class="row">
        <jqx-notification jqx-settings="inventorySuccessMsg" id="inventorySuccessMsg">
            <div id="notification-content"></div>
        </jqx-notification>
        <jqx-notification jqx-settings="inventoryErrorMsg" id="inventoryErrorMsg">
            <div id="notification-content"></div>
        </jqx-notification>
        <div id="notification_container_inventory"
             style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
    </div>
</div>