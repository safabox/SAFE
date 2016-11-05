(function () {
    'use strict';

    angular.module('app')
        .controller('SidebarCtrl', ['_','$scope', '$localStorage', '$state', SidebarCtrl]);

    function SidebarCtrl(_, $scope, $localStorage, $state) {
        
        $scope.$on("$stateChangeSuccess", function updatePage() {
            $scope.roles = $localStorage.usuarioSafe.roles;

            if(_.indexOf($scope.roles, "ROLE_SUPER_ADMIN") >= 0){
                $scope.menuAdministrador = true;
                $scope.content = '';
            }
            else {
               $scope.menuAdministrador = false;
            }
            
            if(_.indexOf($scope.roles, "ROLE_ALUMNO") >= 0){
                $scope.menuAlumno = true;
                $scope.content = '-alumno';
            }
            else {
                $scope.menuAlumno = false;
            }
            
            if(_.indexOf($scope.roles, "ROLE_DOCENTE") >= 0){
                $scope.menuDocente = true;
                $scope.content = '-docente';
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
