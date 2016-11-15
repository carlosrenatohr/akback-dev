angular.module("akamaiposApp", ['jqwidgets'])
    .controller('itemCountController', function($scope, $http, adminService){


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

    var pager = adminService.loadPagerConfig();
    $scope.icountGridSettings = {
        source: new $.jqx.dataAdapter({
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'int'},
                {name: 'Item', type: 'string'},
                {name: 'Part', type: 'string'},
                {name: 'Description', type: 'string'},
                {name: 'Supplier', type: 'string'},
                {name: 'SupplierPart', type: 'string'},
                {name: 'Category', type: 'string'},
                {name: 'CurrentStock', type: 'string'},
                {name: 'CountStock', type: 'string'},
                {name: 'Difference', type: 'string'},
                {name: 'Location', type: 'string'},
                {name: 'ItemStockLineUnique', type: 'string'},
                {name: 'Station', type: 'string'},
                {name: 'Comment', type: 'string'},
                {name: 'Status', type: 'string'},
                {name: 'Created', type: 'string'},
                {name: 'CreatedBy', type: 'string'},
                {name: 'Updated', type: 'string'},
                {name: 'UpdatedBy', type: 'string'}
            ],
            id: 'Unique',
            url: SiteRoot + 'admin/ItemCount/load_allitemcount'
        }),
        columns: [
            {dataField: 'Unique', hidden: true},
            {text: 'Item', dataField: 'Item'},
            {text: 'Part', dataField: 'Part'},
            {text: 'Description', dataField: 'Description'},
            {text: 'Supplier', dataField: 'Supplier'},
            {text: 'Category', dataField: 'Category'},
            {text: 'Cost', dataField: 'Cost'},
            {text: 'Current', dataField: 'CurrentStock'},
            {text: 'Count', dataField: 'CountStock'},
            {text: 'Difference', dataField: 'Difference'},
            {dataField: 'Station', hidden: true},
            {dataField: 'Comment', hidden: true},
            {dataField: 'Created', hidden: true},
            {dataField: 'Updated', hidden: true},
            {dataField: 'CreatedBy', hidden: true},
            {dataField: 'UpdatedBy', hidden: true}
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

    function updateIcountGrid() {
        $('#icountGrid').jqxGrid({
            source: $scope.icountGridSettings.source
        });
    }

    // Notifications settings
    var notifContainer = '#notification_container_icount';
    $scope.icountSuccessMsg = adminService.setNotificationSettings(1, notifContainer);
    $scope.icountErrorMsg = adminService.setNotificationSettings(0, notifContainer);

    $('#icountTabs .form-control').on('keypress keyup paste change', function(){
        $('#saveIcountBtn').prop('disabled', false);
    });

    $scope.openIcount = function() {
        $scope.icountID = null;
        $scope.createOrEditIcount = 'create';
        //
        $('#icount_location').val(1);
        $('#icount_comment').val('');
        icountwind.setTitle('New Item Count');
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
                'Comment': $('#icount_comment').val()
            };
            if ($scope.createOrEditIbrand == 'create') {
                url = SiteRoot + 'admin/ItemCount/createCount'
            } else if ($scope.createOrEditIbrand == 'edit') {
            //     url = SiteRoot + 'admin/ItemBrand/updateBrand/' + $scope.ibrandID
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
                            icountWin.setTitle('Edit Item Count | ID:' + response.id);
                            $('#icountSuccessMsg #msg').html('Item Count created successfully!');
                            $scope.icountSuccessMsg.apply('open');
                        } else {
                            $('#icountSuccessMsg #msg').html('Item Count updated successfully!');
                            $scope.icountSuccessMsg.apply('open');
                            // }
                            updateIcountGrid();
                            if (toclose) {
                                icountwind.close();
                            }
                        }
                    } else if (response.status == 'error') {
                    } else {}
                }
            });
        };
    };

    $scope.closeIcount = function(option) {
        if (option != undefined) {
            $('#mainIcountBtns').show();
            $('#closeIcountBtns').hide();
            $('#deleteIcountBtns').hide();
        }
        if (option == 0) {
            $scope.saveIcount(1);
        } else if (option == 1) {
            icountwind.close();
        } else if (option == 2) {
        } else {
            if ($('#saveIcountBtn').is(':disabled')) {
                icountwind.close();
            } else {
                $('#mainIcountBtns').hide();
                $('#closeIcountBtns').show();
                $('#deleteIcountBtns').hide();
            }
        }
    };

});