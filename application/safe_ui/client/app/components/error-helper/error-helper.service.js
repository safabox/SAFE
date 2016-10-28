(function () {
    'use strict';

    angular
        .module('app')
        .factory('ErrorHelper', factory);

    factory.$inject = ['_', '$state', '$log'];
    function factory(_, $state, $log) {
        var service = {
            goError: goError,
            parseRequestError: parseRequestError,
            getModelErrors: getModelErrors,
        };
        return service;

        function goError(errMsg, data) {
            if (!errMsg) {
                errMsg = 'Ocurrió un error en la aplicación';
            }
            $log.error(errMsg, data);
            $state.go('error', { errMsg: errMsg }, { location: false });
        }

        function getModelErrors(err) {
            var result = [];

            if (err.data) {
                if (err.data.modelState) {
                    var modelState = err.data.modelState;
                    for (var key in modelState) {
                        if (modelState.hasOwnProperty(key)) {
                            for (var i = 0; i < modelState[key].length; i++) {
                                result.push(modelState[key][i]);
                            }
                        }
                    }
                } else if (err.data.message) {
                    result.push(err.data.message);
                }
            } else {
                result.push('Error desconocido');
            }
            return result;
        }

        function parseRequestError(err) {
            var result = '';
            var errores = getModelErrors(err);
            _.forEach(errores, agregarError);
            return result;

            function agregarError(errorMessage) {
                result += errorMessage + '\n';
            }
        }
    }
})();
