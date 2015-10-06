/**
 * Controller Home
 */
angular.module('app.controllers')
    .controller('HomeCtrl',
        ['$scope', '$rootScope', 'Project',
        function($scope, $rootScope, Project) {
            $scope.activities = [
                {'entity_desc': 'Projeto 1', 'user_name': 'OreaSeca', 'diff_humans': '1 hora atrás', 'event': 'O status no novo site foi alterado para vencido'},
                {'entity_desc': 'Projeto xpto', 'user_name': 'OreaSeca', 'diff_humans': '1 hora atrás', 'event': 'O status no novo site foi alterado para vencido'},
                {'entity_desc': 'Projeto lala', 'user_name': 'OreaSeca', 'diff_humans': '1 hora atrás', 'event': 'O status no novo site foi alterado para vencido'},
                {'entity_desc': 'Projeto outro', 'user_name': 'OreaSeca', 'diff_humans': '1 hora atrás', 'event': 'O status no novo site foi alterado para vencido'},
            ];

            $scope.search = function(page) {
                $rootScope.clearError();

                Project.query({'search': $scope.q, 'page': page}, function(res) {
                    $scope.projects = res.data;
                    $scope.pagination = res.meta.pagination;
                });

                $scope.searched = ($scope.q!="");
            };

            $scope.search();
        }]);