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
        columnsResize: true,
        width: "100%",
        theme: 'arctic',
        sortable: true,
        pageable: true,
        pageSize: 20,
        //pagerMode: 'default',
        altRows: true,
        filterable: true,
        //filterMode: 'simple',
        showfilterrow: true,
    };

    this.setNotificationSettings = function (type) {
        return {
            width: "auto",
            appendContainer: "#customerNoticeContainer",
            opacity: 0.9,
            closeOnClick: true,
            autoClose: true,
            showCloseButton: false,
            template: (type == 1) ? 'success' : 'error'
        }
    };
});