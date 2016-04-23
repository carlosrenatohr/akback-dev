<jqx-window jqx-on-close="close()" id="category_add" jqx-create="dialogCategoryAdd" jqx-settings="dialogCategoryAdd" style="display:none;">
    <div>
     	<div style="width:330px;float:left;">
            <div style="float:left; padding:2px; width:340px;">
                <div style="float:left; padding:8px; text-align:right; width:140px; font-weight:bold;">Category Name:</div>
                <div style="float:left; width:180px;">
                    <input type="text" class="form-control" id="add_category_name" ng-model="add_category_name" />
                </div>
                <span style="color:#F00;">*</span>
            </div>
            <div class="row" style="margin-top:10px;">
                <div id="add_primary">
                    <div class="form-group">
                        <div class="col-sm-12" style="padding-top:10px;">
                            <button type="button" id="add_save" ng-click="CreateCategory()" class="btn btn-primary" disabled>Save</button>
                            <button	type="button" id="add_cancel" class="btn btn-warning">Close</button>
                        </div>
                    </div>
                </div>
                <div id="add_save_message" style="display:none;">
                	<div class="form-group">
                        <div class="col-sm-12" style="padding-top:10px;">
                            <div id="add_message">Would you like to save your changes.</div>
                            <button type="button" id="add_yes" class="btn btn-primary">Yes</button>
                            <button type="button" id="add_no" class="btn btn-warning">No</button>
                            <button type="button" id="add_message_cancel" class="btn btn-info">Cancel</button> 
                        </div>
                    </div>           
               </div>
            </div>
           <div id="add_category_jqxNotification">
                <div id="add_category_notificationContent"></div>
           </div>
           
           <div id="add_category_empty_jqxNotification">
                <div id="add_category_empty_notificationContent"></div>
           </div>
           
           <div id="add_category_container" style="width: 320px; height:60px; padding-top:5px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
           
        </div>    
    </div>
</jqx-window>
<style type="text/css">
    #category_add {
        -webkit-border-radius: 15px 15px 15px 15px;
        border-radius: 15px 15px 15px 15px;
        border: 5px solid #449bca;
	}
</style>