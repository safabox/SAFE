(function () {
    'use strict';

    angular
        .module('app.docente.cursos')
        .factory('DocenteCursos', factory);

    factory.$inject = ['Restangular'];

    function factory(Restangular) {
        
        var route = 'docentes';
        var svc = Restangular.service(route);
        return svc;
        
    }
})();

