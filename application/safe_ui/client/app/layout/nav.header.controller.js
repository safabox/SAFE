(function () {
    'use strict';

    angular.module('app')
        .controller('HeaderCtrl', ['$scope','AutorizacionService', '$localStorage', '$state', HeaderCtrl]);

    function HeaderCtrl($scope, AutorizacionService, $localStorage, $state) {
        
        $scope.$on("$stateChangeSuccess", function updatePage() {
            if($localStorage.usuarioSafe !== undefined){
                $scope.user = $localStorage.usuarioSafe.username;
                $scope.roles = $localStorage.usuarioSafe.roles;
            }
                        
            if(_.indexOf($scope.roles, "ROLE_SUPER_ADMIN") >= 0){
               $scope.admin = true;
            }
            else {
               $scope.admin = false;
            }
            
            if(_.indexOf($scope.roles, "ROLE_ALUMNO") >= 0){
               $scope.alumno = true;
            }
            else {
               $scope.alumno = false;
            }
            
            if(_.indexOf($scope.roles, "ROLE_DOCENTE") >= 0){
               $scope.docente = true;
            }
            else {
               $scope.docente = false;
            }
        });       

        $scope.logout = logout;        
        function logout(){
            AutorizacionService.logout();
            $state.go("login");
        }
        
        $scope.inicioAdmin = inicioAdmin;        
        function inicioAdmin(){
            $state.go("admin.dashboard");
        }
        
        $scope.inicioAlumno = inicioAlumno;        
        function inicioAlumno(){
            $state.go("alumno.dashboard");
        }
        
        $scope.inicioDocente = inicioDocente;        
        function inicioDocente(){
            $state.go("docente.dashboard");
        }
        
    }

})(); 
