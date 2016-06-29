/**
 * Created by carlosrenato on 06-17-16.
 */
var demoApp = angular.module("demoApp", ['jqwidgets']);

demoApp.controller("customerController", function ($scope, $http, customerService) {

    var customerWind, customerContactWin;
    $scope.customerTableSettings = customerService.getTableSettings;
    $scope.customerContactTableSettings = customerService.getContactsTableSettings(1);

    var updateCustomerTableData = function() {
        var source = customerService.getTableSettings.source;
        $scope.$apply(function() {
            $scope.customerTableSettings = {
                source: {
                    dataFields: source.dataFields,
                    dataType: source.dataType,
                    id: source.id,
                    url: source.url
                },
                created: function (args) {
                    var instance = args.instance;
                    instance.updateBoundData();
                }
            };
        });
    };

    // Customer window
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

    // Customer contact window
    $scope.addCustomerContactWinSettings = {
        created: function (args) {
            customerContactWin = args.instance;
        },
        resizable: false,
        width: "35%", height: "75%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    // Notifications settings
    $scope.customerNoticeSuccessSettings = customerService.setNotificationSettings(1);
    $scope.customerNoticeErrorSettings = customerService.setNotificationSettings(0);

    // Getting all attributes
    customerService.getCustomerAttributes()
        .then(function (response) {
                $scope.customerControls = response.data;
            }, function () {}
            // at end of request
        ).then(function () {});

    customerService.getCustomerContactsAttributes()
        .then(function (response) {
                $scope.customerContactsControls = response.data;
            }, function () {}
            // at end of request
        );

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

    $scope.customerID = null;
    $scope.newOrEditCustomerAction = null;

    $scope.openAddCustomerWind = function() {
        $('#deleteCustomerBtn').hide();
        $('#saveCustomerBtn').prop('disabled', true);
        //
        $scope.newOrEditCustomerAction = 'create';
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
                var radio = el.find('.customer-radio[data-val=' + row[field]+ ']');
                if (radio.length)
                    radio.jqxRadioButton({ checked:true });
            } else if (type == 'datalist') {
                var itemByValue = el.find('.customer-datalist').jqxListBox('getItemByValue', row[field]);
                el.find('.customer-datalist').jqxListBox({'selectedIndex': (itemByValue) ? itemByValue.index : -1});
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
                var radio = el.find('.customer-radio:first-child');
                if (radio.length)
                    radio.jqxRadioButton({ checked:true });
            } else if (type == 'datalist') {
                el.find('.customer-datalist').jqxListBox({'selectedIndex': 0});
                el.find('.customer-datalist').css({'border-color': '#CCC'});
            }
            else {
                console.info('Control was not found');
            }
            el.find(':first-child').css({'border-color': '#CCC'});
        });
    };

    var validationBeforeCustomer = function() {
        var needValidation = false;

        $('.customer-field').each(function(i, value){
            var el = $(value);
            var type = el.data('control-type');
            var current;
            if (type == 'text') {
                current = el.find('input.req');
                if (current.length && current.val() == '') {
                    needValidation = true;
                    $('#customerNoticeErrorSettings #notification-content')
                        .html(current.attr('placeholder') + ' can not be empty!');
                    $scope.customerNoticeErrorSettings.apply('open');
                    current.css({'border-color': '#F00'});
                } else {
                    current.css({'border-color': '#CCC'});
                }
            } else if (type == 'number' || type == 'number2Decimal') {
                current = el.find('.customer-number.req');
                if (current.length && current.val() == '') {
                    needValidation = true;
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
                    needValidation = true;
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
                if (!listboxSelected && current.hasClass('req')) {
                    needValidation = true;
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

    $scope.saveCustomerAction = function(fromPrompt) {
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
                        //
                        var msg;
                        if ($scope.newOrEditCustomerAction == 'edit') {
                            msg = 'Customer updated successfully';
                            //console.info(data.message);
                        } else if ($scope.newOrEditCustomerAction == 'create') {
                            msg = 'Customer created successfully';
                            $scope.newOrEditCustomerAction = 'edit';
                            $scope.customerID = data.new_id;
                        }
                        //
                        if (fromPrompt) {
                            customerWind.close();
                            resetCustomerForm();
                        } else {
                            $('#saveCustomerBtn').prop('disabled', true);
                            $('#customerNoticeSuccessSettings #notification-content')
                                .html(msg);
                            $scope.customerNoticeSuccessSettings.apply('open');
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

    $scope.deleteCustomerAction = function(option) {
        if (option != undefined) {
            $('#mainButtonsCustomerForm').show();
            $('#promptToCloseCustomerForm').hide();
            $('#promptToDeleteCustomerForm').hide();
        }
        if (option == 0) {
            $.ajax({
                url: SiteRoot + 'admin/Customer/deleteCustomer/' + $scope.customerID,
                method: 'post',
                dataType: 'json',
                success: function(data) {
                    if (data.status == 'success') {
                        updateCustomerTableData();
                        $scope.closeCustomerAction();
                        //$('#customerNoticeSuccessSettings #notification-content')
                        //    .html(msg);
                        //$scope.customerNoticeSuccessSettings.apply('open');
                    } else if (data.status == 'error') {
                        console.log(data.message);
                    } else {
                        console.error('Error from ajax');
                    }
                }
            });
        } else if (option == 1) {
            customerWind.close();
            resetCustomerForm();
        } else if (option == 2) {

        } else {
            $('#mainButtonsCustomerForm').hide();
            $('#promptToCloseCustomerForm').hide();
            $('#promptToDeleteCustomerForm').show();
        }
    };

    $scope.closeCustomerAction = function(option) {
        if (option != undefined) {
            $('#mainButtonsCustomerForm').show();
            $('#promptToCloseCustomerForm').hide();
            $('#promptToDeleteCustomerForm').hide();
        }
        if (option == 0) {
            $scope.saveCustomerAction(true);
        } else if (option == 1) {
            customerWind.close();
        } else if (option == 2) {

        } else {
            if ($('#saveCustomerBtn').is(':disabled')) {
                customerWind.close();
                resetCustomerForm();
            } else {
                $('#mainButtonsCustomerForm').hide();
                $('#promptToCloseCustomerForm').show();
                $('#promptToDeleteCustomerForm').hide();
            }
        }
    };

    /**
     * CONTACT TAB
     */
    $scope.openContactWindow = function() {
        customerContactWin.open();
    };

    $scope.closeCustomerContact = function() {
        customerContactWin.close();
    };

});