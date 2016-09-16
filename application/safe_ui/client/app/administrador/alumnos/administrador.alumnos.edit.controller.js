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
                    vm.generos = getGeneros();
                    
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
                
               var alumnoPut =
                {
                    'legajo':  vm.alumno.legajo,
                    'usuario': {
                        'nombre': vm.alumno.usuario.nombre,
                        'apellido': vm.alumno.usuario.apellido,
                        'username': vm.alumno.usuario.username,     
                        'tipoDocumento':  vm.alumno.usuario.tipoDocumento,
                        'numeroDocumento': vm.alumno.usuario.numeroDocumento,
                        'genero': vm.alumno.usuario.genero,
                        'email': vm.alumno.usuario.email,
                        'enabled': vm.alumno.usuario.enabled,
                        'textPassword': {
                            'first' : vm.alumno.usuario.textPassword.first,
                            'second' : vm.alumno.usuario.textPassword.second
                        }
                    }
                };
                var alumno = AdminAlumnos.one($stateParams.id);
                alumno.customPUT(alumnoPut).then(onSuccess,onError);
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
                logger.error('No se pudo guardar el Alumno', httpResponse);
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

