angular.module('app.factories')
.factory('OAuthFixInterceptor',
    ['$q', '$rootScope', 'OAuthToken', function($q, $rootScope, OAuthToken) {
    return {
        request: function(config) {
            if (OAuthToken.getAuthorizationHeader()) {
                config.headers = config.headers || {};
                config.headers.Authorization = OAuthToken.getAuthorizationHeader();
            }
            return config;
        },

        responseError: function(rejection) {
            var deferred = $q.defer();

            if (404 === rejection.status) {
                $rootScope.$broadcast('event:http-notfound', rejection);
            }

            else if (403 === rejection.status) {
                $rootScope.$broadcast('event:http-forbidden', rejection);
            }

            else if (400 === rejection.status && rejection.data && ("invalid_request" === rejection.data.error || "invalid_grant" === rejection.data.error)) {
                OAuthToken.removeToken();
            }

            else if (401 === rejection.status && rejection.data && ("access_denied" === rejection.data.error || "invalid_token" === rejection.data.error)) {
                $rootScope.$broadcast("oauth:error", rejection, deferred);
                return deferred.promise;

            } else {
                $rootScope.$broadcast('event:http-error', rejection);
            }

            return $q.reject(rejection);
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
}]);