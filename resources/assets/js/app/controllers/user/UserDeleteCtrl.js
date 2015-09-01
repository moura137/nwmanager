/**
 * Controller User Delete
 */
angular.module('app.controllers')
    .controller('UserDeleteCtrl', 
        ['$scope', '$rootScope', '$location', '$routeParams', 'User', 
        function($scope, $rootScope, $location, $routeParams, User)
        {
            $rootScope.clearError();
            $scope.user = new User.get({id: $routeParams.id});

            $scope.delete = function(){
                $("button.btn-danger").button('loading');
                
                $scope.user.$delete().then(function(){
                    $location.path('/user');

                }).catch(function(response){
                    $("button.btn-danger").button('reset');
                    $rootScope.showError(response.status, response.data);
                });
            };
        }]);