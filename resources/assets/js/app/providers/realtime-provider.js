/**
 * ------ Providers ------------
 */
angular.module('app.providers')

.provider('Realtime',['BROADCAST_DRIVER', function(BROADCAST_DRIVER) {
    return {
        configure: function(driver) {
            this.driver = driver;
        },

        $get: ['$RealtimeFactory', function($RealtimeFactory) {
            var driver = this.driver || BROADCAST_DRIVER;
            return $RealtimeFactory(driver);
        }]
    };
}])

.factory('$RealtimeFactory',
    ['RealtimePusher', 'RealtimeFanout', 'RealtimeFaye', 'RealtimeSocketCluster', 'RealtimeLog',
    function (RealtimePusher, RealtimeFanout, RealtimeFaye, RealtimeSocketCluster, RealtimeLog) {
        function RealtimeFactory(driver) {
            if (!(this instanceof RealtimeFactory)) {
                switch(driver) {
                    case 'pusher':
                        return RealtimePusher;
                    break;
                    case 'fanout':
                        return RealtimeFanout;
                    break;
                    case 'faye':
                        return RealtimeFaye;
                    break;
                    case 'socketcluster':
                        return RealtimeSocketCluster;
                    break;
                    default:
                    case 'log':
                        console.log('RealtimeLog');
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

        var self = this;
        return {
            connect: function () {
                if (!this.socket) {
                    var client = new Pusher(Settings.broadcast.pusher.ApiKey);
                    this.socket = $pusher(client);
                }
            },

            disconnect: function () {
                if (this.socket) {
                    this.socket.disconnect();
                    this.socket = null;
                }
            },

            bind: function (channelName, eventName, callback) {
                if (this.socket) {
                    var channel = this.socket.subscribe(channelName);
                    channel.bind(eventName, callback);
                }
            },

            on: function (channelName, eventName, callback) {
                if (this.socket) {
                    var channel = this.socket.subscribe(channelName);
                    channel.unbind(eventName);
                    channel.bind(eventName, callback);
                }
            },

            once: function (channelName, eventName, callback) {
                if (this.socket) {
                    var channel = this.socket.subscribe(channelName);

                    channel.bind(eventName, function g() {
                        channel.unbind(eventName, g);
                        callback.apply(this, arguments);
                    });
                }
            },

            off: function (channelName, eventName) {
                if (this.socket) {
                    if (eventName) {
                        this.socket.channel(channelName).unbind(eventName);
                    } else {
                        this.socket.unsubscribe(channelName);
                    }
                }
            }
        };
    }])

.service('RealtimeFanout',
    ['Settings',
    function (Settings) {
        this.socket = null;

        var self = this;
        return {
            connect: function () {
                if (!self.socket) {
                    var url = 'https://'+Settings.broadcast.fanout.realmId+'.fanoutcdn.com/bayeux';
                    self.socket = new Faye.Client(url);
                }
            },

            disconnect: function () {
                if (self.socket) {
                    self.socket.disconnect();
                    self.socket = null;
                }
            },

            bind: function (channelName, eventName, callback) {
                if (self.socket) {
                    var channel = self.socket.subscribe('/'+channelName, function(data) {
                        if (data.event == eventName) {
                            callback(data.data);
                        }
                    });
                }
            },

            on: function (channelName, eventName, callback) {
                if (self.socket) {
                    self.socket.unsubscribe('/'+channelName);

                    var channel = self.socket.subscribe('/'+channelName, function(data) {
                        if (data.event == eventName) {
                            callback(data.data);
                        }
                    });
                }
            },

            once:  function (channelName, eventName, callback) {
                if (self.socket) {
                    var channel = self.socket.subscribe('/'+channelName, function g(data) {
                        if (data.event == eventName) {
                            self.socket.unsubscribe('/'+channelName, g);
                            callback(data.data);
                        }
                    });
                }
            },

            off: function (channelName, eventName) {
                if (self.socket) {
                    self.socket.unsubscribe('/'+channelName);
                }
            }
        };
    }])


.service('RealtimeFaye',
    ['Settings',
    function (Settings) {
        this.socket = null;

        var self = this;
        return {
            connect: function () {
                if (!self.socket) {
                    self.socket = new Faye.Client(Settings.broadcast.faye.url);
                }
            },

            disconnect: function () {
                if (self.socket) {
                    self.socket.disconnect();
                    self.socket = null;
                }
            },

            bind: function (channelName, eventName, callback) {
                if (self.socket) {
                    var channel = self.socket.subscribe('/'+channelName, function(data) {
                        if (data.event == eventName) {
                            callback(data.data);
                        }
                    });
                }
            },

            on: function (channelName, eventName, callback) {
                if (self.socket) {
                    self.socket.unsubscribe('/'+channelName);

                    var channel = self.socket.subscribe('/'+channelName, function(data) {
                        if (data.event == eventName) {
                            callback(data.data);
                        }
                    });
                }
            },

            once:  function (channelName, eventName, callback) {
                if (self.socket) {
                    var channel = self.socket.subscribe('/'+channelName, function g(data) {
                        if (data.event == eventName) {
                            self.socket.unsubscribe('/'+channelName, g);
                            callback(data.data);
                        }
                    });
                }
            },

            off: function (channelName, eventName) {
                if (self.socket) {
                    self.socket.unsubscribe('/'+channelName);
                }
            }
        };
    }])

.service('RealtimeSocketCluster',
    ['Settings',
    function (Settings) {
        this.socket = null;

        var self = this;
        return {
            connect: function () {
                if (!this.socket) {
                    this.socket = socketCluster.connect(Settings.broadcast.socketcluster);
                }
            },

            disconnect: function () {
                if (this.socket) {
                    this.socket.disconnect();
                    this.socket = null;
                }
            },

            bind: function (channelName, eventName, callback) {
                if (self.socket) {
                    self.socket.watch(channelName, function(data) {
                        if (data.event == eventName) {
                            callback(data.data);
                        }
                    });
                }
            },

            on: function (channelName, eventName, callback) {
                if (self.socket) {
                    self.socket.unwatch(channelName);

                    self.socket.watch(channelName, function(data) {
                        if (data.event == eventName) {
                            callback(data.data);
                        }
                    });
                }
            },

            once: function (channelName, eventName, callback) {
                if (self.socket) {
                    self.socket.watch(channelName, function g(data) {
                        if (data.event == eventName) {
                            self.socket.unwatch(channelName, g);
                            callback(data.data);
                        }
                    });
                }
            },

            off: function (channelName, eventName) {
                if (this.socket) {
                    self.socket.unwatch(channelName);
                }
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

    this.bind = function (channelName, eventName, callback) {
        console.log('BIND()', {
            'channelName': channelName,
            'eventName': eventName,
            'callback': callback
        });
    };

    this.on = function (channelName, eventName, callback) {
        console.log('ON()', {
            'channelName': channelName,
            'eventName': eventName,
            'callback': callback
        });
    };

    this.once = function (channelName, eventName, callback) {
        console.log('ONCE()', {
            'channelName': channelName,
            'eventName': eventName,
            'callback': callback
        });
    };

    this.off = function (channelName, eventName) {
        console.log('OFF()', {
            'channelName': channelName,
            'eventName': eventName,
        });
    };
});