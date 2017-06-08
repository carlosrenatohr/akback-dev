<div id="styling_questions_section">

    <div style="float:left; padding:2px; width:450px;">
        <div style="float:left; padding:8px; text-align:right; width:200px; font-weight:bold;">Button Primary Color:</div>
        <div style="float:left; width:200px;">
            <div style="margin: 3px; float: left;" class="dropDownParent">
                <jqx-drop-down-button jqx-on-opening="qOpening(event)" jqx-width="150" jqx-instance="ddb_qbPrimaryColor"
                                      class="styles-control" jqx-height="22">
                    <jqx-color-picker jqx-create="qColorCreated" jqx-on-colorchange="qColorChange(event)"
                                      jqx-color-mode="'hue'" jqx-width="220" jqx-height="220" data-layout="question"
                                      jqx-color="qbPrimaryColor" id="qbPrimaryColor"></jqx-color-picker>
                </jqx-drop-down-button>
            </div>
        </div>
    </div>

    <div style="float:left; padding:2px; width:450px;">
        <div style="float:left; padding:8px; text-align:right; width:200px; font-weight:bold;">Button Secondary Color:</div>
        <div style="float:left; width:200px;">
            <div style="margin: 3px; float: left;">
                <jqx-drop-down-button jqx-on-opening="qOpening(event)" jqx-width="150" jqx-instance="ddb_qbSecondaryColor"
                                      class="styles-control" jqx-height="22">
                    <jqx-color-picker jqx-create="qColorCreated" jqx-on-colorchange="qColorChange(event)"
                                      jqx-color-mode="'hue'" jqx-width="220" jqx-height="220" data-layout="question"
                                      jqx-color="qbSecondaryColor" id="qbSecondaryColor"></jqx-color-picker>
                </jqx-drop-down-button>
            </div>
        </div>
    </div>

    <div style="float:left; padding:2px; width:450px;">
        <div style="float:left; padding:8px; text-align:right; width:200px; font-weight:bold;">Label Font Color</div>
        <div style="float:left; width:200px;">
            <div style="margin: 3px; float: left;">
                <jqx-drop-down-button jqx-on-opening="qOpening(event)" jqx-width="150" jqx-instance="ddb_qlfontColor"
                                      jqx-height="22" class="styles-control">
                    <jqx-color-picker jqx-create="qColorCreated" jqx-on-colorchange="qColorChange(event)"
                                      jqx-color-mode="'hue'" jqx-width="220" jqx-height="220" data-layout="question"
                                      jqx-color="qlfontColor" id="qlfontColor"></jqx-color-picker>
                </jqx-drop-down-button>
            </div>
        </div>
    </div>

    <div style="float:left; padding:2px; width:450px;">
        <div style="float:left; padding:8px; text-align:right; width:200px; font-weight:bold;">Label Font Size</div>
        <div style="float:left; width:195px;">
            <jqx-drop-down-list id="qlfontSize" class="styles-control">
                <?php for ($o = 4;$o<=30;$o++) { ?>
                    <option value="<?php echo $o; ?>px"><?php echo $o; ?>px</option>
                <?php } ?>
            </jqx-drop-down-list>
        </div>
    </div>
</div>
<style>
    #qlfontSize {
        width: 150px!important;
    }
</style>