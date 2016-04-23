<jqx-window jqx-on-close="close()" id="dialog-alert-time-clock" jqx-create="dialogTimeClockAlertOkSettings" jqx-settings="dialogTimeClockAlertOkSettings">
    <div>Dialog Alert</div>
    <div style="padding:0; margin:0; overflow: hidden;">
        <div align="center" style="width:100%; height:90px;">
            <h2>{{timeclockalert.message}}</h2>
            <h2>{{timeclockalert.actual}}</h2>
            <h2 style="color:red;">{{timeclockalert.status}}</h2>
        </div>
        <input type="hidden" ng-model="popuppasscode.id">
        <div align="right" style="width:100%;">
            <div class="alert-button" ng-click="TimeClockAlertOk()"><img class="alertimg" height="60" width="65" src="<?php echo base_url()?>assets/img/ok.png" /></div>
        </div>
    </div>
</jqx-window>
<style>
    #dialog-alert-time-clock{
        -webkit-border-radius: 15px 15px 15px 15px;
        border-radius: 15px 15px 15px 15px;
        border: 5px solid #449bca;
    }

    .alertimg{
        margin: 0px;
        padding:0px;
    }

    .alert-button{
        border-radius: 10px;
        height: 65px;
        width: 65px;
    }
</style>
