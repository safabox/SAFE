(function () {
    'use strict';

    angular
        .module('app.crear-tema-popup')
        .service('CrearTemaPopup', service);

    service.$inject = ['$uibModal', '$q'];

    function service($uibModal, $q) {

        return {
            show: show,
        };

        function show(cursoId, docenteId, temas, curso) {
            var deferred = $q.defer();

            var modalInstance = $uibModal.open({
                size: 'lg',
                templateUrl: 'app/docentes/cursos/temas/crear-tema-popup/crear-tema-popup.tpl.html',
                controller: 'CrearTemaPopupController',
                controllerAs: 'vm',
                resolve: {
                    cursoId: function () { return cursoId; },
                    docenteId: function () { return docenteId; },
                    temas: function () { return temas; },
                    curso: function () { return curso; },
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
        }
    }
})();
