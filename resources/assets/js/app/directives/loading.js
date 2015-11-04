angular.module('app.directives')
.directive('loading', ['$http', function ($http) {
    return {
      restrict: 'A',
      link: function (scope, element, attrs) {
        scope.isLoading = function () {
          var isLoading = false;
          $http.pendingRequests.forEach(function(object,b){
            if (!object.params || !object.params.hasOwnProperty('typeahead')) {
              isLoading = true;
              return;
            }
          });

          return isLoading;
        };

        scope.$watch(scope.isLoading, function (value) {
          if (value) {
            element.removeClass('ng-hide');
          } else {
            element.addClass('ng-hide');
          }
        });
      }
    };
}]);