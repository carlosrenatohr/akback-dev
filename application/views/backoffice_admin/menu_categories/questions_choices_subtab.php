<div class="row">
    <div class="col-md-6">
        <a style="outline:0;margin: 10px 2px;" class="btn btn-info"
           ng-click="openQuestionItemWin($event)">
            <span class="icon-new"></span>
            New
        </a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <jqx-grid id="_questionItemTable"
                  jqx-settings="questionItemTableSettings"
                  jqx-on-rowdoubleclick="editQuestionItemTable($event)">
        </jqx-grid>
    </div>
</div>
<!-- WINDOWS WITH FORM OF ITEM QUESTIONS -->
<jqx-window jqx-on-close="close()" jqx-settings="questionItemWindowsSettings"
            jqx-create="questionItemWindowsSettings" class="">
    <div>
        Add New Question Item
    </div>
    <div>
        <div class="col-md-12 col-md-offset-0">
            <div class="row itemQuestionFormContainer">
                <div style=" width:100%;float:left;">
                    <div style="float:left; padding:2px; width:500px;">
                        <div
                            style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">
                            Item:
                        </div>
                        <div style="float:left; width:300px;">
                            <jqx-combo-box
                                jqx-settings="itemsCbxSettings"
                                jqx-on-select="itemsCbxSelecting(event)"
                                id="qItem_ItemUnique" class="required-in">
                            </jqx-combo-box>
                        </div>
                        <div style="float:left;">
                                                        <span
                                                            style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                        </div>
                    </div>

                    <div style="float:left; padding:2px; width:500px;">
                        <div
                            style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">
                            Sell Price:
                        </div>
                        <div style="float:left; width:300px;">
                            <jqx-number-input id="qItem_SellPrice"
                                              jqx-symbol="$ "
                                              jqx-input-mode="'simple'"
                                              jqx-disabled="questionDisabled"
                                              jqx-width="'290px'"
                                              jqx-height="25"
                                              jqx-text-align="left"
                                              jqx-decimal-digits="<?php echo $decimalsPrice; ?>"

                            ></jqx-number-input>
                        </div>
                        <div style="float:left;">
                                                        <span
                                                            style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                        </div>
                    </div>

                    <div style="float:left; padding:2px; width:500px; ">
                        <div
                            style=" float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">
                            Label:
                        </div>
                        <div style=" float:left; width:300px; ">
                                                        <textarea class="form-control required-in" id="qItem_Label"
                                                                  name="qItem_Label" placeholder="Label"
                                                                  cols="30" rows="3"></textarea>
                        </div>
                        <div style="float:left;">
                                                        <span
                                                            style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                        </div>
                    </div>

                    <div style=" float:left; padding:2px; width:500px; ">
                        <div
                            style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">
                            Sort:
                        </div>
                        <div style=" float:left; width:300px;">
                            <jqx-number-input
                                style='margin-top: 3px;padding-left: 10px;' class="form-control required-in"
                                id="qItem_sort" name="qItem_sort"
                                jqx-settings="numberItemQuestion" jqx-min="1" jqx-value="1"
                            ></jqx-number-input>
                        </div>
                        <div style="float:left;">
                                                        <span
                                                            style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <div id="mainQItemButtons">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="button" id="saveQuestionItemBtnOnQuestionTab"
                                    ng-click="saveItemByQuestion()"
                                    class="btn btn-primary" disabled>
                                Save
                            </button>
                            <button type="button" id=""
                                    ng-click="closeQuestionItemWin()"
                                    class="btn btn-warning">
                                Close
                            </button>
                            <!--                                                        <button type="button" id="deleteQuestionItemBtnOnQuestionTab"-->
                            <!--                                                                ng-click="deleteItemByQuestion()"-->
                            <!--                                                                class="btn btn-danger" style="overflow:auto;">-->
                            <!--                                                            Delete-->
                            <!--                                                        </button>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BUTTONS TO PROMPT SAVING CHANGES-->
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <div id="promptToCloseQItemForm" class="alertButtonsQuestionForm">
                    <div class="form-group">
                        <div class="col-sm-12">
                            Do you want to save your changes?
                            <button type="button" ng-click="closeQuestionItemWin(0)"
                                    class="btn btn-primary">Yes
                            </button>
                            <button type="button" ng-click="closeQuestionItemWin(1)"
                                    class="btn btn-warning">No
                            </button>
                            <button type="button" ng-click="closeQuestionItemWin(2)"
                                    class="btn btn-info">Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- PROMPT TO DELETE QUESTION ITEM -->
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <div id="promptToDeleteQItemForm" class="alertButtonsQuestionForm">
                    <div class="form-group">
                        <div class="col-sm-12">
                            Do you want to save your changes?
                            <button type="button" ng-click="deleteItemByQuestion(0)"
                                    class="btn btn-primary">Yes
                            </button>
                            <button type="button" ng-click="deleteItemByQuestion(1)"
                                    class="btn btn-warning">No
                            </button>
                            <button type="button" ng-click="deleteItemByQuestion(2)"
                                    class="btn btn-info">Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- NOTIFICATIONS AREA -->
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <jqx-notification jqx-settings="qItemSuccessNotif"
                                  id="qItemSuccessNotif">
                    <div id="notification-content"></div>
                </jqx-notification>
                <jqx-notification jqx-settings="qItemErrorNotif"
                                  id="qItemErrorNotif">
                    <div id="notification-content"></div>
                </jqx-notification>
                <div id="qItemNotification"
                     style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
            </div>
        </div>
    </div>
</jqx-window>