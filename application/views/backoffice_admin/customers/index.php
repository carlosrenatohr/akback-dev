<?php
//angularplugins();
//angulartheme_arctic();
//angulartheme_metrodark();
//angulartheme_darkblue();
//jqxplugindatetime();
customerangular();
jqxangularjs();
jqxthemes();
?>
<?php $this->load->view('backoffice_admin/customers/custom_controls'); ?>
<!-- JS-->
<script>
    // --Global Variable
    var SiteRoot = "<?php echo base_url()?>";
    $("#tabtitle").html("Customer administrator");
</script>
<script type="application/javascript" src="../../assets/admin/customer/customer_controller.js"></script>
<script type="application/javascript" src="../../assets/js/angular/jqwidgets/jqxradiobutton.js"></script>
<script type="application/javascript" src="../../assets/js/angular/jqwidgets/jqxnumberinput.js"></script>
<script type="application/javascript" src="../../assets/js/angular/jqwidgets/jqxdatetimeinput.js"></script>
<script type="application/javascript" src="../../assets/js/angular/jqwidgets/jqxcalendar.js"></script>
<script type="application/javascript" src="../../assets/js/angular/jqwidgets/jqxscrollbar.js"></script>
<script type="application/javascript" src="../../assets/js/angular/jqwidgets/jqxlistbox.js"></script>
<!-- -->

<div ng-controller="customerController" ng-cloak>
    <div class="container-fluid">
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                <nav class="navbar navbar-default" role="navigation" style="background:#CCC;">
                    <div class="col-md-12">
                        <div id="toolbar" class="toolbar-list">
                            <ul class="nav navbar-nav navbar-left">
                                <li>
                                    <a href="<?php echo base_url("dashboard/admin") ?>" style="outline:0;">
                                        <span class="icon-32-back"></span>
                                        Back
                                    </a>
                                </li>
                                <li>
                                    <a style="outline:0;" ng-click="openAddCustomerWind()">
                                        <span class="icon-32-new"></span>
                                        New
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="row">
                <jqx-data-table jqx-settings="customerTableSettings"
                                jqx-create="customerTableSettings"
                                jqx-on-row-double-click="">
                </jqx-data-table>
                <jqx-window jqx-settings="addCustomerWindSettings" jqx-on-create="addCustomerWindSettings">
                    <div class="">
                        Add New Customer
                    </div>
                    <div class="">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="row itemQuestionFormContainer">
                                <div style=" width:100%;float:left;">
                                    <?php foreach($customerFields as $row) { ?>
                                        <div style=" float:left; padding:2px; width:650px; ">
                                            <div style="float:left; padding:8px; text-align:right; width:180px; font-weight:bold;">
                                                <?php echo $row['Label'] ?>:
                                            </div>
                                            <div style=" float:left; /*min-width:250px;*/">
                                                <?php setControl($row); ?>
                                                <?php //input_text('customer_' . $row['Field'], true, $row['Label']) ?>
                                            </div>
                                            <?php
                                            if ($row['Required'] > 0)
                                                required_control();
                                            ?>
                                        </div>
                                    <? } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-md-offset-0">
                            <div class="row">
                                <div id="">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button type="button" id=""
                                                    ng-click=""
                                                    class="btn btn-primary" disabled>
                                                Save
                                            </button>
                                            <button type="button" id=""
                                                    ng-click=""
                                                    class="btn btn-warning">
                                                Close
                                            </button>
                                            <button type="button" id=""
                                                    ng-click=""
                                                    class="btn btn-danger" style="overflow:auto;">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </jqx-window>
            </div>

        </div>
    </div>
</div>

<style type="text/css">
    body {
        padding: 0;
        margin: 0;
    }

    div.toolbar-list a {
        cursor: pointer;
        display: block;
        float: left;
        padding: 1px 10px;
        white-space: nowrap;
    }

    div.toolbar-list span {
        display: block;
        float: none;
        height: 32px;
        margin: 0 auto;
        width: 32px;
    }
    .icon-32-new {
        background-image: url("../../assets/img/addnew.png");
    }

    .icon-32-back {
        background-image: url("../../assets/img/back.png");
    }
</style>