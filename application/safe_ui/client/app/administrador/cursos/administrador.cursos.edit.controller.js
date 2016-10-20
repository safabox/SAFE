(function () {
    'use strict';

    angular.module('app.administrador.cursos')
        .controller('AdministradorCursosEdit', controller);

    controller.$inject = ['$q', 'AdminCursos', '$state', 'logger', 'debugModeEnabled', '$stateParams', 'NgTableParams', 'SeleccionarAlumnosPopup']; 
    
    function controller($q, AdminCursos, $state, logger, debugModeEnabled, $stateParams, NgTableParams, SeleccionarAlumnosPopup) {
        
        var vm = this;
        vm.loading = true;
        vm.debug = debugModeEnabled;
        vm.editMode = ($state.includes('**.edit'));
        vm.noDataAlumnos = true;
        
        vm.agregarAlumno = agregarAlumno;
        vm.eliminarAlumno = eliminarAlumno;
        vm.cancel = cancel;
        vm.groupInfoGral = { isOpen: true };
        vm.groupDocentes = { isOpen: true };
        vm.groupAlumnos = { isOpen: true };
        
        vm.fieldLabels = [
            { name: 'titulo', label: 'Título' },
            { name: 'descripcion', label: 'Descripción' },
        ];
        
        activate();

        vm.alumnosTableParams = new NgTableParams({
            page: 1,
            count: 10
        }, {
            total: 0,
            counts: [10, 20, 50, 100],
            getData: getAlumnosTabla
        });
        
        function activate() {
            
            setTitle();
            loadData();
            
            function loadData() {

                $q.all([getCurso(), getAlumnos()])
                    .then(onLoadComplete);

                function getCurso(){     
                    var curso = AdminCursos.one($stateParams.id);  
                    return  curso.get().then(onSuccess, onError);

                    function onSuccess(response) {            
                        vm.curso = response.plain();     
                    }        
                    function onError(httpResponse) {
                        logger.error('No se pudo obtener el Curso', httpResponse);
                    }         
                }
/*
                function getDocentes(){
                    return  AdminCursos.one($stateParams.id).getList('docentes').then(onSuccess, onError);

                    function onSuccess(response) {            
                        vm.docentes = response.plain();     
                    }        
                    function onError(httpResponse) {
                        logger.error('No se pudo obtener los docentes del curso', httpResponse);
                    }       
                }
*/
                function getAlumnos(){
                    return AdminCursos.one($stateParams.id).getList('alumnos').then(onSuccess, onError);

                    function onSuccess(response) {            
                        vm.alumnos = response.plain();     
                    }        
                    function onError(httpResponse) {
                        logger.error('No se pudo obtener los alumnos del curso', httpResponse);
                    }                   
                }

                function onLoadComplete() {
                    vm.loading = false;
                    
                    if (vm.editMode){
                        setTitle();
                        vm.cantidadAlumnos = _.size(vm.alumnos);                
                        if(vm.cantidadAlumnos !== 0) vm.noDataAlumnos = false;   
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
                } else {
                    vm.title = 'Nuevo Curso';
                    vm.subTitle = 'ALTA CURSO';
                }
            }            
        }
        
        function getAlumnosTabla(params){
            params.total(vm.alumnos.length);

            var result = vm.alumnos.slice((params.page() - 1) * params.count(), params.page() * params.count());
            return result;                        
        }
        
        function agregarAlumno() {
            var itemsNoSeleccionables = getItemsNoSeleccionables(vm.alumnos);
            SeleccionarAlumnosPopup.show(itemsNoSeleccionables, false, $stateParams.id).then(onClose);

            function getItemsNoSeleccionables(alumnos) {
                var result = [];
                _.forEach(alumnos, function (alumno) {
                    result.push({
                        id: alumno.id,
                    });
                });
                return result;
            }

            function onClose(result) {
                _.forEach(result, agregarAlu);
                vm.alumnosTableParams.reload();

                function agregarAlu(alumno) {
                    vm.alumnos.push(crearAlumbo(alumno));

                    function crearAlumbo(alumno) {
                        return {
                            id: alumno.id,
                            legajo: alumno.legajo,
                            nombre: alumno.usuario.nombre,
                            apellido: alumno.usuario.apellido,
                        };
                    }
                }
            }
        }
        
        function eliminarAlumno(idx) {
            vm.alumnos.splice(idx, 1);
            vm.alumnosTableParams.page(1);
            vm.alumnosTableParams.reload();
        }        
        
        vm.guardar = guardar;
        function guardar() {
            
            if (vm.editMode) {   
                
                var cursoPut =
                {
                    'titulo':  vm.curso.titulo,
                    'descripcion': vm.curso.descripcion                    
                };
                
                var curso = AdminCursos.one($stateParams.id);
                curso.customPUT(cursoPut).then(onSuccess,onError);
            }else{
                AdminCursos.post(vm.curso).then(onSuccess,onError);
            }
            
            function onSuccess() {
                logger.info('Curso Guardado');
                vm.form.$dirty = false;
                goBack();
            }
            function onError(httpResponse) {
                console.log(httpResponse);
                logger.error('No se pudo guardar el Curso', httpResponse);
            }
              
        }
        
        function goBack() {
            $state.go('^.list');
        }
        
        function cancel() {
            goBack();
        }
        
    }

})(); 

