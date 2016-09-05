/**
 * Created by carlosrenato on 08-31-16.
 */
app.controller('menuItemsInventoryController', function($scope, $http, itemInventoryService, inventoryExtraService){

    $scope.inventoryData = {};
    $scope.inventoryDisabled = true;
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
    // CheckBox settings
    $scope.checkBoxInventory = {
        width: '10%',
        height: '25',
        theme: 'summer'
    };

    $scope.onSelectCategoryCbx = function(e) {
        //var id = e.args.index;
        if (e.args.item != null) {
            var id = e.args.item.value;
            $scope.subcategoryCbxSettings = inventoryExtraService.getSubcategoriesSettings(id);
            $('#item_subcategory').jqxComboBox({'selectedIndex': -1});
        }
    };

    $scope.onChangeItemNumber = function() {
        var itemNumber;
        if ($scope.createOrEditItemInventory == 'create') {
            itemNumber = $scope.inventoryData.item;
            $scope.inventoryData.part = itemNumber;
            $scope.inventoryData.supplierPart = itemNumber;
        } else if ($scope.createOrEditItemInventory == 'edit') {

        }
    };

    $scope.onChangeCostFields = function() {
        var cost = ($scope.inventoryData.cost);
        cost = (cost != undefined) ? parseFloat(cost) : 0.00;
        var costDuty = ($scope.inventoryData.costDuty);
        costDuty = (costDuty != undefined) ? parseFloat(costDuty) : 0.00;
        var costFreight = ($scope.inventoryData.costFreight);
        costFreight = (costFreight != undefined) ? parseFloat(costFreight) : 0.00;
        var costExtra = ($scope.inventoryData.costExtra);
        costExtra = (costExtra != undefined) ? parseFloat(costExtra) : 0.00;
        //
        var total = cost + costFreight  + costDuty + costExtra;
        $scope.inventoryData.costLanded = total;
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
        $('#iteminventory_giftcard .cbxExtraTab[data-val=0]').jqxRadioButton({ checked:true });
        $('#iteminventory_group .cbxExtraTab[data-val=0]').jqxRadioButton({ checked:true });
        $('#iteminventory_promptprice .cbxExtraTab[data-val=0]').jqxRadioButton({ checked:true });
        $('#iteminventory_promptdescription .cbxExtraTab[data-val=0]').jqxRadioButton({ checked:true });
        $('#iteminventory_EBT .cbxExtraTab[data-val=0]').jqxRadioButton({ checked:true });
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
        $scope.inventoryData.listPrice = row.ListPrice;
        $scope.inventoryData.price1 = row.price1;
        $scope.inventoryData.costLanded =
            parseFloat(row.Cost) + parseFloat(row.Cost_Duty) + parseFloat(row.Cost_Freight) + parseFloat(row.Cost_Extra);
        // Item text controls
        $('.inventory_tab .item_textcontrol').each(function(i, el) {
            var field = $(el).data('field');
            if (field != undefined) {
                $(el).val($.trim(row[field]));
            }
        });
        // Item combobox controls
        var category = $('#item_category').jqxComboBox('getItemByValue', row['CategoryId']);
        $('#item_category').jqxComboBox({'selectedIndex': (category != null) ? category.index : -1});
        var supplier = $('#item_supplier').jqxComboBox('getItemByValue', row['SupplierId']);
        $('#item_supplier').jqxComboBox({'selectedIndex': (supplier != null) ? supplier.index : -1});
        var brand = $('#item_brand').jqxComboBox('getItemByValue', row['BrandId']);
        $('#item_brand').jqxComboBox({'selectedIndex': (brand != null) ? brand.index : -1});
        var subcategory = $('#item_subcategory').jqxComboBox('getItemByValue', row['SubCategoryId']);
        $('#item_subcategory').jqxComboBox({'selectedIndex': (subcategory != null) ? subcategory.index : -1});
        // Item checkbox controls
        var gc;
        gc = $('#iteminventory_giftcard .cbxExtraTab[data-val=' +
            ((row.GiftCard == 0 || row.GiftCard == null) ? '0' : '1') +']');
        gc.jqxRadioButton({ checked:true });
        gc = $('#iteminventory_group .cbxExtraTab[data-val=' +
            ((row.Group == 0 || row.Group == null) ? '0' : '1') +']');
        gc.jqxRadioButton({ checked:true });
        gc = $('#iteminventory_promptprice .cbxExtraTab[data-val=' +
            ((row.PromptPrice == 0 || row.PromptPrice == null) ? 0 : 1) +']');
        gc.jqxRadioButton({ checked:true });
        gc = $('#iteminventory_promptdescription .cbxExtraTab[data-val=' +
            (row.PromptDescription == 0 || row.PromptDescription == null ? 0 : 1) +']');
        gc.jqxRadioButton({ checked:true });
        gc = $('#iteminventory_EBT .cbxExtraTab[data-val=' +
            ((row.EBT == 0 || row.EBT == null) ? 0 : 1) +']');
        gc.jqxRadioButton({ checked:true });
        //
        $('#saveInventoryBtn').prop('disabled', true);
        inventoryWind.setTitle('Edit Item ID: '+ row.Unique + ' | Item: ' + row.Item + '| ' + row.Description);
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
        data['SupplierUnique'] = (supplier != null) ? $.trim(supplier.value) : null;
        var brand = $('#item_brand').jqxComboBox('getSelectedItem');
        data['BrandUnique'] = (brand != null) ? $.trim(brand.value) : null;
        var category = $('#item_category').jqxComboBox('getSelectedItem');
        data['MainCategory'] = (category != null) ? $.trim(category.value) : null;
        var subcategory = $('#item_subcategory').jqxComboBox('getSelectedItem');
        data['CategoryUnique'] = (subcategory != null) ? $.trim(subcategory.value) : null;
        //
        data['GiftCard'] =
        ($('#iteminventory_giftcard [aria-checked="true"]').length > 0) ?
            $('#iteminventory_giftcard [aria-checked="true"]').data('val') :
            0;
        data['Group'] =
        ($('#iteminventory_group [aria-checked="true"]').length > 0) ?
            $('#iteminventory_group [aria-checked="true"]').data('val') :
            0;
        data['PromptPrice'] =
        ($('#iteminventory_promptprice [aria-checked="true"]').length > 0) ?
            $('#iteminventory_promptprice [aria-checked="true"]').data('val') :
            0;
        data['PromptDescription'] =
        ($('#iteminventory_promptdescription [aria-checked="true"]').length > 0)
            ? $('#iteminventory_promptdescription [aria-checked="true"]').data('val')
            : 0,
        data['EBT'] =
            ($('#iteminventory_EBT [aria-checked="true"]').length > 0)
            ? $('#iteminventory_EBT [aria-checked="true"]').data('val')
            : 0;

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
                            $scope.itemInventoryID = data.id;
                            showingNotif(data.message, 1);
                            inventoryWind.setTitle('Edit Item ID: '+ data.id + ' | Item: ' + dataRequest.Item + '| ' + dataRequest.Description);
                        }
                        else if ($scope.createOrEditItemInventory = 'edit') {
                            showingNotif(data.message, 1);
                        }
                        //
                        updateItemsInventoryGrid();
                        $('#saveInventoryBtn').prop('disabled', true);
                        //$scope.closeInventoryWind(1);
                    }
                    else if (data.status == 'error')
                        showingNotif(data.message, 0);
                    else
                        showingNotif(data.message, 0);
                }
            });
        }
    };
});
