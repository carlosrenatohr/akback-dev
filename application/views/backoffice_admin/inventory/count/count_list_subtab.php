<div class="row" style="margin: 0;">
    <div style="width:100%;float:left;">
        <div id="listGridContainer">
            <jqx-grid id="icountlistGrid" style="display: none;"
                      jqx-settings="icountlistGridSettings"
                      jqx-create="icountlistGridSettings"
                      jqx-on-rowdoubleclick="editIcountlist(e)"
            ></jqx-grid>
        </div>
    </div>

    <jqx-window id="delItemCountListWin"
                jqx-is-modal="true" jqx-width="300" jqx-height="150"
                jqx-auto-open="false" jqx-show-close-button="true"
                jqx-resizable="false" jqx-theme="'summer'"
    >
        <div class="header">Notification</div>
        <div class="body">
            <div class="text-content" style="text-align: center;font-size: 15px;margin-bottom: 15px;"
            >Are you sure to delete selected items on grid?</div>
            <div class="button-content">
                <div style="float: right; margin-top: 15px;">
                    <jqx-button id="ok" jqx-width="65" ng-click="delItemCountList(0)"
                                style="margin-right: 10px"
                    >OK
                    </jqx-button>
                    <jqx-button id="ok" jqx-width="65" ng-click="delItemCountList(1)"
                                style="margin-right: 10px"
                    >CANCEL
                    </jqx-button>
                </div>
            </div>
        </div>
    </jqx-window>
</div>