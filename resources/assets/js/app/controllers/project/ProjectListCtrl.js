/**
 * Controller Project List
 */
angular.module('app.controllers')
    .controller('ProjectListCtrl',
        ['$scope', '$rootScope', 'Project',
        function($scope, $rootScope, Project) {

            $scope.search = function(page) {
                $scope.query({'search': $scope.q, 'page': page});
                $scope.searched = true;
            };

            $scope.clear = function() {
                $scope.q = '';
                $scope.searched = false;
                $scope.query();
            };

            $scope.query = function(search) {
                $rootScope.clearError();
                Project.query(search, function(res) {
                    $scope.projects = res.data;
                    $scope.pagination = res.meta.pagination;
                });
            };

            $scope.pageChanged = function() {
                $scope.search($scope.pagination.current_page);
                $('body').scrollTop(0);
            };

            $scope.clear();
        }]);