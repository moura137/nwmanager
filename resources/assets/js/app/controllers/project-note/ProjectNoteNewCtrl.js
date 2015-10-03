/**
 * Controller ProjectNote New
 */
angular.module('app.controllers')
    .controller('ProjectNoteNewCtrl', 
        ['$scope', '$rootScope', '$location', '$stateParams', 'ProjectNote', 
        function($scope, $rootScope, $location, $stateParams, ProjectNote)
        {
            $rootScope.clearError();
            $scope.note = new ProjectNote();
            $scope.note.project_id = $stateParams.id;
            
            $scope.save = function(){
                if($scope.formProjectNote.$valid)
                {
                    $("button[type=submit]").button('loading');

                    $scope.note.$save({id: $stateParams.id}).then(function(){
                        $location.path('project/'+$stateParams.id+'/show').search('tab', 'tab-note');

                    }).catch(function(response){
                        $("button[type=submit]").button('reset');
                        $rootScope.showError(response.status, response.data);
                    });
                }
            };
        }]);