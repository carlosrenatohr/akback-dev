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
<link rel="stylesheet" href="../../assets/admin/styles.css">
<script>
    // --Global Variable
    var SiteRoot = "<?php echo base_url()?>";
</script>
<script type="application/javascript" src="../../assets/admin/user/user_controller.js"></script>
<script type="application/javascript" src="../../assets/admin/user/user_helpers.js"></script>
<!-- -->

<div ng-controller="userController" ng-cloak>
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
                                    <a href="<?php echo base_url("backoffice/dashboard")?>" style="outline:0;">
                                        <span class="icon-32-home"></span>
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url("dashboard/admin")?>" style="outline:0;">
                                        <span class="icon-32-back"></span>
                                        Back
                                    </a>
                                </li>
                                <li>
                                    <a style="outline:0;" ng-click="openAddUserWindows()">
                                        <span class="icon-32-new"></span>
                                        New
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <!--     USER ACTION       -->
            <div class="row">
                <jqx-data-table jqx-settings="userTableSettings"
                                jqx-on-row-double-click="openEditUserWindows(event)">
                </jqx-data-table>
                <jqx-window jqx-on-close="close()" jqx-settings="addUserWindowSettings"
                            jqx-create="addUserWindowSettings" class="userJqxwindows">
                    <div>

                    </div>
                    <div>
                        <div class="new-user-form">

                            <form action="" id="new-user-form">
                            <div class="col-md-12 col-md-offset-0" id="table_add" style="float:left;">
                                <jqx-tabs id="tabsUser" jqx-width="'100%'" jqx-height="'100%'" style=' float: left;' jqx-theme="thetabsadd" jqx-settings="tabsSettings">
                                    <ul style=" margin-left: 30px;">
                                        <li id="info_itemTab">Info</li>
                                        <li id="contact_itemTab">Contact</li>
                                        <li id="position_itemTab" style="display: none;">Position</li>
                                        <li id="notes_itemTab">Notes</li>
                                    </ul>
                                    <!-- ------------  -->
                                    <!-- INFO TAB  -->
                                    <!-- ------------  -->
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
                                                <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Primary:</div>
                                                <div style="float:left; width:180px;">
                                                    <jqx-combo-box  jqx-on-select="positionSelectChanged(event)" id="positionCombobox" class="required-field"
                                                                    jqx-settings="positionSelectSetting">

                                                    </jqx-combo-box>
                                                </div>
                                                <div style="float:left;">
                                                    <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
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
                                                    <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Email:</div>
                                                    <div style="float:left; width:250px;">
                                                        <div class="btn-group">
                                                            <input type="email" class="form-control searchinput addUserField" id="add_email" name="add_email" placeholder="Email Address" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--End Grid2-->
                                        </div><!--End Grid Row-->
                                    </div><!--End Tab1-->

                                    <!-- ------------  -->
                                    <!-- CONTACT TAB  -->
                                    <!-- ------------  -->
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
                                                        <input type="text" class="form-control addUserField" id="add_city" name="add_city" placeholder="City">
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
                                    <!-- ------------  -->
                                    <!-- POSITION TAB  -->
                                    <!-- ------------  -->
                                    <div class="col-md-12 col-md-offset-0 tabs" id="addtab3"
                                         style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height: 390px;">
                                        <?php $this->load->view($position_tab_view); ?>
                                    </div>

                                    <!-- ------------  -->
                                    <!-- NOTES TAB  -->
                                    <!-- ------------  -->
                                    <div class="col-md-12 col-md-offset-0 tabs" id="addtab4" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height: 390px;">
                                        <div class="row">
                                            <div style="width:100%;float:left;">
                                                <div style="float:left; padding:2px; width:100%;">
                                                    <div style="float:left; padding:8px; text-align:left; width:100px; font-weight:bold;">Note:</div>
                                                    <div style="float:left; width:100%;">
                                                        <textarea rows="15" id="add_note" name="add_note" class="form-control addUserField" placeholder="Note"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </jqx-tabs>
                                <!-- Main user buttons row -->
                                <div class="col-md-12 col-md-offset-0">
                                    <div class="row">
                                        <div id="addUserButtons">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button type="button" id="submitAddUserForm" ng-click="submitUserForm()" class="btn btn-primary submitUserBtn" disabled>Save</button>
                                                    <button	type="button" id="cancelAddUserForm" ng-click="closeUserWindows()" class="btn btn-warning cancelUserBtn">Close</button>
                                                    <button	type="button" id="deleteAddUserForm" ng-click="pressDeleteButton()" class="btn btn-danger removeUserBtn" style=" display:none; overflow:auto;">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="addUserConfirm" style="display:none; margin-top:10px; overflow:auto;">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div>Would you like to save your changes.</div>
                                                    <button type="button" ng-click="closeUserWindows(0)" class="btn btn-primary">Yes</button>
                                                    <button type="button" ng-click="closeUserWindows(1)" class="btn btn-warning">No</button>
                                                    <button type="button" ng-click="closeUserWindows(2)" class="btn btn-info">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="addUserAnotherRow" style="display:none; margin-top:10px; overflow:auto;">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <span>Would you like to add another user?</span>
                                                    <button type="button" class="btn btn-primary" ng-click="addAnotherUserConfirm(0)">Yes</button>
                                                    <button type="button" class="btn btn-warning" ng-click="addAnotherUserConfirm(1)">No</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="sureToDeleteUser" style="display:none; margin-top:10px; overflow:auto;">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <span>Are you sure you want to delete <b>{{ editing_username }}</b>?</span>
                                                    <button type="button" class="btn btn-primary" ng-click="deletingUserConfirm(0)">Yes</button>
                                                    <button type="button" class="btn btn-warning" ng-click="deletingUserConfirm(1)">No</button>
                                                    <button type="button" class="btn btn-info" ng-click="deletingUserConfirm(2)">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                            </div>
                        </div>
                        <!-- Notifications area -->
                        <jqx-notification jqx-settings="notificationSuccessSettings" id="notificationSuccessSettings">
                            <div id="notification-content"></div>
                        </jqx-notification>
                        <jqx-notification jqx-settings="notificationErrorSettings" id="notificationErrorSettings">
                            <div id="notification-content"></div>
                        </jqx-notification>
                        <div id="add_container" style="width: 650px; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto; ">
                        </div>
                    </div>
                </jqx-window>
            </div>

        </div>
    </div>
</div>