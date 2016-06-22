/**
 * Created by carlosrenato on 06-17-16.
 */
var demoApp = angular.module("demoApp", ['jqwidgets']);

demoApp.controller("customerController", function ($scope) {

    var customerWind;
    $scope.customerTableSettings = {
        source: {
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'int'},
                {name: 'FirstName', type: 'string'},
                {name: 'MiddleName', type: 'string'},
                {name: 'LastName', type: 'string'},
                {name: 'Company', type: 'string'},
                {name: 'Address1', type: 'string'},
                {name: 'City', type: 'string'},
                {name: 'Country', type: 'string'},
                {name: 'State', type: 'string'},
                {name: 'Zip', type: 'string'},
                {name: 'Email', type: 'string'},

            ],
            id: 'Unique',
            url: SiteRoot + 'admin/Customer/load_allCustomers'
        },
        columns: [
            {text: 'ID', dataField: 'Unique', type: 'int'},
            {text: 'First Name', dataField: 'FirstName', type: 'string'},
            {text: 'Last Name', dataField: 'LastName', type: 'string'},
            {text: 'Company', dataField: 'Company', type: 'string'},
            {text: 'Address', dataField: 'Address1', type: 'string'},
            {text: 'City', dataField: 'City', type: 'string'},
            {text: 'State', dataField: 'State', type: 'string'},
            {text: 'Zip', dataField: 'Zip', type: 'string'},
            {text: 'Phone', dataField: 'Phone1', type: 'string'},
            {text: 'Email', dataField: 'Email', type: 'string'},

        ],
        columnsResize: true,
        width: "100%",
        theme: 'arctic',
        sortable: true,
        pageable: true,
        pageSize: 20,
        pagerMode: 'default',
        altRows: true,
        filterable: true,
        filterMode: 'simple'
    };

    $scope.addCustomerWindSettings = {
        created: function (args) {
            customerWind = args.instance;
        },
        resizable: false,
        width: "60%", height: "80%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    // Setting buttons
    $('.jqxRadio').jqxRadioButton({
        //width: '250px',
        height: 25,
        checked: false,
        theme: 'artic'
    });

    $('.jqxDecimalNumber').jqxNumberInput({
        //width: '250px',
        height: '25px',
        min: 0,
        spinButtons: true,
        digits: 3,
        decimalDigits: 2
    });

    $('.jqxDate').jqxDateTimeInput({
        //width: '300px',
        height: '25px'
    });

    $('.jqxDatalist').jqxListBox({
        selectedIndex: -1,
        source: ["first", "second", "third"],
        width: 200,
        height: 75
    });

    $scope.openAddCustomerWind = function() {
        customerWind.open();
    }

});