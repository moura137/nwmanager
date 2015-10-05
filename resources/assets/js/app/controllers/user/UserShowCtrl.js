/**
 * Controller User Show
 */
angular.module('app.controllers')
    .controller('UserShowCtrl',
        ['$scope', '$rootScope', '$stateParams', 'User', 'Project',
        function($scope, $rootScope, $stateParams, User, Project)
        {
            $rootScope.clearError();
            $scope.user = new User.get({id: $stateParams.id});

            $scope.searchProjects = function(page) {
                Project.query({'owner_id': $stateParams.id, 'page': page}, function(res) {
                    $scope.projects = res.data;
                    $scope.projects_pagination = res.meta.pagination;
                });
            };

            $scope.searchProjects();
        }]);