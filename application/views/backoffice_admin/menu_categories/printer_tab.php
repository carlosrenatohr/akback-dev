<div class="">
    <div class="col-md-12">
        <button class="btn btn-info" ng-click="openPrinterWin()" style="margin: 10px 0;">
            New Printer
        </button>
    </div>
    <div class="col-md-12">
        <div id="printerTable"></div>
    </div>
    <jqx-window jqx-on-close="close()" jqx-settings="printerWindowSettings"
                jqx-create="printerWindowSettings" class="">
        <div>
            New Printer
        </div>
        <div>
            <div class="col-md-12 col-md-offset-0">
                <div class="row">
                    <div style="float:left; padding:2px; width:500px;">
                        <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Item:</div>
                        <div style="float:left; width:350px;">
                            <jqx-combo-box id="itemMainList"
                                           jqx-settings="itemMainList"
                                           jqx-width="'100%'"
                                            >
                            </jqx-combo-box>
                        </div>
                    </div>
                    <div style="float:left; padding:2px; width:500px;">
                        <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Printer:</div>
                        <div style="float:left; width:350px;">
                            <jqx-drop-down-list id="printerMainList"
                                                jqx-settings="printerMainList"
                                                jqx-width="'100%'"
                                                >
                            </jqx-drop-down-list>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main buttons before saving questions on current item -->
            <div class="col-md-12 col-md-offset-0">
                <div class="row">
                    <div id="mainButtonsPrinter">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="button" id="saveBtnPrinter" ng-click="savePrinterByItem()" class="btn btn-primary" disabled>
                                    Save
                                </button>
                                <button	type="button" id="" ng-click="closeBtnPrinter()" class="btn btn-warning">
                                    Close
                                </button>
                                <button	type="button" id="deleteBtnPrinter" ng-click="beforeDeleteIPrinter()" class="btn btn-danger" style="overflow:auto;">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Prompt before saving printers by item -->
            <div class="col-md-12 col-md-offset-0">
                <div class="row">
                    <div id="promptClosePrinter" class="" style="display: none">
                        <div class="form-group">
                            <div class="col-sm-12">
                                Do you want to save your changes?
                                <button type="button" ng-click="closeBtnPrinter(0)" class="btn btn-primary">Yes
                                </button>
                                <button type="button" ng-click="closeBtnPrinter(1)" class="btn btn-warning">No</button>
                                <button type="button" ng-click="closeBtnPrinter(2)" class="btn btn-info">Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Prompt to delete itemp printer -->
            <div class="col-md-12 col-md-offset-0">
                <div class="row">
                    <div id="promptDeletePrinter" style="display: none;">
                        <div class="form-group">
                            <div class="col-sm-12">
                                Are you sure you want to delete it?
                                <button type="button" ng-click="beforeDeleteIPrinter(0)" class="btn btn-primary">Yes</button>
                                <button type="button" ng-click="beforeDeleteIPrinter(1)" class="btn btn-warning">No</button>
                                <button type="button" ng-click="beforeDeleteIPrinter(2)" class="btn btn-info">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- NOTIFICATIONS AREA -->
            <div class="col-md-12 col-md-offset-0">
                <div class="row">
                    <jqx-notification jqx-settings="menuPrinterSuccess" id="menuPrinterSuccess">
                        <div id="notification-content"></div>
                    </jqx-notification>
                    <jqx-notification jqx-settings="menuPrinterError" id="menuPrinterError">
                        <div id="notification-content"></div>
                    </jqx-notification>
                    <div id="notification_container_menuprinter" style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
                </div>
            </div>
        </div>
    </jqx-window>

</div>