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
                    </ul>
                    <div>
                        <div>
                            <div>
                                <a style="outline:0;" class="btn btn-info" ng-click="newMenuAction()">
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
                                    <div class="col-md-12 col-md-offset-0">
                                        <div class="row">
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
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-md-offset-0">
                                        <div class="row">
                                            <div id="">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <button type="button" id="" ng-click="SaveMenuWindows()" class="btn btn-primary" >Save</button>
                                                        <button	type="button" id="" ng-click="CloseMenuWindows()" class="btn btn-warning">Close</button>
<!--                                                        <button	type="button" id="" ng-click="" class="btn btn-danger " style="display:none; overflow:auto;">Delete</button>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </jqx-window>
                        </div>
                    </div>
                    <div>
                        <div>
                            <a style="outline:0;" class="btn btn-info" ng-click="">
                                <span class="icon-32-new"></span>
                                New
                            </a>
                            <jqx-data-table jqx-settings="categoriesTableSettings"
                                            jqx-on-row-double-click="">
                            </jqx-data-table>
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