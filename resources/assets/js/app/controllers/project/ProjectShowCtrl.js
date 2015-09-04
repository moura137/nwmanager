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
                $(".tab-content .tab-pane, .nav.nav-tabs li").removeClass('active');
                $('.tab-content .tab-pane#'+tab).addClass('active');
                $('.nav.nav-tabs li a[rel='+tab+']').closest('li').addClass('active');
            }

            if ($routeParams.tab) {
                $scope.tab($routeParams.tab);
            }
        }]);