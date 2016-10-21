(function () {
    'use strict';

    angular.module('app.administrador.cursos')
        .controller('AdministradorCursosCtrl', controller);

    controller.$inject = ['$q', 'messageBox','$state','AdminCursos', 'logger', '$filter', 'debugModeEnabled'];

    function controller($q, messageBox, $state, AdminCursos, logger, $filter, debugModeEnabled) {
        var vm = this;
        vm.loading = true;
        vm.noData = true;
        vm.debug = debugModeEnabled;
        
        vm.select = select;
        vm.onFilterChange = onFilterChange;
        vm.onNumPerPageChange = onNumPerPageChange;
        vm.onOrderChange = onOrderChange;
        vm.search = search;
        vm.order = order;
        vm.irNuevo = irNuevo;
        vm.puedeEliminar = puedeEliminar;
        vm.puedeRecuperar = puedeRecuperar;
        vm.eliminar = eliminar;
        vm.recuperar = recuperar;
        
        loadData();
        
        function loadData() {
            
            $q.all([getCursos()])
                .then(onLoadComplete);

            function getCursos(){        
                return AdminCursos.getList().then(onSuccess, onError);

                function onSuccess(response) {            
                    vm.cursos = response.plain();    
                    console.log(vm.cursos);
                }        
                function onError(httpResponse) {
                    logger.error('No se pudieron obtener los Docentes', httpResponse);
                }            
            }

            function onLoadComplete() {
                vm.loading = false;
                
                vm.cantidadCursos = _.size(vm.cursos);                
                if(vm.cantidadCursos !== 0) vm.noData = false;   
                
                vm.searchKeywords = '';
                vm.filteredStores = [];
                vm.row = '';
                vm.numPerPageOpt = [2, 5, 10, 20];
                vm.numPerPage = vm.numPerPageOpt[2];
                vm.currentPage = 1;
                vm.currentPageStores = [];
                
                init();
                
                function init () {
                    vm.search();
                    return vm.select(vm.currentPage);
                };                
            }
        }
        
        function irNuevo() {
            $state.go('admin.cursos.new');
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
            vm.filteredStores = $filter('filter')(vm.cursos, vm.searchKeywords);
            return vm.onFilterChange();
        };

        function order(rowName) {
            if (vm.row === rowName) {
                return;
            }
            vm.row = rowName;
            vm.filteredStores = $filter('orderBy')(vm.cursos, rowName);
            return vm.onOrderChange();
        };        
        
        function puedeEliminar(curso){
            if(curso.enabled === true){
                return true;
            }else{
                return false;
            }
        }
        
        function puedeRecuperar(curso){
            if(curso.enabled === true){
                return false;
            }else{
                return true;
            }
        }
        
        
        function eliminar(curso){
            var title = '¿Desea eliminar el curso ' + curso.usuario.nombre + '?';
            messageBox.showOkCancel(title)
                .then(function (answer) {
                    if (answer === 'ok') {
                        var cursoRemove = AdminCursos.one(curso.id);  
                        cursoRemove.remove().then(onSuccess, onError);
                    }
                });
            
            function onSuccess() {
                logger.info('Registro eliminado');
            }

            function onError(httpResponse) {
                logger.error('No se pudo eliminar el curso', httpResponse);
            }
        }
        
        function recuperar(curso){
            var title = '¿Desea recuperar el curso ' + curso.usuario.nombre + '?';
            messageBox.showOkCancel(title)
                .then(function (answer) {
                    if (answer === 'ok') {
                        var cursoRecover = AdminCursos.one(curso.id);  
                        cursoRecover.recover().then(onSuccess, onError);
                    }
                });


            function onSuccess() {
                logger.info('Registro recuperado');
            }

            function onError(httpResponse) {
                logger.error('No se pudo recuperar el Curso', httpResponse);
            }
        }
        
        
        
    }


})(); 