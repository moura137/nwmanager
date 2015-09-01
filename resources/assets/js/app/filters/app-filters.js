angular.module('app.filters')
.filter('nl2br', function() {
  return function(input) {
    if (input !== void 0) {
      return input.replace(/\n/g, '<br>');
    }
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