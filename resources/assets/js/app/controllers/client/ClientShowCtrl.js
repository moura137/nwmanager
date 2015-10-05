/**
 * Controller Client Show
 */
angular.module('app.controllers')
    .controller('ClientShowCtrl',
        ['$scope', '$rootScope', '$stateParams', 'Client', 'Project',
        function($scope, $rootScope, $stateParams, Client, Project)
        {
            $rootScope.clearError();
            $scope.client = new Client.get({id: $stateParams.id});

            $scope.searchProjects = function(page) {
                Project.query({'client_id': $stateParams.id, 'page': page}, function(res) {
                    $scope.projects = res.data;
                    $scope.projects_pagination = res.meta.pagination;
                });
            };

            $scope.searchProjects();
        }]);