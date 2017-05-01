<div class="gridContentTab">
    <div>
        <a style="outline:0;margin: 10px 2px;" class="btn btn-info" ng-click="openQuestionWindow()">
            <span class="icon-new"></span>
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
                            <li id="item-tab-2">Picture</li>
                            <li id="item-tab-2">Style</li>
                        </ul>
                        <div class="col-md-12 question-tabs" id="question-tab1">
                            <?php $this->load->view($questions_data_subtab); ?>
                        </div>
                        <!-- QUESTION TAB WITH ITEMS-QUESTIONS -->
                        <div class="col-md-12 question-tabs" id="question-tab2">
                            <?php $this->load->view($questions_choices_subtab); ?>
                        </div>
                        <div class="col-md-12 question-tabs" id="question-tab4">
                            <?php $this->load->view($questions_picture_subtab); ?>
                        </div>
                        <div class="col-md-12 question-tabs" id="question-tab3">
                            <?php $this->load->view($questions_style_subtab); ?>
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
        #questionWindowsForm {
            max-height: 85%!important;
            max-width: 85%!important;
        }
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
