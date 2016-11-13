angular.module("akamaiposApp", ['jqwidgets'])
    .controller('itemCountController', function($scope, $http, adminService){

    var pager = adminService.loadPagerConfig();
    $scope.icountGridSettings = {
        source: new $.jqx.dataAdapter({
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'int'},
                {name: 'Location', type: 'string'},
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
            {text: 'ID', dataField: 'Unique'},
            {text: 'Location', dataField: 'Location'},
            {text: 'Station', dataField: 'Station'},
            {text: 'Comment', dataField: 'Comment'},
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


});