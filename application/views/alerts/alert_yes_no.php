<jqx-window jqx-on-close="close()" id="DialogAlertYesNo" jqx-create="dialogAlertQYesNoSettings" jqx-settings="dialogAlertQYesNoSettings">
    <div>Dialog Alert</div>
    <div style="padding:0; margin:0; overflow: hidden; background: #144766;">
        <div style="width:100%; height:90px; color:#FFF;">
            <h4 ng-bind-html="alertqyn.message"></h4>
        </div>
        <div align="right" style="width:98%;">
            <form id="DefaultQYN"> 
                <button class="btn-fn" type="submit">Yes</button>
                <li class="btn-fn" ng-click="CancelQYN()">No</li>
            </form>
        </div>
    </div>
 </jqx-window>
<style>
    #DialogAlertYesNo{
      -webkit-border-radius: 15px 15px 15px 15px;
      border-radius: 15px 15px 15px 15px;
      border: 2px solid #449bca;
    }
	
	.btn-fn{
		-moz-user-select: none;
		border: 1px solid #468db3;
		border-radius: 5px;
		box-sizing: border-box;
		color: #f7faf7;
		cursor: pointer;
		display: inline-block;
		font-family: arial,sans-serif;
		font-size: 20px;
		height: 52px;
		line-height: 52px;
		margin: 10px 0 1px 0px;
		overflow: hidden;
		text-align: center;
		width: 72px;
		background: #144766;
		vertical-align:bottom;
	}

</style>