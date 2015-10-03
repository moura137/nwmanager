/**
 * Controller ProjectFile Delete
 */
angular.module('app.controllers')
    .controller('ProjectFileDeleteCtrl', 
        ['$scope', '$rootScope', '$location', '$stateParams', 'ProjectFile', 
        function($scope, $rootScope, $location, $stateParams, ProjectFile)
        {
            $rootScope.clearError();
            $scope.file = new ProjectFile.get({id: $stateParams.id, idFile: $stateParams.idFile});

            $scope.delete = function(){
                $("button.btn-danger").button('loading');
                
                $scope.file.$delete({id: $stateParams.id, idFile: $scope.file.id}).then(function(){
                    $location.path('project/'+$stateParams.id+'/show?tab=tab-file');

                }).catch(function(response){
                    $("button.btn-danger").button('reset');
                    $rootScope.showError(response.status, response.data);
                });
            };
        }]);