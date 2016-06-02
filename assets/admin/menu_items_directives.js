/**
 * Created by carlosrenato on 05-23-16.
 */

app.directive('categoryCellGrid', function($rootScope) {
    return {
        restrict: 'E',
        scope: '=',
        templateUrl: '../../assets/admin/templates/category-cell.tmpl.html',
        'link': function(scope, elem, attrs) {}
    }
});