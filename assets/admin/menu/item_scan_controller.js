/**
 * Created by carlosrenato on 12-16-16.
 */
angular.module("akamaiposApp", ['jqwidgets'])
    .controller('itemScanController', function($scope, $http, itemCountService, adminService) {

        $('#iscanTabs').on('tabclick', function(e) {
            var tab = e.args.item;
            var tabTitle = $('#iscanTabs').jqxTabs('getTitleAt', tab);
            // $('.matchIscanBtnsContainer.newone').remove();
            // var btns = $('.mainIscanBtnsContainer:not(.newone)').clone();
            // btns.addClass('newone');
            if (tab == 0) {
                // $('#scan_tab1').prependTo(btns);
                $('#saveIscanBtn').show();
                $('#matchIscanBtn').hide();
                $('#delScanListBtn').hide();
                // Filters tab
            } else if (tab == 1) {
                // $('#deleteIcountBtn').hide();
                // $('#scan_tab2').prependTo(btns);
                $('#saveIscanBtn').hide();
                $('#matchIscanBtn').show();
                $('#delScanListBtn').show();
            }
        });

        var iscanwind;
        $scope.iscanWindowSettings = {
            created: function (args) {
                iscanwind = args.instance;
            },
            resizable: false,
            width: "100%", height: "100%",
            autoOpen: false,
            theme: 'darkblue',
            isModal: true,
            showCloseButton: false
        };

        function updateIscanGrid() {
            $('#iscanGrid').jqxGrid({
                source: itemCountService.getIscanTableSettings().source
            });
        }

        function updateIscanlistGrid(id) {
            $('#iscanlistGrid').jqxGrid({
                source: itemCountService.getIscanListTableSettings(id).source
            });
        }

        $('.icountField').on('change', function() {
            $('#saveIscanBtn').prop('disabled', false);
        });

        $scope.iscanGridSettings = itemCountService.getIscanTableSettings();
        $scope.iscanlistGridSettings = itemCountService.getIscanListTableSettings();

        // Notifications settings
        var notifContainer = '#notification_container_iscan';
        $scope.iscanSuccessMsg = adminService.setNotificationSettings(1, notifContainer);
        $scope.iscanErrorMsg = adminService.setNotificationSettings(0, notifContainer);

        $('#icount_file').jqxFileUpload({
            width: 300,
            uploadUrl: SiteRoot + 'admin/ItemCount/upload',
            'fileInputName': 'file',
            multipleFilesUpload: true,
            autoUpload: true
        });

        $scope.csvFileSelected = null;
        var uploadedFilesSelected = [];
        var uploadedFilesOriginal = [];
        $('#icount_file')
            .on('select', function(e) {
                setTimeout(function(){
                    $('.jqx-file-upload-buttons-container').css({display: 'none'});
                }, 100);
            }).on('remove', function(e) {
            }).on('uploadEnd', function(e) {
            $scope.csvFileSelected = JSON.parse(e.args.response);
                if ($scope.csvFileSelected.success === true) {
                    $('#fileLoadedTemp').show();
                    uploadedFilesSelected.push($scope.csvFileSelected.name);
                    uploadedFilesOriginal.push($scope.csvFileSelected.original_name);
                    $('#icount_file').data('filename', uploadedFilesSelected.join());
                    $('#fileLoadedTemp').html('Files loaded: <br><b>' + uploadedFilesOriginal.join(', ') + '</b>');
                    $('#iscanSuccessMsg #msg').html($scope.csvFileSelected.message);
                    $scope.iscanSuccessMsg.apply('open');
                } else {
                    $('#fileLoadedTemp').hide();
                    $('#iscanErrorMsg #msg').html($scope.csvFileSelected.message);
                    $scope.iscanErrorMsg.apply('open');
                }
        });

        $scope.iscanID = null;
        $scope.createOrEditIscan = null;

        $scope.openScan = function() {
            $scope.iscanID = null;
            $scope.createOrEditIscan = 'create';
            //
            $('#icount_location').val(1);
            $('#icount_comment').val('');
            $('#fileLoadedTemp').hide();
            setTimeout(function() {
                $('#icount_location').jqxDropDownList({disabled: false});
                $('#icount_file').jqxFileUpload({disabled: false});
                $('#iscanTabs').jqxTabs('select', 0);
                $('#iscanTabs').jqxTabs('disableAt', 1);
                $('#saveIscanBtn').html('Import');
                $('#saveIscanBtn').prop('disabled', true);
                $('#matchIscanBtn').hide();
            }, 100);
            iscanwind.setTitle('New Item Count Scan');
            iscanwind.open();
        };

        $scope.editScan = function (e) {
            var row = e.args.row.bounddata;
            $scope.iscanID = row.Unique;
            $scope.createOrEditIscan = 'edit';
            //
            setTimeout(function() {
                updateIscanlistGrid(row.Unique);
            }, 100);
            $('#icount_location').val(row.Location);
            $('#icount_comment').val(row.Comment);
            var fimp = row.FilesImported ? row.FilesImported : '-';
            $('#fileLoadedTemp').html('Files loaded: <br><b>' + fimp + '</b>');
            $('#fileLoadedTemp').show();
            setTimeout(function() {
                $('#icount_location').jqxDropDownList({disabled: true});
                $('#icount_file').jqxFileUpload({disabled: true});
                $('#iscanTabs').jqxTabs('select', 0);
                $('#iscanTabs').jqxTabs('enableAt', 1);
                $('#saveIscanBtn').html('Save');
                $('#saveIscanBtn').prop('disabled', true);
                $('#matchIscanBtn').hide();
            }, 100);
            var btn = $('<button/>', {
                'id': 'deleteIscanBtn'
            }).addClass('icon-trash user-del-btn').css('left', 0);
            var title = $('<div/>').html('Edit Item Count Scan | ID: ' + row.Unique + ' | ' + row.Comment).prepend(btn)
                .css('padding-left', '2em');
            iscanwind.setTitle(title);
            iscanwind.open();
        };

        $scope.saveScan = function(toClose) {
            var url = '';
            var data = {
                'Comment': $('#icount_comment').val(),
            };
            if ($scope.createOrEditIscan == 'create') {
                if ($scope.csvFileSelected == null || !$scope.csvFileSelected.success) {
                    $('#iscanErrorMsg #msg').html('You need to load a csv file.');
                    $scope.iscanErrorMsg.apply('open');
                    return;
                }
                url = SiteRoot + 'admin/ItemCount/createItemScan';
                data['Location']= $('#icount_location').val();
                data['Comment']= $('#icount_comment').val();
                data['filename']= $('#icount_file').data('filename');
            } else if ($scope.createOrEditIscan == 'edit') {
                url = SiteRoot + 'admin/ItemCount/updateItemScan/' + $scope.iscanID;
            }

            $.ajax({
                method: 'post',
                url: url,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        $('#saveIscanBtn').prop('disabled', true);
                        if ($scope.createOrEditIscan == 'create') {
                            $scope.iscanID = response.id;
                            $scope.createOrEditIscan = 'edit';
                            updateIscanlistGrid(response.id);
                            $('#iscanTabs').jqxTabs('enableAt', 1);
                            $('#iscanTabs').jqxTabs('select', 1);
                            //
                            var btn = $('<button/>', {
                                'id': 'deleteIscanBtn'
                            }).addClass('icon-trash user-del-btn').css('left', 0);
                            var title = $('<div/>').html('Edit Item Scan List | ID: '+ response.id + ' | ' + data.Comment)
                                .prepend(btn)
                                .css('padding-left', '2em');
                            iscanwind.setTitle(title);
                            $('#iscanSuccessMsg #msg').html(response.message);
                            $scope.iscanSuccessMsg.apply('open');
                        } else {
                            $('#iscanSuccessMsg #msg').html(response.message);
                            $scope.iscanSuccessMsg.apply('open');
                        }
                        updateIscanGrid();
                        if (toClose) {
                            iscanwind.close();
                            // $('#icountTabs').jqxTabs('select', 0);
                            // $('#icountTabs').jqxTabs('disableAt', 2);
                        }
                    } else if (response.status == 'error') {
                    } else {}
                }
            })
        };

        $('body').on('click', '#deleteIscanBtn', function(e) {
            $scope.deleteIscan();
        });

        $scope.deleteIscan = function(option) {
            if(option != undefined) {
                $('#mainIscanBtns').show();
                $('#closeIscanBtns').hide();
                $('#deleteIscanBtns').hide();
                $('#matchIscanBtnContainer').hide();
            }
            if (option == 0) {
                $.ajax({
                    url: SiteRoot + 'admin/ItemCount/deleteItemScan/' + $scope.iscanID,
                    method: 'post',
                    dataType: 'json',
                    success: function(response) {
                        if(response.status == 'success') {
                            updateIscanGrid();
                            iscanwind.close();
                            // $('#icountTabs').jqxTabs('select', 0);
                            // $('#icountTabs').jqxTabs('disableAt', 2);
                        }
                        else if (data.status == 'error') {}
                        else {}
                    }
                });
            } else if (option == 1) {
                iscanwind.close();
                // $('#iscanTabs').jqxTabs('select', 0);
                // $('#iscanTabs').jqxTabs('disableAt', 2);
            } else if (option == 2) {
            } else {
                $('#iscanTabs').jqxTabs('select', 0);
                $('#mainIscanBtns').hide();
                $('#closeIscanBtns').hide();
                $('#deleteIscanBtns').show();
                $('#matchIscanBtnContainer').hide();
            }
        };

        $scope.closeIscan = function(option) {
            if (option != undefined) {
                $('#mainIscanBtns').show();
                $('#closeIscanBtns').hide();
                $('#deleteIscanBtns').hide();
                $('#matchIscanBtnContainer').hide();
            }
            if (option == 0) {
                $scope.saveScan(1);
            } else if (option == 1) {
                iscanwind.close();
            } else if (option == 2) {
            } else {
                if ($('#saveIscanBtn').is(':disabled')) {
                    iscanwind.close();
                } else {
                    $('#mainIscanBtns').hide();
                    $('#closeIscanBtns').show();
                    $('#deleteIscanBtns').hide();
                    $('#matchIscanBtnContainer').hide();
                }
            }
        };

        $scope.matchIscan = function(option) {
            if (option != undefined) {
                $('#mainIscanBtns').show();
                $('#closeIscanBtns').hide();
                $('#deleteIscanBtns').hide();
                $('#matchIscanBtnContainer').hide();
            }

            if (option == 0) {
                $.ajax({
                    method: 'post',
                    url: SiteRoot + 'admin/ItemCount/itemMatchScan/' + $scope.iscanID ,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            updateIscanGrid();
                            updateIscanlistGrid($scope.iscanID);
                            $('#matchIscanBtn').hide();
                            // $('#icountGrid').jqxGrid('refresh');
                            // $('#icountGrid').jqxGrid('render');
                            $('#icountSuccessMsg #msg').html('List was updated with Items found.');
                            $scope.icountSuccessMsg.apply('open');
                            // icountwind.close();
                        }
                        else if (response.status == 'error') {}
                        else {}
                    }
                });
            } else if (option == 1) {
            } else {
                $('#mainIscanBtns').hide();
                $('#closeIscanBtns').hide();
                $('#deleteIscanBtns').hide();
                $('#matchIscanBtnContainer').show();
            }
        };

        $("body").on('cellvaluechanged', '#iscanlistGrid', function (event)
        {
            var value = event.args.newvalue;
            var oldvalue = event.args.oldvalue;
            var datafield = event.args.datafield;
            var rowBoundIndex = event.args.rowindex;
            var row = $(this).jqxGrid('getrowdata', rowBoundIndex);
            var data = {};
            if (datafield  == 'Barcode') {
                data['Barcode'] = value;
            }
            if (datafield  == 'Quantity') {
                data['Quantity'] = value;
            }
            if (datafield  == 'Comment') {
                data['Comment'] = value;
            }
            // if (data.length > 0) {
                $.ajax({
                    method: 'post',
                    url: SiteRoot + 'admin/ItemCount/updateItemScanList/' + row.Unique,
                    dataType: 'json',
                    data: data,
                    success: function (response) {}
                });
            // }
        })
        .on('rowselect rowunselect', '#iscanlistGrid', function(e) {
            var len = $('#iscanlistGrid').jqxGrid('selectedrowindexes').length;
            var delDisabled = true;
            if (len > 0) {
                delDisabled = false;
            }
            $('#delScanListBtn').prop('disabled', delDisabled);
        });

        $scope.delScanList = function() {
            var scangrid = $('#iscanlistGrid')
            if (confirm('Are you sure to delete selected items on item scan list?')) {
                var ids = [];
                var idx = scangrid.jqxGrid('selectedrowindexes');
                $.each(idx, function(i, el) {
                    ids.push(scangrid.jqxGrid('getrowdata', el).Unique);
                });
                $.ajax({
                    method: 'post',
                    url: SiteRoot + 'admin/ItemCount/massDeleteItemScanList',
                    dataType: 'json',
                    data: {ids: ids.join()},
                    success: function (response) {
                        updateIscanGrid();
                        updateIscanlistGrid($scope.iscanID);
                        scangrid.jqxGrid('unselectallrows');
                    }
                });
            }
        }
                
    });
