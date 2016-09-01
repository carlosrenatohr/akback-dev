<div class="col-md-12 inventory_tab">
    <div class="row">
        <div class="form-group">
            <label for="inputType" class="col-sm-3 control-label">List Price:</label>

            <div class="col-sm-4">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <jqx-number-input id="itemp_listprice" class="item_textcontrol"
                                      jqx-width="90" jqx-height="30"
                                      jqx-spin-buttons="false" jqx-input-mode="simple"
                                      jqx-symbol="''" ng-change="EditInventoryChange()"
                                      ng-disabled="coslandedDisabled" ng-model="listprice.amount"
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
                                  jqx-width="90" jqx-height="30"
                                  jqx-spin-buttons="false" jqx-input-mode="simple"
                                  jqx-symbol="''" ng-change="EditInventoryChange()"
                                  ng-disabled="coslandedDisabled" ng-model="price1.amount"
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
                                  jqx-width="90" jqx-height="30" jqx-spin-buttons="false" jqx-input-mode="simple"
                                  jqx-symbol="''" ng-change="EditInventoryChange()"
                                  ng-model="price2.amount" data-field="price2"
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
                                  jqx-width="90" jqx-height="30" jqx-spin-buttons="false"
                                  jqx-input-mode="simple" jqx-symbol="''" ng-change="EditInventoryChange()"
                                  ng-model="price3.amount" data-field="price3"
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
                                  jqx-width="90" jqx-height="30" jqx-spin-buttons="false"
                                  jqx-input-mode="simple" jqx-symbol="''" ng-change="EditInventoryChange()"
                                  ng-model="price4.amount" data-field="price4"
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
                                  jqx-width="90" jqx-height="30" jqx-spin-buttons="false"
                                  jqx-input-mode="simple" jqx-symbol="''" ng-change="EditInventoryChange()"
                                  ng-model="price5.amount" data-field="price5"
                ></jqx-number-input>
            </div>
        </div>
    </div>
</div>
</div>