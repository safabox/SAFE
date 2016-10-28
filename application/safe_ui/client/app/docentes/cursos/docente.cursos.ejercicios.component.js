(function () {
    'use strict';

    angular
        .module('app.docente.cursos')
        .component('docenteCursosEjercicios', {
            templateUrl: 'app/docentes/cursos/docente.cursos.ejercicios.tpl.html',
            controller: controller,
            controllerAs: 'vm',
            bindings: {
                model: '=ngModel',
                editMode: '=editMode',
            },
        });

    controller.$inject = ['_', 'debugModeEnabled', 'NgTableParams'];

    function controller(_, debugModeEnabled, NgTableParams) {
        var vm = this;
        vm.debug = debugModeEnabled;
        
        vm.groupVistaPrevia = { isOpen: false };
        
        if(!vm.editMode){
            vm.model.respuestas = [];
        }
        
        vm.agregarRespuesta = agregarRespuesta;
        vm.eliminarRespuesta= eliminarRespuesta;

        
        vm.respuestasTableParams = new NgTableParams({
            page: 1,
            count: 10
        }, {
            total: function () { return vm.model.respuestas.length; },
            counts: [],
            getData: getData
        });
        
        activate();

        function activate() {
            vm.toolbar =    [
                                ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'pre', 'quote'],
                                ['bold', 'italics', 'underline', 'strikeThrough', 'ul', 'ol', 'redo', 'undo', 'clear'],
                                ['justifyLeft', 'justifyCenter', 'justifyRight', 'indent', 'outdent'],
                                ['html', 'insertImage','insertLink', 'insertVideo', 'wordcount', 'charcount']
                            ];
            //vm.model.pregunta = '';
        }
        
        function getData() {
            return vm.model.respuestas;
        }
        
        function agregarRespuesta(){
            if(vm.model.tipo === 1) {
                vm.model.respuestas.push({texto:'',correcta:false});
            }else {
                vm.model.respuestas.push({texto:'',verdadero:false,falso:false});
            }
            
        }
        
        function eliminarRespuesta(idx) {
            vm.model.respuestas.splice(idx, 1);
        }
    }
})();
