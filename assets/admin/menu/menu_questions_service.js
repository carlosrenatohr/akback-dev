/**
 * Created by carlosrenato on 10-26-16.
 */

(function() {
    "use strict";
    angular
        .module('akamaiposApp')
        .service('questionService', QuestionService);

    QuestionService.$inject = ['$http'];
    function QuestionService($http) {

        this.getChoices = function(questionId) {
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

        this.getTests = function() {};
    }
})();

// app.service('questionService', function ($http) {});