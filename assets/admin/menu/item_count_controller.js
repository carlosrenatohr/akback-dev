angular.module("akamaiposApp", ['jqwidgets'])
    .controller('itemCountController', function($scope, $http, itemCountService, adminService){


    $('#icountTabs').on('tabclick', function(e) {
        var tab = e.args.item;
        var tabTitle = $('#icountTabs').jqxTabs('getTitleAt', tab);
        var hidingBtns = function() {
            $('#finishIcountBtn').hide();
            $('#setZeroIcountBtn').hide();
            $('#deleteIcounlistBtn').hide();
            $('#icountlistGrid').hide();
        };
        if (tab == 0) {
        // Filters tab
            hidingBtns();
        } else if (tab == 1) {
            hidingBtns();
        // Item Count list tab
        } else if (tab == 2) {
            $('#icountlistGrid').show();
            $('#setZeroIcountBtn').show();
            $('#deleteIcounlistBtn').show();
            $('#icountlistGrid').jqxGrid('unselectallrows');
            if ($scope.icountStatus == 1)
                $('#finishIcountBtn').show();
            else // 0=deleted; 2=finished; null
                $('#finishIcountBtn').hide();
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
    $scope.icountGridProgressSettings = itemCountService.getIcountTableSettings(1);
    $scope.icountGridCompleteSettings = itemCountService.getIcountTableSettings(2);
    $scope.icountlistGridSettings = itemCountService.getIcountlistTableSettings();
    $scope.icategoryFilterSettings = itemCountService.getCategoryFilter();
    $scope.isubcategoryFilterSettings = itemCountService.getSubcategoryFilter();
    $scope.isupplierFilterSettings = itemCountService.getSupplierFilter();

    function updateIcountGrid() {
        $('#icountGrid1').jqxGrid({
            source: itemCountService.getIcountTableSettings(1).source,
            autoheight: true,
            autorowheight: true
        });
        $('#icountGrid2').jqxGrid({
            source: itemCountService.getIcountTableSettings(2).source,
            autoheight: true,
            autorowheight: true
        });
    }

    function updateIcountlistGrid(id) {
        $('#icountlistGrid').jqxGrid({
            source: itemCountService.getIcountlistTableSettings(id).source,
            autoheight: true,
            autorowheight: true
        });
    }

    $scope.categoryOnChange = function(e) {
        if (e.args.item) {
            var id = e.args.item.value;
            $scope.isubcategoryFilterSettings = itemCountService.getSubcategoryFilter(id);
        }
    };

    // Notifications settings
    var notifContainer = '#notification_container_icount';
    $scope.icountSuccessMsg = adminService.setNotificationSettings(1, notifContainer);
    $scope.icountErrorMsg = adminService.setNotificationSettings(0, notifContainer);

    $('#icountTabs .icountField').on('keypress keyup paste change', function(){
        if (!$(this).hasClass('filters')) {
            $('#saveIcountBtn').prop('disabled', false);
        }
    });

    $('#icountTabs .icountField.filters').on('select', function(e) {
        if (e.args) {
            $('#saveIcountBtn').prop('disabled', false);
        }
    });

    $('body').on('focus', '#icountTabs .icountField.filters .jqx-combobox-input', function(e) {
        var $this = $(this).parents('.icountField.filters');
        $this.jqxComboBox({showArrow: true});
        $this.jqxComboBox('open');
    });

    $('body').on('bindingComplete', '#icountTabs .icountField.filters .jqx-combobox-input', function(e) {
        var $this = $(this).parents('.icountField.filters');
        $this.jqxComboBox({showArrow: true});
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
            var current = (isNaN(parseFloat(row.CurrentStock))) ? 0 : parseFloat(row.CurrentStock);
            var newDiff = parseFloat(value) - (current);
            var nCost = parseFloat(value) * parseFloat(row.TotalCost);// parseFloat(row.Cost);
            var aCost = newDiff * parseFloat(row.TotalCost);
            $.ajax({
                method: 'post',
                url: SiteRoot + 'admin/ItemCount/update_countlistById/' + row.Unique,
                dataType: 'json',
                data: {
                    CountStock: value,
                    Difference: newDiff,
                    NewCost: nCost,
                    AdjustedCost: aCost
                },
                success: function(response) {
                    $('#icountlistGrid').jqxGrid('setcellvalue', rowBoundIndex, "Difference", newDiff);
                    $('#icountlistGrid').jqxGrid('setcellvalue', rowBoundIndex, "NewCost", nCost);
                    $('#icountlistGrid').jqxGrid('setcellvalue', rowBoundIndex, "AdjustedCost", aCost);
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
    })
    .on('bindingcomplete', '#icountlistGrid', function(e) {
        // $(this).show();
        // $(this).jqxGrid('hideloadelement');
    });

    $scope.openIcount = function() {
        $scope.icountID = null;
        $scope.icountStatus = null;
        $scope.createOrEditIcount = 'create';
        //
        // $('#icountlistGrid').jqxGrid('unselectallrows');
        $('#icount_location').val(1);
        $('#icount_comment').val('');
        $('#icount_countdate').jqxDateTimeInput({'disabled': false});
        //
        // $('#deleteIcountBtn').hide();
        $('#finishIcountBtn').hide();
        $('#setZeroIcountBtn').hide();
        $('#deleteIcounlistBtn').hide();
        $('#icountTabs').jqxTabs('select', 0);
        $('#icountTabs').jqxTabs('disableAt', 2);
        //
        $('#icount_location').jqxDropDownList('val', $('#loc_id').val());
        $('#icount_location').jqxDropDownList({'disabled': false});
        $('#icount_countdate').jqxDateTimeInput({'disabled': false});
        $('#icount_countdate').jqxDateTimeInput('setDate', new Date());
        setTimeout(function(){
            $('#icount_comment').focus();
            setTimeout(function(){
                $('#saveIcountBtn').prop('disabled', true);
            }, 50);
        }, 50);
        // $('#icountlistGrid').hide();
        // $('#icountlistGrid').jqxGrid('showloadelement');
        // $('#icountlistGrid').jqxGrid('showloadelement');

        // $('#buildCountListBtn').prop('disabled', true);
        $('#icategoryFilter').jqxComboBox('clearSelection');
        $('#isubcategoryFilter').jqxComboBox('clearSelection');
        $('#isupplierFilter').jqxComboBox('clearSelection');
        $('.icountField.filters').jqxComboBox({disabled: false});
        $('#saveIcountBtn').html('Build Count List');
        $('#saveIcountBtn').show();
        icountwind.setTitle('New Item Count');
        icountwind.open();
    };

    $scope.editIcount = function(e) {
        var row = e.args.row.bounddata;
        $scope.icountID = row.Unique;
        $scope.icountStatus = row.Status;
        $scope.createOrEditIcount = 'edit';
        //
        // setTimeout(function(){
            updateIcountlistGrid(row.Unique);
        // }, 150);
        // $('#icountlistGrid').jqxGrid('unselectallrows');
        // $('#icountlistGrid').hide();
        // $('#icountlistGrid').jqxGrid('showloadelement');
        //
        $('#icount_location').val(row.Location);
        $('#icount_comment').val(row.Comment);
        var countDate = new Date(Date.parse(row.CountDate));
        $('#icount_countdate').jqxDateTimeInput({formatString: 'MM/dd/yyyy hh:mm tt'});
        $("#icount_countdate").jqxDateTimeInput('setDate', row._CountDate);
        $('#icount_countdate').jqxDateTimeInput({'disabled': true});
        $('#icount_location').jqxDropDownList({'disabled': true});
        //
        if (row.CategoryFilter != null && row.CategoryFilter != '') {
            $('#icategoryFilter').jqxComboBox('selectItem', row.CategoryFilter);
        }
        setTimeout(function() {
            if (row.SubCategoryFilter != null && row.SubCategoryFilter != '') {
                var sub = row.SubCategoryFilter.split(',');
                $.each(sub, function(i,el) {
                    $('#isubcategoryFilter').jqxComboBox('selectItem', el);
                });
            }
            $('#saveIcountBtn').prop('disabled', true);
        }, 300);
        if (row.SupplierFilter != null && row.SupplierFilter != '') {
            var supp = row.SupplierFilter.split(',');
            $.each(supp, function(i,el) {
                $('#isupplierFilter').jqxComboBox('selectItem', el);
            });
        }
        //
        // $('#deleteIcountBtn').show();
        $('#icountTabs').jqxTabs('select', 0);
        $('#icountTabs').jqxTabs('enableAt', 2);
        $('.icountField.filters').jqxComboBox({disabled: true});
        $('#saveIcountBtn').html('Save');
        $('#finishIcountBtn').hide();
        $('#setZeroIcountBtn').hide();
        $('#deleteIcounlistBtn').hide();
        $('#saveIcountBtn').hide();
        var btn = $('<button/>', {
            'ng-click': 'finishIcount()',
            'id': 'deleteIcountBtn'
        }).addClass('icon-trash user-del-btn');//.css('left', 0);
        var title = $('<div/>').html(' Edit Item Count | ID: '+ row.Unique + ' | ' + row.Comment).prepend(btn)
            .css('padding-left', '2em');
        icountwind.setTitle(title);
        icountwind.open();
    };

    $scope.saveIcount = function(toClose) {
        var required = function() {
            if ($('#icount_comment').val() == '') {
                $('#icountErrorMsg #msg').html('Name field is required');
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
                'CountDate': $('#icount_countdate').val(),
                'filters': {}
            };
            if ($scope.createOrEditIcount == 'create') {
                var category = $('#icategoryFilter').jqxComboBox('val');
                if (category != '') {
                    data.filters.MainCategory = category;
                    var subcategories = $('#isubcategoryFilter').jqxComboBox('getSelectedItems');
                    if (subcategories.length) {
                        data.filters.SubCategory = [];
                        $.each(subcategories, function(i, el) {
                            data.filters.SubCategory.push(el.value);
                        });
                    }
                }
                var suppliers = $('#isupplierFilter').jqxComboBox('getSelectedItems');
                if (suppliers.length) {
                    data.filters.SupplierUnique = [];
                    $.each(suppliers, function(i, el) {
                        data.filters.SupplierUnique.push(el.value);
                    });
                }
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
                        $('#saveIcountBtn').html('Save');
                        $('#saveIcountBtn').prop('disabled', true);
                        $('#saveIcountBtn').hide();
                        // CREATING
                        if ($scope.createOrEditIcount == 'create') {
                            $scope.icountID = response.id;
                            $scope.createOrEditIbrand = 'edit';
                            $scope.icountStatus = 1;
                            $('#icount_countdate').jqxDateTimeInput({'disabled': true});
                            $('#icount_location').jqxDropDownList({'disabled': true});
                            $('.icountField.filters').jqxComboBox({disabled: true});
                            $('#finishIcountBtn').show();
                            //
                            updateIcountlistGrid($scope.icountID);
                            $('#icountlistGrid').show();
                            setTimeout(function() {
                                $('#icountTabs').jqxTabs('enableAt', 2);
                                $('#icountTabs').jqxTabs('select', 2);
                            }, 150);
                            //
                            var btn = $('<button/>', {
                                'ng-click': 'finishIcount()',
                                'id': 'deleteIcountBtn'
                            }).addClass('icon-trash user-del-btn').css('left', 0);
                            var title = $('<div/>').html(' Edit Item Count | ID: '+ response.id + ' | ' + data.Comment).prepend(btn)
                                .css('padding-left', '2em');
                            icountwind.setTitle(title);
                            $('#icountSuccessMsg #msg').html('Item Count created successfully! <br>' +
                                'Item Count list was built. You can check it at count list subtab. ');
                            $scope.icountSuccessMsg.apply('open');
                            updateIcountGrid(1);
                        // UPDATING
                        } else {
                            var btn = $('<button/>', {
                                'ng-click': 'finishIcount()',
                                'id': 'deleteIcountBtn'
                            }).addClass('icon-trash user-del-btn').css('left', 0);
                            var title = $('<div/>').html(' Edit Item Count | ID: '+ $scope.icountID + ' | ' + $('#icount_comment').val()).prepend(btn)
                                .css('padding-left', '2em');
                            icountwind.setTitle(title);
                            $('#icountSuccessMsg #msg').html('Item Count updated successfully!');
                            $scope.icountSuccessMsg.apply('open');
                            $('#icountGrid1').jqxGrid('updatebounddata', 'filter');
                            $('#icountGrid2').jqxGrid('updatebounddata', 'filter');
                        }
                        if (toClose) {
                            icountwind.close();
                            $('#icountTabs').jqxTabs('select', 0);
                            $('#icountTabs').jqxTabs('disableAt', 2);
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
            $('#setZeroIcountBtns').hide();
        }
        if (option == 0) {
            $scope.saveIcount(1);
        } else if (option == 1) {
            icountwind.close();
            $('#finishIcountBtn').hide();
            $('#icountTabs').jqxTabs('select', 0);
            $('#icountTabs').jqxTabs('disableAt', 2);
        } else if (option == 2) {
        } else {
            if ($('#saveIcountBtn').is(':disabled')) {
                icountwind.close();
                $('#finishIcountBtn').hide();
                $('#icountTabs').jqxTabs('select', 0);
                $('#icountTabs').jqxTabs('disableAt', 2);
            } else {
                $('#mainIcountBtns').hide();
                $('#closeIcountBtns').show();
                $('#deleteIcountBtns').hide();
                $('#finishIcountBtns').hide();
                $('#setZeroIcountBtns').hide();
            }
        }
    };

    $('body').on('click', '#deleteIcountBtn', function(e) {
        $scope.deleteIcount();
    });

    $scope.deleteIcount = function(option) {
        if(option != undefined) {
            $('#mainIcountBtns').show();
            $('#closeIcountBtns').hide();
            $('#deleteIcountBtns').hide();
            $('#finishIcountBtns').hide();
            $('#setZeroIcountBtns').hide();
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
                        $('#icountTabs').jqxTabs('disableAt', 2);

                    }
                    else if (data.status == 'error') {}
                    else {}
                }
            });
        } else if (option == 1) {
            icountwind.close();
            $('#icountTabs').jqxTabs('select', 0);
            $('#icountTabs').jqxTabs('disableAt', 2);
        } else if (option == 2) {
        } else {
            $('#icountTabs').jqxTabs('select', 0);
            $('#mainIcountBtns').hide();
            $('#closeIcountBtns').hide();
            $('#deleteIcountBtns').show();
            $('#finishIcountBtns').hide();
            $('#setZeroIcountBtns').hide();
        }
    };

    $scope.finishIcount = function(option) {
        if (option != undefined) {
            $('#mainIcountBtns').show();
            $('#closeIcountBtns').hide();
            $('#deleteIcountBtns').hide();
            $('#finishIcountBtns').hide();
            $('#setZeroIcountBtns').hide();
        }

        if (option == 0) {
            $.ajax({
                method: 'post',
                url: SiteRoot + 'admin/ItemCount/finalizeCount/' + $scope.icountID ,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        updateIcountGrid();
                        updateIcountlistGrid($scope.icountID);
                        // $('#finishIcountBtn').hide();
                        $('#icountGrid1').jqxGrid('refresh');
                        $('#icountGrid2').jqxGrid('refresh');
                        $('#icountGrid2').jqxGrid('render');
                        $('#icountSuccessMsg #msg').html('Item Count has been completed and Stock Adjusted.');
                        $scope.icountSuccessMsg.apply('open');
                        // icountwind.close();
                    }
                    else if (response.status == 'error') {}
                    else {}
                }
            });
        } else if (option == 1) {
        } else {
            $('#mainIcountBtns').hide();
            $('#closeIcountBtns').hide();
            $('#deleteIcountBtns').hide();
            $('#finishIcountBtns').show();
            $('#setZeroIcountBtns').hide();
        }
    };

    $scope.setZeroIcount = function(option) {
        if (option != undefined) {
            $('#mainIcountBtns').show();
            $('#closeIcountBtns').hide();
            $('#deleteIcountBtns').hide();
            $('#finishIcountBtns').hide();
            // $('#setZeroIcountBtns').hide();
            $('#setzeroItemCountListWin').jqxWindow('close');
        }

        if (option == 0) {
            $.ajax({
                method: 'post',
                url: SiteRoot + 'admin/ItemCount/setZeroCount/' + $scope.icountID ,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        updateIcountGrid();
                        updateIcountlistGrid($scope.icountID);
                        $('#icountGrid1').jqxGrid('refresh');
                        $('#icountGrid2').jqxGrid('refresh');
                        // $('#icountGrid2').jqxGrid('render');
                        $('#icountSuccessMsg #msg').html('Items have set successfully!.');
                        $scope.icountSuccessMsg.apply('open');
                        $('#setzeroItemCountListWin').jqxWindow('close');
                    }
                    else if (response.status == 'error') {}
                    else {}
                }
            });
        } else if (option == 1) {
        } else {
            $('#mainIcountBtns').hide();
            $('#closeIcountBtns').hide();
            $('#deleteIcountBtns').hide();
            $('#finishIcountBtns').hide();
            $('#setzeroItemCountListWin').jqxWindow('open');
            // $('#setZeroIcountBtns').show();
        }
    };

    $scope.delItemCountList = function(option) {
        if(option == 0) {
            var countgrid = $('#icountlistGrid');
            var ids = [];
            var idx = countgrid.jqxGrid('selectedrowindexes');
            $.each(idx, function(i, el) {
                ids.push(countgrid.jqxGrid('getrowdata', el).Unique);
            });
            $.ajax({
                method: 'post',
                url: SiteRoot + 'admin/ItemCount/massDeleteItemCountList',
                dataType: 'json',
                data: {ids: ids.join()},
                success: function (response) {
                    updateIcountGrid();
                    updateIcountlistGrid($scope.icountID);
                    countgrid.jqxGrid('unselectallrows');
                    $('#delItemCountListWin').jqxWindow('close');
                }
            });
        } else if(option == 1) {
            $('#delItemCountListWin').jqxWindow('close');
        } else {
            $('#delItemCountListWin').jqxWindow('open');
        }
        // if (confirm('Are you sure to delete selected items on grid?')) {}
    }

});