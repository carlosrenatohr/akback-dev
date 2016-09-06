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
            itemHeight: 25,
            displayMember: "Barcode",
            valueMember: "Unique",
            theme: 'arctic'
        }
    };

});