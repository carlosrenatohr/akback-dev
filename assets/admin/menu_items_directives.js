/**
 * Created by carlosrenato on 05-23-16.
 */

app.directive('categoryCellGrid', function($rootScope) {
    return {
        restrict: 'E',
        scope: '=',
        templateUrl: '../../assets/admin/templates/category-cell.tmpl.html',
        'link': function(scope, elem, attrs) {
            if (attrs.categoryTitle != undefined) {
                //console.log($scope.menuSelectedWithCategories.grid.round);
                //angular.element(elem).find('.col-md-2').html(attrs.categoryTitle);
            }

        }
    }
});