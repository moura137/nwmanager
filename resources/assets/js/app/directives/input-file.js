angular.module('app.directives')
.directive('inputFile', function () {
    return {
        require: 'ngModel',
        link: function (scope, el, attrs, ngModel) {
            
            // Type with Pattern
            var validatePattern = function (file, attrs) {
                if (!attrs.pattern) {
                  return true;
                }
                var regexp = new RegExp(globStringToRegex(val), 'gi');
                return (file.type != null && regexp.test(file.type.toLowerCase()));
            };

            // Max Size in MB
            var validateMaxSize = function (file, attrs) {
                var maxSize = parseInt(attrs.ngMaxSize)||0;
                return (file.size <= (maxSize * 1024 * 1024));
            };

            el.bind('change', function (event) {
                scope.$apply(function () {
                    var files = event.target.files;
                    var file = null;

                    if (files.length > 0) {
                        file = files[0];
                        ngModel.$setValidity("pattern", validatePattern(file, attrs));
                        ngModel.$setValidity("maxSize", validateMaxSize(file, attrs));
                    }

                    ngModel.$setViewValue(file);
                    ngModel.$render();
                });
            });
        }
    };
});