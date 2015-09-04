'use strict';
angular.module('nouislider', []).directive('slider', [
  '$timeout',
  function ($timeout) {
    return {
      restrict: 'A',
      scope: {
        start: '@',
        step: '@',
        end: '@',
        callback: '@',
        margin: '@',
        tooltips: '@',
        update: '@',
        slide: '@',
        set: '@',
        change: '@',
        showTooltip: '@',
        hideTooltip: '@',
        ngModel: '=',
        ngFrom: '=',
        ngTo: '=',
        ngTooltips: '='
      },
      link: function (scope, element, attrs) {
        var createTooltips, fromParsed, parsedValue, slider, toParsed, tooltips;
        slider = element[0];
        scope.showTooltip = function (values, handle) {
          tooltip.style.display = 'block';
        };
        scope.hideTooltip = function (values, handle) {
          console.log(tooltip);
          tooltip.style.display = 'none';
        };
        createTooltips = function () {
          var i, tipHandles, tooltipText, tooltips;
          if (scope.ngTooltips) {
            tooltipText = void 0;
            if (angular.isArray(scope.ngTooltips)) {
              tooltipText = scope.ngTooltips;
            } else {
              tooltipText = [scope.ngTooltips];
            }
            tipHandles = slider.getElementsByClassName('noUi-handle');
            tooltips = [];
            i = 0;
            while (i < tipHandles.length) {
              tooltips[i] = document.createElement('div');
              tipHandles[i].appendChild(tooltips[i]);
              tooltips[i].className += 'tooltip';
              tooltips[i].innerHTML = '<span></span>';
              tooltips[i] = tooltips[i].getElementsByTagName('span')[0];
              tooltips[i].innerHTML = tooltipText[i];
              i++;
            }
          }
          return tipHandles;
        };
        if (scope.ngFrom != null && scope.ngTo != null) {
          fromParsed = null;
          toParsed = null;
          noUiSlider.create(slider, {
            start: [
              scope.ngFrom || scope.start,
              scope.ngTo || scope.end
            ],
            step: parseFloat(scope.step) || void 0,
            connect: true,
            margin: parseFloat(scope.margin) || void 0,
            range: {
              min: [parseFloat(scope.start)],
              max: [parseFloat(scope.end)]
            }
          });
          if (scope.ngTooltips) {
            tooltips = createTooltips();
          }
          angular.forEach(scope.events, function (handler, event) {
            return slider.noUiSlider.on(event, function (values, handle) {
              return handler(values, handle);
            });
          });
          slider.noUiSlider.on('slide', function (values, handle) {
            var from, to, _ref;
            if (scope.tooltips) {
              tooltips[handle].getElementsByTagName('span')[0].innerHTML = scope.ngTooltips[handle];
            }
            _ref = slider.noUiSlider.get(), from = _ref[0], to = _ref[1];
            fromParsed = parseFloat(from);
            toParsed = parseFloat(to);
            return scope.$apply(function () {
              scope.ngFrom = fromParsed;
              return scope.ngTo = toParsed;
            });
          });
          scope.$watch('ngFrom', function (newVal, oldVal) {
            if (newVal !== fromParsed) {
              return slider.noUiSlider.set([
                newVal,
                null
              ]);
            }
          });
          return scope.$watch('ngTo', function (newVal, oldVal) {
            if (newVal !== toParsed) {
              return slider.noUiSlider.set([
                null,
                newVal
              ]);
            }
          });
        } else {
          parsedValue = null;
          noUiSlider.create(slider, {
            start: [scope.ngModel || scope.start],
            connect: 'lower',
            step: parseFloat(scope.step || 1),
            range: {
              min: [parseFloat(scope.start)],
              max: [parseFloat(scope.end)]
            }
          });
          if (scope.ngTooltips) {
            tooltips = createTooltips();
          }
          angular.forEach(scope.events, function (handler, event) {
            return slider.noUiSlider.on(event, function (values, handle) {
              return handler(values, handle);
            });
          });
          slider.noUiSlider.on('slide', function (values, handle) {
            if (scope.ngTooltips) {
              tooltips[handle].getElementsByTagName('span')[0].innerHTML = scope.ngTooltips[handle];
            }
            parsedValue = parseFloat(slider.noUiSlider.get());
            return $timeout(function () {
              return scope.$apply(function () {
                return scope.ngModel = parsedValue;
              });
            });
          });
          return scope.$watch('ngModel', function (newVal, oldVal) {
            if (newVal !== parsedValue) {
              return slider.noUiSlider.set(newVal);
            }
          });
        }
      }
    };
  }
]);