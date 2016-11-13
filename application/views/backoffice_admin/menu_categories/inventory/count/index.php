<script type="text/javascript">
    $("#tabtitle").text("Items Count");
</script>
<script type="application/javascript" src="<?php echo base_url() ?>assets/admin/menu/item_count_controller.js"></script>
<script type="application/javascript" src="<?php echo base_url() ?>assets/admin/menu/admin_service.js"></script>

<div class="container-fluid" ng-controller="itemCountController">

    <div class="row">
        <nav class="navbar navbar-default" role="navigation" style="background:#CCC;">
            <div class="col-md-12">
                <div id="toolbar" class="toolbar-list">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="<?php echo base_url("backoffice/dashboard") ?>" style="outline:0;">
                                <span class="icon-32-home"></span>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("dashboard/items") ?>" style="outline:0;">
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
        <div class="col-md-12">
            <jqx-grid id="icountGrid"
                      jqx-settings="icountGridSettings"
                      jqx-create="icountGridSettings"
                      jqx-on-rowdoubleclick=""
            ></jqx-grid>
        </div>

    </div>
</div>