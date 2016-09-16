(function () {
    'use strict';

    angular.module('app')
        .controller('AdministradorDocentesEdit', controller);

    controller.$inject = ['$q', 'AdminDocentes', '$state', 'logger', 'debugModeEnabled', '$stateParams']; 
    
    function controller($q, AdminDocentes, $state, logger, debugModeEnabled, $stateParams) {
        
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
                    vm.generos = getGeneros();
                    
                    if (vm.editMode){
                        getDocente();
                    }
                    else{
                        vm.docente = '';
                    }
                }
            }
            
            function setTitle() {
                if (vm.editMode) {
                    vm.title = 'Editar Docente ' + $stateParams.id;
                    vm.subTitle = 'MODIFICACION DOCENTE';
                } else {
                    vm.title = 'Nuevo Docente';
                    vm.subTitle = 'ALTA DECENTE';
                }
            }
            
            function getDocente(){     
                var docente = AdminDocentes.one($stateParams.id);  
                return  docente.get().then(onSuccess, onError);

                function onSuccess(response) {            
                    vm.docente = response.plain();     
                }        
                function onError(httpResponse) {
                    logger.error('No se pudo obtener el Docente', httpResponse);
                }         
            }
            
            function getGeneros(){
                return [{
                        id: 'Masculino',
                        descripcion: 'Masculino'
                    },
                    {
                        id: 'Femenino',
                        descripcion: 'Femenino'
                    }];
            }
            
        }
        
        vm.guardar = guardar;
        function guardar() {
            
            if (vm.editMode) {              
                var docente = AdminDocentes.one($stateParams.id);
                docente.put(vm.docente).then(onSuccess,onError);
            }else{
                AdminDocentes.post(vm.docente).then(onSuccess,onError);
            }
            
            function onSuccess() {
                logger.info('Docente Guardado');
                vm.form.$dirty = false;
                goBack();
            }
            function onError(httpResponse) {
                console.log(httpResponse);
                logger.error('No se pudo guardar el Docente', httpResponse);
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

