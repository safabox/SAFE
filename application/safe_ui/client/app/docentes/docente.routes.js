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
            {
                state: 'docente.cursos.list',
                config: {
                    url: '/cursos',
                    templateUrl: path + 'app/docentes/cursos/docente.cursos.list.html',
                    roles: ["ROLE_DOCENTE"],
                    controller: 'DocenteCursosCtrl',
                    controllerAs: 'vm',    
                    params: {error: null}
                }
            },
            {
                state: 'docente.cursos.edit',
                config: {
                    url: '/cursos/:id',
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
                    url: '/cursos/tema/:id&:idCurso',
                    templateUrl: path + 'app/docentes/cursos/docente.cursos.temas.html',
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
                    url: '/cursos/tema/:id&:idTema&:idCurso',
                    templateUrl: path + 'app/docentes/cursos/docente.cursos.temas.concepto.html',
                    roles: ["ROLE_DOCENTE"],
                    controller: 'TemaConceptoCursosEdit',
                    controllerAs: 'vm',    
                    params: {error: null}
                }
            }, 
            {
                state: 'docente.cursos.actividad',
                config: {
                    abstract: true,
                    url: '',
                    template: '<ui-view/>'
                }
            },              
            {
                state: 'docente.cursos.actividad.edit',
                config: {
                    url: '/cursos/actividad/:id',
                    templateUrl: path + 'app/docentes/cursos/docente.cursos.actividad.html',
                    roles: ["ROLE_DOCENTE"],
                    controller: 'ActividadCursosEdit',
                    controllerAs: 'vm',    
                    params: {error: null}
                }
            },  
        ];
    }
    
})();    

