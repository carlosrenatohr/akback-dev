app.service('menuCategoriesService', function ($http, adminService) {

    //TODO
    // Assign values assigned on menu to categories and menuitem section
    // - missing to receive these new default values on category and items
    function getTextElementByColor(color) {
        if (color == 'transparent' || color.hex == "") {
            // $('#lfontSize').val('12px');
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

    // Helper to set color in dropdownlist and jqxcolor selected
    this.updateColorControl = function(value, textScope, $scope) {
        var tempColor;
        if (value) {
            var withoutHash = value.split('#');
            tempColor = withoutHash[1];
        } else
            tempColor = '000000';
        $scope['ddb_' + textScope].setContent(getTextElementByColor(new $.jqx.color({ hex: tempColor })));
        if ($('#' + textScope).jqxColorPicker('getColor') == undefined)
            $scope[textScope] = tempColor;
        else
            $('#' + textScope).jqxColorPicker('setColor', '#' + tempColor);
    };

    // Helper to get color value in dropdownlist and jqxcolor selected
    this.getColorSelected = function(textScope) {
        var colorValue; // without hash
        var el = $('#' + textScope);
        if (el.jqxColorPicker('getColor') != undefined)
            colorValue = el.jqxColorPicker('getColor').hex;
        else
            colorValue = $scope.qibPrimaryColor;

        if (colorValue != '' && colorValue != null)
            return '#' + colorValue;
        else
            return null;
    };

    // Helper to reset color value to default in dropdownlist and jqxcolor selected
    this.resetDefaultColor = function(textScope, $scope, defaultValue) {
        var value = '000000';
        if (defaultValue != undefined) {
            value = defaultValue;
        }
        $scope['ddb_' + textScope].setContent(getTextElementByColor(new $.jqx.color({ hex: value })));
        $scope[textScope] = value;
        $('#' + textScope).jqxColorPicker('setColor', '#' + value);
    };

    var pager = adminService.loadPagerConfig();
    this.getMenuGridSettings = function (empty) {
        var url = '';
        if (empty == undefined)
            url = SiteRoot + 'admin/MenuCategory/load_allmenus';
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
                    {name: 'ItemButtonPrimaryColor', type: 'string'},
                    {name: 'ItemButtonSecondaryColor', type: 'string'},
                    {name: 'ItemButtonLabelFontColor', type: 'string'},
                    {name: 'ItemButtonLabelFontSize', type: 'string'},
                    {name: 'CategoryButtonPrimaryColor', type: 'string'},
                    {name: 'CategoryButtonSecondaryColor', type: 'string'},
                    {name: 'CategoryButtonLabelFontColor', type: 'string'},
                    {name: 'CategoryButtonLabelFontSize', type: 'string'},
                    {name: 'QuestionPrimaryColor', type: 'string'},
                    {name: 'QuestionSecondaryColor', type: 'string'},
                    {name: 'QuestionLabelFontColor', type: 'string'},
                    {name: 'QuestionLabelFontSize', type: 'string'},
                    {name: 'QuestionItemPrimaryColor', type: 'string'},
                    {name: 'QuestionItemSecondaryColor', type: 'string'},
                    {name: 'QuestionItemLabelFontColor', type: 'string'},
                    {name: 'QuestionItemLabelFontSize', type: 'string'}
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
                {text: 'Item Length', dataField: 'ItemLength', type: 'number'},
                //
                {dataField: 'ItemButtonPrimaryColor', hidden: true},
                {dataField: 'ItemButtonSecondaryColor', hidden: true},
                {dataField: 'ItemButtonLabelFontColor', hidden: true},
                {dataField: 'ItemButtonLabelFontSize', hidden: true},
                {dataField: 'CategoryButtonPrimaryColor', hidden: true},
                {dataField: 'CategoryButtonSecondaryColor', hidden: true},
                {dataField: 'CategoryButtonLabelFontColor', hidden: true},
                {dataField: 'CategoryButtonLabelFontSize', hidden: true},
                {dataField: 'QuestionPrimaryColor', hidden: true},
                {dataField: 'QuestionSecondaryColor', hidden: true},
                {dataField: 'QuestionLabelFontColor', hidden: true},
                {dataField: 'QuestionLabelFontSize', hidden: true},
                {dataField: 'QuestionItemPrimaryColor', hidden: true},
                {dataField: 'QuestionItemSecondaryColor', hidden: true},
                {dataField: 'QuestionItemLabelFontColor', hidden: true},
                {dataField: 'QuestionItemLabelFontSize', hidden: true}
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
    };

    this.getCategoryGridSettings = function (empty) {
        var url = '';
        if (empty == undefined)
            url = SiteRoot + 'admin/MenuCategory/load_allcategories';
        return {
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
                url: url
            }),
            columns: [
                {text: 'ID', dataField: 'Unique', type: 'int'},
                {text: 'Menu', dataField: 'MenuName', type: 'string', filtertype: 'list'},
                {text: 'Category Name', dataField: 'CategoryName', type: 'string'},
                {dataField: 'MenuUnique', type: 'string', hidden: true},
                {text: 'Row', dataField: 'Row', type: 'number'},
                {text: 'Column', dataField: 'Column', type: 'number'},
                {text: 'Sort', dataField: 'Sort', type: 'number'},
                {dataField: 'Status', type: 'number', hidden: true},
                {text: 'Status', dataField: 'StatusName', type: 'string'},
                {dataField: 'PictureFile', hidden: true},
                {dataField: 'ButtonPrimaryColor', hidden: true},
                {dataField: 'ButtonSecondaryColor', hidden: true},
                {dataField: 'LabelFontColor', hidden: true},
                {dataField: 'LabelFontSize', hidden: true}
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
            pageSize: pager.pageSize,
            pagesizeoptions: pager.pagesizeoptions,
            altRows: true,
            autoheight: true,
            autorowheight: true
        };
    };

});