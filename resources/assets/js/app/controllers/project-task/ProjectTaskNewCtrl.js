/**
 * Controller ProjectTask New
 */
angular.module('app.controllers')
    .controller('ProjectTaskNewCtrl',
        ['$scope', '$rootScope', '$location', '$routeParams', 'Settings', 'ProjectTask',
        function($scope, $rootScope, $location, $routeParams, Settings, ProjectTask)
        {
            $rootScope.clearError();
            $scope.status = Settings.projectTask.status;
            $scope.task = new ProjectTask();
            $scope.task.project_id = $routeParams.id;
            $scope.task.status = $scope.status[0].value;

            $scope.save = function(){
                if($scope.formProjectTask.$valid)
                {
                    $("button[type=submit]").button('loading');
                    $scope.task.$save({id: $routeParams.id}).then(function(){
                        $location.path('project/'+$routeParams.id+'/show').search('tab', 'tab-task');

                    }).catch(function(response){
                        $("button[type=submit]").button('reset');
                        $rootScope.showError(response.status, response.data);
                    });
                }
            };
        }]);