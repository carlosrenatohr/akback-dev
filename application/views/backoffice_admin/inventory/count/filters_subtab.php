<div class="row" style="margin: 0;">
    <div style="width:600px;float:left;">
        <div id="icount-filters-container" style="max-width: 550px;float: left;">
                <div style="float:left; padding:2px; width:500px;">
                    <div style="float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">Category</div>
                    <div style="float:left; width:320px;">
                        <jqx-combo-box id="icategoryFilter" class="icountField filters"
                                       jqx-settings="icategoryFilterSettings"
                                       jqx-width="300" jqx-show-arrow="true"
                                       jqx-on-change="categoryOnChange($event)"></jqx-combo-box>
                    </div>
                </div>
                <div style="float:left; padding:2px; width:500px;">
                    <div style="float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">SubCategory</div>
                    <div style="float:left; width:320px;">
                        <jqx-combo-box id="isubcategoryFilter" class="icountField filters"
                                       jqx-settings="isubcategoryFilterSettings" jqx-show-arrow="true"
                        ></jqx-combo-box>
                    </div>
                </div>
                <div style="float:left; padding:2px; width:500px;">
                    <div style="float:left; padding:8px; text-align:right; width:125px; font-weight:bold;">Supplier</div>
                    <div style="float:left; width:320px;">
                        <jqx-combo-box id="isupplierFilter" class="icountField filters"
                                       jqx-settings="isupplierFilterSettings" jqx-show-arrow="true"
                        ></jqx-combo-box>
                    </div>
                </div>
        </div>

    </div>
</div>