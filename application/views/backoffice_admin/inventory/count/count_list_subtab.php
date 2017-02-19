<div class="row" style="margin: 0;">
    <div style="width:100%;float:left;">
        <div id="listGridContainer">
            <jqx-grid id="icountlistGrid" class="icountlistGrid" style="display: none;"
                      jqx-settings="icountlistGridSettings"
                      jqx-create="icountlistGridSettings"
                      jqx-on-rowdoubleclick="editIcountlist(e)"
            ></jqx-grid>
        </div>
    </div>

    <!-- WINDOW TO SET ZERO ALL NON-COUNTED ITEMS COUNT LIST    -->
    <jqx-window id="setzeroItemCountListWin"
                jqx-is-modal="true" jqx-width="450" jqx-height="200"
                jqx-auto-open="false" jqx-show-close-button="true"
                jqx-resizable="false"
    >
        <div class="header">Set Zero to not counted items</div>
        <div class="body">
            <div class="text-content" style="text-align: center;font-size: 15px;margin-bottom: 15px;">
                This will add Zero Quantity to all items that don't already have a Quantity in Count Column.
                Items that already have a quantity in Count Column will not be changed.
                Are you sure you want to do this?
            </div>
            <div class="button-content">
                <div style="float: right; margin-top: 15px;">
                    <jqx-button id="ok" jqx-width="65" ng-click="setZeroIcount(0)"
                                style="margin-right: 10px"
                    >OK
                    </jqx-button>
                    <jqx-button id="ok" jqx-width="65" ng-click="setZeroIcount(1)"
                                style="margin-right: 10px"
                    >CANCEL
                    </jqx-button>
                </div>
            </div>
        </div>
    </jqx-window>
    <!-- WINDOW TO SET ZERO ALL ITEMS COUNT LIST    -->
    <jqx-window id="setzeroAllItemCountListWin"
                jqx-is-modal="true" jqx-width="450" jqx-height="200"
                jqx-auto-open="false" jqx-show-close-button="true"
                jqx-resizable="false"
    >
        <div class="header">Set Zero ALL Items</div>
        <div class="body">
            <div class="text-content" style="text-align: center;font-size: 15px;margin-bottom: 15px;">
                <b>Warning:</b><br>
                Everything in the Count Column will be set to Zero.
                This means any quantities already in Count Column will be changed to 0 as well.
                Are you sure you want to do this ?
            </div>
            <div class="button-content">
                <div style="float: right; margin-top: 15px;">
                    <jqx-button id="ok" jqx-width="65" ng-click="setZeroAllIcount(0)"
                                style="margin-right: 10px"
                    >OK
                    </jqx-button>
                    <jqx-button id="ok" jqx-width="65" ng-click="setZeroAllIcount(1)"
                                style="margin-right: 10px"
                    >CANCEL
                    </jqx-button>
                </div>
            </div>
        </div>
    </jqx-window>
    <!-- WINDOW TO FINALIZE COUNT -->
    <jqx-window id="finishIcountWin"
                jqx-is-modal="true" jqx-width="450" jqx-height="200"
                jqx-auto-open="false" jqx-show-close-button="true"
                jqx-resizable="false"
    >
        <div class="header">Finish Count on Selected Items</div>
        <div class="body">
            <div class="text-content" style="text-align: center;font-size: 15px;margin-bottom: 15px;">
                <p>Your stock will be adjusted based on above counts. <br>
                    Press Finalize to continue or Cancel to continue editing.</p>
            </div>
            <div class="button-content">
                <div style="float: right; margin-top: 15px;">
                    <jqx-button id="ok" jqx-width="65" ng-click="finishIcount(0)"
                                style="margin-right: 10px"
                    >OK
                    </jqx-button>
                    <jqx-button id="ok" jqx-width="65" ng-click="finishIcount(1)"
                                style="margin-right: 10px"
                    >CANCEL
                    </jqx-button>
                </div>
            </div>
        </div>
    </jqx-window>
    <!-- WINDOW TO DELETE ITEM COUNT LIST    -->
    <jqx-window id="delItemCountListWin"
                jqx-is-modal="true" jqx-width="300" jqx-height="150"
                jqx-auto-open="false" jqx-show-close-button="true"
                jqx-resizable="false"
    >
        <div class="header">Delete Item Count List</div>
        <div class="body">
            <div class="text-content" style="text-align: center;font-size: 15px;margin-bottom: 15px;"
            >Delete selected items on grid?</div>
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