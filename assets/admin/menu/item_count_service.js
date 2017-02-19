(function() {
    "use strict";
    angular
        .module('akamaiposApp')
        .service('itemCountService', iCountService);

    iCountService.$inject = ['$http', 'adminService'];

    function iCountService($http, adminService) {

        var pager = adminService.loadPagerConfig();
        this.getIcountTableSettings = function(status) {
            if (status == undefined) {
                status = '';
            }
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
                        {name: '_Created', type: 'date'},
                        {name: 'CreatedByName', type: 'string'},
                        {name: 'Updated', type: 'string'},
                        {name: '_Updated', type: 'date'},
                        {name: 'UpdatedByName', type: 'string'},
                        {name: 'CountDate', type: 'string'},
                        {name: '_CountDate', type: 'string'},
                        {name: 'CountDateFormatted', type: 'date'},
                        {name: 'CategoryFilter', type: 'string'},
                        {name: 'SubCategoryFilter', type: 'string'},
                        {name: 'SupplierFilter', type: 'string'}
                    ],
                    id: 'Unique',
                    url: SiteRoot + 'admin/ItemCount/load_itemcount/' + status
                }),
                columns: [
                    {text: 'ID', dataField: 'Unique', width: '8%'},
                    {dataField: 'Location', hidden: true},
                    {dataField: 'Station', hidden: true},
                    {text: 'Location', dataField: 'LocationName', width: '10%',
                        filtertype: 'checkedlist'},
                    {text: 'Comment', dataField: 'Comment', width: '20%'},
                    {text:'Count Date', dataField: 'CountDateFormatted', width: '10%',
                        cellsformat:'MM/dd/yyyy', filtertype: 'date'},
                    // {text:'Status', dataField: 'StatusName', width: '10%',
                    //     filtertype: 'list'},
                    {text: 'Created', dataField: '_Created', width: '16%',
                        cellsformat:'MM/dd/yyyy hh:mmtt', filtertype: 'date'},
                    {text: 'Created By', dataField: 'CreatedByName', width: '10%',
                        filtertype: 'checkedlist'},
                    {dataField: 'Created', hidden: true},
                    {dataField: 'CountDate', hidden: true},
                    {dataField: '_CountDate', hidden: true},
                    {text: 'Updated', dataField: '_Updated', width: '16%',
                        cellsformat:'MM/dd/yyyy hh:mmtt', filtertype: 'date'},
                    {text: 'Updated By', dataField: 'UpdatedByName', width: '10%',
                        filtertype: 'checkedlist'}
                ],
                width: "99.7%",
                theme: 'arctic',
                filterable: true,
                showfilterrow: true,
                // ready: function() {
                //     $('#icountlistGrid').jqxGrid('updatebounddata', 'filter');
                // },
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

            var decimalCost = parseInt($('#decimalCost').val());
            var decimalQty = parseInt($('#decimalQty').val());
            // to change font color if is negative
            var cellclass = function (row, datafield, value, rowdata) {
                if (value < 0) {
                    return 'less_than';
                } else {
                    return 'greater_than';
                }
            };
            var cellbeginedit = function (index, datafield, columntype, value) {
                // var row = $('#icountlistGrid').jqxGrid('getrowdata', index);
                // if (row.Status == 2) return false;
                return true;
            };

            var cellsCost = function(index, column, value, defaultHtml) {
                var element = $(defaultHtml);
                var val = (isNaN(value) || value === '') ? '' : value.toFixed(decimalCost);
                element.html(val);
                return element[0].outerHTML;
            };

            var cellsCountStock = function(index, column, value, defaultHtml) {
                var element = $(defaultHtml);
                var val = (isNaN(value) || value === '') ? '' : value.toFixed(decimalQty);
                element.html(val);
                return element[0].outerHTML;
            };

            var cellsCurrentStock = function (index, column, value, defaultHtml) {
                var element = $(defaultHtml);
                if (value === '' || value == null) {
                    value = 0;
                }
                element.html(value.toFixed(decimalQty));

                return element[0].outerHTML;
            };

            var cellsDiff = function (index, column, value, defaultHtml) {
                var element = $(defaultHtml);
                var row = $('#icountlistGrid').jqxGrid('getrowdata', index);
                // var current = parseFloat(row.CurrentStock);
                // current = (!isNaN(current)) ? current : 0;
                // var diff = parseFloat(row.CountStock) - current;
                // diff = (isNaN(diff)) ? '' : diff.toFixed(decimalQty);
                // element.html(diff);
                // if (diff < 0) {
                //     element.css('color', 'red');
                // }
                if (!isNaN(value) && value != '') {
                    var diff = value.toFixed(decimalQty);
                    if (diff < 0)
                        element.css('color', 'red');
                    element.html(diff);
                } /*else if (row.CountStock != null) {
                    element.html(0);
                }*/ else {
                    element.html('');
                }

                return element[0].outerHTML;
            };

            var cellsNCount = function (index, column, value, defaultHtml) {
                var element = $(defaultHtml);
                var row = $('#icountlistGrid').jqxGrid('getrowdata', index);
                // var diff = parseFloat(row.CountStock) * parseFloat(row.TotalCost); //row.Cost
                // diff = (isNaN(diff)) ? '' : diff.toFixed(decimalCost);
                // element.html(diff);
                // if (diff < 0) {
                //     element.css('color', 'red');
                // }
                if (!isNaN(value) && value != '') {
                    var diff = value.toFixed(decimalCost);
                    if (diff < 0)
                        element.css('color', 'red');
                    element.html(diff);
                } else if (row.CountStock != null) {
                    element.html(0);
                } else {
                    element.html('');
                }
                return element[0].outerHTML;
            };

            var cellsACount = function (index, column, value, defaultHtml) {
                var element = $(defaultHtml);
                var row = $('#icountlistGrid').jqxGrid('getrowdata', index);
                // var diff;
                // if (isNaN(row.Difference)) {
                //     element.html('');
                // } else {
                //     diff = parseFloat(row.TotalCost) * parseFloat(row.Difference);
                //     diff = (isNaN(diff)) ? '' : diff.toFixed(decimalCost);
                //     element.html(diff);
                if (!isNaN(value) && value != '') {
                    var diff = value.toFixed(decimalCost);
                    if (diff < 0)
                        element.css('color', 'red');
                    element.html(diff);
                } else if (row.CountStock != null) {
                element.html(0);
                } else {
                    element.html('');
                }
                return element[0].outerHTML;
            };

            var aggregates = function (aggregatedValue, currentValue, column, record) {
                var fixed = 0;
                if (column == 'Cost' || column == 'NewCost' || column == 'AdjustedCost' || column == 'TotalCost') {
                    fixed = decimalCost;
                }
                if (column == 'CurrentStock' || column == 'CountStock' || column == 'Difference') {
                    fixed = decimalQty;
                }
                var sum;
                if (currentValue != null && currentValue != '') {
                    sum = (parseFloat(aggregatedValue) + parseFloat(currentValue));
                } else {
                    sum = parseFloat(aggregatedValue);
                }
                return sum.toFixed(fixed); //.toFixed(decimals);
                // return aggregatedValue + 1; //.toFixed(decimals);
            };

            var aggregatesrender = function (aggregates, column, element, summaryData) {
                var renderstring = "<div style='float: left; width: 100%; height: 100%;'>";
                $.each(aggregates, function (key, value) {
                    // if (value < 0) {}
                    renderstring += '<div style="position: relative; margin: 6px; text-align: right; overflow: hidden;"><b> ' + value + '</b></div>';
                });
                renderstring += "</div>";
                return renderstring;
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
                        {name: 'Cost', type: 'number'},
                        {name: 'TotalCost', type: 'number'},
                        {name: 'CurrentStock', type: 'number'},
                        {name: 'CountStock', type: 'number'},
                        {name: 'Difference', type: 'number'},
                        {name: 'NewCost', type: 'number'},
                        {name: 'AdjustedCost', type: 'number'},
                        {name: 'Location', type: 'string'},
                        {name: 'ItemStockLineUnique', type: 'number'},
                        {name: 'Station', type: 'string'},
                        {name: 'Comment', type: 'string'},
                        {name: 'Status', type: 'string'},
                        {name: 'StatusCount', type: 'string'},
                        {name: 'Created', type: 'string'},
                        {name: 'CreatedBy', type: 'string'},
                        {name: 'Updated', type: 'string'},
                        {name: 'UpdatedBy', type: 'string'}
                    ],
                    id: 'Unique',
                    url: url
                }, {async: false}),
                columns: [
                    {dataField: 'Unique', hidden: true},
                    {dataField: 'Cost', hidden: true},
                    {text: 'Item', dataField: 'Item', editable: false, width: '7%'},
                    {text: 'Part', dataField: 'Part', editable: false, width: '7%'},
                    {text: 'Description', dataField: 'Description', editable: false, width: '10%'},
                    {text: 'Supplier', dataField: 'Supplier', editable: false,
                        filtertype: 'checkedlist', width: '8%'},
                    {text: 'Category', dataField: 'Category', editable: false,
                        filtertype: 'checkedlist', width: '8%'},
                    {text: 'Cost', dataField: 'TotalCost', editable: false,
                        filtertype: 'number', width: '8%',cellsformat: 'd',
                        aggregates: [{ 'Total': aggregates }],
                        aggregatesrenderer: aggregatesrender,
                        cellsrenderer: cellsCost,
                        cellsalign: 'right', align: 'right'
                    },
                    {text: 'Stock', dataField: 'CurrentStock', editable: false,
                        cellsrenderer: cellsCurrentStock, filtertype: 'number',
                        cellsalign: 'right', align: 'right', width: '8%',
                        aggregates: [{ 'Total': aggregates }],
                        aggregatesrenderer: aggregatesrender},
                    {text: 'Count', dataField: 'CountStock', width: '7%',
                         cellbeginedit: cellbeginedit,
                         cellsrenderer: cellsCountStock, filtertype: 'number',
                         cellsalign: 'right', align: 'right',
                         aggregates: [{ 'Total': aggregates }],
                         aggregatesrenderer: aggregatesrender,
                         validation: function (cell, value) {
                            if (value < 0 || value == '' || isNaN(value)) {
                                return { result: false, message: "Count must be greater than or equal to 0." };
                            }
                            return true;
                        }
                    },
                    {text: 'Difference', dataField: 'Difference', editable: false, width: '8%',
                        cellsrenderer: cellsDiff, cellclassname:cellclass,
                        filtertype: 'number',cellsalign: 'right', align: 'right',
                        aggregates: [{ 'Total': aggregates }],
                        aggregatesrenderer: aggregatesrender},
                    {text: 'Comment', dataField: 'Comment', width: '10%'},
                    {text: 'New Cost', dataField: 'NewCost', editable: false,
                        cellsrenderer: cellsNCount, width: '8%',
                        cellsalign: 'right', align: 'right',cellsformat: 'd',
                        aggregates: [{ 'Total': aggregates }],
                        aggregatesrenderer: aggregatesrender
                    },
                    {text: 'Adj Cost', dataField: 'AdjustedCost', editable:false,
                        cellsrenderer: cellsACount, width: '8%',
                        cellsalign: 'right', align: 'right',cellsformat: 'd',
                        aggregates: [{ 'Total': aggregates }],
                        aggregatesrenderer: aggregatesrender
                    },
                    {dataField: 'StatusCount', hidden: true},
                    {dataField: 'Station', hidden: true},
                    {dataField: 'Created', hidden: true},
                    {dataField: 'Updated', hidden: true},
                    {dataField: 'CreatedBy', hidden: true},
                    {dataField: 'UpdatedBy', hidden: true}
                ],
                width: "100%",
                theme: 'arctic',
                showaggregates: true,
                showstatusbar: true,
                statusbarheight: 40,
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
                editmode: 'click',
                selectionmode: 'checkbox',
                enablehover: true
            }
        };

        this.getCategoryFilter = function() {
            return {
                source: {
                    datatype: "json",
                    datafields: [
                        {name: 'Unique'},
                        {name: 'MainName'}
                    ],
                    url: SiteRoot + 'admin/MenuItem/getCategoryList',
                },
                valueMember: "Unique",
                displayMember: "MainName",
                placeHolder: 'Select Category..',
                height: 30,
                // autoOpen: true
            };
        };

        this.getSubcategoryFilter = function(parent) {
            var url = '';
            if (parent != undefined)
                url = SiteRoot + 'admin/MenuItem/getSubcategoryList/' + parent;
            return {
                source: new $.jqx.dataAdapter({
                    datatype: "json",
                    datafields: [
                        {name: 'Unique'},
                        {name: 'Name'}
                    ],
                    url: url,
                    async: false
                }),
                valueMember: "Unique",
                displayMember: "Name",
                placeHolder: 'Select Subcategory..',
                multiSelect: true,
                showArrow: true,
                width: 300,
                height: 30
                // autoOpen: true
            };
        };

        this.getSupplierFilter = function() {
            return {
                source: new $.jqx.dataAdapter({
                    datatype: "json",
                    datafields: [
                        {name: 'Unique'},
                        {name: 'Company'}
                    ],
                    url: SiteRoot + 'admin/MenuItem/getSupplierList',
                    async: false
                }),
                valueMember: "Unique",
                displayMember: "Company",
                placeHolder: 'Select Supplier..',
                multiSelect: true,
                showArrow: true,
                width: 300,
                height: 30
                // autoOpen: true
            };
        };

        this.getScanFileSettings = function() {
            var settings = {
                source: new $.jqx.dataAdapter({
                    datatype: "json",
                    datafields: [
                        {name: 'Unique'},
                        {name: 'Comment'},
                        {name: '_nCreated'}
                    ],
                    url: SiteRoot + 'admin/ItemCount/load_itemcountscan/1/?orderBy=Unique&orderType=DESC',
                    async: false
                }),
                valueMember: "Unique",
                displayMember: "Comment",
                placeHolder: 'Select Scan File..',
                showArrow: true,
                width: 400,
                height: 30
                // autoOpen: true
            };
            settings.renderer = function(index, label, value) {
                var item = settings.source.records[index];
                var template =
                    '<div class="item-row-content">' +
                    '<span>' + item.Unique + ' - '+ item.Comment +'</span><br>' +
                    '<span>' + item._nCreated +'</span>' +
                    '</div>';
                return template;
            };

            settings.renderSelectedItem = function(index, item) {
                var item = item.originalItem;
                if (item != null) {
                    return item.Unique + ' - ' + item.Comment;
                }
                return '';
            };

            return settings;
        };

        this.getIscanlistInCount = function(id) {
            var url = '';
            if (id != undefined)
                url = SiteRoot + 'admin/ItemCount/load_itemscanInCount/' + id;
            return {
                source: new $.jqx.dataAdapter({
                    dataType: 'json',
                    dataFields: [
                        {name: 'Unique', type: 'int'},
                        {name: 'CountScanUnique', type: 'string'},
                        {name: 'Barcode', type: 'string'},
                        {name: 'Quantity', type: 'number'},
                        {name: 'Comment', type: 'string'},
                        {name: 'ItemUnique', type: 'string'},
                        {name: 'Item', type: 'string'},
                        {name: 'Part', type: 'string'},
                        {name: 'Description', type: 'string'},
                        {name: 'CountUnique', type: 'string'},
                        {name: 'Status', type: 'string'},
                        {name: 'ImportFile', type: 'string'},
                        {name: 'Created', type: 'date'},
                        {name: 'Updated', type: 'date'}
                    ],
                    id: 'Unique',
                    url: url
                }, {async: false}),
                columns: [
                    {text: 'ID', dataField: 'Unique', width: '10%', editable:false,
                        filtertype: 'number'},
                    {dataField: 'CountScanUnique', hidden: true},
                    {text: 'Barcode', dataField: 'Barcode', width: '15%', editable:false,
                        filtertype: 'input'},
                    {text: 'Quantity', dataField: 'Quantity', width: '15%', editable:false,
                        filtertype: 'number', validation: function (cell, value) {
                        if ( isNaN(value) || value < 0 ) {
                            return { result: false, message: "Quantity must be a number." };
                        }
                        return true;
                    }},
                    {text: 'Item', dataField: 'Item', width: '15%', editable: false,
                        filtertype: 'input'},
                    {text: 'Part', dataField: 'Part', width: '15%', editable: false,
                        filtertype: 'input'},
                    {text: 'Description', dataField: 'Description', width: '15%',editable: false,
                        filtertype: 'input'},
                    {text: 'Comment', dataField: 'Comment', width: '15%',
                        filtertype: 'input'},
                    {dataField: 'Status', hidden: true},
                    {dataField: 'ImportFile', hidden: true}
                ],
                width: "99.7%",
                theme: 'arctic',
                filterable: true,
                showfilterrow: true,
                sortable: true,
                pageable: true,
                editable: true,
                pageSize: pager.pageSize,
                pagesizeoptions: pager.pagesizeoptions,
                altRows: true,
                autoheight: true,
                autorowheight: true
            };
        };

        /**
         * ITEM SCAN GRID
         */
        this.getIscanTableSettings = function(status) {
            var nStatus = '';
            if (status != undefined)
                nStatus = status;
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
                        {name: 'FilesImported', type: 'string'},
                        // {name: 'StatusName', type: 'string'},
                        {name: 'Created', type: 'date'},
                        {name: 'CreatedByName', type: 'string'},
                        {name: 'Updated', type: 'date'},
                        {name: 'UpdatedByName', type: 'string'}
                    ],
                    id: 'Unique',
                    url: SiteRoot + 'admin/ItemCount/load_itemcountscan/' + nStatus
                }, {async: false}),
                columns: [
                    {text: 'ID', dataField: 'Unique', width: '8%', filtertype: 'number'},
                    {dataField: 'Location', hidden: true},
                    {dataField: 'Station', hidden: true},
                    {dataField: 'FilesImported', hidden: true},
                    {text: 'Location', dataField: 'LocationName', width: '12%',
                        filtertype: 'checkedlist'},
                    {text: 'Comment', dataField: 'Comment', width: '25%', filtertype: 'input'},
                    // {text:'Status', dataField: 'StatusName', width: '10%', filtertype: 'list'},
                    // {text:'Status', dataField: 'Status', width: '10%', filtertype: 'list'},
                    {text: 'Created', dataField: 'Created', width: '15%',
                        cellsformat:'MM/dd/yyyy hh:mmtt', filtertype: 'date'},
                    {text: 'Created By', dataField: 'CreatedByName', width: '12%',
                        filtertype: 'checkedlist'},
                    {text: 'Update', dataField: 'Updated', width: '15%',
                        cellsformat:'MM/dd/yyyy hh:mmtt', filtertype: 'date'},
                    {text: 'Updated By', dataField: 'UpdatedByName', width: '12%',
                        filtertype: 'checkedlist'},
                ],
                //
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
                autorowheight: true
            };
        };

        this.getIscanListTableSettings = function(id) {
            var url = '';
            if (id != undefined)
                url = SiteRoot + 'admin/ItemCount/load_itemcountscanlist/' + id;
            return {
                source: new $.jqx.dataAdapter({
                    dataType: 'json',
                    dataFields: [
                        {name: 'Unique', type: 'int'},
                        {name: 'CountScanUnique', type: 'string'},
                        {name: 'Barcode', type: 'string'},
                        {name: 'Quantity', type: 'number'},
                        {name: 'Comment', type: 'string'},
                        {name: 'ItemUnique', type: 'string'},
                        {name: 'Item', type: 'string'},
                        {name: 'Part', type: 'string'},
                        {name: 'Description', type: 'string'},
                        {name: 'CountUnique', type: 'string'},
                        {name: 'Status', type: 'string'},
                        {name: 'ImportFile', type: 'string'},
                        {name: 'Created', type: 'date'},
                        {name: 'CreatedByName', type: 'string'},
                        {name: 'Updated', type: 'date'},
                        {name: 'UpdatedByName', type: 'string'}
                    ],
                    id: 'Unique',
                    url: url
                }, {async: false}),
                columns: [
                    {text: 'ID', dataField: 'Unique', width: '8%', editable:false,
                     filtertype: 'number'},
                    {dataField: 'CountScanUnique', hidden: true},
                    {text: 'Barcode', dataField: 'Barcode', width: '10%',
                     filtertype: 'input'},
                    {text: 'Quantity', dataField: 'Quantity', width: '8%',
                     filtertype: 'number', validation: function (cell, value) {
                        if ( isNaN(value) || value < 0 ) {
                            return { result: false, message: "Quantity must be a number." };
                        }
                        return true;
                     }},
                    {text: 'Item', dataField: 'Item', width: '10%', editable: false,
                     filtertype: 'input'},
                    {text: 'Part', dataField: 'Part', width: '10%', editable: false,
                     filtertype: 'input'},
                    {text: 'Description', dataField: 'Description', width: '14%',editable: false,
                     filtertype: 'input'},
                    {text: 'Comment', dataField: 'Comment', width: '14%',
                     filtertype: 'input'},
                    {dataField: 'Status', hidden: true},
                    {text: 'ImportFile',dataField: 'ImportFile', width: '24%', editable:false,
                    filtertype: 'checkedlist'}
                ],
                width: "99.7%",
                // ready: function() {
                //     $('iscanlistGrid').jqxGrid('updatebounddata', 'filter');
                // },
                theme: 'arctic',
                filterable: true,
                showfilterrow: true,
                sortable: true,
                pageable: true,
                editable: true,
                pageSize: pager.pageSize,
                pagesizeoptions: pager.pagesizeoptions,
                altRows: true,
                autoheight: true,
                autorowheight: true,
                selectionmode: 'checkbox',
                enablehover: true
            };
        };
    }
})();