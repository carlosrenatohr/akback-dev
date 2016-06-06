<div>
    <a style="outline:0;margin: 10px 2px;" class="btn btn-info" ng-click="newCategoryAction()">
        <span class="icon-32-new"></span>
        New
    </a>
    <jqx-data-table jqx-settings="categoriesTableSettings"
                    jqx-on-row-double-click="updateCategoryAction(e)">
    </jqx-data-table>
    <!-- -->
    <jqx-window jqx-on-close="close()" jqx-settings="addCategoryWindowSettings"
                jqx-create="addCategoryWindowSettings" class="">
        <div>
            Add new Category
        </div>
        <div>
            <div class="col-md-12 col-md-offset-0">
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
                        </div>

                        <div style="float:left; padding:2px; width:450px;">
                            <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Sort:</div>
                            <div style="float:left; width:180px;">
                                <input type="number" class="form-control required-field"
                                       id="add_Sort" name="add_Sort" placeholder="Sort"
                                       step="1" min="1" pattern="\d*" value="1">
                            </div>
                            <div style="float:left;">
                                <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                            </div>
                        </div>

                        <div style="float:left; padding:2px; width:450px;">
                            <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Row:</div>
                            <div style="float:left; width:180px;">
                                <input type="number" class="form-control required-field" id="add_CategoryRow"
                                       name="add_CategoryRow" placeholder="Row"
                                       step="1" min="1" pattern="\d*"
                                >
                            </div>
                            <div style="float:left;">
                                <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                            </div>
                        </div>

                        <div style="float:left; padding:2px; width:450px;">
                            <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Column:</div>
                            <div style="float:left; width:180px;">
                                <input type="number" class="form-control required-field" id="add_CategoryColumn"
                                       name="add_CategoryColumn" placeholder="Column"
                                       step="1" min="1" max="12" pattern="\d*"
                                >
                            </div>
                            <div style="float:left;">
                                <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                            </div>
                        </div>

                        <div style="float:left; padding:2px; width:450px;">
                            <div style="float:left; padding:8px; text-align:right; width:150px; font-weight:bold;">Status:</div>
                            <div style="float:left; width:180px;">
                                <select name="Status" id="add_CategoryStatus">
                                    <option value="1">Enabled</option>
                                    <option value="2">Disabled</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-md-offset-0">
                <div class="row">
                    <div id="mainButtonsForCategories">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="button" id="saveCategoryBtn" ng-click="SaveCategoryWindows()" class="btn btn-primary" disabled>Save</button>
                                <button	type="button" id="" ng-click="CloseCategoryWindows()" class="btn btn-warning">Close</button>
                                <button	type="button" id="deleteCategoryBtn" ng-click="beforeDeleteCategory()" class="btn btn-danger " style="display:none; overflow:auto;">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ALERT MESSAGES BEFORE ACTIONS -->
            <div class="col-md-12 col-md-offset-0">
                <div class="row">
                    <div id="beforeDeleteCategory" class="alertButtonsMenuCategories">
                        <div class="form-group">
                            <div class="col-sm-12">
                                Are you sure you want to delete it?
                                <button type="button" ng-click="beforeDeleteCategory(0)" class="btn btn-primary">Yes</button>
                                <button type="button" ng-click="beforeDeleteCategory(1)" class="btn btn-warning">No</button>
                                <button type="button" ng-click="beforeDeleteCategory(2)" class="btn btn-info">Cancel</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-12 col-md-offset-0">
                <div class="row">
                    <div id="promptToSaveInCloseButtonCategory" class="alertButtonsMenuCategories">
                        <div class="form-group">
                            <div class="col-sm-12">
                                Do you want to save your changes?
                                <button type="button" ng-click="CloseCategoryWindows(0)" class="btn btn-primary">Yes</button>
                                <button type="button" ng-click="CloseCategoryWindows(1)" class="btn btn-warning">No</button>
                                <button type="button" ng-click="CloseCategoryWindows(2)" class="btn btn-info">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- NOTIFICATIONS AREA -->
            <div class="col-md-12 col-md-offset-0">
                <div class="row">
                    <jqx-notification jqx-settings="categoryNotificationsSuccessSettings" id="categoryNotificationsSuccessSettings">
                        <div id="notification-content"></div>
                    </jqx-notification>
                    <jqx-notification jqx-settings="categoryNotificationsErrorSettings" id="categoryNotificationsErrorSettings">
                        <div id="notification-content"></div>
                    </jqx-notification>
                    <div id="notification_container_category" style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
                </div>
            </div>
        </div>
    </jqx-window>
</div>