(function () {
    'use strict';

    angular
        .module('app')
        .component('errorList', {
            templateUrl: 'app/components/error-message/error-list.tpl.html',
            controller: controller,
            controllerAs: 'vm',
            bindings: {
                form: '=',
                title: '@',
                labels: '='
            },
        });

    controller.$inject = ['_'];

    function controller(_) {
        var vm = this;

        vm.getFieldLabel = getFieldLabel;
        vm.getErrors = getErrors;

        activate();

        function activate() {
            vm.title = vm.title || 'Existen campos inválidos o faltantes:';
            vm.labels = vm.labels || [];
        }

        function getFieldLabel(fieldName) {
            var result = fieldName;
            var item = _.find(vm.labels, { name: fieldName });
            if (item) {
                result = item.label;
            }
            return _.capitalize(result);
        }

        function getErrors() {
            var errors = [];

            _.forEach(vm.form.$error, function (condition) {
                _.forEach(condition, function (field) {
                    var name = getFieldLabel(field.$name);
                    if (errors.indexOf(name) < 0) {
                        errors.push(name);
                    }
                });
            });
            return errors;
        }
    }
})();
