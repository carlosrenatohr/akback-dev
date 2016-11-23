angular.module("akamaiposApp", ['jqwidgets'])
    .controller('itemCountController', function($scope, $http, itemCountService, adminService){


    $('#icountTabs').on('tabclick', function(e) {
        var tab = e.args.item;
        var tabTitle = $('#icountTabs').jqxTabs('getTitleAt', tab);
        if (tab == 0) {
            $('#deleteIcountBtn').show();
            $('#finishIcountBtn').hide();
        } else if (tab == 1) {
            $('#deleteIcountBtn').hide();
            $('#finishIcountBtn').show();
            // if ($('#buildCountListBtn').data('list') > 0) {
            //     $('#buildListBtns').hide();
            //     $('#listGridContainer').show();
            //     updateIcountlistGrid($scope.icountID);
            // } else {
            //     $('#buildListBtns').show();
            //     $('#listGridContainer').hide();
            // }
        }
    });

    var icountwind;
    $scope.icountWindowSettings = {
        created: function (args) {
            icountwind = args.instance;
        },
        resizable: false,
        width: "100%", height: "100%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    // Item Count Grid
    $scope.icountGridSettings = itemCountService.getIcountTableSettings();
    $scope.icountlistGridSettings = itemCountService.getIcountlistTableSettings();

    function updateIcountGrid() {
        $('#icountGrid').jqxGrid({
            source: itemCountService.getIcountTableSettings().source
        });
    }

    function updateIcountlistGrid(id) {
        $('#icountlistGrid').jqxGrid({
            source: itemCountService.getIcountlistTableSettings(id).source
        });
    }

    // Notifications settings
    var notifContainer = '#notification_container_icount';
    $scope.icountSuccessMsg = adminService.setNotificationSettings(1, notifContainer);
    $scope.icountErrorMsg = adminService.setNotificationSettings(0, notifContainer);

    $('#icountTabs .icountField').on('keypress keyup paste change select', function(){
        $('#saveIcountBtn').prop('disabled', false);
    });
    $('#icountTabs #icount_countdate').on('change valueChanged', function() {
        $('#saveIcountBtn').prop('disabled', false);
    });

    $('body').on('select', '#icount_location', function() {
        $('#saveIcountBtn').prop('disabled', false);
    });

    $("body").on('cellvaluechanged', '#icountlistGrid', function (event)
    {
        var value = event.args.newvalue;
        var oldvalue = event.args.oldvalue;
        var datafield = event.args.datafield;
        var rowBoundIndex = event.args.rowindex;
        if (datafield  == 'CountStock') {
            var row = $(this).jqxGrid('getrowdata', rowBoundIndex);
            var newDiff = parseFloat(value) - ((row.Difference != null) ? parseFloat(row.Difference) : 0);
            $.ajax({
                method: 'post',
                url: SiteRoot + 'admin/ItemCount/update_countlistById/' + row.Unique,
                dataType: 'json',
                data: {
                    CountStock: value,
                    Difference: newDiff
                },
                success: function(response) {
                    $('#icountlistGrid').jqxGrid('setcellvalue', rowBoundIndex, "Difference", newDiff);
                }
            });
        } else if (datafield  == 'Comment') {
            var row = $(this).jqxGrid('getrowdata', rowBoundIndex);
            $.ajax({
                method: 'post',
                url: SiteRoot + 'admin/ItemCount/update_countlistById/' + row.Unique,
                dataType: 'json',
                data: {
                    Comment: value
                },
                success: function(response) {
                    $('#icountlistGrid').jqxGrid('setcellvalue', rowBoundIndex, "Comment", value);
                }
            });
        }
    });

    $scope.openIcount = function() {
        $scope.icountID = null;
        $scope.createOrEditIcount = 'create';
        //
        $('#icount_location').val(1);
        $('#icount_comment').val('');
        $('#icount_countdate').jqxDateTimeInput({'disabled': false});
        //
        $('#deleteIcountBtn').hide();
        $('#icountTabs').jqxTabs('disableAt', 1);

        $('#icount_countdate').jqxDateTimeInput({'disabled': false});
        $('#icount_countdate').jqxDateTimeInput('setDate', new Date());
        $('#saveIcountBtn').prop('disabled', true);
        $('#buildCountListBtn').prop('disabled', true);
        icountwind.setTitle('New Item Count');
        icountwind.open();
    };

    $scope.editIcount = function(e) {
        var row = e.args.row.bounddata;
        $scope.icountID = row.Unique;
        $scope.createOrEditIcount = 'edit';
        //
        $('#icount_location').val(row.Location);
        $('#icount_comment').val(row.Comment);
        // $('#buildCountListBtn').data("id", row.Unique);
        // $('#buildCountListBtn').data("loc", row.Location);
        // $('#buildCountListBtn').data("list", row.hasCountList);
        //
        setTimeout(function(){
            // if ($('#buildCountListBtn').data('list') > 0) {
                $('#icountTabs').jqxTabs('enableAt', 1);
                // $('#buildCountListBtn').prop('disabled', true);
                updateIcountlistGrid($scope.icountID);
            // } else {
            //     $('#icountTabs').jqxTabs('disableAt', 1);
            //     $('#buildCountListBtn').prop('disabled', false);
            // }
        }, 250);
        //
        $('#deleteIcountBtn').show();
        $('#icount_countdate').jqxDateTimeInput({'disabled': true});
        var countDate = new Date(Date.parse(row.CountDate));
        $("#icount_countdate").jqxDateTimeInput('setDate', countDate);
        $('#icountTabs').jqxTabs('enableAt', 1);
        $('#saveIcountBtn').prop('disabled', true);
        icountwind.setTitle('Edit Item Count | ID: '+ row.Unique + ' | ' + row.Comment);
        icountwind.open();
    };

    $scope.saveIcount = function(toClose) {
        var required = function() {
            if ($('#icount_comment').val() == '') {
                $('#ibrandsErrorMsg #msg').html('Name field is required');
                $scope.ibrandsErrorMsg.apply('open');
                return false;
            }

            return true;
        };

        if (required) {
            var url = '';
            var data = {
                'Location': $('#icount_location').val(),
                'Comment': $('#icount_comment').val(),
                'CountDate': $('#icount_countdate').val()
            };
            if ($scope.createOrEditIcount == 'create') {
                url = SiteRoot + 'admin/ItemCount/createCount'
            } else if ($scope.createOrEditIcount == 'edit') {
                url = SiteRoot + 'admin/ItemCount/updateCount/' + $scope.icountID
            }

            $.ajax({
                url: url,
                data: data,
                method: 'post',
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        $('#saveIcountBtn').prop('disabled', true);
                        if ($scope.createOrEditIcount == 'create') {
                            $scope.icountID = response.id;
                            $scope.createOrEditIbrand = 'edit';
                            $('#icount_countdate').prop('disabled', true);
                            $('#buildCountListBtn').prop('disabled', false);
                            $('#buildCountListBtn').data("loc", data.Location);
                            $('#buildCountListBtn').data("list", 0);
                            //
                            $('#icountTabs').jqxTabs('enableAt', 1);
                            // $('#buildCountListBtn').prop('disabled', true);
                            // $('#buildCountListBtn').data("list", 1);
                            updateIcountlistGrid($scope.icountID);
                            //
                            icountwind.setTitle('Edit Item Count | ID:' + response.id);
                            $('#icountSuccessMsg #msg').html('Item Count created successfully! <br>' +
                                'Item Count list was built. You can check it at count list subtab. ');
                            $scope.icountSuccessMsg.apply('open');
                        } else {
                            $('#icountSuccessMsg #msg').html('Item Count updated successfully!');
                            $scope.icountSuccessMsg.apply('open');
                        }
                        updateIcountGrid();
                        if (toClose) {
                            icountwind.close();
                            $('#icountTabs').jqxTabs('select', 0);
                            $('#icountTabs').jqxTabs('disableAt', 1);
                        }
                    } else if (response.status == 'error') {
                    } else {}
                }
            });
        }
    };

    $scope.closeIcount = function(option) {
        if (option != undefined) {
            $('#mainIcountBtns').show();
            $('#closeIcountBtns').hide();
            $('#deleteIcountBtns').hide();
            $('#finishIcountBtns').hide();
        }
        if (option == 0) {
            $scope.saveIcount(1);
        } else if (option == 1) {
            icountwind.close();
            $('#icountTabs').jqxTabs('select', 0);
            $('#icountTabs').jqxTabs('disableAt', 1);
        } else if (option == 2) {
        } else {
            if ($('#saveIcountBtn').is(':disabled')) {
                icountwind.close();
                $('#icountTabs').jqxTabs('select', 0);
                $('#icountTabs').jqxTabs('disableAt', 1);
            } else {
                $('#mainIcountBtns').hide();
                $('#closeIcountBtns').show();
                $('#deleteIcountBtns').hide();
                $('#finishIcountBtns').hide();
            }
        }
    };

    $scope.deleteIcount = function(option) {
        if(option != undefined) {
            $('#mainIcountBtns').show();
            $('#closeIcountBtns').hide();
            $('#deleteIcountBtns').hide();
            $('#finishIcountBtns').hide();
        }
        if (option == 0) {
            $.ajax({
                url: SiteRoot + 'admin/ItemCount/deleteCount/' + $scope.icountID,
                method: 'post',
                dataType: 'json',
                success: function(response) {
                    if(response.status == 'success') {
                        updateIcountGrid();
                        icountwind.close();
                        $('#icountTabs').jqxTabs('select', 0);
                        $('#icountTabs').jqxTabs('disableAt', 1);

                    }
                    else if (data.status == 'error') {}
                    else {}
                }
            });
        } else if (option == 1) {
            icountwind.close();
            $('#icountTabs').jqxTabs('select', 0);
            $('#icountTabs').jqxTabs('disableAt', 1);
        } else if (option == 2) {
        } else {
            $('#mainIcountBtns').hide();
            $('#closeIcountBtns').hide();
            $('#deleteIcountBtns').show();
            $('#finishIcountBtns').hide();
        }
    };

    $scope.buildCountList = function() {
        console.info('building');
        var hasList = $('#buildCountListBtn').data('list'),
        loc = $('#buildCountListBtn').data('loc'),
        id = $('#buildCountListBtn').data('id');
        if (hasList == 0) {
            $.ajax({
                method: 'post',
                url: SiteRoot + 'admin/ItemCount/create_countlistById/' + $scope.icountID + '/' + loc ,
                dataType: 'json',
                data: '',
                success: function(response) {
                    if (response.status == 'success') {
                        $('#icountTabs').jqxTabs('enableAt', 1);
                        $('#buildCountListBtn').prop('disabled', true);
                        $('#buildCountListBtn').data("list", 1);
                        updateIcountlistGrid($scope.icountID);
                        $('#icountSuccessMsg #msg').html('Item Count list was built. You can check it at count list subtab.');
                        $scope.icountSuccessMsg.apply('open');
                    }
                    else if (response.status == 'error') {}
                    else {}
                }
            });
        } else {
            console.error('Count list Exists, please check!');
        }
    };

    $scope.finishIcount = function(option) {
        if (option != undefined) {
            $('#mainIcountBtns').show();
            $('#closeIcountBtns').hide();
            $('#deleteIcountBtns').hide();
            $('#finishIcountBtns').hide();
        }

        if (option == 0) {
            console.log('in progress..');
        } else if (option == 1) {
        } else {
            $('#mainIcountBtns').hide();
            $('#closeIcountBtns').hide();
            $('#deleteIcountBtns').hide();
            $('#finishIcountBtns').show();
        }
    }

});