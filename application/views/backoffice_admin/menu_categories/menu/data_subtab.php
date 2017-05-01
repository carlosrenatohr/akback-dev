<div class="col-md-12 col-md-offset-0" id="menuWindowContent">
    <div class="row menuFormContainer">
        <div style=" width:330px;float:left;">
            <div style="float:left; padding:2px; width:450px;">
                <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Menu Name:</div>
                <div style="float:left; width:180px;">
                    <input type="text" class="form-control required-field" id="add_MenuName" name="add_MenuName" placeholder="Menu Name" autofocus>
                </div>
                <div style="float:left;">
                    <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                </div>
            </div>

            <div style="float:left; padding:2px; width:450px;">
                <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Category Row:</div>
                <div style="float:left; width:180px;">
                    <jqx-number-input
                        style='margin-top: 3px;padding-left: 12px;' class="required-field form-control"
                        id="add_MenuRow" name="add_Row"
                        jqx-settings="number_mainmenuTab"
                        jqx-value="2" jqx-min="1"
                    ></jqx-number-input>

                </div>
                <div style="float:left;">
                    <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                </div>
            </div>

            <div style="float:left; padding:2px; width:450px;">
                <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Category Column:</div>
                <div style="float:left; width:180px;">
                    <jqx-number-input
                        style='margin-top: 3px;padding-left: 12px;' class="required-field form-control"
                        id="add_MenuColumn" name="add_Column"
                        jqx-settings="number_mainmenuTab"
                        jqx-value="5" jqx-min="1"
                    ></jqx-number-input>
                </div>
                <div style="float:left;">
                    <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                </div>
            </div>

            <div style="float:left; padding:2px; width:450px;">
                <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Item Row:</div>
                <div style="float:left; width:180px;">
                    <jqx-number-input
                        style='margin-top: 3px;padding-left: 12px;' class="required-field form-control"
                        id="add_MenuItemRow" name="add_MenuItemRow"
                        jqx-settings="number_mainmenuTab"
                        jqx-value="5" jqx-min="1"
                    ></jqx-number-input>
                </div>
                <div style="float:left;">
                    <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                </div>
            </div>

            <div style="float:left; padding:2px; width:450px;">
                <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Item Column:</div>
                <div style="float:left; width:180px;">
                    <jqx-number-input
                        style='margin-top: 3px;padding-left: 12px;' class="required-field form-control"
                        id="add_MenuItemColumn" name="add_MenuItemRowColumn"
                        jqx-settings="number_mainmenuTab"
                        jqx-value="5" jqx-min="1"
                    ></jqx-number-input>
                </div>
                <div style="float:left;">
                    <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                </div>
            </div>
            <div style="float:left; padding:2px; width:450px;">
                <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Item Length</div>
                <div style="float:left; width:180px;">
                    <jqx-number-input
                        style='margin-top: 3px;padding-left: 12px;' class="required-field form-control"
                        id="add_ItemLength" name="add_ItemLength"
                        jqx-settings="number_mainmenuTab"
                        jqx-value="25" jqx-min="0"
                    ></jqx-number-input>
                </div>
                <div style="float:left;">
                    <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                </div>
            </div>

            <div style="float:left; padding:2px; width:450px;">
                <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Status:</div>
                <div style="float:left; width:180px;">
                    <select name="add_Status" id="add_Status">
                        <option value="1">Enabled</option>
                        <option value="2">Disabled</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>