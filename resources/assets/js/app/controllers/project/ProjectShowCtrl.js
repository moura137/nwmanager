/**
 * Controller Project Show
 */
angular.module('app.controllers')
    .controller('ProjectShowCtrl',
        ['$scope', '$rootScope', '$stateParams', 'Project', 'ProjectFile',
        function($scope, $rootScope, $stateParams, Project, ProjectFile)
        {
            $rootScope.clearError();
            $scope.currentFile = null;
            $scope.project = new Project.get({id: $stateParams.id});

            $scope.tab = function(tab) {
                $(".tab-content .tab-pane, .nav.nav-tabs li").removeClass('active');
                $('.tab-content .tab-pane#'+tab).addClass('active');
                $('.nav.nav-tabs li a[rel='+tab+']').closest('li').addClass('active');
            }

            if ($stateParams.tab) {
                $scope.tab($stateParams.tab);
            }
        }]);