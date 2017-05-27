<div class="col-md-12 inventory_tab">

    <div class="row">
        <div class="form-group">
            <label for="inputType" class="  control-label" style="width:120px;float:left;text-align:right">Cost:</label>
            <div class="col-sm-6">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <jqx-number-input id="menuitemmodal_cost" class="menuitem_pricesControls"
                                      jqx-width="120" jqx-height="30"
                                      jqx-spin-buttons="false" jqx-input-mode="simple"
                                      jqx-symbol="''"
                                      jqx-decimal-digits="<?= $decimalsPrice; ?>"
                                      ng-change="onChangeCostFieldsMenuItem()"
                                      ng-model="cost"
                                      data-field="Cost"
                    ></jqx-number-input>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <label for="inputType" class="  control-label" style="width:120px;float:left;text-align:right">Cost Extra:</label>
            <div class="col-sm-6">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <jqx-number-input id="menuitemmodal_Cost_Extra" class="menuitem_pricesControls"
                                      jqx-width="120" jqx-height="30"
                                      jqx-spin-buttons="false"
                                      jqx-input-mode="simple" jqx-symbol="''"
                                      jqx-decimal-digits="<?= $decimalsPrice; ?>"
                                      ng-change="onChangeCostFieldsMenuItem()"
                                      ng-model="costExtra"
                                      data-field="Cost_Extra"
                    ></jqx-number-input>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <label for="inputType" class="  control-label" style="width:120px;float:left;text-align:right">Cost Freight:</label>
            <div class="col-sm-6">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <jqx-number-input id="menuitemmodal_Cost_Freight" class="menuitem_pricesControls"
                                      jqx-width="120" jqx-height="30"
                                      jqx-spin-buttons="false" jqx-input-mode="simple"
                                      jqx-symbol="''" ng-change="onChangeCostFieldsMenuItem()"
                                      jqx-decimal-digits="<?= $decimalsPrice; ?>"
                                      ng-model="costFreight"
                                      data-field="Cost_Freight"
                    ></jqx-number-input>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <label for="inputType" class="  control-label" style="width:120px;float:left;text-align:right">Cost Duty:</label>
            <div class="col-sm-6">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <jqx-number-input id="menuitemmodal_Cost_Duty" class="menuitem_pricesControls"
                                      jqx-width="120" jqx-height="30"
                                      jqx-spin-buttons="false" jqx-input-mode="simple"
                                      jqx-symbol="''" ng-change="onChangeCostFieldsMenuItem()"
                                      jqx-decimal-digits="<?= $decimalsPrice; ?>"
                                      ng-model="costDuty"
                                      data-field="Cost_Duty"
                    ></jqx-number-input>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <label for="inputType" class="  control-label" style="width:120px;float:left;text-align:right">Cost Landed:</label>
            <div class="col-sm-6">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <jqx-number-input id="menuitemmodal_Cost_Landed" class="menuitem_pricesControls"
                                      jqx-width="120" jqx-height="30"
                                      jqx-spin-buttons="false" jqx-input-mode="simple"
                                      jqx-symbol="''" ng-change="onChangeCostFieldsMenuItem()"
                                      jqx-decimal-digits="<?= $decimalsPrice; ?>"
                                      ng-model="costLanded"
                                      ng-disabled="menuItemDisabled"
                    ></jqx-number-input>
                </div>
            </div>
        </div>
    </div>

</div>