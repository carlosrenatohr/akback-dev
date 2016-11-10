<?php
//$this->load->view('backoffice_templates/backoffice_template.inc.php');
$this->load->view('backoffice_admin/templates/custom_header');
//$this->load->view('backoffice_templates/backoffice_category_menubar');
$this->load->view('backoffice_templates/backoffice_menubar');

//categoryjs();
//jqxangularjs();
//jqxthemes();
?>
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/angular/jquery-1.10.2.min.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/angular/angular.min.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/angular/jqwidgets/jqxangular.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/angular/jqwidgets/jqxcore.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/angular/jqwidgets/jqxdata.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/angular/jqwidgets/jqxbuttons.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/angular/jqwidgets/jqxdatatable.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/angular/jqwidgets/jqxtabs.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/angular/jqwidgets/jqxlistbox.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/angular/jqwidgets/jqxcombobox.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/angular/jqwidgets/jqxscrollbar.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/jqwidgets/jqxmenu.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/jqwidgets/jqxcalendar.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/angular/jqwidgets/jqxdatetimeinput.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/angular/jqwidgets/jqxgrid.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/angular/jqwidgets/jqxgrid.filter.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/angular/jqwidgets/jqxgrid.edit.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/angular/jqwidgets/jqxgrid.pager.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/angular/jqwidgets/jqxnotification.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/angular/jqwidgets/jqxgrid.sort.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/angular/jqwidgets/jqxgrid.columnsresize.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/angular/jqwidgets/jqxwindow.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/angular/jqwidgets/jqxcheckbox.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/angular/jqwidgets/jqxdropdownlist.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/js/angular/jqwidgets/jqxgrid.selection.js"></script>-->


<script type="text/javascript">
    $("#tabtitle").text("Items Brand");
</script>
<script type="application/javascript" src="<?php echo base_url() ?>assets/admin/menu/item_brand_controller.js"></script>
<script type="application/javascript" src="<?php echo base_url() ?>assets/admin/menu/admin_service.js"></script>

<div class="container-fluid" ng-controller="itemBrandController">

    <div class="row">
        <nav class="navbar navbar-default" role="navigation" style="background:#CCC;">
            <div class="col-md-12">
                <div id="toolbar" class="toolbar-list">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="<?php echo base_url("backoffice/dashboard") ?>" style="outline:0;">
                                <span class="icon-32-home"></span>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("dashboard/items") ?>" style="outline:0;">
                                <span class="icon-32-back"></span>
                                Back
                            </a>
                        </li>
                        <li>
                            <a style="outline:0;" ng-click="openIbrands()">
                                <span class="icon-32-new"></span>
                                New
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-12">
            <jqx-grid id="ibrandsGrid"
                      jqx-settings="ibrandsGridSettings"
                      jqx-create="ibrandsGridSettings"
                      jqx-on-rowdoubleclick="editIbrands(e)"
            ></jqx-grid>
        </div>
        <jqx-window jqx-on-close="close()" jqx-settings="ibrandsWindowSettings"
                    jqx-create="ibrandsWindowSettings" id="">
            <div >
                New Brand | Details
            </div>
            <div >
                <jqx-tabs jqx-width="'100%'"
                          jqx-on-selecting=""
                          id="ibrandsTabs">
                    <ul>
                        <li>Brand</li>
                        <li id="secondBrandTab">Info</li>
                    </ul>
                    <!-- Brand subtab -->
                    <div class="">
                        <?php $this->load->view($brand_subtab); ?>
                    </div>
                    <!-- Info subtab -->
                    <div class="">
                        <?php $this->load->view($info_subtab); ?>
                    </div>
                </jqx-tabs>

                <!-- Main buttons before saving item on grid -->
                <div class="col-md-12 col-md-offset-0">
                    <div class="row">
                        <div id="mainIbrandsBtns" class="">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="button" id="saveIbrandsBtn" ng-click="saveIbrands()"
                                            class="btn btn-primary" disabled>
                                        Save
                                    </button>
                                    <button type="button" ng-click="closeIbrands()" class="btn btn-warning">Close</button>
                                    <button type="button" id="deleteIbrandsBtn" ng-click="deleteIbrands()" class="btn btn-danger"
                                            style="overflow:auto;display: none;">Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Prompt before saving item on grid -->
                <div class="col-md-12 col-md-offset-0">
                    <div class="row">
                        <div id="closeIbrandsBtns" class="" style="display: none">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="message">Do you want to save your changes?</div>
                                    <button type="button" ng-click="closeIbrands(0)" class="btn btn-primary">Yes</button>
                                    <button type="button" ng-click="closeIbrands(1)" class="btn btn-warning">No</button>
                                    <button type="button" ng-click="closeIbrands(2)" class="btn btn-info">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Prompt before delete an item on grid -->
                <div class="col-md-12 col-md-offset-0">
                    <div class="row">
                        <div id="deleteIbrandsBtns" class="" style="display: none">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    Do you really want to delete it?
                                    <button type="button" ng-click="deleteIbrands(0)" class="btn btn-primary">Yes</button>
                                    <button type="button" ng-click="deleteIbrands(1)" class="btn btn-warning">No</button>
                                    <button type="button" ng-click="deleteIbrands(2)" class="btn btn-info">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- NOTIFICATIONS AREA -->
                <div class="col-md-12 col-md-offset-0">
                    <div class="row">
                        <jqx-notification jqx-settings="ibrandsSuccessMsg" id="ibrandsSuccessMsg">
                            <div id="msg"></div>
                        </jqx-notification>
                        <jqx-notification jqx-settings="ibrandsErrorMsg" id="ibrandsErrorMsg">
                            <div id="msg"></div>
                        </jqx-notification>
                        <div id="notification_container_ibrands"
                             style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
                    </div>
                </div>
            </div>
        </jqx-window>

    </div>
</div>

<style>
    #invMainWindow {
        max-height: 85%!important;
    }
    .required-ast {
        color: #F00;
        text-align: left;
        padding: 4px;
        font-weight: bold;
    }
    .inventory_tab .row {
        margin-bottom: 5px;
    }
    .row.inventory_tab {
        margin: 0!important;
    }
</style>
<?php $this->load->view('backoffice_includes/backoffice_mainmenu_footer'); ?>