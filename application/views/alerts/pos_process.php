<jqx-window jqx-on-close="close()" id="dialog-process-alert" jqx-create="dialogProcessAlertSettings" jqx-settings="dialogProcessAlertSettings" style="display:none;">
    <div>Dialog Process Alert</div>
    <div style="padding:0; margin:0; overflow: hidden;">
        <div style="width:100%; height:90px;">
            <h4>{{process.message}}</h4>
        </div>
    </div>
</jqx-window>
<style>
    #dialog-process-alert{
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