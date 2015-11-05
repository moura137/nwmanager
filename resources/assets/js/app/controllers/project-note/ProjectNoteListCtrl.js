/**
 * Controller ProjectNote List
 */
angular.module('app.controllers')
    .controller('ProjectNoteListCtrl',
        ['$scope', '$rootScope', '$stateParams', '$compile', '$timeout', '$http', '$window', 'ProjectNote',
        function($scope, $rootScope, $stateParams, $compile, $timeout, $http, $window, ProjectNote) {
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

            $scope.print = function(note) {
                $http.get('/build/views/project-note/printNote.html').then(function(response){
                    $scope.note = note;
                    console.log(note);
                    var div = $('<div />');
                    div.html($compile(response.data)($scope));
                    $timeout(function() {
                        var frame = $window.open('', '_blank', 'width=500,height=500,scrollbar=yes');
                        frame.document.open();
                        frame.document.write(div.html());
                        frame.document.close();
                    }, 100);
                });
            };

            $scope.clear();
        }]);