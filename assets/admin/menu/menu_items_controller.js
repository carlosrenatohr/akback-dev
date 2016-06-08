/**
 * Created by carlosrenato on 05-19-16.
 */

app.controller('menuItemController', function ($scope, $rootScope, $http) {

    // -- MenuCategoriesTabs Main Tabs
    $('#MenuCategoriesTabs').on('tabclick', function (event) {
        var tabclicked = event.args.item;
        // ITEMS TAB - Reload queries
        if(tabclicked == 2) {
            $scope.menuListBoxSettings.apply('refresh');
        }
    });

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
     * MENU LISTBOX
     * @type {Array}
     */
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
                {name: 'MenuItemColumn', type: 'number'},
                {name: 'MenuItemRow', type: 'number'},
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
        width: '100%',
        //height: "100%",
        theme: 'arctic'
    };

    $scope.categoriesByMenu = [];
    $scope.menuListBoxSelecting = function(e) {
        var row = e.args.item.originalItem;
        $scope.categoriesByMenu = row.categories;
        $scope.menuSelectedWithCategories = row;

        $scope.menuSelectedWithCategories.grid = {
                cols: $scope.menuSelectedWithCategories.Column,
                rows: $scope.menuSelectedWithCategories.Row,
                diff: (12 / $scope.menuSelectedWithCategories.Column),
                round: Math.round(12 / $scope.menuSelectedWithCategories.Column)
        };
        var categoriesInGrid = {};
        for (var i = 1; i <= $scope.menuSelectedWithCategories.Row; i++) {
            for (var j = 1; j <= $scope.menuSelectedWithCategories.Column; j++) {
                for (var k in $scope.menuSelectedWithCategories.categories) {
                    if (!categoriesInGrid.hasOwnProperty(i)) {
                        categoriesInGrid[i] = {};
                    }
                    if($scope.menuSelectedWithCategories.categories[k]['Row'] == i
                        &&
                        $scope.menuSelectedWithCategories.categories[k]['Column'] == j) {
                        categoriesInGrid[i][j] = $scope.menuSelectedWithCategories.categories[k];
                    } else {
                        if (categoriesInGrid[i][j] == undefined) {
                            categoriesInGrid[i][j] = null;
                        }
                    }
                }
            }
        }
        $scope.menuSelectedWithCategories.newCategories = categoriesInGrid;
        $('.restricter-dragdrop div').remove();
    };

    /**
     * -- CATEGORY BOTTOM GRID
     */
    $scope.allItemsDataStore = {};
    $scope.selectedCategoryInfo = {};
    $scope.clickCategoryCell = function(e, row) {
        if (row == null) {
            return;
        }
        $scope.selectedCategoryInfo = row;
        //var $this = angular.element(e.currentTarget);
        var $this = $(e.currentTarget);
        $('.category-cell-grid').removeClass('clicked');
        $this.addClass('clicked');
        $this.attr('CategoryID', row.Unique);
        $scope.grid = {
            'cols': $scope.menuSelectedWithCategories.MenuItemColumn,
            'rows': $scope.menuSelectedWithCategories.MenuItemRow,
            'diff': (12 / $scope.menuSelectedWithCategories.MenuItemColumn),
            'round': Math.floor(12 / $scope.menuSelectedWithCategories.MenuItemColumn)
        };
        //
        $('.restricter-dragdrop div').remove();
        //
        var diff = $scope.grid.diff;
        var round = $scope.grid.round;
        for(var i = 0;i < $scope.grid.rows;i++) {
            var template = '';
            template += '<div class="row">';
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
                    var cell = $('body .restricter-dragdrop .draggable[data-col="' + el.Column+ '"][data-row="' + el.Row + '"]');
                    if (el.Status == 0) {
                        cell.jqxDragDrop('destroy');
                        cell.removeClass('itemOnGrid');
                        //cell.unbind('dragStart');
                        //cell.unbind('dragEnd');
                        cell.css('background-color', '#f0f0f0');
                        cell.removeClass('filled');
                        //cell.removeClass('draggable');
                        cell.data('categoryId', '');
                        cell.html('');
                    } else {
                        cell.css('background-color', (el.Status == 1) ? '#063dee' : '#06b1ee');
                        cell.addClass('filled');
                        cell.addClass('itemOnGrid');
                        cell.data('categoryId', el.MenuCategoryUnique);
                        cell.html((el.Label == null || el.Label == '') ?  el.Description : el.Label);
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
        altRows: true
    };

    /**
     * -- TOP GRID OF ITEMS
     */
    // Menu Item Notification settings
    var setNotificationInit = function (type) {
        return {
            width: "auto",
            appendContainer: "#notification_container_menuitem",
            opacity: 0.9,
            closeOnClick: true,
            autoClose: true,
            showCloseButton: false,
            template: (type == 1) ? 'success' : 'error'
        }
    };
    $scope.menuitemNotificationsSuccessSettings = setNotificationInit(1);
    $scope.menuitemNotificationsErrorSettings = setNotificationInit(0);

    $scope.closeItemGridWindows = function(option) {
        if(option != undefined) {
            $('#mainButtonsOnItemGrid').show();
            $('#promptToCloseItemGrid').hide();
        }
        if (option == 0) {
            $scope.saveItemGridBtn();
        } else if (option == 1) {
            itemsMenuWindow.close();
        }
        else if (option == 2) {}
        else {
            if ($('#saveItemGridBtn').is(':disabled')) {
                itemsMenuWindow.close();
            }
            else {
                $('#promptToCloseItemGrid').show();
                $('#mainButtonsOnItemGrid').hide();
            }
        }

    };

    $scope.saveItemGridBtn = function() {
        var data = {
            'MenuCategoryUnique': $scope.itemCellSelectedOnGrid.MenuCategoryUnique,
            'Row': $scope.itemCellSelectedOnGrid.Row,
            'Column': $scope.itemCellSelectedOnGrid.Column,
            'ItemUnique': $('#editItem_ItemSelected').jqxComboBox('getSelectedItem').value,
            'Status': $('#editItem_Status').jqxDropDownList('getSelectedItem').value,
            'Label': $('#editItem_label').val(),
        };
        if ($('#editItem_sort').val() != '') {
            data['sort'] = $('#editItem_sort').val();
        }

        $.ajax({
            'url': SiteRoot + 'admin/MenuItem/postMenuItems',
            'method': 'post',
            'data': data,
            'dataType': 'json',
            'success': function(data) {
                drawExistsItemsOnGrid();
                $('#menuitemNotificationsSuccessSettings #notification-content')
                    .html('Menu item was updated successfully!');
                $scope.menuitemNotificationsSuccessSettings.apply('open');
                setTimeout(function() {
                    itemsMenuWindow.close();
                }, 2000);
            }
        });

    };

    $scope.deleteItemGridBtn = function() {
        var data = {
            'MenuCategoryUnique': $scope.itemCellSelectedOnGrid.MenuCategoryUnique,
            'Row': $scope.itemCellSelectedOnGrid.Row,
            'Column': $scope.itemCellSelectedOnGrid.Column,
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
        var idsRestricted = ['editItem_sort'];
        var inarray = $.inArray($(this).attr('id'), idsRestricted);
        if (inarray >= 0) {
            var charCode = (e.which) ? e.which : e.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            $('#saveItemGridBtn').prop('disabled', false);
            return true;
        } else {
            $('#saveItemGridBtn').prop('disabled', false);
        }
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
                    'Column': $this.data('col'),
                    'Row': $this.data('row')
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
                        //console.log($('#editItem_ItemSelected').jqxComboBox('getItem', selectedIndexItem).label);

                        var label = (data['Label'] == '' || data['Label'] == null)
                                    ? $('#editItem_ItemSelected').jqxComboBox('getItem', selectedIndexItem).label
                                    : data['Label'];
                        $('#editItem_label').val(label);
                        $('#editItem_sort').val((data['sort']) == '' || data['sort'] == null ? 1 : data['sort']);
                        //
                        $('#saveItemGridBtn').prop('disabled', true);
                        itemWindow.setTitle(
                            'Edit Menu Item: ' + data.Unique + ' | Item: ' + data.ItemUnique + ' | Label: ' + label);
                        itemWindow.open();
                    }
                });
            }
        });
    }

    /**
     * -- DRAGGABLE EVENTS
     */
    // ---- DRAG ITEMS ON ABOVE GRID FOR Selected item from combobox
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
                    'Label': $scope.selectedItemInfo.Description,
                    'Row': $(event.args.target).data('row'),
                    'Column': $(event.args.target).data('col'),
                    'Status': 1,
                    'sort': 1
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
                        //console.log('onTargetDrop', data);
                    },
                    dropAction: 'none',
                    //revert: true
                }
            )
            .bind('dragStart', function (event) {
                //$(this).removeClass('draggable');
                //$(this).jqxDragDrop( { dropTarget: $('.draggable').not($(this)) } );
                $(this).jqxDragDrop( { dropTarget: $('div[id^="draggable-"]').not($(this)) } );
            })
            .bind('dragEnd', function (event) {
                //$(this).addClass('draggable');
                if (onCellAboveGrid) {
                    if (!isEqual($scope.onGridTargetMoved, $scope.onGridElementMoved)) {
                        var data = {
                          'element': $scope.onGridElementMoved,
                          'target': $scope.onGridTargetMoved
                        };
                        var current = $('.restricter-dragdrop .draggable[data-col="' + $scope.onGridElementMoved.Column+ '"][data-row="' + $scope.onGridElementMoved.Row + '"]');
                        var target = $('.restricter-dragdrop .draggable[data-col="' + $scope.onGridTargetMoved.Column+ '"][data-row="' + $scope.onGridTargetMoved.Row + '"]');

                        $.ajax({
                            'url': SiteRoot + 'admin/MenuItem/setNewPosition/' + $scope.selectedCategoryInfo.Unique,
                            'method': 'POST',
                            'data': data,
                            'success': function(data) {
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
                                    angular.element('.category-cell-grid.clicked').triggerHandler('click');
                                }, 100);
                            }

                        });
                    }

                }
            })
            .bind('dropTargetEnter', function (event) {
                onCellAboveGrid = true;
                var target_col = $(event.args.target).data('col');
                var element_col = $(event.args.element).data('col');
                var target_row = $(event.args.target).data('row');
                var element_row = $(event.args.element).data('row');
                $scope.onGridTargetMoved = {'Column': target_col, 'Row': target_row};
                $scope.onGridElementMoved = {'Column': element_col, 'Row': element_row};
            })
            .bind('dropTargetLeave', function (event) {
                onCellAboveGrid = false;
            });

            // Helper: Object.isEqual(OtherObject)
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