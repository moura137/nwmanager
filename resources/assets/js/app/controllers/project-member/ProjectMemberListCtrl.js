/**
 * Controller ProjectMember List
 */
angular.module('app.controllers')
    .controller('ProjectMemberListCtrl', 
        ['$scope', '$rootScope', '$routeParams', 'Project', 
        function($scope, $rootScope, $routeParams, Project) {
            
            $scope.query = function(search) {
                $rootScope.clearError();
                $scope.project = Project.get({id: $routeParams.id});
            };

            $scope.removeMember = function(member) {
                window.swal({
                    title: "Deseja remover o membro?",
                    type: "warning",
                    confirmButtonColor: "#DD6B55",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,

                }, function(){
                    Project.removeMember({id: $routeParams.id}, {members: member.member_id}, function(response){
                        
                        $scope.query();

                        window.swal({
                            title: "Removido!",
                            text: "Membro removido com sucesso!",
                            type: "success",
                            timer: 1000,
                        });

                    }, function(response){
                        window.swal({
                            title: "Error!",
                            text: response.data.error_description,
                            type: "error"
                        });
                    });
                });
            };

            $scope.query();
        }]);