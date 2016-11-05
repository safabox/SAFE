(function () {
    'use strict';

    angular.module('app.alumno')
        .controller('AlumnoActividadHomeCtrl', ['$scope', '$state', '$uibModal','$q', '$stateParams', 'logger' ,'AlumnoService', 'UsuarioService', AlumnoActividadHomeCtrl])
        .controller('AlumnoActividadModalCtrl', ['$scope', '$uibModalInstance', 'param', AlumnoActividadModalCtrl])
        .controller('AlumnoActividadConfirmacionModalCtrl', ['$scope', '$uibModalInstance', AlumnoActividadConfirmacionModalCtrl])

    function AlumnoActividadHomeCtrl($scope, $state, $uibModal, $q, $stateParams, logger, AlumnoService, UsuarioService) {
        var self = this;
        self.loading = true;
        self.goBack = goBack;
        self.goTema = goTema;
        self.goCurso = goCurso;
        self.enviar = enviar;
        self.irProximaActividad = irProximaActividad;
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
        
        self.showEnviar = true;
        self.showProximaActividadBtn = false;
        self.showResultado = false;
        self.proximaActividad = null;
        
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
            var evaluacion = getResultado();
            if (evaluacion.resultado.length == 0) {
                var modalInstance = $uibModal.open({
                    templateUrl: 'confirmarEnvioActividad.html',    
                    controller: 'AlumnoActividadConfirmacionModalCtrl'
                });
                modalInstance.result.then(function () {
                  enviarEvaluacion(evaluacion);
                }); 
            } else {
                enviarEvaluacion(evaluacion);
            }            
        }
        
        function irProximaActividad() {
            self.showEnviar = true;
            self.showProximaActividadBtn = false;
            self.showResultado = false;
            mostrarProximaActividad(self.proximaActividad);
        }
        
        function enviarEvaluacion(evaluacion) {
            AlumnoService.one(UsuarioService.getUserCurrentAlumnoId())
                    .one('cursos', self.curso.id)
                    .one('temas', self.tema.id)
                    .one('conceptos', self.concepto.id)
                    .all('resultados').post(evaluacion).then(onSuccess,onError);
            
            function onSuccess(response) {
                var evaluation = response.plain();
                if (evaluation.resultado === 'APROBADO') {
                    logger.info("Muy bien");
                } else {
                    logger.warning("Intentálo de nuevo con la próxima actividad");                   
                }
                if (self.concepto.mostrarResultado) {
                    self.showEnviar = false;                        
                    if (evaluation.proxima_actividad && evaluation.proxima_actividad.estado === 'CURSANDO' && evaluation.proxima_actividad.elemento) {                    
                        self.proximaActividad = evaluation.proxima_actividad.elemento;
                        self.showProximaActividadBtn = true;
                        mostrarResultado(evaluation.resolucion_anterior);
                    } 
                } else {
                    if (evaluation.proxima_actividad && evaluation.proxima_actividad.estado === 'CURSANDO' && evaluation.proxima_actividad.elemento) {                    
                        mostrarProximaActividad(evaluation.proxima_actividad.elemento);
                    } else {
                        $state.go('alumno.curso.tema.concepto.dashboard', { cursoId: self.curso.id, temaId: self.tema.id, background: self.background, data: {curso: self.curso, tema: self.tema}});
                    }    
                }
            }
            function onError(httpResponse) {
                console.log(httpResponse);
                logger.error('No se pudo evaluar al Alumno', httpResponse);
            }
        }
        
        function mostrarProximaActividad(actividad) {            
            self.actividad = actividad;
            self.hasDescription = (self.actividad.descripcion && self.actividad.descripcion.length > 0);
            self.titulo = (self.actividad.titulo && self.actividad.titulo.length > 0) ? self.actividad.titulo : 'Actividad del concepto ' + self.concepto.titulo; 
            chanteTemplate();
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
                    if (respuesta.resultado !== undefined) {
                        var resultado = (respuesta.resultado != false);
                        respuestas.push({id: respuesta.id, resultado: resultado});    
                    }                   
                });
            }
            return {actividadId: self.actividad.id, resultado: respuestas};
        }
        function mostrarResultado(resolucionAnterior) {
            var ejercicio = self.actividad.ejercicio[0];
            if (self.actividad.tipo === 'MULTIPLE_CHOICE') {
                ejercicio.respuestas.forEach(function(respuesta){
                   var id = buscarElemento(resolucionAnterior, respuesta, function(respuestaChoice, id){return respuestaChoice.id === id}) 
                   if (id != null) {
                       respuesta.resultadoEsperado = true;
                   } else {
                       respuesta.resultadoEsperado = false;
                   }
                });
            } else {
                ejercicio.respuestas.forEach(function(respuesta){
                   var respuestaEsperada = buscarElemento(resolucionAnterior, respuesta, function(respuestaRadio, respuestaEsperada){return respuestaRadio.id === respuestaEsperada.id})  
                   if (respuestaEsperada != null) {
                       respuesta.resultadoEsperado = respuestaEsperada.resultado;
                   }                   
                });
            }
            self.showResultado = true;
        }
        
        function buscarElemento(array, objeto, comparador) {
            for (var i=0; i< array.length; i++) {
                if (comparador(objeto, array[i])) return array[i];
            }
            return null;
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
    //Todo modal generico
    function AlumnoActividadConfirmacionModalCtrl($scope, $uibModalInstance) {
        
        $scope.continuarEnvio = function() {
            $uibModalInstance.close();
        };
        $scope.cancelarEnvio = function() {
            $uibModalInstance.dismiss();
        };
    }


})(); 