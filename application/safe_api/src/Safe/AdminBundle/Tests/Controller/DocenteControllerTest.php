<?php

namespace Safe\AdminBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Safe\CoreBundle\Tests\Controller\SafeTestController;
use Doctrine\Common\Util\Debug;
class DocenteControllerTest extends SafeTestController {

    public function testGetAllAction() {
        //inicio
        $adminClient = $this->createAdminClient();                
        $route =  $this->getUrl('api_1_admin_docentesget_docentes', array('_format' => 'json'));
        
        //test
        $adminClient->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $adminClient->getResponse();
        $this->assertJsonResponse($response, 200);       
        $data = json_decode($response->getContent(), true);
        $this->assertTrue(count($data) > 0);
        $docente = $data[0];
        $this->assertArrayHasKey('id', $docente, 'id del docente no encontrado');
        $this->assertArrayHasKey('legajo', $docente, 'Legajo del docente no encontrado');
        $this->assertArrayHasKey('fecha_modificacion', $docente, 'Fecha de modifiacion del docente');
        $this->assertNotNull($docente['fecha_modificacion'], 'Fecha de modifiacion del docente invalida');
        
        $this->assertArrayHasKey('usuario', $docente, 'Datos del usuario del docente no encontrado');        
        $usuario = $docente['usuario'];
        //Datos para el listado
        $this->assertUsuarioAdminList('ROLE_DOCENTE', $usuario);  
        
        //datos ocultos en el listado
        $this->assertArrayNotHasKey('curriculum', $docente, 'El curriculum no debe ser visualizado');
        $this->assertArrayNotHasKey('cursos', $docente, 'los cursos no deben ser visualizados');
    }
    
    public function testGetAction() {
        //inicio
        $adminClient = $this->createAdminClient();                
        $route =  $this->getUrl('api_1_admin_docentesget_docente', array('id' => '1', '_format' => 'json'));
        
        //test
        $adminClient->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $adminClient->getResponse();
        $this->assertJsonResponse($response, 200);       
        $docente = json_decode($response->getContent(), true);
        
        $this->assertArrayHasKey('id', $docente, 'id del docente no encontrado');
        $this->assertArrayHasKey('legajo', $docente, 'Legajo del docente no encontrado');
        $this->assertArrayHasKey('fecha_creacion', $docente, 'Fecha de creacion del docente no encontrada');
        $this->assertNotNull($docente['fecha_creacion'], 'Fecha de creacion del docente invalida');
        $this->assertArrayHasKey('fecha_modificacion', $docente, 'Fecha de modifiacion del docente no encontrada');
        $this->assertNotNull($docente['fecha_modificacion'], 'Fecha de modifiacion del docente invalida');
        
        $this->assertArrayHasKey('usuario', $docente, 'Datos del usuario del docente no encontrado');        
        $usuario = $docente['usuario'];
        
        $this->assertUsuarioAdminList('ROLE_DOCENTE', $usuario);        
        //datos para el detalle
        $this->assertArrayHasKey('curriculum', $docente, 'curriculum del docente no encontrado');
        $this->assertArrayHasKey('cursos', $docente, 'cursos del docente no encontrado');
        $cursos = $docente['cursos'];
        $this->assertNotEmpty($cursos);
        $curso = $cursos[0];
        $this->assertArrayHasKey('id', $curso, 'Id del curso no encontrado');
        $this->assertArrayHasKey('titulo', $curso, 'titulo del curso no encontrado');
        $this->assertArrayHasKey('fecha_modificacion', $curso, 'fecha de modificacion del curso no encontrado');
        $this->assertNotNull($curso['fecha_modificacion'], 'Fecha de modifiacion del curso invalida');
        $this->assertArrayHasKey('fecha_creacion', $curso, 'fecha de creacion del curso no encontrado');
        $this->assertNotNull($curso['fecha_creacion'], 'Fecha de creacion del curso invalida');
        
    }
    
    public function testPostAction() {
        //inicio
        $adminClient = $this->createAdminClient();                
        $route =  $this->getUrl('api_1_admin_docentespost_docente', array('_format' => 'json'));       
        $content = json_encode($this->crearDocenteArray('docente100', '100'));
        
        //test
        $adminClient->request('POST', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $content);
        
        //validacion
        $response = $adminClient->getResponse();
        $this->assertJsonResponse($response, 200);       
        
        $docente = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('id', $docente, 'id del docente no encontrado');
        $this->assertNotNull($docente['id'], 'El id del docente no puede ser nulo');
    }
    
    public function testPutAction() {
        //inicio
        $adminClient = $this->createAdminClient();                
        $route =  $this->getUrl('api_1_admin_docentesput_docente', array('id' => '1', '_format' => 'json'));       
        $docente = $this->crearDocenteArray('docente1', '1');
        $docente['curriculum'] = 'test put';
        
        
        //test
        $adminClient->request('PUT', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), json_encode($docente));
        
        //validacion
        $response = $adminClient->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), 'Se esperaba status code 204 en vez de '.$response->getStatusCode());
        
    
    }
    
    /*public function testPatchAction() {
        //inicio
        $adminClient = $this->createAdminClient();                
        $route =  $this->getUrl('api_1_admin_docentesput_docente', array('id' => '1', '_format' => 'json'));       
        $docente = $this->crearDocenteArray('docente1', '1');
        $docente['curriculum'] = 'test put';
        
        
        //test
        $adminClient->request('PUT', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), json_encode($docente));
        
        //validacion
        $response = $adminClient->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), 'Se esperaba status code 204 en vez de '.$response->getStatusCode());
        
    
    }*/
    
    protected function crearDocenteArray($username, $legajo, $curriculum = '<h3>Educaci&oacute;n<h3>') {
        $dato = array(
            'legajo' => $legajo,
            'curriculum' => $curriculum,
            'usuario' => array(
                'nombre'=> $username.'_nombre',
                'apellido'=> $username.'_apellido',
                'username'=> $username,
                'tipoDocumento'=>  'DNI',
                'numeroDocumento'=> $legajo,
                'genero'=> 'Masculino',
                'email'=> $username.'@mail.org',
                'enabled'=> 'true',
                'plainPassword' => array(
                    'first'=> '123456',
                    'second'=> '123456',
                )
            )
        );
        return $dato;
    }
    
    
    
}
