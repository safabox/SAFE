(function () {
    'use strict';

    angular.module('app.docente.cursos')
        .controller('DocenteCursosEdit', controller);

    controller.$inject = ['_', '$q', 'DocenteCursos', '$state', 'logger', 'debugModeEnabled', '$stateParams', 'UsuarioService', 'NgTableParams', 'CrearTemaPopup', 'messageBox', '$filter']; 
    
    function controller(_, $q, DocenteCursos, $state, logger, debugModeEnabled, $stateParams, UsuarioService, NgTableParams, CrearTemaPopup, messageBox, $filter) {
        
        var vm = this;
        vm.loading = true;
        vm.background = $stateParams.background;
        vm.debug = debugModeEnabled;
        vm.editMode = ($state.includes('**.edit'));
        vm.noDataTemas = true; 
        vm.docenteId = UsuarioService.getUserCurrentDoc();
        
        vm.agregarNuevoTema = agregarNuevoTema;
        vm.eliminarTema = eliminarTema;
        vm.puedeEliminar = puedeEliminar;
        vm.puedeRecuperar = puedeRecuperar;
        vm.recuperarTema = recuperarTema;
        vm.goEditTema = goEditTema;
        
        vm.select = select;
        vm.onFilterChange = onFilterChange;
        vm.onNumPerPageChange = onNumPerPageChange;
        vm.onOrderChange = onOrderChange;
        vm.search = search;
        vm.order = order;
        
        vm.guardar = guardar;
        vm.groupInfoGral = { isOpen: true };
        vm.groupTemas = { isOpen: true };
        vm.goAlumno = goAlumno;
        
        /*
        vm.fieldLabels = [
            { name: 'titulo', label: 'Título' },
            { name: 'descripcion', label: 'Descripción' },
        ];
        
        vm.temasTableParams = new NgTableParams({
            page: 1,
            count: 10
        }, {
            total: 0,
            counts: [8, 10, 20, 50, 100],
            getData: getTemasTabla
        });*/        
        
        activate();
        
        function activate() {
            
            loadData();
            
            function loadData() {

                $q.all([cargarCurso()])
                    .then(onLoadComplete);

                function cargarCurso(){     
                    var curso = DocenteCursos.one(vm.docenteId).one('cursos', $stateParams.id);  
                    return  curso.get().then(onSuccess, onError);

                    function onSuccess(response) {            
                        vm.curso = response.plain(); 
                        if (vm.editMode) {
                            vm.title = vm.curso.titulo;
                            vm.subTitle = vm.curso.copete;
                        }
                    }        
                    function onError(httpResponse) {
                        logger.error('No se pudo obtener el Curso', httpResponse);
                    }         
                }
                
                function onLoadComplete() {
                    vm.loading = false;

                    vm.searchKeywords = '';
                    vm.filteredStores = [];
                    vm.row = '';
                    vm.numPerPageOpt = [2,9,20];
                    vm.numPerPage = vm.numPerPageOpt[1];
                    vm.currentPage = 1;
                    vm.currentPageStores = [];
                    
                    if (vm.editMode){      
                        vm.cantidadTemas = _.size(vm.curso.temas);                
                        if(vm.cantidadTemas !== 0) vm.noDataTemas = false; 
                    }
                    else{
                        vm.curso = '';
                    }
                    
                    init();
                
                    function init () {
                        vm.search();
                        return vm.select(vm.currentPage);
                    };   
                }
            }         
        }
        
        function agregarNuevoTema() {
            CrearTemaPopup.show(vm.curso.id, vm.docenteId, vm.curso.temas, vm.curso, false).then(onClose);
            
            function onClose() {
                $state.reload();
            }
        }

        /* function getTemasTabla(params) {
            params.total(vm.curso.temas.length);

            var result = vm.curso.temas.slice((params.page() - 1) * params.count(), params.page() * params.count());
            return result;              
        }*/
                
        function guardar() {
            goBack();
        }
        
        function eliminarTema(tema) {
            var title = '¿Desea eliminar el tema ' + tema.titulo + '?, perderá la configuración de predecesoras y orden.';
            messageBox.showOkCancel(title)
                .then(function (answer) {
                    if (answer === 'ok') {
                        var temaRemove = DocenteCursos.one(vm.docenteId).one('cursos', vm.curso.id).one('temas', tema.id);  
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
                        var temaRecuperar = DocenteCursos.one(vm.docenteId).one('cursos', vm.curso.id).one('temas', tema.id);  
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
        
        function goEditTema(tema){
            $state.go('docente.cursos.tema.edit', { id: tema.id, idCurso: vm.curso.id, background: vm.background});
        }

        function select(page) {
            var end, start;
            start = (page - 1) * vm.numPerPage;
            end = start + vm.numPerPage;
            return vm.currentPageStores = vm.filteredStores.slice(start, end);
        };

        function onFilterChange() {
            vm.select(1);
            vm.currentPage = 1;
            return vm.row = '';
        };

        function onNumPerPageChange() {
            vm.select(1);
            return vm.currentPage = 1;
        };

        function onOrderChange() {
            vm.select(1);
            return vm.currentPage = 1;
        };

        function search() {
            vm.filteredStores = $filter('filter')(vm.curso.temas, vm.searchKeywords);
            return vm.onFilterChange();
        };

        function order(rowName) {
            if (vm.row === rowName) {
                return;
            }
            vm.row = rowName;
            vm.filteredStores = $filter('orderBy')(vm.curso.temas, rowName);
            return vm.onOrderChange();
        }; 
        
        function goAlumno(alumno) {
            $state.go('docente.cursos.alumno.view', {idCurso: vm.curso.id, idAlumno: alumno.id, background: vm.background, data: {alumno: alumno}});
            
        }
        
    }
})(); 



