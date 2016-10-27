(function () {
    'use strict';

    angular
        .module('app.crear-concepto-popup')
        .controller('CrearConceptoPopupController', controller);

    controller.$inject = ['_', '$q', 'cursoId', 'docenteId', 'temaId', 'debugModeEnabled', '$uibModalInstance', 'logger', 'DocenteCursos', 'concepto'];

    function controller(_, $q, cursoId, docenteId, temaId, debugModeEnabled, $uibModalInstance, logger, DocenteCursos, concepto) {
        var vm = this;
        vm.loading = true;
        vm.debug = debugModeEnabled;

        vm.cursoId = cursoId;
        vm.docenteId = docenteId;
        vm.temaId = temaId;
        vm.predecesoras = [];
                
        vm.ok = ok;
        vm.cancel = cancel;

        activate();

        function activate() {
            loadData();
            
            function loadData() {
                $q.all([cargarConceptosTema()])
                    .then(onLoadComplete);
                
                function cargarConceptosTema(){
                    var temaConceptos = DocenteCursos.one(vm.docenteId).one('cursos', vm.cursoId).one('temas', vm.temaId).one('conceptos');
                    
                    return  temaConceptos.get().then(onSuccess, onError);

                    function onSuccess(response) {            
                        vm.temaConceptos = response.plain();     
                    }        
                    function onError(httpResponse) {
                        logger.error('No se pudo obtener los conceptos del tema', httpResponse);
                    }                            
                }
                
                function onLoadComplete() {
                    vm.loading = false;
                    vm.title = 'Crear Concepto';
                }                
            }
        }

        function ok() {
            vm.tipo = concepto.tipo;
            vm.rango = concepto.rango;
            vm.metodo = concepto.metodo;
            vm.incremento = concepto.incremento;
            
            DocenteCursos.newConcepto(vm.titulo, vm.descripcion, vm.copete, vm.orden, vm.predecesoras, vm.tipo, vm.rango, vm.metodo, vm.incremento, vm.cursoId, vm.docenteId, vm.temaId).then(onSuccess, onError);
            
            function onSuccess(response) {
                logger.info('Se guardó el concepto');
                $uibModalInstance.close(response);
            }

            function onError() {
                logger.error('No se pudo guardar el concepto');
            }
        }

        function cancel() {
            $uibModalInstance.dismiss();
        }
    }
})();
