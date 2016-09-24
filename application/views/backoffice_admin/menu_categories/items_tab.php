<div class="">
    <div class="col-lg-2 col-lg-2-item col-md-2 col-md-2-item col-sm-2">
        <div style="margin: 20px 0;">
            <div class="">
                <label for="">Select a menu</label>
                <jqx-drop-down-list
                    id="menuListDropdown"
                    jqx-settings="menudropdownSettings"
                    jqx-on-change="menuListBoxSelecting(event)"
                    >
                </jqx-drop-down-list>
            </div>
            <div id="selectedItemInfo" class="">
                {{ selectedItemInfo.Description }}
            </div>
            <div id="" class="col-md-12">
                <button class="btn btn-info" ng-click="newMenuItemBtn()" id="NewMenuItemBtn"
                        style="margin: 10px 25%;">
                    Assign Item
                </button>
            </div>
            <div class="">
                <span>Type an item to find:</span>
            </div>
            <jqx-list-box
                jqx-on-select="itemListBoxOnSelect(event)"
                jqx-settings="itemsListboxSettings"
                id="itemListboxSearch"
                >
            </jqx-list-box>
<!--            <div class="" style="min-height: 50px;"></div>-->
        </div>
    </div>
    <div class="col-lg-10 col-lg-10-item col-md-10 col-md-10-item col-sm-10 maingrid-container" style="padding: 0;">
        <!--  ITEMS GRID -->
        <div class="row">
        <div class="col-md-12 col-sm-12 restricter-dragdrop">

        </div>
        <!--  CATEGORY GRID -->
        </div>
        <div class="row">
        <div class="col-md-12 col-sm-12" style="padding-right: 0!important;padding-left: 0!important;">
            <!--  <h4 class="">Category grid</h4>-->
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
                    <li id="">Prices</li>
                    <li id="questionsTabOnMenuItemWindow">Questions</li>
                    <li>Printers</li>
                    <li>Options</li>
                    <li>Layout</li>
                </ul>
                <!-- Menu Item subtab -->
                <div class="">
                    <?php $this->load->view($items_menuitem_subtab_view);?>
                </div>
                <!-- Prices subtab -->
                <div class="">
                    <?php $this->load->view($items_price_subtab_view);?>
                </div>
                <!-- Question subtab -->
                <div class="">
                    <?php $this->load->view($items_questions_subtab_view);?>
                </div>
                <!-- Printer subtab -->
                <div class="">
                    <?php $this->load->view($items_printers_subtab_view);?>
                </div>
                <!-- Extra subtab -->
                <div class="">
                    <?php $this->load->view($items_extra_subtab_view);?>
                </div>
                <!-- Layout subtab -->
                <div class="">
                    <?php $this->load->view($items_layout_subtab_view);?>
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