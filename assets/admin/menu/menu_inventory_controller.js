/**
 * Created by carlosrenato on 08-31-16.
 */
app.controller('menuItemsInventoryController', function($scope, $http, itemInventoryService, inventoryExtraService){

    // Events added
    itemInventoryService.onChangeEvents();

    $('#MenuCategoriesTabs').on('tabclick', function (e) {
        var tabclicked = e.args.item;
        // Items Inventory TAB - Reload queries
        if (tabclicked == 1) {
            updateItemsInventoryGrid();
        }
    });

    $scope.inventoryItemsGrid = itemInventoryService.getInventoryGridData;
    var updateItemsInventoryGrid = function() {
        $('#inventoryItemsGrid').jqxGrid({
            source: itemInventoryService.getInventoryGridData.source
        });
    };

    var inventoryWind;
    $scope.itemsInventoryWindowSettings = {
        created: function (args) {
            inventoryWind = args.instance;
        },
        resizable: false,
        width: "50%", height: "100%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };
    // Notifications settings
    $scope.inventorySuccessMsg = itemInventoryService.setNotificationSettings(1);
    $scope.inventoryErrorMsg = itemInventoryService.setNotificationSettings(0);
    // ComboBox settings
    $scope.supplierCbxSettings = inventoryExtraService.getSupplierSettings();
    $scope.brandCbxSettings = inventoryExtraService.getBrandsSettings();
    $scope.categoryCbxSettings = inventoryExtraService.getCategoriesSettings();
    $scope.subcategoryCbxSettings = inventoryExtraService.getSubcategoriesSettings();

    $scope.onSelectCategoryCbx = function(e) {
        //var id = e.args.index;
        if (e.args.item != null) {
            var id = e.args.item.value;
            $scope.subcategoryCbxSettings = inventoryExtraService.getSubcategoriesSettings(id);
            $('#item_subcategory').jqxComboBox({'selectedIndex': -1});
        }
    };

    $scope.closeInventoryWind = function(close) {
        $('#inventoryTabs').jqxTabs('select', 0);
        $('.inventory_tab .item_textcontrol').each(function(i, el) {
            $(el).val('');
        });
        //
        $('#item_supplier').jqxComboBox({'selectedIndex': -1});
        $('#item_brand').jqxComboBox({'selectedIndex': -1});
        $('#item_category').jqxComboBox({'selectedIndex': -1});
        $('#item_subcategory').jqxComboBox({'selectedIndex': -1});
        //
        $('#saveInventoryBtn').prop('disabled', true);
        if (close == 1)
            inventoryWind.close();
    };

    $scope.closeInventoryAction = function(option) {
        if (option != undefined) {
            $('#mainButtonsOnItemInv').show();
            $('#promptCloseItemInv').hide();
            $('#promptToDeleteItemInv').hide();
        }
        if (option == 0) {
            $scope.saveInventoryAction(true);
        } else if (option == 1) {
            $scope.closeInventoryWind(1);
        } else if (option == 2) {

        } else {
            if ($('#saveInventoryBtn').is(':disabled')) {
                $scope.closeInventoryWind(1);
            } else {
                $('#mainButtonsOnItemInv').hide();
                $('#promptCloseItemInv').show();
                $('#promptToDeleteItemInv').hide();
            }
        }
    };

    // Create|Edit Inventory Actions
    $scope.createOrEditItemInventory = null;
    $scope.itemInventoryID = null;
    $scope.openInventoryWind = function() {
        $scope.createOrEditItemInventory = 'create';
        $scope.itemInventoryID = null;
        //
        $('#saveInventoryBtn').prop('disabled', true);
        inventoryWind.setTitle('New Item');
        inventoryWind.open();
    };

    $scope.editInventoryWind = function(e) {
        var row = (e.args.row.bounddata);
        //console.log(row);
        $scope.createOrEditItemInventory = 'edit';
        $scope.itemInventoryID = row.Unique;
        //
        $('.inventory_tab .item_textcontrol').each(function(i, el) {
            var field = $(el).data('field');
            if (field != undefined) {
                $(el).val($.trim(row[field]));
            }
        });
        var category = $('#item_category').jqxComboBox('getItemByValue', row['CategoryId']);
        $('#item_category').jqxComboBox({'selectedIndex': (category != null) ? category.index : -1});
        var supplier = $('#item_supplier').jqxComboBox('getItemByValue', row['SupplierId']);
        $('#item_supplier').jqxComboBox({'selectedIndex': (supplier != null) ? supplier.index : -1});
        var brand = $('#item_brand').jqxComboBox('getItemByValue', row['BrandId']);
        $('#item_brand').jqxComboBox({'selectedIndex': (brand != null) ? brand.index : -1});
        var subcategory = $('#item_subcategory').jqxComboBox('getItemByValue', row['SubCategoryId']);
        $('#item_subcategory').jqxComboBox({'selectedIndex': (subcategory != null) ? subcategory.index : -1});
        //
        $('#saveInventoryBtn').prop('disabled', true);
        inventoryWind.setTitle('Edit Item '+ row.Item + ' | Unique: ' + row.Unique);
        inventoryWind.open();
    };

    var beforeSaveInventory = function() {
        var needValidation = false;
        $('.inventory_tab .req').each(function(i, el) {
            if (el.value == '') {
                showingNotif($(el).attr('placeholder') + " is required", 0);
                $(el).css({'border-color': '#F00'});
                needValidation = true;
            } else
                $(el).css({'border-color': '#CCC'});
        });
        //
        $('.item_combobox.req').each(function(i, el) {
            var combo = $(el).jqxComboBox('selectedIndex');
            if (combo < 0) {
                showingNotif($(el).data('field') + " is required", 0);
                $(el).css({'border-color': '#F00'});
                needValidation = true;
            } else
                $(el).css({'border-color': '#CCC'});
        });
        return needValidation;
    };

    var gettingInventoryValues = function() {
        var data = {};
        $('.inventory_tab .item_textcontrol').each(function(i, el) {
            var field = $(el).data('field');
            if (field != undefined) {
                data[field] = $.trim($(el).val());
            } else {
                console.log('Not found', $(el).attr('id'));
            }
        });
        //
        var supplier = $('#item_supplier').jqxComboBox('getSelectedItem');
        data['SupplierUnique'] = (supplier != null) ? supplier.value : null;
        var brand = $('#item_brand').jqxComboBox('getSelectedItem');
        data['BrandUnique'] = (brand != null) ? brand.value : null;
        var category = $('#item_category').jqxComboBox('getSelectedItem');
        data['MainCategory'] = (category != null) ? category.value : null;
        var subcategory = $('#item_subcategory').jqxComboBox('getSelectedItem');
        data['CategoryUnique'] = (subcategory != null) ? subcategory.value : null;

        return data;
    };

    var showingNotif = function(msg, type) {
        var title = (type == 0) ? 'Error' : 'Success';
        $('#inventory' + title + 'Msg #notification-content').html(msg);
        if (type == 0)
            $scope.inventoryErrorMsg.apply('open');
        else
            $scope.inventorySuccessMsg.apply('open');
    };

    $scope.saveInventoryAction = function(toClose) {
        if (!beforeSaveInventory()) {
            var url = '', dataRequest = gettingInventoryValues();
            if ($scope.createOrEditItemInventory == 'create')
                url = SiteRoot + 'admin/MenuItem/postItemInventory';
            else if ($scope.createOrEditItemInventory = 'edit')
                url = SiteRoot + 'admin/MenuItem/updateItemInventory/' + $scope.itemInventoryID;
            $.ajax({
                method: 'POST',
                url: url,
                data: dataRequest,
                dataType: 'JSON',
                success: function(data) {
                    //console.log(data);
                    if (data.status == 'success') {
                        if ($scope.createOrEditItemInventory == 'create') {
                            $scope.createOrEditItemInventory = 'edit';
                            $scope.itemInventoryID = row.id;
                            showingNotif(data.message, 1);
                        }
                        else if ($scope.createOrEditItemInventory = 'edit') {
                            showingNotif(data.message, 1);
                        }
                        //
                        updateItemsInventoryGrid();
                        //$scope.closeInventoryWind(1);
                    }
                    else if (data.status == 'error')
                        showingNotif(data.message, 0);
                    else
                        showingNotif(data.message, 0);
                }
            })

        }
    };
});
