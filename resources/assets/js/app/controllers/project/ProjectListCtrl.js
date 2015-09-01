/**
 * Controller Project List
 */
angular.module('app.controllers')
    .controller('ProjectListCtrl', 
        ['$scope', '$rootScope', 'Project', 
        function($scope, $rootScope, Project) {
            
            $scope.search = function() {
                $scope.query({'search': $scope.q});
                $scope.searched = true;
            };

            $scope.clear = function() {
                $scope.q = '';
                $scope.searched = false;
                $scope.query();
            };

            $scope.query = function(search) {
                $rootScope.clearError();
                $scope.projects = Project.query(search);
            };

            $scope.clear();
        }]);