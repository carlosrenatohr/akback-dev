<div class="gridContentTab">
    <div>
        <a style="outline:0;margin: 10px 2px;" class="btn btn-info" ng-click="newMenuAction()">
            <span class="icon-new"></span>
            New
        </a>
    </div>
    <jqx-grid id="menuGridTable" style="display: none;"
                jqx-settings="menuTableSettings"
                jqx-on-rowdoubleclick="updateMenuAction(event)">
    </jqx-grid>
    <!-- Menu window -->
    <jqx-window jqx-on-close="close()" jqx-settings="addMenuWindowSettings"
                jqx-create="addMenuWindowSettings" class="">
        <div>
            Add new menu
        </div>
        <div>
            <jqx-tabs jqx-width="'100%'" id="menuTopTabs">
                <ul>
                    <li>Menu</li>
                    <li>Styles</li>
                </ul>
                <div>
                    <?php $this->load->view($menu_data_subtab_view); ?>
                </div>
                <div>
                    <?php $this->load->view($menu_styles_subtab_view); ?>
                </div>
            </jqx-tabs>
            <?php $this->load->view($menu_btns); ?>
        </div>
    </jqx-window>
</div>