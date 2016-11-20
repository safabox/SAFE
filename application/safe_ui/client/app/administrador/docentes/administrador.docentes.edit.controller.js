(function () {
    'use strict';

    angular.module('app.administrador.docentes')
        .controller('AdministradorDocentesEdit', controller);

    controller.$inject = ['$q', 'AdminDocentes', '$state', 'logger', 'debugModeEnabled', '$stateParams', 'ErrorHelper']; 
    
    function controller($q, AdminDocentes, $state, logger, debugModeEnabled, $stateParams, ErrorHelper) {
        
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
                if(typeof vm.docente.usuario.textPassword === 'undefined')
                {
                    var docentePut =
                    {
                        'legajo':  vm.docente.legajo,
                        'usuario': {
                            'nombre': vm.docente.usuario.nombre,
                            'apellido': vm.docente.usuario.apellido,
                            'username': vm.docente.usuario.username,     
                            'tipoDocumento':  vm.docente.usuario.tipo_documento.codigo,
                            'numeroDocumento': vm.docente.usuario.numero_documento,
                            'genero': vm.docente.usuario.genero,
                            'email': vm.docente.usuario.email,
                            'enabled': true
                        }
                    };
                }
                else 
                {
                    var docentePut =
                    {
                        'legajo':  vm.docente.legajo,
                        'usuario': {
                            'nombre': vm.docente.usuario.nombre,
                            'apellido': vm.docente.usuario.apellido,
                            'username': vm.docente.usuario.username,     
                            'tipoDocumento':  vm.docente.usuario.tipo_documento.codigo,
                            'numeroDocumento': vm.docente.usuario.numero_documento,
                            'genero': vm.docente.usuario.genero,
                            'email': vm.docente.usuario.email,
                            'enabled': true,
                            'textPassword': {
                                'first' : vm.docente.usuario.textPassword.first,
                                'second' : vm.docente.usuario.textPassword.second
                            }
                        }
                    };
                }
               
                var docente = AdminDocentes.one($stateParams.id);
                docente.customPUT(docentePut).then(onSuccess,onError);
            }else{
                
                var docentePut =
                {
                    'legajo':  vm.docente.legajo,
                    'usuario': {
                        'nombre': vm.docente.usuario.nombre,
                        'apellido': vm.docente.usuario.apellido,
                        'username': vm.docente.usuario.username,     
                        'tipoDocumento':  vm.docente.usuario.tipo_documento.codigo,
                        'numeroDocumento': vm.docente.usuario.numero_documento,
                        'genero': vm.docente.usuario.genero,
                        'email': vm.docente.usuario.email,
                        'enabled': true,
                        'textPassword': {
                            'first' : vm.docente.usuario.textPassword.first,
                            'second' : vm.docente.usuario.textPassword.second
                        }
                    }
                };
                
                AdminDocentes.post(docentePut).then(onSuccess,onError);
            }
            
            function onSuccess() {
                logger.info('Docente Guardado');
                vm.form.$dirty = false;
                goBack();
            }
            function onError(httpResponse) {
                var message = ErrorHelper.parseRequestError(httpResponse);
                logger.error(message, httpResponse, 'No se pudo guardar el Docente');
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

