<div id="styling_menu_items_section">

    <!--  LAYOUT CONTROLS  -->
    <div style="float:left; padding:2px; width:100%; ">
        <!-- Row -->
        <div style="float:left; padding:8px; text-align:right; width:200px; font-weight:bold;">Row:</div>
        <div style="float:left; width:52px;">
            <jqx-number-input
                    style='margin-top: 3px;' class="form-control required-field"
                    id="editItem_Row" name="editItem_Row"
                    jqx-settings="numberMenuItem" jqx-min="0" jqx-max="99999"
                    jqx-value="1" jqx-digits="5"
            ></jqx-number-input>
        </div>
        <div style="float:left;">
            <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
        </div>
        <!-- Column -->
        <div style="float:left; padding:8px; text-align:right; width:80px; font-weight:bold;">Column:</div>
        <div style="float:left; width:52px; ">
            <jqx-number-input
                    style='margin-top: 3px;' class="form-control required-field"
                    id="editItem_Column" name="editItem_Column"
                    jqx-settings="numberMenuItem" jqx-min="0" jqx-max="99999"
                    jqx-value="1" jqx-digits="5"
            ></jqx-number-input>
        </div>
        <div style="float:left;">
            <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
        </div>
        <!-- Sort -->
        <div style="float:left; padding:8px; text-align:right; width:80px; font-weight:bold;">Sort:</div>
        <div style="float:left; width:52px;">
            <jqx-number-input
                    style='margin-top: 3px;' class="form-control required-field"
                    id="editItem_sort" name="editItem_sort"
                    jqx-settings="numberMenuItem" jqx-min="0" jqx-max="99999"
                    jqx-value="1" jqx-digits="5"
            ></jqx-number-input>
        </div>
        <div style="float:left;">
            <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
        </div>
    </div>
    <div style=" float:left; padding:2px; width:100%; ">
        <div style="float:left; padding:8px; text-align:right; width:200px; font-weight:bold;">Status:</div>
        <div style="float:left; width:80px;">
            <select name="editItem_Status" id="editItem_Status">
                <option value="1">Enabled</option>
                <option value="2">Disabled</option>
            </select>
        </div>
    </div>
    <!--  STYLE COLOR CONTROLS  -->
    <div style="float:left; padding:2px; width:100%;">
        <div style="float:left; padding:8px; text-align:right; width:200px; font-weight:bold;">Button Primary Color:</div>
        <div style="float:left; width:200px;">
            <div style="margin: 3px; float: left;" class="dropDownParent">
                <jqx-drop-down-button jqx-on-opening="qOpening(event)" jqx-width="150" jqx-instance="ddb_mitbPrimaryColor"
                                      id="ddb_mitbPrimaryColor" class="styles-control" jqx-height="22">
                    <jqx-color-picker jqx-create="qColorCreated" jqx-on-colorchange="mitColorChange(event)"
                                      jqx-color-mode="'hue'" jqx-width="220" jqx-height="220" data-layout="item"
                                      id="mitbPrimaryColor" jqx-color="mitbPrimaryColor"></jqx-color-picker>
                </jqx-drop-down-button>
            </div>
        </div>
    </div>

    <div style="float:left; padding:2px; width:100%;">
        <div style="float:left; padding:8px; text-align:right; width:200px; font-weight:bold;">Button Secondary Color:</div>
        <div style="float:left; width:200px;">
            <div style="margin: 3px; float: left;">
                <jqx-drop-down-button jqx-on-opening="qOpening(event)" jqx-width="150" jqx-instance="ddb_mitbSecondaryColor"
                                      id="ddb_mitbSecondaryColor" class="styles-control" jqx-height="22">
                    <jqx-color-picker jqx-create="qColorCreated" jqx-on-colorchange="mitColorChange(event)"
                                      jqx-color-mode="'hue'" jqx-width="220" jqx-height="220" data-layout="item"
                                      id="mitbSecondaryColor" jqx-color="mitbSecondaryColor"></jqx-color-picker>
                </jqx-drop-down-button>
            </div>
        </div>
    </div>

    <div style="float:left; padding:2px; width:100%;">
        <div style="float:left; padding:8px; text-align:right; width:200px; font-weight:bold;">Label Font Color</div>
        <div style="float:left; width:200px;">
            <div style="margin: 3px; float: left;">
                <jqx-drop-down-button jqx-on-opening="qOpening(event)" jqx-width="150" jqx-instance="ddb_mitlfontColor"
                                      id="ddb_mitlfontColor" jqx-height="22" class="styles-control">
                    <jqx-color-picker jqx-create="qColorCreated" jqx-on-colorchange="mitColorChange(event)"
                                      jqx-color-mode="'hue'" jqx-width="220" jqx-height="220" data-layout="item"
                                      id="mitlfontColor" jqx-color="mitlfontColor"></jqx-color-picker>
                </jqx-drop-down-button>
            </div>
        </div>
    </div>

    <div style="float:left; padding:2px; width:100%;">
        <div style="float:left; padding:8px; text-align:right; width:200px; font-weight:bold;">Label Font Size</div>
        <div style="float:left; width:180px;">
            <jqx-drop-down-list id="mitlfontSize" class="styles-control" jqx-width="150">
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