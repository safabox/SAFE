(function () {
    'use strict';

    angular
        .module('app.docente.cursos')
        .factory('DocenteCursos', factory);

    factory.$inject = ['Restangular'];

    function factory(Restangular) {
        
        var route = 'docentes';
        var svc = Restangular.service(route);
        svc.new = createNewEntity;
        return svc;
        
        function createNewEntity (titulo, descripcion, copete, orden, predecesoras, cursoId, docenteId) {
            var newEntity = {
                titulo: titulo, 
                descripcion: descripcion,
                coperte: copete,
                orden: orden,
                predecesoras: predecesoras,
                habilitado: true,
            };

            var postTema = svc.one(docenteId).one('cursos', cursoId);

            return postTema.post('temas' , newEntity);
        }
        
    }
})();

