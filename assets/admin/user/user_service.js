angular.module('akamaiposApp')
    .service('UserAdminService', function(adminService) {

    this.userGridSetings = function () {

        var pager = adminService.loadPagerConfig();
        var settings = {
            source: {
                dataType: 'json',
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'UserName', type: 'string'},
                    {name: 'FirstName', type: 'string'},
                    {name: 'LastName', type: 'string'},
                    //{name: 'Code', type: 'string'},
                    //{name: 'Password', type: 'string'},
                    {name: 'Address1', type: 'string'},
                    {name: 'Address2', type: 'string'},
                    {name: 'City', type: 'string'},
                    {name: 'State', type: 'string'},
                    {name: 'Zip', type: 'string'},
                    {name: 'Country', type: 'string'},
                    {name: 'PrimaryPosition', type: 'string'},
                    {name: 'PrimaryPositionName', type: 'string'},
                    {name: 'Phone1', type: 'string'},
                    {name: 'Phone2', type: 'string'},
                    {name: 'Email', type: 'string'},
                    {name: 'Note', type: 'string'},
                    {name: 'Created', type: 'string'},
                    {name: 'CreatedByName', type: 'string'},
                    {name: 'Updated', type: 'string'},
                    {name: 'UpdatedByName', type: 'string'}
                ],
                id: 'Unique',
                url: SiteRoot + 'admin/user/load_users'
            },
            columns: [
                {text: 'ID', dataField: 'Unique', type: 'int'},
                {text: 'User Name', dataField: 'UserName'},
                {text: 'First Name', dataField: 'FirstName'},
                {text: 'Last Name', dataField: 'LastName'},
                {text: 'Primary Position', dataField: 'PrimaryPositionName', filtertype: 'list'},
                {dataField: 'PrimaryPosition', hidden: true},
                {text: 'Address 1', dataField: 'Address1', hidden: true},
                {text: 'Address 2', dataField: 'Address2', hidden: true},
                {text: 'City', dataField: 'City', hidden: true},
                {text: 'State', dataField: 'State', hidden: true},
                {text: 'Zip', dataField: 'Zip', hidden: true},
                {text: 'Country', dataField: 'Country', hidden: true},
                {text: 'Phone 1', dataField: 'Phone1'},
                {text: 'Phone 2', dataField: 'Phone2'},
                {text: 'Email', dataField: 'Email'},
                {dataField: 'Note', hidden: true},
                {dataField: 'Created', hidden: true},
                {dataField: 'CreatedByName', hidden: true},
                {dataField: 'Updated', hidden: true},
                {dataField: 'UpdatedByName', hidden: true}
            ],
            columnsResize: true,
            width: "99.7%",
            theme: 'arctic',
            altRows: true,
            sortable: true,
            filterable: true,
            showfilterrow: true,
            pageable: true,
            pageSize: pager.pageSize,
            pagesizeoptions: pager.pagesizeoptions,
            autoheight: true,
            autorowheight: true
        };

        return settings;
    }
});
