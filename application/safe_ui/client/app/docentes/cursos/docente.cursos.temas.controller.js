(function () {
    'use strict';

    angular.module('app.docente.cursos')
        .controller('TemaCursosEdit', controller);

    controller.$inject = ['_', '$q', 'logger', 'debugModeEnabled', '$stateParams', 'DocenteCursos', 'UsuarioService' ]; 
    
    function controller(_, $q, logger, debugModeEnabled, $stateParams, DocenteCursos, UsuarioService) {
        var vm = this;
        vm.debug = debugModeEnabled;
        vm.loading = true;
        
        vm.groupInfoGral = { isOpen: true };
        
        vm.fieldLabels = [
            { name: 'titulo', label: 'Título' },
            { name: 'descripcion', label: 'Descripción' },
        ];

        vm.guardar = guardar;
        vm.cancel = cancel;
        
        activate();
        
        function activate() {
            $q.all([cargaTema()])
                .then(onLoadComplete);       
            
            function cargaTema() {
                var tema = DocenteCursos.one(UsuarioService.getUserCurrentDoc()).one('cursos', $stateParams.idCurso).one('temas', $stateParams.id);  
                return  tema.get().then(onSuccess, onError);

                function onSuccess(response) {            
                    vm.tema = response.plain();     
                }        
                function onError(httpResponse) {
                    logger.error('No se pudo obtener el Curso', httpResponse);
                }   
            }
            
            function onLoadComplete() {
                vm.loading = false;
                setTitle();
            }
            
            function setTitle() {
                vm.title = 'Editar Tema';
            }    
        }
        
        function guardar() {
            
        }
        
        function cancel() {
            goBack();
        }
        
        function goBack() {
            $state.go('^.edit');
        }
    }    
})(); 
