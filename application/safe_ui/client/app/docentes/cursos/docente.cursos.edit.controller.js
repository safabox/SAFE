(function () {
    'use strict';

    angular.module('app.docente.cursos')
        .controller('DocenteCursosEdit', controller);

    controller.$inject = ['_', '$q', 'DocenteCursos', '$state', 'logger', 'debugModeEnabled', '$stateParams', 'UsuarioService', 'NgTableParams', 'CrearTemaPopup', 'messageBox']; 
    
    function controller(_, $q, DocenteCursos, $state, logger, debugModeEnabled, $stateParams, UsuarioService, NgTableParams, CrearTemaPopup, messageBox) {
        
        var vm = this;
        vm.loading = true;
        vm.debug = debugModeEnabled;
        vm.editMode = ($state.includes('**.edit'));
        vm.noDataTemas = true; 
        vm.agregarNuevoTema = agregarNuevoTema;
        vm.eliminarTema = eliminarTema;
        vm.puedeEliminar = puedeEliminar;
        vm.puedeRecuperar = puedeRecuperar;
        vm.recuperarTema = recuperarTema;
        
        vm.guardar = guardar;
        vm.groupInfoGral = { isOpen: true };
        vm.groupTemas = { isOpen: true };
        
        vm.fieldLabels = [
            { name: 'titulo', label: 'Título' },
            { name: 'descripcion', label: 'Descripción' },
        ];
        
        vm.temasTableParams = new NgTableParams({
            page: 1,
            count: 10
        }, {
            total: 0,
            counts: [10, 20, 50, 100],
            getData: getTemasTabla
        });        
        
        activate();
        
        function activate() {
            
            setTitle();
            loadData();
            
            function loadData() {

                $q.all([cargarCurso()])
                    .then(onLoadComplete);

                function cargarCurso(){     
                    var curso = DocenteCursos.one(UsuarioService.getUserCurrentDoc()).one('cursos', $stateParams.id);  
                    return  curso.get().then(onSuccess, onError);

                    function onSuccess(response) {            
                        vm.curso = response.plain();     
                    }        
                    function onError(httpResponse) {
                        logger.error('No se pudo obtener el Curso', httpResponse);
                    }         
                }
                
                function onLoadComplete() {
                    vm.loading = false;
                    
                    if (vm.editMode){
                        setTitle();   
                                                
                        vm.cantidadTemas = _.size(vm.curso.temas);                
                        if(vm.cantidadTemas !== 0) vm.noDataTemas = false; 
                    }
                    else{
                        vm.curso = '';
                    }
                }
            }
            
            function setTitle() {
                if (vm.editMode) {
                    vm.title = 'Editar Curso ' + $stateParams.id;
                    vm.subTitle = 'MODIFICACION CURSO';
                }
            }            
        }
        
        function agregarNuevoTema() {
            CrearTemaPopup.show(vm.curso.id, UsuarioService.getUserCurrentDoc(), vm.curso.temas, vm.curso, false).then(onClose);
            
            function onClose() {
                $state.reload();
            }
        }

        function getTemasTabla(params) {
            params.total(vm.curso.temas.length);

            var result = vm.curso.temas.slice((params.page() - 1) * params.count(), params.page() * params.count());
            return result;              
        }
                
        function guardar() {
            goBack();
        }
        
        function eliminarTema(tema) {
            var title = '¿Desea eliminar el tema ' + tema.titulo + '?, perderá la configuración de predecesoras y orden.';
            messageBox.showOkCancel(title)
                .then(function (answer) {
                    if (answer === 'ok') {
                        var temaRemove = DocenteCursos.one(UsuarioService.getUserCurrentDoc()).one('cursos', vm.curso.id).one('temas', tema.id);  
                        var temaPut =
                        {
                            titulo: tema.titulo, 
                            descripcion: tema.descripcion, 
                            orden: tema.orden,
                            predecesoras: [],
                            habilitado: false,
                        };                
                        temaRemove.customPUT(temaPut).then(onSuccess, onError); 
                    }
                });
            
            function onSuccess() {
                logger.info('Registro eliminado');
                $state.reload()
            }

            function onError(httpResponse) {
                logger.error('No se pudo eliminar el tema', httpResponse);
            }           
        }

        function recuperarTema(tema) {
            var title = '¿Desea recuperar el tema ' + tema.titulo + '?';
            messageBox.showOkCancel(title)
                .then(function (answer) {
                    if (answer === 'ok') {
                        var temaRecuperar = DocenteCursos.one(UsuarioService.getUserCurrentDoc()).one('cursos', vm.curso.id).one('temas', tema.id);  
                        var temaPut =
                        {
                            titulo: tema.titulo, 
                            descripcion: tema.descripcion, 
                            orden: tema.orden,
                            predecesoras: [],
                            habilitado: true,
                        };                
                        temaRecuperar.customPUT(temaPut).then(onSuccess, onError); 
                    }
                });
            
            function onSuccess() {
                logger.info('Registro recuperado');
                $state.reload();
            }

            function onError(httpResponse) {
                logger.error('No se pudo recuperar el tema', httpResponse);
            }  
        }           
        
        function puedeEliminar(tema){
            if(tema.habilitado === true){
                return true;
            }else{
                return false;
            }
        }
        
        function puedeRecuperar(tema){
            if(tema.habilitado === true){
                return false;
            }else{
                return true;
            }
        }
        
        function goBack() {
            $state.go('^.list');
        }
    }
})(); 



