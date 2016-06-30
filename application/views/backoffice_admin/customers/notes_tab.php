<div class="col-md-12 col-md-offset-0">
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-info" ng-click="openNoteWindow()" style="margin: 10px 0;">
                New Note
            </button>
        </div>
        <div class="col-md-12">
            <jqx-grid jqx-settings="customerNotesTableSettings"
                      id="customerNotesGrid"
            ></jqx-grid>
        </div>
        <jqx-window jqx-settings="CustomerNotesWinSettings"
                    jqx-on-create="CustomerNotesWinSettings">
            <div>
                New Customer Contact
            </div>
            <div class="">
                <div style=" width:100%;float:left;">
                    <div style=" width:100%;float:left;" class="customerNotesForm">
                        Notes fields..
                    </div>
                </div>
                <!-- MAIN BUTTONS   -->
                <div class="col-md-12 col-md-offset-0">
                    <div class="row">
                        <div id="mainBtnCustomerContact">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="button" id="saveCustomerNoteBtn"
                                            ng-click=""
                                            class="btn btn-primary">
                                        Save
                                    </button>
                                    <button type="button" id="closeCustomerNoteBtn"
                                            ng-click="closeCustomerNotesWind()"
                                            class="btn btn-warning">
                                        Close
                                    </button>
                                    <button type="button" id="deleteCustomerNoteBtn"
                                            ng-click=""
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
                                    <button type="button" ng-click="" class="btn btn-primary">Yes</button>
                                    <button type="button" ng-click="" class="btn btn-warning">No</button>
                                    <button type="button" ng-click="" class="btn btn-info">Cancel</button>
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
                                    <button type="button" ng-click="" class="btn btn-primary">Yes</button>
                                    <button type="button" ng-click="" class="btn btn-warning">No</button>
                                    <button type="button" ng-click="" class="btn btn-info">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- NOTIFICATIONS AREA -->
                <div class="col-md-12 col-md-offset-0">
                    <div class="row">
                        <jqx-notification jqx-settings="customerNotesSuccessSettings" id="customerNotesSuccessSettings">
                            <div id="notification-content"></div>
                        </jqx-notification>
                        <jqx-notification jqx-settings="customerNotesErrorSettings" id="customerNotesErrorSettings">
                            <div id="notification-content"></div>
                        </jqx-notification>
                        <div id="customerNotesNoticeContainer" style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
                    </div>
                </div>
            </div>
        </jqx-window>
    </div>
</div>