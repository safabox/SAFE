(function () {
    'use strict';

    angular.module('app.administrador.alumnos')
        .controller('AdministradorAlumnosEdit', controller);

    controller.$inject = ['$q', 'AdminAlumnos', '$state', 'logger', 'debugModeEnabled', '$stateParams', 'accordion']; 
    
    function controller($q, AdminAlumnos, $state, logger, debugModeEnabled, $stateParams, accordion) {
        
        var vm = this;
        vm.loading = true;
        vm.debug = debugModeEnabled;
        vm.editMode = ($state.includes('**.edit'));        
        vm.cancel = cancel;
        
        vm.groupInfoGral = { isOpen: true };
        vm.groupSeguridad = { isOpen: true };
        vm.groupCursos = { isOpen: true };

        vm.fieldLabels = [
            { name: 'legajo', label: 'Legajo' },
            { name: 'nombre', label: 'Nombre' },
            { name: 'apellido', label: 'Apellido' },
            { name: 'tipoDocumento', label: 'Tipo de Documento' },
            { name: 'numeroDocumento', label: 'Número de Documento' },
            { name: 'genero', label: 'Género' },
            { name: 'email', label: 'Email' },
            { name: 'username', label: 'Nombre de Usuario' },
            { name: 'password', label: 'Contraseña' },
            { name: 'confirmPassword', label: 'Confirmar Contraseña' },
        ];
                
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
            
            var alumnoPut =
            {
                'legajo':  vm.alumno.legajo,
                'usuario': {
                    'nombre': vm.alumno.usuario.nombre,
                    'apellido': vm.alumno.usuario.apellido,
                    'username': vm.alumno.usuario.username,     
                    'tipoDocumento':  vm.alumno.usuario.tipo_documento.codigo,
                    'numeroDocumento': vm.alumno.usuario.numero_documento,
                    'genero': vm.alumno.usuario.genero,
                    'email': vm.alumno.usuario.email,
                    'enabled': vm.alumno.usuario.enabled,
                    'textPassword': {
                        'first' : vm.alumno.usuario.textPassword.first,
                        'second' : vm.alumno.usuario.textPassword.second
                    }
                }
            };

            if (vm.editMode) {
                var alumno = AdminAlumnos.one($stateParams.id);
                alumno.customPUT(alumnoPut).then(onSuccess,onError);
            }else{
                AdminAlumnos.post(alumnoPut).then(onSuccess,onError);
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

