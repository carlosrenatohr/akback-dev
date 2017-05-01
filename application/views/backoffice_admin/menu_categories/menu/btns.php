<div class="col-md-12 col-md-offset-0">
    <div class="row">
        <div id="mainButtonsForMenus">
            <div class="form-group">
                <div class="col-sm-12">
                    <button type="button" id="saveMenuBtn" ng-click="SaveMenuWindows()" class="btn btn-primary" disabled>Save</button>
                    <button	type="button" id="" ng-click="CloseMenuWindows()" class="btn btn-warning">Close</button>
                    <!--<button	type="button" id="deleteMenuBtn" ng-click="beforeDeleteMenu()" class="btn btn-danger " style="display:none; overflow:auto;">Delete</button>-->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ALERT MESSAGES BEFORE ACTIONS -->
<style>
    .alertButtonsMenuCategories {
        display:none;
    }
</style>
<div class="col-md-12 col-md-offset-0">
    <div class="row">
        <div id="beforeDeleteMenu" class="alertButtonsMenuCategories">
            <div class="form-group">
                <div class="col-sm-12">
                    Are you sure you want to delete it?
                    <button type="button" ng-click="beforeDeleteMenu(0)" class="btn btn-primary">Yes</button>
                    <button type="button" ng-click="beforeDeleteMenu(1)" class="btn btn-warning">No</button>
                    <button type="button" ng-click="beforeDeleteMenu(2)" class="btn btn-info">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-md-offset-0">
    <div class="row">
        <div id="promptToSaveInCloseButtonMenu" class="alertButtonsMenuCategories">
            <div class="form-group">
                <div class="col-sm-12">
                    Do you want to save your changes?
                    <button type="button" ng-click="CloseMenuWindows(0)" class="btn btn-primary">Yes</button>
                    <button type="button" ng-click="CloseMenuWindows(1)" class="btn btn-warning">No</button>
                    <button type="button" ng-click="CloseMenuWindows(2)" class="btn btn-info">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- NOTIFICATIONS AREA -->
<div class="col-md-12 col-md-offset-0">
    <div class="row">
        <jqx-notification jqx-settings="menuNotificationsSuccessSettings" id="menuNotificationsSuccessSettings">
            <div id="notification-content"></div>
        </jqx-notification>
        <jqx-notification jqx-settings="menuNotificationsErrorSettings" id="menuNotificationsErrorSettings">
            <div id="notification-content"></div>
        </jqx-notification>
        <div id="notification_container" style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
    </div>
</div>