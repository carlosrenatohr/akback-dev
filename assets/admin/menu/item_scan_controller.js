/**
 * Created by carlosrenato on 12-16-16.
 */
angular.module("akamaiposApp", ['jqwidgets'])
    .controller('itemScanController', function($scope, $http, itemCountService, adminService) {

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

        function updateIscanGrid(id) {
            $('#iscanlistGrid').jqxGrid({
                source: itemCountService.getIscanTableSettings(id).source
            });
        }

        function updateIscanlistGrid(id) {
            $('#iscanlistGrid').jqxGrid({
                // source: itemCountService.getIscanTableSettings(id).source
            });
        }

        $('.icountField').on('change', function() {
            $('#saveIscanBtn').prop('disabled', false);
        });

        $scope.iscanGridSettings = itemCountService.getIscanTableSettings();

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
                console.log(e.args.response);
                $scope.csvFileSelected = JSON.parse(e.args.response);
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
            $('#icount_comment').val('');
            iscanwind.setTitle('New Item Count Scan');
            iscanwind.open();
        };

        $scope.saveScan = function(toClose) {
            if ($scope.csvFileSelected == null || !$scope.csvFileSelected.success) {
                $('#iscanErrorMsg #msg').html('You need to load a csv file.');
                $scope.iscanErrorMsg.apply('open');
                return;
            }
            var data = {
                'Location': $('#icount_location').val(),
                'Comment': $('#icount_comment').val(),
                'filename': $('#icount_file').data('filename')
            };

            $.ajax({
                method: 'post',
                url: SiteRoot + 'admin/ItemCount/createItemScan',
                data: data,
                success: function(response) {
                    console.log(response);
                    if (response.status == 'success') {
                        $('#saveIscanBtn').prop('disabled', true);
                        if ($scope.createOrEditIscan == 'create') {
                            $scope.iscanID = response.id;
                            $scope.createOrEditIscan = 'edit';

                            // updateIscanlistGrid($scope.iscanID);
                            //
                            // var btn = $('<button/>', {
                            //     'ng-click': 'finishIcount()',
                            //     'id': 'deleteIcountBtn'
                            // }).addClass('icon-32-trash user-del-btn').css('left', 0);
                            // var title = $('<div/>').html(' Edit Item Count | ID: '+ response.id + ' | ' + data.Comment).prepend(btn)
                            //     .css('padding-left', '2em');
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

        $scope.closeIscan = function(option) {
            if (option != undefined) {
                $('#mainIscanBtns').show();
                $('#closeIscanBtns').hide();
                $('#deleteIscanBtns').hide();
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
                }
            }
        };
    });
