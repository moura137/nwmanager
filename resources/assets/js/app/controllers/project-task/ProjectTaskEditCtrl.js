/**
 * Controller ProjectTask Edit
 */
angular.module('app.controllers')
    .controller('ProjectTaskEditCtrl', 
        ['$scope', '$rootScope', '$location', '$routeParams', 'Settings', 'ProjectTask', 
        function($scope, $rootScope, $location, $routeParams, Settings, ProjectTask)
        {
            $rootScope.clearError();
            $scope.task = new ProjectTask.get({id: $routeParams.id, idTask: $routeParams.idTask});
            $scope.task.project_id = $routeParams.id;
            $scope.status = Settings.projectTask.status;

            $scope.save = function(){
                if($scope.formProjectTask.$valid)
                {
                    $("button[type=submit]").button('loading');

                    ProjectTask.update({id: $routeParams.id, idTask: $scope.task.id}, $scope.task, function(){
                        $location.path('project/'+$routeParams.id+'/show').search('tab', 'tab-task');

                    }, function(response){
                        $("button[type=submit]").button('reset');
                        $rootScope.showError(response.status, response.data);
                    });
                }
            };
        }]);