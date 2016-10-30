(function () {
    'use strict';

    angular
        .module('app.alumno')
        .run(appRun);

    appRun.$inject = ['routerHelper', 'SystemConfig'];
    /* @ngInject */
    function appRun(routerHelper, SystemConfig) {
        routerHelper.configureStates(getStates(SystemConfig.getStaticPath()), '/');
    }

    function getStates(path) {
        return [       
            {
                state: 'alumno',
                config: {
                    abstract: true,
                    url: '/alumno',
                    template: '<ui-view/>'
                }
            },
            {
                state: 'alumno.dashboard',
                config: {
                    url: '/dashboard',
                    templateUrl: path + 'app/alumnos/alumno.dashboard.html',
                    controller: 'AlumnoDashboardCtrl',
                    controllerAs: 'vm',
                    roles: ["ROLE_ALUMNO"],
                }
            },
            {
                state: 'alumno.curso',
                config: {
                    abstract: true,
                    url: '/curso',
                    template: '<ui-view/>'
                }
            },
            {
                state: 'alumno.curso.tema',
                config: {
                    abstract: true,
                    url: '/:cursoId/tema',
                    template: '<ui-view/>'
                }
            },
            {
                state: 'alumno.curso.tema.dashboard',
                config: {
                    url: '/dashboard/:background',
                    templateUrl: path + 'app/alumnos/temas/tema.dashboard.html',
                    controller: 'AlumnoTemaDashboardCtrl',
                    controllerAs: 'vm',
                    roles: ["ROLE_ALUMNO"],
                    params: {error: null, data: null}
                }
            },
            {
                state: 'alumno.curso.tema.concepto',
                config: {
                    abstract: true,
                    url: '/:temaId/concepto',
                    template: '<ui-view/>'
                }
            },
            {
                state: 'alumno.curso.tema.concepto.dashboard',
                config: {
                    url: '/dashboard/:background',
                    templateUrl: path + 'app/alumnos/conceptos/concepto.dashboard.html',
                    controller: 'AlumnoConceptoDashboardCtrl',
                    controllerAs: 'vm',
                    roles: ["ROLE_ALUMNO"],
                    params: {error: null, data: null}
                }
            },            
            {
                state: 'alumno.actividad',
                config: {
                    abstract: true,
                    url: '/actividad',
                    template: '<ui-view/>'
                }
            },
            {
                state: 'alumno.actividad.home',
                config: {
                    url: '/home',
                    templateUrl: path + 'app/alumnos/actividades/actividad.home.html',
                    controller: 'AlumnoActividadHomeCtrl',
                    controllerAs: 'vm',
                    roles: ["ROLE_ALUMNO"],
                    params: {error: null, data: null, background: null}
                }
            }
        ];
    }
    
})();    

