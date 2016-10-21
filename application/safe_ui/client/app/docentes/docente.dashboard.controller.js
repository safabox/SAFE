(function () {
    'use strict';

    angular.module('app.docente')
        .controller('DocenteDashboardCtrl', ['$scope','$q',DocenteDashboardCtrl])

    function DocenteDashboardCtrl($scope, $q) {
        var vm = this;
        vm.loading = true;
        
        $q.all([])
            .then(onLoadComplete);
        
        function onLoadComplete() {
            vm.loading = false;
        }

    }


})(); 