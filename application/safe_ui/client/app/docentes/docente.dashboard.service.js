(function () {
    'use strict';

    angular
        .module('app.docente')
        .factory('Docente', factory);

    factory.$inject = ['Restangular'];

    function factory(Restangular) {
        
        var route = 'docentes';
        var svc = Restangular.service(route);
        return svc;
        
    }
})();

