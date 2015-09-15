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
      },

      response : function(response) {
        var data = response.data;
        var headers = response.headers();

        if (headers['content-type'] == 'application/json' || headers['content-type'] == 'text/json') {
          if (data.hasOwnProperty('data')) {
            data = data.data;
          }
          response.data = data;
        }
        
        return response;
      }
    };
}])
.config(['$httpProvider', function($httpProvider) {
    $httpProvider.interceptors.push('httpErrorInterceptor');
}]);