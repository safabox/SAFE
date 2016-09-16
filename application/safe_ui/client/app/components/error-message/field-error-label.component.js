(function () {
    'use strict';

    angular
        .module('app')
        .component('fieldErrorLabel', {
            templateUrl: 'app/components/error-message/field-error-label.tpl.html',
            controller: controller,
            controllerAs: 'vm',
            bindings: {
                field: '=',
                fieldLabel: '@',
                requiredMessage: '@',
                invalidMessage: '@'
            },
        });

    controller.$inject = [];

    function controller() {
        var vm = this;

        activate();

        function activate() {
            vm.fieldLabel = vm.fieldLabel || '';
            vm.requiredMessage = vm.requiredMessage || 'El campo ' + vm.fieldLabel + ' es obligatorio';
            vm.invalidMessage = vm.invalidMessage || 'El campo ' + vm.fieldLabel + ' es inválido';
        }
    }
})();
