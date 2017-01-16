<div class="col-md-12 inventory_tab">
    <div class="row">
            <div id="styling_items_section" style="width: 60%;">

            <div style="float:left; padding:2px; width:450px;">
                <div style="float:left; padding:8px; text-align:right; width:180px; font-weight:bold;">Button Primary Color:</div>
                <div style="float:left; width:180px;">
                    <div style="margin: 3px; float: left;" class="dropDownParent">
                        <jqx-drop-down-button jqx-on-opening="qOpening(event)" jqx-width="150" jqx-instance="ddb_itbPrimaryColor"
                                              class="styles-control" jqx-height="22">
                            <jqx-color-picker jqx-create="qColorCreated" jqx-on-colorchange="qColorChange(event)" jqx-color="'000000'"
                                              jqx-color-mode="'hue'" jqx-width="220" jqx-height="220" data-layout="choice"
                                              id="itbPrimaryColor"></jqx-color-picker>
                        </jqx-drop-down-button>
                    </div>
                </div>
            </div>

            <div style="float:left; padding:2px; width:450px;">
                <div style="float:left; padding:8px; text-align:right; width:180px; font-weight:bold;">Button Secondary Color:</div>
                <div style="float:left; width:180px;">
                    <div style="margin: 3px; float: left;">
                        <jqx-drop-down-button jqx-on-opening="qOpening(event)" jqx-width="150" jqx-instance="ddb_itbSecondaryColor"
                                              class="styles-control" jqx-height="22">
                            <jqx-color-picker jqx-create="qColorCreated" jqx-on-colorchange="qColorChange(event)" jqx-color="'000000'"
                                              jqx-color-mode="'hue'" jqx-width="220" jqx-height="220" data-layout="choice"
                                              id="itbSecondaryColor"></jqx-color-picker>
                        </jqx-drop-down-button>
                    </div>
                </div>
            </div>

            <div style="float:left; padding:2px; width:450px;">
                <div style="float:left; padding:8px; text-align:right; width:180px; font-weight:bold;">Label Font Color</div>
                <div style="float:left; width:180px;">
                    <div style="margin: 3px; float: left;">
                        <jqx-drop-down-button jqx-on-opening="qOpening(event)" jqx-width="150" jqx-instance="ddb_itlfontColor"
                                              jqx-height="22" class="styles-control">
                            <jqx-color-picker jqx-create="qColorCreated" jqx-on-colorchange="qColorChange(event)" jqx-color="'000000'"
                                              jqx-color-mode="'hue'" jqx-width="220" jqx-height="220" data-layout="choice"
                                              id="itlfontColor"></jqx-color-picker>
                        </jqx-drop-down-button>
                    </div>
                </div>
            </div>

            <div style="float:left; padding:2px; width:450px;">
                <div style="float:left; padding:8px; text-align:right; width:180px; font-weight:bold;">Label Font Size</div>
                <div style="float:left; width:180px;">
                    <jqx-drop-down-list id="itlfontSize" class="styles-control">
                        <option value="4px">4px</option>
                        <option value="6px">6px</option>
                        <option value="8px">8px</option>
                        <option value="10px">10px</option>
                        <option value="12px">12px</option>
                        <option value="14px">14px</option>
                        <option value="16px">16px</option>
                        <option value="18px">18px</option>
                        <option value="20px">20px</option>
                        <option value="24px">24px</option>
                    </jqx-drop-down-list>
                </div>
            </div>
        </div>
    </div>
</div>