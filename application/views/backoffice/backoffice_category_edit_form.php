<jqx-window jqx-on-close="close()" id="category_edit" jqx-create="dialogCategoryEdit" jqx-settings="dialogCategoryEdit" style="display:none;">
    <div>
     	<div style="width:330px;float:left;">
            <div style="float:left; padding:2px; width:340px;">
                <div style="float:left; padding:8px; text-align:right; width:140px; font-weight:bold;">Category Name:</div>
                <div style="float:left; width:180px;">
                    <input type="text" class="form-control" id="edit_category_name" ng-model="edit_category_name" />
                </div>
                <span style="color:#F00;">*</span>
            </div>
            <div class="row" style="margin-top:10px;">
                <div id="edit_primary">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="button" id="edit_save" class="btn btn-primary" disabled>Save</button>
                            <button	type="button" id="edit_cancel" class="btn btn-warning">Close</button>
                            <button	type="button" id="edit_delete" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </div>
                <div id="edit_save_message" style="display:none;">
                	<div class="form-group">
                        <div class="col-sm-12">
                            <div id="add_message">Would you like to save your changes.</div>
                            <button type="button" id="edit_yes" class="btn btn-primary">Yes</button>
                            <button type="button" id="edit_no" class="btn btn-warning">No</button>
                            <button type="button" id="edit_message_cancel" class="btn btn-info">Cancel</button> 
                        </div>
                    </div>           
               </div>
               <div id="delete_buttons" style="display:none;">
               		<div class="form-group">
                        <div class="col-sm-12">
                        	<div id="edit_delete_message"></div>
                            <button type="button" id="delete_yes" class="btn btn-primary">Yes</button>
                            <button type="button" id="delete_no" class="btn btn-warning">No</button>
                        </div>
                    </div>    
               </div>
            </div>
           <div id="edit_category_jqxNotification">
                <div id="edit_category_notificationContent"></div>
           </div>
           
           <div id="edit_category_empty_jqxNotification">
                <div id="edit_category_empty_notificationContent"></div>
           </div>
           
           <div id="delete_category_jqxNotification">
                <div id="delete_category_notificationContent"></div>
           </div>
           
           <div id="edit_category_container" style="width: 320px; height:60px; padding-top:5px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
           
        </div>    
    </div>
</jqx-window>
<style type="text/css">
    #category_edit {
        -webkit-border-radius: 15px 15px 15px 15px;
        border-radius: 15px 15px 15px 15px;
        border: 5px solid #449bca;
	}
</style>