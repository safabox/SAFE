(function () {
    'use strict';

    angular
        .module('app.docente')
        .run(appRun);

    appRun.$inject = ['routerHelper', 'SystemConfig'];
    /* @ngInject */
    function appRun(routerHelper, SystemConfig) {
        routerHelper.configureStates(getStates(SystemConfig.getStaticPath()), '/');
    }

    function getStates(path) {
        return [       
            {
                state: 'docente',
                config: {
                    abstract: true,
                    url: '/docente',
                    template: '<ui-view/>'
                }
            },
            {
                state: 'docente.dashboard',
                config: {
                    url: '/dashboard',
                    templateUrl: path + 'app/docentes/docente.dashboard.html',
                    controller: 'DocenteDashboardCtrl',
                    controllerAs: 'vm',
                    roles: ["ROLE_DOCENTE"],
                    params: {error: null}
                }
            },
            {
                state: 'docente.cursos',
                config: {
                    abstract: true,
                    url: '',
                    template: '<ui-view/>'
                }
            },  
            /*{
                state: 'docente.cursos.list',
                config: {
                    url: '/cursos',
                    templateUrl: path + 'app/docentes/cursos/docente.cursos.list.html',
                    roles: ["ROLE_DOCENTE"],
                    controller: 'DocenteCursosCtrl',
                    controllerAs: 'vm',    
                    params: {error: null}
                }
            },*/
            {
                state: 'docente.cursos.edit',
                config: {
                    url: '/cursos/:id&:background',
                    templateUrl: path + 'app/docentes/cursos/docente.cursos.edit.html',
                    roles: ["ROLE_DOCENTE"],
                    controller: 'DocenteCursosEdit',
                    controllerAs: 'vm',    
                    params: {error: null}
                }
            },             
            {
                state: 'docente.cursos.tema',
                config: {
                    abstract: true,
                    url: '',
                    template: '<ui-view/>'
                }
            },  
            {
                state: 'docente.cursos.tema.edit',
                config: {
                    url: '/cursos/tema/:id&:idCurso&:background',
                    templateUrl: path + 'app/docentes/cursos/temas/docente.cursos.temas.html',
                    roles: ["ROLE_DOCENTE"],
                    controller: 'TemaCursosEdit',
                    controllerAs: 'vm',    
                    params: {error: null}
                }
            }, 
            {
                state: 'docente.cursos.tema.concepto',
                config: {
                    abstract: true,
                    url: '',
                    template: '<ui-view/>'
                }
            },  
            {
                state: 'docente.cursos.tema.concepto.edit',
                config: {
                    url: '/cursos/tema/concepto/:id&:idTema&:idCurso&:background',
                    templateUrl: path + 'app/docentes/cursos/conceptos/docente.cursos.temas.concepto.html',
                    roles: ["ROLE_DOCENTE"],
                    controller: 'TemaConceptoCursosEdit',
                    controllerAs: 'vm',    
                    params: {error: null}
                }
            }, 
           /* {
                state: 'docente.cursos.tema.concepto.actividad',
                config: {
                    abstract: true,
                    url: '',
                    template: '<ui-view/>'
                }
            },*/
            {
                state: 'docente.cursos.tema.concepto.newAct',
                config: {
                    url: '/cursos/tema/concepto/actividad/new/:idCurso&:idTema&:idConcepto&:background',
                    templateUrl: path + 'app/docentes/cursos/actividades/docente.cursos.temas.conceptos.actividad.html',
                    roles: ["ROLE_DOCENTE"],
                    controller: 'ActividadCursosEdit',
                    controllerAs: 'vm',    
                    params: {error: null}
                }
            },              
            {
                state: 'docente.cursos.tema.concepto.editAct',
                config: {
                    url: '/cursos/tema/concepto/actividad/:id&:idCurso&:idTema&:idConcepto&:background',
                    templateUrl: path + 'app/docentes/cursos/actividades/docente.cursos.temas.conceptos.actividad.html',
                    roles: ["ROLE_DOCENTE"],
                    controller: 'ActividadCursosEdit',
                    controllerAs: 'vm',    
                    params: {error: null}
                }
            },  
            
            {
                state: 'docente.cursos.alumno',
                config: {
                    abstract: true,
                    url: '/cursos/:idCurso',
                    template: '<ui-view/>'
                }
            },
            {
                state: 'docente.cursos.alumno.view',
                config: {
                    url: '/alumno/:idAlumno/dashboard/:background',
                    templateUrl: path + 'app/docentes/cursos/alumnos/docente.cursos.alumnos.html',
                    roles: ["ROLE_DOCENTE"],
                    controller: 'DocenteAlumnosCtrl',
                    controllerAs: 'vm',    
                    params: {error: null, data: null}
                }
            },
        ];
    }
    
})();    

