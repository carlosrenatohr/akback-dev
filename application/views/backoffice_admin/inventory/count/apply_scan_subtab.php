<div class="row" style="margin: 10px 0;">
    <div class="col-md-offstet-1 col-md-8">
        <label for="" class="col-md-1">Scan File</label>
        <div class="col-md-10">
            <jqx-combo-box id="scanFileCbx" jqx-settings="scanFileCbxSettings"
                           jqx-on-change="scanFileCbxChange($event)"
            ></jqx-combo-box>
        </div>
    </div>
    <div class="col-md-12">
        <jqx-grid id="icountscanGrid" class="" style="display: none;margin-top: 10px;"
                  jqx-settings="icountscanGridSettings"
                  jqx-create="icountscanGridSettings"
                  jqx-on-rowdoubleclick="editIcountscan(e)"
        ></jqx-grid>
    </div>
</div>
<!-- WINDOW TO "ADD TO COUNT" ITEM COUNT LIST    -->
<jqx-window id="addToCountWind"
            jqx-is-modal="true" jqx-width="450" jqx-height="200"
            jqx-auto-open="false" jqx-show-close-button="true"
            jqx-resizable="false"
>
    <div class="header">Add Scan To Count</div>
    <div class="body">
        <div class="text-content" style="text-align: justify;font-size: 15px;margin-bottom: 10px;">
            For any items listed here that match items in the Count List Tab, the Quantity will be Added To<br>
            Are you sure you want to do this ?
        </div>
        <div class="button-content">
            <div style="float: right; margin-top: 15px;">
                <jqx-button id="ok" jqx-width="65" ng-click="addScanToCount(0)"
                            style="margin-right: 10px"
                >YES
                </jqx-button>
                <jqx-button id="ok" jqx-width="65" ng-click="addScanToCount(1)"
                            style="margin-right: 10px"
                >NO
                </jqx-button>
            </div>
        </div>
    </div>
</jqx-window>

<jqx-window id="markFileCompleteWind"
            jqx-is-modal="true" jqx-width="450" jqx-height="200"
            jqx-auto-open="false" jqx-show-close-button="true"
            jqx-resizable="false"
>
    <div class="header">File Completed</div>
    <div class="body">
        <div class="text-content" style="text-align: justify;font-size: 15px;margin-bottom: 10px;">
            Would you like to mark this file as Completed so cannot import again?
        </div>
        <div class="button-content">
            <div style="float: right; margin-top: 15px;">
                <jqx-button id="ok" jqx-width="65" ng-click="completeScanFile(0)"
                            style="margin-right: 10px"
                >YES
                </jqx-button>
                <jqx-button id="ok" jqx-width="65" ng-click="completeScanFile(1)"
                            style="margin-right: 10px"
                >NO
                </jqx-button>
            </div>
        </div>
    </div>
</jqx-window>