(function () {
    'use strict';

    angular
        .module('app')
        .factory('AdminCursos', factory);

    factory.$inject = ['Restangular'];

    function factory(Restangular) {
        
        var route = 'admin/cursos';
        var svc = Restangular.service(route);
        return svc;
        
    }
})();

