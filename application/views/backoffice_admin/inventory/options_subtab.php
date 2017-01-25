<div class="col-md-12 inventory_tab">
    <div class="row">
        <div style=" width:80%;float:left;margin: 15px 0;">
            <!-- 1ST -->
            <div style="float:left; padding:2px; width:750px;">
                <div style=" float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Gift Card?</div>
                <div style=" float:left; width:120px;">
                    <div id="iteminventory_giftcard"
                         style="display: inline-block;margin: -8px 0 0 0;/*margin: -8px 0 0 -10px*/">
                        <jqx-drop-down-list id="itemcontrol_gcard" class="cbxExtraTab"
                                            jqx-width="100" style="margin-top: 10px;">
                            <option value="0">No</option>
                            <option value="1">Internal</option>
                            <option value="2">Gift Pay</option>
                        </jqx-drop-down-list>
                    </div>
                </div>
                <!--   -->
                <div style=" float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Ask for Price?</div>
                <div style=" float:left; width:120px;">
                    <div id="iteminventory_promptprice"
                         style="display: inline-block;margin: -8px 0 0 0;">
                        <jqx-radio-button jqx-settings="checkBoxInventory"
                                          jqx-group-name="'item_pprice'"
                                          data-val="1"
                                          class="cbxExtraTab">
                            <span class="text-rb">Yes</span>
                        </jqx-radio-button>
                        <jqx-radio-button jqx-settings="checkBoxInventory"
                                          jqx-group-name="'item_pprice'"
                                          data-val="0" jqx-checked="true"
                                          class="cbxExtraTab">
                            <span class="text-rb">No</span>
                        </jqx-radio-button>
                    </div>
                </div>
            </div>
            <!-- 2ND -->
            <div style="float:left; padding:2px; width:750px;">
                <div style="float:left;width:100px;padding:8px;text-align:right;font-weight:bold;">Group?</div>
                <div style="float:left; width:120px;">
                    <div id="iteminventory_group"
                         style="display: inline-block;margin: -8px 0 0 0;/*margin: -8px 0 0 -10px*/">
                        <jqx-radio-button jqx-settings="checkBoxInventory"
                                          jqx-group-name="'item_group'"
                                          data-val="1"
                                          class="cbxExtraTab">
                            <span class="text-rb">Yes</span>
                        </jqx-radio-button>
                        <jqx-radio-button jqx-settings="checkBoxInventory"
                                          jqx-group-name="'item_group'"
                                          data-val="0" jqx-checked="true"
                                          class="cbxExtraTab">
                            <span class="text-rb">No</span>
                        </jqx-radio-button>
                    </div>
                </div>
                <!--   -->
                <div style=" float:left; padding:8px; text-align:right;width:150px;font-weight:bold;">Ask for Description?</div>
                <div style=" float:left; width:120px;">
                    <div id="iteminventory_promptdescription"
                         style="display: inline-block;margin: -8px 0 0 0;">
                        <jqx-radio-button jqx-settings="checkBoxInventory"
                                          jqx-group-name="'item_pdescription'"
                                          data-val="1"
                                          class="cbxExtraTab">
                            <span class="text-rb">Yes</span>
                        </jqx-radio-button>
                        <jqx-radio-button jqx-settings="checkBoxInventory"
                                          jqx-group-name="'item_pdescription'"
                                          data-val="0" jqx-checked="true"
                                          class="cbxExtraTab">
                            <span class="text-rb">No</span>
                        </jqx-radio-button>
                    </div>
                </div>
            </div>
            <!-- 3RD -->
            <div style="float:left; padding:2px; width:750px; " class="col-sm-3">
                <div style=" float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">EBT?</div>
                <div style=" float:left; width:120px;">
                    <div id="iteminventory_EBT"
                         style="display: inline-block;margin: -8px 0 0 0;/*margin: -8px 0 0 -10px*/">
                        <jqx-radio-button jqx-settings="checkBoxInventory"
                                          jqx-group-name="'item_ebt'"
                                          data-val="1"
                                          class="cbxExtraTab">
                            <span class="text-rb">Yes</span>
                        </jqx-radio-button>
                        <jqx-radio-button jqx-settings="checkBoxInventory"
                                          jqx-group-name="'item_ebt'"
                                          data-val="0" jqx-checked="true"
                                          class="cbxExtraTab">
                            <span class="text-rb">No</span>
                        </jqx-radio-button>
                    </div>
                </div>
                <!--   -->
                <div style=" float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Countdown</div>
                <div style=" float:left; width:120px;">
                    <jqx-number-input
                        style='margin-top: 3px;' class="item_textcontrol"
                        id="itemcontrol_countdown" name="itemcontrol_countdown"
                        jqx-input-mode="'simple'" jqx-decimal-digits="0"
                        jqx-digits="2" jqx-spin-buttons="false"
                        jqx-width="100" jqx-height="25" jqx-min=""
                        data-field="CountDown"
                    ></jqx-number-input>
                </div>
            </div>
            <!-- 4TH -->
            <div style="float:left; padding:2px; width:750px; ">
                <div style=" float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Points</div>
                <div style=" float:left; width:120px;">
                    <jqx-number-input
                        style='margin-top: 3px;' class="item_textcontrol"
                        id="itemcontrol_points" name="itemcontrol_points"
                        jqx-input-mode="'simple'" jqx-decimal-digits="2"
                        jqx-digits="3" jqx-spin-buttons="false"
                        jqx-width="100" jqx-height="25" jqx-min=""
                        data-field="Points"
                    ></jqx-number-input>
                </div>
                <!-- -->
                <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Minimum Age</div>
                <div style="float:left; width:120px;">
                    <jqx-number-input
                        style='margin-top: 3px;' class="item_textcontrol"
                        id="itemcontrol_minimumage" name="itemcontrol_minimumage"
                        jqx-input-mode="'simple'" jqx-decimal-digits="0"
                        jqx-digits="2" jqx-spin-buttons="false"
                        jqx-width="100" jqx-height="25" jqx-min=""
                        data-field="MinimumAge"
                    ></jqx-number-input>
                </div>
            </div>
            <!-- 5TH -->
            <div style="float:left; padding:2px; width:750px; ">
                <div style=" float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Label</div>
                <div id="iteminventory_labelpos"
                     style="display: inline-block;margin: -8px 0 0 0;/*margin: -8px 0 0 -10px*/">
                    <jqx-drop-down-list id="itemcontrol_labelpos" class="cbxExtraTab"
                                        jqx-width="100" style="margin-top: 10px;">
                        <option value="">None</option>
                        <?php foreach ($labelPos as $label) { ?>
                        <option value="<?php echo $label['Unique'];?>"><?php echo $label['Name'];?></option>
                        <?php } ?>
                    </jqx-drop-down-list>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .cbxExtraTab {
        margin-top: 15px;
        margin-right: 1.5em;
        display: inherit;
    }
</style>