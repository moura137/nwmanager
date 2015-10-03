/**
 * Controller ProjectNote Edit
 */
angular.module('app.controllers')
    .controller('ProjectNoteEditCtrl', 
        ['$scope', '$rootScope', '$location', '$stateParams', 'ProjectNote', 
        function($scope, $rootScope, $location, $stateParams, ProjectNote)
        {
            $rootScope.clearError();
            $scope.note = new ProjectNote.get({id: $stateParams.id, idNote: $stateParams.idNote});
            $scope.note.project_id = $stateParams.id;

            $scope.save = function(){
                if($scope.formProjectNote.$valid)
                {
                    $("button[type=submit]").button('loading');

                    ProjectNote.update({id: $stateParams.id, idNote: $scope.note.id}, $scope.note, function(){
                        $location.path('project/'+$stateParams.id+'/show').search('tab', 'tab-note');

                    }, function(response){
                        $("button[type=submit]").button('reset');
                        $rootScope.showError(response.status, response.data);
                    });
                }
            };
        }]);