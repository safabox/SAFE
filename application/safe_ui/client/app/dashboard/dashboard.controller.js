(function () {
    'use strict';

    angular.module('app')
        .controller('DashboardCtrl', ['$scope','$state','$localStorage', DashboardCtrl])

    function DashboardCtrl($scope, $state, $localStorage) {
        
        $scope.$on("$stateChangeSuccess", function updatePage() {
            if($localStorage.usuarioSafe !== undefined){
                $scope.roles = $localStorage.usuarioSafe.roles;
            }
                        
            if(_.indexOf($scope.roles, "ROLE_SUPER_ADMIN") >= 0){
                $state.go('admin.dashboard');
            }            
            if(_.indexOf($scope.roles, "ROLE_ALUMNO") >= 0){
                $state.go('admin.dashboard');
            }
            if(_.indexOf($scope.roles, "ROLE_DOCENTE") >= 0){
                $state.go('admin.dashboard');
            }
        });       
        
        
    }


})(); 