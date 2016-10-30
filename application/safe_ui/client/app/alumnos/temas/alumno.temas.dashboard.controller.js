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
        //vm.cursoId = $stateParams.cursoId;
        vm.curso = $stateParams.data;
        vm.hasTemas = false;
        vm.hasTemasHabilitados = false;
    
        loadData();
        
        function loadData() {
            $q.all([getTema()])
            .then(onLoadComplete);

        }
        
        function getTema() {
            var tema = AlumnoService.one(UsuarioService.getUserCurrentAlumnoId()).one('cursos', vm.curso.id).one('temas');

            return  tema.get().then(onSuccess, onError);

            function onSuccess(response) {            
                vm.temaGroup = response.plain();   
                vm.hasTemas = (vm.temaGroup && (vm.temaGroup.disponibles.length > 0 || vm.temaGroup.bloqueados.length > 0));
                vm.hasTemasHabilitados = vm.temaGroup && vm.temaGroup.disponibles.length > 0;
       
                
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
        
        function goConcepto(tema) {
            //data-ui-sref="alumno.curso.tema.concepto.dashboard({cursoId: vm.cursoId, temaId: tema.id, background: vm.background})"
            $state.go('alumno.curso.tema.concepto.dashboard', { cursoId: vm.curso.id, temaId: tema.id, background: vm.background, data: {curso: vm.curso, tema: tema}});
            
        }
        function goActividad() {
            if (!vm.hasTemasHabilitados) return;
            var proximaActividad = AlumnoService.one(UsuarioService.getUserCurrentAlumnoId()).one('cursos', vm.curso.id).one('proxima_actividad');
            
            return  proximaActividad.get().then(onSuccess, onError);

            function onSuccess(response) {            
                var responseData = response.plain();
                var pageParams = {background: vm.background, data: {curso: vm.curso, tema: responseData.tema.elemento, concepto: responseData.concepto.elemento, actividad: responseData.actividad.elemento}};
                $state.go('alumno.actividad.home', pageParams);
            }        
            function onError(httpResponse) {
                logger.error('No se pudo obtener la próxima actividad', httpResponse);
            }      
        }


    }


})(); 
