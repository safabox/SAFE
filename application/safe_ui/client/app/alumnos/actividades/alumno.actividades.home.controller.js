(function () {
    'use strict';

    angular.module('app.alumno')
        .controller('AlumnoActividadHomeCtrl', ['$scope', '$state', '$q', AlumnoActividadHomeCtrl])

    function AlumnoActividadHomeCtrl($scope, $state, $q) {
        var vm = this;
        vm.loading = true;
        vm.goBack = goBack;
        $q.all([])
            .then(onLoadComplete);
        
        function onLoadComplete() {
            vm.loading = false;
        }
        function goBack() {
             $state.go('alumno.concepto.dashboard');
        }
      
    }


})(); 