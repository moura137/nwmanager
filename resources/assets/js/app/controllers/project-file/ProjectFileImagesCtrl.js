/**
 * Controller ProjectFile Index Upload
 */
angular.module('app.controllers')
    .controller('ProjectFileImagesCtrl', 
        ['$scope', '$rootScope', '$stateParams', '$filter', 'Settings', 'OAuthToken', 'ProjectFile', 'FileUploader', 
        function($scope, $rootScope, $stateParams, $filter, Settings, OAuthToken, ProjectFile, FileUploader) {
            $scope.project_id = $stateParams.id;
            $scope.files = [];
            $scope.deleting = [];
            $scope.limitSize = 2; // MB
            $scope.error_add = [];

            $scope.query = function(search) {
                $rootScope.clearError();
                $scope.files = ProjectFile.query(search, {id: $stateParams.id});
                $scope.deleting = [];
            };

            $scope.query();

            $scope.clearErrorAdd = function() {
                $scope.error_add = [];
            }

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
                    ProjectFile.deleteAll({id: $stateParams.id}, {'_method': 'DELETE', 'files' : $scope.deleting}, function(response){

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

            var uploader = $scope.uploader = new FileUploader({
                url: Settings.apiUrl + '/project/'+$stateParams.id+'/file',
                formData: [{'description': 'Imagem'}],
                //autoUpload: true,
                headers: {Authorization: OAuthToken.getAuthorizationHeader()},
            });

            // FILTERS
            uploader.filters.push({
                name: 'imageType',
                fn: function(item /*{File|FileLikeObject}*/, options) {
                    var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
                    return '|jpg|png|jpeg|gif|'.indexOf(type) !== -1;
                }
            });

            // FILTERS
            uploader.filters.push({
                name: 'imageSize',
                fn: function(item /*{File|FileLikeObject}*/, options) {
                    var size = item.size/1024/1024; //MB
                    return size <= $scope.limitSize;
                }
            });

            // CALLBACKS
            uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {

                var error = '';
                switch(filter.name){
                    case 'imageType':
                        error += ' &bull; Tipo do Arquivo não permitido!';
                    break;
                    case 'imageSize':
                        error += ' &bull; Arquivo excede o tamanho permitido '+$scope.limitSize+'MB';
                    break;
                    default:
                        error += ' &bull; Erro ao tentar inserir o Arquivo!';
                    break;
                }
                size = $filter('formatSize')(item.size);
                error += ' (<em><b>Arquivo:</b> ' + item.name + ' - <b>Size:</b> '+size+' - <b>Type:</b> '+item.type+'</em>)';

                $scope.error_add.push(error);
            };

            uploader.onProgressItem = function(fileItem, progress) {
                fileItem.error_description = '';
            };

            uploader.onSuccessItem = function(fileItem, response, status, headers) {
                $scope.files.push(response);
                fileItem.remove();
            };

            uploader.onErrorItem = function(fileItem, response, status, headers) {
                fileItem.error_description = response.error_description;
            };
        }]);