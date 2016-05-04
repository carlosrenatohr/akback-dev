/**
 * Created by carlosrenato on 04-25-16.
 */

var DynamicTab;

$(function(){
    changetabtile();
    checkAnyFormFieldEdited();
    checkAnyFormFieldAdd();

    function changetabtile(){
        $("#tabtitle").html("Users");
    }

    $(".searchinput").keyup(function () {
        $(this).next().toggle(Boolean($(this).val()));
    });
    $(".searchclear").toggle(Boolean($(".searchinput").val()));
    $(".searchclear").click(function () {
        $(this).prev().val('').focus();
        $(this).hide();
    });

    $(".edit_searchinput").keyup(function () {
        $(this).next().toggle(Boolean($(this).val()));
    });
    $(".edit_searchclear").toggle(Boolean($(".edit_searchinput").val()));
    $(".edit_searchclear").click(function () {
        $(this).prev().val('').focus();
        $(this).hide();
    });

    $('#addtabs').on('tabclick', function (event) {
        var tabclicked = event.args.item;
        if(tabclicked == 0){
            $("#container").css({"height":"60px"});
        }else if(tabclicked == 1){
            $("#container").css({"height":"60px"});
        }else if(tabclicked == 2){
            $("#container").css({"height":"60px"});
            $("#add_note").focus();
        }
    });

    // Watch any change on user inputs
    $('.addUserField').on('keypress paste change', function(e) {
        $('.submitUserBtn#submitAddUserForm').prop('disabled', false);

    });

    $('.addUserField').on('keyup', function(e) {
        if (e.keyCode == 8 || e.keyCode == 46) {
            enableAddSaveBtn();
        } else {
            e.preventDefault();
        }
    });
    // --

});

var demoApp = angular.module("demoApp", ['jqwidgets']);
/**
 * User controller
 */
