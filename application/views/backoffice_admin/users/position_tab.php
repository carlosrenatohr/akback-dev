<div class="row" >
    <div>
        <button	type="button" id="openUserPositionWindowBtn" ng-click="openUserpositionsWindows()" class="btn btn-warning"
                   style="display: none;margin: 10px;">
            Add Position
        </button>
        <jqx-data-table id="userPositionsTable"
                        style="display: none;margin: 10px;"
                        jqx-on-row-double-click="editPositionByUser(event)"
                        jqx-settings="userPositionsTableSettings">
        </jqx-data-table>
        <!-- -->
        <jqx-window jqx-on-close="" jqx-settings="userPositionsWindowSettings"
                    jqx-create="userPositionsWindowSettings" class="userJqxwindows">

            <div class="">
                Add Position for user: <b>{{ editing_username }}</b>
            </div>
            <div class="">
                <!-- Position fields -->
                <form name="positionForm">
                    <div style="float:left; padding:2px; width:350px;">
                        <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Position:</div>
                        <div style="float:left; width:180px;">
                            <jqx-combo-box id="positionByUserCombobox" class="new-form-control"
                                           jqx-settings="positionSelectSetting" disabled>
                            </jqx-combo-box>
                        </div>
                    </div>

                    <div style="float:left; padding:2px; width:350px;">
                        <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Pay Basis:</div>
                        <div style="float:left; width:180px;">
                            <select id="payBasisSelect" name="PayBasis" class="userPositionField new-form-control"
                            >
                                <option value="Hourly">Hourly</option>
                                <option value="Salary">Salary</option>
                            </select>
                        </div>
                    </div>

                    <div style="float:left; padding:2px; width:350px;">
                        <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Pay Rate:</div>
                        <div style="float:left; width:180px;">
                            <input type="number" class="form-control userPositionField"
                                   id="PayRateField" name="PayRate" placeholder="Pay Rate"
                                   step="0.01" min="1" ng-pattern="/^[0-9]+(\.[0-9]{1})?$/"
                                   ng-model="PayRate"
                            >
                        </div>
                    </div>
                </form>

                <input type="hidden" id="idPositionUserWin">

                <div id="buttonsGroupsPositions" class="row">
                    <div class="form-group">
                        <div class="col-sm-12" style="margin: 40px 0 0 10px;">
                            <button type="button" id="savePositionuserBtn" ng-click="submitUserpositionsWindows()" class="btn btn-primary" disabled>Save</button>
                            <button	type="button" id="" ng-click="closeUserpositionsWindows()" class="btn btn-warning cancelUserBtn">Close</button>
                            <button	type="button" id="deletePositionuserBtn" ng-click="deletePositionByUser()" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </div>

                <div id="sureToCancelPosition" style="display: none;">
                    <div class="form-group">
                        <div class="col-sm-12" style="margin: 40px 10px;">
                            Would you like to save your changes?<br>
                            <button type="button" ng-click="closeUserpositionsWindows(1)" class="btn btn-primary">Yes</button>
                            <button	type="button" ng-click="closeUserpositionsWindows(2)" class="btn btn-warning">No</button>
                            <button	type="button" ng-click="closeUserpositionsWindows(3)" class="btn btn-danger">Cancel</button>
                        </div>
                    </div>
                </div>

                <jqx-notification jqx-settings="notificationPositionSettings" id="notificationPositionSettings">
                    <div id="notification-content"></div>
                </jqx-notification>
            </div>

        </jqx-window>
    </div>

</div>