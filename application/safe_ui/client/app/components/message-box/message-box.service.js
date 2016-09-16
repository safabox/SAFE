(function () {
    'use strict';

    angular
        .module('app')
        .factory('messageBox', factory);

    factory.$inject = ['$uibModal', '$q'];

    function factory($uibModal, $q) {
        return {
            show: show,
            showOkCancel: showOkCancel
        };

        function show(title, content, buttons, size) {
            var deferred = $q.defer();

            var modalInstance = $uibModal.open({
                templateUrl: 'app/components/message-box/message-box.tpl.html',
                controller: controller,
                controllerAs: 'vm',
                size: size,
                resolve: {
                    title: getTitle,
                    content: getContent,
                    buttons: getButtons
                }
            });

            modalInstance.result.then(onClose, onDismiss);

            return deferred.promise;

            function onClose(result) {
                deferred.resolve(result);
            }

            function onDismiss(reason) {
                deferred.reject(reason);
            }

            function getTitle() {
                return title;
            }

            function getContent() {
                return content;
            }

            function getButtons() {
                return buttons || [{
                    caption: 'Aceptar',
                    answer: 'ok',
                    type: 'primary'
                }];
            }
        }

        function showOkCancel(title, content) {
            var buttons = [
                {
                    caption: 'Aceptar',
                    answer: 'ok',
                    type: 'primary'
                },
                {
                    caption: 'Cancelar',
                    answer: 'cancel',
                    type: 'default'
                },
            ];
            return show(title, content, buttons);
        }
    }

    controller.$inject = ['$uibModalInstance', 'title', 'content', 'buttons'];

    function controller($uibModalInstance, title, content, buttons) {
        var vm = this;

        vm.title = title;
        vm.content = content;
        vm.buttons = buttons;

        vm.click = click;

        function click(answer) {
            $uibModalInstance.close(answer);
        }
    }
})();
