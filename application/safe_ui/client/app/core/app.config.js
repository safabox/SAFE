(function() {
    'use strict';

    angular.module('app')
        .factory('appConfig', [appConfig]);

    function appConfig() {
        var pageTransitionOpts = [
            {
                name: 'Fade up',
                "class": 'animate-fade-up'
            }, {
                name: 'Scale up',
                "class": 'ainmate-scale-up'
            }, {
                name: 'Slide in from right',
                "class": 'ainmate-slide-in-right'
            }, {
                name: 'Flip Y',
                "class": 'animate-flip-y'
            }
        ];
        var date = new Date();
        var year = date.getFullYear();
        var main = {
            brand: 'SAFE',
            name: 'Administrador',
            year: year,
            layout: 'wide',                                 // 'boxed', 'wide'
            menu: 'vertical',                               // 'horizontal', 'vertical'
            isMenuCollapsed: false,                         // true, false
            fixedHeader: true,                              // true, false
            fixedSidebar: true,                             // true, false
            pageTransition: pageTransitionOpts[0],          // 0, 1, 2, 3... and build your own
            skin: '12'                                      // 11,12,13,14,15,16; 21,22,23,24,25,26; 31,32,33,34,35,36
        };
        var color = {
            primary:    '#31C0BE',
            success:    '#60CD9B',
            info:       '#66B5D7',
            infoAlt:    '#8170CA',
            warning:    '#EEC95A',
            danger:     '#E87352',
            gray:       '#DCDCDC'
        };
        
        

        return {
            pageTransitionOpts: pageTransitionOpts,
            main: main,
            color: color
        }
    }

})();