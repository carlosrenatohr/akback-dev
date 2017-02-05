<div class="row categoryFormContainer">
    <div style=" width:330px;float:left;">
        <div style="float:left; padding:2px; width:450px;">
            <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Category Name:</div>
            <div style="float:left; width:180px;">
                <input type="text" class="form-control required-field" id="add_CategoryName" name="add_CategoryName" placeholder="Category Name" autofocus>
            </div>
            <div style="float:left;">
                <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
            </div>
        </div>

        <div style="float:left; padding:2px; width:450px;">
            <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Menu:</div>
            <div style="float:left; width:180px;">
                <jqx-drop-down-list id="add_MenuUnique"
                                    jqx-settings="settingsMenuSelect"
                                    jqx-on-select="">
                </jqx-drop-down-list>
            </div>
            <div style="float:left;">
                <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
            </div>
        </div>

        <div style="float:left; padding:2px; width:450px;">
            <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Sort:</div>
            <div style="float:left; width:180px;">
                <jqx-number-input
                    style='margin-top: 3px;padding-left: 12px;' class="required-field form-control"
                    id="add_Sort" name="add_Sort"
                    jqx-settings="number_mainmenuTab" jqx-min="2" jqx-max="5" jqx-value="2"
                ></jqx-number-input>
            </div>
            <div style="float:left;">
                <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
            </div>
        </div>

        <div style="float:left; padding:2px; width:450px;">
            <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Row:</div>
            <div style="float:left; width:180px;">
                <jqx-number-input
                    style='margin-top: 3px;padding-left: 12px;' class="required-field form-control"
                    id="add_CategoryRow" name="add_CategoryRow"
                    jqx-settings="number_mainmenuTab" jqx-min="1" jqx-value="1"
                ></jqx-number-input>
            </div>
            <div style="float:left;">
                <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
            </div>
        </div>

        <div style="float:left; padding:2px; width:450px;">
            <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Column:</div>
            <div style="float:left; width:180px;">
                <jqx-number-input
                    style='margin-top: 3px;padding-left: 12px;' class="required-field form-control"
                    id="add_CategoryColumn" name="add_CategoryColumn"
                    jqx-settings="number_mainmenuTab" jqx-min="1" jqx-value="1"
                ></jqx-number-input>
            </div>
            <div style="float:left;">
                <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
            </div>
        </div>

        <div style="float:left; padding:2px; width:450px;">
            <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Status:</div>
            <div style="float:left; width:180px;">
                <select name="Status" id="add_CategoryStatus" style="width: 180px;">
                    <option value="1">Enabled</option>
                    <option value="2">Disabled</option>
                </select>
            </div>
        </div>
    </div>
</div>