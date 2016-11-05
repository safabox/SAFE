(function () {
    'use strict';

    angular.module('app.docente')
        .controller('DocenteDashboardCtrl', ['$scope','$q','DocenteCursos','UsuarioService', '$state', 'debugModeEnabled', '$filter',DocenteDashboardCtrl])

    function DocenteDashboardCtrl($scope, $q, DocenteCursos,UsuarioService, $state, debugModeEnabled, $filter) {
        var vm = this;
        
        vm.loading = true;
        vm.debug = debugModeEnabled;
        vm.availableClass = ['primary', 'success', 'info', 'warning', 'danger'];
        
        vm.goCurso = goCurso;
        vm.hasFinished = hasFinished;
        
        vm.select = select;
        vm.onFilterChange = onFilterChange;
        vm.onNumPerPageChange = onNumPerPageChange;
        vm.onOrderChange = onOrderChange;
        vm.search = search;
        vm.order = order;
        
        
        loadData();
        
        function loadData() {
            $q.all([cargarDocente()])
                .then(onLoadComplete);
        
            function cargarDocente(){
                var cursos = DocenteCursos.one(UsuarioService.getUserCurrentDoc());
                return cursos.getList('cursos').then(onSuccess, onError);

                function onSuccess(response) {       
                    var backgroundIndex, cursos = response.plain();
                    
                    for(var i=0; i < cursos.length; i++) {
                        backgroundIndex = i % vm.availableClass.length;
                        cursos[i].background = vm.availableClass[backgroundIndex];
                    }
                    
                    vm.cursos = cursos;    
                }        
                function onError(httpResponse) {
                    logger.error('No se pudieron obtener los Cursos del Docente', httpResponse);
                }            
            }
            
            function onLoadComplete() {
                vm.loading = false;
                
                vm.searchKeywords = '';
                vm.filteredStores = [];
                vm.row = '';
                vm.numPerPageOpt = [2,6,20];
                vm.numPerPage = vm.numPerPageOpt[1];
                vm.currentPage = 1;
                vm.currentPageStores = [];
                
                init();
                
                function init () {
                    vm.search();
                    return vm.select(vm.currentPage);
                };                        

            }
        }

        function goCurso(item) {            
            $state.go('docente.cursos.edit', { id: item.id});
        }

        function hasFinished(curso) {
            return (curso.cant_alumnos == curso.cant_alumnos_finalizado);
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

