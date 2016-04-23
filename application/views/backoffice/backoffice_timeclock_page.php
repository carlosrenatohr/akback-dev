<?php
    jqxangularjs();
    jqxthemes();
	$DefaultLocation = $this->session->userdata("storeunique");
?>
<script type="text/javascript">
    var SiteUrl="<?php echo base_url() ?>";
    $("#tabtitle").text("Time Sheet");
</script>
<input type="hidden" ng-model="DefaultLocation" ng-init="DefaultLocation = <?php echo $DefaultLocation; ?>" />
<div ng-cloak class="row-offcanvas row-offcanvas-left ng-cloak">
    <div class="parent-container" ng-controller="akamaiposController as pos">
        <div style="width: 100%;">
                <nav class="navbar navbar-default" role="navigation" style="background:#CCC;">
                    <div class="col-md-12">
                        <div id="toolbar" class="toolbar-list">
                            <ul class="nav navbar-nav navbar-left" style="color: #000;">
                                <li>
                                    <a href="<?php echo base_url("backoffice/dashboard"); $this->session->unset_userdata("token");?>" style="outline:0;">
                                        <span class="icon-32-back"></span>
                                        Home
                                    </a>
                                </li>
                                <li>
                                    <div style="float: left;">
                                      From:
                                      <jqx-date-time-input ng-model="date.rangefrom" jqx-settings="FromdateInputSettings" jqx-format-string="datefromstring"></jqx-date-time-input>
                                    </div>
                                </li>
                                <li>
                                    <div style="float: left;">
                                        To:
                                        <jqx-date-time-input ng-model="date.rangeto" jqx-settings="TodateInputSettings" jqx-format-string="datetostring"></jqx-date-time-input>
                                    </div>
                                </li>
                                <li>
                                    <div style="float: left;">
                                        In Location:
                                        <jqx-combo-box id="location" jqx-settings="comboBoxSettings"></jqx-combo-box>
                                    </div>
                                    <div style="float: left; padding-top:17px; padding-left: 5px; ">
                                        <button class="btn btn-info glyphicon glyphicon-search" type="button" ng-click="DateStoreSearch()"></button>
                                    </div>
                                </li>
                            </ul>
                        </div><!-- /.navbar-collapse -->
                    </div>
                </nav>
          
            <div style="margin-left: 0; padding: 0; overflow: hidden;">
               <!--
                <div>
                    <div style="float: left;">
                        <form class="form-inline">
                            <label for="rg-from">From: </label>
                            <div class="form-group">
                                <jqx-date-time-input ng-model="date.rangefrom" jqx-settings="FromdateInputSettings" jqx-format-string="datefromstring"></jqx-date-time-input>
                            </div>
                        </form>
                    </div>
                    <div style="float: left;">
                        <form class="form-inline">
                            <label for="rg-from">To: </label>
                            <div class="form-group">
                                <jqx-date-time-input ng-model="date.rangeto" jqx-settings="TodateInputSettings" jqx-format-string="datetostring"></jqx-date-time-input>
                            </div>
                        </form>
                    </div>
                    <div style="float: left;">
                        <form class="form-inline">
                            <label for="rg-from"></label>
                            <div class="form-group">
                                <jqx-combo-box jqx-settings="comboBoxSettings"></jqx-combo-box>
                            </div>
                        </form>
                    </div>
                    <div style="float: left; margin-left: 5px;">
                        <form class="form-inline">
                            <button class="btn btn-info" type="button" ng-click="DateStoreSearch()">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            -->
        </div>
    </div>
    <div>
                <jqx-data-table id="table" jqx-watch="disabled" jqx-on-row-click="rowClick(event)" jqx-on-row-double-click="rowDoubleClick(event)" jqx-settings="dataTableSettings"></jqx-data-table>
            </div>

            <edit-time-clock></edit-time-clock>
            <add-time-clock></add-time-clock>
            <delete-time-clock></delete-time-clock>
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