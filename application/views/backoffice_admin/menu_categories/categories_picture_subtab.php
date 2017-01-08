<div class="col-md-12 col-md-offset-0" flow-init flow-name="uploader.flow"
     flow-files-submitted="submitUpload($files, $event, $flow)"
     flow-file-added="fileAddedUpload($file, $event, $flow)"
     flow-file-success="successUpload($file, $message, $flow)"
     flow-file-error="errorUpload($file, $message, $flow)">
    <div class="row">
        <div class="container-fluid">
            <div class="row" style="padding: 10px;border: 1px black dotted;border-radius: 3px;margin: 5px;min-height: 200px;overflow-y: scroll;">
                <div class="col-md-6" ng-repeat="file in currentImages" data-idx="{{ $index }}">
                    <div class="img-item-container">
                        <img ng-src="{{file.path}}" class="img-item">
                    </div>
                    <div class="img-info-container">
                        <span class="text">{{file.name}}</span>
                        <button class="icon-delete-img right-btn" ng-click="removingImageSelected($index, 2)">
                        </button>
                    </div>
                </div>
                <div class="col-md-6" ng-repeat="file in $flow.files" data-idx="{{ $index }}">
                    <div class="img-item-container">
                        <img flow-img="$flow.files[$index]" class="img-item">
                    </div>
                    <div class="img-info-container">
                        <span class="text">{{file.name}}</span>
                        <button class="icon-delete-img right-btn" ng-click="removingImageSelected($index, 1)">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <span class="btn btn-success" id="categoryPictureBtn" flow-btn style="/*display: none;*/">Upload Picture</span>
    </div>
</div>