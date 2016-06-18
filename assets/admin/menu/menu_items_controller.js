/**
 * Created by carlosrenato on 05-19-16.
 */

app.controller('menuItemController', function ($scope, $rootScope, $http) {

    // -- MenuCategoriesTabs Main Tabs
    $('#MenuCategoriesTabs').on('tabclick', function (e) {
        var tabclicked = e.args.item;
        // ITEMS TAB - Reload queries
        if (tabclicked == 2) {
            $scope.menuListBoxSettings.apply('refresh');
            $('.draggable').removeClass('selectedItemOnGrid');
            $('#NewMenuItemBtn').prop('disabled', true)
        }
    });

    $('#jqxTabsMenuItemSection').on('selecting', function(e) {
        var tabclicked = e.args.item;
        // ITEMS SUBTAB
        if (tabclicked == 1) {
            setTimeout(function(){
                $('#itemListboxSearch .jqx-listbox-filter-input').focus();
            }, 100);
        }
    });

    $('#jqxTabsMenuItemWindows').on('tabclick', function(e) {
        var tabclicked = e.args.item;
        if (tabclicked == 0) {
            $('#deleteItemGridBtn').show();
        } else {
            $('#deleteItemGridBtn').hide();
            if($scope.itemCellSelectedOnGrid != null) {
                $scope.$apply(function() {
                    updateQuestionItemTable();
                });
            }
        }
    });

    var itemsMenuWindow;
    $scope.itemsMenuWindowsSetting = {
        created: function (args) {
            itemsMenuWindow = args.instance;
        },
        resizable: false,
        width: "60%", height: "70%",
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
        height: "450px",
        theme: 'arctic'
    };

    $scope.categoriesByMenu = [];
    $scope.menuListBoxSelecting = function (e) {
        $('.category-cell-grid').removeClass('clicked');
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
                    if ($scope.menuSelectedWithCategories.categories[k]['Row'] == i
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
    $scope.clickCategoryCell = function (e, row) {
        if (row == null) {
            return;
        }
        $('#NewMenuItemBtn').prop('disabled', true);
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
        for (var i = 0; i < $scope.grid.rows; i++) {
            var template = '';
            template += '<div class="row">';
            if (diff % 1 !== 0) {
                template += '<div class="col-md-offset-1 col-sm-offset-1"></div>';
            }
            for (var j = 0; j < $scope.grid.cols; j++) {
                var num = j + 1 + (i * $scope.grid.cols);
                template += '<div class="draggable col-md-' + round + ' col-sm-' + round +
                    '" id="draggable-' + num + '" data-col="' + (j + 1) + '" data-row="' + (i + 1) + '">' +
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
            'success': function (data) {
                $.each(data, function (i, el) {
                    var cell = $('body .restricter-dragdrop .draggable[data-col="' + el.Column + '"][data-row="' + el.Row + '"]');
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
                        cell.html((el.Label == null || el.Label == '') ? el.Description : el.Label);
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
    var dataAdapterItems = function(sort) {
        return new $.jqx.dataAdapter(
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
                url: SiteRoot + 'admin/MenuItem/load_allItems?sort=' + sort
            }
        );
    };

    $scope.itemsComboboxSettings = {
        created: function (args) {
            comboboxItems = args.instance;
        },
        placeHolder: 'Select an item',
        displayMember: "Description",
        valueMember: "Unique",
        width: "100%",
        itemHeight: 50,
        //height: '100%',
        //height: 300,
        source: dataAdapterItems('ASC'),
        theme: 'arctic'
    };

    $scope.itemsComboboxSelecting = function(e) {
        var item = e.args.item.originalItem;
        $('#editItem_label').val(item.Description);
    };

    $scope.itemsListboxSettings =
    {
        created: function (args) {
            comboboxItems = args.instance;
        },
        selectedIndex: -1, // 0
        //placeHolder: 'Select an item',
        displayMember: "Description",
        valueMember: "Unique",
        width: "100%",
        //itemHeight: 50,
        height: '450px',
        source: dataAdapterItems('ASC'),
        theme: 'arctic',
        filterable: true,
        filterHeight: 40,
        filterPlaceHolder: 'Looking for item',
        //allowDrop: true,
        //allowDrag: true,
        //dragEnd: function(dragItem, dropItem) {}
    };

    //$('#itemListboxSearch').on('dragEnd', function(e){
    //    console.log(e);
    //    if (e.args.label) {
    //        var ev = e.args.originalEvent;
    //        var x = ev.pageX;
    //        var y = ev.pageY;
    //        if (e.args.originalEvent
    //            && e.args.originalEvent.originalEvent
    //            && e.args.originalEvent.originalEvent.touches) {
    //            var touch = e.args.originalEvent.originalEvent.changedTouches[0];
    //            x = touch.pageX;
    //            y = touch.pageY;
    //        }
    //        var offset = $(".restricter-dragdrop").offset();
    //        var width = $(".restricter-dragdrop").width();
    //        var height = $(".restricter-dragdrop").height();
    //        var right = parseInt(offset.left) + width;
    //        var bottom = parseInt(offset.top) + height;
    //        if (x >= parseInt(offset.left) && x <= right) {
    //            if (y >= parseInt(offset.top) && y <= bottom) {
    //                console.log('IN');
    //                //$("#textarea").val(event.args.label);
    //            }
    //            else {
    //                console.log('OUT');
    //            }
    //        }
    //    }
    //});

    $scope.selectedItemInfo = {};
    $scope.itemListBoxOnSelect = function(e) {
        var args = e.args.item.originalItem;

        $scope.selectedItemInfo = args;
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
            //$('.RowOptionButtonsOnItemGrid').hide();
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

    var validationDataOnItemGrid = function() {
        var needValidation = false;
        $('.editItemFormContainer .required-field').each(function(i, el) {
            if (el.value == '') {
                needValidation = true;
                $('#menuitemNotificationsErrorSettings #notification-content')
                    .html($(el).attr('placeholder') + ' can not be empty!');
                $scope.menuitemNotificationsErrorSettings.apply('open');
                $(el).css({"border-color": "#F00"});
            } else {
                $(el).css({"border-color": "#CCC"});
            }
        });

        var itemCombo = $('#editItem_ItemSelected');
        if (!itemCombo.jqxComboBox('getSelectedItem')) {
            needValidation = true;
            $('#menuitemNotificationsErrorSettings #notification-content')
                .html('You must select an item');
            $scope.menuitemNotificationsErrorSettings.apply('open');
            itemCombo.css({"border-color": "#F00"});
        } else {
            itemCombo.css({"border-color": "#CCC"});
        }

        return needValidation;
    };

    $scope.saveItemGridBtn = function() {
        if (!validationDataOnItemGrid()) {
            var data = {
                'MenuCategoryUnique': $scope.itemCellSelectedOnGrid.MenuCategoryUnique,
                'Row': $('#editItem_Row').val(),
                //'Row': $scope.itemCellSelectedOnGrid.Row,
                'Column': $('#editItem_Column').val(),
                //'Column': $scope.itemCellSelectedOnGrid.Column,
                'ItemUnique': $('#editItem_ItemSelected').jqxComboBox('getSelectedItem').value,
                'Status': $('#editItem_Status').jqxDropDownList('getSelectedItem').value,
                'Label': $('#editItem_label').val(),
                //
                'posRow': $scope.itemCellSelectedOnGrid.Row,
                'posCol': $scope.itemCellSelectedOnGrid.Column
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
                    if (data.status == 'success') {
                        //drawExistsItemsOnGrid();
                        setTimeout(function() {
                            angular.element('.category-cell-grid.clicked').triggerHandler('click');
                        }, 100);
                        $('#menuitemNotificationsSuccessSettings #notification-content')
                            .html('Menu item was updated successfully!');
                        $scope.menuitemNotificationsSuccessSettings.apply('open');
                        setTimeout(function() {
                            itemsMenuWindow.close();
                        }, 2000);
                        updateQuestionItemTable();
                    } else if (data.status == 'error') {
                        $.each(data.message, function(i, value){
                            $('#menuitemNotificationsErrorSettings #notification-content')
                                .html(value);
                            $scope.menuitemNotificationsErrorSettings.apply('open');
                        });
                    } else {
                        console.log('Error from ajax');
                    }
                }
            });
        }

    };

    $scope.deleteItemGridBtn = function(option) {
        if (option == 0) {
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
                    //drawExistsItemsOnGrid();
                    setTimeout(function() {
                        angular.element('.category-cell-grid.clicked').triggerHandler('click');
                    }, 100);
                    itemsMenuWindow.close();
                }
            });
            $('#mainButtonsOnItemGrid').show();
            $('.RowOptionButtonsOnItemGrid').hide();
        } else if (option == 1) {
            $('#mainButtonsOnItemGrid').show();
            $('.RowOptionButtonsOnItemGrid').hide();
            itemsMenuWindow.close();
        } else if (option == 2) {
            $('#mainButtonsOnItemGrid').show();
            $('.RowOptionButtonsOnItemGrid').hide();
        } else {
            //if ($('#saveItemGridBtn').is(':disabled')) {
            //    itemsMenuWindow.close();
            //}
            //else {
            $('#mainButtonsOnItemGrid').hide();
            $('.RowOptionButtonsOnItemGrid').hide();
            $('#promptToDeleteItemGrid').show();
            //}

        }
    };

    // Events item form controls
    $('.editItemFormContainer .required-field')
        .on('keypress keyup paste change', function (e) {
        var idsRestricted = ['editItem_sort', 'editItem_Row', 'editItem_Column'];
        var inarray = $.inArray($(this).attr('id'), idsRestricted);
        if (inarray >= 0) {
            var charCode = (e.which) ? e.which : e.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57 || charCode == 46)) {
                $('#menuitemNotificationsErrorSettings #notification-content')
                    .html('Row, Column and Sort values must be numbers!');
                $scope.menuitemNotificationsErrorSettings.apply('open');
                return false;
            }
            if (this.value.length > 2) {
                return false;
            }
        }
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
        $('.draggable')
            .on('dblclick', function(e) {
            $('#promptToCloseItemGrid').hide();
            $('#mainButtonsOnItemGrid').show();
            $('#jqxTabsMenuItemWindows').jqxTabs({selectedItem: 0});
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
                        $('#editItem_Row').val(data.Row);
                        $('#editItem_Column').val(data.Column);
                        //
                        $('#saveItemGridBtn').prop('disabled', true);
                        $('#deleteItemGridBtn').show();

                        itemWindow.setTitle(
                            'Edit Menu Item: ' + data.Unique + ' | Item: ' + data.ItemUnique + ' | Label: ' + label);
                        itemWindow.open();
                    }
                });
            }
        })
        .on('click', function(e) {
            $('.draggable').removeClass('selectedItemOnGrid');
            $(this).addClass('selectedItemOnGrid');
            var isOccupied = $(this).hasClass('filled');
            $('#NewMenuItemBtn').prop('disabled', isOccupied);

        });
    }

    var resetMenuItemForm = function() {
        var itemCombo, selectedIndexItem;
            itemCombo = $('#editItem_ItemSelected').jqxComboBox('getItemByValue', $scope.selectedItemInfo.Unique);
        if (itemCombo != undefined) {
            selectedIndexItem = itemCombo.index | -1;
        } //else selectedIndexItem = 0;
        $('#editItem_ItemSelected').jqxComboBox({'selectedIndex': selectedIndexItem});
        $('#editItem_Status').jqxDropDownList({'selectedIndex': 0});
        //$('#editItem_label').val('');
        $('#editItem_sort').val(1);
        $('#editItem_Row').val('');
        $('#editItem_Column').val('');
        //
        $('#saveItemGridBtn').prop('disabled', true);
    };

    $scope.newMenuItemBtn = function() {
        var selectedItem = $('body .draggable.selectedItemOnGrid');
        var row = selectedItem.data('row');
        var col = selectedItem.data('col');
        resetMenuItemForm();
        $scope.itemCellSelectedOnGrid = {
            'MenuCategoryUnique': $scope.selectedCategoryInfo.Unique,
            'Row': row,
            'Column': col
        };
        $('#editItem_Row').val(row);
        $('#editItem_Column').val(col);

        $('#deleteItemGridBtn').hide();
        $('#NewMenuItemBtn').prop('disabled', false);
        $('#saveItemGridBtn').prop('disabled', false);
        itemsMenuWindow.setTitle('Add New Menu Item');
        itemsMenuWindow.open();
    };

    /**
     * -- DRAGGABLE EVENTS
     */
    // ---- DRAG ITEMS ON ABOVE GRID FOR Selected item from combobox
    function selectedItemEvents () {

        $('#selectedItemInfo, #itemListboxSearch .jqx-listitem-element').jqxDragDrop(
            {
                dropTarget: $('body .draggable'),
                //restricter:'parent',
                //tolerance: 'fit',
                revert: true,
                opacity: 0.9
            }
        );

        var ItemOnAboveGrid = false;
        $('#selectedItemInfo, .jqx-listitem-element')
        .bind('dragStart', function (event) {
            $('.restricter-dragdrop').css({'border': '#202020 dotted 3px'});
        })
        .bind('dragEnd', function (event) {
            $('.restricter-dragdrop').css({'border': '#202020 solid 2px'});
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
                        }
                        else if (data.status == 'error') {
                            $.each(data.message, function(i, value){
                                //alert(value);
                            });
                        }
                        else {
                            console.log('error from ajax');
                        }
                    }
                });
            }
        })
        .bind('dropTargetEnter', function (event) {
            ItemOnAboveGrid = true;
        })
        .bind('dropTargetLeave', function (event) {
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
            .bind('dragging', function (event) {
                //console.log(event);
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

    /**
     * QUESTION TAB ACTIONS
     */
    $scope.questionTableOnMenuItemsSettings = {
        source: {
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'int'},
                {name: 'ItemUnique', type: 'int'},
                {name: 'QuestionUnique', type: 'int'},
                {name: 'Status', type: 'number'},
                {name: 'Sort', type: 'number'},
            ],
            id: 'Unique',
            url: SiteRoot + 'admin/MenuItem/load_itemquestions'
        },
        columns: [
            {text: 'ID', dataField: 'Unique', type: 'int'},
            {text: 'Item', dataField: 'ItemUnique', type: 'int'},
            {text: 'Question', dataField: 'QuestionUnique', type: 'int'},
            {text: 'Status', dataField: 'Status', type: 'number', hidden: true},
            {text: 'Sort', dataField: 'Sort', type: 'number'},
        ],
        columnsResize: true,
        width: "99.7%",
        theme: 'arctic',
        sortable: true,
        pageable: true,
        pageSize: 15
        //pagerMode: 'default',
        //altRows: true,
        //filterable: true,
        //filterMode: 'simple'
    };

    var updateQuestionItemTable = function() {
        $scope.questionTableOnMenuItemsSettings = {
            source: {
                dataType: 'json',
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'ItemUnique', type: 'int'},
                    {name: 'QuestionUnique', type: 'int'},
                    {name: 'QuestionName', type: 'string'},
                    {name: 'ItemName', type: 'string'},
                    {name: 'Status', type: 'number'},
                    {name: 'StatusName', type: 'string'},
                    {name: 'Sort', type: 'number'},
                ],
                id: 'Unique',
                url: SiteRoot + 'admin/MenuItem/load_itemquestions/' + $scope.itemCellSelectedOnGrid.ItemUnique
            },
            columns: [
                {text: 'ID', dataField: 'Unique', type: 'int'},
                {text: 'Item', dataField: 'ItemUnique', type: 'int', hidden: true},
                {text: 'Item', dataField: 'ItemName', type: 'string'},
                {text: 'Question', dataField: 'QuestionUnique', type: 'int', hidden: true},
                {text: 'Question', dataField: 'QuestionName', type: 'string'},
                {text: 'Status', dataField: 'Status', type: 'number', hidden: true},
                {text: 'Status', dataField: 'StatusName', type: 'string'},
                {text: 'Sort', dataField: 'Sort', type: 'number'}
            ],
            created: function (args) {
                args.instance.updateBoundData();
            }
        }
    };

    $scope.qitemNotificationsSuccessSettings = setNotificationInit(1);
    $scope.qitemNotificationsErrorSettings = setNotificationInit(0);

    var questionOnItemGridWindow, cbxQuestionsItem;
    $scope.questionOnItemGridWindowSettings = {
        created: function (args) {
            questionOnItemGridWindow = args.instance;
        },
        resizable: false,
        width: "40%", height: "40%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    var dataAdapterQuestionItems = new $.jqx.dataAdapter(
        {
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'int'},
                {name: 'QuestionName', type: 'string'},
                {name: 'Question', type: 'string'},
                {name: 'Status', type: 'number'},
                {name: 'Sort', type: 'number'}
            ],
            id: 'Unique',
            url: SiteRoot + 'admin/MenuQuestion/load_allquestions'
        }
    );

    $scope.questionItemsCbxSettings = {
        created: function (args) {
            cbxQuestionsItem = args.instance;
        },
        placeHolder: 'Select a question',
        displayMember: "QuestionName",
        valueMember: "Unique",
        width: "100%",
        itemHeight: 30,
        source: dataAdapterQuestionItems,
        theme: 'arctic'
    };

    $('#itemq_Status').jqxDropDownList({autoDropDownHeight: true});

    // Events questions item form
    $('#itemq_Status, #itemq_Question').on('select', function() {
        $('#saveQuestionItemBtn').prop('disabled', false);
    });

    $('.itemqFormContainer .required-qitem').on('keypress keyup paste change', function (e) {
        var idsRestricted = ['itemq_Sort'];
        var inarray = $.inArray($(this).attr('id'), idsRestricted);
        if (inarray >= 0) {
            var charCode = (e.which) ? e.which : e.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57 || charCode == 46)) {
                if (this.val == '') {
                    $('#qitemNotificationsErrorSettings #notification-content')
                        .html('Sort value must be number');
                    $scope.qitemNotificationsErrorSettings.apply('open');
                    $(this).css({'border-color': '#F00'});
                }
                return false;
            }
            if (this.value.length > 2) {
                return false;
            }
        }
        $('#saveQuestionItemBtn').prop('disabled', false);
    });

    $scope.addOrEditqItem = null;
    $scope.qItemIdChosen = null;
    $scope.openQuestionItemWin = function() {
        //
        $('#itemq_Status').jqxDropDownList({'selectedIndex': 0});
        $('#itemq_Question').jqxComboBox({'selectedIndex': -1});
        $('#itemq_Sort').val(1);
        //
        $('#saveQuestionItemBtn').prop('disabled', true);
        $('#deleteQuestionItemBtn').hide();
        $scope.addOrEditqItem = 'create';
        questionOnItemGridWindow.setTitle('Add New Question | Item: ' + $scope.itemCellSelectedOnGrid.ItemUnique);
        questionOnItemGridWindow.open();
    };

    $scope.editQuestionItemWin = function(e) {
        var row = e.args.row;
        var statusCombo = $('#itemq_Status').jqxDropDownList('getItemByValue', row.Status);
        $('#itemq_Status').jqxDropDownList({'selectedIndex': statusCombo.index});

        var selectedIndexItem;
        var itemCombo = $('#itemq_Question').jqxComboBox('getItemByValue', row.QuestionUnique);
        if (itemCombo != undefined) {
            selectedIndexItem = itemCombo.index | 0;
        }
        $('#itemq_Question').jqxComboBox({'selectedIndex': selectedIndexItem});

        $('#itemq_Sort').val(row.Sort);
        //
        $('#saveQuestionItemBtn').prop('disabled', true);
        $('#deleteQuestionItemBtn').show();
        $scope.addOrEditqItem = 'edit';
        $scope.qItemIdChosen = row.Unique;
        questionOnItemGridWindow.setTitle('Edit Question: ' + row.QuestionUnique +' | Item: ' + row.ItemUnique);
        questionOnItemGridWindow.open();
    };

    $scope.closeQuestionItemWin = function (option) {
        //questionOnItemGridWindow.close();
        if(option != undefined) {
            $('#mainButtonsQitem').show();
            $('#promptToCloseQitem').hide();
            //$('.RowOptionButtonsOnItemGrid').hide();
        }
        if (option == 0) {
            $scope.saveQuestionItem();
        } else if (option == 1) {
            questionOnItemGridWindow.close();
        }
        else if (option == 2) {}
        else {
            if ($('#saveQuestionItemBtn').is(':disabled')) {
                questionOnItemGridWindow.close();
            }
            else {
                $('#promptToCloseQitem').show();
                $('#mainButtonsQitem').hide();
            }
        }
    };

    var validationQuestionItemForm = function() {
        var needValidation = false;
        if (!$('#itemq_Question').jqxComboBox('getSelectedItem')) {
            needValidation = true;
            $('#qitemNotificationsErrorSettings #notification-content')
                .html('Select a question');
            $scope.qitemNotificationsErrorSettings.apply('open');
            $('#itemq_Question').css({'border-color': '#F00'});
        } else {
            $('#itemq_Question').css({'border-color': '#CCC'});
        }
        $('.required-qitem').each( function(i, el) {
            if (el.value == '') {
                needValidation = true;
                $('#qitemNotificationsErrorSettings #notification-content')
                    .html($(el).attr('placeholder') + ' can not be empty!');
                $scope.qitemNotificationsErrorSettings.apply('open');
                $(el).css({'border-color': '#F00'});
            } else {
                $(el).css({'border-color': '#CCC'});
            }
        });

        return needValidation;
    };

    $scope.saveQuestionItem = function() {
        if (!validationQuestionItemForm()) {
            var data = {
                'QuestionUnique': $('#itemq_Question').jqxComboBox('getSelectedItem').value,
                'Status': $('#itemq_Status').jqxDropDownList('getSelectedItem').value,
                'Sort': $('#itemq_Sort').val(),
                'ItemUnique': $scope.itemCellSelectedOnGrid.ItemUnique
            };
            var url, msg;
            if ($scope.addOrEditqItem == 'create') {
                url = 'admin/MenuItem/postQuestionMenuItems';
            } else if($scope.addOrEditqItem == 'edit') {
                url = 'admin/MenuItem/updateQuestionMenuItems/' + $scope.qItemIdChosen;
            }
            $.ajax({
                'method': 'POST',
                'url': SiteRoot + url,
                'dataType': 'json',
                'data': data,
                'success': function(data) {
                    if (data.status == 'success') {
                        if ($scope.addOrEditqItem == 'create') {
                            msg = 'Question saved successfully!';
                        } else {
                            msg = 'Question was updated successfully!';
                        }
                        $('#qitemNotificationsSuccessSettings #notification-content')
                            .html(msg);
                        $scope.qitemNotificationsSuccessSettings.apply('open');
                        setTimeout(function(){
                            questionOnItemGridWindow.close();
                        }, 2000);
                        updateQuestionItemTable();
                    } else if (data.status == 'error') {
                        $('#qitemNotificationsErrorSettings #notification-content')
                            .html('There was an error');
                        $scope.qitemNotificationsErrorSettings.apply('open');
                    }
                    else {
                        console.info('Ajax error');
                    }

                }
            });
        }
    };

    $scope.deleteQuestionItem = function(option) {
        if (option == 0) {
            $.ajax({
                'url': SiteRoot + 'admin/MenuItem/deleteQuestionMenuItems/' + $scope.qItemIdChosen,
                'method': 'post',
                'dataType': 'json',
                'success': function (data) {
                    if (data.status == 'success') {
                        updateQuestionItemTable();
                        questionOnItemGridWindow.close();
                        $('#mainButtonsQitem').show();
                        $('#promptToCloseQitem').hide();
                        $('#promptToDeleteQItem').hide();
                    } else if (data.status == 'error') {
                        $('#qitemNotificationsErrorSettings #notification-content')
                            .html('There was an error');
                        $scope.qitemNotificationsErrorSettings.apply('open');
                    }
                    else {
                        console.info('Ajax error');
                    }
                }
            });
        } else if (option == 1) {
            $('#mainButtonsQitem').show();
            $('#promptToCloseQitem').hide();
            $('#promptToDeleteQItem').hide();
            questionOnItemGridWindow.close();
        } else if (option == 2) {
            $('#mainButtonsQitem').show();
            $('#promptToCloseQitem').hide();
            $('#promptToDeleteQItem').hide();
        } else {
            $('#mainButtonsQitem').hide();
            $('#promptToCloseQitem').hide();
            $('#promptToDeleteQItem').show();
        }
    };

});