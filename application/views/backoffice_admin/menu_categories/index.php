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
<script type="text/javascript" src="<?= base_url()?>assets/js/jqwidgets/jqxdragdrop.js"></script>

<script type="application/javascript" src="../../assets/admin/menu_categories_controller.js"></script>
<script type="application/javascript" src="../../assets/admin/menu_items_controller.js"></script>
<script type="application/javascript" src="../../assets/admin/menu_items_directives.js"></script>
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
                <jqx-tabs  jqx-width="'100%'" jqx-height="'100%'" id="MenuCategoriesTabs">
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

<!--                                                <div style="float:left; padding:2px; width:350px;">-->
<!--                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Row:</div>-->
<!--                                                    <div style="float:left; width:180px;">-->
<!--                                                        <input type="number" class="form-control required-field" id="add_MenuRow"-->
<!--                                                               name="add_Row" placeholder="Row"-->
<!--                                                               step="1" min="1" pattern="\d*"-->
<!--                                                        >-->
<!--                                                    </div>-->
<!--                                                    <div style="float:left;">-->
<!--                                                        <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!---->
<!--                                                <div style="float:left; padding:2px; width:350px;">-->
<!--                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Column:</div>-->
<!--                                                    <div style="float:left; width:180px;">-->
<!--                                                        <input type="number" class="form-control required-field" id="add_MenuColumn"-->
<!--                                                               name="add_Column" placeholder="Column"-->
<!--                                                               step="1" min="1" pattern="\d*"-->
<!--                                                        >-->
<!--                                                    </div>-->
<!--                                                    <div style="float:left;">-->
<!--                                                        <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>-->
<!--                                                    </div>-->
<!--                                                </div>-->
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
                                    <div class="col-md-12 col-md-offset-0">
                                        <div class="row">
                                            <div id="promptToSaveInCloseButtonMenu" class="alertButtonsMenuCategories">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        Do you want to save your changes?
                                                        <button type="button" ng-click="CloseMenuWindows(0)" class="btn btn-primary">Yes</button>
                                                        <button type="button" ng-click="CloseMenuWindows(1)" class="btn btn-warning">No</button>
                                                        <button type="button" ng-click="CloseMenuWindows(2)" class="btn btn-info">Cancel</button>
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
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Row:</div>
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

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Column:</div>
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
                    </div>
                    <!-- -------------- -->
                    <!-- ITEMS TAB -->
                    <!-- -------------- -->
                    <div class="" ng-controller="menuItemController">
                        <div class="">
                            <div class="col-md-2">
                                <jqx-tabs jqx-width="'100%'" jqx-height="'100%'" id="jqxTabsMenuItemSection">
                                    <ul>
                                        <li>Menu</li>
                                        <li>Items</li>
                                    </ul>
                                    <div class="">
                                        <div class="">
                                            <jqx-list-box jqx-settings="menuListBoxSettings" id="menuListBox"
                                                          jqx-on-select="menuListBoxSelecting(event)">
                                            </jqx-list-box>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="" >
<!--                                            <jqx-list-box jqx-settings="menuListBoxSettings" id=""-->
<!--                                                          jqx-on-select="">-->
<!--                                            </jqx-list-box>-->
                                            <div>Type an item to find:</div>
                                            <jqx-combo-box
                                                jqx-on-select="itemComboboxOnselect(event)"
                                                jqx-on-unselect=""
                                                jqx-settings="itemsComboboxSettings"></jqx-combo-box>
                                            <div class="" style="min-height: 20px;"></div>
                                            <div id="selectedItemInfo">
                                                {{ selectedItemInfo.Description }}
                                            </div>
                                        </div>
                                    </div>
                                </jqx-tabs>
                            </div>

                            <div class="col-md-10 restricter-dragdrop">
<!--                            <div class="droppingTarget" style="height: 400px;width: 1200px;background-color: rebeccapurple;"></div>-->
                            </div>
                            <div class="col-md-12">
                                <h4 class="col-md-offset-2">Category grid</h4>
                                <div class="col-md-offset-2 col-md-10" id="categories-container">
                                    <category-cell ng-repeat="uno in categoriesByMenu" ng-click="clickCategoryCell($event, uno)" category-title="{{uno.CategoryName}}">
                                    </category-cell>
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
                                            <div style=" width:330px;float:left;">
                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Item:</div>
                                                    <div style="float:left; width:180px;">
                                                        <jqx-combo-box
                                                            jqx-on-select=""
                                                            jqx-on-unselect=""
                                                            jqx-settings="itemsComboboxSettings"
                                                            id="editItem_ItemSelected">
                                                        </jqx-combo-box>
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Label:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control required-field" id="editItem_label" name="editItem_label" placeholder="Label">
                                                    </div>
                                                    <div style="float:left;">
                                                        <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Status:</div>
                                                    <div style="float:left; width:180px;">
                                                        <select name="editItem_Status" id="editItem_Status">
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
                                            <div id="mainButtonsForEdittingItems">
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
                                </div>
                            </jqx-window>
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

    /* ITEMS */
    .restricter-dragdrop {
        max-height: 500px;
        min-height: 400px;
        overflow-y: scroll;
        background-color: lightgrey;
        border: black 2px dotted;
        padding: 0!important;
    }
    .restricter-dragdrop .row {
        margin-right: 0!important;margin-left: 0!important;
    }
    .restricter-dragdrop .col-md-*, .restricter-dragdrop .col-sm-*  {
        margin-right: 0!important;margin-left: 0!important;
    }
    .restricter-dragdrop .draggable {
        height: 120px;
        background-color: #f0f0f0;
        border: black 1px solid;
        color: #fff;
        padding: 0!important;
    }

    /*.restricter-dragdrop .itemOnGrid {*/
        /*z-index: 999999;*/
    /*}*/

    #categories-container {
        max-height: 300px;
        min-height: 250px;
        overflow-y: scroll;
        background-color: lightgrey;
        border: black 2px dotted;
        padding: 0!important;
    }

    #selectedItemInfo {
        background-color: lightblue;
        -webkit-border-radius:3px;
        -moz-border-radius:3px;
        border-radius:3px;
        height: 40px;
        width: 100%;
        margin: 10px 0;
        text-align: center;
    }

    .category-cell-grid {
        height: 100px;
        background-color: #bc0530;
        color: #fff;
        border: black 1px solid;
        text-align: center;
        padding-top: 40px;
    }
    .category-cell-grid.clicked {
        background-color: #ee063d;
        border: black 2px solid;
        box-shadow: 3px 3px 2px #888888;
    }

</style>

<?php $this->load->view('backoffice_includes/backoffice_mainmenu_footer'); ?>