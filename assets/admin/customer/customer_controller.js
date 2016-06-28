/**
 * Created by carlosrenato on 06-17-16.
 */
var demoApp = angular.module("demoApp", ['jqwidgets']);

demoApp.controller("customerController", function ($scope, $http) {

    var setNotificationInit = function (type) {
        return {
            width: "auto",
            appendContainer: "#customerNoticeContainer",
            opacity: 0.9,
            closeOnClick: true,
            autoClose: true,
            showCloseButton: false,
            template: (type == 1) ? 'success' : 'error'
        }
    };
    $scope.customerNoticeSuccessSettings = setNotificationInit(1);
    $scope.customerNoticeErrorSettings = setNotificationInit(0);

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
                {name: 'Address2', type: 'string'},
                {name: 'City', type: 'string'},
                {name: 'Country', type: 'string'},
                {name: 'State', type: 'string'},
                {name: 'Zip', type: 'string'},
                {name: 'Phone1', type: 'string'},
                {name: 'Phone2', type: 'string'},
                {name: 'Email', type: 'string'},
                {name: 'Custom1', type: 'string'},
                {name: 'Custom2', type: 'string'},
                {name: 'Custom3', type: 'string'},
                {name: 'Custom4', type: 'string'},
                {name: 'Custom5', type: 'string'},
                {name: 'Custom6', type: 'string'},
                {name: 'Custom7', type: 'string'},
                {name: 'Custom8', type: 'string'},
                {name: 'Custom9', type: 'string'},
                {name: 'Custom10', type: 'string'},
                {name: 'Custom11', type: 'string'},
                {name: 'Custom12', type: 'string'},
                {name: 'Custom13', type: 'string'},
                {name: 'Custom14', type: 'string'},
                {name: 'Custom15', type: 'string'},
                {name: 'Status', type: 'string'},

            ],
            id: 'Unique',
            url: SiteRoot + 'admin/Customer/load_allCustomers'
        },
        columns: [
            {text: 'ID', dataField: 'Unique', type: 'int', filterable: false},
            {text: 'First Name', dataField: 'FirstName', type: 'string'},
            {text: 'Middle Name', dataField: 'MiddleName', type: 'string'},
            {text: 'Last Name', dataField: 'LastName', type: 'string'},
            {text: 'Company', dataField: 'Company', type: 'string'},
            {text: 'Address', dataField: 'Address1', type: 'string'},
            {text: 'Address2', dataField: 'Address2', type: 'string', hidden: true},
            {text: 'City', dataField: 'City', type: 'string'},
            {text: 'State', dataField: 'State', type: 'string'},
            {text: 'Zip', dataField: 'Zip', type: 'string'},
            {text: 'Phone', dataField: 'Phone1', type: 'string'},
            {text: 'Phone2', dataField: 'Phone2', type: 'string', hidden: true},
            {text: 'Email', dataField: 'Email', type: 'string'},
            {text: 'Full Identification', dataField: 'Custom1', type: 'string', hidden: true},
            {text: 'Date of Birth', dataField: 'Custom2', type: 'string', hidden: true},
            {text: 'Gender', dataField: 'Custom3', type: 'string', hidden: true},
            {text: 'Marital Status', dataField: 'Custom4', type: 'string', hidden: true},
            {text: 'Ethnicity', dataField: 'Custom5', type: 'string', hidden: true},
            {text: 'Are you 18?', dataField: 'Custom6', type: 'string', hidden: true},
            {text: 'Disabled', dataField: 'Custom7', type: 'string', hidden: true},
            {text: 'Retired', dataField: 'Custom8', type: 'string', hidden: true},
            {text: 'How many working?', dataField: 'Custom9', type: 'string', hidden: true},
            {text: 'Work Status', dataField: 'Custom10', type: 'string', hidden: true},
            {text: 'Income', dataField: 'Custom11', type: 'string', hidden: true},
            {text: 'FS', dataField: 'Custom12', type: 'string', hidden: true},
            {text: 'WA', dataField: 'Custom13', type: 'string', hidden: true},
            {text: 'SS', dataField: 'Custom14', type: 'string', hidden: true},
            {text: 'SSD', dataField: 'Custom15', type: 'string', hidden: true},

        ],
        columnsResize: true,
        width: "100%",
        theme: 'arctic',
        sortable: true,
        pageable: true,
        pageSize: 20,
        //pagerMode: 'default',
        altRows: true,
        filterable: true,
        //filterMode: 'simple',
        showfilterrow: true,
    };

    var updateCustomerTableData = function() {
        $scope.$apply(function(){
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
                        {name: 'Address2', type: 'string'},
                        {name: 'City', type: 'string'},
                        {name: 'Country', type: 'string'},
                        {name: 'State', type: 'string'},
                        {name: 'Zip', type: 'string'},
                        {name: 'Phone1', type: 'string'},
                        {name: 'Phone2', type: 'string'},
                        {name: 'Email', type: 'string'},
                        {name: 'Custom1', type: 'string'},
                        {name: 'Custom2', type: 'string'},
                        {name: 'Custom3', type: 'string'},
                        {name: 'Custom4', type: 'string'},
                        {name: 'Custom5', type: 'string'},
                        {name: 'Custom6', type: 'string'},
                        {name: 'Custom7', type: 'string'},
                        {name: 'Custom8', type: 'string'},
                        {name: 'Custom9', type: 'string'},
                        {name: 'Custom10', type: 'string'},
                        {name: 'Custom11', type: 'string'},
                        {name: 'Custom12', type: 'string'},
                        {name: 'Custom13', type: 'string'},
                        {name: 'Custom14', type: 'string'},
                        {name: 'Custom15', type: 'string'},
                        {name: 'Status', type: 'string'},
                    ],
                    id: 'Unique',
                    url: SiteRoot + 'admin/Customer/load_allCustomers'
                },
                created: function (args) {
                    var instance = args.instance;
                    instance.updateBoundData();
                }
            };
        });
    };

    $scope.addCustomerWindSettings = {
        created: function (args) {
            customerWind = args.instance;
        },
        resizable: false,
        width: "80%", height: "100%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    // Setting buttons
    $scope.numberIntSettings = {
        //'allowNull': true,
        inputMode: 'simple',
        decimalDigits: 0,
        digits: 3,
        spinButtons: true,
        width: 200,
        height: 25,
    };

    $scope.numberDecimalSettings = {
        inputMode: 'simple',
        decimalDigits: 2,
        digits: 3,
        spinButtons: true,
        width: 200,
        height: 25,
        min: ''
    };

    $scope.dateSettings = {
        //selectionMode: 'range'
        //min: new Date(2016, 5, 10),
        max: new Date(),
        formatString: 'd',
        width: '200px', height: '25px'
    };

    $('body')
        .on('select', '.customer-datalist', function (e) {
        //console.log(e.args.item);
        $('#saveCustomerBtn').prop('disabled', false);
    })
        .on('change', '.customer-date', function (e) {
        //console.log(e.args.date);
        $('#saveCustomerBtn').prop('disabled', false);
    })
        .on('keypress keyup paste change', '.customer-textcontrol, .customer-number', function (e) {
            $('#saveCustomerBtn').prop('disabled', false);
    });

    $scope.radioCollection = {};
    $scope.changeRadio = function(e) {
        var el = $(e.target).parent();
        var field = el.data('field');
        $scope.radioCollection[field] = e.data;
    };

    $http({
        'method': 'GET',
        'url': SiteRoot + 'admin/Customer/load_customerAttributes'
    }).then(function(response) {
            console.log(response.data);
            $scope.customerControls = response.data;
        }, function() {}
    ).then(function() {

    });

    $scope.customerID = null;
    $scope.newOrEditCustomerAction = null;

    $scope.openAddCustomerWind = function() {
        $('#deleteCustomerBtn').hide();
        $('#saveCustomerBtn').prop('disabled', true);
        //
        $scope.newOrEditCustomerAction = 'new';
        $scope.customerID = null;
        //
        setTimeout(function(){
            //$('.customer-field:first input').focus();
            $('.customer-field[data-control-type=text]:first input').focus();
        }, 100);
        customerWind.setTitle('Add New Customer');
        customerWind.open();
    };

    $('#gridCustomer').on('rowdoubleclick', function(e) {
    //$scope.openEditCustomerWind = function(e) {
        var row = e.args.row.bounddata;
        //
        $scope.customerID = row.Unique;
        $scope.newOrEditCustomerAction = 'edit';
        //
        $('.customer-field').each(function(i, value) {
            var el = $(value);
            var type = el.data('control-type');
            var field = el.data('field');
            if (type == 'text') {
                el.find('input').val(row[field]);
            } else if (type == 'number' || type == 'number2Decimal') {
                el.find('.customer-number').val(row[field]);
            } else if (type == 'date') {
                //el.find('.customer-date').val(new Date());
                el.find('.customer-date').val(row[field]);
            } else if (type == 'radio') {
                el.find('.customer-radio[data-val=' + row[field]+ ']').jqxRadioButton({ checked:true });
            } else if (type == 'datalist') {
                var itemByValue = el.find('.customer-datalist').jqxListBox('getItemByValue', row[field]);
                el.find('.customer-datalist').jqxListBox({'selectedIndex': itemByValue.index});
            }
            else {
                console.info('NOT FOUND');
            }
        });
        //
        $('#deleteCustomerBtn').show();
        $('#saveCustomerBtn').prop('disabled', true);
        //
        setTimeout(function(){
            $('.customer-field[data-control-type=text]:first input').focus();
        }, 100);
        var fullName = (row.FirstName != null) ? row.FirstName: ''  + ' ' + row.LastName;
        customerWind.setTitle('Edit Customer: ' + row.Unique + ' | Customer: ' + fullName);
        customerWind.open();
    //};
    });

    var resetCustomerForm = function() {
        $('.customer-field').each(function(i, value) {
            var el = $(value);
            var type = el.data('control-type');
            if (type == 'text') {
                el.find('input').val('');
            } else if (type == 'number' || type == 'number2Decimal') {
                el.find('.customer-number').val('');
            } else if (type == 'date') {
                el.find('.customer-date').jqxDateTimeInput({ value: new Date() });
            } else if (type == 'radio') {
                el.find('.customer-radio:first-child').jqxRadioButton({ checked:true });
            } else if (type == 'datalist') {
                el.find('.customer-datalist').jqxListBox({'selectedIndex': 0});
            }
            else {
                console.info('Control was not found');
            }
        });
    };

    var validationBeforeCustomer = function() {
        var needValidation = false;

        $('.customer-field').each(function(i, value){
            var el = $(value);
            var type = el.data('control-type');
            var current;
            if (type == 'text') {
                needValidation = true;
                current = el.find('input.req');
                if (current.length && current.val() == '') {
                    $('#customerNoticeErrorSettings #notification-content')
                        .html(current.attr('placeholder') + ' can not be empty!');
                    $scope.customerNoticeErrorSettings.apply('open');
                    current.css({'border-color': '#F00'});
                } else {
                    current.css({'border-color': '#CCC'});
                }
            } else if (type == 'number' || type == 'number2Decimal') {
                needValidation = true;
                current = el.find('.customer-number.req');
                if (current.length && current.val() == '') {
                    $('#customerNoticeErrorSettings #notification-content')
                        .html(current.attr('placeholder') + ' can not be empty!');
                    $scope.customerNoticeErrorSettings.apply('open');
                    current.css({'border-color': '#F00'});
                } else {
                    current.css({'border-color': '#CCC'});
                }
            } else if (type == 'date') {
                current = el.find('.customer-date.req');
                if (current.val() == undefined && current.val() == '') {
                    $('#customerNoticeErrorSettings #notification-content')
                        .html(current.data('placeholder') + ' needs to be a valid date!');
                    $scope.customerNoticeErrorSettings.apply('open');
                    current.css({'border-color': '#F00'});
                } else {
                    current.css({'border-color': '#CCC'});
                }
            } else if (type == 'datalist') {
                current = el.find('.customer-datalist');
                var listboxSelected = current.jqxListBox('getSelectedItem');
                if (!listboxSelected) {
                    $('#customerNoticeErrorSettings #notification-content')
                        .html('Select an item on ' + current.data('placeholder'));
                    $scope.customerNoticeErrorSettings.apply('open');
                    current.css({'border-color': '#F00'});
                } else {
                    current.css({'border-color': '#CCC'});
                }
            }
        });

        return needValidation;
    };

    $scope.saveCustomerAction = function() {
        if (!validationBeforeCustomer()) {
            var data = {};
            $('.customer-field').each(function(i, value) {
                var el = $(value);
                var type = el.data('control-type');
                var inputValue;
                if (type == 'text') {
                    inputValue = el.find('input.customer-textcontrol').val();
                } else if (type == 'number' || type == 'number2Decimal') {
                    inputValue = el.find('.customer-number').val();
                } else if (type == 'date') {
                    inputValue = el.find('.customer-date').val();
                } else if (type == 'radio') {
                    inputValue = $scope.radioCollection[el.data('field')];
                    data[el.data('field')] = inputValue;
                } else if (type == 'datalist') {
                    inputValue = el.find('.customer-datalist').jqxListBox('getSelectedItem').value;
                }
                else {
                    data[el.data('field')] = '-';
                }
                data[el.data('field')] = inputValue;
            });
            //
            var url = ($scope.newOrEditCustomerAction == 'edit')
                        ? 'admin/Customer/updateCustomer/' + $scope.customerID
                        : 'admin/Customer/createCustomer';
            $.ajax({
                url: SiteRoot + url,
                method: 'post',
                dataType: 'json',
                data: data,
                success: function(data) {
                    if (data.status == 'success') {
                        updateCustomerTableData();
                        customerWind.close();
                        resetCustomerForm();
                        //
                        var msg;
                        if ($scope.newOrEditCustomerAction == 'edit') {
                            msg = 'Customer updated successfully';
                            console.info(msg);
                            //console.info(data.message);
                        } else if ($scope.newOrEditCustomerAction == 'create') {
                            msg = 'Customer created successfully';
                            console.info(msg);
                        }
                    } else if (data.status == 'error'){
                        console.log(data.message);
                    } else {
                        console.error('Error from ajax');
                    }
                }
            });
        }
    };

    $scope.deleteCustomerAction = function() {
        $.ajax({
            url: SiteRoot + 'admin/Customer/deleteCustomer/' + $scope.customerID,
            method: 'post',
            dataType: 'json',
            success: function(data) {
                if (data.status == 'success') {
                    updateCustomerTableData();
                    $scope.closeCustomerAction();
                    console.info(data.message);
                } else if (data.status == 'error'){
                    console.log(data.message);
                } else {
                    console.error('Error from ajax');
                }
            }
        })
    };

    $scope.closeCustomerAction = function() {
        customerWind.close();
        resetCustomerForm();
    };

});