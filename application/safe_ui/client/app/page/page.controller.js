(function () {
    'use strict';

    angular.module('app.page')
        .controller('invoiceCtrl', ['$scope', '$window', invoiceCtrl])
        .controller('authCtrl', ['$scope', '$window', '$location', authCtrl])

        .controller('LoginCtrl', ['$scope', '$state', '$stateParams', 'AutorizacionService', 'PaginaService', LoginCtrl])
    ;
    
    function LoginCtrl($scope, $state, $stateParams, AutorizacionService, PaginaService) {
        
        $scope.login = function() {
            AutorizacionService.login($scope.username, $scope.password).then(
                    function(data){
                        if ($stateParams.toStateOriginal) {
                            $state.go($stateParams.toStateOriginal.name, $stateParams.toParamsOriginal);
                        } else {
                            $state.go(PaginaService.getInicio());
                        }
                        
                    },
                    function(error){
                        console.log(error);
                    }
            );
        }
        
        function handleRequest(res) {
            var token = res.data ? res.data.token : null;
            console.log('JWT:', token);            
        }
    }

    function invoiceCtrl($scope, $window) {
        var printContents, originalContents, popupWin;
        
        $scope.printInvoice = function() {
            printContents = document.getElementById('invoice').innerHTML;
            originalContents = document.body.innerHTML;        
            popupWin = window.open();
            popupWin.document.open();
            popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="styles/main.css" /></head><body onload="window.print()">' + printContents + '</html>');
            popupWin.document.close();
        }
    }

    function authCtrl($scope, $window, $location) {
            $scope.login = function() {
                $location.url('/')
            }

            $scope.signup = function() {
                $location.url('/')
            }

            $scope.reset =  function() {
                $location.url('/')
            }

            $scope.unlock =  function() {
                $location.url('/')
            }   
    }

})(); 



