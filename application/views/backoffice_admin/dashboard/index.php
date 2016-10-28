<script type="text/javascript">
    $(function(){
        $("#tabtitle").html("Dashboard");
    });
</script>
<link rel="stylesheet" href="../assets/admin/styles.css">
<div class="container-fluid">
    <div class="col-md-12 col-md-offset-0">

    <div class="row">
        <nav class="navbar navbar-default" role="navigation" style="background:#CCC;">
            <!--
            <div class="col-md-3">
                 <a class="navbar-brand" style="color: #146295;"><b>List of Customer:</b></a>
            </div>
            -->
            <div class="col-md-12">
                <div id="toolbar" class="toolbar-list">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="<?php echo base_url("backoffice/dashboard")?>" style="outline:0;">
                                <span class="icon-32-home"></span>
                                Dashboard
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="icon-handler">
                            <div class="icon">
                                <a href="<?php echo base_url("dashboard/admin/users")?>">
                                    <img width="48" alt="" src="<?php echo base_url()?>assets/img/customer.png">
                                    <span class="mlabel">USERS</span>
                                </a>
                            </div>
<!--                            <div class="icon">-->
<!--                                <a href="--><?php //echo base_url("dashboard/admin/menu")?><!--">-->
<!--                                    <img width="48" alt="" src="--><?php //echo base_url()?><!--assets/img/kahon.png">-->
<!--                                    <span class="mlabel">MENU</span>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                            <div class="icon">-->
<!--                                <a href="--><?php //echo base_url("dashboard/admin/customers")?><!--">-->
<!--                                    <img width="48" alt="" src="--><?php //echo base_url()?><!--assets/img/customer.png">-->
<!--                                    <span class="mlabel">CUSTOMERS</span>-->
<!--                                </a>-->
<!--                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    body{
        padding:0;
        margin:0;
    }

    .panel-body {
        background:#F8F8F8;
    }

    div.icon {
        float: left;
        margin-bottom: 15px;
        margin-right: 15px;
        text-align: center;
    }

    div.icon a {
        background-color: #fff;
        background-position: -30px center;
        border: 1px solid #ccc;
        border-radius: 5px;
        color: #565656;
        display: block;
        float: left;
        height: 102px;
        text-decoration: none;
        transition-duration: 0.8s;
        transition-property: background-position, -moz-border-radius-bottomleft, -moz-box-shadow;
        vertical-align: middle;
        width: 108px;
        font-size: smaller;
    }

    div.icon {
        text-align: center;
    }

    .mlabel {
        display: block;
        text-align: center;
        font-weight:bolder;
    }

    a:link {
        color: #025a8d;
        outline: medium none;
        text-decoration: none;
    }

    div.icon img {
        margin: 0 auto;
        padding: 10px 0;
    }

    a, img {
        margin: 0;
        padding: 0;
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
</style>