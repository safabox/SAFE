(function () {
    'use strict';

    angular.module('app.administrador.cursos')
        .controller('AdministradorCursosEdit', controller);

    controller.$inject = ['_', '$q', 'AdminCursos', '$state', 'logger', 'debugModeEnabled', '$stateParams', 'NgTableParams', 'SeleccionarAlumnosPopup', 'SeleccionarDocentesPopup']; 
    
    function controller(_, $q, AdminCursos, $state, logger, debugModeEnabled, $stateParams, NgTableParams, SeleccionarAlumnosPopup, SeleccionarDocentesPopup) {
        
        var vm = this;
        vm.loading = true;
        vm.debug = debugModeEnabled;
        vm.editMode = ($state.includes('**.edit'));
        vm.noDataAlumnos = true;
        vm.noDataDocentes = true;
        
        
        vm.agregarAlumno = agregarAlumno;
        vm.eliminarAlumno = eliminarAlumno;       
        vm.agregarDocente = agregarDocente;
        vm.eliminarDocente = eliminarDocente;    
        
        vm.cancel = cancel;
        vm.groupInfoGral = { isOpen: true };
        vm.groupDocentes = { isOpen: true };
        vm.groupAlumnos = { isOpen: true };
        
        vm.fieldLabels = [
            { name: 'titulo', label: 'Título' },
            { name: 'copete', label: 'Copete' },
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
        
        vm.docentesTableParams = new NgTableParams({
            page: 1,
            count: 10
        }, {
            total: 0,
            counts: [10, 20, 50, 100],
            getData: getDocentesTabla
        });
        
        function activate() {
            
            loadData();
            
            function loadData() {

                $q.all([cargarCurso(), cargarDocentes(), cargarAlumnos()])
                    .then(onLoadComplete);

                function cargarCurso(){     
                    var curso = AdminCursos.one($stateParams.id);  
                    return  curso.get().then(onSuccess, onError);

                    function onSuccess(response) {            
                        vm.curso = response.plain();     
                    }        
                    function onError(httpResponse) {
                        logger.error('No se pudo obtener el Curso', httpResponse);
                    }         
                }

                function cargarDocentes(){
                    return  AdminCursos.one($stateParams.id).getList('docentes').then(onSuccess, onError);

                    function onSuccess(response) {            
                        vm.docentes = response.plain();     
                    }        
                    function onError(httpResponse) {
                        logger.error('No se pudo obtener los docentes del curso', httpResponse);
                    }       
                }

                function cargarAlumnos(){
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
                    
                    setTitle();
                    
                    if (vm.editMode){
                        vm.cantidadAlumnos = _.size(vm.alumnos);                
                        if(vm.cantidadAlumnos !== 0) vm.noDataAlumnos = false;  
                        vm.cantidadDocentes = _.size(vm.docentes);                
                        if(vm.cantidadDocentes !== 0) vm.noDataDocentes = false;                            
                    }
                    else{
                        vm.curso = '';
                    }
                }
                
                function setTitle() {
                    if (vm.editMode) {
                        vm.title = 'Editar Curso: ' + vm.curso.titulo;
                        vm.subTitle = 'MODIFICACION CURSO';
                    } else {
                        vm.title = 'Nuevo Curso';
                        vm.subTitle = 'ALTA CURSO';
                    }
                }     
            }
        }
        
        function getAlumnosTabla(params){
            params.total(vm.alumnos.length);

            var result = vm.alumnos.slice((params.page() - 1) * params.count(), params.page() * params.count());
            return result;                        
        }

        function getDocentesTabla(params){
            params.total(vm.docentes.length);

            var result = vm.docentes.slice((params.page() - 1) * params.count(), params.page() * params.count());
            return result;                        
        }        
 
        function agregarDocente() {
            var itemsNoSeleccionables = getItemsNoSeleccionables(vm.docentes);
            SeleccionarDocentesPopup.show(itemsNoSeleccionables, false, $stateParams.id).then(onClose);

            function getItemsNoSeleccionables(docentes) {
                var result = [];
                _.forEach(docentes, function (docente) {
                    result.push({
                        id: docente.id,
                    });
                }); 
                return result;
            }

            function onClose(result) {
                _.forEach(result, agregarDoc);
                vm.docentesTableParams.reload();

                function agregarDoc(docente) {
                    vm.docentes.push(crearAlumbo(docente));

                    function crearAlumbo(docente) {
                        return {
                            id: docente.id,
                            legajo: docente.legajo,
                            usuario: {
                                nombre: docente.usuario.nombre,
                                apellido: docente.usuario.apellido,
                            }
                        };
                    }
                }
                
                vm.cantidadDocentes = _.size(vm.docentes);                
                if(vm.cantidadDocentes !== 0) vm.noDataDocentes = false;                   
            }
        }        

        function eliminarDocente(idx) {
            vm.docentes.splice(idx, 1);
            vm.docentesTableParams.page(1);
            vm.docentesTableParams.reload();
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
                            usuario: {
                                nombre: alumno.usuario.nombre,
                                apellido: alumno.usuario.apellido,
                            }
                        };
                    }
                }
                
                vm.cantidadAlumnos = _.size(vm.alumnos);                
                if(vm.cantidadAlumnos !== 0) vm.noDataAlumnos = false;                   
            }
        }
        
        function eliminarAlumno(idx) {
            vm.alumnos.splice(idx, 1);
            vm.alumnosTableParams.page(1);
            vm.alumnosTableParams.reload();
        }        
        
        vm.guardar = guardar;
        function guardar() {
            
            var cursoPatch =
            {
                'titulo':  vm.curso.titulo,
                'copete': vm.curso.copete,
                'descripcion': '',
                'docentes': [],
                'alumnos': [],
                'habilitado':1
            };

            _.forEach(vm.alumnos, guardarAlumnos);
            function guardarAlumnos(alumno) {
                cursoPatch.alumnos.push(alumno.id);
            }
            
            _.forEach(vm.docentes, guardarDocentes);
            function guardarDocentes(docente) {
                cursoPatch.docentes.push(docente.id);
            }
            
            if (vm.editMode) {   
                var curso = AdminCursos.one($stateParams.id);                
                curso.patch(cursoPatch).then(onSuccess,onError);
                
            }else{
                AdminCursos.post(cursoPatch).then(onSuccess,onError);
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

