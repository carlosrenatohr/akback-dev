<div class="col-md-12 inventory_tab">
    <div class="row">
        <div class="form-group control-cont">
            <label for="inputType" class="control-label">Description:</label>

            <div class="input">
                <input type="text" class="form-control item_textcontrol req" id="item_Description" name="item_Description"
                       data-field="Description" placeholder="Description">
                <span class="required-ast">*</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group control-cont">
            <label for="inputType" class="control-label">Category:</label>

            <div class="input">
                <jqx-combo-box id="item_category" jqx-width="'250px'" jqx-height="'30px'" class="item_combobox req"
                               jqx-settings="categoryCbxSettings" jqx-on-change="onSelectCategoryCbx($event)"
                               data-field="Category" style="float: left;"
                ></jqx-combo-box>
                <span class="required-ast">*</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group control-cont">
            <label for="inputType" class="control-label">SubCategory:</label>
            <div class="input">
                <jqx-combo-box id="item_subcategory" jqx-width="'250px'" jqx-height="'30px'" class="item_combobox"
                               jqx-settings="subcategoryCbxSettings" data-field="Subcategory"
                ></jqx-combo-box>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group control-cont">
            <label for="inputType" class="control-label">Item Number:</label>
            <div class="input" style="width: 380px;">
                <input type="text" class="form-control item_textcontrol" id="item_Item" name="item_Item"
                       ng-change="onChangeItemNumber(event)" ng-model="inventoryData.item"
                       data-field="Item" placeholder="Item Number" autofocus
                       style="float: left;width: 250px;">
<!--                <span class="required-ast">*</span>-->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group control-cont">
            <label for="inputType" class="control-label">Barcode:</label>
            <div class="input">
                <input type="text" class="form-control item_textcontrol" id="item_Part" name="item_Part"
                       data-field="Part" placeholder="Barcode" ng-model="inventoryData.part"
                >
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group control-cont">
            <label for="inputType" class="control-label">Main Printer:</label>
            <div class="input">
                <jqx-drop-down-list id="mainPrinterNewItem" class=""
                                    jqx-settings="printerItemList"
                                    jqx-width="240">
                </jqx-drop-down-list>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group control-cont">
            <label for="inputType" class="control-label">List Price:</label>

            <div class="input">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <jqx-number-input id="item_ListPrice" class="item_textcontrol"
                                      jqx-width="220" jqx-height="'30px'"
                                      jqx-spin-buttons="false" jqx-input-mode="simple"
                                      jqx-symbol="''"
                                      jqx-decimal-digits="<?= $decimalsPrice; ?>"
                                      data-field="ListPrice"
                                      ng-model="inventoryData.listPrice"
                    ></jqx-number-input>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group control-cont">
            <label for="inputType" class="control-label">Sell Price:</label>

            <div class="input">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <jqx-number-input id="item_Price1" class="item_textcontrol"
                                      jqx-width="220" jqx-height="'30px'"
                                      jqx-spin-buttons="false" jqx-input-mode="simple"
                                      jqx-symbol="''"
                                      jqx-decimal-digits="<?= $decimalsPrice; ?>"
                                      data-field="price1"
                                      ng-model="inventoryData.price1"
                    ></jqx-number-input>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group control-cont">
            <label for="inputType" class="control-label">Cost:</label>

            <div class="input">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <jqx-number-input id="item_Cost" class="item_textcontrol"
                                      jqx-width="220" jqx-height="30"
                                      jqx-spin-buttons="false" jqx-input-mode="simple"
                                      jqx-symbol="''"
                                      jqx-decimal-digits="<?= $decimalsPrice; ?>"
                                      ng-change="onChangeCostFields()"
                                      ng-model="inventoryData.cost"
                                      data-field="Cost"
                    ></jqx-number-input>
                </div>
            </div>
        </div>
    </div>
</div>