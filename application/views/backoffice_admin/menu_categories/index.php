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
<!--    <input type="hidden" value="--><?php //echo $decimalsPrice;?><!--" id="mitButtonPrimaryColor"/>-->
    <input type="hidden" value="<?php echo $decimalsQuantity;?>" id="decimalsQuantity "/>
    <!-- Styles Default Settings  -->
    <input type="hidden" value="<?php echo $qButtonPrimaryColor;?>" id="qButtonPrimaryColorDef"/>
    <input type="hidden" value="<?php echo $qButtonSecondaryColor;?>" id="qButtonSecondaryColorDef"/>
    <input type="hidden" value="<?php echo $qLabelFontColor;?>" id="qLabelFontColorDef"/>
    <input type="hidden" value="<?php echo $qLabelFont;?>" id="qLabelFontSizeDef"/>

    <input type="hidden" value="<?php echo $qitButtonPrimaryColor;?>" id="qitButtonPrimaryColorDef"/>
    <input type="hidden" value="<?php echo $qitButtonSecondaryColor;?>" id="qitButtonSecondaryColorDef"/>
    <input type="hidden" value="<?php echo $qitLabelFontColor;?>" id="qitLabelFontColorDef"/>
    <input type="hidden" value="<?php echo $qitLabelFontSize;?>" id="qitLabelFontSizeDef"/>

    <input type="hidden" value="<?php echo $catButtonPrimaryColor;?>" id="catButtonPrimaryColorDef"/>
    <input type="hidden" value="<?php echo $catButtonSecondaryColor;?>" id="catButtonSecondaryColorDef"/>
    <input type="hidden" value="<?php echo $catLabelSizeColor;?>" id="catLabelSizeColorDef"/>
    <input type="hidden" value="<?php echo $catLabelFontSize;?>" id="catLabelFontSizeDef"/>

    <input type="hidden" value="<?php echo $mitButtonPrimaryColor;?>" id="mitButtonPrimaryColorDef"/>
    <input type="hidden" value="<?php echo $mitButtonSecondaryColor;?>" id="mitButtonSecondaryColorDef"/>
    <input type="hidden" value="<?php echo $mitLabelSizeColor;?>" id="mitLabelSizeColorDef"/>
    <input type="hidden" value="<?php echo $mitLabelFontSize;?>" id="mitLabelFontSizeDef"/>

</div>