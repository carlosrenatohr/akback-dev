<div class="col-md-12 col-md-offset-0">
    <div class="row editItemFormContainer">
        <div style=" width:100%;float:left;margin: 15px 0;">
            <div style="float:left; padding:2px; width:650px;" class="customerForm">
                <div style="float:left; padding:8px; text-align:right; width:200px; font-weight:bold;">Account Status:</div>
                <div style=" float:left; width:400px;">

                    <jqx-drop-down-list id="customer_AccountStatus" class="customer_radio"
                        jqx-auto-drop-down-height="true" jqx-width="'300px'"
                        jqx-selected-index="0" jqx-height="25">
                        <option value="Active" selected>Active</option>
                        <option value="On Hold">On Hold</option>
                        <option value="Suspended">Suspended</option>
                    </jqx-drop-down-list>
                </div>
            </div>
        </div>
        <div style=" width:100%;float:left;margin: 15px 0;">
            <div style="float:left; padding:2px; width:650px; " class="customerForm">
                <div style=" float:left; padding:8px; text-align:right; width:200px; font-weight:bold;">Visit Days:</div>
                <div style=" float:left; width:400px;">
                    <jqx-number-input
                        style='margin-top: 3px;' class="customer-number" jqx-width="'300px'"
                        id="customer_VisitDays" name="customer_VisitDays"
                        jqx-decimal-digits="0" jqx-digits="2" jqx-min="0" jqx-value="7"
                        jqx-input-mode="simple" jqx-spin-buttons="true"
                        jqx-text-align="left"
                    ></jqx-number-input>
                </div>
            </div>
        </div>
    </div>
</div>