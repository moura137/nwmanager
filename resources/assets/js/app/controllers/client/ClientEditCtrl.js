/**
 * Controller Client Edit
 */
angular.module('app.controllers')
    .controller('ClientEditCtrl', 
        ['$scope', '$rootScope', '$location', '$stateParams', 'Client', 
        function($scope, $rootScope, $location, $stateParams, Client)
        {
            $rootScope.clearError();
            $scope.client = new Client.get({id: $stateParams.id});

            $scope.save = function(){
                if($scope.formClient.$valid)
                {
                    $("button[type=submit]").button('loading');

                    Client.update({id: $scope.client.id}, $scope.client, function(){
                        $location.path('/client');

                    }, function(response){
                        $("button[type=submit]").button('reset');
                        $rootScope.showError(response.status, response.data);
                    });
                }
            };
        }]);