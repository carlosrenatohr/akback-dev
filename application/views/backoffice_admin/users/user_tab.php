<div class="row">
    <div style="width:330px;float:left;">
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
                <input type="password" class="form-control addUserField required-field" id="add_password" name="add_password" placeholder="Password">
            </div>
            <div style="float:left;">
                <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
            </div>
        </div>

        <div style="float:left; padding:2px;  width:350px;">
            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Code:</div>
            <div style="float:left; width:180px;">
                <input type="password" class="form-control addUserField required-field" id="add_code" name="add_code" placeholder="Code">
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
                            jqx-settings="positionSelectSetting"
                            ng-disabled='disabled'>
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

        <div style="float:left; padding:2px; width:400px;">
            <div style="float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">Email Enabled:</div>
            <div style="float:left; width:250px;">
                <div id="emailEnabledField"
                     style="display: inline-block;">
                    <jqx-radio-button jqx-group-name="'emailEnabledUser'" jqx-theme="summer"
                                      data-val="1" data-msg="yes" jqx-width="'10%'" jqx-height="25"
                                      class="eecx" style="display: inline-block;margin:10px;">
                        <span class="text-rb">Yes</span>
                    </jqx-radio-button>
                    <jqx-radio-button jqx-group-name="'emailEnabledUser'" jqx-theme="summer"
                                      data-val="0" data-msg="no" jqx-width="'10%'" jqx-height="25"
                                      class="eecx" style="display: inline-block;margin: 10px;"
                                        jqx-checked="true">
                        <span class="text-rb">No</span>
                    </jqx-radio-button>
                </div>
            </div>
        </div>
    </div><!--End Grid2-->
</div><!--End Grid Row-->