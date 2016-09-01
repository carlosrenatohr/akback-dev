<div class="col-md-12 tabs" id="tab6" style="padding-top:10px;  padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;"> <!--Tab6-->
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <div class="row">
                    <div id="itembarcode" style="width:40%; float:left;">
                        <input type="text" class="form-control" focus-me="barcodefocus" ng-enter="" placeholder="Enter Barcode" ng-model="barcode.wsearch" id="barcodesearch"/>
                    </div>
                    <div id="functions" style="width:40%; float:left; margin-left:10px;">
                        <button ng-click="" class="btn btn-primary">Add</button>
                        <button ng-click="" class="btn btn-warning">Update</button>
                        <button ng-click="" class="btn btn-danger">Delete Barcode</button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row" style="margin-top:10px;">
                        <div style="margin-bottom:5px; font-size:16px;"><strong>Barcode(s)</strong></div>
                        <div style="width:100%; border:2px solid #06F;">
                            <!--<div class="item-barcode {{selected}}" ng-repeat="barcodes in barcodelist" style="font-size:15px; font-weight: bolder;  border:1px solid #999;" ng-click="setSelected(barcodes.Unique, barcodes.Barcode)">{{barcodes.Barcode}}</div>-->
                        </div>
                    </div>
                </div>
                <input type="hidden" ng-model="BarcodeUnique" />
            </div>
        </div>
    </div>
</div>