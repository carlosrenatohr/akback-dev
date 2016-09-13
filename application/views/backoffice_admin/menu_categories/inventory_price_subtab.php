<div class="col-md-12 inventory_tab">
    <div class="row">
        <div class="form-group">
            <label for="inputType" class="col-sm-3 control-label">List Price:</label>

            <div class="col-sm-4">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <jqx-number-input id="itemp_listprice" class="item_textcontrol"
                                      jqx-width="120" jqx-height="30"
                                      jqx-spin-buttons="false" jqx-input-mode="simple"
                                      jqx-symbol="''" ng-change=""
                                      jqx-decimal-digits="<?= $decimalsPrice; ?>"
                                      ng-model="inventoryData.listPrice"
                                      ng-disabled="inventoryDisabled"
                    ></jqx-number-input>
                </div>
            </div>
        </div>
    </div>

<div class="row">
    <div class="form-group">
        <label for="inputType" class="col-sm-3 control-label">Price1:</label>

        <div class="col-sm-4">
            <div class="input-group">
                <span class="input-group-addon">$</span>
                <jqx-number-input id="itemp_price1" class="item_textcontrol"
                                  jqx-width="120" jqx-height="30"
                                  jqx-spin-buttons="false" jqx-input-mode="simple"
                                  jqx-symbol="''" ng-change="EditInventoryChange()"
                                  jqx-decimal-digits="<?= $decimalsPrice; ?>"
                                  ng-model="inventoryData.price1"
                                  ng-disabled="inventoryDisabled"
                ></jqx-number-input>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <label for="inputType" class="col-sm-3 control-label">Price2:</label>

        <div class="col-sm-4">
            <div class="input-group">
                <span class="input-group-addon">$</span>
                <jqx-number-input id="itemp_price2" class="item_textcontrol"
                                  jqx-width="120" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple"
                                  jqx-symbol="''" ng-change="EditInventoryChange()"
                                  jqx-decimal-digits="<?= $decimalsPrice; ?>"
                                  data-field="price2"
                                  ng-model="inventoryData.price2"
                ></jqx-number-input>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <label for="inputType" class="col-sm-3 control-label">Price3:</label>

        <div class="col-sm-4">
            <div class="input-group">
                <span class="input-group-addon">$</span>
                <jqx-number-input id="itemp_price3" class="item_textcontrol"
                                  jqx-width="120" jqx-height="30" jqx-spin-buttons="false"
                                  jqx-input-mode="simple" jqx-symbol="''" ng-change="EditInventoryChange()"
                                  jqx-decimal-digits="<?= $decimalsPrice; ?>"
                                  ng-model="inventoryData.price3"
                                  data-field="price3"
                ></jqx-number-input>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <label for="inputType" class="col-sm-3 control-label">Price4:</label>

        <div class="col-sm-4">
            <div class="input-group">
                <span class="input-group-addon">$</span>
                <jqx-number-input id="itemp_price4" class="item_textcontrol"
                                  jqx-width="120" jqx-height="30" jqx-spin-buttons="false"
                                  jqx-input-mode="simple" jqx-symbol="''" ng-change="EditInventoryChange()"
                                  jqx-decimal-digits="<?= $decimalsPrice; ?>"
                                  ng-model="inventoryData.price4"
                                  data-field="price4"
                ></jqx-number-input>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <label for="inputType" class="col-sm-3 control-label">Price5:</label>

        <div class="col-sm-4">
            <div class="input-group">
                <span class="input-group-addon">$</span>
                <jqx-number-input id="itemp_price5" class="item_textcontrol"
                                  jqx-width="120" jqx-height="30" jqx-spin-buttons="false"
                                  jqx-input-mode="simple" jqx-symbol="''" ng-change="EditInventoryChange()"
                                  jqx-decimal-digits="<?= $decimalsPrice; ?>"
                                  ng-model="inventoryData.price5"
                                  data-field="price5"
                ></jqx-number-input>
            </div>
        </div>
    </div>
</div>
</div>