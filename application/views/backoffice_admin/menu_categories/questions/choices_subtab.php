<div class="row">
    <div class="col-md-6">
        <a style="outline:0;margin: 10px 2px;" class="btn btn-info"
           ng-click="openQuestionItemWin($event)">
            <span class="icon-new"></span>
            New
        </a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <jqx-grid id="_questionItemTable"
                  jqx-settings="questionItemTableSettings"
                  jqx-on-rowdoubleclick="editQuestionItemTable($event)">
        </jqx-grid>
    </div>
</div>
<!-- WINDOWS WITH FORM OF ITEM QUESTIONS -->
<jqx-window jqx-on-close="close()" jqx-settings="questionItemWindowsSettings"
            jqx-create="questionItemWindowsSettings" class="" id="questionItemWindowsSettings">
    <div>
        Add New Question Item
    </div>
    <div>
        <div class="col-md-12 col-md-offset-0">
            <jqx-tabs jqx-width="'100%'" jqx-height="'320px'"
                      id="questionschoicestabsWin">
                <ul>
                    <li>Item</li>
                    <li>Picture</li>
                    <li>Style</li>
                </ul>
                <div>
                    <?php $this->load->view($qChoices_item_subtab); ?>
                </div>
                <div flow-init flow-name="uploaderQI.flow"
                     flow-files-submitted="submitUploadQI($files, $event, $flow)"
                     flow-file-added="fileAddedUpload($file, $event, $flow)"
                     flow-file-success="successUploadQI($file, $message, $flow)">
                    <?php $this->load->view($qChoices_picture_subtab); ?>
                </div>
                <div>
                    <?php $this->load->view($qChoices_style_subtab); ?>
                </div>
            </jqx-tabs>
        </div>
        <?php $this->load->view($qChoices_btns); ?>
    </div>
</jqx-window>
<style>
    #questionItemWindowsSettings {
        max-height: 85%!important;
        max-width: 85%!important;
    }
</style>