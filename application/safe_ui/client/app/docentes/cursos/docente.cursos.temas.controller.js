(function () {
    'use strict';

    angular.module('app.docente.cursos')
        .controller('TemaCursosEdit', controller);

    controller.$inject = ['_', '$q', '$state','logger', 'debugModeEnabled', '$stateParams', 'DocenteCursos', 'UsuarioService', 'NgTableParams' ]; 
    
    function controller(_, $q, $state, logger, debugModeEnabled, $stateParams, DocenteCursos, UsuarioService, NgTableParams) {
        var vm = this;
        vm.debug = debugModeEnabled;
        vm.loading = true;
        vm.noDataConceptos = true; 
        vm.groupInfoGral = { isOpen: true };
        vm.groupConceptos = { isOpen: true };
        
        vm.fieldLabels = [
            { name: 'titulo', label: 'Título' },
            { name: 'descripcion', label: 'Descripción' },
        ];

        vm.agregarNuevoConcepto = agregarNuevoConcepto;
        vm.eliminarConcepto = eliminarConcepto;
        vm.puedeEliminar = puedeEliminar;
        vm.puedeRecuperar = puedeRecuperar;
        vm.recuperarConcepto = recuperarConcepto;

        vm.guardar = guardar;
        vm.cancel = cancel;
        
        vm.predecesoras = [];
        
        vm.conceptosTableParams = new NgTableParams({
            page: 1,
            count: 10
        }, {
            total: 0,
            counts: [10, 20, 50, 100],
            getData: getConceptosTabla
        });  
        
        activate();
        
        function activate() {
            $q.all([cargaTema(), cargarTemasCurso(), cargaConceptosTema()])
                .then(onLoadComplete);       
            
            function cargaTema() {
                var tema = DocenteCursos.one(UsuarioService.getUserCurrentDoc()).one('cursos', $stateParams.idCurso).one('temas', $stateParams.id);  
                return  tema.get().then(onSuccess, onError);

                function onSuccess(response) {            
                    vm.tema = response.plain();     
                }        
                function onError(httpResponse) {
                    logger.error('No se pudo obtener el Curso', httpResponse);
                }   
            }
            
            function cargarTemasCurso(){
                var curso = DocenteCursos.one(UsuarioService.getUserCurrentDoc()).one('cursos', $stateParams.idCurso).one('temas');

                return  curso.get().then(onSuccess, onError);

                function onSuccess(response) {            
                    vm.cursoTemas = response.plain();     
                }        
                function onError(httpResponse) {
                    logger.error('No se pudo obtener los datos del tema', httpResponse);
                }        
            }
            
            function cargaConceptosTema() {
                var conceptos = DocenteCursos.one(UsuarioService.getUserCurrentDoc()).one('cursos', $stateParams.idCurso).one('temas', $stateParams.id).one('conceptos');
                
                return conceptos.get().then(onSuccess, onError);

                function onSuccess(response) {            
                    vm.conceptos = response.plain();     
                }        
                function onError(httpResponse) {
                    logger.error('No se pudo obtener los datos del tema', httpResponse);
                }                     
            }
            
            function onLoadComplete() {
                vm.loading = false;
                setTitle();
                
                _.forEach(vm.tema.predecesoras, function(value) {
                    vm.predecesoras.push(value.id);
                });
                
                vm.tema.predecesoras = vm.predecesoras;
                
                vm.cantidadConceptos = _.size(vm.conceptos);                
                if(vm.cantidadConceptos !== 0) vm.noDataConceptos = false; 
            }
            
            function setTitle() {
                vm.title = 'Editar Tema';
            }    
        }

        function getConceptosTabla(params) {
            params.total(vm.conceptos.length);

            var result = vm.conceptos.slice((params.page() - 1) * params.count(), params.page() * params.count());
            return result;              
        }
        
        function agregarNuevoConcepto() {
            /*CrearTemaPopup.show(vm.curso.id, UsuarioService.getUserCurrentDoc(), vm.curso.temas, vm.curso, false).then(onClose);
            
            function onClose() {
                $state.reload();
            }*/
        }
        
        function eliminarConcepto(concepto) {
           /* var title = '¿Desea eliminar el conpecto ' + concepto.titulo + '?, perderá la configuración de predecesoras y orden.';
            messageBox.showOkCancel(title)
                .then(function (answer) {
                    if (answer === 'ok') {
                        var temaRemove = DocenteCursos.one(UsuarioService.getUserCurrentDoc()).one('cursos', vm.curso.id).one('temas', tema.id);  
                        var temaPut =
                        {
                            titulo: tema.titulo, 
                            descripcion: tema.descripcion, 
                            orden: tema.orden,
                            predecesoras: [],
                            habilitado: false,
                        };                
                        temaRemove.customPUT(temaPut).then(onSuccess, onError); 
                    }
                });
            
            function onSuccess() {
                logger.info('Registro eliminado');
                $state.reload()
            }

            function onError(httpResponse) {
                logger.error('No se pudo eliminar el tema', httpResponse);
            }            */
        }

        function recuperarConcepto(concepto) {
          /*  var title = '¿Desea recuperar el tema ' + tema.titulo + '?';
            messageBox.showOkCancel(title)
                .then(function (answer) {
                    if (answer === 'ok') {
                        var temaRecuperar = DocenteCursos.one(UsuarioService.getUserCurrentDoc()).one('cursos', vm.curso.id).one('temas', tema.id);  
                        var temaPut =
                        {
                            titulo: tema.titulo, 
                            descripcion: tema.descripcion, 
                            orden: tema.orden,
                            predecesoras: [],
                            habilitado: true,
                        };                
                        temaRecuperar.customPUT(temaPut).then(onSuccess, onError); 
                    }
                });
            
            function onSuccess() {
                logger.info('Registro recuperado');
                $state.reload();
            }

            function onError(httpResponse) {
                logger.error('No se pudo recuperar el tema', httpResponse);
            }  */
        }           
        
        function puedeEliminar(concepto){
            if(concepto.habilitado === true){
                return true;
            }else{
                return false;
            }
        }
        
        function puedeRecuperar(concepto){
            if(concepto.habilitado === true){
                return false;
            }else{
                return true;
            }
        }
        
        function guardar() {
            
        }
        
        function cancel() {
            goBack();
        }
        
        function goBack() {
            $state.go('docente.cursos.edit', { 'id': $stateParams.idCurso});
        }
    }    
})(); 
