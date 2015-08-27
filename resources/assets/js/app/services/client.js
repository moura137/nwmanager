/**
 * Service Client
 */

angular.module('app.services')
    .service('Client', ['$resource', 'Settings', function($resource, Settings) {
        return $resource(Settings.baseUrl + '/client/:id', {id: '@id'}, {
            update: {
                method: 'PUT'
            }
        });
    }]);