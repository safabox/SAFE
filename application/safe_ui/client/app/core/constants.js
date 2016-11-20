(function () {
    'use strict';

    var debugModeEnabled = false;
    var accordion = true;

    var fieldPattern = {
        alfanumerico: '\\w+\\s?\\w*\\s?\\w*\\s?\\w*\\s?\\w*',
        email: '[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,3}$',
    };
    
    var configIrtTipoUno = {
        discriminador: 1,
        azar: 1,
        d: 1.7,
        tipo: 'MULTIPLE_CHOICE',
    };
    
     var configIrtTipoDos = {
        discriminador: 1,
        azar: 1,
        d: 1.7,
        tipo: 'MULTIPLE_CHOICE_MATRIX',
    };
    
    var concepto = {
        tipo: 'RASH',
        rango: [-3,3],
        metodo: 'THETA_NEWTON_RAPHSON',
        incremento: 0.5,
    };    
    
    angular
        .module('app')
        .constant('debugModeEnabled', debugModeEnabled)
        .constant('fieldPattern', fieldPattern)
        .constant('accordion', accordion)
        .constant('configIrtTipoUno', configIrtTipoUno)
        .constant('configIrtTipoDos', configIrtTipoDos)
        .constant('concepto', concepto);
})();


