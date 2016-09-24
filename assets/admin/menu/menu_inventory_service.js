/**
 * Created by carlosrenato on 09-01-16.
 */
app.service('itemInventoryService', function ($http, inventoryExtraService) {

    // Data for items inventory grid
    this.getInventoryGridData = {
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
            {text: 'Description', dataField: 'Description', type: 'string', width: '20%'},
            {text: 'Category', dataField: 'Category', type: 'string', filtertype: 'list', width: '12%'},
            {text: '', dataField: 'CategoryId', type: 'string', hidden: true},
            {text: 'SubCategory', dataField: 'SubCategory', type: 'string', filtertype: 'list', width: '12%'},
            {text: '', dataField: 'SubCategoryId', hidden: true},
            {text: 'Supplier', datafield: 'Supplier', type: 'string', width: '12%'},
            {text: '', datafield: 'SupplierId', hidden: true},
            {text: '', datafield: 'SupplierPart', hidden: true},
            {text: '', datafield: 'Brand', hidden: true},
            {text: '', datafield: 'BrandId', hidden: true},
            {text: 'Price', dataField: 'price1', type: 'string', width: '10%', align:'right', cellsalign:'right'},
            {text: '', dataField: 'price2', hidden:true},
            {text: '', dataField: 'price3', hidden:true},
            {text: '', dataField: 'price4', hidden:true},
            {text: '', dataField: 'price5', hidden:true},
            {text: '', dataField: 'ListPrice', hidden:true},
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
        //height: "99.9%",
        theme: 'arctic',
        filterable: true,
        showfilterrow: true,
        ready: function() {
            $('#inventoryItemsGrid').jqxGrid('updatebounddata', 'filter');
        },
        sortable: true,
        pageable: true
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