/**
 * Controller Client Show
 */
angular.module('app.controllers')
    .controller('ClientShowCtrl', 
        ['$scope', '$rootScope', '$stateParams', 'Client', 
        function($scope, $rootScope, $stateParams, Client)
        {
            $rootScope.clearError();
            $scope.client = new Client.get({id: $stateParams.id});
        }]);