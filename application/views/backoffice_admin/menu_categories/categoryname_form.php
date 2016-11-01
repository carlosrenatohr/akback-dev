<!--  Window to change category Name -->
<jqx-window jqx-on-close="close()" jqx-settings="itemsMenuChangeCategNameWind"
            jqx-create="itemsMenuChangeCategNameWind" class="">
    <div class="">
        Edit Category Name
    </div>
    <div class="">
        <div class="row">
            <div style="float:left; padding:2px; width:650px;">
                <div style="float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">Item:</div>
                <div style="float:left; width:300px;">
                    <input type="text" class="form-control"
                           id="OneCategoryName" placeholder="Category Name" />
                    <input type="hidden" id="OneCategoryId"  />
                </div>
            </div>
        </div>
        <!-- Main buttons before saving item on grid -->
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <div id="mainOneCategoryBtns">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="button" id="saveItemOneCategoryBtn" ng-click="saveOneCategory()" class="btn btn-primary" disabled>Save</button>
                            <button	type="button" id="" ng-click="closeOneCategory()" class="btn btn-warning">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prompt before saving item on grid -->
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <div id="closeOneCategoryBtns" style="display: none">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <p>Do you want to save your changes?</p>
                            <button type="button" ng-click="closeOneCategory(0)" class="btn btn-primary">Yes</button>
                            <button type="button" ng-click="closeOneCategory(1)" class="btn btn-warning">No</button>
                            <button type="button" ng-click="closeOneCategory(2)" class="btn btn-info">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</jqx-window>