/**
 * Service Client
 */

angular.module('app.services')
    .service('Client', ['$resource', 'Settings', function($resource, Settings) {
        return $resource(Settings.baseUrl + '/client/:id', {id: '@id'}, {
            query: {
                isArray: false
            },
            update: {
                method: 'PUT'
            },
            all: {
                url: Settings.baseUrl + '/client',
                method: 'GET',
                isArray: true,
                transformResponse: Settings.utils.responseRemoveData
            },
        });
    }]);