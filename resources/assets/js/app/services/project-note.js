
/**
 * Service ProjectNote
 */
angular.module('app.services')
    .service('ProjectNote', ['$resource', 'Settings', function($resource, Settings) {
        return $resource(Settings.apiUrl + '/project/:id/note/:idNote', {
            id: '@id',
            idNote: '@idNote'
        }, {
            query: {
                isArray: false
            },
            update: {
                method: 'PUT'
            }
        });
    }]);