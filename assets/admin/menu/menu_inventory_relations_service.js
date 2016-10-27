/**
 * Created by carlosrenato on 09-01-16.
 */
app.service('inventoryExtraService', function ($http, questionService) {

    // Source for Suppliers table
    this.getSupplierSettings = function () {
        return {
            source: {
                datatype: "json",
                datafields: [
                    {name: 'Unique'},
                    {name: 'Company'}
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
    this.getBrandsSettings = function () {
        return {
            source: {
                datatype: "json",
                datafields: [
                    {name: 'Unique'},
                    {name: 'Name'}
                ],
                url: SiteRoot + 'admin/MenuItem/getBrandList',
            },
            valueMember: "Unique",
            displayMember: "Name",
            placeHolder: 'Select Brand..'
        };
    };

    // Source for categories table
    this.getCategoriesSettings = function () {
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
            placeHolder: 'Select Category..'
        };
    };

    // Source for subcategories table
    this.getSubcategoriesSettings = function (parent) {
        var url = '';
        if (parent != undefined)
            url = SiteRoot + 'admin/MenuItem/getSubcategoryList/' + parent;
        return {
            source: {
                datatype: "json",
                datafields: [
                    {name: 'Unique'},
                    {name: 'Name'}
                ],
                url: url
            },
            valueMember: "Unique",
            displayMember: "Name",
            placeHolder: 'Select Subcategory..'
        };
    };

    // -- BARCODES LIST
    this.getBarcodesListSettings = function (id) {
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
            filterPlaceHolder: 'Search',
            itemHeight: 25,
            displayMember: "Barcode",
            valueMember: "Unique",
            theme: 'arctic'
        }
    };

    // -- TAXES LIST
    this.getTaxesGridData = function (itemId) {
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
                {
                    text: '', dataField: 'taxed', //threestatecheckbox: true,
                    columntype: 'checkbox', cellclassname: 'cbxItemTaxCell', width: '5%'
                },
                {text: 'Code', dataField: 'Code',  type: 'string', editable: false, width: '22%'},
                {text: 'Description', dataField: 'Description', type: 'string', editable: false, width: '25%'},
                {text: 'Rate', dataField: 'Rate', editable: false,  width: '23%'},
                {text: 'Basis', dataField: 'Basis', editable: false,  width: '25%'}
            ],
            width: "100%",
            height: "300px",
            theme: 'arctic',
            editable: true,
            filterable: false,
            altRows: true,
            sortable: true,
            autoheight: true,
            autorowheight: true,
            pageable: true,
            pageSize: 10,
            ready: function () {}
        };
    };

    // -- STOCK DATA LIST
    this.getStockGridData = function (itemId, location) {
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
                    {name: 'Total', type: 'string'}
                ],
                url: SiteRoot + 'admin/MenuItem/getStocklineItems/' + params
            }),
            columns: [
                {dataField: 'Unique', hidden: true},
                {text: 'Date', dataField: 'TransactionDate', width: '20%'},
                {text: 'Type', dataField: 'Description', width: '20%'},
                {text: 'Location', dataField: 'LocationName', width: '20%'},
                {text: 'Quantity', dataField: 'Quantity', align: 'right', cellsAlign: 'right', width: '20%'},
                {text: 'Total', dataField: 'Total', align: 'right', cellsAlign: 'right', width: '19%'},
                {text: 'Comment', dataField: 'Comment', hidden: true}
            ],
            width: "99%",
            height: 300,
            theme: 'arctic',
            altRows: true,
            sortable: true,
            filterable: false,
            pageable: true,
            pageSize: 10,
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

    this.getStockLocationListSettings = function (all) {
        var str = '';
        if (all != undefined) {
            str = all;
        }
        return {
            source: {
                dataType: 'json',
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'Name', type: 'string'},
                    {name: 'LocationName', type: 'string'}
                ],
                url: SiteRoot + 'admin/MenuItem/getLocationsList/' + str
            },
            autoDropDownHeight: true,
            //displayMember: "Name",
            displayMember: "LocationName",
            valueMember: "Unique",
            theme: 'arctic'
        }
    };

    // -- QUESTION DATA
    this.getQuestionGridData = function(item) {
        var url = '';
        if (item != undefined) {
            url = SiteRoot + 'admin/MenuItem/load_itemquestions/' + item;
        }
        var settings = {
            source: ({
                dataType: 'json',
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'ItemUnique', type: 'int'},
                    {name: 'QuestionUnique', type: 'int'},
                    {name: 'QuestionName', type: 'string'},
                    {name: 'ItemName', type: 'string'},
                    {name: 'Status', type: 'number'},
                    {name: 'StatusName', type: 'string'},
                    {name: 'Tab', type: 'number'},
                    {name: 'Sort', type: 'number'}
                ],
                id: 'Unique',
                url: url
            }),
            columns: [
                {text: 'ID', dataField: 'Unique', type: 'int', hidden: true},
                {text: 'Item', dataField: 'ItemUnique', type: 'int', hidden: true},
                {text: 'Question ID', dataField: 'QuestionUnique', type: 'int', width: '25%'},
                {text: 'Name', dataField: 'QuestionName', type: 'string', width: '50%'},
                {text: 'Status', dataField: 'Status', type: 'number', hidden: true},
                {text: 'Tab', dataField: 'Tab', type: 'number', width: '12.5%'},
                {text: 'Sort', dataField: 'Sort', type: 'number', width: '12.5%'}
            ],
            //columnsResize: true,
            width: "100%",
            height: 300,
            theme: 'arctic',
            sortable: true,
            pageable: true,
            pageSize: 5,
            filterable: false,
            altRows: true,
            autoheight: true,
            autorowheight: true
        };

        if (addSubgrid) {
          settings.rowdetails = true;
          settings.initrowdetails = questionService.getRowdetailsFromChoices();
          settings.rowdetailstemplate = {
              rowdetails: "<div class='choicesNestedGrid'></div>",
              rowdetailsheight: 200,
              rowdetailshidden: true
          };
        }

        return settings;
    };

    this.getQuestionsCbxData = function() {
        return new $.jqx.dataAdapter(
            {
                dataType: 'json',
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'QuestionName', type: 'string'}
                ],
                id: 'Unique',
                url: SiteRoot + 'admin/MenuQuestion/load_allquestions'
            }
        );
    };

    // -- PRINTER DATA
    this.getPrinterGridData = function(item) {
        var url = '';
        if (item != undefined) {
            url = SiteRoot + 'admin/MenuPrinter/load_allItemPrinters/' + item;
        }
        return {
            source: {
                dataType: 'json',
                    dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'ItemUnique', type: 'int'},
                    {name: 'PrinterUnique', type: 'int'},
                    {name: 'name', type: 'string'},
                    {name: 'description', type: 'string'},
                    {name: 'Item', type: 'string'},
                    {name: 'Status', type: 'number'},
                    {name: 'Primary', type: 'number'},
                    {name: 'fullDescription', type: 'string'}
                ],
                url: url
            },
            columns: [
                {text: 'ID', dataField: 'Unique', type: 'int', width: '20%'},
                {text: 'Item', dataField: 'Item', type: 'string', hidden: true},
                {text: 'Name', dataField: 'name', type: 'string', width: '40%'},
                {text: 'Description', dataField: 'description', type: 'string', width: '40%'},
                {text: '', dataField: 'ItemUnique', type: 'int', hidden: true},
                {text: '', dataField: 'Status', type: 'int', hidden: true},
                {text: '', dataField: 'fullDescription', type: 'string', hidden: true},
                //{text: 'Actions', type: 'string', hidden:false, width: '20%', align: 'center',
                //    cellsrenderer: function (row, column, value, rowData) {
                //        return '<button class="btn btn-danger deletePrinterItemBtn" '+
                //            'data-unique="'+ rowData.Unique +'" '+
                //            'style="padding: 0 2%;margin: 2px 25%;font-size: 12px">Delete</button>';
                //    }
                //}
            ],
                //columnsResize: true,
            width: "100%",
            height: 300,
            theme: 'arctic',
            sortable: true,
            pageable: true,
            pageSize: 10,
            filterable: false,
            altRows: true,
            autoheight: true,
            autorowheight: true
        };
    };

    this.getPrintersCbxData = function() {
        return {
            datatype: "json",
            datafields: [
                { name: 'name'},
                { name: 'description'},
                { name: 'fullDescription'},
                { name: 'status' },
                { name: 'unique' }
            ],
            id: 'Unique',
            url: SiteRoot + 'admin/MenuPrinter/load_allPrintersFromConfig'
        };
    }

});