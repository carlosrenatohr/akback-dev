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
                        <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Name:</div>
                        <div style="float:left; width:180px;margin-top: 0.6em;">
                            <p id="customerNameP"></p>
                        </div>
                    </div>

                    <div style="float:left; padding:2px; width:450px;">
                        <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Check In By:</div>
                        <div style="float:left; width:180px;margin-top: 0.6em;">
                            <p id="checkInP"></p>
                        </div>
                    </div>

                    <div style="float:left; padding:2px; width:450px;">
                        <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Check Out By:</div>
                        <div style="float:left; width:180px;margin-top: 0.6em;">
                            <p id="checkOutP"></p>
                        </div>
                    </div>

                    <div style="float:left; padding:2px; width:450px;">
                        <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Location:</div>
                        <div style="float:left; width:180px;">
                            <p id="LocationP"></p>
                            <select name="" id="">
                                <option value="">Location1</option>
                                <option value="">Location2</option>
                            </select>
                        </div>
                    </div>

                    <div style="float:left; padding:2px; width:450px;">
                        <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Quantity:</div>
                        <div style="float:left; width:180px;">
                            <input type="number" class="form-control required-field" id="QuantityControl"
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
                            <textarea name="CheckOut_comment" id="CommentControl" cols="10" rows="5"
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
                            <button type="button" id="checkoutCloseBtn"
                                    ng-click=""
                                    class="btn btn-warning">
                                Close
                            </button>
                            <button type="button" id="checkoutDeleteBtn"
                                    ng-click=""
                                    class="btn btn-danger" style="overflow:auto;">
                                Delete
                            </button>
                            <button type="button" id="checkoutCompleteBtn"
                                    ng-click=""
                                    class="btn btn-success" style="overflow:auto;">
                                Check out
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