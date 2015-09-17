/**
 * Controller Client List
 */
angular.module('app.controllers')
    .controller('ClientListCtrl', 
        ['$scope', '$rootScope', 'Client', 
        function($scope, $rootScope, Client) {
            
            $scope.search = function(page) {
                $scope.query({'search': $scope.q, 'page': page});
                $scope.searched = true;
            };

            $scope.clear = function() {
                $scope.q = '';
                $scope.searched = false;
                $scope.query();
            };

            $scope.query = function(search) {
                $rootScope.clearError();                
                Client.query(search, function(res) {
                    $scope.clients = res.data;
                    $scope.pagination = res.meta.pagination;
                });
            };

            $scope.pageChanged = function() {
                $scope.search($scope.pagination.current_page);
                $('body').scrollTop(0);
            };

            $scope.clear();
        }]);