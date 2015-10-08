/**
 * ------ Providers ------------
 */
angular.module('app.providers')
.provider('Realtime',function() {
    return {
        configure: function(driver){
            this.driver = driver;
        },

        $get: ['$RealtimeFactory', function($RealtimeFactory) {
            return $RealtimeFactory(this.driver);
        }]
    };
})

.factory('$RealtimeFactory',
    ['RealtimePusher',
    function (RealtimePusher) {
        function RealtimeFactory(driver) {
            if (!(this instanceof RealtimeFactory)) {
                switch(driver) {
                    default:
                    case 'pusher':
                        return RealtimePusher;
                    break;
                }
            }
        };

        return RealtimeFactory;
    }])

.service('RealtimePusher',
    ['$pusher', 'Settings',
    function ($pusher, Settings) {
        this.socket = null;

        this.connect = function () {
            if (!this.socket) {
                var client = new Pusher(Settings.Pusher.ApiKey);
                this.socket = $pusher(client);
            }
        };

        this.disconnect = function () {
            if (this.socket) {
                this.socket.disconnect();
                this.socket = null;
            }
        };

        this.on = function (channelName, eventName, callback, context) {
            if (this.socket) {
                var channel = this.socket.subscribe(channelName);
                channel.unbind(eventName);
                channel.bind(eventName, callback, context);
            }
        };

        this.off = function (channelName, eventName) {
            if (this.socket) {
                if (eventName) {
                    this.channel(channelName).unbind(eventName);
                } else {
                    this.socket.unsubscribe(channelName);
                }
            }
        };

        this.channel = function (channelName) {
            if (this.socket) {
                return this.socket.channel(channelName);
            }
        };
    }]);