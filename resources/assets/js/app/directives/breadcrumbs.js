angular.module('app.directives')
.directive('breadcrumbs', ['$rootScope', '$state', function($rootScope, $state){
    return {
        restrict: 'E',
        template: '<ol class="breadcrumb">' +
            '<li ng-repeat="crumb in breadcrumbs" ng-class="{ active: $last }">' +
            '<a ng-href="#[[ crumb.url ]]" ng-if="!$last">[[ crumb.title ]]&nbsp;</a>' +
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
                var currentUrl = '';
                var previousUrl = '';
                while(currentState && currentState.self.name !== '')
                {
                    currentUrl = currentState.self.url || '';

                    if (previousUrl != currentUrl) {
                        breadcrumbs.push({
                            'route': currentState.self.name,
                            'url': currentState.self.url || '/',
                            'title': currentState.self.title
                        });
                    }

                    currentState = currentState.parent;
                    previousUrl = currentUrl;

                    if (x>10) { break; } x++;
                }

                breadcrumbs.reverse();
                scope.breadcrumbs = breadcrumbs;
            }
        }
    };
}]);