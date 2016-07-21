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
    $scope.customerTableSettings = customerService.getTableSettings();
    customerService.getCustomerGridAttrs()
        .then(function(response) {
            var fieldsNames = [], labelNames = [], sizes = [], defaultValues = [], sortValues = [];
            for(var i in response.data) {
                fieldsNames.push(response.data[i].Field);
                labelNames.push(response.data[i].Label);
                sizes.push(response.data[i].Size);
                defaultValues.push(response.data[i].Default);
                sortValues.push(response.data[i].Sort);
            }
            var cols = $scope.customerTableSettings.columns;
            $.each(cols, function(i, el) {
                var idx = $.inArray(el.dataField, fieldsNames);
                if (idx < 0) {
                    el['hidden'] = true;
                } else {
                    el['hidden'] = false;
                    el['text'] = labelNames[idx];
                    el['width'] = sizes[idx] + '%';
                    //$('#gridCustomer').jqxGrid('setcolumnindex', el.dataField, sortValues[idx]);
                    //$('#gridCustomer').jqxGrid('setcolumnproperty', el.dataField, 'text', el.Label);
                    //$('#gridCustomer').jqxGrid('showcolumn', el.dataField);
                }
            });
            //
            var isBindingComplete = true;
            $scope.customerTableSettings.bindingcomplete = function(e) {
                $.each(cols, function(i, el) {
                    var idx = $.inArray(el.dataField, fieldsNames);
                    if (idx >= 0) {
                        $scope.customerTableSettings.apply('setcolumnindex', el.dataField, sortValues[idx]);
                        //$('#gridCustomer').jqxGrid('setcolumnindex', el.dataField, sortValues[idx]);
                    }
                });
                //
                var filterInputs = [];
                var rowFilterInputs = $('#row00gridCustomer .jqx-grid-cell-pinned input[type="textarea"]');
                var defaultSelectInput = defaultValues.indexOf(1);
                rowFilterInputs.each(function (i, el) {
                    if ($(el).css('width') != '0px') {
                        filterInputs.push(el);
                    }
                });

                if (isBindingComplete) {
                    $('#gridCustomer').jqxGrid('applyfilters');
                    $scope.customerTableSettings.apply('applyfilters');
                    isBindingComplete = false;
                }
                $(filterInputs[defaultSelectInput]).focus();
                //console.log('binding complete');
            };

            $scope.customerTableSettings.rendered = function() {}
        });
    $scope.customerContactTableSettings = customerService.getContactsTableSettings();
    $scope.customerNotesTableSettings = customerService.getNotesTableSettings();
    $scope.customerPurchasesTableSettings = customerService.getPurchasesTableSettings();

    var updatingCustomerGrid = false;
    var updateCustomerTableData = function() {
        //var source = customerService.getTableSettings().source;
        var source = customerService.sourceCustomerGrid;
        //$scope.$apply(function() {
        //    $scope.customerTableSettings = {
        //        source: new $.jqx.dataAdapter({
        //            dataFields: source.dataFields,
        //            dataType: source.dataType,
        //            id: source.id,
        //            url: source.url,
        //            root: 'Rows',
        //            beforeprocessing: function(data) {
        //                source.totalrecords = data.TotalRows;
        //            }
        //        }),
        //        //created: function (args) {
        //        //    var instance = args.instance;
        //        //    instance.updateBoundData();
        //        //}
        //    };
        //});
        var newSource = {
            dataFields: source.dataFields,
            dataType: source.dataType,
            //id: source.id,
            url: source.url,
            root: 'Rows',
            beforeprocessing: function(data) {
                newSource.totalrecords = data.TotalRows ;
            },
            filter: function () {
                $("#gridCustomer").jqxGrid('updatebounddata');
            },
            sort: function () {
                $("#gridCustomer").jqxGrid('updatebounddata');
            }
        };

        $('#gridCustomer').jqxGrid({
            source: new $.jqx.dataAdapter(newSource),
        });
        updatingCustomerGrid = true;
    };

    //$('#gridCustomer').on('bindingcomplete', function(e) {
    //    if (updatingCustomerGrid) {
    //        //$('#gridCustomer').jqxGrid('updatebounddata');
    //        updatingCustomerGrid = false;
    //    }
    //    //$('#gridCustomer').jqxGrid('refresh');
    //    //$('#gridCustomer').jqxGrid('refreshdata');
    //    //$('#gridCustomer').jqxGrid('refreshfilterrow');
    //    ////$('#gridCustomer').jqxGrid('gotopage', 1);
    //});

    var updateCustomerContactTableData = function() {
        if ($scope.customerID != undefined) {
            var tableSettings = customerService.getContactsTableSettings($scope.customerID);
            $scope.$apply(function() {
                $scope.customerContactTableSettings = {
                    source: tableSettings.source,
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
            var tableSettings = customerService.getNotesTableSettings($scope.customerID);
            $scope.$apply(function() {
                $scope.customerNotesTableSettings = {
                    source: tableSettings.source,
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
            var tablesettings = customerService.getPurchasesTableSettings($scope.customerID);
            $scope.$apply(function() {
                $scope.customerPurchasesTableSettings = {
                    source: tablesettings.source,
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
        width: "35%", height: "50%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
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
        digits: 3,
        spinButtons: true,
        width: 180,
        height: 25
    };

    $scope.numberDecimalSettings = {
        inputMode: 'simple',
        decimalDigits: 2,
        digits: 3,
        spinButtons: true,
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
        $.each(el.jqxDropDownList('getItems'), function(i, val){
            var option = $(val.originalItem.originalItem);
            //console.log(option.html());
            var isDefault = option.data('defa');
            if (isDefault == 1)
                indexSelected = val.index;
        });
        el.jqxDropDownList({
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
                el.find('.customer_radio').each(function(i, val) {
                    $(val).jqxRadioButton({ checked:false });
                });
                var radio = el.find('.customer_radio[data-val=' + row[field]+ ']');
                if (radio.length)
                    radio.jqxRadioButton({ checked:true });
            } else if (type == 'datalist') {
                //var itemByValue = el.find('.customer-datalist').jqxListBox('getItemByValue', row[field]);
                //el.find('.customer-datalist').jqxListBox({'selectedIndex': (itemByValue) ? itemByValue.index : -1});
                var itemByValue = el.find('.customer-datalist').jqxDropDownList('getItemByValue', row[field]);
                el.find('.customer-datalist').jqxDropDownList({'selectedIndex': (itemByValue) ? itemByValue.index : -1});
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
                var listboxSelected = current.jqxDropDownList('getSelectedItem');
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
                //inputValue = el.find('.customer-datalist').jqxListBox('getSelectedItem').value;
                inputValue = el.find('.customer-datalist').jqxDropDownList('getSelectedItem').value;
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