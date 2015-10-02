/**
 * Controller Login
 */
angular.module('app.controllers')
    .controller('LoginModelCtrl',
        ['$scope', '$rootScope', '$window', '$modalInstance', 'httpBuffer', 'OAuth',
        function($scope, $rootScope, $window, $modalInstance, httpBuffer, OAuth)
        {
            $rootScope.logout();

            $scope.user = {
                username: '',
                password: ''
            };

            $scope.login = function() {
                if($scope.formLogin.$valid)
                {
                    OAuth.getAccessToken($scope.user)
                    .then(function(response) {
                        $rootScope.isRefreshingToken = false;
                        httpBuffer.retryAll();
                        $modalInstance.close();
                    })
                    .catch(function(response){
                        $rootScope.showError(response.status, response.data);
                    });
                }
            };

            $scope.cancel = function() {
                httpBuffer.rejectAll();
                $window.location.href = '/login';
                $modalInstance.dismiss('cancel');
            };
        }]);