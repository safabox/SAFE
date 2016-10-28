(function () {
    'use strict';

    angular.module('app')
        .provider('SystemConfig', function () {
            var config = {
                    staticPath: '/',
                    host:'/'
                };
            this.setStaticPath = function(staticPath) {
                config.staticPath = (staticPath) ? staticPath : config.staticPath;
            }
            this.setHost = function(host) {
                config.host = (host) ? host : config.host;
            }
            this.getStaticPath = function() {
                return config.staticPath;
            }
            this.getHost = function() {
                return config.host;
            }             
            this.$get = function() {
                return  this;
            }
            
                
        });
   
})(); 