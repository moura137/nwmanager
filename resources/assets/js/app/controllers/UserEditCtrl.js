/**
 * Controller User Edit
 */
angular.module('app.controllers')
    .controller('UserEditCtrl', 
        ['$scope', '$rootScope', '$location', '$routeParams', 'User', 
        function($scope, $rootScope, $location, $routeParams, User)
        {
            $rootScope.clearError();
            $scope.entity = new User.get({id: $routeParams.id});

            $scope.save = function(){
                if($scope.formUser.$valid)
                {
                    $("button[type=submit]").button('loading');

                    User.update({id: $scope.entity.id}, $scope.entity, function(){
                        $location.path('/user');

                    }, function(response){
                        $("button[type=submit]").button('reset');
                        $rootScope.showError(response.status, response.data);
                    });
                }
            };
        }]);