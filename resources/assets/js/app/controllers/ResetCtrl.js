/**
 * Controller Reset
 */
angular.module('app.controllers')
    .controller('ResetCtrl',
        ['$scope', '$rootScope', '$stateParams', '$http', 'Settings',
        function($scope, $rootScope, $stateParams, $http, Settings)
        {
            $rootScope.removeToken();

            $scope.user = null;
            $scope.data = {
                email: $stateParams.email,
                token: $stateParams.token,
                password: '',
                password_confirmation: '',
            };

            $scope.success = false;

            // Busca os Dados
            $http.post(Settings.apiUrl + '/oauth/token', $scope.data)
                .then(function(response) {
                    $scope.user = response.data;
                })
                .catch(function(response){
                    $rootScope.showError(response.status, response.data);
                });

            $scope.send = function() {
                if($scope.formReset.$valid)
                {
                    $("button[type=submit]").button('loading');

                    $http.post(Settings.apiUrl + '/oauth/reset', $scope.data)
                        .then(function(response) {
                            $scope.success = true;
                            $scope.user = null;
                            $rootScope.clearError();
                        })
                        .catch(function(response){
                            $rootScope.showError(response.status, response.data);
                        })
                        .finally(function(){
                            $("button[type=submit]").button('reset');
                        });
                }
            };
        }]);