(function () {
    'use strict';

    angular.module('app.docente.cursos')
        .controller('DocenteAlumnosCtrl', ['$q', '$stateParams', '$uibModal','UsuarioService', DocenteAlumnosCtrl])
        .controller('DocenteAlumnoTemaModalCtrl', ['$scope', '$uibModalInstance', 'param', '$timeout','$window', DocenteAlumnoTemaModalCtrl])
        .controller('DocenteAlumnoConceptoModalCtrl', ['$scope', '$uibModalInstance', 'param', '$timeout','$window', DocenteAlumnoTemaModalCtrl])

    function DocenteAlumnosCtrl($q, $stateParams, $uibModal, UsuarioService) {
        var vm = this;
        vm.loading = true;
        
        vm.background = $stateParams.background;
        vm.docenteId = UsuarioService.getUserCurrentDoc();
        vm.cursoId = $stateParams.idCurso;
        vm.alumnoId = $stateParams.idAlumno;
        //vm.alumno = $stateParams.data.alumno;
        vm.viewTemaChart = viewTemaChart;
        loadData();
        
        function loadData() {
            $q.all([])
            .then(onLoadComplete);

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
                       return {'titulo': 'titulo'};
                   }
                }
              });

            modalInstance.result.then(function () {
              console.log("ok");
            }, function () {
              console.log("error");
            });
        }
        
        
        
    }  
    
    function DocenteAlumnoTemaModalCtrl($scope, $uibModalInstance, param, $timeout, $window) {
        //$scope.concepto = param.concepto;
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
                        {value:335, name:'Aprobado'},
                        {value:310, name:'Observación'},
                        {value:234, name:'Desaprobado'},
                        {value:135, name:'Cursando'}
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
                        {value:335, name:'Aprobado'},
                        {value:310, name:'Observación'},
                        {value:234, name:'Desaprobado'},
                        {value:135, name:'Cursando'}
                    ]
                }
            ]
        };
        $scope.listo = function() {
            $uibModalInstance.close();
        };
    }
})(); 
