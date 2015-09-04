angular.module('app.factories')
.factory('httpErrorInterceptor', ['$q', '$location', function($q, $location) {
    return {
      responseError: function(response) {
        if(response.status === 404) {
          $location.url('not-found');
        }

        else if(response.status === 403) {
          $location.url('forbidden');
        }
        
        return $q.reject(response);
      }
    };
}])
.config(['$httpProvider', function($httpProvider) {
    $httpProvider.interceptors.push('httpErrorInterceptor');
}]);