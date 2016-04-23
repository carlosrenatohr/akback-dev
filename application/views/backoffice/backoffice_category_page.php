<?php
    jqxangularjs();
    jqxthemes();
?>
<script type="text/javascript">
    var SiteUrl="<?php echo base_url() ?>";
    $("#tabtitle").text("Category");
</script>
<div class="parent-container" ng-controller="akamaiposController as pos">
    <div ng-cloak class="row-offcanvas row-offcanvas-left ng-cloak">
        <div style="width: 100%;">
            <nav class="navbar navbar-default" role="navigation" style="background:#CCC;">
                <div class="col-md-12">
                    <div id="toolbar" class="toolbar-list">
                        <ul class="nav navbar-nav navbar-left" style="color: #000;">
                            <li>
                                <a href="<?php echo base_url("backoffice/dashboard");?>" style="outline:0;">
                                    <span class="icon-32-back"></span>
                                    Home
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div>
            	<jqx-tabs id="tabs" jqx-width="'100%'" jqx-height="'580px'">
                	<ul>
                        <li>Category</li>
                        <li>Sub Category</li>
                    </ul>
                    <div>
                    	<div>
                    		<div id="table"></div>
                             <!--<input style="margin-top: 10px;" value="Remove Filter" id="clearfilteringbutton" type="button" />-->
                        </div>
                    </div>
                    <div>
                    	<div>
                        	<div id="table_subcat"></div>
                        </div>
                    </div>
                </jqx-tabs>
            </div>
        </div>
    </div>
    <input type="hidden" id="userid" ng-model="userid" ng-init="userid=<?php echo $userid; ?>" />
    <add-category></add-category>
    <edit-category></edit-category>
    <delete-category></delete-category>
    <add-sub-category></add-sub-category>
    <edit-sub-category></edit-sub-category>
    <delete-sub-category></delete-sub-category>
</div>
<style type="text/css">
	body{
		margin: 0;
		padding: 0;
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
    .icon-32-new {
        background-image: url("../assets/img/addnew.png");
    }

    .icon-32-back {
        background-image: url("../assets/img/back.png");
    }
</style>            