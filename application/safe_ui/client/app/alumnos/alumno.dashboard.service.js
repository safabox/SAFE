(function () {
    'use strict';

    angular
        .module('app.alumno')
        .factory('Alumno', factory);

    factory.$inject = ['Restangular'];

    function factory(Restangular) {
        
        var route = 'alumnos';
        var svc = Restangular.service(route);
        return svc;
        
    }
})();

