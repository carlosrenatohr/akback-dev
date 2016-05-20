<?php $this->load->view('backoffice_templates/backoffice_template.inc.php'); ?>

<?php $this->load->view('backoffice_includes/backoffice_mainmenu_header'); ?>

<?php $this->load->view('backoffice_templates/backoffice_category_menubar'); ?>

<?php
jqxangularjs();
jqxthemes();
?>
<script type="text/javascript">
    var SiteRoot ="<?php echo base_url() ?>";
    $("#tabtitle").text("Category");
</script>
<script type="application/javascript" src="../../assets/admin/menu_categories_controller.js"></script>
<script type="application/javascript" src="../../assets/admin/menu_items_controller.js"></script>
<div class="parent-container" ng-controller="menuCategoriesController">
    <div ng-cloak class="row-offcanvas row-offcanvas-left ng-cloak">
        <div style="width: 100%;">
            <nav class="navbar navbar-default" role="navigation" style="background:#CCC;">
                <div class="col-md-12">
                    <div id="toolbar" class="toolbar-list">
                        <ul class="nav navbar-nav navbar-left" style="color: #000;">
                            <li>
                                <a href="<?php echo base_url("dashboard/admin")?>" style="outline:0;">
                                    <span class="icon-32-back"></span>
                                    Back
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div>
                <jqx-tabs id="tabs" jqx-width="'100%'" jqx-height="'580px'">
                    <ul>
                        <li>Menu</li>
                        <li>Categories</li>
                        <li>Items</li>
                    </ul>
                    <!-- -------------- -->
                    <!-- MENU TAB -->
                    <!-- -------------- -->
                    <div>
                        <div>
                            <div>
                                <a style="outline:0;margin: 10px 2px;" class="btn btn-info" ng-click="newMenuAction()">
                                    <span class="icon-32-new"></span>
                                    New
                                </a>
                            </div>
                            <jqx-data-table jqx-settings="menuTableSettings"
                                            jqx-on-row-double-click="updateMenuAction(event)">
                            </jqx-data-table>

                            <jqx-window jqx-on-close="close()" jqx-settings="addMenuWindowSettings"
                                        jqx-create="addMenuWindowSettings" class="">
                                <div>
                                    Add new menu
                                </div>
                                <div>
                                    <div class="col-md-12 col-md-offset-0" id="menuWindowContent">
                                        <div class="row menuFormContainer">
                                            <div style=" width:330px;float:left;">
                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Menu Name:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control required-field" id="add_MenuName" name="add_MenuName" placeholder="Menu Name" autofocus>
                                                    </div>
                                                    <div style="float:left;">
                                                        <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Status:</div>
                                                    <div style="float:left; width:180px;">
                                                        <select name="add_Status" id="add_Status">
                                                            <option value="1">Enabled</option>
                                                            <option value="2">Disabled</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Row:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="number" class="form-control required-field" id="add_MenuRow"
                                                               name="add_Row" placeholder="Row"
                                                               step="1" min="1" pattern="\d*"
                                                        >
                                                    </div>
                                                    <div style="float:left;">
                                                        <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Column:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="number" class="form-control required-field" id="add_MenuColumn"
                                                               name="add_Column" placeholder="Column"
                                                               step="1" min="1" pattern="\d*"
                                                        >
                                                    </div>
                                                    <div style="float:left;">
                                                        <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-md-offset-0">
                                        <div class="row">
                                            <div id="mainButtonsForMenus">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <button type="button" id="saveMenuBtn" ng-click="SaveMenuWindows()" class="btn btn-primary" disabled>Save</button>
                                                        <button	type="button" id="" ng-click="CloseMenuWindows()" class="btn btn-warning">Close</button>
                                                        <button	type="button" id="deleteMenuBtn" ng-click="beforeDeleteMenu()" class="btn btn-danger " style="display:none; overflow:auto;">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ALERT MESSAGES BEFORE ACTIONS -->
                                    <style>
                                        .alertButtonsMenuCategories {
                                            display:none;
                                        }
                                    </style>
                                    <div class="col-md-12 col-md-offset-0">
                                        <div class="row">
                                            <div id="beforeDeleteMenu" class="alertButtonsMenuCategories">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        Are you sure you want to delete it?
                                                        <button type="button" ng-click="beforeDeleteMenu(0)" class="btn btn-primary">Yes</button>
                                                        <button type="button" ng-click="beforeDeleteMenu(1)" class="btn btn-warning">No</button>
                                                        <button type="button" ng-click="beforeDeleteMenu(2)" class="btn btn-info">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- NOTIFICATIONS AREA -->
                                    <div class="col-md-12 col-md-offset-0">
                                        <div class="row">
                                            <jqx-notification jqx-settings="menuNotificationsSuccessSettings" id="menuNotificationsSuccessSettings">
                                                <div id="notification-content"></div>
                                            </jqx-notification>
                                            <jqx-notification jqx-settings="menuNotificationsErrorSettings" id="menuNotificationsErrorSettings">
                                                <div id="notification-content"></div>
                                            </jqx-notification>
                                            <div id="notification_container" style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
                                        </div>
                                    </div>
                                </div>
                            </jqx-window>
                        </div>
                    </div >
                    <!-- -------------- -->
                    <!-- CATEGORIES TAB -->
                    <!-- -------------- -->
                    <div>
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
                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Category Name:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control required-field" id="add_CategoryName" name="add_CategoryName" placeholder="Category Name" autofocus>
                                                    </div>
                                                    <div style="float:left;">
                                                        <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Menu:</div>
                                                    <div style="float:left; width:180px;">
                                                        <jqx-drop-down-list id="add_MenuUnique"
                                                            jqx-settings="settingsMenuSelect"
                                                            jqx-on-select="">
                                                        </jqx-drop-down-list>
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Sort:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control required-field" id="add_Sort" name="add_Sort" placeholder="Sort">
                                                    </div>
                                                    <div style="float:left;">
                                                        <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Status:</div>
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
                    </div>
                    <!-- -------------- -->
                    <!-- ITEMS TAB -->
                    <!-- -------------- -->
                    <div class="" ng-controller="menuItemController">
                        <div class="">
                            <jqx-list-box jqx-settings="menuListBoxSettings" id="menuListBox"
                                          jqx-on-select="menuListBoxSelecting(event)">
                            </jqx-list-box>
                        </div>
                    </div>

                </jqx-tabs>
            </div>
        </div>
    </div>
    <input type="hidden" id="userid" ng-model="userid" />
</div>
<style type="text/css">
    body{
        margin: 0;
        padding: 0;
        overflow:hidden;
    }

        div.toolbar-list a {
        cursor: pointer;
        display: block;
        float: left;
        padding: 1px 10px;
        white-space: nowrap;
    }

    div.toolbar-list span {
        display: block;
        float: none;
        height: 32px;
        margin: 0 auto;
        width: 32px;
    }
    .icon-32-new {
        background-image: url("../../assets/img/addnew.png");
    }

    .icon-32-back {
        background-image: url("../../assets/img/back.png");
    }
</style>

<?php $this->load->view('backoffice_includes/backoffice_mainmenu_footer'); ?>