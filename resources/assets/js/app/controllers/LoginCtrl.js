/**
 * Controller Login
 */
angular.module('app.controllers')
    .controller('LoginCtrl', 
        ['$scope', '$rootScope', '$window', 'OAuth', 
        function($scope, $rootScope, $window, OAuth)
        {
            $rootScope.clearError();
            $rootScope.logout();

            $scope.user = {
                username: '',
                password: ''
            };

            $scope.login = function() {
                if($scope.formLogin.$valid)
                {
                    $("button[type=submit]").button('loading');
                    
                    OAuth.getAccessToken($scope.user)
                    .then(function(response) {
                        return $window.location.href = '/';
                    })
                    .catch(function(response){
                        $("button[type=submit]").button('reset');
                        $rootScope.showError(response.status, response.data);
                    });
                }
            };
        }]);