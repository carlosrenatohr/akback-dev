/**
 * Created by carlosrenato on 04-25-16.
 */

var demoApp = angular.module("demoApp", ['jqwidgets']);
/**
 * User controller
 */
demoApp.controller("userController", function($scope, $http) {

    $scope.newOrEditSelected = null;
    // Tabs config
    $scope.thetabs = 'darkblue';
    $scope.thetabsadd = 'darkblue';

    // User Tabs settings
    $scope.tabsSettings = {
        created: function (args) {
            tabsControl = args.instance
        },
        selectedItem: 0
    };

    // User datatable settings
    $scope.userTableSettings = {
        source: {
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'int'},
                {name: 'UserName', type: 'string'},
                {name: 'FirstName', type: 'string'},
                {name: 'LastName', type: 'string'},
                //{name: 'Code', type: 'string'},
                //{name: 'Password', type: 'string'},
                {name: 'Address1', type: 'string'},
                {name: 'Address2', type: 'string'},
                {name: 'City', type: 'string'},
                {name: 'State', type: 'string'},
                {name: 'Zip', type: 'string'},
                {name: 'Country', type: 'string'},
                {name: 'PrimaryPosition', type: 'string'},
                {name: 'PrimaryPositionName', type: 'string'},
                {name: 'Phone1', type: 'string'},
                {name: 'Phone2', type: 'string'},
                {name: 'Email', type: 'string'},
                {name: 'Note', type: 'string'}
            ],
            id: 'Unique',
            url: SiteRoot + 'admin/user/load_users'
        },
        columns: [
            {text: 'ID', dataField: 'Unique', type: 'int'},
            {text: 'User Name', dataField: 'UserName', type: 'string'},
            {text: 'First Name', dataField: 'FirstName', type: 'string'},
            {text: 'Last Name', dataField: 'LastName', type: 'string'},
            {text: 'Primary Position', dataField: 'PrimaryPositionName', type: 'string'},
            {text: 'Primary Position id', dataField: 'PrimaryPosition', type: 'string', hidden: true},
            {text: 'Address 1', dataField: 'Address1', type: 'string', hidden: true},
            {text: 'Address 2', dataField: 'Address2', type: 'string', hidden: true},
            {text: 'City', dataField: 'City', type: 'string', hidden: true},
            {text: 'State', dataField: 'State', type: 'string', hidden: true},
            {text: 'Zip', dataField: 'Zip', type: 'string', hidden: true},
            {text: 'Country', dataField: 'Country', type: 'string', hidden: true},
            {text: 'Phone 1', dataField: 'Phone1', type: 'string'},
            {text: 'Phone 2', dataField: 'Phone2', type: 'string'},
            {text: 'Email', dataField: 'Email', type: 'string'},
            {name: 'Note', dataField: 'Note', hidden: true}

        ],
        columnsResize: true,
        width: "99.7%",
        theme: 'arctic',
        sortable: true,
        pageable: true,
        pageSize: 20,
        pagerMode: 'default',
        altRows: true,
        filterable: true,
        filterMode: 'simple'
    };

    // User window settings
    $scope.addUserWindowSettings = {
        created: function (args) {
            addUserDialog = args.instance;
        },
        resizable: false,
        width: "100%", height: "100%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    // Open the window form to add user
    $scope.openAddUserWindows = function () {
        $scope.newOrEditSelected = 'new';
        addUserDialog.setTitle('Add new user');
        addUserDialog.open();
        setTimeout(function(){
            $('#add_username').focus();
        }, 100);
    };

    // Open the window form as edit user
    $scope.openEditUserWindows = function (e) {
        $scope.newOrEditSelected = 'edit';
        var values = e.args.row;
        for (var i in values) {
            var ind = i.toLocaleLowerCase();
            if ($('.addUserField#add_' + ind).length) {
                $('.addUserField#add_' + ind).val(values[i]);
            }
        }
        $('#deleteAddUserForm').show();
        var selectedIndexByPosition = $('#positionCombobox').jqxComboBox('getItemByValue', values['PrimaryPosition']).index;
        $('#positionCombobox').jqxComboBox({'selectedIndex': selectedIndexByPosition});
        $scope.userId = values['Unique'];
        $scope.editing_username = values['UserName'];

        //inputsCode
        var inputsCode = $('#add_code, #add_password');
        inputsCode.val('******');
        inputsCode.on('focus', function() {
            $(this).select();
        });

        addUserDialog.setTitle('User ID ' + values.Unique + ': | User Name: ' + values.UserName);
        addUserDialog.open();
        //setTimeout(function(){
        //    $('#add_username').focus();
        //}, 100);
    };

    var resetWindowAddUserForm = function () {
        var currentWindow = $('.userJqxwindows');
        $(currentWindow).find('form input, textarea').val('');
        $('#positionCombobox').jqxComboBox({'selectedIndex': 4});
        $('#tabsUser').jqxTabs({selectedItem: 0});
        $('#addUserButtons').show();
        $('#addUserConfirm').hide();
        $('#addUserAnotherRow').hide();
        $('#sureToDeleteUser').hide();
        //
        //$('.new-user-form input.required-field').css({'border-color':'#ccc'});
        $('#addtab1').unblock();
        $('#addtab2').unblock();
        $('#addtab3').unblock();
        $('#addtab4').unblock();
        //
        $('#submitAddUserForm').prop('disabled', true);
        $('#deleteAddUserForm').hide();

        $('.addUserField.required-field').css({"border-color": "#ccc"});
        $scope.userId = null;
        //
        $('#userPositionsTable').hide();
        $('#openUserPositionWindowBtn').hide();
    };

    var blockTabs = function () {
        $('#addtab1').block({message: null});
        $('#addtab2').block({message: null});
        $('#addtab3').block({message: null});
        $('#addtab4').block({message: null});
    };

    $scope.closeWindows = function (e) {
        if ($('#submitAddUserForm').is(':disabled')) {
            // Resetting
            resetWindowAddUserForm();
            addUserDialog.close();
        }
        else {
            $('#addUserConfirm').show();
            $('#addUserButtons').hide();
        }
    };

    $scope.closeWindowsConfirm = function (selected) {
        $('#addUserButtons').show();
        if (selected == 0) {
            $scope.submitUserForm();
            $('#addUserConfirm').hide();
        } else if (selected == 1) {
            resetWindowAddUserForm();
            addUserDialog.close();
        } else if (selected == 2) {
            $('#addUserConfirm').hide();
        }
    };

    $scope.addAnotherUserConfirm = function (selected) {
        resetWindowAddUserForm();
        if (selected == 1) {
            addUserDialog.close();
        }
        setTimeout(function(){
            $('#add_username').focus();
        }, 100);
        //if (selected == 0) {}
        //else if (selected == 1) {
        //    addUserDialog.close();
        //} else {}
    };

    $scope.pressDeleteButton = function() {
        $('#sureToDeleteUser').show();
        $('#addUserButtons').hide();
    };

    $scope.deletingUserConfirm = function(selected) {
        if (selected == 0) {
            $scope.deleteRowUser();
        } else if (selected == 1) {
            resetWindowAddUserForm();
            addUserDialog.close();
        } else if (selected == 2) {
            $('#sureToDeleteUser').hide();
            $('#addUserButtons').show();
        }
    };

    // PRIMARY POSITION COMBOBOX
    var source =
    {
        datatype: "json",
        datafields: [
            {name: 'PositionName'},
            {name: 'Unique'}
        ],
        url: SiteRoot + 'admin/user/load_allPositions'
    };
    var dataAdapter = new $.jqx.dataAdapter(source);

    $scope.positionSelectPlaceholder = 'Select a position';
    $scope.positionSelectSetting = {
        created: function (args) {
            comboboxPosition = args.instance;
        },
        selectedIndex: 0,
        displayMember: "PositionName",
        valueMember: "Unique",
        width: "99%",
        height: 25,
        source: dataAdapter
    };

    $scope.positionSelectChanged = function (e) {
        if (e.args) {
        }
        //$('.submitUserBtn#submitAddUserForm').prop('disabled', false);
    };

    // NOTIFICATIONS SETTINGS
    var notificationSet = function (type) {
        return {
            width: "auto",
            appendContainer: "#add_container",
            opacity: 0.9,
            closeOnClick: true,
            autoClose: true,
            showCloseButton: false,
            //blink: true,
            template: (type == 1) ? 'success' : 'error'
        }
    };
    $scope.notificationErrorSettings = notificationSet(0);
    $scope.notificationSuccessSettings = notificationSet(1);

    /**
     * USER-POSITIONS tab
     */
    // Position tab window settings
    $('#payBasisSelect').jqxDropDownList({autoDropDownHeight: true});
    $scope.userPositionsWindowSettings = {
        created: function (args) {
            userPositionWindow = args.instance;
        },
        resizable: false,
        width: "30%", height: "40%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    //
    $scope.openUserpositionsWindows = function() {
        //addUserDialog.setTitle('Add new user');
        userPositionWindow.open();
    };

    //
    $scope.closeUserpositionsWindows = function() {
        userPositionWindow.close();
    };

    $scope.editPositionByUser = function(e) {
        var values = e.args.row;

        var selectedIndexByPosition;
        var positionCombo = $('#positionByUserCombobox').jqxComboBox('getItemByValue', values['ConfigPositionUnique']);
        if (positionCombo != undefined) {
            selectedIndexByPosition = positionCombo.index | 0;
        } else selectedIndexByPosition = 0;
        //console.log(selectedIndexByPosition);
        $('#positionByUserCombobox').jqxComboBox({'selectedIndex': selectedIndexByPosition});
        //
        var selectedPayPosition;
        var payCombo = $('#payBasisSelect').jqxDropDownList('getItemByValue', values['PayBasis']);
        if (payCombo  != undefined) {
            selectedPayPosition = payCombo.index | 0;
        } else selectedPayPosition = 0;
        //console.log(selectedPayPosition);
        $('#payBasisSelect').jqxDropDownList({'selectedIndex': selectedPayPosition});
        //
        angular.element('#PayRateField').val(values['PayRate']);
        angular.element('#idPositionUserWin').val(values['Unique']);
        //
        userPositionWindow.open();
    };

    $scope.submitUserpositionsWindows = function() {
        var position = $('#positionByUserCombobox').jqxComboBox('getSelectedItem');
        var payBasis = $('#payBasisSelect').jqxDropDownList('getSelectedItem');
        var values = {};

        values['PayRate'] = angular.element('#PayRateField').val();
        values['PayBasis'] = payBasis.value;
        values['ConfigPositionUnique'] = position.value;
        values['ConfigUserUnique'] = $scope.userId;

        $http({
            'method': 'POST',
            'url': SiteRoot + 'admin/user/add_position_user',
            'data': values
            //headers: {'Content-Type': 'application/json'}
        }).then(function(response) {
            if(response.data.status == "success") {
                console.info('Position added');
                //
                //$scope.$apply(function(){
                $scope.userPositionsTableSettings = {
                    source: {
                        dataType: 'json',
                        dataFields: [
                            {name: 'Unique', type: 'number'},
                            {name: 'PositionName', type: 'string'},
                            {name: 'PrimaryPosition', type: 'string'},
                            {name: 'ConfigUserUnique', type: 'string'},
                            {name: 'ConfigPositionUnique', type: 'string'},
                            {name: 'PrimaryPosition', type: 'string'},
                            {name: 'PayBasis', type: 'string'},
                            {name: 'PayRate', type: 'string'}
                        ],
                        id: 'Unique',
                        url: SiteRoot + 'admin/user/load_positionsByUser/' + $scope.userId,
                        created: function (args) {
                            var instance = args.instance;
                            instance.updateBoundData();
                        }
                    }
                };
                //});
                //
                userPositionWindow.close();
            }

        }, function(response){
            console.log(response.data || 'Request failed');
        });
    };

    $scope.deletePositionByUser = function() {
        var id = angular.element('#idPositionUserWin').val();
        $http({
            'method': 'POST',
            'url': SiteRoot + 'admin/user/delete_position_user/' + id
            //headers: {'Content-Type': 'application/json'}
        }).then(function(response) {
            if(response.data.status == "success") {
                console.info('Position removed');
                //
                $scope.userPositionsTableSettings = {
                    source: {
                        dataType: 'json',
                        dataFields: [
                            {name: 'Unique', type: 'number'},
                            {name: 'PositionName', type: 'string'},
                            {name: 'PrimaryPosition', type: 'string'},
                            {name: 'ConfigUserUnique', type: 'string'},
                            {name: 'ConfigPositionUnique', type: 'string'},
                            {name: 'PrimaryPosition', type: 'string'},
                            {name: 'PayBasis', type: 'string'},
                            {name: 'PayRate', type: 'string'}
                        ],
                        id: 'Unique',
                        url: SiteRoot + 'admin/user/load_positionsByUser/' + $scope.userId,
                        created: function (args) {
                            var instance = args.instance;
                            instance.updateBoundData();
                        }
                    }
                };
                //
                userPositionWindow.close();
            }
        });
    };

    $scope.userPositionsTableSettings = {
        source: {
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'number'},
                {name: 'PositionName', type: 'string'},
                {name: 'PrimaryPosition', type: 'string'},
                {name: 'ConfigUserUnique', type: 'string'},
                {name: 'ConfigPositionUnique', type: 'string'},
                {name: 'PrimaryPosition', type: 'string'},
                {name: 'PayBasis', type: 'string'},
                {name: 'PayRate', type: 'string'}
            ],
            //id: 'Unique',
            //url: SiteRoot + 'admin/user/load_positionsByUser/100'
        },
        columns: [
            {text: 'Unique', dataField: 'Unique', type: 'number', hidden:true},
            {text: 'Name', dataField: 'PositionName', type: 'string'},
            {text: 'Primary', dataField: 'PrimaryPosition', type: 'string'},
            {text: 'User Unique', dataField: 'ConfigUserUnique', type: 'number', hidden:true},
            {text: 'Position Unique', dataField: 'ConfigPositionUnique', type: 'number', hidden:true},
            {text: 'Pay Basis', dataField: 'PayBasis', type: 'string', hidden:true},
            {text: 'Pay Rate', dataField: 'PayRate', type: 'string', hidden:true}
        ],
        columnsResize: true,
        width: "75%",
        theme: 'arctic',
        pagerMode: 'default'
    };

    $('#tabsUser').on('tabclick', function (event) {
        var tabclicked = event.args.item;

        // POSITION TAB
        if(tabclicked == 2) {
            if ($scope.userId != null) {
                $('#userPositionsTable').show();
                $('#openUserPositionWindowBtn').show();
                $scope.$apply(function(){
                    $scope.userPositionsTableSettings = {
                        source: {
                            dataType: 'json',
                            dataFields: [
                                {name: 'Unique', type: 'number'},
                                {name: 'PositionName', type: 'string'},
                                {name: 'PrimaryPosition', type: 'string'},
                                {name: 'ConfigUserUnique', type: 'string'},
                                {name: 'ConfigPositionUnique', type: 'string'},
                                {name: 'PrimaryPosition', type: 'string'},
                                {name: 'PayBasis', type: 'string'},
                                {name: 'PayRate', type: 'string'}
                            ],
                            id: 'Unique',
                            url: SiteRoot + 'admin/user/load_positionsByUser/' + $scope.userId,
                            created: function (args) {
                                var instance = args.instance;
                                instance.updateBoundData();
                            }
                        }
                    };
                });
            }
        }
        if(tabclicked == 3) {
            setTimeout(function(){
                $("#add_note").focus();
            }, 100);
        }
    });


    // HELPER to validate fields of user form
    var userValidationFields = function () {
        var needValidation = false;
        // VALIDATION Not empty fields
        $('.new-user-form input.required-field').each(function (i, el) {
            if (el.value == '') {
                /**
                 *  PENDING, SKIPPING code & password FOR EDITING USER
                 */
                //if ($scope.newOrEditSelected != 'edit') {
                //    if ($(el).attr('id') != 'add_code' || $(el).attr('id') != 'add_password') {
                        $('#notificationErrorSettings #notification-content').html($(el).attr('placeholder') + ' can not be empty!');
                        $(el).css({"border-color": "#F00"});
                        $scope.notificationErrorSettings.apply('open');
                        console.info($(el).attr('placeholder') + ' can not be empty!');
                        needValidation = true;
                    //}
                //}
            }
            else {
                $(el).css({"border-color": "#ccc"});
            }
        });
        // VALIDATION Combobox Primary position
        var comboboxPosition = $('#positionCombobox').jqxComboBox('getSelectedItem');
        if (!comboboxPosition) {
            $('#notificationErrorSettings #notification-content').html('Primary position can not be empty!');
            $scope.notificationErrorSettings.apply('open');
            console.info('Primary position can not be empty!');
            needValidation = true;
        }

        // VALIDATION Format of email
        var emailInputField = $('.addUserField#add_email');
        if (emailInputField.val() != '' && !check_email(emailInputField.val())) {
            $('#notificationErrorSettings #notification-content').html('Format of email is not valid!');
            emailInputField.css({"border-color": "#F00"});
            $scope.notificationErrorSettings.apply('open');
            console.info('Format of email is not valid');
            needValidation = true;
        }
        else {
            emailInputField.css({"border-color": "#ccc"});
        }

        return needValidation;
    };

    // Action to save a user
    $scope.submitUserForm = function () {
        var comboboxPosition = $('#positionCombobox').jqxComboBox('getSelectedItem');
        var needValidation = userValidationFields();
        var params = {};
        // Check if some is missing
        if (!needValidation) {
            // Creating..
            if ($scope.newOrEditSelected == 'new') {
                $.each($('#new-user-form').serializeArray(), function (i, el) {
                    params[el.name] = el.value;
                });
                params['position'] = comboboxPosition.value;
                $.ajax({
                    'url': SiteRoot + 'admin/user/store_user',
                    'method': 'POST',
                    'dataType': 'json',
                    'data': params,
                    success: function (data) {
                        if (data.status == 'success') {
                            $('.addUserField').css({"border-color": "#ccc"});
                            // reload table
                            $scope.userTableSettings = {
                                source: {
                                    dataType: 'json',
                                    dataFields: [
                                        {name: 'Unique', type: 'int'},
                                        {name: 'UserName', type: 'string'},
                                        {name: 'FirstName', type: 'string'},
                                        {name: 'LastName', type: 'string'},
                                        //{name: 'Code', type: 'string'},
                                        //{name: 'Password', type: 'string'},
                                        {name: 'Address1', type: 'string'},
                                        {name: 'Address2', type: 'string'},
                                        {name: 'City', type: 'string'},
                                        {name: 'State', type: 'string'},
                                        {name: 'Zip', type: 'string'},
                                        {name: 'Country', type: 'string'},
                                        {name: 'PrimaryPosition', type: 'string'},
                                        {name: 'PrimaryPositionName', type: 'string'},
                                        {name: 'Phone1', type: 'string'},
                                        {name: 'Phone2', type: 'string'},
                                        {name: 'Email', type: 'string'},
                                        {name: 'Note', type: 'string'}
                                    ],
                                    id: 'Unique',
                                    url: SiteRoot + 'admin/user/load_users'
                                },
                                created: function (args) {
                                    var instance = args.instance;
                                    instance.updateBoundData();
                                }
                            };
                            $('#notificationSuccessSettings #notification-content').html('User created successfully!');
                            $('#notificationSuccessSettings').jqxNotification('open');
                            // CLOSE
                            $('#addUserAnotherRow').show();
                            $('#addUserButtons').hide();
                            blockTabs();
                        }
                        else {
                            $.each(data.message, function (i, msg) {
                                $('#notificationErrorSettings #notification-content').html(msg);
                                $scope.notificationErrorSettings.apply('open');
                                $('.addUserField#add_' + i).css({"border-color": "#F00"});
                                //console.info('Format of email is not valid');
                            });
                        }
                    }
                })

            }
            // AJAX updating user
            else if ($scope.newOrEditSelected == 'edit') {
                $.each($('#new-user-form').serializeArray(), function (i, el) {
                    params[el.name] = el.value;
                });
                params['position'] = comboboxPosition.value;
                params['Unique'] = $scope.userId;
                $.ajax({
                    'url': SiteRoot + 'admin/user/update_user',
                    'method': 'POST',
                    'dataType': 'json',
                    'data': params,
                    success: function (data) {
                        if (data.status == 'success') {
                            $('.addUserField').css({"border-color": "#ccc"});
                            // reload table
                            $scope.userTableSettings = {
                                source: {
                                    dataType: 'json',
                                    dataFields: [
                                        {name: 'Unique', type: 'int'},
                                        {name: 'UserName', type: 'string'},
                                        {name: 'FirstName', type: 'string'},
                                        {name: 'LastName', type: 'string'},
                                        //{name: 'Code', type: 'string'},
                                        //{name: 'Password', type: 'string'},
                                        {name: 'Address1', type: 'string'},
                                        {name: 'Address2', type: 'string'},
                                        {name: 'City', type: 'string'},
                                        {name: 'State', type: 'string'},
                                        {name: 'Zip', type: 'string'},
                                        {name: 'Country', type: 'string'},
                                        {name: 'PrimaryPosition', type: 'string'},
                                        {name: 'PrimaryPositionName', type: 'string'},
                                        {name: 'Phone1', type: 'string'},
                                        {name: 'Phone2', type: 'string'},
                                        {name: 'Email', type: 'string'},
                                        {name: 'Note', type: 'string'}
                                    ],
                                    id: 'Unique',
                                    url: SiteRoot + 'admin/user/load_users'
                                },
                                created: function (args) {
                                    var instance = args.instance;
                                    instance.updateBoundData();
                                }
                            };
                            $('#notificationSuccessSettings #notification-content').html('User updated successfully!');
                            $('#notificationSuccessSettings').jqxNotification('open');

                            $('#addUserButtons').show();
                            blockTabs();
                            setTimeout(function() {
                                addUserDialog.close();
                                resetWindowAddUserForm();
                            }, 2000);
                        }
                        else {
                            $.each(data.message, function (i, msg) {
                                $('#notificationErrorSettings #notification-content').html(msg);
                                $scope.notificationErrorSettings.apply('open');
                                $('.addUserField#add_' + i).css({"border-color": "#F00"});
                                //console.info('Format of email is not valid');
                            });
                        }
                    }
                });
            }
        }

    };

    $scope.deleteRowUser = function () {
        $.ajax({
            url: SiteRoot + 'admin/user/delete_user',
            data: {Unique: $scope.userId},
            'method': 'POST',
            'dataType': 'json',
            success: function (data) {
                if (data.status == 'success') {
                    $('.addUserField').css({"border-color": "#ccc"});
                    // reload table
                    $scope.userTableSettings = {
                        source: {
                            dataType: 'json',
                            dataFields: [
                                {name: 'Unique', type: 'int'},
                                {name: 'UserName', type: 'string'},
                                {name: 'FirstName', type: 'string'},
                                {name: 'LastName', type: 'string'},
                                //{name: 'Code', type: 'string'},
                                //{name: 'Password', type: 'string'},
                                {name: 'Address1', type: 'string'},
                                {name: 'Address2', type: 'string'},
                                {name: 'City', type: 'string'},
                                {name: 'State', type: 'string'},
                                {name: 'Zip', type: 'string'},
                                {name: 'Country', type: 'string'},
                                {name: 'PrimaryPosition', type: 'string'},
                                {name: 'PrimaryPositionName', type: 'string'},
                                {name: 'Phone1', type: 'string'},
                                {name: 'Phone2', type: 'string'},
                                {name: 'Email', type: 'string'},
                                {name: 'Note', type: 'string'}
                            ],
                            id: 'Unique',
                            url: SiteRoot + 'admin/user/load_users'
                        },
                        created: function (args) {
                            var instance = args.instance;
                            instance.updateBoundData();
                        }
                    };
                    $('#notificationSuccessSettings #notification-content').html('User deleted!');
                    $('#notificationSuccessSettings').jqxNotification('open');
                    //
                    $('#sureToDeleteUser').hide();
                    $('#addUserButtons').show();
                    blockTabs();
                    setTimeout(function() {
                        addUserDialog.close();
                        resetWindowAddUserForm();
                    }, 2000);
                    //blockTabs();
                    // CLOSE
                    //$('#addUserAnotherRow').show();
                    //$('#addUserButtons').hide();
                    //blockTabs();
                }
            }
        })

    };
});

// -- User controller //