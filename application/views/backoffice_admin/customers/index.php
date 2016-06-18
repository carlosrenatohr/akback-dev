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
<!-- JS-->
<script>
    // --Global Variable
    var SiteRoot = "<?php echo base_url()?>";
    $("#tabtitle").html("Customer administrator");
</script>
<script type="application/javascript" src="../../assets/admin/customer/customer_controller.js"></script>
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
                                    <a style="outline:0;" ng-click="">
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