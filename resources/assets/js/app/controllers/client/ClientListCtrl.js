/**
 * Controller Client List
 */
angular.module('app.controllers')
    .controller('ClientListCtrl',
        ['$scope', '$rootScope', 'Client',
        function($scope, $rootScope, Client) {

            $scope.search = function(page) {
                $rootScope.clearError();

                Client.query({'search': $scope.q, 'page': page}, function(res) {
                    $scope.clients = res.data;
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