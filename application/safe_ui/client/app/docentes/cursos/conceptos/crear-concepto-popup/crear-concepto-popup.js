(function () {
    'use strict';

    angular
        .module('app.crear-concepto-popup')
        .service('CrearConceptoPopup', service);

    service.$inject = ['$uibModal', '$q'];

    function service($uibModal, $q) {

        return {
            show: show,
        };

        function show(cursoId, docenteId, temaId, conceptoId) {
            var deferred = $q.defer();

            var modalInstance = $uibModal.open({
                size: 'lg',
                templateUrl: 'app/docentes/cursos/conceptos/crear-concepto-popup/crear-concepto-popup.tpl.html',
                controller: 'CrearConceptoPopupController',
                controllerAs: 'vm',
                resolve: {
                    cursoId: function () { return cursoId; },
                    docenteId: function () { return docenteId; },
                    temaId: function () { return temaId; },
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
