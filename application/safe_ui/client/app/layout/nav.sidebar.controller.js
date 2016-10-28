(function () {
    'use strict';

    angular.module('app')
        .controller('SidebarCtrl', ['_','$scope', '$localStorage', '$state', SidebarCtrl]);

    function SidebarCtrl(_, $scope, $localStorage, $state) {
        
        $scope.$on("$stateChangeSuccess", function updatePage() {
           $scope.roles = $localStorage.usuarioSafe.roles;

            if(_.indexOf($scope.roles, "ROLE_SUPER_ADMIN") >= 0){
               $scope.menuAdministrador = true;
            }
            else {
               $scope.menuAdministrador = false;
            }
            
            if(_.indexOf($scope.roles, "ROLE_ALUMNO") >= 0){
               $scope.menuAlumno = true;
            }
            else {
               $scope.menuAlumno = false;
            }
            
            if(_.indexOf($scope.roles, "ROLE_DOCENTE") >= 0){
               $scope.menuDocente = true;
            }
            else {
               $scope.menuDocente = false;
            }
           
        });       
                
        $scope.inicio = inicio;        
        function inicio(){
            if(_.indexOf($scope.roles, "ROLE_SUPER_ADMIN") >= 0) $state.go("admin.dashboard");
            if(_.indexOf($scope.roles, "ROLE_DOCENTE") >= 0) $state.go("alumno.dashboard");
            if(_.indexOf($scope.roles, "ROLE_ALUMNO") >= 0) $state.go("docente.dashboard");
        }        
    }

})(); 
