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

            scope.clickCategoryCell = function(row) {
                console.log(row);
                angular.element(elem).find('.col-md-2').attr('CategoryID', row.Unique);
                $rootScope.grid = {'cols': row.Column, 'rows': row.Row};
                scope.grid = {'cols': row.Column, 'rows': row.Row};
            }

        }
    }
});

app.directive('itemsGrid', ['$rootScope', function($rootScope) {
    var diff = (12 / $rootScope.grid.cols);
    var round = Math.floor(diff);
    var template = '';
    for(var i = 0;i < $rootScope.grid.rows;i++) {
        template += '<div class="row " style="background-color: lightgrey">';
        if (Number(diff) === diff && diff % 1 === 0) {
            template += '<div class="col-md-offset-1 col-sm-offset-1"></div>';
        }
        for(var j = 0;j < $rootScope.grid.cols;i++) {
            template += '<div class="draggable col-md-' + round + 'col-sm-' +  round + '" style="height: 120px;background-color: ' + ((i%2 == 0) ? 'red': 'green') + ';border: black 1px solid;"' +
            'id="draggable-' + (i + (j * 5) + 1) + '">' +
            (i + (j * 5) + 1 ) + '</div>';
        }
        if (Number(diff) === diff && diff % 1 === 0) {
            template += '<div class="col-md-offset-1"></div>';
        }
        template += '</div>';
    }

    return {
        restrict: 'E',
        scope: '=',
        'template': template,
        'link': function(scope, elem, attrs) {
            console.log($rootScope.grid);
            console.log(scope.grid);


        }
    }
}]);