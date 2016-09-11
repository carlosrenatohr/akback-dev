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
            updateItemsInventoryGrid(1);
        }
    });

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
        $scope.barcodeListSettings = inventoryExtraService.getBarcodesListSettings($scope.itemInventoryID)
        $scope.stockInventoryGrid = inventoryExtraService.getStockGridData($scope.itemInventoryID, 0);
        //
        setTimeout(function(){
            $('.inventory_tab #item_Item').focus();
        }, 100);
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
        $scope.barcodeListSettings = inventoryExtraService.getBarcodesListSettings($scope.itemInventoryID);
        $scope.taxesInventoryGrid = inventoryExtraService.getTaxesGridData($scope.itemInventoryID);
        $scope.stockInventoryGrid = inventoryExtraService.getStockGridData($scope.itemInventoryID, 0);
        updateQuestionItemTable($scope.itemInventoryID);
        updatePrinterItemGrid($scope.itemInventoryID);
        //
        setTimeout(function(){
            $('.inventory_tab #item_Item').focus();
        }, 100);
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

        // TAXES VALUES
        var taxesByItem = [];
        for(var i=0; i < $('#taxesGrid').jqxGrid('getrows').length; i++) {
            if (taxesValuesChanged.indexOf(i) > -1) {
                taxesByItem.push({
                    TaxUnique: $('#taxesGrid').jqxGrid('getcellvalue', i, 'Unique'),
                    ItemUnique: $scope.itemInventoryID,
                    Status: $('#taxesGrid').jqxGrid('getcellvalue', i, 'taxed')
                });
            }
        }
        data['taxesValues'] = JSON.stringify(taxesByItem);
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
            var dataRequest = {
                Barcode:input,
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
    }

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

    // --STOCK SUBTAB
    $scope.stockInventoryGrid = inventoryExtraService.getStockGridData();
    $scope.stockitemLocationSettings = inventoryExtraService.getStockLocationListSettings();
    $scope.onSelectStockLocationList = function(e) {
        var location = e.args.item.value;
        $scope.stockInventoryGrid = inventoryExtraService.getStockGridData($scope.itemInventoryID, location);
    }

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
        width: "50%", height: "40%",
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
        width: "100%",
        itemHeight: 30,
        theme: 'arctic'
    };
    //
    $('#invQ_Status').jqxDropDownList({autoDropDownHeight: true});
    //
    $('.invQFormContainer .required-qitem').on('keypress keyup paste change', function (e) {
        var idsRestricted = ['invQ_Sort'];
        var inarray = $.inArray($(this).attr('id'), idsRestricted);
        if (inarray >= 0) {
            var charCode = (e.which) ? e.which : e.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57 || charCode == 46)) {
                if (this.val == '') {
                    $('#questionInventoryError #notification-content')
                        .html('Sort value must be number');
                    $scope.questionInventoryError.apply('open');
                    $(this).css({'border-color': '#F00'});
                }
                return false;
            }
            if (this.value.length > 2) {
                return false;
            }
        }
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
        //
        $('#saveQuestionInvBtn').prop('disabled', true);
        $('#deleteQuestionInvBtn').hide();
        $scope.addOrEditqItem = 'create';
        questionInventoryWind.setTitle('Add New Question | Item: ' + $scope.itemInventoryID);
        questionInventoryWind.open();
    };
    
    $scope.editQuestionItemWin = function(e) {
        //updateQuestionsCbx();
        //
        var row = e.args.row.bounddata;
        var statusCombo = $('#invQ_Status').jqxDropDownList('getItemByValue', row.Status);
        $('#invQ_Status').jqxDropDownList({'selectedIndex': (statusCombo == undefined) ? 1 : statusCombo.index});
    

        var itemCombo = $('#invQ_Question').jqxComboBox('getItemByValue', row.QuestionUnique);
        var selectedIndexItem = (itemCombo != undefined) ? itemCombo.index : -1;
        $('#invQ_Question').jqxComboBox({'selectedIndex': selectedIndexItem});
    
        $('#invQ_Sort').val(row.Sort);
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
    var updatePrinterItemGrid = function(itemID) {
        $('.inventory_tab #printerItemTable').jqxGrid({
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
                url: SiteRoot + 'admin/MenuPrinter/load_allItemPrinters/' + itemID
            })
        });
    };
    //
    //var printerItemWind;
    //$scope.printerItemWindowSettings = {
    //    created: function (args) {
    //        printerItemWind = args.instance;
    //    },
    //    resizable: false,
    //    width: "52%", height: "28%",
    //    autoOpen: false,
    //    theme: 'darkblue',
    //    isModal: true,
    //    showCloseButton: false
    //};
    //
    //// Printer dropdownlist
    //var source =
    //{
    //    datatype: "json",
    //    datafields: [
    //        { name: 'name'},
    //        { name: 'description'},
    //        { name: 'fullDescription'},
    //        { name: 'status' },
    //        { name: 'unique' }
    //    ],
    //    id: 'Unique',
    //    url: SiteRoot + 'admin/MenuPrinter/load_allPrintersFromConfig'
    //};
    //
    //$('#printerInvList').on('select', function(e) {
    //    $('#saveBtnPrinterInv').prop('disabled', false);
    //});
    //
    //var dataAdapter = new $.jqx.dataAdapter(source);
    //$scope.printerInvList = { source: dataAdapter, displayMember: "fullDescription", valueMember: "unique" };
    //
    //function setPrinterStoredArray() {
    //    // Fill with printers by item
    //    printerStoredArray = [];
    //    var rows = $('#printerItemTable').jqxDataTable('getRows');
    //    for(var j in rows) {
    //        printerStoredArray.push(rows[j]['PrinterUnique']);
    //    }
    //    // Check existing printers on stored by item
    //    for (var i in allPrintersArray) {
    //        var item = $("#printerInvList").jqxDropDownList('getItemByValue', allPrintersArray[i]);
    //        if (printerStoredArray.indexOf(allPrintersArray[i]) > -1) {
    //            $("#printerInvList").jqxDropDownList('disableItem', item);
    //        } else {
    //            $("#printerInvList").jqxDropDownList('enableItem', item);
    //        }
    //    }
    //}
    //
    //$scope.itemPrinterID = null;
    //$scope.createOrEditPitem = null;
    //$scope.openPrinterItemWin = function(e) {
    //    $scope.itemSelectedChangedID = $('#editItem_ItemSelected').jqxComboBox('getSelectedItem').value;
    //    $scope.createOrEditPitem = 'create';
    //    $scope.itemPrinterID = null;
    //    // Printers saved by Item
    //    setPrinterStoredArray();
    //    //
    //    $("#printerInvList").jqxDropDownList({selectedIndex: -1});
    //    $('#deleteBtnPrinterInv').hide();
    //    $('#saveBtnPrinterInv').prop('disabled', true);
    //    printerItemWind.setTitle('New Item Printer');
    //    printerItemWind.open();
    //};
    //
    //$scope.updateItemPrinter = function(e) {
    //    var row = e.args.row;
    //    $scope.itemSelectedChangedID = $('#editItem_ItemSelected').jqxComboBox('getSelectedItem').value;
    //    $scope.openPrinterItemWin();
    //    printerItemWind.setTitle('Edit Item Printer | Item: ' + row.ItemUnique + ' | Printer ID: ' + row.PrinterUnique);
    //    //
    //    $scope.createOrEditPitem = 'edit';
    //    $scope.itemPrinterID = row.Unique;
    //    $('#deleteBtnPrinterInv').show();
    //    var item = $("#printerInvList").jqxDropDownList('getItemByValue', row.PrinterUnique);
    //    $("#printerInvList").jqxDropDownList('enableItem', item);
    //    $("#printerInvList").jqxDropDownList({selectedIndex: item.index});
    //    $('#saveBtnPrinterInv').prop('disabled', true);
    //};
    //
    //$scope.closePrinterItemWin = function() {
    //    printerItemWind.close();
    //    $('#mainButtonsPrinterInv').show();
    //    $('#promptDeletePrinterInv').hide();
    //    setPrinterStoredArray();
    //};
    //
    //// Saving Item printer
    //$scope.saveItemPrinter = function() {
    //    var data = {
    //        'ItemUnique': $scope.itemSelectedChangedID,
    //        'PrinterUnique': $('#printerInvList').jqxDropDownList('getSelectedItem').value
    //    };
    //    var url;
    //    if ($scope.createOrEditPitem == 'create') {
    //        url = SiteRoot + 'admin/MenuPrinter/post_item_printer'
    //    } else if ($scope.createOrEditPitem == 'edit')
    //        url = SiteRoot + 'admin/MenuPrinter/update_item_printer/' + $scope.itemPrinterID;
    //    $.ajax({
    //        url: url,
    //        method: 'post',
    //        data: data,
    //        dataType: 'json',
    //        success: function(response) {
    //            if (response.status == 'success') {
    //                $scope.$apply(function() {
    //                    updatePrinterItemGrid();
    //                });
    //                $scope.closePrinterItemWin();
    //            } else if (response.status == 'error')
    //                console.log('Database error!');
    //            else
    //                console.log('There was an error!');
    //        }
    //    })
    //};
    //
    //$scope.promptClosePrinterItemWin = function (option) {
    //    if(option != undefined) {
    //        $('#mainButtonsPrinterInv').show();
    //        $('#promptToClosePrinterInv').hide();
    //        $('#promptDeletePrinterInv').hide();
    //    }
    //    if (option == 0) {
    //        $scope.saveItemPrinter();
    //    } else if (option == 1) {
    //        $scope.closePrinterItemWin();
    //    }
    //    else if (option == 2) {}
    //    else {
    //        if ($('#saveBtnPrinterInv').is(':disabled')) {
    //            $scope.closePrinterItemWin();
    //        }
    //        else {
    //            $('#promptToClosePrinterInv').show();
    //            $('#mainButtonsPrinterInv').hide();
    //            $('#promptDeletePrinterInv').hide();
    //        }
    //    }
    //};
    //
    //// Deleting Item printer
    //$scope.beforeDeleteItemPrinter = function(option) {
    //    if (option == 0) {
    //        $.ajax({
    //            url: SiteRoot + 'admin/MenuPrinter/delete_item_printer/' + $scope.itemPrinterID,
    //            method: 'post',
    //            dataType: 'json',
    //            success: function(response) {
    //                if(response.status == 'success') {
    //                    $scope.$apply(function() {
    //                        updatePrinterItemGrid();
    //                    });
    //                    $scope.closePrinterItemWin();
    //                } else if (response.status == 'error'){
    //                    console.log('there was an error db');
    //                } else {
    //                    console.log('there was an error');
    //                }
    //            }
    //        });
    //    } else if (option == 1) {
    //        $('#mainButtonsPrinterInv').show();
    //        //$('#pro-mptToCloseQitem').hide();
    //        $('#promptDeletePrinterInv').hide();
    //        printerItemWind.close();
    //    } else if (option == 2) {
    //        $('#mainButtonsPrinterInv').show();
    //        //$('#promptToCloseQitem').hide();
    //        $('#promptDeletePrinterInv').hide();
    //    } else {
    //        $('#mainButtonsPrinterInv').hide();
    //        //$('#promptToCloseQitem').hide();
    //        $('#promptDeletePrinterInv').show();
    //    }
    //};
});
