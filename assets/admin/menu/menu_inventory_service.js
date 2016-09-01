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
                {name: 'Description', type: 'string'},
                {name: 'Category', type: 'string'},
                {name: 'SubCategory', type: 'string'},
                {name: 'Supplier', type: 'string'},
                {name: 'SupplierUnique', type: 'int'},
                {name: 'CategoryUnique', type: 'int'},
                {name: 'price1', type: 'string'},

            ],
            url: SiteRoot + 'admin/MenuItem/getItemsData'
        }),
        columns: [
            {text: 'ID', dataField: 'Unique', type: 'int'},
            {text: 'Item Number', dataField: 'Item', type: 'string'},
            {text: 'Description', dataField: 'Description', type: 'string'},
            {text: 'Category', dataField: 'Category', type: 'string', filtertype: 'list'},
            {text: 'SubCategory', dataField: 'SubCategory', type: 'string', filtertype: 'list'},
            {text: 'Supplier', datafield: 'Supplier', type: 'string'},
            {text: 'Price', dataField: 'price1', type: 'string'},
            {text: 'Quantity', dataField: '', type: 'string', hidden: true},
            {text: '', dataField: 'Part', type: 'string', hidden: true}
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
            //.on('select', '.customerForm .customer-datalist', function (e) {
            //    $('#saveCustomerBtn').prop('disabled', false);
            //})
            //.on('change', '.customerForm .customer-date', function (e) {
            //    $('#saveCustomerBtn').prop('disabled', false);
            //})
            //.on('change', '.customerForm .customer_radio', function (e) {
            //    $('#saveCustomerBtn').prop('disabled', false);
            //})
            //
    };
});