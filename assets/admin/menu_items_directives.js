/**
 * Created by carlosrenato on 05-23-16.
 */

app.directive('categoryCell', function($rootScope) {
    return {
        restrict: 'E',
        scope: '=',
        'template':
            '<div class="col-md-2 category-cell-grid"></div>',
        'link': function(scope, elem, attrs) {
            if (attrs.categoryTitle != undefined) {
                angular.element(elem).find('.col-md-2').html(attrs.categoryTitle);
            }

        }
    }
});

app.directive('itemsGrid', ['$rootScope', function($rootScope) {
    //var template = '';
    //for(var i = 0;i < $rootScope.grid.rows;i++) {
    //    template += '<div class="row " style="background-color: lightgrey">';
    //    if (Number(diff) === diff && diff % 1 === 0) {
    //        template += '<div class="col-md-offset-1 col-sm-offset-1"></div>';
    //    }
    //    for(var j = 0;j < $rootScope.grid.cols;i++) {
    //        template += '<div class="draggable col-md-' + round + 'col-sm-' +  round + '" style="height: 120px;background-color: ' + ((i%2 == 0) ? 'red': 'green') + ';border: black 1px solid;"' +
    //        'id="draggable-' + (i + (j * 5) + 1) + '">' +
    //        (i + (j * 5) + 1 ) + '</div>';
    //    }
    //    if (Number(diff) === diff && diff % 1 === 0) {
    //        template += '<div class="col-md-offset-1"></div>';
    //    }
    //    template += '</div>';
    //}

    return {
        restrict: 'E',
        scope: '=',
        'template': function($scope) {
            console.log('directive', $scope);
            var template = '';
            if ($scope.grid != undefined) {
            var diff = $scope.grid.diff;
            var round = $scope.grid.round;
            for(var i = 0;i < $scope.grid.rows;i++) {
                template += '<div class="row " style="background-color: lightgrey">';
                if (Number(diff) === diff && diff % 1 === 0) {
                    template += '<div class="col-md-offset-1 col-sm-offset-1"></div>';
                }
                for(var j = 0;j < $scope.grid.cols;i++) {
                    template += '<div class="draggable col-md-' + round + 'col-sm-' +  round + '" style="height: 120px;background-color: ' + ((i%2 == 0) ? 'red': 'green') + ';border: black 1px solid;"' +
                        'id="draggable-' + (i + (j * 5) + 1) + '">' +
                        (i + (j * 5) + 1 ) + '</div>';
                }
                if (Number(diff) === diff && diff % 1 === 0) {
                    template += '<div class="col-md-offset-1"></div>';
                }
                template += '</div>';
            }
            }
            return template;
        }
        ,
        'link': function(scope, elem, attrs) {
            console.log('link', scope.grid);
        }
    }
}]);