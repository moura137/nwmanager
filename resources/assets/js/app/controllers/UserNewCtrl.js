/**
 * Controller User New
 */
angular.module('app.controllers')
    .controller('UserNewCtrl', 
        ['$scope', '$rootScope', '$location', 'User', 
        function($scope, $rootScope, $location, User)
        {
            $rootScope.clearError();
            $scope.entity = new User();

            $scope.save = function(){
                if($scope.formUser.$valid)
                {
                    $("button[type=submit]").button('loading');

                    $scope.entity.$save().then(function(){
                        $location.path('/user');

                    }).catch(function(response){
                        $("button[type=submit]").button('reset');
                        $rootScope.showError(response.status, response.data);
                    });
                }
            };
        }]);