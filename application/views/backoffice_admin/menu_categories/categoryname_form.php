<!--  Window to change category Name -->
<jqx-window jqx-on-close="close()" jqx-settings="itemsMenuChangeCategNameWind"
            jqx-create="itemsMenuChangeCategNameWind" class="">
    <div class="">
        Edit Category Name
    </div>
    <div class="">
        <div class="row">
            <div style="float:left; padding:2px; width:650px;">
                <div style="float:left; padding:8px; text-align:right; width:200px; font-weight:bold;">Category Name:</div>
                <div style="float:left; width:220px;">
                    <input type="text" class="form-control"
                           id="OneCategoryName" placeholder="Category Name" />
                    <input type="hidden" id="OneCategoryId"  />
                </div>
            </div>
            <!-- STYLES  -->
            <div style="float:left; padding:2px; width:450px;">
                <div style="float:left; padding:8px; text-align:right; width:200px; font-weight:bold;">Button Primary Color:</div>
                <div style="float:left; width:180px;">
                    <div style="margin: 3px; float: left;" class="dropDownParent">
                        <jqx-drop-down-button jqx-on-opening="qOpening(event)" jqx-width="150" jqx-instance="ddb_mitcbPrimaryColor"
                                              id="ddb_mitcbPrimaryColor" class="styles-control" jqx-height="22">
                            <jqx-color-picker jqx-create="qColorCreated" jqx-on-colorchange="mitColorChange(event)" jqx-color="mitcbPrimaryColor"
                                              jqx-color-mode="'hue'" jqx-width="220" jqx-height="220" data-layout="categ"
                                              id="mitcbPrimaryColor"></jqx-color-picker>
                        </jqx-drop-down-button>
                    </div>
                </div>
            </div>

            <div style="float:left; padding:2px; width:450px;">
                <div style="float:left; padding:8px; text-align:right; width:200px; font-weight:bold;">Button Secondary Color:</div>
                <div style="float:left; width:180px;">
                    <div style="margin: 3px; float: left;">
                        <jqx-drop-down-button jqx-on-opening="qOpening(event)" jqx-width="150" jqx-instance="ddb_mitcbSecondaryColor"
                                              id="ddb_mitcbSecondaryColor" class="styles-control" jqx-height="22">
                            <jqx-color-picker jqx-create="qColorCreated" jqx-on-colorchange="mitColorChange(event)" jqx-color="mitcbSecondaryColor"
                                              jqx-color-mode="'hue'" jqx-width="220" jqx-height="220" data-layout="categ"
                                              id="mitcbSecondaryColor"></jqx-color-picker>
                        </jqx-drop-down-button>
                    </div>
                </div>
            </div>

            <div style="float:left; padding:2px; width:450px;">
                <div style="float:left; padding:8px; text-align:right; width:200px; font-weight:bold;">Label Font Color</div>
                <div style="float:left; width:180px;">
                    <div style="margin: 3px; float: left;">
                        <jqx-drop-down-button jqx-on-opening="qOpening(event)" jqx-width="150" jqx-instance="ddb_mitclfontColor"
                                              id="ddb_mitclfontColor" jqx-height="22" class="styles-control">
                            <jqx-color-picker jqx-create="qColorCreated" jqx-on-colorchange="mitColorChange(event)" jqx-color="mitclfontColor"
                                              jqx-color-mode="'hue'" jqx-width="220" jqx-height="220" data-layout="categ"
                                              id="mitclfontColor"></jqx-color-picker>
                        </jqx-drop-down-button>
                    </div>
                </div>
            </div>

            <div style="float:left; padding:2px; width:450px;">
                <div style="float:left; padding:8px; text-align:right; width:200px; font-weight:bold;">Label Font Size</div>
                <div style="float:left; width:220px;">
                    <jqx-drop-down-list id="mitclfontSize" class="styles-control" jqx-width="220">
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
        <!-- Main buttons before saving mitcem on grid -->
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <div id="mainOneCategoryBtns">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="button" id="savemitcemOneCategoryBtn" ng-click="saveOneCategory()" class="btn btn-primary" disabled>Save</button>
                            <button	type="button" id="" ng-click="closeOneCategory()" class="btn btn-warning">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prompt before saving mitcem on grid -->
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <div id="closeOneCategoryBtns" style="display: none">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <p>Do you want to save your changes?</p>
                            <button type="button" ng-click="closeOneCategory(0)" class="btn btn-primary">Yes</button>
                            <button type="button" ng-click="closeOneCategory(1)" class="btn btn-warning">No</button>
                            <button type="button" ng-click="closeOneCategory(2)" class="btn btn-info">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</jqx-window>