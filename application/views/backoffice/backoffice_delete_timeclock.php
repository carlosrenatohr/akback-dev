<jqx-window ngx-on-close="close()" id="delete_timeclock" jqx-create="DeleteTimeClockSettings" jqx-settings="DeleteTimeClockSettings">
    <div>Edit Dialog</div>
    <div style="overflow: hidden;">
        <div style="padding:10px;">{{delete.msg}}</div>
        <div>
            <input type="hidden" ng-model="time_clock.unique"/>
            <button class="btn btn-primary btn-lg" ng-click="DeleteTimeClock()">Yes</button>
            <button class="btn btn-warning btn-lg" ng-click="DeleteTimeClockCancel()">No</button>
        </div>
    </div>
</jqx-window>
<style>
    #delete_timeclock{
        -webkit-border-radius: 15px 15px 15px 15px;
        border-radius: 15px 15px 15px 15px;
        border: 5px solid #449bca;
    }
</style>
