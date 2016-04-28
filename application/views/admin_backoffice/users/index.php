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
<!-- JS-->
<script>
    //-->Global Variable
    var SiteRoot = "<?php echo base_url()?>";
</script>
<script type="application/javascript" src="../../assets/admin/user_controller.js"></script>
<!-- -->
<input type="hidden" id="default_zipcode" value="<?php //echo $zipcode; ?>"/>
<input type="hidden" id="customerid" value="">
<div id="CustomerController" ng-controller="demoController">
    <div class="container-fluid">
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <nav class="navbar navbar-default" role="navigation" style="background:#CCC;">
                    <!--
                    <div class="col-md-3">
                         <a class="navbar-brand" style="color: #146295;"><b>List of Customer:</b></a>
                    </div>
                    -->
                    <div class="col-md-12">
                        <div id="toolbar" class="toolbar-list">
                            <ul class="nav navbar-nav navbar-left">
                                <li>
                                    <a href="<?php echo base_url("dashboard/admin")?>" style="outline:0;">
                                        <span class="icon-32-back"></span>
                                        Home
                                    </a>
                                </li>
                                <li>
                                    <a style="outline:0;" id="_addnew">
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
<!--                <jqx-data-table id="users-table" jqx-watch="disabled"-->
<!--                                jqx-on-row-click="rowClick(event)"-->
<!--                                jqx-on-row-double-click="rowDoubleClick(event)"-->
<!--                                jqx-settings="gridSettings">-->
<!--                </jqx-data-table>-->
                <jqx-window jqx-on-close="close()" class="customer_form" jqx-create="dialogSettings" jqx-settings="dialogSettings" style="display:none;" >
                    <div id="editform">
                        <div style="overflow: hidden;">
                            <div class="col-md-12 col-md-offset-0" id="table" style="float:left;">
                                <jqx-tabs jqx-width="'100%'" jqx-height="'100%'" style="float: left;" jqx-theme="thetabs" jqx-settings="tabset" jqx-selected-item="selectedItem">
                                    <ul style="margin-left: 30px;">
                                        <li>Info</li>
                                        <li>Extra</li>
                                        <li>Note</li>
                                    </ul>
                                    <div class="col-md-12 col-md-offset-0 tabs" id="tab1" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height: 390px;">
                                        <div class="row">
                                            <div style="width:330px;float:left;">
                                                <input type="hidden" name="submitted" id="submitted" value="1">
                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">First Name:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control customer" id="firstname" name="firstname" placeholder="First Name" autofocus>
                                                    </div>
                                                    <div style="float:left;">
                                                        <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Last Name:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control customer" id="lastname" name="lastname" placeholder="Last Name">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Company:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control customer" id="company" name="company" placeholder="Company">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Address1:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control customer" id="address1" name="address1" placeholder="Address1">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Address2:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control customer" id="address2" name="address2" placeholder="Address2">
                                                    </div>
                                                </div>
                                            </div>

                                            <div style="width:330px;float:left;">
                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Phone1:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control customer phone" id="phone1" name="phone1" placeholder="Phone1">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Phone2:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control customer phone" id="phone2" name="phone2" placeholder="Phone2">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Phone3:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control customer phone" id="phone3" name="phone3" placeholder="Phone3">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Fax:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control customer phone" id="fax" name="fax" placeholder="Fax">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:400px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Email:</div>
                                                    <div style="float:left; width:250px;">
                                                        <div class="btn-group">
                                                            <input type="email" class="form-control searchinput customer" id="email" name="email" placeholder="Email Address">
                                                            <span id="edit_searchclear" class="edit_searchclear glyphicon glyphicon-remove-circle"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div style="width:450px;float:left;">
                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Zip:</div>
                                                    <div style="float:left; width:180px;">
                                                        <jqx-combo-box id="zipcode" jqx-on-select="zipselectHandler(event)" jqx-settings="zipcode" jqx-place-holder="placeHolderzipcode"></jqx-combo-box>
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">City:</div>
                                                    <div style="float:left; width:180px;">
                                                        <jqx-combo-box id="city" jqx-on-select="cityselectHandler(event)" jqx-settings="city" jqx-place-holder="placeHoldercity"></jqx-combo-box>
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">State:</div>
                                                    <div style="float:left; width:180px;">
                                                        <jqx-combo-box id="state" jqx-on-select="stateselectHandler(event)" jqx-settings="state" jqx-place-holder="placeHolderstate"></jqx-combo-box>
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Island:</div>
                                                    <div style="float:left; width:180px;">
                                                        <jqx-combo-box id="island" jqx-on-select="islandselectHandler(event)" jqx-settings="island" jqx-place-holder="placeHolderisland"></jqx-combo-box>
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Country:</div>
                                                    <div style="float:left; width:180px;">
                                                        <jqx-combo-box id="country" jqx-on-select="countryselectHandler(event)" jqx-settings="country" jqx-place-holder="placeHoldercountry"></jqx-combo-box>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--End Row-->
                                    </div><!--End tab 1-->
                                    <div class="col-md-12 col-md-offset-0 tabs" id="tab2" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height: 390px;">
                                        <div class="row">
                                            <div style="width:330px;float:left;">
                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Website:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control customer" id="website" name="website" placeholder="Website">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Custom1:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control customer" id="custom1" name="custom1" placeholder="Custom1">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Custom2:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control customer" id="custom2" name="custom2" placeholder="Custom2">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Custom3:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control customer" id="custom3" name="custom3" placeholder="Custom3">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-md-offset-0 tabs" id="tab3" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height:390px;">
                                        <div class="row">
                                            <div style="width:100%;float:left;">
                                                <div style="float:left; padding:2px; width:100%;">
                                                    <div style="float:left; padding:8px; text-align:left; width:100px; font-weight:bold;">Note:</div>
                                                    <div style="float:left; width:100%;">
                                                        <textarea rows="15" id="note" name="note" class="form-control customer" placeholder="Note"></textarea>                                                     </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </jqx-tabs>
                            </div>
                            <div class="col-md-12 col-md-offset-0">
                                <div class="row">
                                    <div id="_btnscd">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button type="button" id="_update" class="btn btn-primary" disabled>Save</button>
                                                <button	type="button" id="_cancel" class="btn btn-warning">Close</button>
                                                <button	type="button" id="_canceldeleted" class="btn btn-warning" style="display:none;">Close</button>
                                                <button	type="button" id="_delete" class="btn btn-danger">Delete</button>
                                                <button	type="button" id="_restore" class="btn btn-success" style="display:none;">Restore</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="msg" style="display:none; overflow:auto;">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                Would you like to save your changes.
                                                <button type="button" id="_yes" class="btn btn-primary">Yes</button>
                                                <button type="button" id="_no" class="btn btn-warning">No</button>
                                                <button type="button" id="_conf_cancel" class="btn btn-info">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="msg_delete" style="display:none; overflow:auto;">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <p id="delmsg"></p>
                                                <button type="button" id="_delyes" class="btn btn-primary">Yes</button>
                                                <button type="button" id="_delno" class="btn btn-warning">No</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="edit_jqxNotification">
                            <div id="edit_notificationContent"></div>
                        </div>
                        <div id="edit_email_jqxNotification">
                            <div id="edit_email_notificationContent"></div>
                        </div>
                        <div id="edit_save_jqxNotification">
                            <div id="edit_save_notificationContent"></div>
                        </div>
                        <div id="edit_delete_jqxNotification">
                            <div id="edit_delete_notificationContent"></div>
                        </div>
                        <div id="edit_restore_jqxNotification">
                            <div id="edit_restore_notificationContent"></div>
                        </div>
                        <div id="edit_container" style="width: 400px; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;">
                        </div>
                        <!--
                        <div style="width:100%; float:left;">
                             <p id="message"></p>
                        </div>
                        -->
                    </div>
                </jqx-window>
                <jqx-window jqx-on-close="close()" class="add_customer_form" jqx-create="addialogSettings" jqx-settings="addialogSettings" style="display:none;">
                    <div>Add New Customer</div>
                    <div id="addform" style="border: 1px solid #000;">
                        <div id="addform_handler" style="overflow: auto;">
                            <div class="col-md-12 col-md-offset-0" id="table_add" style="float:left;">
                                <jqx-tabs id="addtabs" jqx-width="'100%'" jqx-height="'100%'" style='float: left;' jqx-theme="thetabsadd" jqx-settings="tabsSettings" jqx-selected-item="selectedItem">
                                    <ul style="margin-left: 30px;">
                                        <li>Info</li>
                                        <li>Extra</li>
                                        <li>Note</li>
                                    </ul>
                                    <div class="col-md-12 col-md-offset-0 tabs" id="addtab1" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height: 390px;">
                                        <div class="row">
                                            <div style="width:330px;float:left;">
                                                <input type="hidden" name="submitted" id="submitted" value="1">
                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">First Name:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addcustomer" id="add_firstname" name="add_firstname" placeholder="First Name" autofocus>
                                                    </div>
                                                    <div style="float:left;">
                                                        <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px;  width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Last Name:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addcustomer" id="add_lastname" name="add_lastname" placeholder="Last Name">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px;  width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Company:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addcustomer" id="add_company" name="add_company" placeholder="Company">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px;  width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Address1:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addcustomer" id="add_address1" name="add_address1" placeholder="Address1">
                                                    </div>
                                                </div>


                                                <div style="float:left; padding:2px;  width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Address2:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addcustomer" id="add_address2" name="add_address2" placeholder="Address2">
                                                    </div>
                                                </div>
                                            </div><!--End Grid1-->

                                            <div style="width:330px;float:left;">
                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Phone1:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addcustomer phone" id="add_phone1" name="add_phone1" placeholder="Phone1">
                                                    </div>
                                                </div>


                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Phone2:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addcustomer phone" id="add_phone2" name="add_phone2" placeholder="Phone2">
                                                    </div>
                                                </div>


                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Phone3:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addcustomer phone" id="add_phone3" name="add_phone3" placeholder="Phone3">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Fax:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addcustomer phone" id="add_fax" name="add_fax" placeholder="Fax">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:400px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Email:</div>
                                                    <div style="float:left; width:250px;">
                                                        <div class="btn-group">
                                                            <input type="email" class="form-control searchinput addcustomer" id="add_email" name="add_email" placeholder="Email Address" value="">
                                                            <span id="searchclear" class="searchclear glyphicon glyphicon-remove-circle"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--End Grid2-->

                                            <div style="width:450px;float:left;">
                                                <div style="float:left; padding:2px; width:450px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Zip:</div>
                                                    <div style="float:left; width:180px;">
                                                        <jqx-combo-box id="add_zip" jqx-on-select="addzipselectHandler(event)" jqx-settings="addzipcode" jqx-place-holder="placeHolderaddzipcode"></jqx-combo-box>
                                                    </div>
                                                    <div style="float:left;">
                                                        <span class="add_sel_zipcode_message" style="color:#F00;"></span>
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px;  width:450px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">City:</div>
                                                    <div style="float:left; width:180px;">
                                                        <jqx-combo-box id="add_city" jqx-on-select="addcityselectHandler(event)" jqx-settings="addcity" jqx-place-holder="placeHolderaddcity"></jqx-combo-box>
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px;  width:450px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">State:</div>
                                                    <div style="float:left; width:180px;">
                                                        <jqx-combo-box id="add_state" jqx-on-select="addstateselectHandler(event)" jqx-settings="addstate" jqx-place-holder="placeHolderaddstate"></jqx-combo-box>
                                                    </div>
                                                </div>


                                                <div style="float:left; padding:2px;  width:450px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Island:</div>
                                                    <div style="float:left; width:180px;">
                                                        <jqx-combo-box id="add_island" jqx-on-select="addislandselectHandler(event)" jqx-settings="addisland" jqx-place-holder="placeHolderaddisland"></jqx-combo-box>
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px;  width:450px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Country:</div>
                                                    <div style="float:left; width:180px;">
                                                        <jqx-combo-box id="add_country" jqx-on-select="addcountryselectHandler(event)" jqx-settings="addcountry" jqx-place-holder="placeHolderaddcountry"></jqx-combo-box>
                                                    </div>
                                                </div>
                                            </div><!--End Grid 3-->
                                        </div><!--End Grid Row-->
                                    </div><!--End Tab1-->

                                    <div class="col-md-12 col-md-offset-0 tabs" id="addtab2" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height: 390px;">
                                        <div class="row">
                                            <div style="width:350px;float:left;">
                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Website:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addcustomer" id="add_website" name="add_website" placeholder="Website">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Custom1:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addcustomer" id="add_custom1" name="add_custom1" placeholder="Custom1">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Custom2:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addcustomer" id="add_custom2" name="add_custom2" placeholder="Custom2">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Custom3:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addcustomer" id="add_custom3" name="add_custom3" placeholder="Custom3">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-md-offset-0 tabs" id="addtab3" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height: 390px;">
                                        <div class="row">
                                            <div style="width:100%;float:left;">
                                                <div style="float:left; padding:2px; width:100%;">
                                                    <div style="float:left; padding:8px; text-align:left; width:100px; font-weight:bold;">Note:</div>
                                                    <div style="float:left; width:100%;">
                                                        <textarea rows="15" id="add_note" name="add_note" class="form-control addcustomer" placeholder="Note"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </jqx-tabs>
                                <div class="col-md-12 col-md-offset-0">
                                    <div class="row">
                                        <div id="add_btnscd">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button type="button" id="add_save" class="btn btn-primary" disabled>Save</button>
                                                    <button	type="button" id="add_cancel" class="btn btn-warning">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="add_msg" style="display:none; margin-top:10px; overflow:auto;">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    Would you like to save your changes.
                                                    <button type="button" id="add_yes" class="btn btn-primary">Yes</button>
                                                    <button type="button" id="add_no" class="btn btn-warning">No</button>
                                                    <button type="button" id="add_conf_cancel" class="btn btn-info">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="add_confirmation_after_save" style="display:none; margin-top:10px; overflow:auto;">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label id="addsavedmymessage"></label>
                                                    <button type="button" id="add_aftersave_yes" class="btn btn-primary">Yes</button>
                                                    <button type="button" id="add_aftersave_no" class="btn btn-warning">No</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="add_jqxNotification">
                            <div id="add_notificationContent">
                            </div>
                        </div>
                        <div id="add_email_jqxNotification">
                            <div id="add_email_notificationContent">
                            </div>
                        </div>
                        <div id="add_save_jqxNotification">
                            <div id="add_save_notificationContent">
                            </div>
                        </div>
                        <div id="add_container" style="width: 400px; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;">
                        </div>
                    </div>
                </jqx-window>
            </div>
            <!--     USER ACTION       -->
            <div class="row" ng-controller="userController">
                <a style="outline:0;" ng-click="openAddUserWindows()">
                    <span class="icon-32-new"></span>
                    New
                </a>

                <jqx-data-table jqx-settings="userTableSettings">
                </jqx-data-table>


                <jqx-window jqx-on-close="close()" jqx-settings="addUserWindowSettings"
                            jqx-create="addUserWindowSettings">
                    <div>
                        Add new user
                    </div>
                    <div>
                        <div class="new-user-form">
                            <form action="" id="new-user-form">
                            <div class="col-md-12 col-md-offset-0" id="table_add" style="float:left;">
                                <jqx-tabs id="" jqx-width="'100%'" jqx-height="'100%'" style='float: left;' jqx-theme="thetabsadd" jqx-settings="tabsSettings" jqx-selected-item="selectedItem">
                                    <ul style="margin-left: 30px;">
                                        <li>Info</li>
                                        <li>Contact</li>
                                        <li>Position</li>
                                        <li>Notes</li>
                                    </ul>
                                    <div class="col-md-12 col-md-offset-0 tabs" id="addtab1" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height: 390px;">
                                        <div class="row">
                                            <div style="width:330px;float:left;">
