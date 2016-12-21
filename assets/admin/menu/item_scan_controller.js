/**
 * Created by carlosrenato on 12-16-16.
 */
angular.module("akamaiposApp", ['jqwidgets'])
    .controller('itemScanController', function($scope, $http, itemCountService, adminService) {

        $('#iscanTabs').on('tabclick', function(e) {
            var tab = e.args.item;
            var tabTitle = $('#iscanTabs').jqxTabs('getTitleAt', tab);
            if (tab == 0) {
                $('#matchIscanBtn').hide();
                // Filters tab
            } else if (tab == 1) {
                // $('#deleteIcountBtn').hide();
                $('#matchIscanBtn').show();
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
            fileInputName: 'file',
            multipleFilesUpload: false,
            autoUpload: true
        });

        $scope.csvFileSelected = null;
        $('#icount_file').on('select', function(e) {
            setTimeout(function(){
                $('.jqx-file-upload-buttons-container').css({display: 'none'});
            }, 100);
            }).on('remove', function(e) {

            }).on('uploadEnd', function(e) {
            $scope.csvFileSelected = JSON.parse(e.args.response);
            console.log($scope.csvFileSelected);
            if ($scope.csvFileSelected.success === true) {
                $('#fileLoadedTemp').show();
                    $('#icount_file').data('filename', $scope.csvFileSelected.name);
                    $('#fileLoadedTemp').html('File loaded: <b>' + $scope.csvFileSelected.original_name + '</b>');
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
            setTimeout(function() {
                $('#icount_location').jqxDropDownList({disabled: false});
                $('#icount_file').jqxFileUpload({disabled: false});
                $('#iscanTabs').jqxTabs('select', 0);
                $('#iscanTabs').jqxTabs('disableAt', 1);
                $('#saveIscanBtn').html('Import');
                $('#saveIscanBtn').prop('disabled', true);
            }, 100);
            iscanwind.setTitle('New Item Count Scan');
            iscanwind.open();
        };

        $scope.editScan = function (e) {
            var row = e.args.row.bounddata;
            $scope.iscanID = row.Unique;
            $scope.createOrEditIscan = 'edit';
            //
            updateIscanlistGrid(row.Unique);
            $('#icount_location').val(row.Location);
            $('#icount_comment').val(row.Comment);
            setTimeout(function() {
                $('#icount_location').jqxDropDownList({disabled: true});
                $('#icount_file').jqxFileUpload({disabled: true});
                $('#iscanTabs').jqxTabs('select', 0);
                $('#iscanTabs').jqxTabs('enableAt', 1);
                $('#saveIscanBtn').html('Save');
                $('#saveIscanBtn').prop('disabled', true);
            }, 100);
            iscanwind.setTitle('Edit Item Count Scan | ID: ' + row.Unique);
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
                            $('#iscanTabs').jqxTabs('select', 0);
                            $('#iscanTabs').jqxTabs('enableAt', 1);
                            //
                            // var btn = $('<button/>', {
                            //     'ng-click': 'finishIcount()',
                            //     'id': 'deleteIcountBtn'
                            // }).addClass('icon-32-trash user-del-btn').css('left', 0);
                            // var title = $('<div/>').html(' Edit Item Count | ID: '+ response.id + ' | ' + data.Comment).prepend(btn)
                            //     .css('padding-left', '2em');
                            // iscanwind.setTitle(title);
                            iscanwind.setTitle('Edit Item Scan List | ID: ' + response.id);
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
    });
