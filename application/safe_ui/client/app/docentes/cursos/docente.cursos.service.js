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
        svc.editAct = editActividad;
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
        
        function createNewConcepto (titulo, descripcion, copete, orden, predecesoras, tipo, rango, metodo, incremento, cursoId, docenteId, temaId, habilitado, mostrarResultado) {
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
                habilitado: habilitado,
                mostrarResultado: mostrarResultado
            };

            var postConcepto = svc.one(docenteId).one('cursos', cursoId).one('temas', temaId);

            return postConcepto.post('conceptos' , newEntity);
        }
        
        function createNewActivadad (titulo, descripcion, ejercicio, resultado, dificultad, discriminador, azar, d, tipo, cursoId, docenteId, temaId, conceptoId) {
            var newEntity = {
                titulo: titulo, 
                descripcion: descripcion,
                ejercicio: ejercicio, 
                resultado: resultado,
                dificultad: dificultad,
                discriminador: discriminador,
                azar: azar,
                d: d,
                tipo: tipo,      
                habilitado: true,
            };
            
             var postActividad = svc.one(docenteId).one('cursos', cursoId).one('temas', temaId).one('conceptos', conceptoId);

            return postActividad.post('actividads' , newEntity);
        }
 
        function editActividad (titulo, descripcion, ejercicio, resultado, dificultad, discriminador, azar, d, tipo, cursoId, docenteId, temaId, conceptoId, actividadId) {
            
            var editEntity = {
                titulo: titulo, 
                descripcion: descripcion,
                ejercicio: ejercicio, 
                resultado: resultado,
                dificultad: dificultad,
                discriminador: discriminador,
                azar: azar,
                d: d,
                tipo: tipo,      
                habilitado: true,
            };
            
             var putActividad = svc.one(docenteId).one('cursos', cursoId).one('temas', temaId).one('conceptos', conceptoId).one('actividads', actividadId);

            return putActividad.customPUT(editEntity);
        }
        
    }
})();

