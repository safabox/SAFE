(function() {   
    window['staticPath'] = (window['staticPath']) ? window['staticPath'] : '/';
    window['host'] = (window['host']) ? window['host'] : '/';
})();

(function () {
    'use strict';

    angular.module('app')
        .config(['$stateProvider', '$urlRouterProvider', 'SystemConfigProvider', function($stateProvider, $urlRouterProvider, SystemConfigProvider) {
            var routes, setRoutes;          
            /*routes = [
                'dashboard',
                'ui/typography', 'ui/buttons', 'ui/icons', 'ui/grids', 'ui/widgets', 'ui/components', 'ui/boxes', 'ui/timeline', 'ui/pricing-tables', 'ui/maps',
                'table/static', 'table/dynamic', 'table/responsive',
                'form/elements', 'form/layouts', 'form/validation', 'form/wizard',
                'chart/echarts', 'chart/echarts-line', 'chart/echarts-bar', 'chart/echarts-pie', 'chart/echarts-scatter', 'chart/echarts-more',
                'page/404', 'page/500', 'page/blank', 'page/forgot-password', 'page/invoice', 'page/lock-screen', 'page/profile', 'page/invoice', 'page/signin', 'page/signup', 'page/about', 'page/services', 'page/contact',
                'mail/compose', 'mail/inbox', 'mail/single',
                'app/tasks', 'app/calendar'
            ]

            setRoutes = function(route) {
                var config, url;
                url = '/' + route;
                config = {
                    templateUrl: staticRoute + 'app/' + route + '.html'
                };
                $routeProvider.when(url, config);
                return $routeProvider;
            };

            routes.forEach(function(route) {
                return setRoutes(route);
            });*/
            SystemConfigProvider.setStaticPath(window['staticPath']);
            SystemConfigProvider.setHost(window['host']);           
            $stateProvider
            .state("login", {
                  url: "/login",
                  templateUrl: SystemConfigProvider.getStaticPath() + "app/page/signin.html",
                   params: {
                        toStateOriginal: null,
                        toParamsOriginal: null
                    }

                })
                .state("dashboard", {
                  url: "/dashboard",
                  templateUrl: SystemConfigProvider.getStaticPath() + 'app/dashboard/dashboard.html',                  
                  roles: ["ROLE_SUPER_ADMIN", "ROLE_ADMIN"]
                })
                
                .state("404", {
                  url: "/404",
                  templateUrl: SystemConfigProvider.getStaticPath() + "app/page/404.html"

                })
                .state("lock-screen", {
                    url:"/lock-screen",
                    templateUrl: SystemConfigProvider.getStaticPath() + "app/page/lock-screen.html"
                })
                ;    
            $urlRouterProvider.otherwise("/dashboard");
        }]
    )
    .config(['$httpProvider', function($httpProvider){
        $httpProvider.defaults.useXDomain = true;
        delete $httpProvider.defaults.headers.common['X-Requested-With'];
    }])
    .run(['$rootScope', '$location', '$state','UsuarioService', 'SystemConfig',  function($rootScope, $location, $state, UsuarioService, SystemConfig){

        $rootScope.$on("$stateChangeStart", function(event, toState, toParams, fromState, fromParams, options){     
            if (!UsuarioService.tieneRol(toState.roles)) {              
              event.preventDefault();  
              if (toState.templateUrl !== SystemConfig.getStaticPath() + 'app/page/signin.html') {                  
                  $state.go("login", {toStateOriginal: toState, toParamsOriginal: toParams});                                   
              }
            }
        });    
    }]);

})(); 