<div class="col-md-12 col-md-offset-0">
    <div class="row">
        <div class="container-fluid">
            <div class="row" style="padding: 10px;border: 1px black dotted;border-radius: 3px;margin: 5px;min-height: 200px;overflow-y: scroll;">
                <div class="col-md-4" ng-repeat="file in currentImages" data-idx="{{ $index }}">
                    <div class="img-item-container">
                        <img ng-src="{{file.path}}" class="img-item">
                    </div>
                    <div class="img-info-container">
                        <span class="text">{{file.name}}</span>
                        <button class="icon-32-trash right-btn" ng-click="removingImageSelected($index)">
                        </button>
                    </div>
                </div>
                <div class="col-md-4" ng-repeat="file in $flow.files" data-idx="{{ $index }}">
                    <div class="img-item-container">
                        <img flow-img="$flow.files[$index]" class="img-item">
                    </div>
                    <div class="img-info-container">
                        <span class="text">{{file.name}}</span>
                        <button class="icon-32-trash right-btn" ng-click="removingImageSelected($index)">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .img-item-container {
        margin: 0 3%;
        width: 100%;
        max-width: 100%;
        min-height: 300px;
        overflow: hidden;
    }
    .img-item {
        width: 100%;
        max-width: 100%;
        height: auto;
        max-height: 250px;
    }
    .img-info-container {
        width: 80%;height: 30px;
    }
    .img-info-container {
        text-align: center;font-weight: 600;float:left;
    }
    .right-btn {
        float: right;margin-top: -10px;
    }
    .icon-32-trash {
        position: absolute;
        right:0;
        background: url("../../assets/img/icon-32-trash.png") 0 5px no-repeat;
        background-size: 80%;
        width:25px;
        height:25px;
        border:0;
        outline: 0;
    }
</style>