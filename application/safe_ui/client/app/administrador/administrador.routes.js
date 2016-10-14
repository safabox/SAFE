(function () {
    'use strict';

    angular
        .module('app.administrador')
        .run(appRun);

    appRun.$inject = ['routerHelper', 'SystemConfig'];
    /* @ngInject */
    function appRun(routerHelper, SystemConfig) {
        routerHelper.configureStates(getStates(SystemConfig.getStaticPath()), '/');
    }

    function getStates(path) {
        return [       
            {
                state: 'admin.alumnos',
                config: {
                    abstract: true,
                    url: '',
                    template: '<ui-view/>'
                }
            },
            {
                state: 'admin.alumnos.list',
                config: {
                    url: '/alumnos',
                    templateUrl: path + 'app/administrador/alumnos/administrador.alumnos.list.html', 
                    roles: ["ROLE_SUPER_ADMIN", "ROLE_ADMIN"],
                    controller: 'AdministradorAlumnosCtrl',
                    controllerAs: 'vm', 
                    params: {error: null}
                }
            },
            {
                state: 'admin.alumnos.new',
                config: {
                    url: '/alumnos/new',
                    templateUrl: path + 'app/administrador/alumnos/administrador.alumnos.edit.html',                  
                    roles: ["ROLE_SUPER_ADMIN", "ROLE_ADMIN"],
                    controller: 'AdministradorAlumnosEdit',
                    controllerAs: 'vm',
                    params: {error: null}
                }
            },
            {
                state: 'admin.alumnos.edit',
                config: {
                    url: '/alumnos/:id',
                    templateUrl: path + 'app/administrador/alumnos/administrador.alumnos.edit.html',                  
                    roles: ["ROLE_SUPER_ADMIN", "ROLE_ADMIN"],
                    controller: 'AdministradorAlumnosEdit',
                    controllerAs: 'vm',
                    params: {error: null}
                }
            },
            {
                state: 'admin.docentes',
                config: {
                    abstract: true,
                    url: '',
                    template: '<ui-view/>'
                }
            },
            {
                state: 'admin.docentes.list',
                config: {
                    url: '/docentes',
                    templateUrl: path + 'app/administrador/docentes/administrador.docentes.list.html',                  
                    roles: ["ROLE_SUPER_ADMIN", "ROLE_ADMIN"],
                    controller: 'AdministradorDocentesCtrl',
                    controllerAs: 'vm',    
                    params: {error: null}    
                }
            },
            {
                state: 'admin.docentes.new',
                config: {
                    url: '/docentes/new',
                    templateUrl: path + 'app/administrador/docentes/administrador.docentes.edit.html',                  
                    roles: ["ROLE_SUPER_ADMIN", "ROLE_ADMIN"],
                    controller: 'AdministradorDocentesEdit',
                    controllerAs: 'vm',
                    params: {error: null}
                }
            },
            {
                state: 'admin.docentes.edit',
                config: {
                    url: '/docentes/:id',
                    templateUrl: path + 'app/administrador/docentes/administrador.docentes.edit.html',                  
                    roles: ["ROLE_SUPER_ADMIN", "ROLE_ADMIN"],
                    controller: 'AdministradorDocentesEdit',
                    controllerAs: 'vm',
                    params: {error: null}
                }
            },                
            {
                state: 'admin.cursos',
                config: {
                    abstract: true,
                    url: '',
                    template: '<ui-view/>'
                }
            },  
            {
                state: 'admin.cursos.list',
                config: {
                    url: '/cursos',
                    templateUrl: path + 'app/administrador/cursos/administrador.cursos.list.html',                  
                    roles: ["ROLE_SUPER_ADMIN", "ROLE_ADMIN"],
                    controller: 'AdministradorCursosCtrl',
                    controllerAs: 'vm',    
                    params: {error: null}
                }
            },  
            {
                state: 'admin.cursos.new',
                config: {
                    url: '/cursos/new',
                    templateUrl: path + 'app/administrador/cursos/administrador.cursos.edit.html',                  
                    roles: ["ROLE_SUPER_ADMIN", "ROLE_ADMIN"],
                    controller: 'AdministradorCursosEdit',
                    controllerAs: 'vm',
                    params: {error: null}
                }
            }, 
            {
                state: 'admin.cursos.edit',
                config: {
                    url: '/cursos/:id',
                    templateUrl: path + 'app/administrador/cursos/administrador.cursos.edit.html',                  
                    roles: ["ROLE_SUPER_ADMIN", "ROLE_ADMIN"],
                    controller: 'AdministradorCursosEdit',
                    controllerAs: 'vm',
                    params: {error: null}
                }
            }         
        ];
    }
    
})();    

