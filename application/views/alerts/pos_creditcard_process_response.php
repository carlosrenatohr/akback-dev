<jqx-window jqx-on-close="close()" id="CreditCardProcess" jqx-create="dialogCreditCardProcess" jqx-settings="dialogCreditCardProcess" style="display:none;">
    <div class="credit-card-container">
        <div style="padding-bottom:10px; font-size:14px; font-weight:bold;">{{creditcardprocess.message}}</div>
        <div>
        	<!--<button class="btn btn-info btn-lg" ng-click="CreditCardProcessCancel()" ng-disabled="BtnCreditCardCancelWhen">Cancel</button>-->
            <button class="btn btn-info" ng-click="CreditCardProcessCancel()" ng-show="BtnCreditCardOkWhen">Ok</button>
        </div>
    </div>    
</jqx-window>
<style>
    #CreditCardProcess{
        -webkit-border-radius: 15px 15px 15px 15px;
        border-radius: 15px 15px 15px 15px;
        border: 5px solid #449bca;
    }
</style>