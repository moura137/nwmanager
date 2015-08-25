/**
 * Controller Client List
 */
angular.module('app.controllers')
    .controller('ClientListCtrl', ['$scope', 'Client', function($scope, Client) {
        $scope.entities = Client.query();
    }]);