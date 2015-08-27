/**
 * Controller Client Edit
 */
angular.module('app.controllers')
    .controller('ClientEditCtrl', 
        ['$scope', '$rootScope', '$location', '$routeParams', 'Client', 
        function($scope, $rootScope, $location, $routeParams, Client)
        {
            $rootScope.clearError();
            $scope.entity = new Client.get({id: $routeParams.id});

            $scope.save = function(){
                if($scope.formClient.$valid)
                {
                    $("button[type=submit]").button('loading');

                    Client.update({id: $scope.entity.id}, $scope.entity, function(){
                        $location.path('/client');

                    }, function(response){
                        $("button[type=submit]").button('reset');
                        $rootScope.showError(response.status, response.data);
                    });
                }
            };
        }]);