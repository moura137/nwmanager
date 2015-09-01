/**
 * Controller ProjectFile Delete
 */
angular.module('app.controllers')
    .controller('ProjectFileDeleteCtrl', 
        ['$scope', '$rootScope', '$location', '$routeParams', 'ProjectFile', 
        function($scope, $rootScope, $location, $routeParams, ProjectFile)
        {
            $rootScope.clearError();
            $scope.file = new ProjectFile.get({id: $routeParams.id, idFile: $routeParams.idFile});

            $scope.delete = function(){
                $("button.btn-danger").button('loading');
                
                $scope.file.$delete({id: $routeParams.id, idFile: $scope.file.id}).then(function(){
                    $location.path('project/'+$routeParams.id+'/show');

                }).catch(function(response){
                    $("button.btn-danger").button('reset');
                    $rootScope.showError(response.status, response.data);
                });
            };
        }]);