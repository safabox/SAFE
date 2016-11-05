(function () {
    'use strict';

    angular
        .module('app.crear-tema-popup')
        .controller('CrearTemaPopupController', controller);

    controller.$inject = ['_', '$q', 'cursoId', 'docenteId', 'temas', 'debugModeEnabled', '$uibModalInstance', 'logger', 'DocenteCursos', 'curso'];

    function controller(_, $q, cursoId, docenteId, temas, debugModeEnabled, $uibModalInstance, logger, DocenteCursos, curso) {
        var vm = this;
        vm.loading = true;
        vm.debug = debugModeEnabled;

        vm.cursoId = cursoId;
        vm.docenteId = docenteId;
        vm.temas = temas;
        vm.curso = curso;
        vm.predecesoras = [];
                
        vm.ok = ok;
        vm.cancel = cancel;

        activate();

        function activate() {
            loadData();
            
            function loadData() {
                $q.all([cargarTemasCurso()])
                    .then(onLoadComplete);
                
                function cargarTemasCurso(){
                    var curso = DocenteCursos.one(vm.docenteId).one('cursos', vm.cursoId).one('temas');
                    
                    return  curso.get().then(onSuccess, onError);

                    function onSuccess(response) {            
                        vm.cursoTemas = response.plain();     
                    }        
                    function onError(httpResponse) {
                        logger.error('No se pudo obtener los temas del curso', httpResponse);
                    }        
                    
                }
                
                function onLoadComplete() {
                    vm.loading = false;
                    vm.title = 'Crear Tema';
                }                
            }
        }

        function ok() {
            DocenteCursos.new(vm.titulo, vm.descripcion, vm.copete, vm.orden, vm.predecesoras, vm.cursoId, vm.docenteId).then(onSuccess, onError);

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
