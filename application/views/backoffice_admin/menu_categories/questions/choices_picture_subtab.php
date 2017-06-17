<div class="col-md-12 col-md-offset-0">
    <div class="row">
        <div class="container-fluid">
            <div class="row" style="padding: 10px;border: 1px black dotted;border-radius: 3px;margin: 5px;min-height: 300px;/*overflow-y: scroll;*/">
                <div class="col-md-6" ng-repeat="file in currentImagesQI" data-idx="{{ $index }}">
                    <div class="img-item-container">
                        <img ng-src="{{file.path}}" class="img-item">
                    </div>
                    <div class="img-info-container">
                        <span class="text">{{file.name}}</span>
                        <button class="icon-delete-img right-btn" ng-click="removingImageSelectedQI($index, 2)">
                        </button>
                    </div>
                </div>
                <div class="col-md-6" ng-repeat="file in $flow.files" data-idx="{{ $index }}">
                    <div class="img-item-container">
                        <img flow-img="$flow.files[$index]" class="img-item">
                    </div>
                    <div class="img-info-container">
                        <span class="text">{{file.name}}</span>
                        <button class="icon-delete-img right-btn" ng-click="removingImageSelectedQI($index, 1)">
                        </button>
                    </div>
                </div>
            </div>
            <span class="btn btn-success"
                  id="uploadPictureBtnQI" flow-btn >
                    Upload
            </span>
        </div>
    </div>
</div>