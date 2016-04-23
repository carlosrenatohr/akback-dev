<?php
	headerplugins();
	
?>
<script type="text/javascript">
	$(function(){
		$("#tabtitle").text("Reports");
	})
</script>
<div id="wrapper">
	<!-- Navigation -->
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
           <!-- <a class="navbar-brand" href="index.html">SB Admin v2.0</a>-->
            <a href="<?php echo base_url('AK')?>"><img src="<?php echo base_url('assets/img/company_logo.png')?>"></a>
            &nbsp;&nbsp;&nbsp;<strong id="tabtitle" style="font-size:1.3em;"></strong>
        </div>
        <!-- /.navbar-header -->
        <ul class="nav navbar-top-links navbar-right">
        	<li>
            	<a href="<?php echo base_url("backoffice/dashboard")?>" style="outline:0;color:#3C6;">
                    <span class="icon-32-back"></span>
                    Home
                </a>
            </li>
			<li><?php echo "Station: <label style='color:#3C6;'>".$StationName."</label>"; ?></li>
			<li><?php echo "Location: <label style='color:#3C6;'>".$StoreName."</label>"; ?></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li>
                    	<span style="color:#00F; margin-left:5px;">Logged: <?php echo $currentuser ?></span>
                    </li>
                    <li class="divider"></li>
                    <li>
                    	<a href="<?php echo base_url("backoffice/logout") ?>"><i class="fa fa-sign-out fa-fw"></i>Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
        </ul>  
    </nav>
    <div style="margin-bottom: 0; background-color: rgba(50, 50, 50, 0.1); height:40px; width:100%; padding-top:1px;">
    	<div style="float:left; padding:2px;">
        	<a class="btn btn-success" href="<?php echo base_url("backoffice/dashboard")?>" style="outline:0;">
               Home
            </a>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">&nbsp;</div>
        <div class="panel-body">
            <div class="col-md-12">
                <div class="icon-handler">
				<div class="icon">
                        <a href="<?php echo base_url("backoffice/reports/categorysales")?>">
                            <img alt="" src="<?php echo base_url()?>assets/img/report_categorysales.png">
                            <span class="mlabel">Category Sales</span>
                        </a>
                    </div>
					</br>
					<div class="icon">
                        <a href="<?php echo base_url("backoffice/reports/itemsales")?>">
                            <img alt="" src="<?php echo base_url()?>assets/img/report_itemsales.png">
                            <span class="mlabel">Item Sales</span>
                        </a>
                    </div>
					</br>
					<div class="icon">
                        <a href="<?php echo base_url("backoffice/reports/itemreturns")?>">
                            <img alt="" src="<?php echo base_url()?>assets/img/report_itemreturns.png">
                            <span class="mlabel">Item Returns</span>
                        </a>
                    </div>
					</br>
                    <div class="icon">
                        <a href="<?php echo base_url("backoffice/reports/payments")?>">
                            <img alt="" src="<?php echo base_url()?>assets/img/report_payment.png">
                            <span class="mlabel">Payments Received</span>
                        </a>
                    </div>
					</br>
					 <div class="icon">
                        <a href="<?php echo base_url("backoffice/reports/tips")?>">
                            <img alt="" src="<?php echo base_url()?>assets/img/report_tip.png">
                            <span class="mlabel">Tips</span>
                        </a>
                    </div>
					</br>
					<div class="icon">
                        <a href="<?php echo base_url("backoffice/reports/receipts")?>">
                            <img alt="" src="<?php echo base_url()?>assets/img/report_receipts.png">
                            <span class="mlabel">Receipt Totals</span>
                        </a>
                    </div>
					</br>
					 <div class="icon">
                        <a href="<?php echo base_url("backoffice/inventory/valuation/report")?>">
                            <img alt="" src="<?php echo base_url()?>assets/img/report_inventory_value.png">
                            <span class="mlabel">Inventory Value</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
	.panel-primary{
		border-radius: 0;
	}
	
	body{
		overflow:hidden;
	}
</style>