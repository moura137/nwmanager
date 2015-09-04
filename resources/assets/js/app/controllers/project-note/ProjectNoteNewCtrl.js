/**
 * Controller ProjectNote New
 */
angular.module('app.controllers')
    .controller('ProjectNoteNewCtrl', 
        ['$scope', '$rootScope', '$location', '$routeParams', 'ProjectNote', 
        function($scope, $rootScope, $location, $routeParams, ProjectNote)
        {
            $rootScope.clearError();
            $scope.note = new ProjectNote();
            $scope.note.project_id = $routeParams.id;
            
            $scope.save = function(){
                if($scope.formProjectNote.$valid)
                {
                    $("button[type=submit]").button('loading');

                    $scope.note.$save({id: $routeParams.id}).then(function(){
                        $location.path('project/'+$routeParams.id+'/show').search('tab', 'tab-note');

                    }).catch(function(response){
                        $("button[type=submit]").button('reset');
                        $rootScope.showError(response.status, response.data);
                    });
                }
            };
        }]);