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
          clientId: 'ANGULAR_APP',
          grantPath: '/auth/token'
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

App.run([
    '$rootScope', '$location', '$modal', 'AuthUser', 'authService', 'OAuthToken', 'OAuth', 'Settings', 'Realtime', 'Notification',
    function($rootScope, $location, $modal, AuthUser, authService, OAuthToken, OAuth, Settings, Realtime, Notification)
    {
        $rootScope.realtimeBuild = false;

        $rootScope.$on('realtime:build', function(event) {
            if (!$rootScope.realtimeBuild) {
                $rootScope.realtimeBuild = true;

                var channelName = 'activities';
                Realtime.connect();
                Realtime.on(channelName, 'NewTaskEvent', function(task) {
                    var msg = '';
                    msg += 'Tarefa "' + task.name + '" Criada, ';
                    if (task.start_date) msg += '\n<br>Inicio "' + task.start_date;
                    msg += '\n<br>No Projeto "' + task.project.name + '"';
                    Notification.success(msg);
                });

                Realtime.on(channelName, 'EditTaskEvent', function(task) {
                    var msg = '';
                    if (task.status == '1') {
                        msg += 'Tarefa "' + task.name + '" Finalizada, ';
                        if (task.start_date) msg += '\n<br>Inicio "' + task.start_date;
                        if (task.due_date) msg += '\n<br>Previsão "' + task.due_date;
                        msg += '\n<br>No Projeto "' + task.project.name + '"';
                        Notification.success(msg);

                    } else {
                        msg += 'Tarefa "' + task.name + '" Alterada, ';
                        if (task.start_date) msg += '\n<br>Inicio "' + task.start_date;
                        if (task.due_date)msg += '\n<br>Previsão "' + task.due_date;
                        msg += '\n<br>No Projeto "' + task.project.name + '"';
                        Notification.warning(msg);
                    }
                });
            }
        });

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
            $rootScope.$emit('realtime:build');
        });

        $rootScope.$on('event:auth-loginCancelled', function(event, data) {
            $rootScope.isLoggedin = false;
            $rootScope.realtimeBuild = false;
        });

        $rootScope.$on('oauth:error', function(event, rejection, deferred)
        {
            if (!$rootScope.isLoggedin) {
                $rootScope.isLoggedin = true;
                $rootScope.realtimeBuild = false;
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

        $rootScope.$on("$stateChangeStart", function(event, nextState, nextParams, fromState, fromParams)
        {
            $rootScope.bgLayout = nextState.bgLayout;

            if (!OAuth.isAuthenticated()) {
                $rootScope.realtimeBuild = false;
                Realtime.disconnect();

                if (nextState.requiredLogin!==false) {
                    $rootScope.bgLayout = fromState.bgLayout;
                    return $location.url('login');
                }
            } else {
                $rootScope.$emit('event:auth-loginConfirmed');
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