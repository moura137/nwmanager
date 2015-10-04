/**
 * Controller ProjectTask Delete
 */
angular.module('app.controllers')
    .controller('ProjectTaskDeleteCtrl',
        ['$scope', '$rootScope', '$location', '$stateParams', 'ProjectTask',
        function($scope, $rootScope, $location, $stateParams, ProjectTask)
        {
            $rootScope.clearError();
            $scope.task = new ProjectTask.get({id: $stateParams.id, idTask: $stateParams.idTask});

            $scope.delete = function(){
                $("button.btn-danger").button('loading');

                $scope.task.$delete({id: $stateParams.id, idTask: $scope.task.id}).then(function(){
                    $location.path('project/'+$stateParams.id+'/show?tab=tab-task');

                }).catch(function(response){
                    $("button.btn-danger").button('reset');
                    $rootScope.showError(response.status, response.data);
                });
            };
        }]);