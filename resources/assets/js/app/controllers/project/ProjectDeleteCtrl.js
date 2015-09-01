/**
 * Controller Project Delete
 */
angular.module('app.controllers')
    .controller('ProjectDeleteCtrl', 
        ['$scope', '$rootScope', '$location', '$routeParams', 'Project', 
        function($scope, $rootScope, $location, $routeParams, Project)
        {
            $rootScope.clearError();
            $scope.project = new Project.get({id: $routeParams.id});

            $scope.delete = function(){
                $("button.btn-danger").button('loading');
                
                $scope.project.$delete().then(function(){
                    $location.path('/project');

                }).catch(function(response){
                    $("button.btn-danger").button('reset');
                    $rootScope.showError(response.status, response.data);
                });
            };
        }]);