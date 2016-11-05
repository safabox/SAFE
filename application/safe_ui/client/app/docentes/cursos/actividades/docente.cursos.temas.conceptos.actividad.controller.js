(function () {
    'use strict';

    angular.module('app.docente.cursos')
        .controller('ActividadCursosEdit', controller);

    controller.$inject = ['_', '$q', '$state', 'logger', 'debugModeEnabled', '$stateParams', 'configIrtTipoUno', 'configIrtTipoDos', 'DocenteCursos', 'UsuarioService']; 
    
    function controller(_, $q, $state, logger, debugModeEnabled, $stateParams, configIrtTipoUno, configIrtTipoDos, DocenteCursos, UsuarioService) {
        var vm = this;
        vm.debug = debugModeEnabled;
        vm.editMode = ($state.includes('**.editAct'));
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

                if(vm.editMode){
                    var actividad = DocenteCursos.one(vm.docenteId).one('cursos', vm.cursoId).one('temas', vm.temaId).one('conceptos', vm.conceptoId).one('actividads', vm.actividadId);  
                    return actividad.get().then(onSuccess, onError);
                } else {
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
                
                vm.toolbar =    [
                    ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'pre', 'quote'],
                    ['bold', 'italics', 'underline', 'strikeThrough', 'ul', 'ol', 'redo', 'undo', 'clear'],
                    ['justifyLeft', 'justifyCenter', 'justifyRight', 'indent', 'outdent'],
                    ['html', 'insertImage','insertLink', 'insertVideo', 'wordcount', 'charcount']
                ];
                
                if (vm.editMode){
                    vm.title = 'Editar Actividad ';
                    vm.subTitle = 'MODIFICACION CURSO';
                    setActividad();
                }
                else{
                    vm.title = 'Nueva Actividad';                    
                    vm.actividad = {};
                    vm.actividad.ejercicio = [];
                    vm.actividad.resultado = [];
                }         

                function setActividad() {
                    
                    if(vm.actividad.ejercicio[0].tipo == 1){
                        var i = 0                    
                        _.forEach(vm.actividad.ejercicio[0].respuestas, function() {
                            vm.actividad.ejercicio[0].respuestas[i].correcta = false;
                            i++;
                        }); 

                        _.forEach(vm.actividad.resultado, function(value) {
                            var i = 0;
                            _.forEach(vm.actividad.ejercicio[0].respuestas, function(valueRes) {
                                if(value == valueRes.id){
                                    vm.actividad.ejercicio[0].respuestas[i].correcta = true;
                                }
                                i++;
                            }); 
                        }); 
                    } else {
                        var i = 0                    
                        _.forEach(vm.actividad.ejercicio[0].respuestas, function() {
                            vm.actividad.ejercicio[0].respuestas[i].verdadero = false;
                            vm.actividad.ejercicio[0].respuestas[i].falso = false;
                            i++;
                        });
                        
                        _.forEach(vm.actividad.resultado, function(value) {
                            var i = 0;
                            _.forEach(vm.actividad.ejercicio[0].respuestas, function(valueRes) {
                                if(value.id == valueRes.id && value.resultado == true){
                                    vm.actividad.ejercicio[0].respuestas[i].verdadero = true;
                                }
                                if(value.id == valueRes.id && value.resultado == false){
                                    vm.actividad.ejercicio[0].respuestas[i].falso = true;
                                }
                                
                                i++;
                            }); 
                        }); 
                    }
                }
               
            }                      
        }
        
        function agregarEjercicio(tipo) {
            
            setConfigIrt(tipo.id);
            
            vm.actividad.ejercicio.push({
                tipo: tipo.id,
                descripcion: tipo.descripcion,
            });            
            
            function setConfigIrt(tipo){            
                if(tipo == 1){
                    vm.actividad.discriminador = configIrtTipoUno.discriminador;
                    vm.actividad.azar = configIrtTipoUno.azar;
                    vm.actividad.d = configIrtTipoUno.d;
                    vm.actividad.tipo = configIrtTipoUno.tipo;  
                } else {
                    vm.actividad.discriminador = configIrtTipoDos.discriminador;
                    vm.actividad.azar = configIrtTipoDos.azar;
                    vm.actividad.d = configIrtTipoDos.d;
                    vm.actividad.tipo = configIrtTipoDos.tipo; 
                }
            }       
        }
        
        function eliminarEjercicio(idx, event) {
            vm.actividad.ejercicio.splice(idx, 1);
            event.stopPropagation();
            event.preventDefault();
        }
        
        function guardar() {
            var guardo = false;
            var noGuardo = true;
             
            vm.actividad.resultado = [];            
            
            
            switch(vm.actividad.ejercicio[0].tipo) {
                case 1:
                    
                    var i = 0;
                    _.forEach(vm.actividad.ejercicio[0].respuestas, function(value) {
                        if(value.correcta === true){
                            vm.actividad.resultado.push(value.id);
                            guardo = true;
                        }
                        delete vm.actividad.ejercicio[0].respuestas[i].correcta;
                        i++;
                    });  
                    
                    if(guardo) {
                        if(vm.editMode) {                
                            DocenteCursos.editAct(vm.actividad.titulo, vm.actividad.descripcion, vm.actividad.ejercicio, vm.actividad.resultado, vm.actividad.dificultad, vm.actividad.discriminador, vm.actividad.azar, vm.actividad.d, vm.actividad.tipo, vm.cursoId, vm.docenteId, vm.temaId, vm.conceptoId, vm.actividad.id).then(onSuccess, onError);
                        }else {                
                            DocenteCursos.newActividad(vm.actividad.titulo, vm.actividad.descripcion, vm.actividad.ejercicio, vm.actividad.resultado, vm.actividad.dificultad, vm.actividad.discriminador, vm.actividad.azar, vm.actividad.d, vm.actividad.tipo, vm.cursoId, vm.docenteId, vm.temaId, vm.conceptoId, vm.actividad.id).then(onSuccess, onError);        
                        }
                    } else  {
                        logger.error('Tiene que seleccionar al menos una respuesta correcta');
                    }      
                    
                    break;
                    
                case 2:
                    
                    _.forEach(vm.actividad.ejercicio[0].respuestas, function(value) {
                       if(value.verdadero == false && value.falso == false)
                       {
                           noGuardo = false;
                       }
                   }); 

                    if(noGuardo){
                        var i = 0;
                        _.forEach(vm.actividad.ejercicio[0].respuestas, function(value) {
                            if(value.verdadero == true){
                                vm.actividad.resultado.push({id: value.id, resultado: true});
                            }
                            if(value.verdadero == false){
                                vm.actividad.resultado.push({id: value.id, resultado: false});
                            }
                            delete vm.actividad.ejercicio[0].respuestas[i].verdadero;
                            delete vm.actividad.ejercicio[0].respuestas[i].falso;
                            i++;
                        });     
                    }     
 
                    if(noGuardo) {
                        if(vm.editMode) {                
                            DocenteCursos.editAct(vm.actividad.titulo, vm.actividad.descripcion, vm.actividad.ejercicio, vm.actividad.resultado, vm.actividad.dificultad, vm.actividad.discriminador, vm.actividad.azar, vm.actividad.d, vm.actividad.tipo, vm.cursoId, vm.docenteId, vm.temaId, vm.conceptoId, vm.actividad.id).then(onSuccess, onError);
                        }else {                
                            DocenteCursos.newActividad(vm.actividad.titulo, vm.actividad.descripcion, vm.actividad.ejercicio, vm.actividad.resultado, vm.actividad.dificultad, vm.actividad.discriminador, vm.actividad.azar, vm.actividad.d, vm.actividad.tipo, vm.cursoId, vm.docenteId, vm.temaId, vm.conceptoId, vm.actividad.id).then(onSuccess, onError);        
                        }
                    } else  {
                        if(!noGuardo){
                            logger.error('Tiene que seleccionar al menos una respuesta correcta');
                        }
                    }                    
                    
                    break;
                default:
                    logger.error('Error selección de ejercucio');
            }
            
            function onSuccess() {
                logger.info('Se guardó la actividad');
                goBack();
            }

            function onError() {
                logger.error('No se pudo guardar la actividad');
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
