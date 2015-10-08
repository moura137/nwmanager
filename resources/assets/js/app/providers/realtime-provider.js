/**
 * ------ Providers ------------
 */
angular.module('app.providers')

.provider('Realtime',['SettingsProvider', function(SettingsProvider) {
    return {
        configure: function(driver) {
            this.driver = driver;
        },

        $get: ['$RealtimeFactory', function($RealtimeFactory) {
            var driver = this.driver || SettingsProvider.config.broadcast.driver;
            return $RealtimeFactory(driver);
        }]
    };
}])

.factory('$RealtimeFactory',
    ['RealtimePusher', 'RealtimeLog',
    function (RealtimePusher, RealtimeLog) {
        function RealtimeFactory(driver) {
            if (!(this instanceof RealtimeFactory)) {
                switch(driver) {
                    case 'pusher':
                        return RealtimePusher;
                    break;
                    default:
                    case 'log':
                        console.log('RealtimeLog')
                        return RealtimeLog;
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
                var client = new Pusher(Settings.broadcast.pusher.ApiKey);
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
    }])

.service('RealtimeLog', function () {
    this.connect = function () {
        console.log('CONNECT()');
    };

    this.disconnect = function () {
        console.log('DICONNECT()');
    };

    this.on = function (channelName, eventName, callback, context) {
        console.log('ON()', {
            'channelName': channelName,
            'eventName': eventName,
            'callback': callback,
            'context': context
        });
    };

    this.off = function (channelName, eventName) {
        console.log('OFF()', {
            'channelName': channelName,
            'eventName': eventName,
        });
    };

    this.channel = function (channelName) {
        console.log('CHANNEL()', channelName);
    };
});