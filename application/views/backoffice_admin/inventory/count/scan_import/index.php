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
                      style="padding: 0;"
            ></jqx-grid>
            <jqx-window jqx-on-close="close()" jqx-settings="iscanWindowSettings"
                        jqx-create="iscanWindowSettings" id="itemcountWindow"
                        >
                <div >
                    Item Count | Details
                </div>
                <div >
                    <?php $this->load->view($btns_template); ?>
                    <jqx-tabs jqx-width="'100%'"
                              id="iscanTabs">
                        <ul>
                            <li>Import</li>
                            <li>Scan List</li>
                        </ul>
                        <!-- Import subtab -->
                        <div class="" id="scan_tab1">
<!--                            --><?php //$this->load->view($btns_template); ?>
                            <?php $this->load->view($import_subtab); ?>
                        </div>
                        <!-- Scan List subtab -->
                        <div class="" id="scan_tab2">
                            <?php $this->load->view($list_subtab); ?>
                        </div>
                    </jqx-tabs>
<!--                    <input type="hidden" id="decimalCost" value="--><?php //echo $decimalCost;?><!--">-->
<!--                    <input type="hidden" id="decimalQty" value="--><?php //echo $decimalQty;?><!--">-->

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
        padding: 0!important;
    }
</style>