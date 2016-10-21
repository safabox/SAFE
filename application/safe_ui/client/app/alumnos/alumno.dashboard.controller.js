(function () {
    'use strict';

    angular.module('app.alumno')
        .controller('AlumnoDashboardCtrl', ['$scope','$q', AlumnoDashboardCtrl])

    function AlumnoDashboardCtrl($scope, $q) {
        var vm = this;
        vm.loading = true;
        
        $q.all([])
            .then(onLoadComplete);
        
        function onLoadComplete() {
            vm.loading = false;
        }


    }


})(); 