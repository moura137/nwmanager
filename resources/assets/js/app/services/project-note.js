
/**
 * Service ProjectNote
 */
angular.module('app.services')
    .service('ProjectNote', ['$resource', 'Settings', function($resource, Settings) {
        return $resource(Settings.baseUrl + '/project/:id/note/:idNote', {
            id: '@id',
            idNote: '@idNote'
        }, {
            update: {
                method: 'PUT'
            }
        });
    }]);