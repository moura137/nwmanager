/**
 * Controller Login
 */
angular.module('app.controllers')
    .controller('LoginModelCtrl',
        ['$scope', '$rootScope', '$window', '$modalInstance', 'authService', 'OAuth',
        function($scope, $rootScope, $window, $modalInstance, authService, OAuth)
        {
            $scope.user = {
                username: '',
                password: ''
            };

            $rootScope.$on('event:auth-loginConfirmed', function(event, data) {
                $modalInstance.dismiss('cancel');
            });

            $rootScope.$on('event:auth-loginCancelled', function(event, data) {
                $window.location.href = '/login';
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