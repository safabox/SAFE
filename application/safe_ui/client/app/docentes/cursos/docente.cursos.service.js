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
        
        function createNewEntity (titulo, descripcion, orden, predecesoras, cursoId, docenteId, temaId, editMode) {
            var newEntity = {
                titulo: titulo, 
                descripcion: descripcion, 
                orden: orden,
                predecesoras: predecesoras,
                habilitado: true,
            };
            
            var putTema = svc.one(docenteId).one('cursos', cursoId).one('temas', temaId);  
            var postTema = svc.one(docenteId).one('cursos', cursoId);
            
            if(editMode) {
                return putTema.customPUT(newEntity);
            }else {
                return postTema.post('temas' , newEntity);
            }
            
        }
        
    }
})();

