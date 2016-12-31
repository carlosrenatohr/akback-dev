<!-- JS-->
<script type="application/javascript" src="<?= base_url()?>assets/admin/user/user_controller.js"></script>
<script type="application/javascript" src="<?= base_url()?>assets/admin/menu/admin_service.js"></script>
<script type="application/javascript" src="<?= base_url()?>assets/admin/user/user_service.js"></script>
<script type="application/javascript" src="<?= base_url()?>assets/admin/user/user_helpers.js"></script>
<!-- -->
<style>
    #userMainWindows {
        max-width: 95%!important;
    }
</style>
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
                                        <span class="icon-home"></span>
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url("dashboard/admin")?>" style="outline:0;">
                                        <span class="icon-back"></span>
                                        Back
                                    </a>
                                </li>
                                <li>
                                    <a style="outline:0;" ng-click="openAddUserWindows()">
                                        <span class="icon-new"></span>
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
                <jqx-grid id="userMainGrid"
                          jqx-settings="userTableSettings"
                          jqx-on-rowdoubleclick="openEditUserWindows(event)">
                </jqx-grid>
                <jqx-window jqx-on-close="onCloseUserWindowsEvent($event)" jqx-settings="addUserWindowSettings"
                            jqx-create="addUserWindowSettings" class="userJqxwindows" id="userMainWindows">
                    <div>
                        TITLE
                    </div>
                    <div>
                        <div class="new-user-form">

                            <form action="" id="new-user-form">
                            <div class="col-md-12 col-md-offset-0" id="table_add" style="float:left;">
                                <jqx-tabs id="tabsUser" jqx-width="'100%'" jqx-height="'100%'" style=' float: left;' jqx-theme="thetabsadd" jqx-settings="tabsSettings">
                                    <ul style=" margin-left: 30px;">
                                        <li id="user_itemTab">User</li>
                                        <li id="contact_itemTab">Contact</li>
                                        <li id="email_itemTab" style="display: none;">Email Settings</li>
                                        <li id="position_itemTab" style="display: none;">Position</li>
                                        <li id="notes_itemTab">Notes</li>
                                        <li id="info_itemTab">Info</li>
                                    </ul>
                                    <!-- ------------  -->
                                    <!--   USER TAB    -->
                                    <!-- ------------  -->
                                    <div class="col-md-12 col-md-offset-0 tabs" id="addtab1" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height: 390px; ">
                                        <?php $this->load->view($user_tab_view); ?>
                                    </div>
                                    <!-- ------------  -->
                                    <!-- CONTACT TAB  -->
                                    <!-- ------------  -->
                                    <div class="col-md-12 col-md-offset-0 tabs" id="addtab2" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height: 390px;">
                                        <?php $this->load->view($contact_tab_view); ?>
                                    </div>
                                    <!-- ------------  -->
                                    <!-- EMAIL SETTINGS TAB  -->
                                    <!-- ------------  -->
                                    <div class="col-md-12 col-md-offset-0 tabs" id="" style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height: 390px;">
                                        <?php $this->load->view($email_tab_view); ?>
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
                                        <?php $this->load->view($notes_tab_view); ?>
                                    </div>
                                    <!-- ------------ -->
                                    <!--   INFO TAB   -->
                                    <!-- ------------ -->
                                    <div class="col-md-12 col-md-offset-0 tabs" id="addtab5"
                                         style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height: 390px;">
                                        <?php $this->load->view($metadata_tab_view); ?>
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
                        <div id="add_container" style="width: 100%; height:60px; margin-top:15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;">
                        </div>
                    </div>
                </jqx-window>
            </div>

        </div>
    </div>
</div>