
/**
 * Service Oauth
 */
angular.module('app.services')
    .service('AuthUser', ['$resource', 'Settings', function($resource, Settings) {
        return $resource(Settings.baseUrl + '/oauth/:action', {}, {
            user: {
                method: 'GET',
                params: { action: 'user' }
            }
        });
    }]);