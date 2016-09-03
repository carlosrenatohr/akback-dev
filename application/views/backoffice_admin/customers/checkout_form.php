<jqx-window jqx-settings="checkoutFormWindowSettings"
            jqx-on-create="checkoutFormWindowSettings"
            id="checkoutFormWindow">
    <div class="">
        Check out Form | Customer:
    </div>
    <div class="">
        <div class="col-md-12 col-md-offset-0" id="checkOutForm">
            <!-- NEW DELETE BUTTON -->
            <button class="icon-32-trash"
                    id="checkoutDeleteBtn"
                    ng-click="checkoutCloseBtn(undefined, 0, checkinType)"
            ></button>
            <div class="row menuFormContainer">
                <div style="float:left;">
                    <div style="float:left; padding:2px; width:450px;">
                        <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Name:</div>
                        <div style="float:left; width:250px;margin-top: 0.6em;">
                            <p id="customerNameP"></p>
                        </div>
                    </div>

                    <div style="float:left; padding:2px; width:450px;">
                        <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Check In By:</div>
                        <div style="float:left; width:250px;margin-top: 0.6em;">
                            <p id="checkInP"></p>
                        </div>
                    </div>

                    <div style="float:left; padding:2px; width:450px;">
                        <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Check Out By:</div>
                        <div style="float:left; width:250px;margin-top: 0.6em;">
                            <p id="checkOutP"></p>
                        </div>
                    </div>

                    <div style="float:left; padding:2px; width:450px;">
                        <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Location:</div>
                        <div style="float:left; width:250px;">
<!--                            <p id="LocationP"></p>-->
                            <jqx-drop-down-list jqx-width="250" jqx-height="30" id="locationSelect">
                                <?php foreach($locations as $location): ?>
                                <option value="<?php echo $location['Unique']; ?>"
                                    ><?php echo $location['Name']; ?></option>
                                <?php endforeach; ?>
                            </jqx-drop-down-list>
                        </div>
                    </div>

                    <div style="float:left; padding:2px; width:450px;">
                        <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Quantity:</div>
                        <div style="float:left; width:250px;">
                            <jqx-number-input
                                class="" id="QuantityControl"
                                jqx-settings="numberDecimalSettings"
                                jqx-text-align="left"
                            ></jqx-number-input>
                        </div>
                    </div>

                    <div style="float:left; padding:2px; width:450px;">
                        <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Note:</div>
                        <div style="float:left; width:250px;">
                            <textarea name="CheckOut_note" id="NoteControl" cols="10" rows="2"
                                      class="form-control required-field" placeholder="Note"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- -->
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <div id="mainButtonsCheckoutForm">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="button" id="checkoutCloseBtn"
                                    ng-click="checkoutCloseBtn(undefined, 1, checkinType)"
                                    class="btn btn-warning">
                                Close
                            </button>
<!--                            <button type="button" id="checkoutDeleteBtn"-->
<!--                                    ng-click="checkoutCloseBtn(undefined, 0, checkinType)"-->
<!--                                    class="btn btn-danger" style="overflow:auto;">-->
<!--                                Delete-->
<!--                            </button>-->
                            <button type="button" id="checkoutCompleteBtn"
                                    ng-click="checkoutCloseBtn(undefined, 2, checkinType)"
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
                <div id="promptToCloseCheckoutForm" class="" style="display: none">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <p>---</p>
                            <button type="button" ng-click="checkoutCloseBtn(0, selectedCheckinStatus, checkinType)" class="btn btn-primary">Yes</button>
                            <button type="button" ng-click="checkoutCloseBtn(1, selectedCheckinStatus, checkinType)" class="btn btn-warning">No</button>
                            <button type="button" ng-click="checkoutCloseBtn(2, selectedCheckinStatus, checkinType)" class="btn btn-info">Cancel</button>
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

<style>
    #QuantityControl{
        width:250px!important;
    }
    .icon-32-trash {
        position: absolute;
        right:0;
        background: url("../../assets/img/icon-32-trash.png") 0 5px no-repeat;
        background-size: 80%;
        width:25px;
        height:25px;
        border:0;
        outline: 0;
    }
</style>