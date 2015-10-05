/**
 * Controller ProjectFile List
 */
angular.module('app.controllers')
    .controller('ProjectFileListCtrl',
        ['$scope', '$rootScope', '$stateParams', 'ProjectFile',
        function($scope, $rootScope, $stateParams, ProjectFile) {
            $scope.project_id = $stateParams.id;

            $scope.searchFiles = function(page) {
                $rootScope.clearError();
                $scope.deleting = [];

                ProjectFile.query(
                    {'search': $scope.q, 'page': page},
                    {id: $stateParams.id},
                    function(res) {
                        $scope.files = res.data;
                        $scope.files_pagination = res.meta.pagination;
                    });

                $scope.searched = ($scope.q!="")
            };

            $scope.clear = function() {
                $scope.q = '';
                $scope.searchFiles();
            };

            $scope.clear();

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

                        $scope.searchFiles();

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

                        $scope.searchFiles();

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
        }]);