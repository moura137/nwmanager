/**
 * Controller ProjectNote List
 */
angular.module('app.controllers')
    .controller('ProjectNoteListCtrl',
        ['$scope', '$rootScope', '$stateParams', 'ProjectNote',
        function($scope, $rootScope, $stateParams, ProjectNote) {
            $scope.project_id = $stateParams.id;

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
                ProjectNote.query(search, {id: $stateParams.id}, function(res) {
                    $scope.notes = res.data;
                    $scope.notes_pagination = res.meta.pagination;
                });
            };

            $scope.pageChanged = function() {
                $scope.search($scope.notes_pagination.current_page);
                $('body').scrollTop(0);
            };

            $scope.clear();
        }]);