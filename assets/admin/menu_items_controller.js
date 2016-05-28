/**
 * Created by carlosrenato on 05-19-16.
 */
//var app = angular.module("akamaiposApp", ['jqwidgets']);


app.controller('menuItemController', function ($scope, $rootScope, $http) {

    // -- MenuCategoriesTabs Main Tabs
    $('#MenuCategoriesTabs').on('tabclick', function (event) {
        var tabclicked = event.args.item;
        // ITEMS TAB - Reload queries
        if(tabclicked == 2) {
            $scope.menuListBoxSettings.apply('refresh');
        }
    });

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

    var itemsMenuWindow;
    $scope.itemsMenuWindowsSetting = {
        created: function (args) {
            itemsMenuWindow = args.instance;
        },
        resizable: false,
        width: "60%", height: "50%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    /**
     *
     * @type {Array}
     */

    $scope.categoriesByMenu = [];
    $scope.menuListBoxSelecting = function(e) {
        var row = e.args.item.originalItem;
        $scope.categoriesByMenu = row.categories;
        $('.restricter-dragdrop div').remove();
    };

    /**
     * -- CATEGORY BOTTOM GRID
     */
    $scope.allItemsDataStore = {};
    $scope.selectedCategoryInfo = {};
    $scope.clickCategoryCell = function(e, row) {
        $scope.selectedCategoryInfo = row;
        //var $this = angular.element(e.currentTarget);
        var $this = $(e.currentTarget).find('.category-cell-grid');
        $('.category-cell-grid').removeClass('clicked');
        $this.addClass('clicked');
        $this.attr('CategoryID', row.Unique);
        angular.element(e.currentTarget).find('.col-md-2').attr('CategoryID', row.Unique);
        $scope.grid = {
            'cols': row.Column,
            'rows': row.Row,
            'diff': (12 / row.Column),
            'round': Math.floor(12 / row.Column)
        };
        //
        $('.restricter-dragdrop div').remove();
        //
        var diff = $scope.grid.diff;
        var round = $scope.grid.round;
        for(var i = 0;i < $scope.grid.rows;i++) {
            var template = '';
            template += '<div class="row ">';
            if (diff % 1 !== 0) {
                template += '<div class="col-md-offset-1 col-sm-offset-1"></div>';
            }
            for (var j = 0; j < $scope.grid.cols; j++) {
                var num = j + 1 + (i * $scope.grid.cols);
                template += '<div class="draggable col-md-' + round + ' col-sm-' + round +
                    '" id="draggable-' + num + '" data-col="' + (j+1) + '" data-row="' + (i+1) + '">' +
                    num + '</div>';
            }
            if (diff % 1 !== 0) {
                template += '<div class="col-md-offset-1 col-sm-offset-1"></div>';
            }
            template += '</div>';
            $('.restricter-dragdrop').append(template);
        }
        //
        drawExistsItemsOnGrid();
        onClickDraggableItem();
        $('#jqxTabsMenuItemSection').jqxTabs('select', 1);
    };

    function drawExistsItemsOnGrid() {
        $.ajax({
            'url': SiteRoot + 'admin/MenuItem/getItemsByCategoryMenu/' + $scope.selectedCategoryInfo.Unique,
            'method': 'GET',
            'dataType': 'json',
            'success': function(data) {
                $.each(data, function(i, el) {
                    var cell = $('body .restricter-dragdrop .draggable[data-col="' + el.ColumnPosition+ '"][data-row="' + el.RowPosition + '"]');
                    if (el.Status == 0) {
                        cell.css('background-color', '#f0f0f0');
                        cell.removeClass('filled');
                        cell.data('categoryId', '');
                        cell.html('');
                    } else {
                        cell.css('background-color', (el.Status == 1) ? '#063dee' : '#06b1ee');
                        cell.addClass('filled');
                        cell.addClass('itemOnGrid');
                        cell.data('categoryId', el.MenuCategoryUnique);
                        cell.html(el.Description);
                        //$scope.allItemsDataStore[el.MenuCategoryUnique + '-' + el.RowPosition + '-' + el.ColumnPosition] = el;
                    }
                });
                draggableEvents();
                selectedItemEvents();
            }
        });
    }

    /**
     * -- ITEMS COMBO BOX SIDE
     */
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

    $scope.selectedItemInfo = {};
    $scope.itemComboboxOnselect = function(e) {
        var args = e.args;

        $scope.selectedItemInfo = args.item.originalItem;
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

    /**
     * -- TOP GRID OF ITEMS
     */
    $scope.closeItemGridWindows = function() {
        itemsMenuWindow.close();
    };

    $scope.saveItemGridBtn = function() {
        console.log($scope.itemCellSelectedOnGrid);
        var data = {
            'MenuCategoryUnique': $scope.itemCellSelectedOnGrid.MenuCategoryUnique,
            'RowPosition': $scope.itemCellSelectedOnGrid.RowPosition,
            'ColumnPosition': $scope.itemCellSelectedOnGrid.ColumnPosition,
            'ItemUnique': $('#editItem_ItemSelected').jqxComboBox('getSelectedItem').value,
            'Status': $('#editItem_Status').jqxDropDownList('getSelectedItem').value,
            'Label': $('#editItem_label').val()
        };

        $.ajax({
            'url': SiteRoot + 'admin/MenuItem/postMenuItems',
            'method': 'post',
            'data': data,
            'dataType': 'json',
            'success': function(data) {
                drawExistsItemsOnGrid();
                itemsMenuWindow.close();
            }
        });

    };

    $scope.deleteItemGridBtn = function() {
        console.log($scope.itemCellSelectedOnGrid);
        var data = {
            'MenuCategoryUnique': $scope.itemCellSelectedOnGrid.MenuCategoryUnique,
            'RowPosition': $scope.itemCellSelectedOnGrid.RowPosition,
            'ColumnPosition': $scope.itemCellSelectedOnGrid.ColumnPosition,
        };

        $.ajax({
            'url': SiteRoot + 'admin/MenuItem/deleteMenuItems',
            'method': 'post',
            'data': data,
            'dataType': 'json',
            'success': function(data) {
                drawExistsItemsOnGrid();
                itemsMenuWindow.close();
            }
        });
    };

    // Events item form controls
    $('.editItemFormContainer .required-field').on('keypress keyup paste change', function (e) {
        $('#saveItemGridBtn').prop('disabled', false);
    });

    $('#editItem_Status')
        .jqxDropDownList({autoDropDownHeight: true});
    $('#editItem_Status').on('select', function(){
        $('#saveItemGridBtn').prop('disabled', false);
    });

    $('#editItem_ItemSelected').on('select', function(){
        $('#saveItemGridBtn').prop('disabled', false);
    });

    $scope.itemCellSelectedOnGrid = {};
    function onClickDraggableItem() {
        var itemWindow = itemsMenuWindow;
        $('.draggable').on('dblclick', function(e) {
            var $this = $(e.currentTarget);
            if ($this.hasClass('filled')) {
                var data = {
                    'MenuCategoryUnique': $this.data('categoryId'),
                    'ColumnPosition': $this.data('col'),
                    'RowPosition': $this.data('row')
                };
                $.ajax({
                    'url': SiteRoot + 'admin/MenuItem/getItemByPositions',
                    'method': 'post',
                    'data': data,
                    'dataType': 'json',
                    'success': function(data) {
                        $scope.itemCellSelectedOnGrid = data;
                        var statusCombo = $('#editItem_Status').jqxDropDownList('getItemByValue', data['Status']);
                        $('#editItem_Status').jqxDropDownList({'selectedIndex': statusCombo.index});

                        var selectedIndexItem;
                        var itemCombo = $('#editItem_ItemSelected').jqxComboBox('getItemByValue', data['ItemUnique']);
                        if (itemCombo != undefined) {
                            selectedIndexItem = itemCombo.index | 0;
                        } else selectedIndexItem = 0;
                        $('#editItem_ItemSelected').jqxComboBox({'selectedIndex': selectedIndexItem});

                        $('#editItem_label').val(data['Label']);
                        //
                        $('#saveItemGridBtn').prop('disabled', true);
                        itemWindow.open();
                    }

                });
            }
        });
    }

    /**
     * -- DRAGGABLE EVENTS
     */
    function selectedItemEvents () {

        $('#selectedItemInfo').jqxDragDrop(
            {
                dropTarget: $('body .draggable'),
                //restricter:'parent',
                //tolerance: 'fit',
                revert: true
            }
        );

        var ItemOnAboveGrid = false;
        $('#selectedItemInfo').bind('dragStart', function (event) {

        });

        $('#selectedItemInfo').bind('dragEnd', function (event) {
            if (ItemOnAboveGrid) {
                //
                var $this = $(event.args.target);
                var data = {
                    'MenuCategoryUnique': $scope.selectedCategoryInfo.Unique,
                    'ItemUnique': $scope.selectedItemInfo.Unique,
                    'RowPosition': $(event.args.target).data('row'),
                    'ColumnPosition': $(event.args.target).data('col'),
                    'Status': 1
                };
                $.ajax({
                    'url': SiteRoot + 'admin/MenuItem/postMenuItems',
                    'method': 'POST',
                    'data': data,
                    'dataType': 'json',
                    'success': function (data) {
                        if (data.status == 'success') {
                            $this.html($scope.selectedItemInfo.Description);
                            $this.addClass('filled');
                            $this.addClass('itemOnGrid');
                            $this.data('categoryId', $scope.selectedCategoryInfo.Unique);
                            $this.css('background-color', '#063dee');
                            draggableEvents();
                        } else {
                            console.log('error from ajax');
                        }
                    }
                });
            }
        });
        $('#selectedItemInfo').bind('dropTargetEnter', function (event) {
            ItemOnAboveGrid = true;

        });
        $('#selectedItemInfo').bind('dropTargetLeave', function (event) {
            ItemOnAboveGrid = false;
        });
    }

        // ---- DRAG ITEMS ON ABOVE GRID BETWEEN THEMSELVES
        function draggableEvents() {
        if ($('body .itemOnGrid').length) {
            var onCellAboveGrid = false;
            $('.itemOnGrid').jqxDragDrop(
                {
                    dropTarget: $('.draggable'),
                    restricter: '.restricter-dragdrop',
                    //tolerance: 'fit'
                    onTargetDrop: function(data) {
                        console.log('onTargetDrop', data);
                    },
                    dropAction: 'none',
                    //revert: true
                }
            )
            .bind('dragStart', function (event) {
                //$(this).removeClass('draggable');
                //console.log(event.type, event.args.position);
                $(this).jqxDragDrop( { dropTarget: $('.draggable').not($(this)) } );
            })
            .bind('dragEnd', function (event) {
                //$(this).addClass('draggable');
                if (onCellAboveGrid) {
                    if (!isEqual($scope.onGridTargetMoved, $scope.onGridElementMoved)) {
                        var data = {
                          'element': $scope.onGridElementMoved,
                          'target': $scope.onGridTargetMoved
                        };
                        var current = $('.restricter-dragdrop .draggable[data-col="' + $scope.onGridElementMoved.ColumnPosition+ '"][data-row="' + $scope.onGridElementMoved.RowPosition + '"]');
                        var target = $('.restricter-dragdrop .draggable[data-col="' + $scope.onGridTargetMoved.ColumnPosition+ '"][data-row="' + $scope.onGridTargetMoved.RowPosition + '"]');

                        $.ajax({
                            'url': SiteRoot + 'admin/MenuItem/setNewPosition/' + $scope.selectedCategoryInfo.Unique,
                            'method': 'POST',
                            'data': data,
                            'success': function(data) {
                                //console.log(data);
                                //if (!data) {
                                //    target.css('background-color', current.css('background-color'));
                                //    target.addClass('filled');
                                //    target.data('categoryId', current.data('categoryId'));
                                //    target.html(current.html());
                                //
                                //    current.css('background-color', '#f0f0f0');
                                //    current.removeClass('filled');
                                //    current.data('categoryId', '');
                                //    current.html('');
                                //} else {
                                //    var currentData = current.data('categoryId');
                                //    var currentBackColor = current.css('background-color')
                                //    var currentContent = current.html();
                                //
                                //    current.css('background-color', target.css('background-color'));
                                //    current.data('categoryId', target.data('categoryId'));
                                //    current.html(target.html());
                                //
                                //    target.css('background-color', currentBackColor);
                                //    target.data('background-color', currentData);
                                //    target.html(currentContent);
                                //}
                                setTimeout(function() {
                                    angular.element('.category-cell-grid.clicked').parent().triggerHandler('click');
                                }, 100);
                            }

                        });
                    }

                }
                //console.log(event.type, event.args.position);
            })
            .bind('dropTargetEnter', function (event) {
                //console.log(event.type, event.args.position);
                onCellAboveGrid = true;
                //$scope.currentTargetOnItemsGrid = event.args.target;
                var target_col = $(event.args.target).data('col');
                var element_col = $(event.args.element).data('col');
                var target_row = $(event.args.target).data('row');
                var element_row = $(event.args.element).data('row');
                $scope.onGridTargetMoved = {'ColumnPosition': target_col, 'RowPosition': target_row};
                $scope.onGridElementMoved = {'ColumnPosition': element_col, 'RowPosition': element_row};
            })
            .bind('dropTargetLeave', function (event) {
                //console.log(event.type, event.args.position);
                onCellAboveGrid = false;
            });

            function isEqual(obj1, obj2) {
                var equal = true;
                for(var i in obj1) {
                    if (obj1[i] != obj2[i]) {
                        equal = false;
                    }
                }
                return equal;
            }
        }

    }
});