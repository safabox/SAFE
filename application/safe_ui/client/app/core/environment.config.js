(function () {
    'use strict';

    //var urlBase = 'http://localhost:8001/app_dev.php/'; // DEV
    var urlBase = 'http://safeapi.safabox.com/'; // PROD

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
