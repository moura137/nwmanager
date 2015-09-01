// angular.module('app.directives')
// .directive('formGroup', function () {
//     return {
//         restrict: 'E',
//         transclude: true,
//         replace: true,
//         scope: {
//           input: "@input",
//           label: "@label",
//           errors: "="
//         },
//         template: ''+
//         '<div class="form-group" ng-class="{\'has-error\': !formProjectFile.description.$valid && formProjectFile.description.$touched}">'+
//         '    <label class="col-lg-3 control-label">Descrição *</label>'+
//         '    <div class="col-lg-9">'+
//         '        <input type="text" required maxlength="255" name="description" class="form-control" placeholder="Titulo" ng-model="file.description">'+
//         '        <div ng-messages="formProjectFile.description.$error" class="help-block" ng-show="!formProjectFile.description.$valid && formProjectFile.description.$touched">'+
//         '            <span ng-message="required">Campo obrigatório</span>'+
//         '        </div>'+
//         '    </div>'+
//         '</div>',
        
//         template: '<div class="form-group" ng-class="{\'has-error\': errors[input]}">'+
//         '<label ng-class="{\'control-label\': true, \'required\': required}" for="<% input %>"><% label %></label>' +
//         '<div ng-transclude></div>' +
//         '<p ng-repeat="error in errors[input]" class="help-block"><% error %></p>' +
//         '</div>',
//         link: function (scope, element, attrs, ctrl) {
//             scope.required = attrs.required!=undefined ? true : false;
//             element.find('input,select,textarea').addClass('form-control');        
//         }
//     };
// });