/**
 * Created by carlosrenato on 05-13-16.
 */
var app = angular.module("akamaiposApp", ['jqwidgets']);

app.controller('menuCategoriesController', function($scope, $http){

    /**
     * MENU TAB LOGIC
     */
    var menuWindow, categoryWindow;
    $scope.menuTableSettings = {
        source: {
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'int'},
                {name: 'MenuName', type: 'number'},
                {name: 'Status', type: 'number'},
                {name: 'statusName', type: 'string'}
            ],
            id: 'Unique',
            url: SiteRoot + 'admin/MenuCategory/load_allmenus'
        },
        columns: [
            {text: 'ID', dataField: 'Unique', type: 'int'},
            {text: 'Menu Name', dataField: 'MenuName', type: 'number'},
            {text: 'Status', dataField: 'Status', type: 'int', hidden:true},
            {text: 'Status', dataField: 'statusName', type: 'string'},
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
                url = SiteRoot + 'admin/MenuCategory/add_newMenu';
            } else if ($scope.newOrEditOption == 'edit') {
                url = SiteRoot + 'admin/MenuCategory/edit_newMenu/' + $scope.menuId;
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
                                {name: 'Status', type: 'number'},
                                {name: 'statusName', type: 'string'}
                            ],
                            id: 'Unique',
                            url: SiteRoot + 'admin/MenuCategory/load_allmenus'
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
    };


    /**
     * CATEGORIES TAB LOGIC
     */
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
            url: SiteRoot + 'admin/MenuCategory/load_allcategories'
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

    // Menu select
    var source =
    {
        datatype: "json",
        datafields: [
            { name: 'MenuName' },
            { name: 'Status' }
        ],
        id: 'Unique',
        url: SiteRoot + 'admin/MenuCategory/load_allmenus/1'
    };

    var dataAdapter = new $.jqx.dataAdapter(source);
    $scope.settingsMenuSelect =
            { source: dataAdapter, displayMember: "MenuName", valueMember: "Unique" };


    // Status select
    $('#add_CategoryStatus').jqxDropDownList({autoDropDownHeight: true});

    // Init scope
    $scope.newOrEditCategoryOption = null;
    $scope.categoryIdSelected = null;

    // Open category windows
    $scope.addCategoryWindowSettings = {
        created: function (args) {
            categoryWindow = args.instance;
        },
        resizable: false,
        width: "50%", height: "40%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    $scope.newCategoryAction = function() {
        $scope.newOrEditCategoryOption = 'new';
        $scope.categoryIdSelected = null;

        categoryWindow.setTitle('Add new Category');
        categoryWindow.open();
    };

    $scope.updateCategoryAction = function(e) {
        var values = e.args.row;
        var statusCombo = $('#add_CategoryStatus').jqxDropDownList('getItemByValue', values['Status']);
        $('#add_CategoryStatus').jqxDropDownList({'selectedIndex': statusCombo.index});

        var menuCombo = $('#add_MenuUnique').jqxDropDownList('getItemByValue', values['MenuUnique']);
        $('#add_MenuUnique').jqxDropDownList({'selectedIndex': (menuCombo) ? menuCombo.index: '0'});

        $('#add_CategoryName').val(values['CategoryName']);
        $('#add_Sort').val(values['Sort']);
        $scope.newOrEditOption = 'edit';
        $scope.menuId = values['Unique'];
        categoryWindow.setTitle('Edit category ' + values['CategoryName']);
        categoryWindow.open();
    };

    $scope.CloseCategoryWindows = function() {
        categoryWindow.close();
        //resetMenuWindows();
    }




});
