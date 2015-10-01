/**
 * Controller ProjectTask Delete
 */
angular.module('app.controllers')
    .controller('ProjectTaskDeleteCtrl', 
        ['$scope', '$rootScope', '$location', '$routeParams', 'ProjectTask', 
        function($scope, $rootScope, $location, $routeParams, ProjectTask)
        {
            $rootScope.clearError();
            $scope.task = new ProjectTask.get({id: $routeParams.id, idTask: $routeParams.idTask});

            $scope.delete = function(){
                $("button.btn-danger").button('loading');

                $scope.task.$delete({id: $routeParams.id, idTask: $scope.task.id}).then(function(){
                    $location.path('project/'+$routeParams.id+'/show?tab=tab-task');

                }).catch(function(response){
                    $("button.btn-danger").button('reset');
                    $rootScope.showError(response.status, response.data);
                });
            };
        }]);