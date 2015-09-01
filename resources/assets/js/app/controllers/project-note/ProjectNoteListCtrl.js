/**
 * Controller ProjectNote List
 */
angular.module('app.controllers')
    .controller('ProjectNoteListCtrl', 
        ['$scope', '$rootScope', '$routeParams', 'ProjectNote', 
        function($scope, $rootScope, $routeParams, ProjectNote) {
            $scope.project_id = $routeParams.id;
            
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
                $scope.notes = ProjectNote.query(search, {id: $routeParams.id});
            };

            $scope.clear();
        }]);