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
            }
        ];
    }
    
})();    

