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
                    params: {error: null}
                }
            },
            {
                state: 'alumno.tema',
                config: {
                    abstract: true,
                    url: '/tema',
                    template: '<ui-view/>'
                }
            },
            {
                state: 'alumno.tema.dashboard',
                config: {
                    url: '/:cursoId/dashboard/:background',
                    templateUrl: path + 'app/alumnos/temas/tema.dashboard.html',
                    controller: 'AlumnoTemaDashboardCtrl',
                    controllerAs: 'vm',
                    roles: ["ROLE_ALUMNO"],
                    params: {error: null}
                }
            },
            {
                state: 'alumno.concepto',
                config: {
                    abstract: true,
                    url: '/concepto',
                    template: '<ui-view/>'
                }
            },
            {
                state: 'alumno.concepto.dashboard',
                config: {
                    url: '/:cursoId/:temaId/dashboard/:background',
                    templateUrl: path + 'app/alumnos/conceptos/concepto.dashboard.html',
                    controller: 'AlumnoConceptoDashboardCtrl',
                    controllerAs: 'vm',
                    roles: ["ROLE_ALUMNO"],
                    params: {error: null}
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
                    params: {error: null}
                }
            }
        ];
    }
    
})();    

