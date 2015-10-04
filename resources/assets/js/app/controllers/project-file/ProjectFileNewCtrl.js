/**
 * Controller ProjectFile New
 */
angular.module('app.controllers')
    .controller('ProjectFileNewCtrl',
        ['$scope', '$rootScope', '$location', '$stateParams', 'ProjectFile',
        function($scope, $rootScope, $location, $stateParams, ProjectFile)
        {
            $rootScope.clearError();
            $scope.file = new ProjectFile();
            $scope.file.project_id = $stateParams.id;

            $scope.save = function(){
                if($scope.formProjectFile.$valid)
                {
                    $("button[type=submit]").button('loading');

                    $scope.file.$save({id: $stateParams.id}).then(function(){
                        $location.path('project/'+$stateParams.id+'/show').search('tab', 'tab-file');

                    }).catch(function(response){
                        $("button[type=submit]").button('reset');
                        $rootScope.showError(response.status, response.data);
                    });
                }
            };
        }]);