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
                $('#iscanlistGrid').jqxGrid('unselectallrows');
                $('#iscanlistGrid').hide();
                // Filters tab
            } else if (tab == 1) {
                // $('#deleteIcountBtn').hide();
                // $('#scan_tab2').prependTo(btns);
                $('#saveIscanBtn').hide();
                $('#matchIscanBtn').show();
                $('#delScanListBtn').show();
                setTimeout(function() {
                    $('#iscanlistGrid').show();
                    updateIscanlistGrid($scope.iscanID);
                }, 200);
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
            $('#iscanGrid1').jqxGrid({
                source: itemCountService.getIscanTableSettings(1).source,
                width: "99.7%",
                autoheight: true,
                autorowheight: true
            });
            $('#iscanGrid2').jqxGrid({
                source: itemCountService.getIscanTableSettings(2).source,
                width: "99.7%",
                autoheight: true,
                autorowheight: true
            });
        }

        function updateIscanlistGrid(id) {
            $('#iscanlistGrid').jqxGrid({
                source: itemCountService.getIscanListTableSettings(id).source,
                width: "99.7%",
                autoheight: true,
                autorowheight: true
            });
        }

        $('.icountField').on('change keyup keypress', function() {
            $('#saveIscanBtn').prop('disabled', false);
        });

        $scope.iscanGridPendingSettings = itemCountService.getIscanTableSettings(1);
        $scope.iscanGridCompleteSettings = itemCountService.getIscanTableSettings(2);
        $scope.iscanlistGridSettings = itemCountService.getIscanListTableSettings();

        // Notifications settings
        var notifContainer = '#notification_container_iscan';
        $scope.iscanSuccessMsg = adminService.setNotificationSettings(1, notifContainer, 5000);
        $scope.iscanErrorMsg = adminService.setNotificationSettings(0, notifContainer, undefined, false);

        $('#icount_file').jqxFileUpload({
            width: 300,
            uploadUrl: SiteRoot + 'admin/ItemCount/upload',
            fileInputName: 'file',
            multipleFilesUpload: true,
            autoUpload: true,
            accept: 'text/csv, text/plain, application/text'
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
            }).on('uploadStart', function(e) {
            }).on('uploadEnd', function(e) {
                $scope.iscanSuccessMsg.apply('closeAll');
                $scope.iscanErrorMsg.apply('closeAll');
                if (e.args.file == undefined)
                    return;
                $scope.csvFileSelected = JSON.parse(e.args.response);
                if ($scope.csvFileSelected.success === true) {
                    $('#iscanTabs').jqxTabs('disableAt', 1);
                    $('#fileLoadedTemp').show();
                    uploadedFilesSelected.push($scope.csvFileSelected.name);
                    uploadedFilesOriginal.push($scope.csvFileSelected.name);
                    // uploadedFilesOriginal.push($scope.csvFileSelected.original_name);
                    $('#icount_file').data('filename', uploadedFilesSelected.join());
                    $('#fileLoadedTemp').html('Files loaded: <br><b>' + uploadedFilesOriginal.join(', ') + '</b>');
                    // $('#fileLoadedTemp').html('Files loaded: <br><b>' + uploadedFilesSelected.join(', ') + '</b>');
                    var msg = "<br>Please press Save to view the file.";
                    $('#iscanSuccessMsg #msg').html($scope.csvFileSelected.message + msg);
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
            uploadedFilesSelected = [];
            uploadedFilesOriginal = [];
            $('#fileLoadedTemp').html('');
            setTimeout(function() {
                $('#icount_location').jqxDropDownList({disabled: false});
                $('#icount_file').jqxFileUpload({disabled: false});
                $('#iscanTabs').jqxTabs('select', 0);
                $('#iscanTabs').jqxTabs('disableAt', 1);
                $('#saveIscanBtn').prop('disabled', true);
                $('#saveIscanBtn').show();
                $('#matchIscanBtn').hide();
                $('#delScanListBtn').hide();
                $('#iscanlistGrid').hide();
            }, 100);
            iscanwind.setTitle('New Item Count Scan');
            iscanwind.open();
        };

        $scope.editScan = function (e) {
            var row = e.args.row.bounddata;
            $scope.iscanID = row.Unique;
            $scope.createOrEditIscan = 'edit';
            //
            // updateIscanlistGrid();
            $('#icount_location').val(row.Location);
            $('#icount_comment').val(row.Comment);
            var fimp = row.FilesImported ? row.FilesImported : '-';
            uploadedFilesOriginal = fimp.split(',');
            $('#fileLoadedTemp').html('Files loaded: <br><b>' + fimp + '</b>');
            $('#fileLoadedTemp').show();
            setTimeout(function() {
                $('#icount_location').jqxDropDownList({disabled: true});
                $('#icount_file').jqxFileUpload({disabled: false});
                $('#iscanTabs').jqxTabs('select', 0);
                $('#iscanTabs').jqxTabs('enableAt', 1);
                $('#saveIscanBtn').prop('disabled', true);
                $('#saveIscanBtn').show();
                $('#matchIscanBtn').hide();
                $('#delScanListBtn').hide();
                $('#iscanlistGrid').hide();
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
            //
            $scope.iscanSuccessMsg.apply('closeAll');
            $scope.iscanErrorMsg.apply('closeAll');
            //
            var url = '';
            var data = {
                'Comment': $('#icount_comment').val(),
                'filename': $('#icount_file').data('filename')
            };
            if ($scope.createOrEditIscan == 'create') {
                if ($scope.csvFileSelected == null || !$scope.csvFileSelected.success) {
                    $('#iscanErrorMsg #msg').html('You need to load a csv file.');
                    $scope.iscanErrorMsg.apply('open');
                    return;
                }
                url = SiteRoot + 'admin/ItemCount/createItemScan';
                data['Location']= $('#icount_location').val();
                // data['Comment']= $('#icount_comment').val();
            } else if ($scope.createOrEditIscan == 'edit') {
                url = SiteRoot + 'admin/ItemCount/updateItemScan/' + $scope.iscanID;
            }

            $.ajax({
                method: 'POST',
                url: url,
                data: data,
                dataType: 'text',
                async: false,
                success: function(response) {
                    response = response.replace(/<br\s*[\/]?>/gi, '');
                    response = JSON.parse(response);
                    if (response.status == 'success') {
                        $('#saveIscanBtn').prop('disabled', true);
                        if ($scope.createOrEditIscan == 'create') {
                            $scope.iscanID = response.id;
                            $scope.createOrEditIscan = 'edit';
                            // updateIscanlistGrid(response.id);
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
                            //
                            $scope.matchIscan(0, true);
                        } else {
                            $('#iscanSuccessMsg #msg').html(response.message);
                            $scope.iscanSuccessMsg.apply('open');
                        }
                        $('#saveIscanBtn').hide();
                        $('#matchIscanBtn').show();
                        $('#delScanListBtn').show();
                        // Force to close notification
                        setTimeout(function(){
                            $scope.iscanSuccessMsg.apply('closeAll');
                        }, 3000);
                        // Close or show grids
                        if (toClose) {
                            setTimeout(function() {
                                updateIscanGrid();
                            }, 250);
                            iscanwind.close();
                            // $('#icountTabs').jqxTabs('select', 0);
                            // $('#icountTabs').jqxTabs('disableAt', 2);
                        } else {
                            setTimeout(function() {
                                updateIscanGrid();
                                $('#iscanTabs').jqxTabs('enableAt', 1);
                                $('#iscanTabs').jqxTabs('select', 1);
                                $('#iscanlistGrid').show();
                                updateIscanlistGrid($scope.iscanID);
                            }, 250);
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
                $scope.matchIscan(0, true);
                iscanwind.close();
            } else if (option == 2) {
            } else {
                if ($('#saveIscanBtn').is(':disabled')) {
                    $scope.matchIscan(0, true);
                    iscanwind.close();
                } else {
                    $('#mainIscanBtns').hide();
                    $('#closeIscanBtns').show();
                    $('#deleteIscanBtns').hide();
                    $('#matchIscanBtnContainer').hide();
                }
            }
        };

        $scope.matchIscan = function(option, close) {
            if (option != undefined) {
                $('#mainIscanBtns').show();
                $('#closeIscanBtns').hide();
                $('#deleteIscanBtns').hide();
                $('#matchIscanBtnContainer').hide();
            }

            if (option == 0) {
                if ($scope.iscanID != null) {
                    $.ajax({
                        method: 'post',
                        url: SiteRoot + 'admin/ItemCount/itemMatchScan/' + $scope.iscanID ,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 'success') {
                                // $('#matchIscanBtn').hide();
                                if (close == undefined) {
                                    setTimeout(function(){
                                        updateIscanGrid();
                                        $('#iscanlistGrid').show();
                                        updateIscanlistGrid($scope.iscanID);
                                    }, 250);
                                    $('#iscanSuccessMsg #msg').html('List was updated with Items found.');
                                    $scope.iscanSuccessMsg.apply('open');
                                }
                            }
                            else if (response.status == 'error') {}
                            else {}
                        }
                    });
                }
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
                data['Barcode'] = $.trim(value);
            }
            if (datafield  == 'Quantity') {
                data['Quantity'] = $.trim(value);
            }
            if (datafield  == 'Comment') {
                data['Comment'] = $.trim(value);
            }
            // if (data.length > 0) {
                $.ajax({
                    method: 'post',
                    url: SiteRoot + 'admin/ItemCount/updateItemScanList/' + row.Unique,
                    dataType: 'json',
                    data: data,
                    success: function (response) {
                        setTimeout(function() {
                            $('#iscanlistGrid').show();
                            updateIscanlistGrid($scope.iscanID);
                        }, 200);
                    }
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
            var scangrid = $('#iscanlistGrid');
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