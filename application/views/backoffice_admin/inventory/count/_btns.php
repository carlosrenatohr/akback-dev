<!-- Main buttons before saving -->
<!--<div class="col-md-12 col-md-offset-0">-->
<!--    <div class="row">-->
        <div id="mainIcountBtns" class="">
            <div class="form-group">
                <div class="col-sm-12" style="margin-bottom: 1.2em;">
                    <button type="button" ng-click="closeIcount()"
                            class="btn btn-warning"
                    >Close</button>
                    <button type="button" id="saveIcountBtn"
                            ng-click="saveIcount()" class="btn btn-primary" disabled
                    >Build Count List</button>
                    <button type="button" id="deleteIcounlistBtn" ng-click="delItemCountList()"
                            class="btn btn-danger" style="overflow:auto;display: none;"
                    >Delete Item</button>
                    <button type="button" id="finishIcountBtn" ng-click="finishIcount()"
                            class="btn btn-success" style="overflow:auto;display: none;"
                    >Finish Count</button>
                    <button type="button" id="setZeroIcountBtn" ng-click="setZeroIcount()"
                            class="btn btn-info" style="overflow:auto;display: none;"
                    >Zero Not Counted</button>
                </div>
            </div>
        </div>
<!--    </div>-->
<!--</div>-->