angular.module("akamaiposApp", ['jqwidgets'])
    .controller('itemCountController', function($scope, $http, adminService){

    var pager = adminService.loadPagerConfig();
    $scope.icountGridSettings = {
        source: new $.jqx.dataAdapter({
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'int'},
                {name: 'Item', type: 'string'},
                {name: 'Part', type: 'string'},
                {name: 'Description', type: 'string'},
                {name: 'Supplier', type: 'string'},
                {name: 'SupplierPart', type: 'string'},
                {name: 'Category', type: 'string'},
                {name: 'CurrentStock', type: 'string'},
                {name: 'CountStock', type: 'string'},
                {name: 'Difference', type: 'string'},
                {name: 'Location', type: 'string'},
                {name: 'ItemStockLineUnique', type: 'string'},
                {name: 'Station', type: 'string'},
                {name: 'Comment', type: 'string'},
                {name: 'Status', type: 'string'},
                {name: 'Created', type: 'string'},
                {name: 'CreatedBy', type: 'string'},
                {name: 'Updated', type: 'string'},
                {name: 'UpdatedBy', type: 'string'}
            ],
            id: 'Unique',
            url: SiteRoot + 'admin/ItemCount/load_allitemcount'
        }),
        columns: [
            {dataField: 'Unique', hidden: true},
            {text: 'Item', dataField: 'Item'},
            {text: 'Part', dataField: 'Part'},
            {text: 'Description', dataField: 'Description'},
            {text: 'Supplier', dataField: 'Supplier'},
            {text: 'Category', dataField: 'Category'},
            {text: 'Cost', dataField: 'Cost'},
            {text: 'Current', dataField: 'CurrentStock'},
            {text: 'Count', dataField: 'CountStock'},
            {text: 'Difference', dataField: 'Difference'},
            {dataField: 'Station', hidden: true},
            {dataField: 'Comment', hidden: true},
            {dataField: 'Created', hidden: true},
            {dataField: 'Updated', hidden: true},
            {dataField: 'CreatedBy', hidden: true},
            {dataField: 'UpdatedBy', hidden: true}
        ],
        width: "99.7%",
        theme: 'arctic',
        filterable: true,
        showfilterrow: true,
        sortable: true,
        pageable: true,
        pageSize: pager.pageSize,
        pagesizeoptions: pager.pagesizeoptions,
        altRows: true,
        autoheight: true,
        autorowheight: true
    };

    var icountwind;
    $scope.icountWindowSettings = {
        created: function (args) {
            icountwind = args.instance;
        },
        resizable: false,
        width: "100%", height: "100%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    $scope.openIcount = function() {
        // $scope.ibrandID = null;
        // $scope.createOrEditIbrand = 'create';
        //
        icountwind.setTitle('New Item Count');
        icountwind.open();
    };

});