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
            }
        ];
    }
    
})();    

