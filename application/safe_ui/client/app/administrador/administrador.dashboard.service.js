(function () {
    'use strict';

    angular
        .module('app.administrador')
        .factory('Administrador', factory);

    factory.$inject = ['Restangular'];

    function factory(Restangular) {
        
        var route = 'usuarios';
        var svc = Restangular.service(route);
        return svc;
        
    }
})();

