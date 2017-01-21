/**
 * Created by carlosrenato on 06-03-16.
 */
app.controller('menuQuestionController', function ($scope, questionService) {

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
                // TODO IMPLEMENT this on item count and item scan to refresh filters and avoid loadin issue
                // TODO Read http://www.jqwidgets.com/community/topic/uncaught-typeerror-cannot-read-property-visiblerecords-of-null/
                // TODO about grids and 'visiblerecords' issues present on load a grid on subtab
                // $scope.questionTableSettings = questionService.getQuestionTableSettings(1);
                updateQuestionMainTable();

                setTimeout(function() {
                    updateQuestionMainTable();
                }, 250);
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

    // -- Question table settings
    $scope.questionTableSettings = questionService.getQuestionTableSettings();
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
                    {name: 'Max', type: 'string'},
                    {name: 'ButtonPrimaryColor', type: 'string'},
                    {name: 'ButtonSecondaryColor', type: 'string'},
                    {name: 'LabelFontColor', type: 'string'},
                    {name: 'LabelFontSize', type: 'string'}
                ],
                url: SiteRoot + 'admin/MenuQuestion/load_allquestions'
            })
        });
    };

    $('#questionMainTable').on('bindingcomplete', function(){});

    // -- Question Item table settings
    $scope.questionItemTableSettings = questionService.getQuestionChoicesTableSettings();
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
            // $('#deleteQuestionBtn').show();
        }
        if (tabclicked == 1 ) {
            $(this).jqxTabs({height:"100%"});
            // $('#deleteQuestionBtn').hide();
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
        //-- Primary Color Button
        var bpc;
        if (row['ButtonPrimaryColor'])
            bpc = row['ButtonPrimaryColor'];
        else
            bpc = '000000';
        $scope.ddb_qbPrimaryColor.setContent(getTextElementByColor(new $.jqx.color({ hex: bpc })));
        if ($('#qbPrimaryColor').jqxColorPicker('getColor') == undefined)
            $scope.qbPrimaryColor = bpc;
        else
            $('#qbPrimaryColor').jqxColorPicker('setColor', '#' + bpc);
        //-- Secondary Button color
        if (row['ButtonSecondaryColor'])
            bpc = row['ButtonSecondaryColor'];
        else
            bpc = '000000';
        $scope.ddb_qbSecondaryColor.setContent(getTextElementByColor(new $.jqx.color({ hex: bpc })));
        if ($('#qbSecondaryColor').jqxColorPicker('getColor') == undefined)
            $scope.qbSecondaryColor = bpc;
        else
            $('#qbSecondaryColor').jqxColorPicker('setColor', '#' + bpc);
        // Label Font Color
        if (row['LabelFontColor'])
            bpc = row['LabelFontColor'];
        else
            bpc = '000000';
        $scope.ddb_qlfontColor.setContent(getTextElementByColor(new $.jqx.color({ hex: bpc })));
        if ($('#qlfontColor').jqxColorPicker('getColor') == undefined)
            $scope.qlfontColor = bpc;
        else
            $('#qlfontColor').jqxColorPicker('setColor', '#' + bpc);
        // Label Font Size
        $('#qlfontSize').val(row['LabelFontSize']);
        // $('#deleteQuestionBtn').show();
        var btn = $('<button/>', {
            'id': 'deleteQuestionBtn'
        }).addClass('icon-trash user-del-btn').css('left', 0);
        var title = $('<div/>').html('Edit Question: ' + $scope.questionId + ' | Question: <b>' + row.QuestionName + '</b>')
            .prepend(btn)
            .css('padding-left', '2em');
        questionsWindow.setTitle(title);
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
        $scope.ddb_qbPrimaryColor.setContent(getTextElementByColor(new $.jqx.color({ hex: '000000' })));
        $('#qbPrimaryColor').jqxColorPicker('setColor', '#000000');
        $scope.ddb_qbSecondaryColor.setContent(getTextElementByColor(new $.jqx.color({ hex: '000000' })));
        $('#qbSecondaryColor').jqxColorPicker('setColor', '#000000');
        $scope.ddb_qlfontColor.setContent(getTextElementByColor(new $.jqx.color({ hex: '000000' })));
        $('#qlfontColor').jqxColorPicker('setColor', '#000000');
        $('#qlfontSize').val('12px');
        // $('#deleteQuestionBtn').hide();
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
            var bprimary = $('#qbPrimaryColor').jqxColorPicker('getColor');
            var bsecondary = $('#qbSecondaryColor').jqxColorPicker('getColor');
            var lfont = $('#qlfontColor').jqxColorPicker('getColor');
            var values = {
                'Question': $('#qt_Question').val(),
                'QuestionName': $('#qt_QuestionName').val(),
                'Sort': $('#qt_sort').val(),
                'Min': $('#qt_min').val(),
                'Max': $('#qt_max').val(),
                //
                'ButtonPrimaryColor': "#" + ((bprimary) ? bprimary.hex : '000'),
                'ButtonSecondaryColor': "#" + ((bsecondary) ? bsecondary.hex: '000'),
                'LabelFontColor': "#" + ((lfont) ? lfont.hex : '000'),
                'LabelFontSize': $('#qlfontSize').val()
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

    $('body').on('click', '#deleteQuestionBtn', function() {
        $scope.beforeDeleteQuestion();
    });

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

        return questionService.getChoices(questionId);
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
        width: "40%", height: "65%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    var resetQuestionItemForm = function() {
        $('.itemQuestionFormContainer .required-in').css({"border-color": "#ccc"});
        $('#qItem_ItemUnique').jqxComboBox('val', '');
        $('#qItem_sort').jqxNumberInput('val', 1);
        $('#qItem_SellPrice').jqxNumberInput('val', 0);
        $('#qItem_Label').val('');
        $scope.ddb_qibPrimaryColor.setContent(getTextElementByColor(new $.jqx.color({ hex: '000000' })));
        $scope.qibPrimaryColor = '#000000';
        $('#qibPrimaryColor').jqxColorPicker('setColor', '#000000');
        $scope.ddb_qibSecondaryColor.setContent(getTextElementByColor(new $.jqx.color({ hex: '000000' })));
        $scope.qibSecondaryColor = '#000000';
        $('#qibSecondaryColor').jqxColorPicker('setColor', '#000000');
        $scope.ddb_qilfontColor.setContent(getTextElementByColor(new $.jqx.color({ hex: '000000' })));
        $scope.qilfontColor = '#000000';
        $('#qilfontColor').jqxColorPicker('setColor', '#000000');
        $('#qilfontSize').val('12px');
        //
        $('#questionschoicestabsWin').jqxTabs('select', 0);
        $('#mainQItemButtons').show();
        $('#promptToCloseQItemForm').hide();
    };

    $scope.newOrEditQItemOption = null;
    $scope.qitemId = null;

    $scope.openQuestionItemWin = function (e) {
        $scope.newOrEditQItemOption = 'create';
        // $('#deleteQuestionItemBtnOnQuestionTab').hide();
        resetQuestionItemForm();
        $('#saveQuestionItemBtnOnQuestionTab').prop('disabled', true);
        question_item_window.setTitle('Add New Question Item');
        question_item_window.open();
    };

    $scope.editQuestionItemTable = function (e) {
        var row = e.args.row.bounddata;
        $scope.newOrEditQItemOption = 'edit';
        $scope.qitemId = row.Unique;
        //
        var selectedItem;
        var itemCbx = $('#qItem_ItemUnique').jqxComboBox('getItemByValue', row.ItemUnique);
        if (itemCbx != undefined) {
            selectedItem = itemCbx.index
        } else selectedItem = -1;
        $('#qItem_ItemUnique').jqxComboBox({'selectedIndex': selectedItem});
        $('#qItem_sort').val(row.Sort);
        $('#qItem_Label').val(row.Label);
        //-- Primary Button Color
        var bpc;
        if (row['ButtonPrimaryColor'])
            bpc = row['ButtonPrimaryColor'];
        else
            bpc = '000000';
        $scope.ddb_qibPrimaryColor.setContent(getTextElementByColor(new $.jqx.color({ hex: bpc })));
        if ($('#qibPrimaryColor').jqxColorPicker('getColor') == undefined)
            $scope.qibPrimaryColor = bpc;
        else
            $('#qibPrimaryColor').jqxColorPicker('setColor', '#' + bpc);
        //-- Secondary Button Color
        if (row['ButtonSecondaryColor'])
            bpc = row['ButtonSecondaryColor'];
        else
            bpc = '000000';
        $scope.ddb_qibSecondaryColor.setContent(getTextElementByColor(new $.jqx.color({ hex: bpc })));
        if ($('#qibSecondaryColor').jqxColorPicker('getColor') == undefined)
            $scope.qibSecondaryColor = bpc;
        else
            $('#qibSecondaryColor').jqxColorPicker('setColor', '#' + bpc);
        //-- Label Font Color
        if (row['LabelFontColor'])
            bpc = row['LabelFontColor'];
        else
            bpc = '000000';
        $scope.ddb_qilfontColor.setContent(getTextElementByColor(new $.jqx.color({ hex: bpc })));
        if ($('#qilfontColor').jqxColorPicker('getColor') == undefined)
            $scope.qilfontColor = bpc;
        else
            $('#qilfontColor').jqxColorPicker('setColor', '#' + bpc);

        $('#qilfontSize').val(row['LabelFontSize']);
        // $('#deleteQuestionItemBtnOnQuestionTab').show();
        $('#saveQuestionItemBtnOnQuestionTab').prop('disabled', true);
        //
        var btn = $('<button/>', {
            'id': 'deleteQuestionItemBtnOnQuestionTab'
        }).addClass('icon-trash user-del-btn').css('left', 0);
        var title = $('<div/>').html('Edit Question Item: ' + $scope.qitemId + ' | Question ID: ' + $scope.questionId).prepend(btn)
            .css('padding-left', '2em');
        question_item_window.setTitle(title);
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
        autoComplete: true,
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
        if (e.args) {
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
            var bprimary = $('#qibPrimaryColor').jqxColorPicker('getColor');
            var bsecondary = $('#qibSecondaryColor').jqxColorPicker('getColor');
            var lfont = $('#qilfontColor').jqxColorPicker('getColor');
            var data = {
                'QuestionUnique': $scope.questionId,
                'ItemUnique': $('#qItem_ItemUnique').jqxComboBox('getSelectedItem').value,
                'Sort': $('#qItem_sort').val(),
                'Label': $('#qItem_Label').val(),
                //
                'ButtonPrimaryColor': "#" + ((bprimary) ? bprimary.hex : '000'),
                'ButtonSecondaryColor': "#" + ((bsecondary) ? bsecondary.hex: '000'),
                'LabelFontColor': "#" + ((lfont) ? lfont.hex : '000'),
                'LabelFontSize': $('#qilfontSize').val()
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
                        updateQuestionMainTable();
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

    $('body').on('click', '#deleteQuestionItemBtnOnQuestionTab', function(){
        $scope.deleteItemByQuestion();
    });

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
                        updateQuestionMainTable();
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

    /**
     * Style Subtab
     */
    function getTextElementByColor(color) {
        if (color == 'transparent' || color.hex == "") {
            $('#qlfontSize').val('12px');
            $('#qilfontSize').val('12px');
            var el =  $("<div style='text-shadow: none; position: relative; padding-bottom: 2px; margin-top: 2px;'>#000000</div>");
            el.css({'color': 'white', 'background': '#000000'});
            el.addClass('jqx-rc-all');
            return el;
        }
        var element = $("<div style='text-shadow: none; position: relative; padding-bottom: 2px; margin-top: 2px;'>#" + color.hex + "</div>");
        var nThreshold = 105;
        var bgDelta = (color.r * 0.299) + (color.g * 0.587) + (color.b * 0.114);
        var foreColor = (255 - bgDelta < nThreshold) ? 'black' : 'white';
        element.css({'color': foreColor, 'background': "#" + color.hex});
        element.addClass('jqx-rc-all');
        return element;
    }

    $scope.qColorCreated = false;
    $scope.ddb_qbPrimaryColor = {};
    $scope.ddb_qbSecondaryColor = {};
    $scope.ddb_qlfontColor  = {};
    $scope.ddb_qibPrimaryColor = {};
    $scope.ddb_qibSecondaryColor = {};
    $scope.ddb_qilfontColor  = {};
    $scope.qOpening = function (event) {
        $scope.qColorCreated = true;
    };

    $scope.qColorChange = function (event) {
        var id = $(event.target).attr('id');
        var el = ($(event.target).data('layout'));
        $scope['ddb_' + id].setContent(getTextElementByColor(event.args.color));
        if (el == 'question') {
            $('#saveQuestionBtn').prop('disabled', false);
        } else if (el == 'choice')
            $('#saveQuestionItemBtnOnQuestionTab').prop('disabled', false);
    };

    $scope.$on('jqxDropDownButtonCreated', function (event, arguments) {
        arguments.instance.setContent(getTextElementByColor(new $.jqx.color({ hex: "000000" })));
    });

});