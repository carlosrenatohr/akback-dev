/**
 * Created by carlosrenato on 06-17-16.
 */
var demoApp = angular.module("demoApp", ['jqwidgets']);

demoApp.controller("customerController", function ($scope, $http) {

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
    $scope.dateSettings = {
        //selectionMode: 'range'
        //min: new Date(2016, 5, 10),
        max: new Date(),
        width: '250px', height: '25px'
    };

    $('body').on('select', '.customer-datalist', function (e) {
        console.log(e.args.item);
    });

    $scope.changeDatalist = function(e) {
        //console.log(e);
    };

    $scope.radioCollection = {};
    $scope.changeRadio = function(e) {
        var el = $(e.target).parent();
        var field = el.data('field');
        console.log($(e.target));
        $scope.radioCollection[field] = '';
    };

    $http({
        'method': 'GET',
        'url': SiteRoot + 'admin/Customer/load_customerAttributes'
    }).then(function(response) {
            console.log(response.data);
            $scope.customerControls = response.data;
        }, function(){}
    ).then(function(){

    });

    $scope.openAddCustomerWind = function() {
        customerWind.open();
    };

    var validationBeforeCustomer = function() {
        var needValidation = false;

        return needValidation;
    };

    $scope.saveCustomerBtn = function() {
        if (!validationBeforeCustomer()) {
            var data = {};
            $('.customer-field').each(function(i, value) {
                var el = $(value);
                var type = el.data('control-type');
                var inputValue;
                if (type == 'text') {
                    inputValue = el.find('input').val();
                    data[el.data('field')] = inputValue;
                } else if (type == 'number' || type == 'number2Decimal') {
                    inputValue = el.find('.customer-number').val();
                    data[el.data('field')] = inputValue;
                } else if (type == 'datalist') {
                    inputValue = el.find('.customer-datalist').jqxListBox('getSelectedItem').value;
                    data[el.data('field')] = inputValue;
                }
                else {
                    data[el.data('field')] = '';
                }

            });
            console.log(data);
        }
    }

});