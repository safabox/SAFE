(function () {
    'use strict';

    angular
        .module('app.crear-tema-popup')
        .controller('CrearTemaPopupController', controller);

    controller.$inject = ['_', '$q', 'cursoId', 'docenteId', 'temas', 'debugModeEnabled', '$uibModalInstance', 'logger', 'DocenteCursos', 'curso', 'editMode', 'idTema'];

    function controller(_, $q, cursoId, docenteId, temas, debugModeEnabled, $uibModalInstance, logger, DocenteCursos, curso, editMode, idTema) {
        var vm = this;
        vm.loading = true;
        vm.debug = debugModeEnabled;

        vm.cursoId = cursoId;
        vm.docenteId = docenteId;
        vm.temas = temas;
        vm.curso = curso;
        vm.editMode = editMode;
        vm.idTema = idTema;

        vm.ok = ok;
        vm.cancel = cancel;

        activate();

        function activate() {
            loadData();
            
            function loadData() {
                $q.all([cargarTema()])
                    .then(onLoadComplete);
                
                function cargarTema(){
                    var tema = DocenteCursos.one(vm.docenteId).one('cursos', vm.cursoId).one('temas', vm.idTema);  
                    return  tema.get().then(onSuccess, onError);

                    function onSuccess(response) {            
                        vm.tema = response.plain();     
                    }        
                    function onError(httpResponse) {
                        logger.error('No se pudo obtener los datos del tema', httpResponse);
                    }        
                }
                
                function onLoadComplete() {
                    vm.loading = false;
                    
                    if(vm.editMode) {
                        vm.title = 'Editar Tema';
                        vm.titulo = vm.tema.titulo;
                        vm.descripcion = vm.tema.descripcion;
                        vm.orden = vm.tema.orden;
                        vm.predecesoras = vm.tema.predecesoras;
                    }                    
                    else {
                        vm.title = 'Crear Tema';
                    }
                }                
            }
        }

        function ok() {
            DocenteCursos.new(vm.titulo, vm.descripcion, vm.orden, vm.predecesoras, vm.cursoId, vm.docenteId, vm.idTema, vm.editMode).then(onSuccess, onError);

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
