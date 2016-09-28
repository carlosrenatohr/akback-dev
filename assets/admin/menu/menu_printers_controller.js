/**
 * Created by carlosrenato on 08-10-16.
 */

app.controller('menuPrintersController', function($scope) {

    // -- MenuCategories Tabs
    $('#MenuCategoriesTabs').on('tabclick', function (e) {
        var tabclicked = e.args.item;
        var tabTitle = $('#MenuCategoriesTabs').jqxTabs('getTitleAt', tabclicked);
        // PRINTERS TAB - Reload queries
        if (tabTitle == 'Printers') {
            updatePrinterTable();
            //$('#printerTable').jqxGrid('updatebounddata', 'filter');
            if (allPrintersArray == '') {
                var rows = $("#printerItemList").jqxDropDownList('getItems');
                for(var j in rows) {
                    allPrintersArray.push(rows[j]['value']);
                }
            }
        }
    });

    //$('#printerTable').on('bindingComplete', function() {
    var updatePrinterTable = function() {
        $(this).jqxGrid({
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
                    {name: 'fullDescription', type: 'string'},
                    {name: 'ItemDescription', type: 'string'},
                    {name: 'Category', type: 'string'},
                    {name: 'SubCategory', type: 'string'}
                ],
                url: SiteRoot + 'admin/MenuPrinter/load_completePrinters'
            })
        });
    }
    //});

    //$scope.printerTableSettings = {
    $('#printerTable').jqxGrid({
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
                {name: 'fullDescription', type: 'string'},
                {name: 'ItemDescription', type: 'string'},
                {name: 'Category', type: 'string'},
                {name: 'SubCategory', type: 'string'}
            ],
            url: SiteRoot + 'admin/MenuPrinter/load_completePrinters'
        }),
        columns: [
            {text: 'ID', dataField: 'Unique', type: 'int', width: '8%', filtertype: 'textbox'},
            {text: 'Item', dataField: 'Item', type: 'string', width: '15%', filtertype: 'textbox'},
            {text: 'Category', dataField: 'Category', type: 'string', width: '11%', filtertype: 'list'},
            {text: 'SubCategory', dataField: 'SubCategory', type: 'string', width: '11%', filtertype: 'list'},
            {text: 'Item Description', dataField: 'ItemDescription', type: 'string', width: '20%', filtertype: 'textbox'},
            {text: 'Printer Name', dataField: 'name', type: 'string', width: '15%', filtertype: 'textbox'},
            {text: 'Printer Description', dataField: 'description', type: 'string', width: '20%', filtertype: 'textbox'},
            {text: '', dataField: 'ItemUnique', type: 'int', hidden: true},
            {text: '', dataField: 'PrinterUnique', type: 'int', hidden: true},
            {text: '', dataField: 'Status', type: 'int', hidden: true},
            {text: '', dataField: 'fullDescription', type: 'string', hidden: true}
        ],
        width: "100%",
        theme: 'arctic',
        filterable: true,
        showfilterrow: true,
        ready: function() {
            $('#printerTable').jqxGrid('updatebounddata', 'filter');
        },
        sortable: true,
        pageable: true,
        pageSize: 15,
        pagesizeoptions: ['5', '10', '15'],
        altRows: true,
        autoheight: true,
        autorowheight: true
    });
    //};

    var printerWind;
    $scope.printerWindowSettings = {
        created: function (args) {
            printerWind = args.instance;
        },
        resizable: false,
        width: "50%", height: "35%",
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

    var anyChangePrompt = false;
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
        anyChangePrompt = true;
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
        anyChangePrompt = true;
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
        anyChangePrompt = false;
        $('#deleteBtnPrinter').hide();
        printerWind.setTitle('New Item Printer');
        printerWind.open();
    };

    $('#printerTable').on('rowdoubleclick', function(e) {
    //$scope.updatePrinterWin = function(e) {
    //    var row = e.args.row;
        var row = e.args.row.bounddata;
        $scope.createOrEditPrinter = 'edit';
        $scope.printerSelectedID = row.Unique;
        // Printers saved by Item
        setPrinterStoredArray();
        //setAllPrintersArray();
        ////
        if (row.ItemUnique != null) {
            var item = $("#itemMainList").jqxComboBox('getItemByValue', row.ItemUnique);
            $("#itemMainList").jqxComboBox({selectedIndex: item.index});
        } else {
            $("#itemMainList").jqxComboBox({selectedIndex: -1});
        }
        //
        if (row.PrinterUnique != null) {
            var printer = $("#printerMainList").jqxDropDownList('getItemByValue', row.PrinterUnique);
            $("#printerMainList").jqxDropDownList('enableItem', printer);
            $("#printerMainList").jqxDropDownList({selectedIndex: printer.index});
            $('#deleteBtnPrinter').show();
        } else {
            $("#printerMainList").jqxDropDownList({selectedIndex: -1});
            $('#deleteBtnPrinter').hide();
        }
        $('#saveBtnPrinter').hide();
        //$('#saveBtnPrinter').prop('disabled', true);
        anyChangePrompt = false;
        printerWind.setTitle('Edit Item Printer | Item: ' + row.ItemUnique + ' | Printer ID: ' + row.PrinterUnique);
        printerWind.open();
    //};
    });

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
            if ($scope.itemPrinterID == null) {
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
                        if ($scope.createOrEditPrinter == 'edit')
                            $('#printerTable').jqxGrid('updatebounddata', 'filter');
                        else
                            $('#printerTable').jqxGrid('updatebounddata');
                        $scope.closingPrinterWind();
                    } else if (response.status == 'error')
                        console.log('Database error!');
                    else
                        console.log('There was an error!');
                }
            })
        }
    };

    $scope.closingPrinterWind = function() {
        printerWind.close();
        $('#mainButtonsPrinter').show();
        $('#promptClosePrinter').hide();
        $('#promptDeletePrinter').hide();
        setPrinterStoredArray();
        anyChangePrompt = false;
    };

    $scope.closeBtnPrinter = function (option) {
        if(option != undefined) {
            $('#mainButtonsPrinter').show();
            $('#promptClosePrinter').hide();
            $('#promptDeletePrinter').hide();
        }
        if (option == 0) {
            $scope.savePrinterByItem();
        } else if (option == 1) {
            $scope.closingPrinterWind();
        }
        else if (option == 2) {}
        else {
            //if ($('#saveBtnPrinterItem').is(':disabled')) {
            if (!anyChangePrompt) {
                printerWind.close();
            }
            else {
                $('#promptClosePrinter').show();
                $('#mainButtonsPrinter').hide();
                $('#promptDeletePrinter').hide();
            }
        }
    };

    // Deleting Item printer
    $scope.beforeDeleteIPrinter = function(option) {
        if (option == 0) {
            if ($scope.printerSelectedID == null) {
                $scope.closingPrinterWind();
            } else {
                $.ajax({
                    url: SiteRoot + 'admin/MenuPrinter/delete_item_printer/' + $scope.printerSelectedID,
                    method: 'post',
                    dataType: 'json',
                    success: function(response) {
                        if(response.status == 'success') {
                            $scope.closingPrinterWind();
                            //printerWind.close();
                            //$('#printerTable').jqxGrid('updatebounddata', 'filter');
                            updatePrinterTable();
                        } else if (response.status == 'error'){
                            console.log('there was an error db');
                        } else {
                            console.log('there was an error');
                        }
                    }
                });
            }
        } else if (option == 1) {
            $('#mainButtonsPrinter').show();
            $('#promptClosePrinter').hide();
            $('#promptDeletePrinter').hide();
            $scope.closingPrinterWind();
        } else if (option == 2) {
            $('#mainButtonsPrinter').show();
            $('#promptClosePrinter').hide();
            $('#promptDeletePrinter').hide();
        } else {
            $('#mainButtonsPrinter').hide();
            $('#promptClosePrinter').hide();
            $('#promptDeletePrinter').show();
        }
    };

});