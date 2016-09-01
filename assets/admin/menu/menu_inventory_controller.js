/**
 * Created by carlosrenato on 08-31-16.
 */
app.controller('menuItemsInventoryController', function($scope, $http, itemInventoryService){

    // Events added
    itemInventoryService.onChangeEvents();

    $('#MenuCategoriesTabs').on('tabclick', function (e) {
        var tabclicked = e.args.item;
        // Items Inventory TAB - Reload queries
        if (tabclicked == 1) {
            updateItemsInventoryGrid();
        }
    });

    $scope.inventoryItemsGrid = itemInventoryService.getInventoryGridData;
    var updateItemsInventoryGrid = function() {
        $(this).jqxGrid(itemInventoryService.getInventoryGridData.source);
    };


    var inventoryWind;
    $scope.itemsInventoryWindowSettings = {
        created: function (args) {
            inventoryWind = args.instance;
        },
        resizable: false,
        width: "50%", height: "100%",
        autoOpen: false,
        theme: 'darkblue',
        isModal: true,
        showCloseButton: false
    };

    $scope.closeInventoryWind = function(close) {
        $('#inventoryTabs').jqxTabs('select', 0);
        $('.inventory_tab .item_textcontrol').each(function(i, el) {
            $(el).val('');
        });
        if (close == undefined)
            inventoryWind.close();
    };

    $scope.openInventoryWind = function() {
        inventoryWind.open();

    };

    var beforeSaveInventory = function() {
        var needValidation = false;
        $('.inventory_tab .req').each(function(i, el) {
            if (el.value == '') {
                console.log($(el).attr('placeholder') + " is required");
                needValidation = true;
            }
        });
        return needValidation;
    };

    var gettingInventoryValues = function() {
        var data = {};
        $('.inventory_tab .item_textcontrol').each(function(i, el) {
            var field = $(el).data('field');
            if (field != undefined) {
                data[field] = $(el).val();
            } else {
                console.log('Not found', $(el).attr('id'));
            }
        });

        return data;
    };

    $scope.saveInventoryAction = function() {
        if (!beforeSaveInventory()) {
            console.log(gettingInventoryValues());
        }
    };
});
