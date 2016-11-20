
<button id="buildCountListBtn" class="btn btn-success pull-right" style="margin-right: 3em;"
        data-loc="" data-list=""
        ng-click="buildCountList()">Build List</button>

<div class="row" style="margin: 0;">
    <div style="width:600px;float:left;">

        <div style="float:left; padding:2px; width:450px;">
            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Location:</div>
            <div style="float:left; width:320px;">
                <jqx-drop-down-list id="icount_location">
                    <?php foreach ($locations as $loc) { ?>
                        <option value="<?php echo $loc['Unique']?>"><?php echo $loc['LocationName']?></option>
                    <?php } ?>
                </jqx-drop-down-list>
            </div>
            <div style="float:left;">
                <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
            </div>
        </div>
        <div style="float:left; padding:2px; width:450px;">
            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Comment:</div>
            <div style="float:left; width:320px;">
                <input type="text" class="form-control" id="icount_comment" placeholder="Comment">
            </div>
        </div>


    </div>
</div>