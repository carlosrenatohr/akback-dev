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