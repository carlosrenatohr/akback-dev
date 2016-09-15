<div class="col-md-12 inventory_tab">
    <div class="row">
        <div class="form-group">
            <label for="inputType" class="col-sm-3 control-label">Item Number:</label>

            <div class="col-sm-4">
                <input type="text" class="form-control item_textcontrol req" id="item_Item" name="item_Item"
                       ng-change="onChangeItemNumber(event)" ng-model="inventoryData.item"
                       data-field="Item" placeholder="Item Number" autofocus>
            </div>
            <span class="required-ast">*</span>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label for="inputType" class="col-sm-3 control-label">Barcode:</label>

            <div class="col-sm-4">
                <input type="text" class="form-control item_textcontrol req" id="item_Part" name="item_Part"
                       data-field="Part" placeholder="Barcode" ng-model="inventoryData.part">
            </div>
            <span class="required-ast">*</span>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label for="inputType" class="col-sm-3 control-label">Description:</label>

            <div class="col-sm-4">
                <input type="text" class="form-control item_textcontrol" id="item_Description" name="item_Description"
                       data-field="Description" placeholder="Description">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label for="inputType" class="col-sm-3 control-label">Supplier:</label>

            <div class="col-sm-4">
                <jqx-combo-box id="item_supplier" jqx-width="'220px'" jqx-height="'30px'"
                               jqx-settings="supplierCbxSettings" jqx-on-select=""
                               data-field="Supplier" class="item_combobox"
                ></jqx-combo-box>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label for="inputType" class="col-sm-3 control-label">Supplier Part:</label>

            <div class="col-sm-4">
                <input type="text" class="form-control item_textcontrol" id="item_SupplierPart" name="supplierpart"
                       data-field="SupplierPart" placeholder="Supplier Part Number"
                       ng-model="inventoryData.supplierPart">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label for="inputType" class="col-sm-3 control-label">Brand:</label>

            <div class="col-sm-4">
                <jqx-combo-box id="item_brand" jqx-width="'220px'" jqx-height="'30px'"
                               jqx-settings="brandCbxSettings" jqx-on-select=""
                               data-field="Brand" class="item_combobox"
                ></jqx-combo-box>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label for="inputType" class="col-sm-3 control-label">Category:</label>

            <div class="col-sm-4">
                <jqx-combo-box id="item_category"  jqx-width="'220px'" jqx-height="'30px'" class="item_combobox req"
                               jqx-settings="categoryCbxSettings" jqx-on-select="onSelectCategoryCbx(event)"
                               data-field="Category"
                ></jqx-combo-box>
            </div>
            <span class="required-ast">*</span>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label for="inputType" class="col-sm-3 control-label">Sub Category:</label>

            <div class="col-sm-4">
                <jqx-combo-box id="item_subcategory" jqx-width="'220px'" jqx-height="'30px'" class="item_combobox"
                               jqx-settings="subcategoryCbxSettings" jqx-on-select=""
                               data-field="Subcategory"
                ></jqx-combo-box>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label for="inputType" class="col-sm-3 control-label">List Price:</label>

            <div class="col-sm-4">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <jqx-number-input id="item_ListPrice" class="item_textcontrol"
                                      jqx-width="'190px'" jqx-height="'30px'"
                                      jqx-spin-buttons="false" jqx-input-mode="simple"
                                      jqx-symbol="''"
                                      jqx-decimal-digits="<?= $decimalsPrice; ?>"
                                      data-field="ListPrice"
                                      ng-change="setStaticPrices()"
                                      ng-model="inventoryData.listPrice"
                    ></jqx-number-input>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <label for="inputType" class="col-sm-3 control-label">Sell Price:</label>

            <div class="col-sm-4">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <jqx-number-input id="item_Price1" class="item_textcontrol"
                                      jqx-width="'190px'" jqx-height="'30px'"
                                      jqx-spin-buttons="false" jqx-input-mode="simple"
                                      jqx-symbol="''"
                                      jqx-decimal-digits="<?= $decimalsPrice; ?>"
                                      data-field="price1"
                                      ng-change="setStaticPrices()"
                                      ng-model="inventoryData.price1"
                    ></jqx-number-input>
                </div>
            </div>
        </div>
    </div>
</div>