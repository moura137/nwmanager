/**
 * Controller Client New
 */
angular.module('app.controllers')
    .controller('ClientNewCtrl', 
        ['$scope', '$rootScope', '$location', 'Client', 
        function($scope, $rootScope, $location, Client)
        {
            $rootScope.clearError();
            $scope.entity = new Client();

            $scope.save = function(){
                if($scope.formClient.$valid)
                {
                    $("button[type=submit]").button('loading');

                    $scope.entity.$save().then(function(){
                        $location.path('/client');

                    }).catch(function(response){
                        $("button[type=submit]").button('reset');
                        $rootScope.showError(response.status, response.data);
                    });
                }
            };
        }]);