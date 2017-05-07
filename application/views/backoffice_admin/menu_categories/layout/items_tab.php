<div class="">
    <!-- Left Tab | Menu and items picker   -->
    <div class="col-lg-2 col-lg-2-item col-md-2 col-md-2-item col-sm-2"
        style="">
        <div style="margin: 20px 0;">
            <div class="">
                <jqx-drop-down-list
                    id="menuListDropdown"
                    jqx-settings="menudropdownSettings"
                    jqx-on-change="menuListBoxSelecting(event)"
                    >
                </jqx-drop-down-list>
            </div>
            <div id="selectedItemInfo" class="selectedItemInfoClass">
                {{ selectedItemInfo.Description }}
            </div>
            <div class="col-md-12" style="padding: 0;margin: 1px 0;">
                <div class="col-md-9" style="padding: 0 2px;">
                    <input type="text" id="ListBoxSearchInput" class="form-control" placeholder="Search.."
                        style="padding: 0 5px;height: 24px;" autofocus>
                </div>
                <button class="btn btn-info col-md-1" id="ListBoxSearchBtn" type="button"
                    style="height: 24px;padding: 0 5px;margin: 0 5px;">
                    <img width="16" height="16" src="<?php echo base_url('assets/js/angular/images/search.png')?>" alt="">
                </button>
                <button class="btn btn-info col-md-1" id="CreateItemBtn" type="button"
                    style="height: 24px;padding: 0 5px;margin: 0 5px;">
                    <img width="16" height="16" src="<?php echo base_url('assets/img/addnew.png')?>" alt="">
                </button>
            </div>
            <div>
                <img id="loadingMenuItem" src="<?php echo base_url()?>assets/img/loadinfo.gif" alt=""
                    style="position: absolute;width: 20%;left: 35%;display: none;">
                <jqx-list-box
                        jqx-on-select="itemListBoxOnSelect(event)"
                        jqx-settings="itemsListboxSettings"
                        id="itemListboxSearch"
                >
                </jqx-list-box>
            </div>
        </div>
    </div>
    <!-- Right Tab | Menu Item Grid  -->
    <div class="col-lg-10 col-lg-10-item col-md-10 col-md-10-item col-sm-10 maingrid-container"
         style="padding: 0;">
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
        <?php $this->load->view($categoryName_form); ?>
            <!--<div class="droppingTarget" style="height: 400px;width: 1200px;background-color: rebeccapurple;"></div>-->
    </div>
    <!--  Windows to save data on items   -->
    <jqx-window jqx-on-close="close()" jqx-settings="itemsMenuWindowsSetting"
                jqx-create="itemsMenuWindowsSetting" class="">
        <div>
            Edit Item
        </div>
        <div flow-init flow-name="uploader.flow"
             flow-files-submitted="submitUpload($files, $event, $flow)"
             flow-file-added="fileAddedUpload($file, $event, $flow)"
             flow-file-success="successUpload($file, $message, $flow)"
             flow-file-error="errorUpload($file, $message, $flow)">

            <jqx-tabs jqx-width="'100%'"
                      id="jqxTabsMenuItemWindows">
                <ul>
                    <li>Menu Item</li>
                    <li id="">Prices</li>
                    <li id="questionsTabOnMenuItemWindow">Questions</li>
                    <li>Printers</li>
                    <li>Options</li>
                    <li>Layout</li>
                    <li>Picture</li>
                    <li>Style</li>
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
                <!-- Pictue subtab -->
                <div class="">
                    <?php $this->load->view($items_picture_subtab_view);?>
                </div>
                <!-- Pictue subtab -->
                <div class="">
                    <?php $this->load->view($items_style_subtab_view);?>
                </div>
            </jqx-tabs>

            <!-- Main buttons before saving item on grid -->
            <div class="col-md-12 col-md-offset-0">
                <div class="row">
                    <div id="mainButtonsOnItemGrid">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <span class="btn btn-success" id="uploadPictureBtn" flow-btn style="display: none;">
                                    Upload Picture
                                </span>
                                <button type="button" id="saveItemGridBtn" ng-click="saveItemGridBtn()" class="btn btn-primary" disabled>Save</button>
                                <button	type="button" id="" ng-click="closeItemGridWindows()" class="btn btn-warning">Close</button>
<!--                                <button	type="button" id="deleteItemGridBtn" ng-click="deleteItemGridBtn()" class="btn btn-danger " style="overflow:auto;">Delete</button>-->
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

            <jqx-window id="notification-window"
                jqx-is-modal="true" jqx-width="300" jqx-height="150"
                jqx-auto-open="false" jqx-show-close-button="true"
                jqx-resizable="false"
            >
                <div class="header">Notification</div>
                <div class="body">
                    <div class="text-content" style="font-size: center;font-size: 15px;margin-bottom: 15px;"></div>
                    <div class="button-content">
                        <div style="float: right; margin-top: 15px;">
                            <jqx-button id="ok" jqx-width="65"
                                style="margin-right: 10px"
                                >OK
                            </jqx-button>
                        </div>
                    </div>
                </div>
            </jqx-window>
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
    <?php $this->load->view('backoffice_admin/menu_categories/items_modal_create');?>
</div>