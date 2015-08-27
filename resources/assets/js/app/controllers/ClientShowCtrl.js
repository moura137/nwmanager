/**
 * Controller Client Show
 */
angular.module('app.controllers')
    .controller('ClientShowCtrl', 
        ['$scope', '$rootScope', '$routeParams', 'Client', 
        function($scope, $rootScope, $routeParams, Client)
        {
            $rootScope.clearError();
            $scope.entity = new Client.get({id: $routeParams.id});
        }]);