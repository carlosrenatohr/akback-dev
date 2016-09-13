<div class="gridContentTab">
    <div>
        <a style="outline:0;margin: 10px 2px;" class="btn btn-info" ng-click="openQuestionWindow()">
            <span class="icon-32-new"></span>
            New
        </a>
    </div>
    <jqx-grid id="questionMainTable"
                jqx-settings="questionTableSettings"
                jqx-on-rowdoubleclick="editQuestionWindow($event)">
    </jqx-grid>

    <!-- WINDOWS FOR ADD/EDIT QUESTIONS   -->
    <jqx-window jqx-on-close="close()" jqx-settings="questionWindowsFormSettings"
                jqx-create="questionWindowsFormSettings" id="questionWindowsForm">
        <div>
            Add new Question
        </div>

        <div>
            <div id="questionWindowForm">
                <div class="col-md-12 col-md-offset-0">
                    <jqx-tabs jqx-width="'100%'" jqx-height="'300'"
                              jqx-settings="questionstabsSettings"
                              id="questionstabsWin">
                        <ul style=" margin-left: 10px;">
                            <li id="question-tab-1">Question</li>
                            <li id="item-tab-2">Choices</li>
                        </ul>
                        <div class="col-md-12 question-tabs" id="question-tab1">
                            <div class="row">
                                <div style=" width:500px;float:left;">
                                    <div style="float:left; padding:2px; width:450px;">
                                        <div
                                            style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">
                                            Name:
                                        </div>
                                        <div style=" float:left; width:300px;">
                                            <input type="text" class="form-control required-field" id="qt_QuestionName"
                                                   name="qt_QuestionName" placeholder="Question Name" autofocus>
                                        </div>
                                        <div style="float:left;">
                                            <span
                                                style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                        </div>
                                    </div>

                                    <div style="float:left; padding:2px; width:450px;">
                                        <div
                                            style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">
                                            Question:
                                        </div>
                                        <div style="float:left; width:300px;">
                                            <input type="text" class="form-control required-field" id="qt_Question"
                                                   name="qt_Question" placeholder="Question">
                                        </div>
                                        <div style="float:left;">
                                            <span
                                                style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                        </div>
                                    </div>

                                    <div style="float:left; padding:2px; width:450px;">
                                        <div
                                            style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">
                                            Sort:
                                        </div>
                                        <div style=" float:left; width:300px;">
                                            <jqx-number-input
                                                style='margin-top: 3px;padding-left: 10px;' class="form-control required-field"
                                                id="qt_sort" name="qt_sort"
                                                jqx-settings="numberQuestion"
                                                jqx-digits="2"
                                            ></jqx-number-input>
                                        </div>
                                        <div style="float:left;">
                                            <span
                                                style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                        </div>
                                    </div>

                                    <div style=" float:left; padding:2px; width:500px; ">
                                        <div
                                            style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">
                                            Minimum:
                                        </div>
                                        <div style=" float:left; width:300px;">
                                            <jqx-number-input
                                                style='margin-top: 3px;padding-left: 10px;' class="form-control required-field"
                                                id="qt_min" name="qt_min"
                                                jqx-settings="numberQuestion"
                                                jqx-digits="4"
                                            ></jqx-number-input>
                                        </div>
                                        <div style="float:left;">
                                            <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                        </div>
                                    </div>

                                    <div style=" float:left; padding:2px; width:500px; ">
                                        <div
                                            style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">
                                            Maximum:
                                        </div>
                                        <div style=" float:left; width:300px;">
                                            <jqx-number-input
                                                style='margin-top: 3px;padding-left: 10px;' class="form-control required-field"
                                                id="qt_max" name="qt_max"
                                                jqx-settings="numberQuestion"
                                                jqx-digits="4"
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
                        <!-- QUESTION TAB WITH ITEMS-QUESTIONS -->
                        <div class="col-md-12 question-tabs" id="question-tab2">
                            <div class="row">
                                <div class="col-md-6">
                                    <a style="outline:0;margin: 10px 2px;" class="btn btn-info"
                                       ng-click="openQuestionItemWin($event)">
                                        <span class="icon-32-new"></span>
                                        New
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <jqx-data-table id="_questionItemTable"
                                                    jqx-settings="questionItemTableSettings"
                                                    jqx-on-row-double-click="editQuestionItemTable($event)">
                                    </jqx-data-table>
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
                                                        <button type="button" id="deleteQuestionItemBtnOnQuestionTab"
                                                                ng-click="deleteItemByQuestion()"
                                                                class="btn btn-danger" style="overflow:auto;">
                                                            Delete
                                                        </button>
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
                        </div>
                    </jqx-tabs>
            </div>
            <!-- MAIN BUTTONS FOR QUESTIONS FORM -->
            <div class="col-md-12 col-md-offset-0 QuestionWindowsRow">
                <div class="row">
                    <div id="mainButtonsQuestionForm">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="button" id="saveQuestionBtn" ng-click="saveQuestionWindow()"
                                        class="btn btn-primary" disabled>
                                    Save
                                </button>
                                <button type="button" id="" ng-click="closeQuestionWindow()" class="btn btn-warning">
                                    Close
                                </button>
                                <button type="button" id="deleteQuestionBtn" ng-click="beforeDeleteQuestion()"
                                        class="btn btn-danger " style="display:none; overflow:auto;">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- BUTTONS TO PROMPT SAVING CHANGES-->
            <div class="col-md-12 col-md-offset-0 QuestionWindowsRow">
                <div class="row">
                    <div id="promptToCloseQuestionForm" class="alertButtonsQuestionForm">
                        <div class="form-group">
                            <div class="col-sm-12">
                                Do you want to save your changes?
                                <button type="button" ng-click="closeQuestionWindow(0)" class="btn btn-primary">Yes
                                </button>
                                <button type="button" ng-click="closeQuestionWindow(1)" class="btn btn-warning">No
                                </button>
                                <button type="button" ng-click="closeQuestionWindow(2)" class="btn btn-info">Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- PROMPT DELETE -->
            <div class="col-md-12 col-md-offset-0 QuestionWindowsRow">
                <div class="row">
                    <div id="promptToDeleteQuestionForm" class="alertButtonsQuestionForm">
                        <div class="form-group">
                            <div class="col-sm-12">
                                Do you want to delete it?
                                <button type="button" ng-click="beforeDeleteQuestion(0)" class="btn btn-primary">Yes
                                </button>
                                <button type="button" ng-click="beforeDeleteQuestion(1)" class="btn btn-warning">No
                                </button>
                                <button type="button" ng-click="beforeDeleteQuestion(2)" class="btn btn-info">Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- NOTIFICATIONS AREA -->
            <div class="col-md-12 col-md-offset-0 QuestionWindowsRow">
                <div class="row">
                    <jqx-notification jqx-settings="questionNotificationsSuccessSettings"
                                      id="questionNotificationsSuccessSettings">
                        <div id="notification-content"></div>
                    </jqx-notification>
                    <jqx-notification jqx-settings="questionNotificationsErrorSettings"
                                      id="questionNotificationsErrorSettings">
                        <div id="notification-content"></div>
                    </jqx-notification>
                    <div id="notification_container"
                         style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
                </div>
            </div>
        </div>
        </div>
    </jqx-window>
    <style>
        #questionWindowForm .question-tabs {
            padding-top: 10px;
            padding-bottom: 5px;
            background-color: #f5f5f5;
            border: 1px solid #dddddd;
            height: 390px;
        }

        .alertButtonsQuestionForm {
            display: none;
        }
    </style>
</div>
