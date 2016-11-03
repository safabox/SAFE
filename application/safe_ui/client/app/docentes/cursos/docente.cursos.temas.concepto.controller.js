(function () {
    'use strict';

    angular.module('app.docente.cursos')
        .controller('TemaConceptoCursosEdit', controller);

    controller.$inject = ['_', '$q', '$state','logger', 'debugModeEnabled', '$stateParams', 'DocenteCursos', 'UsuarioService', 'NgTableParams', 'messageBox', 'concepto' ]; 
    
    function controller(_, $q, $state, logger, debugModeEnabled, $stateParams, DocenteCursos, UsuarioService, NgTableParams, messageBox, concepto) {
        var vm = this;
        vm.debug = debugModeEnabled;
        vm.loading = true;
        vm.noDataActividad = true; 
        vm.groupInfoGral = { isOpen: true };
        vm.groupActividades = { isOpen: true };
        
        vm.fieldLabels = [
            { name: 'titulo', label: 'Título' },
            { name: 'descripcion', label: 'Descripción' },
        ];
        
        vm.docenteId = UsuarioService.getUserCurrentDoc();
        vm.cursoId = $stateParams.idCurso;
        vm.temaId = $stateParams.idTema;
        vm.conceptoId = $stateParams.id;
            
        vm.eliminarActividad = eliminarActividad;
        vm.recuperarActividad = recuperarActividad;
        vm.puedeEliminar = puedeEliminar;
        vm.puedeRecuperar = puedeRecuperar;
        
        vm.guardar = guardar;
        vm.cancel = cancel;
        
        vm.predecesoras = [];
        
        vm.actividadTableParams = new NgTableParams({
            page: 1,
            count: 10
        }, {
            total: 0,
            counts: [10, 20, 50, 100],
            getData: getActividadesTabla
        });  
        
        activate();
        
        function activate() {
            $q.all([cargaConcepto(), cargaActividadesConcepto(), cargarConceptosTema()])
                .then(onLoadComplete);       
            
            function cargaConcepto() {
                var concepto = DocenteCursos.one(vm.docenteId).one('cursos', vm.cursoId).one('temas', vm.temaId).one('conceptos', vm.conceptoId);
                return concepto.get().then(onSuccess, onError);

                function onSuccess(response) {            
                    vm.concepto = response.plain();     
                }        
                function onError(httpResponse) {
                    logger.error('No se pudo obtener el Concepto', httpResponse);
                }                  
            }
            
            function cargarConceptosTema(){
                var conceptos = DocenteCursos.one(vm.docenteId).one('cursos', vm.cursoId).one('temas', vm.temaId).one('conceptos');

                return  conceptos.get().then(onSuccess, onError);

                function onSuccess(response) {            
                    vm.conpceptosTema = response.plain();     
                }        
                function onError(httpResponse) {
                    logger.error('No se pudo obtener los datos de los conceptos', httpResponse);
                }        
            }
            
            function cargaActividadesConcepto() {
                var actividades = DocenteCursos.one(vm.docenteId).one('cursos', vm.cursoId).one('temas', vm.temaId).one('conceptos', vm.conceptoId).one('actividades');
                
                return actividades.get().then(onSuccess, onError);

                function onSuccess(response) {            
                    vm.actividades = response.plain();     
                }        
                function onError(httpResponse) {
                    logger.error('No se pudo obtener las actividades del concepto', httpResponse);
                }                     
            }
            
            function onLoadComplete() {
                vm.loading = false;
                setTitle();
                
                _.forEach(vm.concepto.predecesoras, function(value) {
                    vm.predecesoras.push(value.id);
                });
                
                vm.concepto.predecesoras = vm.predecesoras;
                
                vm.cantidadActividades = _.size(vm.actividades);                
                if(vm.cantidadActividades !== 0) vm.noDataActividad = false; 
                
                vm.toolbar = [
                    ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'pre', 'quote'],
                    ['bold', 'italics', 'underline', 'strikeThrough', 'ul', 'ol', 'redo', 'undo', 'clear'],
                    ['justifyLeft', 'justifyCenter', 'justifyRight', 'indent', 'outdent'],
                    ['html', 'insertImage','insertLink', 'insertVideo', 'wordcount', 'charcount']
                ];
                
                _.forEach(vm.conpceptosTema, function(value) {
                    if(value.id == vm.conceptoId) {
                        vm.conpceptosTema.splice(value,1);
                    }
                });
                
            }
            
            function setTitle() {
                vm.title = 'Editar Concepto';
            }    
        }

        function getActividadesTabla(params) {
            params.total(vm.actividades.length);

            var result = vm.actividades.slice((params.page() - 1) * params.count(), params.page() * params.count());
            return result;              
        }
                
        function eliminarActividad(actividad) {
            var title = '¿Desea eliminar la actividad ' + actividad.titulo + '?';
            messageBox.showOkCancel(title)
                .then(function (answer) {
                    if (answer === 'ok') {
                        var actividadRemove = DocenteCursos.one(vm.docenteId).one('cursos', vm.cursoId).one('temas', vm.temaId).one('conceptos',concepto.id).one('actividads', actividad.id);  
                        var actividadPath =
                        {  
                            habilitado: false,
                        };                
                        actividadRemove.patch(actividadPath).then(onSuccess, onError); 
                    }
                });
            
            function onSuccess() {
                logger.info('Registro eliminado');
                $state.reload()
            }

            function onError(httpResponse) {
                logger.error('No se pudo eliminar la actividad', httpResponse);
            } 
        }

        function recuperarActividad(actividad) {
            var title = '¿Desea recuperar la actividad ' + concepto.titulo + '?';
            messageBox.showOkCancel(title)
                .then(function (answer) {
                    if (answer === 'ok') {
                        var actividadRecupero = DocenteCursos.one(vm.docenteId).one('cursos', vm.cursoId).one('temas', vm.temaId).one('conceptos',concepto.id).one('actividads', actividad.id);  
                        var actividadPatch =
                        {   
                            habilitado: true,
                        };                
                        actividadRecupero.patch(actividadPatch).then(onSuccess, onError); 
                    }
                });
            
            function onSuccess() {
                logger.info('Registro recuperado');
                $state.reload();
            }

            function onError(httpResponse) {
                logger.error('No se pudo recuperar la actividad', httpResponse);
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
                titulo: vm.concepto.titulo, 
                descripcion: vm.concepto.descripcion,
                copete: vm.concepto.copete, 
                orden: vm.concepto.orden,
                predecesoras: vm.concepto.predecesoras,
                tipo: vm.concepto.tipo,
                rango: vm.concepto.rango,
                metodo: vm.concepto.metodo,
                incremento: vm.concepto.incremento,
            };
            
            var concepto = DocenteCursos.one(vm.docenteId).one('cursos', vm.cursoId).one('temas', vm.temaId).one('conceptos', vm.conceptoId);
            
            concepto.customPUT(putEntity).then(onSuccess,onError);
            
            function onSuccess() {
                logger.info('Concepto Guardado');
                vm.form.$dirty = false;
                goBack();
            }
            function onError(httpResponse) {
                console.log(httpResponse);
                logger.error('No se pudo guardar el concepto', httpResponse);
            }
            
        }
        
        function cancel() {
            goBack();
        }
        
        function goBack() {
            $state.go('docente.cursos.tema.edit', { 'id': vm.temaId , 'idCurso': vm.cursoId });
        }
    }    
})(); 
