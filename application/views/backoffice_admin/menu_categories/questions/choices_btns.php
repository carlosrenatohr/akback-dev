<div class="col-md-12 col-md-offset-0">
    <div class="row">
        <div id="mainQItemButtons">
            <div class="form-group">
                <div class="col-sm-12">
                    <button type="button" id="saveQuestionItemBtnOnQuestionTab"
                            ng-click="saveItemByQuestion()"
                            class="btn btn-primary" disabled
                    >Save</button>
                    <button type="button" id=""
                            ng-click="closeQuestionItemWin()"
                            class="btn btn-warning"
                    >Close</button>
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
        <div id="qItemNotification" style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
    </div>
</div>