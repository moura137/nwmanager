/**
 * Service Client
 */

function resourceErrorHandler(response) {
    if(response.status === 404) {
        //$location('#/404');
        console.log('404');
    }
}

angular.module('app.services')
    .service('Client', ['$resource', 'Settings', function($resource, Settings) {
        return $resource(Settings.baseUrl + '/client/:id', {id: '@id'}, {
            update: {
                method: 'PUT'
            },
            get: {
                method:'GET', 
                interceptor : {responseError : resourceErrorHandler}
            }
        });
    }]);