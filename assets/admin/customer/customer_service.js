/**
 * Created by carlosrenato on 06-27-16.
 */
angular.module('akamaiposApp')
    .service('customerService', function ($http, adminService) {

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

    this.getCustomerGridAttrs = function () {
        return $http({
            'method': 'get',
            'url': SiteRoot + 'admin/Customer/load_customerGridAttributes'
        });
    };

    var _this = this;
    this.customerGridsCols =  [
        {text: 'ID', dataField: 'Unique', filtertype: 'input'}, //filterable: false
        {text: 'First Name', dataField: 'FirstName', columntype: 'textbox', filtertype: 'input'},
        {text: 'Middle Name', dataField: 'MiddleName', type: 'string', filtertype: 'input'},
        {text: 'Last Name', dataField: 'LastName', type: 'string', filtertype: 'input'},
        {text: 'Company', dataField: 'Company', type: 'string'},
        {text: 'Address', dataField: 'Address1', type: 'string'},
        {text: 'Address2', dataField: 'Address2', type: 'string', hidden: true},
        {text: 'City', dataField: 'City', type: 'string'},
        {text: 'State', dataField: 'State', type: 'string'},
        {text: 'Zip', dataField: 'Zip', type: 'string'},
        {text: 'Phone', dataField: 'Phone1', type: 'string'},
        {text: 'Phone2', dataField: 'Phone2', type: 'string', hidden: true},
        {text: 'Email', dataField: 'Email', type: 'string'},
        {text: 'Full Identification', dataField: 'Custom1', type: 'string', filtertype: 'input',hidden: true},
        {text: 'Date of Birth', dataField: 'Custom2', type: 'string', hidden: true,filtertype: 'input'},
        {text: 'LastVisit', dataField: 'LastVisit', type: 'date', filtertype:'range', cellsformat: "MMM dd yyyy hh:mmtt"},
        {text: 'Gender', dataField: 'Custom3', type: 'string', hidden: true,filtertype: 'input'},
        {text: 'Marital Status', dataField: 'Custom4', type: 'string', hidden: true,filtertype: 'input'},
        {text: 'Ethnicity', dataField: 'Custom5', type: 'string', hidden: true,filtertype: 'input'},
        {text: 'Are you 18?', dataField: 'Custom6', type: 'string', hidden: true,filtertype: 'input'},
        {text: 'How many working?', dataField: 'Custom9', type: 'string', hidden: true,filtertype: 'input'},
        {text: 'Disabled', dataField: 'Custom7', type: 'string', hidden: true,filtertype: 'input'},
        {text: 'Retired', dataField: 'Custom8', type: 'string', hidden: true,filtertype: 'input'},
        {text: 'Work Status', dataField: 'Custom10', type: 'string', hidden: true,filtertype: 'input'},
        {text: 'Income', dataField: 'Custom11', type: 'string', hidden: true,filtertype: 'input'},
        {text: 'FS', dataField: 'Custom12', type: 'string', hidden: true,filtertype: 'input'},
        {text: 'WA', dataField: 'Custom13', type: 'string', hidden: true,filtertype: 'input'},
        {text: 'SS', dataField: 'Custom14', type: 'string', hidden: true,filtertype: 'input'},
        {text: 'SSD', dataField: 'Custom15', type: 'string', hidden: true,filtertype: 'input'},
        {text: '', dataField: 'Custom16', type: 'string', hidden: true, filtertype: 'input'},
        {text: '', dataField: 'Custom17', type: 'string', hidden: true, filtertype: 'input'},
        {text: '', dataField: 'Custom18', type: 'string', hidden: true, filtertype: 'input'},
        {text: '', dataField: 'Custom19', type: 'string', hidden: true, filtertype: 'input'},
        {text: '', dataField: 'Custom20', type: 'string', hidden: true, filtertype: 'input'},
        {text: 'Check in 1', dataField: 'CheckIn1', type: 'string', hidden:false, filterable: false,
            cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties) {
                var data = $('#gridCustomer').jqxGrid('getrowdata', row);
                var disabled = '', classname = 'success', color = '#5cb85c';
                if(data.readyToCheckIn == false) {
                    disabled = 'disabled = disabled';
                }
                if (data.AccountStatus == 'Active')
                    classname = 'success';
                else if (data.AccountStatus == 'On Hold')
                    classname = 'warning';
                else if (data.AccountStatus == 'Suspended')
                    classname = 'danger';
                return '<button class="btn btn-'+ classname + ' checkInBtn" '+ disabled +
                        'data-unique="'+ data.Unique + '" data-location="1" '+
                        'data-fname="'+ data.FirstName + '" data-lname="'+ data.LastName +'" '+
                        'style="padding: 0 2%;margin: 2px 25%;font-size: 11px;color: #222;font-weight: 800;"' +
                        '>Check in</button>';
            }
        },
        {text: 'CheckIn 2', dataField: 'CheckIn2', type: 'string', hidden:false, filterable: false,
            cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties) {
                var data = $('#gridCustomer').jqxGrid('getrowdata', row);
                var disabled = '', classname = 'success';
                if(data.readyToCheckIn == false) {
                    disabled = 'disabled = disabled';
                }
                if (data.AccountStatus == 'Active')
                    classname = 'success';
                else if (data.AccountStatus == 'On Hold')
                    classname = 'warning';
                else if (data.AccountStatus == 'Suspended')
                    classname = 'danger';
                return '<button class="btn btn-'+ classname +' checkInBtn" '+ disabled +
                    'data-unique="'+ data.Unique + '" data-location="2" '+
                    'data-fname="'+ data.FirstName + '" data-lname="'+ data.LastName +'" '+
                    'style="padding: 0 2%;margin: 2px 25%;font-size: 11px;color: #222;font-weight: 800;"' +
                    '>Check in</button>';
            }
        },
        {text: '', dataField: 'VisitDays', type: 'string', hidden: true},
        {text: '', dataField: 'AccountStatus', type: 'string', hidden: true},
        {text: '', dataField: 'readyToCheckIn', type: 'bool', hidden: true}
    ];

    // Source from customer table
    this.sourceCustomerGrid = {
        dataType: 'json',
        dataFields: [
            {name: 'Unique', type: 'number'},
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
            {name: 'Custom17', type: 'string'},
            {name: 'Custom18', type: 'string'},
            {name: 'Custom19', type: 'string'},
            {name: 'Custom20', type: 'string'},
            {name: 'Status', type: 'string'},
            {name: 'CheckIn1', type: 'string'},
            {name: 'CheckIn2', type: 'string'},
            {name: 'LastVisit', type: 'date'},
            {name: 'VisitDays', type: 'string'},
            {name: 'AccountStatus', type: 'string'},
            {name: 'readyToCheckIn', type: 'bool'}
        ],
        //id: 'Unique',
        url: SiteRoot + 'admin/Customer/load_allCustomers',
        root: 'Rows',
        beforeprocessing: function(data) {
            _this.sourceCustomerGrid.totalrecords = data.TotalRows;
        },
        processData: function(data) {
            //console.log('loadComplete', $.param(data));
        },
        filter: function () {
            $("#gridCustomer").jqxGrid({'rowdetails': false});
            $("#gridCustomer").jqxGrid('updatebounddata', 'filter');
        },
        sort: function () {
            $("#gridCustomer").jqxGrid({'rowdetails': false});
            $("#gridCustomer").jqxGrid('updatebounddata', 'filter');
        },
        //ready: function () {},
        //cache: false
    };

    var pager = adminService.loadPagerConfig(true);
    this.getTableSettings = function () {
        // Customer dataadatper
        var dataAdapterCustomerGrid = new $.jqx.dataAdapter(_this.sourceCustomerGrid);
        // Row Details - Create contacts nested grid
        var initrowdetails = function (index, parentElement, gridElement, record) {
            var contactsDatagrid = _this.getContactsTableSettings(record.Unique);
            var grid = $($(parentElement).children()[0]);
            //
            var nestedGridAdapter = contactsDatagrid.source;
            if (grid != null) {
                grid.jqxGrid({
                    source: nestedGridAdapter,
                    width: '98.7%', height: '120',
                    columns: contactsDatagrid.columns
                });
            }
        };

        return {
            source: dataAdapterCustomerGrid,
            columns: _this.customerGridsCols,
            width: "98.7%",
            theme: 'arctic',
            sortable: true,
            filterable: true,
            pageable: true,
            pageSize: pager.pageSize,
            pagesizeoptions: pager.pagesizeoptions,
            scrollmode: 'logical',
            //pagerMode: 'simple',
            virtualmode: true,
            rendergridrows: function()
            {
                return dataAdapterCustomerGrid.records;
            },
            showfilterrow: true,
            // TODO: Apparently Row details generates 'still loading..' issue
            rowdetails: true,
            initrowdetails: initrowdetails,
            rowdetailstemplate: {
                rowdetails: "<div class='contactsNestedGridContainer' style='margin:5px 0;'></div>",
                rowdetailsheight: 100,
                rowdetailshidden: true
            },
            altRows: true,
            autoheight: true,
            autorowheight: true
        };
    };

    /**
     * CHECK IN TAB 1
     * @type {{dataType: string, dataFields: Array, url: string}}
     */
    this.sourceCheckIn1Grid =  {
        dataType: 'json',
        dataFields: _this.sourceCustomerGrid.dataFields.concat(
            [
                {name: '_CheckInDate', type: 'string'},
                {name: 'CheckInDate', type: 'date'},
                {name: 'CheckInBy', type: 'string'},
                {name: 'CheckOutDate', type: 'string'},
                {name: 'CheckOutBy', type: 'string'},
                {name: 'Quantity', type: 'string'},
                {name: 'StatusCheckIn', type: 'string'},
                {name: 'Note', type: 'string'},
                {name: 'LocationUnique', type: 'string'},
                {name: 'LocationName', type: 'string'},
                {name: 'CheckInUser', type: 'string'},
                {name: 'CheckOutUser', type: 'string'},
                {name: 'lname', type: 'string'},
                {name: 'fname', type: 'string'},
                {name: 'VisitUnique', type: 'int'}
            ]
        ),
        //id: 'Unique',
        url: SiteRoot + 'admin/CustomerCheckin/load_checkInCustomersByLocation/1/1',
        root: 'Rows',
        beforeprocessing: function(data) {
            _this.sourceCheckIn1Grid.totalrecords = data.TotalRows;
        },
        filter: function () {
            $("#customerCheckIn1").jqxGrid('updatebounddata', 'filter');
        },
        sort: function () {
            $("#customerCheckIn1").jqxGrid('updatebounddata', 'filter');
        },
        cache: false
    };

    this.getCheckin1GridSettings = function () {
        // Customer dataadatper
        var dataAdapterCustomerGrid = new $.jqx.dataAdapter(_this.sourceCheckIn1Grid);
        // Row Details - Create contacts nested grid
        var initrowdetails = function (index, parentElement, gridElement, record) {
            var contactsDatagrid = _this.getContactsTableSettings(record.Unique);
            var grid = $($(parentElement).children()[0]);
            //
            var nestedGridAdapter = contactsDatagrid.source;
            if (grid != null) {
                grid.jqxGrid({
                    source: nestedGridAdapter,
                    width: '98.7%', height: 120,
                    columns: contactsDatagrid.columns
                });
            }
        };
        //
        var aggregates = function (aggregatedValue, currentValue, column, record) {
            return _this.sourceCheckIn1Grid.totalrecords ;
        };

        var aggregatesrender = function (aggregates, column, element, summaryData) {
            var renderstring = "<div style='float: left; width: 100%; height: 100%;'>";
            $.each(aggregates, function (key, value) {
                renderstring += '<div style="position: relative; margin: 6px; text-align: right; overflow: hidden;color:red;"><b>' + key + ': ' + value + '</b></div>';
            });
            renderstring += "</div>";
            return renderstring;
        };

        // Exclude checkin buttons columns
        var checkInCols = _this.customerGridsCols.slice(0);
        var checkin1Id = checkInCols.map(function(el) {return el.dataField; }).indexOf('CheckIn1');
        checkInCols.splice(checkin1Id, 1);
        var checkin2Id = checkInCols.map(function(el) {return el.dataField; }).indexOf('CheckIn2');
        checkInCols.splice(checkin2Id, 1);
        checkInCols.shift();
        checkInCols.unshift({text: '', type: 'string', dataField: 'Unique', filtertype: 'input',
            aggregates: [{ 'Count': aggregates }],
            aggregatesrenderer: aggregatesrender
        });

        return {
            source: dataAdapterCustomerGrid,
            columns: checkInCols.concat(
                {text: 'Visit ID', dataField: 'VisitUnique', hidden: false, filtertype: 'input'},
                {text: 'Check in Date', dataField: 'CheckInDate', type: 'date', filtertype: 'range', cellsformat: "MMM dd yyyy hh:mmtt"},
                {text: '', dataField: 'CheckInBy', type: 'string', hidden: true},
                {text: '', dataField: 'CheckOutDate', type: 'string', hidden: true},
                {text: '', dataField: 'CheckOutBy', type: 'string', hidden: true},
                {text: '', dataField: 'Quantity', type: 'string', hidden: true},
                {text: '', dataField: 'Note', type: 'string', hidden: true},
                {text: '', dataField: 'StatusCheckIn', type: 'string', hidden: true},
                {text: '', dataField: 'LocationUnique', type: 'string', hidden: true},
                {text: '', dataField: 'LocationName', type: 'string', hidden: true},
                {text: '', dataField: 'CheckInUser', type: 'string', hidden: true},
                {text: '', dataField: 'CheckOutUser', type: 'string', hidden: true},
                {text: '', dataField: 'lname', type: 'string', hidden: true},
                {text: '', dataField: 'fname', type: 'string', hidden: true}
            ),
            width: "100%",
            theme: 'arctic',
            sortable: true,
            filterable: true,
            pageable: true,
            pageSize: pager.pageSize,
            pagesizeoptions: pager.pagesizeoptions,
            virtualmode: true,
            showaggregates: true,
            showstatusbar: true,
            rendergridrows: function()
            {
                return dataAdapterCustomerGrid.records;
            },
            showfilterrow: true,
            rowdetails: true,
            initrowdetails: initrowdetails,
            rowdetailstemplate: {
                rowdetails: "<div class='contactsNestedGridCheckin2' style='margin:5px;'></div>",
                rowdetailsheight: 100,
                rowdetailshidden: true
            },
            altRows: true,
            autoheight: true,
            autorowheight: true
        };
    };

    /**
     *  CHECK IN TAB 2
     * @type {{dataType: string, dataFields: Array, url: string}}
     */
    this.sourceCheckIn2Grid =  {
        dataType: 'json',
        dataFields: _this.sourceCustomerGrid.dataFields.concat(
            {name: 'VisitUnique', type: 'int'},
            {name: '_CheckInDate', type: 'string'},
            {name: 'CheckInDate', type: 'date'},
            {name: 'CheckInBy', type: 'string'},
            {name: 'CheckOutDate', type: 'string'},
            {name: 'CheckOutBy', type: 'string'},
            {name: 'Quantity', type: 'string'},
            {name: 'StatusCheckIn', type: 'string'},
            {name: 'Note', type: 'string'},
            {name: 'LocationUnique', type: 'string'},
            {name: 'LocationName', type: 'string'},
            {name: 'CheckInUser', type: 'string'},
            {name: 'CheckOutUser', type: 'string'},
            {name: 'lname', type: 'string'},
            {name: 'fname', type: 'string'}
        ),
        url: SiteRoot + 'admin/CustomerCheckin/load_checkInCustomersByLocation/1/2',
        root: 'Rows',
        beforeprocessing: function(data) {
            _this.sourceCheckIn2Grid.totalrecords = data.TotalRows;
        },
        filter: function () {
            $("#customerCheckIn2").jqxGrid('updatebounddata', 'filter');
        },
        sort: function () {
            $("#customerCheckIn2").jqxGrid('updatebounddata', 'filter');
        },
        cache: false
    };

    this.getCheckin2GridSettings = function () {
        var dataAdapterCustomerGrid = new $.jqx.dataAdapter(_this.sourceCheckIn2Grid);
        // Row Details - Create contacts nested grid
        var initrowdetails = function (index, parentElement, gridElement, record) {
            var contactsDatagrid = _this.getContactsTableSettings(record.Unique);
            var grid = $($(parentElement).children()[0]);
            //
            var nestedGridAdapter = contactsDatagrid.source;
            if (grid != null) {
                grid.jqxGrid({
                    source: nestedGridAdapter,
                    width: '98.7%', height: 120,
                    columns: contactsDatagrid.columns
                });
            }
        };
        //
        var aggregates = function (aggregatedValue, currentValue, column, record) {
            return _this.sourceCheckIn2Grid.totalrecords ;
        };

        var aggregatesrender = function (aggregates, column, element, summaryData) {
            var renderstring = "<div style='float: left; width: 100%; height: 100%;'>";
            $.each(aggregates, function (key, value) {
                renderstring += '<div style="position: relative; margin: 6px; text-align: right; overflow: hidden;color:red;"><b>' + key + ': ' + value + '</b></div>';
            });
            renderstring += "</div>";
            return renderstring;
        };

        // Exclude checkin buttons columns
        var checkInCols = _this.customerGridsCols.slice(0);
        var checkin1Id = checkInCols.map(function(el) {return el.dataField; }).indexOf('CheckIn1');
        checkInCols.splice(checkin1Id, 1);
        var checkin2Id = checkInCols.map(function(el) {return el.dataField; }).indexOf('CheckIn2');
        checkInCols.splice(checkin2Id, 1);
        checkInCols.shift();
        checkInCols.unshift({text: '', type: 'string', dataField: 'Unique',
            aggregates: [{ 'Count': aggregates }],
            aggregatesrenderer: aggregatesrender
        });

        return {
            source: dataAdapterCustomerGrid,
            columns: checkInCols.concat(
                {text: 'Visit ID', dataField: 'VisitUnique', type: 'int', hidden: false, filtertype: 'input'},
                {text: 'Check in Date', dataField: 'CheckInDate', type: 'date', filtertype: 'range', cellsformat: "MMM dd yyyy hh:mmtt"},
                {text: '', dataField: 'CheckInBy', type: 'string', hidden: true},
                {text: '', dataField: 'CheckOutDate', type: 'string', hidden: true},
                {text: '', dataField: 'CheckOutBy', type: 'string', hidden: true},
                {text: '', dataField: 'Quantity', type: 'string', hidden: true},
                {text: '', dataField: 'Note', type: 'string', hidden: true},
                {text: '', dataField: 'StatusCheckIn', type: 'string', hidden: true},
                {text: '', dataField: 'LocationUnique', type: 'string', hidden: true},
                {text: '', dataField: 'LocationName', type: 'string', hidden: true},
                {text: '', dataField: 'CheckInUser', type: 'string', hidden: true},
                {text: '', dataField: 'CheckOutUser', type: 'string', hidden: true},
                {text: '', dataField: 'lname', type: 'string', hidden: true},
                {text: '', dataField: 'fname', type: 'string', hidden: true}
            ),
            width: "98%",
            theme: 'arctic',
            sortable: true,
            filterable: true,
            pageable: true,
            pageSize: pager.pageSize,
            pagesizeoptions: pager.pagesizeoptions,
            virtualmode: true,
            showaggregates: true,
            showstatusbar: true,
            rendergridrows: function()
            {
                return dataAdapterCustomerGrid.records;
            },
            showfilterrow: true,
            rowdetails: true,
            initrowdetails: initrowdetails,
            rowdetailstemplate: {
                rowdetails: "<div class='contactsNestedGridCheckin1' style='margin:5px;'></div>",
                rowdetailsheight: 100,
                rowdetailshidden: true
            },
            altRows: true,
            autoheight: true,
            autorowheight: true
        };
    };

    /**
     *  CHECK IN COMPLETE TAB 3
     * @type {{dataType: string, dataFields: Array, url: string}}
     */
    this.sourceCheckInCompleteGrid =  {
        dataType: 'json',
        dataFields: _this.sourceCustomerGrid.dataFields.concat([
            {name: 'LocationUnique', type: 'string'},
            {name: 'LocationName', type: 'string'},
            {name: 'CheckOutDate', type: 'date'},
            {name: '_CheckOutDate', type: 'string'},
            {name: 'CheckOutBy', type: 'string'},
            {name: 'CheckInDate', type: 'string'},
            {name: '_CheckInDate', type: 'string'},
            {name: 'CheckInBy', type: 'string'},
            {name: 'Quantity', type: 'string'},
            {name: 'StatusCheckIn', type: 'string'},
            {name: 'Note', type: 'string'},
            {name: 'CheckInUser', type: 'string'},
            {name: 'CheckOutUser', type: 'string'},
            {name: 'lname', type: 'string'},
            {name: 'fname', type: 'string'},
            {name: 'VisitUnique', type: 'int'}
        ]),
        url: SiteRoot + 'admin/CustomerCheckin/load_checkInCustomersByLocation/2/0',
        root: 'Rows',
        beforeprocessing: function(data) {
            _this.sourceCheckInCompleteGrid.totalrecords = data.TotalRows;
        },
        filter: function () {
            $("#customerCheckInComplete").jqxGrid('updatebounddata', 'filter');
        },
        sort: function () {
            $("#customerCheckInComplete").jqxGrid('updatebounddata', 'filter');
        },
        cache: false
    };

    this.getCheckinCompleteGridSettings = function () {
        var dataAdapterCustomerGrid = new $.jqx.dataAdapter(_this.sourceCheckInCompleteGrid);
        // Row Details - Create contacts nested grid
        var initrowdetails = function (index, parentElement, gridElement, record) {
            var contactsDatagrid = _this.getContactsTableSettings(record.Unique);
            var grid = $($(parentElement).children()[0]);
            //
            var nestedGridAdapter = contactsDatagrid.source;
            if (grid != null) {
                grid.jqxGrid({
                    source: nestedGridAdapter,
                    width: '98.7%', height: 120,
                    columns: contactsDatagrid.columns
                });
            }
        };
        //
        var aggregates = function (aggregatedValue, currentValue, column, record) {
            return _this.sourceCheckInCompleteGrid.totalrecords ;
        };

        var aggregatesrender = function (aggregates, column, element, summaryData) {
            var renderstring = "<div style='float: left; width: 100%; height: 100%;'>";
            $.each(aggregates, function (key, value) {
                renderstring += '<div style="position: relative; margin: 6px; text-align: right; overflow: hidden;color:red;"><b>' + key + ': ' + value + '</b></div>';
            });
            renderstring += "</div>";
            return renderstring;
        };
        // Exclude checkin buttons columns
        var checkInCols = _this.customerGridsCols.slice(0);
        var checkin1Id = checkInCols.map(function(el) {return el.dataField; }).indexOf('CheckIn1');
        checkInCols.splice(checkin1Id, 1);
        var checkin2Id = checkInCols.map(function(el) {return el.dataField; }).indexOf('CheckIn2');
        checkInCols.splice(checkin2Id, 1);
        checkInCols.shift();
        checkInCols.unshift({text: '', type: 'string', dataField: 'Unique',
            aggregates: [{ 'Count': aggregates }],
            aggregatesrenderer: aggregatesrender
        });

        return {
            source: dataAdapterCustomerGrid,
            columns: checkInCols.concat(
                {text: 'Visit ID', dataField: 'VisitUnique', type: 'int', hidden: false, filtertype: 'input'},
                {text: 'Location name', dataField: 'LocationName', type: 'string', filtertype: 'input'},
                {text: 'Check out date', dataField: 'CheckOutDate', type: 'date', filtertype:'range', cellsformat: 'MM-dd-yyyy'}, //MM-dd-yyyy,     yyyy-MM-dd
                {text: '', dataField: '_CheckOutDate', type: 'string'},
                {text: '', dataField: 'LocationUnique', type: 'string', hidden: true},
                {text: '', dataField: 'CheckOutBy', type: 'string', hidden: true},
                {text: '', dataField: 'CheckInDate', type: 'string', hidden:true},
                {text: '', dataField: '_CheckInDate', type: 'string', hidden:true},
                {text: '', dataField: 'CheckInBy', type: 'string', hidden: true},
                {text: '', dataField: 'Quantity', type: 'string', hidden: true},
                {text: '', dataField: 'Note', type: 'string', hidden: true},
                {text: '', dataField: 'StatusCheckIn', type: 'string', hidden: true},
                {text: '', dataField: 'CheckInUser', type: 'string', hidden: true},
                {text: '', dataField: 'CheckOutUser', type: 'string', hidden: true},
                {text: '', dataField: 'lname', type: 'string', hidden: true},
                {text: '', dataField: 'fname', type: 'string', hidden: true}
            ),
            width: "98.7%",
            theme: 'arctic',
            sortable: true,
            filterable: true,
            pageable: true,
            pageSize: pager.pageSize,
            pagesizeoptions: pager.pagesizeoptions,
            virtualmode: true,
            showaggregates: true,
            showstatusbar: true,
            rendergridrows: function()
            {
                return dataAdapterCustomerGrid.records;
            },
            showfilterrow: true,
            rowdetails: true,
            initrowdetails: initrowdetails,
            rowdetailstemplate: {
                rowdetails: "<div class='contactsNestedGridCheckout' style='margin:5px;'></div>",
                rowdetailsheight: 100,
                rowdetailshidden: true
            }
            //ready: function() {
            //    _this.addDefaultfilter();
            //    //$("#customerCheckInComplete").jqxGrid('sortby', 'LastName', 'asc');
            //}
        };
    };

    this.getContactsTableSettings = function (parentUnique) {
        var urlToRequest = '';
        if (parentUnique != undefined) {
            var queryParams = '?parent=' + parentUnique + '&form=CustomerContact';
            urlToRequest = SiteRoot + 'admin/Customer/load_allCustomers/' + queryParams;
        }
        //else queryParams = '?form=CustomerContact';
        return {
            source: new $.jqx.dataAdapter({
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
                //id: 'Unique',
                url: urlToRequest
            }),
            columns: [
                {text: 'ID', dataField: 'Unique', type: 'int', width: '10%'}, //filterable: false
                {text: 'First Name', dataField: 'FirstName', type: 'string', width: '15%'},
                {text: 'Middle Name', dataField: 'MiddleName', type: 'string', width: '15%'},
                {text: 'Last Name', dataField: 'LastName', type: 'string', width: '15%'},
                {text: 'Company', dataField: 'Company', type: 'string', hidden: true},
                {text: 'Address', dataField: 'Address1', type: 'string', hidden: true},
                {text: 'Address2', dataField: 'Address2', type: 'string', hidden: true},
                {text: 'City', dataField: 'City', type: 'string', hidden: true},
                {text: 'State', dataField: 'State', type: 'string', hidden: true},
                {text: 'Zip', dataField: 'Zip', type: 'string', hidden: true},
                {text: 'Phone', dataField: 'Phone1', type: 'string', hidden: true},
                {text: 'Phone2', dataField: 'Phone2', type: 'string', hidden: true},
                {text: 'Email', dataField: 'Email', type: 'string', hidden: true},
                {text: 'Full Identification', dataField: 'Custom1', type: 'string', width: '15%'},
                {text: 'Date of Birth', dataField: 'Custom2', type: 'string', width: '15%'},
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
                {text: 'Relationship', dataField: 'Custom16', type: 'string', width: '15%'},
                {text: 'ParentUnique', dataField: 'ParentUnique', type: 'int', hidden: true}
            ],
            //columnsResize: true,
            width: "100%",
            theme: 'arctic',
            sortable: true,
            pageable: true,
            pageSize: 10,
            pagerMode: 'simple',
            filterable: true,
            altRows: true,
            autoheight: true,
            autorowheight: true
            //showfilterrow: (parentUnique) ? true : false,
            //columnsautoresize: true
        }
    };

    this.getNotesTableSettings = function (parentUnique) {
        var urlToRequest = '';
        if (parentUnique != undefined) {
            urlToRequest = SiteRoot + 'admin/Customer/load_customerNotes/' + parentUnique;
        }
        return {
            source: new $.jqx.dataAdapter({
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
            }),
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
            filterable: true,
            showfilterrow: (parentUnique) ? true : false,
            pageable: true,
            pageSize: 10,
            altRows: true,
            autoheight: true,
            autorowheight: true
        }
    };

    var rowExpanded;
    var purchaseGrid = $('#customerPurchasesGrid, #gridCustomer, #customerReceiptGrid');
    purchaseGrid.on('rowexpand', function (e) {
        var current = e.args.rowindex;
        if (rowExpanded != current) {
            $(this).jqxGrid('hiderowdetails', rowExpanded);
            rowExpanded = current;
        }
    });

    this.getReceiptTableSettings = function(parentUnique) {
        var urlToRequest = '';
        if (parentUnique != undefined) {
            urlToRequest = SiteRoot + 'admin/Customer/load_receiptsCustomer/' + parentUnique;
        }
        var initrowdetails = function (index, parentElement, gridElement, datarecord) {
            var grid = $($(parentElement).children()[0]);
            var unique = datarecord.ReceiptID;
            var detailsUrl = '';
            if (unique != undefined) {
                detailsUrl = SiteRoot + 'admin/Customer/getReceiptDetailsByHeader/' + unique;
            }
            if (grid != null) {
                grid.jqxGrid({
                    source: new $.jqx.dataAdapter({
                        dataType: 'json',
                        dataFields: [
                            {name: 'ReceiptID', type: 'int'},
                            {name: 'Item', type: 'string'},
                            {name: 'Description', type: 'string'},
                            {name: 'ListPrice', type: 'string'},
                            {name: 'SellPrice', type: 'string'},
                            {name: 'Quantity', type: 'string'},
                            {name: 'Tax', type: 'string'},
                            {name: 'Total', type: 'string'},
                            {name: 'Status', type: 'string'},
                            {name: 'StatusName', type: 'string'},
                            {name: 'Created', type: 'string'},
                            {name: 'CreatedBy', type: 'string'},
                            {name: 'Updated', type: 'string'},
                            {name: 'UpdatedBy', type: 'string'},
                        ],
                        id: 'ReceiptID',
                        url: detailsUrl
                    }),
                    width: '99%',
                    height: '100',
                    columns: [
                        {dataField: 'ReceiptID', hidden: true},
                        {text: 'Item', dataField: 'Item', width: '10%'},
                        {text: 'Description', dataField: 'Description', width: '12%'},
                        {text: 'List', dataField: 'ListPrice', filtertype: 'input',
                            width:'8%', cellsalign: 'right', align: 'right'},
                        {text: 'Sell', dataField: 'SellPrice', filtertype: 'input',
                            width:'8%', cellsalign: 'right', align: 'right'},
                        {text: 'Quantity', dataField: 'Quantity', filtertype: 'input',
                            width:'8%', cellsalign: 'right', align: 'right'},
                        {text: 'Total', dataField: 'Total', filtertype: 'input',
                            width:'8%', cellsalign: 'right', align: 'right'},
                        {text: 'Status', dataField: 'StatusName', width: '10%', filtertype: 'list'},
                        {text: 'Created', dataField: 'Created', width: '8%', filtertype: 'date'},
                        {text: 'Created By', dataField: 'CreatedBy', filtertype: 'list',
                            width: '10%'},
                        {text: 'Updated', dataField: 'Updated', width: '8%', filtertype: 'date'},
                        {text: 'Updated By', dataField: 'UpdatedBy', filtertype: 'list',
                            width: '10%'}
                    ],
                    sortable: true,
                    filterable: true,
                    showfilterrow: true,
                    pageable: true,
                    pageSize: 5,
                    altRows: true,
                    autoheight: true,
                    autorowheight: true
                });
            }
        };

        return {
            source: new $.jqx.dataAdapter({
                dataType: 'json',
                dataFields: [
                    {name: 'ReceiptID', type: 'int'},
                    {name: 'Receipt', type: 'string'},
                    {name: 'SubTotal', type: 'string'},
                    {name: 'Tip', type: 'string'},
                    {name: 'Total', type: 'string'},
                    {name: 'CustomerID', type: 'string'},
                    {name: 'Customer', type: 'string'},
                    {name: 'Location', type: 'string'},
                    {name: 'Status', type: 'string'},
                    {name: 'StatusName', type: 'string'},
                    {name: 'ReceiptDate', type: 'string'},
                    {name: 'Created', type: 'string'},
                    {name: 'CreatedBy', type: 'string'},
                    {name: 'Updated', type: 'string'},
                    {name: 'UpdatedBy', type: 'string'},
                    // {name: 'Quantity', type: 'string'},
                    {name: 'SellPrice', type: 'string'},
                    {name: 'Description', type: 'string'},
                    // {name: 'Discount', type: 'string'},
                    {name: 'ListPrice', type: 'string'},
                    {name: 'Tax', type: 'string'},
                    // {name: 'ExtSell', type: 'string'},
                ],
                id: 'ReceiptID',
                url: urlToRequest
            }),
            columns: [
                {dataField: 'ReceiptID', hidden: true},
                {text: 'Location', dataField: 'Location', filtertype: 'checkedlist', width: '15%'},
                {text: 'Date', dataField: 'ReceiptDate', filtertype: 'range', width: '25%'},
                {text: 'Receipt', dataField: 'Receipt', filtertype: 'textbox', width: '15%'},
                {text: 'Status', dataField: 'StatusName', filtertype: 'checkedlist',  width: '15%'},
                {text: 'Total', dataField: 'Total', width:'15%', filtertype: 'input',
                    filtercondition: 'equal,less_than, greater_than',
                    cellsalign: 'right', align: 'right'},
                {text: 'Created By', dataField: 'CreatedBy', filtertype: 'checkedlist', width: '15%'},
                {dataField: 'Created', hidden: true},
                {dataField: 'UpdatedBy', hidden: true},
                {dataField: 'Updated', hidden: true},
                {dataField: 'Description', hidden: true},
                {dataField: 'SellPrice', hidden: true},
                {dataField: 'ListPrice', hidden: true},
                {dataField: 'Tax', hidden: true},
            ],
            columnsResize: true,
            width: "99%",
            theme: 'artic',
            sortable: true,
            pageable: true,
            pageSize: 10,
            pagerMode: 'simple',
            altRows: true,
            autoheight: true,
            autorowheight: true,
            filterable: true,
            showfilterrow: true,
            rowdetails: true,
            rowdetailstemplate: {
                rowdetails: "<div class='customer_receipt' style='margin-top: 5px;'></div>",
                rowdetailsheight: 100
            },
            initrowdetails: initrowdetails,
            showaggregates: true,
            showstatusbar: true,
            statusbarheight: 50,
            ready: function() {
                $('#row00customerReceiptGrid .jqx-grid-cell-pinned input[type="textarea"]').each(function(i, el){
                    if($(el).css('width') != '0px')
                        $(el).focus();
                });
            },
            updatefilterconditions: function (type, defaultconditions) {
                var stringcomparisonoperators = [];
                var numericcomparisonoperators = ['EQUAL', 'NOT_EQUAL', 'LESS_THAN', 'LESS_THAN_OR_EQUAL', 'GREATER_THAN', 'GREATER_THAN_OR_EQUAL'];
                var datecomparisonoperators = [];
                var booleancomparisonoperators = [];
                switch (type) {
                    case 'stringfilter':
                        return stringcomparisonoperators;
                    case 'numericfilter':
                        return numericcomparisonoperators;
                    case 'datefilter':
                        return datecomparisonoperators;
                    case 'booleanfilter':
                        return booleancomparisonoperators;
                }
            },
            autoshowfiltericon: true,
        }
    };

    this.getPurchasesTableSettings = function (parentUnique) {
        var urlToRequest = '';
        if (parentUnique != undefined) {
            urlToRequest = SiteRoot + 'admin/Customer/load_purchasesCustomer/' + parentUnique;
        }
        var initrowdetails = function (index, parentElement, gridElement, datarecord) {
            var receiptnumber = (datarecord.ReceiptNumber != null) ? datarecord.ReceiptNumber : '';
            var description = (datarecord.Description != null) ? datarecord.Description : '';
            var company = (datarecord.Company != null) ? datarecord.Company : '';
            var quantity = datarecord.Quantity;
            var listPrice = datarecord.ListPrice;
            var sellprice = datarecord.SellPrice;
            var discount =  datarecord.Discount;
            var tax = datarecord.Tax ;
            var total = datarecord.Total;
            var created = datarecord.created;
            var createdby = datarecord.created_by;
            var updated = datarecord.updated;
            var updatedby = datarecord.updated_by;
            var location = datarecord.location_unique;
            var moreDetails =
                "<span>Location: <b>" + location + " </b></span> " +
                "<span>Receipt: <b>" + receiptnumber + " </b></span> " +
                "<span>Created By: <b>" + createdby + " </b> at <b>" + created + "</b></span> " +
                "<span>Updated By: <b>" + updatedby + " </b> at <b>" + updated + "</b></span><br>" +
                "<span>ID: <b>" + datarecord.Unique + " </b></span> " +
                "<span>Description: <b>" + description + " </b></span><br>" +
                "<span>List: <b>" + listPrice + " </b></span> " +
                "<span>Discount: <b>" + discount + " </b></span> " +
                "<span>Sell: <b>" + sellprice + " </b></span>" +
                "<span>Quantity: <b>" + quantity + " </b></span>" +
                "<span>Tax: <b>" + tax + " </b></span>" +
                "<span>Total: <b>" + total + " </b></span><br>"
                ;
            //
            var rowDetailsContainer = $($(parentElement).children()[0]);
            rowDetailsContainer.html(moreDetails);
        };

        var aggregates = function (aggregatedValue, currentValue, column, record) {
            var decimals;
            if (column == 'ExtSell') {
                decimals = $('#decimalPriceValue').val();
            } else if (column == 'Quantity') {
                decimals = $('#decimalQuantityValue').val();
            }
            return (Math.floor(aggregatedValue) + Math.floor(currentValue)).toFixed(decimals);
        };

        var aggregatesrender = function (aggregates, column, element, summaryData) {
            var renderstring = "<div style='float: left; width: 100%; height: 100%;'>";
            $.each(aggregates, function (key, value) {
                renderstring += '<div style="position: relative; margin: 6px; text-align: right; overflow: hidden;"><b>' + key + ': ' + value + '</b></div>';
            });
            renderstring += "</div>";
            return renderstring;
        };

        return {
            source: new $.jqx.dataAdapter({
                dataType: 'json',
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'ReceiptNumber', type: 'string'},
                    {name: 'ReceiptDate_', type: 'string'},
                    {name: 'FirstName', type: 'string'},
                    {name: 'LastName', type: 'string'},
                    {name: 'Company', type: 'string'},
                    {name: 'Item', type: 'string'},
                    {name: 'Description', type: 'string'},
                    {name: 'Quantity', type: 'string'},
                    {name: 'SellPrice', type: 'string'},
                    {name: 'Discount', type: 'string'},
                    {name: 'ListPrice', type: 'string'},
                    {name: 'Tax', type: 'string'},
                    {name: 'Total', type: 'string'},
                    {name: 'ExtSell', type: 'string'},
                    {name: 'CustomerUnique', type: 'string'},
                    {name: 'location_unique', type: 'string'},
                    {name: 'created', type: 'string'},
                    {name: 'created_by', type: 'string'},
                    {name: 'updated', type: 'string'},
                    {name: 'updated_by', type: 'string'},
                ],
                id: 'Unique',
                url: urlToRequest
            }),
            columns: [
                {text: 'ID', dataField: 'Unique', type: 'int', hidden: true},
                {text: 'Receipt Date', dataField: 'ReceiptDate_', type: 'string', width: '15%'}, //filterable: false
                {text: 'First Name', dataField: 'FirstName', type: 'text', hidden: true},
                {text: 'Last Name', dataField: 'LastName', type: 'text', hidden: true},
                {text: 'Company', dataField: 'Company', type: 'text', hidden: true},
                {text: 'Item', dataField: 'Item', type: 'text', width: '10%'},
                {text: 'Description', dataField: 'Description', type: 'text', width: '45%'},
                {text: 'Sell Price', dataField: 'SellPrice', type: 'text', width: '10%',
                    cellsalign: 'right', align: 'right'},
                {text: 'Quantity', dataField: 'Quantity', type: 'text', width: '10%',
                    aggregates: [{ 'Total': aggregates }],
                    aggregatesrenderer: aggregatesrender,
                    cellsalign: 'right', align: 'right'
                },
                {text: 'Ext Sell', dataField: 'ExtSell', type: 'text', width: '10%',
                    aggregates: [{ '<b>Total</b>': aggregates}],
                    aggregatesrenderer: aggregatesrender,
                    cellsalign: 'right', align: 'right'
                },
                {dataField: 'Discount', type: 'string',hidden: true},
                {dataField: 'ListPrice', type: 'string',hidden: true},
                {dataField: 'Tax', type: 'string', hidden: true},
                {dataField: 'Total', type: 'string',hidden: true},
                {text: 'CustomerUnique', dataField: 'CustomerUnique', type: 'string', hidden: true},
                {dataField: 'location_unique', type: 'string', hidden: true},
                {text: 'Created', dataField: 'created', type: 'text', hidden: true},
                {text: 'CreatedBy', dataField: 'created_by', type: 'text', hidden: true},
                {text: 'Updated', dataField: 'updated', type: 'text', hidden: true},
                {text: 'UpdatedBy', dataField: 'updated_by', type: 'text', hidden: true},
            ],
            columnsResize: true,
            width: "99%",
            theme: 'artic',
            sortable: true,
            pageable: true,
            pageSize: 10,
            pagerMode: 'simple',
            altRows: true,
            autoheight: true,
            autorowheight: true,
            filterable: true,
            showfilterrow: true,
            rowdetails: true,
            rowdetailstemplate: {
                rowdetails: "<div style='margin-top: 5px;'></div>",
                rowdetailsheight: 75
            },
            initrowdetails: initrowdetails,
            showaggregates: true,
            showstatusbar: true,
            statusbarheight: 50,
            ready: function() {
                $('#row00customerPurchasesGrid .jqx-grid-cell-pinned input[type="textarea"]').each(function(i, el){
                    if($(el).css('width') != '0px')
                        $(el).focus();
                });
            }
        }
    };

    this.getVisitsTableTabSettings = function(unique) {
        var urlToRequest = '';
        if (unique != undefined)
            urlToRequest = SiteRoot + 'admin/CustomerCheckin/load_checkedInCustomers/2/0/' + unique;
        var dataAdapterCustomerGrid = new $.jqx.dataAdapter({ //_this.sourceCheckInCompleteGrid
            dataType: 'json',
            dataFields: [
                {name: 'LocationUnique', type: 'string'},
                {name: 'LocationName', type: 'string'},
                {name: 'CheckOutDate', type: 'date'},
                {name: '_CheckOutDate', type: 'string'},
                {name: 'CheckOutBy', type: 'string'},
                {name: 'CheckInDate', type: 'string'},
                {name: '_CheckInDate', type: 'string'},
                {name: 'CheckInBy', type: 'string'},
                {name: 'Quantity', type: 'string'},
                {name: 'StatusCheckIn', type: 'string'},
                {name: 'Note', type: 'string'},
                {name: 'CheckInUser', type: 'string'},
                {name: 'CheckOutUser', type: 'string'},
                {name: 'lname', type: 'string'},
                {name: 'fname', type: 'string'},
                {name: 'VisitUnique', type: 'int'}
            ],
            url: urlToRequest
        });
        return {
            source: dataAdapterCustomerGrid,
            columns: [
                {text: 'Location', dataField: 'LocationName', type: 'string', width: '10%', filtertype: 'list'},
                {text: 'Check In Date', dataField: '_CheckInDate', type: 'date', width: '15%', },
                {text: '', dataField: 'CheckInDate', type: 'string', hidden:true},
                {text: 'Check In By', dataField: 'CheckInUser', type: 'string', width: '7%', filtertype: 'list'},
                {text: 'Check Out date', dataField: '_CheckOutDate', type: 'date', width: '15%',},
                {text: '', dataField: 'CheckOutDate', type: 'string', hidden:true},
                {text: 'Check Out By', dataField: 'CheckOutUser', type: 'string', width: '7%', filtertype: 'list'},
                {text: 'Quantity', dataField: 'Quantity', type: 'string', width: '15%'},
                {text: 'Note', dataField: 'Note', type: 'string', width: '30%'},
                {text: 'Visit ID', dataField: 'VisitUnique', type: 'int', hidden: true},
                {text: '', dataField: 'LocationUnique', type: 'string', hidden: true},
                {text: '', dataField: 'StatusCheckIn', type: 'string', hidden: true},
                {text: '', dataField: 'CheckInBy', type: 'string', hidden: true},
                {text: '', dataField: 'CheckOutBy', type: 'string', hidden: true},
                {text: '', dataField: 'lname', type: 'string', hidden: true},
                {text: '', dataField: 'fname', type: 'string', hidden: true}
            ],
            showfilterrow: true,
            width: "98.7%",
            theme: 'arctic',
            sortable: true,
            filterable: true,
            pageable: true,
            pageSize: 10,
            pagerMode: 'simple',
            altRows: true,
            autoheight: true,
            autorowheight: true
        };
    };

    this.getCardTableSettings = function(unique) {
        var urlToRequest = '';
        if (unique != undefined)
            urlToRequest = SiteRoot + 'admin/Customer/load_cardCustomer/' + unique;
        var dataAdapterCustomerGrid = {
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'string'},
                {name: 'Card4', type: 'string'},
                {name: 'CardType', type: 'date'},
                {name: 'Created', type: 'string'},
                {name: 'Created_', type: 'string'},
                {name: 'CreatedBy', type: 'string'},
                {name: 'CreatedByName', type: 'string'}
            ],
            url: urlToRequest
        };

        var settings = {
            source: dataAdapterCustomerGrid,
            columns: [
                {dataField: 'Unique', hidden:true}, // filtertype: 'list'
                {text: 'Card', dataField: 'Card4', width: '25%', filtertype: 'list'},
                {text: 'Card Type', dataField: 'CardType', width: '25%', filtertype: 'list'},
                {text: 'Created', dataField: 'Created_', width: '30%', filtertype: 'range'},
                {text: 'Created By', dataField: 'CreatedByName', width: '20%', filtertype: 'list'}

            ],
            showfilterrow: true,
            width: "99%",
            theme: 'arctic',
            sortable: true,
            filterable: true,
            filterMode: 'simple',
            pageable: true,
            pageSize: 10,
            pagerMode: 'simple',
            autoheight: true,
            autorowheight: true,
            columnsResize: true,
            ready: function() {}
        };

        return settings;
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