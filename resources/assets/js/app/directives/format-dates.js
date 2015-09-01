angular.module('app.directives')
.directive('formatDate', ['$filter', function($filter) {
    return {
        restrict: 'A',
        require: 'ngModel',
        link: function(scope, element, attrs, ngModelController) {
            ngModelController.$parsers.push(function(data) {
                var parts = data.split("/");
                var dt = new Date(parseInt(parts[2], 10), (parseInt(parts[1], 10)-1), parseInt(parts[0], 10));
                var day = ("0" + dt.getDate()).slice(-2);
                var month = ("0" + (dt.getMonth() + 1)).slice(-2);
                return dt.getFullYear() + '-' + month + "-" + day;
            });

            ngModelController.$formatters.push(function(data) {
                return $filter('formatDate')(data);
            });
        }
    }
}]);