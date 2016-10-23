(function () {
    'use strict';

    angular.module('app.docente.cursos')
        .controller('DocenteCursosEdit', controller);

    controller.$inject = ['_', '$q', 'DocenteCursos', '$state', 'logger', 'debugModeEnabled', '$stateParams', 'UsuarioService', 'NgTableParams']; 
    
    function controller(_, $q, DocenteCursos, $state, logger, debugModeEnabled, $stateParams, UsuarioService, NgTableParams) {
        
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
        
        vm.temasTableParams = new NgTableParams({
            page: 1,
            count: 10
        }, {
            total: 0,
            counts: [10, 20, 50, 100],
            getData: getTemasTabla
        });        
        
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
                
                function cargarTemas(){
                    var tema = DocenteCursos.one(UsuarioService.getUserCurrentDoc()).one('cursos', $stateParams.id).one('temas');
                    return tema.get().then(onSuccess, onError);
                    
                    function onSuccess(response){
                        vm.temas = response.plain();
                    }
                    function onError(httpResponse) {
                        logger.error('No se pudo obtener los temas del curso', httpResponse);
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
        
        function getTemasTabla(params) {
            params.total(vm.temas.length);

            var result = vm.temas.slice((params.page() - 1) * params.count(), params.page() * params.count());
            return result;              
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



