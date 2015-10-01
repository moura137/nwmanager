
/**
 * Service ProjectTask
 */
angular.module('app.services')
    .service('ProjectTask', ['$resource', 'Settings', function($resource, Settings) {
        return $resource(Settings.apiUrl + '/project/:id/task/:idTask', {
            id: '@id',
            idTask: '@idTask'
        }, {
            query: {
                isArray: false
            },
            update: {
                method: 'PUT'
            }
        });
    }]);