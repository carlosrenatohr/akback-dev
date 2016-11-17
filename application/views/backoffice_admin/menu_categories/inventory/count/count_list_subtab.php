<div class="row" style="margin: 0;">
    <div style="width:100%;float:left; ">

        <div id="listGridContainer">
            <jqx-grid id="icountlistGrid"
                      jqx-settings="icountlistGridSettings"
                      jqx-create="icountlistGridSettings"
                      jqx-on-rowdoubleclick="editIcountlist(e)"
            ></jqx-grid>
        </div>

        <div id="buildListBtns" style="float:left; padding:2px; width:450px; margin: 10px;">
            <div style="float:left; width:320px;">
                <button id="buildCountListBtn" class="btn btn-success"
                        data-loc="" data-list=""
                        ng-click="buildCountList()">Build List</button>
            </div>
        </div>

    </div>
</div>