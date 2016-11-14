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
                            <a style="outline:0;" ng-click="openIcount()">
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
            <jqx-window jqx-on-close="close()" jqx-settings="icountWindowSettings"
                        jqx-create="icountWindowSettings" id="">
                <div >
                    Item Count | Details
                </div>
                <div >
                    <jqx-tabs jqx-width="'100%'"
                              jqx-on-selecting=""
                              id="">
                        <ul>
                            <li>Brand</li>
                            <li id="secondBrandTab">Info</li>
                        </ul>
                        <!-- Brand subtab -->
                        <div class="">
<!--                            --><?php //$this->load->view($brand_subtab); ?>
                        </div>
                        <!-- Info subtab -->
                        <div class="">
<!--                            --><?php //$this->load->view($info_subtab); ?>
                        </div>
                    </jqx-tabs>

<!--                    <!-- Main buttons before saving item on grid -->-->
<!--                    <div class="col-md-12 col-md-offset-0">-->
<!--                        <div class="row">-->
<!--                            <div id="mainicountBtns" class="">-->
<!--                                <div class="form-group">-->
<!--                                    <div class="col-sm-12">-->
<!--                                        <button type="button" id="saveicountBtn" ng-click=""-->
<!--                                                class="btn btn-primary" disabled>-->
<!--                                            Save-->
<!--                                        </button>-->
<!--                                        <button type="button" ng-click="" class="btn btn-warning">Close</button>-->
<!--                                        <button type="button" id="deleteicountBtn" ng-click="" class="btn btn-danger"-->
<!--                                                style="overflow:auto;display: none;">Delete-->
<!--                                        </button>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!--                    <!-- Prompt before saving item on grid -->-->
<!--                    <div class="col-md-12 col-md-offset-0">-->
<!--                        <div class="row">-->
<!--                            <div id="closeicountBtns" class="" style="display: none">-->
<!--                                <div class="form-group">-->
<!--                                    <div class="col-sm-12">-->
<!--                                        <div class="message">Do you want to save your changes?</div>-->
<!--                                        <button type="button" ng-click="" class="btn btn-primary">Yes</button>-->
<!--                                        <button type="button" ng-click="" class="btn btn-warning">No</button>-->
<!--                                        <button type="button" ng-click="" class="btn btn-info">Cancel</button>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!--                    <!-- Prompt before delete an item on grid -->-->
<!--                    <div class="col-md-12 col-md-offset-0">-->
<!--                        <div class="row">-->
<!--                            <div id="deleteicountBtns" class="" style="display: none">-->
<!--                                <div class="form-group">-->
<!--                                    <div class="col-sm-12">-->
<!--                                        Do you really want to delete it?-->
<!--                                        <button type="button" ng-click="deleteicount(0)" class="btn btn-primary">Yes</button>-->
<!--                                        <button type="button" ng-click="deleteicount(1)" class="btn btn-warning">No</button>-->
<!--                                        <button type="button" ng-click="deleteicount(2)" class="btn btn-info">Cancel</button>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <!-- NOTIFICATIONS AREA -->-->
<!--                    <div class="col-md-12 col-md-offset-0">-->
<!--                        <div class="row">-->
<!--                            <jqx-notification jqx-settings="icountSuccessMsg" id="icountSuccessMsg">-->
<!--                                <div id="msg"></div>-->
<!--                            </jqx-notification>-->
<!--                            <jqx-notification jqx-settings="icountErrorMsg" id="icountErrorMsg">-->
<!--                                <div id="msg"></div>-->
<!--                            </jqx-notification>-->
<!--                            <div id="notification_container_icount"-->
<!--                                 style="width: 100%; height:60px; margin-top: 15px; background-color: #F2F2F2; border: 1px dashed #AAAAAA; overflow: auto;"></div>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
            </jqx-window>
        </div>

    </div>
</div>