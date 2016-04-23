<jqx-window jqx-on-close="close()" id="subcategory_add" jqx-create="dialogSubCategoryAdd" jqx-settings="dialogSubCategoryAdd" style="display:none;">
    <div>
     	<div style="width:330px;float:left;">
            <div style="float:left; padding:2px; width:340px;">
                <div style="float:left; padding:8px; text-align:right; width:85px; font-weight:bold;">Name:</div>
                <div style="float:left; width:230px;">
                    <input type="text" class="form-control" id="add_sub_category_name" ng-model="add_sub_category_name" />
                </div>
                <span style="color:#F00;">*</span>
            </div>
             <div style="float:left; padding:2px; width:340px;">
                <div style="float:left; padding:8px; text-align:right; width:85px; font-weight:bold;">Category:</div>
                <div style="float:left; width:230px;">
                    <div id='add_sub_category_list'></div>
                </div>
                <span style="color:#F00;">*</span>
            </div>
            <div class="row" style="margin-top:10px;">
                <div id="add_subcat_primary">
                    <div class="form-group">
                        <div class="col-sm-12" style="padding-top: 10px;">
                            <button type="button" id="add_subcat_save"  class="btn btn-primary" disabled>Save</button>
                            <button	type="button" id="add_subcat_cancel" class="btn btn-warning">Close</button>
                        </div>
                    </div>
                </div>
                <div id="add_subcat_save_message" style="display:none;">
                	<div class="form-group">
                        <div class="col-sm-12">
                            <div id="add_subcat_message">Would you like to save your changes.</div>
                            <button type="button" id="add_subcat_yes" class="btn btn-primary">Yes</button>
                            <button type="button" id="add_subcat_no" class="btn btn-warning">No</button>
                            <button type="button" id="add_subcat_message_cancel" class="btn btn-info">Cancel</button> 
                        </div>
                    </div>           
               </div>
            </div>
           <div id="add_subcat_jqxNotification">
                <div id="add_subcat_notificationContent"></div>
           </div>
           
           <div id="add_subcat_empty_jqxNotification">
                <div id="add_subcat_empty_notificationContent"></div>
           </div>
           
           <div id="add_subcat_container" style="width: 320px; height:60px; padding-top:5px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>
           
        </div>    
    </div>
</jqx-window>
<style type="text/css">
    #subcategory_add {
        -webkit-border-radius: 15px 15px 15px 15px;
        border-radius: 15px 15px 15px 15px;
        border: 5px solid #449bca;
	}
</style>