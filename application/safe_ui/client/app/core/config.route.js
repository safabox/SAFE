(function () {
    'use strict';

    angular
        .module('app')
        .run(appRun);

    appRun.$inject = ['routerHelper', 'SystemConfig'];
    /* @ngInject */
    function appRun(routerHelper, SystemConfig) {
        routerHelper.configureStates(getStates(SystemConfig.getStaticPath()), '/');
    }

    function getStates(path) {
        return [
            {
                state: 'login',
                config: {
                    url: '/login',
                    templateUrl: path + 'app/page/signin.html',
                    controller: 'LoginCtrl',
                    controllerAs: 'vm',
                    params: {
                          toStateOriginal: null,
                          toParamsOriginal: null
                    }
                }
            },
            {
                state: 'dashboard',
                config: {
                    url: '/',
                    templateUrl: path + 'app/dashboard/dashboard.html',
                    roles: ["ROLE_SUPER_ADMIN", "ROLE_ADMIN"] 
                }
            },
            {
                state: 'admin',
                config: {
                    abstract: true,
                    url: '/admin',
                    template: '<ui-view/>'
                }
            },
            {
                state: 'admin.dashboard',
                config: {
                    url: '/dashboard',
                    templateUrl: path + 'app/administrador/administrador.dashboard.html', 
                    roles: ["ROLE_SUPER_ADMIN", "ROLE_ADMIN"],
                    controller: 'AdminDashboardCtrl',
                    controllerAs: 'vm',    
                    params: {error: null}
                }
            },
            {
                state: '404',
                config: {
                    url: '/404',
                    templateUrl: path + 'app/page/404.html'
                }
            },
            {
                state: 'lock-screen',
                config: {
                    url: '/lock-screen',
                    templateUrl: path + 'app/page/lock-screen.html'
                }
            }
        ];
    }
    
})();    
