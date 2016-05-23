/**
 * Created by carlosrenato on 05-19-16.
 */
//var app = angular.module("akamaiposApp", ['jqwidgets']);

app.controller('menuItemController', function ($scope, $http) {

    // -- MENU LISTBOX
    var dataAdapterMenu = new $.jqx.dataAdapter(
        {
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'int'},
                {name: 'MenuName', type: 'number'},
                {name: 'Status', type: 'number'},
                {name: 'StatusName', type: 'string'},
                {name: 'Column', type: 'number'},
                {name: 'Row', type: 'number'},
                {name: 'CategoryName', type: 'string'},
                {name: 'categories', type: 'json'}
            ],
            id: 'Unique',
            url: SiteRoot + 'admin/MenuItem/load_allMenusWithCategories/1/on'
        }
    );

    $scope.menuListBoxSettings =
    {
        source: dataAdapterMenu,
        displayMember: "MenuName",
        valueMember: "Unique",
        //, width: 200, height: 250
        width: "100%",
        height: "100%",
        theme: 'arctic'
    };
    $scope.items = [];
    $scope.menuListBoxSelecting = function(e) {
        var row = e.args.item.originalItem;
        $scope.items = row.categories;
        //console.log(row.categories);
    };

    // -- ITEMS LIST COMBOBOX
    var dataAdapterItems = new $.jqx.dataAdapter(
        {
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'int'},
                {name: 'Description', type: 'string'},
                {name: 'Item', type: 'string'},
                {name: 'Part', type: 'string'},
                {name: 'Status', type: 'number'}
            ],
            id: 'Unique',
            url: SiteRoot + 'admin/MenuItem/load_allItems'
        }
    );

    $scope.itemsComboboxSettings =
    {
        created: function (args) {
            comboboxItems = args.instance;
        },
        //selectedIndex: 0,
        placeHolder: 'Select an item',
        displayMember: "Description",
        valueMember: "Unique",
        width: "99%",
        itemHeight: 50,
        height: 40,
        source: dataAdapterItems
    };

    // -- CATEGORIES BOTTON GRID
    // -- TO FIX
    $scope.categoriesMenuShownSettings = {
        columns: [
            {text: 'ID', dataField: 'Unique', type: 'int'},
            {text: 'Menu Name', dataField: 'MenuName', type: 'number'},
            {text: 'Status', dataField: 'Status', type: 'int', hidden:true},
            {text: 'Status', dataField: 'StatusName', type: 'string'},
            {text: 'Column', dataField: 'Column', type: 'number', hidden: true},
            {text: 'Row', dataField: 'Row', type: 'number', hidden: true},
        ],
        columnsResize: true,
        width: "99.7%",
        theme: 'arctic',
        //sortable: true,
        pageable: true,
        pageSize: 20,
        pagerMode: 'default',
        altRows: true,
    };

});

$(function() {
    $('.draggable').jqxDragDrop({dropTarget: '.draggable', restricter:'.restricter-dragdrop' });
    $('.draggable').bind('dragStart', function (event) {
        console.log(event.type, event.args.position);
    });
    $('.draggable').bind('dragEnd', function (event) {
        console.log(event.type, event.args.position);
    });
    $('.draggable').bind('dropTargetEnter', function (event) {
        console.log(event.type, event.args.position);
    });
    $('.draggable').bind('dropTargetLeave', function (event) {
        console.log(event.args);
        console.log(event.type, event.args.position);
    });
});