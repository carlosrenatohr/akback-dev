<!-- Main buttons before saving item on grid -->
<div class="col-md-12 col-md-offset-0">
    <div class="row">
        <div id="mainButtonsOnItemGrid">
            <div class="form-group">
                <div class="col-sm-12">
                                <span class="btn btn-success" id="uploadPictureBtn" flow-btn style="display: none;">
                                    Upload Picture
                                </span>
                    <button type="button" id="saveItemGridBtn" ng-click="saveItemGridBtn()" class="btn btn-primary" disabled>Save</button>
                    <button	type="button" id="" ng-click="closeItemGridWindows()" class="btn btn-warning">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Prompt before saving item on grid -->
<div class="col-md-12 col-md-offset-0">
    <div class="row">
        <div id="promptToCloseItemGrid" class="RowOptionButtonsOnItemGrid" style="display: none">
            <div class="form-group">
                <div class="col-sm-12">
                    Do you want to save your changes?
                    <button type="button" ng-click="closeItemGridWindows(0)" class="btn btn-primary">Yes</button>
                    <button type="button" ng-click="closeItemGridWindows(1)" class="btn btn-warning">No</button>
                    <button type="button" ng-click="closeItemGridWindows(2)" class="btn btn-info">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Prompt before delete an item on grid -->
<div class="col-md-12 col-md-offset-0">
    <div class="row">
        <div id="promptToDeleteItemGrid" class="RowOptionButtonsOnItemGrid" style="display: none">
            <div class="form-group">
                <div class="col-sm-12">
                    Do you really want to delete it?
                    <button type="button" ng-click="deleteItemGridBtn(0)" class="btn btn-primary">Yes</button>
                    <button type="button" ng-click="deleteItemGridBtn(1)" class="btn btn-warning">No</button>
                    <button type="button" ng-click="deleteItemGridBtn(2)" class="btn btn-info">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<jqx-window id="notification-window"
            jqx-is-modal="true" jqx-width="300" jqx-height="150"
            jqx-auto-open="false" jqx-show-close-button="true"
            jqx-resizable="false"
>
    <div class="header">Notification</div>
    <div class="body">
        <div class="text-content" style="font-size: center;font-size: 15px;margin-bottom: 15px;"></div>
        <div class="button-content">
            <div style="float: right; margin-top: 15px;">
                <jqx-button id="ok" jqx-width="65"
                            style="margin-right: 10px"
                >OK
                </jqx-button>
            </div>
        </div>
    </div>
</jqx-window>
<!-- NOTIFICATIONS AREA -->
<div class="col-md-12 col-md-offset-0">
    <div class="row">
        <jqx-notification jqx-settings="menuitemNotificationsSuccessSettings" id="menuitemNotificationsSuccessSettings">
            <div id="notification-content"></div>
        </jqx-notification>
        <jqx-notification jqx-settings="menuitemNotificationsErrorSettings" id="menuitemNotificationsErrorSettings">
            <div id="notification-content"></div>
        </jqx-notification>
        <div id="notification_container_menuitem" style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
    </div>
</div>