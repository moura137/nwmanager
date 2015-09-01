
/**
 * Service ProjectFile
 */
angular.module('app.services')
    .service('ProjectFile', ['$resource', 'Settings', function($resource, Settings) {
        return $resource(Settings.baseUrl + '/project/:id/file/:idFile', {
            id: '@id',
            idFile: '@idFile'
        }, {
            save: {
                method: 'POST',
                headers: { 'Content-Type': undefined },
                transformRequest: function (data, headersGetter) {
                    var formData = new FormData();
                    angular.forEach(data, function (value, key) {
                        formData.append(key, value);
                    });
                    return formData;
                },
            },
            
            downloadFile: {
                url: Settings.baseUrl + '/project/:id/file/:idFile/download',
                method: 'GET',
                responseType: 'arraybuffer',
                transformResponse: function(data, headersGetter) {
                    return { data : data };
                }
            },
            
            displayFile: {
                url: Settings.baseUrl + '/project/:id/file/:idFile/display',
                method: 'GET',
                responseType: 'arraybuffer',
                transformResponse: function(data, headersGetter) {
                    return { data : data };
                }
            },

            deleteFile: {
                method: 'DELETE'
            }
        });
    }]);