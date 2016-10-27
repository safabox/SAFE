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
        svc.newConcepto = createNewConcepto;
        svc.newActividad = createNewActivadad;
        return svc;
        
        function createNewEntity (titulo, descripcion, copete, orden, predecesoras, cursoId, docenteId) {
            var newEntity = {
                titulo: titulo, 
                descripcion: descripcion,
                copete: copete,
                orden: orden,
                predecesoras: predecesoras,
                habilitado: true,
            };

            var postTema = svc.one(docenteId).one('cursos', cursoId);

            return postTema.post('temas' , newEntity);
        }
        
        function createNewConcepto (titulo, descripcion, copete, orden, predecesoras, tipo, rango, metodo, incremento, cursoId, docenteId, temaId ) {
            var newEntity = {
                titulo: titulo, 
                descripcion: descripcion,
                copete: copete, 
                orden: orden,
                predecesoras: predecesoras,
                tipo: tipo,
                rango: rango,
                metodo: metodo,
                incremento: incremento,
            };
            console.log(newEntity);
            var postConcepto = svc.one(docenteId).one('cursos', cursoId).one('temas', temaId);

            return postConcepto.post('conceptos' , newEntity);
        }
        
        function createNewActivadad (cursoId, docenteId, temaId, conceptoId) {
            var newEntity = {};
            
             var postActividad = svc.one(docenteId).one('cursos', cursoId).one('temas', temaId).one('conceptos', conceptoId);

            return postActividad.post('actividads' , newEntity);
        }
        
    }
})();

