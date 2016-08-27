(function () {
    'use strict';

    var urlBase = 'http://localhost:8001/'; // DEV
    // var urlBase = ''; // PROD

    var enviromentConfig = {
        apiUrlBase: urlBase + 'api/v1',
        staticPath: '/',
        apiUrlBaseLogin: urlBase + 'api'
    };

    angular
        .module('app')
        .constant('environment', enviromentConfig)
        .constant('toastr', toastr);
})();
