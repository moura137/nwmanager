/**
 * Controller Project Edit
 */
angular.module('app.controllers')
    .controller('ProjectEditCtrl', 
        ['$scope', '$rootScope', '$location', '$routeParams', 'Project', 'Client', 'User', 'Settings', 
        function($scope, $rootScope, $location, $routeParams, Project, Client, User, Settings)
        {
            $rootScope.clearError();
            $scope.clients = Client.query();
            $scope.users = User.query();
            $scope.project = new Project.get({id: $routeParams.id});
            $scope.status = Settings.project.status;

            $scope.save = function(){
                if($scope.formProject.$valid)
                {
                    $("button[type=submit]").button('loading');

                    Project.update({id: $scope.project.id}, $scope.project, function(){
                        $location.path('project/'+$routeParams.id+'/show');

                    }, function(response){
                        $("button[type=submit]").button('reset');
                        $rootScope.showError(response.status, response.data);
                    });
                }
            };
        }]);