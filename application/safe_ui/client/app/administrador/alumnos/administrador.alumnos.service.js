(function () {
    'use strict';

    angular
        .module('app.administrador.alumnos')
        .factory('AdminAlumnos', factory);

    factory.$inject = ['Restangular'];

    function factory(Restangular) {
        
        var route = 'admin/alumnos';
        var svc = Restangular.service(route);
        return svc;     
        
    }
})();

