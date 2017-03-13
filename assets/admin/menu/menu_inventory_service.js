/**
 * Created by carlosrenato on 09-01-16.
 */
app.service('itemInventoryService', function ($http, inventoryExtraService, adminService) {

    // Data for items inventory grid
    var decimalCost = parseInt($('#decimalCost').val());
    var decimalQty = parseInt($('#decimalQty').val());
    this.getInventoryGridData = function (empty, match) {
        var url = '';
        var extraSettings = {};
        var pages = adminService.loadPagerConfig();
        if (empty == undefined) {
            url = SiteRoot + 'admin/MenuItem/getItemsData';
            if (match != undefined) {
                url += ('/?custom=') + match;
                extraSettings.loadComplete = function() {
                    $('#loadingMenuItem').hide();
                }
            }
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
                    {name: 'ListPrice', type: 'number'},
                    {name: 'price1', type: 'number'},
                    {name: 'price2', type: 'number'},
                    {name: 'price3', type: 'number'},
                    {name: 'price4', type: 'number'},
                    {name: 'price5', type: 'number'},
                    {name: 'Cost', type: 'number'},
                    {name: 'Cost_Extra', type: 'number'},
                    {name: 'Cost_Freight', type: 'number'},
                    {name: 'Cost_Duty', type: 'number'},
                    {name: 'Cost_Landed', type: 'number'},
                    {name: 'Quantity', type: 'number'},
                    {name: 'QuantityLoc1', type: 'number'},
                    {name: 'QuantityLoc2', type: 'number'},
                    {name: 'QuantityLoc3', type: 'number'},
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
                    {name: 'Points', type: 'string'},
                    {name: 'ItemLabelVal', type: 'string'},
                    {name: 'ButtonPrimaryColor', type: 'string'},
                    {name: 'ButtonSecondaryColor', type: 'string'},
                    {name: 'LabelFontColor', type: 'string'},
                    {name: 'LabelFontSize', type: 'string'}
                ],
                id: 'Unique',
                url: url
            }, extraSettings),
            columns: [
                {text: 'ID', dataField: 'Unique', type: 'int', width: '5%', filterType:'number'},
                {text: 'Item', dataField: 'Item', type: 'string', width: '10%', filterType:'input'},
                {text: 'Category', dataField: 'Category', type: 'string', width: '10%',
                    filtertype: 'checkedlist'},
                {text: 'SubCategory', dataField: 'SubCategory', filtertype: 'checkedlist', width: '10%'},
                {text: 'Supplier', datafield: 'Supplier', filtertype: 'checkedlist', width: '10%'},
                {text: 'Brand', datafield: 'Brand', filtertype: 'checkedlist', width: '9%'},
                {text: 'Description', dataField: 'Description', type: 'string', width: '12%', filterType:'input'},
                {text: 'List', dataField: 'ListPrice', align:'right', cellsalign:'right', width: '6%', filterType:'number'},
                {text: 'Sell', dataField: 'price1', align:'right', cellsalign:'right', width: '6%', filterType:'number'},
                {text: 'Cost', dataField: 'Cost', align:'right', cellsalign:'right',
                    width: '6%', filterType:'number', cellsformat: 'd' + decimalCost,},
                {text: 'Qty', dataField: 'Quantity', type: 'string', width: '4%',
                    align:'right',cellsalign:'right', filterType:'number'},
                {text: 'QLoc1', dataField: 'QuantityLoc1', type: 'string', width: '4%',
                    align:'right',cellsalign:'right', filterType:'number'},
                {text: 'QLoc2', dataField: 'QuantityLoc2', type: 'string', width: '4%',
                    align:'right',cellsalign:'right', filterType:'number'},
                {text: 'QLoc3', dataField: 'QuantityLoc3', type: 'string', width: '4%',
                    align:'right',cellsalign:'right', filterType:'number'},
                {dataField: 'CategoryId', type: 'string', hidden: true},
                {dataField: 'Part', hidden:true},
                {dataField: 'SubCategoryId', hidden: true},
                {dataField: 'price2', hidden:true},
                {dataField: 'price3', hidden:true},
                {dataField: 'price4', hidden:true},
                {dataField: 'price5', hidden:true},
                {dataField: 'Cost_Extra', hidden:true},
                {dataField: 'Cost_Freight', hidden:true},
                {dataField: 'Cost_Duty', hidden:true},
                {dataField: 'Cost_Landed', hidden:true},
                {datafield: 'SupplierId', hidden: true},
                {datafield: 'SupplierPart', hidden: true},
                // {datafield: 'Brand', hidden: true},
                {datafield: 'BrandId', hidden: true},
                {dataField: 'PromptPrice', hidden:true},
                {dataField: 'PromptDescription', hidden:true},
                {dataField: 'EBT', hidden:true},
                {dataField: 'GiftCard', hidden:true},
                {dataField: 'Group', hidden:true},
                {dataField: 'MinimumAge', hidden:true},
                {dataField: 'CountDown', hidden:true},
                {dataField: 'Points', hidden:true},
                {dataField: 'ItemLabelVal', hidden:true},
                {dataField: 'ButtonPrimaryColor', hidden: true},
                {dataField: 'ButtonSecondaryColor', hidden: true},
                {dataField: 'LabelFontColor', hidden: true},
                {dataField: 'LabelFontSize', hidden: true}
            ],
            width: "99.7%",
            theme: 'arctic',
            filterable: true,
            showfilterrow: true,
            // autoshowfiltericon: true,
            // ready: function() {
            //     $('#inventoryItemsGrid').jqxGrid('updatebounddata', 'filter');
            // },
            sortable: true,
            pageable: true,
            pageSize: pages.pageSize,
            pagesizeoptions: pages.pagesizeoptions,
            altRows: true,
            autoheight: true,
            autorowheight: true
        };
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
        // .tochange
        $('#stocklWind .stockl_input').on('change keypress valueChanged textChanged', function() {
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
        // Height resizing
        $('.inventoryItemsGridContainer').css({'height':  $(window).height()- 100, 'max-height': $(window).height() - 100});
        $(window).on('resize', function() {
            var windHeight = $(window).height();
            $('.inventoryItemsGridContainer').css({'height':  windHeight- 100});
            $('.inventoryItemsGridContainer').css({'max-height': windHeight - 100});
        })
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