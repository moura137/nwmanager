/**
 * Controller Home
 */
angular.module('app.controllers')
    .controller('HomeCtrl',
        ['$scope', '$rootScope', 'Realtime', 'Project', 'Activity',
        function($scope, $rootScope, Realtime, Project, Activity) {
            $scope.activities = [];

            var limit = 6;
            var channelName = 'activities';

            Realtime.connect();
            Realtime.on(channelName, 'ActivityEvent', function(activity) {
                if ($scope.activities.length >= limit) {
                    $scope.activities.splice(limit-1);
                }
                $scope.activities.unshift(activity);
            });

            $scope.searchActivities = function(page) {
                Activity.query({'limit': limit}, function(res) {
                    $scope.activities = res.data;
                });
            };

            $scope.searchProjects = function(page) {
                $rootScope.clearError();

                Project.query({'search': $scope.q, 'page': page}, function(res) {
                    $scope.projects = res.data;
                    $scope.pagination = res.meta.pagination;
                });

                $scope.searched = ($scope.q!="");
            };

            $scope.searchProjects();
            $scope.searchActivities();
        }]);