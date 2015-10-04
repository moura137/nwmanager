/**
 * Controller User Edit
 */
angular.module('app.controllers')
    .controller('UserEditCtrl',
        ['$scope', '$rootScope', '$location', '$stateParams', 'User',
        function($scope, $rootScope, $location, $stateParams, User)
        {
            $rootScope.clearError();
            $scope.user = new User.get({id: $stateParams.id});

            $scope.save = function(){
                if($scope.formUser.$valid)
                {
                    $("button[type=submit]").button('loading');

                    User.update({id: $scope.user.id}, $scope.user, function(){
                        $location.path('/user');

                    }, function(response){
                        $("button[type=submit]").button('reset');
                        $rootScope.showError(response.status, response.data);
                    });
                }
            };
        }]);