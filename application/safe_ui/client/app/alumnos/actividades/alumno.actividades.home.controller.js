(function () {
    'use strict';

    angular.module('app.alumno')
        .controller('AlumnoActividadHomeCtrl', ['$scope', '$state', '$uibModal','$q', '$stateParams', 'AlumnoService', 'UsuarioService', AlumnoActividadHomeCtrl])

    function AlumnoActividadHomeCtrl($scope, $state, $uibModal, $q, $stateParams, AlumnoService, UsuarioService) {
        var vm = this;
        vm.loading = true;
        vm.goBack = goBack;
        vm.goTema = goTema;
        vm.goCurso = goCurso;
        vm.viewConcept = viewConcept;
        console.log($stateParams);
        
        vm.curso = $stateParams.data.curso;
        vm.tema = $stateParams.data.tema;
        vm.concepto = $stateParams.data.concepto;
        vm.actividad = $stateParams.data.actividad;
        vm.background = $stateParams.background;
        
        loadData();
        
        function loadData() {
            $q.all([])
            .then(onLoadComplete);

        }
        function onLoadComplete() {
            vm.loading = false;
        }
        function goBack() {
            $state.go('alumno.curso.tema.concepto.dashboard', { cursoId: vm.curso.id, temaId: vm.tema.id, background: vm.background, data: {curso: vm.curso, tema: vm.tema}});
        }
        function goTema() {
            $state.go('alumno.curso.tema.dashboard', { cursoId: vm.curso.id, background: vm.background, data: vm.curso});
        }
        function goCurso() {
            $state.go('alumno.dashboard');
        }
        function viewConcept() {
            var modalInstance = $uibModal.open({
                templateUrl: 'concepto.html',
                size: 'lg'                
              });

            modalInstance.result.then(function () {
              concole.log("ok");
            }, function () {
              console.log("error");
            });
        }
      
    }


})(); 