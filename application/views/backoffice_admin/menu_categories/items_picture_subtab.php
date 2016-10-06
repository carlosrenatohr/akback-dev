<div class="col-md-12 col-md-offset-0">
    <div class="row">
        <div style=" width:100%;float:left;margin: 15px 0;">

            <div style="float:left; padding:2px; width:650px; ">
                <div style=" float:left; padding:8px; text-align:right; width:220px; font-weight:bold;">Select a picture for item</div>
                <div style=" float:left; width:120px;">
                    <div id="" style="display: inline-block;margin: -8px 0 0 0;/*margin: -8px 0 0 -10px*/">
                        <div flow-init
                             flow-files-submitted="$flow.upload()"
                             flow-file-success="$file.msg = $message"
                            flow-prevent-drop
                            flow-drag-enter="style={border: '5px solid green'}"
                            flow-drag-leave="style={}">
                            <span class="btn btn-success" flow-btn><i class="icon icon-file"></i>Upload File</span>
<!--                            <span class="btn btn-success" flow-btn flow-directory ng-show="$flow.supportDirectory">-->
<!--                                <i class="icon icon-folder-open"></i>-->

                            <table class="table">
                                <tr ng-repeat="file in $flow.files">
                                    <td>{{$index+1}}</td>
                                    <td>{{file.name}}</td>
                                    <td>{{file.msg}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>