<!--                                                <input type="hidden" name="submitted" id="submitted" value="1">-->

                                                <!-- Start user fields-->
                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">User Name:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addUserField required-field" id="add_username" name="add_userName" placeholder="User Name" autofocus>
                                                    </div>
                                                    <div style="float:left;">
                                                        <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">First Name:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addUserField required-field" id="add_firstname" name="add_firstName" placeholder="First Name">
                                                    </div>
                                                    <div style="float:left;">
                                                        <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px;  width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Last Name:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addUserField" id="add_lastname" name="add_lastName" placeholder="Last Name">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px;  width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Password:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addUserField required-field" id="add_password" name="add_password" placeholder="Password">
                                                    </div>
                                                    <div style="float:left;">
                                                        <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px;  width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Code:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addUserField required-field" id="add_code" name="add_code" placeholder="Code">
                                                    </div>
                                                    <div style="float:left;">
                                                        <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                                    </div>
                                                </div>

                                            </div><!--End Grid1-->

                                            <div style="float:left; padding:2px; width:350px;">
                                                <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Primary Position:</div>
                                                <div style="float:left; width:180px;">
                                                    <jqx-combo-box id="" jqx-on-select="" jqx-settings="" jqx-place-holder=""></jqx-combo-box>
                                                </div>
                                            </div>

                                            <div style="width:330px;float:left;">
                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Phone 1:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addUserField phone" id="add_phone1" name="add_phone1" placeholder="Phone1">
                                                    </div>
                                                </div>


                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Phone 2:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addUserField phone" id="add_phone2" name="add_phone2" placeholder="Phone2">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:400px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Email Address:</div>
                                                    <div style="float:left; width:250px;">
                                                        <div class="btn-group">
                                                            <input type="email" class="form-control searchinput addUserField" id="add_email" name="add_email" placeholder="Email Address" value="">
                                                            <span id="searchclear" class="searchclear glyphicon glyphicon-remove-circle"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--End Grid2-->
                                        </div><!--End Grid Row-->
                                    </div><!--End Tab1-->

                                    <div class="col-md-12 col-md-offset-0 tabs" id="addtab2" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height: 390px;">
                                        <div class="row">
                                            <div style="width:350px;float:left;">
                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Address 1:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addUserField" id="add_address1" name="add_address1" placeholder="Adress1">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Address 2:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addUserField" id="add_address2" name="add_address2" placeholder="Adress2">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">City:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addUserField" id="add_address2" name="add_city" placeholder="City">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">State:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addUserField" id="add_state" name="add_state" placeholder="State">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Zip:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addUserField" id="add_zip" name="add_zip" placeholder="Zip">
                                                    </div>
                                                </div>

                                                <div style="float:left; padding:2px; width:350px;">
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Country:</div>
                                                    <div style="float:left; width:180px;">
                                                        <input type="text" class="form-control addUserField" id="add_country" name="add_zip" placeholder="Country">
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-md-offset-0 tabs" id="addtab4" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height: 390px;">
                                        <div class="row">
                                            <div>
                                                <jqx-data-table jqx-watch="" jqx-on-row-double-click="" jqx-settings=""></jqx-data-table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-md-offset-0 tabs" id="addtab3" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height: 390px;">
                                        <div class="row">
                                            <div style="width:100%;float:left;">
                                                <div style="float:left; padding:2px; width:100%;">
                                                    <div style="float:left; padding:8px; text-align:left; width:100px; font-weight:bold;">Note:</div>
                                                    <div style="float:left; width:100%;">
                                                        <textarea rows="15" id="add_note" name="add_note" class="form-control addcustomer" placeholder="Note"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </jqx-tabs>
                                <div class="col-md-12 col-md-offset-0">
                                    <div class="row">
                                        <div id="add_btnscd">
                                            <div class="form-group">
                                                <div class="col-sm-12">
