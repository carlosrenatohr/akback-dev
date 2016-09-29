/**
 * Created by carlosrenato on 05-19-16.
 */

app.controller('menuItemController', function ($scope, $rootScope, $http, inventoryExtraService) {

    // -- MenuCategoriesTabs Main Tabs
    $('#MenuCategoriesTabs').on('tabclick', function (e) {
        var tabclicked = e.args.item;
        var tabTitle = $('#MenuCategoriesTabs').jqxTabs('getTitleAt', tabclicked);
        // ITEMS TAB - Reload queries
        if (tabTitle == 'Layout') {
            updateQuestionsCbx();
            $('#itemListboxSearch').jqxListBox('refresh');
            $('#itemListboxSearch .jqx-listbox-filter-input').val('');
            $('#menuListDropdown').jqxDropDownList({source: dataAdapterMenu });
            $('#menuListDropdown').jqxDropDownList({selectedIndex: 0 });
            // Redraw grid
            $('.draggable').removeClass('selectedItemOnGrid');
            //$('.category-cell-grid').removeClass('valued');

            $('#NewMenuItemBtn').prop('disabled', true)
        }
    });

    $('#jqxTabsMenuItemWindows').on('selecting', function(e) { // tabclick
        var tabclicked = e.args.item;
        var tabTitle = $('#jqxTabsMenuItemWindows').jqxTabs('getTitleAt', tabclicked);
        // ---
        if (tabclicked != 0) {
            $('#deleteItemGridBtn').hide();
            $('#editItem_ItemSelected').jqxComboBox({disabled: false});
        } else {
            $('#deleteItemGridBtn').show();
            $('#editItem_ItemSelected').jqxComboBox({disabled: true});
        }
        // ---
        if (tabTitle == 'Printers') {
            // Fill all printers
            if (allPrintersArray == '') {
                var rows = $("#printerItemList").jqxDropDownList('getItems');
                for(var j in rows) {
                    allPrintersArray.push(rows[j]['value']);
                }
            }
            updatePrinterItemGrid();
        } else if (tabTitle == 'Questions'){
            //
            //if ($scope.countChangesOnSelectingItemCbx > 1) {
            //    e.cancel = true;
            //    $('#promptToCloseItemGrid').show();
            //    $('#mainButtonsOnItemGrid').hide();
            //    $scope.tryToChangeQuestionTab = true;
            //} else {
                e.cancel = false;
                //
                //if ($scope.changingItemOnSelect != null) {
                    updateQuestionItemTable();
                //}
            //}
        }
    });

    var itemsMenuWindow;
    $scope.itemsMenuWindowsSetting = {
        created: function (args) {
            itemsMenuWindow = args.instance;
        },
        resizable: false,
        width: "65%", height: "75%",
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
                {name: 'ItemLength', type: 'number'},
                {name: 'CategoryName', type: 'string'},
                {name: 'categories', type: 'json'}
            ],
            //id: 'Unique',
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

    $scope.menudropdownSettings =
    {
        source: dataAdapterMenu,
        placeHolder: 'Select a Menu',
        displayMember: "MenuName",
        valueMember: "Unique",
        width: '100%',
        height: "25px",
        theme: 'arctic',
        bindingComplete: function() {
            $('#menuListDropdown').jqxDropDownList({selectedIndex: 0 });
            setTimeout(function(){
                $('#itemListboxSearch .jqx-listbox-filter-input').focus();
            }, 250);
        }
    };

    $scope.categoriesByMenu = [];
    $scope.menuListBoxSelecting = function (e) {
        $('.category-cell-grid').removeClass('clicked');
        var row = e.args.item.originalItem;
        $scope.categoriesByMenu = row.categories;
        $scope.menuSelectedWithCategories = row;
        //console.log($scope.menuSelectedWithCategories);

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
        var diff = (12 / $scope.menuSelectedWithCategories.Column);
        var round = Math.round(12 / $scope.menuSelectedWithCategories.Column);
        $scope.menuSelectedWithCategories.grid = {
            cols: $scope.menuSelectedWithCategories.Column,
            rows: $scope.menuSelectedWithCategories.Row,
            diff: (diff),
            round: (round)
        };
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
        var strechedClass = (($scope.grid.cols % 2) != 0) ? ('streched' + $scope.grid.cols) : '';
        for (var i = 0; i < $scope.grid.rows; i++) {
            var template = '';
            template += '<div class="row">';
            if (diff % 1 !== 0) {
                template += '<div class="col-md-offset-1 col-sm-offset-1"></div>';
            }
            for (var j = 0; j < $scope.grid.cols; j++) {
                var num = j + 1 + (i * $scope.grid.cols);
                template += '<div class="draggable col-md-' + round + ' col-sm-' + round + ' ' +
                    strechedClass + '" id="draggable-' + num + '" data-col="' + (j + 1) + '" data-row="' + (i + 1) + '">' +
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
        //$('#jqxTabsMenuItemSection').jqxTabs('select', 1);
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
                        //cell.css('background-color', (el.Status == 1) ? '#063dee' : '#06b1ee');
                        cell.css('background-color', (el.Status == 1) ? '#7C2F3F' : '#752253');
                        cell.addClass((el.Status != 1) ? 'disabled-cell' : '');
                        cell.addClass('filled');
                        cell.addClass('itemOnGrid');
                        cell.data('categoryId', el.MenuCategoryUnique);
                        var label = (el.Label == null || el.Label == '') ? el.Description : el.Label;
                        cell.html("<div class='priceContent'>"+el.SellPrice +"</div><div class='labelContent'>"+ label + "</div>");
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
        if (e.args.item != null) {
            var item = e.args.item.originalItem;
            var description = item.Description;
            if ($scope.itemLengthOfMenuSelected != null)
                description = description.substring(0, $scope.itemLengthOfMenuSelected);
            $('#editItem_label').val(description);
        }
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
        height: '460px',
        source: dataAdapterItems('ASC'),
        theme: 'arctic',
        filterable: true,
        filterHeight: 30,
        searchMode: 'containsignorecase',
        filterPlaceHolder: 'Looking for item',
        //allowDrop: true,
        //allowDrag: true,
        //dragEnd: function(dragItem, dropItem) {}
    };

    $scope.selectedItemInfo = {};
    $scope.itemListBoxOnSelect = function(e) {
        var _args = e.args.item.originalItem;

        $scope.selectedItemInfo = _args;
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
        // --REMOVING HIGHLIGHTED from selected item cell
        //$('#NewMenuItemBtn').prop('disabled', true);
        //$('.draggable').css({'border': 'solid black 1px'});
        if(option != undefined) {
            $('#mainButtonsOnItemGrid').show();
            $('#promptToCloseItemGrid').hide();
            //$('.RowOptionButtonsOnItemGrid').hide();
        }
        if (option == 0) {
            if ($scope.tryToChangeQuestionTab) {
                $scope.saveItemGridBtn();
                $scope.settingTab(1);
                $('#mainButtonsOnItemGrid').show();
                $('#promptToCloseItemGrid').hide();
            } else {
                $scope.saveItemGridBtn(true);
            }
        } else if (option == 1) {
            if (!$scope.tryToChangeQuestionTab) {
                itemsMenuWindow.close();
                //$scope.tryToChangeQuestionTab = false;
            }
            $scope.tryToChangeQuestionTab = false;
            $scope.countChangesOnSelectingItemCbx = 1;
            $scope.changingItemOnSelect = null;
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

    $scope.settingTab = function(tab) {
        $.ajax({
            'method': 'get',
            url: SiteRoot + 'admin/MenuItem/load_itemquestions/' + $scope.changingItemOnSelect.Unique,
            success: function() {;
                $scope.$apply(function(){
                    $scope.tryToChangeQuestionTab = false;
                    $scope.countChangesOnSelectingItemCbx = 1;
                });
                $('#jqxTabsMenuItemWindows').jqxTabs({selectedItem:tab});
                //
                //var selectedIndexItem;
                //var itemCombo = $('#editItem_ItemSelected').jqxComboBox('getItemByValue', $scope.itemCellSelectedOnGrid.ItemUnique);
                //if (itemCombo != undefined) {
                //    selectedIndexItem = itemCombo.index | 0;
                //} else selectedIndexItem = 0;
                //    $('#editItem_ItemSelected').jqxComboBox({'selectedIndex': selectedIndexItem});
            }
        });
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
        // Restriction label length: Menu.ItemLength
        if ($scope.itemLengthOfMenuSelected != null) {
            var labelField = $('.editItemFormContainer #editItem_label');
            if ($scope.itemLengthOfMenuSelected > labelField.val().length) {
                needValidation = true;
                $('#menuitemNotificationsErrorSettings #notification-content')
                    .html('You have exceeded limit of characters!');
                $scope.menuitemNotificationsErrorSettings.apply('open');
                labelField.css({"border-color": "#F00"});
            } else
                labelField.css({"border-color": "#CCC"});
        }

        return needValidation;
    };
    $scope.disabledControl = true;
    $scope.saveItemGridBtn = function(fromPrompt) {
        if (!validationDataOnItemGrid()) {
            var idxSelected = $('#editItem_ItemSelected').jqxComboBox('getSelectedItem').index;
            var dataToSend = {
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
                'posCol': $scope.itemCellSelectedOnGrid.Column,
                // ---- Item Values to save
                'extraValues': {
                    // Prices Values
                    //'ListPrice': parseFloat($('#menuitem_listPrice').val()),
                    //'price1': parseFloat($('#menuitem_price1').val()),
                    'ListPrice': parseFloat($('#itemcontrol_lprice').val()),
                    'price1': parseFloat($('#itemcontrol_sprice').val()),
                    'price2': parseFloat($('#menuitem_price2').val()),
                    'price3': parseFloat($('#menuitem_price3').val()),
                    'price4': parseFloat($('#menuitem_price4').val()),
                    'price5': parseFloat($('#menuitem_price5').val()),
                    // Extra Values
                    'GiftCard':
                        ($('#itemcontrol_giftcard [aria-checked="true"]').length > 0) ?
                            $('#itemcontrol_giftcard [aria-checked="true"]').data('val') :
                            0,
                    'Group':
                        ($('#itemcontrol_group [aria-checked="true"]').length > 0) ?
                            $('#itemcontrol_group [aria-checked="true"]').data('val') :
                            0,
                    'PromptPrice':
                        ($('#itemcontrol_promptprice [aria-checked="true"]').length > 0) ?
                            $('#itemcontrol_promptprice [aria-checked="true"]').data('val') :
                            0,
                    'PromptDescription':
                        ($('#itemcontrol_promptdescription [aria-checked="true"]').length > 0)
                            ? $('#itemcontrol_promptdescription [aria-checked="true"]').data('val')
                            : 0,
                    'EBT':
                        ($('#itemcontrol_EBT [aria-checked="true"]').length > 0)
                        ? $('#itemcontrol_EBT [aria-checked="true"]').data('val')
                        : 0,
                    'MinimumAge': parseInt($('#itemcontrol_minimumage').val()),
                    'CountDown': parseInt($('#itemcontrol_countdown').val()),
                    'Points': parseFloat($('#itemcontrol_points').val()),
                    'Description': $('#itemcontrol_description').val(),
                },
                // -- Main printer on item subtab
                'MainPrinter': $('#mainPrinterSelect').jqxDropDownList('getSelectedItem').value
            };
            if ($('#editItem_sort').val() != '') {
                dataToSend['Sort'] = $('#editItem_sort').val();
            }

            $.ajax({
                'url': SiteRoot + 'admin/MenuItem/postMenuItems',
                'method': 'post',
                'data': dataToSend,
                'dataType': 'json',
                'success': function(data) {
                    if (data.status == 'success') {
                        //drawExistsItemsOnGrid();
                        setTimeout(function() {
                            angular.element('.category-cell-grid.clicked').triggerHandler('click');
                        }, 100);
                        updateQuestionItemTable();
                        $('#saveItemGridBtn').prop('disabled', true);

                        // if was changed item combobox and was selected the question tab
                        // to prompt save changes
                        $scope.countChangesOnSelectingItemCbx = 1;
                        if ($scope.tryToChangeQuestionTab) {
                            $('#jqxTabsMenuItemWindows').jqxTabs({selectedItem: 1});
                            $scope.tryToChangeQuestionTab = false;
                        }
                        //
                        $('#editItem_ItemSelected').jqxComboBox({
                            'source': dataAdapterItems('ASC')
                        });
                        if (fromPrompt) {
                            itemsMenuWindow.close();
                        } else {
                            setTimeout(function() {
                                $('#editItem_ItemSelected').jqxComboBox({
                                    'selectedIndex': idxSelected
                                });
                                $('#editItem_label').val(dataToSend['Label']);
                                $('#saveItemGridBtn').prop('disabled', true);
                            }, 300);

                            $('#menuitem_listPrice').jqxNumberInput('val', dataToSend.extraValues.ListPrice);
                            $('#menuitem_price1').jqxNumberInput('val', dataToSend.extraValues.price1);
                            $('#menuitemNotificationsSuccessSettings #notification-content')
                                .html('Menu item was updated successfully!');
                            $scope.menuitemNotificationsSuccessSettings.apply('open');
                            itemsMenuWindow.setTitle(
                                'Edit Menu Item: ' + $scope.itemCellSelectedOnGrid.Unique + ' | Item: ' +
                                dataToSend.ItemUnique +
                                ' | Label: ' + dataToSend.Label);
                        }
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
    $('.editItemFormContainer .required-field,' +
        ' .menuitem_pricesControls, .cbxExtraTab, .menuitem_extraControls')
        .on('keypress keyup paste change', function (e) {
        if ($(this).attr('id') == 'editItem_label' || e.type == 'keyup') {
            if ($scope.itemLengthOfMenuSelected != null) {
                var characters = $(this).val().length;
                if (characters > $scope.itemLengthOfMenuSelected) {
                    $('#menuitemNotificationsErrorSettings #notification-content')
                        .html('You have exceeded limit of characters!');
                    $scope.menuitemNotificationsErrorSettings.apply('open');
                    $(this).css({"border-color": "#F00"});
                    this.value = this.value.substring(0, $scope.itemLengthOfMenuSelected);
                    //return false;
                } else
                    $(this).css({"border-color": "#CCC"});
            }
        }
        $('#saveItemGridBtn').prop('disabled', false);
    });

    $('#editItem_Status')
        .jqxDropDownList({autoDropDownHeight: true});
    $('#editItem_Status').on('select', function(){
        $('#saveItemGridBtn').prop('disabled', false);
    });

    $scope.countChangesOnSelectingItemCbx = 0;
    $('#editItem_ItemSelected').on('select', function(e) {
        if (e.args.item) {
            $scope.changingItemOnSelect = e.args.item.originalItem;
        }
        $scope.countChangesOnSelectingItemCbx++;
        $('#saveItemGridBtn').prop('disabled', false);
    });

    $scope.itemCellSelectedOnGrid = {};
    function onClickDraggableItem() {
        var itemWindow = itemsMenuWindow;
        $('.draggable')
            .on('dblclick', function(e) {
            $('#jqxTabsMenuItemWindows').jqxTabs({selectedItem: 0});
            $('#questionsTabOnMenuItemWindow').show();
            $('#questionsTabOnMenuItemWindow .jqx-tabs-titleContentWrapper').css('margin-top', '0');
            $('#promptToCloseItemGrid').hide();
            $('#mainButtonsOnItemGrid').show();
            //
            $scope.countChangesOnSelectingItemCbx = 0;
            $scope.tryToChangeQuestionTab = false;
            var itemlengthMenu = $scope.menuSelectedWithCategories.ItemLength;
            if (itemlengthMenu == null || itemlengthMenu == 0)
                $scope.$apply(function(){
                    $scope.itemLengthOfMenuSelected = null;
                });
            else
                $scope.$apply(function(){
                    $scope.itemLengthOfMenuSelected = itemlengthMenu;
                });
            //
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
                        //
                        var selectedIndexItem;
                        var itemCombo = $('#editItem_ItemSelected').jqxComboBox('getItemByValue', data['Unique']);
                        if (itemCombo)
                            selectedIndexItem = itemCombo.index;
                        else selectedIndexItem = 0;
                        // Pending..
                        //setTimeout(function() {
                            $('#editItem_ItemSelected').jqxComboBox({'selectedIndex': selectedIndexItem});
                        //}, 250);

                        $('#editItem_Status').val(data['LayoutStatus']);
                        var label = (data['Label'] == '' || data['Label'] == null)
                                    ? $('#editItem_ItemSelected').jqxComboBox('getItem', selectedIndexItem).label
                                    : data['Label'];
                        // Item length limit applied (Taken from menu selected)
                        if ($scope.itemLengthOfMenuSelected != null)
                            label = label.substring(0, $scope.itemLengthOfMenuSelected);
                        // Fill form controls
                        $('#editItem_label').val(label);
                        $('#editItem_sort').val((data['Sort']) == '' || data['Sort'] == null ? 1 : data['Sort']);
                        $('#editItem_Row').val(data.Row);
                        $('#editItem_Column').val(data.Column);
                        // Prices values
                        $('#itemcontrol_lprice').val(data.ListPrice != null ? data.ListPrice : 0);
                        $('#itemcontrol_sprice').val(data.price1 != null ? data.price1 : 0);
                        $('#menuitem_listPrice').val(data.ListPrice != null ? data.ListPrice : 0);
                        $('#menuitem_price1').val(data.price1 != null ? data.price1 : 0);
                        $('#menuitem_price2').val(data.price2 != null ? data.price2 : 0);
                        $('#menuitem_price3').val(data.price3 != null ? data.price3 : 0);
                        $('#menuitem_price4').val(data.price4 != null ? data.price4 : 0);
                        $('#menuitem_price5').val(data.price5 != null ? data.price5 : 0);
                        // Extra tab values
                        var gc;
                        gc = $('#itemcontrol_giftcard .cbxExtraTab[data-val=' +
                            ((data.GiftCard == 0 || data.GiftCard == null) ? '0' : '1') +']');
                        gc.jqxRadioButton({ checked:true });
                        gc = $('#itemcontrol_group .cbxExtraTab[data-val=' +
                            ((data.Group == 0 || data.Group == null) ? '0' : '1') +']');
                        gc.jqxRadioButton({ checked:true });
                        gc = $('#itemcontrol_promptprice .cbxExtraTab[data-val=' +
                            ((data.PromptPrice == 0 || data.PromptPrice == null) ? 0 : 1) +']');
                        gc.jqxRadioButton({ checked:true });
                        gc = $('#itemcontrol_promptdescription .cbxExtraTab[data-val=' +
                            (data.PromptDescription == 0 || data.PromptDescription == null ? 0 : 1) +']');
                        gc.jqxRadioButton({ checked:true });
                        gc = $('#itemcontrol_EBT .cbxExtraTab[data-val=' +
                            ((data.EBT == 0 || data.EBT == null) ? 0 : 1) +']');
                        gc.jqxRadioButton({ checked:true });
                        $('#itemcontrol_minimumage').val(data.MinimumAge != null ? data.MinimumAge : 0);
                        $('#itemcontrol_points').val(data.Points != null ? data.Points : 0);
                        $('#itemcontrol_countdown').val(data.CountDown != null ? data.CountDown : 0);
                        // New fields on main tab for Item table
                        var description = (data.Description != null) ? data.Description : '';
                        $('#itemcontrol_description').val($.trim(description));
                        // Main Printer
                        mainPrinterSet();
                        //
                        $('#saveItemGridBtn').prop('disabled', true);
                        $('#deleteItemGridBtn').show();
                        $('#editItem_ItemSelected').jqxComboBox({disabled: true});
                        itemWindow.setTitle(
                            'Edit Menu Item: ' + data.MenuItemUnique + ' | Item: ' + data.Unique + ' | Label: ' + label);
                        itemWindow.open();
                    }
                });
            }
        })
        .on('click', function(e) {
            $('.draggable').removeClass('selectedItemOnGrid');
            $('.draggable').css({'border': 'solid black 1px'});
            $(this).addClass('selectedItemOnGrid');
            var isOccupied = $(this).hasClass('filled');
            var itemSelected = $('#itemListboxSearch').jqxListBox('selectedIndex');
            if (itemSelected >= 0)
                $('#NewMenuItemBtn').prop('disabled', isOccupied);
            //if (!isOccupied) {
                $(this).css({'border': 'solid #FFDC00 5px'});
            //}
        });
    }

    function mainPrinterSet() {
        var lowestId;
        var printers = $('#printerItemTable').jqxGrid('getRows');
        $.each(printers, function(i, el) {
            var id = parseInt(el.PrinterUnique);
            if (i == 0)
                lowestId = id;
            if (id < lowestId)
                lowestId = id;
        });
        var printer = $('#mainPrinterSelect').jqxDropDownList('getItemByValue', lowestId);
        $('#mainPrinterSelect').jqxDropDownList({
            selectedIndex: (printer) ? printer.index : -1
        });
    }

    var resetMenuItemForm = function() {
        var itemCombo, selectedIndexItem;
            itemCombo = $('#editItem_ItemSelected').jqxComboBox('getItemByValue', $scope.selectedItemInfo.Unique);
        $('#jqxTabsMenuItemWindows').jqxTabs({selectedItem: 0});
        if (itemCombo != undefined) {
            selectedIndexItem = itemCombo.index | 0;
            $scope.countChangesOnSelectingItemCbx = 0;
        } else {
            selectedIndexItem = -1;
            $scope.countChangesOnSelectingItemCbx = 1;
        }
        $scope.tryToChangeQuestionTab = false;
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
        if ($scope.selectedCategoryInfo.Unique && !$('#NewMenuItemBtn').is(':disabled')) {
            $('.draggable').css('border', 'black 1px solid');
            //
            var $this = $('.selectedItemOnGrid');
            var dataToReq = {
                'MenuCategoryUnique': $scope.selectedCategoryInfo.Unique,
                'ItemUnique': $scope.selectedItemInfo.Unique,
                'Label': $scope.selectedItemInfo.Description,
                'Row': $this.data('row'),
                'Column': $this.data('col'),
                'Status': 1,
                'Sort': 1
            };
            $.ajax({
                'url': SiteRoot + 'admin/MenuItem/postMenuItems',
                'method': 'POST',
                'data': dataToReq,
                'dataType': 'json',
                'success': function (data) {
                    if (data.status == 'success') {
                        $this.html($scope.selectedItemInfo.Description);
                        $this.addClass('filled');
                        $this.addClass('itemOnGrid');
                        $this.data('categoryId', $scope.selectedCategoryInfo.Unique);
                        $this.css('background-color', '#7C2F3F');
                        //$this.css('background-color', '#063dee');
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
        // @Deprecated: Old version, creating a new menu_item
        var creatingMenuItem = function() {
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
            //$('#saveItemGridBtn').prop('disabled', false);
            $('#questionsTabOnMenuItemWindow').hide();
            itemsMenuWindow.setTitle('Add New Menu Item');
            itemsMenuWindow.open();
        };
    };

    /**
     * -- DRAGGABLE EVENTS
     */
    // ---- DRAG ITEMS ON ABOVE GRID FOR Selected item from combobox
    function selectedItemEvents () {

        $('#selectedItemInfo, #itemListboxSearch .jqx-listitem-element').jqxDragDrop(
            {
                dropTarget: $('div[id^="draggable-"]'),
                //restricter:'body',
                //tolerance: 'fit',
                onTargetDrop: function(data) {
                    //console.log('onTargetDrop', data);
                },
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
                $('.draggable').css('border', 'black 1px solid');
                //
                var $this = $(event.args.target);
                var data = {
                    'MenuCategoryUnique': $scope.selectedCategoryInfo.Unique,
                    'ItemUnique': $scope.selectedItemInfo.Unique,
                    'Label': $scope.selectedItemInfo.Description,
                    'Row': $(event.args.target).data('row'),
                    'Column': $(event.args.target).data('col'),
                    'Status': 1,
                    'Sort': 1
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
                            //$this.css('background-color', '#063dee');
                            $this.css('background-color', '#7C2F3F');
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
            $('body').find(event.args.target).css('border', '5px solid #eeb706');
        })
        .bind('dropTargetLeave', function (event) {
            ItemOnAboveGrid = false;
            $('body').find(event.args.target).css('border', '1px solid black');
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
                $(event.args.target).css('border', '5px solid #eeb706');
            })
            .bind('dragging', function (event) {})
            .bind('dropTargetLeave', function (event) {
                onCellAboveGrid = false;
                $(event.args.target).css('border', 'black 1px solid');
            });

            // Helper: FirstObject.isEqual(OtherObject)
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
    $scope.questionTableOnMenuItemsSettings = inventoryExtraService.getQuestionGridData();

    var updateQuestionItemTable = function() {
        $('#questionItemTable').jqxGrid({
            source: new $.jqx.dataAdapter(
                inventoryExtraService.getQuestionGridData($('#editItem_ItemSelected').jqxComboBox('getSelectedItem').value).source
            )
        });
    };

    $scope.qitemNotificationsSuccessSettings = setNotificationInit(1);
    $scope.qitemNotificationsErrorSettings = setNotificationInit(0);

    var questionOnItemGridWindow, cbxQuestionsItem;
    $scope.questionOnItemGridWindowSettings = {
        created: function (args) {
            questionOnItemGridWindow = args.instance;
        },
        resizable: false,
        width: "50%", height: "40%",
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
        source: dataAdapterQuestionItems,
        displayMember: 'QuestionName',
        valueMember: 'Unique',
        width: "100%",
        itemHeight: 30,
        theme: 'arctic'
    };

    function updateQuestionsCbx() {
        $('#itemq_Question').jqxComboBox({source: dataAdapterQuestionItems});
    }

    $('#itemq_Status').jqxDropDownList({autoDropDownHeight: true});

    // Events questions item form
    $('#itemq_Status, #itemq_Question').on('select', function() {
        $('#saveQuestionItemBtn').prop('disabled', false);
    });

    $('.itemqFormContainer .required-qitem').on('keypress keyup paste change', function (e) {
        $('#saveQuestionItemBtn').prop('disabled', false);
    });

    $scope.addOrEditqItem = null;
    $scope.qItemIdChosen = null;
    $scope.openQuestionItemWin = function() {
        disableExistingQuestions();
        $('#itemq_Status').jqxDropDownList({'selectedIndex': 0});
        $('#itemq_Question').jqxComboBox({'selectedIndex': -1});
        $('#itemq_Sort').val(1);
        $('#itemq_Tab').val(1);
        //
        $('#saveQuestionItemBtn').prop('disabled', true);
        $('#deleteQuestionItemBtn').hide();
        $scope.addOrEditqItem = 'create';
        questionOnItemGridWindow.setTitle('Add New Question | Item: ' + $('#editItem_ItemSelected').jqxComboBox('getSelectedItem').value);
        questionOnItemGridWindow.open();
    };

    $scope.editQuestionItemLayoutWin = function(e) {
        var row = e.args.row.bounddata;
        var statusCombo = $('#itemq_Status').jqxDropDownList('getItemByValue', row.Status);
        $('#itemq_Status').jqxDropDownList({'selectedIndex': statusCombo.index});
        //
        disableExistingQuestions(row.QuestionUnique);
        var selectedIndexItem;
        var itemCombo = $('#itemq_Question').jqxComboBox('getItemByValue', row.QuestionUnique);
        if (itemCombo != undefined) {
            selectedIndexItem = itemCombo.index | 0;
        }
        $('#itemq_Question').jqxComboBox({'selectedIndex': selectedIndexItem});

        $('#itemq_Sort').val(row.Sort);
        $('#itemq_Tab').val((row.Tab!=null) ? row.Tab : 1);
        //
        $('#saveQuestionItemBtn').prop('disabled', true);
        $('#deleteQuestionItemBtn').show();
        $scope.addOrEditqItem = 'edit';
        $scope.qItemIdChosen = row.Unique;
        questionOnItemGridWindow.setTitle('Edit Question: ' + row.QuestionUnique +' | Item: ' + row.ItemUnique);
        questionOnItemGridWindow.open();
    };

    var disableExistingQuestions = function(current) {
        var questionsByItem = $('#questionItemTable').jqxGrid('getRows');
        $.each(questionsByItem, function(i, el) {
            var qToDisable = $('#itemq_Question').jqxComboBox('getItemByValue', el.QuestionUnique);
            if (qToDisable) {
                $('#itemq_Question').jqxComboBox('disableItem', qToDisable);
                if (current && current == el.QuestionUnique) {
                    var qToEnable = $('#itemq_Question').jqxComboBox('getItemByValue', el.QuestionUnique);
                    $('#itemq_Question').jqxComboBox('enableItem', qToEnable);
                }
            }
        });
    };

    $scope.closeQuestionItemWin = function (option) {
        if(option != undefined) {
            $('#mainButtonsQitem').show();
            $('#promptToCloseQitem').hide();
            //$('.RowOptionButtonsOnItemGrid').hide();
        }
        if (option == 0) {
            $scope.saveQuestionItem();
            questionOnItemGridWindow.close();
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
                'Tab': $('#itemq_Tab').val(),
                'ItemUnique': $('#editItem_ItemSelected').jqxComboBox('getSelectedItem').value
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
                        //setTimeout(function(){
                        //    questionOnItemGridWindow.close();
                        //}, 2000);
                        $('#saveQuestionItemBtn').prop('disabled', true);
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

    /**
     * PRINTER TAB ACTIONS
     */
    $scope.printerTableOnMenuItemsSettings = {
        source: {
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'int'},
                {name: 'ItemUnique', type: 'int'},
                {name: 'PrinterUnique', type: 'int'},
                {name: 'name', type: 'string'},
                {name: 'description', type: 'string'},
                {name: 'Item', type: 'string'},
                {name: 'Status', type: 'number'},
                {name: 'fullDescription', type: 'string'}
            ],
            id: 'Unique',
            url: SiteRoot + 'admin/MenuPrinter/load_allItemPrinters'
        },
        columns: [
            {text: 'ID', dataField: 'Unique', type: 'int'},
            {text: 'Item', dataField: 'Item', type: 'string', hidden: true},
            {text: 'Name', dataField: 'name', type: 'string'},
            {text: 'Description', dataField: 'description', type: 'string'},
            {text: '', dataField: 'ItemUnique', type: 'int', hidden: true},
            {text: '', dataField: 'Status', type: 'int', hidden: true},
            {text: '', dataField: 'fullDescription', type: 'string', hidden: true}
        ],
        //columnsResize: true,
        width: "99%",
        theme: 'arctic',
        sortable: true,
        pageable: true,
        pageSize: 5,
        autoheight: true,
        autorowheight: true
    };

    var allPrintersArray = [];
    var printerStoredArray = [];
    var updatePrinterItemGrid = function() {
        $('#printerItemTable').jqxGrid({
            source: new $.jqx.dataAdapter({
                dataType: 'json',
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'ItemUnique', type: 'int'},
                    {name: 'PrinterUnique', type: 'int'},
                    {name: 'name', type: 'string'},
                    {name: 'description', type: 'string'},
                    {name: 'Item', type: 'string'},
                    {name: 'Status', type: 'number'},
                    {name: 'fullDescription', type: 'string'}
                ],
                url: SiteRoot + 'admin/MenuPrinter/load_allItemPrinters/' + $('#editItem_ItemSelected').jqxComboBox('getSelectedItem').value
            })
        });
    };

    $scope.qitemNotificationsSuccessSettings = setNotificationInit(1);
    $scope.qitemNotificationsErrorSettings = setNotificationInit(0);

    var printerItemWind;
    $scope.printerItemWindowSettings = {
        created: function (args) {
            printerItemWind = args.instance;
        },
        resizable: false,
        width: "52%", height: "28%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    // Printer dropdownlist
    var source =
    {
        datatype: "json",
        datafields: [
            { name: 'name'},
            { name: 'description'},
            { name: 'fullDescription'},
            { name: 'status' },
            { name: 'unique' }
        ],
        id: 'Unique',
        url: SiteRoot + 'admin/MenuPrinter/load_allPrintersFromConfig'
    };

    //$('#printerItemList').on('select', function(e) {
    $('#printerItemList').on('select', function(e) {
        $('#saveBtnPrinterItem').prop('disabled', false);
    });

    var dataAdapter = new $.jqx.dataAdapter(source);
    $scope.printerItemList = { source: dataAdapter, displayMember: "fullDescription", valueMember: "unique" };

    function setPrinterStoredArray() {
        // Fill with printers by item
        printerStoredArray = [];
        var rows = $('#printerItemTable').jqxGrid('getRows');
        for(var j in rows) {
            printerStoredArray.push(rows[j]['PrinterUnique']);
        }
        // Check existing printers on stored by item
        for (var i in allPrintersArray) {
            var item = $("#printerItemList").jqxDropDownList('getItemByValue', allPrintersArray[i]);
            if (printerStoredArray.indexOf(allPrintersArray[i]) > -1) {
                $("#printerItemList").jqxDropDownList('disableItem', item);
            } else {
                $("#printerItemList").jqxDropDownList('enableItem', item);
            }
        }
    }

    $scope.itemPrinterID = null;
    $scope.createOrEditPitem = null;
    $scope.openPrinterItemWin = function(e) {
        $scope.itemSelectedChangedID = $('#editItem_ItemSelected').jqxComboBox('getSelectedItem').value;
        $scope.createOrEditPitem = 'create';
        $scope.itemPrinterID = null;
        // Printers saved by Item
        setPrinterStoredArray();
        //
        $("#printerItemList").jqxDropDownList({selectedIndex: -1});
        $('#deleteBtnPrinterItem').hide();
        $('#saveBtnPrinterItem').prop('disabled', true);
        printerItemWind.setTitle('New Item Printer');
        printerItemWind.open();
    };

    $scope.updateItemPrinter = function(e) {
        var row = e.args.row.bounddata;
        $scope.itemSelectedChangedID = $('#editItem_ItemSelected').jqxComboBox('getSelectedItem').value;
        $scope.openPrinterItemWin();
        printerItemWind.setTitle('Edit Item Printer | Item: ' + row.ItemUnique + ' | Printer ID: ' + row.PrinterUnique);
        //
        $scope.createOrEditPitem = 'edit';
        $scope.itemPrinterID = row.Unique;
        $('#deleteBtnPrinterItem').show();
        var item = $("#printerItemList").jqxDropDownList('getItemByValue', row.PrinterUnique);
        $("#printerItemList").jqxDropDownList('enableItem', item);
        $("#printerItemList").jqxDropDownList({selectedIndex: item.index});
        $('#saveBtnPrinterItem').prop('disabled', true);
    };

    $scope.closePrinterItemWin = function() {
        printerItemWind.close();
        $('#mainButtonsPitem').show();
        $('#promptDeletePitem').hide();
        setPrinterStoredArray();
    };

    // Saving Item printer
    $scope.saveItemPrinter = function() {
        var data = {
            'ItemUnique': $scope.itemSelectedChangedID,
            'PrinterUnique': $('#printerItemList').jqxDropDownList('getSelectedItem').value
        };
        var url;
        if ($scope.createOrEditPitem == 'create') {
            url = SiteRoot + 'admin/MenuPrinter/post_item_printer'
        } else if ($scope.createOrEditPitem == 'edit')
            url = SiteRoot + 'admin/MenuPrinter/update_item_printer/' + $scope.itemPrinterID;
        $.ajax({
            url: url,
            method: 'post',
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success') {
                    $scope.$apply(function() {
                        updatePrinterItemGrid();
                    });
                    $scope.closePrinterItemWin();
                } else if (response.status == 'error')
                    console.log('Database error!');
                else
                    console.log('There was an error!');
            }
        })
    };

    $scope.promptClosePrinterItemWin = function (option) {
        if(option != undefined) {
            $('#mainButtonsPitem').show();
            $('#promptToClosePitem').hide();
            $('#promptDeletePitem').hide();
        }
        if (option == 0) {
            $scope.saveItemPrinter();
        } else if (option == 1) {
            $scope.closePrinterItemWin();
        }
        else if (option == 2) {}
        else {
            if ($('#saveBtnPrinterItem').is(':disabled')) {
                $scope.closePrinterItemWin();
            }
            else {
                $('#promptToClosePitem').show();
                $('#mainButtonsPitem').hide();
                $('#promptDeletePitem').hide();
            }
        }
    };

    // Deleting Item printer
    $scope.beforeDeleteItemPrinter = function(option) {
        if (option == 0) {
            $.ajax({
                url: SiteRoot + 'admin/MenuPrinter/delete_item_printer/' + $scope.itemPrinterID,
                method: 'post',
                dataType: 'json',
                success: function(response) {
                    if(response.status == 'success') {
                        $scope.$apply(function() {
                            updatePrinterItemGrid();
                        });
                        $scope.closePrinterItemWin();
                    } else if (response.status == 'error'){
                        console.log('there was an error db');
                    } else {
                        console.log('there was an error');
                    }
                }
            });
        } else if (option == 1) {
            $('#mainButtonsPitem').show();
            //$('#pro-mptToCloseQitem').hide();
            $('#promptDeletePitem').hide();
            printerItemWind.close();
        } else if (option == 2) {
            $('#mainButtonsPitem').show();
            //$('#promptToCloseQitem').hide();
            $('#promptDeletePitem').hide();
        } else {
            $('#mainButtonsPitem').hide();
            //$('#promptToCloseQitem').hide();
            $('#promptDeletePitem').show();
        }
    };

    /**
     * PRICES TAB ACTION
     */
    $scope.numberPricesSet = {
        inputMode: 'simple',
        decimalDigits: 2,
        digits: 6,
        spinButtons: false,
        groupSize: 2,
        groupSeparator: ',',
        width: 180,
        height: 25,
        min: '',
        symbol: "$",
        symbolPosition: "left"
    };

    $scope.numberMenuItem = {
        inputMode: 'simple',
        decimalDigits: 0,
        digits: 2,
        spinButtons: true,
        width: 300,
        height: 25,
        min: 1,
        textAlign: 'left'
    };

    $scope.numberExtraSet = {
        inputMode: 'simple',
        decimalDigits: 0,
        digits: 2,
        spinButtons: false,
        width: 100,
        height: 25,
        min: ''
    };

    $scope.decimalsExtraSet = {
        inputMode: 'simple',
        decimalDigits: 2,
        digits: 3,
        spinButtons: false,
        width: 100,
        height: 25,
        min: ''
    };

    $scope.checkboxExtraSet = {
        width: '10%',
        height: '25',
        theme: 'summer'
    };

});