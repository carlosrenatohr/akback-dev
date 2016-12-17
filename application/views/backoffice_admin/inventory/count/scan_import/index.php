<script type="text/javascript">
    $("#tabtitle").text("Item Scan Import");
</script>
<script type="application/javascript" src="<?php echo base_url() ?>assets/js/angular/jqwidgets/jqxfileupload.js"></script>
<script type="application/javascript" src="<?php echo base_url() ?>assets/admin/menu/item_scan_controller.js"></script>
<script type="application/javascript" src="<?php echo base_url() ?>assets/admin/menu/admin_service.js"></script>
<script type="application/javascript" src="<?php echo base_url() ?>assets/admin/menu/item_count_service.js"></script>

<div class="container-fluid" ng-controller="itemScanController">

    <div class="row">
        <nav class="navbar navbar-default" role="navigation" style="background:#CCC;">
            <div class="col-md-12">
                <div id="toolbar" class="toolbar-list">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="<?php echo base_url("backoffice/dashboard") ?>" style="outline:0;">
                                <span class="icon-home"></span>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("dashboard/items/count") ?>" style="outline:0;">
                                <span class="icon-back"></span>
                                Back
                            </a>
                        </li>
                        <li>
                            <a style="outline:0;" ng-click="openScan()">
                                <span class="icon-new"></span>
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
            <jqx-grid id="iscanGrid"
                      jqx-settings="iscanGridSettings"
                      jqx-create="iscanGridSettings"
                      jqx-on-rowdoubleclick="editScan(e)"
            ></jqx-grid>
            <jqx-window jqx-on-close="close()" jqx-settings="iscanWindowSettings"
                        jqx-create="iscanWindowSettings" id="itemcountWindow"
                        >
                <div >
                    Item Count | Details
                </div>
                <div >
                    <jqx-tabs jqx-width="'100%'"
                              id="iscanTabs">
                        <ul>
                            <li>Import</li>
                            <li>Scan List</li>
                        </ul>
                        <!-- Import subtab -->
                        <div class="">
                            <?php $this->load->view($import_subtab); ?>
                        </div>
                        <!-- Scan List subtab -->
                        <div class="">
                            <?php $this->load->view($list_subtab); ?>
                        </div>
                    </jqx-tabs>
<!--                    <input type="hidden" id="decimalCost" value="--><?php //echo $decimalCost;?><!--">-->
<!--                    <input type="hidden" id="decimalQty" value="--><?php //echo $decimalQty;?><!--">-->

<!--                    <!-- Main buttons before saving item on grid -->
                    <div class="col-md-12 col-md-offset-0">
                        <div class="row">
                            <div id="mainIscanBtns" class="">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button type="button" ng-click="closeIscan()"
                                                class="btn btn-warning"
                                        >Close</button>
                                        <button type="button" id="saveIscanBtn"
                                                ng-click="saveScan()" class="btn btn-primary" disabled
                                            >Import</button>
                                        <button type="button" id="matchIscanBtn" ng-click=""
                                                class="btn btn-success" style="overflow:auto;display: none;"
                                            >Item Match</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Prompt before saving item on grid -->
                    <div class="col-md-12 col-md-offset-0">
                        <div class="row">
                            <div id="closeIscanBtns" class="" style="display: none">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="message">Do you want to save your changes?</div>
                                        <button type="button" ng-click="closeIscan(0)" class="btn btn-primary">Yes</button>
                                        <button type="button" ng-click="closeIscan(1)" class="btn btn-warning">No</button>
                                        <button type="button" ng-click="closeIscan(2)" class="btn btn-info">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Prompt before delete an item on grid -->
                    <div class="col-md-12 col-md-offset-0">
                        <div class="row">
                            <div id="deleteIscanBtns" class="" style="display: none">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        Do you really want to delete it?
                                        <button type="button" ng-click="deleteIscan(0)" class="btn btn-primary">Yes</button>
                                        <button type="button" ng-click="deleteIscan(1)" class="btn btn-warning">No</button>
                                        <button type="button" ng-click="deleteIscan(2)" class="btn btn-info">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Prompt before finish count on item count list -->
                    <div class="col-md-12 col-md-offset-0">
                        <div class="row">
                            <div id="matchIscanBtnContainer" class="" style="display: none">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <p>Ready to find into items?</p>
                                        <button type="button" ng-click="matchIscan(0)" class="btn btn-primary">Find</button>
                                        <button type="button" ng-click="matchIscan(1)" class="btn btn-info">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- NOTIFICATIONS AREA -->
                    <div class="col-md-12 col-md-offset-0">
                        <div class="row">
                            <jqx-notification jqx-settings="iscanSuccessMsg" id="iscanSuccessMsg">
                                <div id="msg"></div>
                            </jqx-notification>
                            <jqx-notification jqx-settings="iscanErrorMsg" id="iscanErrorMsg">
                                <div id="msg"></div>
                            </jqx-notification>
                            <div id="notification_container_iscan"
                                 style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
                        </div>
                    </div>
                </div>
            </jqx-window>
        </div>

    </div>
</div>

<style>
    #itemcountWindow {
        max-height: 99%!important;max-width:99%!important;
    }
</style>