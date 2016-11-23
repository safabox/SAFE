(function () {
    'use strict';

    angular.module('app.alumno')
        .controller('AlumnoActividadHomeCtrl', ['$scope', '$state', '$uibModal','$q', '$stateParams', 'logger' ,'AlumnoService', 'UsuarioService', AlumnoActividadHomeCtrl])
        .controller('AlumnoActividadModalCtrl', ['$scope', '$uibModalInstance', 'param', AlumnoActividadModalCtrl])
        .controller('AlumnoActividadNotificacionModalCtrl', ['$scope', '$uibModalInstance', 'param', AlumnoActividadNotificacionModalCtrl])

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
        self.proximaActividad = null;
        self.goProximaActividad = goProximaActividad;
        self.mostrarResultado = false;
        
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
            var respuesta = {
                actividadId: resultado.actividadId, 
                resultado: resultado.resultado
            }
            if (resultado.tieneRespuestasIncompletas) {
                var modalInstance = $uibModal.open({
                    templateUrl: 'actividad_notificacion.html',
                    size: 'md',
                    controller: 'AlumnoActividadNotificacionModalCtrl',
                    resolve: {
                        param: function () {                
                            return {'concepto': self.concepto};
                        }
                    }
                });
                modalInstance.result.then(function () {
                    enviarResultados(respuesta);
                });               
            } else {
                enviarResultados(respuesta);
            }
            
        }
        
        
        function enviarResultados(resultado) {
            self.proximaActividad = null;
            self.mostrarResultado = false;
            AlumnoService.one(UsuarioService.getUserCurrentAlumnoId())
                    .one('cursos', self.curso.id)
                    .one('temas', self.tema.id)
                    .one('conceptos', self.concepto.id)
                    .all('resultados').post(resultado).then(onSuccess,onError);
            
            function onSuccess(response) {
                var evaluation = response.plain();
                self.mostrarResultado = self.concepto.mostrarResultado;
                if (evaluation.resultado === 'APROBADO') {
                    logger.info("Muy bien");
                } else {
                    logger.warning("Intentálo de nuevo con la próxima actividad");
                }
                
                logAbility(evaluation.proxima_actividad.examinee_test_status);
                
                if (evaluation.proxima_actividad && evaluation.proxima_actividad.estado === 'CURSANDO' && evaluation.proxima_actividad.elemento) {
                    self.proximaActividad = evaluation.proxima_actividad.elemento;
                } else {
                    closeConcept();
                }                
                
                
                if (self.mostrarResultado) {
                    mostrarResultado(evaluation.resultado_esperado);
                } else {
                    goProximaActividad();                   
                }
            }            
            function onError(httpResponse) {
                console.log(httpResponse);
                logger.error('No se pudo evaluar al Alumno', httpResponse);
            }
            
            function logAbility(result) {
                try {
                    console.log("Habilidad: [" + result.theta + "], estimated error: [" + result.estimated_error + "], increment: [" + result.discret_increment+ "], status [" + result.status + "]" )
                } catch (err) {
                    console.log(err);
                }
                
            }
        }
        
        function closeConcept() {
            var nextConcept = AlumnoService.one(UsuarioService.getUserCurrentAlumnoId()).one('cursos', self.curso.id).one('temas', self.tema.id).one('proximo_concepto');            
            return  nextConcept.get().then(onSuccess, onError);
            function onSuccess(response) {
                var nextConcept = response.plain();
                if (nextConcept.estado === 'FINALIZADO'){
                    logger.info("Concepto Finalizado");
                    closeIssue();
                }
            }
            function onError(httpResponse) {
                console.log(httpResponse);
            }
        }
        
        function closeIssue() {
            var nextIssue = AlumnoService.one(UsuarioService.getUserCurrentAlumnoId()).one('cursos', self.curso.id).one('proximo_tema');
            return  nextIssue.get().then(onSuccess, onError);
            function onSuccess(response) {
                var nextConcept = response.plain();
                if (nextConcept.estado === 'FINALIZADO'){
                    logger.info("Tema Finalizado");
                }
            }
            function onError(httpResponse) {
                console.log(httpResponse);
            }
        }
        
        
        function goProximaActividad() {
            self.mostrarResultado = false;
            if (self.proximaActividad != null) {
                self.actividad = self.proximaActividad;
                self.hasDescription = (self.actividad.descripcion && self.actividad.descripcion.length > 0);
                self.titulo = (self.actividad.titulo && self.actividad.titulo.length > 0) ? self.actividad.titulo : 'Actividad del concepto ' + self.concepto.titulo; 
                chanteTemplate();
            } else {
                $state.go('alumno.curso.tema.concepto.dashboard', { cursoId: self.curso.id, temaId: self.tema.id, background: self.background, data: {curso: self.curso, tema: self.tema}});
            }   

        }
        
        
        function getResultado() {
            var ejercicio = self.actividad.ejercicio[0];
            var respuestas = [];
            var tieneRespuestasIncompletas = false;
            if (self.actividad.tipo === 'MULTIPLE_CHOICE') {
                ejercicio.respuestas.forEach(function(respuesta){
                    if (respuesta.selected) {
                        respuestas.push(respuesta.id);
                    }
                });
                tieneRespuestasIncompletas = (respuestas.length === 0);
            } else {
                ejercicio.respuestas.forEach(function(respuesta){
                    if (respuesta.resultado !== undefined && respuesta.resultado !== null) {
                        var resultado = (respuesta.resultado != 'false' && respuesta.resultado != false);
                        respuestas.push({id: respuesta.id, resultado: resultado});                        
                    }
                });
                tieneRespuestasIncompletas = (respuestas.length !== ejercicio.respuestas.length);
            }
            return {tieneRespuestasIncompletas: tieneRespuestasIncompletas, actividadId: self.actividad.id, resultado: respuestas};
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
        
        function mostrarResultado(resultadoEsperado) {
            var ejercicio = self.actividad.ejercicio[0];
            var resultado = null; 
            if (self.actividad.tipo === 'MULTIPLE_CHOICE') {                
                ejercicio.respuestas.forEach(function(respuesta){
                    resultado = findInArray(resultadoEsperado, respuesta, function(item, arrayItem){ return item.id == arrayItem});
                    respuesta.isTrue = (resultado != null);
                });
            } else {
                ejercicio.respuestas.forEach(function(respuesta){
                    resultado = findInArray(resultadoEsperado, respuesta, function(item, arrayItem){ return item.id == arrayItem.id});
                    if (resultado != null) {
                      respuesta.isTrue = resultado.resultado;  
                    }                 
                });
            } 
        }
        
        function findInArray(array, element, evaluator) {
            if (!array || array.length == 0) return null;
            for (var i=0; i < array.length; i++) {
                if (evaluator(element, array[i])) {
                    return array[i];
                }
            }
            return null;
        }
    }
    
    function AlumnoActividadModalCtrl($scope, $uibModalInstance, param) {
        $scope.concepto = param.concepto;
        $scope.listo = function() {
            $uibModalInstance.close();
        };
    }

    function AlumnoActividadNotificacionModalCtrl($scope, $uibModalInstance, param) {
        $scope.concepto = param.concepto;
        $scope.ok = function() {
            $uibModalInstance.close();
        };
         $scope.cancel = function() {
            $uibModalInstance.dismiss();
        };
    }

})(); 