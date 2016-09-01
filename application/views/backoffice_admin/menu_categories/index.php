<?php
$this->load->view('backoffice_templates/backoffice_template.inc.php');
$this->load->view('backoffice_includes/backoffice_mainmenu_header');
//$this->load->view('backoffice_templates/backoffice_category_menubar');
$this->load->view('backoffice_templates/backoffice_menubar');

categoryjs();
jqxangularjs();
jqxthemes();
?>

<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/jqwidgets/styles/jqx.summer.css" type="text/css" />
<script type="text/javascript">
    var SiteRoot ="<?php echo base_url() ?>";
    $("#tabtitle").text("Menu");
</script>
<script type="text/javascript" src="<?= base_url()?>assets/js/jqwidgets/jqxdragdrop.js"></script>
<script type="application/javascript" src="../../assets/js/angular/jqwidgets/jqxradiobutton.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jqwidgets/jqxgrid.sort.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jqwidgets/jqxgrid.filter.js"></script>
<script type="application/javascript" src="../../assets/admin/menu/menu_categories_controller.js"></script>
<script type="application/javascript" src="../../assets/admin/menu/menu_items_controller.js"></script>
<script type="application/javascript" src="../../assets/admin/menu/menu_inventory_controller.js"></script>
<script type="application/javascript" src="../../assets/admin/menu/menu_questions_controller.js"></script>
<script type="application/javascript" src="../../assets/admin/menu/menu_printers_controller.js"></script>
<script type="application/javascript" src="../../assets/admin/menu/menu_items_directives.js"></script>
<link rel="stylesheet" href="../../assets/admin/styles.css">
<div class="parent-container" ng-controller="menuCategoriesController">
    <div ng-cloak class=" ng-cloak">
        <div class="container-fluid">

            <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-default" role="navigation" style="background:#CCC;">
                    <div id="toolbar" class="toolbar-list">
                        <ul class="nav navbar-nav navbar-left" style="color: #000;">
                            <li>
                                <a href="<?php echo base_url("backoffice/dashboard")?>" style="outline:0;">
                                    <span class="icon-32-home"></span>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url("dashboard/admin")?>" style="outline:0;">
                                    <span class="icon-32-back"></span>
                                    Back
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                <jqx-tabs  jqx-width="" jqx-height="" id="MenuCategoriesTabs">
                    <ul>
                        <li>Menu</li> <?//2?>
                        <li>Items</li> <?//2 INVENTORY?>
                        <li>Questions</li><?//3?>
                        <li>Printers</li><? //4 ?>
                        <li>Categories</li><? //1 ?>
                        <li>Menu</li><?//0?>
                    </ul>
                    <!-- -------------- -->
                    <!-- MENU ITEMS TAB      -->
                    <!-- -------------- -->
                    <div class="" ng-controller="menuItemController">
                        <?php $this->load->view($items_tab_view); ?>
                    </div>
                    <!-- ------------------------- -->
                    <!-- NEW ITEMS TAB (INVENTORY) -->
                    <!-- ------------------------- -->
                    <div class="" ng-controller="menuItemsInventoryController">
                        <?php $this->load->view($inventory_tab_view); ?>
                    </div>
                    <!-- -------------- -->
                    <!-- QUESTIONS TAB  -->
                    <!-- -------------- -->
                    <div class="" ng-controller="menuQuestionController">
                        <?php $this->load->view($questions_tab_view); ?>
                    </div>
                    <!-- -------------- -->
                    <!-- PRINTERS TAB  -->
                    <!-- -------------- -->
                    <div class="" ng-controller="menuPrintersController">
                        <?php $this->load->view($printers_tab_view); ?>
                    </div>
                    <!-- -------------- -->
                    <!-- CATEGORIES TAB -->
                    <!-- -------------- -->
                    <div>
                        <?php $this->load->view($category_tab_view); ?>
                    </div>
                    <!-- -------------- -->
                    <!-- MENU TAB       -->
                    <!-- -------------- -->
                    <div>
                        <?php $this->load->view($menu_tab_view); ?>
                    </div>
                </jqx-tabs>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="userid" ng-model="userid" />
</div>

<?php $this->load->view('backoffice_includes/backoffice_mainmenu_footer'); ?>