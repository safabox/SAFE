(function () {
    'use strict';

    angular.module('app', [
        // Angular modules
        'ngRoute',
        'ngAnimate',
        'ngAria',
        'ngMessages',
        'ngTable',
        'ui.bootstrap.showErrors',
        'ui.validate',

        // 3rd Party Modules
        'ui.bootstrap',
        'ngMap',
        'ngTagsInput',
        'textAngular',
        'angular-loading-bar',
        'ui.calendar',
        'duScroll',
        'mgo-angular-wizard',
        'restangular',
        'ui.router',
        'ngStorage',
        'blockUI',
        'angular-jwt',
        'checklist-model',
        
        // Custom modules
        'app.nav',
        'app.i18n',
        'app.chart',
        'app.ui',
        'app.ui.form',
        'app.ui.form.validation',
        'app.page',
        'app.administrador',
        'app.administrador.alumnos',
        'app.administrador.docentes',
        'app.administrador.cursos',
        'app.alumno',
        'app.docente',
        'app.docente.cursos',
        'app.crear-tema-popup'
        //'app.crear-concepto-popup'
        //'app.table',
        //'app.task',
        //'app.calendar'
    ]);

})();






    

