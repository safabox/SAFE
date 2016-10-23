(function () {
    'use strict';

    angular.module('app.docente.cursos')
        .controller('ActividadCursosEdit', controller);

    controller.$inject = ['_', '$q', 'logger', 'debugModeEnabled', '$stateParams', 'configIRT' ]; 
    
    function controller(_, $q, logger, debugModeEnabled, $stateParams, configIRT) {
        var vm = this;
        vm.debug = debugModeEnabled;
        vm.loading = true;
        
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
                vm.actividad = {};
            }
            
            function onLoadComplete() {
                vm.loading = false;
                vm.actividad.ejercicio = [];
                setTitle();
                setConfigIrt();
            }
            
            function setTitle() {
                
                if (vm.editMode) {
                    vm.title = 'Editar Actividad ' + $stateParams.id;
                    vm.subTitle = 'MODIFICACION CURSO';
                }else{
                    vm.title = 'Nueva Actividad';
                }
            }    
            
            function setConfigIrt () {
                vm.actividad.discriminador = configIRT.discriminador;
                vm.actividad.azar = configIRT.azar;
                vm.actividad.d = configIRT.d;
                vm.actividad.tipo = configIRT.tipo;
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
            
        }
        
        function cancel() {
            goBack();
        }
    }    
})(); 
