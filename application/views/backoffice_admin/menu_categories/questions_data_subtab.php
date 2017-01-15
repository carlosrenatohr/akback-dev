<div class="row">
    <div style=" width:500px;float:left;">
        <div style="float:left; padding:2px; width:450px;">
            <div
                style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">
                Name:
            </div>
            <div style=" float:left; width:300px;">
                <input type="text" class="form-control required-field" id="qt_QuestionName"
                       name="qt_QuestionName" placeholder="Question Name" autofocus>
            </div>
            <div style="float:left;">
                                            <span
                                                style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
            </div>
        </div>

        <div style="float:left; padding:2px; width:450px;">
            <div
                style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">
                Question:
            </div>
            <div style="float:left; width:300px;">
                <input type="text" class="form-control required-field" id="qt_Question"
                       name="qt_Question" placeholder="Question">
            </div>
            <div style="float:left;">
                                            <span
                                                style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
            </div>
        </div>

        <div style="float:left; padding:2px; width:450px;">
            <div
                style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">
                Sort:
            </div>
            <div style=" float:left; width:300px;">
                <jqx-number-input
                    style='margin-top: 3px;padding-left: 10px;' class="form-control required-field"
                    id="qt_sort" name="qt_sort"
                    jqx-settings="numberQuestion"
                    jqx-digits="2"
                ></jqx-number-input>
            </div>
            <div style="float:left;">
                                            <span
                                                style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
            </div>
        </div>

        <div style=" float:left; padding:2px; width:500px; ">
            <div
                style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">
                Minimum:
            </div>
            <div style=" float:left; width:300px;">
                <jqx-number-input
                    style='margin-top: 3px;padding-left: 10px;' class="form-control required-field"
                    id="qt_min" name="qt_min"
                    jqx-settings="numberQuestion"
                    jqx-digits="4"
                ></jqx-number-input>
            </div>
            <div style="float:left;">
                <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
            </div>
        </div>

        <div style=" float:left; padding:2px; width:500px; ">
            <div
                style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">
                Maximum:
            </div>
            <div style=" float:left; width:300px;">
                <jqx-number-input
                    style='margin-top: 3px;padding-left: 10px;' class="form-control required-field"
                    id="qt_max" name="qt_max"
                    jqx-settings="numberQuestion"
                    jqx-digits="4"
                ></jqx-number-input>
            </div>
            <div style="float:left;">
                                                        <span
                                                            style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
            </div>
        </div>
    </div>
</div>