(function () {
    'use strict';

    angular.module('app.alumno')
        .controller('AlumnoConceptoDashboardCtrl', ['$scope','$q', AlumnoConceptoDashboardCtrl])

    function AlumnoConceptoDashboardCtrl($scope, $q) {
        var vm = this;
        vm.loading = true;
        
        $q.all([])
            .then(onLoadComplete);
        
        function onLoadComplete() {
            vm.loading = false;
        }


    }


})(); 