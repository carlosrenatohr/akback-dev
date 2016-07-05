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
                        <div style="float:left; padding:2px; width:600px;">
                            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Note:</div>
                            <div style="float:left; width:400px; ">
                                <textarea name="customerNote_note" id="customerNote_note"
                                          class="form-control req" placeholder="Note"
                                          cols="30" rows="5"
                                ></textarea>
                            </div>
                            <div style="float:left;">
                                <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                            </div>
                        </div>
                        <div style="float:left; padding:2px; width:600px;">
                            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Note:</div>
                            <div style="float:left; width:400px;padding: 8px 2px;">
                                <p id="CreatedSection">
                                    Created by: <b><span id="createdBy"></span></b>
                                    at <b><span id="createdAt"></span></b>
                                </p>
                                <p id="UpdatedSection" style="display: none;">
                                    Updated by: <b><span id="updatedBy"></span></b>
                                    at <b><span id="updatedAt"></span></b>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- MAIN BUTTONS   -->
                <div class="col-md-12 col-md-offset-0">
                    <div class="row">
                        <div id="mainBtnCustomerNote">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="button" id="saveCustomerNoteBtn"
                                            ng-click="saveCustomerNotes()"
                                            class="btn btn-primary">
                                        Save
                                    </button>
                                    <button type="button" id="closeCustomerNoteBtn"
                                            ng-click="closeCustomerNotes()"
                                            class="btn btn-warning">
                                        Close
                                    </button>
                                    <button type="button" id="deleteCustomerNoteBtn"
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
                        <div id="promptToCloseCustomerNote" class="" style="display: none">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    Do you want to save your changes?
                                    <button type="button" ng-click="closeCustomerNotes(0)" class="btn btn-primary">Yes</button>
                                    <button type="button" ng-click="closeCustomerNotes(1)" class="btn btn-warning">No</button>
                                    <button type="button" ng-click="closeCustomerNotes(2)" class="btn btn-info">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Prompt before delete an item on grid -->
                <div class="col-md-12 col-md-offset-0">
                    <div class="row">
                        <div id="promptToDeleteCustomerNote" class="" style="display: none">
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