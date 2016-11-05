(function () {
    'use strict';

    angular.module('app.alumno')
        .controller('AlumnoActividadHomeCtrl', ['$scope', '$state', '$uibModal','$q', '$stateParams', 'logger' ,'AlumnoService', 'UsuarioService', AlumnoActividadHomeCtrl])
        .controller('AlumnoActividadModalCtrl', ['$scope', '$uibModalInstance', 'param', AlumnoActividadModalCtrl])

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
        self.templateUrl = 'emptyTemplate.html';
        self.toogleOption = toogleOption;
        self.hasDescription = (self.actividad.descripcion && self.actividad.descripcion.length > 0);
        self.titulo = (self.actividad.titulo && self.actividad.titulo.length > 0) ? self.actividad.titulo : 'Actividad del concepto ' + self.concepto.titulo; 
        
        loadData();
        chanteTemplate();
        
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
                size: 'lg',
                controller: 'AlumnoActividadModalCtrl',
                resolve: {
                   param: function () {                
                       return {'concepto': self.concepto};
                   }
                }
              });

            modalInstance.result.then(function () {
              console.log("ok");
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
                var evaluation = response.plain();
                if (evaluation.resultado === 'APROBADO') {
                    logger.info("Muy bien");
                } else {
                    logger.warning("Intentálo de nuevo con la próxima actividad");
                }
                if (evaluation.proxima_actividad && evaluation.proxima_actividad.estado === 'CURSANDO' && evaluation.proxima_actividad.elemento) {
                    self.actividad = evaluation.proxima_actividad.elemento;
                    self.hasDescription = (self.actividad.descripcion && self.actividad.descripcion.length > 0);
                    self.titulo = (self.actividad.titulo && self.actividad.titulo.length > 0) ? self.actividad.titulo : 'Actividad del concepto ' + self.concepto.titulo; 
                    chanteTemplate();
                } else {
                    $state.go('alumno.curso.tema.concepto.dashboard', { cursoId: self.curso.id, temaId: self.tema.id, background: self.background, data: {curso: self.curso, tema: self.tema}});
                }
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
            } else {
                ejercicio.respuestas.forEach(function(respuesta){
                    var resultado = (respuesta.resultado !== 'false');
                    respuestas.push({id: respuesta.id, resultado: resultado});
                });
            }
            return {actividadId: self.actividad.id, resultado: respuestas};
        }
        function chanteTemplate() {
            if (self.actividad.tipo === 'MULTIPLE_CHOICE') {
                self.templateUrl = 'multiplechoice.html';
            } else {
                self.templateUrl =  'multiplechoicematrix.html';
            }
        }
        function toogleOption(option) {
            option.selected = !option.selected;
        }      
    }
    
    function AlumnoActividadModalCtrl($scope, $uibModalInstance, param) {
        $scope.concepto = param.concepto;
        $scope.listo = function() {
            $uibModalInstance.close();
        };
    }


})(); 