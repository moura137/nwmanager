/**
 * Controller ProjectNote List
 */
angular.module('app.controllers')
    .controller('ProjectNoteListCtrl',
        ['$scope', '$rootScope', '$stateParams', 'ProjectNote',
        function($scope, $rootScope, $stateParams, ProjectNote) {
            $scope.project_id = $stateParams.id;

            $scope.searchNotes = function(page) {
                $rootScope.clearError();

                ProjectNote.query(
                    {'search': $scope.q, 'page': page},
                    {id: $stateParams.id},
                    function(res) {
                        $scope.notes = res.data;
                        $scope.notes_pagination = res.meta.pagination;
                    });

                $scope.searched = ($scope.q!="")
            };

            $scope.clear = function() {
                $scope.q = '';
                $scope.searchNotes();
            };

            $scope.clear();
        }]);