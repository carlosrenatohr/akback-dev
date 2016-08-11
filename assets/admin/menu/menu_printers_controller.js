/**
 * Created by carlosrenato on 08-10-16.
 */

app.controller('menuPrintersController', function($scope) {


    $('#MenuCategoriesTabs').on('tabclick', function (e) {
        var tabclicked = e.args.item;
        // ITEMS TAB - Reload queries
        if (tabclicked == 4) {
            updatePrinterTable();
            if (allPrintersArray == '') {
                var rows = $("#printerItemList").jqxDropDownList('getItems');
                for(var j in rows) {
                    allPrintersArray.push(rows[j]['value']);
                }
            }
        }
    });

    function updatePrinterTable() {
        $scope.printerTableSettings = {
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
                    {name: 'fullDescription', type: 'string'},
                    {name: 'ItemDescription', type: 'string'}
                ],
                url: SiteRoot + 'admin/MenuPrinter/load_allItemPrinters'
            },
            columns: [
                {text: 'ID', dataField: 'Unique', type: 'int'},
                {text: 'Item', dataField: 'Item', type: 'string'},
                {text: 'Item Description', dataField: 'ItemDescription', type: 'string'},
                {text: 'Name', dataField: 'name', type: 'string'},
                {text: 'Printer Description', dataField: 'description', type: 'string'},
                {text: '', dataField: 'ItemUnique', type: 'int', hidden: true},
                {text: '', dataField: 'Status', type: 'int', hidden: true},
                {text: '', dataField: 'fullDescription', type: 'string', hidden: true}
            ],
            created: function (args) {
                args.instance.updateBoundData();
            }
        }
    };

    $scope.printerTableSettings = {
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
                {name: 'fullDescription', type: 'string'},
                {name: 'ItemDescription', type: 'string'}
            ],
            url: SiteRoot + 'admin/MenuPrinter/load_allItemPrinters'
        },
        columns: [
            {text: 'ID', dataField: 'Unique', type: 'int'},
            {text: 'Item', dataField: 'Item', type: 'string'},
            {text: 'Item Description', dataField: 'ItemDescription', type: 'string'},
            {text: 'Name', dataField: 'name', type: 'string'},
            {text: 'Printer Description', dataField: 'description', type: 'string'},
            {text: '', dataField: 'ItemUnique', type: 'int', hidden: true},
            {text: '', dataField: 'Status', type: 'int', hidden: true},
            {text: '', dataField: 'fullDescription', type: 'string', hidden: true}
        ],
        width: "100%",
        theme: 'arctic',
        sortable: true,
        pageable: true,
        pageSize: 15
    };

    var printerWind;
    $scope.printerWindowSettings = {
        created: function (args) {
            printerWind = args.instance;
        },
        resizable: false,
        width: "40%", height: "40%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    // Printer dropdownlist
    var sourceMenuPrinter = new $.jqx.dataAdapter(
    {
        datatype: "json",
        datafields: [
            { name: 'name'},
            { name: 'description'},
            { name: 'fullDescription'},
            { name: 'status' },
            { name: 'unique' }
        ],
        url: SiteRoot + 'admin/MenuPrinter/load_allPrintersFromConfig'
    });
    $scope.printerMainList = { source: sourceMenuPrinter, displayMember: "fullDescription", valueMember: "unique" };

    $('#itemMainList').on('select', function(e) {
        var itemSelectedUnique = (e.args.item);
        if (itemSelectedUnique != null) {
            itemSelectedUnique = itemSelectedUnique.originalItem.Unique;
            $('#saveBtnPrinter').prop('disabled', false);
            printerStoredArray = [];
            var rows = $('#printerTable').jqxDataTable('getRows');
            for(var j in rows) {
                if (itemSelectedUnique == rows[j]['ItemUnique'] )
                    printerStoredArray.push(rows[j]['PrinterUnique']);
            }
            // Check existing printers on stored by item
            for (var i in allPrintersArray) {
                var item = $("#printerMainList").jqxDropDownList('getItemByValue', allPrintersArray[i]);
                if (printerStoredArray.indexOf(allPrintersArray[i]) > -1) {
                    $("#printerMainList").jqxDropDownList('disableItem', item);
                } else {
                    $("#printerMainList").jqxDropDownList('enableItem', item);
                }
            }
            $("#printerMainList").jqxDropDownList({selectedIndex: -1});
        }
    });

    var sourceMenuItem = new $.jqx.dataAdapter(
    {
        datatype: "json",
        datafields: [
            { name: 'Description'},
            { name: 'Status' },
            { name: 'Item' },
            { name: 'Unique' }
        ],
        url: SiteRoot + 'admin/MenuItem/load_allItems?sort='
    });
    $scope.itemMainList = { source: sourceMenuItem, displayMember: "Description", valueMember: "Unique", placeHolder: 'Select an item' };

    $('#printerMainList').on('select', function(e) {
        $('#saveBtnPrinter').prop('disabled', false);
    });

    $scope.printerSelectedID = null;
    $scope.createOrEditPrinter = null;
    $scope.openPrinterWin = function() {
        $scope.createOrEditPrinter = 'create';
        $scope.printerSelectedID = null;
        // Printers saved by Item
        //setPrinterStoredArray();
        //
        $("#itemMainList").jqxComboBox({selectedIndex: -1});
        $("#printerMainList").jqxDropDownList({selectedIndex: -1});
        $('#saveBtnPrinter').show();
        $('#saveBtnPrinter').prop('disabled', true);
        $('#deleteBtnPrinter').hide();
        printerWind.setTitle('New Item Printer');
        printerWind.open();
    };

    $scope.updatePrinterWin = function(e) {
        var row = e.args.row;
        $scope.createOrEditPrinter = 'edit';
        $scope.printerSelectedID = row.Unique;
        // Printers saved by Item
        //setPrinterStoredArray();
        //setAllPrintersArray();
        ////
        var printer = $("#printerMainList").jqxDropDownList('getItemByValue', row.PrinterUnique);
        $("#printerMainList").jqxDropDownList('enableItem', printer);
        $("#printerMainList").jqxDropDownList({selectedIndex: printer.index});
        var item = $("#itemMainList").jqxComboBox('getItemByValue', row.ItemUnique);
        $("#itemMainList").jqxComboBox({selectedIndex: item.index});
        $('#saveBtnPrinter').hide();
        //$('#saveBtnPrinter').prop('disabled', true);
        $('#deleteBtnPrinter').show();
        printerWind.setTitle('Edit Item Printer | Item: ' + row.ItemUnique + ' | Printer ID: ' + row.PrinterUnique);
        printerWind.open();
    };

    $scope.closeBtnPrinter = function() {
        printerWind.close();
        $('#mainButtonsPrinter').show();
        $('#promptDeletePrinter').hide();
        setPrinterStoredArray();
    };

    var printerStoredArray = [], allPrintersArray = [];
    function setPrinterStoredArray() {
        // Fill with printers by item
        printerStoredArray = [];
        var rows = $('#printerTable').jqxDataTable('getRows');
        for(var j in rows) {
            printerStoredArray.push(rows[j]['PrinterUnique']);
        }
        // Check existing printers on stored by item
        for (var i in allPrintersArray) {
            var item = $("#printerMainList").jqxDropDownList('getItemByValue', allPrintersArray[i]);
            if (printerStoredArray.indexOf(allPrintersArray[i]) > -1) {
                $("#printerMainList").jqxDropDownList('disableItem', item);
            } else {
                $("#printerMainList").jqxDropDownList('enableItem', item);
            }
        }
    }

    var setNotificationInit = function (type) {
        return {
            width: "auto",
            appendContainer: "#notification_container_menuprinter",
            opacity: 0.9,
            closeOnClick: true,
            autoClose: true,
            showCloseButton: false,
            template: (type == 1) ? 'success' : 'error'
        }
    };
    $scope.menuPrinterSuccess = setNotificationInit(1);
    $scope.menuPrinterError = setNotificationInit(0);

    function validationSavePrinterByItem () {
        var needValidation = false;
        var item = $('#itemMainList').jqxComboBox('getSelectedItem');
        var printer = $('#printerMainList').jqxDropDownList('getSelectedItem');
        //
        if (!item) {
            needValidation = true;
            $('#menuPrinterError #notification-content')
                .html('Select an item from list');
            $scope.menuPrinterError.apply('open');
            $('#itemMainList').css({'border-color': '#F00'});
        } else {
            $('#itemMainList').css({'border-color': '#CCC'});
        }
        //
        if (!printer) {
            needValidation = true;
            $('#menuPrinterError #notification-content')
                .html('Select a printer from list');
            $scope.menuPrinterError.apply('open');
            $('#printerMainList').css({'border-color': '#F00'});
        } else {
            $('#printerMainList').css({'border-color': '#CCC'});
        }

        return needValidation;
    }

    // Saving Item printer
    $scope.savePrinterByItem = function() {
        if(!validationSavePrinterByItem()) {
            var item = $('#itemMainList').jqxComboBox('getSelectedItem');
            var printer = $('#printerMainList').jqxDropDownList('getSelectedItem');
            var data = {
                'ItemUnique': item.value,
                'PrinterUnique': printer.value
            };
            var url;
            if ($scope.createOrEditPrinter == 'create') {
                url = SiteRoot + 'admin/MenuPrinter/post_item_printer'
            } else if ($scope.createOrEditPrinter == 'edit')
                url = SiteRoot + 'admin/MenuPrinter/update_item_printer/' + $scope.itemPrinterID;
            $.ajax({
                url: url,
                method: 'post',
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        $scope.$apply(function() {
                            updatePrinterTable();
                        });
                        $scope.closeBtnPrinter();
                    } else if (response.status == 'error')
                        console.log('Database error!');
                    else
                        console.log('There was an error!');
                }
            })
        }
    };

    // Deleting Item printer
    $scope.beforeDeleteIPrinter = function(option) {
        if (option == 0) {
            $.ajax({
                url: SiteRoot + 'admin/MenuPrinter/delete_item_printer/' + $scope.printerSelectedID,
                method: 'post',
                dataType: 'json',
                success: function(response) {
                    if(response.status == 'success') {
                        $scope.$apply(function() {
                            updatePrinterTable();
                        });
                        $scope.closeBtnPrinter();
                    } else if (response.status == 'error'){
                        console.log('there was an error db');
                    } else {
                        console.log('there was an error');
                    }
                }
            });
        } else if (option == 1) {
            $('#mainButtonsPrinter').show();
            //$('#promptToCloseQitem').hide();
            $('#promptDeletePrinter').hide();
            printerItemWind.close();
        } else if (option == 2) {
            $('#mainButtonsPrinter').show();
            //$('#promptToCloseQitem').hide();
            $('#promptDeletePrinter').hide();
        } else {
            $('#mainButtonsPrinter').hide();
            //$('#promptToCloseQitem').hide();
            $('#promptDeletePrinter').show();
        }
    };

});