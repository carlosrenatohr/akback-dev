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
                                <a>
                                    <img width="48" alt="" src="<?php echo base_url()?>assets/img/pos.png">
                                    <span class="mlabel">POS</span>
                                </a>
                            </div>
                            <div class="icon">
                                <a href="<?php echo base_url("dashboard/admin/customers")?>">
                                    <img width="48" alt="" src="<?php echo base_url()?>assets/img/backoffice/Customer.png">
                                    <span class="mlabel">CUSTOMER</span>
                                </a>
                            </div>
                            <div class="icon">
                                 <a href="<?php echo base_url()."backoffice/supplier"?>">
                                    <img width="48" alt="" src="<?php echo base_url()?>assets/img/handtruck.png">
                                    <span class="mlabel">SUPPLIER</span>
                                </a>
                            </div>
<!--                            <div class="icon">-->
<!--                                <a href="--><?php //echo base_url("backoffice/brand")?><!--">-->
<!--                                    <img width="48" alt="" src="--><?php //echo base_url()?><!--assets/img/brand.png">-->
<!--                                    <span class="mlabel">BRAND</span>-->
<!--                                </a>-->
<!--                            </div>-->
                            <div class="icon">
                                <a href="<?php echo base_url("backoffice/category")?>">
                                    <img width="48" alt="" src="<?php echo base_url()?>assets/img/category.png">
                                    <span class="mlabel">CATEGORY</span>
                                </a>
                            </div>
                            <div class="icon">
                                <a href="<?php echo base_url("dashboard/items")?>">
                                    <img width="48" src="<?php echo base_url()?>assets/img/report_itemreturns.jpg">
                                    <span class="mlabel">ITEMS</span>
                                </a>
                            </div>
                            <div class="icon">
                                <a href="<?php echo base_url("backoffice/inventory")?>">
                                    <img width="48" src="<?php echo base_url()?>assets/img/inventory.png">
                                    <span class="mlabel">INVENTORY</span>
                                </a>
                            </div>

                            <div class="icon">
                                <a href="<?php echo base_url("dashboard/admin/menu")?>">
                                    <img width="48" src="<?php echo base_url()?>assets/img/kahon.png">
                                    <span class="mlabel">MENU</span>
                                </a>
                            </div>
                            
                            <div class="icon">
                                <a href="<?php echo base_url("backoffice/receiving")?>">
                                    <img width="48" alt="" src="<?php echo base_url()?>assets/img/puchase-orders.png">
                                    <span class="mlabel">PURCHASING</span>
                                </a>
                            </div>
                            <div class="icon">
                            	<?php $data["token"] = 1; ?>
                                <a href="<?php echo base_url("backoffice/timeclock");?>">
                                    <img width="48" alt="" src="<?php echo base_url()?>assets/img/Clock.png">
                                    <span class="mlabel">TIME CLOCK</span>
                                </a>
                            </div>
                            <div class="icon">
                                <a href="<?php echo base_url("backoffice/reports")?>">
                                    <img width="48" alt="" src="<?php echo base_url()?>assets/img/reports.png">
                                    <span class="mlabel">REPORTS</span>
                                </a>
                            </div>
							<div class="icon">
                                <a href="<?php echo base_url("dashboard/admin")?>">
                                    <img width="48" alt="" src="<?php echo base_url()?>assets/img/administration.png">
                                    <span class="mlabel">ADMINISTRATION</span>
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
