(function () {
    'use strict';

    angular
        .module('app')
        .factory('authInterceptor', factory);

    factory.$inject = ['$q', '$localStorage'];
    function factory($q, $localStorage) {
        var service = {
            request: request
        };

        return service;

        function request(config) {
           
            var token = '';
                  
            if($localStorage.usuarioSafe !== undefined){
                token = $localStorage.usuarioSafe.token;
            }
            
            if(token){
                config.headers = config.headers || {};
                config.headers.Authorization = 'Bearer ' + token;
            }   
            return config;

        }

    }
})();
