<jqx-window jqx-on-close="close()" id="CreditCardResponse" jqx-create="dialogCardResponse" jqx-settings="dialogCardResponse" style="display:none;">
  <div id="credit-card-response">
        <input type="hidden" ng-model="response.id">
        <input type="hidden" ng-model="ccpayment.status">
        <div class="credit-card-container">
        	<div class="col-md-12 msgresponse text-center"><h2>{{response.message}}</h2></div>
            <div class="col-md-12">
                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-primary btn-lg cardprocessbuttons" ng-if="print_receipt === 1" ng-click="CardReponsePrint(response.id, ccpayment.status)">Print</button>
                    <button type="button" class="btn btn-primary btn-lg cardprocessbuttons" ng-if="print_receipt === 0" disabled="disabled" ng-click="CardReponsePrint(response.id, ccpayment.status)">Print</button>
                </div>
                <div class="col-md-6 text-left">
                    <button class="btn btn-warning btn-lg cardprocessbuttons" ng-click="CardResponseOk()">Ok</button>
                </div>
            </div>
        </div>    
  </div>
</jqx-window>
<style>
    #CreditCardResponse{
        max-height: 400px !important;
        max-width: 600px !important;
        -webkit-border-radius: 15px 15px 15px 15px;
        border-radius: 15px 15px 15px 15px;
        border: 5px solid #449bca;
    }

    .cardprocessbuttons{
        width: 80px !important;
    }
    .msgresponse{
        min-height: 60px;
    }
</style>