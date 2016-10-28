<?php

namespace Safe\AlumnoBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Safe\CoreBundle\Tests\Controller\SafeTestController;
use Doctrine\Common\Util\Debug;
class AlumnoControllerTest extends SafeTestController {

        
    public function testGetAction() {
        //inicio
        $login = $this->loginAlumno();                
        $cliente = $login['cliente'];                
        $id = $login['datos']['idAlumno'];
        $route =  $this->getUrl('api_1_alumnosget_alumno', array('alumnoId' => $id, '_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
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
        
        $this->assertUsuarioList($usuario, 'ROLE_ALUMNO');        
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
    
    public function testGetAction_conIdUsuarioDiferenteAlLogueado_retornaStatusForbidden() {
        //inicio        
        $login = $this->loginAlumno();                
        $cliente = $login['cliente'];                 
        $id = $login['datos']['idAlumno'] +1;
        $route =  $this->getUrl('api_1_alumnosget_alumno', array('alumnoId' => $id, '_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 403);
    }
    
    
    
    public function testPutAction() {
        //inicio
        
        $nuevoNombre = 'Juan Test put';
        
        $login = $this->loginAlumno();                
        $cliente = $login['cliente'];  
        $id = $login['datos']['idAlumno'];
        $route =  $this->getUrl('api_1_alumnosput_alumno', array('alumnoId' => $id, '_format' => 'json'));       
        $alumno = $this->crearAlumnoArray('alumno1', '1');
        $alumno['usuario']['nombre'] = $nuevoNombre;
        
        
        //test
        $cliente->request('PUT', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), json_encode($alumno));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), 'Se esperaba status code 204 en vez de '.$response->getStatusCode());
        
        $alumno = $this->getAlumno($id);
        $this->assertEquals($nuevoNombre, $alumno->getUsuario()->getNombre());
        
    }
    
    public function testPutAction_conIdUsuarioDiferenteAlLogueado_retornaStatusForbidden() {
        //inicio        
        $nuevoNombre = 'Juan Test put';
        $login = $this->loginAlumno();                
        $cliente = $login['cliente'];  
        $id = $login['datos']['idAlumno'] + 1;             
        $route =  $this->getUrl('api_1_alumnosput_alumno', array('alumnoId' => $id, '_format' => 'json'));       
        $alumno = $this->crearAlumnoArray('alumno1', '1');
        $alumno['usuario']['nombre'] = $nuevoNombre;
        
        
        //test
        $cliente->request('PUT', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), json_encode($alumno));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertEquals(403, $response->getStatusCode(), 'Se esperaba status code 403 en vez de '.$response->getStatusCode());
    }
    
    public function testPatchAction() {
        //inicio        
        $nuevoNombre = 'Juan Test Patch';
        $login = $this->loginAlumno();                
        $cliente = $login['cliente'];  
        $id = $login['datos']['idAlumno'];
        $route =  $this->getUrl('api_1_alumnospatch_alumno', array('alumnoId' => $id, '_format' => 'json'));       
        $alumno = array('usuario' => array('nombre' => $nuevoNombre));
        
        
        //test
        $cliente->request('PATCH', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), json_encode($alumno));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), 'Se esperaba status code 204 en vez de '.$response->getStatusCode());
        
        $alumno = $this->getAlumno($id);
        $this->assertEquals($nuevoNombre, $alumno->getUsuario()->getNombre());
    }
    
    public function testPatchAction_conIdUsuarioDiferenteAlLogueado_retornaStatusForbidden() {
        //inicio        
        $nuevoNombre = 'Juan Test Patch';
        $login = $this->loginAlumno();                
        $cliente = $login['cliente'];  
        $id = $login['datos']['idAlumno'] + 1;              
        $route =  $this->getUrl('api_1_alumnospatch_alumno', array('alumnoId' => $id, '_format' => 'json'));       
        $alumno = array('usuario' => array('nombre' => $nuevoNombre));
        
        
        //test
        $cliente->request('PATCH', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), json_encode($alumno));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertEquals(403, $response->getStatusCode(), 'Se esperaba status code 403 en vez de '.$response->getStatusCode());
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
