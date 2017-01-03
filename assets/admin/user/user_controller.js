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
        //
        $('#emailEnabledField .eecx[data-msg="no"]')
            .jqxRadioButton({ checked:true });
        $('#position_itemTab, #info_itemTab, #email_itemTab').hide();
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
                el.jqxDateTimeInput({formatString: 'MM-dd-yyyy hh:mm tt'});
                el.jqxDateTimeInput('setDate', dt);
            }
        }
        var eec = (values.EmailEnabled == 'yes') ? 'yes' : 'no';
        var emailEn = $('#emailEnabledField .eecx[data-msg="' + eec +'"]');
        emailEn.jqxRadioButton({ checked:true });
        if (eec == 'yes') {
            $('#email_itemTab').show();
        } else {
            $('#email_itemTab').hide();
        }
        // $('#deleteAddUserForm').show();
        $('#positionCombobox').jqxComboBox('val', values['PrimaryPosition']);
        $scope.userId = values['Unique'];
        $scope.editing_username = values['UserName'];

        //inputsCode
        var inputsCode = $('#add_code, #add_password, #add_epassword');
        inputsCode.val('******');
        inputsCode.on('focus', function() {
            $(this).select();
        });

        $('#position_itemTab, #info_itemTab').show();
            $('#position_itemTab .jqx-tabs-titleContentWrapper,' +
              '#info_itemTab .jqx-tabs-titleContentWrapper, ' +
                '#email_itemTab .jqx-tabs-titleContentWrapper').css('margin-top', '0');
        //
        var btn = $('<button/>', {
            'ng-click': 'pressDeleteButton()',
            'id': 'deleteAddUserForm'
        }).addClass('icon-trash user-del-btn'); //Built in styles.css on admin
        $('.submitUserBtn#submitAddUserForm').prop('disabled', true);
        var title = $('<div/>').html('User ID ' + values.Unique + ': | User Name: ' + values.UserName).append(btn)
            .css('padding-left', '2em');
        addUserDialog.setTitle(title);
        addUserDialog.open();
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
        $('#email_itemTab').hide();
        //
        //$('.new-user-form input.required-field').css({'border-color':'#ccc'});
        $('#addtab1, #addtab2, #addtab3, #addtab4, #addtab5, #addtab6').unblock();
        //
        $('#submitAddUserForm').prop('disabled', true);
        // $('#deleteAddUserForm').hide();
        $('.addUserField').css({"border-color": "#ccc"});
        $scope.userId = null;
        //
        $('#userPositionsTable').hide();
        $('#openUserPositionWindowBtn').hide();
    };

    var blockTabs = function () {
        $('#addtab1, #addtab2, #addtab3, #addtab4, #addtab5, #addtab6').block({message: null});
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

    $('body').on('click', '#deleteAddUserForm', function(e) {
        $('#tabsUser').jqxTabs('select', 0);
        $('#sureToDeleteUser').show();
        $('#addUserButtons').hide();
    });

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

    $('#tabsUser').on('tabclick', function (event) {
        var tabclicked = event.args.item;
        var tabTitle = $(this).jqxTabs('getTitleAt', tabclicked);
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
            $('.addUserField#add_created').jqxDateTimeInput({formatString: 'MM-dd-yyyy hh:mm tt'});
            $('.addUserField#add_created').jqxDateTimeInput('setDate', dt);
            var dt = new Date(Date.parse(row.Updated));
            $('.addUserField#add_updated').jqxDateTimeInput({formatString: 'MM-dd-yyyy hh:mm tt'});
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
        var mailing = {};
        var emailEn = $('#emailEnabledField [aria-checked="true"]');
        var ee = (emailEn.length > 0) ? emailEn.data('msg') : "no";
        // Check if some is missing
        if (!needValidation) {
            $.each($('#new-user-form').serializeArray(), function (i, el) {
                var len = $('[name='+ el.name+ ']');
                if (len.length > 0 && (len.hasClass('emailtab') || len.siblings().hasClass('emailtab'))) {
                    mailing[el.name] = el.value;
                } else {
                    params[el.name] = el.value;
                }
            });
            params['position'] = comboboxPosition.value;
            params['EmailEnabled'] = ee;
            params['emailConfig'] = mailing;
            // Creating..
            if ($scope.newOrEditSelected == 'new') {
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
                                if (params.EmailEnabled == 'yes') {
                                    $('#email_itemTab').show();
                                    $('#position_itemTab .jqx-tabs-titleContentWrapper,' +
                                    '#info_itemTab .jqx-tabs-titleContentWrapper, ' +
                                    '#email_itemTab .jqx-tabs-titleContentWrapper').css('margin-top', '0');
                                } else {
                                    $('#email_itemTab').hide();
                                }
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
                            // updateUserGrid();
                            $('#userMainGrid').jqxGrid('updatebounddata', 'filter');
                            $('#notificationSuccessSettings #notification-content').html('User updated successfully!');
                            $('#notificationSuccessSettings').jqxNotification('open');


                            $('#submitAddUserForm').attr('disabled', 'disabled');
                            $('#addUserButtons').show();
                            if (closed == 0) {
                                $('#savePositionuserBtn').prop('disabled', true);
                                $scope.closeUserWindows();
                            } else {
                                if (params.EmailEnabled == 'yes') {
                                    $('#email_itemTab').show();
                                } else {
                                    $('#email_itemTab').hide();
                                }
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
        });
    };


    /**
     * USER-POSITIONS tab
     */
    $scope.userPositionsTableSettings = UserAdminService.userPositionGridSettings();
    function updatePositionGrid(id) {
        $('#userPositionsTable').jqxGrid({
            source: new $.jqx.dataAdapter(UserAdminService.userPositionGridSettings(id).source)
        });
    };

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


    function enablePositions() {
        var items = $('#positionByUserCombobox').jqxComboBox('getItems');
        $.each(items, function(i, ele) {
            $('#positionByUserCombobox').jqxComboBox('enableItem', ele);
        });
    }

    function disablePositions(id) {
        var positions = $('#userPositionsTable').jqxGrid('getRows');
        $.each(positions, function(i, el) {
            var item = el.ConfigPositionUnique;
            // if (id != undefined && id != el) {
            var opt = $('#positionByUserCombobox').jqxComboBox('getItemByValue', item);
            $('#positionByUserCombobox').jqxComboBox('disableItem', opt);
            // }
        });
    }

    //
    $scope.openUserpositionsWindows = function() {
        disablePositions();
        $('#positionByUserCombobox').jqxComboBox({disabled: false});
        $('#positionByUserCombobox').jqxComboBox('val', '');
        $('#deletePositionuserBtn').hide();

        $('#primaryFieldContainer').show();
        $('#primaryPosition').jqxCheckBox({checked: false});
        $('#savePositionuserBtn').attr('disabled', 'disabled');
        userPositionWindow.setTitle("Add Position | Username: <b>" + $scope.editing_username+ "</b>");
        userPositionWindow.open();
    };

    $scope.editPositionByUser = function(e) {
        var values = e.args.row.bounddata;
        enablePositions();
        //
        $('#positionByUserCombobox').jqxComboBox('val', values['ConfigPositionUnique']);
        $('#payBasisSelect').jqxDropDownList('val', values['PayBasis']);
        $('#PayRateField').val(values['PayRate']);
        $('#idPositionUserWin').val(values['Unique']);
        //
        if (values['PrimaryPosition'] == 1) {
            $('#deletePositionuserBtn').hide();
            $('#primaryFieldContainer').hide();
        } else {
            $('#deletePositionuserBtn').show();
            $('#primaryFieldContainer').show();
        }
        var isPrimary = (values['PrimaryPosition'] == 1) ? true : false;
        $('#primaryPosition').jqxCheckBox({checked: isPrimary});
        $('#positionByUserCombobox').jqxComboBox({disabled: true});
        $('#savePositionuserBtn').prop('disabled', true);
        userPositionWindow.setTitle(
            "Edit position <b>"+ values['PositionName'] + "</b> | Username: <b>" + $scope.editing_username + "</b>");
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

});

// -- User controller //