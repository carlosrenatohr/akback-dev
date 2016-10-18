<div class="col-md-12">
    <button class="btn btn-info" ng-click="openQuestionItemWin()" style="margin: 10px 0;">
        New Question
    </button>
</div>
<div class="col-md-12">
    <jqx-grid id="questionItemTable"
                    jqx-settings="questionTableOnMenuItemsSettings"
                    jqx-on-rowdoubleclick="editQuestionItemLayoutWin($event)"
                    jqx-create="questionTableOnMenuItemsSettings">
    </jqx-grid>
</div>
<jqx-window jqx-on-close="close()" jqx-settings="questionOnItemGridWindowSettings"
            jqx-create="questionOnItemGridWindowSettings" class="">
    <div>
        New Question
    </div>
    <div>
        <div class="col-md-12 col-md-offset-0">
            <div class="row itemqFormContainer">
                <div style=" width:100%;float:left;">
                    <div style="float:left; padding:2px; width:450px;">
                        <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">
                            Question:
                        </div>
                        <div style="float:left; width:300px;">
                            <jqx-combo-box
                                jqx-on-select="qitemsCbxSelecting($event)"
                                jqx-settings="questionItemsCbxSettings"
                                id="itemq_Question">
                            </jqx-combo-box>
                        </div>
                    </div>

                    <div style="float:left; padding:2px; width:450px;">
                        <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">
                            Sell Price:
                        </div>
                        <div style="float:left; width:300px;">
                            <jqx-number-input id="itemq_sellprice"
                                              jqx-symbol="$ "
                                              jqx-input-mode="'simple'"
                                              jqx-disabled="questionDisabled"
                                              jqx-width="'290px'"
                                              jqx-height="25"
                                              jqx-text-align="left"
                                              jqx-decimal-digits="<?php echo $decimalsPrice; ?>"

                            ></jqx-number-input>
                        </div>
                    </div>

                    <div style=" float:left; padding:2px; width:450px; ">
                        <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Sort:
                        </div>
                        <div style=" float:left; width:300px;">
<!--                            <input type="number" class="form-control required-qitem"-->
<!--                                   id="itemq_Sort" name="itemq_Sort" placeholder="Sort"-->
<!--                                   step="1" min="1" value="1" pattern="\d*">-->
                            <jqx-number-input id="itemq_Sort" class="form-control required-qitem"
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
                            <jqx-number-input id="itemq_Tab" class="form-control required-qitem"
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

                    <div style=" float:left; padding:2px; width:450px; ">
                        <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Status:
                        </div>
                        <div style=" float:left; width:300px;">
                            <select name="itemq_Status" id="itemq_Status">
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
                <div id="mainButtonsQitem">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="button" id="saveQuestionItemBtn" ng-click="saveQuestionItem()"
                                    class="btn btn-primary" disabled>
                                Save
                            </button>
                            <button type="button" id="" ng-click="closeQuestionItemWin()" class="btn btn-warning">
                                Close
                            </button>
                            <button type="button" id="deleteQuestionItemBtn" ng-click="deleteQuestionItem()"
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
                <div id="promptToCloseQitem" class="" style="display: none">
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
                <div id="promptToDeleteQItem" class="" style="display: none">
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
                <jqx-notification jqx-settings="qitemNotificationsSuccessSettings"
                                  id="qitemNotificationsSuccessSettings">
                    <div id="notification-content"></div>
                </jqx-notification>
                <jqx-notification jqx-settings="qitemNotificationsErrorSettings" id="qitemNotificationsErrorSettings">
                    <div id="notification-content"></div>
                </jqx-notification>
                <div id="notification_container_menuitem"
                     style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
            </div>
        </div>
    </div>
</jqx-window>