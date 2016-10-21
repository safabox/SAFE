(function () {
    'use strict';

    angular.module('app.page')
        .controller('LoginCtrl', ['$q', '$state', 'AutorizacionService', 'PaginaService', 'logger', 'UsuarioService', LoginCtrl]);
    
    function LoginCtrl($q, $state, AutorizacionService, PaginaService, logger, UsuarioService) {
        var vm = this;
        
        vm.login = login;
        
        function login() {
            var defered = $q.defer(); 
            
            AutorizacionService.login(vm.username, vm.password).then(onSuccess, onError);

            function onSuccess(response) {
                UsuarioService.iniciar(vm.username, response.data.token, response.data.roles, response.data.idDocente, response.data.idAlumno);
                defered.resolve(UsuarioService);
                $state.go(PaginaService.getInicio());
            }

            function onError(httpResponse) {
                logger.error('Usuario o Contraseña Incorrecta');
                defered.reject(error);
                console.log(httpResponse);
            }
        }
                
        function handleRequest(res) {
            var token = res.data ? res.data.token : null;
            console.log('JWT:', token);            
        }
    }

})(); 



