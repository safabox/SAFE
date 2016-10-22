(function () {
    'use strict';

    angular.module('app.administrador.docentes')
        .controller('AdministradorDocentesCtrl', controller);

    controller.$inject = ['$q', 'messageBox','$state','AdminDocentes', 'logger', '$filter'];

    function controller($q, messageBox, $state, AdminDocentes, logger, $filter) {
        var vm = this;
        vm.loading = true;
        vm.noData = true;
        
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
            
            $q.all([getDocentes()])
                .then(onLoadComplete);

            function getDocentes(){        
                return AdminDocentes.getList().then(onSuccess, onError);

                function onSuccess(response) {            
                    vm.docentes = response.plain();    
                    console.log(vm.docentes);
                }        
                function onError(httpResponse) {
                    logger.error('No se pudieron obtener los Docentes', httpResponse);
                }            
            }

            function onLoadComplete() {
                vm.loading = false;
                
                vm.cantidadDocentes = _.size(vm.docentes);                
                if(vm.cantidadDocentes !== 0) vm.noData = false;   
                
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
            $state.go('admin.docentes.new');
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
            vm.filteredStores = $filter('filter')(vm.docentes, vm.searchKeywords);
            return vm.onFilterChange();
        };

        function order(rowName) {
            if (vm.row === rowName) {
                return;
            }
            vm.row = rowName;
            vm.filteredStores = $filter('orderBy')(vm.docentes, rowName);
            return vm.onOrderChange();
        };        
        
        function puedeEliminar(docente){
            if(docente.usuario.enabled === true){
                return true;
            }else{
                return false;
            }
        }
        
        function puedeRecuperar(docente){
            if(docente.usuario.enabled === true){
                return false;
            }else{
                return true;
            }
        }
        
        function eliminar(docente){
            var title = '¿Desea eliminar el docente ' + docente.usuario.nombre + '?';
            messageBox.showOkCancel(title)
                .then(function (answer) {
                    if (answer === 'ok') {
                        var docenteRemove = AdminDocentes.one(docente.id);
                        
                        var docentePatch =
                        {
                            'usuario': {
                                'enabled': false
                            }
                        };
                
                        docenteRemove.patch(docentePatch).then(onSuccess, onError);
                    }
                });
            
            function onSuccess() {
                logger.info('Registro eliminado');
                $state.reload()
            }

            function onError(httpResponse) {
                logger.error('No se pudo eliminar el docente', httpResponse);
            }
        }
        
        function recuperar(docente){
            var title = '¿Desea recuperar el docente ' + docente.usuario.nombre + '?';
            messageBox.showOkCancel(title)
                .then(function (answer) {
                    if (answer === 'ok') {
                        var docenteRecover = AdminDocentes.one(docente.id); 
                
                        var docentePatch =
                        {
                            'usuario': {
                                'enabled': true
                            }
                        };
                
                        docenteRecover.patch(docentePatch).then(onSuccess, onError);
                    }
                });

            function onSuccess() {
                logger.info('Registro recuperado');
                $state.reload()
            }

            function onError(httpResponse) {
                logger.error('No se pudo recuperar el Docente', httpResponse);
            }
        }
        
        
        
    }


})(); 