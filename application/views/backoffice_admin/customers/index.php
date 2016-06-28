<?php
//angularplugins();
//angulartheme_arctic();
//angulartheme_metrodark();
//angulartheme_darkblue();
//jqxplugindatetime();
customerangular();
jqxangularjs();
jqxthemes();
?>
<?php $this->load->view('backoffice_admin/customers/custom_controls'); ?>
<!-- Assets -->
<link rel="stylesheet" href="../../assets/admin/styles.css">
<script>
    // --Global Variable
    var SiteRoot = "<?php echo base_url()?>";
    $("#tabtitle").html("Customer administrator");
</script>
<script type="application/javascript" src="../../assets/admin/customer/customer_controller.js"></script>
<!--<script type="application/javascript" src="../../assets/admin/customer/customer_directive.js"></script>-->
<script type="application/javascript" src="../../assets/js/angular/jqwidgets/jqxradiobutton.js"></script>
<script type="application/javascript" src="../../assets/js/angular/jqwidgets/jqxnumberinput.js"></script>
<script type="application/javascript" src="../../assets/js/angular/jqwidgets/jqxdatetimeinput.js"></script>
<script type="application/javascript" src="../../assets/js/angular/jqwidgets/jqxcalendar.js"></script>
<script type="application/javascript" src="../../assets/js/angular/jqwidgets/jqxscrollbar.js"></script>
<script type="application/javascript" src="../../assets/js/angular/jqwidgets/jqxlistbox.js"></script>
<!-- -->

