/**
 * Created by carlosrenato on 06-03-16.
 */


app.controller('menuQuestionController', function ($scope) {

    var once = false;
    $('#MenuCategoriesTabs').on('tabclick', function (e) {
        var tabclicked = e.args.item;
        var tabTitle = $('#MenuCategoriesTabs').jqxTabs('getTitleAt', tabclicked);
        // Questions TAB - Reload queries
        if (tabTitle == 'Questions') {
            if (!once) {
                $('#qItem_ItemUnique').jqxComboBox({
                    source: dataAdapterItems()
                });
                updateQuestionMainTable();
                once = true;
            }
            else {
                $('#qItem_ItemUnique').jqxComboBox({
                    source: dataAdapterItems()
                });
                updateQuestionMainTable();
            }
        }
    });

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

    // Row subgrid - Create choices nested grid
    var purchaseGrid = $('#questionMainTable');
    purchaseGrid.on('rowexpand', function (e) {
        var current = e.args.rowindex;
        var rows = purchaseGrid.jqxGrid('getrows');
        for (var i = 0; i < rows.length; i++) {
            if (i != current)
                purchaseGrid.jqxGrid('hiderowdetails', i);
        }
    });

    var initrowdetails = function (index, parentElement, gridElement, record) {
        var grid = $($(parentElement).children()[0]);
        //
        var nestedGridAdapter = choicesData(record.Unique);
        if (grid != null) {
            grid.jqxGrid({
                source: nestedGridAdapter,
                width: '98.7%', height: '100%',
                columns: $scope.questionItemTableSettings.columns,
                altRows: true,
                autoheight: true,
                autorowheight: true
            });
        }
    };

    // -- Question table settings
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
            url: ''
        },
        columns: [
            {text: 'ID', dataField: 'Unique', width: '20%'},
            {text: 'Question Name', dataField: 'QuestionName', width: '20%'},
            {text: 'Question', dataField: 'Question', type: 'string', width: '20%'},
            {text: 'Status', dataField: 'Status', type: 'number', hidden: true},
            {text: 'Minimum', dataField: 'Min', type: 'string', width: '20%'},
            {text: 'Maximum', dataField: 'Max', type: 'string', width: '20%'}
        ],
        columnsResize: true,
        //height: 900,
        width: '99.7%',
        theme: 'arctic',
        pageable: true,
        pagerMode: 'default',
        sortable: true,
        filterable: true,
        showfilterrow: true,
        filterMode: 'simple',
        //sortable: true,
        pageSize: 15,
        pagesizeoptions: ['5', '10', '15'],
        altRows: true,
        autoheight: true,
        autorowheight: true,
        //
        rowdetails: true,
        initrowdetails: initrowdetails,
        rowdetailstemplate: {
            rowdetails: "<div class='choicesNestedGrid' style='margin:5px 0;'></div>",
            rowdetailsheight: 200,
            rowdetailshidden: true
        }
    };

    var updateQuestionMainTable = function() {
        $('#questionMainTable').jqxGrid({
            source: new $.jqx.dataAdapter({
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
                url: SiteRoot + 'admin/MenuQuestion/load_allquestions'
            })
        });
    };

    // -- Question Item table settings
    $scope.questionItemTableSettings = {
        source: {
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'int'},
                {name: 'QuestionUnique', type: 'string'},
                {name: 'ItemUnique', type: 'string'},
                {name: 'Description', type: 'string'},
                {name: 'Label', type: 'string'},
                {name: 'sprice', type: 'string'},
                {name: 'Sort', type: 'string'}
            ],
            id: 'Unique',
            url: SiteRoot + 'admin/MenuQuestion/load_questions_items/'
        },
        columns: [
            {text: 'ID', dataField: 'Unique', width: '10%'},
            {text: 'Name', dataField: 'Description', width: '32%'},
            {text: 'Label', dataField: 'Label', width: '32%'},
            {text: 'Sell Price', dataField: 'sprice', width: '16%'},
            {text: 'Sort', dataField: 'Sort', width: '10%'}
        ],
        width: "100%",
        columnsResize: true,
        theme: 'arctic',
        pagerMode: 'default',
        autoheight: true,
        autorowheight: true,
        sortable: true,
        pageable: true,
        pageSize: 10,
        altRows: true
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
        var parent = $(e.args.originalEvent.target).parents('.jqx-grid')[0];
        if ($(parent).attr('id') != 'questionMainTable')
            return;
        //
        var row = e.args.row.bounddata;
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
        $('#qt_min').val(0);
        $('#qt_max').val(0);
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

        if ($('#qt_max').val() < $('#qt_min').val()) {
            $('#questionNotificationsErrorSettings #notification-content')
                .html("Minimum can't be greater than Maximum");
            $('#qt_max, #qt_min').css({"border-color": "#F00"});
            $scope.questionNotificationsErrorSettings.apply('open');
            needValidation = false;
        } else
            $('#qt_max, #qt_min').css({"border-color": "#ccc"});

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
                    //
                    if ($scope.newOrEditQuestionOption == 'new') {
                        $('#questionNotificationsSuccessSettings #notification-content')
                            .html('Question created successfully!');
                        $scope.questionNotificationsSuccessSettings.apply('open');
                        //setTimeout(function() {
                            $scope.closeQuestionWindow();
                        //}, 1500);
                        updateQuestionMainTable();
                    } else if ($scope.newOrEditQuestionOption == 'edit') {
                        $('#questionNotificationsSuccessSettings #notification-content')
                            .html('Question updated successfully!');
                        $scope.questionNotificationsSuccessSettings.apply('open');
                        if (closed == 0) {
                            $scope.closeQuestionWindow();
                        }
                        $('#questionMainTable').jqxGrid('updatebounddata', 'filter');
                    }
                }


            });
        }
    };

    // -- Question Delete actions
    $scope.beforeDeleteQuestion = function(option) {
        if (option != undefined) {
            $('#mainButtonsQuestionForm').show();
            $('#promptToCloseQuestionForm').hide();
            $('#promptToDeleteQuestionForm').hide();
        }
        if (option == 0) {
            $.ajax({
                method: 'post',
                url: SiteRoot + 'admin/MenuQuestion/deleteQuestion/' + $scope.questionId,
                dataType: 'json',
                success: function (data) {
                    updateQuestionMainTable();
                    questionsWindow.close();
                }
            });
        } else if (option == 1) {
            $scope.closeQuestionWindow();
        } else if (option == 2) {
        } else {
            $('#mainButtonsQuestionForm').hide();
            $('#promptToCloseQuestionForm').hide();
            $('#promptToDeleteQuestionForm').show();
        }
    };

    /**
     * -- Question items tab actions
     */
    var choicesData = function(questionId) {
        if (questionId == undefined)
            questionId = $scope.questionId;

        return new $.jqx.dataAdapter({
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'int'},
                {name: 'QuestionUnique', type: 'string'},
                {name: 'ItemUnique', type: 'string'},
                {name: 'Description', type: 'string'},
                {name: 'Label', type: 'string'},
                {name: 'sprice', type: 'string'},
                {name: 'Sort', type: 'string'}
            ],
            id: 'Unique',
            url: SiteRoot + 'admin/MenuQuestion/load_questions_items/' + questionId
        });
    };

    var updateItemQuestiontable = function() {
        $('#_questionItemTable').jqxGrid({
            source: choicesData()
        });
    };

    var question_item_window, cbxItems;
    $scope.questionItemWindowsSettings = {
        created: function (args) {
            question_item_window = args.instance;
        },
        resizable: false,
        width: "60%", height: "55%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    var resetQuestionItemForm = function() {
        $('.itemQuestionFormContainer .required-in').css({"border-color": "#ccc"});
        $('#qItem_ItemUnique').jqxComboBox({'selectedIndex': -1});
        $('#qItem_sort').jqxNumberInput('val', 1);
        $('#qItem_SellPrice').jqxNumberInput('val', 0);
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
        var row = e.args.row.bounddata;
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
        if (option != undefined) {
            $('#mainQItemButtons').show();
            $('#promptToCloseQItemForm').hide();
        }
        if (option == 0) {
            $scope.saveItemByQuestion(option);
        } else if (option == 1) {
            resetQuestionItemForm();
            question_item_window.close();
        } else if (option == 2) {
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

    var dataAdapterItems = function(empty) {
        var url = '';
        if (empty == undefined)
            url = SiteRoot + 'admin/MenuItem/load_allItems/?sort=ASC';
        return new $.jqx.dataAdapter(
            {
                dataType: 'json',
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'Description', type: 'string'},
                    {name: 'price1', type: 'string'},
                    {name: 'Item', type: 'string'},
                    {name: 'Category', type: 'string'},
                    {name: 'SubCategory', type: 'string'},
                    {name: 'Status', type: 'string'}
                ],
                url: url
            });
    };

    $scope.itemsCbxSettings = {
        created: function (args) {
            cbxItems = args.instance;
        },
        placeHolder: 'Select an item',
        displayMember: "Description",
        valueMember: "Unique",
        searchMode: 'containsignorecase',
        width: "100%",
        itemHeight: 50,
        source: dataAdapterItems(1),
        theme: 'arctic',
        renderer: function(index, label, value) {
            var item = $('#qItem_ItemUnique').jqxComboBox('getItem', index).originalItem;
            var template =
                '<div class="item-row-content">' +
                '<span>' + item.Description + ' | '+ item.price1 +'</span><br>' +
                '<span>' + item.Category + ' | '+ item.SubCategory +'</span>' +
                '</div>';
            return template;
        }
    };

    $scope.itemsCbxSelecting = function(e) {
        if (e.args.item) {
            var item = e.args.item;
            $('#qItem_Label').val(item.label);
            $('#qItem_SellPrice').val(item.originalItem.price1);
            $('#saveQuestionItemBtnOnQuestionTab').prop('disabled', false);
        }
    };

    $('.itemQuestionFormContainer .required-in').on('keypress keyup paste change', function(e) {
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
                        } else if ($scope.newOrEditQItemOption == 'edit') {
                            $('#qItemSuccessNotif #notification-content')
                                .html('Question Item updated!');
                            $scope.qItemSuccessNotif.apply('open');
                        }
                        if (closed == 0) {
                            $scope.closeQuestionItemWin();
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

    $scope.deleteItemByQuestion = function(option) {
        if (option != undefined) {
            $('#mainQItemButtons').show();
            $('#promptToCloseQItemForm').hide();
            $('#promptToDeleteQItemForm').hide();
        }
        if (option == 0) {
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
                            $scope.closeQuestionItemWin();
                    } else {
                        $('#qItemErrorNotif #notification-content')
                            .html('There was an error!');
                        $scope.qItemErrorNotif.apply('open');
                    }
                }
            })
        } else if (option == 1) {
            $scope.closeQuestionItemWin();
        } else if (option == 2) {
        } else {
            $('#mainQItemButtons').hide();
            $('#promptToCloseQItemForm').hide();
            $('#promptToDeleteQItemForm').show();
        }
    };

    $scope.questionDisabled = true;
    $scope.numberQuestion = {
        inputMode: 'simple',
        decimalDigits: 0,
        //digits: 2,
        spinButtons: true,
        textAlign: 'left',
        width: '290px',
        height: 25,
        min: 0,
        value: 0
    };

    $scope.numberItemQuestion = {
        inputMode: 'simple',
        decimalDigits: 0,
        digits: 2,
        spinButtons: true,
        textAlign: 'left',
        width: '290px',
        height: 25
    };

});