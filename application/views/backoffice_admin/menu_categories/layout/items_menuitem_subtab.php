<div class="col-md-12 col-md-offset-0">
    <div class="row editItemFormContainer">
        <div style=" width:100%;float:left;margin: 15px 0;">
            <div style="float:left; padding:2px; width:100%;">
                <div style="float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">Item:</div>
                <div style="float:left; width:300px;">
                    <jqx-combo-box
                        jqx-on-change="itemsComboboxSelecting(event)"
                        jqx-on-unselect=""
                        jqx-settings="itemsComboboxSettings"
                        id="editItem_ItemSelected"
                        >
                    </jqx-combo-box>
                </div>
            </div>

            <div class="row">
                <div class="form-group control-cont">
                    <label for="" class="control-label" style="float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">Item Number:</label>
                    <div style="float:left; width:300px;">
                        <input type="text" class="form-control menuitem_extraControls" id="itemcontrol_Item"
                               ng-change="onChangeItemNumber(event)" ng-model="inventoryData.item"
                               data-field="Item" placeholder="Item Number" autofocus>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group control-cont">
                    <label for="" class="" style="float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">Barcode:</label>
                    <div style="float:left; width:300px;">
                        <input type="text" class="form-control menuitem_extraControls" id="itemcontrol_Part"
                               data-field="Part" placeholder="Barcode" ng-model="inventoryData.part"
                        >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group control-cont">
                    <label style="float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">Category:</label>
                    <div style="float:left; width:300px;">
                        <jqx-combo-box id="itemcontrol_category" jqx-width="'290px'" jqx-height="'30px'" class="menuitem_extraControls"
                                       jqx-settings="categoryCbxSettings"
                                       jqx-on-change="onSelectCategoryCbx($event)" jqx-on-select="onSelectCategoryCbx($event)"
                                       data-field="Category"
                        ></jqx-combo-box>
<!--                        <span class="required-ast">*</span>-->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group control-cont">
                    <label style="float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">SubCategory:</label>
                    <div style="float:left; width:300px;">
                        <jqx-combo-box id="itemcontrol_subcategory" jqx-width="'290px'" jqx-height="'30px'" class="menuitem_extraControls"
                                       jqx-settings="subcategoryCbxSettings" data-field="Subcategory"
                        ></jqx-combo-box>
                    </div>
                </div>
            </div>

            <div style="float:left; padding:2px; width:100%; ">
                <div style=" float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">Description:</div>
                <div style=" float:left; width:300px;">
                    <input type="text" class="form-control menuitem_extraControls" id="itemcontrol_description"
                           name="itemcontrol_description" placeholder="Description">
                </div>
            </div>

            <div style="float:left; padding:2px; width:100%; ">
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

            <div style="float:left; padding:2px; width:100%; ">
                <div style=" float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">Main Printer:</div>
                <div style=" float:left; width:300px;">
                    <jqx-drop-down-list id="mainPrinterSelect" class=""
                                        jqx-settings="printerItemList"
                                        jqx-width="'100%'"
                                        jqx-on-select="">
                    </jqx-drop-down-list>
                </div>
                <div id="editMainPrinterBtn" style="float:left;display: none;">
                    <button ng-click="editMainPrinter()"
                            style="border: 0;margin: -0.5em 0;background: none;">
                        <img src="<?php echo base_url("/assets/img/edit.png")?>" style="width: 18px;margin-top: 5px;">
                    </button>
                </div>
            </div>

            <div style="float:left; padding:2px; width:100%; ">
                <div style=" float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">
                    List Price:
                </div>

                <div style=" float:left; width:300px;">
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <jqx-number-input id="itemcontrol_lprice" class="form-control menuitem_pricesControls"
                                          jqx-width="'265px'" jqx-height="'30px'"
                                          jqx-spin-buttons="false" jqx-input-mode="simple"
                                          jqx-symbol="''"
                                          jqx-decimal-digits="<?= $decimalsPrice; ?>"
                        ></jqx-number-input>
                    </div>
                </div>
            </div>

            <div style="float:left; padding:2px; width:100%; ">
                <div style=" float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">
                    Sell Price:
                </div>

                <div style=" float:left; width:300px;">
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <jqx-number-input id="itemcontrol_sprice" class="form-control menuitem_pricesControls"
                                          jqx-width="'265px'" jqx-height="'30px'"
                                          jqx-spin-buttons="false" jqx-input-mode="simple"
                                          jqx-symbol="''"
                                          jqx-decimal-digits="<?= $decimalsPrice; ?>"
                        ></jqx-number-input>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>