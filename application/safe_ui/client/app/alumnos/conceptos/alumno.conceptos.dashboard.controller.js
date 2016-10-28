(function () {
    'use strict';

    angular.module('app.alumno')
        .controller('AlumnoConceptoDashboardCtrl', ['$scope', '$state', '$q', '$stateParams', 'AlumnoService', 'UsuarioService', AlumnoConceptoDashboardCtrl])

    function AlumnoConceptoDashboardCtrl($scope, $state, $q, $stateParams, AlumnoService, UsuarioService) {
        var vm = this;
        vm.loading = true;
        vm.goBack = goBack;
        vm.goActividad = goActividad;
        vm.background = $stateParams.background;
        vm.cursoId = $stateParams.cursoId;
        vm.temaId = $stateParams.temaId;
        vm.conceptoId = $stateParams.conceptoId;
        
        loadData();
        
        function loadData() {
            $q.all([getConcepto()])
            .then(onLoadComplete);

        }
        function onLoadComplete() {
            vm.loading = false;
        }

        function getConcepto() {
            var concepto = AlumnoService.one(UsuarioService.getUserCurrentAlumnoId()).one('cursos', $stateParams.cursoId).one('temas', $stateParams.temaId).one('conceptos');

            return  concepto.get().then(onSuccess, onError);

            function onSuccess(response) {            
                vm.conceptoGroup = response.plain(); 
                //console.log(vm.conceptoGroup);
            }        
            function onError(httpResponse) {
                logger.error('No se pudo obtener  el listado de conceptos', httpResponse);
            }  
        }

        function goBack() {
             $state.go('alumno.tema.dashboard');
        }
        
        function goActividad() {
             $state.go('alumno.actividad.home');
        }
    }


})(); 