<!--                                                    <button type="button" id="add_save" class="btn btn-primary" disabled>Save</button>-->
                                                    <button type="button" ng-click="submitUserForm()" class="btn btn-primary" >Save</button>
                                                    <button	type="button" id="add_cancel" class="btn btn-warning">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="add_msg" style="display:none; margin-top:10px; overflow:auto;">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    Would you like to save your changes.
                                                    <button type="button" id="add_yes" class="btn btn-primary">Yes</button>
                                                    <button type="button" id="add_no" class="btn btn-warning">No</button>
                                                    <button type="button" id="add_conf_cancel" class="btn btn-info">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="add_confirmation_after_save" style="display:none; margin-top:10px; overflow:auto;">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label id="addsavedmymessage"></label>
                                                    <button type="button" id="add_aftersave_yes" class="btn btn-primary">Yes</button>
                                                    <button type="button" id="add_aftersave_no" class="btn btn-warning">No</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                        <div id="add_jqxNotification">
                            <div id="add_notificationContent">
                            </div>
                        </div>
                        <div id="add_email_jqxNotification">
                            <div id="add_email_notificationContent">
                            </div>
                        </div>
                        <div id="add_save_jqxNotification">
                            <div id="add_save_notificationContent">
                            </div>
                        </div>
                        <jqx-notification jqx-settings="notificationSettings">
                            <div id="notification-content">

                            </div>
                        </jqx-notification>
                        <div id="add_container" style="width: 400px; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;">
                        </div>
                    </div>
                </jqx-window>
            </div>

        </div>
    </div>
