/**
 * Controller ProjectMember List
 */
angular.module('app.controllers')
    .controller('ProjectMemberListCtrl',
        ['$scope', '$rootScope', '$routeParams', 'Project', 'User',
        function($scope, $rootScope, $routeParams, Project, User) {

            $scope.member_select = null;

            $scope.query = function(search) {
                $rootScope.clearError();
                $scope.project = Project.get({id: $routeParams.id});
            };

            /**
             * TYPEAHEAD MEMBERS
             */
            $scope.formatLabel = function (model) {
                if (model) {
                    return model.name;
                }
                return '';
            };
            $scope.getMembers = function(search) {
                return User.all({'search': search}).$promise;
            };

            $scope.addMember = function() {
                if ($scope.member_select) {
                    Project.addMember({id: $routeParams.id}, {members: $scope.member_select.id}, function(response){
                        $scope.project.members.data = JSON.parse(angular.toJson(response));
                    });
                    $scope.member_select = null;
                }
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
                        $scope.project.members.data = JSON.parse(angular.toJson(response));

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

            $scope.query();
        }]);