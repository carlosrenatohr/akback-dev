<jqx-window jqx-on-close="close()" class="dialogClass" id="new_sale_qq" jqx-create="dialogNewSaleQ" jqx-settings="dialogNewSaleQ" style="display: none;">
    <div class="btn-container">
        <button type="button" class="btn btn-danger btn-lg newsaleq" ng-click="CancelReceipt()">Cancel Sale</button>
        <button type="button" class="btn btn-success btn-lg newsaleq" ng-click="PutOnHold()">Put On Hold</button>
        <button type="button" class="btn btn-primary btn-lg newsaleq" ng-click="ReturnDisplay()">Go back</button>
    </div>
</jqx-window>
<style type="text/css">
    /*
    #new_sale_qq{
        max-height: 400px !important;
        max-width: 600px !important;
        -webkit-border-radius: 15px 15px 15px 15px;
        border-radius: 15px 15px 15px 15px;
        border: 5px solid #449bca;
    }
    */
    #new_sale_qq{
        min-width: 20% !important;
        width: 20% !important;
        border: 3px solid #666;
        -webkit-border-radius: 58px;
        -moz-border-radius: 58px;
        border-radius: 5px 20px 5px;
        -webkit-box-shadow: 2px 2px 4px #888;
        -moz-box-shadow: 2px 2px 4px #888;
        box-shadow: 2px 2px 4px #888;
        font-size: 16px;
    }

    .newsaleq {
        font-size: 16px;
    }

    @media screen and (max-width: 1024px) {
        .newsaleq {
            font-size: 16px;
        }
        #new_sale_qq {
            max-width: 38% !important;
            width: 38% !important;
            font-size: 16px;
        }
    }
</style>
