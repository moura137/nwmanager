/**
 * ------ Providers ------------
 */
angular.module('app.providers')
.provider('Settings',
    ['BASE_PATH', 'API_URL', 'CLIENT_ID', 'CLIENT_SECRET', 'AUTH_SECURE', 'BROADCAST_DRIVER', 'PUSHER_API_KEY', 'FANOUT_REALM_ID',
    function(BASE_PATH, API_URL, CLIENT_ID, CLIENT_SECRET, AUTH_SECURE, BROADCAST_DRIVER, PUSHER_API_KEY, FANOUT_REALM_ID){
        var config = {
            basePath: BASE_PATH,
            apiUrl: API_URL,
            clientId: CLIENT_ID,
            clientSecret: CLIENT_SECRET,
            secure: AUTH_SECURE,
            broadcast: {
                driver: BROADCAST_DRIVER,
                pusher: {
                    ApiKey: PUSHER_API_KEY
                },
                fanout: {
                    realmId: FANOUT_REALM_ID
                },
                faye: {
                    url: 'http://localhost:8001/faye'
                },
                socketcluster: {
                    secure: false,
                    port: 8001,
                    hostname: 'localhost',
                    path: '/socketcluster/'
                },
            },
            project : {
                status: [
                    { value: '1', label: 'Aberto', style: 'primary'  },
                    { value: '2', label: 'Fechado', style: 'danger' },
                    { value: '3', label: 'Pausado', style: 'warning' }
                ]
            },
            projectTask : {
                status: [
                    { value: '0', label: 'Incompleta', style: 'warning' },
                    { value: '1', label: 'Completa', style: 'success' }
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