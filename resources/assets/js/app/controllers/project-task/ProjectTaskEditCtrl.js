/**
 * Controller ProjectTask Edit
 */
angular.module('app.controllers')
    .controller('ProjectTaskEditCtrl',
        ['$scope', '$rootScope', '$location', '$stateParams', 'Settings', 'ProjectTask',
        function($scope, $rootScope, $location, $stateParams, Settings, ProjectTask)
        {
            $rootScope.clearError();
            $scope.task = new ProjectTask.get({id: $stateParams.id, idTask: $stateParams.idTask});
            $scope.task.project_id = $stateParams.id;
            $scope.status = Settings.projectTask.status;

            $scope.save = function(){
                if($scope.formProjectTask.$valid)
                {
                    $("button[type=submit]").button('loading');

                    ProjectTask.update({id: $stateParams.id, idTask: $scope.task.id}, $scope.task, function(){
                        $location.path('project/'+$stateParams.id+'/show').search('tab', 'tab-task');

                    }, function(response){
                        $("button[type=submit]").button('reset');
                        $rootScope.showError(response.status, response.data);
                    });
                }
            };
        }]);