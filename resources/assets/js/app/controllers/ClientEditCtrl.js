/**
 * Controller Client List
 */
angular.module('app.controllers')
    .controller('ClientEditCtrl', ['$scope', '$location', '$routeParams', 'Client', 
        function($scope, $location, $routeParams, Client)
        {
            $scope.entity = new Client.get({id: $routeParams.id});

            $scope.save = function(){
                if($scope.formClient.$valid)
                {
                    $("button[type=submit]").button('loading');

                    Client.update({id: $scope.entity.id}, $scope.entity, function(){
                        $location.path('/client');
                    });
                }
            };
        }
    ]);