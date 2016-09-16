(function () {
    'use strict';

    angular.module('app')
        .controller('AdministradorAlumnosCtrl', controller);

    controller.$inject = ['$q', '$state','AdminAlumnos', 'logger', '$filter'];

    function controller($q, $state, AdminAlumnos, logger, $filter) {
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
                
        loadData();
        
        function loadData() {
            
            $q.all([getAlumnos()])
                .then(onLoadComplete);

            function getAlumnos(){        
                return AdminAlumnos.getList().then(onSuccess, onError);

                function onSuccess(response) {            
                    vm.alumnos = response.plain();    
                    console.log(vm.alumnos);
                }        
                function onError(httpResponse) {
                    logger.error('No se pudieron obtener los Alumnos', httpResponse);
                }            
            }

            function onLoadComplete() {
                vm.loading = false;
                
                vm.cantidadAlumnos = _.size(vm.alumnos);                
                if(vm.cantidadAlumnos !== 0) vm.noData = false;   
                
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
            $state.go('admin.alumnos.new');
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
            vm.filteredStores = $filter('filter')(vm.alumnos, vm.searchKeywords);
            return vm.onFilterChange();
        };

        function order(rowName) {
            if (vm.row === rowName) {
                return;
            }
            vm.row = rowName;
            vm.filteredStores = $filter('orderBy')(vm.alumnos, rowName);
            return vm.onOrderChange();
        };        
        
    }


})(); 