demoApp.controller("userController", function($scope, $http) {

    // Tabs config
    $scope.thetabs = 'darkblue';
    $scope.thetabsadd = 'darkblue';

    $scope.tabsSettings = {
        created: function(args) {
            tabsControl = args.instance
        },
        selectedItem:0
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
                {name: 'PrimaryPositionName', type: 'string'},
                {name: 'Phone1', type: 'string'},
                {name: 'Phone2', type: 'string'},
                {name: 'Email', type: 'string'}
            ],
            id: 'Unique',
            url: SiteRoot + 'admin/user/load_users'
        },
        columns: [
            {text: 'id', dataField: 'Unique', type: 'int'},
            {text: 'User Name',dataField: 'UserName', type: 'string'},
            {text: 'First Name',dataField: 'FirstName', type: 'string'},
            {text: 'Last Name', dataField: 'LastName', type: 'string'},
            {text: 'Primary Position',dataField: 'PrimaryPositionName', type: 'string'},
            {text: 'Phone 1', dataField: 'Phone1', type: 'string'},
            {text: 'Phone 2', dataField: 'Phone2', type: 'string'},
            {text: 'Email', dataField: 'Email', type: 'string'}
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
        created: function(args)
        {
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
    $scope.openAddUserWindows = function() {
        addUserDialog.open();
    };

    var resetWindowAddUserForm = function() {
        var currentWindow = $('.userJqxwindows');
        $(currentWindow).find('form input, textarea').val('');
        $('#positionCombobox').jqxComboBox({'selectedIndex': 4});
        $('#tabsUser').jqxTabs({ selectedItem: 0 });
        $('#addUserButtons').show();
        $('#addUserConfirm').hide();
        $('#addUserAnotherRow').hide();
        //
        $('#addtab1').unblock();
        $('#addtab2').unblock();
        $('#addtab3').unblock();
        $('#addtab4').unblock();
        //
        $('#submitAddUserForm').prop('disabled', true);
    };

    var blockTabs = function() {
        $('#addtab1').block({message: null});
        $('#addtab2').block({message: null});
        $('#addtab3').block({message: null});
        $('#addtab4').block({message: null});
    };

    $scope.closeWindows = function(e) {
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

    $scope.closeWindowsConfirm = function(selected) {
        if (selected == 0) {
            $scope.submitUserForm();
        } else if (selected == 1) {
            resetWindowAddUserForm();
            addUserDialog.close();
        } else if (selected == 2) {
            $('#addUserConfirm').hide();
            $('#addUserButtons').show();
        }
    };

    $scope.addAnotherUserConfirm = function(selected) {
        resetWindowAddUserForm();
        if (selected == 0) {

        } else if (selected == 1) {
            addUserDialog.close();
        } else {}
    };



    // POSITION COMBOBOX
    var source =
    {
        datatype: "json",
        datafields: [
            { name: 'name' },
            { name: 'id' }
        ],
        url: SiteRoot + 'admin/user/load_allPositions',
        async: true
    };
    var dataAdapter = new $.jqx.dataAdapter(source);

    $scope.positionSelectPlaceholder = 'Select a position';
    $scope.positionSelectSetting = {
        created: function(args)
        {
            comboboxPosition = args.instance;
        },
        selectedIndex: 0,
        displayMember: "name",
        valueMember: "id",
        width: "99%",
        height: 25,
        source: dataAdapter
    };

    $scope.positionSelectClicked = function(e){
        if (e.args) {
            console.log(e)
        }
    };

    // NOTIFICATIONS SETTINGS
    var notificationSet = function(type) {
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

    // Action to save a user
    $scope.submitUserForm = function() {
        var needValidation = false;

        // VALIDATION Not empty fields
        $('.new-user-form input.required-field').each(function(i, el) {
            if (el.value == '') {
                $('#notificationErrorSettings #notification-content').html($(el).attr('placeholder') + ' can not be empty!');
                $(el).css({"border-color":"#F00"});
                $scope.notificationErrorSettings.apply('open');
                console.info($(el).attr('placeholder') + ' can not be empty!');
                needValidation = true;
            }
            else {
                $(el).css({"border-color":"#ccc"});
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
            emailInputField.css({"border-color":"#F00"});
            $scope.notificationErrorSettings.apply('open');
            console.info('Format of email is not valid');
            needValidation = true;
        }
        else {
            emailInputField.css({"border-color":"#ccc"});
        }
        // Check if some is missing
        if (!needValidation) {
            var params = {};
            $.each($('#new-user-form').serializeArray(), function(i, el) {
                params[el.name] = el.value;
                //params[el.name] = encodeURIComponent(el.value);
            });
            params['position'] = comboboxPosition.value;
            $.ajax({
                'url': SiteRoot + 'admin/user/store_user',
                'method': 'POST',
                'dataType': 'json',
                'data': params,
                success: function(data) {
                    console.log(data);
                    if (data.status == 'success') {
                        $('.addUserField').css({"border-color":"#ccc"});
                        // reload table
                        $scope.userTableSettings = {
                            source: {
                                dataType: 'json',
                                dataFields: [
                                    {name: 'Unique', type: 'int'},
                                    {name: 'UserName', type: 'string'},
                                    {name: 'FirstName', type: 'string'},
                                    {name: 'LastName', type: 'string'},
                                    {name: 'PrimaryPositionName', type: 'string'},
                                    {name: 'Phone1', type: 'string'},
                                    {name: 'Phone2', type: 'string'},
                                    {name: 'Email', type: 'string'}
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
                        console.log(data.message);
                        $.each(data.message, function(i, msg){
                            $('#notificationErrorSettings #notification-content').html(msg);
                            $scope.notificationErrorSettings.apply('open');
                            $('.addUserField#add_' + i).css({"border-color":"#F00"});
                            console.info('Format of email is not valid');
                        });
                    }
                }
            })
        }

    }
});

// -- User controller //

/**
 * HELPERS from customer...
 */
var FilterCharacters = function(text){
    return encodeURIComponent(text);
}

function checkAnyFormFieldEdited() {
    $('.customer').keypress(function(e) { // text written
        enableSaveBtn();
    });

    $('.customer').keyup(function(e) {
        if (e.keyCode == 8 || e.keyCode == 46) { //backspace and delete key
            enableSaveBtn();
        } else { // rest ignore
            e.preventDefault();
        }
    });

    $('.customer').bind('paste', function(e) { // text pasted
        enableSaveBtn();
    });

    $('.customer').change(function(e) { // select element changed
        enableSaveBtn();
    });
}

function checkAnyFormFieldAdd() {
    $('.addcustomer').keypress(function(e) { // text written
        enableAddSaveBtn();
    });

    $('.addcustomer').keyup(function(e) {
        if (e.keyCode == 8 || e.keyCode == 46) { //backspace and delete key
            enableAddSaveBtn();
        } else { // rest ignore
            e.preventDefault();
        }
    });

    $('.addcustomer').bind('paste', function(e) { // text pasted
        enableAddSaveBtn();
    });

    $('.addcustomer').change(function(e) { // select element changed
        enableAddSaveBtn();
    });
}

function enableSaveBtn(){
    $("#_update").attr("disabled", false);
}

function enableAddSaveBtn(){
    $("#add_save").attr("disabled", false);
}

function reset_form(){
    // PENDING TO CLEAR USER INPUTS
}

function check_email(val) {
    if(!val.match(/\S+@\S+\.\S+/)){
        return false;
    }
    if( val.indexOf(' ')!=-1 || val.indexOf('..')!=-1){
        return false;
    }
    return true;
}


function countChar() {
    var len = $("#phone1").val().length;
    if (len >= 6) {
        //do nothing
    } else {
        $('#phone1').val("");
    }
}

function confirmation_message(){
    setTimeout(function(){
    }, intervalclosemessage);
}

$(function(){
    setTimeout(function(){
        $("#table input.jqx-input").focus();
    },1000)
});