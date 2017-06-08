<!-- CATEGORY DEFAULT STYLES -->
<div id="styling_category_section" class="col-md-6">
    <h4>Default Styles for Category</h4>
    <div style="float:left; padding:2px; width:450px;">
        <div style="float:left; padding:8px; text-align:right; width:180px; font-weight:bold;">Button Primary Color:</div>
        <div style="float:left; width:180px;">
            <div style="margin: 3px; float: left;" class="dropDownParent">
                <jqx-drop-down-button jqx-on-opening="opening(event)" jqx-width="150" jqx-instance="ddb_menudCatbPrimaryColor"
                                      class="styles-control" jqx-height="22">
                    <jqx-color-picker jqx-create="createColorPicker" jqx-on-colorchange="colorChange(event)"
                                      jqx-color-mode="'hue'" jqx-width="220" jqx-height="220" data-layout="menu"
                                      jqx-color="menudCatbPrimaryColor" id="menudCatbPrimaryColor"></jqx-color-picker>
                </jqx-drop-down-button>
            </div>
        </div>
    </div>

    <div style="float:left; padding:2px; width:450px;">
        <div style="float:left; padding:8px; text-align:right; width:180px; font-weight:bold;">Button Secondary Color:</div>
        <div style="float:left; width:180px;">
            <div style="margin: 3px; float: left;">
                <jqx-drop-down-button jqx-on-opening="opening(event)" jqx-width="150" jqx-instance="ddb_menudCatbSecondaryColor"
                                      class="styles-control" jqx-height="22">
                    <jqx-color-picker jqx-create="createColorPicker" jqx-on-colorchange="colorChange(event)"
                                      jqx-color-mode="'hue'" jqx-width="220" jqx-height="220" data-layout="menu"
                                      jqx-color="menudCatbSecondaryColor" id="menudCatbSecondaryColor"></jqx-color-picker>
                </jqx-drop-down-button>
            </div>
        </div>
    </div>

    <div style="float:left; padding:2px; width:450px;">
        <div style="float:left; padding:8px; text-align:right; width:180px; font-weight:bold;">Label Font Color</div>
        <div style="float:left; width:180px;">
            <div style="margin: 3px; float: left;">
                <jqx-drop-down-button jqx-on-opening="opening(event)" jqx-width="150" jqx-instance="ddb_menudCatlfontColor"
                                      jqx-height="22" class="styles-control">
                    <jqx-color-picker jqx-create="createColorPicker" jqx-on-colorchange="colorChange(event)"
                                      jqx-color-mode="'hue'" jqx-width="220" jqx-height="220" data-layout="menu"
                                      jqx-color="menudCatlfontColor" id="menudCatlfontColor"></jqx-color-picker>
                </jqx-drop-down-button>
            </div>
        </div>
    </div>

    <div style="float:left; padding:2px; width:450px;">
        <div style="float:left; padding:8px; text-align:right; width:180px; font-weight:bold;">Label Font Size</div>
        <div style="float:left; width:150px;">
            <jqx-drop-down-list id="menudCatlfontSize" class="styles-control"
                jqx-width="150">
                <?php for ($o = 4;$o<=30;$o++) { ?>
                    <option value="<?php echo $o; ?>px"><?php echo $o; ?>px</option>
                <?php } ?>
            </jqx-drop-down-list>
        </div>
    </div>
</div>
<!-- MENU ITEM DEFAULT STYLES-->
<div id="styling_category_section" class="col-md-6">
    <h4>Default Styles for Menu Item</h4>
    <div style="float:left; padding:2px; width:450px;">
        <div style="float:left; padding:8px; text-align:right; width:180px; font-weight:bold;">Button Primary Color:</div>
        <div style="float:left; width:180px;">
            <div style="margin: 3px; float: left;" class="dropDownParent">
                <jqx-drop-down-button jqx-on-opening="opening(event)" jqx-width="150" jqx-instance="ddb_menudItembPrimaryColor"
                                      class="styles-control" jqx-height="22">
                    <jqx-color-picker jqx-create="createColorPicker" jqx-on-colorchange="colorChange(event)"
                                      jqx-color-mode="'hue'" jqx-width="220" jqx-height="220" data-layout="menu"
                                      jqx-color="menudItembPrimaryColor" id="menudItembPrimaryColor"></jqx-color-picker>
                </jqx-drop-down-button>
            </div>
        </div>
    </div>

    <div style="float:left; padding:2px; width:450px;">
        <div style="float:left; padding:8px; text-align:right; width:180px; font-weight:bold;">Button Secondary Color:</div>
        <div style="float:left; width:180px;">
            <div style="margin: 3px; float: left;">
                <jqx-drop-down-button jqx-on-opening="opening(event)" jqx-width="150" jqx-instance="ddb_menudItembSecondaryColor"
                                      class="styles-control" jqx-height="22">
                    <jqx-color-picker jqx-create="createColorPicker" jqx-on-colorchange="colorChange(event)"
                                      jqx-color-mode="'hue'" jqx-width="220" jqx-height="220" data-layout="menu"
                                      jqx-color="menudItembSecondaryColor" id="menudItembSecondaryColor"></jqx-color-picker>
                </jqx-drop-down-button>
            </div>
        </div>
    </div>

    <div style="float:left; padding:2px; width:450px;">
        <div style="float:left; padding:8px; text-align:right; width:180px; font-weight:bold;">Label Font Color</div>
        <div style="float:left; width:180px;">
            <div style="margin: 3px; float: left;">
                <jqx-drop-down-button jqx-on-opening="opening(event)" jqx-width="150" jqx-instance="ddb_menudItemlfontColor"
                                      jqx-height="22" class="styles-control">
                    <jqx-color-picker jqx-create="createColorPicker" jqx-on-colorchange="colorChange(event)"
                                      jqx-color-mode="'hue'" jqx-width="220" jqx-height="220" data-layout="menu"
                                      jqx-color="menudItemlfontColor" id="menudItemlfontColor"></jqx-color-picker>
                </jqx-drop-down-button>
            </div>
        </div>
    </div>

    <div style="float:left; padding:2px; width:450px;">
        <div style="float:left; padding:8px; text-align:right; width:180px; font-weight:bold;">Label Font Size</div>
        <div style="float:left; width:150px;">
            <jqx-drop-down-list id="menudItemlfontSize" class="styles-control"
                jqx-width="150">
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