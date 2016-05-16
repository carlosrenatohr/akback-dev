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
<script type="application/javascript" src="../../assets/admin/user_helpers.js"></script>
<script type="application/javascript" src="../../assets/admin/position_controller.js"></script>
<!-- -->

<div ng-controller="userController">
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

                                    <div class="col-md-12 col-md-offset-0 tabs" id="addtab3"
                                         style="padding-top:10px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd; height: 390px;">
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
                                                        <div style="float:left; padding:2px; width:350px;">
                                                            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Position:</div>
                                                            <div style="float:left; width:180px;">
                                                                <jqx-combo-box id="positionByUserCombobox" class="" disabled
                                                                                jqx-settings="positionSelectSetting">
                                                                </jqx-combo-box>
                                                            </div>
                                                        </div>

                                                        <div style="float:left; padding:2px; width:350px;">
                                                            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Pay Basis:</div>
                                                            <div style="float:left; width:180px;">
                                                                <select id="payBasisSelect" name="PayBasis" class="userPositionField">
                                                                    <option value="hourly">Hourly</option>
                                                                    <option value="salary">Salary</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div style="float:left; padding:2px; width:350px;">
                                                            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Pay Rate:</div>
                                                            <div style="float:left; width:180px;">
                                                                <input type="number" class="form-control userPositionField" id="PayRateField" name="PayRate" placeholder="Pay Rate">
                                                            </div>
                                                        </div>

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
                                                                    <button type="button" ng-click="actionsToBeSurePosition(1)" class="btn btn-primary">Yes</button>
                                                                    <button	type="button" ng-click="actionsToBeSurePosition(2)" class="btn btn-warning">No</button>
                                                                    <button	type="button" ng-click="actionsToBeSurePosition(3)" class="btn btn-danger">Cancel</button>
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
                                    </div>


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
                                <div class="col-md-12 col-md-offset-0">
                                    <div class="row">
                                        <div id="addUserButtons">
                                            <div class="form-group">
                                                <div class="col-sm-12">
<!--                                                    <button type="button" id="add_save" class="btn btn-primary" disabled>Save</button>-->
                                                    <button type="button" id="submitAddUserForm" ng-click="submitUserForm()" class="btn btn-primary submitUserBtn" disabled>Save</button>
                                                    <button	type="button" id="cancelAddUserForm" ng-click="closeWindows($event)" class="btn btn-warning cancelUserBtn">Close</button>
                                                    <button	type="button" id="deleteAddUserForm" ng-click="pressDeleteButton()" class="btn btn-danger removeUserBtn hide" style="display:none; overflow:auto;">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="addUserConfirm" style="display:none; margin-top:10px; overflow:auto;">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div>Would you like to save your changes.</div>
                                                    <button type="button" ng-click="closeWindowsConfirm(0)" class="btn btn-primary">Yes</button>
                                                    <button type="button" ng-click="closeWindowsConfirm(1)" class="btn btn-warning">No</button>
                                                    <button type="button" ng-click="closeWindowsConfirm(2)" class="btn btn-info">Cancel</button>
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

    /*.icon-32-edit{*/
        /*background-image: url("../assets/img/edit.png");*/
    /*}*/

    /*.icon-32-trash{*/
        /*background-image: url("../assets/img/remove3.png");*/
    /*}*/

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
