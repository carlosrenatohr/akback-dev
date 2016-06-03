/**
 * Created by carlosrenato on 06-03-16.
 */


app.controller('menuQuestionController', function ($scope) {

    var questionsWindow;
    $scope.questionWindowsFormSettings = {
        created: function (args) {
            questionsWindow = args.instance;
        },
        resizable: false,
        width: "60%", height: "50%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    $scope.questionTableSettings = {

    }

});