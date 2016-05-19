/**
 * Created by carlosrenato on 05-19-16.
 */
//var app = angular.module("akamaiposApp", ['jqwidgets']);

app.controller('menuItemController', function ($scope, $http) {
    var source =
    {
        dataType: 'json',
        dataFields: [
            {name: 'Unique', type: 'int'},
            {name: 'MenuName', type: 'number'},
            {name: 'Status', type: 'number'},
            {name: 'StatusName', type: 'string'},
            {name: 'Column', type: 'number'},
            {name: 'Row', type: 'number'},
            {name: 'CategoryName', type: 'string'}
        ],
        id: 'Unique',
        url: SiteRoot + 'admin/MenuItem/load_allMenusWithCategories/1/on'
    };
    var dataAdapter = new $.jqx.dataAdapter(source);

    $scope.menuListBoxSettings =
    {
        source: dataAdapter,
        displayMember: "MenuName",
        valueMember: "Unique",
        //, width: 200, height: 250
        width: "10%",
        theme: 'arctic'
    };

    $scope.menuListBoxSelecting = function(e) {
        var row = e.args;
        console.log(row);
    }

});