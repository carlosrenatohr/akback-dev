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
                                        Home
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
                <jqx-data-table jqx-settings="customerTableSettings"
                                jqx-create="customerTableSettings"
                                jqx-on-row-double-click="">
                </jqx-data-table>
                <jqx-window jqx-settings="addCustomerWindSettings" jqx-on-create="addCustomerWindSettings">
                    <div class="">
                        Add New Customer
                    </div>
                    <div class="">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="row itemQuestionFormContainer">
                                <div style=" width:100%;float:left;" ng-repeat="attr in customerControls">
                                    <div style=" float:left; padding:2px; width:650px;">
                                        <div style="float:left; padding:8px; text-align:right; width:180px; font-weight:bold;">
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
                                                id="customer_{{ attr.Label}}">
                                                <option ng-repeat="option in attr.options"
                                                        value="{{ option.Label }}">{{ option.Label }}</option>
                                            </jqx-list-box>
                                        </div>
                                        <!-- TEXT -->
                                        <div ng-if="attr.Control == 'text'" class="customer-field"
                                             data-control-type="{{ attr.Control }}"
                                             data-field="{{ attr.Field }}"
                                             style=" float:left;"
                                        >
                                            <input type=\"text\" class="form-control"
                                                   ng-class="{req : attr.Required}"
                                                   id="customer_{{attr.Field}}" name="customer_{{attr.Field}}"
                                                   placeholder="{{attr.Label}}"/>
                                        </div>
                                        <!-- INTEGER -->
                                        <div ng-if="attr.Control == 'number'" class="customer-field"
                                             data-control-type="{{ attr.Control }}"
                                             data-field="{{ attr.Field }}"
                                             style=" float:left;"
                                        >
                                            <jqx-number-input
                                                jqx-width="100" jqx-height="25" style='margin-top: 3px;' jqx-min="1"
                                                jqx-digits="3" jqx-decimal-digits="0" jqx-value="1" class="customer-number"
                                            ></jqx-number-input>
                                        </div>
                                        <!-- DECIMAL -->
                                        <div ng-if="attr.Control == 'number2Decimal'" class="customer-field"
                                             data-control-type="{{ attr.Control }}"
                                             data-field="{{ attr.Field }}"
                                             style=" float:left;"
                                        >
                                            <jqx-number-input
                                                jqx-width="100" jqx-height="25" jqx-spin-buttons="true" style='margin-top: 3px;'
                                                jqx-min="0" jqx-digits="3" jqx-decimal-digits="2" class="customer-number"
                                            ></jqx-number-input>
                                        </div>
                                        <!-- DATE -->
                                        <div ng-if="attr.Control == 'date'" class="customer-field"
                                             data-control-type="{{ attr.Control }}"
                                             data-field="{{ attr.Field }}"
                                             style="float:left;"
                                        >
                                            <jqx-date-time-input jqx-settings="dateSettings"></jqx-date-time-input>
                                        </div>
                                        <!-- RADIO  -->
                                        <div ng-if="attr.Control == 'radio'" class="customer-field"
                                             data-control-type="{{ attr.Control }}"
                                             data-field="{{ attr.Field }}"
                                             style=" float:left;"
                                        >
                                            <jqx-radio-button ng-repeat="option in attr.options"
                                                              jqx-checked="{{$index == 0 && 'true' || 'false' }}" jqx-height="25"
                                                              jqx-on-change="changeRadio(event)" jqx-width="250"
                                                              jqx-theme="artic"
                                                              jqx-group-name="{{ attr.Field }}"
                                                              style='margin-top: 10px;display: inherit;'>
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
                                            <button type="button" id=""
                                                    ng-click="saveCustomerBtn()"
                                                    class="btn btn-primary" >
                                                Save
                                            </button>
                                            <button type="button" id=""
                                                    ng-click=""
                                                    class="btn btn-warning">
                                                Close
                                            </button>
                                            <button type="button" id=""
                                                    ng-click=""
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