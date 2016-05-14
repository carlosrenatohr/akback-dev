/**
 * Created by carlosrenato on 05-13-16.
 */
var app = angular.module("akamaiposApp", ['jqwidgets']);

app.controller('menuCategoriesController', function($scope, $http){

    $scope.menuTableSettings = {
        source: {
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'int'},
                {name: 'MenuName', type: 'number'},
                {name: 'Status', type: 'number'}
            ],
            id: 'Unique',
            url: SiteRoot + 'admin/category/load_allmenus'
        },
        columns: [
            {text: 'ID', dataField: 'Unique', type: 'int'},
            {text: 'Menu Name', dataField: 'MenuName', type: 'number'},
            {text: 'Status', dataField: 'Status', type: 'int'}
        ],
        columnsResize: true,
        width: "99.7%",
        theme: 'arctic',
        //sortable: true,
        pageable: true,
        pageSize: 20,
        pagerMode: 'default',
        altRows: true,
        //filterable: true,
        //filterMode: 'simple'
    };

    $scope.categoriesTableSettings = {
        source: {
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'int'},
                {name: 'CategoryName', type: 'string'},
                {name: 'Sort', type: 'number'},
                {name: 'Status', type: 'number'},
                {name: 'MenuUnique', type: 'number'},
            ],
            id: 'Unique',
            url: SiteRoot + 'admin/category/load_allcategories'
        },
        columns: [
            {text: 'ID', dataField: 'Unique', type: 'int'},
            {text: 'Category Name', dataField: 'CategoryName', type: 'string'},
            {text: 'Menu', dataField: 'MenuUnique', type: 'string'},
            {text: 'Sort', dataField: 'Sort', type: 'number'},
            {text: 'Status', dataField: 'Status', type: 'number'}
        ],
        columnsResize: true,
        width: "99.7%",
        theme: 'arctic',
        sortable: true,
        pageable: true,
        pageSize: 20,
        pagerMode: 'default',
        altRows: true,
        filterable: true,
        filterMode: 'simple'
    };

    $('#add_Status').jqxDropDownList({autoDropDownHeight: true});
    $scope.addMenuWindowSettings = {
        created: function (args) {
            menuWindow = args.instance;
        },
        resizable: false,
        width: "50%", height: "40%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    $scope.newOrEditOption = null;
    $scope.menuId = null;
    $scope.newMenuAction = function() {
        menuWindow.setTitle('Add new menu');
        $scope.newOrEditOption = 'new';
        $scope.menuId = null;
        menuWindow.open();
    };

    $scope.updateMenuAction = function(e) {
        var values = e.args.row;
        var statusCombo = $('#add_Status').jqxDropDownList('getItemByValue', values['Status']);
        $('#add_Status').jqxDropDownList({'selectedIndex': statusCombo.index});
        $('#add_MenuName').val(values['MenuName']);
        $scope.newOrEditOption = 'edit';
        $scope.menuId = values['Unique'];
        menuWindow.setTitle('Edit menu ' + values['MenuName']);
        menuWindow.open();
    };

    $scope.CloseMenuWindows = function() {
        menuWindow.close();
        resetMenuWindows();
    };

    var validationMenuItem = function(values) {
        console.log(values);
        return true;
    };

    $scope.SaveMenuWindows = function () {
        var values = {
            'MenuName': $('#add_MenuName').val(),
            'Status': $('#add_Status').jqxDropDownList('getSelectedItem').value,
        };
        if (validationMenuItem(values)) {
            var url;
            if ($scope.newOrEditOption == 'new') {
                url = SiteRoot + 'admin/category/add_newMenu';
            } else if ($scope.newOrEditOption == 'edit') {
                url = SiteRoot + 'admin/category/edit_newMenu/' + $scope.menuId;
            }
            $http({
                method: 'POST',
                'url': url,
                'data': values
                //headers: {'Content-Type': 'application/json'}
            }).then(function(response) {
                if(response.data.status == "success") {
                    $scope.menuTableSettings = {
                        source: {
                            dataType: 'json',
                            dataFields: [
                                {name: 'Unique', type: 'int'},
                                {name: 'MenuName', type: 'number'},
                                {name: 'Status', type: 'number'}
                            ],
                            id: 'Unique',
                            url: SiteRoot + 'admin/category/load_allmenus'
                        },
                        created: function (args) {
                            var instance = args.instance;
                            instance.updateBoundData();
                        }
                    };
                    //
                    menuWindow.close();
                    resetMenuWindows();
                } else {
                    console.log(response);
                }
            }, function(response){
                console.log('ERROR: ');
                console.log(response);
            });
        }
    };

    var resetMenuWindows = function() {
        $('#add_MenuName').val('');
        $('#add_Status').jqxDropDownList({'selectedIndex': 0});
    }


});
