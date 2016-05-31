<div class="" ng-controller="menuItemController">
    <div class="">
        <div class="col-md-2">
            <jqx-tabs jqx-width="'100%'" jqx-height="'100%'" id="jqxTabsMenuItemSection">
                <ul>
                    <li>Menu</li>
                    <li>Items</li>
                </ul>
                <div class="">
                    <div class="">
                        <jqx-list-box jqx-settings="menuListBoxSettings" id="menuListBox"
                                      jqx-on-select="menuListBoxSelecting(event)">
                        </jqx-list-box>
                    </div>
                </div>
                <div class="">
                    <div class="" >
                        <!--                                            <jqx-list-box jqx-settings="menuListBoxSettings" id=""-->
                        <!--                                                          jqx-on-select="">-->
                        <!--                                            </jqx-list-box>-->
                        <div>Type an item to find:</div>
                        <jqx-combo-box
                            jqx-on-select="itemComboboxOnselect(event)"
                            jqx-on-unselect=""
                            jqx-settings="itemsComboboxSettings"></jqx-combo-box>
                        <div class="" style="min-height: 20px;"></div>
                        <div id="selectedItemInfo">
                            {{ selectedItemInfo.Description }}
                        </div>
                    </div>
                </div>
            </jqx-tabs>
        </div>

        <div class="col-md-10 restricter-dragdrop">
            <!--                            <div class="droppingTarget" style="height: 400px;width: 1200px;background-color: rebeccapurple;"></div>-->
        </div>
        <div class="col-md-12">
            <h4 class="col-md-offset-2">Category grid</h4>
            <div class="col-md-offset-2 col-md-10" id="categories-container">
                <category-cell ng-repeat="uno in categoriesByMenu" ng-click="clickCategoryCell($event, uno);$event.stopPropagation();" category-title="{{uno.CategoryName}}">
                </category-cell>
            </div>
        </div>
        <!--  Windows to save data on items   -->
        <jqx-window jqx-on-close="close()" jqx-settings="itemsMenuWindowsSetting"
                    jqx-create="itemsMenuWindowsSetting" class="">
            <div>
                Edit Item
            </div>
            <div>
                <div class="col-md-12 col-md-offset-0">
                    <div class="row editItemFormContainer">
                        <div style=" width:100%;float:left;">
                            <div style="float:left; padding:2px; width:650px;">
                                <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Item:</div>
                                <div style="float:left; width:300px;">
                                    <jqx-combo-box
                                        jqx-on-select=""
                                        jqx-on-unselect=""
                                        jqx-settings="itemsComboboxSettings"
                                        id="editItem_ItemSelected">
                                    </jqx-combo-box>
                                </div>
                            </div>

                            <div style="float:left; padding:2px; width:650px; ">
                                <div style=" float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Label:</div>
                                <div style=" float:left; width:300px;">
                                    <textarea class="form-control required-field" id="editItem_label"
                                              cols="30" rows="3"
                                              name="editItem_label" placeholder="Label">
                                    </textarea>
                                    <!-- <input type="text" class="form-control required-field" id="editItem_label" name="editItem_label" placeholder="Label">-->
                                </div>
                                <div style="float:left;">
                                    <span style="color:#F00; text-align:left; padding:4px; font-weight:bold;">*</span>
                                </div>
                            </div>

                            <div style=" float:left; padding:2px; width:650px; ">
                                <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Sort:</div>
                                <div style=" float:left; width:300px;">
                                    <input type="number" class="form-control required-field"
                                           id="editItem_sort" name="editItem_sort" placeholder="Sort"
                                           step="1" min="1" pattern="\d*">
                                </div>
                            </div>

                            <div style=" float:left; padding:2px; width:650px; ">
                                <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Status:</div>
                                <div style=" float:left; width:300px;">
                                    <select name="editItem_Status" id="editItem_Status">
                                        <option value="1">Enabled</option>
                                        <option value="2">Disabled</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-md-offset-0">
                    <div class="row">
                        <div id="mainButtonsForEdittingItems">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="button" id="saveItemGridBtn" ng-click="saveItemGridBtn()" class="btn btn-primary" disabled>Save</button>
                                    <button	type="button" id="" ng-click="closeItemGridWindows()" class="btn btn-warning">Close</button>
                                    <button	type="button" id="deleteItemGridBtn" ng-click="deleteItemGridBtn()" class="btn btn-danger " style="overflow:auto;">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </jqx-window>
    </div>
</div>