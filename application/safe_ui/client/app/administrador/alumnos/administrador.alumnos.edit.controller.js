(function () {
    'use strict';

    angular.module('app')
        .controller('AdministradorAlumnosEdit', controller);

    controller.$inject = ['$q', 'AdminAlumnos', '$state', 'logger', 'debugModeEnabled', '$stateParams']; 
    
    function controller($q, AdminAlumnos, $state, logger, debugModeEnabled, $stateParams) {
        
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
                        getAlumno();
                    }
                    else{
                        vm.alumno = '';
                    }
                }
            }
            
            function setTitle() {
                if (vm.editMode) {
                    vm.title = 'Editar Alumno ' + $stateParams.id;
                    vm.subTitle = 'MODIFICACION ALUMNO';
                } else {
                    vm.title = 'Nuevo Alumno';
                    vm.subTitle = 'ALTA ALUMNO';
                }
            }
            
            function getAlumno(){     
                var alumno = AdminAlumnos.one($stateParams.id);  
                return  alumno.get().then(onSuccess, onError);

                function onSuccess(response) {            
                    vm.alumno = response.plain();     
                }        
                function onError(httpResponse) {
                    logger.error('No se pudo obtener el Alumno', httpResponse);
                }         
            }
            
        }
        
        vm.guardar = guardar;
        function guardar() {
            
            if (vm.editMode) {
             
                vm.prueba =
                {
                    "legajo":  "123457",
                    "usuario": {
                        "nombre": "Roberto",
                        "apellido": "Gómez Bolaño",
                        "username": "chespirito",     
                        "tipoDocumento":  "DNI",
                        "numeroDocumento": "30777555",
                        "genero": "Masculino",
                        "email": "chespirito@organizacion.org",
                        "enabled": "true", 
                        "textPassword": {
                            "first" : "123456",
                            "second" : "123456"
                        }
                       }
                   };
                
                
                var alumno = AdminAlumnos.one($stateParams.id);
                alumno.put(vm.prueba).then(onSuccess,onError);
            }else{
                AdminAlumnos.post(vm.alumno).then(onSuccess,onError);
            }
            
            function onSuccess() {
                logger.info('Alumno Guardado');
                vm.form.$dirty = false;
                goBack();
            }
            function onError(httpResponse) {
                console.log(httpResponse);
                logger.error('No se pudo guardar el Alumno');
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

