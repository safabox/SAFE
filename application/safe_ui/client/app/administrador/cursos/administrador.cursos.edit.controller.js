(function () {
    'use strict';

    angular.module('app')
        .controller('AdministradorCursosEdit', controller);

    controller.$inject = ['$q', 'AdminCursos', '$state', 'logger', 'debugModeEnabled', '$stateParams']; 
    
    function controller($q, AdminCursos, $state, logger, debugModeEnabled, $stateParams) {
        
        var vm = this;
        vm.loading = true;
        vm.debug = debugModeEnabled;
        vm.editMode = ($state.includes('**.edit'));
        
        vm.cancel = cancel;
        
        activate();
        
        function activate() {
            
            setTitle();
            loadData();
            
            function loadData() {

                $q.all([])
                    .then(onLoadComplete);

                function onLoadComplete() {
                    vm.loading = false;
                    
                    if (vm.editMode){
                        getCurso();
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
                } else {
                    vm.title = 'Nuevo Curso';
                    vm.subTitle = 'ALTA CURSO';
                }
            }
            
            function getCurso(){     
                var curso = AdminCursos.one($stateParams.id);  
                return  curso.get().then(onSuccess, onError);

                function onSuccess(response) {            
                    vm.curso = response.plain();     
                }        
                function onError(httpResponse) {
                    logger.error('No se pudo obtener el Curso', httpResponse);
                }         
            }
                        
        }
        
        vm.guardar = guardar;
        function guardar() {
            
            if (vm.editMode) {   
                
                var cursoPut =
                {
                    'titulo':  vm.curso.titulo,
                    'descripcion': vm.curso.descripcion                    
                };
                
                var curso = AdminCursos.one($stateParams.id);
                curso.customPUT(cursoPut).then(onSuccess,onError);
            }else{
                AdminCursos.post(vm.curso).then(onSuccess,onError);
            }
            
            function onSuccess() {
                logger.info('Curso Guardado');
                vm.form.$dirty = false;
                goBack();
            }
            function onError(httpResponse) {
                console.log(httpResponse);
                logger.error('No se pudo guardar el Curso', httpResponse);
            }
              
        }
        
        function goBack() {
            $state.go('^.list');
        }
        
        function cancel() {
            goBack();
        }
        
    }

})(); 

