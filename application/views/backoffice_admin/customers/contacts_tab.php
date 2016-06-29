<div class="col-md-12 col-md-offset-0">
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-info" ng-click="openContactWindow()" style="margin: 10px 0;">
                New Contact
            </button>
        </div>
        <div class="col-md-12">
            <jqx-grid jqx-settings="customerContactTableSettings"
                      id=""
                      jqx-create="customerContactTableSettings"
                      jqx-on-row-double-click=""
            ></jqx-grid>
        </div>
        <jqx-window jqx-settings="addCustomerContactWinSettings"
                    jqx-on-create="addCustomerContactWinSettings">
            <div>
                New Customer Contact
            </div>
            <div class="">
                <div style=" width:100%;float:left;">
                    <div style=" width:100%;float:left;" ng-repeat="attr in customerContactsControls">
                        <multiple-controls></multiple-controls>
                    </div>
                </div>
                <!-- MAIN BUTTONS   -->
                <div class="col-md-12 col-md-offset-0">
                    <div class="row">
                        <div id="">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="button" id="saveCustomerContactBtn"
                                            ng-click=""
                                            class="btn btn-primary">
                                        Save
                                    </button>
                                    <button type="button" id="closeCustomerContactBtn"
                                            ng-click="closeCustomerContact()"
                                            class="btn btn-warning">
                                        Close
                                    </button>
                                    <button type="button" id="deleteCustomerContactBtn"
                                            ng-click=""
                                            class="btn btn-danger" style="overflow:auto;display: none;">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </jqx-window>
    </div>
</div>