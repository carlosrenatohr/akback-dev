<jqx-window jqx-on-close="close()" id="edit_timeclock_form" jqx-create="dialogEditTimeClockSettings" jqx-settings="dialogEditTimeClockSettings">
    <div>Edit Dialog</div>
    <div style="overflow: hidden;">
        <div class="container">
            <div id="edit_timeclock">
                <div style="width: 100%;">
                    <div class="col-sm-8" style="padding:0px;">
                        <input type="hidden" ng-model="time_clock.unique"/>
                        <legend style="float:left; padding: 5px;"><div style="float:left; font-size:14px; font-weight:bold;">User: </div><div style="float:left; font-size:14px; font-weight:bold; margin-left:5px;">{{user.name}}</div></legend>
                        <div class="row">
                            <div style="width:450px;float:left;">
                                <div style="float:left; padding:2px; width:350px;">
                                    <div style="float:left; padding:8px; text-align:right; width:120px; font-weight:bold;">In Date:</div>
                                    <div style="float:left; width:160px;">
                                        <jqx-date-time-input id="edit_in_date" ng-model="edit_date.in" jqx-settings="FromdateInputSettings" jqx-format-string="datefromstring" ng-change="edit_date_in()"></jqx-date-time-input>
                                    </div>
                                    <span style="color:#F00" id="edit_in_date_clear"></span>
                                </div>
                                
                                <div style="float:left; padding:2px; width:350px;">
                                    <div style="float:left; padding:8px; text-align:right; width:120px; font-weight:bold;">Time In:</div>
                                    <div style="float:left; width:160px;">
                                        <jqx-date-time-input id="edit_time_in" ng-model="edit_time.in" jqx-settings="EditTimeInSettings" jqx-format-string="'t'" jqx-show-time-button="true" jqx-show-calendar-button="false" ng-change="edit_time_in()"></jqx-date-time-input>
                                    </div>
                                    <span style="color:#F00" id="edit_time_in_clear"></span>
                                </div>
                                
                                <div style="float:left; padding:2px; width:350px;">
                                    <div style="float:left; padding:8px; text-align:right; width:120px; font-weight:bold;">Location In:</div>
                                    <div style="float:left; width:160px;">
                                        <jqx-combo-box id="edit_location_in" ng-model="edit_location.in" jqx-settings="EditLocationInDropDown" ng-change="edit_location_in()"></jqx-combo-box>
                                    </div>
                                    <span style="color:#F00" id="edit_location_in_clear"></span>
                                </div>
                                
                                <div style="float:left; padding:2px; width:350px;">
                                    <div style="float:left; padding:8px; text-align:right; width:120px; font-weight:bold;">Date Out:</div>
                                    <div style="float:left; width:160px;">
                                        <jqx-date-time-input id="edit_out_date" ng-model="edit_date.out" jqx-settings="FromdateInputSettings" jqx-format-string="datefromstring" ng-change="edit_date_out()"></jqx-date-time-input>
                                    </div>
                                    <span style="color:#F00" id="edit_date_out_clear"></span>
                                </div>
                                
                                <div style="float:left; padding:2px; width:350px;">
                                    <div style="float:left; padding:8px; text-align:right; width:120px; font-weight:bold;">Time Out:</div>
                                    <div style="float:left; width:160px;">
                                        <jqx-date-time-input id="edit_time_out" ng-model="edit_time.out" jqx-settings="EditTimeOutSettings" jqx-format-string="'t'" jqx-show-time-button="true"  jqx-show-calendar-button="false"></jqx-date-time-input>
                                    </div>
                                    <span style="color:#F00" id="edit_time_out_clear"></span>
                                </div>
                                
                                <div style="float:left; padding:2px; width:350px;">
                                    <div style="float:left; padding:8px; text-align:right; width:120px; font-weight:bold;">Location Out:</div>
                                    <div style="float:left; width:160px;">
                                        <jqx-combo-box id="edit_location_out" ng-model="edit_location.out" jqx-settings="EditLocationOutDropDown" ng-change="edit_location_out()"></jqx-combo-box>
                                    </div>
                                    <span style="color:#F00" id="edit_location_out_clear"></span>
                                </div>
                                
                             </div>
                         </div>       
                        <!--/ End /-->
                    </div>
                </div>
                <div style="padding:0px; margin-top:10px; width:450px;float:left;">
                    <div ng-show="Primary">
                        <button class="btn btn-primary btn-lg" id="edit_update" ng-click="EditUpdate()" ng-disabled="EditSaveDisableWhen" title="Save">Save</button>
                        <button class="btn btn-warning btn-lg" ng-click="EditCancel()" title="Close">Close</button>
                        <button class="btn btn-danger btn-lg" title="Delete" ng-click="EditDelete()">Delete</button>
                    </div>
                    <div ng-show="Secondary">
                        <div style="margin: 10px; width:450px;">{{time_clock_delete.msg}}</div>
                        <button class="btn btn-primary btn-lg" ng-click="EditYesUpdate()" title="Delete">Yes</button>
                        <button class="btn btn-warning btn-lg" ng-click="EditNoUpdate()" title="No">No</button>
                    </div>
                    <div ng-show="Tertiary">
                    	<div>{{edit_time_clock.msg}}</div>
                        <button class="btn btn-primary btn-lg" id="edit_save_timeclock" ng-click="EditCloseUpdate()" title="Save">Yes</button>
                        <button class="btn btn-warning btn-lg" ng-click="EditAskCancel()" title="Close">No</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="edit_jqxNotification">
            <div id="edit_notificationContent"></div>
       </div>
       <div id="edit_save_jqxNotification">
            <div id="edit_save_notificationContent"></div>
       </div>
       
       <div id="edit_delete_jqxNotification">
            <div id="edit_delete_notificationContent"></div>
       </div>
       
       <div id="edit_container" style="width: 350px; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;">
       </div>
    </div>
</jqx-window>
<style type="text/css">
    body{
        padding;0;
        margin:0;
    }
    #edit_timeclock_form{
        -webkit-border-radius: 15px 15px 15px 15px;
        border-radius: 15px 15px 15px 15px;
        border: 5px solid #449bca;
    }
</style>