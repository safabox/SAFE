(function () {
    'use strict';

    angular.module('app.docente.cursos')
        .controller('DocenteCursosEdit', controller);

    controller.$inject = ['_', '$q', 'DocenteCursos', '$state', 'logger', 'debugModeEnabled', '$stateParams', 'UsuarioService']; 
    
    function controller(_, $q, DocenteCursos, $state, logger, debugModeEnabled, $stateParams, UsuarioService) {
        
        var vm = this;
        vm.loading = true;
        vm.debug = debugModeEnabled;
        vm.editMode = ($state.includes('**.edit'));
        vm.noDataTemas = true;
        vm.agregarNuevoTema = agregarNuevoTema;
        
        vm.guardar = guardar;
        vm.groupInfoGral = { isOpen: true };
        vm.groupTemas = { isOpen: true };
        
        vm.fieldLabels = [
            { name: 'titulo', label: 'Título' },
            { name: 'descripcion', label: 'Descripción' },
        ];
        
        activate();
        
        function activate() {
            
            setTitle();
            loadData();
            
            function loadData() {

                $q.all([cargarCurso()])
                    .then(onLoadComplete);

                function cargarCurso(){     
                    var curso = DocenteCursos.one(UsuarioService.getUserCurrentDoc()).one('cursos', $stateParams.id);  
                    return  curso.get().then(onSuccess, onError);

                    function onSuccess(response) {            
                        vm.curso = response.plain();     
                    }        
                    function onError(httpResponse) {
                        logger.error('No se pudo obtener el Curso', httpResponse);
                    }         
                }

                function onLoadComplete() {
                    vm.loading = false;
                    
                    if (vm.editMode){
                        setTitle();                          
                    }
                    else{
                        vm.curso = '';
                    }
                }
            }
            
            function setTitle() {
                if (vm.editMode) {
                    vm.title = 'Editar Curso ' + $stateParams.id;
                    vm.subTitle = 'MODIFICACION CURSO';
                }
            }            
        }
        
        function agregarNuevoTema() {
            
        }
        
        
        function guardar() {
            
            /*
            
            function onSuccess() {
                logger.info('Curso Guardado');
                vm.form.$dirty = false;
                goBack();
            }
            function onError(httpResponse) {
                console.log(httpResponse);
                logger.error('No se pudo guardar el Curso', httpResponse);
            }
             */ 
        }
        
        function goBack() {
            $state.go('^.list');
        }
        
        function cancel() {
            goBack();
        }
        
    }
})(); 



