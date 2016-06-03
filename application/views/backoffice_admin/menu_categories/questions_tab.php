<div>
    <div>
        <a style="outline:0;margin: 10px 2px;" class="btn btn-info" ng-click="">
            <span class="icon-32-new"></span>
            New
        </a>
    </div>
    <jqx-data-table jqx-settings="questionTableSettings"
                    jqx-on-row-double-click="">
    </jqx-data-table>

    <jqx-window jqx-on-close="close()" jqx-settings=""
                jqx-create="" class="">
        <div>
            Add new menu
        </div>
        <div>
            <div class="col-md-12 col-md-offset-0" id="menuWindowContent">
                <div class="row menuFormContainer">
                    <div style=" width:330px;float:left;">
                        <div style="float:left; padding:2px; width:350px;">
                            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Menu Name:</div>
                            <div style="float:left; width:180px;">
                                <input type="text" class="form-control required-field" id="add_MenuName" name="add_MenuName" placeholder="Menu Name" autofocus>
                            </div>
                            <div style="float:left;">
                                <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                            </div>
                        </div>

                        <div style="float:left; padding:2px; width:350px;">
                            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Status:</div>
                            <div style="float:left; width:180px;">
                                <select name="add_Status" id="add_Status">
                                    <option value="1">Enabled</option>
                                    <option value="2">Disabled</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-md-offset-0">
                <div class="row">
                    <div id="">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="button" id="saveMenuBtn" ng-click="SaveMenuWindows()" class="btn btn-primary" disabled>Save</button>
                                <button	type="button" id="" ng-click="CloseMenuWindows()" class="btn btn-warning">Close</button>
                                <button	type="button" id="deleteMenuBtn" ng-click="beforeDeleteMenu()" class="btn btn-danger " style="display:none; overflow:auto;">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ALERT MESSAGES BEFORE ACTIONS -->
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
        </div>
    </jqx-window>
</div>