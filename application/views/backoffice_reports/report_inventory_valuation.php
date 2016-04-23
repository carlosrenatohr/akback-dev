<?php
	jqxangularjs();
    jqxthemes();
?>
<div id="wrapper">
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
           <!-- <a class="navbar-brand" href="index.html">SB Admin v2.0</a>-->
            <a href="<?php echo base_url('backoffice')?>"><img src="<?php echo base_url('assets/img/company_logo.png')?>"></a>
            &nbsp;&nbsp;&nbsp;<strong id="tabtitle" style="font-size:1.3em;"></strong>
        </div>
        <!-- /.navbar-header -->
        <ul class="nav navbar-top-links navbar-right">
        	<li><a href="<?php echo base_url("backoffice/reports")?>" style="outline:0;">
                    <span class="icon-32-back"></span>
                    Reports
                </a>
            </li>
        	<li>Station: <span style='color:#3C6;' id="station"></span></li>
            <li>Location: <span style='color:#3C6;' id="location"></span></li>
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
            </li>
        </ul>  
    </nav>
    <div style="margin-bottom: 0; background-color: rgba(50, 50, 50, 0.1); height:40px; width:100%; padding-top:3px;">
    	<div style="float:left; padding:2px;">
        	<a class="btn btn-success" href="<?php echo base_url("backoffice/dashboard")?>" style="outline:0;">
               Home
            </a>
        </div>
        <div style="float:left; padding:2px;">
        	<a class="btn btn-primary" style="outline:0;" href="<?php echo base_url("backoffice/reports")?>">
               Reports
            </a>
        </div>
    </div>
    <div style="margin-bottom: 0; background-color: rgba(50, 50, 50, 0.1); height:35px; width:100%; padding-top:3px;">
    	<ul class="nav navbar-top-links navbar-left">
        	<li><div id='comboboxStore'></div></li>
            <li><div id='dateInput'></div></li>
            <li><div style="float:left;"><button id="searchButton" style="cursor:pointer;"><span class="glyphicon glyphicon-search"></span></button></div></li>
            <li><div style="float:left;"><button id="exportButton" style="cursor:pointer;"><span class="glyphicon glyphicon-export"></span></button></div></li>
            <li><div style="float:left;"><button id="downloadButton" style="cursor:pointer;"><span class="glyphicon glyphicon-download"></span></button></div></li>
        </ul>
    </div>
	<jqx-data-table id="dataTable1" jqx-settings="gridSettings1" ng-show="gridSettingPreLoad"></jqx-data-table>
    <jqx-data-table id="dataTable2" jqx-settings="gridSettings2" ng-show="gridSettingOnSearch"></jqx-data-table>
</div>
<input type="hidden" id="DecimalsQuantity" value="<?php echo $DecimalsQuantity ?>" />
<input type="hidden" id="DecimalsPrice" value="<?php echo $DecimalsPrice ?>" />
<input type="hidden" id="DecimalsCost" value="<?php echo $DecimalsCost ?>" />
<input type="hidden" id="DecimalsTax" value="<?php echo $DecimalsTax ?>" />
<input type="hidden" id="store" value="<?php echo $store ?>" />
<input type="hidden" id="curdate" value="<?php echo $currentdate?>" />
<input type="hidden" id="invdownload" value="<?php echo $file?>" />
<style type="text/css">
	body{
		overflow:hidden;
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
</style>
