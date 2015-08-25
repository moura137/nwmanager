/**
 * Controller Client List
 */
angular.module('app.controllers')
    .controller('ClientNewCtrl', 
        ['$scope', '$location', 'Client', 
        function($scope, $location, Client)
        {
            $scope.entity = new Client();

            $scope.save = function(){
                if($scope.formClient.$valid)
                {
                    $("button[type=submit]").button('loading');

                    $scope.entity.$save().then(function(){
                        $location.path('/client');
                    });
                }
            };
        }
    ]);