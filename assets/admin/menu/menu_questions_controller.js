/**
 * Created by carlosrenato on 06-03-16.
 */


app.controller('menuQuestionController', function ($scope) {

    var questionsWindow, tabsQuestionWindow;
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

    $scope.questionstabsSettings = {
        created: function (args) {
            tabsQuestionWindow = args.instance
        },
        theme: 'darkblue',
        selectedItem: 0
    };

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

    $scope.openQuestionWindows = function() {
        resetQuestionForm();
        questionsWindow.open();
    };

    $scope.closeQuestionWindow = function () {
        //if (option == 0) {
        //    $scope.SaveCategoryWindows();
        //    $('#mainButtonsForCategories').show();
        //    $('.alertButtonsMenuCategories').hide();
        //} else if (option == 1) {
        //    categoryWindow.close();
        //    resetCategoryWindows();
        //} else if (option == 2) {
        //    $('#promptToSaveInCloseButtonCategory').hide();
        //    $('#mainButtonsForCategories').show();
        //} else {
            if ($('#saveQuestionBtn').is(':disabled')) {
                questionsWindow.close();
                resetQuestionForm();
            }
            /*else {
                $('#mainButtonsForCategories').hide();
                $('.alertButtonsMenuCategories').hide();
                $('#promptToSaveInCloseButtonCategory').show();
            }*/
    };

    var resetQuestionForm = function() {
        $('#qt_QuestionName').val('');
        $('#qt_Question').val('');
        $('#qt_sort').val(1);
    };

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
                console.info($(el).attr('placeholder') + ' can not be empty!');
                needValidation = true;
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

            $.ajax({
                method: 'post',
                url: SiteRoot + 'admin/MenuQuestion/postQuestion',
                dataType: 'json',
                data: values,
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

            })
        }
    }

});