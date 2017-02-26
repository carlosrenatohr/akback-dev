<div class="col-md-12 inventory_tab" style="padding-top:10px;  padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <div style="width:45%; float:left;">
                    <input type="text" id="item_barcodeinput" class="form-control item_textcontrol"
                           placeholder="Enter Barcode" ng-model="barcodeData.mainValue"
                           ng-enter="saveItemBarcode()" style="width:70%;height:30px;float: left;"/>
                    <span style="width: 30px;display: inline-block;vertical-align: top;margin: 5px 0;">Sort:</span>
<!--                    <jqx-number-input id="item_barcodesort" class="item_textcontrol"-->
<!--                                      jqx-width="'50px'" jqx-height="'30px'"-->
<!--                                      jqx-spin-buttons="false" jqx-input-mode="simple"-->
<!--                                      jqx-symbol="''"-->
<!--                                      jqx-min="1" jqx-max="99999" jqx-value="1" jqx-digits="5"-->
<!--                                      jqx-decimal-digits="0" style="display: inline-block"-->
<!--                    ></jqx-number-input>-->
                    <jqx-drop-down-list jqx-width="'50px'" class="item_textcontrol"
                                        id="item_barcodesort">
                        <option value=""></option>
                        <?php for ($i=1;$i<=10;$i++) { ?>
                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                        <?php } ?>
                    </jqx-drop-down-list>
                    <span class="required-ast" style="top: 0;position: absolute;">*</span>
                </div>
                <div style="width:40%; float:left; margin-left:10px;">
                    <button ng-click="saveItemBarcode()" class="btn btn-primary">Add</button>
                    <button ng-click="saveItemBarcode(true)" class="btn btn-warning">Update</button>
                    <button ng-click="deleteItemBarcode()" class="btn btn-danger">Delete</button>
                </div>
            </div>
            <br>
            <div class="form-group">
                <div style="margin:10px 0; font-size:16px;" id="barcodeLabel">
                    <strong>Barcode</strong>
                </div>
                <div style="width:100%; border:2px solid #06F;">
<!--                    <jqx-list-box id="inventory_barcodesList"-->
<!--                        jqx-settings="barcodeListSettings"-->
<!--                        jqx-width="'99.7%'" jqx-height="250"-->
<!--                        jqx-on-select="onSelectBarcodeList($event)"-->
<!--                    ></jqx-list-box>-->

                    <jqx-grid id="inventory_barcodesList"
                        jqx-settings="barcodeListSettings"
                        jqx-width="'99.7%'" jqx-height="300"
                        jqx-on-rowclick="onSelectBarcodeList($event)"
                    ></jqx-grid>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #item_barcodesort {
        display: inline-block;
    }
</style>