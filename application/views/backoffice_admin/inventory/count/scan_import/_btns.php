<!-- Main buttons before saving item on grid -->
<div class="col-md-12 col-md-offset-0 mainIscanBtnsContainer" style="margin-bottom: 1em;">
    <div class="row">
        <div id="mainIscanBtns" class="">
            <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn btn-danger" ng-click="delScanList()"
                            disabled id="delScanListBtn">Delete item</button>
                    <button type="button" id="saveIscanBtn"
                            ng-click="saveScan()" class="btn btn-primary" disabled
                    >Import</button>
                    <button type="button" id="matchIscanBtn" ng-click="matchIscan()"
                            class="btn btn-success" style="overflow:auto;display: none;"
                    >Item Match</button>
                    <button type="button" ng-click="closeIscan()"
                            class="btn btn-warning"
                    >Close</button>
                </div>
            </div>
        </div>
    </div>
</div>