/**
 * Controller Project New
 */
angular.module('app.controllers')
    .controller('ProjectNewCtrl', 
        ['$scope', '$rootScope', '$location', 'Project', 'Client', 'User', 'Settings', 
        function($scope, $rootScope, $location, Project, Client, User, Settings)
        {
            $rootScope.clearError();
            $scope.clients = Client.query();
            $scope.users = User.query();
            $scope.status = Settings.project.status;
            
            $scope.project = new Project();

            $scope.save = function(){
                if($scope.formProject.$valid)
                {
                    $("button[type=submit]").button('loading');

                    $scope.project.$save().then(function(response){
                        $location.path('project/'+response.id+'/show');

                    }).catch(function(response){
                        $("button[type=submit]").button('reset');
                        $rootScope.showError(response.status, response.data);
                    });
                }
            };
        }]);