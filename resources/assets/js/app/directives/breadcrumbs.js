angular.module('app.directives')
.directive('breadcrumbs', ['$rootScope', '$state', function($rootScope, $state){
    return {
        restrict: 'E',
        template: '<ol class="breadcrumb">' +
            '<li ng-repeat="crumb in breadcrumbs" ng-class="{ active: $last }">' +
            '<a ui-sref="[[ crumb.route ]]" ng-if="!$last">[[ crumb.title ]]&nbsp;</a>' +
            '<strong ng-show="$last">[[ crumb.title ]]</strong>' +
            '</li>' +
            '</ol>',
        link: function(scope) {
            scope.$on('$stateChangeSuccess', function() {
                updateBreadcrumbsArray();
            });

            updateBreadcrumbsArray();

            function updateBreadcrumbsArray()
            {
                var breadcrumbs = [];

                var currentState = $state.$current;
                var x = 0;
                while(currentState && currentState.self.name !== '' && !currentState.self.abstract)
                {
                    breadcrumbs.push({
                        'route': currentState.self.name,
                        'title': currentState.self.title
                    });
                    currentState = currentState.parent;
                    if (x>10) { break; } x++;
                }

                if (breadcrumbs.length > 1) {
                    breadcrumbs.push({
                        'route': 'painel.home',
                        'title': 'Home'
                    });
                    breadcrumbs.reverse();
                    scope.breadcrumbs = breadcrumbs;
                } else {
                    scope.breadcrumbs = [];
                }
            }
        }
    };
}]);