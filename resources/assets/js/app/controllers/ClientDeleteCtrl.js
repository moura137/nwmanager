/**
 * Controller Client List
 */
angular.module('app.controllers')
    .controller('ClientDeleteCtrl', ['$scope', '$location', '$routeParams', 'Client', 
        function($scope, $location, $routeParams, Client)
        {
            $scope.entity = new Client.get({id: $routeParams.id});

            $scope.delete = function(){
                $("button.btn-danger").button('loading');
                
                $scope.entity.$delete().then(function(){
                    $location.path('/client');

                }).catch(function(response){
                    $("button.btn-danger").button('reset');
                });
            };
        }
    ]);