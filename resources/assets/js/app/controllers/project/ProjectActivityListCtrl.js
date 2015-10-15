/**
 * Controller Project Activities
 */
angular.module('app.controllers')
    .controller('ProjectActivityListCtrl',
        ['$scope', '$rootScope', '$stateParams', 'Activity',
        function($scope, $rootScope, $stateParams, Activity)
        {
            $rootScope.clearError();
            $scope.project_id = $stateParams.id;

            $scope.searchActivities = function(page) {
                $rootScope.clearError();

                Activity.query({'project_id': $stateParams.id, 'search': $scope.q, 'page': page}, function(res) {
                    $scope.activities = res.data;
                    $scope.activity_pagination = res.meta.pagination;
                });

                $scope.searched = ($scope.q!="");
            };

            $scope.clear = function() {
                $scope.q = '';
                $scope.searchActivities();
            };

            $scope.clear();
        }]);