<div id="mainIcountBtns" class="">
    <div class="form-group">
        <div class="col-sm-12" style="margin-bottom: 1.2em;">
            <button type="button" ng-click="closeIcount()"
                    class="btn btn-warning"
            >Close</button>
            <button type="button" id="addToCountBtn" class="btn btn-info" disabled
                    ng-click="addScanToCount()" style="display: none;"
            >Add To Count</button>
            <button type="button" id="saveIcountBtn"
                    ng-click="saveIcount()" class="btn btn-primary" disabled
            >Build Count List</button>
            <button type="button" id="deleteIcounlistBtn" ng-click="delItemCountList()"
                    class="btn btn-danger" style="overflow:auto;display: none;"
            >Delete Item</button>
            <button type="button" id="setZeroIcountBtn" ng-click="setZeroIcount()"
                    class="btn btn-info" style="overflow:auto;display: none;"
            >Zero Not Counted</button>
            <button type="button" id="setZeroAllIcountBtn" ng-click="setZeroAllIcount()"
                    class="btn btn-info" style="overflow:auto;display: none;background: #022561;"
            >Zero All</button>
            <button type="button" id="finishIcountBtn" ng-click="finishIcount()"
                    class="btn btn-success" style="overflow:auto;display: none;"
            >Finish Count</button>
            <img id="loadingMenuCountList" src="<?php echo base_url()?>assets/img/loadinfo.gif" alt=""
                 style="position: absolute;width: 5%;right: 2%;top: 0;z-index: 10;display: none;">
        </div>
    </div>
</div>