angular
    .module('app')
    .provider('routerHelper', routerHelperProvider);

routerHelperProvider.$inject = ['$stateProvider', '$urlRouterProvider', 'SystemConfigProvider', 'environment'];
/* @ngInject */
function routerHelperProvider($stateProvider, $urlRouterProvider, SystemConfigProvider, environment) {
    /* jshint validthis:true */
    this.$get = RouterHelper;
    
    SystemConfigProvider.setStaticPath(environment.staticPath);
    SystemConfigProvider.setHost(environment.apiUrlBaseLogin);  
    
    //$locationProvider.html5Mode(true);
   
    RouterHelper.$inject = ['$rootScope', '$state', 'UsuarioService', 'SystemConfig', 'PaginaService', ];
    /* @ngInject */
    function RouterHelper($rootScope, $state, UsuarioService, SystemConfig, PaginaService) {
        var hasOtherwise = false;

        var service = {
            configureStates: configureStates,
            getStates: getStates
        };
                          
        init();
        
        return service;

        ///////////////

        function configureStates(states, otherwisePath) {
            states.forEach(function(state) {
                $stateProvider.state(state.state, state.config);
            });
            if (otherwisePath && !hasOtherwise) {
                hasOtherwise = true;
                $urlRouterProvider.otherwise(otherwisePath);
            }
        }       
        
        function handleRoutingAuthorization() {
            $rootScope.$on("$stateChangeStart", function(event, toState, toParams){     
                if (!UsuarioService.isAutenticado()) {                            
                  if (toState.templateUrl !== SystemConfig.getStaticPath() + 'app/page/signin.html') {                  
                      event.preventDefault();  
                      $state.go('login', {toStateOriginal: toState, toParamsOriginal: toParams});                                   
                  }
                } else if (!UsuarioService.tieneRol(toState.roles)) {
                    event.preventDefault();  
                    $state.go(PaginaService.getInicio(), {error:{code: '401', message: 'Usuario no autorizado'}}); 
                }
            });  
        }
        
        function getStates() { return $state.get(); }
        
        function init() {
            handleRoutingAuthorization();
        }
    }
}


