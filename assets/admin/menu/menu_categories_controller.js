/**
 * Created by carlosrenato on 05-13-16.
 */

app.controller('menuCategoriesController', function($scope, $http, adminService, menuCategoriesService){

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
        // Categories TAB - Reload queries
        else if(tabTitle == 'Categories') {
            if (!cateonce) {
                $('#categoriesDataTable').on('bindingcomplete', function() {
                    $('#categoriesDataTable').jqxGrid('clearfilters');
                });
            }
            setTimeout(function() {
                $('#categoriesDataTable').show();
                reloadMenuSelectOnCategories();
            }, 250);
        }
        else if (tabTitle == 'Menu') {
            if (!menuonce) {
                $('#menuGridTable').on('bindingcomplete', function() {
                    $('#menuGridTable').jqxGrid('clearfilters');
                });
            }
            setTimeout(function() {
                $('#menuGridTable').show();
                updateMenuGridReq();
            }, 250);
            //updateMainMenuGrid();
            // reloadMenuSelectOnCategories();
        } else {
            $('#menuGridTable').hide();
            $('#categoriesDataTable').hide();
        }
    });

    /**
     * MENU TAB LOGIC
     */
    var pager = adminService.loadPagerConfig();
    var menuWindow, categoryWindow;
    $scope.menuTableSettings = menuCategoriesService.getMenuGridSettings(1);

    function updateMainMenuGrid() {
        if ($scope.newOrEditOption == 'new') {
            updateMenuGridReq();
        } else {
            $('#menuGridTable').jqxGrid('updatebounddata', 'filter');
        }
    }

    function updateMenuGridReq() {
        $('#menuGridTable').jqxGrid({
            source: menuCategoriesService.getMenuGridSettings().source
        });
    }

    // Menu Notification settings
    $scope.menuNotificationsSuccessSettings = adminService.setNotificationSettings(1, '#notification_container');
    $scope.menuNotificationsErrorSettings = adminService.setNotificationSettings(0, '#notification_container');

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

    setTimeout(function() {
        $('#menudCatlfontSize, #menudItemlfontSize').on('change', function() {
            $('#saveMenuBtn').prop('disabled', false);
        });
    }, 1000);
    $('#saveMenuBtn').prop('disabled', true);

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
        $('#add_MenuColumn').val(values['CategoryColumn']);
        $('#add_MenuRow').val(values['CategoryRow']);
        $('#add_MenuItemRow').val(values['ItemRow']);
        $('#add_MenuItemColumn').val(values['ItemColumn']);
        $('#add_ItemLength').val(values['ItemLength']);
        //
        // $('#deleteMenuBtn').show();
        $scope.newOrEditOption = 'edit';
        $scope.menuId = values['Unique'];
        var lfs;
        // -- DEFAULT COLORS - Category
        menuCategoriesService.updateColorControl(values['CategoryButtonPrimaryColor'], 'menudCatbPrimaryColor', $scope);
        menuCategoriesService.updateColorControl(values['CategoryButtonSecondaryColor'], 'menudCatbSecondaryColor', $scope);
        menuCategoriesService.updateColorControl(values['CategoryButtonLabelFontColor'], 'menudCatlfontColor', $scope);
        lfs = (values['CategoryButtonLabelFontSize']) ? values['CategoryButtonLabelFontSize'] : '12px';
        $('menudCatlfontSize').val(lfs);
        // -- DEFAULT COLORS - MenuItem
        menuCategoriesService.updateColorControl(values['ItemButtonPrimaryColor'], 'menudItembPrimaryColor', $scope);
        menuCategoriesService.updateColorControl(values['ItemButtonSecondaryColor'], 'menudItembSecondaryColor', $scope);
        menuCategoriesService.updateColorControl(values['ItemButtonLabelFontColor'], 'menudItemlfontColor', $scope);
        lfs = (values['ItemButtonLabelFontSize']) ? values['ItemButtonLabelFontSize'] : '12px';
        $('#menudItemlfontSize').val(lfs);
        //
        var btn = $('<button/>', {
            'id': 'deleteMenuBtn'
        }).addClass('icon-trash user-del-btn').css('left', 0);
        var title = $('<div/>').html('Edit Menu ID: ' + values['Unique'] + ' | Menu: <b>' + values['MenuName'] +'</b>')
            .prepend(btn)
            .css('padding-left', '2em');
        $('#saveMenuBtn').prop('disabled', true);
        menuWindow.setTitle(title);
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
            'CategoryRow': $('#add_MenuRow').val(),
            'CategoryColumn': $('#add_MenuColumn').val(),
            'ItemRow': $('#add_MenuItemRow').val(),
            'ItemColumn': $('#add_MenuItemColumn').val(),
            'ItemLength': $('#add_ItemLength').val(),
            'Status': $('#add_Status').jqxDropDownList('getSelectedItem').value,
            // Default Colors for Category on Menus
            'CategoryButtonPrimaryColor' : menuCategoriesService.getColorSelected('menudCatbPrimaryColor'),
            'CategoryButtonSecondaryColor' : menuCategoriesService.getColorSelected('menudCatbSecondaryColor'),
            'CategoryButtonLabelFontColor' : menuCategoriesService.getColorSelected('menudCatlfontColor'),
            'CategoryButtonLabelFontSize': $('#menudCatlfontSize').val(),
            // Default Colors for MenuItems on Menus, located on Main grid (layout tab)
            'ItemButtonPrimaryColor' : menuCategoriesService.getColorSelected('menudItembPrimaryColor'),
            'ItemButtonSecondaryColor' : menuCategoriesService.getColorSelected('menudItembSecondaryColor'),
            'ItemButtonLabelFontColor' : menuCategoriesService.getColorSelected('menudItemlfontColor'),
            'ItemButtonLabelFontSize': $('#menudItemlfontSize').val(),
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
        // $('#deleteMenuBtn').hide();
        $('.alertButtonsMenuCategories').hide();
        $('#mainButtonsForMenus').show();

        $('#saveMenuBtn').prop('disabled', true);

        $('#add_MenuName').val('');
        $('#add_MenuRow').val(2);
        $('#add_MenuColumn').val(5);
        $('#add_MenuItemColumn').val(5);
        $('#add_MenuItemRow').val(5);
        $('#add_ItemLength').val(25);
        //
        menuCategoriesService.resetDefaultColor('menudCatbPrimaryColor', $scope, '000000');
        menuCategoriesService.resetDefaultColor('menudCatbSecondaryColor', $scope, '000000');
        menuCategoriesService.resetDefaultColor('menudCatlfontColor', $scope);
        $('#menudCatlfontSize').val('12px');
        menuCategoriesService.resetDefaultColor('menudItembPrimaryColor', $scope, '000000');
        menuCategoriesService.resetDefaultColor('menudItembSecondaryColor', $scope, '000000');
        menuCategoriesService.resetDefaultColor('menudItemlfontColor', $scope);
        $('#menudItemlfontSize').val('12px');
        //
        $('#add_Status').jqxDropDownList({'selectedIndex': 0});
        $('#menuTopTabs').jqxTabs('select', 0);
    };

    $('body').on('click', '#deleteMenuBtn', function() {
        $scope.beforeDeleteMenu();
    });

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
    $('#category_subtabs').on('selecting', function(e) {
        var tabclicked = e.args.item;
        var tabTitle = $(this).jqxTabs('getTitleAt', tabclicked);
        if(tabTitle == 'Picture') {
            $('#categoryPictureBtn').show();
        } else {
            $('#categoryPictureBtn').hide();
        }
    });

    $scope.categoriesTableSettings = menuCategoriesService.getCategoryGridSettings(1);
    // Menu Notification settings
    $scope.categoryNotificationsSuccessSettings = adminService.setNotificationSettings(1, '#notification_container_category');
    $scope.categoryNotificationsErrorSettings = adminService.setNotificationSettings(0, '#notification_container_category');
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

    $('#add_MenuUnique').on('select', function(e) {
        if (e.args.item) {
            var item = e.args.item.originalItem;
            console.log(item);
            if ($scope.newOrEditCategoryOption == 'new') {
                menuCategoriesService.updateColorControl(item.CategoryButtonPrimaryColor, 'bPrimaryColor', $scope);
                menuCategoriesService.updateColorControl(item.CategoryButtonSecondaryColor, 'bSecondaryColor', $scope);
                menuCategoriesService.updateColorControl(item.CategoryButtonLabelFontColor, 'lfontColor', $scope);
                var lfs = (item.CategoryButtonLabelFontSize) ? item.CategoryButtonLabelFontSize : '12px';
                $('#lfontSize').val(lfs);
            }
        }
    });

    function reloadMenuSelectOnCategories() {
        $('#add_MenuUnique').jqxDropDownList({
            source: new $.jqx.dataAdapter({
                    datatype: "json",
                    datafields: [
                        { name: 'MenuName' },
                        { name: 'Status' },
                        { name: 'Unique' },
                        { name: 'CategoryButtonPrimaryColor' },
                        { name: 'CategoryButtonSecondaryColor' },
                        { name: 'CategoryButtonLabelFontColor' },
                        { name: 'CategoryButtonLabelFontSize' }
                    ],
                    url: SiteRoot + 'admin/MenuCategory/load_allmenus/1'
                })
        });
        // Categories grid!
        $('#categoriesDataTable').jqxGrid({
            source: menuCategoriesService.getCategoryGridSettings().source
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
        width: "60%", height: "75%",
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

    $('.styles-control').on('change', function(e) {
        $('#saveCategoryBtn').prop('disabled', false);
    });

    setTimeout(function() {
        $('#lfontSize').on('change', function(e) {
            $('#saveCategoryBtn').prop('disabled', false);
        });
    }, 1000);

    $scope.newCategoryAction = function() {
        $scope.newOrEditCategoryOption = 'new';
        $scope.categoryId = null;
        // CaTegory Picture
        $scope.categoryImages = [];
        $scope.uploader.flow.files = [];
        $('#add_CategoryStatus').jqxDropDownList({selectedIndex: 0});
        $('#add_MenuUnique').jqxDropDownList({selectedIndex: -1});
        resetCategoryWindows();
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
        // Primary Color
        menuCategoriesService.updateColorControl('#' + values['ButtonPrimaryColor'], 'bPrimaryColor', $scope, values['dcpc']);
        menuCategoriesService.updateColorControl('#' + values['ButtonSecondaryColor'], 'bSecondaryColor', $scope, values['dcsc']);
        menuCategoriesService.updateColorControl('#' + values['LabelFontColor'], 'lfontColor', $scope, values['dcfc']);
        var lfs = (values['LabelFontSize']) ? values['LabelFontSize'] : '12px';
        $('#lfontSize').val(lfs);
        // var tempColor;
        // if (values['ButtonPrimaryColor'])
        //     tempColor = values['ButtonPrimaryColor'];
        // else
        //     tempColor = $('#catButtonPrimaryColorDef').val();
        // $scope.ddb_bPrimaryColor.setContent(getTextElementByColor(new $.jqx.color({ hex: tempColor })));
        // if ($('#bPrimaryColor').jqxColorPicker('getColor') == undefined)
        //     $scope.bPrimaryColor = tempColor;
        // else
        //     $('#bPrimaryColor').jqxColorPicker('setColor', '#' + tempColor);
        // // Secondary Color
        // if (values['ButtonSecondaryColor'])
        //     tempColor = values['ButtonSecondaryColor'];
        // else
        //     tempColor = $('#catButtonSecondaryColorDef').val();
        // $scope.ddb_bSecondaryColor.setContent(getTextElementByColor(new $.jqx.color({ hex: tempColor })));
        // if ($('#bSecondaryColor').jqxColorPicker('getColor')  == undefined)
        //     $scope.bSecondaryColor = tempColor;
        // else
        //     $('#bSecondaryColor').jqxColorPicker('setColor', '#' + tempColor);
        // // Font Color
        // if (values['LabelFontColor'])
        //     tempColor = values['LabelFontColor'];
        // else
        //     tempColor = $('#catLabelFontColorDef').val();
        // $scope.ddb_lfontColor.setContent(getTextElementByColor(new $.jqx.color({ hex: tempColor })));
        // $('#lfontColor').jqxColorPicker('setColor', tempColor);
        // if ($('#lfontColor').jqxColorPicker('getColor')  == undefined)
        //     $scope.lfontColor = tempColor;
        // else
        //     $('#lfontColor').jqxColorPicker('setColor', '#' + tempColor);
        // //-- Font Size
        // var lfs = (values['LabelFontSize']) ? values['LabelFontSize'] : $('#catLabelFontSizeDef').val();
        // $('#lfontSize').val(lfs);
        //
        $scope.newOrEditCategoryOption = 'edit';
        $scope.categoryId = values['Unique'];
        // CaTegory Picture
        $scope.categoryImages = [];
        $scope.uploader.flow.files = [];
        if (values.PictureFile) {
            $scope.categoryImages.push({
                name: '',
                newName: values.PictureFile,
                path: $('#location_path').val() + '/' + values.PictureFile
            });
        }
        //
        // $('#deleteCategoryBtn').show();
        $('#sty_subtab').show();
        $('#saveCategoryBtn').prop('disabled', true);
        var btn = $('<button/>', {
            'id': 'deleteCategoryBtn'
        }).addClass('icon-trash user-del-btn').css('left', 0);
        var title = $('<div/>').html('Edit Menu Category: ' + values['Unique'] + ' | Category: <b>' +
            values['CategoryName'] + '</b>')
            .prepend(btn)
            .css('padding-left', '2em');
        categoryWindow.setTitle(title);
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
                $('#category_subtabs').jqxTabs('select', 0);
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
                        {name: 'Sort', type: 'number'},
                        {name: 'Row', type: 'number'},
                        {name: 'Column', type: 'number'},
                        {name: 'Status', type: 'number'},
                        {name: 'StatusName', type: 'string'},
                        {name: 'MenuUnique', type: 'number'},
                        {name: 'MenuName', type: 'string'},
                        {name: 'PictureFile', type: 'string'},
                        {name: 'ButtonPrimaryColor', type: 'string'},
                        {name: 'ButtonSecondaryColor', type: 'string'},
                        {name: 'LabelFontColor', type: 'string'},
                        {name: 'LabelFontSize', type: 'string'}
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
        var imgs = [];
        angular.forEach($scope.uploader.flow.files, function(el, key) {
            if ($scope.successUplodCategories.indexOf(el.newName) > -1) {
                imgs.push(el.newName);
            }
        });
        if (!validationCategoryItem()) {
            var bprimary;
            if ($('#bPrimaryColor').jqxColorPicker('getColor') != undefined)
                bprimary = $('#bPrimaryColor').jqxColorPicker('getColor').hex;
            else
                 bprimary = $scope.bPrimaryColor;
            //
            var bsecondary;
            if ($('#bSecondaryColor').jqxColorPicker('getColor') != undefined)
                bsecondary = $('#bSecondaryColor').jqxColorPicker('getColor').hex;
            else
                bsecondary = $scope.bSecondaryColor;
            //
            var lfont;
            if ($('#lfontColor').jqxColorPicker('getColor') != undefined)
                lfont = $('#lfontColor').jqxColorPicker('getColor').hex;
            else
                lfont = $scope.lfontColor;
            //
            var values = {
                'CategoryName': $('#add_CategoryName').val(),
                'Row': $('#add_CategoryRow').val(),
                'Column': $('#add_CategoryColumn').val(),
                'Sort': $('#add_Sort').val(),
                'Status': $('#add_CategoryStatus').jqxDropDownList('getSelectedItem').value,
                'MenuUnique': $('#add_MenuUnique').jqxDropDownList('getSelectedItem').value,
                'PictureFile': imgs.join(','),
                'ButtonPrimaryColor': "#" + (bprimary),
                'ButtonSecondaryColor': "#" + (bsecondary),
                'LabelFontColor': "#" + (lfont),
                'LabelFontSize': $('#lfontSize').val()
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
                        // $scope.ddb_bPrimaryColor.setContent(getTextElementByColor(new $.jqx.color({ hex: values['ButtonPrimaryColor'] })));
                        // $scope.ddb_bSecondaryColor.setContent(getTextElementByColor(new $.jqx.color({ hex: values['ButtonSecondaryColor'] })));
                        // $scope.ddb_lfontColor.setContent(getTextElementByColor(new $.jqx.color({ hex: values['LabelFontColor'] })));
                        // $('#sty_subtab').show();
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
        $scope.ddb_bPrimaryColor.setContent(getTextElementByColor(new $.jqx.color({ hex: $('#catButtonPrimaryColorDef').val() })));
        $scope.bPrimaryColor = $('#catButtonPrimaryColorDef').val();
        $('#bPrimaryColor').jqxColorPicker('setColor', '#' + $('#catButtonPrimaryColorDef').val());
        $scope.ddb_bSecondaryColor.setContent(getTextElementByColor(new $.jqx.color({ hex: $('#catButtonSecondaryColorDef').val() })));
        $scope.bSecondaryColor = $('#catButtonSecondaryColorDef').val();
        $('#bSecondaryColor').jqxColorPicker('setColor', '#' + $('#catButtonSecondaryColorDef').val());
        $scope.ddb_lfontColor.setContent(getTextElementByColor(new $.jqx.color({ hex: $('#catLabelFontColorDef').val() })));
        $scope.lfontColor = $('#catLabelFontColorDef').val();
        $('#lfontColor').jqxColorPicker('setColor', '#' + $('#catLabelFontColorDef').val());
        $('#lfontSize').val($('#catLabelFontSizeDef').val());
        //
        $('#category_subtabs').jqxTabs('select', 0);
        $('#saveCategoryBtn').prop('disabled', true);
        // $('#deleteCategoryBtn').hide();
    };

    $('body').on('click', '#deleteCategoryBtn', function() {
        $scope.beforeDeleteCategory();
    });

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
        }).then(function(response) {
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
        spinButtons: true,
        width: 165,
        height: 25,
        textAlign: 'left'
    };

    // Styles tab
    function getTextElementByColor(color) {
        // console.log(color.hex);
        if (color == 'transparent' || color.hex == "") {
            $('#lfontSize').val('12px');
            // return $("<div style='text-shadow: none; position: relative; padding-bottom: 2px; margin-top: 2px;'>transparent</div>");
            var el =  $("<div style='text-shadow: none; position: relative; padding-bottom: 2px; margin-top: 2px;'>#000000</div>");
            el.css({'color': 'white', 'background': '#000000'});
            el.addClass('jqx-rc-all');
            return el;
        }
        var element = $("<div style='text-shadow: none; position: relative; padding-bottom: 2px; margin-top: 2px;'>#" + color.hex + "</div>");
        var nThreshold = 105;
        var bgDelta = (color.r * 0.299) + (color.g * 0.587) + (color.b * 0.114);
        var foreColor = (255 - bgDelta < nThreshold) ? 'black' : 'white';
        element.css({'color': foreColor, 'background': "#" + color.hex});
        element.addClass('jqx-rc-all');
        return element;
    }

    $scope.createColorPicker = false;
    // Menu Colors
    $scope.ddb_menudCatbPrimaryColor = {};
    $scope.ddb_menudCatbSecondaryColor = {};
    $scope.ddb_menudCatlfontColor  = {};
    $scope.menudItembPrimaryColor = {};
    $scope.menudItembSecondaryColor = {};
    $scope.menudItemlfontColor = {};
    // Category Colors
    $scope.ddb_bPrimaryColor = {};
    $scope.ddb_bSecondaryColor = {};
    $scope.ddb_lfontColor  = {};
    $scope.opening = function (event) {
        $scope.createColorPicker = true;
    };

    $scope.colorChange = function (event) {
        var id = $(event.target).attr('id');
        var el = ($(event.target).data('layout'));
        $scope['ddb_' + id].setContent(getTextElementByColor(event.args.color));
        if (el == 'category') {
            $('#saveCategoryBtn').prop('disabled', false);
        } else if (el == 'menu') {
            $('#saveMenuBtn').prop('disabled', false);
        }
    };

    $scope.$on('jqxDropDownButtonCreated', function (event, arguments) {
        arguments.instance.setContent(getTextElementByColor(new $.jqx.color({ hex: "000000" })));
    });

    // Picture Tab
    // Move it on module to load easier on other sections (Same on menu_items_controller)
    $scope.categoryImages = [];
    $scope.uploader = {};
    $scope.successUplodCategories = [];
    var mimesAvailable = ['image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'];
    $scope.submitUpload = function (files, e, flow) {
        var type = files[0].file.type;
        if (mimesAvailable.indexOf(type) > -1) {
            $scope.uploader.flow.upload();
        } else {
            $('#menuitemNotificationsErrorSettings #notification-content')
                .html('Only PNG, JPG and GIF files types allowed.');
            $scope.menuitemNotificationsErrorSettings.apply('open');
            var last = $scope.uploader.flow.files.length - 1;
            $scope.uploader.flow.files.splice(last, 1);
        }
    };

    $scope.successUpload = function (e, response, flow) {
        var resp = JSON.parse(response);
        var last = $scope.uploader.flow.files.length - 1;
        if (!resp.success) {
            $scope.uploader.flow.files.splice(last, 1);
            $('#menuNotificationsErrorSettings #notification_container')
                .html(resp.errors);
            $scope.menuNotificationsErrorSettings.apply('open');
        } else {
            $scope.uploader.flow.files[last]['newName'] = resp.newName;
            $scope.successUplodCategories.push(resp.newName);
            $scope.categoryImages.splice(0, 1);
            $('#saveCategoryBtn').prop('disabled', false);
        }
    };

    $scope.errorUpload = function (file, msg, flow) {};

    $scope.fileAddedUpload = function (file, event, flow) {
        var type = file.file.type;
    };

    $scope.removingImageCategory = function(i, option) {
        if (option == 1)
            var list = $scope.uploader.flow.files;
        else
            var list = $scope.categoryImages;
        var foundPic =
            $scope.successUplodCategories.indexOf(list[i].newName);
        //
        $scope.successUplodCategories.splice(foundPic, 1);
        $scope.categoryImages.splice(0, 1);
        $scope.uploader.flow.files.splice(i, 1);
        if (option == 1) {
            if ($scope.successUplodCategories.length <= 0)
                $('#saveCategoryBtn').prop('disabled', true);
        } else if (option == 2) {
            $('#saveCategoryBtn').prop('disabled', false);
        }
    }
});