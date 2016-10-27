(function () {
    'use strict';

    angular.module('app.docente.cursos')
        .controller('ActividadCursosEdit', controller);

    controller.$inject = ['_', '$q', '$state', 'logger', 'debugModeEnabled', '$stateParams', 'configIRT', 'DocenteCursos', 'UsuarioService']; 
    
    function controller(_, $q, $state, logger, debugModeEnabled, $stateParams, configIRT, DocenteCursos, UsuarioService) {
        var vm = this;
        vm.debug = debugModeEnabled;
        vm.editMode = ($state.includes('**.edit'));
        vm.loading = true;
        
        vm.docenteId = UsuarioService.getUserCurrentDoc();
        vm.cursoId = $stateParams.idCurso;
        vm.temaId = $stateParams.idTema;
        vm.conceptoId = $stateParams.idConcepto
        vm.actividadId = $stateParams.id;
        
        vm.groupInfoGral = { isOpen: true };
        vm.groupEjercicios = { isOpen: true };
        vm.groupEjercicio = { isOpen: true };
        
        vm.ejerciciosDisponibles = [
            {
                id: 1,
                descripcion: 'Multiple Choice - General'
            },
            {
                id: 2,
                descripcion: 'Multiple Choice - Matriz de Seleccion'
            },
        ];
        
        vm.fieldLabels = [
            { name: 'titulo', label: 'Título' },
            { name: 'descripcion', label: 'Descripción' },
            { name: 'dificultad', label: 'Dificultad' },
            { name: 'respuesta', label: 'Respuesta'},
        ];
        
        vm.agregarEjercicio = agregarEjercicio;
        vm.eliminarEjercicio = eliminarEjercicio;
        vm.guardar = guardar;
        vm.cancel = cancel;
        
        activate();
        
        function activate() {
            $q.all([cargaActividad()])
                .then(onLoadComplete);       
            
            function cargaActividad() {
                var actividad = DocenteCursos.one(vm.docenteId).one('cursos', vm.cursoId).one('temas', vm.temaId).one('conceptos', vm.conceptoId).one('actividads', vm.actividadId);  
                
                if(vm.editMode){
                    return  actividad.get().then(onSuccess, onError);
                }else {
                    return 0;
                }

                function onSuccess(response) {            
                    vm.actividad = response.plain();     
                }        
                function onError(httpResponse) {
                    logger.error('No se pudo obtener la actividad', httpResponse);
                }         
            }
            
            function onLoadComplete() {
                vm.loading = false;                
                
                
                if (vm.editMode){
                    vm.title = 'Editar Actividad ';
                    vm.subTitle = 'MODIFICACION CURSO';
                    setConfigIrt();                    
                }
                else{
                    vm.title = 'Nueva Actividad';                    
                    vm.actividad = {};
                    vm.actividad.ejercicio = [];
                    vm.actividad.resultado = 0;
                    setConfigIrt();
                }         
                
                function setConfigIrt(){
                    vm.actividad.discriminador = configIRT.discriminador;
                    vm.actividad.azar = configIRT.azar;
                    vm.actividad.d = configIRT.d;
                    vm.actividad.tipo = configIRT.tipo;                    
                }
            }                      
        }
        
        function agregarEjercicio(tipo) {
          
            vm.actividad.ejercicio.push({
                tipo: tipo.id,
                descripcion: tipo.descripcion,
            });            
            
        }
        
        function eliminarEjercicio(idx, event) {
            vm.actividad.ejercicio.splice(idx, 1);
            event.stopPropagation();
            event.preventDefault();
        }
        
        function guardar() {
            
            if(vm.editMode) {                
                DocenteCursos.editAct(vm.actividad.titulo, vm.actividad.descripcion, vm.actividad.ejercicio, vm.actividad.resultado, vm.actividad.dificultad, vm.actividad.discriminador, vm.actividad.azar, vm.actividad.d, vm.actividad.tipo, vm.cursoId, vm.docenteId, vm.temaId, vm.conceptoId, vm.actividad.id).then(onSuccess, onError);
            }else {                
                DocenteCursos.newActividad(vm.actividad.titulo, vm.actividad.descripcion, vm.actividad.ejercicio, vm.actividad.resultado, vm.actividad.dificultad, vm.actividad.discriminador, vm.actividad.azar, vm.actividad.d, vm.actividad.tipo, vm.cursoId, vm.docenteId, vm.temaId, vm.conceptoId, vm.actividad.id).then(onSuccess, onError);        
            }
            
            function onSuccess() {
                logger.info('Se guardó la actividad');
                goBack();
            }

            function onError() {
                logger.error('No se pudo guardar el concepto');
            }
        }
        
        function cancel() {
            goBack();
        }
        
        function goBack() {
            $state.go('docente.cursos.tema.concepto.edit', { 'id': vm.conceptoId, 'idTema': vm.temaId , 'idCurso': vm.cursoId });
        }
    }    
})(); 
