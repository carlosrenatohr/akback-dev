<div class="col-md-12 col-md-offset-0">
    <div class="row" style="padding:0!important;" ng-repeat="el in gettingRowsCustomerContact(1)">
        <div style="float:left;"
             ng-repeat="attr in customerContactsControls | orderBy: 'attr.Column' | ByTab:'1' | ByRow:el"
             class="col-md-6">
            <div style="float:left; padding:2px 0;margin: 5px 0 0;">
                <multiple-controls></multiple-controls>
            </div>
        </div>
        <!--                        <div style="float:left;" ng-repeat="attr in customerControls | ByTab:'1' | ByRow:el" class="customerForm col-md-4">-->
        <!--                            <div style="float:left; padding:2px 0;margin: 5px 0 0;">-->
        <!--                                <multiple-controls></multiple-controls>-->
        <!--                            </div>-->
        <!--                        </div>-->
    </div>

</div>