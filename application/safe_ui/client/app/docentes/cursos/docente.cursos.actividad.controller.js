(function () {
    'use strict';

    angular.module('app.docente.cursos')
        .controller('ActividadCursosEdit', controller);

    controller.$inject = ['_', '$q', 'DocenteCursos', '$state', 'logger', 'debugModeEnabled', '$stateParams', 'UsuarioService']; 
    
    function controller(_, $q, DocenteCursos, $state, logger, debugModeEnabled, $stateParams, UsuarioService) {
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
        
        vm.agregarEjercicio = agregarEjercicio;
        vm.eliminarEjercicio = eliminarEjercicio;        
        
        activate();
        
        function activate() {
            $q.all([])
                .then(onLoadComplete);       
        
            function onLoadComplete() {
                vm.loading = false;
                vm.ejerciciosSeleccionados = [];
                setTitle();
            }
            
            function setTitle() {
                if (vm.editMode) {
                    vm.title = 'Editar Curso ' + $stateParams.id;
                    vm.subTitle = 'MODIFICACION CURSO';
                }else{
                    vm.title = 'Nueva Actividad';
                }
            }             
        }
        
        function agregarEjercicio(tipo) {
          
            vm.ejerciciosSeleccionados.push({
                tipo: tipo.id,
                descripcion: tipo.descripcion,
            });            
            
        }
        
        function eliminarEjercicio(idx, event) {
            vm.ejerciciosSeleccionados.splice(idx, 1);
            event.stopPropagation();
            event.preventDefault();
        }
    }    
})(); 
