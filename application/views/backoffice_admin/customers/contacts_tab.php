<div class="col-md-12 col-md-offset-0">
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-info" ng-click="openContactWindow()" style="margin: 10px 0;">
                New Contact
            </button>
        </div>
        <div class="col-md-12">
            <jqx-grid jqx-settings="customerContactTableSettings"
                      id="customerContactsGrid"
            ></jqx-grid>
        </div>
        <jqx-window jqx-settings="addCustomerContactWinSettings"
                    jqx-on-create="addCustomerContactWinSettings">
            <div>
                New Customer Contact
            </div>
            <div class="">
                <div style=" width:100%;float:left;">
                    <div style=" width:100%;float:left;padding:2px 0;margin: 5px 0 0;" ng-repeat="attr in customerContactsControls" class="customerContactsForm">
                        <multiple-controls></multiple-controls>
                    </div>
                </div>
                <!-- MAIN BUTTONS   -->
                <div class="col-md-12 col-md-offset-0">
                    <div class="row">
                        <div id="mainBtnCustomerContact">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="button" id="saveCustomerContactBtn"
                                            ng-click="saveCustomerContactsAction()"
                                            class="btn btn-primary">
                                        Save
                                    </button>
                                    <button type="button" id="closeCustomerContactBtn"
                                            ng-click="closeCustomerContact()"
                                            class="btn btn-warning">
                                        Close
                                    </button>
                                    <button type="button" id="deleteCustomerContactBtn"
                                            ng-click="deleteCustomerContact()"
                                            class="btn btn-danger" style="overflow:auto;display: none;">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Prompt before saving item on grid -->
                <div class="col-md-12 col-md-offset-0">
                    <div class="row">
                        <div id="promptBtnCustomerContact" class="" style="display: none">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    Do you want to save your changes?
                                    <button type="button" ng-click="closeCustomerContact(0)" class="btn btn-primary">Yes</button>
                                    <button type="button" ng-click="closeCustomerContact(1)" class="btn btn-warning">No</button>
                                    <button type="button" ng-click="closeCustomerContact(2)" class="btn btn-info">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Prompt before delete an item on grid -->
                <div class="col-md-12 col-md-offset-0">
                    <div class="row">
                        <div id="beforeDeleteBtnCustomerContact" class="" style="display: none">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    Do you really want to delete it?
                                    <button type="button" ng-click="deleteCustomerContact(0)" class="btn btn-primary">Yes</button>
                                    <button type="button" ng-click="deleteCustomerContact(1)" class="btn btn-warning">No</button>
                                    <button type="button" ng-click="deleteCustomerContact(2)" class="btn btn-info">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- NOTIFICATIONS AREA -->
                <div class="col-md-12 col-md-offset-0">
                    <div class="row">
                        <jqx-notification jqx-settings="customerContactSuccessSettings" id="customerContactSuccessSettings">
                            <div id="notification-content"></div>
                        </jqx-notification>
                        <jqx-notification jqx-settings="customerContactErrorSettings" id="customerContactErrorSettings">
                            <div id="notification-content"></div>
                        </jqx-notification>
                        <div id="customerContactNoticeContainer" style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
                    </div>
                </div>
            </div>
        </jqx-window>
    </div>
</div>