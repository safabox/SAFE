(function () {
    'use strict';

    angular.module('app.alumno')
        .controller('AlumnoDashboardCtrl', ['$scope','$state','$q', 'AlumnoService', 'UsuarioService', AlumnoDashboardCtrl])

    function AlumnoDashboardCtrl($scope, $state, $q, AlumnoService, UsuarioService) {
        var vm = this;
        var availableClass = ['primary', 'success', 'info', 'warning', 'danger']
        vm.loading = true;
        vm.bot = true;
        vm.goCurso = goCurso;
        vm.hasFinished = hasFinished;
        vm.closeBot = closeBot;
        //$scope.main.menu = 'horizontal';
        
        
        
        loadData();
        
        function loadData() {
            $q.all([getCursos()])
                .then(onLoadComplete);

        }
        
        function hasFinished(curso) {
            return (curso.cant_temas_resueltos >= curso.cant_temas);
        }
        
        function getCursos(){
            var cursos = AlumnoService.one(UsuarioService.getUserCurrentAlumnoId());
                return cursos.getList('cursos').then(onSuccess, onError);

                function onSuccess(response) {  
                    var backgroundIndex, cursos = response.plain();
                    
                    for(var i=0; i < cursos.length; i++) {
                        backgroundIndex = i % availableClass.length;
                        cursos[i].background = availableClass[backgroundIndex];
                    }
                    vm.cursos = cursos;    
                }        
                function onError(httpResponse) {
                    logger.error('No se pudieron obtener los Cursos del alumno', httpResponse);
                }      
        }
        
        function onLoadComplete() {
            vm.loading = false;
        }
        function goCurso(item) {            
            $state.go('alumno.curso.tema.dashboard', { cursoId: item.curso.id, background: item.background, data: item.curso});
        }

        function closeBot() {
            vm.bot = false;
        }

    }


})(); 
