/**
 * Created by carlosrenato on 11-03-16.
 */

angular.module("akamaiposApp", ['jqwidgets'])
    .controller('itemBrandController', function($scope, $http, adminService){

    var ibrandsWin;
    $scope.disabled = true;
    $scope.ibrandsWindowSettings = {
        created: function (args) {
            ibrandsWin = args.instance;
        },
        resizable: false,
        width: "100%", height: "100%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    var pager = adminService.loadPagerConfig();
    $scope.ibrandsGridSettings = {
        source: new $.jqx.dataAdapter({
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'int'},
                {name: 'Name', type: 'string'},
                {name: 'Note', type: 'string'},
                {name: 'Created', type: 'string'},
                {name: 'CreatedByName', type: 'string'},
                {name: 'Updated', type: 'string'},
                {name: 'UpdatedByName', type: 'string'}
            ],
            id: 'Unique',
            url: SiteRoot + 'admin/ItemBrand/load_allbrands'
        }),
        columns: [
            {text: 'ID', dataField: 'Unique'},
            {text: 'Name', dataField: 'Name'},
            {text: 'Note', dataField: 'Note'},
            {dataField: 'Created', hidden: true},
            {dataField: 'Updated', hidden: true},
            {dataField: 'CreatedByName', hidden: true},
            {dataField: 'UpdatedByName', hidden: true}
        ],
        width: "99.7%",
        theme: 'arctic',
        filterable: true,
        showfilterrow: true,
        sortable: true,
        pageable: true,
        pageSize: pager.pageSize,
        pagesizeoptions: pager.pagesizeoptions,
        altRows: true,
        autoheight: true,
        autorowheight: true
    };

    function updateIbrandsGrid() {
        $('#ibrandsGrid').jqxGrid({
            source: $scope.ibrandsGridSettings.source
        })
    }

    // Notifications settings
    var notifContainer = '#notification_container_ibrands';
    $scope.ibrandsSuccessMsg = adminService.setNotificationSettings(1, notifContainer);
    $scope.ibrandsErrorMsg = adminService.setNotificationSettings(0, notifContainer);

    $('#ibrandsTabs .form-control').on('keypress keyup paste change', function(){
        $('#saveIbrandsBtn').prop('disabled', false);
    });

    $scope.ibrandID = null;
    $scope.createOrEditIbrand = null;
    $scope.openIbrands = function() {
        $scope.ibrandID = null;
        $scope.createOrEditIbrand = 'create';
        //
        $('#ibrands_name').val('');
        $('#ibrands_note').val('');
        $('#ibrandsTabs').jqxTabs('select', 0);
        $('#secondBrandTab').hide();
        $('#deleteIbrandsBtn').hide();
        $('#saveIbrandsBtn').prop('disabled', true);
        setTimeout(function(){
            $('#ibrands_name').focus();
        }, 100);
        ibrandsWin.setTitle('New Item Brand');
        ibrandsWin.open();
    };

    $scope.editIbrands = function(e) {
        var row = e.args.row.bounddata;
        $scope.ibrandID = row.Unique;
        $scope.createOrEditIbrand = 'edit';
        for(var i in row) {
            var el = $('#ibrandsTabs #ibrands_' + i.toLocaleLowerCase());
            if (el.length) {
                el.val(row[i]);
            }
        }
        //
        $('#ibrandsTabs').jqxTabs('select', 0);
        $('#secondBrandTab').show();
        $('#deleteIbrandsBtn').show();
        $('#saveIbrandsBtn').prop('disabled', true);
        setTimeout(function(){
            $('#ibrands_name').focus();
        }, 100);
        ibrandsWin.setTitle('Edit Item Brand | ID:' + row.Unique);
        ibrandsWin.open();
    };

    $scope.saveIbrands = function(toclose) {
        var required = function() {
            if ($('ibrands_name').val() == '') {
                $('#ibrandsErrorMsg #msg').html('Name field is required');
                $scope.ibrandsErrorMsg.apply('open');
                return false;
            }

            return true;
        };

        if (required) {
            var url = '';
            var data = {
                'Name': $('#ibrands_name').val(),
                'Note': $('#ibrands_note').val()
            };
            if ($scope.createOrEditIbrand == 'create') {
                url = SiteRoot + 'admin/ItemBrand/postBrand'
            } else if ($scope.createOrEditIbrand == 'edit') {
                url = SiteRoot + 'admin/ItemBrand/updateBrand/' + $scope.ibrandID
            }

            $.ajax({
                url: url,
                data: data,
                method: 'post',
                dataType: 'json',
                success:function(response) {
                    if (response.status == 'success') {
                        $('#saveIbrandsBtn').prop('disabled', true);
                        if ($scope.createOrEditIbrand == 'create') {
                            $scope.ibrandID = response.id;
                            $scope.createOrEditIbrand = 'edit';
                            ibrandsWin.setTitle('Edit Item Brand | ID:' + response.id);
                            $('#ibrandsSuccessMsg #msg').html('Brand created successfully!');
                            $scope.ibrandsSuccessMsg.apply('open');
                        } else {
                            $('#ibrandsSuccessMsg #msg').html('Brand updated successfully!');
                            $scope.ibrandsSuccessMsg.apply('open');
                        }
                        updateIbrandsGrid();
                        if (toclose) {
                            ibrandsWin.close();
                        }
                    } else if (response.status == 'error') {
                    } else {}
                }
            })
        }
    };

    $scope.closeIbrands = function(option) {
        if (option != undefined) {
            $('#mainIbrandsBtns').show();
            $('#closeIbrandsBtns').hide();
            $('#deleteIbrandsBtns').hide();
        }
        if (option == 0) {
            $scope.saveIbrands(1);
        } else if (option == 1) {
            ibrandsWin.close();
        } else if (option == 2) {
        } else {
            if ($('#saveIbrandsBtn').is(':disabled')) {
                ibrandsWin.close();
            } else {
                $('#mainIbrandsBtns').hide();
                $('#closeIbrandsBtns').show();
                $('#deleteIbrandsBtns').hide();
            }
        }
    };

    $scope.deleteIbrands = function(option) {
        if(option != undefined) {
            $('#mainIbrandsBtns').show();
            $('#closeIbrandsBtns').hide();
            $('#deleteIbrandsBtns').hide();
        }
        if (option == 0) {
            $.ajax({
                url: SiteRoot + 'admin/ItemBrand/deleteBrand/' + $scope.ibrandID,
                method: 'post',
                dataType: 'json',
                success: function(response) {
                    if(response.status == 'success') {
                        updateIbrandsGrid();
                        ibrandsWin.close();
                    }
                    else if (data.status == 'error') {}
                    else {}
                }
            });
        } else if (option == 1) {
            ibrandsWin.close();
        } else if (option == 2) {
        } else {
            $('#mainIbrandsBtns').hide();
            $('#closeIbrandsBtns').hide();
            $('#deleteIbrandsBtns').show();
        }
    };

});