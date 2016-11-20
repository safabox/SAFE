(function () {
    'use strict';

    angular.module('app.docente.cursos')
        .controller('DocenteAlumnosCtrl', ['$q', '$state', '$stateParams', '$uibModal', 'logger', 'UsuarioService', 'Docente', DocenteAlumnosCtrl])
        .controller('DocenteAlumnoTemaModalCtrl', ['$scope', '$uibModalInstance', 'param', '$timeout','$window', DocenteAlumnoTemaModalCtrl])
        .controller('DocenteAlumnoConceptoModalCtrl', ['$scope', '$uibModalInstance', 'param', '$timeout','$window', DocenteAlumnoConceptoModalCtrl])

    function DocenteAlumnosCtrl($q, $state, $stateParams, $uibModal, logger, UsuarioService, Docente) {
        var vm = this;
        vm.loading = true;
        
        vm.background = $stateParams.background;
        vm.docenteId = UsuarioService.getUserCurrentDoc();
        vm.cursoId = $stateParams.idCurso;
        vm.alumnoId = $stateParams.idAlumno;
        vm.alumno = $stateParams.data.alumno;
        vm.curso = $stateParams.data.curso;
        vm.viewTemaChart = viewTemaChart;
        vm.viewConceptoChart = viewConceptoChart;
        vm.getStatus = getStatus;
        vm.goBack = goBack;
        loadData();
        
        function loadData() {
            $q.all([getEstadisticaTema()])
            .then(onLoadComplete);

        }
        function getEstadisticaTema() {
            var estadisticaTemas = Docente.one(vm.docenteId).one('cursos', vm.cursoId).one('alumnos', vm.alumnoId).one('estadistica');
            return  estadisticaTemas.get().then(onSuccess, onError);

            function onSuccess(response) {            
                vm.estadisticasTemas = response.plain();   
            }        
            function onError(httpResponse) {
                logger.error('No se pudo obtener las estadisticas de los temas', httpResponse);
            }

        }
        function goBack() {
            $state.go('docente.cursos.edit', { id: vm.cursoId, background: vm.background  });
        }
        
        function onLoadComplete() {
            vm.loading = false;
        }
        
        function viewTemaChart(tema) {
            var modalInstance = $uibModal.open({
                templateUrl: 'tema_chart.html',
                size: 'md',
                controller: 'DocenteAlumnoTemaModalCtrl',
                resolve: {
                   param: function () {                
                       return {tema: tema};
                   }
                }
              });

            modalInstance.result.then(function () {
              console.log("ok");
            });
        }
        
        function viewConceptoChart(concepto) {
            var estadisticaConceptos = Docente.one(vm.docenteId).one('cursos', vm.cursoId).one('alumnos', vm.alumnoId).one('conceptos', concepto.id).one('estadistica');
            return  estadisticaConceptos.get().then(onSuccess, onError);

            function onSuccess(response) {            
                var estadisticaConcepto = response.plain();   
                var modalInstance = $uibModal.open({
                                                    templateUrl: 'concepto_chart.html',
                                                    size: 'md',
                                                    controller: 'DocenteAlumnoConceptoModalCtrl',
                                                        resolve: {
                                                           param: function () {                
                                                               return {'estadisticaConcepto': estadisticaConcepto};
                                                           }
                                                        }
                                                    });
                modalInstance.result.then(function () {
                  console.log("ok");
                });
            }        
            function onError(httpResponse) {
                logger.error('No se pudo obtener las estadisticas del concepto', httpResponse);
            }            
        }
        
        function getStatus(status) {
            switch(status) {
                case 'APROBADO':
                    return 'Aprobado';
                case 'APROBADO_OBSERVACION':
                    return 'Observación';
                case 'DESAPROBADO':
                    return 'Desaprobado';
                case 'FINALIZADO':
                    return 'finalizado';    
                default:
                    return 'Pendiente';
            }
        }
        
    }  
    
    function DocenteAlumnoTemaModalCtrl($scope, $uibModalInstance, param, $timeout, $window) {
        $scope.tema = param.tema;
        $scope.options = {
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient : 'vertical',
                x : 'left',
                data:['Aprobado','Observación','Desaprobado','Cursando']
            },
            toolbox: {
                show : false
            },
            calculable : true,
            series : [
                {
                    type:'pie',
                    radius : '55%',
                    center: ['50%', '60%'],
                    data:[
                        {value:param.tema.cant_aprobados, name:'Aprobado'},
                        {value:param.tema.cant_aprobados_observaciones, name:'Observación'},
                        {value:param.tema.cant_desaprobados, name:'Desaprobado'},
                        {value:param.tema.cant_cursando + param.tema.cant_pendientes, name:'Cursando'}
                    ]
                }
            ]
        };
        $timeout(function(){ $window.dispatchEvent(new Event('resize')); });
        
        $scope.listo = function() {
            $uibModalInstance.close();
        };
    }
    
    function DocenteAlumnoConceptoModalCtrl($scope, $uibModalInstance, param, $timeout, $window) {
        $scope.estadisticaConcepto = param.estadisticaConcepto;
        $scope.options = {
            tooltip : {
                trigger: 'axis',
                showDelay : 0,
                axisPointer:{
                    show: true,
                    type : 'cross',
                    lineStyle: {
                        type : 'dashed',
                        width : 1
                    }
                }
            },
            legend: {
                data:['Progreso de las habilidades']
            },
            toolbox: {
                show : true,
                feature : {
                    //mark : {show: true, title: 'Marcar'},          
                    restore : {show: true, title: 'Refrescar'},
                    saveAsImage : {show: true, title: 'Guardar a imagen'}
                }
            },
            xAxis : [
                {
                    type : 'category',
                    data: (function (thetas) {
                            var d = [];
                            for (var i=0; i < thetas.length; i++) {
                                d.push(i);
                            }
                            return d;
                          })(param.estadisticaConcepto.thetas_anteriores)
                }
            ],
            yAxis : [
                {
                    type : 'value',
                    scale:true,
                    min: -3,
                    max: 3
                }
            ],
            series : [                
                {
                    name:'progreso',                   
                    type:'line', 
                    data: (function (thetas) {
                            var d = [];
                            for (var i=0; i < thetas.length; i++) {
                                d.push({
                                    value: thetas[i].theta,
                                    formatter: "HOla"
                                });
                            }
                            return d;
                          })(param.estadisticaConcepto.thetas_anteriores)
                    
                }
            ]
        };
      
        $scope.listo = function() {
            $uibModalInstance.close();
        };
        $scope.getStatus = function(status) {
            switch(status) {
                case 'APROBADO':
                    return 'Aprobado';
                case 'DESAPROBADO':
                    return 'Desaprobado';
                case 'FINALIZADO':
                    return 'finalizado';    
                default:
                    return 'Pendiente';
            }
        }
        $timeout(function(){ $window.dispatchEvent(new Event('resize')); });
    }
})(); 
