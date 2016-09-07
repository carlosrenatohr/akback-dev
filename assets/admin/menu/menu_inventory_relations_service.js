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
    }

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
    this.getTaxesGridData = function() {
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
                    {name: 'Default', type: 'bool'}
                ],
                url: SiteRoot + 'admin/MenuItem/getTaxesList'
            }),
            columns: [
                {dataField: 'Unique', hidden: true},
                {text:'', dataField: 'Default', //threestatecheckbox: true,
                    columntype: 'checkbox',  width: 70},
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
    }

});