/**
 * Controller User List
 */
angular.module('app.controllers')
    .controller('UserListCtrl',
        ['$scope', '$rootScope', 'User',
        function($scope, $rootScope, User) {

            $scope.search = function(page) {
                $rootScope.clearError();

                User.query({'search': $scope.q, 'page': page}, function(res) {
                    $scope.users = res.data;
                    $scope.pagination = res.meta.pagination;
                });

                $scope.searched = ($scope.q!="");

                $('body').scrollTop(0);
            };

            $scope.clear = function() {
                $scope.q = '';
                $scope.search();
            };

            $scope.clear();
        }]);