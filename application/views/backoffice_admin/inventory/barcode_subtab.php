<div class="col-md-12 inventory_tab" style="padding-top:10px;  padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <div style="width:40%; float:left;">
                    <input type="text" id="item_barcodeinput" class="form-control item_textcontrol"
                           placeholder="Enter Barcode" ng-model="barcodeData.mainValue"
                           ng-enter="saveItemBarcode()" style="width:80%;float: left;"/>
                    <jqx-number-input id="item_barcodesort" class="item_textcontrol"
                                      jqx-width="'50px'" jqx-height="'30px'"
                                      jqx-spin-buttons="false" jqx-input-mode="simple"
                                      jqx-symbol="''"
                                      jqx-min="1" jqx-max="5" jqx-value="1"
                                      jqx-decimal-digits="0"
                    ></jqx-number-input>
                </div>
                <div style="width:40%; float:left; margin-left:10px;">
                    <button ng-click="saveItemBarcode()" class="btn btn-primary">Add</button>
                    <button ng-click="saveItemBarcode(true)" class="btn btn-warning">Update</button>
                    <button ng-click="deleteItemBarcode()" class="btn btn-danger">Delete Barcode</button>
                </div>
            </div>
            <br>
            <div class="form-group">
                <div style="margin:10px 0; font-size:16px;" id="barcodeLabel">
                    <strong>Barcode</strong>
                </div>
                <div style="width:100%; border:2px solid #06F;">
                    <jqx-list-box id="inventory_barcodesList"
                        jqx-settings="barcodeListSettings"
                        jqx-width="'99.7%'" jqx-height="250"
                        jqx-on-select="onSelectBarcodeList($event)"
                    ></jqx-list-box>
                </div>
            </div>
        </div>
    </div>
</div>