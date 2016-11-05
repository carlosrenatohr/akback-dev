/**
 * Created by carlosrenato on 04-25-16.
 */

angular.module("akamaiposApp", ['jqwidgets'])
    .controller("userController", function($scope, $http, UserAdminService, adminService) {
    $scope.newOrEditSelected = null;
    // Tabs config
    $scope.thetabs = 'darkblue';
    $scope.thetabsadd = 'darkblue';
    $scope.disabled = true;

    // User Tabs settings
    $scope.tabsSettings = {
        created: function (args) {
            tabsControl = args.instance
        },
        selectedItem: 0
    };

    // User datatable settings
    $scope.userTableSettings = UserAdminService.userGridSettings();

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

    // Close event for user windows
    $scope.onCloseUserWindowsEvent = function(e) {
        $('#notificationErrorSettings').jqxNotification('closeLast');
        $('#notificationSuccessSettings').jqxNotification('closeLast');
        resetWindowAddUserForm();
    };

    // Open the window form to add user
    $scope.openAddUserWindows = function () {
        $scope.disabled = false;
        $scope.newOrEditSelected = 'new';

        $('#position_itemTab, #info_itemTab').hide();
        $('.submitUserBtn#submitAddUserForm').prop('disabled', true);
        addUserDialog.setTitle('Add New User');
        addUserDialog.open();
        setTimeout(function(){
            $('#add_username').focus();
        }, 100);
    };

    // Open the window form as edit user
    $scope.openEditUserWindows = function (e) {
        $scope.disabled = true;
        $scope.newOrEditSelected = 'edit';
        var values = e.args.row.bounddata;
        for (var i in values) {
            var ind = i.toLocaleLowerCase();
            var el = $('.addUserField#add_' + ind);
            if (el.length) {
                el.val(values[i]);
            }
            if (ind == 'created' || ind == 'updated') {
                var dt = new Date(Date.parse(values[i]));
                el.jqxDateTimeInput({formatString: 'dd-MM-yyyy hh:mm tt'});
                el.jqxDateTimeInput('setDate', dt);
            }
        }
        $('#deleteAddUserForm').show();
        // var selectedIndexByPosition = $('#positionCombobox').jqxComboBox('getItemByValue', values['PrimaryPosition']).index;
        // $('#positionCombobox').jqxComboBox({'selectedIndex': selectedIndexByPosition});
        $('#positionCombobox').jqxComboBox('val', values['PrimaryPosition']);
        $scope.userId = values['Unique'];
        $scope.editing_username = values['UserName'];

        //inputsCode
        var inputsCode = $('#add_code, #add_password');
        inputsCode.val('******');
        inputsCode.on('focus', function() {
            $(this).select();
        });

        $('#position_itemTab, #info_itemTab').show();
        $('#position_itemTab .jqx-tabs-titleContentWrapper,' +
          '#info_itemTab .jqx-tabs-titleContentWrapper').css('margin-top', '0');

        $('.submitUserBtn#submitAddUserForm').prop('disabled', true);
        addUserDialog.setTitle('User ID ' + values.Unique + ': | User Name: ' + values.UserName);
        addUserDialog.open();
        //setTimeout(function(){
        //    $('#add_username').focus();
        //}, 100);
    };

    var resetWindowAddUserForm = function () {
        var currentWindow = $('.userJqxwindows');
        $(currentWindow).find('form input, textarea').val('');
        $('#positionCombobox').jqxComboBox({'selectedIndex': 0});
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
        $('#addtab5').unblock();
        //
        $('#submitAddUserForm').prop('disabled', true);
        $('#deleteAddUserForm').hide();
        $('.addUserField').css({"border-color": "#ccc"});
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
        $('#addtab5').block({message: null});
    };

    $scope.closeUserWindows = function (selected) {

        if (selected == 0) {
            $scope.submitUserForm(selected);
            //$('#addUserConfirm').hide();
        } else if (selected == 1) {
            $('#addUserButtons').show();
            resetWindowAddUserForm();
            addUserDialog.close();
        } else if (selected == 2) {
            $('#addUserButtons').show();
            $('#addUserConfirm').hide();
        }
        else {
            if ($('#submitAddUserForm').is(':disabled')) {
                // Resetting
                resetWindowAddUserForm();
                addUserDialog.close();
            }
            else {
                $('#addUserConfirm').show();
                $('#addUserButtons').hide();
            }
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
    var dataAdapter = new $.jqx.dataAdapter({
        datatype: "json",
        datafields: [
            {name: 'PositionName'},
            {name: 'Unique'}
        ],
        url: SiteRoot + 'admin/user/load_allPositions'
    });

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
        $('.submitUserBtn#submitAddUserForm').prop('disabled', false);
    };

    // NOTIFICATIONS SETTINGS
    $scope.notificationErrorSettings = adminService.setNotificationSettings(0, '#add_container');
    $scope.notificationSuccessSettings = adminService.setNotificationSettings(1, '#add_container');
    $scope.notificationPositionSettings = adminService.setNotificationSettings(1, '#add_container');

    /**
     * USER-POSITIONS tab
     */
    // Position tab window settings
    $('#payBasisSelect').jqxDropDownList({autoDropDownHeight: true, width: '180px'});
    $scope.userPositionsWindowSettings = {
        created: function (args) {
            userPositionWindow = args.instance;
        },
        resizable: false,
        width: "30%", height: "35%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    // Events position
    $scope.PayRate = 1;
    $('#PayRateField, #primaryPosition').on('keypress keyup paste change', function (e) {
        if (this.value == '') {
            $scope.PayRate = 1;
        }
        if ($scope.PayRate == undefined) {
            //console.log(this.value);
            //$(this).css({"border-color": "#F00"});
            return false;
        } else {
            $(this).css({"border-color": "#CCC"});
        }
        $('#savePositionuserBtn').prop('disabled', false);
    });

    $('#payBasisSelect').on('select', function(){
        $('#savePositionuserBtn').prop('disabled', false);
    });

    $('#positionByUserCombobox').on('select', function (e) {
        $('#savePositionuserBtn').prop('disabled', false);
    });


    $scope.closeUserpositionsWindows = function(option) {
        if (option == 1) {
            $scope.submitUserpositionsWindows();
        } else if (option == 2) {
            userPositionWindow.close();
            resetPositionForm();
        } else if (option == 3) {
            $('#sureToCancelPosition').hide();
            $('#buttonsGroupsPositions').show();
        }
        //$('#deletePositionuserBtn').show();
        else {
            if ($('#savePositionuserBtn').is(':disabled')) {
                resetPositionForm();
                userPositionWindow.close();
            } else {
                $('#sureToCancelPosition').show();
                $('#buttonsGroupsPositions').hide();
            }
        }
    };

    function resetPositionForm() {
        angular.element('#PayRateField').val('');
        $('#deletePositionuserBtn').show();

        $('#sureToCancelPosition').hide();
        $('#buttonsGroupsPositions').show();

        $('#savePositionuserBtn').prop('disabled', true);
    }

    //
    $scope.openUserpositionsWindows = function() {
        // disablePositions();
        $('#positionByUserCombobox').jqxComboBox({disabled: false});
        $('#deletePositionuserBtn').hide();

        $('#primaryPosition').jqxCheckBox({checked: false});
        $('#savePositionuserBtn').attr('disabled', 'disabled');
        userPositionWindow.setTitle("Add Position | username: <b>" + $scope.editing_username+ "</b>");
        userPositionWindow.open();
    };

    $scope.editPositionByUser = function(e) {
        var values = e.args.row.bounddata;
        userPositionWindow.setTitle("Edit position <b>"+ values['PositionName'] + "</b> | Username: <b>" + $scope.editing_username + "</b>");

        var selectedIndexByPosition;
        var positionCombo = $('#positionByUserCombobox').jqxComboBox('getItemByValue', values['ConfigPositionUnique']);
        if (positionCombo != undefined) {
            selectedIndexByPosition = positionCombo.index | 0;
        } else selectedIndexByPosition = 0;
        $('#positionByUserCombobox').jqxComboBox({'selectedIndex': selectedIndexByPosition});
        //
        var selectedPayPosition;
        var payCombo = $('#payBasisSelect').jqxDropDownList('getItemByValue', values['PayBasis']);
        if (payCombo  != undefined) {
            selectedPayPosition = payCombo.index | 0;
        } else selectedPayPosition = 0;
        $('#payBasisSelect').jqxDropDownList({'selectedIndex': selectedPayPosition});
        //
        angular.element('#PayRateField').val(values['PayRate']);
        angular.element('#idPositionUserWin').val(values['Unique']);
        //
        if (values['PrimaryPosition'] == 1) {
            $('#deletePositionuserBtn').hide();
        }
        $('#primaryPosition').jqxCheckBox({checked: (values['PrimaryPosition'] == 1) ? true : false});
        //
        $('#savePositionuserBtn').attr('disabled', 'disabled');
        $('#positionByUserCombobox').jqxComboBox({disabled: true});
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
        values['PrimaryPosition'] = $('#primaryPosition').val();

        $http({
            'method': 'POST',
            'url': SiteRoot + 'admin/user/add_position_user',
            'data': values
            //headers: {'Content-Type': 'application/json'}
        }).then(function(response) {
            if(response.data.status == "success") {
                //
                updateUserGrid();
                updatePositionGrid($scope.userId);
                userPositionWindow.close();
                resetPositionForm();
                //
                setTimeout(function() {
                    var position = $('#userMainGrid').jqxGrid('getrowdatabyid', $scope.userId).PrimaryPosition;
                    $('#positionCombobox').val(position);
                }, 200);
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
                //
                updatePositionGrid($scope.userId);
                userPositionWindow.close();
                resetPositionForm();
            }
        });
    };

    $scope.userPositionsTableSettings = UserAdminService.userPositionGridSettings();
    function updatePositionGrid(id) {
        $('#userPositionsTable').jqxGrid({
            source: new $.jqx.dataAdapter(UserAdminService.userPositionGridSettings(id).source)
        });
    }

    $('#tabsUser').on('tabclick', function (event) {
        var tabclicked = event.args.item;
        var tabTitle = $(this).jqxTabs('getTitleAt', tabclicked);
        //
        if (tabclicked == 0) {
            $('#deleteAddUserForm').show();
        } else {
            $('#deleteAddUserForm').hide();
        }
        // POSITION TAB
        if(tabTitle == 'Position') {
            if ($scope.userId != null) {
                $('#userPositionsTable').show();
                $('#openUserPositionWindowBtn').show();
                updatePositionGrid($scope.userId);
            }
        }
        else if(tabTitle == 'Notes') {
            setTimeout(function(){
                $("#add_note").focus();
            }, 100);
        }
        else if(tabTitle == 'Info') {
            var row = $('#userMainGrid').jqxGrid('getrowdatabyid', $scope.userId);

            $('.addUserField#add_createdbyname').val(row.CreatedByName);
            $('.addUserField#add_updatedbyname').val(row.UpdatedByName);
            var dt = new Date(Date.parse(row.Created));
            $('.addUserField#add_created').jqxDateTimeInput({formatString: 'dd-MM-yyyy hh:mm tt'});
            $('.addUserField#add_created').jqxDateTimeInput('setDate', dt);
            var dt = new Date(Date.parse(row.Updated));
            $('.addUserField#add_updated').jqxDateTimeInput({formatString: 'dd-MM-yyyy hh:mm tt'});
            $('.addUserField#add_updated').jqxDateTimeInput('setDate', dt);
        }
    });


    // HELPER to validate fields of user form
    var userValidationFields = function () {
        var needValidation = false;
        // VALIDATION Not empty fields
        $('.new-user-form input.required-field').each(function (i, el) {
            if (el.value == '') {
                //if ($scope.newOrEditSelected != 'edit') {
                //    if ($(el).attr('id') != 'add_code' || $(el).attr('id') != 'add_password') {
                        $('#notificationErrorSettings #notification-content').html($(el).attr('placeholder') + ' can not be empty!');
                        $(el).css({"border-color": "#F00"});
                        $scope.notificationErrorSettings.apply('open');
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
            needValidation = true;
        }

        // VALIDATION Format of email
        var emailInputField = $('.addUserField#add_email');
        if (emailInputField.val() != '' && !check_email(emailInputField.val())) {
            $('#notificationErrorSettings #notification-content').html('Format of email is not valid!');
            emailInputField.css({"border-color": "#F00"});
            $scope.notificationErrorSettings.apply('open');
            needValidation = true;
        }
        else {
            emailInputField.css({"border-color": "#ccc"});
        }

        return needValidation;
    };

    function updateUserGrid() {
        // $scope.userTableSettings = {
        $('#userMainGrid').jqxGrid({
            source: new $.jqx.dataAdapter(UserAdminService.userGridSettings().source)
        });
    }

    // Action to save a user
    $scope.submitUserForm = function (closed) {
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
                            updateUserGrid();
                            $('#notificationSuccessSettings #notification-content').html('User created successfully!');
                            $('#notificationSuccessSettings').jqxNotification('open');
                            // CLOSE
                            if (closed == 0) {
                                $('#savePositionuserBtn').prop('disabled', true);
                                //$scope.closeUserWindows();
                                addUserDialog.close();
                                $('#addUserButtons').show();
                            } else {
                                $('#addUserAnotherRow').show();
                                $('#addUserButtons').hide();
                                blockTabs();
                            }
                        }
                        else {
                            $.each(data.message, function (i, msg) {
                                $('#notificationErrorSettings #notification-content').html(msg);
                                $scope.notificationErrorSettings.apply('open');
                                $('.addUserField#add_' + i).css({"border-color": "#F00"});
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
                            updateUserGrid();
                            $('#notificationSuccessSettings #notification-content').html('User updated successfully!');
                            $('#notificationSuccessSettings').jqxNotification('open');


                            $('#submitAddUserForm').attr('disabled', 'disabled');
                            $('#addUserButtons').show();
                            if (closed == 0) {
                                $('#savePositionuserBtn').prop('disabled', true);
                                $scope.closeUserWindows();
                            }
                        }
                        else {
                            $.each(data.message, function (i, msg) {
                                $('#notificationErrorSettings #notification-content').html(msg);
                                $scope.notificationErrorSettings.apply('open');
                                $('.addUserField#add_' + i).css({"border-color": "#F00"});
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
                    updateUserGrid();
                    addUserDialog.close();
                    resetWindowAddUserForm();
                }
            }
        })

    };
});

// -- User controller //