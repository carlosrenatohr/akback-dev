/**
 * Created by carlosrenato on 10-26-16.
 */

(function() {
    "use strict";
    angular
        .module('akamaiposApp')
        .service('questionService', QuestionService);

    QuestionService.$inject = ['$http', 'adminService'];
    function QuestionService($http, adminService) {

        var _this = this;
        // Row subgrid - Create choices nested grid
        var rowExpanded;
        var questionGrid = $('#questionMainTable, #questionItemTable');
        questionGrid.on('rowexpand', function (e) {
            var current = e.args.rowindex;
            if (rowExpanded != current) {
                $(this).jqxGrid('hiderowdetails', rowExpanded);
                rowExpanded = current;
            }
        });

        this.getRowdetailsFromChoices = function(field) {
            return function (index, parentElement, gridElement, record) {
                var grid = $($(parentElement).children()[0]);
                //
                var unique = record[field] || record.Unique;
                var nestedGridAdapter = _this.getChoices(unique);
                if (grid != null) {
                    grid.jqxGrid({
                        source: nestedGridAdapter,
                        width: '98.7%',
                        columns: _this.getQuestionChoicesTableSettings().columns,
                        altRows: true,
                        autoheight: true,
                        autorowheight: true,
                        sortable: true
                    });
                }
            };
        };

        var pager = adminService.loadPagerConfig(true);
        this.getQuestionTableSettings = function(flag) {
            var url = '';
            if (flag == undefined)
                url = SiteRoot + 'admin/MenuQuestion/load_allquestions';
            var initrowdetails = _this.getRowdetailsFromChoices();
            return {
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
                        {name: 'LabelFontSize', type: 'string'},
                        {name: 'PictureFile', type: 'string'},
                        {name: 'PicturePath', type: 'string'}
                    ],
                    url: url
                }),
                columns: [
                    {text: 'ID', dataField: 'Unique', width: '20%'},
                    {text: 'Question Name', dataField: 'QuestionName', width: '20%'},
                    {text: 'Question', dataField: 'Question', type: 'string', width: '20%'},
                    {text: 'Status', dataField: 'Status', type: 'number', hidden: true},
                    {text: 'Minimum', dataField: 'Min', type: 'string', width: '20%'},
                    {text: 'Maximum', dataField: 'Max', type: 'string', width: '20%'},
                    {dataField: 'ButtonPrimaryColor', hidden: true},
                    {dataField: 'ButtonSecondaryColor', hidden: true},
                    {dataField: 'LabelFontColor', hidden: true},
                    {dataField: 'LabelFontSize', hidden: true},
                    {dataField: 'PictureFile', hidden: true},
                    {dataField: 'PicturePath', hidden: true}
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
                pageSize: pager.pageSize,
                pagesizeoptions: pager.pagesizeoptions,
                altRows: true,
                autoheight: true,
                autorowheight: true,
                //
                rowdetails: true,
                initrowdetails: initrowdetails,
                rowdetailstemplate: {
                    rowdetails: "<div class='choicesNestedGrid'></div>",
                    rowdetailsheight: 100,
                    rowdetailshidden: true
                }
            };
        };

        this.getQuestionChoicesTableSettings = function() {
            return {
                source: {
                    dataType: 'json',
                    dataFields: [
                        {name: 'Unique', type: 'int'},
                        {name: 'QuestionUnique', type: 'string'},
                        {name: 'ItemUnique', type: 'string'},
                        {name: 'Description', type: 'string'},
                        {name: 'Label', type: 'string'},
                        {name: 'sprice', type: 'number'},
                        {name: 'PriceLevel', type: 'string'},
                        {name: 'plPrice', type: 'number'},
                        {name: 'FixedPrice', type: 'number'},
                        {name: 'Sort', type: 'string'},
                        {name: 'ButtonPrimaryColor', type: 'string'},
                        {name: 'ButtonSecondaryColor', type: 'string'},
                        {name: 'LabelFontColor', type: 'string'},
                        {name: 'LabelFontSize', type: 'string'},
                        {name: 'PictureFile', type: 'string'},
                        {name: 'PicturePath', type: 'string'}
                    ],
                    // id: 'Unique',
                    url: SiteRoot + 'admin/MenuQuestion/load_questions_items/'
                },
                columns: [
                    {text: 'ID', dataField: 'Unique', width: '8%', filterable: false},
                    {text: 'Name', dataField: 'Description', width: '26%', filtertype: 'input'},
                    {text: 'Label', dataField: 'Label', width: '26%', filtertype: 'input'},
                    // {text: 'Price', dataField: 'sprice', width: '15%'},
                    {text: 'Price', dataField: 'plPrice', width: '13%', filtertype: 'input'},
                    {text: 'Fixed Price', dataField: 'FixedPrice', width: '12%', filtertype: 'input'},
                    {text: 'Level', dataField: 'PriceLevel', width: '5%', filtertype: 'checkedlist'},
                    {text: 'Sort', dataField: 'Sort', width: '10%', filtertype: 'text'},
                    {dataField: 'ButtonPrimaryColor', hidden: true},
                    {dataField: 'ButtonSecondaryColor', hidden: true},
                    {dataField: 'LabelFontColor', hidden: true},
                    {dataField: 'LabelFontSize', hidden: true},
                    {dataField: 'PictureFile', hidden: true},
                    {dataField: 'PicturePath', hidden: true}
                ],
                width: "100%",
                columnsResize: true,
                theme: 'arctic',
                pagerMode: 'default',
                autoheight: true,
                autorowheight: true,
                filterable: true,
                showfilterrow: true,
                sortable: true,
                pageable: false,
                pageSize: 10,
                altRows: true
            };
        };

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
                    {name: 'PriceLevel', type: 'string'},
                    {name: 'plPrice', type: 'string'},
                    {name: 'FixedPrice', type: 'string'},
                    {name: 'Sort', type: 'string'},
                    {name: 'ButtonPrimaryColor', type: 'string'},
                    {name: 'ButtonSecondaryColor', type: 'string'},
                    {name: 'LabelFontColor', type: 'string'},
                    {name: 'LabelFontSize', type: 'string'},
                    {name: 'PictureFile', type: 'string'},
                    {name: 'PicturePath', type: 'string'}
                ],
                id: 'Unique',
                url: SiteRoot + 'admin/MenuQuestion/load_questions_items/' + questionId
            });
        };

    }
})();

// app.service('questionService', function ($http) {});