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
        var tabTitle = $('#MenuCategoriesTabs').jqxTabs('getTitleAt', tabclicked);
        // Items Inventory TAB - Reload queries
        if (tabTitle == 'Items') {
            updateItemsInventoryGrid(1);
        }
    });

    //
    $('#inventoryTabs').on('selecting', function(e) {
        var tabclick = e.args.item;
        var tabTitle = $('#inventoryTabs').jqxTabs('getTitleAt', tabclick);
        if (tabTitle == 'Item')
            $('#deleteInventoryBtn').show();
        else
            $('#deleteInventoryBtn').hide();
        // Required tabs to create item
        var itemCreatedRequired = ['Stock Level', 'Barcode', 'Questions', 'Printers'];
        if (itemCreatedRequired.indexOf(tabTitle) > -1) {
            promptItemToEdit(e, tabclick);
        } else {
            $('.rowMsgInv').hide();
            $('#mainButtonsOnItemInv').show();
        }
        // Subtabs
        var row = $('#inventoryItemsGrid').jqxGrid('getrowdatabyid', $scope.itemInventoryID);
        if (tabTitle == 'Stock Level') {
            if ($scope.createOrEditItemInventory != 'create')
                $scope.inventoryData.stockQty = row.Quantity;
        }
        if (tabTitle == 'Prices') {
            if ($scope.createOrEditItemInventory != 'create') {
                $scope.inventoryData.lprice = row.ListPrice;
                $scope.inventoryData.sprice = row.price1;
            }
        }
        if (tabTitle == 'Barcode') {}
        if (tabTitle == 'Questions') {
            if ($scope.createOrEditItemInventory != 'create') {
                $('#invQ_Question').jqxComboBox({source: inventoryExtraService.getQuestionsCbxData()});
            }
        }
        if (tabTitle == 'Printers') {}
    });

    function promptItemToEdit(e, tab) {
        if ($scope.createOrEditItemInventory == 'create') {
            e.cancel = true;
            $scope.moveTabInventoryAction(undefined, tab);
        }
    }

    $scope.inventoryItemsGrid = itemInventoryService.getInventoryGridData;
    var updateItemsInventoryGrid = function(init) {
        var el = (init != undefined) ? this : '#inventoryItemsGrid';
        $(el).jqxGrid({
            source: itemInventoryService.getInventoryGridData.source
        });
    };

    var inventoryWind;
    $scope.itemsInventoryWindowSettings = {
        created: function (args) {
            inventoryWind = args.instance;
        },
        resizable: false,
        width: "100%", height: "100%",
        //width: "50%", height: "100%",
        keyboardCloseKey: 'none',
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
        var id;
        if (e.args.item != null) {
            id = e.args.item.value;
            //$scope.subcategoryCbxSettings = inventoryExtraService.getSubcategoriesSettings(id);
        }
        $scope.subcategoryCbxSettings = inventoryExtraService.getSubcategoriesSettings(id);
        $('#item_subcategory').jqxComboBox({'selectedIndex': -1});
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

    $scope.setStaticPrices = function(listprice) {
        if ($scope.createOrEditItemInventory == 'create') {
            if (listprice == 1) {
                var lprice = $scope.inventoryData.listPrice;
                $scope.inventoryData.price1 = lprice;
            }
            $('#itemp_listprice').val($scope.inventoryData.listPrice);
            $('#itemp_price1').val($scope.inventoryData.price1);
        }
    };

    $scope.modifyCurrentQty = function(elect, stockTotal) {
        var transQty = 0;
        var stock = parseFloat($('#stockl_currentQty').val());
        //if (stockTotal != undefined) {
        //    stock = stockTotal;
        //} else
        //    stock = parseFloat($scope.inventoryData.stockQty);
        if (elect == 0) {
            transQty = stock + parseFloat($scope.inventoryData.addremoveQty);
            $('#stockl_newQty').val(transQty);
        }
        if (elect == 1) {
            transQty = parseFloat($scope.inventoryData.newQty) - stock ;
            $('#stockl_addremoveQty').val(transQty);
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
        $('#iteminventory_giftcard .cbxExtraTab[data-val=0]').jqxRadioButton({ checked:true });
        $('#iteminventory_group .cbxExtraTab[data-val=0]').jqxRadioButton({ checked:true });
        $('#iteminventory_promptprice .cbxExtraTab[data-val=0]').jqxRadioButton({ checked:true });
        $('#iteminventory_promptdescription .cbxExtraTab[data-val=0]').jqxRadioButton({ checked:true });
        $('#iteminventory_EBT .cbxExtraTab[data-val=0]').jqxRadioButton({ checked:true });
        //
        $('.inventory_tab .req').css({'border-color': '#CCC'});
        $('#item_category').css({'border-color': '#CCC'});
        $scope.inventoryErrorMsg.apply('closeLast');
        $scope.inventorySuccessMsg.apply('closeLast');
        //
        $('#saveInventoryBtn').prop('disabled', true);
        // Barcode Cleaning
        $scope.barcodeData.mainValue = '';
        $('#item_barcodeinput').val("");
        // Taxes cleaning
        taxesValuesChanged = [];
        // Stock Level Cleaning
        $('#itemstock_locationCbx').jqxComboBox({selectedIndex: 0});
        if (close == 1)
            inventoryWind.close();
    };

    // Create|Edit Inventory Actions
    $scope.createOrEditItemInventory = null;
    $scope.itemInventoryID = null;
    $scope.openInventoryWind = function() {
        $scope.createOrEditItemInventory = 'create';
        $scope.itemInventoryID = null;
        $scope.barcodeListSettings = inventoryExtraService.getBarcodesListSettings($scope.itemInventoryID)
        $scope.stockInventoryGrid = inventoryExtraService.getStockGridData($scope.itemInventoryID, 0);
        $scope.taxesInventoryGrid = inventoryExtraService.getTaxesGridData($scope.itemInventoryID);
        //
        var loc  = $('#stationID').val();
        var station = $('#itemstock_locationCbx').jqxComboBox('getItemByValue', loc);
        $('#itemstock_locationCbx').jqxComboBox({'selectedIndex': (station) ? station.index : 0});
        setTimeout(function(){
            $('.inventory_tab #item_Item').focus();
        }, 100);
        //
        $('#deleteInventoryBtn').hide();
        $('#saveInventoryBtn').prop('disabled', true);
        inventoryWind.setTitle('New Item');
        inventoryWind.open();
    };

    $scope.editInventoryWind = function(e) {
        var row = (e.args.row.bounddata);
        $scope.createOrEditItemInventory = 'edit';
        $scope.itemInventoryID = row.Unique;
        $scope.inventoryData.lprice = row.ListPrice;
        $scope.inventoryData.sprice = row.price1;
        // Item text controls
        $('.inventory_tab .item_textcontrol').each(function(i, el) {
            var field = $(el).data('field');
            if (field != undefined) {
                $(el).val($.trim(row[field]));
            }
        });
        var totalCost = parseFloat(row.Cost) + parseFloat(row.Cost_Duty) + parseFloat(row.Cost_Freight) + parseFloat(row.Cost_Extra);
        $scope.inventoryData.costLanded = totalCost;
        $('#item_Cost_Landed').val(totalCost);
        // Item combobox controls
        var category = $('#item_category').jqxComboBox('getItemByValue', row['CategoryId']);
        $('#item_category').jqxComboBox({'selectedIndex': (category != null) ? category.index : -1});
        var supplier = $('#item_supplier').jqxComboBox('getItemByValue', row['SupplierId']);
        $('#item_supplier').jqxComboBox({'selectedIndex': (supplier != null) ? supplier.index : -1});
        var brand = $('#item_brand').jqxComboBox('getItemByValue', row['BrandId']);
        $('#item_brand').jqxComboBox({'selectedIndex': (brand != null) ? brand.index : -1});
        setTimeout(function() {
            var subcategory = $('#item_subcategory').jqxComboBox('getItemByValue', row['SubCategoryId']);
            $('#item_subcategory').jqxComboBox({selectedIndex: ((subcategory != null) ? subcategory.index : -1)});
            $('#saveInventoryBtn').prop('disabled', true);
        }, 100);
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
        var loc  = $('#stationID').val();
        var station = $('#itemstock_locationCbx').jqxComboBox('getItemByValue', loc);
        $('#itemstock_locationCbx').jqxComboBox({'selectedIndex': (station) ? station.index : 0});
        //$('#stockl_currentQty').jqxNumberInput('val', row['Quantity']);
        $scope.inventoryData.stockQty = row['Quantity'];
        $scope.inventoryData.addremoveQty = 0;
        $scope.inventoryData.newQty = 0;
        $scope.barcodeListSettings = inventoryExtraService.getBarcodesListSettings($scope.itemInventoryID);
        $scope.taxesInventoryGrid = inventoryExtraService.getTaxesGridData($scope.itemInventoryID);
        $scope.stockInventoryGrid = inventoryExtraService.getStockGridData($scope.itemInventoryID, $('#stationID').val());
        updateQuestionItemTable($scope.itemInventoryID);
        updatePrinterItemGrid($scope.itemInventoryID);
        //
        setTimeout(function(){
            $('.inventory_tab #item_Item').focus();
        }, 100);
        $('#deleteInventoryBtn').show();
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
                //console.log('Not found', $(el).attr('id'));
            }
        });
        //
        var supplier = $('#item_supplier').jqxComboBox('getSelectedItem');
        data['SupplierUnique'] = (supplier != null) ? $.trim(supplier.value) : null;
        var brand = $('#item_brand').jqxComboBox('getSelectedItem');
        data['BrandUnique'] = (brand != null) ? $.trim(brand.value) : null;
        var category = $('#item_category').jqxComboBox('getSelectedItem');
        data['MainCategory'] = (category != null) ? (category.value) : null;
        var subcategory = $('#item_subcategory').jqxComboBox('getSelectedItem');
        data['CategoryUnique'] = (subcategory != null) ? (subcategory.value) : null;
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

        // TAXES VALUES
        var taxesByItem = [];
        if ($scope.createOrEditItemInventory = 'create') {
            $.each($('#taxesGrid').jqxGrid('getrows'), function(i, row) {
                //console.log(row, );
                if (row.taxed) {
                    taxesByItem.push({
                        TaxUnique: row.Unique,
                        ItemUnique: $scope.itemInventoryID,
                        Status: row.taxed
                    });
                }
            });
        } else if ($scope.createOrEditItemInventory = 'edit') {
            for(var i=0; i < $('#taxesGrid').jqxGrid('getrows').length; i++) {
                if (taxesValuesChanged.indexOf(i) > -1) {
                    taxesByItem.push({
                        TaxUnique: $('#taxesGrid').jqxGrid('getcellvalue', i, 'Unique'),
                        ItemUnique: $scope.itemInventoryID,
                        Status: $('#taxesGrid').jqxGrid('getcellvalue', i, 'taxed')
                    });
                }
            }
        }
        data['taxesValues'] = (taxesByItem != '') ? JSON.stringify(taxesByItem) : '';
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

    var tabSelectedOnCreate = null;
    $scope.tabSelectedOnCreate = null;
    $scope.moveTabInventoryAction = function(option, tab) {
        if (option != undefined) {
            $('.rowMsgInv').hide();
            $('#mainButtonsOnItemInv').show();
            if (option != 0)
                tabSelectedOnCreate = null;
        }
        if (option == 0) {
            $scope.saveInventoryAction(undefined, tabSelectedOnCreate);
        } else if (option == 1) {
            $scope.closeInventoryWind(1);
        } else if (option == 2) {
        } else {
            //if ($('#saveInventoryBtn').is(':disabled')) {
            //    $scope.closeInventoryWind(1);
            //} else {
            var msg = $('#promptMoveItemInv #tabTitleOnMsg');
            var txt;
            if (tab == 3)
                txt = ' quantity ';
            else if (tab == 5)
                txt = ' barcode ';
            else if (tab == 6)
                txt = ' question ';
            else if (tab == 7)
                txt = ' printer ';
            msg.html(txt);
            $('.rowMsgInv').hide();
            $('#promptMoveItemInv').show();
            tabSelectedOnCreate = tab;
            //$scope.tabSelectedOnCreate = tab;
            //}
        }
    };

    $scope.saveInventoryAction = function(toClose, toTab) {
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
                dataType: 'json',
                success: function(data) {
                    if (data.status == 'success') {
                        if ($scope.createOrEditItemInventory == 'create') {
                            $scope.createOrEditItemInventory = 'edit';
                            $scope.itemInventoryID = data.id;
                            showingNotif(data.message, 1);
                            inventoryWind.setTitle('Edit Item ID: '+ data.id + ' | Item: ' + dataRequest.Item + '| ' + dataRequest.Description);
                            updateItemsInventoryGrid();
                            if(toTab) {
                                $('#inventoryTabs').jqxTabs({'selectedItem': toTab})
                                tabSelectedOnCreate = null;
                                $('.rowMsgInv').hide();
                                $('#mainButtonsOnItemInv').show();
                            }
                        }
                        else if ($scope.createOrEditItemInventory = 'edit') {
                            showingNotif(data.message, 1);
                            $('#inventoryItemsGrid').jqxGrid('updatebounddata', 'filter');
                        }
                        //
                        $('#saveInventoryBtn').prop('disabled', true);
                        if (toClose) {
                            $scope.closeInventoryWind(1);
                        }
                    }
                    else if (data.status == 'error')
                        showingNotif(data.message, 0);
                    else
                        showingNotif(data.message, 0);
                }
            });
        }
    };

    $scope.closeInventoryAction = function(option) {
        if (option != undefined) {
            $('#mainButtonsOnItemInv').show();
            $('#promptCloseItemInv').hide();
            $('#promptToDeleteItemInv').hide();
        }
        if (option == 0) {
            $scope.saveInventoryAction(1);
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

    $scope.deleteInventoryAction = function(option) {
        if(option != undefined) {
            $('#mainButtonsOnItemInv').show();
            $('#promptCloseItemInv').hide();
            $('#promptToDeleteItemInv').hide();
        }
        if (option == 0) {
            //if ($scope.printerSelectedID == null) {
            //    $scope.closingPrinterWind();
            //} else {
            $.ajax({
                url: SiteRoot + 'admin/MenuItem/deleteItemInventory/' + $scope.itemInventoryID,
                method: 'post',
                dataType: 'json',
                success: function(response) {
                    if(response.status == 'success') {
                        updateItemsInventoryGrid();
                        $scope.closeInventoryWind(1);
                    }
                    else if (data.status == 'error')
                        showingNotif(data.message, 0);
                    else
                        showingNotif(data.message, 0);
                }
            });
            //}
        } else if (option == 1) {
            $scope.closeInventoryWind(1);
        } else if (option == 2) {
        } else {
            $('#mainButtonsOnItemInv').hide();
            $('#promptCloseItemInv').hide();
            $('#promptToDeleteItemInv').show();
        }
    };

    // -- BARCODE SUBTAB
    $scope.barcodeData = {};
    $scope.barcodeListSettings = inventoryExtraService.getBarcodesListSettings($scope.itemInventoryID);

    $scope.onSelectBarcodeList = function(e) {
        if (e.args.item != null) {
            var barcode = e.args.item.originalItem.Barcode;
            $scope.barcodeData.idSelected = e.args.item.originalItem.Unique;
            $('#item_barcodeinput').val(barcode);
            $scope.barcodeData.mainValue = barcode;
        }
    };

    $scope.saveItemBarcode = function(action) {
        var input = $scope.barcodeData.mainValue;
        if (input == '') {
            alert('Please enter the barcode number!');
            return;
        }
        if(input != undefined) {
            var equalBarcode = false;
            $.each($('#inventory_barcodesList').jqxListBox('getItems'), function(i, val) {
                if (val.label == input) {
                    equalBarcode = true;
                    alert(input + ' not added because duplicates another barcode assigned to this item.');
                    return;
                }
            });
            if (!equalBarcode) {
                var dataRequest = {
                    Barcode: input,
                    ItemUnique: $scope.itemInventoryID
                };
                var idParam = (action) ? $scope.barcodeData.idSelected : '';
                $.ajax({
                    method: 'post',
                    url: SiteRoot + 'admin/MenuItem/saveBarcodeItem/' + idParam,
                    dataType: 'json',
                    data: dataRequest,
                    success: function(data) {
                        if (data.status == 'success') {
                            $('#inventory_barcodesList').jqxListBox('refresh');
                            //$scope.barcodeListSettings = inventoryExtraService.getBarcodesListSettings($scope.itemInventoryID);
                            $scope.barcodeData.mainValue = '';
                            $('#item_barcodeinput').val("");
                            $('#inventory_barcodesList').jqxListBox({selectedIndex: -1});
                        }
                        else if (data.status == 'error')
                            showingNotif(data.message, 0);
                        else
                            showingNotif(data.message, 0);
                    }
                });
            }
        }
    };

    $scope.deleteItemBarcode = function() {
        var id = $scope.barcodeData.idSelected;
        if (id != undefined && id != null) {
            $.ajax({
                method: 'post',
                url: SiteRoot + 'admin/MenuItem/deleteBarcodeItem/' + id,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 'success') {
                        $('#inventory_barcodesList').jqxListBox('refresh');
                        $scope.barcodeData.mainValue = '';
                        $('#item_barcodeinput').val("");
                        $('#inventory_barcodesList').jqxListBox({selectedIndex: -1});
                    }
                    else if (data.status == 'error')
                        showingNotif(data.message, 0);
                    else
                        showingNotif(data.message, 0);
                }
            });
        }
    };

    // -- TAXES SUBTAB
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
        }
    });

    // -- STOCK SUBTAB
    var stocklWind;
    $scope.stockWind = {
        created: function (args) {
            stocklWind = args.instance;
        },
        resizable: false,
        width: "45%", height: "60%",
        //keyboardCloseKey: 'none',
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };
    $scope.stockInventoryGrid = inventoryExtraService.getStockGridData();
    $scope.stockitemLocationSettings = inventoryExtraService.getStockLocationListSettings(0);
    $scope.stockitemLocation2Settings = inventoryExtraService.getStockLocationListSettings();
    $scope.onSelectStockLocationList = function(e) {
        var location = e.args.item.value;
        $scope.stockInventoryGrid = inventoryExtraService.getStockGridData($scope.itemInventoryID, location);
    };

    $scope.onSelectLocationAdjustQty = function(e) {
        if (e.args.item) {
            var location = e.args.item.value;
            var url = SiteRoot + 'admin/MenuItem/totalQuantityByLocation/';
            if ($scope.itemInventoryID) {
                $.ajax({
                    method: 'get',
                    url: url + $scope.itemInventoryID + '/' + location,
                    success: function(response) {
                        $('#stockl_currentQty').jqxNumberInput('val', response);
                        $('#stockl_newQty').jqxNumberInput('val', response);
                        $('#stockl_addremoveQty').jqxNumberInput('val', 0);
                    }
                });
            }
        }
    };

    $scope.openStockWind = function() {
        var loc = $('#stationID').val();
        var station = $('#stockl_location').jqxComboBox('getItemByValue', loc);
        $('#stockl_location').jqxComboBox({'selectedIndex': -1});
        $('#stockl_location').jqxComboBox({'selectedIndex': (station) ? station.index : 0});
        //var station = $('#itemstock_locationCbx').jqxComboBox('getItemByValue', loc);
        //$('#itemstock_locationCbx').jqxComboBox({'selectedIndex': (station) ? station.index : 0});
        //
        $('#stocklWind #stockl_comment').val('');
        $('#stocklWind .stockl_input:not(#stockl_currentQty)').jqxNumberInput('val', 0);
        $("#stockl_transDate").jqxDateTimeInput({ value: new Date() });
        $("#stockl_transTime").jqxDateTimeInput({ formatString: 'T', showCalendarButton: false });
        // Getting current qty from grid
        //var row = $('#inventoryItemsGrid').jqxGrid('getrowdatabyid', $scope.itemInventoryID);
        //$scope.inventoryData.stockQty = row.Quantity;
        //
        $('#saveStockBtn').prop('disabled', true);
        stocklWind.open();
    };

    $scope.closeStockWind = function(option) {
        if(option != undefined) {
            $('#mainButtonsStockl').show();
            $('#promptButtonsStockl').hide();
        }
        if (option == 0) {
            $scope.saveStockWind();
        } else if (option == 1) {
            stocklWind.close();
        }
        else if (option == 2) {}
        else {
            if ($('#saveStockBtn').is(':disabled')) {
                stocklWind.close();
            }
            else {
                $('#promptButtonsStockl').show();
                $('#mainButtonsStockl').hide();
            }
        }
    };

    function validationStockForm(data) {
        var needValidation = false;
        var qty = $('#stockl_addremoveQty').val();
        if (qty == 0) {
            alert('Quantity to Add or Remove is required field!');
            needValidation = true;
        }
        return needValidation;
    }

    $scope.saveStockWind = function() {
        if (!validationStockForm()) {
            var dataReq = {
                'ItemUnique': $scope.itemInventoryID,
                'LocationUnique': $('#stockl_location').jqxComboBox('getSelectedItem').value,
                'Quantity': $('#stockl_addremoveQty').val(),
                'Comment': $('#stockl_comment').val(),
                'trans_date': $('#stockl_transDate').val(),
                'trans_time': $('#stockl_transTime').val()
            };
            $.ajax({
                url: SiteRoot + 'admin/MenuItem/updateStocklineItems',
                method: 'post',
                dataType: 'json',
                data: dataReq,
                success: function(response) {
                    if(response.status == 'success') {
                        updateItemsInventoryGrid();
                        //$('#inventoryItemsGrid').jqxGrid('updatebounddata', 'filter');
                        $scope.$apply(function() {
                            var loc  = $('#stationID').val();
                            $scope.stockInventoryGrid = inventoryExtraService.getStockGridData($scope.itemInventoryID, loc);
                            $('#stockLevelItemGrid').jqxGrid('hideloadelement');
                            //
                            var station = $('#itemstock_locationCbx').jqxComboBox('getItemByValue', loc);
                            $('#itemstock_locationCbx').jqxComboBox({'selectedIndex': (station) ? station.index : -1});
                        });
                        stocklWind.close();
                    }
                    else if (response.status == 'error')
                        console.log(response.message, 0);
                        //showingNotif(response.message, 0);
                    else
                        console.log(response.message, 0);
                        //showingNotif(response.message, 0);
                }
            });
        }
    };

    $scope.updateStockQuantity = function() {
        // INSERT into item_stock_line table...
        var dataRequest = {
            "ItemUnique": 'this is the item unique',
            'LocationUnique': '',
            'Type': 4, // move to server side
            'Quantity': 'qty add or remove', // on server side validate decimalsQuantity
            'Comment': '', //
            'trans_date': '', //
            'TransactionDate': '', //date("Y-m-d",strtotime($setdate))." ".date("H:i:s",strtotime($settime)),
            'status': 1// move to server side
        // reseting
        //$("#jqxWidgetDate").jqxDateTimeInput({ value: new Date(yyyy, mm, dd) });
        //$("#jqxWidgetTime").jqxDateTimeInput({ formatString: 'T', showCalendarButton: false });
        };
        $.ajax({
            url: '',
            method: 'post',
            dataType: 'array',
            data: dataRequest,
            success: function(response){

            }
        })
    };

    // -- QUESTION SUBTAB
    $scope.questionInventorySuccess = itemInventoryService.setNotificationSettings(1, '#notif_questionInventory');
    $scope.questionInventoryError = itemInventoryService.setNotificationSettings(0, '#notif_questionInventory');
    $scope.questionInventoryGridSettings = inventoryExtraService.getQuestionGridData();

    var updateQuestionItemTable = function(itemId) {
        $('.inventory_tab #questionItemTable').jqxGrid({
            source: new $.jqx.dataAdapter(inventoryExtraService.getQuestionGridData(itemId).source)
        });
    };

    var questionInventoryWind, cbxQuestionsItem;
    $scope.questionInventoryWindSettings = {
        created: function (args) {
            questionInventoryWind = args.instance;
        },
        resizable: false,
        width: "50%", height: "50%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    var dataAdapterQuestionItems = inventoryExtraService.getQuestionsCbxData();
    //
    $scope.questionItemsCbxSettings = {
        created: function (args) {
            cbxQuestionsItem = args.instance;
        },
        placeHolder: 'Select a question',
        source: dataAdapterQuestionItems,
        displayMember: 'QuestionName',
        valueMember: 'Unique',
        width: "200px",
        itemHeight: 30,
        theme: 'arctic'
    };
    //
    $('#invQ_Status').jqxDropDownList({autoDropDownHeight: true});
    //
    $('.invQFormContainer .required-qitem').on('keypress keyup paste change', function (e) {
        $('#saveQuestionInvBtn').prop('disabled', false);
    });
    //
    $scope.addOrEditqItem = null;
    $scope.qInvIdChosen = null;
    $scope.openQuestionItemWin = function() {
        //
        $('#invQ_Status').jqxDropDownList({'selectedIndex': 0});
        $('#invQ_Question').jqxComboBox({'selectedIndex': -1});
        $('#invQ_Sort').val(1);
        $('#invQ_Tab').val(1);
        //
        $('#saveQuestionInvBtn').prop('disabled', true);
        $('#deleteQuestionInvBtn').hide();
        $scope.addOrEditqItem = 'create';
        questionInventoryWind.setTitle('Add New Question | Item: ' + $scope.itemInventoryID);
        questionInventoryWind.open();
    };
    
    $scope.editQuestionItemWin = function(e) {
        //
        var row = e.args.row.bounddata;
        var statusCombo = $('#invQ_Status').jqxDropDownList('getItemByValue', row.Status);
        $('#invQ_Status').jqxDropDownList({'selectedIndex': (statusCombo == undefined) ? 1 : statusCombo.index});
        var itemCombo = $('#invQ_Question').jqxComboBox('getItemByValue', row.QuestionUnique);
        var selectedIndexItem = (itemCombo != undefined) ? itemCombo.index : -1;
        $('#invQ_Question').jqxComboBox({'selectedIndex': selectedIndexItem});
        $('#invQ_Sort').val(row.Sort);
        $('#invQ_Tab').val((row.Tab != null) ? row.Tab : 1);
        //
        $('#saveQuestionInvBtn').prop('disabled', true);
        $('#deleteQuestionInvBtn').show();
        $scope.addOrEditqItem = 'edit';
        $scope.qInvIdChosen = row.Unique;
        questionInventoryWind.setTitle('Edit Question: ' + row.QuestionUnique +' | Item: ' + row.ItemUnique);
        questionInventoryWind.open();
    };
    //
    $scope.closeQuestionItemWin = function (option) {
        if(option != undefined) {
            $('#mainButtonsQinv').show();
            $('#promptToCloseQinv').hide();
        }
        if (option == 0) {
            $scope.saveQuestionItem(1);
        } else if (option == 1) {
            questionInventoryWind.close();
        }
        else if (option == 2) {}
        else {
            if ($('#saveQuestionInvBtn').is(':disabled')) {
                questionInventoryWind.close();
            }
            else {
                $('#promptToCloseQinv').show();
                $('#mainButtonsQinv').hide();
            }
        }
    };
    //
    var validationQuestionItemForm = function() {
        var needValidation = false;
        if (!$('#invQ_Question').jqxComboBox('getSelectedItem')) {
            needValidation = true;
            $('#questionInventoryError #notification-content')
                .html('Select a question');
            $scope.questionInventoryError.apply('open');
            $('#invQ_Question').css({'border-color': '#F00'});
        } else {
            $('#invQ_Question').css({'border-color': '#CCC'});
        }
        $('.invQFormContainer .required-qitem').each( function(i, el) {
            if (el.value == '') {
                needValidation = true;
                $('#questionInventoryError #notification-content')
                    .html($(el).attr('placeholder') + ' can not be empty!');
                $scope.questionInventoryError.apply('open');
                $(el).css({'border-color': '#F00'});
            } else {
                $(el).css({'border-color': '#CCC'});
            }
        });
    
        return needValidation;
    };
    //
    $scope.saveQuestionItem = function(toClose) {
        if (!validationQuestionItemForm()) {
            var data = {
                'QuestionUnique': $('#invQ_Question').jqxComboBox('getSelectedItem').value,
                'Status': $('#invQ_Status').jqxDropDownList('getSelectedItem').value,
                'Sort': $('#invQ_Sort').val(),
                'Tab': $('#invQ_Tab').val(),
                'ItemUnique': $scope.itemInventoryID
            };
            var url, msg;
            if ($scope.addOrEditqItem == 'create') {
                url = 'admin/MenuItem/postQuestionMenuItems';
            } else if($scope.addOrEditqItem == 'edit') {
                url = 'admin/MenuItem/updateQuestionMenuItems/' + $scope.qInvIdChosen;
            }
            $.ajax({
                'method': 'POST',
                'url': SiteRoot + url,
                'dataType': 'json',
                'data': data,
                'success': function(data) {
                    if (data.status == 'success') {
                        if(toClose == 1) {
                            questionInventoryWind.close();
                        } else {
                            if ($scope.addOrEditqItem == 'create') {
                                msg = 'Question saved successfully!';
                            } else {
                                msg = 'Question was updated successfully!';
                            }
                            $('#questionInventorySuccess #notification-content')
                                .html(msg);
                            $scope.questionInventorySuccess.apply('open');

                        }
                        $('#saveQuestionInvBtn').prop('disabled', true);
                        updateQuestionItemTable($scope.itemInventoryID);
                    } else if (data.status == 'error') {
                        $('#questionInventoryError #notification-content')
                            .html('There was an error');
                        $scope.questionInventoryError.apply('open');
                    }
                    else {
                        console.info('Ajax error');
                    }
    
                }
            });
        }
    };
    //
    $scope.deleteQuestionItem = function(option) {
        if (option == 0) {
            $.ajax({
                'url': SiteRoot + 'admin/MenuItem/deleteQuestionMenuItems/' + $scope.qInvIdChosen,
                'method': 'post',
                'dataType': 'json',
                'success': function (data) {
                    if (data.status == 'success') {
                        updateQuestionItemTable($scope.itemInventoryID);
                        questionInventoryWind.close();
                        $('#mainButtonsQinv').show();
                        $('#promptToCloseQinv').hide();
                        $('#promptToDeleteQInv').hide();
                    } else if (data.status == 'error') {
                        $('#questionInventoryError #notification-content')
                            .html('There was an error');
                        $scope.questionInventoryError.apply('open');
                    }
                    else {
                        console.info('Ajax error');
                    }
                }
            });
        } else if (option == 1) {
            $('#mainButtonsQinv').show();
            $('#promptToCloseQinv').hide();
            $('#promptToDeleteQInv').hide();
            questionInventoryWind.close();
        } else if (option == 2) {
            $('#mainButtonsQinv').show();
            $('#promptToCloseQinv').hide();
            $('#promptToDeleteQInv').hide();
        } else {
            $('#mainButtonsQinv').hide();
            $('#promptToCloseQinv').hide();
            $('#promptToDeleteQInv').show();
        }
    };

    // -- PRINTERS SUBTAB
    $scope.printerInventorySuccess = itemInventoryService.setNotificationSettings(1, '#notif_printerInventory');
    $scope.printerInventoryError = itemInventoryService.setNotificationSettings(0, '#notif_printerInventory');
    $scope.printerInventoryGridSettings = inventoryExtraService.getPrinterGridData();
    //
    var allPrintersArray = [];
    var printerStoredArray = [];

    var fillPrintersArray = function() {
        if (allPrintersArray == '') {
            var rows = $("#printerItemList").jqxDropDownList('getItems');
            for(var j in rows) {
                allPrintersArray.push(rows[j]['value']);
            }
        }
    };

    var updatePrinterItemGrid = function(itemID) {
        $('.inventory_tab #printerItemTable').jqxGrid({
            source: new $.jqx.dataAdapter(inventoryExtraService.getPrinterGridData(itemID).source)
        });
    };

    var printerItemWind;
    $scope.printerInvWindowSettings = {
        created: function (args) {
            printerItemWind = args.instance;
        },
        resizable: false,
        width: "60%", height: "30%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    // Printer dropdownlist
    $scope.printerInvList = {
        source: new $.jqx.dataAdapter(inventoryExtraService.getPrintersCbxData()),
        displayMember: "fullDescription", valueMember: "unique"
    };

    function setPrinterStoredArray() {
        // Fill with printers by item
        printerStoredArray = [];
        var rows = $('.inventory_tab #printerItemTable').jqxGrid('getRows');
        for(var j in rows) {
            printerStoredArray.push(rows[j]['PrinterUnique']);
        }
        // Check existing printers on stored by item
        for (var i in allPrintersArray) {
            var item = $("#printerInvList").jqxDropDownList('getItemByValue', allPrintersArray[i]);
            if (printerStoredArray.indexOf(allPrintersArray[i]) > -1) {
                $("#printerInvList").jqxDropDownList('disableItem', item);
            } else {
                $("#printerInvList").jqxDropDownList('enableItem', item);
            }
        }
    }

    $scope.itemPrinterID = null;
    $scope.createOrEditPitem = null;
    $scope.openPrinterItemWin = function(e) {
        fillPrintersArray();
        $scope.createOrEditPitem = 'create';
        $scope.itemPrinterID = null;
        // Printers saved by Item
        setPrinterStoredArray();
        //
        $("#printerInvList").jqxDropDownList({selectedIndex: -1});
        $('#deleteBtnPrinterInv').hide();
        $('#saveBtnPrinterInv').prop('disabled', true);
        printerItemWind.setTitle('New Item Printer');
        printerItemWind.open();
    };
    //
    $scope.updateItemPrinter = function(e) {
        fillPrintersArray();
        var row = e.args.row.bounddata;
        $scope.openPrinterItemWin();
        printerItemWind.setTitle('Edit Item Printer | Item: ' + row.ItemUnique + ' | Printer ID: ' + row.PrinterUnique);
        //
        $scope.createOrEditPitem = 'edit';
        $scope.itemPrinterID = row.Unique;
        $('#deleteBtnPrinterInv').show();
        var item = $("#printerInvList").jqxDropDownList('getItemByValue', row.PrinterUnique);
        $("#printerInvList").jqxDropDownList('enableItem', item);
        $("#printerInvList").jqxDropDownList({selectedIndex: item.index});
        $('#saveBtnPrinterInv').prop('disabled', true);
    };

    $scope.closePrinterItemWin = function() {
        printerItemWind.close();
        $('#mainButtonsPrinterInv').show();
        $('#promptDeletePrinterInv').hide();
        setPrinterStoredArray();
    };

    // Saving Item Printer
    $scope.saveItemPrinter = function() {
        var data = {
            'ItemUnique': $scope.itemInventoryID,
            'PrinterUnique': $('#printerInvList').jqxDropDownList('getSelectedItem').value
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
                    updatePrinterItemGrid($scope.itemInventoryID);
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
            $('#mainButtonsPrinterInv').show();
            $('#promptToClosePrinterInv').hide();
            $('#promptDeletePrinterInv').hide();
        }
        if (option == 0) {
            $scope.saveItemPrinter();
        } else if (option == 1) {
            $scope.closePrinterItemWin();
        }
        else if (option == 2) {}
        else {
            if ($('#saveBtnPrinterInv').is(':disabled')) {
                $scope.closePrinterItemWin();
            }
            else {
                $('#promptToClosePrinterInv').show();
                $('#mainButtonsPrinterInv').hide();
                $('#promptDeletePrinterInv').hide();
            }
        }
    };

    // Deleting Item Printer
    $scope.beforeDeleteItemPrinter = function(option) {
        if (option == 0) {
            $.ajax({
                url: SiteRoot + 'admin/MenuPrinter/delete_item_printer/' + $scope.itemPrinterID,
                method: 'post',
                dataType: 'json',
                success: function(response) {
                    if(response.status == 'success') {
                        updatePrinterItemGrid($scope.itemInventoryID);
                        $scope.closePrinterItemWin();
                    } else if (response.status == 'error'){
                        console.log('there was an error db');
                    } else {
                        console.log('there was an error');
                    }
                }
            });
        } else if (option == 1) {
            $('#mainButtonsPrinterInv').show();
            $('#promptDeletePrinterInv').hide();
            printerItemWind.close();
        } else if (option == 2) {
            $('#mainButtonsPrinterInv').show();
            $('#promptDeletePrinterInv').hide();
        } else {
            $('#mainButtonsPrinterInv').hide();
            $('#promptDeletePrinterInv').show();
        }
    };
});
