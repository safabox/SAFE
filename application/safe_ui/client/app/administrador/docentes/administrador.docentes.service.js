(function () {
    'use strict';

    angular
        .module('app.administrador.docentes')
        .factory('AdminDocentes', factory);

    factory.$inject = ['Restangular'];

    function factory(Restangular) {
        
        var route = 'admin/docentes';
        var svc = Restangular.service(route);
        return svc;
        
    }
})();

