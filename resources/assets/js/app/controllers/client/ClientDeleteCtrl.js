/**
 * Controller Client Delete
 */
angular.module('app.controllers')
    .controller('ClientDeleteCtrl', 
        ['$scope', '$rootScope', '$location', '$stateParams', 'Client', 
        function($scope, $rootScope, $location, $stateParams, Client)
        {
            $rootScope.clearError();
            $scope.client = new Client.get({id: $stateParams.id});

            $scope.delete = function(){
                $("button.btn-danger").button('loading');
                
                $scope.client.$delete().then(function(){
                    $location.path('/client');

                }).catch(function(response){
                    $("button.btn-danger").button('reset');
                    $rootScope.showError(response.status, response.data);
                });
            };
        }]);