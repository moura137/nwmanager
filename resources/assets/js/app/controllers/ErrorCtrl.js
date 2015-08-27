/**
 * Controller Error
 */
angular.module('app.controllers')
    .controller('ErrorCtrl', 
        ['$scope', '$rootScope', 
        function($scope, $rootScope) {
            $rootScope.clearError();
        }]);