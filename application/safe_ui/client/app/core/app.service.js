(function () {
    'use strict';

    angular.module('app')
        .factory('UsuarioService', ['$localStorage', UsuarioService])
        .factory('AutorizacionService', ['UsuarioService', '$http', '$q','SystemConfig', AutorizacionService])
        .factory('PaginaService', ['UsuarioService', PaginaService])

;
    
    function PaginaService(UsuarioService) {
        return {
            getInicio: getInicio
        }
        
        function getInicio() {
            if (UsuarioService.isAlumno()) return 'alumno.dashboard';
            if (UsuarioService.isDocente()) return 'docente.dashboard';
            if (UsuarioService.isAdmin()) return 'admin.dashboard';
        }
    }
    
    function AutorizacionService(UsuarioService, $http, $q, SystemConfig) {
        
        return {
            login: login,
            logout: logout
        }
        
        function login(username, password) {
            var defered = $q.defer(); 
            return $http.post(SystemConfig.getHost() + 'api/login_check', {
                _username: username,
                _password: password
            }).then(function(response){
                UsuarioService.iniciar(username, response.data.token, response.data.roles);
                defered.resolve(UsuarioService);
            }, function(error){
                defered.reject(error);
            });
        }
        
        function logout() {
            UsuarioService.eliminar();
        }
        
    }
    
    function UsuarioService($localStorage) { 
        if (!$localStorage.usuarioSafe) {
            reset();
        }
        
        return {              
            iniciar: iniciar,
            reset: reset,
            eliminar: eliminar,
            isAutenticado: isAutenticado,
            tieneRol: tieneRol,
            
            isAlumno: isAlumno,
            isDocente: isDocente,
            isAdmin: isAdmin,
                                
        }
        function isAlumno() {
            return tieneRol(["ROLE_ALUMNO"]);
        }
        function isDocente() {
            return tieneRol(["ROLE_DOCENTE"]);
        }
        function isAdmin() {
            return tieneRol(["ROLE_SUPER_ADMIN", "ROLE_ADMIN"]);
        }
        
        function iniciar(username, token, roles) {
            reset();
            $localStorage.usuarioSafe.username = username;
            $localStorage.usuarioSafe.token = token;
            $localStorage.usuarioSafe.autenticado = true;
            agregarRoles(roles);
        }
        function eliminar() {
            delete $localStorage.usuarioSafe;
        }
        function reset() {            
            $localStorage.usuarioSafe = {
                username: '',
                token:'',
                roles : [],
                autenticado : false
            };
        }
        
        function isAutenticado() {
            return !!$localStorage.usuarioSafe && $localStorage.usuarioSafe.autenticado;
        }
        
        function agregarRoles(nuevosRoles) {            
            var rolesAAgregar = (!nuevosRoles) ? [] : nuevosRoles;
            angular.extend($localStorage.usuarioSafe.roles, rolesAAgregar);
        }
        
        function limpiarRoles() {
            $localStorage.usuarioSafe.roles = [];
        }
        
        function tieneRol(rolesEvaluados) {
            if (!rolesEvaluados) return true;
            if (!isAutenticado()) return false;
            for(var i=0; i<rolesEvaluados.length; i++) {
                if ($localStorage.usuarioSafe.roles.indexOf(rolesEvaluados[i]) > -1) return true;
            }
            return false;
        }
    }

})(); 