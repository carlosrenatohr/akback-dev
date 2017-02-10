app.service('menuCategoriesService', function ($http, adminService) {

    //TODO
    // ADD Fields of default styles on menu
    // Load it and test if new way to load and set colors on category
    var pager = adminService.loadPagerConfig();
    this.getMenuGridSettings = function (empty) {
        var url = '';
        if (empty == undefined)
            url = SiteRoot + 'admin/MenuCategory/load_allmenus';
        console.log(url);
        return {
            source: new $.jqx.dataAdapter({
                dataType: 'json',
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'MenuName', type: 'string'},
                    {name: 'Status', type: 'string'},
                    {name: 'StatusName', type: 'string'},
                    {name: 'CategoryColumn', type: 'string'},
                    {name: 'CategoryRow', type: 'string'},
                    {name: 'ItemRow', type: 'string'},
                    {name: 'ItemColumn', type: 'string'},
                    {name: 'ItemLength', type: 'string'},
                    //

                ],
                url: url
            }),
            columns: [
                {text: 'ID', dataField: 'Unique', type: 'int'},
                {text: 'Menu Name', dataField: 'MenuName', type: 'number'},
                {text: 'Status', dataField: 'Status', type: 'int', hidden: true},
                {text: 'Status', dataField: 'StatusName', type: 'string'},
                {text: 'Column', dataField: 'CategoryColumn', type: 'number'},
                {text: 'Row', dataField: 'CategoryRow', type: 'number'},
                {dataField: 'ItemRow', hidden: true},
                {dataField: 'ItemColumn', hidden: true},
                {text: 'Item Length', dataField: 'ItemLength', type: 'number'}
            ],
            // ready: function() {
            //     $('#menuGridTable').jqxGrid('updatebounddata', 'filter');
            // },
            width: "99.8%",
            theme: 'arctic',
            filterable: true,
            sortable: true,
            pageable: true,
            showfilterrow: true,
            pageSize: pager.pageSize,
            pagesizeoptions: pager.pagesizeoptions,
            altRows: true,
            autoheight: true,
            autorowheight: true
        };
    }
});