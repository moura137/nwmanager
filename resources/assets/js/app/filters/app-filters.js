angular.module('app.filters')
.filter('nl2br', function() {
  return function(input) {
    if (input !== void 0) {
      return input.replace(/\n/g, '<br>');
    }
  };
})

.filter('formatSize', function() {
  return function(input) {
    if (input !== void 0) {
        suffix = ' bytes';
        if (input >= 1024) {
            suffix = ' KB';
            input = input / 1024;
        }

        if (input >= 1024) {
            suffix = ' MB';
            input = input / 1024;
        }

        if (input >= 1024) {
            suffix = ' GB';
            input = input / 1024;
        }

        input = Math.round(input * 100) / 100

        return input + suffix;
    }
  };
})

.filter('strpad', function() {
  return function(input, n, c) {
    if (input !== void 0) {
        n = parseInt(n);
        if (c == undefined) {
            c = '0';
        }
        var pad = "0".repeat(n);
        input = (pad + input).slice(-1 * n);
    }
    return input;
  };
})

.filter('dateToISO', function() {
  return function(input) {
    if (input !== void 0) {
        input = input.replace(/ /, "T");
        return new Date(input).toISOString();
    }
  };
})

.filter('formatDateTime', ['$filter', function($filter) {
  return function(input) {
    if (input !== void 0) {
        input = $filter('dateToISO')(input);
        input = $filter('date')(input, 'dd/MM/yyyy HH:mm:ss', '+0000');
        return input;
    }
  };
}])

.filter('formatDate', ['$filter', function($filter) {
  return function(input) {
    if (input !== void 0) {
        input = $filter('dateToISO')(input);
        input = $filter('date')(input, 'dd/MM/yyyy', '+0000');
        return input;
    }
  };
}])

.filter('formatTime', ['$filter', function($filter) {
  return function(input) {
    if (input !== void 0) {
        input = $filter('dateToISO')(input);
        input = $filter('date')(input, 'HH:mm:ss', '+0000');
        return input;
    }
  };
}]);