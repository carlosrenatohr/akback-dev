<div class="gridContentTab">
    <a style="outline:0;margin: 10px 2px;" class="btn btn-info" ng-click="newCategoryAction()">
        <span class="icon-new"></span>
        New
    </a>
    <jqx-grid id="categoriesDataTable" style="display: none;"
                    jqx-settings="categoriesTableSettings"
                    jqx-on-rowdoubleclick="updateCategoryAction(e)">
    </jqx-grid>
    <!-- Category window -->
    <jqx-window jqx-on-close="close()" jqx-settings="addCategoryWindowSettings"
                jqx-create="addCategoryWindowSettings" class="">
        <!--  Window's Title -->
        <div>
            Add new Category
        </div>
        <!--  Window's body -->
        <div >
            <jqx-tabs id="category_subtabs">
                <ul>
                    <li id="cat_subtab">Category</li>
                    <li id="picture_subtab">Picture</li>
                    <li id="sty_subtab">Style</li>
                </ul>
                <div class="col-md-12 col-md-offset-0">
                    <?php $this->load->view($cat_data_subview); ?>
                </div>
                <div>
                    <?php $this->load->view($cat_picture_subview); ?>
                </div>
                <div>
                    <?php $this->load->view($cat_style_subview); ?>
                </div>
            </jqx-tabs>

            <div class="col-md-12 col-md-offset-0">
                <div class="row">
                    <div id="mainButtonsForCategories">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="button" id="saveCategoryBtn" ng-click="SaveCategoryWindows()" class="btn btn-primary" disabled>Save</button>
                                <button	type="button" id="" ng-click="CloseCategoryWindows()" class="btn btn-warning">Close</button>
<!--                                <span class="btn btn-success" id="categoryPictureBtn" flow-btn style="display: none;">Upload Picture</span>-->
                                <button	type="button" id="deleteCategoryBtn" ng-click="beforeDeleteCategory()" class="btn btn-danger " style="display:none; overflow:auto;">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ALERT MESSAGES BEFORE ACTIONS -->
            <div class="col-md-12 col-md-offset-0">
                <div class="row">
                    <div id="beforeDeleteCategory" class="alertButtonsMenuCategories">
                        <div class="form-group">
                            <div class="col-sm-12">
                                Are you sure you want to delete it?
                                <button type="button" ng-click="beforeDeleteCategory(0)" class="btn btn-primary">Yes</button>
                                <button type="button" ng-click="beforeDeleteCategory(1)" class="btn btn-warning">No</button>
                                <button type="button" ng-click="beforeDeleteCategory(2)" class="btn btn-info">Cancel</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-12 col-md-offset-0">
                <div class="row">
                    <div id="promptToSaveInCloseButtonCategory" class="alertButtonsMenuCategories">
                        <div class="form-group">
                            <div class="col-sm-12">
                                Do you want to save your changes?
                                <button type="button" ng-click="CloseCategoryWindows(0)" class="btn btn-primary">Yes</button>
                                <button type="button" ng-click="CloseCategoryWindows(1)" class="btn btn-warning">No</button>
                                <button type="button" ng-click="CloseCategoryWindows(2)" class="btn btn-info">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- NOTIFICATIONS AREA -->
            <div class="col-md-12 col-md-offset-0">
                <div class="row">
                    <jqx-notification jqx-settings="categoryNotificationsSuccessSettings" id="categoryNotificationsSuccessSettings">
                        <div id="notification-content"></div>
                    </jqx-notification>
                    <jqx-notification jqx-settings="categoryNotificationsErrorSettings" id="categoryNotificationsErrorSettings">
                        <div id="notification-content"></div>
                    </jqx-notification>
                    <div id="notification_container_category" style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
                </div>
            </div>
        </div>
    </jqx-window>
</div>