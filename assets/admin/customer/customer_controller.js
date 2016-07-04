/**
 * Created by carlosrenato on 06-17-16.
 */
var demoApp = angular.module("demoApp", ['jqwidgets']);

demoApp.controller("customerController", function ($scope, $http, customerService) {

    /**
     * TABS
     * @param e
     */
    $scope.changingCustomerTab = function(e) {
        var tabclick = e.args.item;
        var deleteBtn = angular.element('#deleteCustomerBtn');
        if ($scope.newOrEditCustomerAction == 'edit') {
            if (tabclick == 0)
                deleteBtn.show();
            else
                deleteBtn.hide();
            // Contacts tab
            if(tabclick == 2) {
                updateCustomerContactTableData();
            }
            // Notes tab
            if(tabclick == 3) {
                updateCustomerNotesTableData();
            }
            // Purchases tab
            if(tabclick == 4) {
                updateCustomerPurchasesTableData();
            }
        }
    };

    var customerWind, customerContactWin, customerNotesWin;
    $scope.customerTableSettings = customerService.getTableSettings;
    $scope.customerContactTableSettings = customerService.getContactsTableSettings();
    $scope.customerNotesTableSettings = customerService.getNotesTableSettings();
    $scope.customerPurchasesTableSettings = customerService.getPurchasesTableSettings();

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

    var updateCustomerContactTableData = function() {
        if ($scope.customerID != undefined) {
            var source = customerService.getContactsTableSettings($scope.customerID).source;
            $scope.$apply(function() {
                $scope.customerContactTableSettings = {
                    source: new $.jqx.dataAdapter(
                        {
                        dataFields: source.dataFields,
                        dataType: source.dataType,
                        //id: source.id,
                        url: source.url
                        }
                    ),
                    created: function (args) {
                        var instance = args.instance;
                        instance.updatebounddata();
                        //instance.refreshdata();
                        //var completed = $("#customerNotesGrid").jqxGrid('IsBindingCompleted');
                    }
                };
            });
        }
    };

    var updateCustomerNotesTableData = function() {
        if ($scope.customerID != undefined) {
            var source = customerService.getNotesTableSettings($scope.customerID).source;
            $scope.$apply(function() {
                $scope.customerNotesTableSettings = {
                    source: new $.jqx.dataAdapter(
                        {
                        dataFields: source.dataFields,
                        dataType: source.dataType,
                        id: source.id,
                        url: source.url
                        }
                    ),
                    created: function (args) {
                        var instance = args.instance;
                        instance.updatebounddata();
                    },
                };
            });
        }
    };

    var updateCustomerPurchasesTableData = function() {
        if ($scope.customerID != undefined) {
            var source = customerService.getPurchasesTableSettings($scope.customerID).source;
            $scope.$apply(function() {
                $scope.customerPurchasesTableSettings = {
                    source: new $.jqx.dataAdapter({
                        dataFields: source.dataFields,
                        dataType: source.dataType,
                        id: source.id,
                        url: source.url
                    }),
                    created: function (args) {
                        var instance = args.instance;
                        instance.updatebounddata();
                    }
                };
            });
        }
    };

    // Customer window
    $scope.addCustomerWindSettings = {
        created: function (args) {
            customerWind = args.instance;
        },
        resizable: false,
        width: "100%", height: "100%",
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

    // Customer notes window
    $scope.CustomerNotesWinSettings = {
        created: function (args) {
            customerNotesWin = args.instance;
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
        height: 25
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

    // --- Customer Control Events
    $('body')
        .on('select', '.customerForm .customer-datalist', function (e) {
        //console.log(e.args.item);
            $('#saveCustomerBtn').prop('disabled', false);
    })
        .on('change', '.customerForm .customer-date', function (e) {
        //console.log(e.args.date);
            $('#saveCustomerBtn').prop('disabled', false);
    })
        .on('change', '.customerForm .customer-radio', function (e) {
            $('#saveCustomerBtn').prop('disabled', false);
    })
        .on('keypress keyup paste change', '.customerForm .customer-textcontrol, .customerForm .customer-number', function (e) {
            $('#saveCustomerBtn').prop('disabled', false);
    })
        .on('focus', '.customerForm .customer-number', function(e) {
            $(this).find('input').select();
        })
    // Customer contacts Events
        .on('select', '.customerContactsForm .customer-datalist', function (e) {
            $('#saveCustomerContactBtn').prop('disabled', false);
    })
        .on('change', '.customerContactsForm .customer-date', function (e) {
            $('#saveCustomerContactBtn').prop('disabled', false);
    })
        .on('change', '.customerForm .customer-radio', function (e) {
            $('#saveCustomerContactBtn').prop('disabled', false);
    })
        .on('keypress keyup paste change', '.customerContactsForm .customer-textcontrol, .customerContactsForm .customer-number', function (e) {
            $('#saveCustomerContactBtn').prop('disabled', false);
    });
    // ---

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
        toggleTabs(false);
        setTimeout(function() {
            $('.customerForm .customer-field[data-control-type=text]:first input').focus();
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
        fillCustomerFieldsWithValues($('.customerForm .customer-field'), row);
        //
        $('#deleteCustomerBtn').show();
        $('#saveCustomerBtn').prop('disabled', true);
        //
        toggleTabs(true);
        setTimeout(function() {
            $('.customerForm .customer-field[data-control-type=text]:first input').focus();
        }, 100);
        var fName = (row.FirstName != null) ? row.FirstName : '';
        var lName = (row.LastName != null) ? row.LastName : '';
        var fullName = fName + ' ' + lName;
        customerWind.setTitle('Edit Customer: ' + row.Unique + ' | Customer: ' + fullName);
        customerWind.open();
        //
        //updateCustomerContactTableData();
        //updateCustomerNotesTableData();
        //updateCustomerPurchasesTableData();
    //};
    });

    /**
     * --- HELPERS TO FILL CONTROLS ON CUSTOMER
     */
    var toggleTabs = function(toShow) {
        var elements = '#customertabContact, #customertabNote, #customertabPurchase';
        if (toShow) {
            $(elements).find('.jqx-tabs-titleContentWrapper').css('margin-top', '0');
            $(elements).show();
        } else {
            $(elements).hide();
        }
    };

    var fillCustomerFieldsWithValues = function(element, row) {
        element.each(function(i, value) {
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
    };

    var resetCustomerForm = function(container) {
        container.each(function(i, value) {
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

    var validationBeforeCustomer = function(formContainer, notifSection) {
        var needValidation = false;

        var openNotification = function(msg, current) {
            if (notifSection == 'contacts') {
                $('#customerContactErrorSettings #notification-content')
                    .html(msg);
                $scope.customerContactErrorSettings.apply('open');
            } else {
                $('#customerNoticeErrorSettings #notification-content')
                    .html(msg);
                $scope.customerNoticeErrorSettings.apply('open');
            }
            current.css({'border-color': '#F00'});
        };
        formContainer.each(function(i, value) {
            var el = $(value);
            var type = el.data('control-type');
            var current;
            if (type == 'text') {
                current = el.find('input.req');
                if (current.length && current.val() == '') {
                    needValidation = true;
                    openNotification(current.attr('placeholder') + ' can not be empty!', current);
                } else {
                    current.css({'border-color': '#CCC'});
                }
            } else if (type == 'number' || type == 'number2Decimal') {
                current = el.find('.customer-number.req');
                if (current.length && current.val() == '') {
                    needValidation = true;
                    openNotification(current.attr('placeholder') + ' can not be empty!', current);
                } else {
                    current.css({'border-color': '#CCC'});
                }
            } else if (type == 'date') {
                current = el.find('.customer-date.req');
                if (current.val() == undefined && current.val() == '') {
                    needValidation = true;
                    openNotification(current.data('placeholder') + ' needs to be a valid date!', current);
                } else {
                    current.css({'border-color': '#CCC'});
                }
            } else if (type == 'datalist') {
                current = el.find('.customer-datalist');
                var listboxSelected = current.jqxListBox('getSelectedItem');
                if (!listboxSelected && current.hasClass('req')) {
                    needValidation = true;
                    openNotification('Select an item on ' + current.data('placeholder'), current);
                } else {
                    current.css({'border-color': '#CCC'});
                }
            }
        });

        return needValidation;
    };

    var gettingCustomerValues = function(formContainer) {
        var data = {};
        formContainer.each(function(i, value) {
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

        return data;
    };

    $scope.saveCustomerAction = function(fromPrompt) {
        var formContainer = $('.customerForm .customer-field');
        if (!validationBeforeCustomer(formContainer)) {
            var data = gettingCustomerValues(formContainer);
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
                            resetCustomerForm(formContainer);
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
            resetCustomerForm($('.customerForm .customer-field'));
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
                resetCustomerForm($('.customerForm .customer-field'));
                $('#customerTabs').jqxTabs('select', 0);
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
    // Notifications settings
    $scope.customerContactSuccessSettings = customerService.setNotificationSettings(1, 'contacts');
    $scope.customerContactErrorSettings = customerService.setNotificationSettings(0, 'contacts');

    $scope.newOrEditCustomerContacts = null;
    $scope.customerContactID = null;

    $scope.openContactWindow = function() {
        $scope.newOrEditCustomerContacts = 'create';
        $('#deleteCustomerContactBtn').hide();
        $('#saveCustomerContactBtn').prop('disabled', false);
        customerContactWin.open();
    };

    $('#customerContactsGrid').on('rowdoubleclick', function(e) {
    //$scope.editCustomerContactWindow = function(e) {
        var row = e.args.row.bounddata;
        $scope.customerContactID = row.Unique;
        $scope.newOrEditCustomerContacts = 'edit';
        //
        fillCustomerFieldsWithValues($('.customerContactsForm .customer-field'), row);
        //
        $('#deleteCustomerContactBtn').show();
        $('#saveCustomerContactBtn').prop('disabled', true);
        //
        setTimeout(function(){
            $('.customerContactsForm .customer-field[data-control-type=text]:first input').focus();
        }, 100);
        //var fullName = (row.FirstName != null) ? row.FirstName: ''  + ' ' + row.LastName;

        customerContactWin.setTitle('Edit Contact: ' + row.Unique + ' | Customer: ' + row.ParentUnique);
        customerContactWin.open();
    //};
    });

    $scope.saveCustomerContactsAction = function(fromPrompt) {
        var formContainer = $('.customerContactsForm .customer-field');
        if (!validationBeforeCustomer(formContainer, 'contacts')) {
            var data = gettingCustomerValues(formContainer);
            data['ParentUnique'] = $scope.customerID;
            //
            var url = ($scope.newOrEditCustomerContacts == 'edit')
                ? 'admin/Customer/updateCustomer/' + $scope.customerContactID
                : 'admin/Customer/createCustomer';
            $.ajax({
                url: SiteRoot + url,
                method: 'post',
                dataType: 'json',
                data: data,
                success: function(data) {
                    if (data.status == 'success') {
                        updateCustomerContactTableData();
                        //
                        var msg;
                        if ($scope.newOrEditCustomerContacts == 'edit') {
                            msg = 'Customer contact updated successfully';
                            //console.info(data.message);
                        } else if ($scope.newOrEditCustomerContacts == 'create') {
                            msg = 'Customer Contact created successfully';
                            $scope.newOrEditCustomerContacts = 'edit';
                            $scope.customerContactID = data.new_id;
                        }
                        //
                        if (fromPrompt) {
                            customerContactWin.close();
                            resetCustomerForm($('.customerContactsForm .customer-field'));
                        } else {
                            $('#saveCustomerContactBtn').prop('disabled', true);
                            $('#customerContactSuccessSettings #notification-content')
                                .html(msg);
                            $scope.customerContactSuccessSettings.apply('open');
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

    $scope.closeCustomerContact = function(option) {
        if (option != undefined) {
            $('#mainBtnCustomerContact').show();
            $('#promptBtnCustomerContact').hide();
            $('#beforeDeleteBtnCustomerContact').hide();
        }
        if (option == 0) {
            $scope.saveCustomerContactsAction(true);
        } else if (option == 1) {
            customerContactWin.close();
        } else if (option == 2) {

        } else {
            if ($('#saveCustomerContactBtn').is(':disabled')) {
                customerContactWin.close();
                resetCustomerForm($('.customerContactsForm .customer-field'));
                $('#customerTabs').jqxTabs('select', 2);
            } else {
                $('#mainBtnCustomerContact').hide();
                $('#promptBtnCustomerContact').show();
                $('#beforeDeleteBtnCustomerContact').hide();
            }
        }
    };

    $scope.deleteCustomerContact = function(option) {
        if (option != undefined) {
            $('#mainBtnCustomerContact').show();
            $('#promptBtnCustomerContact').hide();
            $('#beforeDeleteBtnCustomerContact').hide();
        }
        if (option == 0) {
            $.ajax({
                url: SiteRoot + 'admin/Customer/deleteCustomer/' + $scope.customerContactID,
                method: 'post',
                dataType: 'json',
                success: function(data) {
                    if (data.status == 'success') {
                        updateCustomerContactTableData();
                        $scope.closeCustomerContact();
                    } else if (data.status == 'error') {
                        console.log(data.message);
                    } else {
                        console.error('Error from ajax');
                    }
                }
            });
        } else if (option == 1) {
            customerContactWin.close();
            resetCustomerForm($('.customerContactsForm .customer-field'));
        } else if (option == 2) {

        } else {
            $('#mainBtnCustomerContact').hide();
            $('#promptBtnCustomerContact').hide();
            $('#beforeDeleteBtnCustomerContact').show();
        }
    };

    /**
     * NOTES TAB
     */
    $scope.customerNotesSuccessSettings = customerService.setNotificationSettings(1, 'notes');
    $scope.customerNotesErrorSettings = customerService.setNotificationSettings(0, 'notes');

    $scope.newOrEditCustomerNotes = null;
    $scope.customerNoteID = null;

    $('#customerNote_note').on('keypress keyup paste change', function (e) {
        $('#saveCustomerNoteBtn').prop('disabled', false);
    });

    $scope.openNoteWindow = function() {
        $scope.newOrEditCustomerNotes = 'create';
        resetCustomerNote();
        setTimeout(function() {
            $('#customerNote_note').focus();
        }, 100);
        $('#deleteCustomerNoteBtn').hide();
        $('#saveCustomerNoteBtn').prop('disabled', true);
        customerNotesWin.open();
    };

    $('#customerNotesGrid').on('rowdoubleclick', function(e) {
        var row = e.args.row.bounddata;
        $scope.customerNoteID = row.Unique;
        $scope.newOrEditCustomerNotes = 'edit';
        setTimeout(function() {
            $('#customerNote_note').focus();
        }, 100);

        $('.customerNotesForm #customerNote_note').val(row.Note);
        $('#deleteCustomerNoteBtn').show();
        $('#saveCustomerNoteBtn').prop('disabled', true);
        //
        customerNotesWin.setTitle('Edit Note: ' + row.Unique + ' | Customer: ' + row.ReferenceUnique);
        customerNotesWin.open();
    });

    var resetCustomerNote = function() {
        $('.customerNotesForm #customerNote_note').val('');
    };

    $scope.saveCustomerNotes = function(fromPrompt) {
        var el = $('#customerNote_note');
        if (el.val() == '') {
                //needValidation = true;
                $('#customerNotesErrorSettings #notification-content')
                    .html(el.attr('placeholder') + ' can not be empty!');
                $scope.customerNotesErrorSettings.apply('open');
                el.css({'border-color': '#F00'});
        } else {
            el.css({'border-color': '#CCC'});
            var data = {
                'Note': $('#customerNote_note').val(),
                'ReferenceUnique': $scope.customerID,
                'Type': 'customer'
            };
            //
            var url = ($scope.newOrEditCustomerNotes == 'edit')
                ? 'admin/Customer/updateCustomerNote/' + $scope.customerNoteID
                : 'admin/Customer/createCustomerNote';
            $.ajax({
                url: SiteRoot + url,
                method: 'post',
                dataType: 'json',
                data: data,
                success: function(data) {
                    if (data.status == 'success') {
                        updateCustomerNotesTableData();
                        //
                        var msg;
                        if ($scope.newOrEditCustomerNotes == 'edit') {
                            msg = 'Note updated successfully';
                        } else if ($scope.newOrEditCustomerNotes == 'create') {
                            msg = 'Note created successfully';
                            $scope.newOrEditCustomerNotes = 'edit';
                            $scope.customerNoteID = data.new_id;
                        }
                        //
                        if (fromPrompt) {
                            customerNotesWin.close();
                            $('#customerNote_note').val('');
                        } else {
                            $('#saveCustomerNoteBtn').prop('disabled', true);
                            $('#customerNotesSuccessSettings #notification-content')
                                .html(msg);
                            $scope.customerNotesSuccessSettings.apply('open');
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

    $scope.closeCustomerNotes = function(option) {
        if (option != undefined) {
            $('#mainBtnCustomerNote').show();
            $('#promptToCloseCustomerNote').hide();
            $('#promptToDeleteCustomerNote').hide();
        }
        if (option == 0) {
            $scope.saveCustomerNotes(true);
        } else if (option == 1) {
            customerNotesWin.close();
        } else if (option == 2) {

        } else {
            if ($('#saveCustomerNoteBtn').is(':disabled')) {
                customerNotesWin.close();
                resetCustomerNote();
                $('#customerTabs').jqxTabs('select', 3);
            } else {
                $('#mainBtnCustomerNote').hide();
                $('#promptToCloseCustomerNote').show();
                $('#promptToDeleteCustomerNote').hide();
            }
        }
    };

    $scope.deleteCustomerContact = function(option) {
        if (option != undefined) {
            $('#mainBtnCustomerNote').show();
            $('#promptToCloseCustomerNote').hide();
            $('#promptToDeleteCustomerNote').hide();
        }
        if (option == 0) {
            $.ajax({
                url: SiteRoot + 'admin/Customer/deleteCustomerNote/' + $scope.customerNoteID,
                method: 'post',
                dataType: 'json',
                success: function(data) {
                    if (data.status == 'success') {
                        updateCustomerNotesTableData();
                        $scope.closeCustomerNotes();
                    } else if (data.status == 'error') {
                        console.log(data.message);
                    } else {
                        console.error('Error from ajax');
                    }
                }
            });
        } else if (option == 1) {
            customerNotesWin.close();
            resetCustomerNote();
        } else if (option == 2) {

        } else {
            $('#mainBtnCustomerNote').hide();
            $('#promptToCloseCustomerNote').hide();
            $('#promptToDeleteCustomerNote').show();
        }
    };

});