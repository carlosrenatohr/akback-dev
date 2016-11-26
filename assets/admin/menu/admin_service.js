/**
 * Created by carlosrenato on 11-03-16.
 */
(function() {
    "use strict";
    angular
        .module('akamaiposApp')
        .service('adminService', AdminService);

    AdminService.$inject = ['$http'];
    function AdminService($http) {
        this.setNotificationSettings = function (type, container) {
            // if (container == undefined)
            //     container = '#notification_container_inventory';
            return {
                width: "auto",
                appendContainer: container,
                opacity: 0.9,
                closeOnClick: true,
                autoClose: true,
                // autoCloseDelay: 1750,
                showCloseButton: false,
                template: (type == 1) ? 'success' : 'error'
            }
        };
        /**
         * @description
         * @param alternative in case of subrows
         * @returns {{}}
         */
        this.loadPagerConfig = function(alternative) {
            var pager = {};
            var ww = $(window).width();
            var wh = $(window).height();
            if (ww != undefined && wh != undefined) {
                pager = function(ww, wh) {
                    var pagesResult = {};
                    // if (ww >= 1280 && wh >= 980) {
                    if (!alternative) {
                        if (wh >= 960) {
                            pagesResult.pageSize = 25;
                            pagesResult.pagesizeoptions = ['5', '15', '25'];
                        }
                        // else if (ww >= 1280 && wh >= 800) {
                        else if (wh >= 800) {
                            pagesResult.pageSize = 20;
                            pagesResult.pagesizeoptions = ['5', '10', '20'];
                        }
                        // else if (ww >= 1024 && wh >= 768) {
                        else if (wh >= 760) {
                            pagesResult.pageSize = 18;
                            pagesResult.pagesizeoptions = ['5', '10', '18'];
                        }
                        else if (wh >= 700) {
                            pagesResult.pageSize = 15;
                            pagesResult.pagesizeoptions = ['5', '10', '15'];
                        }
                        else {
                            pagesResult.pageSize = 10;
                            pagesResult.pagesizeoptions = ['5', '10'];
                        }
                    } else {
                        if (wh >= 960) {
                            pagesResult.pageSize = 25;
                            pagesResult.pagesizeoptions = ['5', '15', '25'];
                        }
                        // else if (ww >= 1280 && wh >= 800) {
                        else if (wh >= 800) {
                            pagesResult.pageSize = 18;
                            pagesResult.pagesizeoptions = ['5', '10', '18'];
                        }
                        // else if (ww >= 1024 && wh >= 768) {
                        else if (wh >= 760) {
                            pagesResult.pageSize = 15;
                            pagesResult.pagesizeoptions = ['5', '10', '15'];
                        }
                        else if (wh >= 700) {
                            pagesResult.pageSize = 12;
                            pagesResult.pagesizeoptions = ['5', '10', '12'];
                        }
                        else {
                            pagesResult.pageSize = 10;
                            pagesResult.pagesizeoptions = ['5', '10'];
                        }
                    }

                    return pagesResult;
                }(ww, wh);
            } else {
                pager = {
                    pageSize: 2,
                    pagesizeoptions: ['2', '10', '15']
                };
            }

            return pager;
        }
    }

})();