<style>
    #stocklWind .row {
        margin: 0 0 12px;
    }
</style>
<div class="col-md-12 inventory_tab">
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <div class="">
                    <button class="btn btn-primary" ng-click="openStockWind()">
                        <img src="<?php echo base_url("assets/img/kahon.png") ?>"/>
                    </button>
                    Adjust Quantity <?php echo $station; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <div>
                    <jqx-combo-box id="itemstock_locationCbx"
                                   jqx-settings="stockitemLocationSettings"
                                   jqx-on-select="onSelectStockLocationList($event)"
                                   jqx-selected-index="<?php echo $station;?>">
                    </jqx-combo-box>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div id="" style="overflow:auto; height:auto;">
                <jqx-grid id="stockLevelItemGrid"
                          jqx-settings="stockInventoryGrid"
                          jqx-create="stockInventoryGrid"
                ></jqx-grid>
            </div>
        </div>
    </div>
    <!--    -->
    <!--    -->
    <!--    -->
</div>

<jqx-window id="stocklWind"
            jqx-settings="stockWind"
            jqx-create="stockWind">
    <div class="">
        Adjusting Quantity
    </div>
    <div class="">
        <div class="row">
            <label  class="col-sm-4 control-label" style="text-align:right">Current Quantity in
                Stock:</label>

            <div class="col-sm-4">
                <jqx-number-input id="stockl_currentQty" class="stockl_input"
                                  jqx-width="200" jqx-height="30"
                                  jqx-spin-buttons="false" jqx-input-mode="simple"
                                  jqx-symbol="''"
                                  jqx-decimal-digits="<?= $decimalsQuantity; ?>"
                                  ng-model="inventoryData.stockQty"
                                  ng-disabled="inventoryDisabled"
                ></jqx-number-input>
            </div>
        </div>
        <div class="row">
            <label  class="col-sm-4 control-label" style="text-align:right">Quantity to Add or
                Remove:</label>

            <div class="col-sm-4">
                <jqx-number-input id="stockl_addremoveQty" class="stockl_input"
                                  jqx-width="200" jqx-height="30"
                                  jqx-spin-buttons="false" jqx-input-mode="simple"
                                  jqx-symbol="''" ng-change="modifyCurrentQty(0)"
                                  jqx-decimal-digits="<?= $decimalsQuantity; ?>"
                                  ng-model="inventoryData.addremoveQty"
                ></jqx-number-input>
            </div>
        </div>
        <div class="row">
            <label  class="col-sm-4 control-label" style="text-align:right">New Quantity</label>

            <div class="col-sm-4">
                <jqx-number-input id="stockl_newQty" class="stockl_input"
                                  jqx-width="200" jqx-height="30"
                                  jqx-spin-buttons="false" jqx-input-mode="simple"
                                  jqx-symbol="''" ng-change="modifyCurrentQty(1)"
                                  jqx-decimal-digits="<?= $decimalsQuantity; ?>"
                                  ng-model="inventoryData.newQty"
                ></jqx-number-input>
            </div>
        </div>
        <div class="row">
            <label  class="col-sm-4 control-label" style="text-align:right">Transaction
                Date</label>

            <div class="col-sm-4">
                <jqx-date-time-input
                    id="stockl_transDate" class="stockl_input"
                    jqx-format-string="d"
                ></jqx-date-time-input>
            </div>
        </div>
        <div class="row">
            <label  class="col-sm-4 control-label" style="text-align:right">Transaction
                Time:</label>

            <div class="col-sm-4">
                <jqx-date-time-input
                    id="stockl_transTime" class="stockl_input"
                    jqx-format-string="T"
                    jqx-show-time-button="true"
                    jqx-show-calendar-button="false"
                ></jqx-date-time-input>
            </div>
        </div>
        <div class="row">
            <label  class="col-sm-4 control-label" style="text-align:right">Location:</label>

            <div class="col-sm-4">
                <jqx-combo-box id="stockl_location" class="stockl_input"
                               jqx-settings="stockitemLocation2Settings"
                               jqx-selected-index="<?php echo $station;?>"
                               jqx-on-select="">
                </jqx-combo-box>
            </div>
        </div>
        <div class="row">
            <label  class="col-sm-4 control-label" style="text-align:right">Comment:</label>

            <div class="col-sm-6">
                    <textarea id="stockl_comment" class="form-control stockl_input"
                              cols="5" rows="3"
                    ></textarea>
            </div>
        </div>
        <!--  -->
        <!--  -->
        <!--  -->
        <br>
        <div id="mainButtonsStockl">
            <div class="col-md-8">
                <button type="button" ng-click="saveStockWind()"
                        id="saveStockBtn" class="btn btn-primary" disabled>Save</button>
                <button type="button" ng-click="closeStockWind()"
                        id="deleteStockBtn" class="btn btn-warning">Close</button>
            </div>
        </div>
        <div id="promptButtonsStockl" style="display:none; margin-top:10px; overflow:auto;">
            <div class="col-sm-8">
                Would you like to save your changes. <br>
                <button type="button" ng-click="closeStockWind(0)" class="btn btn-primary">Yes</button>
                <button type="button" ng-click="closeStockWind(1)" class="btn btn-warning">No</button>
                <button type="button" ng-click="closeStockWind(2)" class="btn btn-info">Cancel</button>
            </div>
        </div>
    </div>
</jqx-window>
<input type="hidden" id="stationID" value="<? echo $station; ?>">