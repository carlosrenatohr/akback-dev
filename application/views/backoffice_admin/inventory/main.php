<?php
//$this->load->view('backoffice_templates/backoffice_template.inc.php');
//$this->load->view('backoffice_includes/backoffice_mainmenu_header');
////$this->load->view('backoffice_templates/backoffice_category_menubar');
//$this->load->view('backoffice_templates/backoffice_menubar');
//
//categoryjs();
//jqxangularjs();
//jqxthemes();
?>
<script type="text/javascript">
//    var SiteRoot ="<?php //echo base_url() ?>//";
    $("#tabtitle").text("Items");
</script>
<!--<script type="application/javascript" src="--><?php //echo base_url()?><!--assets/js/angular/jqwidgets/jqxradiobutton.js"></script>-->
<script type="application/javascript" src="<?php echo base_url() ?>assets/admin/menu/config.js"></script>
    <script type="application/javascript" src="<?php echo base_url() ?>assets/admin/menu/admin_service.js"></script>
    <script type="application/javascript" src="<?php echo base_url() ?>assets/admin/menu/menu_questions_service.js"></script>
    <script type="application/javascript" src="<?php echo base_url() ?>assets/admin/menu/menu_inventory_controller.js"></script>
    <script type="application/javascript" src="<?php echo base_url() ?>assets/admin/menu/menu_inventory_service.js"></script>
<script type="application/javascript" src="<?php echo base_url() ?>assets/admin/menu/menu_inventory_directive.js"></script>
<script type="application/javascript" src="<?php echo base_url() ?>assets/admin/menu/menu_inventory_relations_service.js"></script>
<!-- ng-flow libraries -->
<script src="<?php echo base_url() ?>assets/admin/ng-flow-standalone.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/fusty-flow.js"></script>
<script src="<?php echo base_url() ?>assets/admin/fusty-flow-factory.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/styles.css">
<!--<link rel="stylesheet" href="--><?php //echo base_url() ?><!--assets/js/jqwidgets/styles/jqx.summer.css" type="text/css" />-->

<div class="container-fluid" id="inventorySection"
     ng-controller="menuItemsInventoryController" style="padding: 0;">

    <div class="">
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
                            <a href="<?php echo base_url("dashboard/items/brands") ?>" style="outline:0;">
                                <span class="icon-item-brand"></span>
                                Brands
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("dashboard/items/count") ?>" style="outline:0;">
                                <span class="icon-item-count"></span>
                                Count
                            </a>
                        </li>
                        <li>
                            <a style="outline:0;" ng-click="openInventoryWind()">
                                <span class="icon-new"></span>
                                New
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="" style="width:100%;height: 1200px;max-height: 500px;overflow-y: scroll;">
<!--        <div class="col-md-12" style="padding: 0;margin: 5px 0;">-->
<!--            <div class="col-md-5" style="padding: 0 2px;">-->
<!--                <input type="text" id="InventorySearchField" class="form-control" placeholder="Search.."-->
<!--                       style="padding: 0 5px;height: 24px;" autofocus>-->
<!--            </div>-->
<!--            <button class="btn btn-info col-md-1" id="InventorySearchBtn" type="button"-->
<!--                    style="height: 24px;padding: 0 5px;">Search</button>-->
<!--            <img id="loadingMenuItem" src="--><?php //echo base_url()?><!--asset s/img/loadinfo.gif" alt=""-->
<!--                 style="position: absolute;width: 3%;left: 1%;top: -25px;z-index: 999;display: none;">-->
<!--            <div class="col-md-offset-4"></div>-->
<!--        </div>-->
        <jqx-grid id="inventoryItemsGrid"
                  jqx-settings="inventoryItemsGrid"
                  jqx-on-rowdoubleclick="editInventoryWind(e)"
                  jqx-create="inventoryItemsGrid"
        ></jqx-grid>
        <!-- - -->
        <jqx-window jqx-on-close="closeInventoryWind($event)" jqx-settings="itemsInventoryWindowSettings"
                    jqx-create="itemsInventoryWindowSettings" id="invMainWindow">
            <div>
                New Item | Details
            </div>
            <div flow-init flow-name="uploader.flow"
                 flow-files-submitted="submitUpload($files, $event, $flow)"
                 flow-file-added="fileAddedUpload($file, $event, $flow)"
                 flow-file-success="successUpload($file, $message, $flow)">
                <jqx-tabs jqx-width="'100%'"
                          jqx-on-selecting=""
                          id="inventoryTabs">
                    <ul>
                        <li>Item</li>
                        <li>Cost</li>
                        <li>Prices</li>
                        <li>Stock Level</li>
                        <li>Tax</li>
                        <li>Barcode</li>
                        <li>Questions</li>
                        <li>Printers</li>
                        <li>Options</li>
                        <li id="picture_tab">Picture</li>
<!--                        <li id="">Style</li>-->
                    </ul>
                    <!-- Item subtab -->
                    <div class="">
                        <?php $this->load->view($inventory_item_subtab_view); ?>
                    </div>
                    <!-- Cost subtab -->
                    <div class="">
                        <?php $this->load->view($inventory_cost_subtab_view); ?>
                    </div>
                    <!-- Price subtab -->
                    <div class="">
                        <?php $this->load->view($inventory_price_subtab_view); ?>
                    </div>
                    <!-- Stock Level subtab -->
                    <div class="">
                        <?php $this->load->view($inventory_stocklevel_subtab_view); ?>
                    </div>
                    <!-- Tax subtab -->
                    <div class="">
                        <?php $this->load->view($inventory_tax_subtab_view); ?>
                    </div>
                    <!-- Barcode subtab -->
                    <div class="">
                        <?php $this->load->view($inventory_barcode_subtab_view); ?>
                    </div>
                    <!-- Question subtab -->
                    <div class="">
                        <?php $this->load->view($inventory_question_subtab_view); ?>
                    </div>
                    <!-- Printer subtab -->
                    <div class="">
                        <?php $this->load->view($inventory_printer_subtab_view); ?>
                    </div>
                    <!-- Options subtab -->
                    <div class="">
                        <?php $this->load->view($inventory_options_subtab_view); ?>
                    </div>
                    <!-- Picture subtab -->
                    <div class="">
                        <?php $this->load->view($inventory_picture_subtab_view); ?>
                    </div>
                    <!-- Style subtab -->
<!--                    <div class="">-->
<!--                        --><?php //$this->load->view($inventory_style_subtab_view); ?>
<!--                    </div>-->
                </jqx-tabs>
                <?php $this->load->view($inventory_btns); ?>
            </div>
        </jqx-window>

    </div>
</div>
    <input type="hidden" id="decimalCost" value="<?php echo $decimalsCost; ?>">
    <input type="hidden" id="decimalQty" value="<?php echo $decimalsQuantity;?>">
<?php $this->load->view('backoffice_includes/backoffice_mainmenu_footer'); ?>