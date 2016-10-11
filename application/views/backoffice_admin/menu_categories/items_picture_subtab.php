<div class="col-md-12 col-md-offset-0">
    <div class="row">
        <div class="container-fluid">
            <div class="row" style="padding: 10px;border: 1px black dotted;border-radius: 3px;margin: 5px;min-height: 200px;overflow-y: scroll;">
                <div class="col-md-4" ng-repeat="file in currentImages" data-idx="{{ $index }}">
                    <div style="margin: 0 10%;max-height: 300px;">
                        <img ng-src="{{file.path}}" width="200" height="200">
                    </div>
                    <div style="width: 80%">
                        <span style="text-align: center;font-weight: 600;float:left">{{file.name}}</span>
                        <button class="icon-32-trash" style="float: right;" ng-click="removingImageSelected($index)">
                        </button>
                    </div>
                </div>
                <div class="col-md-4" ng-repeat="file in $flow.files" data-idx="{{ $index }}">
                    <div style="margin: 0 10%;max-height: 300px;">
                        <img flow-img="$flow.files[$index]" width="200" height="200">
                    </div>
                    <div style="width: 80%">
                        <span style="text-align: center;font-weight: 600;float:left">{{file.name}}</span>
                        <button class="icon-32-trash" style="float: right;" ng-click="removingImageSelected($index)">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .icon-32-trash {
        /*position: absolute;*/
        /*right:0;*/
        background: url("../../assets/img/icon-32-trash.png") 0 5px no-repeat;
        background-size: 80%;
        width:25px;
        height:25px;
        border:0;
        outline: 0;
    }
</style>