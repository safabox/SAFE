(function () {
    'use strict';
    
    angular
        .module('app')
        .config(restangularProviderConfig)
        .config(authProviderConfig)
        .config(blockUIConfig);

    restangularProviderConfig.$inject = ['RestangularProvider', 'environment'];
        function restangularProviderConfig(RestangularProvider, environment) {
            RestangularProvider.setBaseUrl(environment.apiUrlBase);
        }

    authProviderConfig.$inject = ['$httpProvider'];
        function authProviderConfig($httpProvider) {
            $httpProvider.interceptors.push('authInterceptor');
    }
    
    blockUIConfig.$inject = ['blockUIConfig'];
    function blockUIConfig(blockUIConfigProvider) {
        blockUIConfigProvider.message = 'Aguarde...';

        blockUIConfigProvider.requestFilter = requestFilter;

        function requestFilter(config) {
            if (config.excludeBlockUI) {
                return false;
            }
        }
    }
    
})();