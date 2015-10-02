angular.module('app.directives')
.directive('includeScope', ['$templateRequest', '$compile', function ($templateRequest, $compile) {
    return {
      restrict: 'AE',
      scope: false,
      link: function(scope, element, attr) {
        var src = attr.src;
        $templateRequest(src, true).then(function(response) {
            element.html($compile(response)(scope));
        });
      }
    };
}]);