/**
 * Controller User List
 */
angular.module('app.controllers')
    .controller('UserListCtrl', 
        ['$scope', '$rootScope', 'User', 
        function($scope, $rootScope, User) {
            
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
                User.query(search, function(res) {
                    $scope.users = res.data;
                    $scope.pagination = res.meta.pagination;
                });
            };

            $scope.pageChanged = function() {
                $scope.search($scope.pagination.current_page);
            };

            $scope.clear();
        }]);