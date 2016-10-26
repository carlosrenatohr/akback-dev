var app = angular.module("akamaiposApp", ['jqwidgets', 'flow'])
    .config(['flowFactoryProvider', function (flowFactoryProvider) {
        flowFactoryProvider.defaults = {
            target: SiteRoot + 'admin/MenuItem/loadPictureItem',
            permanentErrors: [404, 500, 501],
            maxChunkRetries: 1,
            chunkRetryInterval: 5000,
            simultaneousUploads: 3,
            singleFile: true
        };
        flowFactoryProvider.on('catchAll', function (type, e, response, g) {
            // console.log('catchAll', arguments);
        });

        flowFactoryProvider.factory = fustyFlowFactory;
    }]);