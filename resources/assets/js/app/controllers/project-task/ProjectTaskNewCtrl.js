/**
 * Controller ProjectTask New
 */
angular.module('app.controllers')
    .controller('ProjectTaskNewCtrl',
        ['$scope', '$rootScope', '$location', '$stateParams', 'Settings', 'ProjectTask',
        function($scope, $rootScope, $location, $stateParams, Settings, ProjectTask)
        {
            $rootScope.clearError();
            $scope.status = Settings.projectTask.status;
            $scope.task = new ProjectTask();
            $scope.task.project_id = $stateParams.id;
            $scope.task.status = $scope.status[0].value;

            $scope.save = function(){
                if($scope.formProjectTask.$valid)
                {
                    $("button[type=submit]").button('loading');
                    $scope.task.$save({id: $stateParams.id}).then(function(){
                        $location.path('project/'+$stateParams.id+'/show').search('tab', 'tab-task');

                    }).catch(function(response){
                        $("button[type=submit]").button('reset');
                        $rootScope.showError(response.status, response.data);
                    });
                }
            };
        }]);