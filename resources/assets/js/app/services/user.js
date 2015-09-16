
/**
 * Service User
 */
angular.module('app.services')
    .service('User', ['$resource', 'Settings', function($resource, Settings) {
        return $resource(Settings.baseUrl + '/user/:id', {id: '@id'}, {
            query: {
                isArray: false
            },
            update: {
                method: 'PUT'
            },
            all: {
                url: Settings.baseUrl + '/user',
                method: 'GET',
                isArray: true,
                transformResponse: function(data, headersGetter) {
                    var headers = headersGetter();
                    if (headers['content-type'] == 'application/json' || headers['content-type'] == 'text/json') {
                      dataJson = JSON.parse(data);
                      if (dataJson.hasOwnProperty('data')) {
                        dataJson = dataJson.data;
                      }
                      return dataJson;
                    }
                    return data;
                }
            },
        });
    }]);