/**
 * Created by carlosrenato on 05-19-16.
 */

app.controller('menuItemController', function ($scope, $rootScope, $http, inventoryExtraService, questionService, menuCategoriesService, adminService) {

    $scope.menuItemDisabled = true;
    // -- MenuCategoriesTabs Main Tabs
    $('#MenuCategoriesTabs').on('tabclick', function (e) {
        var tabclicked = e.args.item;
        var tabTitle = $('#MenuCategoriesTabs').jqxTabs('getTitleAt', tabclicked);
        // ITEMS TAB - Reload queries
        if (tabTitle == 'Layout') {
            updateQuestionsCbx();
            // $('#itemListboxSearch').jqxListBox('refresh');
            // $('#itemListboxSearch').val(-1);

            $('#itemListboxSearch .jqx-listbox-filter-input').val('');
            $('#menuListDropdown').jqxDropDownList({source: dataAdapterMenu });
            $('#menuListDropdown').jqxDropDownList({selectedIndex: 0 });
            // Redraw grid
            $('.draggable').removeClass('selectedItemOnGrid');

            $('#NewMenuItemBtn').prop('disabled', true)
        }
    });

    $('#ListBoxSearchInput').on('keypress', function(e) {
        var kcode = e.keyCode;
        if (kcode == 13) {
            searchActionOnItemList($(this).val());
        }
    });
    $('#ListBoxSearchBtn').on('click', function() {
        searchActionOnItemList($('#ListBoxSearchInput').val());
    });

    /**
     * -- MODAL TO CREATE NEW ITEM FROM MENU ITEM GRID
     */
    var itemsModalCreate;
    $scope.itemsModalCreate = {
        created: function (args) {
            itemsModalCreate = args.instance;
        },
        resizable: false,
        width: "60%", height: "75%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    $scope.ItemModalStateAction = null;
    $scope.ItemModalID = null;
    $('#CreateItemBtn').on('click', function() {
        $scope.ItemModalStateAction = 'new';
        $scope.ItemModalID = null;
        $('#pricestabItemModal').hide();
        $('#costtabItemModal').hide();
        $('#optionstabItemModal').hide();

        $('#itemsModalCreateTabs').jqxTabs('select', 0);
        setTimeout(function() {
            $('#item_Description').focus();
        }, 150);
        itemsModalCreate.setTitle('Create Item');
        itemsModalCreate.open();
    });

    $scope.categoryCbxSettings = inventoryExtraService.getCategoriesSettings();
    $scope.subcategoryCbxSettings = inventoryExtraService.getSubcategoriesSettings();
    $scope.nitemSuccess = adminService.setNotificationSettings(1, '#nitemNotification');
    $scope.nitemError = adminService.setNotificationSettings(0, '#nitemNotification');
    $scope.taxesInventoryGrid = inventoryExtraService.getTaxesGridData();
    var taxesValuesChanged = [];
    // Tax by item checkboxes change event
    $("#taxesGrid").on('cellvaluechanged', function (event)
    {
        var args = event.args;
        var datafield = event.args.datafield;
        var rowBoundIndex = args.rowindex;
        var value = args.newvalue;
        var oldvalue = args.oldvalue;
        if (datafield == 'taxed') {
            if (taxesValuesChanged.indexOf(rowBoundIndex) == -1)
                taxesValuesChanged.push(rowBoundIndex);
            $('#saveItemMBtn').prop('disabled', false);
        }
    });

    //-- Events on Item Create Modal
    $('.item_textcontrol, .item_combobox').on('change keypress keyup paste', function() {
        $('#saveItemMBtn').prop('disabled', false);
        if ($(this).attr('id') == 'item_ListPrice') {
            $('#item_Price1').val($(this).jqxNumberInput('val'));
        }
    });

    $scope.onchangeMainPrinter = function(e) {
        $('#saveItemMBtn').prop('disabled', false);
    };

    function resetItemCreateModalForm () {
        $('#itemsModalCreateTabs').jqxTabs('select', 0);
        $('.item_textcontrol').val('');
        $('#item_category').val('');
        $('#item_subcategory').val('');
        $('#mainPrinterNewItem').jqxDropDownList({selectedIndex: -1 })
        $('#item_ListPrice').val(0);
        $('#item_Price1').val(0);
        $('#item_Cost').val(0);
        // $scope.taxesInventoryGrid = inventoryExtraService.getTaxesGridData();
        $('#taxesGrid').jqxGrid({
            'source':  inventoryExtraService.getTaxesGridData().source
        });
        setTimeout(function(){
            $('#saveItemMBtn').prop('disabled', true);
        }, 500);
    }

    $scope.onSelectCategoryCbx = function(e) {
        if (e.args && e.args.item != null) {
            var id = e.args.item.value;
            $scope.subcategoryCbxSettings = inventoryExtraService.getSubcategoriesSettings(id);
        } else {
            $scope.subcategoryCbxSettings = inventoryExtraService.getSubcategoriesSettings();
        }
    };

    $scope.closeMenuGridItemCreate = function(option) {
        if (option != undefined) {
            $('#mainButtonsOnItemCreateModal').show();
            $('#promptToCloseItemCreateModal').hide();
        }
        if (option == 0) {
            $scope.saveItemOnMenuItemGrid();
        } else if (option == 1) {
            itemsModalCreate.close();
            resetItemCreateModalForm();
        } else if (option == 2) {
        } else {
            if ($('#saveItemMBtn').is(':disabled')) {
                itemsModalCreate.close();
                resetItemCreateModalForm();
            } else {
                $('#mainButtonsOnItemCreateModal').hide();
                $('#promptToCloseItemCreateModal').show();
            }
        }
    };
    //--

    $scope.saveItemOnMenuItemGrid = function() {
        var beforeSaveInventory = function(fieldsToSkip) {
            var needValidation = false;
            if (fieldsToSkip == undefined) {
                fieldsToSkip = [];
            }
            $('.inventory_tab .req').each(function(i, el) {
                var fieldName = $(el).data('field');
                if (el.value == '' && fieldsToSkip.indexOf(fieldName) < 0) {
                    $('#nitemError #notification-content')
                        .html($(el).attr('placeholder') + " is required");
                    $scope.nitemError.apply('open');
                    $(el).css({'border-color': '#F00'});
                    needValidation = true;
                } else
                    $(el).css({'border-color': '#CCC'});
            });
            //
            $('.item_combobox.req').each(function(i, el) {
                var combo = $(el).jqxComboBox('selectedIndex');
                if (combo < 0) {
                    $('#nitemError #notification-content')
                        .html($(el).data('field') + " is required");
                    $scope.nitemError.apply('open');
                    $(el).css({'border-color': '#F00'});
                    needValidation = true;
                } else
                    $(el).css({'border-color': '#CCC'});
            });
            return needValidation;
        };
        if (!beforeSaveInventory()) {
            var dataRequest = {};
            $('.inventory_tab .item_textcontrol').each(function(i, el) {
                var field = $(el).data('field');
                if (field != undefined) {
                    dataRequest[field] = $.trim($(el).val());
                } else {}
            });
            //
            if ($('#item_Part').val() == '' || $('#item_Part').val() == null) {
                dataRequest['Part'] = $('#item_Item').val();
            }
            //
            dataRequest['MainCategory'] = $('#item_category').val();
            dataRequest['CategoryUnique'] = $('#item_subcategory').val();
            var mainPrinter = $("#mainPrinterNewItem").jqxDropDownList('getSelectedItem');
            dataRequest['MainPrinter'] = (mainPrinter != null) ? (mainPrinter.value) : null;
            //
            var taxesByItem = [];
            $.each($('#taxesGrid').jqxGrid('getrows'), function(i, row) {
                if (row.taxed) {
                    taxesByItem.push({
                        TaxUnique: row.Unique,
                        ItemUnique: $scope.itemInventoryID,
                        Status: row.taxed
                    });
                }
            });
            dataRequest['taxesValues'] = (taxesByItem != '') ? JSON.stringify(taxesByItem) : '';
            if ($scope.ItemModalStateAction == 'new') {
                var url = SiteRoot + 'admin/MenuItem/simplePostItem';
            } else if ($scope.ItemModalStateAction == 'edit') {
                var url = SiteRoot + 'admin/MenuItem/simpleUpdateItem/' + $scope.ItemModalID;
            }
            $.ajax({
                method: 'POST',
                url: url,
                data: dataRequest,
                dataType: 'json',
                async: false,
                success: function(data) {
                    if (data.status == 'success') {
                        if ($scope.ItemModalStateAction == 'new') {
                            // IF SELECTED CELL ON GRID IS EMPTY
                            // FILL IT WITH NEW ITEM CREATED ON MODAL
                            var selectedItemOnGrid = $('.selectedItemOnGrid');
                            if (selectedItemOnGrid[0] != undefined) {
                                if (!selectedItemOnGrid.hasClass('filled')) {
                                    var newDataIt = {
                                        'MenuCategoryUnique': $scope.selectedCategoryInfo.Unique,
                                        'ItemUnique': data.id, // Item Unique
                                        'Label': $('#item_Description').val(), // description
                                        'Row': selectedItemOnGrid.data('row'),
                                        'Column': selectedItemOnGrid.data('col')
                                    };
                                    $.ajax({
                                        'url': SiteRoot + 'admin/MenuItem/postMenuItems',
                                        'method': 'post',
                                        'data': newDataIt,
                                        'dataType': 'json',
                                        'success': function (data) {
                                            var $this = selectedItemOnGrid;
                                            if (data.status == 'success') {
                                                $this.html(
                                                    "<div class='priceContent'>"+ $('#item_Price1').val() +
                                                    "</div>" +
                                                    "<div class='labelContent'>"+ newDataIt.Label +
                                                    "</div>"
                                                );
                                                $this.addClass('filled');
                                                $this.addClass('itemOnGrid');
                                                $this.data('categoryId', $scope.selectedCategoryInfo.Unique);
                                                $this.css('background-color', '#7C2F3F');
                                                draggableEvents();
                                                setTimeout(function() {
                                                    resetItemCreateModalForm();
                                                    angular.element('.category-cell-grid.clicked').triggerHandler('click');
                                                }, 100);
                                            } else if (data.status == 'error') {
                                                $.each(data.message, function(i, value){
                                                    $('#notification-window .text-content').html('' +
                                                        'Cell is already occupied. To use, please move or delete item.'
                                                    );
                                                    $('#notification-window').jqxWindow('open');
                                                    return;
                                                });
                                            } else {
                                                console.error('error from ajax');
                                            }
                                        }
                                    });
                                }
                            } else {
                                // resetItemCreateModalForm();
                            }

                        } else if ($scope.ItemModalStateAction == 'edit') {
                            console.log('item updated'); // console.log(data)
                        }
                        //
                        searchActionOnItemList($('#item_Description').val()); // $('#ListBoxSearchInput').val()
                        $('#ListBoxSearchInput').val($('#item_Description').val());
                        resetItemCreateModalForm();
                        itemsModalCreate.close();
                    } else if (data.status == 'error') {
                        $('#nitemError #notification-content')
                            .html(data.message);
                        $scope.nitemError.apply('open');
                    } else {
                        $('#nitemError #notification-content')
                            .html(data.message);
                        $scope.nitemError.apply('open');
                    }
                }
            });
        } else {
            console.log('Validation error!')
        }
    };

    /**
     * -- SEARCH ITEM ON LEFT SIDEBAR
     */
    function searchActionOnItemList(inputEntered) {
        $('#loadingMenuItem').show();
        $('#itemListboxSearch').jqxListBox({
            source: dataAdapterItems('ASC', inputEntered)
        });
        setTimeout(function() {
            selectedItemEvents();
        }, 500);
    }

    /**
     * -- MENU ITEM TABS ACTIONS
     */
    var printerTabOnce = true;
    $('#jqxTabsMenuItemWindows').on('selecting', function(e) { // tabclick
        var tabclicked = e.args.item;
        var tabTitle = $('#jqxTabsMenuItemWindows').jqxTabs('getTitleAt', tabclicked);
        // ---
        if (tabclicked != 0) {
            // $('#deleteItemGridBtn').hide();
            $('#editItem_ItemSelected').jqxComboBox({disabled: false});
        } else {
            // $('#deleteItemGridBtn').show();
            $('#editItem_ItemSelected').jqxComboBox({disabled: true});
            // Main Printer
            if ($scope.itemCellSelectedOnGrid != null) {
                var printer = $('#mainPrinterSelect').jqxDropDownList('getItemByValue', $scope.itemCellSelectedOnGrid.PrimaryPrinter);
                $('#mainPrinterSelect').jqxDropDownList({
                    selectedIndex: (printer) ? printer.index : -1
                });
            } else {
                mainPrinterSet();
            }
        }
        // ---
        if (tabTitle == 'Printers') {
            if (printerTabOnce) {
                $('#printerItemList').jqxDropDownList({
                    source: printerDataadapter()
                });
                $('#printerItemList').on('bindingComplete', function() {
                    // Fill all printers
                    if (allPrintersArray == '') {
                        var rows = $("#printerItemList").jqxDropDownList('getItems');
                        for(var j in rows) {
                            allPrintersArray.push(rows[j]['value']);
                        }
                    }
                });
                printerTabOnce = false;
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
        if (tabTitle == 'Picture') {
            $('#uploadPictureBtn').show();
        } else {
            $('#uploadPictureBtn').hide();
        }
    });

    /**
     * -- MAIN MODAL FOR MENU ITEM ON GRID
     */
    var itemsMenuWindow;
    $scope.itemsMenuWindowsSetting = {
        created: function (args) {
            itemsMenuWindow = args.instance;
        },
        resizable: false,
        width: "100%", // height: "75%",
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
                {name: 'categories', type: 'json'},
                //
                {name: 'ScreenResolutionWidth', type: 'string'},
                {name: 'ScreenResolutionHeight', type: 'string'},
                {name: 'LeftPanelWidth', type: 'string'},
                {name: 'RightPanelWidth', type: 'string'},
                {name: 'ItemGridHeight', type: 'string'},
                {name: 'ItemButtonHeight', type: 'string'},
                {name: 'ItemButtonWidth', type: 'string'},
                {name: 'CategoryGridWidth', type: 'string'},
                {name: 'CategoryGridHeight', type: 'string'},
                {name: 'CategoryButtonWidth', type: 'string'},
                {name: 'CategoryButtonHeight', type: 'string'},
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
                $('#ListBoxSearchInput').focus();
            }, 250);
        }
    };

    /**
     * -- EVENT ON MAIN LISTBOX MENU TO SELECT AND LOAD ON GRID
     */
    var screenWidth, screenWidthParse, screenHeigth, screenHeigthParse,
        itemBtnWidth, itemBtnHeight,
        leftTab, leftTabParse, rightTab, rightTabParse,
        iGridHeight, iGridHeightParse,
        minLeftWidth, minRightWidth,
        categoryGridWidth, categoryGridHeight, categoryBtnWidth, categoryBtnHeight;
    $scope.categoriesByMenu = [];
    $scope.menuListBoxSelecting = function (e) {
        $('.category-cell-grid').removeClass('clicked');
        var row = e.args.item.originalItem;
        $scope.categoriesByMenu = row.categories;
        $scope.menuSelectedWithCategories = row;

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
        // Layout
        screenWidth = (row.ScreenResolutionWidth != null) ? row.ScreenResolutionWidth : '1024px';
        screenWidthParse = screenWidth.split('px');
        screenWidthParse = parseInt(screenWidthParse[0]);
        screenHeigth = (row.ScreenResolutionHeight != null) ? row.ScreenResolutionHeight : '768px';
        screenHeigthParse = screenHeigth.split('px');
        screenHeigthParse = parseInt(screenHeigthParse[0]);
        leftTab = (row.LeftPanelWidth != null) ? row.LeftPanelWidth : '30%';
        leftTabParse = leftTab.split('%');
        leftTabParse = parseInt(leftTabParse[0]);
        rightTab = (row.RightPanelWidth != null) ? row.RightPanelWidth : '70%';
        rightTabParse = rightTab.split('%');
        rightTabParse = parseInt(rightTabParse[0]);
        iGridHeight = (row.ItemGridHeight != null) ? row.ItemGridHeight : '320px';
        iGridHeightParse = iGridHeight.split('px');
        iGridHeightParse = parseInt(iGridHeightParse[0]);
        minLeftWidth = screenWidthParse * (leftTabParse / 100);
        minRightWidth = screenWidthParse * (rightTabParse / 100);
        //
        itemBtnWidth = row.ItemButtonWidth;
        itemBtnHeight = (row.ItemButtonHeight != null) ? row.ItemButtonHeight : '20px';
        //-- General Grid Settings and Display
        $('#MenuItemLayoutContent').css({'width': screenWidth, 'height': screenHeigth});
        $('#leftTabMenuItem').css('width', leftTab);
        $('#itemselect-container').css('min-width', minLeftWidth);
        $('#rightTabMenuItem').css('width', rightTab);
        $('.maingrid-container').css('width', minRightWidth);
        // if (screenWidthParse > $(window).width()) {
        //     minRightWidth *= 1.5;
        // }
        $('#mainGridMenuItem').css({'width': minRightWidth, 'height': iGridHeight});
        $('.restricter-dragdrop').css({'width': minRightWidth, 'height': iGridHeight});
        //-- Categories Grid Below Settings
        categoryGridWidth = (row.CategoryGridWidth != null) ? row.CategoryGridWidth : '90%';
        categoryGridWidth = categoryGridWidth.split('%');
        categoryGridWidth = parseInt(categoryGridWidth[0]);
        categoryGridHeight = (row.CategoryGridHeight != null) ? row.CategoryGridHeight : '200px';
        categoryBtnWidth = (row.CategoryButtonWidth);
        categoryBtnHeight = (row.CategoryButtonHeight != null) ? row.CategoryButtonHeight : '100px';
        //
        var categoryInd = minRightWidth * (categoryGridWidth / 100) / $scope.menuSelectedWithCategories.Column;
        setTimeout(function() {
            $('#categories-container').css({'height':categoryGridHeight});
            $('#categories-grid').css({'min-width': minRightWidth, 'height': categoryGridHeight});
            $('.category-cell-grid').css({'height': categoryBtnHeight, 'width':categoryInd, 'float': 'left'});
            // $('.categoryRowDrawn').css({'width':categoryGridWidth + '%'})
            // $('#categories-container').css({'width':categoryGridWidth  + '%'})
        }, 500)
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
            template += '<div class="menuItemRowDrawn">'; // class="row"
            if (diff % 1 !== 0) {
                // template += '<div class="col-md-offset-1 col-sm-offset-1"></div>';
            }
            for (var j = 0; j < $scope.grid.cols; j++) {
                var num = j + 1 + (i * $scope.grid.cols);
                template += '<div class="draggable col-md-' + round + ' col-sm-' + round + ' ' +
                    strechedClass + '" id="draggable-' + num + '" data-col="' + (j + 1) + '" data-row="' + (i + 1) + '">' +
                    num + '</div>';
            }
            if (diff % 1 !== 0) {
                // template += '<div class="col-md-offset-1 col-sm-offset-1"></div>';
            }
            template += '</div>';
            $('.restricter-dragdrop').append(template);
        }
        drawExistsItemsOnGrid();
        onClickDraggableItem();
        //-- Main Menu Item Grid Above Settings
        var nWidth = (minRightWidth * 98 / 100) / $scope.menuSelectedWithCategories.MenuItemColumn;
        var nHeight = iGridHeightParse / $scope.menuSelectedWithCategories.MenuItemRow;
        $('.draggable').css({width: nWidth, height: itemBtnHeight, padding: 0});
        $('.menuItemRowDrawn').css({'padding-left': '2%'/*'width': minRightWidth*/});
    };

    /**
     * -- CATEGORY MODAL OPENED BY DOUBLE CLICK AT BOTTOM GRID OF CATEGORIES
     */
    var categNameWind;
    $scope.itemsMenuChangeCategNameWind = {
        created: function (args) {
            categNameWind = args.instance;
        },
        resizable: false,
        width: "60%", height: "65%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    $('#OneCategoryName').on('keypress keyup paste change', function(e) {
        $('#saveItemOneCategoryBtn').prop('disabled', false);
        $('#savemitcemOneCategoryBtn').prop('disabled', false);
    });

    $('body').on('select change', '#mitclfontSize', function(e) {
        $('#saveItemOneCategoryBtn').prop('disabled', false);
        $('#savemitcemOneCategoryBtn').prop('disabled', false);
    });

    $scope.mitcbPrimaryColor = null;
    $scope.mitcbSecondaryColor = null;
    $scope.mitclfontColor = null;
    $scope.dblclickCategoryCell = function(e, row) {
        $http.get(SiteRoot + 'admin/MenuCategory/get_oneCategory/' + row.Unique)
            .then(function(response) {
                if (response.data) {
                    var category = response.data.row;
                    $('#OneCategoryName').val(category.CategoryName);
                    $('#OneCategoryId').val(category.Unique);
                    // Styles
                    // -- PRIMARY BUTTON
                    menuCategoriesService.updateColorControl('#' + category['ButtonPrimaryColor'], 'mitcbPrimaryColor', $scope);
                    menuCategoriesService.updateColorControl('#' + category['ButtonSecondaryColor'], 'mitcbSecondaryColor', $scope);
                    menuCategoriesService.updateColorControl('#' + category['LabelFontColor'], 'mitclfontColor', $scope);
                    var lfs = (category['LabelFontSize']) ? category['LabelFontSize'] : '12px';
                    $('#mitclfontSize').val(lfs);
                    $('#savemitcemOneCategoryBtn').prop('disabled', true);
                    categNameWind.open();
                }
            }, function(){})
    };

    $scope.saveOneCategory = function() {
        var unique = $('#OneCategoryId').val();
        var name = $('#OneCategoryName').val();
        var bprimary = $('#mitcbPrimaryColor').jqxColorPicker('getColor');
        var bsecondary = $('#mitcbSecondaryColor').jqxColorPicker('getColor');
        var lfont = $('#mitclfontColor').jqxColorPicker('getColor');
        var data = {
            CategoryName: name,
            'ButtonPrimaryColor': "#" + ((bprimary) ? bprimary.hex : $('#catButtonPrimaryColorDef').val()),
            'ButtonSecondaryColor': "#" + ((bsecondary) ? bsecondary.hex: $('#catButtonSecondaryColorDef').val()),
            'LabelFontColor': "#" + ((lfont) ? lfont.hex : $('#catLabelFontColorDef').val()),
            'LabelFontSize': $('#mitclfontSize').val()
        };

        $http.post(
                SiteRoot + 'admin/MenuCategory/update_Category/' + unique + '/1',
                data)
            .then(function(response) {
                var categorySelected = ($scope.selectedCategoryInfo);
                $scope.menuSelectedWithCategories.newCategories[categorySelected.Row][categorySelected.Column].CategoryName = name;
                categNameWind.close();
            });
    };

    $scope.closeOneCategory = function(option) {
        if (option != undefined) {
            $('#mainOneCategoryBtns').show();
            $('#closeOneCategoryBtns').hide();
        }
        if (option == 0) {
            $scope.saveOneCategory();
        } else if (option == 1) {
            categNameWind.close();
        } else if (option == 2) {
        } else {
            if ($('#savemitcemOneCategoryBtn').is(':disabled')) {
                categNameWind.close();
            }
            else {
                $('#mainOneCategoryBtns').hide();
                $('#closeOneCategoryBtns').show();
            }
        }
    };

    /**
     * -- HELPER TO DRAW DATA ON MAIN MENU ITEM GRID
     */
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
    function dataAdapterItems(sort, search) {
        var url = '';
        var settings = {};
        if (sort != undefined) {
            url = SiteRoot + 'admin/MenuItem/load_allItems?sort=' + sort;
            if (search != undefined) {
                url += ('&search=' + search);
                settings.loadComplete = function(e) {
                    $('#loadingMenuItem').hide();
                }
            }
        }
        return new $.jqx.dataAdapter(
            {
                dataType: 'json',
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'Description', type: 'string'},
                    {name: 'Item', type: 'string'},
                    {name: 'Part', type: 'string'},
                    {name: 'ListPrice', type: 'string'},
                    {name: 'price1', type: 'string'},
                    {name: 'Cost', type: 'string'},
                    {name: 'Category', type: 'string'},
                    {name: 'SubCategory', type: 'string'},
                    {name: 'MainCategory', type: 'string'},
                    {name: 'CategoryUnique', type: 'string'},
                    {name: 'PrimaryPrinter', type: 'string'},
                    // {name: 'taxes', type: 'string'},
                    {name: 'Status', type: 'number'}
                ],
                url: url
            }, settings
        );
    }

    var comboboxItems;
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
        // source: [],
        source: dataAdapterItems('ASC'),
        theme: 'arctic'
    };
    $scope.itemsComboboxSelecting = function(e) {
        if (e.args) {
            var item = e.args.item.originalItem;
            var description = item.Description;
            if ($scope.itemLengthOfMenuSelected != null)
                description = description.substring(0, $scope.itemLengthOfMenuSelected);
            // $('#editItem_label').val(description);
        }
    };

    var listboxItems;
    $scope.itemsListboxSettings =
    {
        created: function (args) {
            listboxItems = args.instance;
        },
        selectedIndex: -1,
        displayMember: "Description",
        valueMember: "Unique",
        width: "100%",
        itemHeight: 40,
        height: '550px',
        source: [],
        theme: 'arctic',
        renderer: function(index, label, value) {
            var item = $('#itemListboxSearch').jqxListBox('getItem', index).originalItem;
            var template =
                '<div class="item-row-content">' +
                    '<span>' + item.Description + ' | '+ item.price1 +'</span><br>' +
                    '<span>' + item.Category + ' | '+ item.SubCategory +'</span>' +
                    // '<div class="separator" style="width: 100px;border-bottom: #222 2px solid;"></div>' +
                '</div>';
            return template;
        }
    };

    $scope.selectedItemInfo = {};
    $scope.itemListBoxOnSelect = function(e) {
        if (e.args != undefined) {
            var _args = e.args.item.originalItem;
            $scope.selectedItemInfo = _args;
        }
    };

    $('#itemListboxSearch').on('change', function(e) {
        if (e.args.item != null) {
            var row = e.args.item.originalItem;
            console.log(row);
            var el = e.args.item.element;
            $(el)
                .unbind('dblclick')
                .bind('dblclick', function(e) {
                    $scope.ItemModalStateAction = 'edit';
                    $scope.ItemModalID = row.Unique;
                    //
                    $('#pricestabItemModal').show();
                    $('#costtabItemModal').show();
                    $('#optionstabItemModal').show();
                    //
                    $('#item_Description').val(row.Description);
                    $('#item_category').jqxComboBox('val', row.MainCategory);
                    $('#item_Item').val(row.Item);
                    $('#item_Part').val(row.Part);
                    $('#mainPrinterNewItem').val(row.PrimaryPrinter);
                    $('#item_ListPrice').jqxNumberInput('val', row.ListPrice);
                    $('#item_Price1').jqxNumberInput('val', row.price1);
                    $('#item_Cost').jqxNumberInput('val', row.Cost);
                    // Open Modal
                    $('#itemsModalCreateTabs').jqxTabs('select', 0);
                    setTimeout(function() {
                        $('#taxesGrid').jqxGrid({
                            'source':  inventoryExtraService.getTaxesGridData(row.Unique).source
                        });
                        $('#item_subcategory').jqxComboBox('val', row.CategoryUnique);
                        $('#item_Description').focus();
                        $('#saveItemMBtn').prop('disabled', true);
                    }, 300);
                    itemsModalCreate.setTitle('Edit Item ID: ' + row.Unique + ' | Item: ' + row.Item);
                    itemsModalCreate.open();
                });
        }
    });

    /**
     * -- CATEGORIES BOTTOM GRID
     * // -- TO FIX
     */
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
    $scope.menuitemNotificationsSuccessSettings = adminService.setNotificationSettings(1, '#notification_container_menuitem');
    $scope.menuitemNotificationsErrorSettings = adminService.setNotificationSettings(0, '#notification_container_menuitem');

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

    /**
     * VAlidaTion of Data Before saving Menu Item on main modal
     * @returns {boolean}
     */
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
        if (itemCombo.val() == '') {
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
            if (labelField.val().length > $scope.itemLengthOfMenuSelected) {
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

    /**
     * Save BTN action on Main Modal to store data of menu_item
     * @type {boolean}
     */
    $scope.disabledControl = true;
    $scope.saveItemGridBtn = function(fromPrompt) {
        var imgs = [];
        angular.forEach($scope.uploader.flow.files, function(el, key) {
            if ($scope.successUploadNames.indexOf(el.newName) > -1) {
                imgs.push(el.newName);
            }
        });
        if (!validationDataOnItemGrid()) {
            var bprimary = $('#mitbPrimaryColor').jqxColorPicker('getColor');
            var bsecondary = $('#mitbSecondaryColor').jqxColorPicker('getColor');
            var lfont = $('#mitlfontColor').jqxColorPicker('getColor');
            //
            // var idxSelected = $('#editItem_ItemSelected').jqxComboBox('getSelectedItem').index;
            var idxSelected = $('#editItem_ItemSelected').val();
            var dataToSend = {
                'MenuCategoryUnique': $scope.itemCellSelectedOnGrid.MenuCategoryUnique,
                'Row': $('#editItem_Row').val(),
                //'Row': $scope.itemCellSelectedOnGrid.Row,
                'Column': $('#editItem_Column').val(),
                //'Column': $scope.itemCellSelectedOnGrid.Column,
                // 'ItemUnique': $('#editItem_ItemSelected').jqxComboBox('getSelectedItem').value,
                'ItemUnique': $('#editItem_ItemSelected').val(),
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
                    'PriceModify': parseFloat($('#menuitem_priceModify').val()),
                    // Cost Values
                    'Cost': parseFloat($('#item_cost').jqxNumberInput('val')),
                    'Cost_Extra': parseFloat($('#item_Cost_Extra').jqxNumberInput('val')),
                    'Cost_Freight': parseFloat($('#item_Cost_Freight').jqxNumberInput('val')),
                    'Cost_Duty': parseFloat($('#item_Cost_Duty').jqxNumberInput('val')),
                    // Extra Values
                    'GiftCard': $('#itemcontrol_gcard').val(),
                        // ($('#itemcontrol_giftcard [aria-checked="true"]').length > 0) ?
                        //     $('#itemcontrol_giftcard [aria-checked="true"]').data('val') :
                        //     0,
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
                    'Label': $('#itemcontrol_itemlabelpos').val()
                },
                'pictures': imgs.join(','),
                'ButtonPrimaryColor': "#" + ((bprimary) ? bprimary.hex : $('#mitButtonPrimaryColorDef').val()),
                'ButtonSecondaryColor': "#" + ((bsecondary) ? bsecondary.hex: $('#mitButtonSecondaryColorDef').val()),
                'LabelFontColor': "#" + ((lfont) ? lfont.hex : $('#mitLabelFontColorDef').val()),
                'LabelFontSize': $('#mitlfontSize').val()
            };
            // -- Main printer on item subtab
            if ($('#mainPrinterSelect').val() != '') {
                dataToSend['MainPrinter'] = $('#mainPrinterSelect').jqxDropDownList('getSelectedItem').value;
            }
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
                        // $('#editItem_ItemSelected').jqxComboBox({
                        //     'source': dataAdapterItems('ASC')
                        // });
                        if (fromPrompt) {
                            itemsMenuWindow.close();
                        } else {
                            setTimeout(function() {
                                // $('#editItem_ItemSelected').jqxComboBox({
                                //     'selectedIndex': idxSelected
                                // });
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
                    } else
                        console.log('Error from ajax');
                }
            });
        }
    };

    /**
     * Deleting a menu item from main modal
     */
    $('body').on('click', '#deleteItemGridBtn', function(e) {
        $scope.deleteItemGridBtn();
    });

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

    /**
     * // Events item form controls
     */
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
    $('#editItem_Status, #mainPrinterSelect').on('select', function(){
        $('#saveItemGridBtn').prop('disabled', false);
    });
    $('body').on('select', '#itemcontrol_gcard', function(){
        $('#saveItemGridBtn').prop('disabled', false);
    });
    $('body').on('select', '#itemcontrol_itemlabelpos', function(){
        $('#saveItemGridBtn').prop('disabled', false);
    });
    $('body').on('select', '#mitlfontSize', function(){
        $('#saveItemGridBtn').prop('disabled', false);
    });

    $scope.countChangesOnSelectingItemCbx = 0;
    $('#editItem_ItemSelected').on('change', function(e) {
        if (e.args.item) {
            $scope.changingItemOnSelect = e.args.item.originalItem;
        }
        $scope.countChangesOnSelectingItemCbx++;
        $('#saveItemGridBtn').prop('disabled', false);
    });

    $scope.onChangeCostFieldsMenuItem = function() {
        var cost = $('#item_cost').jqxNumberInput('val');
        cost = (cost != undefined) ? parseFloat(cost) : 0.00;
        var costDuty = $('#item_Cost_Duty').jqxNumberInput('val');
        costDuty = (costDuty != undefined) ? parseFloat(costDuty) : 0.00;
        var costFreight = $('#item_Cost_Freight').jqxNumberInput('val');
        costFreight = (costFreight != undefined) ? parseFloat(costFreight) : 0.00;
        var costExtra = $('#item_Cost_Extra').jqxNumberInput('val');
        costExtra = (costExtra != undefined) ? parseFloat(costExtra) : 0.00;
        //
        var total = cost + costFreight  + costDuty + costExtra;
        $('#item_Cost_Landed').jqxNumberInput('val', total);
    };

    $scope.itemCellSelectedOnGrid = {};
    $scope.currentImages = [];
    function onClickDraggableItem() {
        var itemWindow = itemsMenuWindow;
        $('.draggable')
            .on('dblclick', function(e) {
            $('#editItem_ItemSelected').jqxComboBox({
                source: dataAdapterItems('ASC') // []
            });
            //
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
                var dataToSend = {
                    'MenuCategoryUnique': $this.data('categoryId'),
                    'Column': $this.data('col'),
                    'Row': $this.data('row')
                };
                $.ajax({
                    'url': SiteRoot + 'admin/MenuItem/getItemByPositions',
                    'method': 'post',
                    'data': dataToSend,
                    'async': false,
                    'dataType': 'json',
                    'success': function(data) {
                        $scope.itemCellSelectedOnGrid = data;
                        // Load images
                        $scope.uploader.flow.files = [];
                        $scope.currentImages = [];
                        angular.forEach(data.pictures, function(el, key) {
                            $scope.currentImages.push({
                                name: el.File,
                                newName: el.File,
                                path: el.path
                            });
                        });

                        var selectedIndexItem;
                        var itemCombo = $('#editItem_ItemSelected').jqxComboBox('getItemByValue', data['Unique']);
                        if (itemCombo)
                            selectedIndexItem = itemCombo.index;
                        else selectedIndexItem = 0;
                        // Pending..
                        setTimeout(function() {
                            $('#editItem_ItemSelected').jqxComboBox({'selectedIndex': selectedIndexItem});
                            $('#editItem_ItemSelected').jqxComboBox({disabled: true});
                            $('#saveItemGridBtn').prop('disabled', true);
                        //     $('#editItem_ItemSelected').val(data['Unique']);
                        }, 250);

                        $('#editItem_Status').val(data['LayoutStatus']);
                        var label = (data['MenuItemLabel'] == '' || data['MenuItemLabel'] == null)
                                    // ? $('#editItem_ItemSelected').jqxComboBox('getItem', selectedIndexItem).label
                                    ? ''
                                    : data['MenuItemLabel'];
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
                        $('#itemq_sellprice').val(data.price1 != null ? data.price1 : 0);
                        $('#menuitem_listPrice').val(data.ListPrice != null ? data.ListPrice : 0);
                        $('#menuitem_price1').val(data.price1 != null ? data.price1 : 0);
                        $('#menuitem_price2').val(data.price2 != null ? data.price2 : 0);
                        $('#menuitem_price3').val(data.price3 != null ? data.price3 : 0);
                        $('#menuitem_price4').val(data.price4 != null ? data.price4 : 0);
                        $('#menuitem_price5').val(data.price5 != null ? data.price5 : 0);
                        $('#menuitem_priceModify').val(data.PriceModify != null ? data.PriceModify : 0);
                        // Cost Tab
                        var cost = (data.Cost == null) ? 0 : parseFloat(data.Cost);
                        var costExtra = (data.Cost_Extra == null) ? 0 : parseFloat(data.Cost_Extra);
                        var costFreight = (data.Cost_Freight == null) ? 0 : parseFloat(data.Cost_Freight);
                        var costDuty = (data.Cost_Duty == null) ? 0 : parseFloat(data.Cost_Duty);
                        var landed =  cost + costExtra + costFreight + costDuty;
                        $('#item_cost').jqxNumberInput('val', cost);
                        $('#item_Cost_Extra').jqxNumberInput('val', costExtra);
                        $('#item_Cost_Freight').jqxNumberInput('val', costFreight);
                        $('#item_Cost_Duty').jqxNumberInput('val', costDuty);
                        $('#item_Cost_Landed').jqxNumberInput('val', landed);
                        // Tax tab TODO Missing store taxes on menu item
                        $('#taxesGridMitem').jqxGrid({                   // ↓ Item Unique ↓
                            'source':  inventoryExtraService.getTaxesGridData(data.Unique).source
                        });
                        // Extra tab values
                        var gc;
                        // gc = $('#itemcontrol_giftcard .cbxExtraTab[data-val=' +
                        //     ((data.GiftCard == 0 || data.GiftCard == null) ? '0' : '1') +']');
                        // gc.jqxRadioButton({ checked:true });
                        $('#itemcontrol_gcard').val(data.GiftCard);
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
                        $('#itemcontrol_itemlabelpos').val(data.ItemLabelVal != null ? data.ItemLabelVal : '');
                        // New fields on main tab for Item table
                        var description = (data.Description != null) ? data.Description : '';
                        $('#itemcontrol_description').val($.trim(description));
                        //-- Styles --//
                        var bpc;
                        // Primary Button Color
                        if (data['ButtonPrimaryColor'])
                            bpc = data['ButtonPrimaryColor'];
                        else
                            bpc = $('#mitButtonPrimaryColorDef').val();
                        $('#ddb_mitbPrimaryColor').jqxDropDownButton('setContent', getTextElementByColor(new $.jqx.color({ hex: bpc })));
                        if ($('#mitbPrimaryColor').jqxColorPicker('getColor') == undefined)
                            $scope.mitbPrimaryColor = bpc;
                        else
                            $('#mitbPrimaryColor').jqxColorPicker('setColor', '#' + bpc);
                        // Secondary Button Color
                        if (data['ButtonSecondaryColor'])
                            bpc = data['ButtonSecondaryColor'];
                        else
                            bpc = $('#mitButtonSecondaryColorDef').val();
                        // $scope.ddb_mitbSecondaryColor.setContent(getTextElementByColor(new $.jqx.color({ hex: bpc })));
                        $('#ddb_mitbSecondaryColor').jqxDropDownButton('setContent', getTextElementByColor(new $.jqx.color({ hex: bpc })));
                        if ($('#mitbSecondaryColor').jqxColorPicker('getColor') == undefined)
                            $scope.mitbSecondaryColor = bpc;
                        else
                            $('#mitbSecondaryColor').jqxColorPicker('setColor', '#' + bpc);
                        // Label Font Color
                        if (data['LabelFontColor'])
                            bpc = data['LabelFontColor'];
                        else
                            bpc = $('#mitLabelFontColorDef').val();
                        // $scope.ddb_mitlfontColor.setContent(getTextElementByColor(new $.jqx.color({ hex: bpc })));
                        $('#ddb_mitlfontColor').jqxDropDownButton('setContent', getTextElementByColor(new $.jqx.color({ hex: bpc })));
                        if ($('#mitlfontColor').jqxColorPicker('getColor') == undefined)
                            $scope.mitlfontColor = bpc;
                        else
                            $('#mitlfontColor').jqxColorPicker('setColor', '#' + bpc);
                        // Label Font Size
                        var lfs = (data['LabelFontSize']) ? data['LabelFontSize'] :$('#mitLabelFontSizeDef').val();
                        $('#mitlfontSize').val(lfs);
                        // Main Printer
                        if (data.PrimaryPrinter != null) {
                            var printer = $('#mainPrinterSelect').jqxDropDownList('getItemByValue', data.PrimaryPrinter);
                            $('#mainPrinterSelect').jqxDropDownList({
                                selectedIndex: (printer) ? printer.index : -1,
                                disabled: true
                            });
                            $('#editMainPrinterBtn').show();
                        } else {
                            mainPrinterSet();
                            setTimeout(function() {
                                $('#mainPrinterSelect').jqxDropDownList({
                                    selectedIndex: -1,
                                    disabled: false
                                });
                            }, 100);
                            $('#editMainPrinterBtn').hide();
                        }
                        //
                        $('#saveItemGridBtn').prop('disabled', true);
                        // $('#deleteItemGridBtn').show();
                        var btn = $('<button/>', {
                            'id': 'deleteItemGridBtn'
                        }).addClass('icon-trash user-del-btn').css('left', 0);
                        var title = $('<div/>').html('Edit Menu Item: ' + data.MenuItemUnique + ' | Item ID: '+ data.Unique +' | Item: ' + data.Item + ' | Label: ' + label).prepend(btn)
                            .css('padding-left', '2em');
                        itemWindow.setTitle(title);
                        itemWindow.open();
                    }
                });
            } else {
                $scope.ItemModalStateAction = 'new';
                $scope.ItemModalID = null;
                $('#pricestabItemModal').hide();
                $('#costtabItemModal').hide();
                $('#optionstabItemModal').hide();
                $('#itemsModalCreateTabs').jqxTabs('select', 0);
                setTimeout(function() {
                    $('#item_Description').focus();
                }, 150);
                itemsModalCreate.setTitle('Create Item');
                itemsModalCreate.open();
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

    $scope.editMainPrinter = function() {
        $('#jqxTabsMenuItemWindows').jqxTabs({selectedItem: 3});
    };

    var resetMenuItemForm = function() {
        var itemCombo, selectedIndexItem;
            // itemCombo = $('#editItem_ItemSelected').jqxComboBox('getItemByValue', $scope.selectedItemInfo.Unique);
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
        $('#editItem_sort').val(2);
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
                'Column': $this.data('col')
            };
            $.ajax({
                'url': SiteRoot + 'admin/MenuItem/postMenuItems',
                'method': 'POST',
                'data': dataToReq,
                'dataType': 'json',
                'success': function (data) {
                    if (data.status == 'success') {
                        var label = $scope.selectedItemInfo.Description;
                        $this.html(
                            "<div class='priceContent'>"+$scope.selectedItemInfo.price1 +
                            "</div><div class='labelContent'>"+ label + "</div>"
                        );
                        //$this.html($scope.selectedItemInfo.Description);
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

            // $('#deleteItemGridBtn').hide();
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
                onTargetDrop: function(data) {},
                revert: true,
                opacity: 0.9
            }
        );

        $('#selectedItemInfo, .jqx-listitem-element')
            .unbind('dragStart')
            .unbind('dragEnd')
            .unbind('dropTargetEnter')
            .unbind('dropTargetLeave');
        var ItemOnAboveGrid = false;
        var rowUsed, colUsed;
        $('#selectedItemInfo, .jqx-listitem-element')
        .bind('dragStart', function (event) {
            $('.restricter-dragdrop').css({'border': '#202020 dotted 3px'});
            // Modify previous clone dragging element
            var nw = $('.filled.itemOnGrid.jqx-draggable').width();
            // var baseLeft = $('.selectedItemInfoClass.jqx-draggable.jqx-draggable-dragging').css('left');
            var _self = event.args.data.self;
            if (_self._isTouchDevice) {
                var toAdd = _self._offset.click.left;
            }
            else {
                var toAdd = event.args.offsetX;
                // var toAddy = event.args.offsetY;
            }

            $('.selectedItemInfoClass.jqx-draggable.jqx-draggable-dragging,' +
                '.jqx-listitem-element.jqx-draggable.jqx-draggable-dragging')
                .css({
                    'width': nw,
                    // 'margin-left': parseInt(baseLeft) + parseInt(toAdd),
                    'margin-left': parseInt(toAdd),
                });
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
                    'Row': rowUsed,
                    'Column': colUsed
                };
                $.ajax({
                    'url': SiteRoot + 'admin/MenuItem/postMenuItems',
                    'method': 'POST',
                    'data': data,
                    'dataType': 'json',
                    'success': function (data) {
                        if (data.status == 'success') {
                            $this.html(
                                "<div class='priceContent'>"+$scope.selectedItemInfo.price1 +
                                "</div>" +
                                "<div class='labelContent'>"+ $scope.selectedItemInfo.Description +
                                "</div>"
                            );
                            $this.addClass('filled');
                            $this.addClass('itemOnGrid');
                            $this.data('categoryId', $scope.selectedCategoryInfo.Unique);
                            //$this.css('background-color', '#063dee');
                            $this.css('background-color', '#7C2F3F');
                            draggableEvents();
                            setTimeout(function() {
                                angular.element('.category-cell-grid.clicked').triggerHandler('click');
                            }, 100);
                        }
                        else if (data.status == 'error') {
                            $.each(data.message, function(i, value){
                                // alert(value);
                                $('#notification-window .text-content').html('' +
                                    'Cell is already occupied. To use, please move or delete item.'
                                );
                                $('#notification-window').jqxWindow('open');
                                return;
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
            rowUsed = $(event.args.target).data('row')
            colUsed = $(event.args.target).data('col');
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

            // $('.itemOnGrid')
            //     .unbind('dragStart')
            //     .unbind('dragEnd')
            //     .unbind('dropTargetEnter')
            //     .unbind('dropTargetLeave');

            $('.itemOnGrid').jqxDragDrop(
                {
                    dropTarget: $('.draggable'),
                    restricter: '.restricter-dragdrop',
                    //tolerance: 'fit'
                    onTargetDrop: function(data) {},
                    dropAction: 'none',
                    revert: true
                }
            )
            .bind('dragStart', function (event) {
                //$(this).removeClass('draggable');
                //$(this).jqxDragDrop( { dropTarget: $('.draggable').not($(this)) } );
                $(this).jqxDragDrop( { dropTarget: $('div[id^="draggable-"]').not($(this)) } );
                //
                var nw = $('.filled.itemOnGrid.jqx-draggable:first').width();
                var nh = $('.filled.itemOnGrid.jqx-draggable:first').height();
                var _self = event.args.data.self;
                if (_self._isTouchDevice) {
                    var toAddx = _self._offset.click.left
                    var toAddy = _self._offset.click.top;
                }
                else {
                    var toAddx = event.args.offsetX;
                    var toAddy = event.args.offsetY;
                }
                //
                $('.draggable.filled.itemOnGrid.jqx-draggable.jqx-draggable-dragging')
                    .css({
                        'width': nw - parseInt(nh / 2),
                        'height': nh - parseInt(nh / 2),
                        'margin-left': parseInt(toAddx),
                        'margin-top': parseInt(toAddy)
                    });
            })
            .bind('dragEnd', function (event) {
                //$(this).addClass('draggable');
                if (onCellAboveGrid) {
                    // if (!isEqual($scope.onGridTargetMoved, $scope.onGridElementMoved)) {
                    if ($scope.targetIsFilled) {
                        $('#notification-window .text-content').html(
                            'Cell is already occupied. To use, please move or delete item.'
                        );
                        $('#notification-window').jqxWindow('open');
                        $('.draggable:not(#selectedItemInfo)').css({'border': 'solid black 1px'});
                        return;
                    } else {
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
                $scope.targetIsFilled = $(event.args.target).hasClass('itemOnGrid');
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

        $('#notification-window').jqxWindow({
            okButton: $('#notification-window #ok'), //cancelButton: $('#cancel'),
            initContent: function () {
                $('#ok').focus();
                // var offset = $('#notification-window').offset();
                $('#notification-window')
                    .jqxWindow({'position':{ x: 'center', y: 150}})
            }
        });
}

    /**
     * QUESTION TAB ACTIONS
     */
    $scope.questionTableOnMenuItemsSettings = inventoryExtraService.getQuestionGridData(null, true);

    var updateQuestionItemTable = function() {
        $('#questionItemTable').jqxGrid({
            source: new $.jqx.dataAdapter(
                // inventoryExtraService.getQuestionGridData($('#editItem_ItemSelected').jqxComboBox('getSelectedItem').value).source
                inventoryExtraService.getQuestionGridData($('#editItem_ItemSelected').val()).source
            ),
            rowdetails: true,
            initrowdetails: questionService.getRowdetailsFromChoices('QuestionUnique'),
            rowdetailstemplate: {
                rowdetails: "<div class='choicesNestedGrid'></div>",
                rowdetailsheight: 100,
                rowdetailshidden: true
            }
        });
        var questions = $('#itemq_Question').jqxComboBox('getItems');
        $.each(questions, function(i, el) {
            $('#itemq_Question').jqxComboBox('enableItem', el);
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
        width: "50%", height: "52%",
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

    $scope.qitemsCbxSelecting = function (e) {
        if (e.args) {
            var item = e.args.item;
            // $('#itemq_sellprice').val(item.originalItem.price1);
            // $('#itemq_sellprice').val($scope.itemCellSelectedOnGrid.price1);
        }
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
        // $('#deleteQuestionItemBtn').hide();
        $scope.addOrEditqItem = 'create';
        questionOnItemGridWindow.setTitle('Add New Question | Item: ' + $('#editItem_ItemSelected').val());
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
        // $('#deleteQuestionItemBtn').show();
        $scope.addOrEditqItem = 'edit';
        $scope.qItemIdChosen = row.Unique;
        //
        var btn = $('<button/>', {
            'id': 'deleteQuestionItemBtn'
        }).addClass('icon-trash user-del-btn').css('left', 0);
        var title = $('<div/>').html('Edit Question: ' + row.QuestionUnique +' | Item: ' + row.ItemUnique).prepend(btn)
            .css('padding-left', '2em');
        questionOnItemGridWindow.setTitle(title);
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
                'ItemUnique': $('#editItem_ItemSelected').val()
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

    $('body').on('click', '#deleteQuestionItemBtn', function() {
        $scope.deleteQuestionItem();
    });

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
                {name: 'Primary', type: 'string'},
                {name: 'primaryLabel', type: 'string'},
                {name: 'fullDescription', type: 'string'}
            ],
            url: ''
        },
        columns: [
            {text: 'ID', dataField: 'Unique', type: 'int', width: '10%'},
            {text: 'Item', dataField: 'Item', type: 'string', hidden: true},
            {text: 'Name', dataField: 'name', type: 'string', width: '25%'},
            {text: 'Description', dataField: 'description', type: 'string', width: '55%'},
            {text: '', dataField: 'ItemUnique', type: 'int', hidden: true},
            {text: '', dataField: 'Status', type: 'int', hidden: true},
            {text: '', dataField: 'fullDescription', type: 'string', hidden: true},
            {dataField: 'Primary', hidden: true},
            {text: 'Primary', dataField: 'primaryLabel', type: 'string', width: '10%'}
        ],
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
                    {name: 'Primary', type: 'string'},
                    {name: 'primaryLabel', type: 'string'},
                    {name: 'fullDescription', type: 'string'}
                ],
                // url: SiteRoot + 'admin/MenuPrinter/load_allItemPrinters/' + $('#editItem_ItemSelected').jqxComboBox('getSelectedItem').value
                url: SiteRoot + 'admin/MenuPrinter/load_allItemPrinters/' + $('#editItem_ItemSelected').val()
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
        width: "52%", height: "32%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    // Printer dropdownlist
    var printerDataadapter = function(empty) {
        var url = '';
        if (empty == undefined)
            url = SiteRoot + 'admin/MenuPrinter/load_allPrintersFromConfig';

        return new $.jqx.dataAdapter({
            datatype: "json",
            datafields: [
                { name: 'name'},
                { name: 'description'},
                { name: 'fullDescription'},
                { name: 'status' },
                { name: 'unique' }
            ],
            url: url
        });
    };

    $('#printerItemList').on('select', function(e) {
        $('#saveBtnPrinterItem').prop('disabled', false);
    });
    $('#primaryCheckItemContainer #primaryPrinterChbox').on('change', function(e) {
        $('#saveBtnPrinterItem').prop('disabled', false);
    });

    $scope.printerItemList = { source: printerDataadapter(), displayMember: "fullDescription", valueMember: "unique" };

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
        $scope.itemSelectedChangedID = $('#editItem_ItemSelected').val();
        $scope.createOrEditPitem = 'create';
        $scope.itemPrinterID = null;
        // Printers saved by Item
        setPrinterStoredArray();
        //
        var isTherePrinter = $('#jqxTabsMenuItemWindows #printerItemTable').jqxGrid('getRows');
        if (isTherePrinter.length > 0)
            $('#primaryCheckItemContainer').show();
        else
            $('#primaryCheckItemContainer').hide();
        $('#primaryCheckItemContainer #primaryPrinterChbox').jqxCheckBox({checked: false});
        //
        $("#printerItemList").jqxDropDownList({selectedIndex: -1});
        // $('#deleteBtnPrinterItem').hide();
        $('#saveBtnPrinterItem').prop('disabled', true);
        printerItemWind.setTitle('New Item Printer');
        printerItemWind.open();
    };

    $scope.updateItemPrinter = function(e) {
        var row = e.args.row.bounddata;
        $scope.itemSelectedChangedID = $('#editItem_ItemSelected').val();
        $scope.openPrinterItemWin();
        var btn = $('<button/>', {
            'id': 'deleteBtnPrinterItem'
        }).addClass('icon-trash user-del-btn').css('left', 0);
        var title = $('<div/>').html('Edit Item Printer | Item: ' + row.ItemUnique + ' | Printer ID: ' + row.PrinterUnique)
            .prepend(btn)
            .css('padding-left', '2em');
        printerItemWind.setTitle(title);
        //
        $('#primaryCheckItemContainer').show();
        $('#primaryCheckItemContainer #primaryPrinterChbox').jqxCheckBox({checked: (row.Primary == 1) ? true : false});
        //
        $scope.createOrEditPitem = 'edit';
        $scope.itemPrinterID = row.Unique;
        // $('#deleteBtnPrinterItem').show();
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
        var isTherePrinter = $('#jqxTabsMenuItemWindows #printerItemTable').jqxGrid('getRows');
        if (isTherePrinter.length > 0) {
            if ($('#primaryCheckItemContainer #primaryPrinterChbox').jqxCheckBox('checked')) {
                $scope.itemCellSelectedOnGrid.PrimaryPrinter = $('#printerItemList').jqxDropDownList('getSelectedItem').value;
                data['Primary'] = 1;
            }
        }
        else {
            $scope.itemCellSelectedOnGrid.PrimaryPrinter = $('#printerItemList').jqxDropDownList('getSelectedItem').value;
            data['Primary'] = 1;
        }
        //
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

    $('body').on('click', '#deleteBtnPrinterItem', function() {
        $scope.beforeDeleteItemPrinter();
    });

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
        spinButtons: true,
        min: 1,
        textAlign: 'left',
        width: '50px',
        height: 25
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

    /**
     * Upload pictures to item
     * @type {{}}
     */
    $scope.uploader = {};
    $scope.successUploadNames = [];
    var mimesAvailable = ['image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'];
    $scope.submitUpload = function (files, e, flow) {
        var type = files[0].file.type;
        if (mimesAvailable.indexOf(type) > -1) {
            $scope.uploader.flow.upload();
        } else {
            $('#menuitemNotificationsErrorSettings #notification-content')
                .html('Only PNG, JPG and GIF files types allowed.');
            $scope.menuitemNotificationsErrorSettings.apply('open');
            var last = $scope.uploader.flow.files.length - 1;
            $scope.uploader.flow.files.splice(last, 1);
        }
    };

    $scope.successUpload = function (e, response, flow) {
        // console.log('sucess upload...', arguments);
        var resp = JSON.parse(response);
        var last = $scope.uploader.flow.files.length - 1;
        if (!resp.success) {
            $scope.uploader.flow.files.splice(last, 1);
            $('#menuitemNotificationsErrorSettings #notification-content')
                .html(resp.errors);
            $scope.menuitemNotificationsErrorSettings.apply('open');
        } else {
            $scope.uploader.flow.files[last]['newName'] = resp.newName;
            $scope.successUploadNames.push(resp.newName);
            $scope.currentImages.splice(0, 1);
            $('#saveItemGridBtn').prop('disabled', false);
        }
    };

    $scope.errorUpload = function (file, msg, flow) {};

    $scope.fileAddedUpload = function (file, event, flow) {
        var type = file.file.type;
    };

    $scope.removingImageSelected = function(i, option) {
        if (option == 1)
            var list = $scope.uploader.flow.files;
        else
            var list = $scope.currentImages;
        var foundPic =
            $scope.successUploadNames.indexOf(list[i].newName);
        //
        $scope.successUploadNames.splice(foundPic, 1);
        $scope.currentImages.splice(0, 1);
        $scope.uploader.flow.files.splice(i, 1);
        // $http.post(SiteRoot + '', {})
        //     .success(function(){
        //
        //     })
        if (option == 1) {
            if ($scope.successUploadNames.length <= 0)
                $('#saveItemGridBtn').prop('disabled', true);
        } else if (option == 2) {
            $('#saveItemGridBtn').prop('disabled', false);
        }
    };

    /**
     * Style Subtab
     */
    function getTextElementByColor(color) {
        if (color == 'transparent' || color.hex == "") {
            $('#mitlfontSize').val('12px');
            var el =  $("<div style='text-shadow: none; position: relative; padding-bottom: 2px; margin-top: 2px;'>#000000</div>");
            el.css({'color': 'white', 'background': '#000000'});
            el.addClass('jqx-rc-all');
            return el;
        }
        var element = $("<div style='text-shadow: none; position: relative; padding-bottom: 2px; margin-top: 2px;'>#" + color.hex + "</div>");
        var nThreshold = 105;
        var bgDelta = (color.r * 0.299) + (color.g * 0.587) + (color.b * 0.114);
        var foreColor = (255 - bgDelta < nThreshold) ? 'black' : 'white';
        element.css({'color': foreColor, 'background': "#" + color.hex});
        element.addClass('jqx-rc-all');
        return element;
    }

    $scope.qColorCreated = false;
    $scope.ddb_mitbPrimaryColor = {};
    $scope.ddb_mitbSecondaryColor = {};
    $scope.ddb_mitlfontColor  = {};
    $scope.qOpening = function (event) {
        $scope.qColorCreated = true;
    };

    $scope.mitColorChange = function (event) {
        var id = $(event.target).attr('id');
        var el = $(event.target).data('layout');
        // $scope['ddb_' + id].setContent(getTextElementByColor(event.args.color));
        $('#ddb_' + id).jqxDropDownButton('setContent', getTextElementByColor(event.args.color));
        if (el == 'item')
            $('#saveItemGridBtn').prop('disabled', false);
        else if (el == 'categ')
            $('#savemitcemOneCategoryBtn').prop('disabled', false);
    };

    $scope.$on('jqxDropDownButtonCreated', function (event, arguments) {
        arguments.instance.setContent(getTextElementByColor(new $.jqx.color({ hex: "000000" })));
    });

});