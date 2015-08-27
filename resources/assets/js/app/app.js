/** APP-JS */
var App = angular.module('App', [
    'app.env.config', 
    'app.controllers', 
    'app.services', 
    'app.factories',
    'app.filters',
    'ngRoute', 
    'angular-oauth2',
    'angularjs-gravatardirective']);

/** Modules **/
angular.module('app.controllers', ['angular-oauth2', 'ngMessages']);
angular.module('app.services', ['ngResource']);
angular.module('app.factories', []);
angular.module('app.filters', []);

/**
 * ------ Providers ------------
 */
App.provider('Settings', function(API_URL, CLIENT_ID, CLIENT_SECRET){
    var config = {
        baseUrl: API_URL,
        clientId: CLIENT_ID,
        clientSecret: CLIENT_SECRET
    };

    return {
        config: config,
        $get: function(){
            return config;
        }
    };
});


/**
 * ------ Routes ------------
 */
App.config(['$routeProvider',
    function($routeProvider) { $routeProvider
        .when('/client', {
            templateUrl: 'build/views/client/list.html',
            controller: 'ClientListCtrl'
        })

        .when('/client/:id/show', {
            templateUrl: 'build/views/client/show.html',
            controller: 'ClientShowCtrl'
        })

        .when('/client/new', {
            templateUrl: 'build/views/client/new.html',
            controller: 'ClientNewCtrl'
        })

        .when('/client/:id/edit', {
            templateUrl: 'build/views/client/edit.html',
            controller: 'ClientEditCtrl'
        })

        .when('/client/:id/delete', {
            templateUrl: 'build/views/client/delete.html',
            controller: 'ClientDeleteCtrl'
        })

        .when('/user', {
            templateUrl: 'build/views/user/list.html',
            controller: 'UserListCtrl'
        })

        .when('/user/new', {
            templateUrl: 'build/views/user/new.html',
            controller: 'UserNewCtrl'
        })

        .when('/user/:id/edit', {
            templateUrl: 'build/views/user/edit.html',
            controller: 'UserEditCtrl'
        })

        .when('/user/:id/delete', {
            templateUrl: 'build/views/user/delete.html',
            controller: 'UserDeleteCtrl'
        })

        .when('/', {
            templateUrl: 'build/views/home.html',
            controller: 'HomeCtrl'
        })

        .when('/not-found', {
            templateUrl: 'build/views/404.html',
            controller: 'ErrorCtrl',
            access: { requiredLogin: false }
        })

        .when('/forbidden', {
            templateUrl: 'build/views/403.html',
            controller: 'ErrorCtrl',
            access: { requiredLogin: false }
        })

        .otherwise({
            redirectTo: '/not-found',
            access: { requiredLogin: false }
        });
    }
]);

App.config([
    '$httpProvider', '$interpolateProvider',
    function($httpProvider, $interpolateProvider) {
        $httpProvider.defaults.headers.common["Accept"] = 'application/json';

        $interpolateProvider.startSymbol('[[');
        $interpolateProvider.endSymbol(']]');
    }
]);

/**
 * ----- OAUTH2 ---------
 */
App.config([
    'OAuthProvider', 'OAuthTokenProvider', 'SettingsProvider',
    function(OAuthProvider, OAuthTokenProvider, SettingsProvider)
    {
        OAuthProvider.configure({
          baseUrl: SettingsProvider.config.baseUrl,
          clientId: SettingsProvider.config.clientId,
          clientSecret: SettingsProvider.config.clientSecret,
          grantPath: '/oauth/access-token',
          revokePath: '/oauth/access-token'
        });

        OAuthTokenProvider.configure({
          name: 'token',
          options: {
            secure: false,
            path: '/'
          }
        });
    }
]);

App.run([
    '$rootScope', '$window', '$http', 'httpBuffer', 'OAuthToken', 'OAuth', 'Settings', 
    function($rootScope, $window, $http, httpBuffer, OAuthToken, OAuth, Settings)
    {
        $rootScope.refreshToken = false;

        $rootScope.$on('oauth:error', function(event, rejection, deferred) {
            
            // Refresh token when a `invalid_token` error occurs.
            if ('access_denied' === rejection.data.error)
            {
                httpBuffer.add(rejection.config, deferred);

                if (!$rootScope.refreshToken) {
                    $rootScope.refreshToken = true;

                    OAuth.getRefreshToken().then(function(response)
                    {
                        httpBuffer.retryAll();
                        $rootScope.refreshToken = false;

                    }, function(response) {
                        httpBuffer.rejectAll();
                        $rootScope.refreshToken = false;
                    });
                }

                return deferred.promise;

            } else {
                httpBuffer.clear();
                return $window.location.href = '/login?error_reason=' + rejection.data.error;
            }
        });

        $rootScope.$on("$routeChangeStart", function(event, nextRoute, currentRoute) {
            $rootScope.clearError();
            $rootScope.getAuthUser();
            
            if ((nextRoute.access === undefined || nextRoute.access.requiredAuth===true) && !OAuth.isAuthenticated()) {
                return $window.location.href = '/login?error_reason=' + rejection.data.error;
            }
        });

        $rootScope.logout = function() {
            OAuthToken.removeToken();
        };

        $rootScope.getAuthUser = function() {
            if (OAuth.isAuthenticated())
            {
                $http.get(Settings.baseUrl + '/oauth/user').then(function(response){
                    $rootScope.AuthUser = response.data;
                });
            }
        };

        $rootScope.error = null;

        function explodeError(messages) {
            angular.forEach(messages, function(value, key) {
                if (typeof value == 'object') {
                    explodeError(value);
                } else {
                    $rootScope.error.messages.push(value);
                }
            });
        }

        $rootScope.clearError = function() {
            $rootScope.error = null;
        }

        $rootScope.showError = function(status, data) {
            $rootScope.error = {
                'error': true,
                'status': status,
                'messages': []
            };

            var type = typeof data.error_description;

            if (data.error_description == undefined) {
                $rootScope.error.messages.push("Algo estranho aconteceu!");

            } else {
                switch(type) {
                    default:
                    case 'string':
                    case 'number':
                        $rootScope.error.messages.push(data.error_description);
                    break;
                    case 'object':
                        explodeError(data.error_description);
                    break;
                }
            }
        };
    }
]);