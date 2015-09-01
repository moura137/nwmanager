/**
 * Controller Project Show
 */
angular.module('app.controllers')
    .controller('ProjectShowCtrl', 
        ['$scope', '$rootScope', '$routeParams', 'Project', 'ProjectFile', 
        function($scope, $rootScope, $routeParams, Project, ProjectFile)
        {
            $rootScope.clearError();
            $scope.currentFile = null;
            $scope.project = new Project.get({id: $routeParams.id});

            $scope.tab = function(tab) {
                $(".tab-content .tab-pane").removeClass('active');
                $('#'+tab).addClass('active');
            }
        }]);