/**
 * Controller ProjectNote Delete
 */
angular.module('app.controllers')
    .controller('ProjectNoteDeleteCtrl', 
        ['$scope', '$rootScope', '$location', '$routeParams', 'ProjectNote', 
        function($scope, $rootScope, $location, $routeParams, ProjectNote)
        {
            $rootScope.clearError();
            $scope.note = new ProjectNote.get({id: $routeParams.id, idNote: $routeParams.idNote});

            $scope.delete = function(){
                $("button.btn-danger").button('loading');
                
                $scope.note.$delete({id: $routeParams.id, idNote: $scope.note.id}).then(function(){
                    $location.path('project/'+$routeParams.id+'/show').search('tab', 'tab-note');

                }).catch(function(response){
                    $("button.btn-danger").button('reset');
                    $rootScope.showError(response.status, response.data);
                });
            };
        }]);