<div ng-controller="customerController" ng-cloak>
    <div class="container-fluid">
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <nav class="navbar navbar-default" role="navigation" style="background:#CCC;">
                    <div class="col-md-12">
                        <div id="toolbar" class="toolbar-list">
                            <ul class="nav navbar-nav navbar-left">
                                <li>
                                    <a href="<?php echo base_url("backoffice/dashboard") ?>" style="outline:0;">
                                        <span class="icon-32-home"></span>
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url("dashboard/admin") ?>" style="outline:0;">
                                        <span class="icon-32-back"></span>
                                        Back
                                    </a>
                                </li>
                                <li>
                                    <a style="outline:0;" ng-click="openAddCustomerWind()">
                                        <span class="icon-32-new"></span>
                                        New
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="row">
<!--                <jqx-data-table jqx-settings="customerTableSettings"-->
<!--                                jqx-create="customerTableSettings"-->
<!--                                jqx-on-row-double-click="openEditCustomerWind(event)">-->
<!--                </jqx-data-table>-->
                <jqx-grid jqx-settings="customerTableSettings"
                            id="gridCustomer"
                          jqx-create="customerTableSettings"
                          jqx-on-row-double-click="openEditCustomerWind($event)"
                ></jqx-grid>
                <jqx-window jqx-settings="addCustomerWindSettings" jqx-on-create="addCustomerWindSettings">
                    <div class="">
                        Add New Customer
                    </div>
                    <div class="">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="row itemQuestionFormContainer">
                                <div style=" width:100%;float:left;" ng-repeat="attr in customerControls">
                                    <div style="float:left; padding:2px; width:650px;margin: 5px 0 0;">
                                        <div style="float:left; padding:8px; text-align:right; width:200px; font-weight:bold;">
                                            {{ attr.Label }}
                                        </div>
                                        <!-- DATALIST -->
                                        <div ng-if="attr.Control == 'datalist'" class="customer-field"
                                             data-control-type="{{ attr.Control }}"
                                             data-field="{{ attr.Field }}"
                                             style=" float:left;"
                                        >
                                            <jqx-list-box data-control-type="{{ attr.Control }}"
                                                jqx-on-select="changeDatalist(event)"
                                                class="customer-datalist"
                                                id="customer_{{ attr.Label}}"
                                                >
                                                <option ng-repeat="option in attr.options"
                                                        value="{{ option.Label }}">{{ option.Label }}</option>
                                            </jqx-list-box>
                                        </div>
                                        <!-- TEXT -->
                                        <div ng-if="attr.Control == 'text'" class="customer-field"
                                             data-control-type="{{ attr.Control }}"
                                             data-field="{{ attr.Field }}"
                                             style="float:left;width: 200px;"
                                        >
                                            <input type=\"text\" class="form-control customer-textcontrol"
                                                   ng-class="{req : attr.Required}"
                                                   id="customer_{{attr.Field}}" name="customer_{{attr.Field}}"
                                                   placeholder="{{attr.Label}}"/>
                                        </div>
                                        <!-- INTEGER -->
                                        <div ng-if="attr.Control == 'number'" class="customer-field"
                                             data-control-type="{{ attr.Control }}"
                                             data-field="{{ attr.Field }}"
                                             style="float:left;"
                                        >
                                            <jqx-number-input
                                                style='margin-top: 3px;'
                                                ng-class="{req : attr.Required}" class="customer-number"
                                                jqx-settings="numberIntSettings"
                                            ></jqx-number-input>
                                        </div>
                                        <!-- DECIMAL -->
                                        <div ng-if="attr.Control == 'number2Decimal'" class="customer-field"
                                             data-control-type="{{ attr.Control }}"
                                             data-field="{{ attr.Field }}"
                                             style=" float:left;"
                                        >
                                            <jqx-number-input
                                                ng-class="{req : attr.Required}" style='margin-top: 3px;'
                                                class="customer-number"
                                                jqx-settings="numberDecimalSettings"
                                            ></jqx-number-input>
                                        </div>
                                        <!-- DATE -->
                                        <div ng-if="attr.Control == 'date'" class="customer-field"
                                             data-control-type="{{ attr.Control }}"
                                             data-field="{{ attr.Field }}"
                                             style="float:left;"
                                        >
                                            <jqx-date-time-input class="customer-date" jqx-settings="dateSettings"
                                                                 ng-class="{req : attr.Required}"
                                            ></jqx-date-time-input>
                                        </div>
                                        <!-- RADIO  -->
                                        <div ng-if="attr.Control == 'radio'" class="customer-field"
                                             data-control-type="{{ attr.Control }}"
                                             data-field="{{ attr.Field }}"
                                             style="display: inline-block;"
                                        >
                                            <jqx-radio-button ng-repeat="option in attr.options"
                                                              jqx-checked="{{$index == 0 && 'true' || 'false' }}"
                                                              jqx-height="25"
                                                              jqx-width="50"
                                                              jqx-on-change="changeRadio(event)" jqx-width="250"
                                                              jqx-group-name="{{ attr.Field }}"
                                                              jqx-data="{{ option.Label }}"
                                                              jqx-theme="artic"
                                                              data-val="{{ option.Label }}"
                                                              class="customer-radio"
                                                              style='margin-top: 10px;margin-left: 10px;display: inherit;'>
                                                    <span>{{option.Label }}</span>
                                            </jqx-radio-button>
                                        </div>
                                        <!-- REQUIRED ASTERISK -->
                                        <div style="float:left;" ng-if="attr.Required > 0">
                                            <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-md-offset-0">
                            <div class="row">
                                <div id="">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button type="button" id="saveCustomerBtn"
                                                    ng-click="saveCustomerAction()"
                                                    class="btn btn-primary" disabled>
                                                Save
                                            </button>
                                            <button type="button" id="closeCustomerBtn"
                                                    ng-click="closeCustomerAction()"
                                                    class="btn btn-warning">
                                                Close
                                            </button>
                                            <button type="button" id="deleteCustomerBtn"
                                                    ng-click="deleteCustomerAction()"
                                                    class="btn btn-danger" style="overflow:auto;">
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
    </div>
</div>

<style>
    .customer-datalist {
        height:100px!important;
        width:200px!important;
    }
</style>