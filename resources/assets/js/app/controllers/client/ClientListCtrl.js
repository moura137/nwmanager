/**
 * Controller Client List
 */
angular.module('app.controllers')
    .controller('ClientListCtrl', 
        ['$scope', '$rootScope', 'Client', 
        function($scope, $rootScope, Client) {
            
            $scope.search = function() {
                $scope.query({'search': $scope.q});
                $scope.searched = true;
            };

            $scope.clear = function() {
                $scope.q = '';
                $scope.searched = false;
                $scope.query();
            };

            $scope.query = function(search) {
                $rootScope.clearError();
                $scope.clients = Client.query(search);
            };

            $scope.clear();
        }]);