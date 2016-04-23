<?php
    jqxangularjs();
    jqxthemes();
?>
<div class="splash" ng-cloak="">
    <p>Loading</p>
</div>
<div class="row-offcanvas row-offcanvas-left ng-cloak">
    <div class="container-fluid">
        <div class="row">
            <nav class="navbar navbar-default" role="navigation" style="background:#CCC;">
                <div class="col-md-12">
                    <div id="toolbar" class="toolbar-list" style="padding: 5px;">
                        <ul class="nav navbar-nav navbar-left">
                            <li>
                                <a ng-click="HomeScreen()" style="outline:0; cursor: pointer;">
                                    <span class="icon-32-back"></span>
                                    Home
                                </a>
                            </li>
                            <li>
                                <a ng-click="CreateNew()" style="outline:0; cursor: pointer;" id="_addnew">
                                    <span class="icon-32-new"></span>
                                    New
                                </a>
                            </li>
                            <li>
                                <button class="btn btn-primary btn-lg" ng-click="PurchaseHeaderShowAll()">Show All</button>
                            </li>
                            <li>
                                <button class="btn btn-info btn-lg" ng-click="OnHoldStatus()">On Hold</button>
                            </li>
                            <li>
                                <button class="btn btn-success btn-lg" ng-click="CompleteStatus()">Complete</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="row">
            <jqx-data-table id="receiving" jqx-settings="receivingGridSettings" jqx-on-row-double-click="receivingRowDoubleClick(event)"></jqx-data-table>
        </div>
    </div>
    <input type="hidden" ng-model="userid" ng-init="userid='<?php echo $userid?>'">
    <input type="hidden" ng-model="storeid" ng-init="storeid='<?php echo $storeunique?>'">
    <input type="hidden" ng-model="purchaseheader.unique">
    <!--<addnew-purchase></addnew-purchase>-->
    <inventory-purchase></inventory-purchase>
    <podel-confirmation></podel-confirmation>
</div>
<style type="text/css">
    body{
        padding:0;
        margin:0;
        overflow: hidden;
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

    .icon-32-back {
        background-image: url("../assets/img/back.png");
    }

    .icon-32-new {
        background-image: url("../assets/img/addnew.png");
    }

    [ng-cloak].splash {
        display: block !important;
    }

    .splash {
        background-color: #428bca;
        display: none;
    }

</style>