/**
 * Created by carlosrenato on 09-01-16.
 */
app.service('itemInventoryService', function ($http, inventoryExtraService) {

    // Data for items inventory grid
    this.getInventoryGridData = function () {
        var pages;
        var ww = $(window).width();
        var wh = $(window).height();
        if (ww != undefined && wh != undefined) {
            pages = resizePagination(ww, wh);
        } else {
            pages = {
                pageSize: 2,
                pagesizeoptions: ['2', '10', '15']
            };
        }
        return {
            source: new $.jqx.dataAdapter({
                dataType: 'json',
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'Item', type: 'string'},
                    {name: 'Part', type: 'string'},
                    {name: 'Description', type: 'string'},
                    {name: 'Supplier', type: 'string'},
                    {name: 'SupplierId', type: 'int'},
                    {name: 'SupplierPart', type: 'string'},
                    {name: 'BrandId', type: 'int'},
                    {name: 'Brand', type: 'string'},
                    {name: 'ListPrice', type: 'string'},
                    {name: 'price1', type: 'string'},
                    {name: 'price2', type: 'string'},
                    {name: 'price3', type: 'string'},
                    {name: 'price4', type: 'string'},
                    {name: 'price5', type: 'string'},
                    {name: 'Cost', type: 'string'},
                    {name: 'Cost_Extra', type: 'string'},
                    {name: 'Cost_Freight', type: 'string'},
                    {name: 'Cost_Duty', type: 'string'},
                    {name: 'Cost_Landed', type: 'string'},
                    {name: 'Quantity', type: 'string'},
                    {name: 'CategoryId', type: 'int'},
                    {name: 'Category', type: 'string'},
                    {name: 'SubCategoryId', type: 'int'},
                    {name: 'SubCategory', type: 'string'},
                    {name: 'PromptPrice', type: 'string'},
                    {name: 'PromptDescription', type: 'string'},
                    {name: 'EBT', type: 'string'},
                    {name: 'GiftCard', type: 'string'},
                    {name: 'Group', type: 'string'},
                    {name: 'MinimumAge', type: 'int'},
                    {name: 'CountDown', type: 'int'},
                    {name: 'Points', type: 'string'}
                ],
                id: 'Unique',
                url: SiteRoot + 'admin/MenuItem/getItemsData'
            }),
            columns: [
                {text: 'ID', dataField: 'Unique', type: 'int', width: '10%'},
                {text: 'Item Number', dataField: 'Item', type: 'string', width: '18%'},
                {text: '', dataField: 'Part', hidden:true},
                {text: 'Category', dataField: 'Category', type: 'string', filtertype: 'list', width: '12%'},
                {text: '', dataField: 'CategoryId', type: 'string', hidden: true},
                {text: 'SubCategory', dataField: 'SubCategory', type: 'string', filtertype: 'list', width: '12%'},
                {text: '', dataField: 'SubCategoryId', hidden: true},
                {text: 'Description', dataField: 'Description', type: 'string', width: '20%'},
                {text: '', datafield: 'Supplier', hidden: 'true'},
                {text: '', datafield: 'SupplierId', hidden: true},
                {text: '', datafield: 'SupplierPart', hidden: true},
                {text: '', datafield: 'Brand', hidden: true},
                {text: '', datafield: 'BrandId', hidden: true},
                {text: 'List', dataField: 'ListPrice', width: '11%', align:'right', cellsalign:'right'},
                {text: 'Sell', dataField: 'price1', width: '11%', align:'right', cellsalign:'right'},
                {text: '', dataField: 'price2', hidden:true},
                {text: '', dataField: 'price3', hidden:true},
                {text: '', dataField: 'price4', hidden:true},
                {text: '', dataField: 'price5', hidden:true},
                {text: '', dataField: 'Cost', hidden:true},
                {text: '', dataField: 'Cost_Extra', hidden:true},
                {text: '', dataField: 'Cost_Freight', hidden:true},
                {text: '', dataField: 'Cost_Duty', hidden:true},
                {text: '', dataField: 'Cost_Landed', hidden:true},
                {text: 'Quantity', dataField: 'Quantity', type: 'string', width: '6%', align:'right',cellsalign:'right'},
                {text: '', dataField: 'PromptPrice', hidden:true},
                {text: '', dataField: 'PromptDescription', hidden:true},
                {text: '', dataField: 'EBT', hidden:true},
                {text: '', dataField: 'GiftCard', hidden:true},
                {text: '', dataField: 'Group', hidden:true},
                {text: '', dataField: 'MinimumAge', hidden:true},
                {text: '', dataField: 'CountDown', hidden:true},
                {text: '', dataField: 'Points', hidden:true},
            ],
            width: "100%",
            theme: 'arctic',
            filterable: true,
            showfilterrow: true,
            ready: function() {
                $('#inventoryItemsGrid').jqxGrid('updatebounddata', 'filter');
            },
            sortable: true,
            pageable: true,
            pageSize: pages.pageSize,
            pagesizeoptions: pages.pagesizeoptions,
            altRows: true,
            autoheight: true,
            autorowheight: true
        };
    }

    var resizePagination = function  (ww, wh) {
        var pagesResult = {};
        if (ww >= 1920 && wh >= 980) {
            // $('#inventoryItemsGrid').jqxGrid({
            //     pageSize: 25,
            //     pagesizeoptions: ['5', '15', '25'],
            //     // source: updateItemGridManually()
            // });
            pagesResult.pageSize = 25;
            pagesResult.pagesizeoptions = ['5', '15', '25'];
        }
        else if (ww >= 1280 && wh >= 980) {
            pagesResult.pageSize= 20;
            pagesResult.pagesizeoptions= ['5', '10', '20'];
        }
        else if (ww >= 1280 && wh >= 800) {
            pagesResult.pageSize = 18;
            pagesResult.pagesizeoptions = ['5', '10', '18'];
        }
        else if (ww >= 1024 && wh >= 768) {
            pagesResult.pageSize = 15;
            pagesResult.pagesizeoptions = ['5', '10', '15'];
        }
        else {
            pagesResult.pageSize = 10;
            pagesResult.pagesizeoptions = ['5', '10'];
        }

        return pagesResult;
    };

    // Events to disable buttons
    this.onChangeEvents = function() {
        // Inputs change event
        $('body')
            .on('keypress keyup paste change', '.inventory_tab .item_textcontrol', function (e) {
                $('#saveInventoryBtn').prop('disabled', false);
            })
            .on('change',
                '.item_combobox, ' +
                '.cbxItemTaxCell .jqx-checkbox, ' +
                '.inventory_tab .cbxExtraTab',
                function(e) {
                    $('#saveInventoryBtn').prop('disabled', false);
                })
        ;
        //
        $('#stocklWind .stockl_input.tochange').on('change', function() {
            $('#saveStockBtn').prop('disabled', false);
        });
        // Question subtab events
        $('#invQ_Status, #invQ_Question').on('select', function() {
            $('#saveQuestionInvBtn').prop('disabled', false);
        });
        // Printer subtab events
        $('#printerInvList').on('select', function(e) {
            $('#saveBtnPrinterInv').prop('disabled', false);
        });
        $('#primaryCheckContainer #primaryPrinterChbox').on('change', function(e) {
            $('#saveBtnPrinterInv').prop('disabled', false);
        });
    };

    this.setNotificationSettings = function (type, container) {
        if (container == undefined)
            container = '#notification_container_inventory';
        return {
            width: "auto",
            appendContainer: container,
            opacity: 0.9,
            closeOnClick: true,
            autoClose: true,
            showCloseButton: false,
            template: (type == 1) ? 'success' : 'error'
        }
    };
});