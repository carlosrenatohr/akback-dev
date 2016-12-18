<div class="col-md-12 col-md-offset-0">
    <div class="row">
        <div style=" width:100%;float:left;margin: 15px 0;">

            <div style="float:left; padding:2px; width:650px; ">
                <div style=" float:left; padding:8px; text-align:right; width:220px; font-weight:bold;">Gift Card?</div>
                <div style=" float:left; width:120px;">
                    <div id="itemcontrol_giftcard" style="margin-top: 5px;">
<!--                        <jqx-radio-button jqx-settings="checkboxExtraSet"-->
<!--                                          jqx-group-name="'item_gift'"-->
<!--                                          data-val="1"-->
<!--                                          class="cbxExtraTab">-->
<!--                            <span class="text-rb">Yes</span>-->
<!--                        </jqx-radio-button>-->
<!--                        <jqx-radio-button jqx-settings="checkboxExtraSet"-->
<!--                                          jqx-group-name="'item_gift'"-->
<!--                                          data-val="0"-->
<!--                                          class="cbxExtraTab">-->
<!--                            <span class="text-rb">No</span>-->
<!--                        </jqx-radio-button>-->
                        <jqx-drop-down-list id="itemcontrol_gcard" class="menuitem_extraControls"
                                            jqx-width="100">
                            <option value="0"></option>
                            <option value="1">Internal</option>
                            <option value="2">Gift Pay</option>
                        </jqx-drop-down-list>
                    </div>
                </div>
                <div style=" float:left; width: 165px;padding:8px; text-align:right; font-weight:bold;">Group?</div>
                <div style="float:left; width:120px;">
                    <div id="itemcontrol_group"
                         style="display: inline-block;margin: -8px 0 0 0;/*margin: -8px 0 0 -10px*/">
                        <jqx-radio-button jqx-settings="checkboxExtraSet"
                                          jqx-group-name="'item_group'"
                                          data-val="1"
                                          class="cbxExtraTab">
                            <span class="text-rb">Yes</span>
                        </jqx-radio-button>
                        <jqx-radio-button jqx-settings="checkboxExtraSet"
                                          jqx-group-name="'item_group'"
                                          data-val="0"
                                          class="cbxExtraTab">
                            <span class="text-rb">No</span>
                        </jqx-radio-button>
                    </div>
                </div>
            </div>

            <div style="float:left; padding:2px; width:650px; ">
                <div style=" float:left; padding:8px; text-align:right; width:220px; font-weight:bold;">Ask for Price?</div>
                <div style=" float:left; width:120px;">
                    <div id="itemcontrol_promptprice"
                         style="display: inline-block;margin: -8px 0 0 0;">
                        <jqx-radio-button jqx-settings="checkboxExtraSet"
                                          jqx-group-name="'item_pprice'"
                                          data-val="1"
                                          class="cbxExtraTab">
                            <span class="text-rb">Yes</span>
                        </jqx-radio-button>
                        <jqx-radio-button jqx-settings="checkboxExtraSet"
                                          jqx-group-name="'item_pprice'"
                                          data-val="0"
                                          class="cbxExtraTab">
                            <span class="text-rb">No</span>
                        </jqx-radio-button>
                    </div>
                </div>
                <div style=" float:left; padding:8px; text-align:right; font-weight:bold;">Ask for Description?</div>
                <div style=" float:left; width:120px;">
                    <div id="itemcontrol_promptdescription"
                         style="display: inline-block;margin: -8px 0 0 0;">
                        <jqx-radio-button jqx-settings="checkboxExtraSet"
                                          jqx-group-name="'item_pdescription'"
                                          data-val="1"
                                          class="cbxExtraTab">
                            <span class="text-rb">Yes</span>
                        </jqx-radio-button>
                        <jqx-radio-button jqx-settings="checkboxExtraSet"
                                          jqx-group-name="'item_pdescription'"
                                          data-val="0"
                                          class="cbxExtraTab">
                            <span class="text-rb">No</span>
                        </jqx-radio-button>
                    </div>
                </div>
            </div>

            <div style="float:left; padding:2px; width:650px; ">
                <div style=" float:left; padding:8px; text-align:right; width:220px; font-weight:bold;">EBT?</div>
                <div style=" float:left; width:300px;">
                    <div id="itemcontrol_EBT"
                         style="display: inline-block;margin: -8px 0 0 0;/*margin: -8px 0 0 -10px*/">
                        <jqx-radio-button jqx-settings="checkboxExtraSet"
                                          jqx-group-name="'item_ebt'"
                                          data-val="1"
                                          class="cbxExtraTab">
                            <span class="text-rb">Yes</span>
                        </jqx-radio-button>
                        <jqx-radio-button jqx-settings="checkboxExtraSet"
                            jqx-group-name="'item_ebt'"
                            data-val="0"
                            class="cbxExtraTab">
                            <span class="text-rb">No</span>
                        </jqx-radio-button>
                    </div>
                </div>
            </div>
            <div style="float:left; padding:2px; width:650px; ">
                <div style=" float:left; padding:8px; text-align:right; width:220px; font-weight:bold;">Points</div>
                <div style=" float:left; width:120px;">
                    <jqx-number-input
                        style='margin-top: 3px;' class="menuitem_extraControls"
                        id="itemcontrol_points" name="itemcontrol_points"
                        jqx-settings="decimalsExtraSet"
                    ></jqx-number-input>
                </div>
                <div style="float:left; padding:8px; text-align:right; width:120px; font-weight:bold;"
                    >Minimum Age</div>
                <div style=" float:left; width:120px;">
                    <jqx-number-input
                        style='margin-top: 3px;' class="menuitem_extraControls"
                        id="itemcontrol_minimumage" name="itemcontrol_minimumage"
                        jqx-settings="numberExtraSet"
                    ></jqx-number-input>
                </div>
            </div>
            <div style="float:left; padding:2px; width:650px; ">
                <div style=" float:left; padding:8px; text-align:right; width:220px; font-weight:bold;">Countdown</div>
                <div style=" float:left; width:300px;">
                    <jqx-number-input
                        style='margin-top: 3px;' class="menuitem_extraControls"
                        id="itemcontrol_countdown" name="itemcontrol_countdown"
                        jqx-settings="numberExtraSet"
                    ></jqx-number-input>
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