</div>


<style type="text/css">
    body{
        padding: 0;
        margin: 0;
    }

    .required{
        color: #F00;
    }

    div.toolbar-list a {
        cursor: pointer;
        display: block;
        float: left;
        padding: 1px 10px;
        white-space: nowrap;
    }

    div.toolbar-list span {
        display: block;
        float: none;
        height: 32px;
        margin: 0 auto;
        width: 32px;
    }
    .icon-32-new {
        background-image: url("../../assets/img/addnew.png");
    }

    .icon-32-edit{
        background-image: url("../assets/img/edit.png");
    }

    .icon-32-trash{
        background-image: url("../assets/img/remove3.png");
    }

    .icon-32-back {
        background-image: url("../../assets/img/back.png");
    }

    /*
    .customer_form{
        min-height: 200px !important;
        min-width: 500px !important;
    }
    */

    .add_customer_form{
        height: 100% !important;
        width: 100% !important;
    }

    .ngx-icon-close{
        display:none;
    }

    .customer_form{
        -webkit-border-radius: 15px 15px 15px 15px;
        border-radius: 15px 15px 15px 15px;
        border: 5px solid #449bca;
    }

    .add_customer_form{
        -webkit-border-radius: 15px 15px 15px 15px;
        border-radius: 15px 15px 15px 15px;
        border: 5px solid #449bca;
    }

    #ngxTabs1{
        -webkit-border-radius: 20px 20px 20px 20px;
        border-radius: 20px 20px 20px 20px;
    }

    div.growlUI { background: url("../assets/img/symbol_check.png") no-repeat 10px 10px; width:48px; }
    div.growlUI h1, div.growlUI h2 {
        color: white; padding: 5px 5px 5px 65px; text-align: left
    }

    div.growlUI h1{
        font-size:1.5em;
    }
    div.growlUI h2{
        font-size: 1em;
    }

    #editform{
        position:relative;
    }

    .taskbar{
        border-top: 2px solid #CCC;
        overflow: auto;
        bottom: 0px;
        height: 30px;
        width: 100%;
        position:absolute;
        left:0px;
    }

    .add_taskbar{
        border-top: 2px solid #CCC;
        overflow: auto;
        bottom: 0px;
        height: 30px;
        width: 100%;
        position:absolute;
        left:0px;
    }

    .searchclear {
        position:absolute;
        right:5px;
        top:0;
        bottom:0;
        height:14px;
        margin:auto;
        font-size:14px;
        cursor:pointer;
        color:#ccc;
    }

    .edit_searchclear {
        position:absolute;
        right:5px;
        top:0;
        bottom:0;
        height:14px;
        margin:auto;
        font-size:14px;
        cursor:pointer;
        color:#ccc;
    }
</style>
