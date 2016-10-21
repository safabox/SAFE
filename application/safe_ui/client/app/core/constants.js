(function () {
    'use strict';

    var debugModeEnabled = false;
    var accordion = true;

    var fieldPattern = {
        alfanumerico: '\\w+\\s?\\w*\\s?\\w*\\s?\\w*\\s?\\w*',
        email: '[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,3}$',
    };

    angular
        .module('app')
        .constant('debugModeEnabled', debugModeEnabled)
        .constant('fieldPattern', fieldPattern)
        .constant('accordion', accordion);
})();


