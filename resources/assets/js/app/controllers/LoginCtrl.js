/**
 * Controller Login
 */
angular.module('app.controllers')
    .controller('LoginCtrl', 
        ['$scope', '$rootScope', '$window', 'OAuth', 
        function($scope, $rootScope, $window, OAuth)
        {
            $rootScope.logout();
            $scope.error = null;

            $scope.user = {
                username: '',
                password: ''
            };

            $scope.showError = function(status, data) {
                $scope.error = {
                    'error': true,
                    'status': status
                };

                if (data.error_description != undefined) {
                    $scope.error.message = data.error_description;
                } else {
                    $scope.error.message = "Algo estranho aconteceu!";
                }
            };

            $scope.login = function() {
                $scope.error = null;

                if($scope.formLogin.$valid)
                {
                    OAuth.getAccessToken($scope.user)
                    .then(function(response) {
                        return $window.location.href = '/';
                    })
                    .catch(function(response){
                        status = response.status;
                        data = response.data;
                        $scope.showError(status, data);
                    });
                }
            };
        }]);