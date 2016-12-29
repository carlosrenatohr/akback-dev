<div class="row" style="margin: 0;">
    <div style="width:600px;float:left;">
        <div style="float:left; padding:2px; width:500px;">
            <div style="float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">Location:</div>
            <div style="float:left; width:210px;">
                <jqx-drop-down-list id="icount_location" class="icountField" jqx-width="210"
                    >
                    <?php foreach ($locations as $loc) { ?>
                        <option value="<?php echo $loc['Unique']?>"
                            <?php ($station == $loc['Unique']) ? 'selected ' : '' ?>
                         ><?php echo $loc['LocationName']?></option>
                    <?php } ?>
                </jqx-drop-down-list>
            </div>
            <div style="float:left;">
                <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
            </div>
        </div>

        <div style="float:left; padding:2px; width:500px;">
            <div style="float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">Comment:</div>
            <div style="float:left; width:320px;">
                <input type="text" class="form-control icountField" id="icount_comment" placeholder="Comment">
            </div>
        </div>

        <div style="float:left; padding:2px; width:500px;">
            <div style="float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">Browse:</div>
            <div style="float:left; width:320px;">
                <div class="icountField" id="icount_file" data-filename=""></div>
            </div>
        </div>
        <div style="float:left; padding:2px; width:500px;display: none;word-break: break-word" id="fileLoadedTemp">
        </div>

        <input type="hidden" id="loc_id" value="<?php echo $station; ?>">


    </div>
</div>