/**
 * Created by carlosrenato on 08-10-16.
 */

app.controller('menuPrintersController', function($scope) {
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
            {text: '', dataField: 'fullDescription', type: 'string', hidden: true},
        ],
        //columnsResize: true,
        width: "100%",
        height: "800",
        theme: 'arctic',
        sortable: true,
        pageable: true,
        pageSize: 15
    };

    var printerItemWind;
    $scope.printerWindowSettings = {
        created: function (args) {
            printerItemWind = args.instance;
        },
        resizable: false,
        width: "40%", height: "30%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    // Printer dropdownlist
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

    //$('#printerItemList').on('select', function(e) {
    //    $('#saveBtnPrinterItem').prop('disabled', false);
    //});

    //var dataAdapter = new $.jqx.dataAdapter(source);
    //$scope.printerItemList = { source: dataAdapter, displayMember: "fullDescription", valueMember: "unique" };

    $scope.printerSelectedID = null;
    $scope.createOrEditPrinter = null;
    $scope.openPrinterWin = function(e) {
        //$scope.itemSelectedChangedID = $('#editItem_ItemSelected').jqxComboBox('getSelectedItem').value;
        //$scope.createOrEditPitem = 'create';
        //$scope.itemPrinterID = null;
        //// Printers saved by Item
        ////setPrinterStoredArray();
        ////
        //$("#printerItemList").jqxDropDownList({selectedIndex: -1});
        //$('#deleteBtnPrinterItem').hide();
        //$('#saveBtnPrinterItem').prop('disabled', true);
        printerItemWind.setTitle('New Item Printer');
        printerItemWind.open();
    };

    $scope.updatePrinterWin = function(e) {
        var row = e.args.row;
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
    };

});