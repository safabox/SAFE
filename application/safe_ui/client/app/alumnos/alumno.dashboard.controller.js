(function () {
    'use strict';

    angular.module('app.alumno')
        .controller('AlumnoDashboardCtrl', ['$scope','$state','$q', AlumnoDashboardCtrl])

    function AlumnoDashboardCtrl($scope, $state, $q) {
        var vm = this;
        vm.loading = true;
        vm.bot = true;
        vm.goCurso = goCurso;
        
        vm.closeBot = closeBot;
        //$scope.main.menu = 'horizontal';
        $q.all([])
            .then(onLoadComplete);
        
        function onLoadComplete() {
            vm.loading = false;
        }
        function goCurso() {
            $state.go('alumno.tema.dashboard');
        }

        function closeBot() {
            vm.bot = false;
        }

    }


})(); 