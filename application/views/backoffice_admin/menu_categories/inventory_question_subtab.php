<div class="row inventory_tab" >
    <div class="col-md-12">
        <button class="btn btn-info" ng-click="openQuestionItemWin()" style="margin: 10px 0;">
            New Question
        </button>
    </div>
    <div class="col-md-12">
        <jqx-grid id="questionItemTable"
                    jqx-settings="questionInventoryGridSettings"
                    jqx-create="questionInventoryGridSettings"
                    jqx-on-rowdoubleclick="editQuestionItemWin($event)"
                    >
        </jqx-grid>
    </div>
</div>
<jqx-window jqx-on-close="close()" jqx-settings="questionInventoryWindSettings"
            jqx-create="questionInventoryWindSettings" class="">
    <div>
        New Question
    </div>
    <div>
        <div class="col-md-12 col-md-offset-0">
            <div class="row invQFormContainer">
                <div style=" width:100%;float:left;">
                    <div style="float:left; padding:2px; width:400px;">
                        <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">
                            Question:
                        </div>
                        <div style="float:left;">
                            <jqx-combo-box
                                jqx-on-select=""
                                jqx-settings="questionItemsCbxSettings"
                                id="invQ_Question">
                            </jqx-combo-box>
                        </div>
                    </div>

                    <div style=" float:left; padding:2px; width:400px; ">
                        <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Sort:
                        </div>
                        <div style="float:left;">
                            <jqx-number-input id="invQ_Sort" class="form-control required-qitem"
                                              jqx-width="200" jqx-height="30"
                                              jqx-spin-buttons="false" jqx-input-mode="simple"
                                              jqx-symbol="''" jqx-decimal-digits="0"
                                              jqx-min="1" jqx-value="1" jqx-digits="2"
                                              jqx-text-align="left"
                            ></jqx-number-input>
                        </div>
                        <div style="float:left;">
                            <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                        </div>
                    </div>
                    <div style=" float:left; padding:2px; width:400px; ">
                        <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Tab:
                        </div>
                        <div style="float:left;">
                            <jqx-number-input id="invQ_Tab" class="form-control required-qitem"
                                              jqx-width="200" jqx-height="30"
                                              jqx-spin-buttons="false" jqx-input-mode="simple"
                                              jqx-symbol="''" jqx-decimal-digits="0"
                                              jqx-min="1" jqx-value="1" jqx-digits="2"
                                              jqx-text-align="left"
                            ></jqx-number-input>
                        </div>
                        <div style="float:left;">
                            <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                        </div>
                    </div>

                    <div style=" float:left; padding:2px; width:400px; ">
                        <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Status:
                        </div>
                        <div style="float:left;">
                            <select name="invQ_Status" id="invQ_Status">
                                <option value="1">Enabled</option>
                                <option value="2">Disabled</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main buttons before saving questions on current item -->
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <div id="mainButtonsQinv">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="button" id="saveQuestionInvBtn" ng-click="saveQuestionItem()"
                                    class="btn btn-primary" disabled>
                                Save
                            </button>
                            <button type="button" id="" ng-click="closeQuestionItemWin()" class="btn btn-warning">
                                Close
                            </button>
                            <button type="button" id="deleteQuestionInvBtn" ng-click="deleteQuestionItem()"
                                    class="btn btn-danger " style="overflow:auto;">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Prompt before saving questions by item -->
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <div id="promptToCloseQinv" class="" style="display: none">
                    <div class="form-group">
                        <div class="col-sm-12">
                            Do you want to save your changes?
                            <button type="button" ng-click="closeQuestionItemWin(0)" class="btn btn-primary">Yes
                            </button>
                            <button type="button" ng-click="closeQuestionItemWin(1)" class="btn btn-warning">No</button>
                            <button type="button" ng-click="closeQuestionItemWin(2)" class="btn btn-info">Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Prompt before delete an item on grid -->
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <div id="promptToDeleteQInv" class="" style="display: none">
                    <div class="form-group">
                        <div class="col-sm-12">
                            Do you really want to delete it?
                            <button type="button" ng-click="deleteQuestionItem(0)" class="btn btn-primary">Yes</button>
                            <button type="button" ng-click="deleteQuestionItem(1)" class="btn btn-warning">No</button>
                            <button type="button" ng-click="deleteQuestionItem(2)" class="btn btn-info">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- NOTIFICATIONS AREA -->
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <jqx-notification jqx-settings="questionInventorySuccess"
                                  id="questionInventorySuccess">
                    <div id="notification-content"></div>
                </jqx-notification>
                <jqx-notification jqx-settings="questionInventoryError"
                                  id="questionInventoryError">
                    <div id="notification-content"></div>
                </jqx-notification>
                <div id="notif_questionInventory"
                     style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
            </div>
        </div>
    </div>
</jqx-window>