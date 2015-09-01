/**
 * Controller ProjectNote Edit
 */
angular.module('app.controllers')
    .controller('ProjectNoteEditCtrl', 
        ['$scope', '$rootScope', '$location', '$routeParams', 'ProjectNote', 
        function($scope, $rootScope, $location, $routeParams, ProjectNote)
        {
            $rootScope.clearError();
            $scope.note = new ProjectNote.get({id: $routeParams.id, idNote: $routeParams.idNote});
            $scope.note.project_id = $routeParams.id;

            $scope.save = function(){
                if($scope.formProjectNote.$valid)
                {
                    $("button[type=submit]").button('loading');

                    ProjectNote.update({id: $routeParams.id, idNote: $scope.note.id}, $scope.note, function(){
                        $location.path('project/'+$routeParams.id+'/show');

                    }, function(response){
                        $("button[type=submit]").button('reset');
                        $rootScope.showError(response.status, response.data);
                    });
                }
            };
        }]);