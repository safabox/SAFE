(function () {
    'use strict';

    angular
        .module('app.crear-concepto-popup')
        .controller('CrearConceptoPopupController', controller);

    controller.$inject = ['_', '$q', 'cursoId', 'docenteId', 'temaId', 'conceptoId', 'debugModeEnabled', '$uibModalInstance', 'logger', 'DocenteCursos'];

    function controller(_, $q, cursoId, docenteId, temaId, conceptoId, debugModeEnabled, $uibModalInstance, logger, DocenteCursos) {
        var vm = this;
        vm.loading = true;
        vm.debug = debugModeEnabled;

        vm.cursoId = cursoId;
        vm.docenteId = docenteId;
        vm.temaId = temaId;
        vm.conceptoId = conceptoId;
        vm.predecesoras = [];
                
        vm.ok = ok;
        vm.cancel = cancel;

        activate();

        function activate() {
            loadData();
            
            function loadData() {
                $q.all([cargarConcepto(), cargarConceptosTema()])
                    .then(onLoadComplete);
                
                function cargarConcepto(){
                    var tema = DocenteCursos.one(vm.docenteId).one('cursos', vm.cursoId).one('temas', vm.idTema).one('conceptos', vm.conceptoId);  
                    return  tema.get().then(onSuccess, onError);

                    function onSuccess(response) {            
                        vm.concepto = response.plain();     
                    }        
                    function onError(httpResponse) {
                        logger.error('No se pudo obtener los datos del concepto', httpResponse);
                    }        
                }
                
                function cargarConceptosTema(){
                    var temaConceptos = DocenteCursos.one(vm.docenteId).one('cursos', vm.cursoId).one('temas', vm.idTema).one('conceptos');
                    
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
            DocenteCursos.newConcepto(vm.titulo, vm.descripcion, vm.copete, vm.orden, vm.predecesoras, vm.tipo, vm.rango, vm.metodo, vm.incremento, vm.cursoId, vm.docenteId, vm.temaId).then(onSuccess, onError);
            
            function onSuccess(response) {
                logger.info('Se guardó el tema');
                $uibModalInstance.close(response);
            }

            function onError() {
                logger.error('No se pudo guardar el tema');
            }
        }

        function cancel() {
            $uibModalInstance.dismiss();
        }
    }
})();
