/**
 * Service Activity
 */

angular.module('app.services')
    .service('Activity', ['$resource', 'Settings', function($resource, Settings) {
        return $resource(Settings.apiUrl + '/activities', {}, {
            query: {
                isArray: false
            },
        });
    }]);