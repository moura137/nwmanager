/**
 * ------ Providers ------------
 */
angular.module('app.providers')
.provider('Settings',
    ['BASE_PATH', 'API_URL', 'CLIENT_ID', 'CLIENT_SECRET',
    function(BASE_PATH, API_URL, CLIENT_ID, CLIENT_SECRET){
        var config = {
            basePath: BASE_PATH,
            apiUrl: API_URL,
            clientId: CLIENT_ID,
            clientSecret: CLIENT_SECRET,
            project : {
                status: [
                    { value: '1', label: 'Aberto', style: 'primary'  },
                    { value: '2', label: 'Fechado', style: 'danger' },
                    { value: '3', label: 'Pausado', style: 'warning' }
                ]
            },
            utils : {
                responseRemoveData: function(data, headersGetter) {
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
            }
        };

        return {
            config: config,
            $get: function(){
                return config;
            }
        };
    }]);