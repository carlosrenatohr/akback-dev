<!-- Main buttons before saving item on grid -->
<div class="col-md-12 col-md-offset-0 mainIscanBtnsContainer"
     id="mainIscanBtns" style="margin-bottom: 0.5em;">
    <div class="row">
        <div class="form-group">
            <div class="col-sm-12">
                <button class="btn btn-danger" ng-click="delScanList()"
                        disabled id="delScanListBtn">Delete item</button>
                <button type="button" id="saveIscanBtn"
                        ng-click="saveScan()" class="btn btn-primary" disabled
                >Save</button>
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

<!-- Prompt before saving item on grid -->
<div class="col-md-12 col-md-offset-0" style="margin-bottom: 0.5em;display: none"
     id="closeIscanBtns">
    <div class="row">
        <div class="form-group">
            <div class="col-sm-12">
                <div class="message">Do you want to save your changes?</div>
                <button type="button" ng-click="closeIscan(0)" class="btn btn-primary">Yes</button>
                <button type="button" ng-click="closeIscan(1)" class="btn btn-warning">No</button>
                <button type="button" ng-click="closeIscan(2)" class="btn btn-info">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Prompt before delete an item on grid -->
<div class="col-md-12 col-md-offset-0"
     id="deleteIscanBtns" style="display: none;margin-bottom: 0.5em;">
    <div class="row">
        <div class="form-group">
            <div class="col-sm-12">
                Do you really want to delete it?
                <button type="button" ng-click="deleteIscan(0)" class="btn btn-primary">Yes</button>
                <button type="button" ng-click="deleteIscan(1)" class="btn btn-warning">No</button>
                <button type="button" ng-click="deleteIscan(2)" class="btn btn-info">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- Prompt before finish count on item count list -->
<div class="col-md-12 col-md-offset-0" style="margin-bottom: 0.5em;display: none;"
     id="matchIscanBtnContainer">
    <div class="row">
        <div class="form-group">
            <div class="col-sm-12">
                <p>This operation will find matching items based on barcode in import file. <br>
                After update, you will see any matching items in the Item Column.</p>
                <button type="button" ng-click="matchIscan(0)" class="btn btn-primary">Match</button>
                <button type="button" ng-click="matchIscan(1)" class="btn btn-info">Cancel</button>
            </div>
        </div>
    </div>
</div>