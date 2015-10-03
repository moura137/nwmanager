/**
 * Controller Login
 */
angular.module('app.controllers')
    .controller('LoginCtrl',
        ['$scope', '$rootScope', '$location', 'OAuth',
        function($scope, $rootScope, $location, OAuth)
        {
            $rootScope.removeToken();

            $scope.user = {
                username: '',
                password: ''
            };

            $scope.login = function() {
                if($scope.formLogin.$valid)
                {
                    OAuth.getAccessToken($scope.user)
                    .then(function(response) {
                        $location.url('/');
                    })
                    .catch(function(response){
                        $rootScope.showError(response.status, response.data);
                    });
                }
            };
        }]);