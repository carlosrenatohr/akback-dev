<script type="text/javascript">
    $("#tabtitle").text("Items Count");
</script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/angular/jqwidgets/jqxfileupload.js"></script>
<script type="application/javascript" src="<?php echo base_url() ?>assets/admin/menu/item_count_controller.js"></script>
<script type="application/javascript" src="<?php echo base_url() ?>assets/admin/menu/admin_service.js"></script>
<script type="application/javascript" src="<?php echo base_url() ?>assets/admin/menu/item_count_service.js"></script>

<div class="container-fluid" ng-controller="itemCountController">

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
                            <a href="<?php echo base_url("dashboard/items") ?>" style="outline:0;">
                                <span class="icon-back"></span>
                                Back
                            </a>
                        </li>
                        <li>
                            <a style="outline:0;" ng-click="openIcount()">
                                <span class="icon-new"></span>
                                New
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('dashboard/items/count/import')?>" style="outline:0;">
                                <span class="icon-import"></span>
                                Import
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-12">
            <jqx-tabs id="">
                <ul>
                    <li>In Progress</li>
                    <li>Complete</li>
                </ul>
                <div>
                    <jqx-grid id="icountGrid1"
                              jqx-settings="icountGridProgressSettings"
                              jqx-create="icountGridProgressSettings"
                              jqx-on-rowdoubleclick="editIcount(e)"
                    ></jqx-grid>
                </div>
                <div>
                    <jqx-grid id="icountGrid2"
                              jqx-settings="icountGridCompleteSettings"
                              jqx-create="icountGridCompleteSettings"
                              jqx-on-rowdoubleclick="editIcount(e)"
                    ></jqx-grid>
                </div>
            </jqx-tabs>
            <jqx-window jqx-on-close="close()" jqx-settings="icountWindowSettings"
                        jqx-create="icountWindowSettings" id="itemcountWindow">
                <div>
                    Item Count | Details
                </div>
                <div >
                    <!-- Main buttons before saving -->
                    <?php $this->load->view($btns_template); ?>
                    <jqx-tabs jqx-width="'100%'"
                              id="icountTabs">
                        <ul>
                            <li>Count</li>
                            <li>Filters</li>
                            <li>Import</li>
                            <li>Count List</li>
                        </ul>
                        <!-- Count subtab -->
                        <div class="">
                            <?php $this->load->view($count_subtab); ?>
                        </div>
                        <!-- Count Filters subtab -->
                        <div class="">
                            <?php $this->load->view($filters_subtab); ?>
                        </div>
                        <!-- Apply Scans subtab -->
                        <div class="">
                            <?php $this->load->view($applyscan_subtab); ?>
                        </div>
                        <!-- Count List subtab -->
                        <div class="">
                            <?php $this->load->view($list_subtab); ?>
                        </div>
                    </jqx-tabs>
                    <input type="hidden" id="decimalCost" value="<?php echo $decimalCost;?>">
                    <input type="hidden" id="decimalQty" value="<?php echo $decimalQty;?>">

<!--                    <div class="col-md-12 col-md-offset-0">-->
<!--                        <div class="row">-->
<!--                            <div id="mainIcountBtns" class="">-->
<!--                                <div class="form-group">-->
<!--                                    <div class="col-sm-12">-->
<!--                                        <button type="button" ng-click="closeIcount()"-->
<!--                                                class="btn btn-warning"-->
<!--                                        >Close</button>-->
<!--                                        <button type="button" id="saveIcountBtn"-->
<!--                                                ng-click="saveIcount()" class="btn btn-primary" disabled-->
<!--                                            >Build Count List</button>-->
<!--                                        <button type="button" id="finishIcountBtn" ng-click="finishIcount()"-->
<!--                                                class="btn btn-success" style="overflow:auto;display: none;"-->
<!--                                            >Finish Count</button>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->

                    <!-- Prompt before saving item on grid -->
                    <div class="col-md-12 col-md-offset-0">
                        <div class="row">
                            <div id="closeIcountBtns" class="" style="display: none">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="message">Do you want to save your changes?</div>
                                        <button type="button" ng-click="closeIcount(0)" class="btn btn-primary">Yes</button>
                                        <button type="button" ng-click="closeIcount(1)" class="btn btn-warning">No</button>
                                        <button type="button" ng-click="closeIcount(2)" class="btn btn-info">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Prompt before delete an item on grid -->
<!--                    <div class="col-md-12 col-md-offset-0">-->
<!--                        <div class="row">-->
<!--                            <div id="deleteIcountBtns" class="" style="display: none">-->
<!--                                <div class="form-group">-->
<!--                                    <div class="col-sm-12">-->
<!--                                        Do you really want to delete it?-->
<!--                                        <button type="button" ng-click="deleteIcount(0)" class="btn btn-primary">Yes</button>-->
<!--                                        <button type="button" ng-click="deleteIcount(1)" class="btn btn-warning">No</button>-->
<!--                                        <button type="button" ng-click="deleteIcount(2)" class="btn btn-info">Cancel</button>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                    <!-- Prompt before finish count on item count list -->
<!--                    <div class="col-md-12 col-md-offset-0">-->
<!--                        <div class="row">-->
<!--                            <div id="finishIcountBtns" class="" style="display: none">-->
<!--                                <div class="form-group">-->
<!--                                    <div class="col-sm-12">-->
<!--                                        <p>Your stock will be adjusted based on above counts. <br>-->
<!--                                            Press Finalize to continue or Cancel to continue editing</p>-->
<!--                                        <button type="button" ng-click="finishIcount(0)" class="btn btn-primary">Finalize</button>-->
<!--                                        <button type="button" ng-click="finishIcount(1)" class="btn btn-info">Cancel</button>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->

                    <!-- Prompt before finish count on item count list -->
<!--                    <div class="col-md-12 col-md-offset-0">-->
<!--                        <div class="row">-->
<!--                            <div id="setZeroIcountBtns" class="" style="display: none">-->
<!--                                <div class="form-group">-->
<!--                                    <div class="col-sm-12">-->
<!--                                        <p>-->
<!--                                            This will add Zero Quantity to all items that don't already have a Quantity in Count Column.<br>-->
<!--                                            Items that already have a quantity in Count Column will not be changed. <br>-->
<!--                                            Are you sure you want to do this?-->
<!--                                        </p>-->
<!--                                        <button type="button" ng-click="setZeroIcount(0)" class="btn btn-primary">Yes</button>-->
<!--                                        <button type="button" ng-click="setZeroIcount(1)" class="btn btn-info">Cancel</button>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                    <!-- NOTIFICATIONS AREA -->
                    <div class="col-md-12 col-md-offset-0">
                        <div class="row">
                            <jqx-notification jqx-settings="icountSuccessMsg" id="icountSuccessMsg">
                                <div id="msg"></div>
                            </jqx-notification>
                            <jqx-notification jqx-settings="icountErrorMsg" id="icountErrorMsg">
                                <div id="msg"></div>
                            </jqx-notification>
                            <div id="notification_container_icount"
                                 style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
                        </div>
                    </div>
                </div>
            </jqx-window>
        </div>

    </div>
</div>