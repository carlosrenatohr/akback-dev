<div class="">
    <div class="col-md-12">
        <button class="btn btn-info" ng-click="" style="margin: 10px 0;">
            New Item
        </button>
    </div>
    <div class="col-md-12">
        <jqx-grid id="inventoryItemsGrid"
                    jqx-settings="inventoryItemsGrid"
                    jqx-create="inventoryItemsGrid"
        ></jqx-grid>
    </div>
    <jqx-window jqx-on-close="close()" jqx-settings=""
                jqx-create="" class="">
        <div>
            New Item | Details
        </div>
        <div class="">
            Inventory
        </div>
    </jqx-window>

</div>