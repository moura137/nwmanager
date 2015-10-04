/**
 * Controller ProjectTask List
 */
angular.module('app.controllers')
    .controller('ProjectTaskListCtrl',
        ['$scope', '$rootScope', '$stateParams', 'Settings', 'ProjectTask',
        function($scope, $rootScope, $stateParams, Settings, ProjectTask) {
            $scope.project_id = $stateParams.id;

            $scope.search = function(page) {
                $scope.query({'search': $scope.q, 'page': page});
                $scope.searched = true;
            };

            $scope.query = function(search) {
                $rootScope.clearError();
                ProjectTask.query(search, {id: $stateParams.id}, function(res) {
                    $scope.tasks = res.data;
                    $scope.tasks_pagination = res.meta.pagination;
                });
            };

            $scope.pageChanged = function() {
                $scope.search($scope.tasks_pagination.current_page);
                $('body').scrollTop(0);
            };

            $scope.query();

            $scope.deleteTask = function(task) {
                window.swal({
                    title: "Deseja excluir a Tarefa?",
                    type: "warning",
                    confirmButtonColor: "#DD6B55",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,

                }, function(){
                    ProjectTask.delete({id: task.project_id, idTask: task.id}, {}, function(){

                        $scope.query();

                        window.swal.close();

                    }, function(response){
                        window.swal({
                            title: "Error!",
                            text: response.data.error_description,
                            type: "error"
                        });
                    });
                });
            };

            $scope.task = new ProjectTask();

            $scope.saveTask = function(){
                $scope.task.status = Settings.projectTask.status[0].value;

                $scope.task.$save({id: $stateParams.id}).then(function(){
                    $scope.query();

                }).catch(function(response){
                    $rootScope.showError(response.status, response.data);

                }).finally(function(){
                    $scope.task = new ProjectTask();
                });
            };
        }]);