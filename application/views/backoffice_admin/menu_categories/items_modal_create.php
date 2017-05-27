<!--  Windows to save items   -->
<jqx-window jqx-on-close="close()" jqx-settings="itemsModalCreate"
            jqx-create="itemsModalCreate" class="">
    <div>
        Create Item
    </div>
    <div>
        <jqx-tabs jqx-width="'100%'"
                  id="itemsModalCreateTabs">
            <ul>
                <li>Item</li>
                <li>Tax</li>
                <li id="pricestabItemModal">Prices</li>
                <li id="costtabItemModal">Cost</li>
                <li id="optionstabItemModal">Options</li>
            </ul>
            <!-- Menu Item subtab -->
            <div class="">
                <?php $this->load->view('backoffice_admin/menu_categories/items_modal_createitem_itemtab');?>
            </div>
            <!-- Taxes Item subtab -->
            <div class="">
                <?php $this->load->view('backoffice_admin/menu_categories/items_modal_createitem_taxtab');?>
            </div>
            <!-- Prices Item subtab -->
            <div >
                <?php $this->load->view('backoffice_admin/menu_categories/items_modal_createitem_pricetab');?>
            </div>
            <!-- Cost Item subtab -->
            <div >
                <?php $this->load->view('backoffice_admin/menu_categories/items_modal_createitem_costtab');?>
            </div>
            <!-- Options Item subtab -->
            <div >
                <?php $this->load->view('backoffice_admin/menu_categories/items_modal_createitem_optionstab');?>
            </div>
        </jqx-tabs>

        <!-- Main buttons before saving item on grid -->
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <div id="mainButtonsOnItemCreateModal">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="button" id="saveItemMBtn" ng-click="saveItemOnMenuItemGrid()" class="btn btn-primary" disabled>Save</button>
                            <button	type="button" id="" ng-click="closeMenuGridItemCreate()" class="btn btn-warning">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prompt before saving item on grid -->
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <div id="promptToCloseItemCreateModal" class="" style="display: none">
                    <div class="form-group">
                        <div class="col-sm-12">
                            Do you want to save your changes?
                            <button type="button" ng-click="closeMenuGridItemCreate(0)" class="btn btn-primary">Yes</button>
                            <button type="button" ng-click="closeMenuGridItemCreate(1)" class="btn btn-warning">No</button>
                            <button type="button" ng-click="closeMenuGridItemCreate(2)" class="btn btn-info">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- NOTIFICATIONS AREA -->
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <jqx-notification jqx-settings="nitemSuccess" id="nitemSuccess">
                    <div id="notification-content"></div>
                </jqx-notification>
                <jqx-notification jqx-settings="nitemError" id="nitemError">
                    <div id="notification-content"></div>
                </jqx-notification>
                <div id="nitemNotification" style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
            </div>
        </div>
    </div>
</jqx-window>