/**
 * Created by carlosrenato on 06-27-16.
 */
demoApp.service('customerService', function ($http) {

    this.getCustomerAttributes = function () {
        return $http({
            'method': 'GET',
            'url': SiteRoot + 'admin/Customer/load_customerAttributes'
        });
    };

    this.getCustomerContactsAttributes = function () {
        return $http({
            'method': 'GET',
            'url': SiteRoot + 'admin/Customer/load_customerContactsAttributes'
        });
    };

    this.getTableSettings = {
        source: {
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'int'},
                {name: 'FirstName', type: 'string'},
                {name: 'MiddleName', type: 'string'},
                {name: 'LastName', type: 'string'},
                {name: 'Company', type: 'string'},
                {name: 'Address1', type: 'string'},
                {name: 'Address2', type: 'string'},
                {name: 'City', type: 'string'},
                {name: 'Country', type: 'string'},
                {name: 'State', type: 'string'},
                {name: 'Zip', type: 'string'},
                {name: 'Phone1', type: 'string'},
                {name: 'Phone2', type: 'string'},
                {name: 'Email', type: 'string'},
                {name: 'Custom1', type: 'string'},
                {name: 'Custom2', type: 'string'},
                {name: 'Custom3', type: 'string'},
                {name: 'Custom4', type: 'string'},
                {name: 'Custom5', type: 'string'},
                {name: 'Custom6', type: 'string'},
                {name: 'Custom7', type: 'string'},
                {name: 'Custom8', type: 'string'},
                {name: 'Custom9', type: 'string'},
                {name: 'Custom10', type: 'string'},
                {name: 'Custom11', type: 'string'},
                {name: 'Custom12', type: 'string'},
                {name: 'Custom13', type: 'string'},
                {name: 'Custom14', type: 'string'},
                {name: 'Custom15', type: 'string'},
                {name: 'Status', type: 'string'}

            ],
            id: 'Unique',
            url: SiteRoot + 'admin/Customer/load_allCustomers'
        },
        columns: [
            {text: 'ID', dataField: 'Unique', type: 'int'}, //filterable: false
            {text: 'First Name', dataField: 'FirstName', type: 'string'},
            {text: 'Middle Name', dataField: 'MiddleName', type: 'string'},
            {text: 'Last Name', dataField: 'LastName', type: 'string'},
            {text: 'Company', dataField: 'Company', type: 'string'},
            {text: 'Address', dataField: 'Address1', type: 'string'},
            {text: 'Address2', dataField: 'Address2', type: 'string', hidden: true},
            {text: 'City', dataField: 'City', type: 'string'},
            {text: 'State', dataField: 'State', type: 'string'},
            {text: 'Zip', dataField: 'Zip', type: 'string'},
            {text: 'Phone', dataField: 'Phone1', type: 'string'},
            {text: 'Phone2', dataField: 'Phone2', type: 'string', hidden: true},
            {text: 'Email', dataField: 'Email', type: 'string'},
            {text: 'Full Identification', dataField: 'Custom1', type: 'string', hidden: true},
            {text: 'Date of Birth', dataField: 'Custom2', type: 'string', hidden: true},
            {text: 'Gender', dataField: 'Custom3', type: 'string', hidden: true},
            {text: 'Marital Status', dataField: 'Custom4', type: 'string', hidden: true},
            {text: 'Ethnicity', dataField: 'Custom5', type: 'string', hidden: true},
            {text: 'Are you 18?', dataField: 'Custom6', type: 'string', hidden: true},
            {text: 'Disabled', dataField: 'Custom7', type: 'string', hidden: true},
            {text: 'Retired', dataField: 'Custom8', type: 'string', hidden: true},
            {text: 'How many working?', dataField: 'Custom9', type: 'string', hidden: true},
            {text: 'Work Status', dataField: 'Custom10', type: 'string', hidden: true},
            {text: 'Income', dataField: 'Custom11', type: 'string', hidden: true},
            {text: 'FS', dataField: 'Custom12', type: 'string', hidden: true},
            {text: 'WA', dataField: 'Custom13', type: 'string', hidden: true},
            {text: 'SS', dataField: 'Custom14', type: 'string', hidden: true},
            {text: 'SSD', dataField: 'Custom15', type: 'string', hidden: true},
        ],
        width: "100%",
        theme: 'arctic',
        sortable: true,
        pageable: true,
        pageSize: 20,
        pagerMode: 'simple',
        filterable: true,
        showfilterrow: true
    };

    this.getContactsTableSettings = function (parentUnique) {
        var urlToRequest = '';
        if (parentUnique != undefined) {
            var queryParams = '?parent=' + parentUnique + '&form=CustomerContact';
            urlToRequest = SiteRoot + 'admin/Customer/load_allCustomers/' + queryParams;
        }
        //else queryParams = '?form=CustomerContact';
        return {
            source: {
                dataType: 'json',
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'FirstName', type: 'string'},
                    {name: 'MiddleName', type: 'string'},
                    {name: 'LastName', type: 'string'},
                    {name: 'Company', type: 'string'},
                    {name: 'Address1', type: 'string'},
                    {name: 'Address2', type: 'string'},
                    {name: 'City', type: 'string'},
                    {name: 'Country', type: 'string'},
                    {name: 'State', type: 'string'},
                    {name: 'Zip', type: 'string'},
                    {name: 'Phone1', type: 'string'},
                    {name: 'Phone2', type: 'string'},
                    {name: 'Email', type: 'string'},
                    {name: 'Custom1', type: 'string'},
                    {name: 'Custom2', type: 'string'},
                    {name: 'Custom3', type: 'string'},
                    {name: 'Custom4', type: 'string'},
                    {name: 'Custom5', type: 'string'},
                    {name: 'Custom6', type: 'string'},
                    {name: 'Custom7', type: 'string'},
                    {name: 'Custom8', type: 'string'},
                    {name: 'Custom9', type: 'string'},
                    {name: 'Custom10', type: 'string'},
                    {name: 'Custom11', type: 'string'},
                    {name: 'Custom12', type: 'string'},
                    {name: 'Custom13', type: 'string'},
                    {name: 'Custom14', type: 'string'},
                    {name: 'Custom15', type: 'string'},
                    {name: 'Custom16', type: 'string'},
                    {name: 'Status', type: 'string'},
                    {name: 'ParentUnique', type: 'int'}
                ],
                id: 'Unique',
                url: urlToRequest
            },
            columns: [
                {text: 'ID', dataField: 'Unique', type: 'int'}, //filterable: false
                {text: 'First Name', dataField: 'FirstName', type: 'string'},
                {text: 'Middle Name', dataField: 'MiddleName', type: 'string'},
                {text: 'Last Name', dataField: 'LastName', type: 'string'},
                {text: 'Company', dataField: 'Company', type: 'string'},
                {text: 'Address', dataField: 'Address1', type: 'string', hidden: true},
                {text: 'Address2', dataField: 'Address2', type: 'string', hidden: true},
                {text: 'City', dataField: 'City', type: 'string', hidden: true},
                {text: 'State', dataField: 'State', type: 'string', hidden: true},
                {text: 'Zip', dataField: 'Zip', type: 'string', hidden: true},
                {text: 'Phone', dataField: 'Phone1', type: 'string', hidden: true},
                {text: 'Phone2', dataField: 'Phone2', type: 'string', hidden: true},
                {text: 'Email', dataField: 'Email', type: 'string', hidden: true},
                {text: 'Full Identification', dataField: 'Custom1', type: 'string'},
                {text: 'Date of Birth', dataField: 'Custom2', type: 'string'},
                {text: 'Gender', dataField: 'Custom3', type: 'string', hidden: true},
                {text: 'Marital Status', dataField: 'Custom4', type: 'string', hidden: true},
                {text: 'Ethnicity', dataField: 'Custom5', type: 'string', hidden: true},
                {text: 'Are you 18?', dataField: 'Custom6', type: 'string', hidden: true},
                {text: 'Disabled', dataField: 'Custom7', type: 'string', hidden: true},
                {text: 'Retired', dataField: 'Custom8', type: 'string', hidden: true},
                {text: 'How many working?', dataField: 'Custom9', type: 'string', hidden: true},
                {text: 'Work Status', dataField: 'Custom10', type: 'string', hidden: true},
                {text: 'Income', dataField: 'Custom11', type: 'string', hidden: true},
                {text: 'FS', dataField: 'Custom12', type: 'string', hidden: true},
                {text: 'WA', dataField: 'Custom13', type: 'string', hidden: true},
                {text: 'SS', dataField: 'Custom14', type: 'string', hidden: true},
                {text: 'SSD', dataField: 'Custom15', type: 'string', hidden: true},
                {text: 'Relationship', dataField: 'Custom16', type: 'string'},
                {text: 'ParentUnique', dataField: 'ParentUnique', type: 'int', hidden: true}
            ],
            //columnsResize: true,
            width: "100%",
            theme: 'arctic',
            sortable: true,
            pageable: true,
            pageSize: 20,
            pagerMode: 'simple',
            filterable: true,
            showfilterrow: (parentUnique) ? true : false
        }
    };

    this.getNotesTableSettings = function (parentUnique) {
        var urlToRequest = '';
        if (parentUnique != undefined) {
            urlToRequest = SiteRoot + 'admin/Customer/load_customerNotes/' + parentUnique;
        }
        return {
            source: {
                dataType: 'json',
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'ReferenceUnique', type: 'int'},
                    {name: 'Note', type: 'string'},
                    {name: 'Status', type: 'string'},
                    {name: 'Type', type: 'string'},
                    {name: 'Created', type: 'string'},
                    {name: 'CreatedBy', type: 'string'},
                    {name: 'CreatedUser', type: 'string'},
                    {name: 'Updated', type: 'string'},
                    {name: 'UpdatedBy', type: 'string'},
                    {name: 'UpdatedUser', type: 'string'},

                ],
                id: 'Unique',
                url: urlToRequest
            },
            columns: [
                {text: 'ID', dataField: 'Unique', type: 'int', width: '5%'}, //filterable: false
                {text: 'CustomerID', dataField: 'ReferenceUnique', type: 'int', hidden: true}, //filterable: false
                {text: 'Note', dataField: 'Note', type: 'text'},
                {text: 'Status', dataField: 'Status', type: 'text', hidden: true},
                {text: 'Type', dataField: 'Type', type: 'string', hidden: true},
                {text: 'Created', dataField: 'Created', type: 'string', hidden: true},
                {text: 'CreatedUser', dataField: 'CreatedUser', type: 'string', hidden: true},
                {text: 'Updated', dataField: 'Updated', type: 'string', hidden: true},
                {text: 'UpdatedUser', dataField: 'UpdatedUser', type: 'string', hidden: true}
            ],
            columnsResize: true,
            width: "100%",
            theme: 'arctic',
            sortable: true,
            //pageable: true,
            //pageSize: 20,
            //pagerMode: 'simple',
            filterable: true,
            showfilterrow: (parentUnique) ? true : false
        }
    };

    var initrowdetails = function (index, parentElement, gridElement, datarecord) {
        var description = (datarecord.Description != null) ? datarecord.Description : '';
        var company = (datarecord.Company != null) ? datarecord.Company : '';
        var moreDetails = "<span>Description: <b>" + description + "</b></span><br><br><span>Company: <b>" + company + "</b><span><br>";
        //
        var rowDetailsContainer = $($(parentElement).children()[0]);
        rowDetailsContainer.html(moreDetails);
    };

    var purchaseGrid = $('#customerPurchasesGrid');
    purchaseGrid.on('rowexpand', function(e) {
        var current = e.args.rowindex;
        var rows = purchaseGrid.jqxGrid('getrows');
        for(var i = 0;i < rows.length;i++) {
            if (i != current)
                purchaseGrid.jqxGrid('hiderowdetails', i);
        }
    });

    this.getPurchasesTableSettings = function (parentUnique) {
        var urlToRequest = '';
        if (parentUnique != undefined) {
            urlToRequest = SiteRoot + 'admin/Customer/load_purchasesCustomer/' + parentUnique;
        }
        return {
            source: {
                dataType: 'json',
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'ReceiptNumber', type: 'string'},
                    {name: 'FirstName', type: 'string'},
                    {name: 'LastName', type: 'string'},
                    {name: 'Company', type: 'string'},
                    {name: 'Item', type: 'string'},
                    {name: 'Description', type: 'string'},
                    {name: 'Quantity', type: 'string'},
                    {name: 'SellPrice', type: 'string'},
                    {name: 'ExtSell', type: 'string'},
                    {name: 'CustomerUnique', type: 'string'}
                ],
                id: 'Unique',
                url: urlToRequest
            },
            columns: [
                {text: 'ID', dataField: 'Unique', type: 'int', hidden: true},
                {text: 'Receipt Number', dataField: 'ReceiptNumber', type: 'string', width: '15%'}, //filterable: false
                {text: 'First Name', dataField: 'FirstName', type: 'text', hidden: true},
                {text: 'Last Name', dataField: 'LastName', type: 'text', hidden: true},
                {text: 'Company', dataField: 'Company', type: 'text', hidden: true},
                {text: 'Item', dataField: 'Item', type: 'text', width: '20%'},
                {text: 'Description', dataField: 'Description', type: 'text', hidden: true},
                {text: 'Quantity', dataField: 'Quantity', type: 'text', width: '25%'},
                {text: 'Sell Price', dataField: 'SellPrice', type: 'text', width: '20%'},
                {text: 'Ext Sell', dataField: 'ExtSell', type: 'text', width: '20%'},
                {text: 'CustomerUnique', dataField: 'CustomerUnique', type: 'string', hidden: true}
            ],
            columnsResize: true,
            width: "99%",
            theme: 'artic',
            sortable: true,
            pageable: true,
            pageSize: 20,
            pagerMode: 'simple',
            altRows: true,
            filterable: true,
            //showfilterrow: (parentUnique) ? true : false
            rowdetails: true,
            rowdetailstemplate: {
                rowdetails: "<div style='margin: 10px 0;'>No description</div>",
                rowdetailsheight: 75
            },
            initrowdetails: initrowdetails
        }
    };

    this.setNotificationSettings = function (type, container) {
        var containerSelect;
        if (container == 'contacts') {
            containerSelect = '#customerContactNoticeContainer';
        } else if ((container == 'notes')) {
            containerSelect = '#customerNotesNoticeContainer';
        } else {
            containerSelect = "#customerNoticeContainer";
        }
        return {
            width: "auto",
            appendContainer: containerSelect,
            opacity: 0.9,
            closeOnClick: true,
            autoClose: true,
            showCloseButton: false,
            template: (type == 1) ? 'success' : 'error'
        }
    };
});