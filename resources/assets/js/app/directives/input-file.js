angular.module('app.directives')
.directive('inputFile', function () {
    return {
        scope: true, //create a new scope
        link: function (scope, el, attrs) {
            el.on('change', function (event) {
                var files = event.target.files;
                if (files.length > 0) {
                    for (var i = 0;i<files.length;i++) {
                        //emit event upward
                        scope.$emit("fileSelected", { file: files[i] });
                    }
                } else {
                    scope.$emit("fileSelected", { file: null });
                }
            });
        }
    };
});