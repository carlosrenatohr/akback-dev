/**
 * Created by carlosrenato on 09-01-16.
 */
app.service('inventoryExtraService', function ($http) {

    // Source for Suppliers table
    this.getSupplierSettings = function() {
        return {
            source: {
                datatype: "json",
                datafields: [
                    { name: 'Unique' },
                    { name: 'Company' }
                ],
                url: SiteRoot + 'admin/MenuItem/getSupplierList',
                //async: false
            },
            valueMember: "Unique",
            displayMember: "Company",
            placeHolder: 'Select Supplier..'
        };
    };

    // Source for Brands table
    this.getBrandsSettings = function() {
        return {
            source: {
                datatype: "json",
                datafields: [
                    { name: 'Unique' },
                    { name: 'Name' }
                ],
                url: SiteRoot + 'admin/MenuItem/getBrandList',
            },
            valueMember: "Unique",
            displayMember: "Name",
            placeHolder: 'Select Brand..'
        };
    };

    // Source for categories table
    this.getCategoriesSettings = function() {
        return {
            source: {
                datatype: "json",
                datafields: [
                    { name: 'Unique' },
                    { name: 'MainName' }
                ],
                url: SiteRoot + 'admin/MenuItem/getCategoryList',
            },
            valueMember: "Unique",
            displayMember: "MainName",
            placeHolder: 'Select Category..'
        };
    };

    // Source for subcategories table
    this.getSubcategoriesSettings = function(parent) {
        var url = '';
        if (parent != undefined)
            url = SiteRoot + 'admin/MenuItem/getSubcategoryList/' + parent;
        return {
            source: {
                datatype: "json",
                datafields: [
                    { name: 'Unique' },
                    { name: 'Name' }
                ],
                url: url
            },
            valueMember: "Unique",
            displayMember: "Name",
            placeHolder: 'Select Subcategory..'
        };
    };

    // -- BARCODES LIST
    this.getBarcodesListSettings = function(id) {
        var url = '';
        if (id != undefined)
            url = SiteRoot + 'admin/MenuItem/getBarcodesByItem/' + id;
        return {
            source: {
                dataType: 'json',
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'Barcode', type: 'string'}
                ],
                url: url
            },
            filterable: true,
            filterPlaceHolder:'Search',
            itemHeight: 25,
            displayMember: "Barcode",
            valueMember: "Unique",
            theme: 'arctic'
        }
    };

    // -- TAXES LIST
    this.getTaxesGridData = function(itemId) {
        if (itemId == undefined)
            itemId = '';
        return {
            source: new $.jqx.dataAdapter({
                dataType: 'json',
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'Description', type: 'string'},
                    {name: 'Code', type: 'string'},
                    {name: 'Rate', type: 'float'},
                    {name: 'Basis', type: 'string'},
                    {name: 'Status', type: 'string'},
                    {name: 'Default', type: 'bool'},
                    {name: 'taxed', type: 'bool'}
                ],
                url: SiteRoot + 'admin/MenuItem/getTaxesList/' + itemId
            }),
            columns: [
                {dataField: 'Unique', hidden: true},
                {text:'', dataField: 'taxed', //threestatecheckbox: true,
                    columntype: 'checkbox', cellclassname:'cbxItemTaxCell', width: 70},
                {text: 'Code', dataField: 'Code', type: 'string', editable: false},
                {text: 'Description', dataField: 'Description', type: 'string', editable: false},
                {text: 'Rate', dataField: 'Rate', editable: false},
                {text: 'Basis', dataField: 'Basis', editable: false}
            ],
            width: "100%",
            theme: 'arctic',
            editable: true,
            filterable: false,
            ready: function() {

            }
        };
    };

    // -- STOCK DATA LIST
    this.getStockGridData = function(itemId, location) {
        console.log(itemId, location);
        var params = '';
        if (itemId != undefined) {
            params = (itemId) + '/';
            if (location != undefined)
                params += (location);
                //params += '1';
        }
        var initrowdetails = function (index, parentElement, gridElement, datarecord) {
            var comments = (datarecord.Comment != null) ? datarecord.Comment : '';
            var moreDetails =
                    "<span><b>Comments:</b><br/> " + comments + "</span> "
                ;
            //
            var rowDetailsContainer = $($(parentElement).children()[0]);
            rowDetailsContainer.html(moreDetails);
        };

        return {
            source: new $.jqx.dataAdapter({
                dataType: 'json',
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'ItemUnique', type: 'int'},
                    {name: 'LocationUnique', type: 'int'},
                    {name: 'Quantity', type: 'string'},
                    {name: 'TransactionDate', type: 'string'},
                    {name: 'Comment', type: 'string'},
                    {name: 'LocationName', type: 'string'},
                    {name: 'Description', type: 'string'},
                    {name: 'Total', type: 'string'},
                ],
                url: SiteRoot + 'admin/MenuItem/getStocklineItems/' + params
            }),
            columns: [
                {dataField: 'Unique', hidden: true},
                {text: 'Date', dataField: 'TransactionDate', width:'19%'},
                {text: 'Type', dataField: 'Description',width:'19%'},
                {text: 'Location', dataField: 'LocationName',width:'19%'},
                {text: 'Quantity', dataField: 'Quantity', cellsAlign: 'center',width:'19%'},
                {text: 'Total', dataField: 'Total', cellsAlign: 'center', width:'19%'},
                {text: 'Comment', dataField: 'Comment', hidden:true}
            ],
            width: "99%",
            height: 300,
            theme: 'arctic',
            altRows: true,
            sortable: true,
            filterable: false,
            autoheight: true,
            autorowheight: true,
            rowdetails: true,
            rowdetailstemplate: {
                rowdetails: "<div style='margin-top: 5px;'></div>",
                rowdetailsheight: 75
            },
            initRowDetails: initrowdetails
        };
    };

    this.getStockLocationListSettings = function() {
        return {
            source: {
                dataType: 'json',
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'LocationName', type: 'string'}
                ],
                url: SiteRoot + 'MenuItem/getLocationsList'
            },
            autoDropDownHeight: true,
            filterPlaceHolder:'Search',
            displayMember: "LocationName",
            valueMember: "Unique",
            theme: 'arctic'
        }
    };

});