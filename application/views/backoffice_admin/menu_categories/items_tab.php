<div class="">
    <div class="col-md-2">
        <jqx-tabs jqx-width="'100%'" jqx-height="'100%'" id="jqxTabsMenuItemSection">
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
                <div class="" >
                    <div>Type an item to find:</div>
<!--                    <jqx-combo-box-->
<!--                        jqx-on-select="itemComboboxOnselect(event)"-->
<!--                        jqx-on-unselect=""-->
<!--                        jqx-settings="itemsComboboxSettings">-->
<!--                    </jqx-combo-box>-->
                    <jqx-list-box
                        jqx-on-select="itemListBoxOnSelect(event)"
                        jqx-on-unselect=""
                        jqx-settings="itemsListboxSettings"
                        id="itemListboxSearch">
                    </jqx-list-box>
                    <div class="" style="min-height: 20px;"></div>
                    <div id="selectedItemInfo">
                        {{ selectedItemInfo.Description }}
                    </div>
                </div>
            </div>
        </jqx-tabs>
    </div>

    <div class="col-md-10 restricter-dragdrop">
        <!--<div class="droppingTarget" style="height: 400px;width: 1200px;background-color: rebeccapurple;"></div>-->
    </div>
    <div class="col-md-12">
        <h4 class="col-md-offset-2">Category grid</h4>
        <div class="col-md-offset-2 col-md-10" id="categories-container">
            <category-cell-grid category-title="{{uno.CategoryName}}">
            </category-cell-grid>
        </div>
    </div>
    <!--  Windows to save data on items   -->
    <jqx-window jqx-on-close="close()" jqx-settings="itemsMenuWindowsSetting"
                jqx-create="itemsMenuWindowsSetting" class="">
        <div>
            Edit Item
        </div>
        <div>
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
                                          name="editItem_label" placeholder="Label">
                                </textarea>
                                <!-- <input type="text" class="form-control required-field" id="editItem_label" name="editItem_label" placeholder="Label">-->
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
                    <div id="promptToCloseItemGrid" class="" style="display: none">
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