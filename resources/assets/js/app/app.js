/** APP-JS */
var App = angular.module('App', ['app.controllers', 'ngRoute', 'angular-oauth2']);

/** Modules **/
angular.module('app.controllers', ['angular-oauth2', 'ngMessages']);

/** Define Tags **/
App.config(function($interpolateProvider) {
  $interpolateProvider.startSymbol('[[');
  $interpolateProvider.endSymbol(']]');
});
 
/** Define Requisição Ajax **/
App.config(['$httpProvider', function($httpProvider) {
    $httpProvider.defaults.headers.common["Accept"] = 'application/json';
}]);

/**
 * ------ Routes ------------
 */
App.config(['$routeProvider',
    function($routeProvider) { $routeProvider
        .when('/login', {
            templateUrl: 'build/views/login.html',
            controller: 'LoginCtrl',
        })
        
        .when('/home', {
            templateUrl: 'build/views/home.html',
            controller: 'HomeCtrl',
        })
        
        .when('/404', {
            templateUrl: 'build/views/404.html',
            controller: 'ErrorCtrl'
        })

        .otherwise({
            redirectTo: '/404'
        });
    }
]);

/**
 * ----- OAUTH2 ---------
 */
App.config(['OAuthProvider', 'OAuthTokenProvider', function(OAuthProvider, OAuthTokenProvider) {
    OAuthProvider.configure({
      baseUrl: '/',
      clientId: 'ANGULAR_APP',
      clientSecret: 'bwrc6ZJuT5Z99sn6a3cH', // optional
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
}]);

App.run(['$rootScope', '$window', '$http', 'OAuthToken', 'OAuth', function($rootScope, $window, $http, OAuthToken, OAuth) {
    $rootScope.$on('oauth:error', function(event, rejection, deferred) {

      // Refresh token when a `invalid_token` error occurs.
      if ('access_denied' === rejection.data.error) {
        OAuth.getRefreshToken().then(function(response){
            
            $http(rejection.config).then(function(resp) {
                deferred.resolve(resp);
            },function(resp) {
                deferred.reject();
            });

        }, function(response) {
            deferred.reject();
        });

        return deferred.promise;

      } else {
          // Redirect to `/login` with the `error_reason`.
          return $window.location.href = '/#/login?error_reason=' + rejection.data.error;
      }
    });

    $rootScope.logout = function() {
        OAuthToken.removeToken();
    };

    $rootScope.$on("$routeChangeStart", function(event, nextRoute, currentRoute) {
        if (nextRoute.access === undefined || nextRoute.access.requiredAuth===true) {
            // $http.get('/oauth/user').then(function(data){
            //     $rootScope.authUser = data;
            // });
        }
    });
}]);