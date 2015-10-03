/**
 * Controller Forgot
 */
angular.module('app.controllers')
    .controller('ForgotCtrl',
        ['$scope', '$rootScope', '$http', 'Settings',
        function($scope, $rootScope, $http, Settings)
        {
            $rootScope.removeToken();

            $scope.user = {
                email: '',
            };

            $scope.send = function() {
                if($scope.formForgot.$valid)
                {
                    $("button[type=submit]").button('loading');

                    $http.post(Settings.apiUrl + '/oauth/forgot', $scope.user)
                        .then(function(response) {
                            window.swal('Email enviado com Sucesso!', null, 'success');
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