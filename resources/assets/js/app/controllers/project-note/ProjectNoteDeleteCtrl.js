/**
 * Controller ProjectNote Delete
 */
angular.module('app.controllers')
    .controller('ProjectNoteDeleteCtrl',
        ['$scope', '$rootScope', '$location', '$stateParams', 'ProjectNote',
        function($scope, $rootScope, $location, $stateParams, ProjectNote)
        {
            $rootScope.clearError();
            $scope.note = new ProjectNote.get({id: $stateParams.id, idNote: $stateParams.idNote});

            $scope.delete = function(){
                $("button.btn-danger").button('loading');

                $scope.note.$delete({id: $stateParams.id, idNote: $scope.note.id}).then(function(){
                    $location.path('project/'+$stateParams.id+'/show').search('tab', 'tab-note');

                }).catch(function(response){
                    $("button.btn-danger").button('reset');
                    $rootScope.showError(response.status, response.data);
                });
            };
        }]);