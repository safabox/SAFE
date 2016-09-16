<?php

namespace Safe\AdminBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Safe\CoreBundle\Tests\Controller\SafeTestController;
use Doctrine\Common\Util\Debug;
class AdminAlumnoControllerTest extends SafeTestController {

    public function testGetAllAction() {
        //inicio
        $clienteAdministrador = $this->createClienteAdministrador();                
        $route =  $this->getUrl('api_1_admin_alumnosget_alumnos', array('_format' => 'json'));
        
        //test
        $clienteAdministrador->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $clienteAdministrador->getResponse();
        $this->assertJsonResponse($response, 200);       
        $data = json_decode($response->getContent(), true);
        $this->assertTrue(count($data) > 0);
        $alumno = $data[0];
        $this->assertArrayHasKey('id', $alumno, 'id del alumno no encontrado');
        $this->assertArrayHasKey('legajo', $alumno, 'Legajo del alumno no encontrado');
        $this->assertArrayHasKey('fecha_modificacion', $alumno, 'Fecha de modificacion del alumno no encontrada');
        $this->assertNotNull($alumno['fecha_modificacion'], 'Fecha de modifiacion del alumno invalida');
        
        $this->assertArrayHasKey('usuario', $alumno, 'Datos del usuario del alumno no encontrado');        
        $usuario = $alumno['usuario'];
        //Datos para el listado
        $this->assertUsuarioAdminList($usuario, 'ROLE_ALUMNO');  
        
        //datos ocultos en el listado
        $this->assertArrayNotHasKey('cursos', $alumno, 'los cursos no deben ser visualizados');
    }
    
    public function testGetAction() {
        //inicio
        $clienteAdministrador = $this->createClienteAdministrador();                
        $route =  $this->getUrl('api_1_admin_alumnosget_alumno', array('id' => '1', '_format' => 'json'));
        
        //test
        $clienteAdministrador->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $clienteAdministrador->getResponse();
        $this->assertJsonResponse($response, 200);       
        $alumno = json_decode($response->getContent(), true);
        
        $this->assertArrayHasKey('id', $alumno, 'id del alumno no encontrado');
        $this->assertArrayHasKey('legajo', $alumno, 'Legajo del alumno no encontrado');
        $this->assertArrayHasKey('fecha_creacion', $alumno, 'Fecha de creacion del alumno no encontrada');
        $this->assertNotNull($alumno['fecha_creacion'], 'Fecha de creacion del alumno invalida');
        $this->assertArrayHasKey('fecha_modificacion', $alumno, 'Fecha de modifiacion del alumno no encontrada');
        $this->assertNotNull($alumno['fecha_modificacion'], 'Fecha de modifiacion del alumno invalida');
        
        $this->assertArrayHasKey('usuario', $alumno, 'Datos del usuario del alumno no encontrado');        
        $usuario = $alumno['usuario'];
        
        $this->assertUsuarioAdminList($usuario, 'ROLE_ALUMNO');        
        //datos para el detalle
        $this->assertArrayHasKey('cursos', $alumno, 'cursos del alumno no encontrado');
        $cursos = $alumno['cursos'];
        $this->assertNotEmpty($cursos);
        $curso = $cursos[0];
        $this->assertArrayHasKey('id', $curso, 'Id del curso no encontrado');
        $this->assertArrayHasKey('titulo', $curso, 'titulo del curso no encontrado');
        $this->assertArrayHasKey('fecha_modificacion', $curso, 'fecha de modificacion del curso no encontrado');
        $this->assertNotNull($curso['fecha_modificacion'], 'Fecha de modifiacion del curso invalida');
        $this->assertArrayHasKey('fecha_creacion', $curso, 'fecha de creacion del curso no encontrado');
        $this->assertNotNull($curso['fecha_creacion'], 'Fecha de creacion del curso invalida');
        
        $this->assertArrayHasKey('numero_documento', $usuario, 'numero de documento no encontrado');
        $this->assertArrayHasKey('tipo_documento', $usuario, 'tipo de documento no encontrado');
        $tipoDocumento = $usuario['tipo_documento'];
        $this->assertArrayHasKey('codigo', $tipoDocumento, 'tipo de documento[codigo] no encontrado');

    }
    
    public function testPostAction() {
        //inicio
        $clienteAdministrador = $this->createClienteAdministrador();                
        $route =  $this->getUrl('api_1_admin_alumnospost_alumno', array('_format' => 'json'));       
        $content = json_encode($this->crearAlumnoArray('alumno100', '100'));
        
        //test
        $clienteAdministrador->request('POST', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $content);
        
        //validacion
        $response = $clienteAdministrador->getResponse();
        $this->assertJsonResponse($response, 200);       
        
        $alumno = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('id', $alumno, 'id del alumno no encontrado');
        $this->assertNotNull($alumno['id'], 'El id del alumno no puede ser nulo');
    }
    
    public function testPutAction() {
        //inicio
        $id = '1';
        $nuevoNombre = 'Juan Test put';
        $clienteAdministrador = $this->createClienteAdministrador();                
        $route =  $this->getUrl('api_1_admin_alumnosput_alumno', array('id' => $id, '_format' => 'json'));       
        $alumno = $this->crearAlumnoArray('alumno1', '1');
        $alumno['usuario']['nombre'] = $nuevoNombre;
        
        
        //test
        $clienteAdministrador->request('PUT', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), json_encode($alumno));
        
        //validacion
        $response = $clienteAdministrador->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), 'Se esperaba status code 204 en vez de '.$response->getStatusCode());
        
        $alumno = $this->getAlumno($id);
        $this->assertEquals($nuevoNombre, $alumno->getUsuario()->getNombre());
        
    }
    
    public function testPatchAction() {
        //inicio
        $id = '1';
        $nuevoNombre = 'Juan Test Patch';
        $clienteAdministrador = $this->createClienteAdministrador();                
        $route =  $this->getUrl('api_1_admin_alumnospatch_alumno', array('id' => $id, '_format' => 'json'));       
        $alumno = array('usuario' => array('nombre' => $nuevoNombre));
        
        
        //test
        $clienteAdministrador->request('PATCH', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), json_encode($alumno));
        
        //validacion
        $response = $clienteAdministrador->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), 'Se esperaba status code 204 en vez de '.$response->getStatusCode());
        
        $alumno = $this->getAlumno($id);
        $this->assertEquals($nuevoNombre, $alumno->getUsuario()->getNombre());
    }
    
    protected function crearAlumnoArray($username, $legajo, $curriculum = '<h3>Educaci&oacute;n<h3>') {
        $dato = array(
            'legajo' => $legajo,
            'usuario' => array(
                'nombre'=> $username.'_nombre',
                'apellido'=> $username.'_apellido',
                'username'=> $username,
                'tipoDocumento'=>  'DNI',
                'numeroDocumento'=> $legajo,
                'genero'=> 'Masculino',
                'email'=> $username.'@mail.org',
                'enabled'=> 'true',
                'textPassword' => array(
                    'first'=> '123456',
                    'second'=> '123456',
                )
            )
        );
        return $dato;
    }
    
    protected function getAlumno($id) {
        return $this->em
            ->getRepository('SafeAlumnoBundle:Alumno')
            ->find($id)
        ;
    }
    
    
    
}
