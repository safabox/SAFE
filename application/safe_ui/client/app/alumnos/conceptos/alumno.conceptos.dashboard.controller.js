(function () {
    'use strict';

    angular.module('app.alumno')
        .controller('AlumnoConceptoDashboardCtrl', ['$scope', '$state', '$q', AlumnoConceptoDashboardCtrl])

    function AlumnoConceptoDashboardCtrl($scope, $state, $q) {
        var vm = this;
        vm.loading = true;
        vm.goBack = goBack;
        vm.goActividad = goActividad;
        $q.all([])
            .then(onLoadComplete);
        
        function onLoadComplete() {
            vm.loading = false;
        }


        function goBack() {
             $state.go('alumno.tema.dashboard');
        }
        
        function goActividad() {
             $state.go('alumno.actividad.home');
        }
    }


})(); 