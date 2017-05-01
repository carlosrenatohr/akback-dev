<div class="row">
    <div style=" width:500px;float:left;">
        <div style="float:left; padding:2px; width:450px;">
            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">
                Name:
            </div>
            <div style=" float:left; width:320px;">
                <input type="text" class="form-control required-field" id="qt_QuestionName"
                       name="qt_QuestionName" placeholder="Question Name" maxlength="30" autofocus>
            </div>
            <div style="float:left;">
                <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
            </div>
        </div>

        <div style="float:left; padding:2px; width:450px;">
            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">
                Question:
            </div>
            <div style="float:left; width:320px;">
                <input type="text" class="form-control required-field" id="qt_Question"
                       name="qt_Question" placeholder="Question" maxlength="30">
            </div>
            <div style="float:left;">
                <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
            </div>
        </div>

        <!--  SORT -->
        <div style="float:left; padding:2px; width:700px;">
            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">
                Sort:
            </div>
            <div style=" float:left; width:85px;">
                <jqx-number-input
                    style='margin-top: 3px;padding-left: 10px;' class="form-control required-field"
                    id="qt_sort" name="qt_sort"
                    jqx-min="0" jqx-max="99999" jqx-value="1" jqx-decimal-digits="0"
                    jqx-digits="5"
                    jqx-spin-buttons="true" jqx-width="80" jqx-height="25"
                    jqx-input-mode="'simple'" jqx-text-align="'left'"
                ></jqx-number-input>
            </div>
            <div style="float:left;">
                <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
            </div>
            <!--  MIN -->
            <div style="float:left; padding:8px; text-align:right; width:40px; font-weight:bold; ">
                Min:
            </div>
            <div style="float:left; width:70px;">
                <jqx-number-input
                        style='margin-top: 3px;padding-left: 10px;' class="form-control required-field"
                        id="qt_min" name="qt_min"
                        jqx-settings="numberQuestion" jqx-min="0" jqx-max="99999"
                        jqx-value="1"
                        jqx-digits="3"
                ></jqx-number-input>
            </div>
            <div style="float:left;">
                <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
            </div>
            <!--    MAX  -->
            <div style="float:left; padding:8px; text-align:right; width:40px; font-weight:bold;">
                Max:
            </div>
            <div style="float:left; width:70px;">
                <jqx-number-input
                        style='margin-top: 3px;padding-left: 10px;' class="form-control required-field"
                        id="qt_max" name="qt_max"
                        jqx-settings="numberQuestion"
                        jqx-min="0" jqx-max="99999"
                        jqx-value="1"
                        jqx-digits="3"
                ></jqx-number-input>
            </div>
            <div style="float:left;">
                <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
            </div>
        </div>

<!--        <div style=" float:left; padding:2px; width:500px; "></div>-->
<!--        <div style=" float:left; padding:2px; width:500px; "></div>-->
    </div>
</div>