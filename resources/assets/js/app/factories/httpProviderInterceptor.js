angular.module('app.factories')
.factory('httpProviderInterceptor', ['$q', '$location', function($q, $location) {
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
          if (!angular.isObject(data)) {
            data = JSON.parse(data);
          }

          if (data.hasOwnProperty('data') && !data.hasOwnProperty('meta')) {
            response.data = data.data;
          }
        }
        
        return response;
      }
    };
}])
.config(['$httpProvider', function($httpProvider) {
    $httpProvider.interceptors.push('httpProviderInterceptor');
    $httpProvider.defaults.headers.common["Accept"] = 'application/json';
    $httpProvider.defaults.headers.put["Content-type"] = 'application/x-www-form-urlencoded;chartset=utf-8';
    $httpProvider.defaults.headers.post["Content-type"] = 'application/x-www-form-urlencoded;chartset=utf-8';
}]);