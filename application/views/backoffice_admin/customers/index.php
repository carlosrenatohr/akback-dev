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
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/jqwidgets/styles/jqx.summer.css" type="text/css" />
<script>
    // --Global Variable
    var SiteRoot = "<?php echo base_url()?>";
    $("#tabtitle").html("Customer administrator");
</script>
<script type="application/javascript" src="../../assets/admin/customer/customer_controller.js"></script>
<script type="application/javascript" src="../../assets/admin/customer/customer_service.js"></script>
<script type="application/javascript" src="../../assets/admin/customer/customer_filter.js"></script>
<script type="application/javascript" src="../../assets/admin/customer/customer_directive.js"></script>
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
                <jqx-grid jqx-settings="customerTableSettings"
                          id="gridCustomer"
                          jqx-create="customerTableSettings"
                          jqx-on-row-double-click="openEditCustomerWind($event)"
                ></jqx-grid>
                <jqx-window jqx-settings="addCustomerWindSettings" jqx-on-create="addCustomerWindSettings"
                    id="addCustomerWindow">
                    <div class="">
                        Add New Customer
                    </div>
                    <div class="">
                        <jqx-tabs jqx-width="'100%'"
                                  jqx-on-tabclick="changingCustomerTab($event)"
                                  id="customerTabs">
                            <ul>
                                <li id="customertabInfo" class="mainTabInfo">Info</li>
                                <li id="customertabCustom" class="mainTabInfo">Custom</li>
                                <li id="customertabContact" class="SecTabInfo">Contacts</li>
                                <li id="customertabNote" class="SecTabInfo">Notes</li>
                                <li id="customertabPurchase" class="SecTabInfo">Purchases</li>
                            </ul>
                            <!-- Customer info subtab -->
                            <div class="">
                                <div class="col-md-12 col-md-offset-0">

                                    <div class="row" style="padding: 15px 0;" ng-repeat="el in gettingRows(1)">
                                        <div style="float:left;" ng-repeat="attr in customerControls | ByTab:'1' | ByRow:el" class="customerForm col-md-4">
                                            <div style="float:left; padding:2px 0;margin: 5px 0 0;">
                                                <multiple-controls></multiple-controls>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Customer Custom subtab -->
                            <div>
                                <div class="col-md-12 col-md-offset-0">
                                    <div class="row" style="padding: 15px 0;" ng-repeat="el in gettingRows(2)">
                                        <div style="float:left;" ng-repeat="attr in customerControls | ByTab:'2' | ByRow:el" class="customerForm col-md-6">
                                            <div style="float:left; padding:2px 0;margin: 5px 0 0;">
                                                <multiple-controls></multiple-controls>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Customer Contacts subtab -->
                            <div>
                                <?php $this->load->view($contacts_tab_view); ?>
                            </div>
                            <!-- Customer Notes subtab -->
                            <div>
                                <?php $this->load->view($notes_tab_view); ?>
                            </div>
                            <!-- Customer Purchases subtab -->
                            <div>
                                <?php $this->load->view($purchases_tab_view); ?>
                            </div>
                        </jqx-tabs>

                        <!-- -->
                        <div class="col-md-12 col-md-offset-0">
                            <div class="row">
                                <div id="mainButtonsCustomerForm">
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
                        <!-- Prompt before saving item on grid -->
                        <div class="col-md-12 col-md-offset-0">
                            <div class="row">
                                <div id="promptToCloseCustomerForm" class="" style="display: none">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            Do you want to save your changes?
                                            <button type="button" ng-click="closeCustomerAction(0)" class="btn btn-primary">Yes</button>
                                            <button type="button" ng-click="closeCustomerAction(1)" class="btn btn-warning">No</button>
                                            <button type="button" ng-click="closeCustomerAction(2)" class="btn btn-info">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Prompt before delete an item on grid -->
                        <div class="col-md-12 col-md-offset-0">
                            <div class="row">
                                <div id="promptToDeleteCustomerForm" class="" style="display: none">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            Do you really want to delete it?
                                            <button type="button" ng-click="deleteCustomerAction(0)" class="btn btn-primary">Yes</button>
                                            <button type="button" ng-click="deleteCustomerAction(1)" class="btn btn-warning">No</button>
                                            <button type="button" ng-click="deleteCustomerAction(2)" class="btn btn-info">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- NOTIFICATIONS AREA -->
                        <div class="col-md-12 col-md-offset-0">
                            <div class="row">
                                <jqx-notification jqx-settings="customerNoticeSuccessSettings" id="customerNoticeSuccessSettings">
                                    <div id="notification-content"></div>
                                </jqx-notification>
                                <jqx-notification jqx-settings="customerNoticeErrorSettings" id="customerNoticeErrorSettings">
                                    <div id="notification-content"></div>
                                </jqx-notification>
                                <div id="customerNoticeContainer" style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
                            </div>
                        </div>
                    </div>
                </jqx-window>
            </div>

        </div>
    </div>
</div>

<style>
    #addCustomerWindow {
        max-width: 1000px!important;
    }
</style>