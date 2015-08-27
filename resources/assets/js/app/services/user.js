
/**
 * Service User
 */
angular.module('app.services')
    .service('User', ['$resource', 'Settings', function($resource, Settings) {
        return $resource(Settings.baseUrl + '/user/:id', {id: '@id'}, {
            update: {
                method: 'PUT'
            }
        });
    }]);