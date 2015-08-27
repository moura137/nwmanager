/**
 * Controller Client Delete
 */
angular.module('app.controllers')
    .controller('ClientDeleteCtrl', 
        ['$scope', '$rootScope', '$location', '$routeParams', 'Client', 
        function($scope, $rootScope, $location, $routeParams, Client)
        {
            $rootScope.clearError();
            $scope.entity = new Client.get({id: $routeParams.id});

            $scope.delete = function(){
                $("button.btn-danger").button('loading');
                
                $scope.entity.$delete().then(function(){
                    $location.path('/client');

                }).catch(function(response){
                    $("button.btn-danger").button('reset');
                    $rootScope.showError(response.status, response.data);
                });
            };
        }]);