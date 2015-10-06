/**
 * Service Client
 */

angular.module('app.services')
    .service('Client', ['$resource', 'Settings', function($resource, Settings) {
        return $resource(Settings.apiUrl + '/client/:id', {id: '@id'}, {
            query: {
                isArray: false
            },
            update: {
                method: 'PUT'
            },
            all: {
                url: Settings.apiUrl + '/client',
                method: 'GET',
                isArray: true,
                transformResponse: Settings.utils.responseRemoveData
            },
        });
    }]);