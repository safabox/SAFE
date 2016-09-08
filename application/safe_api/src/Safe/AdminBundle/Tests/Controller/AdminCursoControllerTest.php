<?php

namespace Safe\AdminBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Safe\CoreBundle\Tests\Controller\SafeTestController;
use Doctrine\Common\Util\Debug;
class AdminCursoControllerTest extends SafeTestController {

    public function testGetAllAction() {
        //inicio
        $clienteAdministrador = $this->createClienteAdministrador();                
        $route =  $this->getUrl('api_1_admin_cursosget_cursos', array('_format' => 'json'));
        
        //test
        $clienteAdministrador->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $clienteAdministrador->getResponse();
        $this->assertJsonResponse($response, 200);       
        $data = json_decode($response->getContent(), true);
        $this->assertTrue(count($data) > 0);
        $curso = $data[0];        
        $this->assertArrayHasKey('id', $curso, 'id del curso no encontrado');
        $this->assertArrayHasKey('titulo', $curso, 'Titulo del curso no encontrado');
        $this->assertArrayHasKey('fecha_modificacion', $curso, 'Fecha de modificacion del curso');
        $this->assertNotNull($curso['fecha_modificacion'], 'Fecha de modificacion del curso invalida');
        $this->assertArrayHasKey('fecha_creacion', $curso, 'Fecha de creacion del curso');
        $this->assertNotNull($curso['fecha_creacion'], 'Fecha de creacion del curso invalida');
        //No tiene que estar en los listados
        $this->assertArrayNotHasKey('descripcion', $curso, 'La descripcion del curso no debe mostrarse');
    }
    
    public function testGetAction() {
        //inicio
        $clienteAdministrador = $this->createClienteAdministrador();                
        $route =  $this->getUrl('api_1_admin_cursosget_curso', array('id' => '1', '_format' => 'json'));
        
        //test
        $clienteAdministrador->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $clienteAdministrador->getResponse();
        $this->assertJsonResponse($response, 200);       
        $curso = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('id', $curso, 'id del curso no encontrado');
        $this->assertArrayHasKey('titulo', $curso, 'Titulo del curso no encontrado');
        $this->assertArrayHasKey('fecha_modificacion', $curso, 'Fecha de modificacion del curso no encontrada');
        $this->assertNotNull($curso['fecha_modificacion'], 'Fecha de modificacion del curso invalida');
        $this->assertArrayHasKey('fecha_creacion', $curso, 'Fecha de creacion del curso no encontrada');
        $this->assertNotNull($curso['fecha_creacion'], 'Fecha de creacion del curso invalida');

        //datos para el detalle
        $this->assertArrayHasKey('descripcion', $curso, 'Descripcion del curso no encontrada');
        
    }
    
    public function testPostAction() {
        //inicio
        $clienteAdministrador = $this->createClienteAdministrador();                
        $route =  $this->getUrl('api_1_admin_cursospost_curso', array('_format' => 'json'));       
        $docentes = array(1, 2);
        $alumnos = array(1, 2, 3);
        $titulo = 'Curso Test 100';
        $descripcion = 'una descripcion';
        $content = json_encode($this->crearCursoArray($titulo, $descripcion, $docentes, $alumnos));
        
        //test
        $clienteAdministrador->request('POST', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $content);
        
        //validacion
        $response = $clienteAdministrador->getResponse();
        $this->assertJsonResponse($response, 200);       
        
        $curso = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('id', $curso, 'id del curso no encontrado');
        
        $idCreado = $curso['id'];
        $this->assertNotNull($idCreado, 'El id del curso no puede ser nulo');
        
        $cursoGuardado = $this->getCurso($idCreado);
        $this->assertEquals($titulo, $cursoGuardado->getTitulo());
        $this->assertEquals($descripcion, $cursoGuardado->getDescripcion());
        $this->assertTrue(count($docentes) == $cursoGuardado->getDocentes()->count(), 'No coinciden la cantidad de docentes');
        $this->assertTrue(count($alumnos) == $cursoGuardado->getAlumnos()->count(), 'No coinciden la cantidad de alumnos');
    }
    
    public function testPutAction() {
        //inicio
        $id = '1';        
        $clienteAdministrador = $this->createClienteAdministrador();                
        $route =  $this->getUrl('api_1_admin_cursosput_curso', array('id' => $id, '_format' => 'json'));       
        $nuevoTitulo = 'Curso Test put';
        $nuevaDescripcion = 'una descripcion put';
        $docentes = array(1);
        $alumnos = array(1);
        $contenido = $this->crearCursoArray($nuevoTitulo, $nuevaDescripcion, $docentes, $alumnos);
        
        
        //test
        $clienteAdministrador->request('PUT', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), json_encode($contenido));
        
        //validacion
        $response = $clienteAdministrador->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), 'Se esperaba status code 204 en vez de '.$response->getStatusCode());
        
        $curso = $this->getCurso($id);
        $this->assertEquals($nuevoTitulo, $curso->getTitulo());
        $this->assertEquals($nuevaDescripcion, $curso->getDescripcion());
        $this->assertTrue(count($docentes) == $curso->getDocentes()->count(), 'No coinciden la cantidad de docentes');
        $this->assertTrue(count($alumnos) == $curso->getAlumnos()->count(), 'No coinciden la cantidad de alumnos');
        
    }
    
    public function testPatchAction() {
        //inicio
        $id = '1';        
        $clienteAdministrador = $this->createClienteAdministrador();                
        $route =  $this->getUrl('api_1_admin_cursospatch_curso', array('id' => $id, '_format' => 'json'));       
        
        $alumnos = array(1,2);
        $contenido = array('alumnos' => $alumnos);
        
        //test
        $clienteAdministrador->request('PATCH', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), json_encode($contenido));
        
        //validacion
        $response = $clienteAdministrador->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), 'Se esperaba status code 204 en vez de '.$response->getStatusCode());
        
        $curso = $this->getCurso($id);
        $this->assertTrue(count($alumnos) == $curso->getAlumnos()->count(), 'No coinciden la cantidad de alumnos');
        
    }

    
    protected function crearCursoArray($titulo, $descripcion, $docentes=array(), $alumnos=array()) {        
        $dato = array(
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'docentes' => $docentes,
            'alumnos' => $alumnos
        );
        return $dato;
    }
    
    protected function getCurso($id) {
        return $this->em
            ->getRepository('SafeCursoBundle:Curso')
            ->find($id)
        ;
    }
    
    
    
}
