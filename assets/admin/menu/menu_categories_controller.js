/**
 * Created by carlosrenato on 05-13-16.
 */

app.controller('menuCategoriesController', function($scope, $http, itemInventoryService){

    var menuonce = false;
    var cateonce = false;
    // -- MenuCategoriesTabs Main Tabs
    $('#MenuCategoriesTabs').on('selecting', function (event) {
        var tabclicked = event.args.item;
        var tabTitle = $('#MenuCategoriesTabs').jqxTabs('getTitleAt', tabclicked);
        if(tabclicked == 0) {
            event.cancel = true;
            window.location.href = SiteRoot + 'backoffice/dashboard';
        }
        // else if(tabclicked == 1){
        //     event.cancel = true;
        //     window.location.href = SiteRoot + 'dashboard/admin';
        // }
        // Categories TAB - Reload queries
        else if(tabTitle == 'Categories') {
            if (!cateonce) {
                $('#categoriesDataTable').on('bindingcomplete', function() {
                    $('#categoriesDataTable').jqxGrid('clearfilters');
                });
            }
            reloadMenuSelectOnCategories();
        }
        else if (tabTitle == 'Menu') {
            if (!menuonce) {
                $('#menuGridTable').on('bindingcomplete', function() {
                    $('#menuGridTable').jqxGrid('clearfilters');
                });
            }
            updateMenuGridReq();
            //updateMainMenuGrid();
            // reloadMenuSelectOnCategories();
        }
    });

    /**
     * MENU TAB LOGIC
     */
    var menuWindow, categoryWindow;
    $scope.menuTableSettings = {
        source: new $.jqx.dataAdapter({
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'int'},
                {name: 'MenuName', type: 'string'},
                {name: 'Status', type: 'string'},
                {name: 'StatusName', type: 'string'},
                {name: 'Column', type: 'string'},
                {name: 'Row', type: 'string'},
                {name: 'MenuItemRow', type: 'string'},
                {name: 'MenuItemColumn', type: 'string'},
                {name: 'ItemLength', type: 'string'}
            ],
            // url: SiteRoot + 'admin/MenuCategory/load_allmenus'
            url: ''
        }),
        columns: [
            {text: 'ID', dataField: 'Unique', type: 'int'},
            {text: 'Menu Name', dataField: 'MenuName', type: 'number'},
            {text: 'Status', dataField: 'Status', type: 'int', hidden:true},
            {text: 'Status', dataField: 'StatusName', type: 'string'},
            {text: 'Column', dataField: 'Column', type: 'number'},
            {text: 'Row', dataField: 'Row', type: 'number'},
            {text: 'Menu Item Row', dataField: 'MenuItemRow', type: 'number', hidden: true},
            {text: 'Menu Item Column', dataField: 'MenuItemColumn', type: 'number', hidden: true},
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
        pageSize: 15,
        pagesizeoptions: ['5', '10', '15'],
        altRows: true,
        autoheight: true,
        autorowheight: true
    };

    function updateMainMenuGrid() {
        if ($scope.newOrEditOption == 'new') {
            updateMenuGridReq();
        } else {
            $('#menuGridTable').jqxGrid('updatebounddata', 'filter');
        }
    }

    function updateMenuGridReq() {
        $('#menuGridTable').jqxGrid({
            source: new $.jqx.dataAdapter({
                dataType: 'json',
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'MenuName', type: 'string'},
                    {name: 'Status', type: 'string'},
                    {name: 'StatusName', type: 'string'},
                    {name: 'Column', type: 'string'},
                    {name: 'Row', type: 'string'},
                    {name: 'MenuItemRow', type: 'string'},
                    {name: 'MenuItemColumn', type: 'string'},
                    {name: 'ItemLength', type: 'string'}
                ],
                url: SiteRoot + 'admin/MenuCategory/load_allmenus'
            })
        });
    }

    // Menu Notification settings
    var setNotificationInit = function (type) {
        return {
            width: "auto",
            appendContainer: "#notification_container",
            opacity: 0.9,
            closeOnClick: true,
            autoClose: true,
            showCloseButton: false,
            template: (type == 1) ? 'success' : 'error'
        }
    };
    $scope.menuNotificationsSuccessSettings = setNotificationInit(1);
    $scope.menuNotificationsErrorSettings = setNotificationInit(0);

    // Menu Windows settings
    $('#add_Status').jqxDropDownList({autoDropDownHeight: true});
    $scope.addMenuWindowSettings = {
        created: function (args) {
            menuWindow = args.instance;
        },
        resizable: false,
        width: "60%", height: "65%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    // Events menu controls
    $('.menuFormContainer .required-field').on('keypress keyup paste change', function (e) {
        $('#saveMenuBtn').prop('disabled', false);
    });

    $('#add_Status').on('select', function(){
        $('#saveMenuBtn').prop('disabled', false);
    });

    $scope.newOrEditOption = null;
    $scope.menuId = null;
    $scope.newMenuAction = function() {
        menuWindow.setTitle('Add New Menu');
        $scope.newOrEditOption = 'new';
        $scope.menuId = null;
        $('#saveMenuBtn').prop('disabled', true);
        setTimeout(function(){
            $('#add_MenuName').focus();
        }, 100);
        menuWindow.open();
    };

    $scope.updateMenuAction = function(e) {
        var values = e.args.row.bounddata;
        var statusCombo = $('#add_Status').jqxDropDownList('getItemByValue', values['Status']);
        $('#add_Status').jqxDropDownList({'selectedIndex': statusCombo.index});
        $('#add_MenuName').val(values['MenuName']);
        $('#add_MenuColumn').val(values['Column']);
        $('#add_MenuRow').val(values['Row']);
        $('#add_MenuItemRow').val(values['MenuItemRow']);
        $('#add_MenuItemColumn').val(values['MenuItemColumn']);
        $('#add_ItemLength').val(values['ItemLength']);

        $('#deleteMenuBtn').show();
        $scope.newOrEditOption = 'edit';
        $scope.menuId = values['Unique'];
        $('#saveMenuBtn').prop('disabled', true);
        menuWindow.setTitle('Edit Menu ID: ' + values['Unique'] + ' | Menu: <b>' + values['MenuName'] +'</b>');
        menuWindow.open();
    };

    $scope.CloseMenuWindows = function(option) {
        if (option == 0) {
            $scope.SaveMenuWindows(option);
            $('#mainButtonsForMenus').show();
            $('.alertButtonsMenuCategories').hide();
        } else if (option == 1) {
            resetMenuWindows();
            menuWindow.close();
        } else if (option == 2) {
            $('#promptToSaveInCloseButtonMenu').hide();
            $('#mainButtonsForMenus').show();
        } else {
            if ($('#saveMenuBtn').is(':disabled')) {
                menuWindow.close();
                resetMenuWindows();
            } else {
                $('#mainButtonsForMenus').hide();
                $('.alertButtonsMenuCategories').hide();
                $('#promptToSaveInCloseButtonMenu').show();
            }
        }
    };

    var validationMenuItem = function(values) {
        var needValidation = false;
        $('.menuFormContainer .required-field').each(function(i, el) {
            if (el.value == '') {
                $('#menuNotificationsErrorSettings #notification-content')
                    .html($(el).attr('placeholder') + ' can not be empty!');
                $(el).css({"border-color": "#F00"});
                $scope.menuNotificationsErrorSettings.apply('open');
                needValidation = true;
            } else {
                $(el).css({"border-color": "#ccc"});
            }
        });
        return needValidation;
    };

    $scope.SaveMenuWindows = function (closed) {
        var values = {
            'MenuName': $('#add_MenuName').val(),
            'Row': $('#add_MenuRow').val(),
            'Column': $('#add_MenuColumn').val(),
            'MenuItemRow': $('#add_MenuItemRow').val(),
            'MenuItemColumn': $('#add_MenuItemColumn').val(),
            'ItemLength': $('#add_ItemLength').val(),
            'Status': $('#add_Status').jqxDropDownList('getSelectedItem').value
        };
        if (!validationMenuItem(values)) {
            var url;
            if ($scope.newOrEditOption == 'new') {
                url = SiteRoot + 'admin/MenuCategory/add_newMenu';
            } else if ($scope.newOrEditOption == 'edit') {
                url = SiteRoot + 'admin/MenuCategory/edit_newMenu/' + $scope.menuId;
            }
            //$http({
            $.ajax({
                method: 'POST',
                url: url,
                data: values,
                dataType: 'json',
                //}).then(function(response) {
                success: function (response) {
                    if (response.status == "success") {
                        updateMainMenuGrid();
                        if ($scope.newOrEditOption == 'new') {
                            $('#menuNotificationsSuccessSettings #notification-content')
                                .html('Menu created successfully!');
                            $scope.menuNotificationsSuccessSettings.apply('open');
                            setTimeout(function () {
                                menuWindow.close();
                                resetMenuWindows();
                            }, 1500);
                        } else if ($scope.newOrEditOption == 'edit') {
                            $('#menuNotificationsSuccessSettings #notification-content')
                                .html('Menu updated successfully!');
                            $scope.menuNotificationsSuccessSettings.apply('open');
                            $('#saveMenuBtn').prop('disabled', true);
                            if (closed == 0) {
                                $scope.CloseMenuWindows();
                            }
                        }
                        // -----
                        reloadMenuSelectOnCategories();
                        // ------
                    } else {
                        $.each(response.message, function (i, val) {
                            $('#menuNotificationsErrorSettings #notification-content')
                                .html(val);
                            $('#add_' + i).css({"border-color": "#F00"});
                            $scope.menuNotificationsErrorSettings.apply('open');
                        });
                    }
                }
            });
        }
    };

    var resetMenuWindows = function() {
        $('.menuFormContainer .required-field').css({"border-color": "#ccc"});
        $('#deleteMenuBtn').hide();
        $('.alertButtonsMenuCategories').hide();
        $('#mainButtonsForMenus').show();

        $('#saveMenuBtn').prop('disabled', true);

        $('#add_MenuName').val('');
        $('#add_MenuRow').val(2);
        $('#add_MenuColumn').val(5);
        $('#add_MenuItemColumn').val(5);
        $('#add_MenuItemRow').val(5);
        $('#add_ItemLength').val(25);
        $('#add_Status').jqxDropDownList({'selectedIndex': 0});
    };

    $scope.beforeDeleteMenu = function(option) {
        $('#mainButtonsForMenus').hide();
        if (option == 0) {
            $http({
                method: 'POST',
                url: SiteRoot + 'admin/MenuCategory/remove_menu/' + $scope.menuId
            }).then(function(response) {
                if (response.data.status == "success") {
                    updateMainMenuGrid();
                    //$('#menuNotificationsSuccessSettings #notification-content')
                    //    .html('Menu was deleted successfully!');
                    //$scope.menuNotificationsSuccessSettings.apply('open');
                    menuWindow.close();
                    resetMenuWindows();
                } else {
                    console.log(response);
                }
            }, function(response) {
                console.log('There was an error');
                //console.log(response);
            });
        } else if (option == 1) {
            resetMenuWindows();
            menuWindow.close();
        } else if (option == 2) {
            $('.alertButtonsMenuCategories').hide();
            $('#mainButtonsForMenus').show();
            // Press button delete
        } else {
            $('#beforeDeleteMenu').show();
            $('#mainButtonsForMenus').hide();
        }
    };

    /**
     * --------------------
     * CATEGORIES TAB LOGIC
     * --------------------
     */
    $scope.categoriesTableSettings = {
        source: {
            dataType: 'json',
            dataFields: [
                {name: 'Unique', type: 'int'},
                {name: 'CategoryName', type: 'string'},
                {name: 'Sort', type: 'number'},
                {name: 'Row', type: 'number'},
                {name: 'Column', type: 'number'},
                {name: 'Status', type: 'number'},
                {name: 'StatusName', type: 'string'},
                {name: 'MenuUnique', type: 'number'},
                {name: 'MenuName', type: 'string'}
            ],
            url: ''
            // url: SiteRoot + 'admin/MenuCategory/load_allcategories'
        },
        columns: [
            {text: 'ID', dataField: 'Unique', type: 'int'},
            {text: 'Category Name', dataField: 'CategoryName', type: 'string'},
            {dataField: 'MenuUnique', type: 'string', hidden: true},
            {text: 'Menu', dataField: 'MenuName', type: 'string', filtertype: 'list'},
            {text: 'Row', dataField: 'Row', type: 'number'},
            {text: 'Column', dataField: 'Column', type: 'number'},
            {text: 'Sort', dataField: 'Sort', type: 'number'},
            {dataField: 'Status', type: 'number', hidden: true},
            {text: 'Status', dataField: 'StatusName', type: 'string'}
        ],
        columnsResize: true,
        width: "99.7%",
        //height: "100%",
        theme: 'arctic',
        filterable: true,
        showfilterrow: true,
        sortable: true,
        pageable: true,
        pagerMode: 'default',
        pageSize: 15,
        pagesizeoptions: ['5', '10', '15'],
        altRows: true,
        autoheight: true,
        autorowheight: true
    };

    // Menu Notification settings
    var setNotificationCategoryInit = function (type) {
        return {
            width: "auto",
            appendContainer: "#notification_container_category",
            opacity: 0.9,
            closeOnClick: true,
            autoClose: true,
            showCloseButton: false,
            template: (type == 1) ? 'success' : 'error'
        }
    };
    $scope.categoryNotificationsSuccessSettings = setNotificationCategoryInit(1);
    $scope.categoryNotificationsErrorSettings = setNotificationCategoryInit(0);

    // Menu select
    var dataAdapter = new $.jqx.dataAdapter(
    {
        datatype: "json",
        datafields: [
            { name: 'MenuName' },
            { name: 'Status' },
            { name: 'Unique' }
        ],
        id: 'Unique',
        url: SiteRoot + 'admin/MenuCategory/load_allmenus/1'
    });

    $scope.settingsMenuSelect =
        { source: dataAdapter, displayMember: "MenuName", valueMember: "Unique", width: 180};

    function reloadMenuSelectOnCategories() {
        $('#add_MenuUnique').jqxDropDownList({
            source: new $.jqx.dataAdapter({
                    datatype: "json",
                    datafields: [
                        { name: 'MenuName' },
                        { name: 'Status' },
                        { name: 'Unique' }
                    ],
                    url: SiteRoot + 'admin/MenuCategory/load_allmenus/1'
                })
        });
        // Categories grid!
        $('#categoriesDataTable').jqxGrid({
            source: new $.jqx.dataAdapter({
                dataType: 'json',
                dataFields: [
                    {name: 'Unique', type: 'int'},
                    {name: 'CategoryName', type: 'string'},
                    {name: 'Sort', type: 'number'},
                    {name: 'Row', type: 'number'},
                    {name: 'Column', type: 'number'},
                    {name: 'Status', type: 'number'},
                    {name: 'StatusName', type: 'string'},
                    {name: 'MenuUnique', type: 'number'},
                    {name: 'MenuName', type: 'string'}
                ],
                url: SiteRoot + 'admin/MenuCategory/load_allcategories'
            })
        });
    }

    // Status select
    $('#add_CategoryStatus').jqxDropDownList({autoDropDownHeight: true});
    $('#add_MenuUnique').jqxDropDownList({autoDropDownHeight: true});

    // Init scope
    $scope.newOrEditCategoryOption = null;
    $scope.categoryId = null;

    // Open category windows
    $scope.addCategoryWindowSettings = {
        created: function (args) {
            categoryWindow = args.instance;
        },
        resizable: false,
        width: "60%", height: "65%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    // Events category controls
    $('.categoryFormContainer .required-field').on('keypress keyup paste change', function (e) {
        $('#saveCategoryBtn').prop('disabled', false);
    });

    $('#add_CategoryStatus, #add_MenuUnique').on('select', function() {
        //$('#add_CategoryStatus').on('select', function() {
        $('#saveCategoryBtn').prop('disabled', false);
    });

    $scope.newCategoryAction = function() {
        $scope.newOrEditCategoryOption = 'new';
        $scope.categoryId = null;

        $('#add_CategoryStatus').jqxDropDownList({selectedIndex: 0});
        $('#add_MenuUnique').jqxDropDownList({selectedIndex: -1});
        setTimeout(function() {
            $('#add_CategoryName').focus();
        }, 100);
        $('#saveCategoryBtn').prop('disabled', true);
        categoryWindow.setTitle('Add New Menu Category');
        categoryWindow.open();
    };

    $scope.updateCategoryAction = function(e) {
        var values = e.args.row.bounddata;
        var statusCombo = $('#add_CategoryStatus').jqxDropDownList('getItemByValue', values['Status']);
        $('#add_CategoryStatus').jqxDropDownList({'selectedIndex': statusCombo.index});

        var menuCombo = $('#add_MenuUnique').jqxDropDownList('getItemByValue', values['MenuUnique']);
        var indexSelected = (menuCombo != undefined) ? menuCombo.index : -1;
        $('#add_MenuUnique').jqxDropDownList({'selectedIndex': indexSelected});

        $('#add_CategoryName').val(values['CategoryName']);
        $('#add_CategoryRow').val(values['Row']);
        $('#add_CategoryColumn').val(values['Column']);
        $('#add_Sort').val(values['Sort']);
        $scope.newOrEditCategoryOption = 'edit';
        $scope.categoryId = values['Unique'];

        $('#deleteCategoryBtn').show();
        $('#saveCategoryBtn').prop('disabled', true);
        categoryWindow.setTitle('Edit Menu Category: ' + values['Unique'] + ' | Category: <b>' +
            values['CategoryName'] + '</b>');
        categoryWindow.open();
    };

    $scope.CloseCategoryWindows = function(option) {
        if (option == 0) {
            $scope.SaveCategoryWindows(option);
            $('#mainButtonsForCategories').show();
            $('.alertButtonsMenuCategories').hide();
        } else if (option == 1) {
            categoryWindow.close();
            resetCategoryWindows();
        } else if (option == 2) {
            $('#promptToSaveInCloseButtonCategory').hide();
            $('#mainButtonsForCategories').show();
        } else {
            if ($('#saveCategoryBtn').is(':disabled')) {
                categoryWindow.close();
                resetCategoryWindows();
            } else {
                $('#mainButtonsForCategories').hide();
                $('.alertButtonsMenuCategories').hide();
                $('#promptToSaveInCloseButtonCategory').show();
            }
        }
    };

    var validationCategoryItem = function() {
        var isOk = false;
        $('.categoryFormContainer .required-field').each(function(i, el) {
            if (el.value == '') {
                $('#categoryNotificationsErrorSettings #notification-content')
                    .html($(el).attr('placeholder') + ' can not be empty!');
                $(el).css({"border-color": "#F00"});
                $scope.categoryNotificationsErrorSettings.apply('open');
                isOk = true;
            } else {
                $(el).css({"border-color": "#ccc"});
            }
        });
        // Menu no selected
        if ($('#add_MenuUnique').jqxDropDownList('getSelectedItem') == null) {
            $('#categoryNotificationsErrorSettings #notification-content')
                .html('Menu cannot be empty, please select');
            $('#add_MenuUnique').css({"border-color": "#F00"});
            $scope.categoryNotificationsErrorSettings.apply('open');
            isOk = true;
        } else {
            $('#add_MenuUnique').css({"border-color": "#ccc"});
        }
        return isOk;
    };

    function updateCategoryGridTable() {
        if ($scope.newOrEditCategoryOption == 'new') {
            $('#categoriesDataTable').jqxGrid({
                source: new $.jqx.dataAdapter({
                    dataType: 'json',
                    dataFields: [
                        {name: 'Unique', type: 'int'},
                        {name: 'CategoryName', type: 'string'},
                        {name: 'Row', type: 'number'},
                        {name: 'Column', type: 'number'},
                        {name: 'Sort', type: 'number'},
                        {name: 'Status', type: 'number'},
                        {name: 'StatusName', type: 'string'},
                        {name: 'MenuUnique', type: 'number'},
                        {name: 'MenuName', type: 'string'}
                    ],
                    url: SiteRoot + 'admin/MenuCategory/load_allcategories'
                })
            });
        }
        else {
            $('#categoriesDataTable').jqxGrid('updatebounddata', 'filter');
        }
    }

    $scope.SaveCategoryWindows = function(closed) {
        if (!validationCategoryItem()) {
            var values = {
                'CategoryName': $('#add_CategoryName').val(),
                'Row': $('#add_CategoryRow').val(),
                'Column': $('#add_CategoryColumn').val(),
                'Sort': $('#add_Sort').val(),
                'Status': $('#add_CategoryStatus').jqxDropDownList('getSelectedItem').value,
                'MenuUnique': $('#add_MenuUnique').jqxDropDownList('getSelectedItem').value
            };

            var url;
            if ($scope.newOrEditCategoryOption == 'new') {
                url = SiteRoot + 'admin/MenuCategory/add_newCategory';
            } else if ($scope.newOrEditCategoryOption == 'edit') {
                url = SiteRoot + 'admin/MenuCategory/update_Category/' + $scope.categoryId;
            }
            $http({
                'method': 'POST',
                'url': url,
                data: values
            }).then(function (response) {
                if (response.data.status == "success") {
                    updateCategoryGridTable();
                    //
                    if ($scope.newOrEditCategoryOption == 'new') {
                        $('#categoryNotificationsSuccessSettings #notification-content')
                            .html('Category created successfully!');
                        $scope.categoryNotificationsSuccessSettings.apply('open');
                        setTimeout(function() {
                            categoryWindow.close();
                            resetCategoryWindows();
                        }, 2000);
                    } else if ($scope.newOrEditCategoryOption == 'edit') {
                        $('#categoryNotificationsSuccessSettings #notification-content')
                            .html('Category updated!');
                        $scope.categoryNotificationsSuccessSettings.apply('open');
                        $('#saveCategoryBtn').prop('disabled', true);
                        if(closed == 0) {
                            $scope.CloseCategoryWindows();
                        }
                    }
                } else {
                    $.each(response.data.message, function(i, val) {
                        $('#categoryNotificationsErrorSettings #notification-content')
                            .html(val);
                        $('#add_' + i).css({"border-color": "#F00"});
                    });
                    $scope.categoryNotificationsErrorSettings.apply('open');
                }
            }, function (response) {
                console.log('There was an error');
            });
        }
    };

    var resetCategoryWindows = function() {
        $('.categoryFormContainer .required-field').css({"border-color": "#ccc"});
        $('#add_MenuUnique').css({"border-color": "#ccc"});
        //
        $('.alertButtonsMenuCategories').hide();
        $('#mainButtonsForCategories').show();
        //
        $('#add_CategoryName').val('');
        $('#add_CategoryRow').val(1);
        $('#add_CategoryColumn').val(1);
        $('#add_Sort').val(1);
        $('#add_CategoryStatus').jqxDropDownList({selectedIndex: 0});
        $('#add_MenuUnique').jqxDropDownList({selectedIndex: -1});
        //
        $('#saveCategoryBtn').prop('disabled', true);
        $('#deleteCategoryBtn').hide();
    };

    $scope.beforeDeleteCategory = function(option) {
        $('#mainButtonsForCategories').hide();
        if (option == 0) {
            $scope.deleteCategoryWindow();
        } else if (option == 1) {
            resetCategoryWindows();
            categoryWindow.close();
        } else if (option == 2) {
            $('.alertButtonsMenuCategories').hide();
            $('#mainButtonsForCategories').show();
            // Press button delete
        } else {
            $('#beforeDeleteCategory').show();
            $('#mainButtonsForCategories').hide();
        }
    };

    $scope.deleteCategoryWindow = function() {
        $http({
            method: 'POST',
            url: SiteRoot + 'admin/MenuCategory/remove_category/' + $scope.categoryId
        }).then(function(response){
            console.info(response);
            if (response.data.status == "success") {
                updateCategoryGridTable();
                categoryWindow.close();
                resetCategoryWindows();
            } else {
                console.log(response);
            }
        }, function(response) {
            console.log('There was an error');
        });
    };

    $scope.number_mainmenuTab = {
        inputMode: 'simple',
        decimalDigits: 0,
        digits: 2,
        spinButtons: true,
        width: 165,
        height: 25,
        textAlign: 'left',
    }

});