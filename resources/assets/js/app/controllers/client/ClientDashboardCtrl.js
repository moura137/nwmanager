/**
 * Controller Client Dashboard
 */
angular.module('app.controllers')
    .controller('ClientDashboardCtrl',
        ['$scope', '$rootScope', 'Client', 'Project',
        function($scope, $rootScope, Client, Project) {

            $scope.limit = 10;
            $scope.client = null;

            $scope.search = function(page) {
                $rootScope.clearError();
                var search = $scope.q + '%';

                Client.query({'search': search, 'page': page, 'limit': $scope.limit}, function(res) {
                    var clients = res.data;

                    $scope.clients = clients;
                    $scope.clients_pagination = res.meta.pagination;

                    if (clients.length) {
                        $scope.client = clients[0];
                        $scope.searchProjects();

                    } else {
                        $scope.client = null;
                        $scope.projects = [];
                        $scope.projects_pagination = {};
                    }
                });

                $scope.searched = ($scope.q!="");
            };

            $scope.clear = function() {
                $scope.q = '';
                $scope.search();
            };

            $scope.clear();

            $scope.changeClient = function(client) {
                $scope.client = client;
                $scope.searchProjects();
            };

            $scope.searchProjects = function(page) {
                Project.query({'client_id': $scope.client.id, 'page': page}, function(res) {
                    $scope.projects = res.data;
                    $scope.projects_pagination = res.meta.pagination;
                });
            };
        }]);