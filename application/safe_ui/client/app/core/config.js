(function () {
    'use strict';
    
    angular
        .module('app')
        .config(restangularProviderConfig)
        .config(authProviderConfig);;

    restangularProviderConfig.$inject = ['RestangularProvider', 'environment'];
        function restangularProviderConfig(RestangularProvider, environment) {
            RestangularProvider.setBaseUrl(environment.apiUrlBase);
        }

    authProviderConfig.$inject = ['$httpProvider'];
        function authProviderConfig($httpProvider) {
            $httpProvider.interceptors.push('authInterceptor');
    }
    
})();