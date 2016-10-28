(function () {
    'use strict';

    angular.module('app.alumno')
        .controller('AlumnoActividadHomeCtrl', ['$scope', '$state', '$uibModal','$q', AlumnoActividadHomeCtrl])

    function AlumnoActividadHomeCtrl($scope, $state, $uibModal, $q) {
        var vm = this;
        vm.loading = true;
        vm.goBack = goBack;
        vm.viewConcept = viewConcept;
        $q.all([])
            .then(onLoadComplete);
        
        function onLoadComplete() {
            vm.loading = false;
        }
        function goBack() {
             $state.go('alumno.concepto.dashboard');
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
      
    }


})(); 