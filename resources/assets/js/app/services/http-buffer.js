angular.module('http-auth-interceptor-buffer', [])
.factory('httpBuffer', ['$injector', function($injector) {
    
    //Requests buffer
    var buffer = [];

    //HTTP service, initialized later due to circular dependency
    var $http;

    function retryHttpRequest(config, deferred) {
        console.log('retryHttpRequest');

        //Get the http service now
        $http = $http || $injector.get('$http');

        //Retry the request
        $http(config).then(function(response) {
            console.log('successCallback');
            deferred.resolve(response);
        }, function(reason) {
            console.log('errorCallback');
            deferred.reject(reason);
        });
    }

    return {

        /**
         * Store a new request in the buffer
         */
        add: function(config, deferred) {
            console.log('add');
            buffer.push({
                config: config,
                deferred: deferred
            });
            return deferred.promise;
        },

        /**
         * Retries all the buffered requests clears the buffer.
         */
        retryAll: function() {
            console.log('retryAll');

            for (var i = 0; i < buffer.length; ++i) {
                retryHttpRequest(buffer[i].config, buffer[i].deferred);
            }

            this.clear();
        },

        /**
         * Clear the buffer (without rejecting requests)
         */
        clear: function() {
            console.log('clear');
            buffer = [];
        },

        /**
         * Reject all the buffered requests
         */
        rejectAll: function(reason) {
            console.log('rejectAll');
            
            //Loop all buffered requests and reject them
            for (var i = 0; i < buffer.length; i++) {
                buffer[i].deferred.reject(reason);
            }

            //Clear the buffer
            this.clear();
        },
    };
}]);