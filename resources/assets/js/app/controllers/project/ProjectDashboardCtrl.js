/**
 * Controller Project Dashboard
 */
angular.module('app.controllers')
    .controller('ProjectDashboardCtrl',
        ['$scope', '$rootScope', 'Project',
        function($scope, $rootScope, Project) {

            $scope.search = function(page) {
                $rootScope.clearError();

                Project.query({'search': $scope.q, 'page': page}, function(res) {
                    $scope.projects = res.data;
                    $scope.pagination = res.meta.pagination;
                });

                $scope.searched = ($scope.q!="");

                $('body').scrollTop(0);
            };

            $scope.clear = function() {
                $scope.q = '';
                $scope.search();
            };

            $scope.clear();
        }]);