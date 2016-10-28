(function () {
    'use strict';

    angular.module('app.docente.cursos')
        .controller('TemaCursosEdit', controller);

    controller.$inject = ['_', '$q', '$state','logger', 'debugModeEnabled', '$stateParams', 'DocenteCursos', 'UsuarioService', 'NgTableParams', 'CrearConceptoPopup', 'messageBox', 'concepto' ]; 
    
    function controller(_, $q, $state, logger, debugModeEnabled, $stateParams, DocenteCursos, UsuarioService, NgTableParams, CrearConceptoPopup, messageBox, concepto) {
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
        
        vm.docenteId = UsuarioService.getUserCurrentDoc();
        vm.cursoId = $stateParams.idCurso;
        vm.temaId = $stateParams.id;
            
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
                var tema = DocenteCursos.one(vm.docenteId).one('cursos', vm.cursoId).one('temas', vm.temaId);  
                return  tema.get().then(onSuccess, onError);

                function onSuccess(response) {            
                    vm.tema = response.plain();     
                }        
                function onError(httpResponse) {
                    logger.error('No se pudo obtener el Curso', httpResponse);
                }   
            }
            
            function cargarTemasCurso(){
                var curso = DocenteCursos.one(vm.docenteId).one('cursos', vm.cursoId).one('temas');

                return  curso.get().then(onSuccess, onError);

                function onSuccess(response) {            
                    vm.cursoTemas = response.plain();     
                }        
                function onError(httpResponse) {
                    logger.error('No se pudo obtener los datos del tema', httpResponse);
                }        
            }
            
            function cargaConceptosTema() {
                var conceptos = DocenteCursos.one(vm.docenteId).one('cursos', vm.cursoId).one('temas', vm.temaId).one('conceptos');
                
                return conceptos.get().then(onSuccess, onError);

                function onSuccess(response) {            
                    vm.conceptos = response.plain();     
                }        
                function onError(httpResponse) {
                    logger.error('No se pudo obtener los conceptos del tema', httpResponse);
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
                
                _.forEach(vm.cursoTema, function(value) {
                    if(value.id == vm.temaId) {
                        vm.cursoTema.splice(value,1);
                    }
                });
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
            CrearConceptoPopup.show(vm.cursoId, vm.docenteId, vm.temaId).then(onClose);
            
            function onClose() {
                $state.reload();
            }
        }
        
        function eliminarConcepto(conc) {
            var title = '¿Desea eliminar el conpecto ' + conc.titulo + '?, perderá la configuración de predecesoras y orden.';
            messageBox.showOkCancel(title)
                .then(function (answer) {
                    if (answer === 'ok') {
                        var conceptoRemove = DocenteCursos.one(vm.docenteId).one('cursos', vm.cursoId).one('temas', vm.temaId).one('concepto',concepto.id);  
                        var conceptoPut =
                        {
                            titulo: conc.titulo, 
                            descripcion: conc.descripcion,
                            copete: conc.copete, 
                            orden: conc.orden,
                            predecesoras: conc.predecesoras,
                            tipo: concepto.tipo,
                            rango: concepto.rango,
                            metodo: concepto.metodo,
                            incremento: concepto.incremento,
                            habilitado: false,
                        };                
                        conceptoRemove.customPUT(conceptoPut).then(onSuccess, onError); 
                    }
                });
            
            function onSuccess() {
                logger.info('Registro eliminado');
                $state.reload()
            }

            function onError(httpResponse) {
                logger.error('No se pudo eliminar el concepto', httpResponse);
            } 
        }

        function recuperarConcepto(conc) {
            var title = '¿Desea recuperar el concepto ' + conc.titulo + '?';
            messageBox.showOkCancel(title)
                .then(function (answer) {
                    if (answer === 'ok') {
                        var conceptoRecupero = DocenteCursos.one(vm.docenteId).one('cursos', vm.cursoId).one('temas', vm.temaId).one('concepto',concepto.id);  
                        var conceptoPut =
                        {
                            titulo: conc.titulo, 
                            descripcion: conc.descripcion,
                            copete: conc.copete, 
                            orden: conc.orden,
                            predecesoras: conc.predecesoras,
                            tipo: concepto.tipo,
                            rango: concepto.rango,
                            metodo: concepto.metodo,
                            incremento: concepto.incremento,
                            habilitado: false,
                        };                            
                        conceptoRecupero.customPUT(conceptoPut).then(onSuccess, onError); 
                    }
                });
            
            function onSuccess() {
                logger.info('Registro recuperado');
                $state.reload();
            }

            function onError(httpResponse) {
                logger.error('No se pudo recuperar el concepto', httpResponse);
            }  
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
            var putEntity = {
                titulo: vm.tema.titulo, 
                descripcion: vm.tema.descripcion,
                copete: vm.tema.copete,
                orden: vm.tema.orden,
                predecesoras: vm.tema.predecesoras,
                habilitado: true,
            };
            
            var tema = DocenteCursos.one(vm.docenteId).one('cursos', vm.cursoId).one('temas', vm.temaId);
            
            tema.customPUT(putEntity).then(onSuccess,onError);
            
            function onSuccess() {
                logger.info('Tema Guardado');
                vm.form.$dirty = false;
                goBack();
            }
            function onError(httpResponse) {
                console.log(httpResponse);
                logger.error('No se pudo guardar el tema', httpResponse);
            }
            
        }
        
        function cancel() {
            goBack();
        }
        
        function goBack() {
            $state.go('docente.cursos.edit', { 'id': $stateParams.idCurso});
        }
    }    
})(); 
