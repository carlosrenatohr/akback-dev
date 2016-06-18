<div class="">
    <div class="col-lg-2 col-md-2 col-sm-2">
        <jqx-tabs jqx-width="'100%'" id="jqxTabsMenuItemSection">
            <ul>
                <li>Menu</li>
                <li>Items</li>
            </ul>
            <div class="">
                <div class="">
                    <jqx-list-box jqx-settings="menuListBoxSettings"
                                  jqx-on-select="menuListBoxSelecting(event)"
                                  id="menuListBox">
                    </jqx-list-box>
                </div>
            </div>
            <div class="">
                <div class="">
                    <div id="selectedItemInfo" class="col-md-12">
                        {{ selectedItemInfo.Description }}
                    </div>
                    <div id="" class="col-md-12">
                        <button class="btn btn-info" ng-click="newMenuItemBtn()" id="NewMenuItemBtn"
                                style="margin: 10px 25%;">
                            New Item
                        </button>
                    </div>
                    <div class="col-md-12">
                        <span>Type an item to find:</span>
                    </div>
                    <jqx-list-box
                        jqx-on-select="itemListBoxOnSelect(event)"
                        jqx-on-unselect=""
                        jqx-settings="itemsListboxSettings"
                        id="itemListboxSearch"
                        >
                    </jqx-list-box>
                    <div class="" style="min-height: 50px;"></div>
                </div>
            </div>
        </jqx-tabs>
    </div>

    <div class="col-lg-10 col-md-10 col-sm-10">
        <div class="row">
        <div class="col-md-12 col-sm-12 restricter-dragdrop">

        </div>
        </div>
        <div class="row">
        <div class="col-md-12 col-sm-12">
            <h4 class="">Category grid</h4>
            <div id="categories-container">
                <category-cell-grid category-title="{{uno.CategoryName}}">
                </category-cell-grid>
            </div>
        </div>
        </div>
        <!--<div class="droppingTarget" style="height: 400px;width: 1200px;background-color: rebeccapurple;"></div>-->
    </div>
    <!--  Windows to save data on items   -->
    <jqx-window jqx-on-close="close()" jqx-settings="itemsMenuWindowsSetting"
                jqx-create="itemsMenuWindowsSetting" class="">
        <div>
            Edit Item
        </div>
        <div>
            <jqx-tabs jqx-width="'100%'"
                      id="jqxTabsMenuItemWindows">
                <ul>
                    <li>Menu Item</li>
                    <li>Questions Tab</li>
                </ul>
                <!-- Menu Item subtab -->
                <div class="">
                    <div class="col-md-12 col-md-offset-0">
                        <div class="row editItemFormContainer">
                            <div style=" width:100%;float:left;">
                                <div style="float:left; padding:2px; width:650px;">
                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Item:</div>
                                    <div style="float:left; width:300px;">
                                        <jqx-combo-box
                                            jqx-on-select="itemsComboboxSelecting(event)"
                                            jqx-on-unselect=""
                                            jqx-settings="itemsComboboxSettings"
                                            id="editItem_ItemSelected">
                                        </jqx-combo-box>
                                    </div>
                                </div>

                                <div style="float:left; padding:2px; width:650px; ">
                                    <div style=" float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Label:</div>
                                    <div style=" float:left; width:300px;">
                                <textarea class="form-control required-field" id="editItem_label"
                                          cols="30" rows="3"
                                          name="editItem_label" placeholder="Label"></textarea>
                                        <!-- <input type="text" class="form-control required-field" id="editItem_label" name="editItem_label" placeholder="Label">-->
                                    </div>
                                    <div style="float:left;">
                                        <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                    </div>
                                </div>

                                <div style=" float:left; padding:2px; width:650px; ">
                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Row:</div>
                                    <div style=" float:left; width:300px;">
                                        <input type="number" class="form-control required-field"
                                               id="editItem_Row" name="editItem_Row" placeholder="Row"
                                               step="1" min="1" value="1" pattern="\d*">
                                    </div>
                                    <div style="float:left;">
                                        <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                    </div>
                                </div>

                                <div style=" float:left; padding:2px; width:650px; ">
                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Column:</div>
                                    <div style=" float:left; width:300px;">
                                        <input type="number" class="form-control required-field"
                                               id="editItem_Column" name="editItem_Column" placeholder="Column"
                                               step="1" min="1" value="1" pattern="\d*">
                                    </div>
                                    <div style="float:left;">
                                        <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                    </div>
                                </div>

                                <div style=" float:left; padding:2px; width:650px; ">
                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Sort:</div>
                                    <div style=" float:left; width:300px;">
                                        <input type="number" class="form-control required-field"
                                               id="editItem_sort" name="editItem_sort" placeholder="Sort"
                                               step="1" min="1" value="1" pattern="\d*">
                                    </div>
                                    <div style="float:left;">
                                        <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                    </div>
                                </div>

                                <div style=" float:left; padding:2px; width:650px; ">
                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Status:</div>
                                    <div style=" float:left; width:300px;">
                                        <select name="editItem_Status" id="editItem_Status">
                                            <option value="1">Enabled</option>
                                            <option value="2">Disabled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Question subtab -->
                <div class="">
                    <div class="col-md-12">
                        <button class="btn btn-info" ng-click="openQuestionItemWin()" style="margin: 10px 0;">
                            New Question
                        </button>
                    </div>
                    <div class="col-md-12">
                        <jqx-data-table jqx-settings="questionTableOnMenuItemsSettings"
                                        jqx-on-row-double-click="editQuestionItemWin(event)"
                                        jqx-create="questionTableOnMenuItemsSettings">
                        </jqx-data-table>
                    </div>
                    <jqx-window jqx-on-close="close()" jqx-settings="questionOnItemGridWindowSettings"
                                jqx-create="questionOnItemGridWindowSettings" class="">
                        <div>
                            New Question
                        </div>
                        <div>
                            <div class="col-md-12 col-md-offset-0">
                                <div class="row itemqFormContainer">
                                    <div style=" width:100%;float:left;">
                                        <div style="float:left; padding:2px; width:650px;">
                                            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Question:</div>
                                            <div style="float:left; width:300px;">
                                                <jqx-combo-box
                                                    jqx-on-select=""
                                                    jqx-on-unselect=""
                                                    jqx-settings="questionItemsCbxSettings"
                                                    id="itemq_Question">
                                                </jqx-combo-box>
                                            </div>
                                        </div>

                                        <div style=" float:left; padding:2px; width:650px; ">
                                            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Sort:</div>
                                            <div style=" float:left; width:300px;">
                                                <input type="number" class="form-control required-qitem"
                                                       id="itemq_Sort" name="itemq_Sort" placeholder="Sort"
                                                       step="1" min="1" value="1" pattern="\d*">
                                            </div>
                                            <div style="float:left;">
                                                <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                            </div>
                                        </div>

                                        <div style=" float:left; padding:2px; width:650px; ">
                                            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Status:</div>
                                            <div style=" float:left; width:300px;">
                                                <select name="itemq_Status" id="itemq_Status">
                                                    <option value="1">Enabled</option>
                                                    <option value="2">Disabled</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Main buttons before saving questions on current item -->
                            <div class="col-md-12 col-md-offset-0">
                                <div class="row">
                                    <div id="mainButtonsQitem">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button type="button" id="saveQuestionItemBtn" ng-click="saveQuestionItem()" class="btn btn-primary" disabled>
                                                    Save
                                                </button>
                                                <button	type="button" id="" ng-click="closeQuestionItemWin()" class="btn btn-warning">
                                                    Close
                                                </button>
                                                <button	type="button" id="deleteQuestionItemBtn" ng-click="deleteQuestionItem()" class="btn btn-danger " style="overflow:auto;">
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Prompt before saving questions by item -->
                            <div class="col-md-12 col-md-offset-0">
                                <div class="row">
                                    <div id="promptToCloseQitem" class="" style="display: none">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                Do you want to save your changes?
                                                <button type="button" ng-click="closeQuestionItemWin(0)" class="btn btn-primary">Yes</button>
                                                <button type="button" ng-click="closeQuestionItemWin(1)" class="btn btn-warning">No</button>
                                                <button type="button" ng-click="closeQuestionItemWin(2)" class="btn btn-info">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Prompt before delete an item on grid -->
                            <div class="col-md-12 col-md-offset-0">
                                <div class="row">
                                    <div id="promptToDeleteQItem" class="" style="display: none">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                Do you really want to delete it?
                                                <button type="button" ng-click="deleteQuestionItem(0)" class="btn btn-primary">Yes</button>
                                                <button type="button" ng-click="deleteQuestionItem(1)" class="btn btn-warning">No</button>
                                                <button type="button" ng-click="deleteQuestionItem(2)" class="btn btn-info">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- NOTIFICATIONS AREA -->
                            <div class="col-md-12 col-md-offset-0">
                                <div class="row">
                                    <jqx-notification jqx-settings="qitemNotificationsSuccessSettings" id="qitemNotificationsSuccessSettings">
                                        <div id="notification-content"></div>
                                    </jqx-notification>
                                    <jqx-notification jqx-settings="qitemNotificationsErrorSettings" id="qitemNotificationsErrorSettings">
                                        <div id="notification-content"></div>
                                    </jqx-notification>
                                    <div id="notification_container_menuitem" style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
                                </div>
                            </div>
                        </div>
                    </jqx-window>
                </div>
            </jqx-tabs>

            <!-- Main buttons before saving item on grid -->
            <div class="col-md-12 col-md-offset-0">
                <div class="row">
                    <div id="mainButtonsOnItemGrid">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="button" id="saveItemGridBtn" ng-click="saveItemGridBtn()" class="btn btn-primary" disabled>Save</button>
                                <button	type="button" id="" ng-click="closeItemGridWindows()" class="btn btn-warning">Close</button>
                                <button	type="button" id="deleteItemGridBtn" ng-click="deleteItemGridBtn()" class="btn btn-danger " style="overflow:auto;">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prompt before saving item on grid -->
            <div class="col-md-12 col-md-offset-0">
                <div class="row">
                    <div id="promptToCloseItemGrid" class="RowOptionButtonsOnItemGrid" style="display: none">
                        <div class="form-group">
                            <div class="col-sm-12">
                                Do you want to save your changes?
                                <button type="button" ng-click="closeItemGridWindows(0)" class="btn btn-primary">Yes</button>
                                <button type="button" ng-click="closeItemGridWindows(1)" class="btn btn-warning">No</button>
                                <button type="button" ng-click="closeItemGridWindows(2)" class="btn btn-info">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prompt before delete an item on grid -->
            <div class="col-md-12 col-md-offset-0">
                <div class="row">
                    <div id="promptToDeleteItemGrid" class="RowOptionButtonsOnItemGrid" style="display: none">
                        <div class="form-group">
                            <div class="col-sm-12">
                                Do you really want to delete it?
                                <button type="button" ng-click="deleteItemGridBtn(0)" class="btn btn-primary">Yes</button>
                                <button type="button" ng-click="deleteItemGridBtn(1)" class="btn btn-warning">No</button>
                                <button type="button" ng-click="deleteItemGridBtn(2)" class="btn btn-info">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- NOTIFICATIONS AREA -->
            <div class="col-md-12 col-md-offset-0">
                <div class="row">
                    <jqx-notification jqx-settings="menuitemNotificationsSuccessSettings" id="menuitemNotificationsSuccessSettings">
                        <div id="notification-content"></div>
                    </jqx-notification>
                    <jqx-notification jqx-settings="menuitemNotificationsErrorSettings" id="menuitemNotificationsErrorSettings">
                        <div id="notification-content"></div>
                    </jqx-notification>
                    <div id="notification_container_menuitem" style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
                </div>
            </div>
        </div>
    </jqx-window>
</div>