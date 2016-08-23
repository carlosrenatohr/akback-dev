/**
 * Created by carlosrenato on 06-03-16.
 */


app.controller('menuQuestionController', function ($scope) {

    var questionsWindow, tabsQuestionWindow;
    // --Question window settings
    $scope.questionWindowsFormSettings = {
        created: function (args) {
            questionsWindow = args.instance;
        },
        resizable: false,
        width: "65%", height: "100%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    // --Question table settings
    $scope.questionTableSettings = {
        source: {
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'int'},
                {name: 'QuestionName', type: 'string'},
                {name: 'Question', type: 'string'},
                {name: 'Status', type: 'number'},
                {name: 'Sort', type: 'number'},
                {name: 'Min', type: 'string'},
                {name: 'Max', type: 'string'}
            ],
            id: 'Unique',
            url: SiteRoot + 'admin/MenuQuestion/load_allquestions'
        },
        columns: [
            {text: 'ID', dataField: 'Unique', type: 'int'},
            {text: 'Question Name', dataField: 'QuestionName', type: 'string'},
            {text: 'Question', dataField: 'Question', type: 'string'},
            {text: 'Status', dataField: 'Status', type: 'number', hidden: true},
            {text: 'Minimum', dataField: 'Min', type: 'string'},
            {text: 'Maximum', dataField: 'Max', type: 'string'}
        ],
        columnsResize: true,
        width: "99.7%",
        theme: 'arctic',
        pageable: true,
        pageSize: 20,
        pagerMode: 'default',
        altRows: true,
        sortable: true,
        filterable: true,
        filterMode: 'simple',
    };

    // -- Question Item table settings
    $scope.questionItemTableSettings = {
        source: {
            columns: [
                {text: 'ID', dataField: 'Unique', type: 'int'},
                {text: 'Name', dataField: 'Description', type: 'string'},
                {text: 'Label', dataField: 'Label', type: 'string'},
                {text: 'Sort', dataField: 'Sort', type: 'number'}
            ]
        },
        width: "100%",
        columnsResize: true,
        theme: 'arctic',
        pagerMode: 'default'
    };

    // -- Question tabs settings
    $scope.questionstabsSettings = {
        created: function (args) {
            tabsQuestionWindow = args.instance
        },
        theme: 'darkblue',
        selectedItem: 0
    };

    $('#questionstabsWin').on('tabclick', function (event) {
        var tabclicked = event.args.item;
        //
        if (tabclicked == 0 ) {
            $(this).jqxTabs({height:"300px"});
            $('#deleteQuestionBtn').show();
        }
        if (tabclicked == 1 ) {
            $(this).jqxTabs({height:"100%"});
            $('#deleteQuestionBtn').hide();
            if($scope.questionId != null) {
                $scope.$apply(function() {
                    updateItemQuestiontable();
                });
            }
        }
    });

    // -- Notification settings
    var notificationSet = function (type, sector) {
        return {
            width: "auto",
            appendContainer: (sector == 'item') ? "#qItemNotification" : "#notification_container",
            opacity: 0.9,
            closeOnClick: true,
            autoClose: true,
            showCloseButton: false,
            template: (type == 1) ? 'success' : 'error'
        }
    };
    $scope.questionNotificationsSuccessSettings = notificationSet(1);
    $scope.questionNotificationsErrorSettings = notificationSet(0);

    $scope.qItemSuccessNotif = notificationSet(1, 'item');
    $scope.qItemErrorNotif = notificationSet(0, 'item');

    // -- Create and edit actions on question form
    $scope.newOrEditQuestionOption = null;
    $scope.questionId = null;
    $scope.openQuestionWindow = function() {
        $scope.newOrEditQuestionOption = 'new';
        $('#item-tab-2').hide();
        resetQuestionForm();
        questionsWindow.setTitle('Add New Question');
        questionsWindow.open();
    };

    $scope.editQuestionWindow = function(e) {
        var row = e.args.row;
        $scope.newOrEditQuestionOption = 'edit';
        $scope.questionId = row.Unique;
        $('#item-tab-2').show();
        $('#item-tab-2 .jqx-tabs-titleContentWrapper').css('margin-top', '0');
        $('#qt_QuestionName').val(row.QuestionName);
        $('#qt_Question').val(row.Question);
        $('#qt_sort').val((row.Sort != null) ? row.Sort : 0);
        $('#qt_max').val((row.Max != null) ? row.Max : 0);
        $('#qt_min').val((row.Min != null) ? row.Min : 0);
        $('#deleteQuestionBtn').show();
        questionsWindow.setTitle('Edit Question: ' + $scope.questionId + ' | Question: <b>' + row.QuestionName + '</b>');
        questionsWindow.open();
    };

    var resetQuestionForm = function() {
        //
        $('#mainButtonsQuestionForm').show();
        $('.alertButtonsQuestionForm').hide();
        $('#qt_QuestionName').val('');
        $('#qt_Question').val('');
        $('#qt_sort').val(1);
        //
        $('#questionstabsWin').jqxTabs({selectedItem: 0});
        $('#questionWindowForm .required-field').css({"border-color": "#ccc"});
        $('#deleteQuestionBtn').hide();
        $('#saveQuestionBtn').prop('disabled', true);
    };

    $scope.closeQuestionWindow = function (option) {
        if (option == 0) {
            $scope.saveQuestionWindow(option);
        } else if (option == 1) {
            questionsWindow.close();
            resetQuestionForm();
        } else if (option == 2) {
            $('.alertButtonsQuestionForm').hide();
            $('#mainButtonsQuestionForm').show();
            $('#promptToCloseQuestionForm').hide();
        } else {
            if ($('#saveQuestionBtn').is(':disabled')) {
                questionsWindow.close();
                resetQuestionForm();
            }
            else {
                $('#mainButtonsQuestionForm').hide();
                $('.alertButtonsQuestionForm').hide();
                $('#promptToCloseQuestionForm').show();
            }
        }
    };

    // -- Question Events controls
    $('#questionWindowForm .required-field').on('keypress keyup paste change', function (e) {
        var idsRestricted = ['qt_sort'];
        var inarray = $.inArray($(this).attr('id'), idsRestricted);
        if (inarray >= 0) {
            var charCode = (e.which) ? e.which : e.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                if (this.value == '' || this.value == 1) {
                    $('#questionNotificationsErrorSettings #notification-content')
                        .html($(this).attr('placeholder') + ' must be number!');
                    $scope.questionNotificationsErrorSettings.apply('open');
                }
                return false;
            }
            if (this.value.length > 2) {
                return false;
            }
        }
        $('#saveQuestionBtn').prop('disabled', false);
    });

    var validationQuestionForm = function() {
        var needValidation = true;
        $('#questionWindowForm .required-field').each(function(i, el) {
            if(el.value == '') {
                $('#questionNotificationsErrorSettings #notification-content').html($(el).attr('placeholder') + ' can not be empty!');
                $(el).css({"border-color": "#F00"});
                $scope.questionNotificationsErrorSettings.apply('open');
                needValidation = false;
            }
            else {
                $(el).css({"border-color": "#ccc"});
            }
        });

        return needValidation;
    };


    $scope.saveQuestionWindow = function(closed) {
        if (validationQuestionForm()) {
            var values = {
                'Question': $('#qt_Question').val(),
                'QuestionName': $('#qt_QuestionName').val(),
                'Sort': $('#qt_sort').val(),
                'Min': $('#qt_min').val(),
                'Max': $('#qt_max').val()
            };
            var url = '';
            if ($scope.newOrEditQuestionOption == 'edit') {
                url = 'admin/MenuQuestion/updateQuestion/' + $scope.questionId;
            }

            $.ajax({
                method: 'post',
                url: SiteRoot + ((url == '') ? 'admin/MenuQuestion/postQuestion' : url),
                dataType: 'json',
                data: values,
                success: function(data) {
                    $('#saveQuestionBtn').prop('disabled', true);
                    $scope.questionTableSettings = {
                        source: {
                            dataType: 'json',
                            dataFields: [
                                {name: 'Unique', type: 'int'},
                                {name: 'QuestionName', type: 'string'},
                                {name: 'Question', type: 'string'},
                                {name: 'Status', type: 'number'},
                                {name: 'Sort', type: 'number'}
                            ],
                            id: 'Unique',
                            url: SiteRoot + 'admin/MenuQuestion/load_allquestions'
                        },
                        created: function (args) {
                            args.instance.updateBoundData();
                        }
                    };
                    //
                    if ($scope.newOrEditQuestionOption == 'new') {
                        $('#questionNotificationsSuccessSettings #notification-content')
                            .html('Question created successfully!');
                        $scope.questionNotificationsSuccessSettings.apply('open');
                        setTimeout(function() {
                            $scope.closeQuestionWindow();
                        }, 1500);
                    } else if ($scope.newOrEditQuestionOption == 'edit') {
                        $('#questionNotificationsSuccessSettings #notification-content')
                            .html('Question updated successfully!');
                        $scope.questionNotificationsSuccessSettings.apply('open');
                        if (closed == 0) {
                            $scope.closeQuestionWindow();
                        }
                    }
                }


            });
        }
    };

    // -- Question Delete actions
    $scope.beforeDeleteQuestion = function() {
        $.ajax({
            method: 'post',
            url: SiteRoot + 'admin/MenuQuestion/deleteQuestion/' + $scope.questionId,
            dataType: 'json',
            success: function(data) {
                $scope.questionTableSettings = {
                    source: {
                        dataType: 'json',
                        dataFields: [
                            {name: 'Unique', type: 'int'},
                            {name: 'QuestionName', type: 'string'},
                            {name: 'Question', type: 'string'},
                            {name: 'Status', type: 'number'},
                            {name: 'Sort', type: 'number'}
                        ],
                        id: 'Unique',
                        url: SiteRoot + 'admin/MenuQuestion/load_allquestions'
                    },
                    created: function (args) {
                        args.instance.updateBoundData();
                    }
                };
                questionsWindow.close();
            }
        });
    };

    /**
     * -- Question items tab actions
     */

    var updateItemQuestiontable = function() {
        $scope.questionItemTableSettings = {
            source: {
                dataType: 'json',
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'QuestionUnique', type: 'string'},
                    {name: 'ItemUnique', type: 'string'},
                    {name: 'Description', type: 'string'},
                    {name: 'Label', type: 'string'},
                    {name: 'Sort', type: 'number'}
                ],
                id: 'Unique',
                url: SiteRoot + 'admin/MenuQuestion/load_questions_items/' + $scope.questionId
            },
            columns: [
                {text: 'ID', dataField: 'Unique', type: 'int', width: '10%'},
                {text: 'Name', dataField: 'Description', type: 'string', width: '40%'},
                {text: 'Label', dataField: 'Label', type: 'string', width: '40%'},
                {text: 'Sort', dataField: 'Sort', type: 'string', width: '10%'}
            ],
            width: "100%",
            created: function (args) {
                args.instance.updateBoundData();
            }
        }
    };

    var question_item_window, cbxItems;
    $scope.questionItemWindowsSettings = {
        created: function (args) {
            question_item_window = args.instance;
        },
        resizable: false,
        width: "50%", height: "45%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    var resetQuestionItemForm = function() {
        $('.itemQuestionFormContainer .required-in').css({"border-color": "#ccc"});
        $('#qItem_ItemUnique').jqxComboBox({'selectedIndex': -1});
        $('#qItem_sort').val(1);
        $('#qItem_Label').val('');
        //
        $('#mainQItemButtons').show();
        $('#promptToCloseQItemForm').hide();
    };

    $scope.newOrEditQItemOption = null;
    $scope.qitemId = null;

    $scope.openQuestionItemWin = function (e) {
        $scope.newOrEditQItemOption = 'create';
        $('#deleteQuestionItemBtnOnQuestionTab').hide();
        $('#saveQuestionItemBtnOnQuestionTab').prop('disabled', true);
        question_item_window.setTitle('Add New Question Item');
        question_item_window.open();
    };

    $scope.editQuestionItemTable = function (e) {
        var row = e.args.row;
        $scope.newOrEditQItemOption = 'edit';
        $scope.qitemId = row.Unique;

        var selectedItem;
        var itemCbx = $('#qItem_ItemUnique').jqxComboBox('getItemByValue', row.ItemUnique);
        if (itemCbx != undefined) {
            selectedItem = itemCbx.index
        } else selectedItem = -1;
        $('#qItem_ItemUnique').jqxComboBox({'selectedIndex': selectedItem});

        $('#qItem_sort').val(row.Sort);
        $('#qItem_Label').val(row.Label);
        $('#deleteQuestionItemBtnOnQuestionTab').show();
        $('#saveQuestionItemBtnOnQuestionTab').prop('disabled', true);
        question_item_window.setTitle('Edit Question Item: ' + $scope.qitemId + ' | Question ID: ' + $scope.questionId);
        question_item_window.open();
    };

    $scope.closeQuestionItemWin = function(option) {
        if (option == 0) {
            $scope.saveItemByQuestion(option);
        } else if (option == 1) {
            question_item_window.close();
            resetQuestionItemForm();
        } else if (option == 2) {
            $('#mainQItemButtons').show();
            $('#promptToCloseQItemForm').hide();
        } else {
            if ($('#saveQuestionItemBtnOnQuestionTab').is(':disabled')) {
                resetQuestionItemForm();
                question_item_window.close();
                //$('#saveQuestionItemBtnOnQuestionTab').prop('disabled', true);
            }
            else {
                $('#mainQItemButtons').hide();
                $('#promptToCloseQItemForm').show();
            }
        }
    };

    var dataAdapterItems =
        new $.jqx.dataAdapter(
        {
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'int'},
                {name: 'Description', type: 'string'},
                {name: 'Item', type: 'string'},
                {name: 'Part', type: 'string'},
                {name: 'Status', type: 'number'}
            ],
            id: 'Unique',
            url: SiteRoot + 'admin/MenuItem/load_allItems/?sort=ASC'
        }
    );

    $scope.itemsCbxSettings = {
        created: function (args) {
            cbxItems = args.instance;
        },
        placeHolder: 'Select an item',
        displayMember: "Description",
        valueMember: "Unique",
        width: "100%",
        itemHeight: 50,
        source: dataAdapterItems,
        theme: 'arctic'
    };

    $scope.itemsCbxSelecting = function(e) {
        var item = e.args.item;
        if (item) {
            $('#qItem_Label').val(item.label);
            $('#saveQuestionItemBtnOnQuestionTab').prop('disabled', false);
        }
    };

    $('.itemQuestionFormContainer .required-in').on('keypress keyup paste change', function(e) {
        var idsRestricted = ['qItem_sort'];
        //var inarray = $.inArray($(this).attr('id'), idsRestricted);
        //if (inarray >= 0) {
        //    var charCode = (e.which) ? e.which : e.keyCode;
        //    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        //        if (this.value == '') {
        //            $('#qItemErrorNotif #notification-content')
        //                .html('Sort value must be number!');
        //            $scope.qItemErrorNotif.apply('open');
        //        }
        //        return false;
        //    }
        //    if (this.value.length > 2) {
        //        return false;
        //    }
        //}
        $('#saveQuestionItemBtnOnQuestionTab').prop('disabled', false);
    });

    var beforeValidationsSaveItemQuestion = function() {
        var needvalidation = false;
        $('.itemQuestionFormContainer .required-in').each(function(index, el) {
            if (el.value == '') {
                needvalidation = true;
                $(el).css({"border-color": "#F00"});
                $('#qItemErrorNotif #notification-content')
                    .html($(el).attr('placeholder') + ' can not be empty!');
                $scope.qItemErrorNotif.apply('open');
            } else {
                $(el).css({"border-color": "#ccc"});
            }
        });
        //
        var cbxItemUnique = $('#qItem_ItemUnique').jqxComboBox('getSelectedItem');
        if (!cbxItemUnique) {
            $('#qItem_ItemUnique').css({"border-color": "#F00"});
            $('#qItemErrorNotif #notification-content')
                .html('Item value can not be empty!');
            $scope.qItemErrorNotif.apply('open');
            needvalidation = true;
        } else {
            $('#qItem_ItemUnique').css({"border-color": "#ccc"});
        }
        return needvalidation;
    };

    $scope.saveItemByQuestion = function(closed) {
        if (!beforeValidationsSaveItemQuestion()) {
            var data = {
                'QuestionUnique': $scope.questionId,
                'ItemUnique': $('#qItem_ItemUnique').jqxComboBox('getSelectedItem').value,
                'Sort': $('#qItem_sort').val(),
                'Label': $('#qItem_Label').val()
            };
            var url;
            if ($scope.newOrEditQItemOption == 'create') {
                url = 'admin/MenuQuestion/post_question_item';
            } else if ($scope.newOrEditQItemOption == 'edit') {
                url = 'admin/MenuQuestion/update_question_item/' + $scope.qitemId;
            }
            $.ajax({
                method: 'POST',
                url:  SiteRoot + url,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        updateItemQuestiontable();
                        $('#saveQuestionItemBtnOnQuestionTab').prop('disabled', true);
                        if ($scope.newOrEditQItemOption == 'create') {
                            $('#qItemSuccessNotif #notification-content')
                                .html('Question item created successfully!');
                            $scope.qItemSuccessNotif.apply('open');
                            setTimeout(function() {
                                $scope.closeQuestionItemWin();
                            }, 1500);
                        } else if ($scope.newOrEditQItemOption == 'edit') {
                            $('#qItemSuccessNotif #notification-content')
                                .html('Question Item updated!');
                            $scope.qItemSuccessNotif.apply('open');
                            if (closed == 0) {
                                $scope.closeQuestionItemWin();
                            }
                        }
                    } else {
                        $('#qItemErrorNotif #notification-content')
                            .html('There was an error!');
                        $scope.qItemErrorNotif.apply('open');
                    }
                }
            });
        }
    };

    $scope.deleteItemByQuestion = function() {
        $.ajax({
            method: 'POST',
            url:  SiteRoot + 'admin/MenuQuestion/delete_question_item/' + $scope.qitemId,
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success') {
                    updateItemQuestiontable();
                    $('#saveQuestionItemBtnOnQuestionTab').prop('disabled', true);
                    $('#qItemSuccessNotif #notification-content')
                        .html('Question item was deleted!');
                    $scope.qItemSuccessNotif.apply('open');
                    setTimeout(function() {
                        $scope.closeQuestionItemWin();
                    }, 1500);
                } else {
                    $('#qItemErrorNotif #notification-content')
                        .html('There was an error!');
                    $scope.qItemErrorNotif.apply('open');
                }
            }
        })
    };

    $scope.numberQuestion = {
        inputMode: 'simple',
        decimalDigits: 0,
        digits: 2,
        spinButtons: true,
        textAlign: 'left',
        width: '290px',
        height: 25,
        min: 0,
        value: 0
    };

});