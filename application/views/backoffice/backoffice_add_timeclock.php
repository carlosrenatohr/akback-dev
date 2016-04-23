<jqx-window jqx-on-close="close()" id="add_timeclock_form" jqx-create="dialogAddTimeClockSettings" jqx-settings="dialogAddTimeClockSettings">
    <div>Add Dialog</div>
    <div style="overflow: hidden;">
        <div class="container">
            <div id="add_timeclock">
                <div style="width: 100%;">
                    <div class="col-sm-8" style="padding:0px;">
                        <input type="hidden" ng-model="adduser.unique" />
                        <input type="hidden" ng-model="adduser.name" />
                        <legend style="float:left; padding: 5px;"><div id="username_label" style="float:left; font-size:14px; font-weight:bold;">User: </div><jqx-combo-box id="username" ng-model="add_user.name" jqx-on-select="selectHandler(event)" jqx-settings="AddUserDropDown"></jqx-combo-box>
                        <span style="color:#F00">*</span>
                        </legend>
                        <div class="row">
                            <div style="width:450px;float:left;">
                                <div style="float:left; padding:2px; width:350px;">
                                    <div style="float:left; padding:8px; text-align:right; width:120px; font-weight:bold;">In Date:</div>
                                    <div style="float:left; width:160px;">
                                        <jqx-date-time-input id="add_in_date" ng-model="add_date.in" jqx-settings="FromdateInputSettings" jqx-format-string="datefromstring" ng-change="add_date_in()"></jqx-date-time-input>
                                    </div>
                                    <span style="color:#F00" id="add_in_date_clear"></span>
                                </div>
                                
                                <div style="float:left; padding:2px; width:350px;">
                                    <div style="float:left; padding:8px; text-align:right; width:120px; font-weight:bold;">Time In:</div>
                                    <div style="float:left; width:160px;">
                                        <jqx-date-time-input id="add_time_in" ng-model="add_time.in" jqx-settings="TimeInSettings" jqx-format-string="'t'" jqx-show-time-button="true" jqx-show-calendar-button="false" ng-change="add_time_in()"></jqx-date-time-input>
                                    </div>
                                    <span style="color:#F00" id="add_time_in_clear"></span>
                                </div>
                                
                                <div style="float:left; padding:2px; width:350px;">
                                    <div style="float:left; padding:8px; text-align:right; width:120px; font-weight:bold;">Location In:</div>
                                    <div style="float:left; width:160px;">
                                        <jqx-combo-box id="add_location_in" ng-model="add_location.in" jqx-settings="AddLocationInDropDown" ng-change="add_location_in()"></jqx-combo-box>
                                    </div>
                                    <span style="color:#F00" id="add_location_in_clear"></span>
                                </div>
                                
                                <div style="float:left; padding:2px; width:350px;">
                                    <div style="float:left; padding:8px; text-align:right; width:120px; font-weight:bold;">Date Out:</div>
                                    <div style="float:left; width:160px;">
                                        <jqx-date-time-input id="add_out_date" ng-model="add_date.out" jqx-settings="FromdateInputSettings" jqx-format-string="datefromstring" ng-change="add_date_out()"></jqx-date-time-input>
                                    </div>
                                    <span style="color:#F00" id="add_date_out_clear"></span>
                                </div>
                                
                                <div style="float:left; padding:2px; width:350px;">
                                    <div style="float:left; padding:8px; text-align:right; width:120px; font-weight:bold;">Time Out:</div>
                                    <div style="float:left; width:160px;">
                                        <jqx-date-time-input id="add_time_out" ng-model="add_time.out" jqx-settings="TimeOutSettings" jqx-format-string="'t'" jqx-show-time-button="true"  jqx-show-calendar-button="false"></jqx-date-time-input>
                                    </div>
                                    <span style="color:#F00" id="add_time_out_clear"></span>
                                </div>
                                
                                <div style="float:left; padding:2px; width:350px;">
                                    <div style="float:left; padding:8px; text-align:right; width:120px; font-weight:bold;">Location Out:</div>
                                    <div style="float:left; width:160px;">
                                        <jqx-combo-box id="add_location_out" ng-model="add_location.out" jqx-settings="AddLocationOutDropDown"></jqx-combo-box>
                                    </div>
                                    <span style="color:#F00" id="add_location_out_clear"></span>
                                </div>
                                
                             </div>
                        </div>        
                    </div>
                </div>
                <div  style="padding:0px; margin-top:10px; width:450px;float:left;">
                    <div ng-show="add_Primary">
                        <button class="btn btn-primary btn-lg" id="add_save_timeclock" ng-click="AddTimeClock()" ng-disabled="AddSaveDisableWhen" title="Save">Save</button>
                        <button class="btn btn-warning btn-lg" ng-click="AddCancel()" title="Close">Close</button>
                    </div>
                    
                    <div ng-show="add_Secondary">
                        <div>{{add_time_clock.msg}}</div>
                        <button class="btn btn-primary btn-lg" id="add_ask_save_timeclock" ng-click="AddTimeClock()" title="Save">Yes</button>
                        <button class="btn btn-warning btn-lg" ng-click="AddAskCancel()" title="Close">No</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="add_jqxNotification">
            <div id="add_notificationContent"></div>
        </div>
        <div id="add_save_jqxNotification">
            <div id="add_save_notificationContent"></div>
        </div>
        <div id="add_container" style="width: 350px; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;">
        </div>
    </div>
</jqx-window>
<style type="text/css">
    body{
        padding;0;
        margin:0;
    }
    #add_timeclock_form{
        -webkit-border-radius: 15px 15px 15px 15px;
        border-radius: 15px 15px 15px 15px;
        border: 5px solid #449bca;
    }

    #username_label{
        float:left;
        margin-right: 10px;
    }

    #username {
        float:left;
    }
</style>