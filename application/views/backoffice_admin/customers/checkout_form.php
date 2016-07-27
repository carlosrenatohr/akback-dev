<jqx-window jqx-settings="checkoutFormWindowSettings"
            jqx-on-create="checkoutFormWindowSettings"
            id="checkoutFormWindow">
    <div class="">
        Check out Form | Customer:
    </div>
    <div class="">
        <div class="col-md-12 col-md-offset-0" id="checkOutForm">
            <div class="row menuFormContainer">
                <div style=" width:330px;float:left;">
                    <div style="float:left; padding:2px; width:450px;">
                        <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">First Name and Last Name:</div>
                        <div style="float:left; width:180px;">
                            <input type="text" class="form-control required-field" id="CheckOut_fname" name="CheckOut_fname" placeholder="First and Last Name" autofocus>
                        </div>
                        <div style="float:left;">
                            <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                        </div>
                    </div>

                    <div style="float:left; padding:2px; width:450px;">
                        <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Check In By:</div>
                        <div style="float:left; width:180px;">
                            ---
                        </div>
                        <div style="float:left;">
                            <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                        </div>
                    </div>

                    <div style="float:left; padding:2px; width:450px;">
                        <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Check Out By:</div>
                        <div style="float:left; width:180px;">
                            ---
                        </div>
                        <div style="float:left;">
                            <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                        </div>
                    </div>

                    <div style="float:left; padding:2px; width:450px;">
                        <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Location:</div>
                        <div style="float:left; width:180px;">
                            ---
                        </div>
                        <div style="float:left;">
                            <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                        </div>
                    </div>

                    <div style="float:left; padding:2px; width:450px;">
                        <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Note:</div>
                        <div style="float:left; width:180px;">
                                            <textarea name="CheckOut_note" id="CheckOut_note" cols="10" rows="5"
                                                      class="form-control required-field" placeholder="Note"></textarea>
                        </div>
                        <div style="float:left;">
                            <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                        </div>
                    </div>

                    <div style="float:left; padding:2px; width:450px;">
                        <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Quantity:</div>
                        <div style="float:left; width:180px;">
                            <input type="number" class="form-control required-field" id="CheckOut_quantity"
                                   name="CheckOut_quantity" placeholder="Quantity"
                                   step="1" min="1" pattern="\d*"
                            >
                        </div>
                        <div style="float:left;">
                            <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                        </div>
                    </div>

                    <div style="float:left; padding:2px; width:450px;">
                        <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Comment:</div>
                        <div style="float:left; width:180px;">
                                            <textarea name="CheckOut_comment" id="CheckOut_comment" cols="10" rows="5"
                                                      class="form-control required-field" placeholder="Comment"></textarea>
                        </div>
                        <div style="float:left;">
                            <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- -->
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <div id="mainButtonsCustomerForm">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="button" id="saveCustomerBtn"
                                    ng-click=""
                                    class="btn btn-primary" disabled>
                                Save
                            </button>
                            <button type="button" id="closeCustomerBtn"
                                    ng-click=""
                                    class="btn btn-warning">
                                Close
                            </button>
                            <button type="button" id="deleteCustomerBtn"
                                    ng-click=""
                                    class="btn btn-danger" style="overflow:auto;">
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
                <div id="promptToCloseCustomerForm" class="" style="display: none">
                    <div class="form-group">
                        <div class="col-sm-12">
                            Do you want to save your changes?
                            <button type="button" ng-click="closeCustomerAction(0)" class="btn btn-primary">Yes</button>
                            <button type="button" ng-click="closeCustomerAction(1)" class="btn btn-warning">No</button>
                            <button type="button" ng-click="closeCustomerAction(2)" class="btn btn-info">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prompt before delete an item on grid -->
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <div id="promptToDeleteCustomerForm" class="" style="display: none">
                    <div class="form-group">
                        <div class="col-sm-12">
                            Do you really want to delete it?
                            <button type="button" ng-click="deleteCustomerAction(0)" class="btn btn-primary">Yes</button>
                            <button type="button" ng-click="deleteCustomerAction(1)" class="btn btn-warning">No</button>
                            <button type="button" ng-click="deleteCustomerAction(2)" class="btn btn-info">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- NOTIFICATIONS AREA -->
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <jqx-notification jqx-settings="customerNoticeSuccessSettings" id="customerNoticeSuccessSettings">
                    <div id="notification-content"></div>
                </jqx-notification>
                <jqx-notification jqx-settings="customerNoticeErrorSettings" id="customerNoticeErrorSettings">
                    <div id="notification-content"></div>
                </jqx-notification>
                <div id="customerNoticeContainer" style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
            </div>
        </div>
    </div>
    </div>
</jqx-window>