/**
 * Controller ProjectFile New
 */
angular.module('app.controllers')
    .controller('ProjectFileNewCtrl', 
        ['$scope', '$rootScope', '$location', '$routeParams', 'ProjectFile', 
        function($scope, $rootScope, $location, $routeParams, ProjectFile)
        {
            $rootScope.clearError();
            $scope.file = new ProjectFile();
            $scope.file.project_id = $routeParams.id;
            
            //listen for the file selected event
            $scope.$on("fileSelected", function (event, args) {
                $scope.$apply(function () {
                    $scope.file.file = args.file;
                });
            });

            $scope.save = function(){
                if($scope.formProjectFile.$valid)
                {
                    $("button[type=submit]").button('loading');

                    $scope.file.$save({id: $routeParams.id}).then(function(){
                        $location.path('project/'+$routeParams.id+'/show');

                    }).catch(function(response){
                        $("button[type=submit]").button('reset');
                        $rootScope.showError(response.status, response.data);
                    });
                }
            };
        }]);