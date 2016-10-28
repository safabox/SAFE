(function () {
    'use strict';

    angular
        .module('app.administrador.cursos')
        .factory('SeleccionarAlumnosPopup', factory);

    factory.$inject = ['$uibModal', '$q'];

    function factory($uibModal, $q) {
        return {
            show: show,
        };

        function show(itemsNoSeleccionables, seleccionSimple) {
            var deferred = $q.defer();

            var modalInstance = $uibModal.open({
                size: 'lg',
                templateUrl: 'app/administrador/cursos/seleccionar-alumnos-popup.tpl.html',
                controller: controller,
                controllerAs: 'vm',
                resolve: {
                    itemsNoSeleccionables: function () { return itemsNoSeleccionables; },
                    modoMultiple: function () { return seleccionSimple !== true; },
                }
            });

            modalInstance.result.then(onClose, onDismiss);

            return deferred.promise;

            function onClose(result) {
                deferred.resolve(result);
            }

            function onDismiss(reason) {
                deferred.reject(reason);
            }
        }
    }

    controller.$inject = ['$q', '_', '$scope', '$uibModalInstance', 'itemsNoSeleccionables', 'modoMultiple', 'NgTableParams', 'AdminAlumnos'];

    function controller($q, _, $scope, $uibModalInstance, itemsNoSeleccionables, modoMultiple, NgTableParams, AdminAlumnos) {
        var vm = this;

        vm.loading = true;

        vm.itemsNoSeleccionables = itemsNoSeleccionables;
        vm.modoMultiple = modoMultiple;

        vm.itemsSeleccionados = [];
        vm.seleccionarTodos = false;
        vm.seleccionValida = false;

        //vm.searchFilters = entityProvider.getSearchFilters();

        vm.detallesTableParams = new NgTableParams({
            page: 1,
            count: 8,
            sorting: {
                id: 'asc'
            }
        }, {
            total: 0,
            counts: [],
            getData: getData
        });

        vm.ok = ok;
        vm.cancel = cancel;
        vm.seleccionarItem = seleccionarItem;
        vm.search = search;

        vm.selectAll = {
            checked: false,
        };

        activate();

        function activate() {
            $scope.$watch('vm.selectAll.checked', onSelectAll);

            function onSelectAll(value) {
                _.forEach(vm.detallesTableParams.data, function (item) {
                    if (!item.deshabilitado) {
                        item.seleccionado = value;
                        seleccionarItem(item);
                    }
                });
            }
        }

        function ok() {
            var result = getResult();
            $uibModalInstance.close(result);

            function getResult() {
                if (vm.modoMultiple) {
                    return vm.itemsSeleccionados;
                }
                return vm.itemSeleccionado;
            }
        }

        function cancel() {
            $uibModalInstance.dismiss();
        }

        function seleccionarItem(item) {
            if (vm.modoMultiple) {
                seleccionMultiple(item);
            } else {
                seleccionSimple(item);
            }

            function seleccionSimple(item) {
                vm.itemSeleccionado = item;
                vm.seleccionValida = true;
            }

            function seleccionMultiple(item) {
                if (item.seleccionado) {
                    vm.itemsSeleccionados.push(item.plain());
                } else {
                    _.remove(vm.itemsSeleccionados, { id: item.id });
                }
                vm.seleccionValida = vm.itemsSeleccionados.length > 0;
            }
        }

        function search(filter) {
            vm.activeSearchFilter = filter;
            vm.detallesTableParams.page(1);
            vm.detallesTableParams.reload();
        }

        function getData(params) {
            var apiParams = {
                count: params.count(),
                page: params.page(),
                sort: params.orderBy(),
            };

            var filter = vm.activeSearchFilter;

            if (filter) {
                apiParams.search = vm.activeSearchFilter;
            }

            var deferred = $q.defer();
            AdminAlumnos.getList().then(onSuccess, onError);
            
            return deferred.promise;

            function onError(httpResponse) {
                deferred.reject(httpResponse);
                goError('No se pueden obtener alumnos', httpResponse);
            }

            function onSuccess(result) {
                params.total(result.total);
                vm.loading = false;
                vm.noData = (result.total === 0) && !filter;
                vm.noFilteredData = (result.total === 0) && filter;
                var cantidadSeleccionados = 0;
                var cantidadNoSeleccionables = 0;

                _.forEach(result, function (item) {
                    item.deshabilitado = _.some(vm.itemsNoSeleccionables, { id: item.id });
                    item.seleccionado = _.some(vm.itemsSeleccionados, { id: item.id });

                    cantidadSeleccionados += item.seleccionado ? 1 : 0;
                    cantidadNoSeleccionables += item.deshabilitado ? 1 : 0;
                });

                var seleccionarTodos = (cantidadSeleccionados > 0 && (cantidadNoSeleccionables + cantidadSeleccionados) === result.length);
                vm.selectAll.checked = seleccionarTodos;

                deferred.resolve(result);
            }
        }

        function goError(errMsg, data) {
            logger.error('No se pudo guardar el Alumno');
        }
    }
})();
