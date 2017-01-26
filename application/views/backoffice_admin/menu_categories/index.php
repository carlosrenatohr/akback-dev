<script type="text/javascript">
    $("#tabtitle").text("Menu");
</script>
<script type="application/javascript" src="<?= base_url()?>assets/admin/menu/config.js"></script>
<script type="application/javascript" src="<?= base_url()?>assets/admin/menu/admin_service.js"></script>
<script type="application/javascript" src="<?= base_url()?>assets/admin/menu/menu_categories_controller.js"></script>
<script type="application/javascript" src="<?= base_url()?>assets/admin/menu/menu_items_controller.js"></script>
<script type="application/javascript" src="<?= base_url()?>assets/admin/menu/menu_inventory_controller.js"></script>
<script type="application/javascript" src="<?= base_url()?>assets/admin/menu/menu_inventory_service.js"></script>
<!--<script type="application/javascript" src="--><?//= base_url()?><!--assets/admin/menu/menu_inventory_directive.js"></script>-->
<script type="application/javascript" src="<?= base_url()?>assets/admin/menu/menu_inventory_relations_service.js"></script>
<script type="application/javascript" src="<?= base_url()?>assets/admin/menu/menu_questions_service.js"></script>
<script type="application/javascript" src="<?= base_url()?>assets/admin/menu/menu_questions_controller.js"></script>
<script type="application/javascript" src="<?= base_url()?>assets/admin/menu/menu_printers_controller.js"></script>
<script type="application/javascript" src="<?= base_url()?>assets/admin/menu/menu_items_directives.js"></script>
<!-- ng-flow libraries -->
<script src="<?= base_url()?>assets/admin/ng-flow-standalone.min.js"></script>
<script src="<?= base_url()?>assets/admin/fusty-flow.js"></script>
<script src="<?= base_url()?>assets/admin/fusty-flow-factory.js"></script>

<div class="parent-container" ng-controller="menuCategoriesController">
    <div ng-cloak class=" ng-cloak">
        <div class="container-fluid" style="padding: 0;">

            <div class="row">
                <div class="col-md-12">
                <jqx-tabs  jqx-width="" jqx-height="" id="MenuCategoriesTabs"
                            jqx-selected-item="1">
                    <ul>
                        <li>
                            <img src="<?php echo base_url() ?>assets/img/home_icon.png" alt="Dashboard">
                            Dashboard
                        </li>
<!--                        <li>-->
<!--                            <img src="--><?php //echo base_url() ?><!--assets/img/back.png" alt="Back">-->
<!--                            Back-->
<!--                        </li>-->
                        <li>Layout</li> <?//2 Items orig?>
<!--                        <li>Items</li> --><?////2 INVENTORY?>
                        <li>Questions</li><?//3?>
                        <li>Printers</li><? //4 ?>
                        <li>Categories</li><? //1 ?>
                        <li>Menu</li><?//0?>
                    </ul>
                    <div></div>
                    <!-- -------------- -->
                    <!-- MENU ITEMS TAB      -->
                    <!-- -------------- -->
                    <div class="" ng-controller="menuItemController">
                        <?php $this->load->view($items_tab_view); ?>
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
    <input type="hidden" value="<?php echo $decimalsPrice;?>" id="mitButtonPrimaryColor"/>
    <input type="hidden" value="<?php echo $decimalsQuantity;?>" id="decimalsQuantity "/> 
    <input type="hidden" value="<?php echo $qitLabelFontSize;?>" id="qitLabelFontSize"/>
    <input type="hidden" value="<?php echo $qitLabelFontColor;?>" id="qitLabelFontColor" />
    <input type="hidden" value="<?php echo $qitButtonSecondaryColor;?>" id="qitButtonSecondaryColor"/>
    <input type="hidden" value="<?php echo $qitButtonPrimaryColor;?>" id="qitButtonPrimaryColor"/> 
    <input type="hidden" value="<?php echo $qLabelFont;?>" id="qLabelFont"/> 
    <input type="hidden" value="<?php echo $qLabelFontColor;?>" id="qLabelFontColor"/>
    <input type="hidden" value="<?php echo $qButtonSecondaryColor;?>" id="qButtonSecondaryColor"/> 
    <input type="hidden" value="<?php echo $qButtonPrimaryColor;?>" id="qButtonPrimaryColor"/>
    <input type="hidden" value="<?php echo $catLabelFontSize;?>" id="catLabelFontSize"/>
    <input type="hidden" value="<?php echo $catLabelSizeColor;?>" id="catLabelSizeColor"/>
    <input type="hidden" value="<?php echo $catButtonSecondaryColor;?>" id="catButtonSecondaryColor"/>
    <input type="hidden" value="<?php echo $catButtonPrimaryColor;?>" id="catButtonPrimaryColor"/> 
    <input type="hidden" value="<?php echo $mitLabelFontSizer;?>" id="mitLabelFontSizer"/> 
    <input type="hidden" value="<?php echo $mitLabelSizeColor;?>" id="mitLabelSizeColor"/> 
    <input type="hidden" value="<?php echo $mitButtonSecondaryColor;?>" id="mitButtonSecondaryColor"/>
    <input type="hidden" value="<?php echo $mitButtonPrimaryColor;?>" id="mitButtonPrimaryColor"/>
    
</div>