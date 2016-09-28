<div class="col-md-12 col-md-offset-0">
    <div class="row editItemFormContainer">
        <div style=" width:100%;float:left;margin: 15px 0;">
            <div style="float:left; padding:2px; width:650px;">
                <div style="float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">Item:</div>
                <div style="float:left; width:300px;">
                    <jqx-combo-box
                        jqx-on-select="itemsComboboxSelecting(event)"
                        jqx-on-unselect=""
                        jqx-settings="itemsComboboxSettings"
                        id="editItem_ItemSelected">
                    </jqx-combo-box>
                </div>
            </div>

            <div style="float:left; padding:2px; width:650px; ">
                <div style=" float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">Description:</div>
                <div style=" float:left; width:300px;">
                    <input type="text" class="form-control menuitem_extraControls" id="itemcontrol_description"
                           name="itemcontrol_description" placeholder="Description">
                </div>
            </div>

            <div style="float:left; padding:2px; width:650px; ">
                <div style=" float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">Label:</div>
                <div style=" float:left; width:300px;">
                    <input type="text" class="form-control required-field" id="editItem_label"
                           name="editItem_label" placeholder="Label">
                </div>
                <div style="float:left;">
                    <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                </div>
                <div class="" ng-if="itemLengthOfMenuSelected != null">
                    <label for="">Maximum Characters: {{ itemLengthOfMenuSelected }}</label>
                </div>
            </div>

            <div style="float:left; padding:2px; width:650px; ">
                <div style=" float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">Main Printer:</div>
                <div style=" float:left; width:300px;">
                    <jqx-drop-down-list id="mainPrinterSelect" class=""
                                        jqx-settings="printerItemList"
                                        jqx-width="'100%'"
                                        jqx-on-select="">
                    </jqx-drop-down-list>
                </div>
            </div>

            <div style="float:left; padding:2px; width:650px; ">
                <div style=" float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">
                    List Price:
                </div>

                <div style=" float:left; width:300px;">
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <jqx-number-input id="itemcontrol_lprice" class="form-control menuitem_pricesControls"
                                          jqx-width="'190px'" jqx-height="'30px'"
                                          jqx-spin-buttons="false" jqx-input-mode="simple"
                                          jqx-symbol="''"
                                          jqx-decimal-digits="<?= $decimalsPrice; ?>"
                        ></jqx-number-input>
                    </div>
                </div>
            </div>

            <div style="float:left; padding:2px; width:650px; ">
                <div style=" float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">
                    Sell Price:
                </div>

                <div style=" float:left; width:300px;">
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <jqx-number-input id="itemcontrol_sprice" class="form-control menuitem_pricesControls"
                                          jqx-width="'190px'" jqx-height="'30px'"
                                          jqx-spin-buttons="false" jqx-input-mode="simple"
                                          jqx-symbol="''"
                                          jqx-decimal-digits="<?= $decimalsPrice; ?>"
                        ></jqx-number-input>
                    </div>
                </div>
            </div>

<!--            <div style=" float:left; padding:2px; width:650px; ">-->
<!--                <div style="float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">Row:</div>-->
<!--                <div style=" float:left; width:300px;">-->
<!--                    <jqx-number-input-->
<!--                        style='margin-top: 3px;' class="form-control required-field"-->
<!--                        id="editItem_Row" name="editItem_Row"-->
<!--                        jqx-settings="numberMenuItem"-->
<!--                    ></jqx-number-input>-->
<!--                </div>-->
<!--                <div style="float:left;">-->
<!--                    <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--            <div style=" float:left; padding:2px; width:650px; ">-->
<!--                <div style="float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">Column:</div>-->
<!--                <div style=" float:left; width:300px;">-->
<!--                    <jqx-number-input-->
<!--                        style='margin-top: 3px;' class="form-control required-field"-->
<!--                        id="editItem_Column" name="editItem_Column"-->
<!--                        jqx-settings="numberMenuItem"-->
<!--                    ></jqx-number-input>-->
<!--                </div>-->
<!--                <div style="float:left;">-->
<!--                    <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--            <div style=" float:left; padding:2px; width:650px; ">-->
<!--                <div style="float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">Sort:</div>-->
<!--                <div style=" float:left; width:300px;">-->
<!--                    <jqx-number-input-->
<!--                        style='margin-top: 3px;' class="form-control required-field"-->
<!--                        id="editItem_sort" name="editItem_sort"-->
<!--                        jqx-settings="numberMenuItem"-->
<!--                    ></jqx-number-input>-->
<!--                </div>-->
<!--                <div style="float:left;">-->
<!--                    <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--            <div style=" float:left; padding:2px; width:650px; ">-->
<!--                <div style="float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">Status:</div>-->
<!--                <div style=" float:left; width:300px;">-->
<!--                    <select name="editItem_Status" id="editItem_Status">-->
<!--                        <option value="1">Enabled</option>-->
<!--                        <option value="2">Disabled</option>-->
<!--                    </select>-->
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
</div>