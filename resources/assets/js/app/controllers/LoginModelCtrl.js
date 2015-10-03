/**
 * Controller Login
 */
angular.module('app.controllers')
    .controller('LoginModelCtrl',
        ['$scope', '$rootScope', '$location', '$modalInstance', 'authService', 'OAuth',
        function($scope, $rootScope, $location, $modalInstance, authService, OAuth)
        {
            $rootScope.removeToken();

            $scope.user = {
                username: '',
                password: ''
            };

            $rootScope.$on('event:auth-loginConfirmed', function(event, data) {
                $modalInstance.dismiss('cancel');
            });

            $rootScope.$on('event:auth-loginCancelled', function(event, data) {
                $modalInstance.dismiss('cancel');
                $location.url('/login');
            });

            $scope.login = function() {
                if($scope.formLogin.$valid)
                {
                    OAuth.getAccessToken($scope.user)
                    .then(function(response) {
                        authService.loginConfirmed(response);
                    })
                    .catch(function(response){
                        $rootScope.showError(response.status, response.data);
                    });
                }
            };

            $scope.cancel = function() {
                authService.loginCancelled()
            };
        }]);