/**
 * USAGE: <project-file-download></project-file-download>
 */
angular.module('app.directives')
.directive('projectFileDownload', [
    '$timeout', 'Settings', 'ProjectFile',
    function($timeout, Settings, ProjectFile)
    {
        return {
            restrict: 'E',
            templateUrl: Settings.basePath + '/build/views/templates/directives/project-file-download.html',
            link: function(scope, element, attrs) {
                var anchor = element.children()[0];

                scope.$on('disable-button', function(event) {
                    $(anchor).prop('disabled', true)
                        .addClass('disabled')
                        .find('span')
                        .text('Carregando...');
                });

                scope.$on('enable-button', function(event) {
                    $(anchor).prop('disabled', false)
                        .removeClass('disabled')
                        .find('span')
                        .text('Download');
                });

                scope.$on('save-file', function(event, data) {
                    scope.$emit('enable-button');

                    // Convert Base64 to Blob
                    blobUtil.base64StringToBlob(data.file, data.mime).then(function (blob) {
                      // success
                      var newAchor = $(anchor)
                        .clone()
                        .attr('href', blobUtil.createObjectURL(blob))
                        .attr('download', data.filename)
                        .find('i')
                        .removeClass('fa-download')
                        .addClass('fa-arrow-circle-o-down')
                        .end()
                        .appendTo($(anchor).parent());

                        $(anchor).remove();

                        $timeout(function() {
                            $(newAchor)[0].click();
                        });

                    }).catch(function (err) {
                      // error
                      console.log(err);
                    });
                });
            },
            controller: [
                '$scope', '$element', '$attrs', 'ProjectFile',
                function($scope, $element, $attrs, ProjectFile) {

                    var anchor = $element.children()[0];

                    $scope.downloadFile = function() {
                        var idFile = $attrs.idFile;
                        var projectId = $attrs.projectId;

                        $scope.$emit('disable-button');

                        ProjectFile.downloadFile({
                            'id': projectId,
                            'idFile': idFile
                        },
                        function (data, headers) {
                            $scope.$emit('save-file', data);
                        },
                        function (response, headers) {
                            $scope.$emit('enable-button');

                            window.swal({
                                title: "Erro no Download",
                                text: response.data.error_description,
                                type: "error"
                            });
                        });
                    };
            }]
        }
    }]);