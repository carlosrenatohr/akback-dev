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
                showCloseButton: false,
                template: (type == 1) ? 'success' : 'error'
            }
        };
    }

})();