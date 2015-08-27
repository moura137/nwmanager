/**
 * Controller User List
 */
angular.module('app.controllers')
    .controller('UserListCtrl', 
        ['$scope', '$rootScope', 'User', 
        function($scope, $rootScope, User) {
            
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
                $scope.entities = User.query(search);
            };

            $scope.clear();
        }]);