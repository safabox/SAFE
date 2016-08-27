/*(function() {   
    window['staticPath'] = (window['staticPath']) ? window['staticPath'] : '/';
    window['host'] = (window['host']) ? window['host'] : '/';
})(); */

(function () {
    'use strict';

    angular.module('app')
        .config(['$stateProvider', '$urlRouterProvider', 'SystemConfigProvider','environment', function($stateProvider, $urlRouterProvider, SystemConfigProvider, environment) {

            SystemConfigProvider.setStaticPath(environment.staticPath);
            SystemConfigProvider.setHost(environment.apiUrlBaseLogin);           
            $stateProvider
                .state("login", {
                    url: "/login",
                    templateUrl: SystemConfigProvider.getStaticPath() + "app/page/signin.html",
                    controller: 'LoginCtrl',
                    controllerAs: 'vm',
                    params: {
                          toStateOriginal: null,
                          toParamsOriginal: null
                    }
                })
                .state("dashboard", {
                    url: "/",
                    templateUrl: SystemConfigProvider.getStaticPath() + 'app/dashboard/dashboard.html',                  
                    roles: ["ROLE_SUPER_ADMIN", "ROLE_ADMIN"],   
                })

                .state('admin', {
                    abstract: true,
                    url: '/admin',
                    template: '<ui-view/>'
                })
                .state('admin.dashboard', {                    
                    url: '/dashboard',
                    templateUrl: SystemConfigProvider.getStaticPath() + 'app/administrador/admin_dashboard.html',                  
                    roles: ["ROLE_SUPER_ADMIN", "ROLE_ADMIN"],
                    controller: 'AdminDashboardCtrl',
                    controllerAs: 'vm',    
                    params: {error: null}
                })

                .state('alumno', {
                    abstract: true,
                    url: '/alumno',
                    template: '<ui-view/>'
                })                
                .state('alumno.dashboard', {                    
                    url: '/dashboard',
                    templateUrl: SystemConfigProvider.getStaticPath() + 'app/alumnos/alumno_dashboard.html',
                    roles: ["ROLE_ALUMNO"],
                    params: {error: null}
                })

                .state('docente', {
                    abstract: true,
                    url: '/docente',
                    template: '<ui-view/>'
                })
                .state('docente.dashboard', {                    
                    url: '/dashboard',
                    templateUrl: SystemConfigProvider.getStaticPath() + 'app/docentes/docente_dashboard.html',
                    roles: ["ROLE_DOCENTE"],
                    params: {error: null}
                })
                .state("404", {
                    url: "/404",
                    templateUrl: SystemConfigProvider.getStaticPath() + "app/page/404.html"
                })
                .state("lock-screen", {
                    url:"/lock-screen",
                    templateUrl: SystemConfigProvider.getStaticPath() + "app/page/lock-screen.html"
                });                
           $urlRouterProvider.otherwise("/");
        }]
    )
    .config(['$httpProvider', function($httpProvider){
        $httpProvider.defaults.useXDomain = true;
        delete $httpProvider.defaults.headers.common['X-Requested-With'];
    }])
    .run(['$rootScope', '$location', '$state','UsuarioService', 'SystemConfig', 'PaginaService',  function($rootScope, $location, $state, UsuarioService, SystemConfig, PaginaService){

        $rootScope.$on("$stateChangeStart", function(event, toState, toParams, fromState, fromParams, options){     
            if (!UsuarioService.isAutenticado()) {                            
              if (toState.templateUrl !== SystemConfig.getStaticPath() + 'app/page/signin.html') {                  
                  event.preventDefault();  
                  $state.go("login", {toStateOriginal: toState, toParamsOriginal: toParams});                                   
              }
            } else if (!UsuarioService.tieneRol(toState.roles)) {
                event.preventDefault();  
                $state.go(PaginaService.getInicio(), {error:{code: '401', message: 'Usuario no autorizado'}}); 
            }
        });    
    }]);

})(); 