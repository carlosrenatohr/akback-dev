<div class="col-md-12 col-md-offset-0">
    <div class="row">
        <div class="container-fluid" flow-init flow-name="uploader.flow"
             flow-files-submitted="submitUpload()"
             flow-file-success="successUpload($message)">
            <div class="row" style="margin: 10px 0;">
                <div style=" float:left; padding:8px; text-align:right; width:220px; font-weight:bold;">Select a picture for item</div>
                <span class="btn btn-success" flow-btn><i class="icon icon-file"></i>Upload File</span>
            </div>
            <div class="row" style="padding: 10px;border: 1px black dotted;border-radius: 3px;margin: 5px;">
                <div class="col-md-4" ng-repeat="file in $flow.files" data-idx="{{ $index }}">
                    <p style="text-align: center;font-weight: 600;  ">{{file.name}}</p>
                    <div style="margin: 0 10%;min-height: 110px;">
                        <img flow-img="$flow.files[$index]" width="100" height="100">
                    </div>
                    <button class="btn btn-danger" ng-click="removingImageSelected($index)"
                        style="margin: 5px 15%;">Remove</button>
                </div>
            </div>
        </div>
    </div>
</div>