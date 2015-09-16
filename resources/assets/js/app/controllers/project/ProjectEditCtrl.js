/**
 * Controller Project Edit
 */
angular.module('app.controllers')
    .controller('ProjectEditCtrl', 
        ['$scope', '$rootScope', '$location', '$routeParams', 'Project', 'Client', 'User', 'Settings', 
        function($scope, $rootScope, $location, $routeParams, Project, Client, User, Settings)
        {
            $rootScope.clearError();
            $scope.project = Project.get({id: $routeParams.id});
            $scope.status = Settings.project.status;

            /**
             * TYPEAHEAD
             */
            $scope.formatLabel = function (model) {
                if (model) {
                    return model.name;
                }
                return '';
            };

            $scope.getOwners = function(search) {
                return User.all({'search': search}).$promise;
            };

            $scope.onSelectedOwner = function ($item) {
                $scope.project.owner_id = $item.id;
            };

            $scope.getClients = function(search) {
                return Client.all({'search': search}).$promise;
            };

            $scope.onSelectedClient = function ($item) {
                $scope.project.client_id = $item.id;
            };

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