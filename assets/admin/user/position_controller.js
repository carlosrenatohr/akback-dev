/**
 * Created by carlosrenato on 05-10-16.
 */
//var app = angular.module("demoApp", ['jqWidgets']);

demoApp.controller("positionController", function($scope) {

    $scope.userPositionsTableSettings = {
        source: {
            dataType: 'json',
            dataFields: [
                {name: 'PositionName', type: 'string'},
                {name: 'PrimaryPosition', type: 'string'},
            ],
            id: 'Unique',
            url: SiteRoot + 'admin/user/load_positionsByUser/100'
        },
        columns: [
            {text: 'Name', dataField: 'PositionName', type: 'string'},
            {text: 'Primary', dataField: 'PrimaryPosition', type: 'string'},
        ],
        columnsResize: true,
        width: "75%",
        theme: 'arctic',
        //sortable: true,
        //pageable: true,
        //pageSize: 5,
        pagerMode: 'default',
        //altRows: true,
        //filterable: true,
        //filterMode: 'simple'
    };
});
