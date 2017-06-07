<div id="MenuItemLayoutContent"
        style="/*width: 1200px!important;height:768px;overflow-x: scroll;*/">
    <!--|| Left Tab | Menu and items picker ||-->
    <div id="leftTabMenuItem" style="width: 30%;float: left;overflow-x: scroll;">
<!--        <div class="col-lg-2 col-lg-2-item col-md-2 col-md-2-item col-sm-2"-->
        <div id="itemselect-container" style="min-width: 1000px;/*width: 30%!important;overflow-x: scroll;*/">
            <div style="margin: 20px 0;">
                <div class="">
                    <jqx-drop-down-list
                            id="menuListDropdown"
                            jqx-settings="menudropdownSettings"
                            jqx-on-change="menuListBoxSelecting(event)"
                    >
                    </jqx-drop-down-list>
                </div>
                <div id="selectedItemInfo" class="selectedItemInfoClass">
                    {{ selectedItemInfo.Description }}
                </div>
                <div class="col-md-12" style="padding: 0;margin: 1px 0;">
                    <div class="col-md-9" style="padding: 0 2px;">
                        <input type="text" id="ListBoxSearchInput" class="form-control" placeholder="Search.."
                               style="padding: 0 5px;height: 24px;" autofocus>
                    </div>
                    <button class="btn btn-info col-md-1" id="ListBoxSearchBtn" type="button"
                            style="height: 24px;padding: 0 5px;margin: 0 5px;">
                        <img width="16" height="16" src="<?php echo base_url('assets/js/angular/images/search.png')?>" alt="">
                    </button>
                    <button class="btn btn-info col-md-1" id="CreateItemBtn" type="button"
                            style="height: 24px;padding: 0 5px;margin: 0 5px;">
                        <img width="16" height="16" src="<?php echo base_url('assets/img/addnew.png')?>" alt="">
                    </button>
                </div>
                <div>
                    <img id="loadingMenuItem" src="<?php echo base_url()?>assets/img/loadinfo.gif" alt=""
                         style="position: absolute;width: 20%;left: 35%;display: none;">
                    <jqx-list-box
                            jqx-on-select="itemListBoxOnSelect(event)"
                            jqx-settings="itemsListboxSettings"
                            id="itemListboxSearch">
                    </jqx-list-box>
                </div>
            </div>
        </div>
    </div>
    <!--|| Right Tab | Menu Item Grid  ||-->
    <div id="rightTabMenuItem" style="width: 70%;float: right;/*overflow-x: scroll;*/">
        <!--<div class="col-lg-10 col-lg-10-item col-md-10 col-md-10-item col-sm-10 maingrid-container"-->
        <div class="maingrid-container"
             style="padding: 0;/*width: 70%!important;overflow-x: scroll;*/">
            <!--|| ITEMS GRID ||-->
            <div id="mainGridMenuItem" style="overflow-y: scroll;overflow-x: scroll;">
            <!-- <div class="col-md-12 col-sm-12 restricter-dragdrop">-->
                <div class="restricter-dragdrop" style="height: 320px;"></div>
            </div>
            <!-- || CATEGORIES GRID ||-->
            <div id="categories-parent-container" style="padding-right: 0!important;padding-left: 0!important;">
<!--            <div class="col-md-12 col-sm-12" style="padding-right: 0!important;padding-left: 0!important;">-->
                <!--  <h4 class="">Category grid</h4>-->
                <div id="categories-container">
                    <category-cell-grid category-title="{{uno.CategoryName}}" id="categories-grid">
                    </category-cell-grid>
                </div>
            </div>
            <!-- || FORM to Edit Categories ||-->
            <?php $this->load->view($categoryName_form); ?>
        </div>
    </div>
    <!--   ----------------------------   -->
    <!--  Windows to save data on items   -->
    <!--   ----------------------------   -->
    <jqx-window jqx-on-close="close()" jqx-settings="itemsMenuWindowsSetting"
                jqx-create="itemsMenuWindowsSetting" id="itemsMenuMainWindow">
        <div>
            Edit Item
        </div>
        <div flow-init flow-name="uploader.flow"
             flow-files-submitted="submitUpload($files, $event, $flow)"
             flow-file-added="fileAddedUpload($file, $event, $flow)"
             flow-file-success="successUpload($file, $message, $flow)"
             flow-file-error="errorUpload($file, $message, $flow)">

            <jqx-tabs jqx-width="'100%'"
                      id="jqxTabsMenuItemWindows">
                <ul>
                    <li>Menu Item</li>
                    <li id="">Prices</li>
                    <li id="questionsTabOnMenuItemWindow">Questions</li>
                    <li>Printers</li>
                    <li>Options</li>
                    <li>Cost</li>
                    <li>Tax</li>
<!--                    <li>Layout</li>-->
                    <li>Picture</li>
                    <li>Style</li>
                </ul>
                <!-- Menu Item subtab -->
                <div class="">
                    <?php $this->load->view($items_menuitem_subtab_view);?>
                </div>
                <!-- Prices subtab -->
                <div class="">
                    <?php $this->load->view($items_price_subtab_view);?>
                </div>
                <!-- Question subtab -->
                <div class="">
                    <?php $this->load->view($items_questions_subtab_view);?>
                </div>
                <!-- Printer subtab -->
                <div class="">
                    <?php $this->load->view($items_printers_subtab_view);?>
                </div>
                <!-- Extra subtab -->
                <div class="">
                    <?php $this->load->view($items_extra_subtab_view);?>
                </div>
                <!-- Cost subtab -->
                <div class="">
                    <?php $this->load->view($items_cost_subtab_view);?>
                </div>
                <!-- Tax subtab -->
                <div class="">
                    <?php $this->load->view($items_tax_subtab_view);?>
                </div>
                <!-- Layout subtab -->
<!--                <div class="">-->
<!--                    --><?php //$this->load->view($items_layout_subtab_view);?>
<!--                </div>-->
                <!-- Pictue subtab -->
                <div class="">
                    <?php $this->load->view($items_picture_subtab_view);?>
                </div>
                <!-- Pictue subtab -->
                <div class="">
                    <?php $this->load->view($items_style_subtab_view);?>
                </div>
            </jqx-tabs>
            <?php $this->load->view($items_tab_btns);?>
        </div>
    </jqx-window>
    <?php $this->load->view('backoffice_admin/menu_categories/items_modal_create');?>
</div>
<style>
    #itemsMenuMainWindow {
        max-width: 90%!important;
        max-height: 90%!important;
    }
</style>