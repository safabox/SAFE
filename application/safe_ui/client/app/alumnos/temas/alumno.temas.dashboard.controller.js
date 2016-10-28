(function () {
    'use strict';

    angular.module('app.alumno')
        .controller('AlumnoTemaDashboardCtrl', ['$scope', '$state', '$q', '$stateParams', 'AlumnoService', 'UsuarioService', AlumnoTemaDashboardCtrl])

    function AlumnoTemaDashboardCtrl($scope, $state, $q, $stateParams, AlumnoService, UsuarioService) {
        var vm = this;
        vm.loading = true;
        vm.goBack = goBack;
        vm.goConcepto = goConcepto;
        vm.goActividad = goActividad;
        vm.background = $stateParams.background;
        vm.cursoId = $stateParams.cursoId;
        
    
        loadData();
        
        function loadData() {
            $q.all([getTema()])
            .then(onLoadComplete);

        }
        
        function getTema() {
            var tema = AlumnoService.one(UsuarioService.getUserCurrentAlumnoId()).one('cursos', $stateParams.cursoId).one('temas');

            return  tema.get().then(onSuccess, onError);

            function onSuccess(response) {            
                vm.temaGroup = response.plain();   
            }        
            function onError(httpResponse) {
                logger.error('No se pudo obtener el listado de temas', httpResponse);
            }      
        }
        
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
