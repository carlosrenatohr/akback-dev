<script type="text/javascript">
    $(function(){
        changetabtile();
    });
    function changetabtile(){
        $("#tabtitle").html("Dashboard");
    }
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-primary">
                <div class="panel-heading">&nbsp;</div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="icon-handler">
                            <div class="icon">
                                <a href="<?php echo base_url("dashboard/admin/users")?>">
                                    <img width="48" alt="" src="<?php echo base_url()?>assets/img/customer.png">
                                    <span class="mlabel">USER</span>
                                </a>
                            </div>
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
        height: 97px;
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

</style>