<div class="col-md-12 inventory_tab" style="padding-top:10px; height: 400px; padding-bottom:5px; background-color: #f5f5f5; border: 1px solid #dddddd;">
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <div class="">
                    <button class="btn btn-primary" id="">
                        <img src="<?php echo base_url("assets/img/kahon.png")?>" />
                    </button>
                    Adjust Quantity
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <div>
                    <jqx-combo-box id="itemstock_locationCbx"
                                   jqx-on-select=""
                                   jqx-settings=""
                    ></jqx-combo-box>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div id="" style="overflow:auto; height:auto;">
                <jqx-grid id="taxesGrid"
                          jqx-settings="stockInventoryGrid"
                          jqx-create="stockInventoryGrid"
                ></jqx-grid>
            </div>
        </div>
    </div>
    <!--    -->
    <!--    -->
    <!--    -->
    <form id="_adjqty" style="display:none; cursor:default;">
        <div class="col-md-11">
            <div class="row" id="_adjustqty">
                <div class="row">
                    <div class="form-group">
                        <label for="inputType" class="col-sm-6 control-label" style="text-align:right">Current Quantity in Stock:</label>
                        <div class="col-sm-3">
                            <div id='_qtyinstock'></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label for="inputType" class="col-sm-6 control-label" style="text-align:right">Quantity to Add or Remove:</label>
                        <div class="col-sm-3">
                            <div id='_qtyaddremove' class="stklevel"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label for="inputType" class="col-sm-6 control-label" style="text-align:right">New Quantity:</label>
                        <div class="col-sm-3">
                            <div id='_newqty'></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label for="inputType" class="col-sm-6 control-label" style="text-align:right">Transaction Date:</label>
                        <div class="col-sm-3">
                            <div id='jqxWidgetDate'></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label for="inputType" class="col-sm-6 control-label" style="text-align:right">Transaction Time:</label>
                        <div class="col-sm-3">
                            <div id='jqxWidgetTime'></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label for="inputType" class="col-sm-6 control-label" style="text-align:right">Location:</label>
                        <div class="col-sm-3">
                            <!--<select id="_location" name="_location" class="stklevel" style="width:100%;"></select>-->
                            <jqx-combo-box id="_location" jqx-on-select="" jqx-settings=""></jqx-combo-box>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-9" align="right">
                                <label for="inputType" class="col-sm-6 control-label" style="text-align:left">Comment:</label>
                            </div>
                            <div class="col-md-9 col-md-offset-1">
                                <textarea id="_qtycomment" class="form-control" cols="5" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" id="stkbtns">
                    <div class="col-md-10" align="right">
                        <button type="button" id="_adjsave" class="btn btn-primary" disabled>Save</button>
                        <button	type="button" id="_adjcancel" class="btn btn-warning">Close</button>
                    </div>
                </div>
                <div class="row">
                    <div id="msgstklevel" style="display:none; margin-top:10px; overflow:auto;">
                        <div class="form-group">
                            <div class="col-sm-12">
                                Would you like to save your changes.
                                <button type="button" id="_stkyes" class="btn btn-primary">Yes</button>
                                <button type="button" id="_stkno" class="btn btn-warning">No</button>
                                <button type="button" id="_stkcancel" class="btn btn-info">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!--    </form>-->
</div>