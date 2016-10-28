(function () {
    'use strict';

    angular
        .module('app')
        .factory('_', factory)
        .run(init);

    factory.$inject = ['$window'];

    function factory($window) {
        // Get a local handle on the global lodash reference.
        var svc = $window._;

        // ---
        // CUSTOM LODASH METHODS.
        // ---

        // Return the [formerly global] reference so that it can be injected
        // into other aspects of the AngularJS application.
        return (svc);
    }

    init.$inject = ['_'];
    function init(_) { // eslint-disable-line no-unused-vars
        // Dummy para asegurar la creación del servicio
    }
})();
