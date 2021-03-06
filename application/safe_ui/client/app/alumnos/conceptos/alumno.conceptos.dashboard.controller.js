(function () {
    'use strict';

    angular.module('app.alumno')
        .controller('AlumnoConceptoDashboardCtrl', ['$scope', '$state', '$q', '$stateParams', 'logger','AlumnoService', 'UsuarioService', AlumnoConceptoDashboardCtrl])

    function AlumnoConceptoDashboardCtrl($scope, $state, $q, $stateParams, logger, AlumnoService, UsuarioService) {
        var vm = this;
        vm.loading = true;
        vm.goBack = goBack;
        vm.goActividad = goActividad;
        vm.conceptoId = $stateParams.conceptoId;
        vm.curso = $stateParams.data.curso;
        vm.tema = $stateParams.data.tema;
        vm.background = $stateParams.background;
        vm.hasConceptos = false;
        vm.hasConceptosFinalizados = false;
        vm.hasConceptosHabilitados = false;
        vm.goProximaActividad = goProximaActividad;
        vm.loadData = loadData;
        
        
        loadData();
        
        function loadData() {
            $q.all([getConcepto()])
            .then(onLoadComplete);

        }
        function onLoadComplete() {
            vm.loading = false;
        }

        function getConcepto() {
            var concepto = AlumnoService.one(UsuarioService.getUserCurrentAlumnoId()).one('cursos', vm.curso.id).one('temas', vm.tema.id).one('conceptos');

            return  concepto.get().then(onSuccess, onError);

            function onSuccess(response) {            
                vm.conceptoGroup = response.plain(); 
                vm.hasConceptos = (vm.conceptoGroup && (vm.conceptoGroup.disponibles.length > 0 || vm.conceptoGroup.bloqueados.length > 0));
                vm.hasConceptosFinalizados = (vm.conceptoGroup && vm.conceptoGroup.finalizados.length > 0);
                vm.hasConceptosHabilitados = vm.conceptoGroup && vm.conceptoGroup.disponibles.length > 0;
            }        
            function onError(httpResponse) {
                logger.error('No se pudo obtener  el listado de conceptos', httpResponse);
            }  
        }
        
        function goBack() {
            $state.go('alumno.curso.tema.dashboard', { cursoId: vm.curso.id, background: vm.background, data: vm.curso});
        }
        
        function goActividad() {
            if (!vm.hasConceptosHabilitados) return;
            var proximaActividad = AlumnoService.one(UsuarioService.getUserCurrentAlumnoId()).one('cursos', vm.curso.id).one('temas', vm.tema.id).one('proxima_actividad');
            
            return  proximaActividad.get().then(onSuccess, onError);

            function onSuccess(response) {            
                var responseData = response.plain();
                if (!!responseData.actividad && responseData.actividad.estado === 'CURSANDO' && responseData.actividad.elemento != null) {
                    var pageParams = {background: vm.background, data: {curso: vm.curso, tema: vm.tema, concepto: responseData.concepto.elemento, actividad: responseData.actividad.elemento}};
                    $state.go('alumno.actividad.home', pageParams);    
                } else {
                    logger.info("No hay actividades disponibles");
                    vm.loading = true;
                    vm.loadData();
                }
                
                
            }        
            function onError(httpResponse) {
                logger.error('No se pudo obtener la próxima actividad', httpResponse);
            }
        }
        
        function goProximaActividad(concepto) {
            if (!vm.hasConceptosHabilitados) return;
            var proximaActividad = AlumnoService.one(UsuarioService.getUserCurrentAlumnoId()).one('cursos', vm.curso.id).one('temas', vm.tema.id).one('conceptos', concepto.id).one('proxima_actividad');
            
            return  proximaActividad.get().then(onSuccess, onError);

            function onSuccess(response) {            
                var responseData = response.plain();
                if (responseData.estado === 'CURSANDO') {
                    var pageParams = {background: vm.background, data: {curso: vm.curso, tema: vm.tema, concepto: concepto, actividad: responseData.elemento}};
                    $state.go('alumno.actividad.home', pageParams);
                } else {
                    logger.info("No hay actividades disponibles");
                    vm.loading = true;
                    vm.loadData();
                }
            }        
            function onError(httpResponse) {
                logger.error('No se pudo obtener la próxima actividad', httpResponse);
            }
        }
    }


})(); 
