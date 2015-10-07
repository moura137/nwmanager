/**
 * Controller Home
 */
angular.module('app.controllers')
    .controller('HomeCtrl',
        ['$scope', '$rootScope', '$pusher', 'Project', 'Activity',
        function($scope, $rootScope, $pusher, Project, Activity) {
            $scope.activities = [];

            var channelName = 'feed-activity';
            var pusher = $pusher(window.client);

            pusher.unsubscribe(channelName);
            var channel = pusher.subscribe(channelName);

            channel.bind('pusher:subscription_succeeded', function(object) {
              console.log('pusher:subscription_succeeded', object);
            });

            channel.bind('pusher:subscription_error', function(status) {
              console.log('pusher:subscription_error', status);

              if(status == 408 || status == 503){
                // retry?
              }
            });

            channel.bind('ActivityEvent', function(activity) {
                console.log('ActivityEvent', activity);

                var limit = 6;
                if ($scope.activities.length >= limit) {
                    $scope.activities.splice(limit-1);
                }
                $scope.activities.unshift(activity.data);
            });

            $scope.searchActivities = function(page) {
                Activity.query({'limit': 6}, function(res) {
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