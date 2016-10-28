(function () {
    'use strict';

    angular.module('app.docente.cursos')
        .controller('DocenteCursosCtrl', controller);

    controller.$inject = ['$q', 'DocenteCursos', 'logger', '$filter', 'debugModeEnabled', 'UsuarioService'];

    function controller($q, DocenteCursos, logger, $filter, debugModeEnabled, UsuarioService) {
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
        
        loadData();
        
        function loadData() {
            
            $q.all([getCursos()])
                .then(onLoadComplete);

            function getCursos(){
                var cursos = DocenteCursos.one(UsuarioService.getUserCurrentDoc());
                return cursos.getList('cursos').then(onSuccess, onError);

                function onSuccess(response) {            
                    vm.cursos = response.plain();    
                    console.log(vm.cursos);
                }        
                function onError(httpResponse) {
                    logger.error('No se pudieron obtener los Cursos del Docente', httpResponse);
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
    }


})(); 
