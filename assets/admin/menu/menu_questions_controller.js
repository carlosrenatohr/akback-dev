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
        width: "50%", height: "100%",
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
                {name: 'Sort', type: 'number'}
            ],
            id: 'Unique',
            url: SiteRoot + 'admin/MenuQuestion/load_allquestions'
        },
        columns: [
            {text: 'ID', dataField: 'Unique', type: 'int'},
            {text: 'Question Name', dataField: 'QuestionName', type: 'string'},
            {text: 'Question', dataField: 'Question', type: 'string'},
            {text: 'Status', dataField: 'Status', type: 'number', hidden: true},
            {text: 'Sort', dataField: 'Sort', type: 'number'}
        ],
        columnsResize: true,
        width: "99.7%",
        theme: 'arctic',
        pageable: true,
        pageSize: 20,
        pagerMode: 'default',
        altRows: true,
        filterable: true,
        filterMode: 'simple'
    };

    // -- Question Item table settings
    $scope.questionItemTableSettings = {
        source: {
            columns: [
                {text: 'ID', type: 'int'},
                {text: 'Name', type: 'string'},
                {text: 'Label', type: 'string'},
                {text: 'Sort', type: 'number'}
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
        if (tabclicked == 1 ) {
            if($scope.questionId != null) {
                $scope.$apply(function() {
                    updateItemQuestiontable();
                });
            }
        }
    });

    var updateItemQuestiontable  = function() {
        $scope.questionItemTableSettings = {
            source: {
                dataType: 'json',
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'QuestionUnique', type: 'string'},
                    {name: 'ItemUnique', type: 'string'},
                    {name: 'Description', type: 'string'},
                    {name: 'Label', type: 'number'},
                    {name: 'Sort', type: 'number'}
                ],
                id: 'Unique',
                url: SiteRoot + 'admin/MenuQuestion/load_questions_items/' + ($scope.questionId)
            },
            columns: [
                {text: 'ID', dataField: 'Unique', type: 'int'},
                {text: 'Name', dataField: 'Description', type: 'string'},
                {text: 'Label', dataField: 'Label', type: 'string'},
                {text: 'Sort', dataField: 'Sort', type: 'number'}
            ],
            created: function (args) {
                args.instance.updateBoundData();
            }
        }
    };

    // -- Notification settings
    var notificationSet = function (type) {
        return {
            width: "auto",
            appendContainer: "#notification_container",
            opacity: 0.9,
            closeOnClick: true,
            autoClose: true,
            showCloseButton: false,
            template: (type == 1) ? 'success' : 'error'
        }
    };
    $scope.questionNotificationsSuccessSettings = notificationSet(1);
    $scope.questionNotificationsErrorSettings = notificationSet(0);

    // -- Create and edit actions on question form
    $scope.newOrEditQuestionOption = null;
    $scope.questionId = null;
    $scope.openQuestionWindow = function() {
        $scope.newOrEditQuestionOption = 'new';
        resetQuestionForm();
        questionsWindow.open();
    };

    $scope.editQuestionWindow = function(e) {
        var row = e.args.row;
        $scope.newOrEditQuestionOption = 'edit';
        $scope.questionId = row.Unique;
        $('#qt_QuestionName').val(row.QuestionName);
        $('#qt_Question').val(row.Question);
        $('#qt_sort').val(row.Sort);
        $('#deleteQuestionBtn').show();
        questionsWindow.open();
    };

    var resetQuestionForm = function() {
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
            $scope.saveQuestionWindow();
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
        $('#saveQuestionBtn').prop('disabled', false);
    });

    $('#questionWindowForm input[number]').on('keypress keyup paste change', function (e) {
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            if (this.value == '' || this.value == 1) {
                $('#questionNotificationsErrorSettings #notification-content')
                    .html($(this).attr('placeholder') + ' must be number!');
                $scope.questionNotificationsErrorSettings.apply('open');
            }
            return false;
        }
        $('#saveQuestionBtn').prop('disabled', false);
        return true;
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


    $scope.saveQuestionWindow = function() {
        if (validationQuestionForm()) {
            var values = {
                'Question': $('#qt_Question').val(),
                'QuestionName': $('#qt_QuestionName').val(),
                'sort': $('#qt_sort').val()
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
                            questionsWindow.close();
                            resetQuestionForm();
                        }, 2000);
                    } else if ($scope.newOrEditQuestionOption == 'edit') {
                        $('#questionNotificationsSuccessSettings #notification-content')
                            .html('Question updated successfully!');
                        $scope.questionNotificationsSuccessSettings.apply('open');
                        $('#saveQuestionBtn').prop('disabled', true);
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
                console.log(data);
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
    }

});