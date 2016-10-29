<div class="col-md-12 col-md-offset-0">
    <div class="row">
        <div class="col-md-12" style="margin-top: 10px;">
            <jqx-grid id="customerCardTabGrid"
                      jqx-settings="customerCardTabSettings"
                      jqx-on-rowdoubleclick="editCustomerCard(e)"

            ></jqx-grid>
            <!--  -->
            <jqx-window id="CustomerCardWin"
                        jqx-settings="CustomerCardWinSettings"
                        jqx-on-create="CustomerCardWinSettings">
                <div>
                    Customer Card
                </div>
                <div class="">
                    <div class="col-md-12 col-md-offset-0" style="margin-top: 12px;">
                        <div class="col-md-8">
                            <div class="form-group">
                                <p>
                                    <b>Card:</b> <span id="ccard_card"></span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <p>
                                    <b>Card Type: </b><span id="ccard_type"></span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <p id="CreatedSection">
                                    <b>Created by:</b> <span id="ccard_createdBy"></span>
                                    at <span id="ccard_createdAt"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- MAIN BUTTONS   -->
                    <div class="col-md-12 col-md-offset-0">
                        <div class="form-group" id="mainCCardButtons">
                            <div class="col-sm-12">
                                <button type="button" id=""
                                        ng-click="closeCustomerCard()"
                                        class="btn btn-warning">
                                    Close
                                </button>
                                <button type="button" id=""
                                        ng-click="deleteCustomerCard()"
                                        class="btn btn-danger">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Prompt before delete an item on grid -->
                    <div class="col-md-12 col-md-offset-0">
                        <div id="promptToDeleteCCard" class="" style="display: none">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <p>Do you really want to delete it?</p>
                                    <button type="button" ng-click="deleteCustomerCard(0)" class="btn btn-primary">Yes</button>
                                    <button type="button" ng-click="deleteCustomerCard(1)" class="btn btn-warning">No</button>
                                    <button type="button" ng-click="deleteCustomerCard(2)" class="btn btn-info">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- NOTIFICATIONS AREA -->
<!--                    <div class="col-md-12 col-md-offset-0">-->
<!--                        <jqx-notification jqx-settings="customerNotesSuccessSettings" id="customerNotesSuccessSettings">-->
<!--                            <div id="notification-content"></div>-->
<!--                        </jqx-notification>-->
<!--                        <jqx-notification jqx-settings="customerNotesErrorSettings" id="customerNotesErrorSettings">-->
<!--                            <div id="notification-content"></div>-->
<!--                        </jqx-notification>-->
<!--                        <div id="customerNotesNoticeContainer" style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>-->
<!--                    </div>-->
                </div>
            </jqx-window>
        </div>
    </div>
</div>