<jqx-window jqx-on-close="close()" id="po_delete_conf" jqx-create="dialogPOItemConfSettings" jqx-settings="dialogPOItemConfSettings">
    <div class="container-fluid">
        <input type="hidden" ng-model="POItem.unique">
        <input type="hidden" ng-model="POItem.index">
        <div class="col-md-12">
            <div class="row" style="margin-bottom: 5px;">
                <span>Are you sure you want to delete?</span>
            </div>
            <div class="row">
                <button class="btn btn-danger" ng-click="POItemDelYes()">Yes</button>
                <button class="btn btn-warning" ng-click="POItemDelNo()">No</button>
            </div>
        </div>
    </div>
</jqx-window>
<style>
    #po_delete_conf{
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