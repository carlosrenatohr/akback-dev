/**
 * Created by carlosrenato on 06-17-16.
 */
var demoApp = angular.module("demoApp", ['jqwidgets', 'jqwidgets-amd']);

demoApp.controller("customerController", function ($scope, $http, customerService) {
    $scope.articTheme = 'darkblue';
    /**
     * TABS
     * @param e
     */
    var customerIsSaved = false;
    var tabSelectedBeforeSave = -1;
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
            if(tabclick == 5) {
                updateCustomerPurchasesTableData();
            }
            // Visits tab
            if(tabclick == 6) {
                updateCustomerVisitsTableData();
            }
        // Behavior of create form
        } else if ($scope.newOrEditCustomerAction == 'create') {
            if(tabclick == 2 && !customerIsSaved) {
                e.cancel = true;
                $('#saveCustomerBtn').prop('disabled', false);
                $scope.closeCustomerAction(-1, tabclick);
                $('#promptToCloseMsg').html('To add contacts, you must first save this customer.');
            }
        }
    };

    //customerService.getLocationName(1)
    //    .then(function(response) {
    //         $('#mainCustomerTabs').jqxTabs('setTitleAt', 1, response.data);
    //    });
    //
    //customerService.getLocationName(2)
    //    .then(function(response) {
    //         $('#mainCustomerTabs').jqxTabs('setTitleAt' , 2, response.data);
    //    });

    //$scope.customerTableSettings = customerService.getTableSettings();
    $scope.customerCheckIn1GridleSettings = customerService.getCheckin1GridSettings();
    $scope.customerCheckIn2GridSettings = customerService.getCheckin2GridSettings();
    $scope.customerCheckInCompleteGridSettings = customerService.getCheckinCompleteGridSettings();
    customerService.getCustomerGridAttrs()
        .then(function(response) {
            $scope.customerTableSettings = customerService.getTableSettings();
            setNewSettingsOnTable(response, $scope.customerTableSettings, '#gridCustomer', '#row00gridCustomer');
            setNewSettingsOnTable(response, $scope.customerCheckIn1GridleSettings, '#customerCheckIn1', '#row00customerCheckIn1');
            setNewSettingsOnTable(response, $scope.customerCheckIn2GridSettings, '#customerCheckIn2', '#row00customerCheckIn2');
            setNewSettingsOnTable(response, $scope.customerCheckInCompleteGridSettings, '#customerCheckInComplete', '#row00customerCheckInComplete');
        });

    // @helper: new settings on customer grids rendering
    var isBindingComplete = [];
    function setNewSettingsOnTable(response, gridSettings, gridID, rowParentElement) {
        //if (gridSettings == '#gridCustomer')
        //    $scope.customerTableSettings = customerService.getTableSettings();

        var fieldsNames = [], labelNames = [], sizes = [], defaultValues = [], sortValues = [];
        for(var i in response.data) {
            fieldsNames.push(response.data[i].Field);
            labelNames.push(response.data[i].Label);
            sizes.push(response.data[i].Size);
            defaultValues.push(response.data[i].Default);
            sortValues.push(response.data[i].Sort);
        }
        var cols = gridSettings.columns;
        $.each(cols, function(i, el) {
            var idx = $.inArray(el.dataField, fieldsNames);
            if (idx < 0) {
                el['hidden'] = true;
            } else {
                el['hidden'] = false;
                el['text'] = labelNames[idx];
                el['width'] = sizes[idx] + '%';
                el['classname'] = 'headercolumncustomer-' + fieldsNames[idx];
                //el['rendered'] = function(columnheader,second, third, fif) {};
                //$('#gridCustomer').jqxGrid('setcolumnindex', el.dataField, sortValues[idx]);
                //$('#gridCustomer').jqxGrid('setcolumnproperty', el.dataField, 'text', el.Label);
                //$('#gridCustomer').jqxGrid('showcolumn', el.dataField);
            }
            // Check in tabs
            if (gridID == '#customerCheckIn1' || gridID == '#customerCheckIn2') {
                if (el.dataField == 'CheckInDate') {
                    el['hidden'] = false;
                    el['width'] = '10%';
                }
                if(el.dataField == 'VisitUnique') {
                    el['hidden'] = false;
                    el['width'] = '5%';
                }
            }
            // Check out tab
            if (gridID == '#customerCheckInComplete') {
                if (el.dataField == 'CheckOutDate' || el.dataField == 'LocationName') {
                    el['hidden'] = false;
                    el['width'] = '7%';
                }
                if(el.dataField == 'VisitUnique') {
                    el['hidden'] = false;
                    el['width'] = '5%';
                }
            }
        });
        // BINDING COMPLETE
        if (gridID == '#gridCustomer') {
            isBindingComplete[gridID] = true;
            $(gridID).on('bindingcomplete', function(e) {
                //gridSettings.bindingcomplete = function(e) {
                if (isBindingComplete[gridID]) {

                    $.each(cols, function(i, el) {
                        var idx = $.inArray(el.dataField, fieldsNames);
                        if (idx >= 0) {
                            //gridSettings.apply('setcolumnindex', el.dataField, sortValues[idx]);
                            $('#gridCustomer').jqxGrid('setcolumnindex', el.dataField, sortValues[idx]);
                        }
                    });
                    var defaultSelectInput = defaultValues.indexOf(1);

                    // bindingcomplete only once
                    //$(gridID).jqxGrid('applyfilters');
                    //$(gridID).jqxGrid('applyfilters');
                    //gridSettings.apply('applyfilters');
                    // DEFAULT selecting input
                    var columnHeaderSelected = $(gridID + ' .jqx-grid-column-header.headercolumncustomer-' + fieldsNames[defaultSelectInput]).index();
                    $(rowParentElement + ' .jqx-grid-cell-pinned').eq(columnHeaderSelected).find('input[type="textarea"]').focus();
                    // only ONCE
                    isBindingComplete[gridID] = false;
                } else {
                    $('#gridCustomer').jqxGrid({rowdetails: true});
                }
            });
        }

        gridSettings.rendered = function() {}
    }

    $scope.customerContactTableSettings = customerService.getContactsTableSettings();
    $scope.customerNotesTableSettings = customerService.getNotesTableSettings();
    $scope.customerPurchasesTableSettings = customerService.getPurchasesTableSettings();
    $scope.customerVisitsTabSettings = customerService.getVisitsTableTabSettings();

    var updateCustomerTableData = function(location, nofilters) {
        var grid = '#gridCustomer';
        // checked in, location 1
        if (location == 1) {
            grid = '#customerCheckIn1';
        // checked in, location 2
        } else if(location == 2) {
            grid = '#customerCheckIn2';
        // checked out
        } else if(location == 3) {
            grid = '#customerCheckInComplete';
        } else {
            grid = '#gridCustomer';
        }
        if (nofilters === 'undefined')
            $(grid).jqxGrid('applyfilters');
        $(grid).jqxGrid('updatebounddata');
    };

    var updateCustomerContactTableData = function() {
        if ($scope.customerID != undefined) {
            var tableSettings = customerService.getContactsTableSettings($scope.customerID);
            $('#customerContactsGrid').jqxGrid({
                source: tableSettings.source
            });
        }
    };

    var updateCustomerNotesTableData = function() {
        if ($scope.customerID != undefined) {
            var tableSettings = customerService.getNotesTableSettings($scope.customerID);
            $('#customerNotesGrid').jqxGrid({
                source: tableSettings.source
            });
        }
    };

    var updateCustomerPurchasesTableData = function() {
        if ($scope.customerID != undefined) {
            var tablesettings = customerService.getPurchasesTableSettings($scope.customerID);
            $('#customerPurchasesGrid').jqxGrid({
                source: tablesettings.source
            });
        }
    };

    var updateCustomerVisitsTableData = function() {
        if ($scope.customerID != undefined) {
            var tablesettings = customerService.getVisitsTableTabSettings($scope.customerID);
            $('#customerVisitsTabGrid').jqxGrid({
                source: tablesettings.source
            });
        }
    };

    var customerWind, customerContactWin, customerNotesWin, checkoutCustomerWin;
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
        width: "35%", height: "50%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    /**
     * CHECKOUT FORM ACTIONS
     * @type {{created: $scope.checkoutFormWindowSettings.created, resizable: boolean, width: string, height: string, autoOpen: boolean, theme: string, isModal: boolean, showCloseButton: boolean}}
     */
    $scope.checkoutFormWindowSettings = {
        created: function (args) {
            checkoutCustomerWin = args.instance;
        },
        resizable: false,
        width: "52%", height: "65%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    // @helper: Set customers as checked in
    $('body').on('click', '.checkInBtn', function(e) {
        e.stopPropagation();
        var data = {
            'CustomerUnique': $(this).data('unique'),
            'LocationUnique': $(this).data('location'),
            'FirstName': $(this).data('fname'),
            'LastName': $(this).data('lname')
        };
        $.ajax({
            url: SiteRoot + 'admin/CustomerCheckin/setCustomerAsCheckin',
            method: 'POST',
            data: data,
            dataType: 'JSON',
            success: function(data) {
                if (data.status == 'success') {
                    updateCustomerTableData(0, true);
                    //updateCustomerTableData($(this).data('location'),  true);
                    updateCustomerTableData(1,  true);
                    updateCustomerTableData(2,  true);
                } else if(data.status == 'error') {
                    console.info(data.message);
                } else {
                    console.error(data);
                }
            }
        })
    });

    $scope.customervisitID = null;
    $scope.checkinType = 1;
    var checkoutControlChanged = false;
    $('#QuantityControl, #NoteControl').on('keypress keyup paste', function(e) { // change
        checkoutControlChanged = true;
    });
    $('body').on('change select', '#locationSelect, #locationSelect_jqxDropDownList', function(e) {
        checkoutControlChanged = true;
    });

    $('#customerCheckIn1, #customerCheckIn2, #customerCheckInComplete').on('rowdoubleclick', function(e) {
        var row = e.args.row.bounddata;
        $scope.customervisitID = row.VisitUnique;
        if($(e.target).attr('id') == 'customerCheckIn1')
            $scope.checkinType = 1;
        else if($(e.target).attr('id') == 'customerCheckIn2')
            $scope.checkinType = 2;
        else if($(e.target).attr('id') == 'customerCheckInComplete')
            $scope.checkinType = 3;
        //console.log(row);
        var fullname = row.fname + ' ' + row.lname;
        $('#checkOutForm #customerNameP').html(fullname);
        $('#checkOutForm #checkInP').html(row.CheckInUser + ' at ' + row._CheckInDate);
        //
        if (row.CheckOutBy !== null) {
            $('#checkOutForm #checkOutP').html(row.CheckOutUser + ' at ' + row._CheckOutDate);
        }
        if (row.LocationUnique !== null) {
            $('#checkOutForm #LocationP').html('ID: ' + row.LocationUnique + ' | ' + row.LocationName);
        }
        var statusCombo = $('#locationSelect').jqxDropDownList('getItemByValue', row.LocationUnique);
        $('#locationSelect').jqxDropDownList({'selectedIndex': statusCombo.index});
        //$('#locationSelect').jqxComboBox({'selectedIndex': statusCombo.index});
        $('#checkOutForm #QuantityControl').val(row.Quantity);
        setTimeout(function(){
            $('#checkOutForm #QuantityControl').focus();
        }, 100);
        $('#checkOutForm #NoteControl').val(row.Note);
        //
        if(row.StatusCheckIn == 2)
            $('#mainButtonsCheckoutForm #checkoutCompleteBtn').hide();
        else
            $('#mainButtonsCheckoutForm #checkoutCompleteBtn').show();
        checkoutControlChanged = false;
        checkoutCustomerWin.setTitle('Check Out Form | Customer ID: ' + row.Unique + ' | ' + fullname);
        checkoutCustomerWin.open();
    });

    $scope.checkoutCloseBtn = function(option, status, type) {
        if (option != undefined) {
            $('#mainButtonsCheckoutForm').show();
            $('#promptToCloseCheckoutForm').hide();
        }
        if (option == 0) {
            $scope.updateCheckInCustomer(status, type);
        } else if (option == 1) {
            checkoutCustomerWin.close();
            $('#mainButtonsCheckoutForm').show();
            $('#promptToCloseCheckoutForm').hide();
        } else if (option == 2) {
        } else {
            $scope.selectedCheckinStatus = status;
            if (status == 0)
                $('#promptToCloseCheckoutForm p').html('Do you really want to delete it?');
            else if(status == 2)
                $('#promptToCloseCheckoutForm p').html('Do you want to check it out?');
            else {
                if(!checkoutControlChanged) {
                    checkoutControlChanged = false;
                    checkoutCustomerWin.close();
                    return;
                } else {
                    $('#promptToCloseCheckoutForm p').html('Do you want to save your changes?');
                }
            }
            $('#mainButtonsCheckoutForm').hide();
            $('#promptToCloseCheckoutForm').show();
        }
    };

    $scope.updateCheckInCustomer = function(status, type) {
        var data = {};
        var location = $('#locationSelect').jqxDropDownList('getSelectedItem').value;
        if(type == 1 || type == 2 || type == 3) {
            if(status == 1 || status == 2){
                data = {
                    'LocationUnique': location,
                    'Quantity': $('#checkOutForm #QuantityControl').val(),
                    'Note': $('#checkOutForm #NoteControl').val()
                };
            }
            if(status == 0 || status == 2)
                data['Status'] = status;
        }
        $.ajax({
            'method': 'POST',
            'url': SiteRoot + 'admin/CustomerCheckin/updateStatusCheckin/' + $scope.customervisitID,
            'data': data,
            'dataType': 'json',
            'success': function(response) {
                if (response.status == 'success') {
                    checkoutCustomerWin.close();
                    checkoutControlChanged = false;
                    updateCustomerTableData(location);
                    if(location == 1)
                        updateCustomerTableData(2, true);
                    else
                        updateCustomerTableData(1, true);
                    updateCustomerTableData(3, true);
                } else if (response.status == 'error') {
                    console.log(response.message);
                } else {
                    console.log('There was an error!');
                }
            }
        });
    };

    // Notifications settings
    $scope.customerNoticeSuccessSettings = customerService.setNotificationSettings(1);
    $scope.customerNoticeErrorSettings = customerService.setNotificationSettings(0);

    // Getting all attributes
    $scope.gettingRowsCustomer = function(tabSent) {
        var rows = [];
        for(var i in $scope.customerControls) {
            var row = $scope.customerControls[i].Row;
            if ($scope.customerControls[i].Tab == tabSent) {
                if (rows.indexOf(row) < 0) {
                    rows.push(row);
                }
            }
        }
        return rows;
    };

    customerService.getCustomerAttributes()
        .then(function (response) {
            $scope.customerControls = response.data;
            }, function () {}
            // at end of request
        ).then(function () {});

    $scope.gettingRowsCustomerContact = function(tabSent) {
        var rows = [];
        for(var i in $scope.customerContactsControls) {
            var row = $scope.customerContactsControls[i].Row;
            if ($scope.customerContactsControls[i].Tab == tabSent) {
                if (rows.indexOf(row) < 0) {
                    rows.push(row);
                }
            }
        }
        return rows;
    };

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
        digits: 6,
        spinButtons: true,
        groupSize: 2,
        groupSeparator: ',',
        width: 180,
        height: 25
    };

    $scope.numberDecimalSettings = {
        inputMode: 'simple',
        decimalDigits: 2,
        digits: 6,
        spinButtons: true,
        groupSize: 2,
        groupSeparator: ',',
        width: 180,
        height: 25,
        min: ''
    };

    $scope.dateSettings = {
        //selectionMode: 'range'
        //min: new Date(2016, 5, 10),
        max: new Date(),
        formatString: 'd',
        width: '180px', height: '25px'
    };

    $scope.dropdownlistSettings = {
        width: '180px', height: '30px',
        created: function(args) {
            var el = $(args.element);
            //console.log(el.attr('id'));
            setDropdownlistSettings(el);
        }
    };

    // Helper to reset jqxDropDownLists
    function setDropdownlistSettings(el) {
        var indexSelected = -1;
        //$.each(el.jqxDropDownList('getItems'), function(i, val){
        $.each(el.jqxComboBox('getItems'), function(i, val){
            var option = $(val.originalItem.originalItem);
            //console.log(option.html());
            var isDefault = option.data('defa');
            if (isDefault == 1)
                indexSelected = val.index;
        });
        //el.jqxDropDownList({
        el.jqxComboBox({
            selectedIndex: indexSelected,
            placeHolder: 'Select ' + el.data('placeholder').toLowerCase() + '..'
        });
    }

    // Helper to reset jqxRadioButtons
    function setRadioButtonsSettings(el) {
        //console.log(el.data('field'));
        el.find('.customer_radio').each(function(i, val){
            //console.log($(val).find('span.text-rb').html());
            var isDefault = $(val).data('defa');
            $(val).jqxRadioButton({ checked: (isDefault == 1) });
        });
    }

    // --- Customer Control Events
    $('body')
        .on('select', '.customerForm .customer-datalist', function (e) {
            $('#saveCustomerBtn').prop('disabled', false);
    })
        .on('change', '.customerForm .customer-date', function (e) {
        //console.log(e.args.date);
            $('#saveCustomerBtn').prop('disabled', false);
    })
        .on('change', '.customerForm .customer_radio', function (e) {
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
        .on('change', '.customerForm .customer_radio', function (e) {
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
        customerIsSaved = false;
        // Static fields
        $('#customer_VisitDays').val(7);
        $("#customer_AccountStatus").jqxDropDownList('val', "Active");
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
        var parent = $(e.args.originalEvent.target).parents('.jqx-grid')[0];
        if ($(parent).attr('id') != 'gridCustomer')
            return;
        var row = e.args.row.bounddata;
        //
        $scope.customerID = row.Unique;
        $scope.customerNameSelected = row.FirstName + ' ' + row.LastName;
        $scope.newOrEditCustomerAction = 'edit';
        //
        fillCustomerFieldsWithValues($('.customerForm .customer-field'), row);
        $('#customer_VisitDays').val(
            (row['VisitDays'] != null)
                ? row['VisitDays']
                : 0
        );
        $("#customer_AccountStatus").jqxDropDownList('val',
            (row['AccountStatus'] != null)
                ? row['AccountStatus']
                : "Active"
        );
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
        var elements = '#customertabNote, #customertabPurchase, #customertabVisits'; //#customertabContact,
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
                el.find('.customer_radio').each(function(i, val) {
                    $(val).jqxRadioButton({ checked:false });
                });
                var radio = el.find('.customer_radio[data-val=' + row[field]+ ']');
                if (radio.length)
                    radio.jqxRadioButton({ checked:true });
            } else if (type == 'datalist') {
                //var itemByValue = el.find('.customer-datalist').jqxListBox('getItemByValue', row[field]);
                //el.find('.customer-datalist').jqxListBox({'selectedIndex': (itemByValue) ? itemByValue.index : -1});
                var itemByValue = el.find('.customer-datalist').jqxComboBox('getItemByValue', row[field]);
                el.find('.customer-datalist').jqxComboBox({'selectedIndex': (itemByValue) ? itemByValue.index : -1});
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
                var radio = el.find('.customer_radio:first-child');
                setRadioButtonsSettings(el);
                //if (radio.length)
                //    radio.jqxRadioButton({ checked:true });
            } else if (type == 'datalist') {
                //el.find('.customer-datalist').jqxListBox({'selectedIndex': 0});
                var el2 = el.find('.customer-datalist');
                setDropdownlistSettings(el2);
                el2.css({'border-color': '#CCC'});
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
                //var listboxSelected = current.jqxListBox('getSelectedItem');
                var listboxSelected = current.jqxComboBox('getSelectedItem');
                if (!listboxSelected && current.hasClass('req')) {
                    needValidation = true;
                    openNotification('Select an item on ' + current.data('placeholder'), current);
                } else {
                    current.css({'border-color': '#CCC'});
                }
            } else if (type == 'radio') {
                if (el.hasClass('req')) {
                    var hasValue = false;
                    if ($(el).find('.customer_radio[aria-checked="true"]').length > 0) {
                        hasValue = true;
                    }
                    if (!hasValue) {
                        needValidation = true;
                        openNotification('"' + el.parent().find('.labelContent').html() + '" checkbox required!' , el);
                        el.css({border: 'solid 1px red', padding: '2px'});
                    } else {
                        el.css({border: 'solid 1px #FFF'});
                    }
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
                //inputValue = el.find('.customer-datalist').jqxListBox('getSelectedItem').value;
                var listbox = el.find('.customer-datalist').jqxComboBox('getSelectedItem');
                if(!listbox) {
                    inputValue = null;
                } else {
                    inputValue = listbox.value;
                }

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
            var dataRequest = gettingCustomerValues(formContainer);
            var url = ($scope.newOrEditCustomerAction == 'edit')
                        ? 'admin/Customer/updateCustomer/' + $scope.customerID
                        : 'admin/Customer/createCustomer';
            // Extra static fields
            dataRequest['VisitDays'] = $('#customer_VisitDays').val();
            dataRequest['AccountStatus'] = $.trim($('#customer_AccountStatus').val());
            $.ajax({
                url: SiteRoot + url,
                method: 'post',
                dataType: 'json',
                data: dataRequest,
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
                            var fName = (dataRequest.FirstName != null) ? dataRequest.FirstName : '';
                            var lName = (dataRequest.LastName != null) ? dataRequest.LastName : '';
                            var fullName = fName + ' ' + lName;
                            customerWind.setTitle('Edit Customer: ' + data.new_id + ' | Customer: ' + fullName);
                        }
                        //
                        if (tabSelectedBeforeSave > -1) {
                            $('#customerTabs').jqxTabs({selectedItem: tabSelectedBeforeSave});
                            customerIsSaved = true;
                            tabSelectedBeforeSave = -1;
                            $('#promptToCloseMsg').html('Do you want to save your changes?');
                        } else {
                            if (fromPrompt) {
                                customerWind.close();
                                resetCustomerForm(formContainer);
                                $('#customerTabs').jqxTabs({selectedItem: 0});
                            } else {
                                $('#customerNoticeSuccessSettings #notification-content')
                                    .html(msg);
                                $scope.customerNoticeSuccessSettings.apply('open');
                            }

                            $('#saveCustomerBtn').prop('disabled', true);
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

    $scope.closeCustomerAction = function(option, tab) {
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
                //resetCustomerForm($('.customerForm .customer-field'));
                //$('#customerTabs').jqxTabs('select', 0);
            } else {
                if (tab != undefined) {
                    tabSelectedBeforeSave = tab;
                } else {
                    tabSelectedBeforeSave = -1;
                    $('#promptToCloseMsg').html('Do you want to save your changes?');
                }
                $('#mainButtonsCustomerForm').hide();
                $('#promptToCloseCustomerForm').show();
                $('#promptToDeleteCustomerForm').hide();
            }
        }
    };

    $scope.closingCustomerWind = function(e) {
        resetCustomerForm($('.customerForm .customer-field'));
        $('#customerTabs').jqxTabs({selectedItem: 0});
        $('#saveCustomerBtn').prop('disabled', true);
        $scope.customerNoticeSuccessSettings.apply('closeAll');
        $scope.customerNoticeErrorSettings.apply('closeAll');
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
        $('#saveCustomerContactBtn').prop('disabled', true);
        setTimeout(function(){
            $('.customerContactsForm .defaultVal').focus();
        }, 100);
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
        setTimeout(function(){
            $('.customerContactsForm .defaultVal').focus();
        }, 100);
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
        }, 150);
        //
        $('#userNotesDataContent').hide();
        $('#deleteCustomerNoteBtn').hide();
        $('#saveCustomerNoteBtn').prop('disabled', true);
        customerNotesWin.setTitle("New Note | Customer ID: " + $scope.customerID +" | Name: " + $scope.customerNameSelected);
        customerNotesWin.open();
    };

    $('#customerNotesGrid').on('rowdoubleclick', function(e) {
        var row = e.args.row.bounddata;
        $scope.customerNoteID = row.Unique;
        $scope.newOrEditCustomerNotes = 'edit';
        setTimeout(function() {
            $('#customerNote_note').focus();
        }, 150);
        //
        $('#userNotesDataContent').show();
        $('.customerNotesForm #customerNote_note').val(row.Note);
        $('.customerNotesForm #createdBy').html(row.CreatedUser);
        $('.customerNotesForm #createdAt').html(row.Created); // .format('M jS, Y \\i\\s')
        if (row.Updated != null && row.UpdatedUser != null) {
            $('.customerNotesForm #UpdatedSection').show();
            $('.customerNotesForm #updatedBy').html(row.UpdatedUser);
            $('.customerNotesForm #updatedAt').html(row.Updated);
        }
        $('#deleteCustomerNoteBtn').show();
        $('#saveCustomerNoteBtn').prop('disabled', true);
        //
        customerNotesWin.setTitle('Edit Note: ' + row.Unique + ' | Customer ID: ' + row.ReferenceUnique + ' | Name: ' + $scope.customerNameSelected);
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