angular.module('app.directives')
.directive('inputFile', function () {
    return {
        require: 'ngModel',
        link: function (scope, el, attrs, ngModel) {
            // console.log(scope);
            el.bind('change', function (event) {
                scope.$apply(function () {
                    var files = event.target.files;
                    var file = null;

                    if (files.length > 0) {
                        file = files[0];
                        
                        // MaxSize in MB
                        var maxSize = parseInt(attrs.ngMaxSize)||0;
                        if (file.size > (maxSize * 1024 * 1024)) {
                            ngModel.$setValidity("maxSize", false);
                        } else {
                            ngModel.$setValidity("maxSize", true);
                        }
                    }

                    ngModel.$setViewValue(file);
                    ngModel.$render();
                });
            });
        }
    };
});