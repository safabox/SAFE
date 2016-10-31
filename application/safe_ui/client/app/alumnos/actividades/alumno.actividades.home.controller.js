(function () {
    'use strict';

    angular.module('app.alumno')
        .controller('AlumnoActividadHomeCtrl', ['$scope', '$state', '$uibModal','$q', '$stateParams', 'logger' ,'AlumnoService', 'UsuarioService', AlumnoActividadHomeCtrl])
        .controller('AlumnoActividadMultipleChoiceCtrl', ['$scope', AlumnoActividadMultipleChoiceCtrl])

    function AlumnoActividadHomeCtrl($scope, $state, $uibModal, $q, $stateParams, logger, AlumnoService, UsuarioService) {
        var self = this;
        self.loading = true;
        self.goBack = goBack;
        self.goTema = goTema;
        self.goCurso = goCurso;
        self.enviar = enviar;
        self.viewConcept = viewConcept;
        self.curso = $stateParams.data.curso;
        self.tema = $stateParams.data.tema;
        self.concepto = $stateParams.data.concepto;
        self.actividad = $stateParams.data.actividad;
        self.background = $stateParams.background;        
        self.template = getTemplate();
        
        loadData();
        
        function loadData() {
            $q.all([])
            .then(onLoadComplete);

        }
        function onLoadComplete() {
            self.loading = false;
        }
        function goBack() {
            $state.go('alumno.curso.tema.concepto.dashboard', { cursoId: self.curso.id, temaId: self.tema.id, background: self.background, data: {curso: self.curso, tema: self.tema}});
        }
        function goTema() {
            $state.go('alumno.curso.tema.dashboard', { cursoId: self.curso.id, background: self.background, data: self.curso});
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
        
        function enviar() {
            var resultado = getResultado();
            console.log("resultado", getResultado());
            
            AlumnoService.one(UsuarioService.getUserCurrentAlumnoId())
                    .one('cursos', self.curso.id)
                    .one('temas', self.tema.id)
                    .one('conceptos', self.concepto.id)
                    .all('resultados').post(resultado).then(onSuccess,onError);
            
            function onSuccess(response) {
                logger.info('Alumno Guardado');
                console.log("response", response);
            }
            function onError(httpResponse) {
                console.log(httpResponse);
                logger.error('No se pudo evaluar al Alumno', httpResponse);
            }
        }
        
        
        function getResultado() {
            var ejercicio = self.actividad.ejercicio[0];
            var respuestas = [];
            if (self.actividad.tipo === 'MULTIPLE_CHOICE') {
                ejercicio.respuestas.forEach(function(respuesta){
                    if (respuesta.selected) {
                        respuestas.push(respuesta.id);
                    }
                });
            }
            return {actividadId: self.actividad.id, resultado: respuestas};
        }
        function getTemplate() {
            if (self.actividad.tipo === 'MULTIPLE_CHOICE') {
                return  'multiplechoice.html';
            }
        }
      
    }
    
    function AlumnoActividadMultipleChoiceCtrl($scope) {
        var self = this;
        
        console.log(self);
    }


})(); 