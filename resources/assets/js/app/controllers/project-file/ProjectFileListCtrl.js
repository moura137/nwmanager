/**
 * Controller ProjectFile List
 */
angular.module('app.controllers')
    .controller('ProjectFileListCtrl', 
        ['$scope', '$rootScope', '$routeParams', '$filter', 'ProjectFile', 
        function($scope, $rootScope, $routeParams, $filter, ProjectFile) {
            $scope.project_id = $routeParams.id;
            
            $scope.query = function(search) {
                $rootScope.clearError();
                $scope.files = ProjectFile.query(search, {id: $routeParams.id});
                $scope.deleting = [];
            };

            $scope.query();

            $scope.deleteFile = function(file) {
                window.swal({
                    title: "Deseja excluir o Arquivo?",
                    type: "warning",
                    confirmButtonColor: "#DD6B55",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,

                }, function(){
                    ProjectFile.deleteFile({id: file.project_id, idFile: file.id}, {}, function(){
                        
                        $scope.query();

                        window.swal({
                            title: "Excluído!",
                            text: "Arquivo excluído com sucesso!",
                            type: "success",
                            timer: 1500,
                        });

                    }, function(response){
                        window.swal({
                            title: "Error!",
                            text: response.data.error_description,
                            type: "error"
                        });
                    });
                });
            };

            $scope.checkedAll = function($event) {
                var checked = $event.target.checked;
                $('input.chkfile').prop('checked', !checked).click();
            }

            $scope.chkDelete = function () {
                var deleting = [];
                $('input.chkfile:checked').each(function(k,v){
                    deleting.push(v.value);
                });
                $scope.deleting = deleting;
            }

            $scope.deleteAll = function() {
                if ($scope.deleting.length<=0) {
                    window.swal("Selecione um arquivo para Excluir!", "", "warning");
                    return;
                }

                window.swal({
                    title: "Deseja excluir os Arquivos?",
                    text: "Selecionados: " + $scope.deleting.length,
                    type: "warning",
                    confirmButtonColor: "#DD6B55",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,

                }, function(){
                    ProjectFile.deleteAll({id: $routeParams.id}, {'_method': 'DELETE', 'files' : $scope.deleting}, function(response){
                        
                        $scope.query();

                        window.swal({
                            title: "Exclusão Finalizada",
                            text: "Sucessos: " + response.result.success.length + "\nFalhas: " + response.result.fails.length,
                            type: "success",
                            timer: 1500,
                        });

                    }, function(response){
                        window.swal({
                            title: "Error!",
                            text: response.data.error_description,
                            type: "error"
                        });
                    });
                });
            };

            var arrayBufferToBase64 = function( buffer ) {
                var binary = '';
                var bytes = new Uint8Array( buffer );
                var len = bytes.byteLength;
                for (var i = 0; i < len; i++) {
                    binary += String.fromCharCode( bytes[ i ] );
                }
                return window.btoa( binary );
            };

            $scope.downloadFile = function(file, fileName) {
                ProjectFile.downloadFile({id: file.project_id, idFile: file.id}, {},
                function (res, headers) {
                    var data = res.data;

                    if (fileName==undefined) {
                        fileName = headers('content-disposition');
                        var regex = /^.*\"(.*)\".*$/;
                        fileName = fileName.replace(regex, "$1");
                    }

                    var blob = new Blob([data], {type: headers('content-type')});
                    var objectUrl = window.URL.createObjectURL(blob);
                    var a = document.createElement("a");
                    document.body.appendChild(a);
                    a.style = "display: none";
                    a.href = objectUrl;
                    a.download = fileName;
                    a.click();
                    window.URL.revokeObjectURL(objectUrl);
                    a.remove();
                },
                function (res, headers) {
                    window.swal({
                        title: "Error!",
                        text: 'Erro ao tentar efetuar o download',
                        type: "error"
                    });
                });
            };

            $scope.displayFile = function(file) {
                $scope.currentFile = file;

                ProjectFile.displayFile({id: file.project_id, idFile: file.id}, {},
                function (res, headers) {
                    var data = res.data;
                    var type = headers('content-type');
                    if (type == 'image/jpeg' || type == 'image/jpg' || type == 'image/gif' || type == 'image/png') {
                        var src = "data:"+type+";base64," + arrayBufferToBase64(data);
                        var img = document.getElementById("displayImg");
                        img.src = src;
                        $('#previewImg').modal('show');
                    } else {
                        $scope.downloadFile(file);
                    }
                }, function (res, headers) {
                    window.swal({
                        title: "Error!",
                        text: 'Erro ao tentar efetuar o download',
                        type: "error"
                    });
                });
            };
        }]);