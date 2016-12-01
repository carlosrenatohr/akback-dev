(function() {
    "use strict";
    angular
        .module('akamaiposApp')
        .service('itemCountService', iCountService);

    iCountService.$inject = ['$http', 'adminService'];

    function iCountService($http, adminService) {

        var pager = adminService.loadPagerConfig();
        this.getIcountTableSettings = function() {
            return {
                source: new $.jqx.dataAdapter({
                    dataType: 'json',
                    dataFields: [
                        {name: 'Unique', type: 'int'},
                        {name: 'Location', type: 'string'},
                        {name: 'LocationName', type: 'string'},
                        {name: 'Station', type: 'string'},
                        {name: 'Comment', type: 'string'},
                        {name: 'Status', type: 'string'},
                        {name: 'StatusName', type: 'string'},
                        {name: 'Created', type: 'string'},
                        {name: 'CreatedByName', type: 'string'},
                        {name: 'Updated', type: 'string'},
                        {name: 'UpdatedByName', type: 'string'},
                        {name: 'CountDate', type: 'string'},
                        {name: 'CountDateFormatted', type: 'string'},
                        {name: 'hasCountList', type: 'string'}
                    ],
                    id: 'Unique',
                    url: SiteRoot + 'admin/ItemCount/load_itemcount'
                }),
                columns: [
                    {text: 'ID', dataField: 'Unique', width: '7%'},
                    {dataField: 'Location', hidden: true},
                    {dataField: 'Station', hidden: true},
                    {dataField: 'hasCountList', hidden: true},
                    {text: 'Location', dataField: 'LocationName', width: '12%'},
                    {text: 'Comment', dataField: 'Comment', width: '15%'},
                    {text:'Count Date', dataField: 'CountDateFormatted', width: '10%'},
                    {text:'Status', dataField: 'StatusName', width: '10%'},
                    {dataField: 'CountDate', hidden: true},
                    {dataField: 'Created', hidden: true},
                    {text: 'Created By', dataField: 'CreatedByName', width: '15%'},
                    {text: 'Updated By', dataField: 'UpdatedByName', width: '15%'},
                    {text: 'Updated', dataField: 'Updated', width: '15%'}
                ],
                width: "99.7%",
                theme: 'arctic',
                filterable: true,
                showfilterrow: true,
                ready: function() {
                    $('#icountlistGrid').jqxGrid('updatebounddata', 'filter');
                },
                sortable: true,
                pageable: true,
                pageSize: pager.pageSize,
                pagesizeoptions: pager.pagesizeoptions,
                altRows: true,
                autoheight: true,
                autorowheight: true
            };
        };

        this.getIcountlistTableSettings = function(id) {
            var url = '';
            if (id != undefined)
                url = SiteRoot + 'admin/ItemCount/load_allitemcountlist/' + id;

            // to change font color if is negative
            var cellclass = function (row, datafield, value, rowdata) {
                if (value < 0) {
                    return 'less_than';
                } else {
                    return 'greater_than';
                }
            };
            var cellbeginedit = function (index, datafield, columntype, value) {
                var row = $('#icountlistGrid').jqxGrid('getrowdata', index);
                if (row.Status == 2) return false;
            };

            var cellsrenderer = function (index, column, value, defaultHtml) {
                if (value == '' || value == null) {
                    var element = $(defaultHtml);
                    element.html(0);
                    return element[0].outerHTML;
                }
                // return defaultHtml;
                // var row = $('#icountlistGrid').jqxGrid('getrowdata', index);
                // if (row.Status == 1) {
                //     var element = $(defaultHtml);
                //     element.css('color', '#999');
                //     return element[0].outerHTML;
                // }
                return defaultHtml;
            };

            var cellsDiff = function (index, column, value, defaultHtml) {
                var element = $(defaultHtml);
                var row = $('#icountlistGrid').jqxGrid('getrowdata', index);
                var diff = parseFloat(row.CountStock) - parseFloat(row.CurrentStock);
                diff = (isNaN(diff)) ? 0 : diff;
                element.html(diff);
                if (diff < 0) {
                    element.css('color', 'red');
                }
                return element[0].outerHTML;
            };

            return {
                source: new $.jqx.dataAdapter({
                    dataType: 'json',
                    dataFields: [
                        {name: 'Unique', type: 'int'},
                        {name: 'Item', type: 'string'},
                        {name: 'Part', type: 'string'},
                        {name: 'Description', type: 'string'},
                        {name: 'Supplier', type: 'string'},
                        {name: 'SupplierPart', type: 'string'},
                        {name: 'Category', type: 'string'},
                        {name: 'CurrentStock', type: 'number'},
                        {name: 'CountStock', type: 'number'},
                        {name: 'Difference', type: 'number'},
                        {name: 'Location', type: 'string'},
                        {name: 'ItemStockLineUnique', type: 'number'},
                        {name: 'Station', type: 'string'},
                        {name: 'Comment', type: 'string'},
                        {name: 'Status', type: 'string'},
                        {name: 'Created', type: 'string'},
                        {name: 'CreatedBy', type: 'string'},
                        {name: 'Updated', type: 'string'},
                        {name: 'UpdatedBy', type: 'string'}
                    ],
                    id: 'Unique',
                    url: url
                }),
                columns: [
                    {dataField: 'Unique', hidden: true},
                    {text: 'Item', dataField: 'Item', editable: false},
                    {text: 'Part', dataField: 'Part', editable: false},
                    {text: 'Description', dataField: 'Description', editable: false},
                    {text: 'Supplier', dataField: 'Supplier', editable: false,
                        filtertype: 'list'},
                    {text: 'Category', dataField: 'Category', editable: false,
                        filtertype: 'list'},
                    {text: 'Cost', dataField: 'Cost', editable: false,
                        filtertype: 'number',
                        filtercondition: 'equal,less_than, greater_than'},
                    {text: 'Current', dataField: 'CurrentStock', editable: false,
                        cellsrenderer: cellsrenderer, filtertype: 'number'},
                    {text: 'Count', dataField: 'CountStock', cellsrenderer: cellsrenderer,
                        cellbeginedit: cellbeginedit, filtertype: 'number'},
                    {text: 'Difference', dataField: 'Difference', editable: false,
                        cellsrenderer: cellsDiff,
                        cellclassname:cellclass, filtertype: 'number',
                        filtercondition: 'equal,less_than, greater_than'
                    },
                    {text: 'Comment', dataField: 'Comment'},
                    {dataField: 'Station', hidden: true},
                    {dataField: 'Created', hidden: true},
                    {dataField: 'Updated', hidden: true},
                    {dataField: 'CreatedBy', hidden: true},
                    {dataField: 'UpdatedBy', hidden: true}
                ],
                width: "99.7%",
                theme: 'arctic',
                filterable: true,
                showfilterrow: true,
                sortable: true,
                pageable: true,
                pageSize: pager.pageSize,
                pagesizeoptions: pager.pagesizeoptions,
                altRows: true,
                autoheight: true,
                autorowheight: true,
                editable: true,
                editmode: 'click'
            }
        };
    }
})();