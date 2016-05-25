/**
 * Created by carlosrenato on 05-19-16.
 */
//var app = angular.module("akamaiposApp", ['jqwidgets']);

app.controller('menuItemController', function ($scope, $rootScope, $http) {

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

    $scope.categoriesByMenu = [];
    $scope.menuListBoxSelecting = function(e) {
        var row = e.args.item.originalItem;
        $scope.categoriesByMenu = row.categories;
        //console.log(row.categories);
    };

    $rootScope.grid = {
        'cols': 12,
        'rows': 5,
        'diff': (12 / 12),
        'round': Math.floor(12 / 12)
    };

    $scope.clickCategoryCell = function(e, row) {
        angular.element(e.currentTarget).find('.col-md-2').attr('CategoryID', row.Unique);
        $scope.grid = {
            'cols': row.Column,
            'rows': row.Row,
            'diff': (12 / row.Column),
            'round': Math.floor(12 / row.Column)
        };
        //
        console.log($scope.grid);

        var diff = $scope.grid.diff;
        var round = $scope.grid.round;
        $('.restricter-dragdrop div').remove();
        for(var i = 0;i < $scope.grid.rows;i++) {
            var template = '';
            template += '<div class="row " style="background-color: lightgrey">';
            if (Number(diff) === diff && diff % 1 === 0) {
                template += '<div class="col-md-offset-1 col-sm-offset-1"></div>';
            }
            for (var j = 0; j < $scope.grid.cols; j++) {
                template += '<div class="draggable col-md-' + round + ' col-sm-' + round + '" style="height: 120px;background-color: ' + ((i % 2 == 0) ? 'red' : 'green') + ';border: black 1px solid;"' +
                    'id="draggable-' + (i + (j * 5) + 1) + '">' +
                    (i + (j * 5) + 1 ) + '</div>';
            }
            if (Number(diff) === diff && diff % 1 === 0) {
                template += '<div class="col-md-offset-1"></div>';
            }
            template += '</div>';
            $('.restricter-dragdrop').append(template);
        }

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
    $('.draggable').jqxDragDrop(
        {dropTarget: '.droppingTarget',
        restricter:'.restricter-dragdrop',
        //tolerance: 'fit'
        }
    );
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

    //(function centerLabels() {
    //    var labels = $('.draggable');
    //    labels.each(function (index, el) {
    //        el = $(el);
    //        var top = (el.height() - el.height()) / 2;
    //        el.css('top', top + 'px');
    //    });
    //} ());
});