/**
 * Created by carlosrenato on 08-31-16.
 */
app.controller('menuItemsInventoryController', function($scope, $http){

    $('#MenuCategoriesTabs').on('tabclick', function (e) {
        var tabclicked = e.args.item;
        // Items Inventory TAB - Reload queries
        if (tabclicked == 1) {
            updateItemsInventoryGrid();
        }
    });

    var updateItemsInventoryGrid = function() {
        $(this).jqxGrid({
            source: new $.jqx.dataAdapter({
                dataType: 'json',
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'Item', type: 'string'},
                    {name: 'Description', type: 'string'},
                    {name: 'SupplierUnique', type: 'int'},
                    {name: 'CategoryUnique', type: 'int'},
                    {name: 'price1', type: 'string'},

                ],
                url: SiteRoot + 'admin/MenuPrinter/load_completePrinters'
            })
        });
    };

    $scope.inventoryItemsGrid = {
        source: new $.jqx.dataAdapter({
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'int'},
                {name: 'Item', type: 'string'},
                {name: 'Description', type: 'string'},
                {name: 'SupplierUnique', type: 'int'},
                {name: 'CategoryUnique', type: 'int'},
                {name: 'price1', type: 'string'},

            ],
            url: SiteRoot + 'admin/MenuPrinter/load_completePrinters'
        }),
        columns: [
            {text: 'ID', dataField: 'Unique', type: 'int'},
            {text: 'Item Number', dataField: 'Item', type: 'string'},
            {text: 'Size', type: 'string'},
            {text: 'Color', type: 'string'},
            {text: 'Supplier', datafield: 'SupplierUnique', type: 'string'},
            {text: 'Category', dataField: 'CategoryUnique', type: 'string'},
            {text: 'Price', dataField: 'price1', type: 'string'},
            {text: 'Quantity', dataField: '', type: 'string'},
            {text: '', dataField: 'Part', type: 'string', hidden: true}
        ],
        width: "100%",
        theme: 'arctic',
        filterable: true,
        showfilterrow: true,
        ready: function() {
            $('#inventoryItemsGrid').jqxGrid('updatebounddata', 'filter');
        },
        sortable: true,
        pageable: true
    }
});
