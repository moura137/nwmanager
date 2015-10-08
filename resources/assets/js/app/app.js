/** APP-JS */
var App = angular.module('App', [
    'app.env.config',
    'app.controllers',
    'app.services',
    'app.factories',
    'app.providers',
    'app.directives',
    'app.filters',
    'app.routes',
    'angularFileUpload',
    'nouislider',
    'ngSanitize',
    'angular-oauth2',
    'http-auth-interceptor',
    'pusher-angular',
    'ui-notification']);

/** Modules **/
angular.module('app.controllers', ['angular-oauth2', 'ngMessages', 'ui.bootstrap', 'ui.bootstrap.tpls', 'mgcrea.ngStrap.navbar']);
angular.module('app.services', ['ngResource']);
angular.module('app.providers', []);
angular.module('app.factories', []);
angular.module('app.directives', []);
angular.module('app.filters', []);
angular.module('app.routes', []);

App.config(['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
}]);

App.config(['$httpProvider', function($httpProvider) {
    $httpProvider.interceptors.splice(0);
    $httpProvider.interceptors.push('OAuthFixInterceptor');

    $httpProvider.defaults.headers.common["Accept"] = 'application/json';
    $httpProvider.defaults.headers.put["Content-type"] = 'application/x-www-form-urlencoded;chartset=utf-8';
    $httpProvider.defaults.headers.post["Content-type"] = 'application/x-www-form-urlencoded;chartset=utf-8';
}]);

/**
 * ----- OAUTH2 ---------
 */
App.config([
    'OAuthProvider', 'OAuthTokenProvider', 'SettingsProvider',
    function(OAuthProvider, OAuthTokenProvider, SettingsProvider)
    {
        OAuthProvider.configure({
          baseUrl: SettingsProvider.config.apiUrl,
          clientId: SettingsProvider.config.clientId,
          clientSecret: SettingsProvider.config.clientSecret,
          grantPath: '/oauth/access-token',
          revokePath: '/oauth/access-token'
        });

        OAuthTokenProvider.configure({
          name: 'token',
          options: {
            secure: SettingsProvider.config.secure,
            path: '/'
          }
        });
    }
]);


App.config(['RealtimeProvider',
    function(RealtimeProvider)
    {
        RealtimeProvider.configure('pusher');
    }]);

App.run([
    '$rootScope', '$location', '$modal', '$timeout', '$pusher', 'AuthUser', 'authService', 'OAuthToken', 'OAuth', 'Settings', 'Realtime',
    function($rootScope, $location, $modal, $timeout, $pusher, AuthUser, authService, OAuthToken, OAuth, Settings, Realtime)
    {
        $rootScope.$on('event:http-notfound', function(event, rejection) {
            $location.url('not-found');
        });

        $rootScope.$on('event:http-forbidden', function(event, rejection) {
            $location.url('forbidden');
        });

        $rootScope.$on('event:http-error', function(event, rejection) {
            if (rejection.status >= 500) {
                $location.url('server-error');
            }
        });

        $rootScope.$on('event:auth-loginConfirmed', function(event, data) {
            $rootScope.isLoggedin = false;
            $rootScope.getAuthUser();
        });

        $rootScope.$on('event:auth-loginCancelled', function(event, data) {
            $rootScope.isLoggedin = false;
        });

        $rootScope.$on('oauth:error', function(event, rejection, deferred)
        {
            if (!$rootScope.isLoggedin) {
                $rootScope.isLoggedin = true;
                Realtime.disconnect();

                OAuth.getRefreshToken().then(function(response){
                    authService.loginConfirmed(response);

                }, function(response) {
                    var modalInstance = $modal.open({
                        templateUrl: Settings.basePath + '/build/views/templates/login-modal.html',
                        controller: 'LoginModelCtrl',
                        size: 'sm',
                        backdrop: 'static'
                    });
                });
            }
            return deferred.promise;
        });

        // $rootScope.$on("pusher-build", function(event)
        // {
        //     if (!window.client) {
        //         window.client = new Pusher(Settings.Pusher.ApiKey);
        //         var pusher = $pusher(window.client);

        //         pusher.connection.bind('state_change', function(states) {
        //           console.log('state_change', states);
        //         });

        //         pusher.connection.bind('connected', function(socket) {
        //           console.log('connected', socket);
        //         });

        //         pusher.connection.bind('error', function(err) {
        //           console.log('ERROR', err);

        //           if( err.data.code === 4004 ) {
        //             console.log('>>> Limite Excedido');
        //           }
        //         });
        //     }
        // });

        $rootScope.$on("$stateChangeStart", function(event, nextState, nextParams, fromState, fromParams)
        {
            $rootScope.bgLayout = nextState.bgLayout;

            if (!OAuth.isAuthenticated()) {
                Realtime.disconnect();

                if (nextState.requiredLogin!==false) {
                    $rootScope.bgLayout = fromState.bgLayout;
                    return $location.url('login');
                }
            } else {
                $rootScope.getAuthUser();
            }
        });

        $rootScope.$on("$stateChangeSuccess", function(event, nextState, nextParams, fromState, fromParams)
        {
            $rootScope.pageTitle = nextState.title || '';
            $rootScope.clearError();
            $(document).trigger("fix-height");
            $('body').scrollTop(0);
        });

        $rootScope.removeToken = function() {
            OAuthToken.removeToken();
        };

        $rootScope.getAuthUser = function() {
            AuthUser.user({}, {}, function(data){
                $rootScope.AuthUser = data;
            });
        };

        $rootScope.error = null;

        var explodeError = function (messages) {
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

            if (!data || data.error_description == undefined) {
                $rootScope.error.messages.push("Algo estranho aconteceu!");

            } else {
                var type = typeof data.error_description;

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