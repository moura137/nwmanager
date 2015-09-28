
/**
 * Service ProjectFile
 */
angular.module('app.services')
    .service('ProjectFile', ['$resource', 'Settings', function($resource, Settings) {
        return $resource(Settings.apiUrl + '/project/:id/file/:idFile', {
            id: '@id',
            idFile: '@idFile'
        }, {
            query: {
                isArray: false
            },
            save: {
                method: 'POST',
                headers: { 'Content-Type': undefined },
                transformRequest: function (data, headersGetter) {
                    var formData = new FormData();
                    angular.forEach(data, function (value, key) {
                        if (value instanceof FileList) {
                            if (value.length == 1) {
                              formData.append(key, value[0]);
                            } else {
                              angular.forEach(value, function(file, index) {
                                formData.append(key + '_' + index, file);
                              });
                            }
                        } else {
                            formData.append(key, value);
                        }
                    });
                    return formData;
                },
            },

            downloadFile: {
                url: Settings.apiUrl + '/project/:id/file/:idFile/download',
                method: 'GET'
            },

            displayFile: {
                url: Settings.apiUrl + '/project/:id/file/:idFile/display',
                method: 'GET',
                responseType: 'arraybuffer',
                transformResponse: function(data, headersGetter) {
                    return { data : data };
                }
            },

            deleteFile: {
                method: 'DELETE'
            },

            deleteAll: {
                url: Settings.apiUrl + '/project/:id/files',
                method: 'POST',
            }
        });
    }]);