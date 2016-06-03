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

<script type="application/javascript" src="../../assets/admin/menu/menu_categories_controller.js"></script>
<script type="application/javascript" src="../../assets/admin/menu/menu_items_controller.js"></script>
<script type="application/javascript" src="../../assets/admin/menu/menu_questions_controller.js"></script>
<script type="application/javascript" src="../../assets/admin/menu/menu_items_directives.js"></script>
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
                        <li>Questions</li>
                    </ul>
                    <!-- -------------- -->
                    <!-- MENU TAB       -->
                    <!-- -------------- -->
                    <div>
                        <?php $this->load->view($menu_tab_view); ?>
                    </div>
                    <!-- -------------- -->
                    <!-- CATEGORIES TAB -->
                    <!-- -------------- -->
                    <div>
                        <?php $this->load->view($category_tab_view); ?>
                    </div>
                    <!-- -------------- -->
                    <!-- ITEMS TAB      -->
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
        max-height: 450px;
        min-height: 450px;
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
        min-height: 300px;
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
        background-color: #f0f0f0;
        color: #fff;
        border: black 1px solid;
        text-align: center;
        padding-top: 40px;
    }
    .category-cell-grid.valued {
        background-color: #bc0530;
    }
    .category-cell-grid.clicked {
        background-color: #ee063d;
        border: black 2px solid;
        box-shadow: 3px 3px 2px #888888;
    }

</style>

<?php $this->load->view('backoffice_includes/backoffice_mainmenu_footer'); ?>