/**
 * Controller Project New
 */
angular.module('app.controllers')
    .controller('ProjectNewCtrl',
        ['$scope', '$rootScope', '$location', 'Project', 'Client', 'User', 'Settings',
        function($scope, $rootScope, $location, Project, Client, User, Settings)
        {
            $rootScope.clearError();
            $scope.project = new Project();
            $scope.status = Settings.project.status;

            $scope.formatLabel = function (model) {
                if (model) {
                    return model.name;
                }
                return '';
            };
            /**
             * TYPEAHEAD OWNER
             */
            $scope.getOwners = function(search) {
                return User.all({'search': search}).$promise;
            };
            $scope.onSelectedOwner = function ($item, $model, $label) {
                $scope.project.owner_id = $item.id;
            };

            /**
             * TYPEAHEAD CLIENT
             */
            $scope.getClients = function(search) {
                return Client.all({'search': search}).$promise;
            };
            $scope.onSelectedClient = function ($item, $model, $label) {
                $scope.project.client_id = $item.id;
            };

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