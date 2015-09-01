
/**
 * Service Project
 */
angular.module('app.services')
    .service('Project', ['$resource', 'Settings', function($resource, Settings) {
        return $resource(Settings.baseUrl + '/project/:id', {id: '@id'}, {
            update: {
                method: 'PUT'
            }
        });
    }]);