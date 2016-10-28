(function () {
    'use strict';

    angular.module('app.alumno')
        .controller('AlumnoTemaDashboardCtrl', ['$scope', '$state', '$q', AlumnoTemaDashboardCtrl])

    function AlumnoTemaDashboardCtrl($scope, $state, $q) {
        var vm = this;
        vm.loading = true;
        vm.goBack = goBack;
        vm.goConcepto = goConcepto;
        vm.goActividad = goActividad;
        $q.all([])
            .then(onLoadComplete);
        
        function onLoadComplete() {
            vm.loading = false;
        }
        function goBack() {
             $state.go('alumno.dashboard');
        }
        function goConcepto() {
             $state.go('alumno.concepto.dashboard');
        }
        function goActividad() {
             $state.go('alumno.actividad.home');
        }


    }


})(); 