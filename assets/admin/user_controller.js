/**
 * Created by carlosrenato on 04-25-16.
 */

var DynamicTab;
var selzipcode, selzipunique, selcity, selstate, selisland, selcountry = null;
var zipcodesDataAdapter = '';
var citiesDataAdapter =  '';
var statesDataAdapter = '' ;
var islandDataAdapter =  '';
var countriesDataAdapter =  '';
var areacode;
var intervalclosemessage = 1000;
var global_custid, global_custname='';

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
        console.log('The clicked tab is ' + tabclicked);
        if(tabclicked == 0){
            $("#container").css({"height":"60px"});
        }else if(tabclicked == 1){
            $("#container").css({"height":"60px"});
        }else if(tabclicked == 2){
            $("#container").css({"height":"60px"});
            $("#add_note").focus();
        }

    });

});

var demoApp = angular.module("demoApp", ['jqwidgets']);

/**
 * User controller
 */
demoApp.controller("userController", function($scope, $http) {

    // Tabs config
    $scope.thetabs = 'darkblue';
    $scope.thetabsadd = 'darkblue';

    $scope.tabset = {
        selectedItem:0
    };
    $scope.tabsSettings = {
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
                //{name: 'Primary Position', type: 'string'},
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
            //{text: 'Primary Position',dataField: 'Primary Position', type: 'string'},
            {text: 'Phone 1', dataField: 'Phone1', type: 'string'},
            {text: 'Phone 2', dataField: 'Phone2', type: 'string'},
            {text: 'Email', dataField: 'Email', type: 'string'},
        ],
        columnsResize: true,
        width: "99.7%",
        theme: 'arctic',
        sortable: true,
        pageable: true,
        pageSize: 15,
        pagerMode: 'default',
        altRows: true,
        filterable: true,
        filterMode: 'simple',
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
        showCloseButton: true
    };

    //
    $scope.notificationSettings = {
        width: "auto",
        appendContainer: "#add_container",
        opacity: 0.9,
        closeOnClick: true,
        autoClose: true,
        showCloseButton: false,
        //blink: true,
        template: 'error'
    };

    // Open the window form to add user
    $scope.openAddUserWindows = function() {
        addUserDialog.open();
    };

    // Action to save a user
    $scope.submitUserForm = function() {
        var needValidation = false;
        $('.new-user-form input.required-field').each(function(i, el) {
            $scope.notificationSettings.apply('closeAll');
            if (el.value == '') {
                $('#notification-content').html($(el).attr('placeholder') + ' can not be empty!');
                $scope.notificationSettings.apply('open');
                console.info($(el).attr('placeholder') + ' can not be empty!');
                needValidation = true;
            }
        });
        if (!needValidation) {
            var params = {};
            $.each($('#new-user-form').serializeArray(), function(i, el){
                params[el.name] = encodeURIComponent(el.value);
            });
            $.ajax({
                'url': SiteRoot + 'admin/user/store_user',
                'method': 'POST',
                'dataType': 'json',
                'data': params,
                success: function(data) {
                    console.log(data);
                }
            })
        }

    }
});

// -- User controller //

