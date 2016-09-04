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
        $(this).jqxGrid(itemInventoryService.getInventoryGridData.source);
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

    $scope.inventorySuccessMsg = itemInventoryService.setNotificationSettings(1);
    $scope.inventoryErrorMsg = itemInventoryService.setNotificationSettings(0);

    $scope.supplierCbxSettings = inventoryExtraService.getSupplierSettings();
    $scope.brandCbxSettings = inventoryExtraService.getBrandsSettings();
    $scope.categoryCbxSettings = inventoryExtraService.getCategoriesSettings();
    $scope.subcategoryCbxSettings = inventoryExtraService.getSubcategoriesSettings();

    $scope.onSelectCategoryCbx = function(e) {
        //var id = e.args.index;
        var id = e.args.item.value;
        $scope.subcategoryCbxSettings = inventoryExtraService.getSubcategoriesSettings(id);
        $('#item_subcategory').jqxComboBox({'selectedItem': -1});
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
        console.log(close);
        if (close == undefined)
            inventoryWind.close();
    };

    $scope.openInventoryWind = function() {
        inventoryWind.setTitle('New Item');
        inventoryWind.open();
    };

    $scope.editInventoryWind = function(e) {
        var row = (e.args.row.bounddata);
        $('.inventory_tab .item_textcontrol').each(function(i, el) {
            var field = $(el).data('field');
            if (field != undefined) {
                $(el).val(row[field]);
            }
        });
        var supplier = $('#item_supplier').jqxComboBox('getItemByValue', row['SupplierId']);
        $('#item_supplier').jqxComboBox({'selectedIndex': (supplier != null) ? supplier.index : -1});
        var brand = $('#item_brand').jqxComboBox('getItemByValue', row['BrandId']);
        $('#item_supplier').jqxComboBox({'selectedIndex': (brand != null) ? brand.index : -1});
        var category = $('#item_category').jqxComboBox('getItemByValue', row['CategoryId']);
        $('#item_category').jqxComboBox({'selectedIndex': (category != null) ? category.index : -1});
        var subcategory = $('#item_subcategory').jqxComboBox('getItemByValue', row['SubCategoryId']);
        $('#item_subcategory').jqxComboBox({'selectedIndex': (subcategory != null) ? subcategory.index : -1});
        //
        inventoryWind.setTitle('Edit Item '+ row.Item + ' | Unique: ' + row.Unique);
        inventoryWind.open();
    };

    var beforeSaveInventory = function() {
        var needValidation = false;
        $('.inventory_tab .req').each(function(i, el) {
            if (el.value == '') {
                $('#inventoryErrorMsg #notification-content')
                    .html($(el).attr('placeholder') + " is required");
                $scope.inventoryErrorMsg.apply('open');
                needValidation = true;
            }
        });
        return needValidation;
    };

    var gettingInventoryValues = function() {
        var data = {};
        $('.inventory_tab .item_textcontrol').each(function(i, el) {
            var field = $(el).data('field');
            if (field != undefined) {
                data[field] = $(el).val();
            } else {
                console.log('Not found', $(el).attr('id'));
            }
        });
        //
        var supplier = $('#item_supplier').jqxComboBox('getSelectedItem');
        data['SupplierUnique'] = (supplier != null) ? supplier.value : null;
        var brand = $('#item_brand').jqxComboBox('getSelectedItem');
        data['BrandUnique'] = (brand != null) ? brand.value : null;
        var category = $('#item_subcategory').jqxComboBox('getSelectedItem');
        data['CategoryUnique'] = (category != null) ? category.value : null;

        return data;
    };

    $scope.saveInventoryAction = function() {
        if (!beforeSaveInventory()) {
            var dataRequest = gettingInventoryValues();
            $.ajax({
                method: 'POST',
                url: SiteRoot + 'admin/MenuItem/postItemInventory',
                data: dataRequest,
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    $scope.closeInventoryWind();
                }
            })

        }
    };
});
