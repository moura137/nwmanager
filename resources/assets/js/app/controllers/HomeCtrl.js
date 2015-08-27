/**
 * Controller Home
 */
angular.module('app.controllers')
    .controller('HomeCtrl', 
        ['$scope', '$rootScope', 
        function($scope, $rootScope) {
            $rootScope.clearError();
        }]);