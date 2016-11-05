<div class="row" >
    <div>
        <button	type="button" id="openUserPositionWindowBtn" ng-click="openUserpositionsWindows()" class="btn btn-warning"
                   style="display: none;margin: 10px;">
            Add Position
        </button>
        <jqx-grid id="userPositionsTable" style="display: none;"
                jqx-on-rowdoubleclick="editPositionByUser(event)"
                jqx-settings="userPositionsTableSettings">
        </jqx-grid>
        <!-- -->
        <jqx-window jqx-on-close="" jqx-settings="userPositionsWindowSettings"
                    jqx-create="userPositionsWindowSettings" class="userJqxwindows">

            <div class="">
                Add Position for user: <b>{{ editing_username }}</b>
            </div>
            <div class="">
                <!-- Position fields -->
                <form name="positionForm">
                    <div style="float:left; padding:2px; ">
                        <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Position:</div>
                        <div style="float:left; width:180px;">
                            <jqx-combo-box id="positionByUserCombobox" class="new-form-control"
                                           jqx-settings="positionSelectSetting" disabled>
                            </jqx-combo-box>
                        </div>
                    </div>

                    <div style="float:left; padding:2px; ">
                        <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Pay Basis:</div>
                        <div style="float:left; width:180px;">
                            <select id="payBasisSelect" name="PayBasis" class="userPositionField new-form-control" style="width: 180px;"
                            >
                                <option value="Hourly">Hourly</option>
                                <option value="Salary">Salary</option>
                            </select>
                        </div>
                    </div>

                    <div style="float:left; padding:2px;">
                        <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Pay Rate:</div>
                        <div style="float:left; width:180px;">
                            <input type="number" class="form-control userPositionField"
                                   id="PayRateField" name="PayRate" placeholder="Pay Rate"
                                   step="0.01" min="1" ng-pattern="/^[0-9]+(\.[0-9]{1})?$/"
                                   ng-model="PayRate"
                            >
                        </div>
                    </div>

                    <div style="float:left; padding:2px;">
                        <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Primary</div>
                        <div style="float:left; width:180px;">
                            <jqx-check-box id="primaryPosition" style="margin-top: 10px;"
                                jqx-checked="false" jqx-width="180"
                            ></jqx-check-box>
                        </div>
                    </div>
                </form>

                <input type="hidden" id="idPositionUserWin">
                <br>
                <div id="buttonsGroupsPositions">
                    <div style="margin: 20px 0;display: inline-block;">
                        <button type="button" id="savePositionuserBtn" ng-click="submitUserpositionsWindows()" class="btn btn-primary" disabled>Save</button>
                        <button	type="button" id="" ng-click="closeUserpositionsWindows()" class="btn btn-warning cancelUserBtn">Close</button>
                        <button	type="button" id="deletePositionuserBtn" ng-click="deletePositionByUser()" class="btn btn-danger">Delete</button>
                    </div>
                </div>

                <div id="sureToCancelPosition" style="display: none;">
                    <div class="" style="margin: 20px 0;display: inline-block;">
                        Would you like to save your changes?<br>
                        <button type="button" ng-click="closeUserpositionsWindows(1)" class="btn btn-primary">Yes</button>
                        <button	type="button" ng-click="closeUserpositionsWindows(2)" class="btn btn-warning">No</button>
                        <button	type="button" ng-click="closeUserpositionsWindows(3)" class="btn btn-danger">Cancel</button>
                    </div>
                </div>

                <jqx-notification jqx-settings="notificationPositionSettings" id="notificationPositionSettings">
                    <div id="notification-content"></div>
                </jqx-notification>
            </div>

        </jqx-window>
    </div>

</div>