demoApp.controller("demoController", function ($scope, $compile, $window) {

    $scope.dialogSettings =
    {
        created: function(args)
        {
            dialog = args.instance;
        },
        resizable: false,
        width: "100%", height: "100%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    $scope.addialogSettings =
    {
        created: function(args)
        {
            addialog = args.instance;
        },
        resizable: false,
        width: "100%", height: "100%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    }

    $("#_cancel").click(function() {
        var changed = $("#_update").is(":disabled");
        if (changed) {
            $('#tab1').unblock();
            $('#tab2').unblock();
            $('#tab3').unblock();
            reset_form();

            dialog.close();

            $scope.$apply(function () {
                $scope.tabset = {};
            });

            $scope.$apply(function () {
                $scope.tabset = {
                    selectedItem: 0
                }
            })
            setTimeout(function(){
                $("#table input.jqx-input").focus();
            },500);
        } else {
            $("#_btnscd").hide();
            $("#msg").show();
            $("#msg_delete").hide();

            $('#edit_jqxNotification').jqxNotification('closeAll');
            var process6 = false;
            if($("#firstname").val() == ''){
                $("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
                $("#edit_notificationContent").html("First name is required field");
                $("#edit_jqxNotification").jqxNotification("open");
                $("#firstname").css({"border-color":"#f00"});
                process6 = false;
            }else{
                $("#firstname").css({"border-color":"#ccc"});
                process6 = true;
            }

            var process1 = false;
            var SelZipCode = $("#zipcode").jqxComboBox('getSelectedItem');
            var SelZipCodeText = $("#zipcode").val();
            if(SelZipCode){
                process1 = true;
            }else{
                if(SelZipCodeText == ''){
                    process1 = true;
                }else{
                    $("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true,  template: "error" });
                    $("#edit_notificationContent").html("Zip code does not exist");
                    $("#edit_jqxNotification").jqxNotification("open");
                    process1 = false;
                }
            }


            var process2 = false;
            var SelCity = $("#city").jqxComboBox('getSelectedItem');
            var SelCityText = $("#city").val();
            if(SelCity){
                process2 = true;
            }else{
                if(SelCityText == ''){
                    process2 = true;
                }else{
                    $("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
                    $("#edit_notificationContent").html("City does not exist");
                    $("#edit_jqxNotification").jqxNotification("open");
                    process2 = false;
                }
            }

            var process3 = false;
            var SelState = $("#state").jqxComboBox('getSelectedItem');
            var SelStateText = $("#state").val();
            if(SelState){
                process3 = true;
            }else{
                if(SelStateText == ''){
                    process3 = true;
                }else{
                    $("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
                    $("#edit_notificationContent").html("State does not exist");
                    $("#edit_jqxNotification").jqxNotification("open");
                    process3 = false;
                }
            }

            var process4 = false;
            var SelIsland = $("#island").jqxComboBox('getSelectedItem');
            var SelIslandText = $("#island").val();
            if(SelIsland){
                process4 = true;
            }else{
                if(SelIslandText == ''){
                    process4 = true;
                }else{
                    $("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
                    $("#edit_notificationContent").html("Island does not exist");
                    $("#edit_jqxNotification").jqxNotification("open");
                    process4 = false;
                }
            }

            var process5 = false;
            var SelCountry = $("#country").jqxComboBox('getSelectedItem');
            var SelCountryText = $("#country").val();
            if(SelCountry){
                process5 = true;
            }else{
                if(SelCountryText == ''){
                    process5 = true;
                }else{
                    $("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
                    $("#edit_notificationContent").html("Country does not exist");
                    $("#edit_jqxNotification").jqxNotification("open");
                    process5 = false;
                }
            }

            var process7 = false;
            if($("#email").val() != ''){
                if(check_email($("#email").val())){
                    $("#email").css({"border-color":"#ccc"});
                    process7 = true;
                }else{
                    $("#email").css({"border-color":"#F00"});
                    process7 = false;
                    $("#edit_email_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "mail" });
                    $("#edit_email_notificationContent").html("Please type a valid email address");
                    $("#edit_email_jqxNotification").jqxNotification("open");
                }
            }else{
                $("#email").css({"border-color":"#ccc"});
                process7 = true;
            }

            if(process1 == true && process2 == true && process3 == true && process4 == true && process5 == true && process6 == true && process7 == true){
                $('#tab1').block({message: null});
                $('#tab2').block({message: null});
                $('#tab3').block({message: null});
                $scope.tabset = {};
            }else{
                $scope.$apply(function(){
                    $scope.tabset = {};
                });
                $scope.$apply(function(){
                    $scope.tabset = {
                        selectedItem: 0
                    }
                });
            }
        }
        $("#del_confirmation_msg").hide();
        $("#delmymessage").html("");

    });


    $("#_no").click(function () {
        dialog.close();
        $scope.$apply(function () {
            $scope.tabset = {};
        });

        $scope.$apply(function () {
            $scope.tabset = {
                selectedItem: 0
            }
        })
        reset_form();
    });

    $("#_conf_cancel").click(function () {
        $('#tab1').unblock();
        $('#tab2').unblock();
        $("#msg").hide();
        $("#_btnscd").show();
    });

    $("#_update").click(function () {
        $('#edit_jqxNotification').jqxNotification('closeAll');
        var process6 = false;
        if($("#firstname").val() == ''){
            $("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
            $("#edit_notificationContent").html("First name is required field");
            $("#edit_jqxNotification").jqxNotification("open");
            $("#firstname").css({"border-color":"#f00"});
            process6 = false;
        }else{
            $("#firstname").css({"border-color":"#ccc"});
            process6 = true;
        }

        var process1 = false;
        var SelZipCode = $("#zipcode").jqxComboBox('getSelectedItem');
        var SelZipCodeText = $("#zipcode").val();
        if(SelZipCode){
            process1 = true;
        }else{
            if(SelZipCodeText == ''){
                process1 = true;
            }else{
                $("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true,  template: "error" });
                $("#edit_notificationContent").html("Zip code does not exist");
                $("#edit_jqxNotification").jqxNotification("open");
                process1 = false;
            }
        }


        var process2 = false;
        var SelCity = $("#city").jqxComboBox('getSelectedItem');
        var SelCityText = $("#city").val();
        if(SelCity){
            process2 = true;
        }else{
            if(SelCityText == ''){
                process2 = true;
            }else{
                $("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
                $("#edit_notificationContent").html("City does not exist");
                $("#edit_jqxNotification").jqxNotification("open");
                process2 = false;
            }
        }

        var process3 = false;
        var SelState = $("#state").jqxComboBox('getSelectedItem');
        var SelStateText = $("#state").val();
        if(SelState){
            process3 = true;
        }else{
            if(SelStateText == ''){
                process3 = true;
            }else{
                $("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
                $("#edit_notificationContent").html("State does not exist");
                $("#edit_jqxNotification").jqxNotification("open");
                process3 = false;
            }
        }

        var process4 = false;
        var SelIsland = $("#island").jqxComboBox('getSelectedItem');
        var SelIslandText = $("#island").val();
        if(SelIsland){
            process4 = true;
        }else{
            if(SelIslandText == ''){
                process4 = true;
            }else{
                $("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
                $("#edit_notificationContent").html("Island does not exist");
                $("#edit_jqxNotification").jqxNotification("open");
                process4 = false;
            }
        }

        var process5 = false;
        var SelCountry = $("#country").jqxComboBox('getSelectedItem');
        var SelCountryText = $("#country").val();
        if(SelCountry){
            process5 = true;
        }else{
            if(SelCountryText == ''){
                process5 = true;
            }else{
                $("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
                $("#edit_notificationContent").html("Country does not exist");
                $("#edit_jqxNotification").jqxNotification("open");
                process5 = false;
            }
        }

        var process7 = false;
        if($("#email").val() != ''){
            if(check_email($("#email").val())){
                $("#email").css({"border-color":"#ccc"});
                process7 = true;
            }else{
                $("#email").css({"border-color":"#F00"});
                process7 = false;
                $("#edit_email_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "mail" });
                $("#edit_email_notificationContent").html("Please type a valid email address");
                $("#edit_email_jqxNotification").jqxNotification("open");
            }
        }else{
            $("#email").css({"border-color":"#ccc"});
            process7 = true;
        }

        if(process1 == true && process2 == true && process3 == true && process4 == true && process5 == true && process6 == true && process7 == true){
            $.when(update_customer_info()).done(function () {
                $("#firstname").focus();
            });
        }else{
            $scope.$apply(function(){
                $scope.tabset = {};
            });
            $scope.$apply(function(){
                $scope.tabset = {
                    selectedItem: 0
                }
            });
        }
    });

    $("#_yes").click(function(){
        $('#edit_jqxNotification').jqxNotification('closeAll');
        var process6 = false;
        if($("#firstname").val() == ''){
            $("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
            $("#edit_notificationContent").html("First name is required field");
            $("#edit_jqxNotification").jqxNotification("open");
            $("#firstname").css({"border-color":"#f00"});
            process6 = false;
        }else{
            $("#firstname").css({"border-color":"#ccc"});
            process6 = true;
        }

        var process1 = false;
        var SelZipCode = $("#zipcode").jqxComboBox('getSelectedItem');
        var SelZipCodeText = $("#zipcode").val();
        if(SelZipCode){
            process1 = true;
        }else{
            if(SelZipCodeText == ''){
                process1 = true;
            }else{
                $("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true,  template: "error" });
                $("#edit_notificationContent").html("Zip code does not exist");
                $("#edit_jqxNotification").jqxNotification("open");
                process1 = false;
            }
        }

        var process2 = false;
        var SelCity = $("#city").jqxComboBox('getSelectedItem');
        var SelCityText = $("#city").val();
        if(SelCity){
            process2 = true;
        }else{
            if(SelCityText == ''){
                process2 = true;
            }else{
                $("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
                $("#edit_notificationContent").html("City does not exist");
                $("#edit_jqxNotification").jqxNotification("open");
                process2 = false;
            }
        }

        var process3 = false;
        var SelState = $("#state").jqxComboBox('getSelectedItem');
        var SelStateText = $("#state").val();
        if(SelState){
            process3 = true;
        }else{
            if(SelStateText == ''){
                process3 = true;
            }else{
                $("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
                $("#edit_notificationContent").html("State does not exist");
                $("#edit_jqxNotification").jqxNotification("open");
                process3 = false;
            }
        }

        var process4 = false;
        var SelIsland = $("#island").jqxComboBox('getSelectedItem');
        var SelIslandText = $("#island").val();
        if(SelIsland){
            process4 = true;
        }else{
            if(SelIslandText == ''){
                process4 = true;
            }else{
                $("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
                $("#edit_notificationContent").html("Island does not exist");
                $("#edit_jqxNotification").jqxNotification("open");
                process4 = false;
            }
        }

        var process5 = false;
        var SelCountry = $("#country").jqxComboBox('getSelectedItem');
        var SelCountryText = $("#country").val();
        if(SelCountry){
            process5 = true;
        }else{
            if(SelCountryText == ''){
                process5 = true;
            }else{
                $("#edit_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "error" });
                $("#edit_notificationContent").html("Country does not exist");
                $("#edit_jqxNotification").jqxNotification("open");
                process5 = false;
            }
        }

        var process7 = false;
        if($("#email").val() != ''){
            if(check_email($("#email").val())){
                $("#email").css({"border-color":"#ccc"});
                process7 = true;
            }else{
                $("#email").css({"border-color":"#F00"});
                process7 = false;
                $("#edit_email_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "mail" });
                $("#edit_email_notificationContent").html("Please type a valid email address");
                $("#edit_email_jqxNotification").jqxNotification("open");
            }
        }else{
            $("#email").css({"border-color":"#ccc"});
            process7 = true;
        }

        if(process1 == true && process2 == true && process3 == true && process4 == true && process5 == true && process6 == true && process7 == true){
            $.when(update_customer_info()).done(function(){
                $scope.gridSettings = {
                    source: {
                        dataType: "json",
                        dataFields: [
                            {name: 'Unique', type: 'int'},
                            {name: 'FirstName', type: 'string'},
                            {name: 'LastName', type: 'string'},
                            {name: 'Company', type: 'string'},
                            {name: 'Address1', type: 'string'},
                            {name: 'Address2', type: 'string'},
                            {name: 'City', type: 'string'},
                            {name: 'State', type: 'string'},
                            {name: 'Zip', type: 'string'},
                            {name: 'County', type: 'string'},
                            {name: 'Country', type: 'string'},
                            {name: 'Phone1', type: 'string'},
                            {name: 'Phone2', type: 'string'},
                            {name: 'Phone3', type: 'string'},
                            {name: 'Fax', type: 'string'},
                            {name: 'Email', type: 'string'},
                            {name: 'Website', type: 'string'},
                            {name: 'Custom1', type: 'string'},
                            {name: 'Custom2', type: 'string'},
                            {name: 'Custom3', type: 'string'},
                            {name: 'Note', type: 'string'}
                        ],
                        id: 'Unique',
                        url: SiteRoot + "backoffice/load_customer"
                    },
                    created: function (args) {
                        var instance = args.instance;
                        instance.updateBoundData();
                    }
                }
                dialog.close();
                $scope.$apply(function () {
                    $scope.tabset = {};
                });

                $scope.$apply(function () {
                    $scope.tabset = {
                        selectedItem: 0
                    }
                })
                setTimeout(function(){
                    $("#table input.jqx-input").focus();
                },500);
            });
        }else{
            $scope.$apply(function(){
                $scope.tabset = {};
            });
            $scope.$apply(function(){
                $scope.tabset = {
                    selectedItem: 0
                }
            });
        }
    });

    $("#_delete").click(function(){
        $("#tab1").block({message:null});
        $("#tab2").block({message:null});
        $("#tab3").block({message:null});
        var customerid = $("#customerid").val();
        var name = $("#firstname").val() + " " + $("#lastname").val();
        var company = $("#company").val();
        $("#_btnscd").hide();
        $("#msg_delete").show();
        $("#delmsg").text("Would you like to delete "+customerid+" "+name+" "+company+"?");
    });

    $("#_delyes").click(function(){
        $.when(delete_process()).then(function(){
            $("#_btnscd").show();
            $("#_restore").show();
            $("#_canceldeleted").show();
            $("#_cancel").hide();
            $("#_delete").hide();
        })
    });

    $("#_delno").click(function(){
        $("#tab1").block({message:null});
        $("#tab2").block({message:null});
        $("#tab3").block({message:null});
        var customerid = $("#customerid").val();
        $("#msg_delete").hide();
        $("#_btnscd").show();
        $("#delmsg").text("");
    });

    $("#_restore").click(function(){
        $.when(restore_process()).done(function(){
            $("#del_confirmation_msg").hide();
            //$("#delmymessage").html("");
            $("#_restore").hide();
            $("#_canceldeleted").hide();
            $("#_cancel").show();
            $("#_delete").show();
            $("#_delete").attr("disabled",false);
        })
    });

    $("#_canceldeleted").click(function(){
        $scope.$apply(function () {
            $("#table").jqxDataTable('updateBoundData');
            $("#_canceldeleted").hide();
            $("#_cancel").show();
            $("#_restore").hide();
            $("#_delete").show();
        })
        $scope.$apply(function () {
            $scope.tabset = {};
        });

        $scope.$apply(function () {
            $scope.tabset = {
                selectedItem: 0
            }
        })
        reset_form();
        dialog.close();
        setTimeout(function(){
            $("#table input.jqx-input").focus();
        },500);
    })


    $("#_addnew").on("click", function(){
        var DefaultZipCode = 0;
        $scope.addzipcode.apply('selectItem', DefaultZipCode);
        $.when(city(DefaultZipCode)).then(function(){
            $.when(state(DefaultZipCode)).then(function(){
                $.when(island(DefaultZipCode)).then(function(){
                    $.when(country(DefaultZipCode)).done(function(){
                        $scope.addisland.apply('selectItem', selisland);
                        $scope.addstate.apply('selectItem', selstate);
                        $scope.addcity.apply('selectItem', selcity);
                        $scope.addcountry.apply('selectItem', selcountry);
                        $("#addform_handler").show();
                        $("#ngxTabs1").unblock();

                        $scope.$apply(function(){
                            $scope.selectedItem = 0;
                        });

                        addialog.open();
                        add_reset_form();

                    })
                })
            })
        })

        addialog.open();
        add_reset_form();
    });


    $("#add_cancel").click(function(){
        $('#add_jqxNotification').jqxNotification('closeAll');
        $scope.$apply(function(){
            $scope.tabsSettings = {};
        });
        var addsavebtn = $("#add_save").is(":disabled");
        if(addsavebtn){
            add_reset_form();
            $scope.$apply(function(){
                addialog.close();
                $scope.tabsSettings = {
                    selectedItem: 0
                }
            });
            setTimeout(function(){
                $("#table input.jqx-input").focus();
            },500);
        }else{
            $("#add_msg").show();
            $("#add_btnscd").hide();
            var process6 = false;
            if($("#add_firstname").val() == ''){
                $("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
                $("#add_notificationContent").html("First name is required field");
                $("#add_jqxNotification").jqxNotification("open");
                $("#add_firstname").css({"border-color":"#f00"});
                process6 = false;
            }else{
                $("#add_firstname").css({"border-color":"#ccc"});
                process6 = true;
            }

            var process1 = false;
            var SelZipCode = $("#add_zip").jqxComboBox('getSelectedItem');
            var SelZipCodeText = $("#add_zip").val();
            if(SelZipCode){
                process1 = true;
            }else{
                if(SelZipCodeText == ''){
                    process1 = true;
                }else{
                    $("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true,  template: "error" });
                    $("#add_notificationContent").html("Zip code does not exist");
                    $("#add_jqxNotification").jqxNotification("open");
                    process1 = false;
                }
            }


            var process2 = false;
            var SelCity = $("#add_city").jqxComboBox('getSelectedItem');
            var SelCityText = $("#add_city").val();
            if(SelCity){
                process2 = true;
            }else{
                if(SelCityText == ''){
                    process2 = true;
                }else{
                    $("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
                    $("#add_notificationContent").html("City does not exist");
                    $("#add_jqxNotification").jqxNotification("open");
                    process2 = false;
                }
            }

            var process3 = false;
            var SelState = $("#add_state").jqxComboBox('getSelectedItem');
            var SelStateText = $("#add_state").val();
            if(SelState){
                process3 = true;
            }else{
                if(SelStateText == ''){
                    process3 = true;
                }else{
                    $("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
                    $("#add_notificationContent").html("State does not exist");
                    $("#add_jqxNotification").jqxNotification("open");
                    process3 = false;
                }
            }

            var process4 = false;
            var SelIsland = $("#add_island").jqxComboBox('getSelectedItem');
            var SelIslandText = $("#add_island").val();
            if(SelIsland){
                $(".add_sel_island_message").text('');
                process4 = true;
            }else{
                if(SelIslandText == ''){
                    process4 = true;
                }else{
                    $("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
                    $("#add_notificationContent").html("Island does not exist");
                    $("#add_jqxNotification").jqxNotification("open");
                    process4 = false;
                }
            }

            var process5 = false;
            var SelCountry = $("#add_country").jqxComboBox('getSelectedItem');
            var SelCountryText = $("#add_country").val();
            if(SelCountry){
                process5 = true;
            }else{
                if(SelCountryText == ''){
                    process5 = true;
                }else{
                    $("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
                    $("#add_notificationContent").html("Country does not exist");
                    $("#add_jqxNotification").jqxNotification("open");
                    process5 = false;
                }
            }

            if($("#add_email").val() != ''){
                if(check_email($("#add_email").val())){
                    $("#add_email").css({"border-color":"#ccc"});
                    process7 = true;
                }else{
                    $("#add_email").css({"border-color":"#F00"});
                    process7 = false;
                    $("#add_email_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "mail" });
                    $("#add_email_notificationContent").html("Please type a valid email address");
                    $("#add_email_jqxNotification").jqxNotification("open");
                }
            }else{
                $("#add_email").css({"border-color":"#ccc"});
                process7 = true;
            }

            if(process1 == true && process2 == true && process3 == true && process4 == true && process5 == true && process6 == true && process7 == true){
                $('#addtab1').block({message: null});
                $('#addtab2').block({message: null});
                $('#addtab3').block({message: null});

            }else{
                $scope.$apply(function(){
                    $scope.tabsSettings = {};
                });
                $scope.$apply(function(){
                    $scope.tabsSettings = {
                        selectedItem: 0
                    }
                });
            }
        }
    });

    $("#add_save").click(function(){
        $('#add_jqxNotification').jqxNotification('closeAll');
        var process6 = false;
        if($("#add_firstname").val() == ''){
            $("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
            $("#add_notificationContent").html("First name is required field");
            $("#add_jqxNotification").jqxNotification("open");
            $("#add_firstname").css({"border-color":"#f00"});
            process6 = false;
        }else{
            $("#add_firstname").css({"border-color":"#ccc"});
            process6 = true;
        }

        var process1 = false;
        var SelZipCode = $("#add_zip").jqxComboBox('getSelectedItem');
        var SelZipCodeText = $("#add_zip").val();
        if(SelZipCode){
            process1 = true;
        }else{
            if(SelZipCodeText == ''){
                process1 = true;
            }else{
                $("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true,  template: "error" });
                $("#add_notificationContent").html("Zip code does not exist");
                $("#add_jqxNotification").jqxNotification("open");
                process1 = false;
            }
        }


        var process2 = false;
        var SelCity = $("#add_city").jqxComboBox('getSelectedItem');
        var SelCityText = $("#add_city").val();
        if(SelCity){
            process2 = true;
        }else{
            if(SelCityText == ''){
                process2 = true;
            }else{
                $("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
                $("#add_notificationContent").html("City does not exist");
                $("#add_jqxNotification").jqxNotification("open");
                process2 = false;
            }
        }

        var process3 = false;
        var SelState = $("#add_state").jqxComboBox('getSelectedItem');
        var SelStateText = $("#add_state").val();
        if(SelState){
            process3 = true;
        }else{
            if(SelStateText == ''){
                process3 = true;
            }else{
                $("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
                $("#add_notificationContent").html("State does not exist");
                $("#add_jqxNotification").jqxNotification("open");
                process3 = false;
            }
        }

        var process4 = false;
        var SelIsland = $("#add_island").jqxComboBox('getSelectedItem');
        var SelIslandText = $("#add_island").val();
        if(SelIsland){
            process4 = true;
        }else{
            if(SelIslandText == ''){
                process4 = true;
            }else{
                $("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
                $("#add_notificationContent").html("Island does not exist");
                $("#add_jqxNotification").jqxNotification("open");
                process4 = false;
            }
        }

        var process5 = false;
        var SelCountry = $("#add_country").jqxComboBox('getSelectedItem');
        var SelCountryText = $("#add_country").val();
        if(SelCountry){
            process5 = true;
        }else{
            if(SelCountryText == ''){
                process5 = true;
            }else{
                $("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "error" });
                $("#add_notificationContent").html("Country does not exist");
                $("#add_jqxNotification").jqxNotification("open");
                process5 = false;
            }
        }

        var process7 = false;
        if($("#add_email").val() != ''){
            if(check_email($("#add_email").val())){
                $("#add_email").css({"border-color":"#ccc"});
                process7 = true;
            }else{
                $("#add_email").css({"border-color":"#F00"});
                process7 = false;
                $("#add_email_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "mail" });
                $("#add_email_notificationContent").html("Please type a valid email address");
                $("#add_email_jqxNotification").jqxNotification("open");
            }
        }else{
            $("#add_email").css({"border-color":"#ccc"});
            process7 = true;
        }


        if(process1 == true && process2 == true && process3 == true && process4 == true && process5 == true && process6 == true && process7 == true){
            $.when(add_customer_info()).done(function(){
                $scope.$apply(function(){
                    $scope.tabsSettings = {};
                });
                $scope.$apply(function(){
                    $scope.tabsSettings = {
                        selectedItem: 0
                    }
                })
                $("#add_save_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "success" });
                $("#add_save_notificationContent").html("New Customer Saved.");
                $("#add_save_jqxNotification").jqxNotification("open");
            })
        }else{
            $scope.$apply(function(){
                $scope.tabsSettings = {};
            });
            $scope.$apply(function(){
                $scope.tabsSettings = {
                    selectedItem: 0
                }
            })
        }
    });

    $("#add_aftersave_yes").click(function(){
        add_reset_form();
        $scope.$apply(function(){
            $scope.tabsSettings = {};
        });
        $scope.$apply(function(){
            $scope.tabsSettings = {
                selectedItem: 0
            }
        });
        $scope.gridSettings = {
            source: {
                dataType: "json",
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'FirstName', type: 'string'},
                    {name: 'LastName', type: 'string'},
                    {name: 'Company', type: 'string'},
                    {name: 'Address1', type: 'string'},
                    {name: 'Address2', type: 'string'},
                    {name: 'City', type: 'string'},
                    {name: 'State', type: 'string'},
                    {name: 'Zip', type: 'string'},
                    {name: 'County', type: 'string'},
                    {name: 'Country', type: 'string'},
                    {name: 'Phone1', type: 'string'},
                    {name: 'Phone2', type: 'string'},
                    {name: 'Phone3', type: 'string'},
                    {name: 'Fax', type: 'string'},
                    {name: 'Email', type: 'string'},
                    {name: 'Website', type: 'string'},
                    {name: 'Custom1', type: 'string'},
                    {name: 'Custom2', type: 'string'},
                    {name: 'Custom3', type: 'string'},
                    {name: 'Note', type: 'string'}
                ],
                id: 'Unique',
                url: SiteRoot + "backoffice/load_customer"
            },
            created: function (args) {
                var instance = args.instance;
                instance.updateBoundData();
            }
        }

        $("#add_confirmation_after_save").hide();
        $("#addsavedmymessage").html("");
        $("#add_btnscd").show();
        $("#add_save").attr("disabled", true);
        $('#addtab1').unblock();
        $('#addtab2').unblock();
        $('#addtab3').unblock();
    });

    $("#add_aftersave_no").click(function(){
        add_reset_form();
        $('#addtab1').unblock();
        $('#addtab2').unblock();
        $('#addtab3').unblock();
        $scope.$apply(function(){
            $scope.tabsSettings = {};
        });
        $scope.$apply(function(){
            $scope.tabsSettings = {
                selectedItem: 0
            }
        });
        $scope.gridSettings.disabled = false;
        addialog.close();
        $scope.$apply(function(){
            $scope.gridSettings = {
                created: function(args)
                {
                    grid = args.instance;
                },
                source:  {
                    dataType: "json",
                    dataFields: [
                        { name: 'Unique', type : 'int' },
                        { name: 'FirstName', type: 'string'},
                        { name: 'LastName', type: 'string' },
                        { name: 'Company', type: 'string'},
                        { name: 'Address1', type: 'string'},
                        { name: 'Address2', type: 'string'},
                        { name: 'City', type: 'string'},
                        { name: 'State', type: 'string'},
                        { name: 'Zip', type: 'string'},
                        { name: 'County', type: 'string'},
                        { name: 'Country', type: 'string'},
                        { name: 'Phone1', type: 'string'},
                        { name: 'Phone2', type: 'string'},
                        { name: 'Phone3', type: 'string'},
                        { name: 'Fax', type: 'string'},
                        { name: 'Email', type: 'string'},
                        { name: 'Website', type: 'string'},
                        { name: 'Custom1', type: 'string'},
                        { name: 'Custom2', type: 'string'},
                        { name: 'Custom3', type: 'string'},
                        { name: 'Note', type: 'string'}
                    ],
                    id: 'Unique',
                    url: SiteRoot+"backoffice/load_customer"
                },
                created: function (args) {
                    var instance = args.instance;
                    instance.updateBoundData();
                }
            }
        });
        $("#add_confirmation_after_save").hide();
        setTimeout(function(){
            $("#table input.jqx-input").focus();
        },500);
    });


    $("#add_yes").click(function(){
        var process6 = false;
        if($("#add_firstname").val() == ''){
            $("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "info" });
            $("#add_notificationContent").html("First name is required field");
            $("#add_jqxNotification").jqxNotification("open");
            $("#add_firstname").css({"border-color":"#f00"});
            process6 = false;
        }else{
            $("#add_firstname").css({"border-color":"#ccc"});
            process6 = true;
        }

        var process1 = false;
        var SelZipCode = $("#add_zip").jqxComboBox('getSelectedItem');
        var SelZipCodeText = $("#add_zip").val();
        if(SelZipCode){
            process1 = true;
        }else{
            if(SelZipCodeText == ''){
                process1 = true;
            }else{
                $("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true,  template: "info" });
                $("#add_notificationContent").html("Zip code does not exist");
                $("#add_jqxNotification").jqxNotification("open");
                process1 = false;
            }
        }


        var process2 = false;
        var SelCity = $("#add_city").jqxComboBox('getSelectedItem');
        var SelCityText = $("#add_city").val();
        if(SelCity){
            process2 = true;
        }else{
            if(SelCityText == ''){
                process2 = true;
            }else{
                $("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "info" });
                $("#add_notificationContent").html("City does not exist");
                $("#add_jqxNotification").jqxNotification("open");
                process2 = false;
            }
        }

        var process3 = false;
        var SelState = $("#add_state").jqxComboBox('getSelectedItem');
        var SelStateText = $("#add_state").val();
        if(SelState){
            process3 = true;
        }else{
            if(SelStateText == ''){
                process3 = true;
            }else{
                $("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "info" });
                $("#add_notificationContent").html("State does not exist");
                $("#add_jqxNotification").jqxNotification("open");
                process3 = false;
            }
        }

        var process4 = false;
        var SelIsland = $("#add_island").jqxComboBox('getSelectedItem');
        var SelIslandText = $("#add_island").val();
        if(SelIsland){
            process4 = true;
        }else{
            if(SelIslandText == ''){
                process4 = true;
            }else{
                $("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "info" });
                $("#add_notificationContent").html("Island does not exist");
                $("#add_jqxNotification").jqxNotification("open");
                process4 = false;
            }
        }

        var process5 = false;
        var SelCountry = $("#add_country").jqxComboBox('getSelectedItem');
        var SelCountryText = $("#add_country").val();
        if(SelCountry){
            process5 = true;
        }else{
            if(SelCountryText == ''){
                process5 = true;
            }else{
                $("#add_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "info" });
                $("#add_notificationContent").html("Country does not exist");
                $("#add_jqxNotification").jqxNotification("open");
                process5 = false;
            }
        }

        var process7 = false;
        if($("#add_email").val() != ''){
            if(check_email($("#add_email").val())){
                $("#add_email").css({"border-color":"#ccc"});
                process7 = true;
            }else{
                $("#add_email").css({"border-color":"#f00"});
                process7 = false;
                $("#add_email_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "email" });
                $("#add_email_notificationContent").html("Please type a valid email address");
                $("#add_email_jqxNotification").jqxNotification("open");
            }
        }else{
            $("#add_email").css({"border-color":"#ccc"});
            process7 = true;
        }

        if(process1 == true && process2 == true && process3 == true && process4 == true && process5 == true && process6 == true && process7 == true){
            $.when(add_customer_info()).done(function(){
                $scope.$apply(function(){
                    $scope.tabsSettings = {};
                });
                $scope.$apply(function(){
                    $scope.tabsSettings = {
                        selectedItem: 0
                    }
                })
                $('#addtab1').unblock();
                $('#addtab2').unblock();
                $('#addtab3').unblock();
                $("#add_save_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#add_container", opacity: 0.9, autoClose: true, template: "success" });
                $("#add_save_notificationContent").html("New Customer Saved.");
                $("#add_save_jqxNotification").jqxNotification("open");

                setTimeout(function(){
                    $("#table input.jqx-input").focus();
                },500);
            });
            $("#add_btnscd").hide();
            $("#add_msg").hide();
        }
    });

    $("#add_no").click(function(){
        $scope.$apply(function(){
            $scope.tabsSettings = {};
        });
        $scope.$apply(function(){
            $scope.tabsSettings = {
                selectedItem: 0
            }
        });
        $('#addtab1').unblock();
        $('#addtab2').unblock();
        $('#addtab3').unblock();
        add_reset_form();
        addialog.close();
        $scope.$apply(function(){
            $scope.gridSettings = {
                created: function(args)
                {
                    grid = args.instance;
                },
                source:  {
                    dataType: "json",
                    dataFields: [
                        { name: 'Unique', type : 'int' },
                        { name: 'FirstName', type: 'string'},
                        { name: 'LastName', type: 'string' },
                        { name: 'Company', type: 'string'},
                        { name: 'Address1', type: 'string'},
                        { name: 'Address2', type: 'string'},
                        { name: 'City', type: 'string'},
                        { name: 'State', type: 'string'},
                        { name: 'Zip', type: 'string'},
                        { name: 'County', type: 'string'},
                        { name: 'Country', type: 'string'},
                        { name: 'Phone1', type: 'string'},
                        { name: 'Phone2', type: 'string'},
                        { name: 'Phone3', type: 'string'},
                        { name: 'Fax', type: 'string'},
                        { name: 'Email', type: 'string'},
                        { name: 'Website', type: 'string'},
                        { name: 'Custom1', type: 'string'},
                        { name: 'Custom2', type: 'string'},
                        { name: 'Custom3', type: 'string'},
                        { name: 'Note', type: 'string'}
                    ],
                    id: 'Unique',
                    url: SiteRoot+"backoffice/load_customer"
                },
                created: function (args) {
                    var instance = args.instance;
                    instance.updateBoundData();
                }
            }
        })
        setTimeout(function(){
            $("#table input.jqx-input").focus();
        },500);
    });

    $("#add_conf_cancel").click(function(){
        $scope.$apply(function(){
            $scope.tabsSettings = {};
        });
        $scope.$apply(function(){
            $scope.tabsSettings = {
                selectedItem: 0
            }
        });
        $("#add_msg").hide();
        $("#add_btnscd").show();
        $('#addtab1').unblock();
        $('#addtab2').unblock();
        $('#addtab3').unblock();
        $("#add_firstname").focus();
    });

//###############################################################################################################################################################//
    //# Load Customer List #//

    $scope.thetabs = 'darkblue';
    $scope.thetabsadd = 'darkblue';

    $scope.tabset = {
        selectedItem:0
    };
    $scope.tabsSettings = {
        selectedItem:0
    };

    var jqxWidget = $('.add_customer_form');
    var offset = jqxWidget.offset();

    $scope.gridSettings ={
        created: function(args)
        {
            grid = args.instance;
        },
        source:  {
            dataType: "json",
            dataFields: [
                { name: 'Unique', type : 'int' },
                { name: 'FirstName', type: 'string'},
                { name: 'LastName', type: 'string' },
                { name: 'Company', type: 'string'},
                { name: 'Address1', type: 'string'},
                { name: 'Address2', type: 'string'},
                { name: 'City', type: 'string'},
                { name: 'State', type: 'string'},
                { name: 'Zip', type: 'string'},
                { name: 'County', type: 'string'},
                { name: 'Country', type: 'string'},
                { name: 'Phone1', type: 'string'},
                { name: 'Phone2', type: 'string'},
                { name: 'Phone3', type: 'string'},
                { name: 'Fax', type: 'string'},
                { name: 'Email', type: 'string'},
                { name: 'Website', type: 'string'},
                { name: 'Custom1', type: 'string'},
                { name: 'Custom2', type: 'string'},
                { name: 'Custom3', type: 'string'},
                { name: 'Note', type: 'string'}
            ],
            id: 'Unique',
            url: SiteRoot+"backoffice/load_customer"
        },
        columnsResize: true,
        width: "99.7%",
        theme: 'arctic',
        sortable: true,
        pageable: true,
        pageSize: 15,
        pagerMode: 'default',
        altRows: true,
        filterable: true,
        filterMode: 'simple',
        ready: function () {

        },
        columns: [
            { text: 'ID', dataField: 'Unique', width: "5%" },
            { text: 'First Name', dataField: 'FirstName', width: "8%" },
            { text: 'Last Name', dataField: 'LastName', width: '8%' },
            { text: 'Company', dataField: 'Company', width: '15%' },
            { text: 'Address1', dataField: 'Address1', width: '17%' },
            { text: 'Address2', dataField: 'Address2', hidden: true },
            { text: 'City', dataField: 'City', width: '9%' },
            { text: 'State', dataField: 'State', width: '6%'},
            { text: 'Zip', dataField: 'Zip', width: '8%'},
            { text: 'County', dataField: 'County', hidden: true },
            { text: 'Country', dataField: 'Country', hidden: true },
            { text: 'Phone', dataField: 'Phone1', width: '8%' },
            { text: 'Phone2', dataField: 'Phone2', hidden: true },
            { text: 'Phone3', dataField: 'Phone3', hidden: true },
            { text: 'E-mail', dataField: 'Email', width: '16%' },
            { text: 'Fax', dataField: 'Fax',hidden: true },
            { text: 'Website', dataField: 'Website', hidden: true},
            { text: 'Custom1', dataField: 'Custom1', hidden: true},
            { text: 'Custom2', dataField: 'Custom2', hidden: true},
            { text: 'Custom3', dataField: 'Custom3', hidden: true},
            { text: 'Note', dataField: 'Note', hidden: true}

        ]
    };

//###############################################################################################################################################################//
    /* Row RowDoubleClick */
    $scope.rowDoubleClick = function (event) {
        var args = event.args;
        var index = args.index;
        var row = args.row;
        var item = '';

        dialog.setTitle("Customer ID: " + row.Unique + " | " + row.FirstName+ " "+row.LastName);
        editRow = index;
        $("#customerid").val(row.Unique);
        $("#firstname").val(row.FirstName);
        $("#lastname").val(row.LastName);
        $("#company").val(row.Company);
        $("#address1").val(row.Address1);
        $("#address2").val(row.Address2);

        $("#zipcode").jqxComboBox('selectItem', row.Zip);

        $("#phone1").val(row.Phone1);
        $("#phone2").val(row.Phone2);
        $("#phone3").val(row.Phone3);
        $("#email").val(row.Email);
        $("#fax").val(row.Fax);
        $("#website").val(row.Website);
        $("#custom1").val(row.Custom1);
        $("#custom2").val(row.Custom2);
        $("#custom3").val(row.Custom3);
        $("#note").val(row.Note);

        global_custid = row.Unique;
        global_custname = row.FirstName+" "+row.LastName;
        selzipcode = row.Zip;
        selcity = row.City;
        selstate = row.State;
        selcountry = row.Country;
        selcounty = row.island;

        setTimeout(function(){
            $("#city").jqxComboBox('selectItem', row.City);
            $("#state").jqxComboBox('selectItem', row.State);
            $("#country").jqxComboBox('selectItem', row.Country);
            $("#island").jqxComboBox('selectItem', row.County);
            $("#_update").prop("disabled", true);
            dialog.open();
        },500);


        setTimeout(function(){
            $("#firstname").focus();
        }, 200);
    };

//#########################################################################################################################################################//
    /*@@ City Drop Down @@*/
    $scope.addcity = {selectedIndex: 0, source: citiesDataAdapter, displayMember: "City", valueMember: "City", width: "99%", height: 25};
    $scope.placeHolderaddcity = "Select City";
    $("#add_city").on("select", function(event){
        if(event.args){
            var item = event.args.item;
            if (item) {
                selcity = item.value;
                $("#add_save").prop("disabled", false);
                $("#add_city").on('keydown', function(event){
                    if(event.keyCode == 8 || event.keyCode == 46){
                        $("#add_city").jqxComboBox('clearSelection');
                        selcity = null;
                        $("#add_save").prop("disabled", false);
                    }
                })
            }
        }
    })

    $scope.city = {selectedIndex: 0, source: citiesDataAdapter, displayMember: "City", valueMember: "City", width: "99%", height: 25};
    $scope.placeHoldercity = "Select City";
    $("#city").on("select", function(event){
        if(event.args){
            var item = event.args.item;
            if (item) {
                selcity = item.value;
                $("#_update").prop("disabled", false);
                $("#city").on('keydown', function(event){
                    if(event.keyCode == 8 || event.keyCode == 46){
                        $("#city").jqxComboBox('clearSelection');
                        selcity = null;
                        $("#_update").prop("disabled", false);
                    }
                })
            }
        }
    })
//#########################################################################################################################################################//
    /*@@ Island Drop Down @@*/
    $scope.addisland = {selectedIndex: 0, source: islandDataAdapter, displayMember: "Island", valueMember: "County", width: "99%", height: 25};
    $scope.placeHolderaddisland = "Select Island";
    $("#add_island").on("select", function(event){
        if(event.args){
            var item = event.args.item;
            if (item) {
                selisland = item.value;
                $("#add_save").prop("disabled", false);
                $("#add_island").on('keydown', function(event){
                    if(event.keyCode == 8 || event.keyCode == 46){
                        $("#add_island").jqxComboBox('clearSelection');
                        selisland = null;
                        $("#add_save").prop("disabled", false);
                    }
                })
            }
        }
    })


    $scope.island = {selectedIndex: 0, source: islandDataAdapter, displayMember: "Island", valueMember: "County", width: "99%", height: 25};
    $scope.placeHolderisland = "Select Island";
    $("#island").on("select", function(event){
        if(event.args){
            var item = event.args.item;
            if (item) {
                selisland = item.value;
                $("#_update").prop("disabled", false);
                $("#island").on('keydown', function(event){
                    if(event.keyCode == 8 || event.keyCode == 46){
                        $("#island").jqxComboBox('clearSelection');
                        selisland = null;
                        $("#_update").prop("disabled", false);
                    }
                })
            }
        }
    })

//#########################################################################################################################################################//
    /*@@ State Drop Down @@*/
    $scope.addstate = {selectedIndex: 0, source: statesDataAdapter, displayMember: "State", valueMember: "StateID", width: "99%", height: 25};
    $scope.placeHolderaddstate = "Select State";
    $("#add_state").on("select", function(event){
        if(event.args){
            var item = event.args.item;
            if (item) {
                selstate = item.value;
                $("#add_save").prop("disabled", false);
                $("#add_state").on('keydown', function(event){
                    if(event.keyCode == 8 || event.keyCode == 46){
                        $("#add_state").jqxComboBox('clearSelection');
                        selstate = null;
                        $("#add_save").prop("disabled", false);
                    }
                })
            }
        }
    })

    $scope.state = {selectedIndex: 0, source: statesDataAdapter, displayMember: "State", valueMember: "StateID", width: "99%", height: 25};
    $scope.placeHolderstate = "Select State";
    $("#state").on("select", function(event){
        if(event.args){
            var item = event.args.item;
            if (item) {
                selstate = item.value;
                $("#_update").prop("disabled", false);
                $("#state").on('keydown', function(event){
                    if(event.keyCode == 8 || event.keyCode == 46){
                        $("#state").jqxComboBox('clearSelection');
                        selstate = null;
                        $("#_update").prop("disabled", false);
                    }
                })
            }
        }
    })
//#########################################################################################################################################################//
    /*@@ Zip Code Drop Down @@*/
    $scope.addzipcode = { selectedIndex: 0, source: zipcodesDataAdapter, displayMember: "ZipCode", valueMember: "ZipCode", width: "99%", height: 25};
    $scope.placeHolderaddzipcode = "Select Zip Code";
    $("#add_zip").on("select", function(event){
        if(event.args){
            var item = event.args.item;
            if (item) {
                $.when(city(item.value)).then(function(){
                    $scope.addcity.apply('selectItem', selcity);
                    $.when(state(item.value)).then(function(){
                        $scope.addstate.apply('selectItem', selstate);
                        $.when(island(item.value)).then(function(){
                            $scope.addisland.apply('selectItem', selisland);
                            $.when(country(item.value)).done(function(){
                                $scope.addcountry.apply('selectItem', selcountry);
                                $("#add_save").prop("disabled", false);
                            })
                        })
                    })
                })
                $("#add_zip").on('keydown', function(event){
                    if(event.keyCode == 8 || event.keyCode == 46){
                        $("#add_zip").jqxComboBox('clearSelection');
                        selzipcode = null;
                        $("#add_save").prop("disabled", false);
                    }
                })
            }
        }
    })

    $scope.zipcode = {selectedIndex: 0, source: zipcodesDataAdapter, displayMember: "ZipCode", valueMember: "ZipCode", width: "99%", height: 25};
    $scope.placeHolderzipcode = "Select Zip Code";
    $("#zipcode").on("select", function(event){
        if(event.args){
            item = event.args.item;
            if (item) {
                $.when(city(item.value)).then(function(){
                    $scope.city.apply('selectItem', selcity);
                    $.when(state(item.value)).then(function(){
                        $scope.state.apply('selectItem', selstate);
                        $.when(island(item.value)).then(function(){
                            $scope.island.apply('selectItem', selisland);
                            $.when(country(item.value)).done(function(){
                                $scope.country.apply('selectItem', selcountry);
                                $("#_update").prop("disabled", false);
                            })
                        })
                    })
                })
                $("#zipcode").on('keydown', function(event){
                    if(event.keyCode == 8 || event.keyCode == 46){
                        $("#zipcode").jqxComboBox('clearSelection');
                        selzipcode = null;
                        $("#_update").prop("disabled", false);
                    }
                })
            }
        }
    })

//#########################################################################################################################################################//
    /*@@ Country Drop Down @@*/
    $scope.addcountry = { selectedIndex: 0, source: countriesDataAdapter, displayMember: "CountryName", valueMember: "CountryCode", width: "99%", height: 25};
    $scope.placeHolderaddcountry = "Select Country";
    $("#add_country").on("select", function(event){
        if(event.args){
            var item = event.args.item;
            if (item) {
                selcountry = args.item.value;
                $("#add_country").on('keydown', function(event){
                    if(event.keyCode == 8 || event.keyCode == 46){
                        $("#add_country").jqxComboBox('clearSelection');
                        selcountry = null;
                    }
                })
            }
        }
    })

    $scope.country = {selectedIndex: 0, source: countriesDataAdapter, displayMember: "CountryName", valueMember: "CountryCode", width: "99%", height: 25};
    $scope.placeHoldercountry = "Select Country";
    $("#country").on("select", function(event){
        if(event.args){
            var item = event.args.item;
            if (item) {
                selcountry = args.item.value;
                $("#country").on('keydown', function(event){
                    if(event.keyCode == 8 || event.keyCode == 46){
                        $("#country").jqxComboBox('clearSelection');
                        selcountry = null;
                    }
                })
            }
        }
    })

//#########################################################################################################################################################//
});
/*End Angular Conroller*/

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
    global_custid=null;
    global_custname=null;
    selzipcode=null;
    selzipunique=null;
    selcity=null;
    selstate=null;
    selisland=null;
    selcountry=null;
    $("#firstname").val("");
    $("#lastname").val("");
    $("#company").val("");
    $("#address1").val("");
    $("#address2").val("");
    $("#zipcode").jqxComboBox('clearSelection');
    $("#city").jqxComboBox('clearSelection');
    $("#state").jqxComboBox('clearSelection');
    $("#country").jqxComboBox('clearSelection');
    $("#island").jqxComboBox('clearSelection');
    $("#phone1").val("");
    $("#phone2").val("");
    $("#phone3").val("");
    $("#email").val("");
    $("#fax").val("");
    $("#website").val("");
    $("#custom1").val("");
    $("#custom2").val("");
    $("#custom3").val("");
    $("#edit_email_message").text("");
    $(".edit_searchclear").hide();
    $("#note").val("");
    $('#tab1').unblock();
    $('#tab2').unblock();
    $("#tab3").unblock();
    $("#msg").hide();
    $("#_btnscd").show();
    $("#_update").attr("disabled",true);
    $("#_delete").attr("disabled",false);
    $("#_restore").hide();
    $("#_delete").show();
    setTimeout(function(){
        $("#firstname").focus();
    }, 200);

}

function update_customer_info(){
    var updatedefer = $.Deferred();
    var customerid = $("#customerid").val();
    var fname = FilterCharacters($("#firstname").val());
    var lname = FilterCharacters($("#lastname").val());
    var company = FilterCharacters($("#company").val());
    var address1 = FilterCharacters($("#address1").val());
    var address2 = FilterCharacters($("#address2").val());
    var city = FilterCharacters(selcity);
    var state = FilterCharacters(selstate);
    var zip = selzipcode;
    var country = FilterCharacters(selcountry);
    var county = FilterCharacters(selisland);
    var phone1 = $("#phone1").val();
    var phone2 = $("#phone2").val();
    var phone3 = $("#phone3").val();
    var email = $("#email").val();
    var fax = $("#fax").val();
    var website = FilterCharacters($("#website").val());
    var custom1 = FilterCharacters($("#custom1").val());
    var custom2 = FilterCharacters($("#custom2").val());
    var custom3 = FilterCharacters($("#custom3").val());
    var note = FilterCharacters($("#note").val());

    var post_data="customerid="+customerid;
    post_data+="&fname="+fname;
    post_data+="&lname="+lname;
    post_data+="&company="+company;
    post_data+="&address1="+address1;
    post_data+="&address2="+address2;
    post_data+="&city="+city;
    post_data+="&state="+state;
    post_data+="&county="+county;
    post_data+="&zip="+zip;
    post_data+="&country="+country;
    post_data+="&phone1="+phone1;
    post_data+="&phone2="+phone2;
    post_data+="&phone3="+phone3;
    post_data+="&email="+email;
    post_data+="&fax="+fax;
    post_data+="&website="+website;
    post_data+="&custom1="+custom1;
    post_data+="&custom2="+custom2;
    post_data+="&custom3="+custom3;
    post_data+="&note="+note;

    /*
     if(fname == ''){
     var elementStr = $("#message").text("");
     $("#message").text("Please fill out all required field.");
     $("#message").css({"color":"#F00"});
     confirmation_message();
     }else{
     if(email != ''){
     if(check_email(email)){
     update_customert_info_save(post_data);
     $("#edit_email_message").text("");
     console.log("email approved");
     }else{
     console.log("email invalid");
     $("#edit_email_message").text("Please type a valid email address.");
     confirmation_message();
     }
     }else{
     update_customert_info_save(post_data);
     }
     }
     */
    update_customert_info_save(post_data);
}

function update_customert_info_save(data){
    var updatecustDefer = $.Deferred();
    $.ajax({
        url: SiteRoot+'backoffice/update_customer_info',
        type: 'post',
        data: data,
        dataType: 'json',
        success: function(data){
            if(data.success){
                //$("#message").text("Customer Profile Updated.");
                $("#_update").attr("disabled", true);
                //$("#message").fadeIn();
                //$("#message").css({"color":"#5cb85c"});
                //confirmation_message();
            }
            $("#table").jqxDataTable('updateBoundData');
            $("#msg").hide();
            $("#_btnscd").show();
            $('#tab1').unblock();
            $('#tab2').unblock();
            $('#tab3').unblock();
            //dialog.close();
            updatecustDefer.resolve();
        },
        error: function(){
            updatecustDefer.reject();
            alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
        }
    });
    return updatecustDefer.promise();
}


function delete_process(){
    var deferdeleteitem = $.Deferred();

    var customerid = $("#customerid").val();
    var name = $("#firstname").val() + " " + $("#lastname").val();
    var company = $("#company").val();

    $.ajax({
        url: SiteRoot+"backoffice/customerdelete",
        type: "post",
        data: {custid : customerid},
        dataType:"json",
        success: function(data){
            if(data.success == true){
                $("#msg_delete").hide();
                //$("#message").text("Customer Information Deleted.");
                //$("#message").text(global_custid+" "+global_custname+" "+"marked for deletion. To finalize deletion, select CLOSE or select RESTORE to undo");
                //$("#message").fadeIn();
                //$("#message").css({"color":"#F00"});
                //confirmation_message();
                $("#edit_delete_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "info" });
                $('#edit_delete_jqxNotification').jqxNotification({ autoCloseDelay: 3000 });
                $("#edit_delete_notificationContent").html(global_custid+" "+global_custname+" "+"marked for deletion. To finalize deletion, select CLOSE or select RESTORE to undo");
                $("#edit_delete_jqxNotification").jqxNotification("open");
            }
            deferdeleteitem.resolve();
        },
        error: function(){
            deferdeleteitem.reject();
            alert("Sorry, we encoutered a technical difficulties\nPlease try again later.");
        }
    });
    return deferdeleteitem.promise();
}

function restore_process(){
    var restoredefer = $.Deferred();
    var customerid = $("#customerid").val();
    $.ajax({
        url: SiteRoot+"backoffice/customerrestore",
        type: "post",
        data: {custid : customerid},
        dataType:"json",
        success: function(data){
            if(data.success == true){
                //$("#message").text("Customer Information Restored.");
                //$("#message").fadeIn();
                //$("#message").css({"color":"#5cb85c"});
                //confirmation_message();
                $("#edit_restore_jqxNotification").jqxNotification({ width: "100%", appendContainer: "#edit_container", opacity: 0.9, autoClose: true, template: "info" });
                $('#edit_restore_jqxNotification').jqxNotification({ autoCloseDelay: 2000 });
                $("#edit_restore_notificationContent").html("Customer Data Restored");
                $("#edit_restore_jqxNotification").jqxNotification("open");
            }
            restoredefer.resolve();
        },
        error: function(){
            alert("Sorry, we encoutered a technical difficulties\nPlease try again later.");
        }
    });
    return restoredefer.promise();
}


function add_customer_info(){
    var fname = FilterCharacters($("#add_firstname").val());
    var lname = FilterCharacters($("#add_lastname").val());
    var company = FilterCharacters($("#add_company").val());
    var address1 = FilterCharacters($("#add_address1").val());
    var address2 = FilterCharacters($("#add_address2").val());
    var city = FilterCharacters(selcity);
    var state = FilterCharacters(selstate);
    var zip = selzipcode;
    var country = FilterCharacters(selcountry);
    var county = FilterCharacters(selisland);
    var phone1 = $("#add_phone1").val();
    var phone2 = $("#add_phone2").val();
    var phone3 = $("#add_phone3").val();
    var email = $("#add_email").val();
    var fax = $("#add_fax").val();
    var website = FilterCharacters($("#add_website").val());
    var custom1 = FilterCharacters($("#add_custom1").val());
    var custom2 = FilterCharacters($("#add_custom2").val());
    var custom3 = FilterCharacters($("#add_custom3").val());
    var note = FilterCharacters($("#add_note").val());

    var	post_data="&fname="+fname;
    post_data+="&lname="+lname;
    post_data+="&company="+company;
    post_data+="&address1="+address1;
    post_data+="&address2="+address2;
    post_data+="&city="+city;
    post_data+="&state="+state;
    post_data+="&zip="+zip;
    post_data+="&country="+country;
    post_data+="&county="+county;
    post_data+="&phone1="+phone1;
    post_data+="&phone2="+phone2;
    post_data+="&phone3="+phone3;
    post_data+="&email="+email;
    post_data+="&fax="+fax;
    post_data+="&website="+website;
    post_data+="&custom1="+custom1;
    post_data+="&custom2="+custom2;
    post_data+="&custom3="+custom3;
    post_data+="&note="+note;
    post_data+="&status=1";

    add_customer_info_save(post_data);
}

function add_customer_info_save(data){
    var adddefer = $.Deferred();
    $.ajax({
        url: SiteRoot+'backoffice/add_customer_info',
        type: 'post',
        data: data,
        dataType: 'json',
        success: function(data){
            if(data.success){
                $("#add_btnscd").hide();
                $("#addsavedmymessage").html("Do you want to add another new customer?");
                $("#add_confirmation_after_save").show();
                //$("#addtab1 #addtab2 #addtab3").block({message: null});
                $('#addtab1').block({message: null});
                $('#addtab2').block({message: null});
                $('#addtab3').block({message: null});
                //$("#add_message").text("New Customer information saved.");
                //$("#add_message").css({"color":"#5cb85c"});
                //$("#add_message").hide();
                confirmation_message();
            }
            adddefer.resolve();
        },
        error: function(){
            adddefer.reject();
            alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
        }
    });
    return adddefer.promise();
}

function add_reset_form(){
    selzipcode=null;
    selzipunique=null;
    selcity=null;
    selstate=null;
    selisland=null;
    selcountry=null;
    $("#add_firstname").val("");
    $("#add_firstname").css({"border-color":"#ccc"});
    $("#add_lastname").val("");
    $("#add_company").val("");
    $("#add_address1").val("");
    $("#add_address2").val("");
    $("#add_zip").jqxComboBox('clearSelection');
    $("#add_city").jqxComboBox('clearSelection');
    $("#add_state").jqxComboBox('clearSelection');
    $("#add_island").jqxComboBox('clearSelection');
    $("#add_country").jqxComboBox('clearSelection');
    $("#add_phone1").val("");
    $("#add_phone2").val("");
    $("#add_phone3").val("");
    $("#add_email").val("");
    $("#add_email").css({"border-color":"#ccc"});
    $("#add_fax").val("");
    $("#add_website").val("");
    $("#add_custom1").val("");
    $("#add_custom2").val("");
    $("#add_custom3").val("");
    $("#add_note").val("");
    $("#add_email_message").text("");
    $("#searchclear").hide();
    $('#tab1').unblock();
    $('#tab2').unblock();
    $("#add_msg").hide();
    $("#add_btnscd").show();
    $("#add_save").attr("disabled", true);
    setTimeout(function(){
        $("#add_firstname").focus()
    }, 200);
}


function check_email(val){
    if(!val.match(/\S+@\S+\.\S+/)){
        return false;
    }
    if( val.indexOf(' ')!=-1 || val.indexOf('..')!=-1){
        return false;
    }
    return true;
}

function city(unique){
    var CityDefer = $.Deferred();
    $.ajax({
        url: SiteRoot+'backoffice/get_geocities_unique',
        type: 'post',
        data: {geocitiesid: unique},
        dataType:"json",
        success: function(data){
            selcity = data.City;
            selzipcode = data.Zip;
            areacode = data.AreaCode;
            CityDefer.resolve();
        },
        error: function(){
            CityDefer.reject();
            alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
        }
    });
    return CityDefer.promise();
}


function state(unique){
    var StateDefer = $.Deferred();
    $.ajax({
        url: SiteRoot+'backoffice/get_geocities_unique',
        type: 'post',
        data: {geocitiesid: unique},
        dataType:"json",
        success: function(data){
            selstate = data.State;
            StateDefer.resolve();
        },
        error: function(){
            StateDefer.reject();
            alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
        }
    });
    return StateDefer.promise();
}

function island(unique){
    var Islanddefer = $.Deferred();
    $.ajax({
        url: SiteRoot+'backoffice/get_geocities_unique',
        type: 'post',
        data: {geocitiesid: unique},
        dataType:"json",
        success: function(data){
            selisland = data.County;
            Islanddefer.resolve();
        },
        error: function(){
            Islanddefer.reject();
            alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
        }
    });
    return Islanddefer.promise();
}

function country(unique){
    var CountryDefer = $.Deferred();
    $.ajax({
        url: SiteRoot+'backoffice/get_geocities_unique',
        type: 'post',
        data: {geocitiesid: unique},
        dataType:"json",
        success: function(data){
            selcountry = data.Country;
            CountryDefer.resolve();
        },
        error: function(){
            CountryDefer.reject();
            alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
        }
    });
    return CountryDefer.promise();
}


function find_zipcode_selected(unique){
    var ZipcodeDefer = $.Deferred();
    $.ajax({
        url: SiteRoot+'backoffice/find_zipcode_selected',
        type: 'post',
        data: {zipcodeid : unique},
        dataType:"json",
        success: function(data){
            selzipunique = data.ZipUnique;
            ZipcodeDefer.resolve();
            areacode = data.AreaCode;
        },
        error: function(){
            ZipcodeDefer.reject();
            alert("Sorry, we encountered a technical difficulties\nPlease try again later.");
        }
    });
    return ZipcodeDefer.promise();
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
    //intervalclosemessage = 5000;
    setTimeout(function(){
        //$("#message").text("");
        //$("#add_message").text("");
    }, intervalclosemessage);
}

$(function(){
    setTimeout(function(){
        $("#table input.jqx-input").focus();
    },1000)
})