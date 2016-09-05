/**
 * Created by carlosrenato on 09-01-16.
 */
app.service('itemInventoryService', function ($http) {

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
                {name: 'ListPrice', type: 'float'},
                {name: 'price1', type: 'float'},
                {name: 'price2', type: 'float'},
                {name: 'price3', type: 'float'},
                {name: 'price4', type: 'float'},
                {name: 'price5', type: 'float'},
                {name: 'Cost', type: 'float'},
                {name: 'Cost_Extra', type: 'float'},
                {name: 'Cost_Freight', type: 'float'},
                {name: 'Cost_Duty', type: 'float'},
                {name: 'Cost_Landed', type: 'float'},
                {name: 'Quantity', type: 'float'},
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
                {name: 'Points', type: 'float'},

            ],
            url: SiteRoot + 'admin/MenuItem/getItemsData',
            unique: 'Unique',
        }),
        columns: [
            {text: 'ID', dataField: 'Unique', type: 'int'},
            {text: 'Item Number', dataField: 'Item', type: 'string'},
            {text: '', dataField: 'Part', hidden:true},
            {text: 'Description', dataField: 'Description', type: 'string'},
            {text: 'Category', dataField: 'Category', type: 'string', filtertype: 'list'},
            {text: '', dataField: 'CategoryId', type: 'string', hidden: true},
            {text: 'SubCategory', dataField: 'SubCategory', type: 'string', filtertype: 'list'},
            {text: '', dataField: 'SubCategoryId', hidden: true},
            {text: 'Supplier', datafield: 'Supplier', type: 'string'},
            {text: '', datafield: 'SupplierId', hidden: true},
            {text: '', datafield: 'SupplierPart', hidden: true},
            {text: '', datafield: 'Brand', hidden: true},
            {text: '', datafield: 'BrandId', hidden: true},
            {text: 'Price', dataField: 'price1', type: 'string'},
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
            {text: 'Quantity', dataField: 'Quantity', type: 'string'},
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
        pageable: true
    };

    // Events to disable buttons
    this.onChangeEvents = function() {
        $('body')
            .on('keypress keyup paste change', '.inventory_tab .item_textcontrol', function (e) {
                $('#saveInventoryBtn').prop('disabled', false);
            })
            .on('change', '.item_combobox, .inventory_tab .cbxExtraTab', function(e) {
                $('#saveInventoryBtn').prop('disabled', false);
            });
    };

    this.setNotificationSettings = function (type) {
        return {
            width: "auto",
            appendContainer: '#notification_container_inventory',
            opacity: 0.9,
            closeOnClick: true,
            autoClose: true,
            showCloseButton: false,
            template: (type == 1) ? 'success' : 'error'
        }
    };
});