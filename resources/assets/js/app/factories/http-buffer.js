angular.module('app.factories')
.factory('httpBuffer', ['$injector', function($injector) {

    //Requests buffer
    var buffer = [];

    //HTTP service, initialized later due to circular dependency
    var $http;

    function retryHttpRequest(config, deferred) {
        //Get the http service now
        $http = $http || $injector.get('$http');

        //Retry the request
        $http(config).then(function(response) {
            deferred.resolve(response);
        }, function(reason) {
            deferred.reject(reason);
        });
    }

    return {

        /**
         * Store a new request in the buffer
         */
        add: function(config, deferred) {
            buffer.push({
                config: config,
                deferred: deferred
            });
            return deferred.promise;
        },

        /**
         * Retries all the buffered requests clears the buffer.
         */
        retryAll: function(configUpdater) {
            var updater = configUpdater || function(config) {return config;};
            for (var i = 0; i < buffer.length; ++i) {
                retryHttpRequest(updater(buffer[i].config), buffer[i].deferred);
            }

            this.clear();
        },

        /**
         * Reject all the buffered requests
         */
        rejectAll: function(reason) {
            //Loop all buffered requests and reject them
            for (var i = 0; i < buffer.length; i++) {
                buffer[i].deferred.reject(reason);
            }

            //Clear the buffer
            this.clear();
        },

        /**
         * Clear the buffer (without rejecting requests)
         */
        clear: function() {
            buffer = [];
        },
    };
}]);