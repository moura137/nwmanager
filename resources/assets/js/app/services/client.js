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